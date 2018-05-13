<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\mock;

/**
 *
 * Dead simple Akismet mock.
 *
 * @package Gothick Akismet
 */
class akismet_mock extends \Gothick\AkismetClient\Client
{
	protected $blatant;
	protected $keyVerified;

	public function __construct($blatant = false, $keyVerified = false)
	{
		$this->blatant = $blatant;
		$this->keyVerified = $keyVerified;
	}

	public function commentCheck($params = array(), $server_params = array())
	{
		if ($params['comment_author'] == 'viagra-test-123')
		{
			return new akismet_client_check_result_mock(true, $this->blatant);
		}
		return new akismet_client_check_result_mock(false, false);
	}

	public function verifyKey($api_key = null, $params = array())
	{
		return new akismet_client_verify_key_result_mock($this->keyVerified);
	}
}
