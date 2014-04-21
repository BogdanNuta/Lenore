<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	// retrieve comments object for a specified video
	function get ($id, $page, $size, $order = 'DESC')
	{
		if (!$id) {
            redirect($this->data['base_url'] . '?msg=' . lang('error-404'), 'location', 302); die();
        }
		$this->page = ($page < 1) ? 1 : $page;
		$this->size = ($size < 1) ? 1 : $size;
		$order = (strtolower($order) == 'desc') ? 'DESC' : 'ASC';
		$sql = 'SELECT SQL_CALC_FOUND_ROWS *
			, UNIX_TIMESTAMP(date) AS date
			, bc_flagged.id AS has_flagged
			, bc_comments.id AS id 
			FROM bc_comments 
			LEFT JOIN bc_flagged ON bc_flagged.id = bc_comments.id AND bc_flagged.ip = "'.mysql_escape_string($_SERVER['REMOTE_ADDR']).'" 
			WHERE video = '.mysql_escape_string($id) . ' ORDER BY date '.$order.' LIMIT '.$this->size.' OFFSET '.(($this->page - 1) * $this->size).';';
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
		  //return $query->result();
		} else {
		  log_message('error','comments->get() - ' . $sql . ': Failed to retrieve records');
		}
	}

	// insert comments for a video	
	function post ($id, $author, $comment) {

		$comment = htmlspecialchars($comment);
		$comment = nl2br($comment);
		$comment = strip_tags($comment, '<br><a><i><em><strong><b><u>');
		$author = strip_tags($author);
		$author = htmlspecialchars($author);
		$sql = 'INSERT INTO bc_comments (video, author, comment, flagged) VALUES (' . mysql_escape_string($id) . ', ' . $this->db->escape($author) . ', ' . $this->db->escape($comment) . ', 0);';
		$query = $this->db->query($sql, null, null, true);
		//return $this->db->insert_id();
		
	}

	// comment a comment to be deleted if threshold setting is met	
	function flag ($id) {
	
		$sql = "SELECT `flagged` FROM `bc_comments` WHERE `id` = ".mysql_escape_string($id)." LIMIT 1;";
		$query = $this->db->query($sql);
	
		if ($query) {
		
			$row = $query->row(); 
			if (($row->flagged + 1) >= $this->config->item('com_flag_remove')) {
		
				$this->db->query("DELETE FROM bc_comments WHERE id = " . mysql_escape_string($id) . " LIMIT 1;", null, null, true);
				$this->db->query("DELETE FROM bc_flagged WHERE id = " . mysql_escape_string($id) . ";", null, null, true);
		
			} else {
			
				$sql = "SELECT `ip` FROM `bc_flagged` WHERE `ip` = '" . mysql_escape_string($_SERVER['REMOTE_ADDR']) . "' AND `id` = " . mysql_escape_string($id) . ";";
				$query = $this->db->query($sql);
				if($query->num_rows() == 0) {
					$this->db->query("INSERT INTO bc_flagged (`id`, `ip`) VALUES ('" . $id . "', '" . mysql_escape_string($_SERVER['REMOTE_ADDR']) . "');", null, null, true);
				}
					
				$this->db->query("UPDATE bc_comments SET flagged = flagged + 1 WHERE id = '" . mysql_escape_string($id) . "' LIMIT 1;", null, null, true);
					
			}
		
		}
		
	}

	function get_all ()
	{
		$sql = 'select * from bc_comments order by id desc;';
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
		 // return $query->result();
		} else {
		  log_message('error','comments->get() - ' . $sql . ': Failed to retrieve records');
		}
	}

	function clear_flagged ($id)
	{
		$query = $this->db->query('update bc_comments set flagged=0 where id=' . mysql_escape_string($id));
	}

	function delete ($id)
	{
		$query = $this->db->query('delete from bc_comments where id=' . mysql_escape_string($id));
	}

}

/* End of file comments_model.php */
/* Location: ./application/models/comments_model.php */
