<?php
/**
*
* @package phpBB Extension - LMDI Alphasort
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\alphasort\migrations;

// use \phpbb\db\migration\container_aware_migration;


class migration_1 extends \phpbb\db\migration\migration
{

	public function effectively_installed()
	{
		return isset($this->config['lmdi_alphasort']);
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'forums' => array('lmdi_alphasort' => array('BOOL', 0),),
				$this->table_prefix . 'users' => array(
					'lmdi_alphasort_forum' => array('UINT:2', 0),
					'lmdi_alphasort_crit' => array('VCHAR:1', '*'),
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			// ACP modules
			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ALPHASORT_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_ALPHASORT_TITLE',
				array(
					'module_basename'	=> '\lmdi\alphasort\acp\alphasort_module',
					'auth'			=> 'ext_lmdi/alphasort && acl_a_board',
					'modes'			=> array('settings'),
				),
			)),

			// Configuration entries
			array('config.add', array('lmdi_alphasort', 1)),
		);
	}

	public function revert_data()
	{

		return array(
			array('config.remove', array('lmdi_alphasort')),

			array('module.remove', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_ALPHASORT_TITLE'
			)),

		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'forums' => array(
					'lmdi_alphasort',
				),
				$this->table_prefix . 'users' => array(
					'lmdi_alphasort_forum',
					'lmdi_alphasort_crit',
				),
			),
		);
	}

}
