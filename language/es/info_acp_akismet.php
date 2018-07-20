<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ACP_AKISMET_TITLE'			=> 'Akismet',
	'ACP_AKISMET_SETTINGS'		=> 'Ajustes',
	'ACP_AKISMET_SETTING_SAVED'	=> '¡Ajustes guardados correctamente!',

	// Log operations
	'AKISMET_LOG_SETTING_CHANGED'				=> '<strong>Ajustes de Akismet actualizados.</strong>',
	'AKISMET_LOG_CALL_FAILED'					=> '<strong>Error en la llamada al API de Akismet</strong><br />» API devuelta: “%1$s”',
	'AKISMET_LOG_POST_DISAPPROVED'				=> '<strong>Mensaje rechazado “%1$s” escrito por “%2$s” por la siguiente razón</strong><br />» Mensaje detectado como spam por Akismet',
	'AKISMET_LOG_TOPIC_DISAPPROVED'				=> '<strong>Tema rechazado “%1$s” escrito por “%2$s” por la siguiente razón</strong><br />» Tema detectado como spam por Akismet',
	'AKISMET_LOG_SPAMMER_REGISTRATION'			=> '<strong>Usuario %s: Registro de spammer detectado por Akismet</strong>',
	'AKISMET_LOG_BLATANT_SPAMMER_REGISTRATION'	=> '<strong>Usuario %s: Registro de spammer evidente detectado por Akismet</strong>',
	'AKISMET_LOG_SPAMMER_GROUP_REMOVED'			=> '<strong>Akismet: El group %s fue eliminado</strong><br />Akismet ya no agregará nuevos registros de spam a un grupo'
));
