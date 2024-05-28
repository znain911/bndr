<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function count_all_items($params=array())
	{
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT patient_id 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_id is not null ";
				   
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	public function total_patient($params=array())
	{
		
		$query = "SELECT patient_gender, patient_create_date,date_format(patient_create_date, '%Y') as  create_date FROM starter_patients 
		where patient_id is not null ";
		
		if(!empty($params['search']['organization']))
		{
			$organization = $params['search']['organization'];
			$query .= "and patient_org_id = '$organization' ";
		}
		if(!empty($params['search']['cenTers']))
		{
			$cenTers = $params['search']['cenTers'];
			$query .= "and patient_org_centerid = '$cenTers' ";
		}
		if(!empty($params['search']['yeartgi']))
		{
			$yeartgi = $params['search']['yeartgi'];
			$query .= "and patient_create_date like '$yeartgi%'";
		}elseif(!empty($params['search']['tgiweek']))
		{
			$tgiweek = $params['search']['tgiweek'];
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('Y-m-d');
			$to = $dto->setISODate($y, $w, 6)->format('Y-m-d');
			
			$query .= " and patient_create_date between '$from' and '$to'";
		}
		elseif(!empty($params['search']['tgiMonth']))
		{
			$tgiMonth = $params['search']['tgiMonth'];
			$query .= "and patient_create_date like '$tgiMonth%'";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function get_tgi_org($params=array())
	{
		
		$query = "SELECT dhistory_type_of_glucose,patient_gender FROM starter_patients
			left join starter_visit_diabetes_histories on starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id
			where  starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id and 
			dhistory_type_of_glucose is not null ";
			
		if(!empty($params['search']['organization']))
		{
			$organization = $params['search']['organization'];
			$query .= "and patient_org_id = '$organization' ";
		}
		if(!empty($params['search']['cenTers']))
		{
			$cenTers = $params['search']['cenTers'];
			$query .= "and patient_org_centerid = '$cenTers' ";
		}
		if(!empty($params['search']['yeartgi']))
		{
			$yeartgi = $params['search']['yeartgi'];
			$query .= "and patient_create_date like '$yeartgi%'";
		}elseif(!empty($params['search']['tgiweek']))
		{
			$tgiweek = $params['search']['tgiweek'];
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('Y-m-d');
			$to = $dto->setISODate($y, $w, 6)->format('Y-m-d');
			
			$query .= " and patient_create_date between '$from' and '$to'";
		}
		elseif(!empty($params['search']['tgiMonth']))
		{
			$tgiMonth = $params['search']['tgiMonth'];
			$query .= "and patient_create_date like '$tgiMonth%'";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function total_distinct_patient($params=array())
	{
		
		$query = "SELECT distinct patient_id,date_format(patient_create_date, '%Y') as  create_date FROM starter_patients
			left join starter_patient_visit on starter_patient_visit.visit_patient_id = starter_patients.patient_id
			where starter_patient_visit.visit_patient_id = starter_patients.patient_id ";
		
		if(!empty($params['search']['organization']))
		{
			$organization = $params['search']['organization'];
			$query .= "and patient_org_id = '$organization' ";
		}
		if(!empty($params['search']['cenTers']))
		{
			$cenTers = $params['search']['cenTers'];
			$query .= "and patient_org_centerid = '$cenTers' ";
		}
		if(!empty($params['search']['yeartgi']))
		{
			$yeartgi = $params['search']['yeartgi'];
			$query .= "and patient_create_date like '$yeartgi%'";
		}elseif(!empty($params['search']['tgiweek']))
		{
			$tgiweek = $params['search']['tgiweek'];
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('Y-m-d');
			$to = $dto->setISODate($y, $w, 6)->format('Y-m-d');
			
			$query .= " and patient_create_date between '$from' and '$to'";
		}
		elseif(!empty($params['search']['tgiMonth']))
		{
			$tgiMonth = $params['search']['tgiMonth'];
			$query .= "and patient_create_date like '$tgiMonth%'";
		}
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function reg_visit1_2022($params=array())
	{
		
		$query = "SELECT starter_patients.*,date_format(patient_create_date, '%Y') as  create_date,visit_is,visit_admit_date FROM starter_patients
			left join starter_patient_visit on starter_patient_visit.visit_patient_id = starter_patients.patient_id
			where starter_patient_visit.visit_patient_id = starter_patients.patient_id ";
			
		if(!empty($params['search']['organization']))
		{
			$organization = $params['search']['organization'];
			$query .= "and patient_org_id = '$organization' ";
		}
		if(!empty($params['search']['cenTers']))
		{
			$cenTers = $params['search']['cenTers'];
			$query .= "and patient_org_centerid = '$cenTers' ";
		}
		if(!empty($params['search']['yeartgi']))
		{
			$yeartgi = $params['search']['yeartgi'];
			$query .= "and patient_create_date like '$yeartgi%'";
		}elseif(!empty($params['search']['tgiweek']))
		{
			$tgiweek = $params['search']['tgiweek'];
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('Y-m-d');
			$to = $dto->setISODate($y, $w, 6)->format('Y-m-d');
			
			$query .= " and patient_create_date between '$from' and '$to'";
		}
		elseif(!empty($params['search']['tgiMonth']))
		{
			$tgiMonth = $params['search']['tgiMonth'];
			$query .= "and patient_create_date like '$tgiMonth%'";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	public function get_tgi($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT dhistory_type_of_glucose,patient_gender FROM starter_patients
			left join starter_visit_diabetes_histories on starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id
			where  starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id and 
			dhistory_type_of_glucose is not null ";
			
			if(!empty($params['search']['yeartgi']))
		{
			$yeartgi = $params['search']['yeartgi'];
			$query .= "and patient_create_date like '$yeartgi%'";
		}
		elseif(!empty($params['search']['tgiweek']))
		{
			$tgiweek = $params['search']['tgiweek'];
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('Y-m-d');
			$to = $dto->setISODate($y, $w, 6)->format('Y-m-d');
			
			$query .= " and patient_create_date between '$from' and '$to'";
		}
		elseif(!empty($params['search']['tgiMonth']))
		{
			$tgiMonth = $params['search']['tgiMonth'];
			$query .= "and patient_create_date like '$tgiMonth%'";
		}
		
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function count_all_imported_items($params=array())
	{
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT patient_id 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_is_registered='NO' ";
				   
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	public function doc_image_today($params=array())
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		where  time like '$today%' and submitted_by like '%Doctor%' ";
		
		if(isset($org))
		{
			$query .= "and  org_id = $org ";
		}
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function oprtr_image_today()
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		where time like '$today%' and submitted_by like '%Operator%' ";
		
		
		if(isset($org))
		{
			$query .= "and  org_id = $org ";
		}
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function patient_wise_image_upload_p($params=array())
	{
		$doc = $params['doc'];
		$center = $params['center'];
		$query = "SELECT * FROM `pres_image`
		left join starter_patients on starter_patients.patient_id = pres_image.patient_id
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where visit_type = 'Progress' and submitted_by like '$doc%' and center_id = $center and starter_patients.patient_id = pres_image.patient_id ";
		
		if(!empty($params['from_date']) && !empty($params['to_date'])){
			$from_date = $params['from_date'];
			$to_date   = $params['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['from_date'])){
			$from_date = $params['from_date'];
			$query .= " AND time like '$from_date%'  ";
		}elseif(!empty($params['today'])){
			if($params['today'] === 'filtered'){
				$today = date('Y-m-d');
			$query .= " AND time like '$today%'  ";
			}else{
			$today = $params['today'];
			$query .= " AND time like '$today%'  ";
			}
		}
		
		if(!empty($params['month']) && !empty($params['year'])){
			$month = $params['month'];
			$year = $params['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['month']) || !empty($params['year'])){
			if(!empty($params['month']))
			{
				$month = $params['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['year'])){
				$year = $params['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query .= " order by time desc ";
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function patient_wise_image_upload_ch($params=array())
	{
		$doc = $params['doc'];
		$center = $params['center'];
		$query = "SELECT * FROM `pres_image`
		left join starter_patients on starter_patients.patient_id = pres_image.patient_id
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where visit_type = 'Case History' and submitted_by like '$doc%' and center_id = $center and starter_patients.patient_id = pres_image.patient_id";
		
		if(!empty($params['from_date']) && !empty($params['to_date'])){
			$from_date = $params['from_date'];
			$to_date   = $params['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['from_date'])){
			$from_date = $params['from_date'];
			$query .= " AND time like '$from_date%'  ";
		}elseif(!empty($params['today'])){
			if($params['today'] === 'filtered'){
				$today = date('Y-m-d');
			$query .= " AND time like '$today%'  ";
			}else{
			$today = $params['today'];
			$query .= " AND time like '$today%'  ";
			}
		}
		
		if(!empty($params['month']) && !empty($params['year'])){
			$month = $params['month'];
			$year = $params['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['month']) || !empty($params['year'])){
			if(!empty($params['month']))
			{
				$month = $params['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['year'])){
				$year = $params['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query .= " order by time desc ";
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function get_a_visit($pid,$vdate)
	{
		$query = "SELECT * FROM `starter_patient_visit`  
			where visit_patient_id = $pid and visit_date = '$vdate' and visit_is = 'PROGRESS_REPORT' ";
			
		$result = $this->db->query($query);
		return $result->row_array();
		
	}
	
	public function get_a_visit_ch($pid,$vdate)
	{
		$query = "SELECT * FROM `starter_patient_visit`  
			where visit_patient_id = $pid and visit_date = '$vdate' and visit_is = 'CASE_HISTORY' ";
			
		$result = $this->db->query($query);
		return $result->row_array();
		
	}
	
	public function patient_wise_image_entry_p($params=array())
	{
		$doc = $params['doc'];
		$center = $params['center'];
		$query = "SELECT * FROM `pres_image`
		left join starter_patients on starter_patients.patient_id = pres_image.patient_id
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where visit_type = 'Progress' and submitted_by like '$doc%' and insert_status = 'YES' and center_id = $center and starter_patients.patient_id = pres_image.patient_id";
		
		if(!empty($params['from_date']) && !empty($params['to_date'])){
			$from_date = $params['from_date'];
			$to_date   = $params['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['from_date'])){
			$from_date = $params['from_date'];
			$query .= " AND time like '$from_date%'  ";
		}elseif(!empty($params['today'])){
			if($params['today'] === 'filtered'){
				$today = date('Y-m-d');
			$query .= " AND time like '$today%'  ";
			}else{
			$today = $params['today'];
			$query .= " AND time like '$today%'  ";
			}
		}
		
		if(!empty($params['month']) && !empty($params['year'])){
			$month = $params['month'];
			$year = $params['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['month']) || !empty($params['year'])){
			if(!empty($params['month']))
			{
				$month = $params['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['year'])){
				$year = $params['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query .= " order by time desc ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function patient_wise_image_entry_ch($params=array())
	{
		$doc = $params['doc'];
		$center = $params['center'];
		$query = "SELECT * FROM `pres_image`
		left join starter_patients on starter_patients.patient_id = pres_image.patient_id
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where visit_type = 'Case History' and submitted_by like '$doc%' and insert_status = 'YES' and center_id = $center and starter_patients.patient_id = pres_image.patient_id";
		
		if(!empty($params['from_date']) && !empty($params['to_date'])){
			$from_date = $params['from_date'];
			$to_date   = $params['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['from_date'])){
			$from_date = $params['from_date'];
			$query .= " AND time like '$from_date%'  ";
		}elseif(!empty($params['today'])){
			if($params['today'] === 'filtered'){
				$today = date('Y-m-d');
			$query .= " AND time like '$today%'  ";
			}else{
			$today = $params['today'];
			$query .= " AND time like '$today%'  ";
			}
		}
		
		if(!empty($params['month']) && !empty($params['year'])){
			$month = $params['month'];
			$year = $params['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['month']) || !empty($params['year'])){
			if(!empty($params['month']))
			{
				$month = $params['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['year'])){
				$year = $params['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query .= " order by time desc ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	
	
	public function count_all_drugs_items($params=array())
	{
		$query = "SELECT id 
				   FROM starter_dgds 
				   LEFT JOIN starter_pharmaceuticals ON
				   starter_pharmaceuticals.company_id=starter_dgds.company
				   WHERE status='YES' ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (brand LIKE '%$search_term%' ";
			$query .= "OR generic LIKE '%$search_term%' ";
			$query .= "OR strength LIKE '%$search_term%' ";
			$query .= "OR dosages LIKE '%$search_term%' ";
			$query .= "OR DAR LIKE '%$search_term%') ";
        }
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_latest_visit_date($pid)
	{
		$query = $this->db->query("SELECT * FROM `starter_patient_visit`  where visit_patient_id = $pid");
		return $query->row_array();
	}
	
	public function get_all_items($params=array())
	{
		
		
		if ($this->session->userdata('user_type') === 'Org Admin'){
			if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}
			$org = $this->session->userdata('user_org');
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
					patient_admitted_user_type,
					patient_admitted_user_syncid,
					patient_guide_book
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_id is not null
				   AND patient_org_id = $org ";
		} else {
			if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		
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
					patient_admitted_user_type,
					patient_admitted_user_syncid,
					patient_guide_book
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_is_registered='YES' ";
		}
		
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
				$date = '-'.$month.'-'; 
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
		
		if(isset($center_id))
		{
			$query .= " AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY starter_patients.patient_id DESC ";
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
	public function get_doctor_name($id)
	{
		$query = "SELECT doctor_full_name  FROM `starter_doctors`
where doctor_id = $id
					";
				
		$result = $this->db->query($query);
		return $result->row_array();
	}
	public function image_ch_count($name,$from,$to,$operator,$month,$year)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Case History' ";
		if(!empty($from) && !empty($to)){
			$from_date = $from;
			$to_date   = $to;
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($operator)){
			
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($month) && !empty($year)){
			
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($month) || !empty($year)){
			if(!empty($month))
			{
				
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}elseif(!empty($year)){
				
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_ch_count_today($name,$from,$org,$doctor,$center)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Case History' ";
		if(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
        }else{
			$from_date = date('Y-m-d');
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($doctor)){
			
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($center)){
			
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($org)){
			
			$query .= " AND org_id = '$org' ";
        }
		
		
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function image_ch_entry_count($name,$from,$to,$operator,$month,$year)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Case History' and insert_status = 'YES' ";
		
		if(!empty($from) && !empty($to)){
			$from_date = $from;
			$to_date   = $to;
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($operator)){
			
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($month) && !empty($year)){
			
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($month) || !empty($year)){
			if(!empty($month))
			{
				
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}elseif(!empty($year)){
				
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_ch_entry_count_today($name,$from,$org,$doctor,$center)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Case History' and insert_status = 'YES' ";
		
		if(!empty($from) ){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
        }else{
			$from_date = date('Y-m-d');
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($doctor)){
			
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($center)){
			
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($org)){
			
			$query .= " AND org_id = '$org' ";
        }
		
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_count($name,$from,$to,$operator,$month,$year)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Progress' ";
		
		if(!empty($from) && !empty($to)){
			$from_date = $from;
			$to_date   = $to;
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($operator)){
			
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($month) && !empty($year)){
			
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($month) || !empty($year)){
			if(!empty($month))
			{
				
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}elseif(!empty($year)){
				
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_count_today($name,$from,$org,$doctor,$center)
	{
		$query = "SELECT * FROM `pres_image`
		where  visit_type = 'Progress' ";
		
		if(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
        }else{
			$from_date = date('Y-m-d');
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($doctor)){
			
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($center)){
			
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($org)){
			
			$query .= " AND org_id = '$org' ";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_entry_count($name,$from,$to,$operator,$month,$year)
	{
		$query = "SELECT * FROM `pres_image`
		where visit_type = 'Progress' and insert_status = 'YES' ";
		
		if(!empty($from) && !empty($to)){
			$from_date = $from;
			$to_date   = $to;
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($from)){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($operator)){
			
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($month) && !empty($year)){
			
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($month) || !empty($year)){
			if(!empty($month))
			{
				
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}elseif(!empty($year)){
				
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_entry_count_today($name,$from,$org,$doctor,$center)
	{
		$query = "SELECT * FROM `pres_image`
		where visit_type = 'Progress' and insert_status = 'YES' ";
		
		if(!empty($from) ){
			$from_date = $from;
			$query .= " AND time like '$from_date%'  ";
        }else{
			$from_date = date('Y-m-d');
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($doctor)){
			
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by = '$name' ";
		}
		
		if(!empty($center)){
			
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($org)){
			
			$query .= " AND org_id = '$org' ";
        }
		
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function doc_image_all($params=array())
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where patient_id is not null   ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
		}
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date   = $params['search']['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['search']['from_date'])){
			$from_date = $params['search']['from_date'];
			$query .= " AND time like '%$from_date%'  ";
		}
		
		if(!empty($params['search']['org'])){
			$org = $params['search']['org'];
			$query .= " AND org_id = '$org' ";
        }
		
		if(!empty($params['search']['center'])){
			$center = $params['search']['center'];
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($params['search']['doctor'])){
			$doctor = $params['search']['doctor'];
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by like '%Doctor%' ";
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
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
	
	public function doc_image_all_today($params=array())
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where patient_id is not null   ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
		}
		
		if(!empty($params['search']['from_date']) ){
			$from_date = $params['search']['from_date'];
			
			$query .= " AND time like '%$from_date%'  ";
		}else{
			$from_date = date('Y-m-d');
			
			$query .= " AND time like '%$from_date%'  ";
		}
		
		if(!empty($params['search']['org'])){
			$org = $params['search']['org'];
			$query .= " AND org_id = '$org' ";
        }
		
		if(!empty($params['search']['center'])){
			$center = $params['search']['center'];
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($params['search']['doctor'])){
			$doctor = $params['search']['doctor'];
			$query .= " AND submitted_by like '$doctor%' ";
        }else{
			$query .= " AND submitted_by like '%Doctor%' ";
		}
	
		
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
	
	public function oprtr_image_all_today($params=array())
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where  patient_id is not null  ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
		}
		if(!empty($params['search']['from_date']) ){
			$from_date = $params['search']['from_date'];
			
			$query .= " AND time like '%$from_date%'  ";
		}else{
			$from_date = date('Y-m-d');
			
			$query .= " AND time like '%$from_date%'  ";
		}
		
		if(!empty($params['search']['org'])){
			$org = $params['search']['org'];
			$query .= " AND org_id = '$org' ";
        }
		
		if(!empty($params['search']['center'])){
			$center = $params['search']['center'];
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($params['search']['operator'])){
			$operator = $params['search']['operator'];
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by like '%Operator%' ";
		}
		
		
		
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
	
		public function oprtr_image_all($params=array())
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where  patient_id is not null  ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
		}
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$to_date   = $params['search']['to_date'];
			$query .= " AND time BETWEEN '$from_date' AND '$to_date' ";
        }elseif(!empty($params['search']['from_date'])){
			$from_date = $params['search']['from_date'];
			$query .= " AND time like '$from_date%'  ";
		}
		
		if(!empty($params['search']['org'])){
			$org = $params['search']['org'];
			$query .= " AND org_id = '$org' ";
        }
		
		if(!empty($params['search']['center'])){
			$center = $params['search']['center'];
			$query .= " AND center_id = '$center' ";
        }
		
		if(!empty($params['search']['operator'])){
			$operator = $params['search']['operator'];
			$query .= " AND submitted_by like '$operator%' ";
        }else{
			$query .= " AND submitted_by like '%Operator%' ";
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month;
			$query .= " AND time LIKE '%$date%' ";
        
		}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
			
			if(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= " AND time LIKE '%$date%' ";
			}
        }
		
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
	
	public function get_all_visit($params=array())
	{
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}
		$org = $this->session->userdata('user_org');
		
		$query = "SELECT patient_entryid as patient_id ,  if ( patient_gender = '1' , 'Female', 'Male') as patient_gender , patient_name,  orgcenter_name,
			 patient_phone, patient_dateof_birth,
			patient_age, patient_create_date, visit_admit_date, (case 
			when  visit_is = 'CASE_HISTORY' then 'Case History' 
			when visit_is = 'PROGRESS_REPORT' || visit_number != NULL then 'Follow up' 
			END) AS visit_type
			,operator_full_name as submitted_by ,visit_admited_by_usertype,visit_admited_by  FROM bndr.starter_patient_visit
			left join bndr.starter_operators on bndr.starter_operators.operator_id = bndr.starter_patient_visit.visit_admited_by
			left join bndr.starter_patients on bndr.starter_patients.patient_id = bndr.starter_patient_visit.visit_patient_id
			left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
			where visit_org_id = $org  ";
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= " AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        }
		
		if(!empty($params['search']['operator'])){
			$operator = $params['search']['operator'];
			$query .= " AND operator_id = $operator ";
        }
		
		if(!empty($params['search']['doctor'])){
			$doctor = $params['search']['doctor'];
			$query .= " AND visit_admited_by_usertype = 'Doctor' and visit_admited_by = $doctor ";
        }
		if(!empty($params['search']['type'])){
			$type = $params['search']['type'];
			$query .= " AND visit_is = '$type' ";
        }
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month;
			$query .= " AND visit_admit_date LIKE '%$date%' ";
        
		}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$date = '-'.$month.'-'; 
				$query .= " AND visit_admit_date LIKE '%$date%' ";
			}
			
			if(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= " AND visit_admit_date LIKE '%$date%' ";
			}
        }
		
		// if(!empty($params['search']['keywords']))
		// {
			// $search_term = $params['search']['keywords'];
			// $query .= "AND (patient_entryid LIKE '%$search_term%' ";
			// $query .= "OR patient_phone LIKE '%$search_term%' ";
			// $query .= "OR patient_nid LIKE '%$search_term%' ";
			// $query .= "OR patient_guide_book LIKE '%$search_term%' ";
			// $query .= "OR patient_name LIKE '%$search_term%' ";
			// $query .= "OR patient_age LIKE '%$search_term%') ";
		// }
		
		if(isset($center_id))
		{
			$query .= " AND visit_org_centerid = '$center_id' ";
		}
		
		if(empty($params['search']['year']) && empty($params['search']['month']) && empty($params['search']['type'])
			&& empty($params['search']['operator']) && empty($params['search']['center']) && empty($params['search']['from_date']) && empty($params['search']['to_date'])
		&& empty($params['search']['doctor']))
		{
			$today = date('Y-m-d');
			$query .= " and visit_admit_date like '%$today%' ";
		}
		
		$query .= " ORDER BY visit_date DESC ";
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
	
	public function get_all_imported_items($params=array())
	{
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		
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
					patient_admitted_user_type,
					patient_admitted_user_syncid
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_is_registered='NO' ";
		
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY starter_patients.patient_id DESC ";
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
	
	public function get_all_drugs_items($params=array())
	{
		$query = "SELECT * 
				   FROM starter_dgds 
				   LEFT JOIN starter_pharmaceuticals ON
				   starter_pharmaceuticals.company_id=starter_dgds.company
				   WHERE status='YES' ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (brand LIKE '%$search_term%' ";
			$query .= "OR generic LIKE '%$search_term%' ";
			$query .= "OR strength LIKE '%$search_term%' ";
			$query .= "OR dosages LIKE '%$search_term%' ";
			$query .= "OR DAR LIKE '%$search_term%') ";
        }
		
		$query .= "ORDER BY id DESC ";
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
	
	public function count_all_organaizations($params=array())
	{
		$query = "SELECT org_id
				   FROM starter_organizations ";
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
		
		$query = $this->db->query($query);
		return $query->num_rows();
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
		$query .= "ORDER BY org_name ASC ";
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
		$query = "SELECT orgcenter_id FROM starter_centers ";
		if(!empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$search_term = $params['search']['keywords'];
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
			$query .= "AND (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
        }elseif(empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date']))
		{
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
			
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) || empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) && empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function count_all_companies($params=array())
	{
		$query = "SELECT company_id FROM starter_pharmaceuticals WHERE company_status='YES' ";
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND company_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (company_name LIKE '%$search_term%') ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_companies($params=array())
	{
		$query = "SELECT * FROM starter_pharmaceuticals WHERE company_status='YES' ";
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND company_create_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (company_name LIKE '%$search_term%') ";
		}
		
		$query .= "ORDER BY company_id DESC ";
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
	
	public function get_all_centers($params=array())
	{
		$query = "SELECT * 
				   FROM starter_centers
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_centers.orgcenter_org_id
				   LEFT JOIN starter_divisions ON
				   starter_divisions.division_id=starter_centers.orgcenter_division_id
				   LEFT JOIN starter_districts ON
				   starter_districts.district_id=starter_centers.orgcenter_district_id
				   LEFT JOIN starter_upazilas ON
				   starter_upazilas.upazila_id=starter_centers.orgcenter_upazila_id ";
		if(!empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$search_term = $params['search']['keywords'];
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
			$query .= "AND (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
        }elseif(empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date']))
		{
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE orgcenter_create_date BETWEEN '$from_date' AND '$to_date' ";
			
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) || empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) && empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (orgcenter_name LIKE '%$search_term%' ";
			$query .= "OR orgcenter_create_date LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_centers.orgcenter_name ASC ";
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
	
	public function today_all_items($params = array())
	{
		$today = date('Y-m-d');
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid ";
		$query .= "WHERE patient_create_date LIKE '%$today%' ";
		if(!empty($params['search']['keywords'])){
			$search_term = $params['search']['keywords'];
			$query .= "AND (patient_entryid LIKE '%$search_term%' ";
			$query .= "OR patient_phone LIKE '%$search_term%' ";
			$query .= "OR patient_nid LIKE '%$search_term%' ";
			$query .= "OR patient_guide_book LIKE '%$search_term%' ";
			$query .= "OR patient_name LIKE '%$search_term%' ";
			$query .= "OR patient_age LIKE '%$search_term%') ";
        }
		if(isset($center_id))
		{
			
				$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
			
		}
		// if(!empty($params['search']['center']))
		// {
			// $center_id = $params['search']['center'];
			// $query .= "AND patient_org_centerid='$center_id' ";
		// }
		
		$query .= "ORDER BY starter_patients.patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
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
	
	public function count_payment_pendins($params=array())
	{
		$query = "SELECT visit_id 
				  FROM starter_patient_visit 
				  
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
				  
		$query .= "WHERE payment_patient_status=0 ";
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
			$query .= "AND visit_org_centerid='$center_id' ";
		}
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND visit_admit_date LIKE '%$date%' ";
        }elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}elseif(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}
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
	
	public function get_payment_pendins($params=array())
	{
		$query = "SELECT * 
				  FROM starter_patient_visit 
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id 
				 
      			  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
				  
				  LEFT JOIN starter_patients ON
				  starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
				  
		$query .= "WHERE payment_patient_status=0 ";
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
			$query .= "AND visit_org_centerid='$center_id' ";
		}
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND visit_admit_date LIKE '%$date%' ";
        }elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}elseif(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}
        }
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
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
	
	public function count_payment_paids($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT visit_id ,visit_patient_id
				  FROM starter_patient_visit 
				  
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
				  
		$query .= "WHERE starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		if($center_id){
			$query .= "AND visit_org_centerid='$center_id' ";
		}
		
		if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
				$docName = $this->session->userdata('full_name');
				$query .= "and visit_doctor ='$docName' ";
		}
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND visit_admit_date LIKE '%$date%' ";
        }elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}elseif(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}
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
		return $query->result_array();
	}
	
	public function get_payment_paids($params=array())
	{
		// LEFT JOIN starter_visit_payments ON
				  // starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id 
	  $center_id = null;
	  if($this->session->userdata('user_type') == 'Administrator'){
		  if(!empty($params['search']['center'])){
			  $center_id = $params['search']['center'];
		  }
		  
	  }else{
		$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT * 
				  FROM starter_patient_visit 
				  
				  
				  
				  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
				  
				  LEFT JOIN starter_patients ON
				  starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
				  
		$query .= "WHERE starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
		
		if($center_id){
			$query .= "AND visit_org_centerid='$center_id' ";
		}
		
		if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
				$docName = $this->session->userdata('full_name');
				$query .= "and visit_doctor ='$docName' ";
		}
		
		if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
        
		}
		
		if(!empty($params['search']['month']) && !empty($params['search']['year'])){
			$month = $params['search']['month'];
			$year = $params['search']['year'];
			$date = $year.'-'.$month.'-';
			$query .= "AND visit_admit_date LIKE '%$date%' ";
        }elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
			if(!empty($params['search']['month']))
			{
				$month = $params['search']['month'];
				$year = date("Y");
				$date = $year.'-'.$month.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}elseif(!empty($params['search']['year'])){
				$year = $params['search']['year'];
				$date = $year.'-'; 
				$query .= "AND visit_admit_date LIKE '%$date%' ";
			}
        }
		
		if(!empty($params['search']['keywords']))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (patient_entryid  LIKE '%$search_term%' ";
			$query .= "OR patient_guide_book LIKE '%$search_term%' ";
			$query .= "OR patient_phone LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
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
	
	public function get_all_visits($params=array())
	{
		$patient_id = $params['patient_id'];
		
		$query = "SELECT starter_patient_visit.*, starter_visit_payments.*, starter_visit_diabetes_histories.dhistory_duration_of_glucose
				  FROM starter_patient_visit
				  LEFT JOIN starter_visit_diabetes_histories ON
				  starter_visit_diabetes_histories.dhistory_visit_id=starter_patient_visit.visit_id
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		if(!empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$search_term = $params['search']['keywords'];
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
        }elseif(empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date']))
		{
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
			
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) || empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) && empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
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
	
	public function get_all_reports($params=array())
	{
		$query = "SELECT *
				  FROM starter_patient_visit 
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		if(!empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
			$search_term = $params['search']['keywords'];
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
			$query .= "AND (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
        }elseif(empty($params['search']['keywords']) && !empty($params['search']['from_date']) && !empty($params['search']['to_date']))
		{
			$from_date = $params['search']['from_date'];
			$stop_date = $params['search']['to_date'];
			$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
			$query .= "WHERE visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
			
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) || empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}elseif(!empty($params['search']['keywords']) && ( empty($params['search']['from_date']) && empty($params['search']['to_date'])))
		{
			$search_term = $params['search']['keywords'];
			$query .= "WHERE (visit_entryid LIKE '%$search_term%' ";
			$query .= "OR visit_guidebook_no LIKE '%$search_term%' ";
			$query .= "OR visit_type LIKE '%$search_term%' ";
			$query .= "OR visit_date LIKE '%$search_term%') ";
		}
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
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
	
	public function get_entryid($patient_id)
	{
		$query = $this->db->query("SELECT patient_entryid FROM starter_patients WHERE starter_patients.patient_id='$patient_id' LIMIT 1");
		$result = $query->row_array();
		return $result['patient_entryid'];
	}
	
	public function count_payment_rpendins($params = array())
	{
		$today = date('Y-m-d');
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT patient_id FROM starter_patients ";
		$query .= "WHERE patient_payment_status=0 ";
		
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_payment_rpendins($params = array())
	{
		$today = date('Y-m-d');
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
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
					patient_regfee_amount,
					patient_payment_status,
					patient_age,
					patient_admitted_by,
					patient_admitted_user_type,
					patient_admitted_user_syncid
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$query .= "WHERE patient_payment_status=0 ";
		
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY starter_patients.patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_payment_rpaids($params = array())
	{
		$today = date('Y-m-d');
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT patient_id FROM starter_patients ";
		$query .= "WHERE patient_payment_status=1 ";
		
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_payment_rpaids($params = array())
	{
		$today = date('Y-m-d');
		if(!empty($params['search']['center']))
		{
			$center_id = $params['search']['center'];
		}else{
			$center_id = $this->session->userdata('user_org_center_id');
		}
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$query .= "WHERE patient_payment_status=1 ";
		
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
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY starter_patients.patient_id DESC ";
		if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
			$start = $params['start'];
			$query .= "LIMIT {$start},{$limit} ";
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
}