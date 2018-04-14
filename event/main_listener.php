<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\event;

use Gothick\AkismetClient\Result\CommentCheckResult;
use Gothick\AkismetClient\Result\SubmitHamResult;
use Gothick\AkismetClient\Result\SubmitSpamResult;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\log\log_interface */
	protected $log;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \Gothick\AkismetClient\Client */
	protected $akismet;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $phpbb_root_path;

	/** @var array */
	protected $server_vars = array();

	/**
	 * Constructor
	 *
	 * @param \phpbb\user              			  $user				phpBB User class
	 * @param \phpbb\request\request		      $request			phpBB Request class
	 * @param \phpbb\config\config    			  $config			phpBB Config class
	 * @param \phpbb\log\log_interface			  $log				phpBB Log class
	 * @param \phpbb\auth\auth         			  $auth				phpBB Auth class
	 * @param \Gothick\AkismetClient\Client       $akismet			Akismet client class
	 * @param string                   			  $php_ext			php extension
	 * @param string                   			  $phpbb_root_path	phpBB root path
	 */
	public function __construct(\phpbb\user $user, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\log\log_interface $log, \phpbb\auth\auth $auth, \Gothick\AkismetClient\Client $akismet, $php_ext, $phpbb_root_path)
	{
		$this->user = $user;
		$this->request = $request;
		$this->config = $config;
		$this->log = $log;
		$this->auth = $auth;
		$this->akismet = $akismet;
		$this->php_ext = $php_ext;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function getSubscribedEvents()
	{
		return array(
			'core.posting_modify_submit_post_before'		=> 'check_submitted_post',
			'core.notification_manager_add_notifications'	=> 'add_akismet_details_to_notification',
			'core.user_add_after'							=> 'check_new_user',
			'core.delete_group_after'						=> 'group_deleted',
			'core.approve_posts_after'						=> 'submit_ham',
		);
	}

	/**
	 * The main event.
	 * When a post is submitted, we do several checks: is the
	 * user an admin or moderator (instant approval), does it fail the Akismet
	 * isSpam check, etc. On a failure we mark the post as not approved and
	 * log and notify.
	 *
	 * @param \phpbb\event\data $event
	 */
	public function check_submitted_post($event)
	{
		// Skip the Akismet check for anyone who's a moderator or an administrator.
		if ($this->auth->acl_getf_global('m_') || $this->auth->acl_getf_global('a_'))
		{
			return;
		}

		// Skip the Akismet check for users with more than defined posts
		if ($this->config['phpbb_akismet_skip_check_after_n_posts'] != 0 && $this->user->data['user_posts'] > $this->config['phpbb_akismet_skip_check_after_n_posts'])
		{
			return;
		}

		$data = $event['data'];
		if ($this->is_spam($data))
		{
			// Whatever the post status was before, this will override it
			// and mark it as unapproved.
			$data['force_approved_state'] = ITEM_UNAPPROVED;
			// This will be used by our notification event listener to
			// figure out that the post was moderated by Akismet.
			$data['phpbb_akismet_unapproved'] = true;
			$event['data'] = $data;

			$this->log_mark_post_spam($event['mode'], $data);
		}
	}

	/**
	 * Check a new user registration for spamminess.
	 *
	 * @param \phpbb\event\data $event
	 */
	public function check_new_user($event)
	{
		if ($this->config['phpbb_akismet_check_registrations'])
		{
			$user_id = $event['user_id']; // Can't use $this->user->data['user_id'] as there isn't an actual user logged in during registration, of course.
			$user_row = $event['user_row'];
			$params = [
				'comment_type'			=> 'signup',
				'user_ip'				=> $this->user->ip,
				'user_agent'			=> $this->user->browser,
				'comment_author'		=> $user_row['username'],
				'comment_author_email'	=> $user_row['user_email'],
			];

			$result = $this->akismet_comment_check($params);

			if ($result['is_spam'])
			{
				$log_message = $result['is_blatant_spam'] ? 'AKISMET_LOG_BLATANT_SPAMMER_REGISTRATION' : 'AKISMET_LOG_SPAMMER_REGISTRATION';
				$this->log->add('mod', $user_id, $this->user->ip, $log_message, false, array($user_row['username']));

				if ($group_id = $this->config['phpbb_akismet_add_registering_spammers_to_group'])
				{
					$this->group_user_add($group_id, $user_id);
				}

				if ($result['is_blatant_spam'] && $group_id = $this->config['phpbb_akismet_add_registering_blatant_spammers_to_group'])
				{
					$this->group_user_add($group_id, $user_id);
				}
			}
		}
	}

	/**
	 * We send out customised versions of the standard post_in_queue and
	 * topic_in_queue notifications so that people can tell that the reason
	 * for queueing was an Akismet spam detection rather than any other
	 * reason.
	 *
	 * @param \phpbb\event\data $event
	 */
	public function add_akismet_details_to_notification($event)
	{
		if ($event['notification_type_name'] === 'notification.type.post_in_queue' || $event['notification_type_name'] === 'notification.type.topic_in_queue')
		{
			$data = $event['data'];
			if (isset($data['phpbb_akismet_unapproved']))
			{
				$event['notification_type_name'] = 'phpbb.akismet.' . $event['notification_type_name'];
			}
			$event['data'] = $data;
		}
	}

	/**
	 * If someone deletes a group we're configured to add users to, update
	 * our configuration. Should avoid problems.
	 *
	 * @param \phpbb\event\data $event
	 */
	public function group_deleted($event)
	{
		if ($event['group_id'] == $this->config['phpbb_akismet_add_registering_spammers_to_group'])
		{
			$this->config->set('phpbb_akismet_add_registering_spammers_to_group', 0);
			$this->log_disable_group_add($event['group_name']);
		}

		if ($event['group_id'] == $this->config['phpbb_akismet_add_registering_blatant_spammers_to_group'])
		{
			$this->config->set('phpbb_akismet_add_registering_blatant_spammers_to_group', 0);
			$this->log_disable_group_add($event['group_name']);
		}
	}

	/**
	 * Inform Akismet service about false positive.
	 *
	 * Note that we submit all approved posts as ham, regardless of
	 * why post was in moderation queue. Akismet can deal with it
	 * and maybe even be trained better.
	 *
	 * @param \phpbb\event\data $event
	 */
	public function submit_ham($event)
	{
		if ($event['action'] !== 'approve')
		{
			return;
		}

		foreach ($event['post_info'] as $post)
		{
			$params = array(
				'user_ip'				=> $post['user_ip'],
				'comment_content'		=> $post['post_text'],
				'comment_author_email'	=> $post['user_email'],
				'comment_author'		=> $post['username'],
				'permalink'				=> generate_board_url() . '/' . append_sid("viewtopic.{$this->php_ext}", "p={$post['post_id']}", true, ''),
				// 'forum-post' recommended for type:
				// http://blog.akismet.com/2012/06/19/pro-tip-tell-us-your-comment_type/
				'comment_type'			=> 'forum-post',
			);
			$this->akismet_call('submitHam', $params, false); // without server, current user and page data are different than spammer's
		}
	}

	/**
	 * Add user to a group. Load phpBB function when needed.
	 *
	 * @param int $group_id
	 * @param int $user_id
	 */
	protected function group_user_add($group_id, $user_id)
	{
		if (!function_exists('group_user_add'))
		{
			include $this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext;
		}

		group_user_add($group_id, $user_id);
	}

	/**
	 * Check a post for spam.
	 *
	 * @param array $data Data array from event that triggered us.
	 * @return bool
	 */
	protected function is_spam($data)
	{
		// For URL of poster, i.e. poster's "website" profile field.
		$this->user->get_profile_fields($this->user->data['user_id']);

		// Akismet fields
		$params = array(
			'user_ip'				=> $this->user->ip,
			'user_agent'			=> $this->user->browser,
			'comment_content'		=> $data['message'],
			'comment_author_email'	=> $this->user->data['user_email'],
			'comment_author'		=> $this->user->data['username'],
			'comment_author_url'	=> isset($this->user->profile_fields['pf_phpbb_website']) ? $this->user->profile_fields['pf_phpbb_website'] : '',
			'permalink'				=> generate_board_url() . '/' . append_sid("viewtopic.{$this->php_ext}", "p={$data['post_id']}", true, ''),
			// 'forum-post' recommended for type:
			// http://blog.akismet.com/2012/06/19/pro-tip-tell-us-your-comment_type/
			'comment_type'			=> 'forum-post',
		);

		$result = $this->akismet_comment_check($params);

		return $result['is_spam'];
	}

	/**
	 * Call Akismet's comment-check method using our handy client.
	 * I hear it was written by a talented and ruggedly-handsome programmer.
	 *
	 * @param	array	$params		Akismet parameters
	 * @return	array	Result array
	 */
	protected function akismet_comment_check($params)
	{
		$result = array(
			'is_spam'			=> false,
			'is_blatant_spam'	=> false,
		);

		$check = $this->akismet_call('commentCheck', $params);
		if ($check !== false)
		{
			$result['is_spam'] = $check->isSpam();
			$result['is_blatant_spam'] = $check->isBlatantSpam();
		}

		return $result;
	}

	/**
	 * Log situation when we stop adding new potential spammers to designated group
	 * because it was removed.
	 *
	 * @param	string	$group_name	Group name
	 */
	protected function log_disable_group_add($group_name)
	{
		$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, 'AKISMET_LOG_SPAMMER_GROUP_REMOVED', false, array($group_name));
	}

	/**
	 * Log situation when post was marked spam by Akismet
	 *
	 * @param	string	$mode	Posting mode
	 * @param	array	$data	Data submitted by the user
	 * @return	void
	 */
	protected function log_mark_post_spam($mode, $data)
	{
		if ($mode === 'post' || ($mode === 'edit' && $data['topic_first_post_id'] == $data['post_id']))
		{
			$log_message = 'AKISMET_LOG_TOPIC_DISAPPROVED';
		}
		else
		{
			$log_message = 'AKISMET_LOG_POST_DISAPPROVED';
		}

		$this->log->add('mod', $this->user->data['user_id'], $this->user->ip, $log_message, false, array($data['topic_title'], $this->user->data['username']));
	}

	/**
	 * Perform an API call to Akismet server
	 *
	 * @param	string	$method			Method name of the call (commentCheck|submitSpam|submitHam)
	 * @param	array	$params			Parameters for the call
	 * @param	boolean	$with_server	Should we send server info as well?
	 * @return 	boolean|SubmitSpamResult|SubmitHamResult|CommentCheckResult
	 * 									False on failure; result class of defined method otherwise
	 */
	protected function akismet_call($method, $params, $with_server = true)
	{
		// Call will definitely not pass without API key, don't even try
		if (empty($this->config['phpbb_akismet_api_key']))
		{
			return false;
		}

		try
		{
			$server = $with_server ? $this->get_server_vars() : array();
			return $this->akismet->$method($params, $server);
		}
		catch (\Exception $e)
		{
			$this->log->add('critical', $this->user->data['username'], $this->user->ip, 'AKISMET_LOG_CALL_FAILED', false, array($e->getMessage()));
		}

		return false;
	}

	/**
	 * Get server variables. Data are cached for multiple use.
	 *
	 * @return array	Server variables
	 */
	protected function get_server_vars()
	{
		if (empty($this->server_vars))
		{
			// We can't just pass $_SERVER in to our Akismet client as phpBB turns off super globals (which is,
			// of course, fair enough.) Interrogate our request object instead, grabbing as many relevant
			// things as we can, excluding anything that might leak anything sensitive to Akismet (bear in
			// mind we're already throwing all the user details and the entire contents of their comment
			// at Akismet, of course.)

			// https://akismet.com/development/api/#comment-check
			// "This data is highly useful to Akismet. How the submitted content interacts with the server can
			// be very telling, so please include as much of it as possible."
			$server_vars = array(
				// TODO: Use a blacklist for sensitive server-related stuff, rather than a whitelist. It'll
				// be more friendly for other people's setups, and the code will be shorter.
				'AUTH_TYPE',
				'GATEWAY_INTERFACE',
				'HTTPS',
				'HTTP_ACCEPT',
				'HTTP_ACCEPT_CHARSET',
				'HTTP_ACCEPT_ENCODING',
				'HTTP_ACCEPT_LANGUAGE',
				'HTTP_CONNECTION',
				'HTTP_HOST',
				'HTTP_REFERER',
				'HTTP_USER_AGENT',
				'ORIG_PATH_INFO',
				'PATH_INFO',
				'PATH_TRANSLATED',
				'PHP_AUTH_DIGEST',
				'PHP_AUTH_PW',
				'PHP_SELF',
				'PHP_AUTH_USER',
				'QUERY_STRING',
				'REDIRECT_REMOTE_USER',
				'REMOTE_ADDR',
				'REMOTE_HOST',
				'REMOTE_PORT',
				'REMOTE_USER',
				'REQUEST_METHOD',
				'REQUEST_SCHEME',
				'REQUEST_TIME',
				'REQUEST_TIME_FLOAT',
				'REQUEST_URI',
				'SCRIPT_FILENAME',
				'SCRIPT_NAME',
				'SCRIPT_URI',
				'SCRIPT_URL',
				'SERVER_ADDR',
				'SERVER_NAME',
				'SERVER_PORT',
				'SERVER_PROTOCOL',
				'SERVER_SIGNATURE',
				'SERVER_SOFTWARE',
				'USER',
			);

			// Try to recreate $_SERVER.
			foreach ($server_vars as $var)
			{
				$value = $this->request->server($var, null);
				if ($value !== null)
				{
					$this->server_vars[$var] = $value;
				}
			}
		}

		return $this->server_vars;
	}
}
