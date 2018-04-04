<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\tests\factory;

class main_controller_test extends \phpbb_test_case
{
	/** @var \phpbb\log\log_interface|\PHPUnit_Framework_MockObject_MockObject */
	protected $log;

	/** @var \phpbb\config\config|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;

	/** @var \phpbb\language\language|\PHPUnit_Framework_MockObject_MockObject */
	protected $language;

	/** @var \phpbb\user|\PHPUnit_Framework_MockObject_MockObject */
	protected $user;

	public function setUp()
	{
		global $phpbb_root_path, $phpEx;

		parent::setUp();

		$this->log = $this->getMockBuilder(\phpbb\log\dummy::class)->getMock();
		$this->config = new \phpbb\config\config([]);
		$lang_loader = new \phpbb\language\language_file_loader($phpbb_root_path, $phpEx);
		$this->language = new \phpbb\language\language($lang_loader);
		$this->user = new \phpbb\user($this->language, '\phpbb\datetime');
	}

	/**
	 * Test factory without Akismet API key
	 */
	public function test_factory_without_key()
	{
		$this->config['version'] = '1.0.0';

		$factory = new \phpbb\akismet\utility\akismet_factory($this->config, $this->log, $this->user);
		$this->assertNotFalse($factory->createAkismet());
	}

	/**
	 * Test factory with Akismet API key
	 */
	public function test_factory_with_key()
	{
		$this->config['phpbb_akismet_api_key'] = 'abcdef';
		$this->config['version'] = '1.2.3';

		// If we've set the key up properly, we shouldn't get an error message.
		$this->log->expects($this->never())
			->method('add');
		
		$factory = new \phpbb\akismet\utility\akismet_factory($this->config, $this->log, $this->user);
		$akismet_client = $factory->createAkismet();
		$this->assertInstanceOf(\Gothick\AkismetClient\Client::class, $akismet_client);
	}
}

