<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Education_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_educations ORDER BY starter_educations.education_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_educations', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('education_id', $id);
		$this->db->update('starter_educations', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_educations WHERE starter_educations.education_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}