<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends BC_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function get ()
	{
		$id = null;
		$page = null;
		$size = null;
		$order = null;
		$this->data['set_count'] = true;
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['page'])) $page = $_GET['page'];
		if(isset($_GET['size'])) $size = $_GET['size'];
		if(isset($_GET['order'])) $order = $_GET['order'];

		if($size == null) $size = $this->config->item('com_page_size');
		if($page == null) $page = 0;
		if($id != null) {
			$this->data['comments'] = $this->comments->get($id, $page, $size, $order);
			$output = $this->load->view('comments.php', $this->data);
		}
		echo $output;
	}

	public function post ()
	{
		$id = null;
		$author = null;
		$comment = null;
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['author'])) $author = $_GET['author'];
		if(isset($_GET['comment'])) $comment = $_GET['comment'];
		$data = "";
		if($id != null && $comment != null) {
			$data = $this->comments->post($id, $author, $comment);
		}
		$output = $data;
		echo $output;
	}

	public function flag ()
	{
		$id = null;
		if(isset($_GET['id'])) $id = $_GET['id'];
		if($id != null) {
			$data = $this->comments->flag($id);
		}
		$output = "FLAG COMMENT";
		echo $output;
	}

}

/* End of file comments.php */
/* Location: ./application/controllers/comments.php */