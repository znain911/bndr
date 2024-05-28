<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center_model extends CI_Model {
	
	public function get_all_items($params=array())
	{
		$query = "SELECT * 
				   FROM starter_centers
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_centers.orgcenter_org_id
				   LEFT JOIN starter_divisions ON
				   starter_divisions.division_id=starter_centers.orgcenter_division_id
				   LEFT JOIN starter_districts ON
				   starter_districts.district_id=starter_centers.orgcenter_district_id
				   LEFT JOIN starter_upazilas ON
				   starter_upazilas.upazila_id=starter_centers.orgcenter_upazila_id ";
		$query .= "ORDER BY starter_centers.orgcenter_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_centers', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('orgcenter_id', $id);
		$this->db->update('starter_centers', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_centers WHERE starter_centers.orgcenter_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_todaytotal_items($date)
	{
		$query = $this->db->query("SELECT orgcenter_id FROM starter_centers WHERE orgcenter_create_date LIKE '%$date%'");
		return $query->num_rows()+1;
	}
	
	public function get_org_code($org_id)
	{
		$query = $this->db->query("SELECT org_code FROM starter_organizations WHERE starter_organizations.org_id='$org_id' LIMIT 1");
		$result = $query->row_array();
		return $result['org_code'];
	}
	
}