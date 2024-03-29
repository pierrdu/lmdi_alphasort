<?php
/**
 *
 * @package	Extension Alphasort [Français]
 * @author	Pierre Duhem <pierre@duhem.com>
 * (c) 2016-2022 - LMDI Pierre duhem
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
	'ALPHASORT_LEGEND3'				=> 'Sélection des forums offrant la fonction de tri',
	'ALPHASORT_NOSHOW_LIST'			=> 'Autoriser le tri',

	'ACP_ALPHASORT_CONFIG'			=> 'Configuration de l’extension',
	'ALPHASORT' 					=> 'Tri alphabétique',
	'ALL_TOPICS' 					=> 'Pas de tri',
	'LOG_ALPHASORT_CONFIG_UPDATED'	=> 'La configuration a été mise à jour.',

	)
);
