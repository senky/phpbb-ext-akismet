<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * Estonian translation by phpBBeesti.ee [Exabot]
 *
 */

if (!defined('IN_PHPBB'))
{
	exit();
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'SPAM_MESSAGE'	=> 'Teie kiri näeb välja nagu rämpspost. Palun korrigeerige oma sõnumit!',
));
