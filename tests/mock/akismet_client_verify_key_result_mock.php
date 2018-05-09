<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\tests\mock;

class akismet_client_verify_key_result_mock extends \Gothick\AkismetClient\Result\VerifyKeyResult
{
	protected $result;

	public function __construct($result = false)
	{
		$this->result = $result;
	}

	public function isValid()
	{
		return $this->result;
	}
}
