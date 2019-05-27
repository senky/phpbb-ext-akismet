<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Jakub Senko <jakubsenko@gmail.com>
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
	'ACP_AKISMET_WELCOME'				=> 'Welcome to Akismet',
	'ACP_AKISMET_INTRO'					=> 'This extension will use <a href="http://akismet.com">Automattic‘s Akismet</a> service to protect your board from spam, placing suspicious new posts directly into the moderation queue automatically.',
	'ACP_AKISMET_ADMINS_AND_MODS_OKAY'	=> 'All posts from board administrators and moderators will bypass the check completely.',
	'ACP_AKISMET_SIGN_UP'				=> 'To use this extension, you must first <a href="http://akismet.com">sign up for an API key</a>, then enter the key below.',
	'ACP_AKISMET_UNENCRYPTED_WARNING'	=> 'Please note that new topics and posts will be passed unencrypted—that is, over a standard http connection—to the Akismet servers for checking.',

	'ACP_AKISMET_SETTING_CHANGED'	=> 'Akismet settings updated.', // For log
	'ACP_AKISMET_SETTING_SAVED'		=> 'Settings have been saved successfully!',
	'ACP_AKISMET_API_KEY_INVALID'	=> 'Akismet API key is invalid.',

	'ACP_AKISMET_AKISMET_API_KEY'				=> 'Akismet API Key',
	'ACP_AKISMET_API_KEY'						=> 'API Key',
	'ACP_AKISMET_REGISTRATION_SETITNGS'			=> 'Registration Settings',
	'ACP_AKISMET_CHECK_REGISTRATIONS'			=> 'Check new user registrations with Akismet',
	'ACP_AKISMET_CHECK_REGISTRATIONS_EXPLAIN'	=> 'If you choose “yes”, Akismet will try to detect likely spammers as soon as they register, before they‘ve posted any replies or new topics.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_SPAMMERS_TO_GROUP'	=> 'Don‘t add registering spammers to additional groups',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP'			=> 'Add registering spammers to a group',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'If Akismet detects a “spammy” registration from a new user, add the user to the selected group. You can use this to restrict their posting privileges, etc. until you‘ve investigated them. <strong>NB: For security reasons, you can only add new spammy registrations to user-defined groups or the Newly Registered group</strong>.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_BLATANT_SPAMMERS_TO_GROUP'	=> 'Don‘t add registering spammers to additional groups',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP'			=> 'Add registering blatant spammers to a group',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Akismet‘s “blatant” spammer detection will be triggered by the worst, most pervasive, most obvious spam. You can add these spammers to a particular group, too, perhaps one with no posting privileges at all. <strong>NB: For security reasons, you can only add new spammy registrations to user-defined groups or the Newly Registered group</strong>.',

	'ACP_AKISMET_POST_SETITNGS'						=> 'Post Settings',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS'			=> 'Skip the check if a user has more than this number of approved posts already',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS_EXPLAIN'	=> 'Set to 0 to check every post regardless. This might be useful, because in case someone‘s account is compromised, spam posts will be sent to moderation queue and can be easily removed. But it also adds more load to the server.',

	'ACP_AKISMET_ADMIN_FORM_SETITNGS'		=> 'Contact Us Form Settings',
	'ACP_AKISMET_CHECK_ADMIN_FORM'			=> 'Check Contact Us for submissions',
	'ACP_AKISMET_CHECK_ADMIN_FORM_EXPLAIN'	=> 'If you choose “yes”, Akismet will stop spam submissions of Contact Us form. WARNING: This might potentially prevent regular users from contacting you!',
));
