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

class group_deleted_test extends main_listener_base
{
	/**
	 * Make sure we unset the configuration to send spammers to a particular group if that
	 * group gets deleted.
	 */
	public function test_normal_group_deleted()
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.delete_group_after', array($this->get_listener(), 'group_deleted'));

		// It shouldn't pop something in the moderator log.
		$this->log->expects($this->never())
			->method('add')
			->with($this->equalTo('mod'));

		// Initialize config values
		$this->config->set('senky_akismet_add_registering_spammers_to_group', 888);
		$this->config->set('senky_akismet_add_registering_blatant_spammers_to_group', 999);

		// Event data
		$group_id = 123;

		// Generate event
		$event_data = array('group_id');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.delete_group_after', $event);

		// Match data after event was dispatched
		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertEquals(888, $this->config['senky_akismet_add_registering_spammers_to_group']);
		$this->assertEquals(999, $this->config['senky_akismet_add_registering_blatant_spammers_to_group']);
	}

	/**
	 * Make sure we unset the configuration to send spammers to a particular group if that
	 * group gets deleted.
	 */
	public function test_spammy_group_deleted()
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.delete_group_after', array($this->get_listener(), 'group_deleted'));

		// It should pop something in the moderator log.
		$this->log->expects($this->once())
			->method('add')
			->with($this->equalTo('mod'));

		// Initialize config values
		$this->config->set('senky_akismet_add_registering_spammers_to_group', 888);
		$this->config->set('senky_akismet_add_registering_blatant_spammers_to_group', 999);

		// Event data
		$group_id = 888;

		// Generate event
		$event_data = array('group_id');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.delete_group_after', $event);

		// Match data after event was dispatched
		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertEquals(0, $this->config['senky_akismet_add_registering_spammers_to_group']);
		$this->assertEquals(999, $this->config['senky_akismet_add_registering_blatant_spammers_to_group']);
	}

	/**
	 * Make sure we unset the configuration to send spammers to a particular group if that
	 * group gets deleted.
	 */
	public function test_blatantly_spammy_group_deleted()
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.delete_group_after', array($this->get_listener(), 'group_deleted'));

		// It should pop something in the moderator log.
		$this->log->expects($this->once())
			->method('add')
			->with($this->equalTo('mod'));

		// Initialize config values
		$this->config->set('senky_akismet_add_registering_spammers_to_group', 888);
		$this->config->set('senky_akismet_add_registering_blatant_spammers_to_group', 999);

		// Event data
		$group_id = 999;

		// Generate event
		$event_data = array('group_id');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.delete_group_after', $event);

		// Match data after event was dispatched
		$event_data_after = $event->get_data_filtered($event_data);
		$this->assertEquals(888, $this->config['senky_akismet_add_registering_spammers_to_group']);
		$this->assertEquals(0, $this->config['senky_akismet_add_registering_blatant_spammers_to_group']);
	}
}
