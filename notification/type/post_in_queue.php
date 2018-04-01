<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbb\akismet\notification\type;

class post_in_queue extends \phpbb\notification\type\post_in_queue
{
	public function get_type()
	{
		return 'phpbb.akismet.notification.type.post_in_queue';
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return '@phpbb_akismet/post_in_queue';
	}
}
