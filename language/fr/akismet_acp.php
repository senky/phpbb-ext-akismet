<?php
/**
 *
 * Akismet Anti-Spam Extension. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2019 Jakub Senko <jakubsenko@gmail.com>
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
	'ACP_AKISMET_WELCOME'				=> 'Service « Akismet » pour phpBB',
	'ACP_AKISMET_INTRO'					=> 'Cette extension utilise le service « <a href="http://akismet.com">Automattic‘s Akismet</a> » pour protéger le forum du contenu indésirable, plaçant automatiquement les nouveaux messages suspicieux dans la file d’attente de modération.',
	'ACP_AKISMET_ADMINS_AND_MODS_OKAY'	=> 'Tous les messages des administrateurs et des modérateurs du forum contourneront complètement le contrôle.',
	'ACP_AKISMET_SIGN_UP'				=> 'Pour utiliser cette extension, il est nécessaire au préalable de <a href="http://akismet.com">s’enregistrer sur le site Web d’Akismet</a> pour obtenir une clé de son API, puis de saisir la clé ci-dessous.',
	'ACP_AKISMET_UNENCRYPTED_WARNING'	=> 'Merci de noter que les nouveaux sujets et messages seront transmis aux serveurs du service « Akismet » pour vérification, sans être chiffrés, c’est-à-dire via une connexion HTTP standard.',

	'ACP_AKISMET_SETTING_CHANGED'	=> 'Paramètres du service « Akismet » mis à jour.', // For log
	'ACP_AKISMET_SETTING_SAVED'		=> 'Les paramètres ont été sauvegardés avec succès !',
	'ACP_AKISMET_API_KEY_INVALID'	=> 'La clé de l’API du service « Akismet » est incorrecte.',

	'ACP_AKISMET_AKISMET_API_KEY'				=> 'Clé de l’API du service « Akismet »',
	'ACP_AKISMET_API_KEY'						=> 'Clé de l’API',
	'ACP_AKISMET_REGISTRATION_SETITNGS'			=> 'Paramètres généraux',
	'ACP_AKISMET_CHECK_REGISTRATIONS'			=> 'Vérifier les nouveaux enregistrements d’utilisateurs au moyen du service « Akismet »',
	'ACP_AKISMET_CHECK_REGISTRATIONS_EXPLAIN'	=> 'Permet d’activer la détection des utilisateurs indésirables au moyen du service « Akismet » lors de leur enregistrement sur le forum avant même qu’ils aient publiés un message sur ce dernier.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_SPAMMERS_TO_GROUP'	=> 'Ne pas ajouter les utilisateurs indésirables à des groupes additionnels',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP'			=> 'Ajouter les utilisateurs indésirables à un groupe',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Permet d’ajouter les utilisateurs indésirables qui s’enregistrent sur le forum, dans le groupe sélectionné. Option utile pour restreindre les permissions durant la période d’investigation des utilisateurs suspectés d’être indésirables. <strong>Information : Pour des raisons de sécurité, il est possible d’ajouter les utilisateurs indésirables nouvellement enregistrés uniquement dans les groupes supplémentaires créés par l’administrateur ou dans le groupe des « Nouveaux utilisateurs enregistrés »</strong>.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_BLATANT_SPAMMERS_TO_GROUP'	=> 'Ne pas ajouter les utilisateurs indésirables avérés à des groupes additionnels',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP'			=> 'Ajouter les utilisateurs indésirables avérés à un groupe',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Permet d’ajouter les utilisateurs indésirables « avérés » (flagrants). Il est possible d’ajouter ces utilisateurs dans un groupe particulier, permettant de ne pas les autoriser à publier des messages. <strong>Information : Pour des raisons de sécurité, il est possible d’ajouter les utilisateurs indésirables nouvellement enregistrés uniquement dans les groupes supplémentaires créés par l’administrateur ou dans le groupe des « Nouveaux utilisateurs enregistrés »</strong>.',

	'ACP_AKISMET_POST_SETITNGS'						=> 'Post Settings',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS'			=> 'Ignorer la vérification pour laquelle un utilisateur a déjà plus de messages approuvés que le nombre saisi ci-contre',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS_EXPLAIN'	=> 'Permet de vérifier chaque message si défini sur « 0 ». Option utile dans les situations où un compte utilisateur a été piraté, en contrepartie la charge sur le serveur Web hébergeant le forum sera plus importante.',

	'ACP_AKISMET_ADMIN_FORM_SETITNGS'		=> 'Contact Us Form Settings',
	'ACP_AKISMET_CHECK_ADMIN_FORM'			=> 'Check Contact Us for submissions',
	'ACP_AKISMET_CHECK_ADMIN_FORM_EXPLAIN'	=> 'If you choose “yes”, Akismet will stop spam submissions of Contact Us form. WARNING: This might potentially prevent regular users from contacting you!',
));
