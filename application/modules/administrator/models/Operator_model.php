<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_operators 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_operators.operator_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_operators.operator_org_centerid
								   ORDER BY starter_operators.operator_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_operators', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('operator_id', $id);
		$this->db->update('starter_operators', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_operators WHERE starter_operators.operator_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_operators WHERE starter_operators.operator_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_phone($phone)
	{
		$query = $this->db->query("SELECT * FROM starter_operators WHERE starter_operators.operator_phone='$phone' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_total_operatortoday($date)
	{
		$query = $this->db->query("SELECT operator_id FROM starter_operators WHERE operator_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
}