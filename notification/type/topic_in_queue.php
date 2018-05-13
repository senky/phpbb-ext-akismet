<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace senky\akismet\notification\type;

class topic_in_queue extends \phpbb\notification\type\topic_in_queue
{
	/**
	 * {@inheritDoc}
	 */
	public function get_type()
	{
		return 'senky.akismet.notification.type.topic_in_queue';
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return '@senky_akismet/topic_in_queue';
	}
}
