<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function count_all_items($params=array())
	{
		$center   = $params['search']['center'];
		$operator = $params['search']['operator'];
		
		$query = "SELECT patient_id 
				   FROM starter_patients 
				   
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid 
				   
				   WHERE patient_is_registered='YES' 
				   AND patient_org_centerid='$center'
				   AND patient_admitted_by='$operator'
				   AND patient_admitted_user_type='Operator' ";
				   
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND patient_create_date LIKE '%$date%' ";
        }elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND patient_create_date LIKE '%$date%' ";
			}elseif(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND patient_create_date LIKE '%$date%' ";
			}
        }
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (patient_entryid LIKE '%$search_term%' ";
			$query .= "OR patient_phone LIKE '%$search_term%' ";
			$query .= "OR patient_nid LIKE '%$search_term%' ";
			$query .= "OR patient_guide_book LIKE '%$search_term%' ";
			$query .= "OR patient_name LIKE '%$search_term%' ";
			$query .= "OR patient_age LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_items($params=array())
	{
		$center   = $params['search']['center'];
		$operator = $params['search']['operator'];
		
		$query = "SELECT 
					patient_form_version,
					patient_entryid,
					patient_gender,
					patient_name,
					org_name,
					orgcenter_name,
					patient_blood_group,
					patient_phone,
					patient_dateof_birth,
					patient_registration_date,
					patient_create_date,
					patient_id,
					patient_age,
					patient_admitted_by,
					patient_payment_status,
					patient_admitted_user_type,
					patient_admitted_user_syncid
				   FROM starter_patients 
				   
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid 
				   
				   WHERE patient_is_registered='YES' 
				   AND patient_org_centerid='$center'
				   AND patient_admitted_by='$operator'
				   AND patient_admitted_user_type='Operator' ";
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND patient_create_date LIKE '%$date%' ";
        
		}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND patient_create_date LIKE '%$date%' ";
			}
			
			if(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND patient_create_date LIKE '%$date%' ";
			}
        }
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (patient_entryid LIKE '%$search_term%' ";
			$query .= "OR patient_phone LIKE '%$search_term%' ";
			$query .= "OR patient_nid LIKE '%$search_term%' ";
			$query .= "OR patient_guide_book LIKE '%$search_term%' ";
			$query .= "OR patient_name LIKE '%$search_term%' ";
			$query .= "OR patient_age LIKE '%$search_term%') ";
		}
		
		$query .= "ORDER BY patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_all_organaizations($params=array())
	{
		$query = "SELECT * 
				   FROM starter_organizations
				   LEFT JOIN starter_divisions ON
				   starter_divisions.division_id=starter_organizations.org_division_id
				   LEFT JOIN starter_districts ON
				   starter_districts.district_id=starter_organizations.org_district_id
				   LEFT JOIN starter_upazilas ON
				   starter_upazilas.upazila_id=starter_organizations.org_upazila_id ";
		if(!empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$search_term = $params['search']['keywords'];
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE org_create_date BETWEEN '$from_date' AND '$to_date' ";
			$query .= "AND (org_name LIKE '%$search_term%' ";
			$query .= "OR org_code LIKE '%$search_term%') ";
        }elseif(empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date']))
		{
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE org_create_date BETWEEN '$from_date' AND '$to_date' ";
			
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) || empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (org_name LIKE '%$search_term%' ";
			$query .= "OR org_code LIKE '%$search_term%') ";
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) && empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (org_name LIKE '%$search_term%' ";
			$query .= "OR org_code LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_organizations.org_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_all_centers($params=array())
	{
		$org_id = $this->session->userdata('user_org');
		$query = "SELECT orgcenter_id FROM starter_centers WHERE orgcenter_org_id='$org_id' ";
		
		/*
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		*/
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (orgcenter_name LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_centers($params=array())
	{
		$org_id = $this->session->userdata('user_org');
		$query = "SELECT * FROM starter_centers 
				  
				  LEFT JOIN starter_organizations ON
				  starter_organizations.org_id=starter_centers.orgcenter_org_id
				  
				  WHERE orgcenter_org_id='$org_id' ";
		
		/*
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		*/
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (orgcenter_name LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_centers.orgcenter_id DESC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_all_operators($params=array())
	{
		$center_id = $params['search']['center'];
		$query = "SELECT operator_id FROM starter_operators WHERE operator_org_centerid='$center_id' ";
		
		/*
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND operator_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}*/
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (operator_full_name LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_operators($params=array())
	{
		$center_id = $params['search']['center'];
		$query = "SELECT * FROM starter_operators 
				  
				  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_operators.operator_org_centerid
				  
				  WHERE operator_org_centerid='$center_id' ";
		
		/*
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND operator_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}*/
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (operator_full_name LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY operator_full_name ASC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_all_visits($params=array())
	{
		$patient_id = $params['patient'];
		$center = $params['center'];
		
		$query = "SELECT visit_id
				  FROM starter_patient_visit
				  WHERE visit_patient_id='$patient_id' AND visit_org_centerid='$center' ";
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_visits($params=array())
	{
		$patient_id = $params['patient'];
		$center = $params['center'];
		
		$query = "SELECT 
				  starter_patient_visit.*, 
				  starter_visit_payments.* 
				  
				  FROM starter_patient_visit
				  
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id 
				  
				  WHERE visit_patient_id='$patient_id' AND visit_org_centerid='$center' ";
		
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		
		$query .= "ORDER BY visit_id DESC ";
		
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
}