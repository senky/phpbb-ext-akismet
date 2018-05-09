<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\factory;

class main_controller_test extends \phpbb_test_case
{
	/** @var \phpbb\config\config|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;

	public function setUp()
	{
		parent::setUp();

		$this->config = new \phpbb\config\config(array());
	}

	/**
	 * Test factory without Akismet API key
	 */
	public function test_factory_without_key()
	{
		$this->config['version'] = '1.0.0';

		$factory = new \senky\akismet\utility\akismet_factory($this->config);
		$this->assertNotFalse($factory->create_akismet());
	}

	/**
	 * Test factory with Akismet API key
	 */
	public function test_factory_with_key()
	{
		$this->config['senky_akismet_api_key'] = 'abcdef';
		$this->config['version'] = '1.2.3';

		$factory = new \senky\akismet\utility\akismet_factory($this->config);
		$akismet_client = $factory->create_akismet();
		$this->assertInstanceOf(\Gothick\AkismetClient\Client::class, $akismet_client);
	}
}

