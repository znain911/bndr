<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_patients 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_patients.patient_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
								   ORDER BY starter_patients.patient_id DESC LIMIT 20");
		return $query->result_array();
	}
	
	public function total_pending_patients()
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE starter_patients.patient_status=0");
		return $query->num_rows();
	}
	
	public function total_pending_doctors()
	{
		$query = $this->db->query("SELECT doctor_id FROM starter_doctors WHERE starter_doctors.doctor_status=0");
		return $query->num_rows();
	}
	
	public function total_pending_operators()
	{
		$query = $this->db->query("SELECT operator_id FROM starter_operators WHERE starter_operators.operator_status=0");
		return $query->num_rows();
	}
	
	public function total_pending_assistants()
	{
		$query = $this->db->query("SELECT assistant_id FROM starter_doctor_assistants WHERE starter_doctor_assistants.assistant_status=0");
		return $query->num_rows();
	}
	public function doc_active($doc_id)
	{
		$query = $this->db->query("UPDATE starter_doctors SET doctor_login_info = NULL  WHERE starter_doctors.doctor_id = $doc_id");
		
	}
	
	
}