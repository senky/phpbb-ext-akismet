<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\event;

class submit_spam_test extends main_listener_base
{
	public function submit_spam_data()
	{
		return array(
			array(
				'restore',
				array(
					1	=> array(
						'what'	=> 'ever',
					),
				),
				array(),
				false,
				'SPAM',
			),
			array(
				'disapprove',
				array(
					1	=> array(
						'user_ip'		=> '1.2.3.4',
						'post_text'		=> 'post text',
						'user_email'	=> 'user@email.com',
						'username'		=> 'User Name',
						'post_id'		=> 1,
					),
					2	=> array(
						'user_ip'		=> '5.5.5.5',
						'post_text'		=> 'post text 2',
						'user_email'	=> 'user2@email.com',
						'username'		=> 'User Name 2',
						'post_id'		=> 2,
					),
				),
				array(
					array(
						'user_ip'				=> '1.2.3.4',
						'comment_content'		=> 'post text',
						'comment_author_email'	=> 'user@email.com',
						'comment_author'		=> 'User Name',
						'permalink'				=> 'http://viewtopic.php?p=1',
						'comment_type'			=> 'forum-post',
					),
					array(
						'user_ip'				=> '5.5.5.5',
						'comment_content'		=> 'post text 2',
						'comment_author_email'	=> 'user2@email.com',
						'comment_author'		=> 'User Name 2',
						'permalink'				=> 'http://viewtopic.php?p=2',
						'comment_type'			=> 'forum-post',
					),
				),
				false,
				'SPAM',
			),
			array(
				'disapprove',
				array(
					1	=> array(
						'user_ip'		=> '1.2.3.4',
						'post_text'		=> 'post text',
						'user_email'	=> 'user@email.com',
						'username'		=> 'User Name',
						'post_id'		=> 1,
					),
				),
				array(
					array(
						'user_ip'				=> '1.2.3.4',
						'comment_content'		=> 'post text',
						'comment_author_email'	=> 'user@email.com',
						'comment_author'		=> 'User Name',
						'permalink'				=> 'http://viewtopic.php?p=1',
						'comment_type'			=> 'forum-post',
					),
				),
				true,
				'SPAM',
			),
			array(
				'disapprove',
				array(
					1	=> array(
						'user_ip'		=> '1.2.3.4',
						'post_text'		=> 'post text',
						'user_email'	=> 'user@email.com',
						'username'		=> 'User Name',
						'post_id'		=> 1,
					),
				),
				array(),
				false,
				'OTHER',
			),
		);
	}

	/**
	 * @dataProvider submit_spam_data
	 */
	public function test_submit_spam($action, $post_info, $params, $returns_exception, $disapprove_reason_lang)
	{
		// Temporarily replace Akismet client
		$akismet = $this->akismet;
		$this->akismet = $this->getMockBuilder(\Gothick\AkismetClient\Client::class)
			->disableOriginalConstructor()
			->getMock();

		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.disapprove_posts_after', array($this->get_listener(), 'submit_spam'));

		// Make sure we have API key set
		$this->config['senky_akismet_api_key'] = 'abcdef';

		// Set expectations
		if ($action == 'disapprove' && $disapprove_reason_lang == 'SPAM')
		{
			$this->akismet->expects($this->exactly(count($post_info)))
				->method('submitSpam')
				->with($this->callback(function($input) use ($params, $post_info) {
					static $index = 0;

					// Callback is called once more at the end of the cycle, we need to return true in that case.
					if ($index >= count($post_info))
					{
						return true;
					}

					return $input == $params[$index++];
				}), array())
				->will($returns_exception ? $this->throwException(new \Exception()) : $this->returnValue(true));

			if ($returns_exception)
			{
				$this->log->expects($this->once())
					->method('add')
					->with($this->equalTo('critical'));
			}
		}

		// Generate event
		$event_data = array('action', 'post_info', 'disapprove_reason_lang');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.disapprove_posts_after', $event);

		// Switch back Akismet client
		$this->akismet = $akismet;
	}
}
