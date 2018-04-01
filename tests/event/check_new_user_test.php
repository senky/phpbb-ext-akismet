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

class check_new_user_test extends main_listener_base
{
	public function user_registration_data()
	{
		return array(
			array(
				123,
				array(
					'phpbb_akismet_check_registrations' => true
				), // Config
				'viagra-test-123', // User name being registered
				false, // "Blatant" spammer
				false, // Should it pass the spammy test? (No, they're trying to sell viagra!)
				false, // Should it be added to the spammers group? (No, as we've not set that config option)
				false  // Should it be added to the blatant spammers group? (No, as we've not set that config option)
			),
			array(
				124,
				array(
					'phpbb_akismet_check_registrations' => true
				), // Config
				'viagra-test-123', // User name being registered
				true, // "Blatant" spammer
				false, // Should it pass the spammy test? (No, they're *blatantly* trying to sell viagra!)
				false, // Should it be added to the spammers group? (No, as we've not set that config option.)
				false  // Should it be added to the blatant spammers group? (No, as we've not set that config option)
			),
			array(
				125,
				array(
					'phpbb_akismet_check_registrations' => true,
					'phpbb_akismet_add_registering_spammers_to_group' => 234
				), // Config
				'viagra-test-123', // User name being registered
				false, // "Blatant" spammer
				false, // Should it pass the spammy test? (No, they're trying to sell viagra!)
				true, // Should it be added to the spammers group? (Yes, as we've set that config option)
				false  // Should it be added to the blatant spammers group? (No, as we've not set that config option)
			),
			array(
				126,
				array(
					'phpbb_akismet_check_registrations' => true,
					'phpbb_akismet_add_registering_spammers_to_group' => 234
				), // Config
				'viagra-test-123', // User name being registered
				true, // "Blatant" spammer
				false, // Should it pass the spammy test? (No, they're *blatantly* trying to sell viagra!)
				true, // Should it be added to the spammers group? (Yes, as we've set that config option)
				false  // Should it be added to the blatant spammers group? (No, as we've not set that config option)
			),
			array(
				127,
				array(
					'phpbb_akismet_check_registrations' => false, // Not configured to check registrations...
					'phpbb_akismet_add_registering_spammers_to_group' => 234,
					'phpbb_akismet_add_registering_blatant_spammers_to_group' => 345
				),
				'viagra-test-123',
				true,
				true, // So even a blatant spammer should pass through
				false, // And we shouldn't add it to the spammy group even though we're configured to put spammers in there
				false  // ...nor to the blatant spammers group
			),
			array(
				128,
				array(
					'phpbb_akismet_check_registrations' => true,
					'phpbb_akismet_add_registering_spammers_to_group' => 234,
					'phpbb_akismet_add_registering_blatant_spammers_to_group' => 345
				),
				'matt',
				false,
				true, // "Matt" should be fine; he's not trying to sell us viagra
				false, // And shouldn't be added to the spammy group, even though we're configured to put spammers in there.
				false  // ...nor to the blatant spammers group
			),
			array(
				129,
				array(
					'phpbb_akismet_check_registrations' => true,
					'phpbb_akismet_add_registering_spammers_to_group' => 234,
					'phpbb_akismet_add_registering_blatant_spammers_to_group' => 345
				),
				'viagra-test-123',
				true, // Blatant spammer
				false, // Shouldn't pass the spammy test
				false, // Should be added to the spammy group
				false  // *and* to the the blatant spammers group
			),
		);
	}

	/**
	 * @dataProvider user_registration_data
	 */
	public function test_registration_check($user_id, $config, $username, $blatant, $should_pass, $should_add_to_spammy_group, $should_add_to_blatantly_spammy_group)
	{
		// Initiate DB
		$db = $this->new_dbal();

		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.user_add_after', array($this->get_listener(), 'check_new_user'));

		// Set config values, username and Akismet client
		foreach ($config as $name => $value)
		{
			$this->config->set($name, $value);
		}
		$this->user->data['username'] = $username;
		$this->phpbb_container->set('phpbb.akismet.client', new \phpbb\akismet\tests\mock\akismet_mock($blatant));

		// Set expectations
		if (!$should_pass)
		{
			$this->log->expects($this->atLeastOnce())
				->method('add');
		}

		// Event data
		$user_row = array(
			'username'		=> $username,
			'user_email'	=> 'whoever@example.com',
		);

		// Generate event
		$event_data = array('user_id', 'user_row');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.user_add_after', $event);

		// Verify expectations
		if ($should_add_to_spammy_group)
		{
			$sql = 'SELECT *
				FROM phpbb_user_group
				WHERE user_id = ' . (int) $user_id . '
					AND group_id = 234';
			$result = $db->sql_query($sql);
			$this->assertNotFalse($db->sql_fetchrow($result));
		}
		if ($should_add_to_blatantly_spammy_group)
		{
			$sql = 'SELECT *
				FROM phpbb_user_group
				WHERE user_id = ' . (int) $user_id . '
					AND group_id = 235';
			$result = $db->sql_query($sql);
			$this->assertNotFalse($db->sql_fetchrow($result));
		}
	}

	/**
	 * @dataProvider user_registration_data
	 *
	 * Same as test_registration_check, except we'll fake a failure to create the Akismet client. All
	 * registrations should pass through without being marked as spam.
	 */
	public function test_no_akismet_object_registration($config, $username, $blatant, $should_pass, $should_add_to_spammy_group)
	{
		// Subscribe our method
		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
		$dispatcher->addListener('core.user_add_after', array($this->get_listener(), 'check_new_user'));

		if ($config['phpbb_akismet_check_registrations'])
		{
			// If we're configured to check registrations, then I expect us to fail with
			// an exception, as there'll be no Akismet client configured.
			$this->log->expects($this->once())
				->method('add')
				->with($this->equalTo('critical'));
		}
		else
		{
			// But if we're not configured, none of our code should run, so there should
			// be no logging.
			$this->log->expects($this->never())
				->method('add');
		}

		// Event data
		$user_row = array(
			'username'		=> $username,
			'user_email'	=> 'whoever@example.com',
		);

		// Generate event
		$event_data = array('user_id', 'user_row');
		$event = new \phpbb\event\data(compact($event_data));

		// Dispatch event
		$dispatcher->dispatch('core.user_add_after', $event);
	}
}
