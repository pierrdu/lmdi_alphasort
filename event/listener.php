<?php
/**
*
* @package phpBB Extension - LMDI Alphasort extension
* @copyright (c) 2016-2022 LMDI - Pierre Duhem
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\alphasort\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $db;
	protected $config;
	protected $template;
	protected $cache;
	protected $user;
	protected $language;
	protected $request;
	protected $root_path;
	protected $phpEx;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\template\template $template,
		\phpbb\cache\service $cache,
		\phpbb\user $user,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		$phpEx
		)
	{
		$this->db = $db;
		$this->template = $template;
		$this->cache = $cache;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->phpEx = $phpEx;
	}


	static public function getSubscribedEvents()
	{
	return array(
		'core.user_setup'					=> 'load_language_on_setup',
		'core.viewforum_get_topic_data' 		=> 'topics_count',
		'core.viewforum_get_topic_ids_data'	=> 'query_production'
		);
	}


	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'lmdi/alphasort',
			'lang_set' => 'alphasort',
			);
		$event['lang_set_ext'] = $lang_set_ext;
	}


	public function topics_count($event)
	{
		$forum_id = $event['forum_id'];
		$forum_sort = (int) $this->user->data['lmdi_alphasort_forum'];
		$user_id = (int) $this->user->data['user_id'];

		// Changement de forum
		if ($forum_id != $forum_sort)
		{
			$crit = '*';
			$this->maj_crit($crit, $user_id);
			$this->maj_forum($forum_id, $user_id);
			$this->user->data['lmdi_alphasort_crit'] = $crit;
			$this->user->data['lmdi_alphasort_forum'] = $forum_id;
		}

		// Analyse de la ligne de commande
		$crit = $this->user->data['lmdi_alphasort_crit'];
		$letter = $this->request->variable('letter', '', false);
		if (!empty($letter))
		{
			$crit = substr($letter, 0, 1);
			$this->maj_crit($crit, $user_id);
		}

		// Mise à jour en mémoire
		$this->user->data['lmdi_alphasort_crit'] = $crit;
		$this->user->data['lmdi_alphasort_forum'] = $forum_id;

		// Codage de la recherche
		$wh = "";
		if ($crit != "*")
		{
			$wh .= " AND topic_title LIKE '$crit%'";
		}
		$sql = "select count(topic_id) as tot from ".TOPICS_TABLE." WHERE forum_id=$forum_id $wh";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$tc = (int) $row['tot'];
		$tc ++;
		$event['topics_count'] = $tc;
	}


	private function maj_crit($crit, $user_id)
	{
	$sql = "UPDATE " . USERS_TABLE ."
			SET lmdi_alphasort_crit = '$crit' 
			WHERE user_id = $user_id";
	$this->db->sql_query($sql);
	}


	private function maj_forum($forum, $user_id)
	{
	$sql = "UPDATE " . USERS_TABLE ."
			SET lmdi_alphasort_forum = $forum 
			WHERE user_id = $user_id";
	$this->db->sql_query($sql);
	}


	public function query_production($event)
	{
		static $enabled_forums = "";
		if (empty($enabled_forums))
		{
			$enabled_forums = $this->cache->get('_alphasort_forums');
		}
		if (!$enabled_forums)
		{
			$enabled_forums = $this->cache_production();
		}
		if (!empty($enabled_forums))
		{
			$forum_id = (int) $event['forum_data']['forum_id'];
			$forum_sort = (int) $this->user->data['lmdi_alphasort_forum'];
			if (in_array($forum_id, $enabled_forums))
			{
				// Page de suite, sinon on ne fait rien
				if ($forum_id == $forum_sort)
				{
					$crit = $this->user->data['lmdi_alphasort_crit'];
					$sql_ary = $event['sql_ary'];
					$wh = $sql_ary['WHERE'];
					if ($crit != "*")
					{
						$wh .= " AND t.topic_title LIKE '$crit%'";
						$sql_ary['WHERE'] = $wh;

						$order = 't.topic_title ASC,';
						$order .= $sql_ary['ORDER_BY'];
						$sql_ary['ORDER_BY'] = $order;

						$event['sql_ary'] = $sql_ary;
					}
				}

				foreach(range('A', 'Z') as $let)
				{
					$params = "f=$forum_id&amp;letter=$let";
					$this->template->assign_block_vars('alphabet',
						array(
						'LETTER' => ($crit == $let) ? "<font color=\"red\">$let</font>" : $let,
						'U_LETTER'=> append_sid("viewforum." . $this->phpEx, $params),
						));
				}
				$nosort = $this->language->lang('ALL_TOPICS');
				$this->template->assign_vars(array(
					'S_SORT_ALPHABET'=>1,
					'U_ALL_TOPICS'=> append_sid("viewforum." . $this->phpEx, "f=$forum_id&amp;letter=*"),
					'NOSORT' => ($crit == "*") ? "<font color=\"red\">$nosort</font>" : $nosort,
					));
			}
			else
			{
				$this->template->assign_vars(array(
					'S_SORT_ALPHABET'=>0,
					));
			}
		}
	}	// query_production


	private function cache_production()
	{
		$cache = array();
		$sql = 'SELECT  forum_id from ' . FORUMS_TABLE . '
			WHERE lmdi_alphasort = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$cache[] = $row['forum_id'];
		}
		$this->db->sql_freeresult($result);
		$this->cache->put('_alphasort_forums', $cache, 86400 *  7);
		return($cache);
	}	// cache_production


}
