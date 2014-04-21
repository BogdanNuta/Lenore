<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ratings extends BC_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function rate()
	{
		$item = null;
		$rating = null;
		if(isset($_GET['item'])) $item = $_GET['item'];
		if(isset($_GET['rating'])) $rating = $_GET['rating'];

		if($item != null && $rating != null ) {
			$data = $this->ratings->rate($item, $rating);
		}
		$output = $data;
		echo $output;
	}

	public function get()
	{
		$output = 0;
		$items = null;
		if(isset($_GET['items'])) $items = $_GET['items'];
		if($items != null) {
			$data = $this->ratings->get($items);
			if($data != null) $output = $data[0]->rating;
		}
		echo $output;
	}

}

/* End of file ratings.php */
/* Location: ./application/controllers/ratings.php */