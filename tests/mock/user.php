<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\tests\mock;

/**
* User Mock
* @package Gothick Akismet
*/
class user extends \phpbb\user
{
	protected $username;

	public function __construct($username)
	{
		$this->data['username'] = $username;
		$this->data['username_clean'] = $username;
	}

	public function lang()
	{
		return implode(' ', func_get_args());
	}

	public function get_profile_fields($user_id)
	{
		$this->profile_fields = array('pf_phpbb_website' => 'http://mock.user.website/');
	}
}
