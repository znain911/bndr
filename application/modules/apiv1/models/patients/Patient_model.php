<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patient_model extends CI_Model {
	
	public function count_all_items()
	{
		$query = $this->db->query("SELECT COUNT(patient_id) AS total_records FROM starter_patients");
		$result = $query->row_array();
		if($result['total_records'])
		{
			return $result['total_records'];
		}else{
			return 0;
		}
	}
	
	public function get_all_items($params=array())
	{
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
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		
		if(isset($center_id))
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "WHERE patient_create_date BETWEEN '$from_date' AND '$to_date' AND starter_patients.patient_org_centerid='$center_id' ";
			}else
			{
				$query .= "WHERE starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "WHERE patient_create_date BETWEEN '$from_date' AND '$to_date' ";
			}
		}
		
		$query .= "ORDER BY starter_patients.patient_id ASC";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_csv_items($params=array())
	{		
		$center_id = $this->session->userdata('user_org_center_id');
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
				  ";
		
		if(isset($center_id))
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "WHERE patient_create_date BETWEEN '$from_date' AND '$to_date' AND starter_patients.patient_org_centerid='$center_id' ";
			}else
			{
				$query .= "WHERE starter_patients.patient_org_centerid='$center_id' ";
			}
		}else
		{
			if(array_key_exists("from_date",$params) && array_key_exists("to_date",$params)){
				$from_date = $params['from_date'];
				$stop_date = $params['to_date'];
				$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
				$query .= "WHERE patient_create_date BETWEEN '$from_date' AND '$to_date' ";
			}
		}
		
		$query .= "ORDER BY starter_patients.patient_id ASC";
		$query = $this->db->query($query);
		return $query->result_array();
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
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$search_term = $params['src'];
		$query .= "WHERE (patient_entryid LIKE '%$search_term%' ";
		$query .= "OR patient_phone LIKE '%$search_term%' ";
		$query .= "OR patient_name LIKE '%$search_term%' ";
		$query .= "OR patient_nid LIKE '%$search_term%' ";
		$query .= "OR patient_guide_book LIKE '%$search_term%' ";
		$query .= "OR patient_idby_center LIKE '%$search_term%' ";
		$query .= "OR patient_age LIKE '%$search_term%') ";
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
	
	public function update_sync($patient_entryid, $data)
	{
		$this->db->where('patient_entryid', $patient_entryid);
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
	
	public function get_patient_data($id)
	{
		$query = $this->db->query("SELECT * FROM starter_patients
								   LEFT JOIN starter_patient_familyinfo ON
								   starter_patient_familyinfo.familyinfo_patient_id=starter_patients.patient_id
								   LEFT JOIN starter_patient_emgcontacts ON
								   starter_patient_emgcontacts.emgcontact_patient_id=starter_patients.patient_id
								   LEFT JOIN starter_patient_profinfo ON
								   starter_patient_profinfo.profinfo_patient_id=starter_patients.patient_id
								   WHERE starter_patients.patient_entryid='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_rowid($entry_id)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE patient_entryid='$entry_id' LIMIT 1");
		$result = $query->row_array();
		if($result['patient_id'])
		{
			return $result['patient_id'];
		}else{
			return null;
		}
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
	
	public function get_center_list()
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers ORDER BY orgcenter_id ASC");
		return $query->result_array();
	}
	
	public function get_org_code($org_id)
	{
		$query = $this->db->query("SELECT org_code FROM starter_organizations WHERE starter_organizations.org_id='$org_id' LIMIT 1");
		$result = $query->row_array();
		return $result['org_code'];
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
		$query = $this->db->query("SELECT * 
								   FROM starter_organizations
								   ORDER BY org_id DESC");
		return $query->result_array();
	}
	
	public function get_all_centers($org_id)
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY orgcenter_id ASC");
		return $query->result_array();
	}
	
}