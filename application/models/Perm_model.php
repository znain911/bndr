<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perm_model extends CI_Model{
	
	public function check_permissionby_admin($admin_id, $permission_id)
	{
		$query = $this->db->query("SELECT permission_id FROM starter_admin_permission 
		                           WHERE starter_admin_permission.permission_adminid='$admin_id' 
		                           AND starter_admin_permission.permission_permission_id='$permission_id' 
								   ");
		return $query->row_array();
	}
	
}
