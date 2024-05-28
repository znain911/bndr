<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_patients 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_patients.patient_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
								   ORDER BY starter_patients.patient_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_patients', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('patient_id', $id);
		$this->db->update('starter_patients', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_patients
								   LEFT JOIN starter_patient_familyinfo ON
								   starter_patient_familyinfo.familyinfo_patient_id=starter_patients.patient_id
								   LEFT JOIN starter_patient_emgcontacts ON
								   starter_patient_emgcontacts.emgcontact_patient_id=starter_patients.patient_id
								   LEFT JOIN starter_patient_profinfo ON
								   starter_patient_profinfo.profinfo_patient_id=starter_patients.patient_id
								   WHERE starter_patients.patient_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_todaytotal_items($date)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE patient_create_date LIKE '%$date%'");
		return $query->num_rows()+1;
	}
	
	public function save_family_info($data)
	{
		$this->db->insert('starter_patient_familyinfo', $data);
	}
	
	public function update_family_info($id, $data)
	{
		$this->db->where('familyinfo_patient_id', $id);
		$this->db->update('starter_patient_familyinfo', $data);
	}
	
	public function save_emergency_info($data)
	{
		$this->db->insert('starter_patient_emgcontacts', $data);
	}
	
	public function update_emergency_info($id, $data)
	{
		$this->db->where('emgcontact_patient_id', $id);
		$this->db->update('starter_patient_emgcontacts', $data);
	}
	
	public function save_professional_info($data)
	{
		$this->db->insert('starter_patient_profinfo', $data);
	}
	
	public function update_professional_info($id, $data)
	{
		$this->db->where('profinfo_patient_id', $id);
		$this->db->update('starter_patient_profinfo', $data);
	}
	
	public function get_centers($org_id)
	{
		$query = $this->db->query("SELECT * FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY starter_centers.orgcenter_id ASC");
		return $query->result_array();
	}
	
	public function get_org_code($org_id)
	{
		$query = $this->db->query("SELECT org_code FROM starter_organizations WHERE starter_organizations.org_id='$org_id' LIMIT 1");
		$result = $query->row_array();
		return $result['org_code'];
	}
	
}