<?php
/**
 * Akismet notification type migrations.
 *
 * @package phpBB Extension - Gothick Akismet
 * @copyright (c) 2017 Matt Gibson Creative Ltd.
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
namespace senky\akismet\migrations\v10x;

class m2_configs extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return $this->config->offsetExists('senky_akismet_api_key');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return array('\senky\akismet\migrations\v10x\m1_acp_module');
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('senky_akismet_api_key', '')),
			array('config.add', array('senky_akismet_check_registrations', 0)),
			array('config.add', array('senky_akismet_add_registering_spammers_to_group', 0)),
			array('config.add', array('senky_akismet_add_registering_blatant_spammers_to_group', 0)),
			array('config.add', array('senky_akismet_skip_check_after_n_posts', 0)),
		);
	}
}
