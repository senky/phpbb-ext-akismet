<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\event;

class submit_ham_test extends main_listener_base
{
	public function submit_ham_data()
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
			),
			array(
				'approve',
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
			),
			array(
				'approve',
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
			),
		);
	}

	/**
	 * @dataProvider submit_ham_data
	 */
	public function test_submit_ham($action, $post_info, $params, $returns_exception)
	{
		// Temporarily replace Akismet client
		$akismet = $this->akismet;
		$this->akismet = $this->getMockBuilder(\Gothick\AkismetClient\Client::class)
			->disableOriginalConstructor()
			->getMock();

		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.approve_posts_after', array($this->get_listener(), 'submit_ham'));
		
		// Make sure we have API key set
		$this->config['senky_akismet_api_key'] = 'abcdef';

		// Set expectations
		if ($action == 'approve')
		{
			$this->akismet->expects($this->exactly(count($post_info)))
				->method('submitHam')
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
		$event_data = array('action', 'post_info');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.approve_posts_after', $event);

		// Switch back Akismet client
		$this->akismet = $akismet;
	}
}
