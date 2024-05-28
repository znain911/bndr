<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization_model extends CI_Model {
	
	public function the_last_org_id()
	{
		$query = $this->db->query("SELECT org_id FROM starter_organizations ORDER BY org_id DESC LIMIT 1");
		$result = $query->row_array();
		return $result['org_id'] + 1;
	}
	
	public function count_all_items()
	{
		$query = $this->db->query("SELECT org_id FROM starter_organizations");
		return $query->num_rows();
	}
	
	public function get_all_items($params=array())
	{
		$query = "SELECT * 
				   FROM starter_organizations
				   LEFT JOIN starter_divisions ON
				   starter_divisions.division_id=starter_organizations.org_division_id
				   LEFT JOIN starter_districts ON
				   starter_districts.district_id=starter_organizations.org_district_id
				   LEFT JOIN starter_upazilas ON
				   starter_upazilas.upazila_id=starter_organizations.org_upazila_id ";
		$query .= "ORDER BY org_name ASC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
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