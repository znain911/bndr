<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistant_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_doctor_assistants 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctor_assistants.assistant_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctor_assistants.assistant_org_centerid
								   ORDER BY starter_doctor_assistants.assistant_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_doctor_assistants', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('assistant_id', $id);
		$this->db->update('starter_doctor_assistants', $data);
	}
	
	public function update_sync($sync_id, $data)
	{
		$this->db->where('assistant_sync_id', $sync_id);
		$this->db->update('starter_doctor_assistants', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_doctor_assistants WHERE starter_doctor_assistants.assistant_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_doctor_assistants WHERE starter_doctor_assistants.assistant_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_phone($phone)
	{
		$query = $this->db->query("SELECT * FROM starter_doctor_assistants WHERE starter_doctor_assistants.assistant_phone='$phone' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_total_assistanttoday($date)
	{
		$query = $this->db->query("SELECT assistant_id FROM starter_doctor_assistants WHERE assistant_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
}