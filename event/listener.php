<?php
/**
*
* @package phpBB Extension - LMDI Alphasort extension
* @copyright (c) 2016 LMDI - Pierre Duhem
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
	protected $request;
	protected $root_path;
	protected $phpEx;
	
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbb\config\config $config,
		\phpbb\template\template $template,
		\phpbb\cache\service $cache,
		\phpbb\user $user,
		\phpbb\request\request $request,
		$root_path,
		$phpEx
		)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->cache = $cache;
		$this->user = $user;
		$this->request = $request;
		$this->root_path = $root_path;
		$this->phpEx = $phpEx;
	}

	static public function getSubscribedEvents ()
	{
	return array(
		'core.user_setup'					=> 'load_language_on_setup',
		'core.viewforum_get_topic_data' 		=> 'count_topics',
		'core.viewforum_get_topic_ids_data' 	=> 'query_production'
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

	public function count_topics($event)
	{
		$letter = $this->request->variable('letter', '', false);
		$all = $this->request->variable('all', 0);
		$forum_id = $event['forum_data']['forum_id'];
		if(!isset($forum_id)) 
			$forum_id = $this->request->variable('f', 0);

		$cl = $this->config['lmdi_alphasort_l'];
		$cf = $this->config['lmdi_alphasort_f'];

		if($forum_id == $cf and $cl and !$letter and !$all)
			$letter = $cl;

		// echo "cl $cl - cf $cf - letter $letter - fid $forum_id";
		$wh = "";
		if ($letter=="*")
		{
			foreach(range('A', 'Z') as $let)
			{
				$wh .= " AND NOT topic_title LIKE '$let%'";
			}
		}
		else
		{
			$wh .= " AND topic_title LIKE '$letter%'";
		}
		$sql = "select count(topic_id) as tot from ".TOPICS_TABLE." WHERE forum_id=$forum_id $wh";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$tc = (int) $row['tot'];
		$tc ++;

		$event['topics_count'] = $tc;
	}


	public function query_production($event)
	{
		static $enabled_forums = "";
		if (empty ($enabled_forums))
		{
			$enabled_forums = $this->cache->get('_alphasort_forums');
		}
		if (!empty ($enabled_forums))
		{
			$letter = $this->request->variable('letter', '', false);
			$all = $this->request->variable('all', 0);
			$forum_id = $event['forum_data']['forum_id'];
			// var_dump ($forum_id);
			if(!isset($forum_id)) 
				$forum_id = $this->request->variable('f', 0);
			if (in_array ($forum_id, $enabled_forums))
			{
				$cl = $this->config['lmdi_alphasort_l'];
				$cf = $this->config['lmdi_alphasort_f'];

				if(($forum_id != $cf) or ($all))
					$this->config->set ('lmdi_alphasort_l', false);

				$this->config->set ('lmdi_alphasort_f', $forum_id);

				if($letter) 
					$this->config->set ('lmdi_alphasort_l', $letter);
				

				if($forum_id==$cf and $cl and !$letter and !$all)
					$letter = $cl;

				$sa = $event['sql_ary'];
				$wh = $sa['WHERE'];
				if($letter=="*")
				{
					foreach(range('A', 'Z') as $let)
					{
						$wh .= " AND NOT t.topic_title LIKE '$let%'";
					}
				}
				else
				{
					$wh .= " AND t.topic_title LIKE '$letter%'";
				}
				$sa['WHERE'] = $wh;
				$event['sql_ary'] = $sa;

				foreach(range('A', 'Z') as $let)
				{
					$params = "f=$forum_id&amp;letter=$let";
					$this->template->assign_block_vars('alphabet',
						array(
						'LETTER' => $let,
						'U_LETTER'=> append_sid ("viewforum." . $this->phpEx, $params),
						));
				}
				$this->template->assign_vars(array(
					'S_SORT_ALPHABET'=>1,
					'U_LETTER_SYM'=> append_sid("viewforum." . $this->phpEx, "f=$forum_id&amp;letter=*"),
					'U_ALL_TOPICS'=> append_sid("viewforum." . $this->phpEx, "f=$forum_id&amp;all=1"),
					));
			}
			else
			{
				$this->template->assign_vars(array(
					'S_SORT_ALPHABET'=>0,
					));
			}
		}
	}

}
