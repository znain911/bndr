<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctor_model extends CI_Model {
	
	public function get_all_items()
	{
		if($this->session->userdata('user_type') === 'Org Admin' ){
			$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM starter_doctors
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctors.doctor_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctors.doctor_org_centerid
								   where doctor_org_id = $org
								   ORDER BY starter_doctors.doctor_id DESC");
		return $query->result_array();
		}else{
		$query = $this->db->query("SELECT * 
								   FROM starter_doctors
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_doctors.doctor_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_doctors.doctor_org_centerid
								   ORDER BY starter_doctors.doctor_id DESC");
		return $query->result_array();
		}
	}

	public function create($data)
	{
		$this->db->insert('starter_doctors', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('doctor_id', $id);
		$this->db->update('starter_doctors', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_doctors WHERE starter_doctors.doctor_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_email($email)
	{
		$query = $this->db->query("SELECT * FROM starter_doctors WHERE starter_doctors.doctor_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_phone($phone)
	{
		$query = $this->db->query("SELECT * FROM starter_doctors WHERE starter_doctors.doctor_phone='$phone' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_total_doctortoday($date)
	{
		$query = $this->db->query("SELECT doctor_id FROM starter_doctors WHERE doctor_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
}