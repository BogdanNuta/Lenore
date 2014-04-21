<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BC_Pagination extends CI_Pagination {

	private $CI;

    public function __construct()
    {
		$this->CI =& get_instance();
        $this->CI->config->load('config');
    }

	public function set($page = 0, $sort, $filter, $searchstr, $total_videos, $base_url, $params = NULL)
	{

		// adjust CI's default Pagination behavior
		$cnt = (int)$total_videos / 24;
		$config['total_rows'] = $cnt;
		$config['cur_page'] = $page;
		$config['base_url'] = $base_url . '/' . $searchstr == "" || $searchstr == null ? '?sort=' . $sort . (strlen($filter) > 0 ? '&filter=' . $filter : '') . '&page=#' : '?term=' . $searchstr . '&sort=' . $sort . '&page=#';
		$config['per_page'] = 1;
		$config['num_links'] = 4;
		$config['first_link'] = FALSE;

		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li class="first">';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$config['last_link'] = '&nbsp;';
		$config['next_link'] = '&nbsp;';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&nbsp;';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		// allow for normal passing of config to base Pagination class
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				$config[$key] = (string)$val;
			}
		}
		$this->initialize($config);
	}
}


/* End of file BC_Pagination.php */
/* Location: ./application/libraries/BC_Pagination.php */
