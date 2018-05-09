<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\acp;

class akismet_info
{
	public function module()
	{
		return array(
			'filename'	=> '\senky\akismet\acp\akismet_module',
			'title'		=> 'ACP_AKISMET_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_AKISMET_SETTINGS',
					'auth'	=> 'ext_senky/akismet && acl_a_board',
					'cat'	=> array('ACP_AKISMET_TITLE'),
				),
			),
		);
	}
}
