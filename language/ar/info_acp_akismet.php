<?php
/**
 *
 * Akismet. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 Jakub Senko <jakubsenko@gmail.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Translated By : Bassel Taha Alhitary <http://alhitary.net>
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
	'ACP_AKISMET_TITLE'			=> 'خدمة الحماية أكيسمت',
	'ACP_AKISMET_SETTINGS'		=> 'الإعدادات',
	'ACP_AKISMET_SETTING_SAVED'	=> 'تم حفظ الإعدادات بنجاح !',

	// Log operations
	'AKISMET_LOG_SETTING_CHANGED'				=> '<strong>تحديث إعدادات “أكيسمت”.</strong>',
	'AKISMET_LOG_CALL_FAILED'					=> '<strong>فشلت عملية الإتصال بمفتاح “أكيسمت” API</strong><br />» الرد: “%1$s”',
	'AKISMET_LOG_POST_DISAPPROVED'				=> '<strong>مشاركة مرفوضة “%1$s” بواسطة “%2$s” للسبب التالي</strong><br />» خدمة “أكيسمت” حددت المُشاركة بأنها مُزعجة',
	'AKISMET_LOG_TOPIC_DISAPPROVED'				=> '<strong>موضوع مرفوض “%1$s” بواسطة “%2$s” للسبب التالي</strong><br />» خدمة “أكيسمت” حددت الموضوع بأنه مُزعج',
	'AKISMET_LOG_SPAMMER_REGISTRATION'			=> '<strong>العضو %s: خدمة “أكيسمت” حددت التسجيل بأنه مُزعج</strong>',
	'AKISMET_LOG_BLATANT_SPAMMER_REGISTRATION'	=> '<strong>العضو %s: خدمة “أكيسمت” حددت التسجيل بأنه مُزعج كثيراً</strong>',
	'AKISMET_LOG_SPAMMER_GROUP_REMOVED'			=> '<strong>“أكيسمت”: تم حذف المجموعة %s</strong><br />خدمة “أكيسمت” لن تضيف التسجيلات المُزعجة إلى المجموعة',
));
