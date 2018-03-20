<?php
/**
*
* @package phpBB Extension - LMDI Alphasort
* @copyright (c) 2016 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace lmdi\alphasort\acp;

class alphasort_info
{
	public function module()
	{
		return array(
			'filename'	=> '\lmdi\alphasort\acp\alphasort_module',
			'title'		=> 'ACP_ALPHASORT_TITLE',
			'version'		=> '1.0.0',
			'modes'		=> array (
				'settings' => array('title' => 'ACP_ALPHASORT_CONFIG',
					'auth' => 'ext_lmdi/alphasort && acl_a_board',
					'cat' => array('ACP_ALPHASORT_TITLE')),
			),
		);
	}
}
