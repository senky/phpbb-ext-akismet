<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\controller
{
	function check_form_key($dummy)
	{
		return \senky\akismet\tests\controller\admin_controller_test::$check_form_key_result;
	}

	function add_form_key($dummy)
	{
	}

	function adm_back_link($dummy)
	{
		return '';
	}
}

namespace senky\akismet\tests\controller
{
	class admin_controller_test extends \phpbb_test_case
	{
		public static $check_form_key_result = false;

		/** @var \phpbb\request\request|\PHPUnit_Framework_MockObject_MockObject */
		protected $request;

		/** @var \phpbb\template\template|\PHPUnit_Framework_MockObject_MockObject */
		protected $template;

		/** @var \phpbb\log\log_interface|\PHPUnit_Framework_MockObject_MockObject */
		protected $log;

		/** @var \phpbb\config\config|\PHPUnit_Framework_MockObject_MockObject */
		protected $config;

		/** @var \phpbb\language\language|\PHPUnit_Framework_MockObject_MockObject */
		protected $language;

		/** @var \phpbb\user|\PHPUnit_Framework_MockObject_MockObject */
		protected $user;

		/** @var \phpbb\group\helper|\PHPUnit_Framework_MockObject_MockObject */
		protected $group_helper;

		/** @var \phpbb\db\driver\driver_interface|\PHPUnit_Framework_MockObject_MockObject */
		protected $db;

		/** @var string */
		protected $php_ext;

		/** @var string */
		protected $root_path;

		/** @var string */
		protected $groups_table;

		/** @var string */
		protected $u_action;

		/** @var string */
		protected $key_verified;

		public function setUp()
		{
			global $phpbb_root_path, $phpEx;

			parent::setUp();

			$this->request = $this->getMockBuilder(\phpbb\request\request::class)->getMock();
			$this->template = $this->getMockBuilder(\phpbb\template\template::class)->getMock();
			$this->log = $this->getMockBuilder(\phpbb\log\dummy::class)->getMock();
			$this->config = new \phpbb\config\config([]);
			$lang_loader = new \phpbb\language\language_file_loader($phpbb_root_path, $phpEx);
			$this->language = new \phpbb\language\language($lang_loader);
			$this->user = new \phpbb\user($this->language, '\phpbb\datetime');
			$this->group_helper = $this->getMockBuilder(\phpbb\group\helper::class)->disableOriginalConstructor()->getMock();
			$this->db = $this->getMockBuilder(\phpbb\db\driver\driver_interface::class)->getMock();
			$this->php_ext = $phpEx;
			$this->root_path = $phpbb_root_path;
			$this->groups_table = 'phpbb_groups';

			$this->u_action = $phpbb_root_path . 'adm/index.php?i=-phpbb-akismet-acp-akismet_module&mode=settings';
			$this->key_verified = true;
		}

		public function get_controller()
		{
			$controller = new \senky\akismet\controller\admin_controller(
				$this->request,
				$this->template,
				$this->user,
				$this->log,
				$this->config,
				$this->language,
				$this->group_helper,
				$this->db,
				new \senky\akismet\tests\mock\akismet_mock(false, $this->key_verified),
				$this->php_ext,
				$this->root_path,
				$this->groups_table
			);
			$controller->set_action($this->u_action);

			return $controller;
		}

		/**
		 * Basic test to exercise the constructor
		 */
		public function test_construct()
		{
			$this->assertInstanceOf(\senky\akismet\controller\admin_controller::class, $this->get_controller());
		}

		/**
		 * Make sure we're paying attention to the form key.
		 */
		public function test_invalid_form_key()
		{
			$controller = $this->get_controller();
			self::$check_form_key_result = false;

			$this->request->method('is_set_post')
				->with('submit')
				->willReturn(true);
			
			$this->setExpectedTriggerError(E_USER_NOTICE, 'FORM_INVALID');
			
			$controller->display_settings();
		}

		/**
		 * Make sure we're paying attention to the invalid API key.
		 */
		public function test_invalid_api_key()
		{
			$this->key_verified = false;
			$controller = $this->get_controller();
			self::$check_form_key_result = true;

			$this->request->method('is_set_post')
				->with('submit')
				->willReturn(true);
			
			$this->setExpectedTriggerError(E_USER_WARNING, 'ACP_AKISMET_API_KEY_INVALID');
			
			$controller->display_settings();
		}

		/**
		 * Make sure we log the change of settings to the admin log.
		 */
		public function test_save_settings_logged()
		{
			$this->key_verified = true;
			$controller = $this->get_controller();
			self::$check_form_key_result = true;

			$this->request->method('is_set_post')
				->with('submit')
				->willReturn(true);

			$this->log->expects($this->once())
				->method('add')
				->with($this->equalTo('admin'));
			
			$this->setExpectedTriggerError(E_USER_NOTICE, 'ACP_AKISMET_SETTING_SAVED');

			$controller->display_settings();
		}

		/**
		 * Test that the controller assigns all its variables properly.
		 */
		public function test_assign_vars()
		{
			$this->key_verified = true;
			$controller = $this->get_controller();

			$this->config['senky_akismet_api_key'] = 'IM_AN_API_KEY_HONEST_GUV_123';
			$this->config['senky_akismet_check_registrations'] = 1;
			$this->config['senky_akismet_add_registering_spammers_to_group'] = 2;
			$this->config['senky_akismet_add_registering_blatant_spammers_to_group'] = 3;
			$this->config['senky_akismet_skip_check_after_n_posts'] = 5;

			$this->db->expects($this->exactly(8))
				->method('sql_fetchrow')
				->will($this->onConsecutiveCalls(
					array(
						// Should be ignored, as we ignore all special groups except NEWLY_REGISTERED
						'group_id' => '1',
						'group_type' => GROUP_SPECIAL,
						'group_name' => 'ADMINISTRATORS',
					),
					array(
						// Should be picked up
						'group_id' => '2',
						'group_type' => GROUP_HIDDEN,
						'group_name' => 'Newly-Registered Spammers',
					),
					array(
						// Should be picked up
						'group_id' => '3',
						'group_type' => GROUP_HIDDEN,
						'group_name' => 'Newly-Registered Blatant Spammers',
					),
					false, // End of rows
					array(
						// Should be ignored, as we ignore all special groups except NEWLY_REGISTERED
						'group_id' => '1',
						'group_type' => GROUP_SPECIAL,
						'group_name' => 'ADMINISTRATORS',
					),
					array(
						// Should be picked up
						'group_id' => '2',
						'group_type' => GROUP_HIDDEN,
						'group_name' => 'Newly-Registered Spammers',
					),
					array(
						// Should be picked up
						'group_id' => '3',
						'group_type' => GROUP_HIDDEN,
						'group_name' => 'Newly-Registered Blatant Spammers',
					),
					false // End of rows
				));

			$this->template->expects($this->once())
				->method('assign_vars')
				->with($this->callback(function($vars) {
					if ($vars['U_ACTION'] != $this->u_action)
					{
						return false;
					}
					if ($vars['API_KEY'] != 'IM_AN_API_KEY_HONEST_GUV_123')
					{
						return false;
					}
					if ($vars['S_CHECK_REGISTRATIONS'] != 1)
					{
						return false;
					}
					if (!preg_match('/option value="2" selected="selected"/', $vars['S_GROUP_LIST']))
					{
						return false;
					}
					if (!preg_match('/option value="3" selected="selected"/', $vars['S_GROUP_LIST_BLATANT']))
					{
						return false;
					}
					if ($vars['SKIP_CHECK_AFTER_N_POSTS'] != 5)
					{
						return false;
					}

					return true;
				}));

			$this->group_helper->method('get_name')
				->will($this->returnArgument(0));

			$controller->display_settings();
		}
	}
}
