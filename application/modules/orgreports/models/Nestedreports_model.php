<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nestedreports_model extends CI_Model {
	
	public function count_org_centers()
	{
		$org_id = $this->session->userdata('user_org');
		$query = $this->db->query("SELECT orgcenter_id FROM starter_centers WHERE orgcenter_org_id='$org_id'");
		return $query->num_rows();
	}
	
	public function get_org_centers($params=array())
	{
		if(array_key_exists('limit', $params))
		{
			$limit = $params['limit'];
		}else{
			$limit = 15;
		}
		$org_id = $this->session->userdata('user_org');
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name, org_name
								   FROM starter_centers 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_centers.orgcenter_org_id
								   WHERE orgcenter_org_id='$org_id' ORDER BY orgcenter_name ASC LIMIT $limit");
		return $query->result_array();
	}
	
	///////////////////////////////////////////
	
	public function count_center_operators($center)
	{
		$query = $this->db->query("SELECT operator_id FROM starter_operators WHERE operator_org_centerid='$center'");
		return $query->num_rows();
	}
	
	public function get_center_operators($params=array())
	{
		if(array_key_exists('limit', $params))
		{
			$limit = $params['limit'];
		}else{
			$limit = 15;
		}
		$center = $params['center'];
		$query = $this->db->query("SELECT operator_id, operator_full_name, operator_org_centerid, orgcenter_name 
								   FROM starter_operators 
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_operators.operator_org_centerid
								   
								   WHERE operator_org_centerid='$center' ORDER BY operator_full_name ASC LIMIT $limit");
		return $query->result_array();
	}
	
	/////////////////////////////////////////////
	
	public function count_operator_patients($center, $operator)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients 
								   WHERE patient_org_centerid='$center'
								   AND patient_admitted_by='$operator'
								   AND patient_admitted_user_type='Operator'
								   ");
		return $query->num_rows();
	}
	
	public function get_operator_patients($params=array())
	{
		if(array_key_exists('limit', $params))
		{
			$limit = $params['limit'];
		}else{
			$limit = 15;
		}
		$center = $params['center'];
		$operator = $params['operator'];
		$query = $this->db->query("SELECT * 
								   FROM starter_patients 
								   WHERE patient_org_centerid='$center'
								   AND patient_admitted_by='$operator'
								   AND patient_admitted_user_type='Operator' 
								   LIMIT $limit");
		return $query->result_array();
	}
	
	/////////////////////////////////////////////
	
	public function count_patient_visits($patient, $center)
	{
		$query = $this->db->query("SELECT visit_id FROM starter_patient_visit WHERE visit_patient_id='$patient' AND visit_org_centerid='$center'");
		return $query->num_rows();
	}
	
	public function get_patient_visits($params=array())
	{
		if(array_key_exists('limit', $params))
		{
			$limit = $params['limit'];
		}else{
			$limit = 15;
		}
		$patient = $params['patient'];
		$center = $params['center'];
		$query = $this->db->query("SELECT * FROM starter_patient_visit
								   
								   LEFT JOIN starter_visit_payments ON
								   starter_visit_payments.payment_id=starter_patient_visit.visit_id
								   
								   WHERE visit_patient_id='$patient' AND visit_org_centerid='$center' ORDER BY visit_id ASC LIMIT $limit");
		return $query->result_array();
	}
}