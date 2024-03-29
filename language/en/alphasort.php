<?php
/**
 *
 * @package	Extension Alphasort [English]
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
	'ACP_ALPHASORT_TITLE'			=> 'Alphabetical sort of topics',
	'ALPHASORT_LEGEND3'				=> 'Selection of forums with topic sorting',
	'ALPHASORT_NOSHOW_LIST'			=> 'Enable sort',

	'ACP_ALPHASORT_CONFIG'			=> 'Extension configuration',
	'ALPHASORT' 					=> 'Sort topics',
	'ALL_TOPICS' 					=> 'No sorting',
	'LOG_ALPHASORT_CONFIG_UPDATED'	=> 'The configuration was successfully updated.',
	)
);
