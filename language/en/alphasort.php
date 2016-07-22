<?php
/**
 *
 * @package	Extension Alphasort [English]
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
	'ACP_ALPHASORT_TITLE'			=> 'Alphabetical sort of topics',
	'PST_LEGEND3'					=> 'Forum settings',
	'PST_NOSHOW_LIST'				=> 'Enable sort',
	'LEGEND_ADD_TERM'				=> 'Term Management',
	'ACP_CHECKALL'					=> 'Select/deselect',
	'ACP_CHECKALL_EXPLAIN'			=> 'Here you can check/uncheck all forums together.',
	'ACP_ALL_FORUMS'				=> 'All forums',

	// Main form's words
	'ACP_ALPHASORT_CONFIG'			=> 'Extension configuration',
	'ALPHASORT' 					=> 'Sort topics',
	'ALL_TOPICS' 					=> 'No sorting',
	'SORT_SYMBOLS' 				=> 'Symbols',
	'LOG_ALPHASORT_CONFIG_UPDATED'	=> 'Configuration updated',
	)
);
