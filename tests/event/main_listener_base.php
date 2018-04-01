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

class main_listener_base extends \phpbb_database_test_case
{
	/** @var \phpbb\user|\PHPUnit_Framework_MockObject_MockObject */
	protected $user;

	/** @var \phpbb\request\request|\PHPUnit_Framework_MockObject_MockObject */
	protected $request;

	/** @var \phpbb\config\config|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;

	/** @var \phpbb\log\log|\PHPUnit_Framework_MockObject_MockObject */
	protected $log;

	/** @var \phpbb\auth\auth|\PHPUnit_Framework_MockObject_MockObject */
	protected $auth;

	/** @var \phpbb\akismet\tests\mock\akismet_mock */
	protected $akismet;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $root_path;

	/**
	 * {@inheritDoc}
	 */
	protected static function setup_extensions()
	{
		return array('phpbb/akismet');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getDataSet()
	{
		return $this->createXMLDataSet(__DIR__ . '/fixtures/users.xml');
	}

	public function setUp()
	{
		global $phpbb_root_path, $phpEx;
		global $db, $auth, $phpbb_dispatcher, $phpbb_container, $phpbb_log;

		parent::setUp();

		$this->user = $this->getMockBuilder(\phpbb\user::class)
			->disableOriginalConstructor()
			->getMock();
		$this->request = $this->getMock(\phpbb\request\request::class);
		$this->config = new \phpbb\config\config(array());
		$this->log = $this->getMockBuilder(\phpbb\log\dummy::class)->getMock();
		$this->auth = $this->getMock(\phpbb\auth\auth::class);
		$this->phpbb_container = new \phpbb_mock_container_builder();
		$this->php_ext = $phpEx;
		$this->root_path = $phpbb_root_path;

		// Global variables
		$db = $this->new_dbal();
		$auth = $this->auth;
		$phpbb_dispatcher = new \phpbb_mock_event_dispatcher();
		$phpbb_container = $this->phpbb_container;
		$phpbb_container->set('group_helper', $this->getMockBuilder(\phpbb\group\helper::class)->disableOriginalConstructor()->getMock());
		$phpbb_log = $this->log;
	}

	protected function get_listener()
	{
		return new \phpbb\akismet\event\main_listener(
			$this->user,
			$this->request,
			$this->config,
			$this->log,
			$this->auth,
			$this->phpbb_container,
			$this->php_ext,
			$this->root_path
		);
	}
}
