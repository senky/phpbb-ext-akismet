<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\migrations\v10x;

class m3_admin_form extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed()
	{
		return $this->config->offsetExists('senky_akismet_check_admin_form');
	}

	/**
	 * {@inheritDoc}
	 */
	static public function depends_on()
	{
		return ['\senky\akismet\migrations\v10x\m2_configs'];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data()
	{
		return [
			['config.add', ['senky_akismet_check_admin_form', 0]],
		];
	}
}
