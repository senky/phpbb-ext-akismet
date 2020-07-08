<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
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
	// ACP modules
	'ACP_AKISMET_TITLE'			=> 'Akismet Rämpspost',
	'ACP_AKISMET_SETTINGS'		=> 'Seaded',
	'ACP_AKISMET_SETTING_SAVED'	=> 'Seaded edukalt salvestatud!',

	// Log operations
	'AKISMET_LOG_SETTING_CHANGED'				=> '<strong>Akismeti seaded uuendatud.</strong>',
	'AKISMET_LOG_CALL_FAILED'					=> '<strong>Pöördumine Akismeti API-le ebaõnnestus</strong><br />» API tagasi: “%1$s”',
	'AKISMET_LOG_POST_DISAPPROVED'				=> '<strong>Tagasilükatud postitus “%1$s”, mille on kirjutanud “%2$s”, järgmisel põhjusel</strong><br />» Akismet tuvastas rämpspostina',
	'AKISMET_LOG_TOPIC_DISAPPROVED'				=> '<strong>Tagasilükatud teema “%1$s”, mille on kirjutanud “%2$s” järgmisel põhjusel</strong><br />» Akismet tuvastas teema rämpspostina',
	'AKISMET_LOG_SPAMMER_REGISTRATION'			=> '<strong>Kasutaja %s: Akismet tuvastas rämpsposti sisestamise</strong>',
	'AKISMET_LOG_BLATANT_SPAMMER_REGISTRATION'	=> '<strong>Kasutaja %s: Akismet tuvastas rämpsposti sisestamise</strong>',
	'AKISMET_LOG_SPAMMER_GROUP_REMOVED'			=> '<strong>Akismet: Grupp %s kustutati</strong><br />Akismet ei lisa gruppi enam uusi rämpspostitajaid'
));
