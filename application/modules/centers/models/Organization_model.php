<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT org_id, org_name 
								   FROM starter_organizations
								   ORDER BY starter_organizations.org_id ASC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_organizations', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('org_id', $id);
		$this->db->update('starter_organizations', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_organizations WHERE starter_organizations.org_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_admininfo($id)
	{
		$query = $this->db->query("SELECT * FROM starter_owner WHERE starter_owner.owner_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_all_divisions()
	{
		$query = $this->db->query("SELECT * FROM starter_divisions ORDER BY starter_divisions.division_id ASC");
		return $query->result_array();
	}
	
	public function get_todaytotal_items($date)
	{
		$query = $this->db->query("SELECT org_id FROM starter_organizations WHERE org_create_date LIKE '%$date%'");
		return $query->num_rows()+1;
	}
	public function get_all_districts($division_id)
	{
		$query = $this->db->query("SELECT * FROM starter_districts WHERE starter_districts.district_division_id='$division_id' ORDER BY starter_districts.district_id ASC");
		return $query->result_array();
	}
	
	public function get_all_upazilas($district_id)
	{
		$query = $this->db->query("SELECT * FROM starter_upazilas WHERE starter_upazilas.upazila_district_id='$district_id' ORDER BY starter_upazilas.upazila_id ASC");
		return $query->result_array();
	}
	
}