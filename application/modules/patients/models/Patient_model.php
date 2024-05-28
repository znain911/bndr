<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {
	public function get_ip($name)
	{
		
		$query = $this->db->query("SELECT doctor_login_ip FROM `starter_doctors` where doctor_full_name = '$name'");
		return $query->row_array();
		
	}
	public function get_sp()
	{
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_operators 
								   where operator_user_type = 'Super Operator'
								   ORDER BY starter_operators.operator_full_name");
		return $query->result_array();
	}
	public function check_email($email)
	{
		$query = $this->db->query("SELECT patient_id, patient_email FROM starter_patients WHERE patient_email='$email' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_phone($phone)
	{
		$query = $this->db->query("SELECT patient_id, patient_phone FROM starter_patients WHERE patient_phone='$phone' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_nid($nid)
	{
		$query = $this->db->query("SELECT patient_id, patient_nid FROM starter_patients WHERE patient_nid='$nid' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_guidebook($guidebook)
	{
		$query = $this->db->query("SELECT patient_id, patient_guide_book FROM starter_patients WHERE patient_guide_book='$guidebook' LIMIT 1");
		return $query->row_array();
	}
	
	
	public function count_all_imported_items()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT patient_id FROM starter_patients WHERE patient_is_registered='NO' ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_all_imported_items($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_is_registered='NO' ";
		
		if(isset($center_id))
		{
			$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
		}
		$query .= "ORDER BY patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_all_items()
	{
		if ($this->session->userdata('user_type') === 'Org Admin'){
			$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT patient_id FROM starter_patients where patient_org_id = $org ");
		return $query->num_rows();
		}else {
		$query = $this->db->query("SELECT patient_id FROM starter_patients");
		return $query->num_rows();
		}
	}
	
	public function get_all_items($params=array())
	{
		if ($this->session->userdata('user_type') === 'Org Admin'){
			$center_id = $this->session->userdata('user_org_center_id');
			$org = $this->session->userdata('user_org');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid 
				   where patient_org_id = $org ";
		if(isset($center_id))
		{
			if(!empty($params['search']['keywords'])){
				$search_term = $params['search']['keywords'];
				$query .= "AND (patient_entryid LIKE '%$search_term%' ";
				$query .= "OR patient_phone LIKE '%$search_term%' ";
				$query .= "OR patient_first_name LIKE '%$search_term%' ";
				$query .= "OR patient_last_name LIKE '%$search_term%' ";
				$query .= "OR patient_age LIKE '%$search_term%') ";
			}else
			{
				$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(!empty($params['search']['keywords'])){
				$search_term = $params['search']['keywords'];
				$query .= "AND (patient_entryid LIKE '%$search_term%' ";
				$query .= "OR patient_phone LIKE '%$search_term%' ";
				$query .= "OR patient_first_name LIKE '%$search_term%' ";
				$query .= "OR patient_last_name LIKE '%$search_term%' ";
				$query .= "OR patient_age LIKE '%$search_term%') ";
			}
		}
			
		}else {
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid ";
		if(isset($center_id))
		{
			if(!empty($params['search']['keywords'])){
				$search_term = $params['search']['keywords'];
				$query .= "WHERE (patient_entryid LIKE '%$search_term%' ";
				$query .= "OR patient_phone LIKE '%$search_term%' ";
				$query .= "OR patient_first_name LIKE '%$search_term%' ";
				$query .= "OR patient_last_name LIKE '%$search_term%' ";
				$query .= "OR patient_age LIKE '%$search_term%') ";
			}else
			{
				$query .= "WHERE starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(!empty($params['search']['keywords'])){
				$search_term = $params['search']['keywords'];
				$query .= "WHERE (patient_entryid LIKE '%$search_term%' ";
				$query .= "OR patient_phone LIKE '%$search_term%' ";
				$query .= "OR patient_first_name LIKE '%$search_term%' ";
				$query .= "OR patient_last_name LIKE '%$search_term%' ";
				$query .= "OR patient_age LIKE '%$search_term%') ";
			}
		}
		}
		$query .= "ORDER BY starter_patients.patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_excel_items($params=array())
	{
		
		$center_id = $this->session->userdata('user_org_center_id');
		$is_registered = $params['is_registered'];
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				   WHERE patient_is_registered='$is_registered' ";
		
		if(isset($center_id))
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' AND starter_patients.patient_org_centerid='$center_id' ";
			}else
			{
				$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
			}
		}
		
		$query .= "ORDER BY starter_patients.patient_id ASC";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	
	public function get_csv_items($params=array())
	{	if($this->session->userdata('user_type') === 'Org Admin') {
			$org = $this->session->userdata('user_org');
	
					$query = "SELECT patient_entryid as patient_id ,  if ( patient_gender = '1' , 'Female', 'Male') as patient_gender , patient_name,  orgcenter_name,
			 patient_phone, patient_dateof_birth,
			patient_age, patient_create_date, visit_date,visit_admit_date, visit_is AS visit_type
			,operator_full_name as submitted_by  FROM bndr.starter_patient_visit
			left join bndr.starter_operators on bndr.starter_operators.operator_id = bndr.starter_patient_visit.visit_admited_by
			left join bndr.starter_patients on bndr.starter_patients.patient_id = bndr.starter_patient_visit.visit_patient_id
			left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
			where visit_org_id = $org ";

			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
							$from_date = $params['from_date'];
							$to_date = $params['to_date'];
							$query .= " AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";

							
			}

			if(array_key_exists("operator",$params)){
							$operator = $params['operator'];
							$query .= " AND operator_full_name = '$operator' ";

							
			}

			if(array_key_exists("center",$params)){
							$center = $params['center'];
							$query .= " AND orgcenter_name = '$center' ";

							
			}

			if(array_key_exists("month",$params) || array_key_exists("year",$params)){
				if(array_key_exists("month",$params) && array_key_exists("year",$params)){
							$month = $params['month'];
							$year = $params['year'];
							$date = $year.'-'.$month;
							$query .= " AND visit_admit_date like '$date%'  ";
				}
				elseif(array_key_exists("month",$params)){
							$month = $params['month'];
							$date = '-'.$month.'-';
							$query .= " AND visit_admit_date like '%$date%'  ";
				}elseif(array_key_exists("year",$params)){
							$year = $params['year'];
							$date = $year.'-';
							$query .= " AND visit_admit_date like '$date%'  ";
				}

							
			}
					$query .= " ORDER BY visit_admit_date desc";
					$query = $this->db->query($query);
					return $query->result_array();
			
		}else {	
		$center_id = $this->session->userdata('user_org_center_id');
		$is_registered = $params['is_registered'];
		$query = "SELECT 
				   patient_entryid,
				   patient_guide_book,
				   patient_idby_center,
				   patient_name,
				   patient_gender,
				   patient_phone,
				   patient_blood_group,
				   patient_address
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  WHERE patient_is_registered='$is_registered' ";
		
		if(isset($center_id))
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' AND starter_patients.patient_org_centerid='$center_id' ";
			}else
			{
				$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
			}
		}
		
		$query .= "ORDER BY starter_patients.patient_id ASC";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	}
	
	public function count_srcall_items($params=array())
	{
		$query = "SELECT COUNT(patient_id) AS total_records FROM starter_patients ";
		$search_term = $params['src'];
		$query .= "WHERE (patient_entryid LIKE '%$search_term%' ";
		$query .= "OR patient_phone LIKE '%$search_term%' ";
		$query .= "OR patient_name LIKE '%$search_term%' ";
		$query .= "OR patient_nid LIKE '%$search_term%' ";
		$query .= "OR patient_guide_book LIKE '%$search_term%' ";
		$query .= "OR patient_idby_center LIKE '%$search_term%' ";
		$query .= "OR patient_age LIKE '%$search_term%') ";
		
		$query = $this->db->query($query);
		$result = $query->row_array();
		if($result['total_records'])
		{
			return $result['total_records'];
		}else{
			return 0;
		}
	}
	
	public function get_srcall_items($params=array())
	{
		$org_id = $this->session->userdata('user_org_id');
		
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$search_term = $params['src'];
		if($org_id === '3'){
			$query .= "WHERE patient_guide_book LIKE '%$search_term%' ";
			
		}else{
			$query .= "WHERE (patient_entryid LIKE '%$search_term%' ";
			$query .= "OR patient_phone LIKE '%$search_term%' ";
			$query .= "OR patient_name LIKE '%$search_term%' ";
			$query .= "OR patient_nid LIKE '%$search_term%' ";
			$query .= "OR patient_guide_book LIKE '%$search_term%' ";
			$query .= "OR patient_idby_center LIKE '%$search_term%' ";
			$query .= "OR patient_age LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_patients.patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit}";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit} ";
        }
		
		$query = $this->db->query($query);
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
	
	public function get_centerwise_count($center_id)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE patient_org_centerid='$center_id'");
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
	
	public function get_center_list()
	{
		if($this->session->userdata('user_type') === 'Org Admin'){
			$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers
				where orgcenter_org_id = $org ORDER BY orgcenter_id ASC");
		return $query->result_array();
		}else {
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers ORDER BY orgcenter_id ASC");
		return $query->result_array();
		}
	}
	
	public function get_org_code($org_id)
	{
		$query = $this->db->query("SELECT org_code FROM starter_organizations WHERE starter_organizations.org_id='$org_id' LIMIT 1");
		$result = $query->row_array();
		return $result['org_code'];
	}
	
	public function get_center_code($center_id)
	{
		$query = $this->db->query("SELECT orgcenter_code FROM starter_centers WHERE orgcenter_id='$center_id' LIMIT 1");
		$result = $query->row_array();
		return $result['orgcenter_code'];
	}
	
	public function get_config()
	{
		$query = $this->db->query("SELECT * FROM starter_configuration WHERE starter_configuration.config_key='REG_FEE' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_receipt_information($patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_patients 
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_patients.patient_org_id
								   WHERE starter_patients.patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function import_patient($data)
	{
		$this->db->insert('starter_patients', $data);
	}
	
	public function get_monthly_expenditures()
	{
		$query = $this->db->query("SELECT expenditure_id, expenditure_title FROM starter_monthly_expenditures ORDER BY expenditure_id ASC");
		return $query->result_array();
	}
	
	public function get_educations()
	{
		$query = $this->db->query("SELECT education_id, education_title FROM starter_educations ORDER BY education_id ASC");
		return $query->result_array();
	}
	
	public function get_professions()
	{
		$query = $this->db->query("SELECT profession_id, profession_title FROM starter_professions ORDER BY profession_id ASC");
		return $query->result_array();
	}
	
	public function get_all_organizations()
	{
		if( $this->session->userdata('user_type') === 'Org Admin') {
			$org_id = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM starter_organizations
								   where org_id = $org_id");
		return $query->result_array();
		}else {
		$query = $this->db->query("SELECT * 
								   FROM starter_organizations
								   ORDER BY org_name ASC");
		return $query->result_array();
		}
	}
	
	public function get_all_centers($org_id)
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY orgcenter_name ASC");
		return $query->result_array();
	}
	public function get_center_list_visit()
	{
		$org = $this->session->userdata('user_org');
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM bndr.starter_centers
left join bndr.starter_organizations on bndr.starter_organizations.org_id = bndr.starter_centers.orgcenter_org_id
where orgcenter_org_id = $org
 ORDER BY orgcenter_id ASC");
		return $query->result_array();
	}
	
	public function get_operators()
	{
		$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_operators 
								   where operator_org_id = $org
								   ORDER BY starter_operators.operator_full_name");
		return $query->result_array();
	}
	
}