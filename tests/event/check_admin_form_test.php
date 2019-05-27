<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\event;

class check_admin_form_test extends main_listener_base
{
	public function form_data()
	{
		return [
			[
				'viagra-test-123',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'0',
				false,
				false,
				false,
			],
			[
				'viagra-test-123',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'0',
				false,
				false,
				false,
			],
			[
				'matt',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'0',
				false,
				false,
				true,
			],
			[
				'viagra-test-123', // Username should be marked spam, but it should pass because of posts count
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'6',
				false,
				false,
				true,
			],
			[
				'viagra-test-123', // Username should be marked spam, but it should pass because user is admin
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'0',
				true,
				false,
				true,
			],
			[
				'viagra-test-123', // Username should be marked spam, but it should pass because user is moderator
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'0',
				false,
				true,
				true,
			],
		];
	}

	/**
	 * @dataProvider form_data
	 */
	public function test_check_admin_form($username, $message, $user_posts, $is_admin, $is_mod, $should_pass)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.message_admin_form_submit_before', array($this->get_listener(), 'check_admin_form'));
		
		// Set username, user posts, senky_akismet_api_key and skip_check_after_n_posts
		$this->user->data['username'] = $username;
		$this->user->data['user_posts'] = $user_posts;
		$this->config['senky_akismet_api_key'] = 'abcdef';
		$this->config['senky_akismet_skip_check_after_n_posts'] = 5;
		$this->config['senky_akismet_check_admin_form'] = true;

		$this->auth->expects($this->at(0))
			->method('acl_getf_global')
			->with('m_')
			->willReturn($is_mod);

		// Admin check is triggered only if user is not moderator
		if (!$is_mod)
		{
			$this->auth->expects($this->at(1))
				->method('acl_getf_global')
				->with('a_')
				->willReturn($is_admin);
		}

		if (!$should_pass)
		{
			$this->language->expects($this->once())
				->method('add_lang')
				->with('admin_form', 'senky/akismet');

			$this->language->expects($this->once())
				->method('lang')
				->with('SPAM_MESSAGE')
				->willReturn('SPAM_MESSAGE');
		}

		// Event data
		$subject = 'subject';
		$body = $message;
		$errors = [];

		// Generate event
		$event_data = array('subject', 'body', 'errors');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.message_admin_form_submit_before', $event);

		// Verify expectations
		$event_data_after = $event->get_data_filtered($event_data);

		if ($should_pass)
		{
			$this->assertEmpty($event_data_after['errors']);
		}
		else
		{
			$this->assertEquals($event_data_after['errors'][0], 'SPAM_MESSAGE');
		}
	}

	/**
	 * @dataProvider form_data
	 */
	public function test_no_akismet_object_check_admin_form($username, $message, $mode, $should_pass)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.message_admin_form_submit_before', array($this->get_listener(), 'check_submitted_post'));

		// This is the same as test_check_admin_form except because we don't have an Akismet
		// object set up, every check should quietly pass (with no exceptions)

		// Event data
		$data = array(
			'subject'	=> '',
			'body'		=> $message,
			'errors'	=> [],
		);

		// Generate event
		$event_data = array('subject', 'body', 'errors');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.message_admin_form_submit_before', $event);

		// Verify expectations
		$event_data_after = $event->get_data_filtered($event_data);

		// As we couldn't have gotten an Akismet object, every test should pass.
		$this->assertEmpty($event_data_after['errors']);
	}
}
