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
	'ACP_AKISMET_WELCOME'				=> 'Bienvenido a Akismet',
	'ACP_AKISMET_INTRO'					=> 'Esta extensión usará el servicio <a href="http://akismet.com">Automático de Akismet</a> para proteger tu foro de correo no deseado, colocando nuevos mensajes sospechosos directamente en la cola de moderación de forma automática.',
	'ACP_AKISMET_ADMINS_AND_MODS_OKAY'	=> 'Todas los mensajes de los Administradores y Moderadores del foro omitirán por completo el control.',
	'ACP_AKISMET_SIGN_UP'				=> 'Para usar esta extensión, primero debes <a href="http://akismet.com">registrarse para obtener una clave API</a>, luego deberás ingresar dicha clave a continuación.',
	'ACP_AKISMET_UNENCRYPTED_WARNING'	=> 'Ten en cuenta que los nuevos temas y mensajes se pasarán sin cifrar, es decir, a través de una conexión HTTP estándar, a los servidores Akismet para su verificación.',

	'ACP_AKISMET_SETTING_CHANGED'	=> 'Ajustes de Akismet actualizados.', // For log
	'ACP_AKISMET_SETTING_SAVED'		=> '¡Ajustes guardados correctamente!',
	'ACP_AKISMET_API_KEY_INVALID'	=> 'La clave API de Akismet no es válida.',

	'ACP_AKISMET_AKISMET_API_KEY'				=> 'Clave API de Akismet',
	'ACP_AKISMET_API_KEY'						=> 'Clave API',
	'ACP_AKISMET_GENERAL_SETITNGS'				=> 'Ajustes Generales',
	'ACP_AKISMET_CHECK_REGISTRATIONS'			=> 'Verificar nuevos registros de usuarios con Akismet',
	'ACP_AKISMET_CHECK_REGISTRATIONS_EXPLAIN'	=> 'Si eliges “si”, Akismet intentará detectar probables spammers tan pronto como se registren, antes de que hayan publicado respuestas o nuevos temas.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_SPAMMERS_TO_GROUP'	=> 'No añadir el registro de spammers a grupos adicionales',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP'			=> 'Añadir el registro de spammers a un grupo',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Si Akismet detecta un registro “spammer” de un nuevo usuario, agrégalo al grupo seleccionado. Puedes usar esto para restringir sus privilegios de publicación, etc. hasta que los haya investigado. <strong>Nota: Por razones de seguridad, solo puede agregar nuevos registros de spam a grupos definidos por el usuario o al grupo Nuevos usuarios registrados</strong>.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_BLATANT_SPAMMERS_TO_GROUP'	=> 'No añadir el registro de spammers a grupos adicionales',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP'			=> 'Añadir el registro de spammers evidentes a un grupo',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'La detección de Akismet “evidente” de spammers se desencadenará por el peor, más penetrante y obvio spam. Puedes agregar estos spammers a un grupo en particular, también, sin privilegios de publicación. <strong>Nota: Por razones de seguridad, solo puede agregar nuevos registros de spam a grupos definidos por el usuario o al grupo Nuevos usuarios registrados</strong>.',

	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS'			=> 'Omitir la comprobación si un usuario ya tiene más de este número de mensajes aprobadas',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS_EXPLAIN'	=> 'Establécelo en 0 para verificar cada mensaje independientemente. Esto podría ser útil, porque en caso de que la cuenta de alguien se vea comprometida, los mensajes no deseados se enviarán a la cola de moderación y se pueden eliminar fácilmente. Pero también añade más carga al servidor.',
));
