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
	'ACP_AKISMET_WELCOME'				=> 'مرحباً بك في خدمة الحماية أكيسمت',
	'ACP_AKISMET_INTRO'					=> 'هذه الإضافة سوف تستخدم خدمة <a href="http://akismet.com">الأكيسمت التلقائي</a> لحماية منتداك من المُشاركات المُزعجة, عبر وضع المُشاركات الجديدة المشبوهة مُباشرة إلى قائمة الإنتظار للمشرفين تلقائياً.',
	'ACP_AKISMET_ADMINS_AND_MODS_OKAY'	=> 'جميع مُشاركات المدراء والمشرفين بالمنتدى لن تخضع إلى عملية الفحص بواسطة أكيسمت.',
	'ACP_AKISMET_SIGN_UP'				=> 'لإستخدام هذه الخدمة, يجب عليك أولاً <a href="http://akismet.com">التسجيل للحصول على مفتاح API</a>, ثم ادخال رقم المفتاح في الخيار أدناه.',
	'ACP_AKISMET_UNENCRYPTED_WARNING'	=> 'نرجوا الملاحظة بأنه سيتم تمرير المواضيع الجديدة والمشاركات بدون تشفير — بمعنى آخر, سيكون عبر اتصال قياسي http — إلى خوادم “أكيسمت” لعملية الفحص. ',

	'ACP_AKISMET_SETTING_CHANGED'	=> 'تحديث إعدادات “أكيسمت”.', // For log
	'ACP_AKISMET_SETTING_SAVED'		=> 'تم حفظ الإعدادات بنجاح !',
	'ACP_AKISMET_API_KEY_INVALID'	=> 'مفتاح الأكيسمت API غير صالح.',

	'ACP_AKISMET_AKISMET_API_KEY'				=> 'مفتاح الأكيسمت API',
	'ACP_AKISMET_API_KEY'						=> 'مفتاح API',
	'ACP_AKISMET_REGISTRATION_SETITNGS'			=> 'اعدادات التسجيل',
	'ACP_AKISMET_CHECK_REGISTRATIONS'			=> 'التحقق من تسجيلات الأعضاء الجُدد بواسطة الأكيسمت',
	'ACP_AKISMET_CHECK_REGISTRATIONS_EXPLAIN'	=> 'عند اختيارك “نعم”, الأكيسمت سيحاول أكتشاف المشتبة بهم من المُزعجين بمجرد تسجيلهم بالمنتدى, قبل أن يرسلوا أي مشاركة أو مواضيع جديدة.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_SPAMMERS_TO_GROUP'	=> 'عدم إضافة المُسجلين المُزعجين إلى مجموعات إضافية',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP'			=> 'إضافة المُسجلين المُزعجين إلى المجموعة',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'إذا اكتشفت خدمة “أكيسمت” عملية تسجيل “مُزعجة” من مستخدم جديد, سيتم إضافة هذا المستخدم الجديد إلى المجموعة التي حددتها هنا. تستطيع استخدام هذا الخيار لتقييد صلاحية النشر لهم, ألخ... حتى تنتهي من التحقق منهم. <strong>ملاحظة: لأسباب أمنية, تستطيع فقط إضافة المُزعجين المسجلين الجُدد إلى مجموعات معرفة مُسبقاً أو مجموعة آخر الأعضاء المُسجلين</strong>.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_BLATANT_SPAMMERS_TO_GROUP'	=> 'عدم إضافة المُسجلين المُزعجين إلى مجموعات إضافية',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP'			=> 'إضافة المُسجلين المُزعجين كثيراً إلى المجموعة',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'خدمة “أكيسمت” للكشف عن المُزعجين “كثيراً” سوف تعمل عند وجود المشاركات الأسوأ, الأكثر انتشاراً, والأكثر وضوحاً. تستطيع إضافة المُزعجين إلى مجموعة محددة, أيضاً, ربما لمجموعة لا تحتوي على صلاحية النشر إطلاقاً. <strong>ملاحظة: لأسباب أمنية, تستطيع فقط إضافة المُزعجين المسجلين الجُدد إلى مجموعات معرفة مُسبقاً أو مجموعة آخر الأعضاء المُسجلين</strong>.',

	'ACP_AKISMET_POST_SETITNGS'						=> 'اعدادات المشاركة',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS'			=> 'عدم تطبيق الفحص للعضو الذي لديه هذا العدد من المشاركات الموافق عليها مُسبقاً',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS_EXPLAIN'	=> 'القيمة صفر 0 تعني فحص جميع المشاركات. قد يكون ذلك مفيداً, لأنه في حالة تعرض حساب شخص ما للخطر, سيتم إرسال المشاركات المزعجة إلى قائمة الانتظار وبالتالي يمكن إزالتها بسهولة. لكن هذا يضيف أيضا المزيد من الحمل على الخادم.',

	'ACP_AKISMET_ADMIN_FORM_SETITNGS'		=> 'اعدادات صفحة الاتصال بنا',
	'ACP_AKISMET_CHECK_ADMIN_FORM'			=> 'فحص الرسائل عبر صفحة الاتصال بنا',
	'ACP_AKISMET_CHECK_ADMIN_FORM_EXPLAIN'	=> 'عند اختيارك “نعم”, الأكيسمت سيعمل على ايقاف الرسائل المزعجة التي يتم ارسالها عبر صفحة الاتصال بنا. تحذير: هذا قد يمنع الأعضاء العاديين من الاتصال بك!',
));
