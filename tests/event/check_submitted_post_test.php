<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\tests\event;

class check_submitted_post_test extends main_listener_base
{
	public function post_data()
	{
		return array(
			array(
				'viagra-test-123',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'reply',
				false,
			),
			array(
				'viagra-test-123',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'post', // Post produces a different log message, so it's a different path.
				false,
			),
			array(
				'matt',
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
				'reply',
				true,
			)
		);
	}

	/**
	 * @dataProvider post_data
	 */
	public function test_post_check($username, $message, $mode, $should_pass)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.posting_modify_submit_post_before', array($this->get_listener(), 'check_submitted_post'));
		
		// Set username and Akismet client
		$this->user->data['username'] = $username;
		$this->phpbb_container->set('phpbb.akismet.client', new \phpbb\akismet\tests\mock\akismet_mock($blatant));

		// Set expectations
		if (!$should_pass)
		{
			$this->log->expects($this->once())
				->method('add')
				->with($this->equalTo('mod'));
			
			$this->request->expects($this->any())
				->method('server')
				->with($this->anything(), null)
				->willReturn('');
		}

		// Event data
		$data = array(
			'message' => $message,
			'topic_id' => 123,
		);

		// Generate event
		$event_data = array('mode', 'data');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.posting_modify_submit_post_before', $event);

		// Verify expectations
		$event_data_after = $event->get_data_filtered($event_data);

		if ($should_pass)
		{
			$this->assertFalse(isset($event_data_after['data']['force_approved_state']));
		}
		else
		{
			$this->assertTrue(isset($event_data_after['data']['force_approved_state']));
			$this->assertEquals($event_data_after['data']['force_approved_state'], ITEM_UNAPPROVED);
		}
	}

	/**
	 * @dataProvider post_data
	 */
	public function test_no_akismet_object_post($username, $message, $mode, $should_pass)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.posting_modify_submit_post_before', array($this->get_listener(), 'check_submitted_post'));

		// This is the same as test_post_check except because we don't have an Akismet
		// object set up, every check should quietly pass (with no exceptions, but a
		// bit of gentle logging.
		$this->log->expects($this->once())
			->method('add')
			->with($this->equalTo('critical'));

		// Event data
		$data = array(
			'message' => $message,
			'topic_id' => 123,
		);

		// Generate event
		$event_data = array('mode', 'data');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.posting_modify_submit_post_before', $event);

		// Verify expectations
		$event_data_after = $event->get_data_filtered($event_data);

		// As we couldn't have gotten an Akismet object, every test should pass.
		$this->assertFalse(isset($event_data_after['data']['force_approved_state']));
	}
}
