<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

require_once __DIR__ . '/../../../../../includes/functions_module.php';

class akismet_module_test extends \phpbb_test_case
{
	/** @var \phpbb_mock_extension_manager */
	protected $extension_manager;

	/** @var \phpbb\module\module_manager */
	protected $module_manager;

	public function setUp()
	{
		global $phpbb_dispatcher, $phpbb_extension_manager, $phpbb_root_path, $phpEx;

		$this->extension_manager = new \phpbb_mock_extension_manager(
			$phpbb_root_path,
			array(
				'senky/akismet' => array(
					'ext_name' => 'senky/akismet',
					'ext_active' => '1',
					'ext_path' => 'ext/senky/akismet/',
				),
			));
		$phpbb_extension_manager = $this->extension_manager;

		$this->module_manager = new \phpbb\module\module_manager(
			new \phpbb\cache\driver\dummy(),
			$this->getMockBuilder('\phpbb\db\driver\driver_interface')->getMock(),
			$this->extension_manager,
			MODULES_TABLE,
			$phpbb_root_path,
			$phpEx
		);

		$phpbb_dispatcher = new \phpbb_mock_event_dispatcher();
	}

	public function test_module_info()
	{
		$this->assertEquals(array(
			'\\senky\\akismet\\acp\\akismet_module' => array(
				'filename'	=> '\\senky\\akismet\\acp\\akismet_module',
				'title'		=> 'ACP_AKISMET_TITLE',
				'modes'		=> array(
					'settings'	=> array(
						'title'	=> 'ACP_AKISMET_SETTINGS',
						'auth'	=> 'ext_senky/akismet && acl_a_board',
						'cat'	=> array('ACP_AKISMET_TITLE')
					),
				),
			),
		), $this->module_manager->get_module_infos('acp', 'acp_akismet_module'));
	}

	public function module_auth_test_data()
	{
		return array(
			// module_auth, expected result
			array('ext_foo/bar', false),
			array('ext_senky/akismet', true),
		);
	}

	/**
	 * @dataProvider module_auth_test_data
	 */
	public function test_module_auth($module_auth, $expected)
	{
		$this->assertEquals($expected, p_master::module_auth($module_auth, 0));
	}

	public function main_module_test_data()
	{
		return array(
			array('settings'),
		);
	}

	/**
	 * @dataProvider main_module_test_data
	 */
	public function test_main_module($mode)
	{
		global $phpbb_root_path, $phpEx;
		global $phpbb_container, $request, $template;

		define('IN_ADMIN', true);
		$request = $this->getMock('\phpbb\request\request');
		$template = $this->getMock('\phpbb\template\template');
		$phpbb_container = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
		$language = $this->getMockBuilder(\phpbb\language\language::class)
			->disableOriginalConstructor()
			->getMock();
		$admin_controller = $this->getMockBuilder('\senky\akismet\controller\admin_controller')
			->disableOriginalConstructor()
			->getMock();

		$phpbb_container
			->expects($this->at(0))
			->method('get')
			->with('language')
			->will($this->returnValue($language));

		$language->expects($this->once())
			->method('add_lang')
			->with('akismet_acp', 'senky/akismet');

		$phpbb_container
			->expects($this->at(1))
			->method('get')
			->with('senky.akismet.admin.controller')
			->will($this->returnValue($admin_controller));

		$admin_controller
			->expects($this->once())
			->method('set_action');

		$p_master = new p_master();
		$p_master->load('acp', '\senky\akismet\acp\akismet_module', $mode);
	}
}