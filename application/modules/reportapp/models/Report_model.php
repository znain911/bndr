<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {
	
	public function get_org_info($org_id)
	{
		$query = $this->db->query("SELECT * FROM starter_organizations WHERE starter_organizations.org_id='$org_id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_centers($org_id)
	{
		$query = $this->db->query("SELECT * FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY starter_centers.orgcenter_id ASC");
		return $query->result_array();
	}
	
	public function total_center_patients($orgcenter_id)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE starter_patients.patient_org_centerid='$orgcenter_id'");
		return $query->num_rows();
	}
	
	public function total_center_doctors($orgcenter_id)
	{
		$query = $this->db->query("SELECT doctor_id FROM starter_doctors WHERE starter_doctors.doctor_org_centerid='$orgcenter_id'");
		return $query->num_rows();
	}
	
	public function total_center_visits($orgcenter_id)
	{
		$query = $this->db->query("SELECT visit_id FROM starter_patient_visit WHERE starter_patient_visit.visit_org_centerid='$orgcenter_id'");
		return $query->num_rows();
	}
	
	public function total_patients($orgcenter_id, $type)
	{
		$query = $this->db->query("SELECT patient_id FROM starter_patients WHERE starter_patients.patient_org_centerid='$orgcenter_id'");
		$results = $query->result_array();
		
		//get type
		$count = 0;
		foreach($results as $result):
			$patient_type = $this->check_patient_type($result['patient_id'], $type);
			if($patient_type == 1 || $patient_type > 1)
			{
				$count += 1;
			}
		endforeach;
		
		return $count;
		
		
	}
	
	public function check_patient_type($patient_id, $type)
	{
		$query = $this->db->query("SELECT visit_id FROM starter_patient_visit WHERE starter_patient_visit.visit_patient_id='$patient_id' AND starter_patient_visit.visit_patient_type='$type'");
		$result = $query->num_rows();
		return $result;
	}
	
	public function get_all_visits($params=array())
	{
		$query = "SELECT * FROM starter_patient_visit 
				  LEFT JOIN starter_visit_payments ON
				  starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id ";
		$query .= "ORDER BY starter_patient_visit.visit_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}

public function get_cntr_visits($cntrid)
	{
		$this -> db -> select('*');
		$this -> db -> join('starter_visit_payments', 'starter_visit_payments.payment_visit_id = starter_patient_visit.visit_id', 'left');
		$this -> db -> where( 'starter_patient_visit.visit_registration_center', $cntrid);
		$this -> db -> order_by('starter_patient_visit.visit_id','DESC');
		$this -> db -> from('starter_patient_visit');
		$query = $this->db->get();
		return $query->result_array();
	}






	
	public function get_patientinfo($id)
	{
		$query = $this->db->query("SELECT * FROM starter_patients
								   LEFT JOIN starter_organizations ON
								   starter_organizations.org_id=starter_patients.patient_org_id
								   LEFT JOIN starter_centers ON
								   starter_centers.orgcenter_id=starter_patients.patient_org_centerid
								   WHERE starter_patients.patient_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_first_registration($patient_id)
	{
		$query = $this->db->query("SELECT visit_date FROM starter_patient_visit WHERE starter_patient_visit.visit_patient_id='$patient_id' ORDER BY visit_id ASC LIMIT 1");
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
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations WHERE starter_visit_general_examinations.generalexam_visit_id='$visit_id' AND starter_visit_general_examinations.generalexam_patient_id='$patient_id'");
		return $query->result_array();
	}
	
	public function visit_laboratory_investigations($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_investigations WHERE starter_visit_laboratory_investigations.labinvs_visit_id='$visit_id' AND starter_visit_laboratory_investigations.labinvs_patient_id='$patient_id'");
		return $query->result_array();
	}	
	
	public function visit_laboratory_ecg($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_ecg WHERE starter_visit_laboratory_ecg.ecg_visit_id='$visit_id' AND starter_visit_laboratory_ecg.ecg_patient_id='$patient_id'");
		return $query->row_array();
	}
	public function visit_complications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_complication WHERE starter_visit_complication.vcomplication_visit_id='$visit_id' AND starter_visit_complication.vcomplication_patient_id='$patient_id'");
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
	
	public function prev_cooking_oil($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_cooking_oil WHERE starter_prvadv_cooking_oil.cooking_oil_visit_id='$visit_id' AND starter_prvadv_cooking_oil.cooking_oil_patient_id='$patient_id'");
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
		$query = $this->db->query("SELECT * FROM starter_crntomedication_oads WHERE starter_crntomedication_oads.oads_visit_id='$visit_id' AND starter_crntomedication_oads.oads_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_insulins($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_insulin WHERE starter_crntomedication_insulin.insulin_visit_id='$visit_id' AND starter_crntomedication_insulin.insulin_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_antihtns($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn WHERE starter_crntomedication_anti_htn.anti_htn_visit_id='$visit_id' AND starter_crntomedication_anti_htn.anti_htn_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_antilipids($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids WHERE starter_crntomedication_anti_lipids.anti_lipid_visit_id='$visit_id' AND starter_crntomedication_anti_lipids.anti_lipid_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_antiplatelets($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_antiplatelets WHERE starter_crntomedication_antiplatelets.antiplatelets_visit_id='$visit_id' AND starter_crntomedication_antiplatelets.antiplatelets_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_cardiacmedications($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_cardiac_medication WHERE starter_crntomedication_cardiac_medication.cardiac_medication_visit_id='$visit_id' AND starter_crntomedication_cardiac_medication.cardiac_medication_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_antiobesities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity WHERE starter_crntomedication_anti_obesity.anti_obesity_visit_id='$visit_id' AND starter_crntomedication_anti_obesity.anti_obesity_patient_id='$patient_id'");
		return $query->result_array();
	}

	public function crnt_medication_others($visit_id, $patient_id)
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
	
	public function get_visit_managements($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_management WHERE starter_visit_management.management_visit_id='$visit_id' AND starter_visit_management.management_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function get_visit_exercise($visit_id, $patient_id, $management_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_exercise WHERE starter_visit_exercise.exercise_visit_id='$visit_id' AND starter_visit_exercise.exercise_patient_id='$patient_id' AND starter_visit_exercise.exercise_management_id='$management_id'");
		return $query->result_array();
	}
	
	public function visit_diagonosis($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_diagonosis WHERE starter_visit_diagonosis.diagonosis_visit_id='$visit_id' AND starter_visit_diagonosis.diagonosis_patient_id='$patient_id'");
		return $query->row_array();
	}
	
	public function prev_phisical_activities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_physical_activity WHERE starter_prvadv_physical_activity.physical_act_visit_id='$visit_id' AND starter_prvadv_physical_activity.physical_act_patient_id='$patient_id'");
		return $query->result_array();
	}
	public function crnt_phisical_activities($visit_id, $patient_id)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_physical_activity WHERE starter_crntadv_physical_activity.physical_act_visit_id='$visit_id' AND starter_crntadv_physical_activity.physical_act_patient_id='$patient_id'");
		return $query->result_array();
	}
	
}