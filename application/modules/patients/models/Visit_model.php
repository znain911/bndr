<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_model extends CI_Model {
	
	public function get_config()
	{
		$query = $this->db->query("SELECT * FROM starter_configuration WHERE starter_configuration.config_key='REG_FEE' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_insuline()
	{
		$query = $this->db->query("SELECT * FROM starter_insuline   ORDER BY starter_insuline.insuline_id ASC");
		return $query->result_array();
	}
	public function get_s_insuline($term)
	{
		$query = $this->db->query("SELECT * FROM starter_insuline where insuline_brand like '%$term%'   ORDER BY starter_insuline.insuline_id ASC");
		return $query->result_array();
	}
	
		public function getImageVid($pid )
	{
		
		$query = $this->db->query("SELECT visit_number FROM `pres_image`
			where patient_id = '$pid' and visit_type = 'Progress' order by id desc ");
		return $query->row_array();
		
	}
	
		public function transfer($pid , $visitId)
	{
		
		$query = $this->db->query("update `pres_image` set visit_type = 'Progress' , visit_number = $visitId
			where patient_id = '$pid' and visit_type = 'Case History'  ");
		
		
	}
	
	public function caseHistoryPic($pid)
	{
		
		$query = $this->db->query("SELECT patient_id , image_name FROM `pres_image`
			where  patient_id = '$pid' and visit_type = 'Case History'");
		return $query->result_array();
		
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
	public function get_image($pid)
	{
		$query = $this->db->query("SELECT * FROM `pres_image` LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id where patient_id = $pid  ");
		return $query->result_array();
	}
	
	public function get_ch_image($pid)
	{
		$query = $this->db->query("SELECT * FROM `pres_image` LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id where patient_id = $pid  and visit_type = 'Case History'");
		return $query->row_array();
	}
	
	public function get_foot($pid)
	{
		$query = $this->db->query("SELECT * FROM `pres_image` LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id where patient_id = $pid and foot_doctor is not null and visit_type = 'Case History' ");
		return $query->row_array();
	}
	
	public function get_eye($pid)
	{
		$query = $this->db->query("SELECT * FROM `pres_image` LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=pres_image.center_id where patient_id = $pid and eye_doctor is not null and visit_type = 'Case History'");
		return $query->row_array();
	}
	
	public function check_patient_exist($patient_id, $entry)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE starter_patients.patient_id='$patient_id' AND starter_patients.patient_entryid='$entry' LIMIT 1");
		return $query->row_array();
	}
	public function image_insert($patient_id, $image, $subBy,$vid,$docName,$cid,$org)
	{
		$query = $this->db->query("INSERT INTO `pres_image` (`visit_type`,`patient_id`, `image_name`, `submitted_by`, `doctor_name`, `visit_date`, `center_id`, `org_id`) 
		VALUES ( 'Case History','$patient_id', '$image', '$subBy', '$docName', '$vid', '$cid', '$org')");
		
	}
	
	public function image_insert_foot($patient_id, $image, $subBy,$vid,$footdoc,$cid,$org)
	{
		$query = $this->db->query("INSERT INTO `pres_image` (`visit_type`,`patient_id`, `image_name`, `submitted_by`, `foot_doctor`, `visit_date`, `center_id`, `org_id`) 
		VALUES ( 'Case History','$patient_id', '$image', '$subBy', '$footdoc', '$vid', '$cid', '$org')");
		
	}
	
	public function image_insert_eye($patient_id, $image, $subBy,$vid,$eyedoc,$cid,$org)
	{
		$query = $this->db->query("INSERT INTO `pres_image` (`visit_type`,`patient_id`, `image_name`, `submitted_by`, `eye_doctor`, `visit_date`, `center_id`, `org_id`) 
		VALUES ( 'Case History','$patient_id', '$image', '$subBy', '$eyedoc', '$vid', '$cid', '$org')");
		
	}
	
	public function image_update($patient_id, $name)
	{
		$query = $this->db->query("update  `pres_image`
				set insert_status = 'YES' , 
				insert_by = '$name'
				where patient_id = '$patient_id' and visit_type = 'Case History'");
		
	}
	public function image_lock_status($patient_id)
	{
		$query = $this->db->query("SELECT locked_by FROM `pres_image`
		where patient_id = '$patient_id' and visit_type = 'Case History'");
		return $query->row_array();
	}
	
	public function image_number()
	{
		$query = $this->db->query("SELECT id FROM `pres_image`");
		return $query->num_rows();
	}
	public function lock_image($patient_id,$name)
	{
		$query = $this->db->query("update  `pres_image`
				set locked_by = '$name' 
				where patient_id = '$patient_id' and visit_type = 'Case History'");
		
	}
	
	public function patientDetailImage($pid)
	{
		
		$query = $this->db->query("SELECT patient_entryid , patient_name FROM `starter_patients`
			where patient_id = '$pid'");
		return $query->row_array();
		
	}
	
	public function check_visit_exist($visit_id, $entryid, $patient_id)
	{
		$query = $this->db->query("SELECT visit_id, visit_form_version 
								   FROM starter_patient_visit 
								   WHERE starter_patient_visit.visit_id='$visit_id' 
								   AND starter_patient_visit.visit_entryid='$entryid' 
								   AND starter_patient_visit.visit_patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}
	public function check_lab_exist($visit_id, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_additional
			where labinvs_visit_id = '$visit_id' and labinvs_name = '$name'");
		return $query->row_array();
	}
	
	public function get_entryid($patient_id)
	{
		$query = $this->db->query("SELECT patient_entryid FROM starter_patients WHERE starter_patients.patient_id='$patient_id' LIMIT 1");
		$result = $query->row_array();
		return $result['patient_entryid'];
	}
	
	public function save_visit_information($data)
	{
		$this->db->insert('starter_patient_visit', $data);
	}
	
	public function save_diabetes_history($data)
	{
		$this->db->insert('starter_visit_diabetes_histories', $data);
	}
	
	public function update_visit_information($data, $visit_id, $patient_id)
	{
		$this->db->where('visit_id', $visit_id);
		$this->db->where('visit_patient_id', $patient_id);
		$this->db->update('starter_patient_visit', $data);
	}
	public function update_visit_laboratory_investigation_main($data, $visit_id, $patient_id)
	{
		$this->db->where('labinvs_visit_id', $visit_id);
		$this->db->where('labinvs_patient_id', $patient_id);
		$this->db->update('starter_visit_laboratory_main', $data);
	}
	public function update_visit_laboratory_investigation_additional($data, $visit_id, $patient_id,$labinv_name)
	{
		$this->db->where('labinvs_visit_id', $visit_id);
		$this->db->where('labinvs_patient_id', $patient_id);
		$this->db->where('labinvs_name', $labinv_name);
		$this->db->update('starter_visit_laboratory_additional', $data);
	}
	
	public function save_visit_general_examination($data)
	{
		$this->db->insert('starter_visit_general_examinations_new', $data);
	}
	public function update_general_information($data, $visit_id, $patient_id)
	{
		$this->db->where('generalexam_visit_id', $visit_id);
		$this->db->where('generalexam_patient_id', $patient_id);
		$this->db->update('starter_visit_general_examinations_new', $data);
	}
	
	public function delete_visit_general_examination($visit_id, $patient_id)
	{
		$this->db->where('generalexam_visit_id', $visit_id);
		$this->db->where('generalexam_patient_id', $patient_id);
		$this->db->delete('starter_visit_general_examinations');
	}
	
	public function save_visit_laboratory_investigation($data)
	{
		$this->db->insert('starter_visit_laboratory_additional', $data);
	}
	public function save_visit_laboratory_investigation_main($data)
	{
		$this->db->insert('starter_visit_laboratory_main', $data);
	}
	function case_history($patient_id)
{
	$CI =& get_instance();
	$query = $CI->db->query("SELECT visit_id FROM starter_patient_visit WHERE visit_patient_id='$patient_id' and visit_is = 'CASE_HISTORY'");
	$result = $query->row_array();
	return $result;
}
	
	public function delete_visit_laboratory_investigation($visit_id, $patient_id)
	{
		$this->db->where('labinvs_visit_id', $visit_id);
		$this->db->where('labinvs_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_investigations');
	}
	
	public function save_visit_laboratory_ecg($data)
	{
		$this->db->insert('starter_visit_laboratory_ecg', $data);
	}
	
	public function save_visit_laboratory_usg($data)
	{
		$this->db->insert('starter_visit_laboratory_usg', $data);
	}
	
	public function save_foot_exam_info($data)
	{
		$this->db->insert('starter_visit_foot_examinations', $data);
	}
	
	public function save_foot_exam_periferal_info($data)
	{
		$this->db->insert('starter_visit_foot_examinations_periferals', $data);
	}
	
	public function save_foot_exam_sensation_info($data)
	{
		$this->db->insert('starter_visit_foot_examinations_sensation', $data);
	}
	
	public function delete_visit_laboratory_ecg($visit_id, $patient_id)
	{
		$this->db->where('ecg_visit_id', $visit_id);
		$this->db->where('ecg_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_ecg');
	}
	
	public function save_visit_complication($data)
	{
		$this->db->insert('starter_visit_complication', $data);
	}
	
	public function save_visit_acute_complication($data)
	{
		$this->db->insert('starter_visit_acute_complication', $data);
	}
	
	public function delete_visit_complication($visit_id, $patient_id)
	{
		$this->db->where('vcomplication_visit_id', $visit_id);
		$this->db->where('vcomplication_patient_id', $patient_id);
		$this->db->delete('starter_visit_complication');
	}
	
	public function delete_visit_acute_complication($visit_id, $patient_id)
	{
		$this->db->where('vcomplication_visit_id', $visit_id);
		$this->db->where('vcomplication_patient_id', $patient_id);
		$this->db->delete('starter_visit_acute_complication');
	}
	
	public function save_visit_personal_habits($data)
	{
		$this->db->insert('starter_visit_personal_habits', $data);
	}
	
	public function delete_visit_personal_habits($visit_id, $patient_id)
	{
		$this->db->where('phabit_visit_id', $visit_id);
		$this->db->where('phabit_patient_id', $patient_id);
		$this->db->delete('starter_visit_personal_habits');
	}
	
	public function save_visit_family_history($data)
	{
		$this->db->insert('starter_visit_family_history', $data);
	}
	
	public function delete_visit_family_history($visit_id, $patient_id)
	{
		$this->db->where('fmhistory_visit_id', $visit_id);
		$this->db->where('fmhistory_patient_id', $patient_id);
		$this->db->delete('starter_visit_family_history');
	}
	
	public function save_visit_dietary_history($data)
	{
		$this->db->insert('starter_visit_dietary_history', $data);
	}
	
	public function save_visit_prev_diatory_history($data)
	{
		$this->db->insert('starter_prvadv_dietary_history', $data);
	}
	
	public function delete_visit_prev_diatory_history($visit_id, $patient_id)
	{
		$this->db->where('diehist_visit_id', $visit_id);
		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_dietary_history');
	}
	
	public function save_visit_crnt_diatory_history($data)
	{
		$this->db->insert('starter_crntadv_dietary_history', $data);
	}
	
	public function delete_visit_crnt_diatory_history($visit_id, $patient_id)
	{
		$this->db->where('diehist_visit_id', $visit_id);
		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_dietary_history');
	}
	
	public function save_visit_prev_cookingoil($data)
	{
		$this->db->insert('starter_prvadv_cooking_oil', $data);
	}
	
	public function delete_visit_prev_cookingoil($visit_id, $patient_id)
	{
		$this->db->where('cooking_oil_visit_id', $visit_id);
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_cooking_oil');
	}
	
	public function save_visit_crnt_cookingoil($data)
	{
		$this->db->insert('starter_crntadv_cooking_oil', $data);
	}
	
	public function delete_visit_crnt_cookingoil($visit_id, $patient_id)
	{
		$this->db->where('cooking_oil_visit_id', $visit_id);
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_cooking_oil');
	}
	
	public function save_visit_phisical_actitivites($data)
	{
		$this->db->insert('starter_visit_physical_activities', $data);
	}
	
	public function save_visit_eye_exam_info($data)
	{
		$this->db->insert('starter_visit_eye_examinations', $data);
	}
	
	public function save_visit_drug_history($data)
	{
		$this->db->insert('starter_visit_drug_histories', $data);
	}
	
	public function save_final_treatment_infos($data)
	{
		$this->db->insert('starter_visit_final_treatment_infos', $data);
	}
	
	public function save_visitprev_phisical_actitivites($data)
	{
		$this->db->insert('starter_prvadv_physical_activity', $data);
	}
	
	public function delete_visitprev_phisical_actitivites($visit_id, $patient_id)
	{
		$this->db->where('physical_act_visit_id', $visit_id);
		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_physical_activity');
	}
	
	public function save_visitcrnt_phisical_actitivites($data)
	{
		$this->db->insert('starter_crntadv_physical_activity', $data);
	}
	
	public function delete_visitcrnt_phisical_actitivites($visit_id, $patient_id)
	{
		$this->db->where('physical_act_visit_id', $visit_id);
		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_physical_activity');
	}
	
	public function save_visitcrnt_insuline($data)
	{
		$this->db->insert('starter_crntadv_insulin', $data);
	}
	
	public function save_visitprev_oads($data)
	{
		$this->db->insert('starter_prvomedication_oads', $data);
	}
	
	public function delete_visitprev_oads($visit_id, $patient_id)
	{
		$this->db->where('oads_visit_id', $visit_id);
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_oads');
	}
	
	public function save_visitcrnt_oads($data)
	{
		$this->db->insert('starter_crntomedication_oads', $data);
	}
	
	public function delete_visitcrnt_oads($visit_id, $patient_id)
	{
		$this->db->where('oads_visit_id', $visit_id);
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_oads');
	}
	
	public function save_visitprev_insulin($data)
	{
		$this->db->insert('starter_prvomedication_insulin', $data);
	}
	
	public function delete_visitprev_insulin($visit_id, $patient_id)
	{
		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_insulin');
	}
	
	public function save_visitcrnt_insulin($data)
	{
		$this->db->insert('starter_crntomedication_insulin', $data);
	}
	
	public function delete_visitcrnt_insulin($visit_id, $patient_id)
	{
		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_insulin');
	}
	
	public function save_visitprev_anti_htn($data)
	{
		$this->db->insert('starter_prvomedication_anti_htn', $data);
	}
	
	public function delete_visitprev_anti_htn($visit_id, $patient_id)
	{
		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_htn');
	}
	
	public function save_visitcrnt_anti_htn($data)
	{
		$this->db->insert('starter_crntomedication_anti_htn', $data);
	}
	
	public function delete_visitcrnt_anti_htn($visit_id, $patient_id)
	{
		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_htn');
	}
	
	public function save_visitprev_anti_lipids($data)
	{
		$this->db->insert('starter_prvomedication_anti_lipids', $data);
	}
	
	public function delete_visitprev_anti_lipids($visit_id, $patient_id)
	{
		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_lipids');
	}
	
	public function save_visitcrnt_anti_lipids($data)
	{
		$this->db->insert('starter_crntomedication_anti_lipids', $data);
	}
	
	public function delete_visitcrnt_anti_lipids($visit_id, $patient_id)
	{
		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_lipids');
	}
	
	public function save_visitprev_anti_obesity($data)
	{
		$this->db->insert('starter_prvomedication_anti_obesity', $data);
	}
	
	public function delete_visitprev_anti_obesity($visit_id, $patient_id)
	{
		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_obesity');
	}
	
	public function save_visitcrnt_anti_obesity($data)
	{
		$this->db->insert('starter_crntomedication_anti_obesity', $data);
	}
	
	public function delete_visitcrnt_anti_obesity($visit_id, $patient_id)
	{
		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_obesity');
	}
	
	public function save_visitprev_antiplatelets($data)
	{
		$this->db->insert('starter_prvomedication_antiplatelets', $data);
	}
	
	public function delete_visitprev_antiplatelets($visit_id, $patient_id)
	{
		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_antiplatelets');
	}
	
	public function save_visitcrnt_antiplatelets($data)
	{
		$this->db->insert('starter_crntomedication_antiplatelets', $data);
	}
	
	public function delete_visitcrnt_antiplatelets($visit_id, $patient_id)
	{
		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_antiplatelets');
	}
	
	public function save_visitprev_cardiac_medication($data)
	{
		$this->db->insert('starter_prvomedication_cardiac_medication', $data);
	}
	
	public function delete_visitprev_cardiac_medication($visit_id, $patient_id)
	{
		$this->db->where('cardiac_medication_visit_id', $visit_id);
		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_cardiac_medication');
	}
	
	public function save_visitcrnt_cardiac_medication($data)
	{
		$this->db->insert('starter_crntomedication_cardiac_medication', $data);
	}
	
	public function delete_visitcrnt_cardiac_medication($visit_id, $patient_id)
	{
		$this->db->where('cardiac_medication_visit_id', $visit_id);
		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_cardiac_medication');
	}
	
	public function save_visitprev_omedication_other($data)
	{
		$this->db->insert('starter_prvomedication_other', $data);
	}
	
	public function delete_visitprev_omedication_other($visit_id, $patient_id)
	{
		$this->db->where('other_visit_id', $visit_id);
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_other');
	}
	
	public function save_visitcrnt_omedication_other($data)
	{
		$this->db->insert('starter_crntomedication_others', $data);
	}
	
	public function delete_visitcrnt_omedication_other($visit_id, $patient_id)
	{
		$this->db->where('other_visit_id', $visit_id);
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_others');
	}
	
	public function get_todaytotal_items($date)
	{
		$query = $this->db->query("SELECT COUNT(visit_id) AS total_records FROM starter_patient_visit WHERE visit_admit_date LIKE '%$date%'");
		$result = $query->row_array();
		if($result['total_records'])
		{
			return intval($result['total_records']) + 1;
		}else{
			return 1;
		}
	}
	
	public function get_all_visits($params=array())
	{
		$patient_id = $params['patient_id'];
		$query = "SELECT starter_patient_visit.*, starter_visit_payments.*, orgcenter_name,starter_visit_diabetes_histories.dhistory_duration_of_glucose FROM starter_patient_visit
				  
				  LEFT JOIN starter_visit_diabetes_histories ON
				  starter_visit_diabetes_histories.dhistory_visit_id=starter_patient_visit.visit_id
				  LEFT JOIN starter_centers ON
				  starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
				  
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		$query .= "WHERE starter_patient_visit.visit_patient_id='$patient_id' ";
		
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}
	
	
	
	public function check_visit($visit_id, $patient_id, $visit_entryid)
	{
		$query = $this->db->query("SELECT visit_id, visit_form_version,visit_date FROM starter_patient_visit WHERE starter_patient_visit.visit_id='$visit_id' AND starter_patient_visit.visit_patient_id='$patient_id' AND starter_patient_visit.visit_entryid='$visit_entryid' LIMIT 1");
		return $query->row_array();
	}
	
	public function check_visit_image($date ,$pid)
	{
		$query = $this->db->query("SELECT * FROM `pres_image` where patient_id = '$pid' and visit_date = '$date'");
		return $query->result_array();
	}
	
	public function get_a_visit($visit_id,$patient_id)
	{
		$query = $this->db->query("SELECT visit_date,visit_doctor,visit_org_centerid FROM starter_patient_visit
			where visit_id = '$visit_id' and visit_patient_id = '$patient_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_complication($params=array())
	{
		$visit_id = $params['visit_id'];
		$patient_id = $params['patient_id'];
		$query = $this->db->query("SELECT * FROM starter_visit_complication
		where vcomplication_visit_id = '$visit_id' and vcomplication_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_general($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations_new
where generalexam_visit_id = '$visit_id' and generalexam_patient_id = '$patient_id'");

		return $query->row_array();
	}
	
	public function get_glucose($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_visit_diabetes_histories
where dhistory_visit_id = '$visit_id' and dhistory_patient_id = '$patient_id'");

		return $query->row_array();
	}
	
	public function get_lab($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_main
		where labinvs_visit_id = '$visit_id' and labinvs_patient_id ='$patient_id'");

		return $query->row_array();
	}
	
	public function get_lab_additional($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_additional
		where labinvs_visit_id = '$visit_id' and labinvs_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_oads_v($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_oads
		where oads_visit_id = '$visit_id' and oads_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_ins($visit_id, $patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_insulin
		where insulin_visit_id = '$visit_id' and insulin_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_anti_htn_v($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn
		where anti_htn_visit_id = '$visit_id' and anti_htn_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_anti_lipid_v($visit_id, $patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids
				where anti_lipid_visit_id = '$visit_id' and anti_lipid_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_antiplatelet($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_antiplatelets
		where antiplatelets_visit_id = '$visit_id' and antiplatelets_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_obesity($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity
		where anti_obesity_visit_id = '$visit_id' and anti_obesity_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_other($visit_id,$patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_crntomedication_others
		where other_visit_id = '$visit_id' and other_patient_id = '$patient_id'");

		return $query->result_array();
	}
	
	public function get_investigation($visit_id, $patient_id)
	{
		
		$query = $this->db->query("SELECT * FROM starter_visit_final_treatment_infos
		where finaltreat_visit_id = '$visit_id' and finaltreat_patient_id = '$patient_id'");

		return $query->row_array();
	}
	public function get_entryid_view($patient_id)
	{
		
		$query = $this->db->query("SELECT patient_entryid FROM starter_patients 
where patient_id = '$patient_id'");

		return $query->row_array();
	}
	public function get_patientinfo($id)
	{
		$query = $this->db->query("SELECT * FROM starter_patients
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
								   WHERE starter_patients.patient_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_foods()
	{
		$query = $this->db->query("SELECT * FROM starter_food_items ORDER BY starter_food_items.food_id ASC");
		return $query->result_array();
	}
	
	public function get_physical_activities()
	{
		$query = $this->db->query("SELECT * FROM starter_physical_activities ORDER BY starter_physical_activities.activity_id ASC");
		return $query->result_array();
	}
	
	public function get_drugs_bysrc($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_dgds WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	public function get_oads($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_oads WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_insulin($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_insuline2 WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_anti_htn($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_anti_htn WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_anti_lipid($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_anti_lipid WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_anti_platelet($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_anti_platelet WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_others($term)
	{
		$query = $this->db->query("SELECT id, brand FROM starter_others WHERE brand LIKE '%$term%' ORDER BY brand ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_registration_centers($term)
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers WHERE orgcenter_name LIKE '%$term%' ORDER BY orgcenter_name ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_visit_centers($term)
	{
		$query = $this->db->query("SELECT orgcenter_name FROM starter_centers WHERE orgcenter_name LIKE '%$term%' ORDER BY orgcenter_name ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function load_doctors($term)
	{
		$query = $this->db->query("SELECT doctor_id, doctor_full_name FROM starter_doctors WHERE doctor_full_name LIKE '%$term%' ORDER BY doctor_full_name ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function load_doctors_with_center_wise($term, $center_id)
	{
		//$center_id = $this->session->userdata('user_org_center_id');
		$query = $this->db->query("SELECT doctor_id, doctor_full_name 
								   FROM starter_doctors 
								   WHERE doctor_full_name LIKE '%$term%' 
								   AND doctor_org_centerid='$center_id'
								   ORDER BY doctor_full_name ASC LIMIT 20");
		return $query->result_array();
	}
	
	public function get_drug_info($term)
	{
		$query = $this->db->query("SELECT 
								   starter_dgds.id, 
								   starter_dgds.brand, 
								   starter_dgds.generic, 
								   starter_pharmaceuticals.company_name
								   FROM starter_dgds
								   LEFT JOIN starter_pharmaceuticals ON
								   starter_pharmaceuticals.company_id=starter_dgds.company
								   WHERE brand='$term' 
								   LIMIT 1
								  ");
		return $query->row_array();
	}
	
	public function get_insulin_info($term)
	{
		$query = $this->db->query("SELECT insuline_company, insuline_generic 
								   FROM starter_insuline
								   WHERE insuline_brand LIKE '%$term%' 
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function visit_patient_information($patient_id)
	{
		$query = $this->db->query("SELECT starter_patients.*, starter_centers.orgcenter_name FROM starter_patients 
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
								   WHERE starter_patients.patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}	
	
	public function visit_information($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_patient_visit 
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
								   
								   WHERE starter_patient_visit.visit_id='$visit_id' AND starter_patient_visit.visit_patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function menstrual_information($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_menstrual_cycle WHERE starter_visit_menstrual_cycle.menstrlc_visit_id='$visit_id' AND starter_visit_menstrual_cycle.menstrlc_patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function obstetric_history($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_obstetric_history WHERE starter_visit_obstetric_history.obstetric_visit_id='$visit_id' AND starter_visit_obstetric_history.obstetric_patient_id='$patient_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function visit_general_examinations($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations_new WHERE starter_visit_general_examinations_new.generalexam_visit_id='$visit_id' AND starter_visit_general_examinations_new.generalexam_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function visit_general_examinations_old($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations WHERE starter_visit_general_examinations.generalexam_visit_id='$visit_id' AND starter_visit_general_examinations.generalexam_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_oads($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_oads WHERE starter_prvomedication_oads.oads_visit_id='$visit_id' AND starter_prvomedication_oads.oads_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_insulins($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_insulin WHERE starter_prvomedication_insulin.insulin_visit_id='$visit_id' AND starter_prvomedication_insulin.insulin_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_antihtns($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_htn WHERE starter_prvomedication_anti_htn.anti_htn_visit_id='$visit_id' AND starter_prvomedication_anti_htn.anti_htn_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_antilipids($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_lipids WHERE starter_prvomedication_anti_lipids.anti_lipid_visit_id='$visit_id' AND starter_prvomedication_anti_lipids.anti_lipid_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_antiplatelets($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_antiplatelets WHERE starter_prvomedication_antiplatelets.antiplatelets_visit_id='$visit_id' AND starter_prvomedication_antiplatelets.antiplatelets_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_cardiacmedications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_cardiac_medication WHERE starter_prvomedication_cardiac_medication.cardiac_medication_visit_id='$visit_id' AND starter_prvomedication_cardiac_medication.cardiac_medication_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_antiobesities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_obesity WHERE starter_prvomedication_anti_obesity.anti_obesity_visit_id='$visit_id' AND starter_prvomedication_anti_obesity.anti_obesity_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_medication_others($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_other WHERE starter_prvomedication_other.other_visit_id='$visit_id' AND starter_prvomedication_other.other_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	/*******Current Advice Medication******/
	public function crnt_medication_oads($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_oads WHERE starter_crntomedication_oads.oads_visit_id='$visit_id' AND starter_crntomedication_oads.oads_patient_id='$patient_id' ORDER BY oads_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_insulins($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_insulin WHERE starter_crntomedication_insulin.insulin_visit_id='$visit_id' AND starter_crntomedication_insulin.insulin_patient_id='$patient_id' ORDER BY insulin_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_antihtns($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn WHERE starter_crntomedication_anti_htn.anti_htn_visit_id='$visit_id' AND starter_crntomedication_anti_htn.anti_htn_patient_id='$patient_id' ORDER BY anti_htn_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_antilipids($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids WHERE starter_crntomedication_anti_lipids.anti_lipid_visit_id='$visit_id' AND starter_crntomedication_anti_lipids.anti_lipid_patient_id='$patient_id' ORDER BY anti_lipid_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_antiplatelets($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_antiplatelets WHERE starter_crntomedication_antiplatelets.antiplatelets_visit_id='$visit_id' AND starter_crntomedication_antiplatelets.antiplatelets_patient_id='$patient_id' ORDER BY antiplatelets_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_cardiacmedications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_cardiac_medication WHERE starter_crntomedication_cardiac_medication.cardiac_medication_visit_id='$visit_id' AND starter_crntomedication_cardiac_medication.cardiac_medication_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_antiobesities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity WHERE starter_crntomedication_anti_obesity.anti_obesity_visit_id='$visit_id' AND starter_crntomedication_anti_obesity.anti_obesity_patient_id='$patient_id' ORDER BY anti_obesity_id ASC");
		return $query->result_array();
	}

	public function crnt_medication_others($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_others WHERE starter_crntomedication_others.other_visit_id='$visit_id' AND starter_crntomedication_others.other_patient_id='$patient_id' ORDER BY other_id ASC");
		return $query->result_array();
	}
	
	public function visit_laboratory_investigations($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_additional WHERE starter_visit_laboratory_additional.labinvs_visit_id='$visit_id' AND starter_visit_laboratory_additional.labinvs_patient_id='$patient_id'");
		return $query->result_array();
	}	
	public function visit_laboratory_investigations_old($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_investigations WHERE starter_visit_laboratory_investigations.labinvs_visit_id='$visit_id' AND starter_visit_laboratory_investigations.labinvs_patient_id='$patient_id'");
		return $query->result_array();
	}	
	public function visit_laboratory_main($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_main WHERE starter_visit_laboratory_main.labinvs_visit_id='$visit_id' AND starter_visit_laboratory_main.labinvs_patient_id='$patient_id'");
		return $query->row_array();
	}	
	
	public function visit_laboratory_ecg($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_ecg WHERE starter_visit_laboratory_ecg.ecg_visit_id='$visit_id' AND starter_visit_laboratory_ecg.ecg_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function visit_laboratory_usg($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_usg WHERE usg_visit_id='$visit_id' AND usg_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function visit_complications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_complication WHERE starter_visit_complication.vcomplication_visit_id='$visit_id' AND starter_visit_complication.vcomplication_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function visit_acute_complications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_acute_complication WHERE starter_visit_acute_complication.vcomplication_visit_id='$visit_id' AND starter_visit_acute_complication.vcomplication_patient_id='$patient_id'");
		return $query->result_array();
	}	
	
	public function visit_personal_habits($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_personal_habits WHERE starter_visit_personal_habits.phabit_visit_id='$visit_id' AND starter_visit_personal_habits.phabit_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function visit_family_history($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_family_history WHERE starter_visit_family_history.fmhistory_visit_id='$visit_id' AND starter_visit_family_history.fmhistory_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_diatory_history($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_dietary_history WHERE starter_prvadv_dietary_history.diehist_visit_id='$visit_id' AND starter_prvadv_dietary_history.diehist_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function get_visit_diatory_histories($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_dietary_history WHERE diehist_visit_id='$visit_id' AND diehist_patient_id='$patient_id' ORDER BY diehist_id ASC");
		return $query->result_array();
	}
	
	public function prev_cooking_oil($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_cooking_oil WHERE starter_prvadv_cooking_oil.cooking_oil_visit_id='$visit_id' AND starter_prvadv_cooking_oil.cooking_oil_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_phisical_activities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_physical_activity WHERE starter_prvadv_physical_activity.physical_act_visit_id='$visit_id' AND starter_prvadv_physical_activity.physical_act_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function get_visit_phisical_activities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_physical_activities WHERE physical_act_visit_id='$visit_id' AND physical_act_patient_id='$patient_id' ORDER BY physical_act_id ASC");
		return $query->result_array();
	}
	
	public function get_visit_managements($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_management WHERE starter_visit_management.management_visit_id='$visit_id' AND starter_visit_management.management_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function visit_diagonosis($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_diagonosis WHERE starter_visit_diagonosis.diagonosis_visit_id='$visit_id' AND starter_visit_diagonosis.diagonosis_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function get_visit_payments($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_payments WHERE starter_visit_payments.payment_visit_id='$visit_id' AND starter_visit_payments.payment_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function get_visit_exercise($visit_id, $patient_id, $management_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_exercise WHERE starter_visit_exercise.exercise_visit_id='$visit_id' AND starter_visit_exercise.exercise_patient_id='$patient_id' AND starter_visit_exercise.exercise_management_id='$management_id'");
		return $query->result_array();
	}
	
	public function drug_company_info($company_id)
	{
		$query = $this->db->query("SELECT * FROM starter_pharmaceuticals WHERE starter_pharmaceuticals.company_id='$company_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function prev_other_oads($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_oads WHERE oads_visit_id='$visit_id' AND oads_patient_id='$patient_id' ORDER BY oads_id ASC");
		return $query->result_array();
	}
	
	public function crnt_other_oads($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_oads WHERE oads_visit_id='$visit_id' AND oads_patient_id='$patient_id' ORDER BY oads_id ASC");
		return $query->result_array();
	}
	
	public function prev_other_insuline($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_insulin WHERE insulin_visit_id='$visit_id' AND insulin_patient_id='$patient_id' ORDER BY insulin_id ASC");
		return $query->result_array();
	}
	
	public function crnt_other_insuline($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_insulin WHERE insulin_visit_id='$visit_id' AND insulin_patient_id='$patient_id' ORDER BY insulin_id ASC");
		return $query->result_array();
	}
	
	public function prev_other_antihtn($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_htn WHERE starter_prvomedication_anti_htn.anti_htn_visit_id='$visit_id' AND starter_prvomedication_anti_htn.anti_htn_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_other_antilipids($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_lipids WHERE starter_prvomedication_anti_lipids.anti_lipid_visit_id='$visit_id' AND starter_prvomedication_anti_lipids.anti_lipid_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_other_antiplatelets($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_antiplatelets WHERE antiplatelets_visit_id='$visit_id' AND antiplatelets_patient_id='$patient_id' ORDER BY antiplatelets_id ASC");
		return $query->result_array();
	}
	
	public function crnt_other_antiplatelets($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_antiplatelets WHERE antiplatelets_visit_id='$visit_id' AND antiplatelets_patient_id='$patient_id' ORDER BY antiplatelets_id ASC");
		return $query->result_array();
	}
	
	public function prev_other_antiobesity($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_obesity WHERE starter_prvomedication_anti_obesity.anti_obesity_visit_id='$visit_id' AND starter_prvomedication_anti_obesity.anti_obesity_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_other_aspirine($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_aspirin WHERE starter_prvomedication_aspirin.aspirin_visit_id='$visit_id' AND starter_prvomedication_aspirin.aspirin_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function prev_other_medic_other($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_other WHERE starter_prvomedication_other.other_visit_id='$visit_id' AND starter_prvomedication_other.other_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	
	public function crnt_other_antihtn($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn WHERE starter_crntomedication_anti_htn.anti_htn_visit_id='$visit_id' AND starter_crntomedication_anti_htn.anti_htn_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_other_antilipids($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids WHERE starter_crntomedication_anti_lipids.anti_lipid_visit_id='$visit_id' AND starter_crntomedication_anti_lipids.anti_lipid_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_other_antiobesity($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity WHERE starter_crntomedication_anti_obesity.anti_obesity_visit_id='$visit_id' AND starter_crntomedication_anti_obesity.anti_obesity_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_other_aspirine($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_aspirin WHERE starter_crntomedication_aspirin.aspirin_visit_id='$visit_id' AND starter_crntomedication_aspirin.aspirin_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_other_medic_other($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_others WHERE starter_crntomedication_others.other_visit_id='$visit_id' AND starter_crntomedication_others.other_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	
	public function crnt_diatory_history($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_dietary_history WHERE starter_crntadv_dietary_history.diehist_visit_id='$visit_id' AND starter_crntadv_dietary_history.diehist_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_cooking_oil($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_cooking_oil WHERE starter_crntadv_cooking_oil.cooking_oil_visit_id='$visit_id' AND starter_crntadv_cooking_oil.cooking_oil_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function crnt_phisical_activities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_physical_activity WHERE starter_crntadv_physical_activity.physical_act_visit_id='$visit_id' AND starter_crntadv_physical_activity.physical_act_patient_id='$patient_id'");
		return $query->result_array();
	}	
	
	public function crnt_insulins($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * 
								   FROM starter_crntadv_insulin
								   LEFT JOIN starter_insuline ON
								   starter_insuline.insuline_id=starter_crntadv_insulin.insulin_type_id
								   WHERE starter_crntadv_insulin.insulin_visit_id='$visit_id' 
								   AND starter_crntadv_insulin.insulin_patient_id='$patient_id'
								  ");
		return $query->result_array();
	}
	
	public function save_mestrual_info($data)
	{
		$this->db->insert('starter_visit_menstrual_cycle', $data);
	}
	
	public function delete_mestrual_info($visit_id, $patient_id)
	{
		$this->db->where('menstrlc_visit_id', $visit_id);
		$this->db->where('menstrlc_patient_id', $patient_id);
		$this->db->delete('starter_visit_menstrual_cycle');
	}
	
	public function save_obstetric_history($data)
	{
		$this->db->insert('starter_visit_obstetric_history', $data);
	}
	
	public function delete_obstetric_history($visit_id, $patient_id)
	{
		$this->db->where('obstetric_visit_id', $visit_id);
		$this->db->where('obstetric_patient_id', $patient_id);
		$this->db->delete('starter_visit_obstetric_history');
	}
	
	public function save_management_data($data)
	{
		$this->db->insert('starter_visit_management', $data);
	}
	
	public function delete_management_data($visit_id, $patient_id)
	{
		$this->db->where('management_visit_id', $visit_id);
		$this->db->where('management_patient_id', $patient_id);
		$this->db->delete('starter_visit_management');
	}
	
	public function save_exercise_data($data)
	{
		$this->db->insert('starter_visit_exercise', $data);
	}
	
	public function delete_exercise_data($visit_id, $patient_id)
	{
		$this->db->where('exercise_visit_id', $visit_id);
		$this->db->where('exercise_patient_id', $patient_id);
		$this->db->delete('starter_visit_exercise');
	}
	
	public function save_diagonosis_data($data)
	{
		$this->db->insert('starter_visit_diagonosis', $data);
	}
	
	public function delete_diagonosis_data($visit_id, $patient_id)
	{
		$this->db->where('diagonosis_visit_id', $visit_id);
		$this->db->where('diagonosis_patient_id', $patient_id);
		$this->db->delete('starter_visit_diagonosis');
	}
	
	public function save_payment_data($data)
	{
		$this->db->insert('starter_visit_payments', $data);
	}
	
	public function delete_payment_data($visit_id, $patient_id)
	{	
		$this->db->where('payment_visit_id', $visit_id);
		$this->db->where('payment_patient_id', $patient_id);
		$this->db->delete('starter_visit_payments');
	}
	
	public function get_receipt_information($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_patient_visit
								   LEFT JOIN starter_visit_payments ON
								   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
								   LEFT JOIN starter_patients ON
								   starter_patients.patient_id=starter_patient_visit.visit_patient_id
								   WHERE starter_patient_visit.visit_id='$visit_id'
								   AND starter_patient_visit.visit_patient_id='$patient_id'
								   LIMIT 1
								");
		return $query->row_array();
	}
	
	public function get_count_of_patient_visits($patient_id)
	{
		$query = $this->db->query("SELECT COUNT(visit_id) AS total_records FROM starter_patient_visit WHERE visit_patient_id='$patient_id'");
		$result = $query->row_array();
		if($result['total_records'])
		{
			return $result['total_records'];
		}else{
			return 0;
		}			
	}
	
	public function get_final_treatment_info($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_final_treatment_infos WHERE finaltreat_patient_id='$patient_id' AND finaltreat_visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_drug_history_info($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_drug_histories WHERE drughistory_patient_id='$patient_id' AND drughistory_visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_diabetes_history($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_diabetes_histories WHERE dhistory_patient_id='$patient_id' AND dhistory_visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_eye_examination($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_eye_examinations WHERE eyeexam_patient_id='$patient_id' AND eyeexam_visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_foot_examination($visit_id, $patient_id, $type='examinations')
	{
		if($type == 'examinations')
		{
			$query_1 = $this->db->query("SELECT * FROM starter_visit_foot_examinations WHERE footexm_patient_id='$patient_id' AND footexm_visit_id='$visit_id' LIMIT 1");
			return $query_1->row_array();
		}
		
		if($type == 'periferals')
		{
			$query_2 = $this->db->query("SELECT * FROM starter_visit_foot_examinations_periferals WHERE footexmprfl_patient_id='$patient_id' AND footexmprfl_visit_id='$visit_id' LIMIT 1");
			return $query_2->row_array();
		}
		
		if($type == 'sensation')
		{
			$query_3 = $this->db->query("SELECT * FROM starter_visit_foot_examinations_sensation WHERE footexmsns_patient_id='$patient_id' AND footexmsns_visit_id='$visit_id' LIMIT 1");
			return $query_3->row_array();
		}
	}
	
	public function get_visit_complications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_complication WHERE vcomplication_patient_id='$patient_id' AND vcomplication_visit_id='$visit_id' ORDER BY vcomplication_id ASC");
		return $query->result_array();
	}
	
	public function get_visit_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_patient_visit
								   
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patient_visit.visit_org_centerid
								   
								   WHERE visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_personal_habit_info($visit_id)
	{
		$habits = array();
		$query = $this->db->query("SELECT phabit_name FROM starter_visit_personal_habits
								   WHERE phabit_visit_id='$visit_id' ORDER BY phabit_id ASC");
		$results = $query->result_array();
		foreach($results as $result)
		{
			$habits[] = $result['phabit_name'];
		}
		
		return $habits;
	}
	
	public function get_visit_family_history_info($visit_id)
	{
		$habits = array();
		$query = $this->db->query("SELECT fmhistory_name FROM starter_visit_family_history
								   WHERE fmhistory_visit_id='$visit_id' ORDER BY fmhistory_id ASC");
		$results = $query->result_array();
		foreach($results as $result)
		{
			$habits[] = $result['fmhistory_name'];
		}
		
		return $habits;
	}
	
	public function get_visit_diabetes_history_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_diabetes_histories
								   WHERE dhistory_visit_id='$visit_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_diabetes_history_complication_info($visit_id)
	{
		$habits = array();
		$query = $this->db->query("SELECT vcomplication_name FROM starter_visit_complication
								   WHERE vcomplication_visit_id='$visit_id' ORDER BY vcomplication_id ASC");
		$results = $query->result_array();
		foreach($results as $result)
		{
			$habits[] = $result['vcomplication_name'];
		}
		
		return $habits;
	}
	
	public function get_visit_general_examination_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations_new
								   WHERE generalexam_visit_id='$visit_id' ORDER BY generalexam_id ASC");
		$results = $query->row_array();
		
		return $results;
	}
	
	public function get_visit_general_examination_other($visit_id)
	{
		$query = $this->db->query("SELECT gexamother_content FROM starter_visit_general_examinations_others
								   WHERE gexamother_visit_id='$visit_id' LIMIT 1");
		$results = $query->row_array();
		if($results){
			return $results['gexamother_content'];
		}else{
			return null;
		}
	}
	
	public function get_visit_foot_examination_info($visit_id)
	{
		//Get visit foot examinations
		$query_1 = $this->db->query("SELECT * FROM starter_visit_foot_examinations
								   WHERE footexm_visit_id='$visit_id' LIMIT 1");
		$results_1 = $query_1->row_array();
		
		//Get visit foot examinations periferals
		$query_2 = $this->db->query("SELECT * FROM starter_visit_foot_examinations_periferals
								   WHERE footexmprfl_visit_id='$visit_id' LIMIT 1");
		$results_2 = $query_2->row_array();
		
		//Get visit foot examinations sensation
		$query_3 = $this->db->query("SELECT * FROM starter_visit_foot_examinations_sensation
								   WHERE footexmsns_visit_id='$visit_id' LIMIT 1");
		$results_3 = $query_3->row_array();
		
		$get_result = array(
						'footexm_date'                    => $results_1['footexm_date'],
						'footexm_other_content'           => $results_1['footexm_other_content'],
						'footexm_doctor_name'             => $results_1['footexm_doctor_name'],
						'footexm_doctor_id'               => $results_1['footexm_doctor_id'],
						
						'arteria_dorsalis_predis_present_left' => $results_2['footexmprfl_arteria_dorsalis_predis_present_left'],
						'arteria_dorsalis_predis_present_right' => $results_2['footexmprfl_arteria_dorsalis_predis_present_right'],
						'arteria_dorsalis_predis_absent_left'  => $results_2['footexmprfl_arteria_dorsalis_predis_absent_left'],
						'arteria_dorsalis_predis_absent_right'  => $results_2['footexmprfl_arteria_dorsalis_predis_absent_right'],
						'posterior_tribila_present_left'       => $results_2['footexmprfl_posterior_tribila_present_left'],
						'posterior_tribila_present_right'       => $results_2['footexmprfl_posterior_tribila_present_right'],
						'posterior_tribila_absent_left'        => $results_2['footexmprfl_posterior_tribila_absent_left'],
						'posterior_tribila_absent_right'        => $results_2['footexmprfl_posterior_tribila_absent_right'],
						
						'monofilament_present_left'            => $results_3['footexmsns_monofilament_present_left'],
						'monofilament_present_right'            => $results_3['footexmsns_monofilament_present_right'],
						'monofilament_absent_left'             => $results_3['footexmsns_monofilament_absent_left'],
						'monofilament_absent_right'             => $results_3['footexmsns_monofilament_absent_right'],
						'tuning_fork_present_left'             => $results_3['footexmsns_tuning_fork_present_left'],
						'tuning_fork_present_right'             => $results_3['footexmsns_tuning_fork_present_right'],
						'tuning_fork_absent_left'              => $results_3['footexmsns_tuning_fork_absent_left'],
						'tuning_fork_absent_right'              => $results_3['footexmsns_tuning_fork_absent_right'],
						
					  );
		return $get_result;
	}
	
	public function get_visit_dietary_history_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_dietary_history 
								   WHERE diehist_visit_id='$visit_id'
								   ORDER BY diehist_id ASC");
		return $query->result_array();
	}
	
	public function get_visit_physical_activity_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_physical_activities 
								   WHERE physical_act_visit_id='$visit_id'
								   ORDER BY physical_act_id ASC");
		return $query->result_array();
	}
	
	public function get_visit_eye_examination_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_eye_examinations 
								   WHERE eyeexam_visit_id='$visit_id'
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_laboratory_investigation_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_additional 
								   WHERE labinvs_visit_id='$visit_id'
								   ORDER BY labinvs_id ASC");
		return $query->result_array();
	}
	public function get_visit_laboratory_investigation_main($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_main 
								   WHERE labinvs_visit_id='$visit_id'");
		return $query->row_array();
	}
	
	public function get_visit_general($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations_new 
								   WHERE generalexam_visit_id='$visit_id'");
		return $query->row_array();
	}
	
	public function get_visit_laboratory_investigation_ecg_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_ecg 
								   WHERE ecg_visit_id='$visit_id'
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_laboratory_investigation_usg_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_usg 
								   WHERE usg_visit_id='$visit_id'
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_drug_history_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_drug_histories 
								   WHERE drughistory_visit_id='$visit_id'
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function get_visit_final_treatment_info($visit_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_final_treatment_infos 
								   WHERE finaltreat_visit_id='$visit_id'
								   LIMIT 1");
		return $query->row_array();
	}
	
	public function save_visit_general_other_content($data){
		$this->db->insert('starter_visit_general_examinations_others', $data);
	}
	
	public function delete_old_visit_information($visit_id)
	{
		//Delete visit personal habit
		$this->db->where('phabit_visit_id', $visit_id);
		$this->db->delete('starter_visit_personal_habits');
		
		//Delete visit family history
		$this->db->where('fmhistory_visit_id', $visit_id);
		$this->db->delete('starter_visit_family_history');

		//Delete visit diabetes history
		$this->db->where('dhistory_visit_id', $visit_id);
		$this->db->delete('starter_visit_diabetes_histories');
		//Delete visit complication
		$this->db->where('vcomplication_visit_id', $visit_id);
		$this->db->delete('starter_visit_complication');

		//Delete visit general examination
		$this->db->where('generalexam_visit_id', $visit_id);
		$this->db->delete('starter_visit_general_examinations');
		//Delete visit general examination other content
		$this->db->where('gexamother_visit_id', $visit_id);
		$this->db->delete('starter_visit_general_examinations_others');

		//Delete visit Foot examination
		$this->db->where('footexm_visit_id', $visit_id);
		$this->db->delete('starter_visit_foot_examinations');
		//Delete foot examination periferal pulse
		$this->db->where('footexmprfl_visit_id', $visit_id);
		$this->db->delete('starter_visit_foot_examinations_periferals');
		//Delete foot examination sensation
		$this->db->where('footexmsns_visit_id', $visit_id);
		$this->db->delete('starter_visit_foot_examinations_sensation');

		//Delete visit diatory history
		$this->db->where('diehist_visit_id', $visit_id);
		$this->db->delete('starter_visit_dietary_history');

		//Delete visit phisical activity
		$this->db->where('physical_act_visit_id', $visit_id);
		$this->db->delete('starter_visit_physical_activities');

		//Delete Eye examination
		$this->db->where('eyeexam_visit_id', $visit_id);
		$this->db->delete('starter_visit_eye_examinations');

		//Delete visit laboratory investigation
		$this->db->where('labinvs_visit_id', $visit_id);
		$this->db->delete('starter_visit_laboratory_investigations');
		
		//Delete visit laboratory investigation ECG
		$this->db->where('ecg_visit_id', $visit_id);
		$this->db->delete('starter_visit_laboratory_ecg');
		
		//Delete visit laboratory investigation USG
		$this->db->where('usg_visit_id', $visit_id);
		$this->db->delete('starter_visit_laboratory_usg');

		//Delete Drug History
		$this->db->where('drughistory_visit_id', $visit_id);
		$this->db->delete('starter_visit_drug_histories');
		//Delete Prev OADs
		$this->db->where('oads_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_oads');
		//Delete Prev Insulin
		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_insulin');
		//Delete prev anti htn
		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_anti_htn');
		//Delete prev anti lipids
		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_anti_lipids');
		//Delete prev antiplatelets
		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_antiplatelets');
		//Delete prev anti obesity
		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_anti_obesity');
		//Delete prev other
		$this->db->where('other_visit_id', $visit_id);
		$this->db->delete('starter_prvomedication_other');

		//Delete Save Final Treatment
		$this->db->where('finaltreat_visit_id', $visit_id);
		$this->db->delete('starter_visit_final_treatment_infos');
		//Delete current OADs
		$this->db->where('oads_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_oads');
		//Delete current insulin
		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_insulin');
		//Delete current anti htn
		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_anti_htn');
		//Delete current anti lipids
		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_anti_lipids');
		//Delete current antiplatelets
		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_antiplatelets');
		//Delete current anti obesity
		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_anti_obesity');
		//Delete current other
		$this->db->where('other_visit_id', $visit_id);
		$this->db->delete('starter_crntomedication_others');

		//Delete Save Payments
		$this->db->where('payment_visit_id', $visit_id);
		$this->db->delete('starter_visit_payments');
	}
	
	public function get_visit_no($patient_id)
	{
		$query = $this->db->query("SELECT COUNT(visit_id) AS total_records FROM starter_patient_visit WHERE visit_patient_id='$patient_id'");
		$result = $query->row_array();
		if($result['total_records'])
		{
			return $result['total_records'] + 1;
		}else{
			return 1;
		}
	}
	
	public function get_org_by_centerid($center_id)
	{
		$query = $this->db->query("SELECT orgcenter_org_id FROM starter_centers WHERE orgcenter_id='$center_id'");
		$result = $query->row_array();
		return $result['orgcenter_org_id'];
	}
	
	public function get_investions($src)
	{
		$query = $this->db->query("SELECT inv_id, inv_name FROM starter_lab_investigations where inv_name like '$src%' order by inv_name");
		return $query->result_array();
	}
	
	public function get_all_visit_centers()
	{
		$query = $this->db->query("SELECT visit_visit_center FROM starter_patient_visit");
		return $query->result_array();
	}
	
	
}