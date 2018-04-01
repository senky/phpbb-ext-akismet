<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\acp;

class akismet_info
{
	public function module()
	{
		return array(
			'filename'	=> '\phpbb\akismet\acp\akismet_module',
			'title'		=> 'ACP_AKISMET_TITLE',
			'modes'		=> array(
				'settings'	=> array(
					'title'	=> 'ACP_AKISMET_SETTINGS',
					'auth'	=> 'ext_phpbb/akismet && acl_a_board',
					'cat'	=> array('ACP_AKISMET_TITLE'),
				),
			),
		);
	}
}
