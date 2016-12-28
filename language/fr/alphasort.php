<?php
/**
 *
 * @package	Extension Alphasort [Français]
 * @author	Pierre Duhem <pierre@duhem.com>
 * (c) 2016 - LMDI Pierre duhem
 *
 **/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'AUTOLINK_MOD_MENU_NAME'			=> 'Extension Alphasort',
	'ACP_ALPHASORT_TITLE'			=> 'Tri alphabétique des sujets',
	'PST_LEGEND3'					=> 'Sélection des forums offrant la fonction de tri',
	'PST_NOSHOW_LIST'				=> 'Autoriser le tri',

	'ACP_ALPHASORT_CONFIG'			=> 'Configuration de l’extension',
	'ALPHASORT' 					=> 'Tri alphabétique',
	'ALL_TOPICS' 					=> 'Pas de tri',
	'LOG_ALPHASORT_CONFIG_UPDATED'	=> 'Configuration mise à jour',

	)
);
