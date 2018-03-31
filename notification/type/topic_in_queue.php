<?php
/**
 * Akismet custom "topic in queue" notification
 *
 * @package phpBB Extension - Gothick Akismet
 * @copyright (c) 2015 Matt Gibson Creative Ltd.
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbb\akismet\notification\type;

class topic_in_queue extends \phpbb\notification\type\topic_in_queue
{
	public function get_type()
	{
		return 'phpbb.akismet.notification.type.topic_in_queue';
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return '@phpbb_akismet/topic_in_queue';
	}
}
