<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_model extends CI_Model {
	
	public function get_config()
	{
		$query = $this->db->query("SELECT * FROM starter_configuration WHERE starter_configuration.config_key='REG_FEE' LIMIT 1");
		return $query->row_array();
	}

	public function update($data)
	{
		$this->db->where('config_key', 'REG_FEE');
		$this->db->update('starter_configuration', $data);
	}
	
}