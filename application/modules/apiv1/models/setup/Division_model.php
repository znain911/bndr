<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_divisions ORDER BY starter_divisions.division_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_divisions', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('division_id', $id);
		$this->db->update('starter_divisions', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_divisions WHERE starter_divisions.division_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}