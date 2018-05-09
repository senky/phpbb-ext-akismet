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

class add_akismet_details_to_notification_test extends main_listener_base
{
	public function notification_template_data()
	{
		return array(
			array(
				true, // senky_akismet_unapproved
				'notification.type.some_type_or_other', // Incoming notification type
				'notification.type.some_type_or_other' // Expected outgoing notification type
			),
			array(
				false, // senky_akismet_unapproved
				'notification.type.some_type_or_other', // Incoming notification type
				'notification.type.some_type_or_other' // Expected outgoing notification type
			),
			array(
				null, // senky_akismet_unapproved
				'notification.type.some_type_or_other', // Incoming notification type
				'notification.type.some_type_or_other' // Expected outgoing notification type
			),
			array(
				null, // senky_akismet_unapproved
				'notification.type.post_in_queue', // Incoming notification type
				'notification.type.post_in_queue' // Expected outgoing notification type
			),
			array(
				null, // senky_akismet_unapproved
				'notification.type.topic_in_queue', // Incoming notification type
				'notification.type.topic_in_queue' // Expected outgoing notification type
			),
			array(
				true, // senky_akismet_unapproved
				'notification.type.post_in_queue', // Incoming notification type
				'senky.akismet.notification.type.post_in_queue' // Expected outgoing notification type
			),
			array(
				true, // senky_akismet_unapproved
				'notification.type.topic_in_queue', // Incoming notification type
				'senky.akismet.notification.type.topic_in_queue' // Expected outgoing notification type
			),
		);
	}

	/**
	 * @dataProvider notification_template_data
	 */
	public function test_akismet_notification_template_triggered($senky_akismet_unapproved, $incoming_type, $expected_outgoing_type)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.notification_manager_add_notifications', array($this->get_listener(), 'add_akismet_details_to_notification'));

		// Event data
		$data = array(
			'senky_akismet_unapproved' => $senky_akismet_unapproved,
		);
		$notification_type_name = $incoming_type;

		// Generate event
		$event_data = array('data', 'notification_type_name');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.notification_manager_add_notifications', $event);

		// Verify expectations
		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertEquals($expected_outgoing_type, $event_data_after['notification_type_name']);
	}
}
