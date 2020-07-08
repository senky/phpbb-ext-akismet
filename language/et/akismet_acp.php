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
	'ACP_AKISMET_WELCOME'				=> 'Tere tulemast Akismeti',
	'ACP_AKISMET_INTRO'					=> 'See laiendus kasutab <a href="https://akismet.com">Automaatset Akismeti</a> teenust, et kaitsta teie foorumit rämpsposti eest, paigutades kahtlased uued postitused otse modereerimisjärjekorda.',
	'ACP_AKISMET_ADMINS_AND_MODS_OKAY'	=> 'Kõik foorumi administraatorite ja moderaatorite postitused väljuvad antud kontrollist täielikult, et ehk neid ei arvestata.',
	'ACP_AKISMET_SIGN_UP'				=> 'Selle laienduse kasutamiseks peate kõigepealt <a href="https://akismet.com">registreeruma API-võtme saamiseks</a> ja sisestama võtme allpool.',
	'ACP_AKISMET_UNENCRYPTED_WARNING'	=> 'Pange tähele, et uued teemad ja postitused edastatakse kontrollimiseks Akismeti serveritesse krüpteerimata - st. tavalise http(s) ühenduse kaudu.',

	'ACP_AKISMET_SETTING_CHANGED'	=> 'Akismeti seaded uuendatud.', // For log
	'ACP_AKISMET_SETTING_SAVED'		=> 'Seaded on edukalt salvestatud!',
	'ACP_AKISMET_API_KEY_INVALID'	=> 'Akismet API-võti on kehtetu.',

	'ACP_AKISMET_AKISMET_API_KEY'				=> 'Akismet API-võti',
	'ACP_AKISMET_API_KEY'						=> 'API-võti',
	'ACP_AKISMET_REGISTRATION_SETITNGS'			=> 'Registreerimise seaded',
	'ACP_AKISMET_CHECK_REGISTRATIONS'			=> 'Uute kasutajate registreerimisi saate kontrollida Akismetis',
	'ACP_AKISMET_CHECK_REGISTRATIONS_EXPLAIN'	=> 'Kui valite Jah, proovib Akismet tuvastada tõenäolised rämpspostitajad koheselt kui nad registreeruvad, enne kui nad on jõudnud postitada uusi vastuseid või teemasid.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_SPAMMERS_TO_GROUP'	=> 'Ärge lisage rämpspostitajaid täiendavatesse gruppidesse',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP'			=> 'Lisa rämpspostitajad gruppi',
	'ACP_AKISMET_ADD_DETECTED_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Kui Akismet tuvastab uuelt kasutajalt rämpsposti registreerimise, lisage kasutaja valitud gruppi. Selle abil saate piirata nende postitusõigusi jne. kuni olete neid lähemalt uurinud. <strong>NB: Turvalisuse huvides saate uusi rämpspostitajaid lisada ainult kasutaja määratletud gruppidesse või äsja registreeritud kasutajagruppi</strong>.',

	'ACP_AKISMET_DONT_ADD_REGISTERING_BLATANT_SPAMMERS_TO_GROUP'	=> 'Ärge lisage rämpspostitajaid täiendavatesse gruppidesse',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP'			=> 'Lisage rämpspostitaja gruppi',
	'ACP_AKISMET_ADD_DETECTED_BLATANT_SPAMMERS_TO_GROUP_EXPLAIN'	=> 'Akismeti räige rämpsposti tuvastamine käivitatakse kõige halvema, põhjalikuma ja ilmselge rämpspostiga. Saate lisada need rämpspostitajad ka konkreetsesse gruppi, võib-olla sellisesse, millel puudub üldse postitamisõigus. <strong>NB: Turvalisuse huvides saate uusi rämpspostitajaid lisada ainult kasutaja määratletud gruppidesse või äsja registreeritud kasutajagruppi</strong>.',

	'ACP_AKISMET_POST_SETITNGS'						=> 'Postituse seaded',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS'			=> 'Jäta kontroll vahele, kui kasutajal on rohkem kui see arv kinnitatud postitusi',
	'ACP_AKISMET_SKIP_CHECK_AFTER_N_POSTS_EXPLAIN'	=> 'Määrake 0, et kontrollida igat postitust. See võib olla kasulik, sest kui kellegi konto on rikutud, saadetakse rämpspostitus modereerimisjärjekorda ja seda saab hõlpsalt eemaldada. Kuid see lisab serverile ka suuremat koormust.',

	'ACP_AKISMET_ADMIN_FORM_SETITNGS'		=> 'Võtke meiega ühendust kontaktivormilt',
	'ACP_AKISMET_CHECK_ADMIN_FORM'			=> 'Kontrolli rämpspostitamist kontaktivormil',
	'ACP_AKISMET_CHECK_ADMIN_FORM_EXPLAIN'	=> 'Kui see on valitud Jah, siis Akismet kontrollib rämpspostitusi kontaktivormil. HOIATUS: See võib takistada tavakasutajatel teiega ühendust võtmast!',
));
