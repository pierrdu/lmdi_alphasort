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
	// Menu text and titles
	'AUTOLINK_MOD_MENU_NAME'			=> 'Extension Alphasort',
	'ACP_ALPHASORT_TITLE'			=> 'Tri alphabétique des sujets',
	'PST_LEGEND3'					=> 'Paramétrage des forums',
	'PST_NOSHOW_LIST'				=> 'Autoriser le tri',
	'ACP_CHECKALL'					=> 'Sélection/désélection',
	'ACP_CHECKALL_EXPLAIN'			=> 'Vous pouvez ici sélectionner/déselectionner tous les forums en une seule fois.',
	'ACP_ALL_FORUMS'				=> 'Tous les forums',

	// Main form's words
	'ACP_ALPHASORT_CONFIG'			=> 'Configuration de l\'extension',
	'ALPHASORT' 					=> 'Tri alphabétique',
	'ALL_TOPICS' 					=> 'Pas de tri',
	'SORT_SYMBOLS' 				=> 'Symboles',

	)
);
