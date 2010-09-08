<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Online
 *
 * This model contains the nessesary database functions for maintaining a list of currently online users
 *
 * @package		Online_Users
 * @author		Joseph Pugh
 */

class Online extends Model
{
	private $table_online = 'online';
	
	function __construct()
	{
		parent::__construct();
		
		$ci =& get_instance();
	}
	
	/**
	 * Check if the hit is unique per user id.
	 *
	 * @param	int
	 * @return	bool
	 */
	function is_online($user_id) {
		$this->db->select('1', FALSE);
		$this->db->where('user_id =', $user_id);
		
		$query = $this->db->get($this->table_online);
		
		return $query->num_rows() == 0;
	}
	
	/**
	 * Insert a new online user.
	 *
	 * @param	array
	 * @return	void
	 */
	function set_online($data) {
		$this->db->insert($this->table_online, $data);
	}
	
	/**
	 * Update the user's last hit time.
	 *
	 * @param	int
	 * @return	void
	 */
	function update_online($user_id) {
		$this->db->set('time', time());
		$this->db->where('user_id', $user_id);
		$this->db->update($this->table_online);
	}
	
	/**
	 * Purge all expired online users.
	 *
	 * @param	int
	 * @return	void
	 */
	function purge_expired($expired) {
		$this->db->where('time <=', $expired);
		$this->db->delete($this->table_online);
	}
	
	/**
	 * Get an array of the currently online users.
	 *
	 * @return	array
	 */
	function get_online() {
		$this->db->select('user_id');
		
		$query = $this->db->get($this->table_online);
		
		return $query->result();
	}
}

/* End of file online.php */
/* Location: ./application/models/online.php */