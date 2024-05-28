<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance_model extends CI_Model {
	
	private function get_org_name($org_id)
	{
		$query = $this->db->query("SELECT org_name FROM starter_organizations WHERE org_id='$org_id'");
		$result = $query->row_array();
		return explode(' ', strtolower($result['org_name']));
	}
	
	public function count_total_records_of_orgs()
	{
		$org_id = $this->session->userdata('user_org');
		if($org_id && $org_id !== ''){
			$org_name = $this->get_org_name($org_id);
			if(in_array('bihs', $org_name))
			{
				$query = $this->db->query("SELECT org_id FROM starter_organizations WHERE org_name LIKE '%bihs%'");
				return $query->num_rows();
			}elseif(in_array('nhn', $org_name)){
				$query = $this->db->query("SELECT org_id FROM starter_organizations WHERE org_name LIKE '%nhn%'");
				return $query->num_rows();
			}else{
				return 1;
			}
		}else{
			$query = $this->db->query("SELECT org_id FROM starter_organizations");
			return $query->num_rows();
		}
	}
	
	public function get_total_records_of_orgs()
	{
		$org_id = $this->session->userdata('user_org');
		if($org_id && $org_id !== ''){
			$org_name = $this->get_org_name($org_id);
			if(in_array('bihs', $org_name))
			{
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%bihs%'");
				return $query->result_array();
			}elseif(in_array('nhn', $org_name)){
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%nhn%'");
				return $query->result_array();
			}else{
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_id='$org_id'");
				return $query->result_array();
			}
			
		}else{
			$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations ORDER BY org_name ASC LIMIT 10");
			return $query->result_array();
		}
		
	}
	
	public function get_total_records_of_orgs_toexcel()
	{
		$org_id = $this->session->userdata('user_org');
		if($org_id && $org_id !== ''){
			$org_name = $this->get_org_name($org_id);
			if(in_array('bihs', $org_name))
			{
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%bihs%'");
				return $query->result_array();
			}elseif(in_array('nhn', $org_name)){
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%nhn%'");
				return $query->result_array();
			}else{
				$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations WHERE org_id='$org_id'");
				return $query->result_array();
			}
		}else{
			$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations ORDER BY org_name ASC");
			return $query->result_array();
		}
		
	}
	
	public function get_total_reg_fees_today_by_org($org_id)
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT patient_id FROM starter_patients 
								   WHERE patient_create_date LIKE '%$current_date%'
								   AND patient_org_id='$org_id'");
		$reg_fee = $this->get_config('reg');
		$results = $query->num_rows() * $reg_fee['config_option'];
		return $results;
	}
	
	public function get_total_regs_today($org_id)
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT patient_id FROM starter_patients 
								   WHERE patient_create_date LIKE '%$current_date%'
								   AND patient_org_id='$org_id'");
		$results = $query->num_rows();
		return $results;
	}
	
	public function get_total_reg_amount_today()
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT patient_id FROM starter_patients 
								   WHERE patient_create_date LIKE '%$current_date%'");
		$reg_fee = $this->get_config('reg');
		$results = $query->num_rows() * $reg_fee['config_option'];
		return $results;
	}
	
	public function get_total_reg_amount($type=null)
	{
		$the_month = date("Y").'-';
		if($type !== null)
		{
			$org_id = $this->session->userdata('user_org');
			if($type == 'PAID')
			{
				if($org_id && $org_id !== ''){
					$where_cls = "WHERE patient_payment_status='1' AND patient_org_id='$org_id' AND patient_create_date LIKE '%$the_month%'";
				}else{
					$where_cls = "WHERE patient_payment_status='1' AND patient_create_date LIKE '%$the_month%'";
				}
			}elseif($type == 'UNPAID'){
				
				if($org_id && $org_id !== ''){
					$where_cls = "WHERE patient_payment_status='0' AND patient_org_id='$org_id' AND patient_create_date LIKE '%$the_month%'";
				}else{
					$where_cls = "WHERE patient_payment_status='0' AND patient_create_date LIKE '%$the_month%'";
				}
			}
		}else{
			$org_id = $this->session->userdata('user_org');
			if($org_id && $org_id !== ''){
				$where_cls = "WHERE patient_org_id='$org_id' AND patient_create_date LIKE '%$the_month%'";
			}else{
				$where_cls = "WHERE patient_create_date LIKE '%$the_month%'";
			}
		}
		
			
		$query = $this->db->query("SELECT patient_id FROM starter_patients $where_cls");
		
		$reg_fee = $this->get_config('reg');
		$results = $query->num_rows() * $reg_fee['config_option'];
		return $results;
	}
	
	public function get_total_visit_fees_today_by_org($org_id)
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT visit_admit_date, orgcenter_org_id 
								   FROM starter_visit_payments 
								   
								   LEFT JOIN starter_patient_visit ON
								   starter_patient_visit.visit_id=starter_visit_payments.payment_visit_id
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
								   
								   WHERE visit_admit_date LIKE '%$current_date%'
								   AND orgcenter_org_id='$org_id'");
		$visit_fee = $this->get_config('visit');
		$results = $query->num_rows() * $visit_fee['config_option_two'];
		return $results;
	}
	
	public function get_total_visits_today($org_id)
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT visit_id, orgcenter_org_id 
								   FROM starter_patient_visit 
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
								   
								   WHERE visit_admit_date LIKE '%$current_date%'
								   AND orgcenter_org_id='$org_id'");
		$results = $query->num_rows();
		return $results;
	}
	
	public function get_total_visit_amount_today()
	{
		$current_date = date("Y-m-d");
		$query = $this->db->query("SELECT visit_admit_date 
								   FROM starter_visit_payments 
								   
								   LEFT JOIN starter_patient_visit ON
								   starter_patient_visit.visit_id=starter_visit_payments.payment_visit_id
								   
								   WHERE visit_admit_date LIKE '%$current_date%'");
		$visit_fee = $this->get_config('visit');
		$results = $query->num_rows() * $visit_fee['config_option_two'];
		return $results;
	}
	
	public function get_total_visit_amount($type=null)
	{
		$the_month = date("Y").'-';
		if($type !== null)
		{
			if($type == 'PAID')
			{
				$where_cls = "WHERE payment_patient_status='1' AND visit_admit_date LIKE '%$the_month%'";
			}elseif($type == 'UNPAID'){
				$where_cls = "WHERE payment_patient_status='0' AND visit_admit_date LIKE '%$the_month%'";
			}
		}else{
			$where_cls = null;
		}
		
		if($type !== null)
		{
			$org_id = $this->session->userdata('user_org');
			if($type == 'PAID')
			{
				if($org_id && $org_id !== ''){
					$where_cls = "WHERE payment_patient_status='1' AND visit_org_id='$org_id' AND visit_admit_date LIKE '%$the_month%'";
				}else{
					$where_cls = "WHERE payment_patient_status='1' AND visit_admit_date LIKE '%$the_month%'";
				}
			}elseif($type == 'UNPAID'){
				
				if($org_id && $org_id !== ''){
					$where_cls = "WHERE payment_patient_status='0' AND visit_org_id='$org_id' AND visit_admit_date LIKE '%$the_month%'";
				}else{
					$where_cls = "WHERE payment_patient_status='0' AND visit_admit_date LIKE '%$the_month%'";
				}
			}
		}else{
			$org_id = $this->session->userdata('user_org');
			if($org_id && $org_id !== ''){
				$where_cls = "WHERE visit_org_id='$org_id' AND visit_admit_date LIKE '%$the_month%'";
			}else{
				$where_cls = "WHERE visit_admit_date LIKE '%$the_month%'";
			}
		}
		
		
		$query = $this->db->query("SELECT visit_org_id, visit_admit_date 
								   FROM starter_visit_payments 
								   LEFT JOIN starter_patient_visit ON
								   starter_patient_visit.visit_id=starter_visit_payments.payment_visit_id
								   $where_cls");
		$visit_fee = $this->get_config('visit');
		$results = $query->num_rows() * $visit_fee['config_option_two'];
		return $results;
	}
	
	public function get_config($type)
	{
		if($type == 'reg')
		{
			$tpe = 'config_option';
		}elseif($type == 'visit'){
			$tpe = 'config_option_two';
		}else{
			$tpe = 'config_option';
		}
		$query = $this->db->query("SELECT $tpe FROM starter_configuration WHERE starter_configuration.config_key='REG_FEE' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_orgs_by_keywords($input_keywords)
	{
		$org_id = $this->session->userdata('user_org');
		if ($this->session->userdata('user_type') === 'Org Admin'){
			$query = "SELECT orgcenter_id as org_id ,orgcenter_name as org_name FROM starter_centers 
			WHERE orgcenter_org_id =$org_id ";
		
			if($input_keywords !== ''){
				$search_term = $input_keywords;
				$query .= "AND (orgcenter_name LIKE '%$search_term%' ";
				$query .= "OR orgcenter_code LIKE '%$search_term%') ";
			}
			
			$query .= "ORDER BY orgcenter_name ASC ";
			$query = $this->db->query($query);
			return $query->result_array();
		}else{
		if($org_id && $org_id !== ''){
			$org_name = $this->get_org_name($org_id);
			
			if($input_keywords !== ''){
				$keywords = explode(' ', strtolower($input_keywords));
				$search_term = $input_keywords;
			}else{
				$keywords = array();
			}
			if(is_array($keywords) && count($keywords) !== 0)
			{
				if(in_array('bihs', $org_name))
				{
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE (org_name LIKE '%bihs%') ";
				}elseif(in_array('nhn', $org_name)){
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE (org_name LIKE '%nhn%') ";
				}else{
					$get_the_same_keywords = array_intersect($org_name, $keywords);
					$string = '';
					foreach($get_the_same_keywords as $value)
					{
						$string .= $value.' ';
					}
					$term = substr($string, 0, -1);
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE (org_name LIKE '%$term%' OR org_code LIKE '%$term%') ";
				}
			}else{
				if(in_array('bihs', $org_name))
				{
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%bihs%' ";
				}elseif(in_array('nhn', $org_name)){
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE org_name LIKE '%nhn%' ";
				}else{
					$string = '';
					foreach($org_name as $value)
					{
						$string .= $value.' ';
					}
					$term = substr($string, 0, -1);
					$query = "SELECT org_id, org_name FROM starter_organizations WHERE (org_name LIKE '%$term%' OR org_code LIKE '%$term%') ";
				}
			}
			
			$query .= "ORDER BY org_name ASC ";
			$query = $this->db->query($query);
			return $query->result_array();
		}else{
			$query = "SELECT org_id, org_name FROM starter_organizations ";
		
			if($input_keywords !== ''){
				$search_term = $input_keywords;
				$query .= "WHERE (org_name LIKE '%$search_term%' ";
				$query .= "OR org_code LIKE '%$search_term%') ";
			}
			
			$query .= "ORDER BY org_name ASC ";
			$query = $this->db->query($query);
			return $query->result_array();
		}
		}
	}
	
	public function get_center_list()
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers ORDER BY orgcenter_id ASC");
		return $query->result_array();
	}
	
	
}