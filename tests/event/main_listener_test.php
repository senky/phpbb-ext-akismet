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

class main_listener_test extends main_listener_base
{
	/**
	* Test the event listener is constructed correctly
	*/
	public function test_construct()
	{
		$this->assertInstanceOf('\Symfony\Component\EventDispatcher\EventSubscriberInterface', $this->get_listener());
	}
	/**
	* Test the event listener is subscribing events
	*/
	public function test_getSubscribedEvents()
	{
		$this->assertEquals(array(
			'core.posting_modify_submit_post_before',
			'core.notification_manager_add_notifications',
			'core.user_add_after',
			'core.delete_group_after',
			'core.approve_posts_after',
		), array_keys(\senky\akismet\event\main_listener::getSubscribedEvents()));
	}
}
