<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Centers_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_local_app_centers 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_local_app_centers.api_app_org_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_local_app_centers.api_app_center_id
								   
								   ORDER BY api_app_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_local_app_centers', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('api_app_id', $id);
		$this->db->update('starter_local_app_centers', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_local_app_centers WHERE api_app_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_all_orgs()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_organizations
								   ORDER BY org_name ASC");
		return $query->result_array();
	}
	
	public function get_all_centers($org_id)
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY starter_centers.orgcenter_id ASC");
		return $query->result_array();
	}
	
}