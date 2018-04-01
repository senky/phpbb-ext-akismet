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

/**
 * ACP page for configuring Gothick Akismet: API key, Akismet, etc.
 *
 * @author matt
 *
 */
class akismet_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container;

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');
		$language->add_lang('akismet_acp', 'phpbb/akismet');

		/* @var $admin_controller \phpbb\akismet\controller\admin_controller */
		$admin_controller = $phpbb_container->get('phpbb.akismet.admin.controller');
		$admin_controller->set_action($this->u_action);

		$this->tpl_name = 'akismet_body';
		$this->page_title = $language->lang('ACP_AKISMET_TITLE');

		$admin_controller->display_settings();
	}
}
