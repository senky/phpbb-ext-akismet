<?php
/**
 *
 * Akismet Anti-Spam Extension. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	// ACP modules
	'ACP_AKISMET_TITLE'			=> 'Service « Akismet »',
	'ACP_AKISMET_SETTINGS'		=> 'Paramètres',
	'ACP_AKISMET_SETTING_SAVED'	=> 'Les paramètres ont été sauvegardés avec succès !',

	// Log operations
	'AKISMET_LOG_SETTING_CHANGED'				=> '<strong>Paramètres du service « Akismet » mis à jour.</strong>',
	'AKISMET_LOG_CALL_FAILED'					=> '<strong>Échec lors de l’appel à l’API du service « Akismet »</strong><br />» L’API a retourné : « %1$s »',
	'AKISMET_LOG_POST_DISAPPROVED'				=> '<strong>Message désapprouvé « %1$s » publié par « %2$s » pour la raison suivante</strong><br />» Message détecté comme indésirable par le service « Akismet »',
	'AKISMET_LOG_TOPIC_DISAPPROVED'				=> '<strong>Sujet désapprouvé « %1$s » publié par « %2$s » pour la raison suivante</strong><br />» Sujet détecté comme indésirable par le service « Akismet »',
	'AKISMET_LOG_SPAMMER_REGISTRATION'			=> '<strong>Utilisateur %s : détecté comme indésirable par le service « Akismet »</strong>',
	'AKISMET_LOG_BLATANT_SPAMMER_REGISTRATION'	=> '<strong>Utilisateur %s : détecté comme indésirable avéré par le service « Akismet »</strong>',
	'AKISMET_LOG_SPAMMER_GROUP_REMOVED'			=> '<strong>Service « Akismet » : Groupe %s supprimé</strong><br />Le service « Akismet » n’ajoutera plus les nouveaux utilisateurs enregistrés détectés comme indésirables dans ce groupe'
));
