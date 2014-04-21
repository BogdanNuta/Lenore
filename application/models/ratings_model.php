<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ratings_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	function rate($item, $rating) 
	{
	
		$sql = "SELECT `ip` FROM `bc_rated` WHERE `ip` = '" . mysql_escape_string($_SERVER['REMOTE_ADDR']) . "' AND `id` = '" . mysql_escape_string($item) . "' LIMIT 1;";
		//echo $sql . '<br />';
		$query = $this->db->query($sql);
		//echo $query->num_rows() . '<br />';
		if($query->num_rows() == 0) 
		{
			
			$rating = floatval($rating);
			if ($rating > 5) { $rating = 5; }
			if ($rating < 1) { $rating = 1; }
			
			$q = "INSERT IGNORE INTO `bc_ratings` (`id`, `rating`, `votes`, `total`) VALUES ('".mysql_escape_string($item)."', 0, 0, 0);";
			//echo $q . '<br />';
			$o = $this->db->query($q);
			
			$q = "SELECT `votes`, `total` FROM `bc_ratings` WHERE `id` = '".mysql_escape_string($item)."' LIMIT 1;";
			//echo $q . '<br />';
			$o = $this->db->query($q);
			
			$s = $o->row();				
			$t = ($s->total + $rating);
			$n = ($s->votes + 1);
			$r = ($t / $n);
	
			$q = "UPDATE `bc_ratings` SET `rating` = '".$r."', `votes` = '".$n."', `total` = '".$t."' WHERE `id` = '".mysql_escape_string($item)."';";
			//echo $q . '<br />';
			$o = $this->db->query($q);
			
			$q = "INSERT IGNORE INTO `bc_rated` (`id`, `ip`) VALUES ('".mysql_escape_string($item)."', '".mysql_escape_string($_SERVER['REMOTE_ADDR'])."');";
			//echo $q . '<br />';
			$o = $this->db->query($q);

		}
	
	}

	function get($items) 
	{
	
		global $vorpal;
		$in = "";
		if (is_array($items)) {
			foreach ($items as $k => $v) {
				$in .= "'".mysql_escape_string($v)."',";
			}
			$in = substr($in, 0, -1);
			$q = "SELECT `rating`, `id`, `votes` FROM `bc_ratings` WHERE `id` IN (".$in.");";
		} else {
			$q = "SELECT `rating`, `id`, `votes` FROM `bc_ratings` WHERE `id` = '".mysql_escape_string($items)."';";
		}
		$o = $this->db->query($q);
		if ($o->num_rows() > 0) {
			return $o->result();
		} else {
			return null;
		}
	
	}

	function israted($item) 
	{
	
		$q = "SELECT `ip` FROM `bc_rated` WHERE `ip` = '" . mysql_escape_string($_SERVER['REMOTE_ADDR']) . "' AND `id` = '" . mysql_escape_string($item) . "' LIMIT 1;";
		$o = $this->db->query($q);
		if ($o->num_rows() > 0) {
			return true;
		}
		return false;

	}

}

/* End of file ratings_model.php */
/* Location: ./application/models/ratings_model.php */
