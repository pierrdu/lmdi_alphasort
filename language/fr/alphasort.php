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
	'AUTOLINK_ADD_A_NEW_WORD'		=> 'Ajouter un nouveau terme',
	'RECURS_FEATURE'				=> 'Empêcher le remplacement récursif',
	'RECURS_FEATURE_EXPLAIN'			=> 'Si les URL saisies contiennent l\'un des termes servant de mot-clef, il existe un risque de remplacement récursif. Cette option empêche le remplacement récursif, mais a pour effet que le terme est remplacé par le terme exact saisi dans la table ci-dessous.',
	'TERM_ADDITION'				=> 'Addition d\'un nouveau terme',
	'TERM_ADDITION_EXPLAIN'			=> 'Appel d\'un formulaire de création d\'un nouveau terme.',
	'PST_LEGEND3'					=> 'Paramétrage des forums',
	'PST_NOSHOW_LIST'				=> 'Autoriser le tri dans',
	'ACP_CHECKALL'					=> 'Sélection/désélection',
	'ACP_CHECKALL_EXPLAIN'			=> 'Vous pouvez ici sélectionner/déselectionner tous les forums en une seule fois.',
	'ACP_ALL_FORUMS'				=> 'Tous les forums',

	// Main form's words
	'ACP_ALPHASORT_CONFIG'			=> 'Configuration de l\'extension',

	'ALPHASORT' 					=> 'Tri alphabétique',
	'ALL_TOPICS' 					=> 'Tous les sujets',
	'SORT_SYMBOLS' 				=> 'Symboles',

	// Error messages
	'AUTOLINK_NOT_ADDED'			=> 'Le terme n\'a pas été ajouté dans la table.',
	'AUTOLINK_NOT_REMOVED'			=> 'Le terme n\'a pas été supprimé dans la table.',
	'AUTOLINK_NOT_UPDATED'			=> 'Le terme n\'a pas été mis à jour dans la table.',
	'AUTOLINK_INVALID_ID'			=> 'Le numéro du terme que vous voulez éditer ou supprimer n\'existe pas.',
	'AUTOLINK_DIFFERENT_SIZE_ARRAY'	=> 'Le nombre des valeurs de fréquence et des URL doit être identique.',
	'AUTOLINK_EMPTY_WORD_FIELD'		=> 'La zone de saisie du terme est vide.',
	'AUTOLINK_EMPTY_URL_FIELD'		=> 'La zone de saisie de l\'URL est vide.',
	'AUTOLINK_WORD_ALREADY_EXIST'		=> 'Ce terme existe déjà.',
	)
);
