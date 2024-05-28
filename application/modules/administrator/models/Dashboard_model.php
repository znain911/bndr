<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	
	public function get_new_center_info($center_id)
	{
		$query = $this->db->query("SELECT orgcenter_org_id FROM starter_centers WHERE orgcenter_id='$center_id' LIMIT 1");
		$result = $query->row_array();
		return $result['orgcenter_org_id'];
	}
	
	public function multiplev1()
	{
		$query = $this->db->query("SELECT patient_id ,patient_entryid , patient_name ,patient_form_version,patient_guide_book   FROM `starter_patient_visit2`
			left join starter_patients on starter_patients.patient_id = starter_patient_visit2.visit_patient_id
			where  starter_patients.patient_id = starter_patient_visit2.visit_patient_id and compile_info = 'NO' ");
		return $query->result_array();
	}
	
	public function count_all_items()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		//$query = "SELECT patient_id FROM starter_patients WHERE patient_is_registered='YES' ";
		$query = "SELECT patient_id FROM starter_patients  ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	public function get_all_organizations()
	{
		
		$query = $this->db->query("SELECT * 
								   FROM starter_organizations
								   ORDER BY org_name ASC");
		return $query->result_array();
		
	}
	
	public function hide_ch_pic($patient_id)
	{
		
		$query = $this->db->query("update `pres_image` set insert_status = 'hide'
					
			where patient_id = $patient_id and visit_type = 'Case History'  and insert_status = 'NO'");
		if ($this->db->affected_rows() > 0)
			{
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
		
	}
	
	public function rp_ch_pic($patient_id)
	{
		
		$query = $this->db->query("update `pres_image` set insert_status = 'rp'
					
			where patient_id = $patient_id and visit_type = 'Case History'  and insert_status = 'NO'");
		if ($this->db->affected_rows() > 0)
			{
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
		
	}
	
	public function hide_pr_pic($patient_id,$vid)
	{
		
		$query = $this->db->query("update `pres_image` set insert_status = 'hide'
					
			where patient_id = $patient_id and visit_number = '$vid' and visit_type = 'Progress'  and insert_status = 'NO'");
		if ($this->db->affected_rows() > 0)
			{
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
		
	}
	
	public function rp_pr_pic($patient_id,$vid)
	{
		
		$query = $this->db->query("update `pres_image` set insert_status = 'rp'
					
			where patient_id = $patient_id and visit_number = '$vid' and visit_type = 'Progress'  and insert_status = 'NO'");
		if ($this->db->affected_rows() > 0)
			{
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
		
	}
	
	public function hidePicCh()
	{
		
		$query = $this->db->query("SELECT visit_type,patient_id , submitted_by,doctor_name,visit_date,orgcenter_name  FROM `pres_image`
					LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'hide' and visit_type = 'Case History'  order by id asc");
		return $query->result_array();
		
	}
	
	public function rpPic()
	{
		
		$query = $this->db->query("SELECT visit_type,patient_id , submitted_by,doctor_name,visit_date,orgcenter_name  FROM `pres_image`
					LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'rp'  order by id asc");
		return $query->result_array();
		
	}
	
	public function hidePicPr()
	{
		
		$query = $this->db->query("SELECT visit_type,patient_id , submitted_by,doctor_name,visit_date,orgcenter_name  FROM `pres_image`
					LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'hide' and visit_type = 'Progress'  order by id asc");
		return $query->result_array();
		
	}
	
	
	public function caseHistoryPicId()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT visit_type,patient_id , submitted_by,doctor_name,visit_date,orgcenter_name  FROM `pres_image`
					LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'NO' and visit_type = 'Case History' ";
		
		if($center_id){
			$query .= " and center_id = $center_id ";
		}
		$query .= " order by id asc ";
		$result = $this->db->query($query);
		return $result->result_array();
		
	}
	
	
	
	public function progressPicId()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT visit_type,patient_id , submitted_by , doctor_name,visit_date,orgcenter_name FROM `pres_image`
					LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'NO' and visit_type = 'Progress'  ";
			
		if($center_id){
			$query .= " and center_id = $center_id ";
		}
		$query .= " order by id asc ";
		$result = $this->db->query($query);
		return $result->result_array();
		
	}
	
	public function caseHistoryPic($pid)
	{
		
		$query = $this->db->query("SELECT patient_id , image_name FROM `pres_image`
			where insert_status = 'NO' and patient_id = '$pid' and visit_type = 'Case History'");
		return $query->result_array();
		
	}
	
	public function caseHistoryPichide($pid)
	{
		
		$query = $this->db->query("SELECT patient_id , image_name FROM `pres_image`
			where insert_status = 'hide' and patient_id = '$pid' and visit_type = 'Case History'");
		return $query->result_array();
		
	}
	
	public function picRp($pid)
	{
		
		$query = $this->db->query("SELECT visit_type, patient_id , image_name FROM `pres_image`
			where insert_status = 'rp' and patient_id = '$pid' ");
		return $query->result_array();
		
	}
	
	public function progressPic($pid, $vid)
	{
		
		$query = $this->db->query("SELECT patient_id , image_name FROM `pres_image`
			where insert_status = 'NO' and patient_id = '$pid' and visit_number = '$vid' and visit_type = 'Progress' order by id asc");
		return $query->result_array();
		
	}
	
	public function progressPichide($pid, $vid)
	{
		
		$query = $this->db->query("SELECT patient_id , image_name FROM `pres_image`
			where insert_status = 'hide' and patient_id = '$pid' and visit_number = '$vid' and visit_type = 'Progress' order by id asc");
		return $query->result_array();
		
	}
	
	public function progressAllPic($pid)
	{
		
		$query = $this->db->query("SELECT * FROM `pres_image`
			LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'NO' and patient_id = '$pid' and visit_type = 'Progress' order by id asc");
		return $query->result_array();
		
	}
	
	public function progressAllPichide($pid)
	{
		
		$query = $this->db->query("SELECT * FROM `pres_image`
			LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id
			where insert_status = 'hide' and patient_id = '$pid' and visit_type = 'Progress' order by id asc");
		return $query->result_array();
		
	}
	
	public function patientDetailImage($pid)
	{
		
		$query = $this->db->query("SELECT patient_entryid , patient_name FROM `starter_patients`
			where patient_id = '$pid'");
		return $query->row_array();
		
	}
	
	public function footDoctor($pid)
	{
		
		$query = $this->db->query("SELECT foot_doctor FROM `pres_image` where foot_doctor is not null and patient_id = '$pid' and visit_type = 'Case History';");
		return $query->row_array();
		
	}
	
	public function eyeDoctor($pid)
	{
		
		$query = $this->db->query("SELECT eye_doctor FROM `pres_image` where eye_doctor is not null and patient_id = '$pid' and visit_type = 'Case History';");
		return $query->row_array();
		
	}
	
	public function ftDoctor($pid)
	{
		
		$query = $this->db->query("SELECT doctor_name FROM `pres_image` where doctor_name is not null and patient_id = '$pid' and visit_type = 'Case History';");
		return $query->row_array();
		
	}
	
	public function ftDoctorrp($pid)
	{
		
		$query = $this->db->query("SELECT doctor_name FROM `pres_image` where doctor_name is not null and patient_id = '$pid' and insert_status = 'rp' order by id desc;");
		return $query->row_array();
		
	}
	
	public function get_operator_id($name,$patient_org_id)
	{
		$patient_org_id = intval($patient_org_id);
		$query = $this->db->query("SELECT operator_id FROM starter_operators
		where operator_full_name = '$name' and operator_org_id = $patient_org_id");
		return $query->row_array();
		
	}
	public function get_ip($name)
	{
		
		$query = $this->db->query("SELECT doctor_login_ip FROM `starter_doctors` where doctor_full_name = '$name'");
		return $query->row_array();
		
	}
	public function get_patient_id($bndr)
	{
		
		$query = $this->db->query("SELECT patient_id FROM bndr.starter_patients
where patient_entryid = '$bndr'");
		return $query->row_array();
		
	}
	public function rajbndr($data)
	{
		$this->db->insert('starter_patients', $data);
	}
	public function rajbndrfamily($data)
	{
		$this->db->insert('starter_patient_familyinfo', $data);
	}
	public function latest_date_raj()
	{
		
		$query = $this->db->query("SELECT patient_create_date FROM bndr.starter_patients
		where patient_org_id = 54
order by patient_create_date desc 
limit 1");
		return $query->result_array();
		
	}
	public function total_patient()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT patient_gender, patient_create_date,date_format(patient_create_date, '%Y') as  create_date FROM starter_patients ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->result_array();
	}
	public function total_distinct_patient()
	{
		
		$query = "SELECT distinct patient_id,date_format(patient_create_date, '%Y') as  create_date FROM starter_patients
			left join starter_patient_visit on starter_patient_visit.visit_patient_id = starter_patients.patient_id
			where starter_patient_visit.visit_patient_id = starter_patients.patient_id; ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	public function bmi()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT height,weight FROM starter_visit_general_examinations_new; ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	public function blood_sugar()
	{
		
		$query = "SELECT fbg ,2hag,hba1c,t_chol,ldl_c,hdl_c,patient_gender  FROM starter_patients
		left join starter_visit_laboratory_main on starter_visit_laboratory_main.labinvs_patient_id = starter_patients.patient_id
		where starter_visit_laboratory_main.labinvs_patient_id = starter_patients.patient_id";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function life_style()
	{
		
		$query = "SELECT  finaltreat_dietary_advice FROM starter_patient_visit
		left join starter_visit_final_treatment_infos on starter_visit_final_treatment_infos.finaltreat_patient_id = starter_patient_visit.visit_patient_id
		where starter_visit_final_treatment_infos.finaltreat_patient_id = starter_patient_visit.visit_patient_id and visit_is = 'PROGRESS_REPORT'";
				
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function summary_oads()
	{
		
		$query = "SELECT  oads_name,finaltreat_dietary_advice,insulin_name FROM starter_patient_visit
			left join starter_crntomedication_oads on starter_crntomedication_oads.oads_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_insulin on starter_crntomedication_insulin.insulin_patient_id = starter_patient_visit.visit_patient_id
			left join starter_visit_final_treatment_infos on starter_visit_final_treatment_infos.finaltreat_patient_id = starter_patient_visit.visit_patient_id
			where visit_is = 'PROGRESS_REPORT'
			group by visit_id
		";
				
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function summary_all_meds()
	{
		
		$query = "SELECT  visit_id,insulin_name,oads_name,anti_htn_name,anti_lipid_name,anti_obesity_name,other_name,finaltreat_dietary_advice FROM starter_patient_visit
			left join starter_crntomedication_oads on starter_crntomedication_oads.oads_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_insulin on starter_crntomedication_insulin.insulin_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_anti_htn on starter_crntomedication_anti_htn.anti_htn_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_anti_lipids on starter_crntomedication_anti_lipids.anti_lipid_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_anti_obesity on starter_crntomedication_anti_obesity.anti_obesity_patient_id = starter_patient_visit.visit_patient_id
			left join starter_crntomedication_others on starter_crntomedication_others.other_patient_id = starter_patient_visit.visit_patient_id
			left join starter_visit_final_treatment_infos on starter_visit_final_treatment_infos.finaltreat_patient_id = starter_patient_visit.visit_patient_id
			where visit_is = 'PROGRESS_REPORT'
			group by visit_id
					";
				
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function all_meds_ls($visit_id)
	{
		$visitId = intval($visit_id);
		$query = "SELECT finaltreat_dietary_advice FROM starter_visit_final_treatment_infos
where finaltreat_visit_id = $visitId
					";
				
		$result = $this->db->query($query);
		return $result->row_array();
	}
	public function get_tgi()
	{
		
		$query = "SELECT dhistory_type_of_glucose,patient_gender FROM starter_patients
			left join starter_visit_diabetes_histories on starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id
			where  starter_visit_diabetes_histories.dhistory_patient_id = starter_patients.patient_id and 
			dhistory_type_of_glucose is not null ";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	
	public function reg_visit1_2022()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT starter_patients.*,date_format(patient_create_date, '%Y') as  create_date,visit_is,visit_admit_date FROM starter_patients
			left join starter_patient_visit on starter_patient_visit.visit_patient_id = starter_patients.patient_id
			where starter_patient_visit.visit_patient_id = starter_patients.patient_id;";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function all_comorbidity()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT vcomplication_name FROM starter_visit_complication;";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	public function total_followup()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * FROM starter_patient_visit
			where visit_is = 'PROGRESS_REPORT' ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function count_visit()
	{
		$today = date('Y-m-d');
		$org = $this->session->userdata('user_org');
		$query = "SELECT patient_entryid as patient_id   FROM bndr.starter_patient_visit
		left join bndr.starter_operators on bndr.starter_operators.operator_id = bndr.starter_patient_visit.visit_admited_by
		left join bndr.starter_patients on bndr.starter_patients.patient_id = bndr.starter_patient_visit.visit_patient_id
		left join bndr.starter_centers on bndr.starter_centers.orgcenter_id = bndr.starter_patient_visit.visit_org_centerid
		where visit_org_id = $org and visit_admit_date like '%$today%' ORDER BY visit_admit_date desc ";
		
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function doc_image_today()
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
		where  time like '$today%' and submitted_by like '%Operator%' ";
		
		if(isset($org))
		{
			$query .= "and  org_id = $org ";
		}
		$result = $this->db->query($query);
		return $result->result_array();
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
	
	public function get_all_items($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid WHERE patient_id is not null ";
		
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
	
	public function get_doctor_name($id)
	{
		$query = "SELECT doctor_full_name  FROM `starter_doctors`
where doctor_id = $id
					";
				
		$result = $this->db->query($query);
		return $result->row_array();
	}
	
	public function get_all_visit($params=array())
	{
		$today = date('Y-m-d');
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
where visit_org_id = $org and visit_admit_date like '%$today%' order by visit_admit_date desc ";
		
		
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
	
	
	public function doc_image_all($params=array())
	{
		
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where submitted_by like '%Doctor%'   ";
		
		if(isset($org))
		{
			$query .= "and  org_id = $org ";
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
		where submitted_by like '%Doctor%' and time like '$today%'  ";
		
		if(isset($org))
		{
			$query .= "and  org_id = $org ";
		}
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function oprtr_image_all($params=array())
	{
		
		$org = $this->session->userdata('user_org');
		$query = "SELECT * FROM `pres_image`
		left join starter_centers on starter_centers.orgcenter_id = pres_image.center_id
		where submitted_by like '%Operator%'  ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
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
		where submitted_by like '%Operator%' and time like '$today%'  ";
		
		if(isset($org))
		{
			$query .= "and  pres_image.org_id = $org ";
		}
		$query = $this->db->query($query);
		return $query->result_array();
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
	public function image_ch_count($name)
	{
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Case History' ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_ch_count_today($name)
	{
		$today = date('Y-m-d');
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Case History' and time like '$today%' ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_ch_entry_count($name)
	{
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Case History' and insert_status = 'YES'; ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_ch_entry_count_today($name)
	{
		$today = date('Y-m-d');
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Case History' and insert_status = 'YES' and time like '$today%' ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_count($name)
	{
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Progress'; ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_count_today($name)
	{
		$today = date('Y-m-d');
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Progress' and time like '$today%' ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_entry_count($name)
	{
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Progress' and insert_status = 'YES'; ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function image_p_entry_count_today($name)
	{
		$today = date('Y-m-d');
		$query = "SELECT * FROM `pres_image`
		where submitted_by = '$name' and visit_type = 'Progress' and insert_status = 'YES' and time like '$today%' ";
		$query = $this->db->query($query);
		return $query->result_array();
	}
	public function count_today_all_items()
	{
		$today = date('Y-m-d');
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT patient_id FROM starter_patients ";
		$query .= "WHERE patient_create_date LIKE '%$today%' ";
		
		if(isset($center_id))
		{
			$query .= "AND starter_patients.patient_org_centerid='$center_id'";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
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
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$query .= "WHERE patient_create_date LIKE '%$today%' ";
		
		if(isset($center_id))
		{
			
				$query .= "AND starter_patients.patient_org_centerid='$center_id' ";
			
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
	
	public function count_payment_rpendins()
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT patient_id FROM starter_patients WHERE patient_payment_status=0 AND patient_is_registered='YES' ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_payment_rpendins($params = array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid ";
		$query .= "WHERE patient_payment_status=0 AND patient_is_registered='YES' ";
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY patient_id DESC ";
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
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT patient_id FROM starter_patients WHERE patient_payment_status=1 ";
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id'";
		}
		$result = $this->db->query($query);
		return $result->num_rows();
	}
	
	public function get_payment_rpaids($params = array())
	{
		$today = date('Y-m-d');
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * 
				   FROM starter_patients 
				   LEFT JOIN starter_organizations ON
				   starter_organizations.org_id=starter_patients.patient_org_id
				   LEFT JOIN starter_centers ON
				   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
				  ";
		$query .= "WHERE patient_payment_status=1 ";
		
		if(isset($center_id))
		{
			$query .= "AND patient_org_centerid='$center_id' ";
		}
		
		$query .= "ORDER BY patient_id DESC ";
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
	
	public function count_all_visits($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT payment_patient_status FROM starter_patient_visit 
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		
		if(isset($center_id))
		{
			$query .= "WHERE visit_org_centerid='$center_id' ";
		}else
		{
			//$query .= "WHERE payment_patient_status=0 ";
		}
		
		$query = $this->db->query($query);
		return $query->num_rows();
	}
	
	public function get_all_visits($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		$query = "SELECT * FROM starter_patient_visit 
				  
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id 
				  
				  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
				  
				  LEFT JOIN starter_patients ON
				  starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
		
		if(isset($center_id))
		{
			$query .= "WHERE payment_patient_status=0 AND visit_org_centerid='$center_id' ";
		}else
		{
			$query .= "WHERE payment_patient_status=0 ";
		}
		
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function count_allpaid_visits($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		
		$query = "SELECT payment_patient_status,visit_patient_id FROM starter_patient_visit 
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		if(isset($center_id))
		 {
			 $query .= "WHERE starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id AND visit_org_centerid='$center_id' ";
		 }else
		 {
			$query .= "WHERE starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		}
		 if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
				$docName = $this->session->userdata('full_name');
				$query .= "and visit_doctor ='$docName' ";
		}
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_allpaid_visits($params=array())
	{
		$center_id = $this->session->userdata('user_org_center_id');
		// LEFT JOIN starter_visit_payments ON
				  // starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
		$query = "SELECT * FROM starter_patient_visit 
				  

				  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
				  
				  LEFT JOIN starter_patients ON
				  starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
		if(isset($center_id))
		{
			$query .= "WHERE  visit_org_centerid='$center_id' and starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
		}else
		{
			$query .= "WHERE starter_patients.patient_id=starter_patient_visit.visit_patient_id ";
		}
		
		if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
				$docName = $this->session->userdata('full_name');
				$query .= "and visit_doctor ='$docName' ";
		}
		
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	public function get_center_list()
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers ORDER BY orgcenter_id ASC");
		return $query->result_array();
	}
	public function get_latest_visit_date($pid)
	{
		$query = $this->db->query("SELECT * FROM `starter_patient_visit`  where visit_patient_id = $pid");
		return $query->row_array();
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
	
	public function get_all_operators()
	{
		$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_operators 
								   ORDER BY starter_operators.operator_full_name");
		return $query->result_array();
	}
	
	public function get_doctors()
	{
		$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_doctors 
								   where doctor_org_id = $org
								   ORDER BY starter_doctors.doctor_full_name");
		return $query->result_array();
	}
	
	public function get_all_doctors()
	{
		$org = $this->session->userdata('user_org');
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_doctors 
								   ORDER BY starter_doctors.doctor_full_name");
		return $query->result_array();
	}
	
	public function get_sp()
	{
			$query = $this->db->query("SELECT * 
								   FROM bndr.starter_operators 
								   where operator_user_type = 'Super Operator'
								   ORDER BY starter_operators.operator_full_name");
		return $query->result_array();
	}
	
	
	
}