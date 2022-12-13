<?php
/**
* @package phpBB Extension - LMDI Alphasort
* @copyright (c) 2016-2022 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\alphasort\acp;

class alphasort_module {

	public $u_action;
	protected $action;
	protected $table;

	public function main($id, $mode)
	{
		global $db, $language, $template, $cache, $request, $config;

		$language->add_lang('alphasort', 'lmdi/alphasort');
		$this->tpl_name = 'acp_alphasort_body';
		$this->page_title = $language->lang('ACP_ALPHASORT_TITLE');

		$action = $request->variable('action', '');
		// var_dump($action);
		$update_action = false;

		switch($action)
		{
			case 'forums' :
				if(!check_form_key('acp_alphasort'))
				{
					trigger_error('FORM_INVALID');
				}
				$enabled_forums = implode(',', $request->variable('mark_alphasort_forum', array(0), true));
				$sql = 'UPDATE ' . FORUMS_TABLE . '
					SET lmdi_alphasort = DEFAULT';
				$db->sql_query($sql);
				if(!empty($enabled_forums))
				{
					$eforums = explode(',', $enabled_forums);
					$nbf = count($eforums);
					for($i=0; $i<$nbf; $i++)
					{
						$numf = $eforums[$i];
						$sql = 'UPDATE ' . FORUMS_TABLE . "
							SET lmdi_alphasort = 1
							WHERE forum_id = $numf";
						$db->sql_query($sql);
					}
					// var_dump($eforums);
					$cache->put('_alphasort_forums', $eforums, 86400 * 7);
				}
				else
				{
					$cache->destroy('_alphasort_forums');
				}

				trigger_error($language->lang('LOG_ALPHASORT_CONFIG_UPDATED') . adm_back_link($this->u_action));
			break;
		}

		$form_key = 'acp_alphasort';
		add_form_key($form_key);

		$forum_list = $this->get_forum_list();
		foreach($forum_list as $row)
		{
			$template->assign_block_vars('forums', array(
				'FORUM_NAME'			=> $row['forum_name'],
				'FORUM_ID'			=> $row['forum_id'],
				'CHECKED_ENABLE_FORUM'	=> $row['lmdi_alphasort']? 'checked="checked"' : '',
			));
		}
		$template->assign_vars(array(
			'F_ACTION'		=> $this->u_action . '&amp;action=forums',
			'S_CONFIG_PAGE'	=> true,
			'S_SET_FORUMS'		=> true,
			));
	}

	protected function get_forum_list()
	{
		global $db;
		$sql = 'SELECT forum_id, forum_name, lmdi_alphasort
			FROM ' . FORUMS_TABLE . '
			WHERE forum_type = ' . FORUM_POST . '
			ORDER BY left_id ASC';
		$result = $db->sql_query($sql);
		$forum_list = $db->sql_fetchrowset($result);
		$db->sql_freeresult($result);
		return $forum_list;
	}

}
