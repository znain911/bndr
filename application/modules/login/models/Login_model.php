<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	public function get_roles()
	{
		$query = $this->db->query("SELECT * FROM starter_admin_role ORDER BY starter_admin_role.role_id ASC");
		return $query->result_array();
	}
	
	public function check_user_credentials($email, $password)
	{
		$query = $this->db->query("SELECT * FROM starter_owner WHERE starter_owner.owner_email='$email' AND starter_owner.owner_password='$password'");
		return $query->row();
	}
	
	public function check_user_phone_credentials($phone, $password)
	{
		$query = $this->db->query("SELECT * FROM starter_owner WHERE starter_owner.owner_phone='$phone' AND starter_owner.owner_password='$password'");
		return $query->row();
	}
	
	public function update_admin($owner_id, $data)
	{
		$this->db->where('owner_id', $owner_id);
		$this->db->update('starter_owner', $data);
	}
	
	
	
}