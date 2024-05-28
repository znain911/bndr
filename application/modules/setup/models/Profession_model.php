<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profession_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_professions ORDER BY starter_professions.profession_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_professions', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('profession_id', $id);
		$this->db->update('starter_professions', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_professions WHERE starter_professions.profession_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}