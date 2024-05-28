<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {
	
	/*******Operator login********/
	
	public function check_operator_email_credentials($email, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_operators
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_operators.operator_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_operators.operator_org_centerid
								   WHERE starter_operators.operator_email='$email' 
								   AND starter_operators.operator_password='$password'");
		return $query->row();
	}
	
	public function doc_active($doc_id)
	{
		$query = $this->db->query("UPDATE starter_doctors SET doctor_login_info = 'Login' WHERE starter_doctors.doctor_id = $doc_id");
		
	}
	
	public function check_operator_phone_credentials($phone, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_operators
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_operators.operator_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_operators.operator_org_centerid 
								   WHERE starter_operators.operator_phone='$phone' AND starter_operators.operator_password='$password'");
		return $query->row();
	}
	
	public function update_operator($operator_id, $data)
	{
		$this->db->where('operator_id', $operator_id);
		$this->db->update('starter_operators', $data);
	}
	
	/************End Operator Login****************/
	
	/*******Doctor login********/
	
	public function check_doctor_email_credentials($email, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_doctors
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctors.doctor_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctors.doctor_org_centerid 
								   WHERE starter_doctors.doctor_email='$email' 
								   AND starter_doctors.doctor_password='$password'");
		return $query->row();
	}
	
	public function check_doctor_phone_credentials($phone, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_doctors
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctors.doctor_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctors.doctor_org_centerid  
								   WHERE starter_doctors.doctor_phone='$phone' 
								   AND starter_doctors.doctor_password='$password'");
		return $query->row();
	}
	
	public function update_doctor($doctor_id, $data)
	{
		$this->db->where('doctor_id', $doctor_id);
		$this->db->update('starter_doctors', $data);
	}
	
	/************End Doctor Login****************/
	
	/*******Doctor Assistant login********/
	
	public function check_assistant_email_credentials($email, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_doctor_assistants
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctor_assistants.assistant_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctor_assistants.assistant_org_centerid 
								   WHERE starter_doctor_assistants.assistant_email='$email' 
								   AND starter_doctor_assistants.assistant_password='$password'");
		return $query->row();
	}
	
	public function check_assistant_phone_credentials($phone, $password)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_doctor_assistants
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctor_assistants.assistant_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctor_assistants.assistant_org_centerid 
								   WHERE starter_doctor_assistants.assistant_phone='$phone' 
								   AND starter_doctor_assistants.assistant_password='$password'");
		return $query->row();
	}
	
	public function update_assistant($assistant_id, $data)
	{
		$this->db->where('assistant_id', $assistant_id);
		$this->db->update('starter_doctor_assistants', $data);
	}
	
	/************End Doctor Assistant****************/
	
	
	
}