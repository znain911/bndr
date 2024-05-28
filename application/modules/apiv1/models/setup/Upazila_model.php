<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upazila_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_upazilas 
								   
								   LEFT JOIN starter_districts ON
								   starter_districts.district_id=starter_upazilas.upazila_district_id
								   
								   LEFT JOIN starter_divisions ON
								   starter_divisions.division_id=starter_districts.district_division_id
								   
								   ORDER BY starter_upazilas.upazila_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_upazilas', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('upazila_id', $id);
		$this->db->update('starter_upazilas', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_upazilas 
								   
								   LEFT JOIN starter_districts ON
								   starter_districts.district_id=starter_upazilas.upazila_district_id
								   
								   LEFT JOIN starter_divisions ON
								   starter_divisions.division_id=starter_districts.district_division_id
								   
								   WHERE starter_upazilas.upazila_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_all_divisions()
	{
		$query = $this->db->query("SELECT division_id, division_name FROM starter_divisions ORDER BY starter_divisions.division_id ASC");
		return $query->result_array();
	}
	
	public function get_all_districts($division_id)
	{
		$query = $this->db->query("SELECT * FROM starter_districts WHERE starter_districts.district_division_id='$division_id' ORDER BY starter_districts.district_id ASC");
		return $query->result_array();
	}
	
}