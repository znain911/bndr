<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	private $active_user;
	private $active_center;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  $this->active_user = null;
	  $this->active_center = null;
	  
	  $this->load->model('patients/Organization_model', 'Organization_model', true);
	  $this->load->model('patients/Patient_model', 'Patient_model', true);
	  $this->load->model('patients/Progress_model', 'Progress_model', true);
	  $this->load->helper('custom_string');
	  $this->load->model('Common_model');
	}
	
	private function get_visit_org_id($center_id)
	{
		$og_id = $this->Progress_model->get_org_by_centerid($center_id);
		return $og_id;
	}
	
	public function create_progress_report()
	{
		$this->active_user = $this->input->post('active_user');
		$this->active_user_type = $this->input->post('user_type');
		$this->active_center = $this->input->post('active_center');
		$local_app_centers = $this->Common_model->get_local_app_centers();
		if($this->active_user === NULL && !in_array($this->active_center, $local_app_centers))
		{
			$result = array('status' => 'error', 'content' => 'This api is to be used in registered centers!');
			echo json_encode($result);
			exit;
		}
		
		$sms_array = array(
						'FBS'    => null,
						'ABF'    => null,
						'HbA1c'  => null,
						'BP'     => null,
						'Weight' => null,
					);
		$this->load->library('form_validation');
		$patient_id = $this->input->post('visit_patient');
		$today = date("Y-m-d");
		$total_items = $this->Progress_model->get_todaytotal_items($today);
		$entry_ID = date('dmy').str_pad($total_items, 7, '0', STR_PAD_LEFT);
		
		$patient_total_visits = $this->Progress_model->get_count_of_patient_visits($patient_id);
		$serial_no = 'Visit '.($patient_total_visits+1);
		
		//check patient type
		if($patient_total_visits > 0)
		{
			$visit_patient_type = 'OLD';
		}else{
			$visit_patient_type = 'NEW';
		}
		$visit_no = $this->Progress_model->get_visit_no($patient_id);
		$basic_data = array(
						'visit_number'             => $visit_no,
						'visit_is'                 => 'PROGRESS_REPORT',
						'visit_entryid'            => $entry_ID,
						'visit_form_version'       => 'v2',
						'visit_serial_no'          => $serial_no,
						'visit_patient_id'         => $patient_id,
						'visit_org_centerid'       => html_escape($this->input->post('visit_center_id')),
						'visit_date'               => db_formated_date($this->input->post('visit_date')),
						'visit_patient_type'       => $visit_patient_type,
						'visit_registration_center'=> html_escape($this->input->post('registration_center_id')),
						'visit_org_id'             => $this->get_visit_org_id(html_escape($this->input->post('visit_center_id'))),
						'visit_admit_date'         => date("Y-m-d H:i:s"),
						'visit_admited_by'         => $this->active_user,
						'visit_admited_by_usertype'=> $this->active_user_type,
					  );
		$validate = array(
						array(
							'field' => 'visit_date', 
							'label' => 'Visit Date', 
							'rules' => 'Required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//Save basic visit informations
			$ins_id = $this->Progress_model->save_visit_information($basic_data);
			$visit_id = $this->db->insert_id($ins_id);
			
			//Save visit diabetes history
			$diabetes_history_data = array(
										'dhistory_patient_id'                 => $patient_id,
										'dhistory_visit_id'                   => $visit_id,
										'dhistory_type_of_glucose'            => html_escape($this->input->post('type_of_glucose')),
										'dhistory_duration_of_glucose'        => html_escape($this->input->post('duration_of_glucose')),
										'dhistory_prev_bad_obstetric_history' => html_escape($this->input->post('prev_bad_obstetric_history')),
										'dhistory_prev_history_of_gdm'        => html_escape($this->input->post('prev_history_of_gdm')),
										'dhistory_past_medical_history'       => html_escape($this->input->post('past_medical_history')),
									);
			$this->Progress_model->save_diabetes_history($diabetes_history_data);
			
			//Save visit complication
			$complication_rows = $this->input->post('complication_row');
			if(!empty($complication_rows)):
			foreach($complication_rows as $row)
			{
				$complication_name = html_escape($this->input->post('complication_'.$row));
				
				if($complication_name)
				{
					$complication_data = array(
											'vcomplication_patient_id' => $patient_id,
											'vcomplication_visit_id'   => $visit_id,
											'vcomplication_name'       => $complication_name,
										);
					$this->Progress_model->save_visit_complication($complication_data);
				}
			}
			endif;
			
			
			//Save visit general examination
			$gexam_rows = $this->input->post('gexam_row');
			if(!empty($gexam_rows)):
			$BP = array(
						'sbp' => null,
						'dbp' => null,
					);
			foreach($gexam_rows as $row)
			{
				$generalexam_name = html_escape($this->input->post('gexam_row_name_'.$row));
				if($this->input->post('gexam_row_unit_'.$row) == 'ft/inch')
				{
					$generalexam_unit = html_escape($this->input->post('gexam_row_unit_'.$row));
					$generalexam_value = '';
					if($this->input->post('gexam_row_value_fit'))
					{
						$generalexam_value .= html_escape($this->input->post('gexam_row_value_fit')).' feet ';
					}
					
					if($this->input->post('gexam_row_value_inch'))
					{
						$generalexam_value .= html_escape($this->input->post('gexam_row_value_inch')).' Inch';
					}
				}else{
					$generalexam_unit = html_escape($this->input->post('gexam_row_unit_'.$row));
					$generalexam_value = html_escape($this->input->post('gexam_row_value_'.$row));
				}
				
				if($generalexam_name == 'Weight')
				{
					$sms_array['Weight'] = $generalexam_value.' '.$generalexam_unit;
				}
				
				if($generalexam_name == html_escape('Sitting SBP'))
				{
					$BP['sbp'] = $generalexam_value.' '.$generalexam_unit;
				}
				
				if($generalexam_name == html_escape('Sitting DBP'))
				{
					$BP['dbp'] .= $generalexam_value.' '.$generalexam_unit;
				}
				
				if($generalexam_name && $generalexam_value)
				{
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'generalexam_name'       => $generalexam_name,
										'generalexam_value'      => $generalexam_value,
										'generalexam_unit'       => $generalexam_unit,
									);
					$this->Progress_model->save_visit_general_examination($general_exam_data);
				}
			}
			$sms_array['BP'] = $BP['sbp'].'/'.$BP['dbp'];
			endif;
			
			//Save visit laboratory investigation
			$labinv_rows = $this->input->post('labinv_row');
			if(!empty($labinv_rows)):
			foreach($labinv_rows as $row)
			{
				$labinv_name = html_escape($this->input->post('labinv_row_name_'.$row));
				$labinv_value = html_escape($this->input->post('labinv_row_value_'.$row));
				$labinv_unit = html_escape($this->input->post('labinv_row_unit_'.$row));
				
				if($labinv_name == 'FBG')
				{
					$sms_array['FBS'] = $labinv_value.' '.$labinv_unit;
				}
				
				if($labinv_name == '2hAG')
				{
					$sms_array['ABF'] = $labinv_value.' '.$labinv_unit;
				}
				
				if($labinv_name == 'HbA1c')
				{
					$sms_array['HbA1c'] = $labinv_value.' '.$labinv_unit;
				}
				
				if($labinv_name && $labinv_value)
				{
					$laboratory_investigation = array(
										'labinvs_patient_id' => $patient_id,
										'labinvs_visit_id'   => $visit_id,
										'labinvs_name'       => $labinv_name,
										'labinvs_value'      => $labinv_value,
										'labinvs_unit'      => $labinv_unit,
									);
					$this->Progress_model->save_visit_laboratory_investigation($laboratory_investigation);
				}
			}
			endif;
			
			//Save visit laboratory investigation ECG
			$ecg_abnormals = $this->input->post('abn_keywords');
			$ecg_data = array(
							'ecg_patient_id' => $patient_id,
							'ecg_visit_id'   => $visit_id,
							'ecg_type'       => html_escape($this->input->post('ecg_type')),
							'ecg_abnormals'  => json_encode($ecg_abnormals),
						);
			$this->Progress_model->save_visit_laboratory_ecg($ecg_data);
			
			//Save Final Treatment
			$final_treatment_data = array(
										'finaltreat_patient_id'        => $patient_id,
										'finaltreat_visit_id'          => $visit_id,
										'finaltreat_doctor_name'       => html_escape($this->input->post('finaltreat_doctor_name')),
										'finaltreat_doctor_id'         => html_escape($this->input->post('finaltreat_doctor_id')),
										'finaltreat_date'              => db_formated_date($this->input->post('finaltreat_date')),
										'finaltreat_dietary_advice'    => html_escape($this->input->post('finaltreat_dietary_advice')),
										'finaltreat_physical_acitvity' => html_escape($this->input->post('finaltreat_physical_acitvity')),
										'finaltreat_diet_no'           => html_escape($this->input->post('finaltreat_diet_no')),
										'finaltreat_page_no'           => html_escape($this->input->post('finaltreat_page_no')),
										'finaltreat_next_visit_date'   => db_formated_date($this->input->post('finaltreat_next_visit_date')),
										'finaltreat_next_investigation'=> html_escape($this->input->post('finaltreat_next_investigation')),
									);
			$this->Progress_model->save_final_treatment_infos($final_treatment_data);
				
			// current OADs
			$crnt_oads_rows = $this->input->post('crnt_oads_row');
			if($this->input->post('crnt_is_oads') == '1' && !empty($crnt_oads_rows)):
			foreach($crnt_oads_rows as $row)
			{
				$crnt_oads_name = html_escape($this->input->post('crnt_oads_name_'.$row));
				$crnt_oads_dose = html_escape($this->input->post('crnt_oads_value_'.$row));
				
				$crnt_oads_condition_time      = html_escape($this->input->post('crnt_oads_condition_time_'.$row));
				$crnt_oads_condition_time_type = html_escape($this->input->post('crnt_oads_condition_time_type_'.$row));
				$crnt_oads_condition_apply     = html_escape($this->input->post('crnt_oads_condition_apply_'.$row));
				$crnt_oads_duration            = html_escape($this->input->post('crnt_oads_duration_'.$row));
				$crnt_oads_duration_type       = html_escape($this->input->post('crnt_oads_duration_type_'.$row));
				
				if($crnt_oads_condition_time & $crnt_oads_duration){
					$oads_advice_codition_time        = $crnt_oads_condition_time;
					$oads_advice_codition_time_type   = $crnt_oads_condition_time_type;
					$oads_advice_codition_apply       = $crnt_oads_condition_apply;
					$oads_duration                    = $crnt_oads_duration;
					$oads_duration_type               = $crnt_oads_duration_type;
					
				}else{
					$oads_advice_codition_time      = null;
					$oads_advice_codition_time_type = null;
					$oads_advice_codition_apply     = null;
					$oads_duration                  = null;
					$oads_duration_type             = null;
				} 
				
				if($crnt_oads_name && $crnt_oads_dose)
				{
					$crnt_oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name'       => $crnt_oads_name,
									'oads_dose'       => $crnt_oads_dose,
									'oads_advice_codition_time'      => $oads_advice_codition_time,
									'oads_advice_codition_time_type' => $oads_advice_codition_time_type,
									'oads_advice_codition_apply'     => $oads_advice_codition_apply,
									'oads_duration'                  => $oads_duration,
									'oads_duration_type'             => $oads_duration_type,
								);
					$this->Progress_model->save_visitcrnt_oads($crnt_oads_data);
				}
			}
			endif;
			
			// current insulin
			$crnt_insulin_rows = $this->input->post('crnt_insulin_row');
			if($this->input->post('crnt_is_insulin') == '1' && !empty($crnt_insulin_rows)):
			foreach($crnt_insulin_rows as $row)
			{
				$crnt_insulin_name = html_escape($this->input->post('crnt_insulin_name_'.$row));
				$crnt_insulin_dose = html_escape($this->input->post('crnt_insulin_value_'.$row));
				
				$crnt_insulin_condition_time      = html_escape($this->input->post('crnt_insulin_condition_time_'.$row));
				$crnt_insulin_condition_time_type = html_escape($this->input->post('crnt_insulin_condition_time_type_'.$row));
				$crnt_insulin_condition_apply     = html_escape($this->input->post('crnt_insulin_condition_apply_'.$row));
				$crnt_insulin_duration            = html_escape($this->input->post('crnt_insulin_duration_'.$row));
				$crnt_insulin_duration_type       = html_escape($this->input->post('crnt_insulin_duration_type_'.$row));
				
				if($crnt_insulin_condition_time & $crnt_insulin_duration){
					$insulin_advice_codition_time      = $crnt_insulin_condition_time;
					$insulin_advice_codition_time_type = $crnt_insulin_condition_time_type;
					$insulin_advice_codition_apply     = $crnt_insulin_condition_apply;
					$insulin_duration                  = $crnt_insulin_duration;
					$insulin_duration_type             = $crnt_insulin_duration_type;
				}else{
					$insulin_advice_codition_time      = null;
					$insulin_advice_codition_time_type = null;
					$insulin_advice_codition_apply     = null;
					$insulin_duration                  = null;
					$insulin_duration_type             = null;
				} 
				
				if($crnt_insulin_name && $crnt_insulin_dose)
				{
					$crnt_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name'       => $crnt_insulin_name,
									'insulin_dose'       => $crnt_insulin_dose,
									'insulin_advice_codition_time'      => $insulin_advice_codition_time,
									'insulin_advice_codition_time_type' => $insulin_advice_codition_time_type,
									'insulin_advice_codition_apply'     => $insulin_advice_codition_apply,
									'insulin_duration'                  => $insulin_duration,
									'insulin_duration_type'             => $insulin_duration_type,
								);
					$this->Progress_model->save_visitcrnt_insulin($crnt_insulin_data);
				}
			}
			endif;
			
			// current anti htn
			$crnt_anti_htn_row_rows = $this->input->post('crnt_anti_htn_row');
			if($this->input->post('crnt_is_anti_htn') == '1' && !empty($crnt_anti_htn_row_rows)):
			foreach($crnt_anti_htn_row_rows as $row)
			{
				$anti_htn_name = html_escape($this->input->post('crnt_anti_htn_name_'.$row));
				$anti_htn_dose = html_escape($this->input->post('crnt_anti_htn_value_'.$row));
				
				$crnt_anti_htn_condition_time      = html_escape($this->input->post('crnt_anti_htn_condition_time_'.$row));
				$crnt_anti_htn_condition_time_type = html_escape($this->input->post('crnt_anti_htn_condition_time_type_'.$row));
				$crnt_anti_htn_condition_apply     = html_escape($this->input->post('crnt_anti_htn_condition_apply_'.$row));
				$crnt_anti_htn_duration            = html_escape($this->input->post('crnt_anti_htn_duration_'.$row));
				$crnt_anti_htn_duration_type       = html_escape($this->input->post('crnt_anti_htn_duration_type_'.$row));
				
				if($crnt_anti_htn_condition_time & $crnt_anti_htn_duration){
					$anti_htn_advice_codition_time      = $crnt_anti_htn_condition_time;
					$anti_htn_advice_codition_time_type = $crnt_anti_htn_condition_time_type;
					$anti_htn_advice_codition_apply     = $crnt_anti_htn_condition_apply;
					$anti_htn_duration                  = $crnt_anti_htn_duration;
					$anti_htn_duration_type             = $crnt_anti_htn_duration_type;
				}else{
					$anti_htn_advice_codition_time      = null;
					$anti_htn_advice_codition_time_type = null;
					$anti_htn_advice_codition_apply     = null;
					$anti_htn_duration                  = null;
					$anti_htn_duration_type             = null;
				}
				
				if($anti_htn_name && $anti_htn_dose)
				{
					$crnt_anti_htn_dose_data = array(
									'anti_htn_patient_id' => $patient_id,
									'anti_htn_visit_id'   => $visit_id,
									'anti_htn_name'       => $anti_htn_name,
									'anti_htn_dose'       => $anti_htn_dose,
									'anti_htn_advice_codition_time'      => $anti_htn_advice_codition_time,
									'anti_htn_advice_codition_time_type' => $anti_htn_advice_codition_time_type,
									'anti_htn_advice_codition_apply'     => $anti_htn_advice_codition_apply,
									'anti_htn_duration'                  => $anti_htn_duration,
									'anti_htn_duration_type'             => $anti_htn_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
				}
			}
			endif;
			
			// current anti lipids
			$crnt_lipids_rows = $this->input->post('crnt_lipids_row');
			if($this->input->post('crnt_is_anti_lipids') == '1' && !empty($crnt_lipids_rows)):
			foreach($crnt_lipids_rows as $row)
			{
				$anti_lipid_name = html_escape($this->input->post('crnt_lipids_name_'.$row));
				$anti_lipid_dose = html_escape($this->input->post('crnt_lipids_value_'.$row));
				
				$crnt_anti_lipid_condition_time      = html_escape($this->input->post('crnt_lipids_condition_time_'.$row));
				$crnt_anti_lipid_condition_time_type = html_escape($this->input->post('crnt_lipids_condition_time_type_'.$row));
				$crnt_anti_lipid_condition_apply     = html_escape($this->input->post('crnt_lipids_condition_apply_'.$row));
				$crnt_anti_lipid_duration            = html_escape($this->input->post('crnt_lipids_duration_'.$row));
				$crnt_anti_lipid_duration_type       = html_escape($this->input->post('crnt_lipids_duration_type_'.$row));
				
				if($crnt_anti_lipid_condition_time & $crnt_anti_lipid_duration){
					$anti_lipid_advice_codition_time      = $crnt_anti_lipid_condition_time;
					$anti_lipid_advice_codition_time_type = $crnt_anti_lipid_condition_time_type;
					$anti_lipid_advice_codition_apply     = $crnt_anti_lipid_condition_apply;
					$anti_lipid_duration                  = $crnt_anti_lipid_duration;
					$anti_lipid_duration_type             = $crnt_anti_lipid_duration_type;
				}else{
					$anti_lipid_advice_codition_time      = null;
					$anti_lipid_advice_codition_time_type = null;
					$anti_lipid_advice_codition_apply     = null;
					$anti_lipid_duration                  = null;
					$anti_lipid_duration_type             = null;
				}
				
				if($anti_lipid_name && $anti_lipid_dose)
				{
					$crnt_anti_lipids_data = array(
									'anti_lipid_patient_id' => $patient_id,
									'anti_lipid_visit_id'   => $visit_id,
									'anti_lipid_name'       => $anti_lipid_name,
									'anti_lipid_dose'       => $anti_lipid_dose,
									'anti_lipid_advice_codition_time'      => $anti_lipid_advice_codition_time,
									'anti_lipid_advice_codition_time_type' => $anti_lipid_advice_codition_time_type,
									'anti_lipid_advice_codition_apply'     => $anti_lipid_advice_codition_apply,
									'anti_lipid_duration'                  => $anti_lipid_duration,
									'anti_lipid_duration_type'             => $anti_lipid_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
				}
			}
			endif;
			
			// current antiplatelets
			$crnt_aspirine_rows = $this->input->post('crnt_aspirine_row');
			if($this->input->post('crnt_is_aspirine') == '1' && !empty($crnt_aspirine_rows)):
			foreach($crnt_aspirine_rows as $row)
			{
				$antiplatelets_name = html_escape($this->input->post('crnt_aspirine_name_'.$row));
				$antiplatelets_dose = html_escape($this->input->post('crnt_aspirine_value_'.$row));
				
				$crnt_antiplatelets_condition_time      = html_escape($this->input->post('crnt_aspirine_condition_time_'.$row));
				$crnt_antiplatelets_condition_time_type = html_escape($this->input->post('crnt_aspirine_condition_time_type_'.$row));
				$crnt_antiplatelets_condition_apply     = html_escape($this->input->post('crnt_aspirine_condition_apply_'.$row));
				$crnt_antiplatelets_duration            = html_escape($this->input->post('crnt_aspirine_duration_'.$row));
				$crnt_antiplatelets_duration_type       = html_escape($this->input->post('crnt_aspirine_duration_type_'.$row));
				
				if($crnt_antiplatelets_condition_time & $crnt_antiplatelets_duration){
					$antiplatelets_advice_codition_time       = $crnt_antiplatelets_condition_time;
					$antiplatelets_advice_codition_time_type  = $crnt_antiplatelets_condition_time_type;
					$antiplatelets_advice_codition_apply      = $crnt_antiplatelets_condition_apply;
					$antiplatelets_duration                   = $crnt_antiplatelets_duration;
					$antiplatelets_duration_type              = $crnt_antiplatelets_duration_type;
				}else{
					$antiplatelets_advice_codition_time       = null;
					$antiplatelets_advice_codition_time_type  = null;
					$antiplatelets_advice_codition_apply      = null;
					$antiplatelets_duration                   = null;
					$antiplatelets_duration_type              = null;
				}
				
				if($antiplatelets_name && $antiplatelets_dose)
				{
					$crnt_antiplatelets_data = array(
									'antiplatelets_patient_id' => $patient_id,
									'antiplatelets_visit_id'   => $visit_id,
									'antiplatelets_name'       => $antiplatelets_name,
									'antiplatelets_dose'       => $antiplatelets_dose,
									'antiplatelets_advice_codition_time'      => $antiplatelets_advice_codition_time,
									'antiplatelets_advice_codition_time_type' => $antiplatelets_advice_codition_time_type,
									'antiplatelets_advice_codition_apply'     => $antiplatelets_advice_codition_apply,
									'antiplatelets_duration'                  => $antiplatelets_duration,
									'antiplatelets_duration_type'             => $antiplatelets_duration_type,
								);
					$this->Progress_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
				}
			}
			endif;
			
			// current anti obesity
			$crnt_obesity_rows = $this->input->post('crnt_obesity_row');
			if($this->input->post('crnt_is_anti_obesity') == '1' && !empty($crnt_obesity_rows)):
			foreach($crnt_obesity_rows as $row)
			{
				$anti_obesity_name = html_escape($this->input->post('crnt_obesity_name_'.$row));
				$anti_obesity_dose = html_escape($this->input->post('crnt_obesity_value_'.$row));
				
				$crnt_obesity_condition_time      = html_escape($this->input->post('crnt_obesity_condition_time_'.$row));
				$crnt_obesity_condition_time_type = html_escape($this->input->post('crnt_obesity_condition_time_type_'.$row));
				$crnt_obesity_condition_apply     = html_escape($this->input->post('crnt_obesity_condition_apply_'.$row));
				$crnt_obesity_duration            = html_escape($this->input->post('crnt_obesity_duration_'.$row));
				$crnt_obesity_duration_type       = html_escape($this->input->post('crnt_obesity_duration_type_'.$row));
				
				if($crnt_obesity_condition_time & $crnt_obesity_duration){
					$anti_obesity_advice_codition_time       = $crnt_obesity_condition_time;
					$anti_obesity_advice_codition_time_type  = $crnt_obesity_condition_time_type;
					$anti_obesity_advice_codition_apply      = $crnt_obesity_condition_apply;
					$anti_obesity_duration                   = $crnt_obesity_duration;
					$anti_obesity_duration_type              = $crnt_obesity_duration_type;
				}else{
					$anti_obesity_advice_codition_time       = null;
					$anti_obesity_advice_codition_time_type  = null;
					$anti_obesity_advice_codition_apply      = null;
					$anti_obesity_duration                   = null;
					$anti_obesity_duration_type              = null;
				}
				
				if($anti_obesity_name && $anti_obesity_dose)
				{
					$crnt_anti_obesity_data = array(
									'anti_obesity_patient_id' => $patient_id,
									'anti_obesity_visit_id'   => $visit_id,
									'anti_obesity_name'       => $anti_obesity_name,
									'anti_obesity_dose'       => $anti_obesity_dose,
									'anti_obesity_advice_codition_time'      => $anti_obesity_advice_codition_time,
									'anti_obesity_advice_codition_time_type' => $anti_obesity_advice_codition_time_type,
									'anti_obesity_advice_codition_apply'     => $anti_obesity_advice_codition_apply,
									'anti_obesity_duration'                  => $anti_obesity_duration,
									'anti_obesity_duration_type'             => $anti_obesity_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
				}
			}
			endif;
			
			// current other
			$crnt_other_rows = $this->input->post('crnt_other_row');
			if($this->input->post('crnt_is_others') == '1' && !empty($crnt_other_rows)):
			foreach($crnt_other_rows as $row)
			{
				$other_name = html_escape($this->input->post('crnt_other_name_'.$row));
				$other_dose = html_escape($this->input->post('crnt_other_value_'.$row));
				
				$crnt_other_condition_time      = html_escape($this->input->post('crnt_other_condition_time_'.$row));
				$crnt_other_condition_time_type = html_escape($this->input->post('crnt_other_condition_time_type_'.$row));
				$crnt_other_condition_apply     = html_escape($this->input->post('crnt_other_condition_apply_'.$row));
				$crnt_other_duration            = html_escape($this->input->post('crnt_other_duration_'.$row));
				$crnt_other_duration_type       = html_escape($this->input->post('crnt_other_duration_type_'.$row));
				
				if($crnt_other_condition_time & $crnt_other_duration){
					$other_advice_codition_time        = $crnt_other_condition_time;
					$other_advice_codition_time_type   = $crnt_other_condition_time_type;
					$other_advice_codition_apply       = $crnt_other_condition_apply;
					$other_duration                    = $crnt_other_duration;
					$other_duration_type               = $crnt_other_duration_type;
				}else{
					$other_advice_codition_time        = null;
					$other_advice_codition_time_type   = null;
					$other_advice_codition_apply       = null;
					$other_duration                    = null;
					$other_duration_type               = null;
				}
				
				if($other_name && $other_dose)
				{
					$crnt_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
									'other_advice'     => $other_advice,
									'other_duration'   => $other_duration,
									'other_advice_codition_time'      => $other_advice_codition_time,
									'other_advice_codition_time_type' => $other_advice_codition_time_type,
									'other_advice_codition_apply'     => $other_advice_codition_apply,
									'other_duration'                  => $other_duration,
									'other_duration_type'             => $other_duration_type,
								);
					$this->Progress_model->save_visitcrnt_omedication_other($crnt_omedication_other);
				}
			}
			endif;
				
			//Save Payments
			$payment_satatus = $this->input->post('payment');
			$payment_data = array(
								'payment_visit_id'           => $visit_id,
								'payment_patient_id'         => $patient_id,
								'payment_patient_fee_amount' => $this->input->post('fee_amount'),
								'payment_patient_status'     => $payment_satatus,
							);
			$this->Progress_model->save_payment_data($payment_data);
			
			$result = array('has_synced' => 'YES');
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$result = array('has_synced' => 'NO');
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function update_progress_report()
	{
		$this->active_user = $this->input->post('active_user');
		$this->active_center = $this->input->post('active_center');
		$local_app_centers = $this->Common_model->get_local_app_centers();
		if($this->active_user === NULL && !in_array($this->active_center, $local_app_centers))
		{
			$result = array('status' => 'error', 'content' => 'This api is to be used in registered centers!');
			echo json_encode($result);
			exit;
		}
		
		$this->load->library('form_validation');
		$patient_id = $this->input->post('visit_patient');
		$visit_id = $this->input->post('visit_id');
		$entry_ID = $this->input->post('visit_entryid');
		
		$basic_data = array(
						'visit_org_centerid'       => html_escape($this->input->post('visit_center_id')),
						'visit_date'               => db_formated_date($this->input->post('visit_date')),
						'visit_org_id'             => $this->get_visit_org_id(html_escape($this->input->post('visit_center_id'))),
					  );
		$validate = array(
						array(
							'field' => 'visit_date', 
							'label' => 'Visit Date', 
							'rules' => 'Required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//Update basic visit informations
			$this->Progress_model->update_visit_information($basic_data, $visit_id, $patient_id);
			
			//Delete Old visit informations
			$this->Progress_model->delete_old_visit_information($visit_id);
			
			//Save visit diabetes history
			$diabetes_history_data = array(
										'dhistory_patient_id'                 => $patient_id,
										'dhistory_visit_id'                   => $visit_id,
										'dhistory_type_of_glucose'            => html_escape($this->input->post('type_of_glucose')),
										'dhistory_duration_of_glucose'        => html_escape($this->input->post('duration_of_glucose')),
										'dhistory_prev_bad_obstetric_history' => html_escape($this->input->post('prev_bad_obstetric_history')),
										'dhistory_prev_history_of_gdm'        => html_escape($this->input->post('prev_history_of_gdm')),
										'dhistory_past_medical_history'       => html_escape($this->input->post('past_medical_history')),
									);
			$this->Progress_model->save_diabetes_history($diabetes_history_data);
			
			//Save visit complication
			$complication_rows = $this->input->post('complication_row');
			if(!empty($complication_rows)):
			foreach($complication_rows as $row)
			{
				$complication_name = html_escape($this->input->post('complication_'.$row));
				
				if($complication_name)
				{
					$complication_data = array(
											'vcomplication_patient_id' => $patient_id,
											'vcomplication_visit_id'   => $visit_id,
											'vcomplication_name'       => $complication_name,
										);
					$this->Progress_model->save_visit_complication($complication_data);
				}
			}
			endif;
			
			
			//Save visit general examination
			$gexam_rows = $this->input->post('gexam_row');
			if(!empty($gexam_rows)):
			foreach($gexam_rows as $row)
			{
				$generalexam_name = html_escape($this->input->post('gexam_row_name_'.$row));
				if($this->input->post('gexam_row_unit_'.$row) == 'ft/inch')
				{
					$generalexam_unit = html_escape($this->input->post('gexam_row_unit_'.$row));
					$generalexam_value = '';
					if($this->input->post('gexam_row_value_fit'))
					{
						$generalexam_value .= html_escape($this->input->post('gexam_row_value_fit')).' feet ';
					}
					
					if($this->input->post('gexam_row_value_inch'))
					{
						$generalexam_value .= html_escape($this->input->post('gexam_row_value_inch')).' Inch';
					}
				}else{
					$generalexam_unit = html_escape($this->input->post('gexam_row_unit_'.$row));
					$generalexam_value = html_escape($this->input->post('gexam_row_value_'.$row));
				}
				
				if($generalexam_name && $generalexam_value)
				{
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'generalexam_name'       => $generalexam_name,
										'generalexam_value'      => $generalexam_value,
										'generalexam_unit'       => $generalexam_unit,
									);
					$this->Progress_model->save_visit_general_examination($general_exam_data);
				}
			}
			endif;
			
			//Save visit laboratory investigation
			$labinv_rows = $this->input->post('labinv_row');
			if(!empty($labinv_rows)):
			foreach($labinv_rows as $row)
			{
				$labinv_name = html_escape($this->input->post('labinv_row_name_'.$row));
				$labinv_value = html_escape($this->input->post('labinv_row_value_'.$row));
				$labinv_unit = html_escape($this->input->post('labinv_row_unit_'.$row));
				
				if($labinv_name && $labinv_value)
				{
					$laboratory_investigation = array(
										'labinvs_patient_id' => $patient_id,
										'labinvs_visit_id'   => $visit_id,
										'labinvs_name'       => $labinv_name,
										'labinvs_value'      => $labinv_value,
										'labinvs_unit'      => $labinv_unit,
									);
					$this->Progress_model->save_visit_laboratory_investigation($laboratory_investigation);
				}
			}
			endif;
			
			//Save visit laboratory investigation ECG
			$ecg_abnormals = $this->input->post('abn_keywords');
			$ecg_data = array(
							'ecg_patient_id' => $patient_id,
							'ecg_visit_id'   => $visit_id,
							'ecg_type'       => html_escape($this->input->post('ecg_type')),
							'ecg_abnormals'  => json_encode($ecg_abnormals),
						);
			$this->Progress_model->save_visit_laboratory_ecg($ecg_data);
			
			//Save Final Treatment
			$final_treatment_data = array(
										'finaltreat_patient_id'        => $patient_id,
										'finaltreat_visit_id'          => $visit_id,
										'finaltreat_doctor_name'       => html_escape($this->input->post('finaltreat_doctor_name')),
										'finaltreat_doctor_id'         => html_escape($this->input->post('finaltreat_doctor_id')),
										'finaltreat_date'              => db_formated_date($this->input->post('finaltreat_date')),
										'finaltreat_dietary_advice'    => html_escape($this->input->post('finaltreat_dietary_advice')),
										'finaltreat_physical_acitvity' => html_escape($this->input->post('finaltreat_physical_acitvity')),
										'finaltreat_diet_no'           => html_escape($this->input->post('finaltreat_diet_no')),
										'finaltreat_page_no'           => html_escape($this->input->post('finaltreat_page_no')),
										'finaltreat_next_visit_date'   => db_formated_date($this->input->post('finaltreat_next_visit_date')),
										'finaltreat_next_investigation'=> html_escape($this->input->post('finaltreat_next_investigation')),
									);
			$this->Progress_model->save_final_treatment_infos($final_treatment_data);
				
			// current OADs
			$crnt_oads_rows = $this->input->post('crnt_oads_row');
			if($this->input->post('crnt_is_oads') == '1' && !empty($crnt_oads_rows)):
			foreach($crnt_oads_rows as $row)
			{
				$crnt_oads_name = html_escape($this->input->post('crnt_oads_name_'.$row));
				$crnt_oads_dose = html_escape($this->input->post('crnt_oads_value_'.$row));
				
				$crnt_oads_condition_time      = html_escape($this->input->post('crnt_oads_condition_time_'.$row));
				$crnt_oads_condition_time_type = html_escape($this->input->post('crnt_oads_condition_time_type_'.$row));
				$crnt_oads_condition_apply     = html_escape($this->input->post('crnt_oads_condition_apply_'.$row));
				$crnt_oads_duration            = html_escape($this->input->post('crnt_oads_duration_'.$row));
				$crnt_oads_duration_type       = html_escape($this->input->post('crnt_oads_duration_type_'.$row));
				
				if($crnt_oads_condition_time & $crnt_oads_duration){
					$oads_advice_codition_time        = $crnt_oads_condition_time;
					$oads_advice_codition_time_type   = $crnt_oads_condition_time_type;
					$oads_advice_codition_apply       = $crnt_oads_condition_apply;
					$oads_duration                    = $crnt_oads_duration;
					$oads_duration_type               = $crnt_oads_duration_type;
					
				}else{
					$oads_advice_codition_time      = null;
					$oads_advice_codition_time_type = null;
					$oads_advice_codition_apply     = null;
					$oads_duration                  = null;
					$oads_duration_type             = null;
				} 
				
				if($crnt_oads_name && $crnt_oads_dose)
				{
					$crnt_oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name'       => $crnt_oads_name,
									'oads_dose'       => $crnt_oads_dose,
									'oads_advice_codition_time'      => $oads_advice_codition_time,
									'oads_advice_codition_time_type' => $oads_advice_codition_time_type,
									'oads_advice_codition_apply'     => $oads_advice_codition_apply,
									'oads_duration'                  => $oads_duration,
									'oads_duration_type'             => $oads_duration_type,
								);
					$this->Progress_model->save_visitcrnt_oads($crnt_oads_data);
				}
			}
			endif;
			
			// current insulin
			$crnt_insulin_rows = $this->input->post('crnt_insulin_row');
			if($this->input->post('crnt_is_insulin') == '1' && !empty($crnt_insulin_rows)):
			foreach($crnt_insulin_rows as $row)
			{
				$crnt_insulin_name = html_escape($this->input->post('crnt_insulin_name_'.$row));
				$crnt_insulin_dose = html_escape($this->input->post('crnt_insulin_value_'.$row));
				
				$crnt_insulin_condition_time      = html_escape($this->input->post('crnt_insulin_condition_time_'.$row));
				$crnt_insulin_condition_time_type = html_escape($this->input->post('crnt_insulin_condition_time_type_'.$row));
				$crnt_insulin_condition_apply     = html_escape($this->input->post('crnt_insulin_condition_apply_'.$row));
				$crnt_insulin_duration            = html_escape($this->input->post('crnt_insulin_duration_'.$row));
				$crnt_insulin_duration_type       = html_escape($this->input->post('crnt_insulin_duration_type_'.$row));
				
				if($crnt_insulin_condition_time & $crnt_insulin_duration){
					$insulin_advice_codition_time      = $crnt_insulin_condition_time;
					$insulin_advice_codition_time_type = $crnt_insulin_condition_time_type;
					$insulin_advice_codition_apply     = $crnt_insulin_condition_apply;
					$insulin_duration                  = $crnt_insulin_duration;
					$insulin_duration_type             = $crnt_insulin_duration_type;
				}else{
					$insulin_advice_codition_time      = null;
					$insulin_advice_codition_time_type = null;
					$insulin_advice_codition_apply     = null;
					$insulin_duration                  = null;
					$insulin_duration_type             = null;
				} 
				
				if($crnt_insulin_name && $crnt_insulin_dose)
				{
					$crnt_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name'       => $crnt_insulin_name,
									'insulin_dose'       => $crnt_insulin_dose,
									'insulin_advice_codition_time'      => $insulin_advice_codition_time,
									'insulin_advice_codition_time_type' => $insulin_advice_codition_time_type,
									'insulin_advice_codition_apply'     => $insulin_advice_codition_apply,
									'insulin_duration'                  => $insulin_duration,
									'insulin_duration_type'             => $insulin_duration_type,
								);
					$this->Progress_model->save_visitcrnt_insulin($crnt_insulin_data);
				}
			}
			endif;
			
			// current anti htn
			$crnt_anti_htn_row_rows = $this->input->post('crnt_anti_htn_row');
			if($this->input->post('crnt_is_anti_htn') == '1' && !empty($crnt_anti_htn_row_rows)):
			foreach($crnt_anti_htn_row_rows as $row)
			{
				$anti_htn_name = html_escape($this->input->post('crnt_anti_htn_name_'.$row));
				$anti_htn_dose = html_escape($this->input->post('crnt_anti_htn_value_'.$row));
				
				$crnt_anti_htn_condition_time      = html_escape($this->input->post('crnt_anti_htn_condition_time_'.$row));
				$crnt_anti_htn_condition_time_type = html_escape($this->input->post('crnt_anti_htn_condition_time_type_'.$row));
				$crnt_anti_htn_condition_apply     = html_escape($this->input->post('crnt_anti_htn_condition_apply_'.$row));
				$crnt_anti_htn_duration            = html_escape($this->input->post('crnt_anti_htn_duration_'.$row));
				$crnt_anti_htn_duration_type       = html_escape($this->input->post('crnt_anti_htn_duration_type_'.$row));
				
				if($crnt_anti_htn_condition_time & $crnt_anti_htn_duration){
					$anti_htn_advice_codition_time      = $crnt_anti_htn_condition_time;
					$anti_htn_advice_codition_time_type = $crnt_anti_htn_condition_time_type;
					$anti_htn_advice_codition_apply     = $crnt_anti_htn_condition_apply;
					$anti_htn_duration                  = $crnt_anti_htn_duration;
					$anti_htn_duration_type             = $crnt_anti_htn_duration_type;
				}else{
					$anti_htn_advice_codition_time      = null;
					$anti_htn_advice_codition_time_type = null;
					$anti_htn_advice_codition_apply     = null;
					$anti_htn_duration                  = null;
					$anti_htn_duration_type             = null;
				}
				
				if($anti_htn_name && $anti_htn_dose)
				{
					$crnt_anti_htn_dose_data = array(
									'anti_htn_patient_id' => $patient_id,
									'anti_htn_visit_id'   => $visit_id,
									'anti_htn_name'       => $anti_htn_name,
									'anti_htn_dose'       => $anti_htn_dose,
									'anti_htn_advice_codition_time'      => $anti_htn_advice_codition_time,
									'anti_htn_advice_codition_time_type' => $anti_htn_advice_codition_time_type,
									'anti_htn_advice_codition_apply'     => $anti_htn_advice_codition_apply,
									'anti_htn_duration'                  => $anti_htn_duration,
									'anti_htn_duration_type'             => $anti_htn_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
				}
			}
			endif;
			
			// current anti lipids
			$crnt_lipids_rows = $this->input->post('crnt_lipids_row');
			if($this->input->post('crnt_is_anti_lipids') == '1' && !empty($crnt_lipids_rows)):
			foreach($crnt_lipids_rows as $row)
			{
				$anti_lipid_name = html_escape($this->input->post('crnt_lipids_name_'.$row));
				$anti_lipid_dose = html_escape($this->input->post('crnt_lipids_value_'.$row));
				
				$crnt_anti_lipid_condition_time      = html_escape($this->input->post('crnt_lipids_condition_time_'.$row));
				$crnt_anti_lipid_condition_time_type = html_escape($this->input->post('crnt_lipids_condition_time_type_'.$row));
				$crnt_anti_lipid_condition_apply     = html_escape($this->input->post('crnt_lipids_condition_apply_'.$row));
				$crnt_anti_lipid_duration            = html_escape($this->input->post('crnt_lipids_duration_'.$row));
				$crnt_anti_lipid_duration_type       = html_escape($this->input->post('crnt_lipids_duration_type_'.$row));
				
				if($crnt_anti_lipid_condition_time & $crnt_anti_lipid_duration){
					$anti_lipid_advice_codition_time      = $crnt_anti_lipid_condition_time;
					$anti_lipid_advice_codition_time_type = $crnt_anti_lipid_condition_time_type;
					$anti_lipid_advice_codition_apply     = $crnt_anti_lipid_condition_apply;
					$anti_lipid_duration                  = $crnt_anti_lipid_duration;
					$anti_lipid_duration_type             = $crnt_anti_lipid_duration_type;
				}else{
					$anti_lipid_advice_codition_time      = null;
					$anti_lipid_advice_codition_time_type = null;
					$anti_lipid_advice_codition_apply     = null;
					$anti_lipid_duration                  = null;
					$anti_lipid_duration_type             = null;
				}
				
				if($anti_lipid_name && $anti_lipid_dose)
				{
					$crnt_anti_lipids_data = array(
									'anti_lipid_patient_id' => $patient_id,
									'anti_lipid_visit_id'   => $visit_id,
									'anti_lipid_name'       => $anti_lipid_name,
									'anti_lipid_dose'       => $anti_lipid_dose,
									'anti_lipid_advice_codition_time'      => $anti_lipid_advice_codition_time,
									'anti_lipid_advice_codition_time_type' => $anti_lipid_advice_codition_time_type,
									'anti_lipid_advice_codition_apply'     => $anti_lipid_advice_codition_apply,
									'anti_lipid_duration'                  => $anti_lipid_duration,
									'anti_lipid_duration_type'             => $anti_lipid_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
				}
			}
			endif;
			
			// current antiplatelets
			$crnt_aspirine_rows = $this->input->post('crnt_aspirine_row');
			if($this->input->post('crnt_is_aspirine') == '1' && !empty($crnt_aspirine_rows)):
			foreach($crnt_aspirine_rows as $row)
			{
				$antiplatelets_name = html_escape($this->input->post('crnt_aspirine_name_'.$row));
				$antiplatelets_dose = html_escape($this->input->post('crnt_aspirine_value_'.$row));
				
				$crnt_antiplatelets_condition_time      = html_escape($this->input->post('crnt_aspirine_condition_time_'.$row));
				$crnt_antiplatelets_condition_time_type = html_escape($this->input->post('crnt_aspirine_condition_time_type_'.$row));
				$crnt_antiplatelets_condition_apply     = html_escape($this->input->post('crnt_aspirine_condition_apply_'.$row));
				$crnt_antiplatelets_duration            = html_escape($this->input->post('crnt_aspirine_duration_'.$row));
				$crnt_antiplatelets_duration_type       = html_escape($this->input->post('crnt_aspirine_duration_type_'.$row));
				
				if($crnt_antiplatelets_condition_time & $crnt_antiplatelets_duration){
					$antiplatelets_advice_codition_time       = $crnt_antiplatelets_condition_time;
					$antiplatelets_advice_codition_time_type  = $crnt_antiplatelets_condition_time_type;
					$antiplatelets_advice_codition_apply      = $crnt_antiplatelets_condition_apply;
					$antiplatelets_duration                   = $crnt_antiplatelets_duration;
					$antiplatelets_duration_type              = $crnt_antiplatelets_duration_type;
				}else{
					$antiplatelets_advice_codition_time       = null;
					$antiplatelets_advice_codition_time_type  = null;
					$antiplatelets_advice_codition_apply      = null;
					$antiplatelets_duration                   = null;
					$antiplatelets_duration_type              = null;
				}
				
				if($antiplatelets_name && $antiplatelets_dose)
				{
					$crnt_antiplatelets_data = array(
									'antiplatelets_patient_id' => $patient_id,
									'antiplatelets_visit_id'   => $visit_id,
									'antiplatelets_name'       => $antiplatelets_name,
									'antiplatelets_dose'       => $antiplatelets_dose,
									'antiplatelets_advice_codition_time'      => $antiplatelets_advice_codition_time,
									'antiplatelets_advice_codition_time_type' => $antiplatelets_advice_codition_time_type,
									'antiplatelets_advice_codition_apply'     => $antiplatelets_advice_codition_apply,
									'antiplatelets_duration'                  => $antiplatelets_duration,
									'antiplatelets_duration_type'             => $antiplatelets_duration_type,
								);
					$this->Progress_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
				}
			}
			endif;
			
			// current anti obesity
			$crnt_obesity_rows = $this->input->post('crnt_obesity_row');
			if($this->input->post('crnt_is_anti_obesity') == '1' && !empty($crnt_obesity_rows)):
			foreach($crnt_obesity_rows as $row)
			{
				$anti_obesity_name = html_escape($this->input->post('crnt_obesity_name_'.$row));
				$anti_obesity_dose = html_escape($this->input->post('crnt_obesity_value_'.$row));
				
				$crnt_obesity_condition_time      = html_escape($this->input->post('crnt_obesity_condition_time_'.$row));
				$crnt_obesity_condition_time_type = html_escape($this->input->post('crnt_obesity_condition_time_type_'.$row));
				$crnt_obesity_condition_apply     = html_escape($this->input->post('crnt_obesity_condition_apply_'.$row));
				$crnt_obesity_duration            = html_escape($this->input->post('crnt_obesity_duration_'.$row));
				$crnt_obesity_duration_type       = html_escape($this->input->post('crnt_obesity_duration_type_'.$row));
				
				if($crnt_obesity_condition_time & $crnt_obesity_duration){
					$anti_obesity_advice_codition_time       = $crnt_obesity_condition_time;
					$anti_obesity_advice_codition_time_type  = $crnt_obesity_condition_time_type;
					$anti_obesity_advice_codition_apply      = $crnt_obesity_condition_apply;
					$anti_obesity_duration                   = $crnt_obesity_duration;
					$anti_obesity_duration_type              = $crnt_obesity_duration_type;
				}else{
					$anti_obesity_advice_codition_time       = null;
					$anti_obesity_advice_codition_time_type  = null;
					$anti_obesity_advice_codition_apply      = null;
					$anti_obesity_duration                   = null;
					$anti_obesity_duration_type              = null;
				}
				
				if($anti_obesity_name && $anti_obesity_dose)
				{
					$crnt_anti_obesity_data = array(
									'anti_obesity_patient_id' => $patient_id,
									'anti_obesity_visit_id'   => $visit_id,
									'anti_obesity_name'       => $anti_obesity_name,
									'anti_obesity_dose'       => $anti_obesity_dose,
									'anti_obesity_advice_codition_time'      => $anti_obesity_advice_codition_time,
									'anti_obesity_advice_codition_time_type' => $anti_obesity_advice_codition_time_type,
									'anti_obesity_advice_codition_apply'     => $anti_obesity_advice_codition_apply,
									'anti_obesity_duration'                  => $anti_obesity_duration,
									'anti_obesity_duration_type'             => $anti_obesity_duration_type,
								);
					$this->Progress_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
				}
			}
			endif;
			
			// current other
			$crnt_other_rows = $this->input->post('crnt_other_row');
			if($this->input->post('crnt_is_others') == '1' && !empty($crnt_other_rows)):
			foreach($crnt_other_rows as $row)
			{
				$other_name = html_escape($this->input->post('crnt_other_name_'.$row));
				$other_dose = html_escape($this->input->post('crnt_other_value_'.$row));
				
				$crnt_other_condition_time      = html_escape($this->input->post('crnt_other_condition_time_'.$row));
				$crnt_other_condition_time_type = html_escape($this->input->post('crnt_other_condition_time_type_'.$row));
				$crnt_other_condition_apply     = html_escape($this->input->post('crnt_other_condition_apply_'.$row));
				$crnt_other_duration            = html_escape($this->input->post('crnt_other_duration_'.$row));
				$crnt_other_duration_type       = html_escape($this->input->post('crnt_other_duration_type_'.$row));
				
				if($crnt_other_condition_time & $crnt_other_duration){
					$other_advice_codition_time        = $crnt_other_condition_time;
					$other_advice_codition_time_type   = $crnt_other_condition_time_type;
					$other_advice_codition_apply       = $crnt_other_condition_apply;
					$other_duration                    = $crnt_other_duration;
					$other_duration_type               = $crnt_other_duration_type;
				}else{
					$other_advice_codition_time        = null;
					$other_advice_codition_time_type   = null;
					$other_advice_codition_apply       = null;
					$other_duration                    = null;
					$other_duration_type               = null;
				}
				
				if($other_name && $other_dose)
				{
					$crnt_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
									'other_advice'     => $other_advice,
									'other_duration'   => $other_duration,
									'other_advice_codition_time'      => $other_advice_codition_time,
									'other_advice_codition_time_type' => $other_advice_codition_time_type,
									'other_advice_codition_apply'     => $other_advice_codition_apply,
									'other_duration'                  => $other_duration,
									'other_duration_type'             => $other_duration_type,
								);
					$this->Progress_model->save_visitcrnt_omedication_other($crnt_omedication_other);
				}
			}
			endif;
				
			//Save Payments
			$payment_satatus = $this->input->post('payment');
			$payment_data = array(
								'payment_visit_id'           => $visit_id,
								'payment_patient_id'         => $patient_id,
								'payment_patient_fee_amount' => $this->input->post('fee_amount'),
								'payment_patient_status'     => $payment_satatus,
							);
			$this->Progress_model->save_payment_data($payment_data);
			
			$result = array('has_been_updated' => 'YES');
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$result = array('has_been_updated' => 'NO');
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function delete()
	{
		$this->active_user = $this->input->post('active_user');
		$this->active_center = $this->input->post('active_center');
		$local_app_centers = $this->Common_model->get_local_app_centers();
		if($this->active_user === NULL && !in_array($this->active_center, $local_app_centers))
		{
			$result = array('status' => 'error', 'content' => 'This api is to be used in registered centers!');
			echo json_encode($result);
			exit;
		}
		
		$visit_id = $this->input->post('id');
		$patient_id = $this->input->post('pid');
		
		$this->db->where('vcomplication_visit_id', $visit_id);
		$this->db->where('vcomplication_patient_id', $patient_id);
		$this->db->delete('starter_visit_complication');
		
		$this->db->where('diagonosis_visit_id', $visit_id);
		$this->db->where('diagonosis_patient_id', $patient_id);
		$this->db->delete('starter_visit_diagonosis');
		
		$this->db->where('exercise_visit_id', $visit_id);
		$this->db->where('exercise_patient_id', $patient_id);
		$this->db->delete('starter_visit_exercise');
		
		$this->db->where('fmhistory_visit_id', $visit_id);
		$this->db->where('fmhistory_patient_id', $patient_id);
		$this->db->delete('starter_visit_family_history');
		
		$this->db->where('generalexam_visit_id', $visit_id);
		$this->db->where('generalexam_patient_id', $patient_id);
		$this->db->delete('starter_visit_general_examinations');
		
		$this->db->where('ecg_visit_id', $visit_id);
		$this->db->where('ecg_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_ecg');
		
		$this->db->where('labinvs_visit_id', $visit_id);
		$this->db->where('labinvs_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_investigations');
		
		$this->db->where('management_visit_id', $visit_id);
		$this->db->where('management_patient_id', $patient_id);
		$this->db->delete('starter_visit_management');
		
		$this->db->where('menstrlc_visit_id', $visit_id);
		$this->db->where('menstrlc_patient_id', $patient_id);
		$this->db->delete('starter_visit_menstrual_cycle');
		
		$this->db->where('payment_visit_id', $visit_id);
		$this->db->where('payment_patient_id', $patient_id);
		$this->db->delete('starter_visit_payments');
		
		$this->db->where('phabit_visit_id', $visit_id);
		$this->db->where('phabit_patient_id', $patient_id);
		$this->db->delete('starter_visit_personal_habits');
		
		$this->db->where('cooking_oil_visit_id', $visit_id);
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_cooking_oil');
		
		$this->db->where('diehist_visit_id', $visit_id);
		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_dietary_history');
		
		$this->db->where('physical_act_visit_id', $visit_id);
		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_physical_activity');
		
		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_antiplatelets');
		
		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_htn');
		
		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_lipids');
		
		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_obesity');
		
		$this->db->where('cardiac_medication_visit_id', $visit_id);
		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_cardiac_medication');
		
		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_insulin');
		
		$this->db->where('oads_visit_id', $visit_id);
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_oads');
		
		$this->db->where('other_visit_id', $visit_id);
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_other');
		
		$this->db->where('cooking_oil_visit_id', $visit_id);
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_cooking_oil');

		$this->db->where('diehist_visit_id', $visit_id);
		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_dietary_history');

		$this->db->where('physical_act_visit_id', $visit_id);
		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_physical_activity');

		$this->db->where('antiplatelets_visit_id', $visit_id);
		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_antiplatelets');

		$this->db->where('anti_htn_visit_id', $visit_id);
		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_htn');

		$this->db->where('anti_lipid_visit_id', $visit_id);
		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_lipids');

		$this->db->where('anti_obesity_visit_id', $visit_id);
		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_obesity');

		$this->db->where('cardiac_medication_visit_id', $visit_id);
		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_cardiac_medication');

		$this->db->where('insulin_visit_id', $visit_id);
		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_insulin');

		$this->db->where('oads_visit_id', $visit_id);
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_oads');

		$this->db->where('other_visit_id', $visit_id);
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_others');
		
		$this->db->where('visit_id', $visit_id);
		$this->db->where('visit_patient_id', $patient_id);
		$this->db->delete('starter_patient_visit');
		
		$result = array("has_been_deleted" => "YES");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
