<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moderation extends BC_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$comments = $this->comments->get_all();
		$this->data['comments'] = $comments;
		$this->data['site_url'] = site_url();
        $this->load->view('moderation', $this->data);

	}

	public function delete($id)
	{
		if(isset($id)) $this->comments->delete($id);
	}

	public function clear($id)
	{
		if(isset($id)) $this->comments->clear_flagged($id);
	}

}

/* End of file moderation.php */
/* Location: ./application/controllers/moderation.php */
