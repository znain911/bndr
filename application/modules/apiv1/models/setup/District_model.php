<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_districts 
								   LEFT JOIN starter_divisions ON
								   starter_divisions.division_id=starter_districts.district_division_id
								   ORDER BY starter_districts.district_id DESC");
		return $query->result_array();
	}
	
	public function get_divisions()
	{
		$query = $this->db->query("SELECT * FROM starter_divisions ORDER BY starter_divisions.division_id ASC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_districts', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('district_id', $id);
		$this->db->update('starter_districts', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_districts WHERE starter_districts.district_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}