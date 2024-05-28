<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit extends CI_Controller {
	
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
	  $this->load->model('patients/Visit_model', 'Visit_model', true);
	  $this->load->helper('custom_string');
	  $this->load->model('Common_model');
	}
	
	private function get_visit_org_id($center_id)
	{
		$og_id = $this->Visit_model->get_org_by_centerid($center_id);
		return $og_id;
	}
	
	public function sync()
	{
		$p_entryid = $this->input->post('patient_bndr_id');
		$patient_id = $this->Visit_model->get_patient_id($p_entryid);
		$params = array(
			'visit_number' => $this->input->post('visit_number'), 
			'visit_is' => $this->input->post('visit_is'), 
			'visit_form_version' => $this->input->post('visit_form_version'), 
			'visit_entryid' => $this->input->post('visit_entryid'), 
			'visit_serial_no' => $this->input->post('visit_serial_no'), 
			'visit_patient_id' => $patient_id, 
			'visit_org_centerid' => $this->input->post('visit_org_centerid'), 
			'visit_type' => $this->input->post('visit_type'), 
			'visit_registration_date' => $this->input->post('visit_registration_date'), 
			'visit_date' => $this->input->post('visit_date'), 
			'visit_has_symptomatic' => $this->input->post('visit_has_symptomatic'), 
			'visit_symptomatic_type' => $this->input->post('visit_symptomatic_type'), 
			'visit_patient_type' => $this->input->post('visit_patient_type'), 
			'visit_diabetes_duration' => $this->input->post('visit_diabetes_duration'), 
			'visit_registration_org_id' => $this->input->post('visit_registration_org_id'), 
			'visit_org_id' => $this->input->post('visit_org_id'), 
			'visit_registration_center' => $this->input->post('visit_registration_center'), 
			'visit_visit_center' => $this->input->post('visit_visit_center'), 
			'visit_doctor' => $this->input->post('visit_doctor'), 
			'visit_guidebook_no' => $this->input->post('visit_guidebook_no'), 
			'visit_types_of_diabetes' => $this->input->post('visit_types_of_diabetes'), 
			'visit_admit_date' => $this->input->post('visit_admit_date'), 
			'visit_admited_by' => $this->input->post('visit_admited_by'), 
			'visit_admited_by_usertype' => $this->input->post('visit_admited_by_usertype'),
			'visit_sync_id'          => $this->input->post('visit_sync_id'),
		  );
		  
		
		//Save basic visit informations
		$ins_id = $this->Visit_model->save_visit_information($params);
		$visit_id = $this->db->insert_id($ins_id);
		
		//Save visit personal habit
		$visit_personal_habit = $this->input->post('visit_personal_habit');
		foreach($visit_personal_habit as $data)
		{
			$phabit_data = array(
								'phabit_patient_id'    => $patient_id,
								'phabit_visit_id'      => $visit_id,
								'phabit_name'          => $data['phabit_name'], 
							);
			$this->Visit_model->save_visit_personal_habits($phabit_data);
		}

		//Save visit family history
		$visit_family_history = $this->input->post('visit_personal_habit');
		foreach($visit_family_history as $data)
		{
			$fmhistory_data = array(
								'fmhistory_patient_id' => $patient_id,
								'fmhistory_visit_id'   => $visit_id,
								'fmhistory_name'       => $data['fmhistory_name'],
							);
			$this->Visit_model->save_visit_family_history($fmhistory_data);
		}

		//Save visit diabetes history
		$diabetes_history_data = array(
									'dhistory_patient_id'                 => $patient_id,
									'dhistory_visit_id'                   => $visit_id,
									'dhistory_type_of_glucose'            => $this->input->post('dhistory_type_of_glucose'), 
									'dhistory_duration_of_glucose'        => $this->input->post('dhistory_duration_of_glucose'), 
									'dhistory_prev_bad_obstetric_history' => $this->input->post('dhistory_prev_bad_obstetric_history'), 
									'dhistory_prev_history_of_gdm'        => $this->input->post('dhistory_prev_history_of_gdm'), 
									'dhistory_past_medical_history'       => $this->input->post('dhistory_past_medical_history'), 
									'dhistory_symptoms_at_diagnosis'      => $this->input->post('dhistory_symptoms_at_diagnosis'), 
									'dhistory_symptoms_at_diagnosis_types'=> $this->input->post('dhistory_symptoms_at_diagnosis_types'), 
									'dhistory_other_complaints'           => $this->input->post('dhistory_other_complaints'),
								);
		$this->Visit_model->save_diabetes_history($diabetes_history_data);

		//Save visit complication
		$visit_complication = $this->input->post('visit_complication');
		foreach($visit_complication as $data)
		{
			$complication_data = array(
									'vcomplication_patient_id' => $patient_id,
									'vcomplication_visit_id'   => $visit_id,
									'vcomplication_name'       => $data['vcomplication_name'], 
								);
			$this->Visit_model->save_visit_complication($complication_data);
		}

		//Save visit general examination
		$visit_general_examination = $this->input->post('visit_general_examination');
		foreach($visit_general_examination as $data)
		{
			$general_exam_data = array(
									'generalexam_patient_id' => $patient_id,
									'generalexam_visit_id'   => $visit_id,
									'generalexam_name'       => $data['generalexam_name'], 
									'generalexam_value'      => $data['generalexam_value'], 
									'generalexam_unit'       => $data['generalexam_unit'],
								);
			$this->Visit_model->save_visit_general_examination($general_exam_data);
		}

		//Save visit general examination other content
		$g_other_content = array(
								'gexamother_patient_id' => $patient_id,
								'gexamother_visit_id'   => $visit_id,
								'gexamother_content'    => $this->input->post('gexamother_content'),
							);
		$this->Visit_model->save_visit_general_other_content($g_other_content);

		//Save visit Foot examination
		$foot_examination_data = array(
									'footexm_patient_id'    => $patient_id,
									'footexm_visit_id'      => $visit_id,
									'footexm_date'          => $this->input->post('footexm_date'), 
									'footexm_doctor_name'   => $this->input->post('footexm_doctor_name'), 
									'footexm_doctor_id'     => $this->input->post('footexm_doctor_id'), 
									'footexm_other_content' => $this->input->post('footexm_other_content'),
								);
		$this->Visit_model->save_foot_exam_info($foot_examination_data);

		//Save foot examination periferal pulse
		$foot_examination_periferal_data = array(
												'footexmprfl_patient_id'                      => $patient_id,
												'footexmprfl_visit_id'                        => $visit_id,
												'footexmprfl_arteria_dorsalis_predis_present' => $this->input->post('footexmprfl_arteria_dorsalis_predis_present'), 
												'footexmprfl_arteria_dorsalis_predis_absent'  => $this->input->post('footexmprfl_arteria_dorsalis_predis_absent'), 
												'footexmprfl_posterior_tribila_present'       => $this->input->post('footexmprfl_posterior_tribila_present'), 
												'footexmprfl_posterior_tribila_absent'        => $this->input->post('footexmprfl_posterior_tribila_absent'),
											);
		$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);

		//Save foot examination sensation
		$foot_examination_sensation_data = array(
												'footexmsns_patient_id'           => $patient_id,
												'footexmsns_visit_id'             => $visit_id,
												'footexmsns_monofilament_present' => $this->input->post('footexmsns_monofilament_present'), 
												'footexmsns_monofilament_absent'  => $this->input->post('footexmsns_monofilament_absent'), 
												'footexmsns_tuning_fork_present'  => $this->input->post('footexmsns_tuning_fork_present'), 
												'footexmsns_tuning_fork_absent'   => $this->input->post('footexmsns_tuning_fork_absent'),
											);
		$this->Visit_model->save_foot_exam_sensation_info($foot_examination_sensation_data);

		//Save visit diatory history
		$visit_diatory_history = $this->input->post('visit_diatory_history');
		foreach($visit_diatory_history as $data)
		{
			$diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name' => $data['diehist_name'],
									'diehist_daily' => $data['diehist_daily'],
									'diehist_weekly' => $data['diehist_weekly'],
								);
			$this->Visit_model->save_visit_dietary_history($diatory_history);
		}

		//Save visit phisical activity
		$visit_phisical_activity = $this->input->post('visit_phisical_activity');
		foreach($visit_phisical_activity as $data)
		{
			$phisical_activity = array(
										'physical_act_patient_id'     => $patient_id,
										'physical_act_visit_id'       => $visit_id,
										'physical_act_type' => $data['physical_act_type'], 
										'physical_act_duration_a_day' => $data['physical_act_duration_a_day'], 
										'physical_act_duration_a_week' => $data['physical_act_duration_a_week'],
									);
			$this->Visit_model->save_visit_phisical_actitivites($phisical_activity);
		}

		//Save Eye examination
		$eye_examination_data = array(
									'eyeexam_patient_id'  => $patient_id,
									'eyeexam_visit_id'    => $visit_id,
									'eyeexam_date'        => $this->input->post('eyeexam_date'), 
									'eyeexam_left_eye'    => $this->input->post('eyeexam_left_eye'), 
									'eyeexam_right_eye'   => $this->input->post('eyeexam_right_eye'), 
									'eyeexam_other'       => $this->input->post('eyeexam_other'), 
									'eyeexam_treatment'   => $this->input->post('eyeexam_treatment'), 
									'eyeexam_doctor_name' => $this->input->post('eyeexam_doctor_name'), 
									'eyeexam_doctor_id'   => $this->input->post('eyeexam_doctor_id'),
								);
		$this->Visit_model->save_visit_eye_exam_info($eye_examination_data);

		//Save visit laboratory investigation
		$visit_laboratory_investigation = $this->input->post('visit_laboratory_investigation');
		foreach($visit_laboratory_investigation as $data)
		{
			$laboratory_investigation = array(
												'labinvs_patient_id' => $patient_id,
												'labinvs_visit_id'   => $visit_id,
												'labinvs_name'       => $data['labinvs_name'], 
												'labinvs_value'      => $data['labinvs_value'], 
												'labinvs_unit'       => $data['labinvs_unit'],
											);
			$this->Visit_model->save_visit_laboratory_investigation($laboratory_investigation);
		}

		//Save visit laboratory investigation ECG
		$ecg_data = array(
						'ecg_patient_id' => $patient_id,
						'ecg_visit_id'   => $visit_id,
						'ecg_type'       => $this->input->post('ecg_type'), 
						'ecg_abnormals'  => $this->input->post('ecg_abnormals'),
					);
		$this->Visit_model->save_visit_laboratory_ecg($ecg_data);


		//Save Drug History
		$drug_history_data = array(
								'drughistory_patient_id'                => $patient_id,
								'drughistory_visit_id'                  => $visit_id,
								'drughistory_date'                      => $this->input->post('drughistory_date'), 
								'drughistory_fdiagnosis'                => $this->input->post('drughistory_fdiagnosis'), 
								'drughistory_other_associated_diseases' => $this->input->post('drughistory_other_associated_diseases'),
							);
		$this->Visit_model->save_visit_drug_history($drug_history_data);

		// Prev OADs
		$visit_prev_oads = $this->input->post('visit_prev_oads');
		foreach($visit_prev_oads as $data)
		{
			$oads_data = array(
							'oads_patient_id' => $patient_id,
							'oads_visit_id'   => $visit_id,
							'oads_name' => $data['oads_name'], 
							'oads_dose' => $data['oads_dose'], 
							'oads_advice_codition_time' => $data['oads_advice_codition_time'], 
							'oads_advice_codition_time_type' => $data['oads_advice_codition_time_type'], 
							'oads_advice_codition_apply' => $data['oads_advice_codition_apply'], 
							'oads_duration' => $data['oads_duration'], 
							'oads_duration_type' => $data['oads_duration_type'],
						);
			$this->Visit_model->save_visitprev_oads($oads_data);
		}

		// Prev Insulin
		$visit_prev_insulin = $this->input->post('visit_prev_insulin');
		foreach($visit_prev_insulin as $data)
		{
			$prev_insulin_data = array(
										'insulin_patient_id' => $patient_id,
										'insulin_visit_id'   => $visit_id,
										'insulin_name' => $data['insulin_name'], 
										'insulin_dose' => $data['insulin_dose'], 
										'insulin_advice_codition_time' => $data['insulin_advice_codition_time'], 
										'insulin_advice_codition_time_type' => $data['insulin_advice_codition_time_type'], 
										'insulin_advice_codition_apply' => $data['insulin_advice_codition_apply'], 
										'insulin_duration' => $data['insulin_duration'], 
										'insulin_duration_type' => $data['insulin_duration_type'],
									);
			$this->Visit_model->save_visitprev_insulin($prev_insulin_data);
		}


		// prev anti htn
		$visit_prev_anti_htn = $this->input->post('visit_prev_anti_htn');
		foreach($visit_prev_anti_htn as $data)
		{
			$anti_htn_dose_data = array(
										'anti_htn_patient_id' => $patient_id,
										'anti_htn_visit_id'   => $visit_id,
										'anti_htn_name' => $data['anti_htn_name'], 
										'anti_htn_dose' => $data['anti_htn_dose'], 
										'anti_htn_advice_codition_time' => $data['anti_htn_advice_codition_time'], 
										'anti_htn_advice_codition_time_type' => $data['anti_htn_advice_codition_time_type'], 
										'anti_htn_advice_codition_apply' => $data['anti_htn_advice_codition_apply'], 
										'anti_htn_duration' => $data['anti_htn_duration'], 
										'anti_htn_duration_type' => $data['anti_htn_duration_type'],
									);
			$this->Visit_model->save_visitprev_anti_htn($anti_htn_dose_data);
		}

		// prev anti lipids
		$visit_prev_anti_lipids = $this->input->post('visit_prev_anti_lipids');
		foreach($visit_prev_anti_lipids as $data)
		{
			$prev_anti_lipids_data = array(
											'anti_lipid_patient_id' => $patient_id,
											'anti_lipid_visit_id'   => $visit_id,
											'anti_lipid_name' => $data['anti_lipid_name'], 
											'anti_lipid_dose' => $data['anti_lipid_dose'], 
											'anti_lipid_advice_codition_time' => $data['anti_lipid_advice_codition_time'],
											'anti_lipid_advice_codition_time_type' => $data['anti_lipid_advice_codition_time_type'], 
											'anti_lipid_advice_codition_apply' => $data['anti_lipid_advice_codition_apply'], 
											'anti_lipid_duration' => $data['anti_lipid_duration'], 
											'anti_lipid_duration_type' => $data['anti_lipid_duration_type'],
										);
			$this->Visit_model->save_visitprev_anti_lipids($prev_anti_lipids_data);
		}

		// prev antiplatelets
		$visit_prev_antiplatelets = $this->input->post('visit_prev_antiplatelets');
		foreach($visit_prev_antiplatelets as $data)
		{
			$prev_antiplatelets_data = array(
											'antiplatelets_patient_id' => $patient_id,
											'antiplatelets_visit_id'   => $visit_id,
											'antiplatelets_name' => $data['antiplatelets_name'], 
											'antiplatelets_dose' => $data['antiplatelets_dose'], 
											'antiplatelets_advice_codition_time' => $data['antiplatelets_advice_codition_time'], 
											'antiplatelets_advice_codition_time_type' => $data['antiplatelets_advice_codition_time_type'], 
											'antiplatelets_advice_codition_apply' => $data['antiplatelets_advice_codition_apply'], 
											'antiplatelets_duration' => $data['antiplatelets_duration'], 
											'antiplatelets_duration_type' => $data['antiplatelets_duration_type'],
										);
			$this->Visit_model->save_visitprev_antiplatelets($prev_antiplatelets_data);
		}

		// prev anti obesity
		$visit_prev_anti_obesity = $this->input->post('visit_prev_anti_obesity');
		foreach($visit_prev_anti_obesity as $data)
		{
			$prev_anti_obesity_data = array(
											'anti_obesity_patient_id' => $patient_id,
											'anti_obesity_visit_id'   => $visit_id,
											'anti_obesity_name' => $data['anti_obesity_name'], 
											'anti_obesity_dose' => $data['anti_obesity_dose'], 
											'anti_obesity_advice_codition_time' => $data['anti_obesity_advice_codition_time'], 
											'anti_obesity_advice_codition_time_type' => $data['anti_obesity_advice_codition_time_type'], 
											'anti_obesity_advice_codition_apply' => $data['anti_obesity_advice_codition_apply'], 
											'anti_obesity_duration' => $data['anti_obesity_duration'], 
											'anti_obesity_duration_type' => $data['anti_obesity_duration_type'],
										);
			$this->Visit_model->save_visitprev_anti_obesity($prev_anti_obesity_data);
		}

		// prev other
		$visit_prev_other = $this->input->post('visit_prev_other');
		foreach($visit_prev_other as $data)
		{
			$prev_omedication_other = array(
											'other_patient_id' => $patient_id,
											'other_visit_id'   => $visit_id,
											'other_name' => $data['other_name'], 
											'other_dose' => $data['other_dose'], 
											'other_advice_codition_time' => $data['other_advice_codition_time'], 
											'other_advice_codition_time_type' => $data['other_advice_codition_time_type'], 
											'other_advice_codition_apply' => $data['other_advice_codition_apply'], 
											'other_duration' => $data['other_duration'], 
											'other_duration_type' => $data['other_duration_type'], 
										);
			$this->Visit_model->save_visitprev_omedication_other($prev_omedication_other);
		}

		//Save Final Treatment
		$final_treatment_data = array(
									'finaltreat_patient_id'        => $patient_id,
									'finaltreat_visit_id'          => $visit_id,
									'finaltreat_doctor_name'       => $this->input->post('finaltreat_doctor_name'), 
									'finaltreat_doctor_id'         => $this->input->post('finaltreat_doctor_id'), 
									'finaltreat_date'              => $this->input->post('finaltreat_date'), 
									'finaltreat_dietary_advice'    => $this->input->post('finaltreat_dietary_advice'), 
									'finaltreat_physical_acitvity' => $this->input->post('finaltreat_physical_acitvity'), 
									'finaltreat_diet_no'           => $this->input->post('finaltreat_diet_no'), 
									'finaltreat_page_no'           => $this->input->post('finaltreat_page_no'), 
									'finaltreat_next_visit_date'   => $this->input->post('finaltreat_next_visit_date'), 
									'finaltreat_next_investigation'=> $this->input->post('finaltreat_next_investigation'),
								);
		$this->Visit_model->save_final_treatment_infos($final_treatment_data);

		// current OADs
		$visit_crnt_oads = $this->input->post('visit_crnt_oads');
		foreach($visit_crnt_oads as $data)
		{
			$crnt_oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name' => $data['oads_name'], 
									'oads_dose' => $data['oads_dose'], 
									'oads_advice_codition_time' => $data['oads_advice_codition_time'], 
									'oads_advice_codition_time_type' => $data['oads_advice_codition_time_type'], 
									'oads_advice_codition_apply' => $data['oads_advice_codition_apply'], 
									'oads_duration' => $data['oads_duration'], 
									'oads_duration_type' => $data['oads_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_oads($crnt_oads_data);
		}

		// current insulin
		$visit_crnt_insulin = $this->input->post('visit_crnt_insulin');
		foreach($visit_crnt_insulin as $data)
		{
			$crnt_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name' => $data['insulin_name'], 
									'insulin_dose' => $data['insulin_dose'], 
									'insulin_advice_codition_time' => $data['insulin_advice_codition_time'], 
									'insulin_advice_codition_time_type' => $data['insulin_advice_codition_time_type'], 
									'insulin_advice_codition_apply' => $data['insulin_advice_codition_apply'], 
									'insulin_duration' => $data['insulin_duration'], 
									'insulin_duration_type' => $data['insulin_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_insulin($crnt_insulin_data);
		}

		// current anti htn
		$visit_crnt_anti_htn = $this->input->post('visit_crnt_anti_htn');
		foreach($visit_crnt_anti_htn as $data)
		{
			$crnt_anti_htn_dose_data = array(
									'anti_htn_patient_id' => $patient_id,
									'anti_htn_visit_id'   => $visit_id,
									'anti_htn_name' => $data['anti_htn_name'], 
									'anti_htn_dose' => $data['anti_htn_dose'], 
									'anti_htn_advice_codition_time' => $data['anti_htn_advice_codition_time'], 
									'anti_htn_advice_codition_time_type' => $data['anti_htn_advice_codition_time_type'], 
									'anti_htn_advice_codition_apply' => $data['anti_htn_advice_codition_apply'], 
									'anti_htn_duration' => $data['anti_htn_duration'], 
									'anti_htn_duration_type' => $data['anti_htn_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
		}

		// current anti lipids
		$visit_crnt_anti_lipids = $this->input->post('visit_crnt_anti_lipids');
		foreach($visit_crnt_anti_lipids as $data)
		{
			$crnt_anti_lipids_data = array(
										'anti_lipid_patient_id' => $patient_id,
										'anti_lipid_visit_id'   => $visit_id,
										'anti_lipid_name' => $data['anti_lipid_name'], 
										'anti_lipid_dose' => $data['anti_lipid_dose'], 
										'anti_lipid_advice_codition_time' => $data['anti_lipid_advice_codition_time'],
										'anti_lipid_advice_codition_time_type' => $data['anti_lipid_advice_codition_time_type'], 
										'anti_lipid_advice_codition_apply' => $data['anti_lipid_advice_codition_apply'], 
										'anti_lipid_duration' => $data['anti_lipid_duration'], 
										'anti_lipid_duration_type' => $data['anti_lipid_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
		}

		// current antiplatelets
		$visit_crnt_antiplatelets = $this->input->post('visit_crnt_antiplatelets');
		foreach($visit_crnt_antiplatelets as $data)
		{
			$crnt_antiplatelets_data = array(
										'antiplatelets_patient_id' => $patient_id,
										'antiplatelets_visit_id'   => $visit_id,
										'antiplatelets_name' => $data['antiplatelets_name'], 
										'antiplatelets_dose' => $data['antiplatelets_dose'], 
										'antiplatelets_advice_codition_time' => $data['antiplatelets_advice_codition_time'], 
										'antiplatelets_advice_codition_time_type' => $data['antiplatelets_advice_codition_time_type'], 
										'antiplatelets_advice_codition_apply' => $data['antiplatelets_advice_codition_apply'], 
										'antiplatelets_duration' => $data['antiplatelets_duration'], 
										'antiplatelets_duration_type' => $data['antiplatelets_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
		}

		// current anti obesity
		$visit_crnt_anti_obesity = $this->input->post('visit_crnt_anti_obesity');
		foreach($visit_crnt_anti_obesity as $data)
		{
			$crnt_anti_obesity_data = array(
										'anti_obesity_patient_id' => $patient_id,
										'anti_obesity_visit_id'   => $visit_id,
										'anti_obesity_name' => $data['anti_obesity_name'], 
										'anti_obesity_dose' => $data['anti_obesity_dose'], 
										'anti_obesity_advice_codition_time' => $data['anti_obesity_advice_codition_time'], 
										'anti_obesity_advice_codition_time_type' => $data['anti_obesity_advice_codition_time_type'], 
										'anti_obesity_advice_codition_apply' => $data['anti_obesity_advice_codition_apply'], 
										'anti_obesity_duration' => $data['anti_obesity_duration'], 
										'anti_obesity_duration_type' => $data['anti_obesity_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
		}

		// current other
		$visit_crnt_other = $this->input->post('visit_crnt_other');
		foreach($visit_crnt_other as $data)
		{
			$crnt_omedication_other = array(
										'other_patient_id' => $patient_id,
										'other_visit_id'   => $visit_id,
										'other_name' => $data['other_name'], 
										'other_dose' => $data['other_dose'], 
										'other_advice_codition_time' => $data['other_advice_codition_time'], 
										'other_advice_codition_time_type' => $data['other_advice_codition_time_type'], 
										'other_advice_codition_apply' => $data['other_advice_codition_apply'], 
										'other_duration' => $data['other_duration'], 
										'other_duration_type' => $data['other_duration_type'], 
									);
			$this->Visit_model->save_visitcrnt_omedication_other($crnt_omedication_other);
		}

		//Save Payments
		$payment_data = array(
							'payment_visit_id'           => $visit_id,
							'payment_patient_id'         => $patient_id,
							'payment_patient_fee_amount' => $this->input->post('payment_patient_fee_amount'), 
							'payment_patient_status'     => $this->input->post('payment_patient_status'),
						);
		$this->Visit_model->save_payment_data($payment_data);
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sync_update()
	{
		$p_entryid = $this->input->post('patient_bndr_id');
		$patient_id = $this->Visit_model->get_patient_id($p_entryid);
		$params = array(
			'visit_number' => $this->input->post('visit_number'), 
			'visit_is' => $this->input->post('visit_is'), 
			'visit_form_version' => $this->input->post('visit_form_version'), 
			'visit_serial_no' => $this->input->post('visit_serial_no'), 
			'visit_org_centerid' => $this->input->post('visit_org_centerid'), 
			'visit_type' => $this->input->post('visit_type'), 
			'visit_registration_date' => $this->input->post('visit_registration_date'), 
			'visit_date' => $this->input->post('visit_date'), 
			'visit_has_symptomatic' => $this->input->post('visit_has_symptomatic'), 
			'visit_symptomatic_type' => $this->input->post('visit_symptomatic_type'), 
			'visit_patient_type' => $this->input->post('visit_patient_type'), 
			'visit_diabetes_duration' => $this->input->post('visit_diabetes_duration'), 
			'visit_registration_org_id' => $this->input->post('visit_registration_org_id'), 
			'visit_org_id' => $this->input->post('visit_org_id'), 
			'visit_registration_center' => $this->input->post('visit_registration_center'), 
			'visit_visit_center' => $this->input->post('visit_visit_center'), 
			'visit_doctor' => $this->input->post('visit_doctor'), 
			'visit_guidebook_no' => $this->input->post('visit_guidebook_no'), 
			'visit_types_of_diabetes' => $this->input->post('visit_types_of_diabetes'), 
			'visit_admit_date' => $this->input->post('visit_admit_date'), 
			'visit_admited_by' => $this->input->post('visit_admited_by'), 
			'visit_admited_by_usertype' => $this->input->post('visit_admited_by_usertype'),
		  );
		  
		
		//Save basic visit informations
		$visit_entryid = $this->input->post('visit_entryid')
		$visit_id = $this->Visit_model->get_visit_id($visit_entryid);
		$this->Visit_model->update_sync($visit_entryid, $params);
		
		//Delete Old visit informations
		$this->Visit_model->delete_old_visit_information($visit_id);
		
		//Save visit personal habit
		$visit_personal_habit = $this->input->post('visit_personal_habit');
		foreach($visit_personal_habit as $data)
		{
			$phabit_data = array(
								'phabit_patient_id'    => $patient_id,
								'phabit_visit_id'      => $visit_id,
								'phabit_name'          => $data['phabit_name'], 
							);
			$this->Visit_model->save_visit_personal_habits($phabit_data);
		}

		//Save visit family history
		$visit_family_history = $this->input->post('visit_personal_habit');
		foreach($visit_family_history as $data)
		{
			$fmhistory_data = array(
								'fmhistory_patient_id' => $patient_id,
								'fmhistory_visit_id'   => $visit_id,
								'fmhistory_name'       => $data['fmhistory_name'],
							);
			$this->Visit_model->save_visit_family_history($fmhistory_data);
		}

		//Save visit diabetes history
		$diabetes_history_data = array(
									'dhistory_patient_id'                 => $patient_id,
									'dhistory_visit_id'                   => $visit_id,
									'dhistory_type_of_glucose'            => $this->input->post('dhistory_type_of_glucose'), 
									'dhistory_duration_of_glucose'        => $this->input->post('dhistory_duration_of_glucose'), 
									'dhistory_prev_bad_obstetric_history' => $this->input->post('dhistory_prev_bad_obstetric_history'), 
									'dhistory_prev_history_of_gdm'        => $this->input->post('dhistory_prev_history_of_gdm'), 
									'dhistory_past_medical_history'       => $this->input->post('dhistory_past_medical_history'), 
									'dhistory_symptoms_at_diagnosis'      => $this->input->post('dhistory_symptoms_at_diagnosis'), 
									'dhistory_symptoms_at_diagnosis_types'=> $this->input->post('dhistory_symptoms_at_diagnosis_types'), 
									'dhistory_other_complaints'           => $this->input->post('dhistory_other_complaints'),
								);
		$this->Visit_model->save_diabetes_history($diabetes_history_data);

		//Save visit complication
		$visit_complication = $this->input->post('visit_complication');
		foreach($visit_complication as $data)
		{
			$complication_data = array(
									'vcomplication_patient_id' => $patient_id,
									'vcomplication_visit_id'   => $visit_id,
									'vcomplication_name'       => $data['vcomplication_name'], 
								);
			$this->Visit_model->save_visit_complication($complication_data);
		}

		//Save visit general examination
		$visit_general_examination = $this->input->post('visit_general_examination');
		foreach($visit_general_examination as $data)
		{
			$general_exam_data = array(
									'generalexam_patient_id' => $patient_id,
									'generalexam_visit_id'   => $visit_id,
									'generalexam_name'       => $data['generalexam_name'], 
									'generalexam_value'      => $data['generalexam_value'], 
									'generalexam_unit'       => $data['generalexam_unit'],
								);
			$this->Visit_model->save_visit_general_examination($general_exam_data);
		}

		//Save visit general examination other content
		$g_other_content = array(
								'gexamother_patient_id' => $patient_id,
								'gexamother_visit_id'   => $visit_id,
								'gexamother_content'    => $this->input->post('gexamother_content'),
							);
		$this->Visit_model->save_visit_general_other_content($g_other_content);

		//Save visit Foot examination
		$foot_examination_data = array(
									'footexm_patient_id'    => $patient_id,
									'footexm_visit_id'      => $visit_id,
									'footexm_date'          => $this->input->post('footexm_date'), 
									'footexm_doctor_name'   => $this->input->post('footexm_doctor_name'), 
									'footexm_doctor_id'     => $this->input->post('footexm_doctor_id'), 
									'footexm_other_content' => $this->input->post('footexm_other_content'),
								);
		$this->Visit_model->save_foot_exam_info($foot_examination_data);

		//Save foot examination periferal pulse
		$foot_examination_periferal_data = array(
												'footexmprfl_patient_id'                      => $patient_id,
												'footexmprfl_visit_id'                        => $visit_id,
												'footexmprfl_arteria_dorsalis_predis_present' => $this->input->post('footexmprfl_arteria_dorsalis_predis_present'), 
												'footexmprfl_arteria_dorsalis_predis_absent'  => $this->input->post('footexmprfl_arteria_dorsalis_predis_absent'), 
												'footexmprfl_posterior_tribila_present'       => $this->input->post('footexmprfl_posterior_tribila_present'), 
												'footexmprfl_posterior_tribila_absent'        => $this->input->post('footexmprfl_posterior_tribila_absent'),
											);
		$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);

		//Save foot examination sensation
		$foot_examination_sensation_data = array(
												'footexmsns_patient_id'           => $patient_id,
												'footexmsns_visit_id'             => $visit_id,
												'footexmsns_monofilament_present' => $this->input->post('footexmsns_monofilament_present'), 
												'footexmsns_monofilament_absent'  => $this->input->post('footexmsns_monofilament_absent'), 
												'footexmsns_tuning_fork_present'  => $this->input->post('footexmsns_tuning_fork_present'), 
												'footexmsns_tuning_fork_absent'   => $this->input->post('footexmsns_tuning_fork_absent'),
											);
		$this->Visit_model->save_foot_exam_sensation_info($foot_examination_sensation_data);

		//Save visit diatory history
		$visit_diatory_history = $this->input->post('visit_diatory_history');
		foreach($visit_diatory_history as $data)
		{
			$diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name' => $data['diehist_name'],
									'diehist_daily' => $data['diehist_daily'],
									'diehist_weekly' => $data['diehist_weekly'],
								);
			$this->Visit_model->save_visit_dietary_history($diatory_history);
		}

		//Save visit phisical activity
		$visit_phisical_activity = $this->input->post('visit_phisical_activity');
		foreach($visit_phisical_activity as $data)
		{
			$phisical_activity = array(
										'physical_act_patient_id'     => $patient_id,
										'physical_act_visit_id'       => $visit_id,
										'physical_act_type' => $data['physical_act_type'], 
										'physical_act_duration_a_day' => $data['physical_act_duration_a_day'], 
										'physical_act_duration_a_week' => $data['physical_act_duration_a_week'],
									);
			$this->Visit_model->save_visit_phisical_actitivites($phisical_activity);
		}

		//Save Eye examination
		$eye_examination_data = array(
									'eyeexam_patient_id'  => $patient_id,
									'eyeexam_visit_id'    => $visit_id,
									'eyeexam_date'        => $this->input->post('eyeexam_date'), 
									'eyeexam_left_eye'    => $this->input->post('eyeexam_left_eye'), 
									'eyeexam_right_eye'   => $this->input->post('eyeexam_right_eye'), 
									'eyeexam_other'       => $this->input->post('eyeexam_other'), 
									'eyeexam_treatment'   => $this->input->post('eyeexam_treatment'), 
									'eyeexam_doctor_name' => $this->input->post('eyeexam_doctor_name'), 
									'eyeexam_doctor_id'   => $this->input->post('eyeexam_doctor_id'),
								);
		$this->Visit_model->save_visit_eye_exam_info($eye_examination_data);

		//Save visit laboratory investigation
		$visit_laboratory_investigation = $this->input->post('visit_laboratory_investigation');
		foreach($visit_laboratory_investigation as $data)
		{
			$laboratory_investigation = array(
												'labinvs_patient_id' => $patient_id,
												'labinvs_visit_id'   => $visit_id,
												'labinvs_name'       => $data['labinvs_name'], 
												'labinvs_value'      => $data['labinvs_value'], 
												'labinvs_unit'       => $data['labinvs_unit'],
											);
			$this->Visit_model->save_visit_laboratory_investigation($laboratory_investigation);
		}

		//Save visit laboratory investigation ECG
		$ecg_data = array(
						'ecg_patient_id' => $patient_id,
						'ecg_visit_id'   => $visit_id,
						'ecg_type'       => $this->input->post('ecg_type'), 
						'ecg_abnormals'  => $this->input->post('ecg_abnormals'),
					);
		$this->Visit_model->save_visit_laboratory_ecg($ecg_data);


		//Save Drug History
		$drug_history_data = array(
								'drughistory_patient_id'                => $patient_id,
								'drughistory_visit_id'                  => $visit_id,
								'drughistory_date'                      => $this->input->post('drughistory_date'), 
								'drughistory_fdiagnosis'                => $this->input->post('drughistory_fdiagnosis'), 
								'drughistory_other_associated_diseases' => $this->input->post('drughistory_other_associated_diseases'),
							);
		$this->Visit_model->save_visit_drug_history($drug_history_data);

		// Prev OADs
		$visit_prev_oads = $this->input->post('visit_prev_oads');
		foreach($visit_prev_oads as $data)
		{
			$oads_data = array(
							'oads_patient_id' => $patient_id,
							'oads_visit_id'   => $visit_id,
							'oads_name' => $data['oads_name'], 
							'oads_dose' => $data['oads_dose'], 
							'oads_advice_codition_time' => $data['oads_advice_codition_time'], 
							'oads_advice_codition_time_type' => $data['oads_advice_codition_time_type'], 
							'oads_advice_codition_apply' => $data['oads_advice_codition_apply'], 
							'oads_duration' => $data['oads_duration'], 
							'oads_duration_type' => $data['oads_duration_type'],
						);
			$this->Visit_model->save_visitprev_oads($oads_data);
		}

		// Prev Insulin
		$visit_prev_insulin = $this->input->post('visit_prev_insulin');
		foreach($visit_prev_insulin as $data)
		{
			$prev_insulin_data = array(
										'insulin_patient_id' => $patient_id,
										'insulin_visit_id'   => $visit_id,
										'insulin_name' => $data['insulin_name'], 
										'insulin_dose' => $data['insulin_dose'], 
										'insulin_advice_codition_time' => $data['insulin_advice_codition_time'], 
										'insulin_advice_codition_time_type' => $data['insulin_advice_codition_time_type'], 
										'insulin_advice_codition_apply' => $data['insulin_advice_codition_apply'], 
										'insulin_duration' => $data['insulin_duration'], 
										'insulin_duration_type' => $data['insulin_duration_type'],
									);
			$this->Visit_model->save_visitprev_insulin($prev_insulin_data);
		}


		// prev anti htn
		$visit_prev_anti_htn = $this->input->post('visit_prev_anti_htn');
		foreach($visit_prev_anti_htn as $data)
		{
			$anti_htn_dose_data = array(
										'anti_htn_patient_id' => $patient_id,
										'anti_htn_visit_id'   => $visit_id,
										'anti_htn_name' => $data['anti_htn_name'], 
										'anti_htn_dose' => $data['anti_htn_dose'], 
										'anti_htn_advice_codition_time' => $data['anti_htn_advice_codition_time'], 
										'anti_htn_advice_codition_time_type' => $data['anti_htn_advice_codition_time_type'], 
										'anti_htn_advice_codition_apply' => $data['anti_htn_advice_codition_apply'], 
										'anti_htn_duration' => $data['anti_htn_duration'], 
										'anti_htn_duration_type' => $data['anti_htn_duration_type'],
									);
			$this->Visit_model->save_visitprev_anti_htn($anti_htn_dose_data);
		}

		// prev anti lipids
		$visit_prev_anti_lipids = $this->input->post('visit_prev_anti_lipids');
		foreach($visit_prev_anti_lipids as $data)
		{
			$prev_anti_lipids_data = array(
											'anti_lipid_patient_id' => $patient_id,
											'anti_lipid_visit_id'   => $visit_id,
											'anti_lipid_name' => $data['anti_lipid_name'], 
											'anti_lipid_dose' => $data['anti_lipid_dose'], 
											'anti_lipid_advice_codition_time' => $data['anti_lipid_advice_codition_time'],
											'anti_lipid_advice_codition_time_type' => $data['anti_lipid_advice_codition_time_type'], 
											'anti_lipid_advice_codition_apply' => $data['anti_lipid_advice_codition_apply'], 
											'anti_lipid_duration' => $data['anti_lipid_duration'], 
											'anti_lipid_duration_type' => $data['anti_lipid_duration_type'],
										);
			$this->Visit_model->save_visitprev_anti_lipids($prev_anti_lipids_data);
		}

		// prev antiplatelets
		$visit_prev_antiplatelets = $this->input->post('visit_prev_antiplatelets');
		foreach($visit_prev_antiplatelets as $data)
		{
			$prev_antiplatelets_data = array(
											'antiplatelets_patient_id' => $patient_id,
											'antiplatelets_visit_id'   => $visit_id,
											'antiplatelets_name' => $data['antiplatelets_name'], 
											'antiplatelets_dose' => $data['antiplatelets_dose'], 
											'antiplatelets_advice_codition_time' => $data['antiplatelets_advice_codition_time'], 
											'antiplatelets_advice_codition_time_type' => $data['antiplatelets_advice_codition_time_type'], 
											'antiplatelets_advice_codition_apply' => $data['antiplatelets_advice_codition_apply'], 
											'antiplatelets_duration' => $data['antiplatelets_duration'], 
											'antiplatelets_duration_type' => $data['antiplatelets_duration_type'],
										);
			$this->Visit_model->save_visitprev_antiplatelets($prev_antiplatelets_data);
		}

		// prev anti obesity
		$visit_prev_anti_obesity = $this->input->post('visit_prev_anti_obesity');
		foreach($visit_prev_anti_obesity as $data)
		{
			$prev_anti_obesity_data = array(
											'anti_obesity_patient_id' => $patient_id,
											'anti_obesity_visit_id'   => $visit_id,
											'anti_obesity_name' => $data['anti_obesity_name'], 
											'anti_obesity_dose' => $data['anti_obesity_dose'], 
											'anti_obesity_advice_codition_time' => $data['anti_obesity_advice_codition_time'], 
											'anti_obesity_advice_codition_time_type' => $data['anti_obesity_advice_codition_time_type'], 
											'anti_obesity_advice_codition_apply' => $data['anti_obesity_advice_codition_apply'], 
											'anti_obesity_duration' => $data['anti_obesity_duration'], 
											'anti_obesity_duration_type' => $data['anti_obesity_duration_type'],
										);
			$this->Visit_model->save_visitprev_anti_obesity($prev_anti_obesity_data);
		}

		// prev other
		$visit_prev_other = $this->input->post('visit_prev_other');
		foreach($visit_prev_other as $data)
		{
			$prev_omedication_other = array(
											'other_patient_id' => $patient_id,
											'other_visit_id'   => $visit_id,
											'other_name' => $data['other_name'], 
											'other_dose' => $data['other_dose'], 
											'other_advice_codition_time' => $data['other_advice_codition_time'], 
											'other_advice_codition_time_type' => $data['other_advice_codition_time_type'], 
											'other_advice_codition_apply' => $data['other_advice_codition_apply'], 
											'other_duration' => $data['other_duration'], 
											'other_duration_type' => $data['other_duration_type'], 
										);
			$this->Visit_model->save_visitprev_omedication_other($prev_omedication_other);
		}

		//Save Final Treatment
		$final_treatment_data = array(
									'finaltreat_patient_id'        => $patient_id,
									'finaltreat_visit_id'          => $visit_id,
									'finaltreat_doctor_name'       => $this->input->post('finaltreat_doctor_name'), 
									'finaltreat_doctor_id'         => $this->input->post('finaltreat_doctor_id'), 
									'finaltreat_date'              => $this->input->post('finaltreat_date'), 
									'finaltreat_dietary_advice'    => $this->input->post('finaltreat_dietary_advice'), 
									'finaltreat_physical_acitvity' => $this->input->post('finaltreat_physical_acitvity'), 
									'finaltreat_diet_no'           => $this->input->post('finaltreat_diet_no'), 
									'finaltreat_page_no'           => $this->input->post('finaltreat_page_no'), 
									'finaltreat_next_visit_date'   => $this->input->post('finaltreat_next_visit_date'), 
									'finaltreat_next_investigation'=> $this->input->post('finaltreat_next_investigation'),
								);
		$this->Visit_model->save_final_treatment_infos($final_treatment_data);

		// current OADs
		$visit_crnt_oads = $this->input->post('visit_crnt_oads');
		foreach($visit_crnt_oads as $data)
		{
			$crnt_oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name' => $data['oads_name'], 
									'oads_dose' => $data['oads_dose'], 
									'oads_advice_codition_time' => $data['oads_advice_codition_time'], 
									'oads_advice_codition_time_type' => $data['oads_advice_codition_time_type'], 
									'oads_advice_codition_apply' => $data['oads_advice_codition_apply'], 
									'oads_duration' => $data['oads_duration'], 
									'oads_duration_type' => $data['oads_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_oads($crnt_oads_data);
		}

		// current insulin
		$visit_crnt_insulin = $this->input->post('visit_crnt_insulin');
		foreach($visit_crnt_insulin as $data)
		{
			$crnt_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name' => $data['insulin_name'], 
									'insulin_dose' => $data['insulin_dose'], 
									'insulin_advice_codition_time' => $data['insulin_advice_codition_time'], 
									'insulin_advice_codition_time_type' => $data['insulin_advice_codition_time_type'], 
									'insulin_advice_codition_apply' => $data['insulin_advice_codition_apply'], 
									'insulin_duration' => $data['insulin_duration'], 
									'insulin_duration_type' => $data['insulin_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_insulin($crnt_insulin_data);
		}

		// current anti htn
		$visit_crnt_anti_htn = $this->input->post('visit_crnt_anti_htn');
		foreach($visit_crnt_anti_htn as $data)
		{
			$crnt_anti_htn_dose_data = array(
									'anti_htn_patient_id' => $patient_id,
									'anti_htn_visit_id'   => $visit_id,
									'anti_htn_name' => $data['anti_htn_name'], 
									'anti_htn_dose' => $data['anti_htn_dose'], 
									'anti_htn_advice_codition_time' => $data['anti_htn_advice_codition_time'], 
									'anti_htn_advice_codition_time_type' => $data['anti_htn_advice_codition_time_type'], 
									'anti_htn_advice_codition_apply' => $data['anti_htn_advice_codition_apply'], 
									'anti_htn_duration' => $data['anti_htn_duration'], 
									'anti_htn_duration_type' => $data['anti_htn_duration_type'],
								);
			$this->Visit_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
		}

		// current anti lipids
		$visit_crnt_anti_lipids = $this->input->post('visit_crnt_anti_lipids');
		foreach($visit_crnt_anti_lipids as $data)
		{
			$crnt_anti_lipids_data = array(
										'anti_lipid_patient_id' => $patient_id,
										'anti_lipid_visit_id'   => $visit_id,
										'anti_lipid_name' => $data['anti_lipid_name'], 
										'anti_lipid_dose' => $data['anti_lipid_dose'], 
										'anti_lipid_advice_codition_time' => $data['anti_lipid_advice_codition_time'],
										'anti_lipid_advice_codition_time_type' => $data['anti_lipid_advice_codition_time_type'], 
										'anti_lipid_advice_codition_apply' => $data['anti_lipid_advice_codition_apply'], 
										'anti_lipid_duration' => $data['anti_lipid_duration'], 
										'anti_lipid_duration_type' => $data['anti_lipid_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
		}

		// current antiplatelets
		$visit_crnt_antiplatelets = $this->input->post('visit_crnt_antiplatelets');
		foreach($visit_crnt_antiplatelets as $data)
		{
			$crnt_antiplatelets_data = array(
										'antiplatelets_patient_id' => $patient_id,
										'antiplatelets_visit_id'   => $visit_id,
										'antiplatelets_name' => $data['antiplatelets_name'], 
										'antiplatelets_dose' => $data['antiplatelets_dose'], 
										'antiplatelets_advice_codition_time' => $data['antiplatelets_advice_codition_time'], 
										'antiplatelets_advice_codition_time_type' => $data['antiplatelets_advice_codition_time_type'], 
										'antiplatelets_advice_codition_apply' => $data['antiplatelets_advice_codition_apply'], 
										'antiplatelets_duration' => $data['antiplatelets_duration'], 
										'antiplatelets_duration_type' => $data['antiplatelets_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
		}

		// current anti obesity
		$visit_crnt_anti_obesity = $this->input->post('visit_crnt_anti_obesity');
		foreach($visit_crnt_anti_obesity as $data)
		{
			$crnt_anti_obesity_data = array(
										'anti_obesity_patient_id' => $patient_id,
										'anti_obesity_visit_id'   => $visit_id,
										'anti_obesity_name' => $data['anti_obesity_name'], 
										'anti_obesity_dose' => $data['anti_obesity_dose'], 
										'anti_obesity_advice_codition_time' => $data['anti_obesity_advice_codition_time'], 
										'anti_obesity_advice_codition_time_type' => $data['anti_obesity_advice_codition_time_type'], 
										'anti_obesity_advice_codition_apply' => $data['anti_obesity_advice_codition_apply'], 
										'anti_obesity_duration' => $data['anti_obesity_duration'], 
										'anti_obesity_duration_type' => $data['anti_obesity_duration_type'],
									);
			$this->Visit_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
		}

		// current other
		$visit_crnt_other = $this->input->post('visit_crnt_other');
		foreach($visit_crnt_other as $data)
		{
			$crnt_omedication_other = array(
										'other_patient_id' => $patient_id,
										'other_visit_id'   => $visit_id,
										'other_name' => $data['other_name'], 
										'other_dose' => $data['other_dose'], 
										'other_advice_codition_time' => $data['other_advice_codition_time'], 
										'other_advice_codition_time_type' => $data['other_advice_codition_time_type'], 
										'other_advice_codition_apply' => $data['other_advice_codition_apply'], 
										'other_duration' => $data['other_duration'], 
										'other_duration_type' => $data['other_duration_type'], 
									);
			$this->Visit_model->save_visitcrnt_omedication_other($crnt_omedication_other);
		}

		//Save Payments
		$payment_data = array(
							'payment_visit_id'           => $visit_id,
							'payment_patient_id'         => $patient_id,
							'payment_patient_fee_amount' => $this->input->post('payment_patient_fee_amount'), 
							'payment_patient_status'     => $this->input->post('payment_patient_status'),
						);
		$this->Visit_model->save_payment_data($payment_data);
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function create()
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
		$total_items = $this->Visit_model->get_todaytotal_items($today);
		$entry_ID = date('dmy').str_pad($total_items, 7, '0', STR_PAD_LEFT);
		
		$patient_total_visits = $this->Visit_model->get_count_of_patient_visits($patient_id);
		$serial_no = 'Visit '.($patient_total_visits+1);
		
		//check patient type
		if($patient_total_visits > 0)
		{
			$visit_patient_type = 'OLD';
		}else{
			$visit_patient_type = 'NEW';
		}
		$visit_no = $this->Visit_model->get_visit_no($patient_id);
		$basic_data = array(
						'visit_number'             => $visit_no,
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
			$ins_id = $this->Visit_model->save_visit_information($basic_data);
			$visit_id = $this->db->insert_id($ins_id);				
			
			//Save visit personal habit
			$phabit_rows = $this->input->post('phabit_row');
			if(!empty($phabit_rows)):
			foreach($phabit_rows as $row)
			{
				$phabit_name = html_escape($this->input->post('phabit_row_name_'.$row));
				
				if($phabit_name)
				{
					$phabit_data = array(
						'phabit_patient_id'    => $patient_id,
						'phabit_visit_id'      => $visit_id,
						'phabit_name'          => $phabit_name,
					);
					$this->Visit_model->save_visit_personal_habits($phabit_data);
				}
			}
			endif;
			
			//Save visit family history
			$fmhistory_rows = $this->input->post('family_history_row');
			if(!empty($fmhistory_rows)):
			foreach($fmhistory_rows as $row)
			{
				$fmhistory_name = html_escape($this->input->post('family_history_row_name_'.$row));
				
				if($fmhistory_name)
				{
					$fmhistory_data = array(
								'fmhistory_patient_id' => $patient_id,
								'fmhistory_visit_id'   => $visit_id,
								'fmhistory_name'       => $fmhistory_name,
							);
					$this->Visit_model->save_visit_family_history($fmhistory_data);
				}
			}
			endif;
			
			//Save visit diabetes history
			$diabetes_history_data = array(
										'dhistory_patient_id'                 => $patient_id,
										'dhistory_visit_id'                   => $visit_id,
										'dhistory_type_of_glucose'            => html_escape($this->input->post('type_of_glucose')),
										'dhistory_duration_of_glucose'        => html_escape($this->input->post('duration_of_glucose')),
										'dhistory_prev_bad_obstetric_history' => html_escape($this->input->post('prev_bad_obstetric_history')),
										'dhistory_prev_history_of_gdm'        => html_escape($this->input->post('prev_history_of_gdm')),
										'dhistory_past_medical_history'       => html_escape($this->input->post('past_medical_history')),
										'dhistory_symptoms_at_diagnosis'      => html_escape($this->input->post('symptoms_at_diagnosis')),
										'dhistory_symptoms_at_diagnosis_types'=> json_encode($this->input->post('symptoms_at_diagnosis_types')),
										'dhistory_other_complaints'            => html_escape($this->input->post('other_complaints')),
									);
			$this->Visit_model->save_diabetes_history($diabetes_history_data);
			
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
					$this->Visit_model->save_visit_complication($complication_data);
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
					$this->Visit_model->save_visit_general_examination($general_exam_data);
				}
			}
			$sms_array['BP'] = $BP['sbp'].'/'.$BP['dbp'];
			endif;
			
			//Save visit general examination other content
			$g_other_txt = html_escape($this->input->post('other_physical_examinations'));
			if($g_other_txt)
			{
				$g_other_content = array(
									'gexamother_patient_id' => $patient_id,
									'gexamother_visit_id'   => $visit_id,
									'gexamother_content'    => $g_other_txt,
								);
				$this->Visit_model->save_visit_general_other_content($g_other_content);
			}
			
			//Save visit Foot examination
			$foot_examination_data = array(
										'footexm_patient_id'    => $patient_id,
										'footexm_visit_id'      => $visit_id,
										'footexm_date'          => db_formated_date($this->input->post('footexm_date')),
										'footexm_doctor_name'   => html_escape($this->input->post('footexm_doctor_name')),
										'footexm_doctor_id'     => html_escape($this->input->post('footexm_doctor_id')),
										'footexm_other_content' => html_escape($this->input->post('footexm_other_content')),
									);
			$this->Visit_model->save_foot_exam_info($foot_examination_data);
			
			//Save foot examination periferal pulse
			$foot_examination_periferal_data = array(
													'footexmprfl_patient_id'                      => $patient_id,
													'footexmprfl_visit_id'                        => $visit_id,
													'footexmprfl_arteria_dorsalis_predis_present' => html_escape($this->input->post('arteria_dorsalis_predis_present')),
													'footexmprfl_arteria_dorsalis_predis_absent'  => html_escape($this->input->post('arteria_dorsalis_predis_absent')),
													'footexmprfl_posterior_tribila_present'       => html_escape($this->input->post('posterior_tribila_present')),
													'footexmprfl_posterior_tribila_absent'        => html_escape($this->input->post('posterior_tribila_absent')),
												);
			$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);
			
			//Save foot examination sensation
			$foot_examination_sensation_data = array(
													'footexmsns_patient_id'           => $patient_id,
													'footexmsns_visit_id'             => $visit_id,
													'footexmsns_monofilament_present' => html_escape($this->input->post('monofilament_present')),
													'footexmsns_monofilament_absent'  => html_escape($this->input->post('monofilament_absent')),
													'footexmsns_tuning_fork_present'  => html_escape($this->input->post('tuning_fork_present')),
													'footexmsns_tuning_fork_absent'   => html_escape($this->input->post('tuning_fork_absent')),
												);
			$this->Visit_model->save_foot_exam_sensation_info($foot_examination_sensation_data);
			
			//Save visit diatory history
			$prev_diatory_rows = $this->input->post('prev_diatory_history_row');
			if(!empty($prev_diatory_rows)):
			foreach($prev_diatory_rows as $row)
			{
				$diehist_name       = html_escape($this->input->post('prev_diatory_history_row_name_'.$row));
				$diehist_daily      = html_escape($this->input->post('prev_diatory_history_daily_'.$row));
				$diehist_weekly     = html_escape($this->input->post('prev_diatory_history_weekly_'.$row));
				
				if($diehist_name && $diehist_daily)
				{
					$diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name'        => $diehist_name,
									'diehist_daily'       => $diehist_daily,
									'diehist_weekly'      => $diehist_weekly,
								);
					$this->Visit_model->save_visit_dietary_history($diatory_history);
				}
			}
			endif;
			
			//Save visit phisical activity
			$phisical_acitivity_rows = $this->input->post('prev_phisical_acitivity_row');
			if(!empty($phisical_acitivity_rows)):
			foreach($phisical_acitivity_rows as $row)
			{
				$physical_act_type = html_escape($this->input->post('prev_phisical_acitivity_row_name_'.$row));
				$physical_act_duration_a_day = html_escape($this->input->post('prev_phisical_acitivity_value_'.$row));
				$physical_act_duration_a_week = html_escape($this->input->post('prev_phisical_acitivity_value_per_week_'.$row));
				
				if($physical_act_type && $physical_act_duration_a_day)
				{
					$phisical_activity = array(
									'physical_act_patient_id'     => $patient_id,
									'physical_act_visit_id'       => $visit_id,
									'physical_act_type'           => $physical_act_type,
									'physical_act_duration_a_day' => $physical_act_duration_a_day,
									'physical_act_duration_a_week'=> $physical_act_duration_a_week,
								);
					$this->Visit_model->save_visit_phisical_actitivites($phisical_activity);
				}
			}
			endif;
			
			//Save Eye examination
			$eye_examination_data = array(
										'eyeexam_patient_id'  => $patient_id,
										'eyeexam_visit_id'    => $visit_id,
										'eyeexam_date'        => db_formated_date($this->input->post('eyeexam_date')),
										'eyeexam_left_eye'    => html_escape($this->input->post('eyeexam_left_eye')),
										'eyeexam_right_eye'   => html_escape($this->input->post('eyeexam_right_eye')),
										'eyeexam_other'       => html_escape($this->input->post('eyeexam_other')),
										'eyeexam_treatment'   => html_escape($this->input->post('eyeexam_treatment')),
										'eyeexam_doctor_name' => html_escape($this->input->post('eyeexam_doctor_name')),
										'eyeexam_doctor_id'   => html_escape($this->input->post('eyeexam_doctor_id')),
									);
			$this->Visit_model->save_visit_eye_exam_info($eye_examination_data);
			
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
				
				if($labinv_name == 'Post-meal BG')
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
					$this->Visit_model->save_visit_laboratory_investigation($laboratory_investigation);
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
			$this->Visit_model->save_visit_laboratory_ecg($ecg_data);
			
			//Save Drug History
			$drug_history_data = array(
									'drughistory_patient_id'                => $patient_id,
									'drughistory_visit_id'                  => $visit_id,
									'drughistory_date'                      => db_formated_date($this->input->post('drughistory_date')),
									'drughistory_fdiagnosis'                => html_escape($this->input->post('drughistory_fdiagnosis')),
									'drughistory_other_associated_diseases' => html_escape($this->input->post('drughistory_other_associated_diseases')),
								);
			$this->Visit_model->save_visit_drug_history($drug_history_data);
			
			// Prev OADs
			$oads_row_rows = $this->input->post('oads_row');
			if($this->input->post('prev_is_oads') == '1' && !empty($oads_row_rows)):
			foreach($oads_row_rows as $row)
			{
				$oads_name = html_escape($this->input->post('oads_name_'.$row));
				$oads_dose = html_escape($this->input->post('oads_value_'.$row));
				
				$prev_oads_condition_time      = html_escape($this->input->post('oads_condition_time_'.$row));
				$prev_oads_condition_time_type = html_escape($this->input->post('oads_condition_time_type_'.$row));
				$prev_oads_condition_apply     = html_escape($this->input->post('oads_condition_apply_'.$row));
				$prev_oads_duration            = html_escape($this->input->post('oads_duration_'.$row));
				$prev_oads_duration_type       = html_escape($this->input->post('oads_duration_type_'.$row));
				
				if($prev_oads_condition_time & $prev_oads_duration){
					$oads_advice_codition_time        = $prev_oads_condition_time;
					$oads_advice_codition_time_type   = $prev_oads_condition_time_type;
					$oads_advice_codition_apply       = $prev_oads_condition_apply;
					$oads_duration                    = $prev_oads_duration;
					$oads_duration_type               = $prev_oads_duration_type;
					
				}else{
					$oads_advice_codition_time      = null;
					$oads_advice_codition_time_type = null;
					$oads_advice_codition_apply     = null;
					$oads_duration                  = null;
					$oads_duration_type             = null;
				}
				
				if($oads_name && $oads_dose)
				{
					$oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name'       => $oads_name,
									'oads_dose'       => $oads_dose,
									'oads_advice_codition_time'      => $oads_advice_codition_time,
									'oads_advice_codition_time_type' => $oads_advice_codition_time_type,
									'oads_advice_codition_apply'     => $oads_advice_codition_apply,
									'oads_duration'                  => $oads_duration,
									'oads_duration_type'             => $oads_duration_type,
								);
					$this->Visit_model->save_visitprev_oads($oads_data);
				}
			}
			endif;
			
			// Prev Insulin
			$prev_insulin_rows = $this->input->post('prev_insulin_row');
			if($this->input->post('prev_is_insulin') == '1' && !empty($prev_insulin_rows)):
			foreach($prev_insulin_rows as $row)
			{
				$prev_insulin_name = html_escape($this->input->post('prev_insulin_name_'.$row));
				$prev_insulin_dose = html_escape($this->input->post('prev_insulin_value_'.$row));
				
				$prev_insulin_condition_time      = html_escape($this->input->post('prev_insulin_condition_time_'.$row));
				$prev_insulin_condition_time_type = html_escape($this->input->post('prev_insulin_condition_time_type_'.$row));
				$prev_insulin_condition_apply     = html_escape($this->input->post('prev_insulin_condition_apply_'.$row));
				$prev_insulin_duration            = html_escape($this->input->post('prev_insulin_duration_'.$row));
				$prev_insulin_duration_type       = html_escape($this->input->post('prev_insulin_duration_type_'.$row));
				
				if($prev_insulin_condition_time & $prev_insulin_duration){
					$insulin_advice_codition_time      = $prev_insulin_condition_time;
					$insulin_advice_codition_time_type = $prev_insulin_condition_time_type;
					$insulin_advice_codition_apply     = $prev_insulin_condition_apply;
					$insulin_duration                  = $prev_insulin_duration;
					$insulin_duration_type             = $prev_insulin_duration_type;
				}else{
					$insulin_advice_codition_time      = null;
					$insulin_advice_codition_time_type = null;
					$insulin_advice_codition_apply     = null;
					$insulin_duration                  = null;
					$insulin_duration_type             = null;
				}
				
				if($prev_insulin_name && $prev_insulin_dose)
				{
					$prev_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name'       => $prev_insulin_name,
									'insulin_dose'       => $prev_insulin_dose,
									'insulin_advice_codition_time'      => $insulin_advice_codition_time,
									'insulin_advice_codition_time_type' => $insulin_advice_codition_time_type,
									'insulin_advice_codition_apply'     => $insulin_advice_codition_apply,
									'insulin_duration'                  => $insulin_duration,
									'insulin_duration_type'             => $insulin_duration_type,
								);
					$this->Visit_model->save_visitprev_insulin($prev_insulin_data);
				}
			}
			endif;
			
			// prev anti htn
			$anti_htn_row_rows = $this->input->post('anti_htn_row');
			if($this->input->post('prev_is_anti_htn') == '1' && !empty($anti_htn_row_rows)):
			foreach($anti_htn_row_rows as $row)
			{
				$anti_htn_name = html_escape($this->input->post('anti_htn_name_'.$row));
				$anti_htn_dose = html_escape($this->input->post('anti_htn_value_'.$row));
				
				$prev_anti_htn_condition_time      = html_escape($this->input->post('anti_htn_condition_time_'.$row));
				$prev_anti_htn_condition_time_type = html_escape($this->input->post('anti_htn_condition_time_type_'.$row));
				$prev_anti_htn_condition_apply     = html_escape($this->input->post('anti_htn_condition_apply_'.$row));
				$prev_anti_htn_duration            = html_escape($this->input->post('anti_htn_duration_'.$row));
				$prev_anti_htn_duration_type       = html_escape($this->input->post('anti_htn_duration_type_'.$row));
				
				if($prev_anti_htn_condition_time & $prev_anti_htn_duration){
					$anti_htn_advice_codition_time      = $prev_anti_htn_condition_time;
					$anti_htn_advice_codition_time_type = $prev_anti_htn_condition_time_type;
					$anti_htn_advice_codition_apply     = $prev_anti_htn_condition_apply;
					$anti_htn_duration                  = $prev_anti_htn_duration;
					$anti_htn_duration_type             = $prev_anti_htn_duration_type;
				}else{
					$anti_htn_advice_codition_time      = null;
					$anti_htn_advice_codition_time_type = null;
					$anti_htn_advice_codition_apply     = null;
					$anti_htn_duration                  = null;
					$anti_htn_duration_type             = null;
				}
				
				if($anti_htn_name && $anti_htn_dose)
				{
					$anti_htn_dose_data = array(
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
					$this->Visit_model->save_visitprev_anti_htn($anti_htn_dose_data);
				}
			}
			endif;
			
			// prev anti lipids
			$lipids_rows = $this->input->post('lipids_row');
			if($this->input->post('prev_is_anti_lipids') == '1' && !empty($lipids_rows)):
			foreach($lipids_rows as $row)
			{
				$anti_lipid_name = html_escape($this->input->post('lipids_name_'.$row));
				$anti_lipid_dose = html_escape($this->input->post('lipids_value_'.$row));
				
				$prev_anti_lipid_condition_time      = html_escape($this->input->post('lipids_condition_time_'.$row));
				$prev_anti_lipid_condition_time_type = html_escape($this->input->post('lipids_condition_time_type_'.$row));
				$prev_anti_lipid_condition_apply     = html_escape($this->input->post('lipids_condition_apply_'.$row));
				$prev_anti_lipid_duration            = html_escape($this->input->post('lipids_duration_'.$row));
				$prev_anti_lipid_duration_type       = html_escape($this->input->post('lipids_duration_type_'.$row));
				
				if($prev_anti_lipid_condition_time & $prev_anti_lipid_duration){
					$anti_lipid_advice_codition_time      = $prev_anti_lipid_condition_time;
					$anti_lipid_advice_codition_time_type = $prev_anti_lipid_condition_time_type;
					$anti_lipid_advice_codition_apply     = $prev_anti_lipid_condition_apply;
					$anti_lipid_duration                  = $prev_anti_lipid_duration;
					$anti_lipid_duration_type             = $prev_anti_lipid_duration_type;
				}else{
					$anti_lipid_advice_codition_time      = null;
					$anti_lipid_advice_codition_time_type = null;
					$anti_lipid_advice_codition_apply     = null;
					$anti_lipid_duration                  = null;
					$anti_lipid_duration_type             = null;
				}
				
				if($anti_lipid_name && $anti_lipid_dose)
				{
					$prev_anti_lipids_data = array(
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
					$this->Visit_model->save_visitprev_anti_lipids($prev_anti_lipids_data);
				}
			}
			endif;
			
			// prev antiplatelets
			$aspirine_rows = $this->input->post('aspirine_row');
			if($this->input->post('prev_is_aspirine') == '1' && !empty($aspirine_rows)):
			foreach($aspirine_rows as $row)
			{
				$prev_antiplatelets_name = html_escape($this->input->post('aspirine_name_'.$row));
				$prev_antiplatelets_dose = html_escape($this->input->post('aspirine_value_'.$row));
				
				$prev_antiplatelets_condition_time      = html_escape($this->input->post('aspirine_condition_time_'.$row));
				$prev_antiplatelets_condition_time_type = html_escape($this->input->post('aspirine_condition_time_type_'.$row));
				$prev_antiplatelets_condition_apply     = html_escape($this->input->post('aspirine_condition_apply_'.$row));
				$prev_antiplatelets_duration            = html_escape($this->input->post('aspirine_duration_'.$row));
				$prev_antiplatelets_duration_type       = html_escape($this->input->post('aspirine_duration_type_'.$row));
				
				if($prev_antiplatelets_condition_time & $prev_antiplatelets_duration){
					$antiplatelets_advice_codition_time       = $prev_antiplatelets_condition_time;
					$antiplatelets_advice_codition_time_type  = $prev_antiplatelets_condition_time_type;
					$antiplatelets_advice_codition_apply      = $prev_antiplatelets_condition_apply;
					$antiplatelets_duration                   = $prev_antiplatelets_duration;
					$antiplatelets_duration_type              = $prev_antiplatelets_duration_type;
				}else{
					$antiplatelets_advice_codition_time       = null;
					$antiplatelets_advice_codition_time_type  = null;
					$antiplatelets_advice_codition_apply      = null;
					$antiplatelets_duration                   = null;
					$antiplatelets_duration_type              = null;
				}
				
				if($prev_antiplatelets_name && $prev_antiplatelets_dose)
				{
					$prev_antiplatelets_data = array(
									'antiplatelets_patient_id' => $patient_id,
									'antiplatelets_visit_id'   => $visit_id,
									'antiplatelets_name'       => $prev_antiplatelets_name,
									'antiplatelets_dose'       => $prev_antiplatelets_dose,
									'antiplatelets_advice_codition_time'      => $antiplatelets_advice_codition_time,
									'antiplatelets_advice_codition_time_type' => $antiplatelets_advice_codition_time_type,
									'antiplatelets_advice_codition_apply'     => $antiplatelets_advice_codition_apply,
									'antiplatelets_duration'                  => $antiplatelets_duration,
									'antiplatelets_duration_type'             => $antiplatelets_duration_type,
								);
					$this->Visit_model->save_visitprev_antiplatelets($prev_antiplatelets_data);
				}
			}
			endif;
			
			
			// prev anti obesity
			$obesity_rows = $this->input->post('obesity_row');
			if($this->input->post('prev_is_anti_obesity') == '1' && !empty($obesity_rows)):
			foreach($obesity_rows as $row)
			{
				$anti_obesity_name = html_escape($this->input->post('obesity_name_'.$row));
				$anti_obesity_dose = html_escape($this->input->post('obesity_value_'.$row));
				
				$prev_obesity_condition_time      = html_escape($this->input->post('obesity_condition_time_'.$row));
				$prev_obesity_condition_time_type = html_escape($this->input->post('obesity_condition_time_type_'.$row));
				$prev_obesity_condition_apply     = html_escape($this->input->post('obesity_condition_apply_'.$row));
				$prev_obesity_duration            = html_escape($this->input->post('obesity_duration_'.$row));
				$prev_obesity_duration_type       = html_escape($this->input->post('obesity_duration_type_'.$row));
				
				if($prev_obesity_condition_time & $prev_obesity_duration){
					$anti_obesity_advice_codition_time       = $prev_obesity_condition_time;
					$anti_obesity_advice_codition_time_type  = $prev_obesity_condition_time_type;
					$anti_obesity_advice_codition_apply      = $prev_obesity_condition_apply;
					$anti_obesity_duration                   = $prev_obesity_duration;
					$anti_obesity_duration_type              = $prev_obesity_duration_type;
				}else{
					$anti_obesity_advice_codition_time       = null;
					$anti_obesity_advice_codition_time_type  = null;
					$anti_obesity_advice_codition_apply      = null;
					$anti_obesity_duration                   = null;
					$anti_obesity_duration_type              = null;
				}
				
				if($anti_obesity_name && $anti_obesity_dose)
				{
					$prev_anti_obesity_data = array(
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
					$this->Visit_model->save_visitprev_anti_obesity($prev_anti_obesity_data);
				}
			}
			endif;
			
			// prev other
			$other_rows = $this->input->post('other_row');
			if($this->input->post('prev_is_others') == '1' && !empty($other_rows)):
			foreach($other_rows as $row)
			{
				$other_name = html_escape($this->input->post('other_name_'.$row));
				$other_dose = html_escape($this->input->post('other_value_'.$row));
				
				$prev_other_condition_time      = html_escape($this->input->post('other_condition_time_'.$row));
				$prev_other_condition_time_type = html_escape($this->input->post('other_condition_time_type_'.$row));
				$prev_other_condition_apply     = html_escape($this->input->post('other_condition_apply_'.$row));
				$prev_other_duration            = html_escape($this->input->post('other_duration_'.$row));
				$prev_other_duration_type       = html_escape($this->input->post('other_duration_type_'.$row));
				
				if($prev_other_condition_time & $prev_other_duration){
					$other_advice_codition_time        = $prev_other_condition_time;
					$other_advice_codition_time_type   = $prev_other_condition_time_type;
					$other_advice_codition_apply       = $prev_other_condition_apply;
					$other_duration                    = $prev_other_duration;
					$other_duration_type               = $prev_other_duration_type;
				}else{
					$other_advice_codition_time        = null;
					$other_advice_codition_time_type   = null;
					$other_advice_codition_apply       = null;
					$other_duration                    = null;
					$other_duration_type               = null;
				}
				
				if($other_name && $other_dose)
				{
					$prev_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
									'other_advice_codition_time'      => $other_advice_codition_time,
									'other_advice_codition_time_type' => $other_advice_codition_time_type,
									'other_advice_codition_apply'     => $other_advice_codition_apply,
									'other_duration'                  => $other_duration,
									'other_duration_type'             => $other_duration_type,
								);
					$this->Visit_model->save_visitprev_omedication_other($prev_omedication_other);
				}
			}
			endif;
			
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
			$this->Visit_model->save_final_treatment_infos($final_treatment_data);
				
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
					$this->Visit_model->save_visitcrnt_oads($crnt_oads_data);
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
					$this->Visit_model->save_visitcrnt_insulin($crnt_insulin_data);
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
					$this->Visit_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
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
					$this->Visit_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
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
					$this->Visit_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
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
					$this->Visit_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
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
					$this->Visit_model->save_visitcrnt_omedication_other($crnt_omedication_other);
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
			$this->Visit_model->save_payment_data($payment_data);
			
			
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
	
	public function update_v_2()
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
						'visit_org_id'             => $this->get_visit_org_id(html_escape($this->input->post('visit_center_id'))),
						'visit_date'               => db_formated_date($this->input->post('visit_date')),
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
			$this->Visit_model->update_visit_information($basic_data, $visit_id, $patient_id);
			
			//Delete Old visit informations
			$this->Visit_model->delete_old_visit_information($visit_id);
			
			//Save visit personal habit
			$phabit_rows = $this->input->post('phabit_row');
			if(!empty($phabit_rows)):
			foreach($phabit_rows as $row)
			{
				$phabit_name = html_escape($this->input->post('phabit_row_name_'.$row));
				
				if($phabit_name)
				{
					$phabit_data = array(
						'phabit_patient_id'    => $patient_id,
						'phabit_visit_id'      => $visit_id,
						'phabit_name'          => $phabit_name,
					);
					$this->Visit_model->save_visit_personal_habits($phabit_data);
				}
			}
			endif;
			
			//Save visit family history
			$fmhistory_rows = $this->input->post('family_history_row');
			if(!empty($fmhistory_rows)):
			foreach($fmhistory_rows as $row)
			{
				$fmhistory_name = html_escape($this->input->post('family_history_row_name_'.$row));
				
				if($fmhistory_name)
				{
					$fmhistory_data = array(
								'fmhistory_patient_id' => $patient_id,
								'fmhistory_visit_id'   => $visit_id,
								'fmhistory_name'       => $fmhistory_name,
							);
					$this->Visit_model->save_visit_family_history($fmhistory_data);
				}
			}
			endif;
			
			//Save visit diabetes history
			$diabetes_history_data = array(
										'dhistory_patient_id'                 => $patient_id,
										'dhistory_visit_id'                   => $visit_id,
										'dhistory_type_of_glucose'            => html_escape($this->input->post('type_of_glucose')),
										'dhistory_duration_of_glucose'        => html_escape($this->input->post('duration_of_glucose')),
										'dhistory_prev_bad_obstetric_history' => html_escape($this->input->post('prev_bad_obstetric_history')),
										'dhistory_prev_history_of_gdm'        => html_escape($this->input->post('prev_history_of_gdm')),
										'dhistory_past_medical_history'       => html_escape($this->input->post('past_medical_history')),
										'dhistory_symptoms_at_diagnosis'      => html_escape($this->input->post('symptoms_at_diagnosis')),
										'dhistory_symptoms_at_diagnosis_types'=> json_encode($this->input->post('symptoms_at_diagnosis_types')),
										'dhistory_other_complaints'            => html_escape($this->input->post('other_complaints')),
									);
			$this->Visit_model->save_diabetes_history($diabetes_history_data);
			
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
					$this->Visit_model->save_visit_complication($complication_data);
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
					$this->Visit_model->save_visit_general_examination($general_exam_data);
				}
			}
			endif;
			
			//Save visit general examination other content
			$g_other_txt = html_escape($this->input->post('other_physical_examinations'));
			if($g_other_txt)
			{
				$g_other_content = array(
									'gexamother_patient_id' => $patient_id,
									'gexamother_visit_id'   => $visit_id,
									'gexamother_content'    => $g_other_txt,
								);
				$this->Visit_model->save_visit_general_other_content($g_other_content);
			}
			
			//Save visit Foot examination
			$foot_examination_data = array(
										'footexm_patient_id'    => $patient_id,
										'footexm_visit_id'      => $visit_id,
										'footexm_date'          => db_formated_date($this->input->post('footexm_date')),
										'footexm_doctor_name'   => html_escape($this->input->post('footexm_doctor_name')),
										'footexm_doctor_id'     => html_escape($this->input->post('footexm_doctor_id')),
										'footexm_other_content' => html_escape($this->input->post('footexm_other_content')),
									);
			$this->Visit_model->save_foot_exam_info($foot_examination_data);
			
			//Save foot examination periferal pulse
			$foot_examination_periferal_data = array(
													'footexmprfl_patient_id'                      => $patient_id,
													'footexmprfl_visit_id'                        => $visit_id,
													'footexmprfl_arteria_dorsalis_predis_present' => html_escape($this->input->post('arteria_dorsalis_predis_present')),
													'footexmprfl_arteria_dorsalis_predis_absent'  => html_escape($this->input->post('arteria_dorsalis_predis_absent')),
													'footexmprfl_posterior_tribila_present'       => html_escape($this->input->post('posterior_tribila_present')),
													'footexmprfl_posterior_tribila_absent'        => html_escape($this->input->post('posterior_tribila_absent')),
												);
			$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);
			
			//Save foot examination sensation
			$foot_examination_sensation_data = array(
													'footexmsns_patient_id'           => $patient_id,
													'footexmsns_visit_id'             => $visit_id,
													'footexmsns_monofilament_present' => html_escape($this->input->post('monofilament_present')),
													'footexmsns_monofilament_absent'  => html_escape($this->input->post('monofilament_absent')),
													'footexmsns_tuning_fork_present'  => html_escape($this->input->post('tuning_fork_present')),
													'footexmsns_tuning_fork_absent'   => html_escape($this->input->post('tuning_fork_absent')),
												);
			$this->Visit_model->save_foot_exam_sensation_info($foot_examination_sensation_data);
			
			//Save visit diatory history
			$prev_diatory_rows = $this->input->post('prev_diatory_history_row');
			if(!empty($prev_diatory_rows)):
			foreach($prev_diatory_rows as $row)
			{
				$diehist_name       = html_escape($this->input->post('prev_diatory_history_row_name_'.$row));
				$diehist_daily      = html_escape($this->input->post('prev_diatory_history_daily_'.$row));
				$diehist_weekly     = html_escape($this->input->post('prev_diatory_history_weekly_'.$row));
				
				if($diehist_name && $diehist_daily)
				{
					$diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name'        => $diehist_name,
									'diehist_daily'       => $diehist_daily,
									'diehist_weekly'      => $diehist_weekly,
								);
					$this->Visit_model->save_visit_dietary_history($diatory_history);
				}
			}
			endif;
			
			//Save visit phisical activity
			$phisical_acitivity_rows = $this->input->post('prev_phisical_acitivity_row');
			if(!empty($phisical_acitivity_rows)):
			foreach($phisical_acitivity_rows as $row)
			{
				$physical_act_type = html_escape($this->input->post('prev_phisical_acitivity_row_name_'.$row));
				$physical_act_duration_a_day = html_escape($this->input->post('prev_phisical_acitivity_value_'.$row));
				$physical_act_duration_a_week = html_escape($this->input->post('prev_phisical_acitivity_value_per_week_'.$row));
				
				if($physical_act_type && $physical_act_duration_a_day)
				{
					$phisical_activity = array(
									'physical_act_patient_id'     => $patient_id,
									'physical_act_visit_id'       => $visit_id,
									'physical_act_type'           => $physical_act_type,
									'physical_act_duration_a_day' => $physical_act_duration_a_day,
									'physical_act_duration_a_week'=> $physical_act_duration_a_week,
								);
					$this->Visit_model->save_visit_phisical_actitivites($phisical_activity);
				}
			}
			endif;
			
			//Save Eye examination
			$eye_examination_data = array(
										'eyeexam_patient_id'  => $patient_id,
										'eyeexam_visit_id'    => $visit_id,
										'eyeexam_date'        => db_formated_date($this->input->post('eyeexam_date')),
										'eyeexam_left_eye'    => html_escape($this->input->post('eyeexam_left_eye')),
										'eyeexam_right_eye'   => html_escape($this->input->post('eyeexam_right_eye')),
										'eyeexam_other'       => html_escape($this->input->post('eyeexam_other')),
										'eyeexam_treatment'   => html_escape($this->input->post('eyeexam_treatment')),
										'eyeexam_doctor_name' => html_escape($this->input->post('eyeexam_doctor_name')),
										'eyeexam_doctor_id'   => html_escape($this->input->post('eyeexam_doctor_id')),
									);
			$this->Visit_model->save_visit_eye_exam_info($eye_examination_data);
			
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
					$this->Visit_model->save_visit_laboratory_investigation($laboratory_investigation);
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
			$this->Visit_model->save_visit_laboratory_ecg($ecg_data);
			
			//Save Drug History
			$drug_history_data = array(
									'drughistory_patient_id'                => $patient_id,
									'drughistory_visit_id'                  => $visit_id,
									'drughistory_date'                      => db_formated_date($this->input->post('drughistory_date')),
									'drughistory_fdiagnosis'                => html_escape($this->input->post('drughistory_fdiagnosis')),
									'drughistory_other_associated_diseases' => html_escape($this->input->post('drughistory_other_associated_diseases')),
								);
			$this->Visit_model->save_visit_drug_history($drug_history_data);
			
			// Prev OADs
			$oads_row_rows = $this->input->post('oads_row');
			if($this->input->post('prev_is_oads') == '1' && !empty($oads_row_rows)):
			foreach($oads_row_rows as $row)
			{
				$oads_name = html_escape($this->input->post('oads_name_'.$row));
				$oads_dose = html_escape($this->input->post('oads_value_'.$row));
				
				$prev_oads_condition_time      = html_escape($this->input->post('oads_condition_time_'.$row));
				$prev_oads_condition_time_type = html_escape($this->input->post('oads_condition_time_type_'.$row));
				$prev_oads_condition_apply     = html_escape($this->input->post('oads_condition_apply_'.$row));
				$prev_oads_duration            = html_escape($this->input->post('oads_duration_'.$row));
				$prev_oads_duration_type       = html_escape($this->input->post('oads_duration_type_'.$row));
				
				if($prev_oads_condition_time & $prev_oads_duration){
					$oads_advice_codition_time        = $prev_oads_condition_time;
					$oads_advice_codition_time_type   = $prev_oads_condition_time_type;
					$oads_advice_codition_apply       = $prev_oads_condition_apply;
					$oads_duration                    = $prev_oads_duration;
					$oads_duration_type               = $prev_oads_duration_type;
					
				}else{
					$oads_advice_codition_time      = null;
					$oads_advice_codition_time_type = null;
					$oads_advice_codition_apply     = null;
					$oads_duration                  = null;
					$oads_duration_type             = null;
				}
				
				if($oads_name && $oads_dose)
				{
					$oads_data = array(
									'oads_patient_id' => $patient_id,
									'oads_visit_id'   => $visit_id,
									'oads_name'       => $oads_name,
									'oads_dose'       => $oads_dose,
									'oads_advice_codition_time'      => $oads_advice_codition_time,
									'oads_advice_codition_time_type' => $oads_advice_codition_time_type,
									'oads_advice_codition_apply'     => $oads_advice_codition_apply,
									'oads_duration'                  => $oads_duration,
									'oads_duration_type'             => $oads_duration_type,
								);
					$this->Visit_model->save_visitprev_oads($oads_data);
				}
			}
			endif;
			
			// Prev Insulin
			$prev_insulin_rows = $this->input->post('prev_insulin_row');
			if($this->input->post('prev_is_insulin') == '1' && !empty($prev_insulin_rows)):
			foreach($prev_insulin_rows as $row)
			{
				$prev_insulin_name = html_escape($this->input->post('prev_insulin_name_'.$row));
				$prev_insulin_dose = html_escape($this->input->post('prev_insulin_value_'.$row));
				
				$prev_insulin_condition_time      = html_escape($this->input->post('prev_insulin_condition_time_'.$row));
				$prev_insulin_condition_time_type = html_escape($this->input->post('prev_insulin_condition_time_type_'.$row));
				$prev_insulin_condition_apply     = html_escape($this->input->post('prev_insulin_condition_apply_'.$row));
				$prev_insulin_duration            = html_escape($this->input->post('prev_insulin_duration_'.$row));
				$prev_insulin_duration_type       = html_escape($this->input->post('prev_insulin_duration_type_'.$row));
				
				if($prev_insulin_condition_time & $prev_insulin_duration){
					$insulin_advice_codition_time      = $prev_insulin_condition_time;
					$insulin_advice_codition_time_type = $prev_insulin_condition_time_type;
					$insulin_advice_codition_apply     = $prev_insulin_condition_apply;
					$insulin_duration                  = $prev_insulin_duration;
					$insulin_duration_type             = $prev_insulin_duration_type;
				}else{
					$insulin_advice_codition_time      = null;
					$insulin_advice_codition_time_type = null;
					$insulin_advice_codition_apply     = null;
					$insulin_duration                  = null;
					$insulin_duration_type             = null;
				}
				
				if($prev_insulin_name && $prev_insulin_dose)
				{
					$prev_insulin_data = array(
									'insulin_patient_id' => $patient_id,
									'insulin_visit_id'   => $visit_id,
									'insulin_name'       => $prev_insulin_name,
									'insulin_dose'       => $prev_insulin_dose,
									'insulin_advice_codition_time'      => $insulin_advice_codition_time,
									'insulin_advice_codition_time_type' => $insulin_advice_codition_time_type,
									'insulin_advice_codition_apply'     => $insulin_advice_codition_apply,
									'insulin_duration'                  => $insulin_duration,
									'insulin_duration_type'             => $insulin_duration_type,
								);
					$this->Visit_model->save_visitprev_insulin($prev_insulin_data);
				}
			}
			endif;
			
			// prev anti htn
			$anti_htn_row_rows = $this->input->post('anti_htn_row');
			if($this->input->post('prev_is_anti_htn') == '1' && !empty($anti_htn_row_rows)):
			foreach($anti_htn_row_rows as $row)
			{
				$anti_htn_name = html_escape($this->input->post('anti_htn_name_'.$row));
				$anti_htn_dose = html_escape($this->input->post('anti_htn_value_'.$row));
				
				$prev_anti_htn_condition_time      = html_escape($this->input->post('anti_htn_condition_time_'.$row));
				$prev_anti_htn_condition_time_type = html_escape($this->input->post('anti_htn_condition_time_type_'.$row));
				$prev_anti_htn_condition_apply     = html_escape($this->input->post('anti_htn_condition_apply_'.$row));
				$prev_anti_htn_duration            = html_escape($this->input->post('anti_htn_duration_'.$row));
				$prev_anti_htn_duration_type       = html_escape($this->input->post('anti_htn_duration_type_'.$row));
				
				if($prev_anti_htn_condition_time & $prev_anti_htn_duration){
					$anti_htn_advice_codition_time      = $prev_anti_htn_condition_time;
					$anti_htn_advice_codition_time_type = $prev_anti_htn_condition_time_type;
					$anti_htn_advice_codition_apply     = $prev_anti_htn_condition_apply;
					$anti_htn_duration                  = $prev_anti_htn_duration;
					$anti_htn_duration_type             = $prev_anti_htn_duration_type;
				}else{
					$anti_htn_advice_codition_time      = null;
					$anti_htn_advice_codition_time_type = null;
					$anti_htn_advice_codition_apply     = null;
					$anti_htn_duration                  = null;
					$anti_htn_duration_type             = null;
				}
				
				if($anti_htn_name && $anti_htn_dose)
				{
					$anti_htn_dose_data = array(
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
					$this->Visit_model->save_visitprev_anti_htn($anti_htn_dose_data);
				}
			}
			endif;
			
			// prev anti lipids
			$lipids_rows = $this->input->post('lipids_row');
			if($this->input->post('prev_is_anti_lipids') == '1' && !empty($lipids_rows)):
			foreach($lipids_rows as $row)
			{
				$anti_lipid_name = html_escape($this->input->post('lipids_name_'.$row));
				$anti_lipid_dose = html_escape($this->input->post('lipids_value_'.$row));
				
				$prev_anti_lipid_condition_time      = html_escape($this->input->post('lipids_condition_time_'.$row));
				$prev_anti_lipid_condition_time_type = html_escape($this->input->post('lipids_condition_time_type_'.$row));
				$prev_anti_lipid_condition_apply     = html_escape($this->input->post('lipids_condition_apply_'.$row));
				$prev_anti_lipid_duration            = html_escape($this->input->post('lipids_duration_'.$row));
				$prev_anti_lipid_duration_type       = html_escape($this->input->post('lipids_duration_type_'.$row));
				
				if($prev_anti_lipid_condition_time & $prev_anti_lipid_duration){
					$anti_lipid_advice_codition_time      = $prev_anti_lipid_condition_time;
					$anti_lipid_advice_codition_time_type = $prev_anti_lipid_condition_time_type;
					$anti_lipid_advice_codition_apply     = $prev_anti_lipid_condition_apply;
					$anti_lipid_duration                  = $prev_anti_lipid_duration;
					$anti_lipid_duration_type             = $prev_anti_lipid_duration_type;
				}else{
					$anti_lipid_advice_codition_time      = null;
					$anti_lipid_advice_codition_time_type = null;
					$anti_lipid_advice_codition_apply     = null;
					$anti_lipid_duration                  = null;
					$anti_lipid_duration_type             = null;
				}
				
				if($anti_lipid_name && $anti_lipid_dose)
				{
					$prev_anti_lipids_data = array(
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
					$this->Visit_model->save_visitprev_anti_lipids($prev_anti_lipids_data);
				}
			}
			endif;
			
			// prev antiplatelets
			$aspirine_rows = $this->input->post('aspirine_row');
			if($this->input->post('prev_is_aspirine') == '1' && !empty($aspirine_rows)):
			foreach($aspirine_rows as $row)
			{
				$prev_antiplatelets_name = html_escape($this->input->post('aspirine_name_'.$row));
				$prev_antiplatelets_dose = html_escape($this->input->post('aspirine_value_'.$row));
				
				$prev_antiplatelets_condition_time      = html_escape($this->input->post('aspirine_condition_time_'.$row));
				$prev_antiplatelets_condition_time_type = html_escape($this->input->post('aspirine_condition_time_type_'.$row));
				$prev_antiplatelets_condition_apply     = html_escape($this->input->post('aspirine_condition_apply_'.$row));
				$prev_antiplatelets_duration            = html_escape($this->input->post('aspirine_duration_'.$row));
				$prev_antiplatelets_duration_type       = html_escape($this->input->post('aspirine_duration_type_'.$row));
				
				if($prev_antiplatelets_condition_time & $prev_antiplatelets_duration){
					$antiplatelets_advice_codition_time       = $prev_antiplatelets_condition_time;
					$antiplatelets_advice_codition_time_type  = $prev_antiplatelets_condition_time_type;
					$antiplatelets_advice_codition_apply      = $prev_antiplatelets_condition_apply;
					$antiplatelets_duration                   = $prev_antiplatelets_duration;
					$antiplatelets_duration_type              = $prev_antiplatelets_duration_type;
				}else{
					$antiplatelets_advice_codition_time       = null;
					$antiplatelets_advice_codition_time_type  = null;
					$antiplatelets_advice_codition_apply      = null;
					$antiplatelets_duration                   = null;
					$antiplatelets_duration_type              = null;
				}
				
				if($prev_antiplatelets_name && $prev_antiplatelets_dose)
				{
					$prev_antiplatelets_data = array(
									'antiplatelets_patient_id' => $patient_id,
									'antiplatelets_visit_id'   => $visit_id,
									'antiplatelets_name'       => $prev_antiplatelets_name,
									'antiplatelets_dose'       => $prev_antiplatelets_dose,
									'antiplatelets_advice_codition_time'      => $antiplatelets_advice_codition_time,
									'antiplatelets_advice_codition_time_type' => $antiplatelets_advice_codition_time_type,
									'antiplatelets_advice_codition_apply'     => $antiplatelets_advice_codition_apply,
									'antiplatelets_duration'                  => $antiplatelets_duration,
									'antiplatelets_duration_type'             => $antiplatelets_duration_type,
								);
					$this->Visit_model->save_visitprev_antiplatelets($prev_antiplatelets_data);
				}
			}
			endif;
			
			
			// prev anti obesity
			$obesity_rows = $this->input->post('obesity_row');
			if($this->input->post('prev_is_anti_obesity') == '1' && !empty($obesity_rows)):
			foreach($obesity_rows as $row)
			{
				$anti_obesity_name = html_escape($this->input->post('obesity_name_'.$row));
				$anti_obesity_dose = html_escape($this->input->post('obesity_value_'.$row));
				
				$prev_obesity_condition_time      = html_escape($this->input->post('obesity_condition_time_'.$row));
				$prev_obesity_condition_time_type = html_escape($this->input->post('obesity_condition_time_type_'.$row));
				$prev_obesity_condition_apply     = html_escape($this->input->post('obesity_condition_apply_'.$row));
				$prev_obesity_duration            = html_escape($this->input->post('obesity_duration_'.$row));
				$prev_obesity_duration_type       = html_escape($this->input->post('obesity_duration_type_'.$row));
				
				if($prev_obesity_condition_time & $prev_obesity_duration){
					$anti_obesity_advice_codition_time       = $prev_obesity_condition_time;
					$anti_obesity_advice_codition_time_type  = $prev_obesity_condition_time_type;
					$anti_obesity_advice_codition_apply      = $prev_obesity_condition_apply;
					$anti_obesity_duration                   = $prev_obesity_duration;
					$anti_obesity_duration_type              = $prev_obesity_duration_type;
				}else{
					$anti_obesity_advice_codition_time       = null;
					$anti_obesity_advice_codition_time_type  = null;
					$anti_obesity_advice_codition_apply      = null;
					$anti_obesity_duration                   = null;
					$anti_obesity_duration_type              = null;
				}
				
				if($anti_obesity_name && $anti_obesity_dose)
				{
					$prev_anti_obesity_data = array(
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
					$this->Visit_model->save_visitprev_anti_obesity($prev_anti_obesity_data);
				}
			}
			endif;
			
			// prev other
			$other_rows = $this->input->post('other_row');
			if($this->input->post('prev_is_others') == '1' && !empty($other_rows)):
			foreach($other_rows as $row)
			{
				$other_name = html_escape($this->input->post('other_name_'.$row));
				$other_dose = html_escape($this->input->post('other_value_'.$row));
				
				$prev_other_condition_time      = html_escape($this->input->post('other_condition_time_'.$row));
				$prev_other_condition_time_type = html_escape($this->input->post('other_condition_time_type_'.$row));
				$prev_other_condition_apply     = html_escape($this->input->post('other_condition_apply_'.$row));
				$prev_other_duration            = html_escape($this->input->post('other_duration_'.$row));
				$prev_other_duration_type       = html_escape($this->input->post('other_duration_type_'.$row));
				
				if($prev_other_condition_time & $prev_other_duration){
					$other_advice_codition_time        = $prev_other_condition_time;
					$other_advice_codition_time_type   = $prev_other_condition_time_type;
					$other_advice_codition_apply       = $prev_other_condition_apply;
					$other_duration                    = $prev_other_duration;
					$other_duration_type               = $prev_other_duration_type;
				}else{
					$other_advice_codition_time        = null;
					$other_advice_codition_time_type   = null;
					$other_advice_codition_apply       = null;
					$other_duration                    = null;
					$other_duration_type               = null;
				}
				
				if($other_name && $other_dose)
				{
					$prev_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
									'other_advice_codition_time'      => $other_advice_codition_time,
									'other_advice_codition_time_type' => $other_advice_codition_time_type,
									'other_advice_codition_apply'     => $other_advice_codition_apply,
									'other_duration'                  => $other_duration,
									'other_duration_type'             => $other_duration_type,
								);
					$this->Visit_model->save_visitprev_omedication_other($prev_omedication_other);
				}
			}
			endif;
			
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
			$this->Visit_model->save_final_treatment_infos($final_treatment_data);
				
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
					$this->Visit_model->save_visitcrnt_oads($crnt_oads_data);
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
					$this->Visit_model->save_visitcrnt_insulin($crnt_insulin_data);
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
					$this->Visit_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
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
					$this->Visit_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
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
					$this->Visit_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
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
					$this->Visit_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
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
					$this->Visit_model->save_visitcrnt_omedication_other($crnt_omedication_other);
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
			$this->Visit_model->save_payment_data($payment_data);
			
			
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
	
	
	
	public function update()
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
		$visit_id = $this->input->post('id');
		
		$basic_data = array(
						'visit_type'               => html_escape($this->input->post('visit_type')),
						'visit_date'               => date("Y-m-d"),
						'visit_has_symptomatic'    => html_escape($this->input->post('is_sympt')),
						'visit_symptomatic_type'   => html_escape($this->input->post('sympt_type')),
						'visit_patient_type'       => html_escape($this->input->post('patient_type')),
						'visit_diabetes_duration'  => html_escape($this->input->post('diabetes_duration')),
						'visit_registration_center'=> html_escape($this->input->post('registration_center')),
						'visit_visit_center'       => html_escape($this->input->post('visit_center')),
						'visit_doctor'             => html_escape($this->input->post('to_doctor')),
						'visit_guidebook_no'       => html_escape($this->input->post('guidebook_no')),
						'visit_types_of_diabetes'  => html_escape($this->input->post('types_of_diabetes')),
					  );
		$validate = array(
						array(
							'field' => 'visit_type', 
							'label' => 'Visit Type', 
							'rules' => 'Required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//Save basic visit informations
			$this->Visit_model->update_visit_information($basic_data, $visit_id, $patient_id);
			
			if($this->input->post('patient_gender') == '1')
			{
				//Save mestrual informations
				$this->Visit_model->delete_mestrual_info($visit_id, $patient_id);
				$mestrual_data = array(
									'menstrlc_visit_id'   => $visit_id,
									'menstrlc_patient_id' => $patient_id,
									'menstrlc_regular'    => html_escape($this->input->post('mentrual_regular')),
									'menstrlc_irregular'  => html_escape($this->input->post('mentrual_irregular')),
									'menstrlc_menopause'  => html_escape($this->input->post('mentrual_menopause')),
								);
				$this->Visit_model->save_mestrual_info($mestrual_data);
				
				//Save Obstetric History
				$this->Visit_model->delete_obstetric_history($visit_id, $patient_id);
				$obstetric_history = array(
										'obstetric_visit_id'             => $visit_id,
										'obstetric_patient_id'           => $patient_id,
										'obstetric_children'             => html_escape($this->input->post('obstetric_no_of_children')),
										'obstetric_large_baby'           => html_escape($this->input->post('obstetric_no_of_largebaby')),
										'obstetric_infertility_duration' => html_escape($this->input->post('obstetric_fertility_duration')),
										'obstetric_last_child_age'       => html_escape($this->input->post('obstetric_last_child_age')),
									 );
				$this->Visit_model->save_obstetric_history($obstetric_history);
			}
			
			//Save visit general examination
			$this->Visit_model->delete_visit_general_examination($visit_id, $patient_id);
			$gexam_rows = $this->input->post('gexam_row');
			if(!empty($gexam_rows)):
			foreach($gexam_rows as $row)
			{
				$generalexam_name = html_escape($this->input->post('gexam_row_name_'.$row));
				//$generalexam_unit = html_escape($this->input->post('gexam_row_unit_'.$row));
				$generalexam_value = html_escape($this->input->post('gexam_row_value_'.$row));
				$generalexam_unit  = html_escape($this->input->post('gexam_row_unit_'.$row));
				
				if($generalexam_name && $generalexam_value)
				{
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'generalexam_name'       => $generalexam_name,
										'generalexam_value'      => $generalexam_value,
										'generalexam_unit'       => $generalexam_unit,
									);
					$this->Visit_model->save_visit_general_examination($general_exam_data);
				}
			}
			endif;
			
			
			//Save visit laboratory investigation
			$this->Visit_model->delete_visit_laboratory_investigation($visit_id, $patient_id);
			$labinv_rows = $this->input->post('labinv_row');
			if(!empty($labinv_rows)):
			foreach($labinv_rows as $row)
			{
				$labinv_name = html_escape($this->input->post('labinv_row_name_'.$row));
				$labinv_value = html_escape($this->input->post('labinv_row_value_'.$row));
				
				if($labinv_name && $labinv_value)
				{
					$laboratory_investigation = array(
										'labinvs_patient_id' => $patient_id,
										'labinvs_visit_id'   => $visit_id,
										'labinvs_name'       => $labinv_name,
										'labinvs_value'      => $labinv_value,
									);
					$this->Visit_model->save_visit_laboratory_investigation($laboratory_investigation);
				}
			}
			endif;
			
			//Save visit laboratory investigation ECG
			$this->Visit_model->delete_visit_laboratory_ecg($visit_id, $patient_id);
			$ecg_abnormals = $this->input->post('abn_keywords');
			$ecg_data = array(
							'ecg_patient_id' => $patient_id,
							'ecg_visit_id'   => $visit_id,
							'ecg_type'       => html_escape($this->input->post('ecg_type')),
							'ecg_abnormals'  => json_encode($ecg_abnormals),
						);
			$this->Visit_model->save_visit_laboratory_ecg($ecg_data);

			//Save Acute visit complication
			$this->Visit_model->delete_visit_acute_complication($visit_id, $patient_id);
			$acute_complication_rows = $this->input->post('acute_complication_row');
			if(!empty($acute_complication_rows)):
			foreach($acute_complication_rows as $row)
			{
				$complication_name = html_escape($this->input->post('acute_complication_'.$row));
				
				if($complication_name)
				{
					$complication_data = array(
											'vcomplication_patient_id' => $patient_id,
											'vcomplication_visit_id'   => $visit_id,
											'vcomplication_name'       => $complication_name,
										);
					$this->Visit_model->save_visit_acute_complication($complication_data);
				}
			}
			endif;
			
			//Save visit complication
			$this->Visit_model->delete_visit_complication($visit_id, $patient_id);
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
					$this->Visit_model->save_visit_complication($complication_data);
				}
			}
			endif;
			
			
			//Save visit personal habit
			$this->Visit_model->delete_visit_personal_habits($visit_id, $patient_id);
			$phabit_rows = $this->input->post('phabit_row');
			if(!empty($phabit_rows)):
			foreach($phabit_rows as $row)
			{
				$phabit_name = html_escape($this->input->post('phabit_row_name_'.$row));
				$phabit_adiction_type = html_escape($this->input->post('phabit_'.$row));
				$phabit_amount = html_escape($this->input->post('phabit_amount_'.$row));
				$phabit_time_unit = html_escape($this->input->post('phabit_time_'.$row));
				
				if($phabit_name && $phabit_adiction_type)
				{
					$phabit_data = array(
						'phabit_patient_id'    => $patient_id,
						'phabit_visit_id'      => $visit_id,
						'phabit_name'          => $phabit_name,
						'phabit_adiction_type' => $phabit_adiction_type,
						'phabit_amount'        => $phabit_amount,
						'phabit_time_unit'     => $phabit_time_unit,
					);
					$this->Visit_model->save_visit_personal_habits($phabit_data);
				}
			}
			endif;
			
			
			//Save visit family history
			$this->Visit_model->delete_visit_family_history($visit_id, $patient_id);
			$fmhistory_rows = $this->input->post('fmdetails_row');
			if(!empty($fmhistory_rows)):
			foreach($fmhistory_rows as $row)
			{
				$fmhistory_label = html_escape($this->input->post('fmdetails_row_label_'.$row));
				$fmhistory_diabetes = $this->input->post('diabetes_radio_'.$row);
				$fmhistory_htn = $this->input->post('htn_radio_'.$row);
				$fmhistory_ihd = $this->input->post('mi_radio_'.$row);
				$fmhistory_stroke = $this->input->post('stroke_radio_'.$row);
				$fmhistory_amupation = $this->input->post('amupation_radio_'.$row);
				
				if($fmhistory_label)
				{
					$fmhistory_data = array(
								'fmhistory_patient_id' => $patient_id,
								'fmhistory_visit_id'   => $visit_id,
								'fmhistory_label'      => $fmhistory_label,
								'fmhistory_diabetes'   => $fmhistory_diabetes,
								'fmhistory_htn'        => $fmhistory_htn,
								'fmhistory_ihd'        => $fmhistory_ihd,
								'fmhistory_stroke'     => $fmhistory_stroke,
								'fmhistory_amupation'  => $fmhistory_amupation,
							);
					$this->Visit_model->save_visit_family_history($fmhistory_data);
				}
			}
			endif;
			
			
			//Save visit previous diatory history
			$this->Visit_model->delete_visit_prev_diatory_history($visit_id, $patient_id);
			$prev_diatory_rows = $this->input->post('prev_diatory_history_row');
			if(!empty($prev_diatory_rows)):
			foreach($prev_diatory_rows as $row)
			{
				$diehist_name       = html_escape($this->input->post('prev_diatory_history_row_name_'.$row));
				$diehist_daily      = html_escape($this->input->post('prev_diatory_history_daily_'.$row));
				$diehist_weekly     = html_escape($this->input->post('prev_diatory_history_weekly_'.$row));
				$diehist_monthly    = html_escape($this->input->post('prev_diatory_history_monthly_'.$row));
				$diehist_calore     = html_escape($this->input->post('prev_diatory_history_calorie_'.$row));
				$diehist_diet_chart = html_escape($this->input->post('prev_diatory_history_diet_'.$row));
				
				if($diehist_name && $diehist_daily)
				{
					$prev_diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name'        => $diehist_name,
									'diehist_daily'       => $diehist_daily,
									'diehist_weekly'      => $diehist_weekly,
									'diehist_monthly'     => $diehist_monthly,
									'diehist_calore'      => $diehist_calore,
									'diehist_diet_chart'  => $diehist_diet_chart,
								);
					$this->Visit_model->save_visit_prev_diatory_history($prev_diatory_history);
				}
			}
			endif;
			
			
			//Save visit previous type of cooking oil
			$this->Visit_model->delete_visit_prev_cookingoil($visit_id, $patient_id);
			$cookingoil_rows = $this->input->post('prev_cookoil_row');
			if(!empty($cookingoil_rows)):
			foreach($cookingoil_rows as $row)
			{
				$cooking_oil_name = html_escape($this->input->post('prev_cookoil_row_name_'.$row));
				$cooking_oil_has_used = html_escape($this->input->post('prev_cookoil_'.$row));
				$cooking_oil_litr_permonth = html_escape($this->input->post('prev_cookoil_amount_'.$row));
				
				if($cooking_oil_name && $cooking_oil_has_used)
				{
					$prev_type_of_cooking = array(
									'cooking_oil_patient_id'    => $patient_id,
									'cooking_oil_visit_id'      => $visit_id,
									'cooking_oil_name'          => $cooking_oil_name,
									'cooking_oil_has_used'      => $cooking_oil_has_used,
									'cooking_oil_litr_permonth' => $cooking_oil_litr_permonth,
								);
					$this->Visit_model->save_visit_prev_cookingoil($prev_type_of_cooking);
				}
			}
			endif;
			
			
			//Save visit previous phisical activity
			$this->Visit_model->delete_visitprev_phisical_actitivites($visit_id, $patient_id);
			$phisical_acitivity_rows = $this->input->post('prev_phisical_acitivity_row');
			if(!empty($phisical_acitivity_rows)):
			foreach($phisical_acitivity_rows as $row)
			{
				$physical_act_type = html_escape($this->input->post('prev_phisical_acitivity_row_name_'.$row));
				$physical_act_duration_a_day = html_escape($this->input->post('prev_phisical_acitivity_value_'.$row));
				
				if($physical_act_type && $physical_act_duration_a_day)
				{
					$prev_phisical_activity = array(
									'physical_act_patient_id'     => $patient_id,
									'physical_act_visit_id'       => $visit_id,
									'physical_act_type'           => $physical_act_type,
									'physical_act_duration_a_day' => $physical_act_duration_a_day,
								);
					$this->Visit_model->save_visitprev_phisical_actitivites($prev_phisical_activity);
				}
			}
			endif;
			
			
			//Save Previous Medication
				
				// Prev OADs
				$this->Visit_model->delete_visitprev_oads($visit_id, $patient_id);
				$oads_row_rows = $this->input->post('oads_row');
				if($this->input->post('prev_is_oads') == '1' && !empty($oads_row_rows)):
				foreach($oads_row_rows as $row)
				{
					$oads_name = html_escape($this->input->post('oads_name_'.$row));
					$oads_dose = html_escape($this->input->post('oads_value_'.$row));
					
					if($oads_name && $oads_dose)
					{
						$oads_data = array(
										'oads_patient_id' => $patient_id,
										'oads_visit_id'   => $visit_id,
										'oads_name'       => $oads_name,
										'oads_dose'       => $oads_dose,
									);
						$this->Visit_model->save_visitprev_oads($oads_data);
					}
				}
				endif;
				
				// Prev Insulin
				$this->Visit_model->delete_visitprev_insulin($visit_id, $patient_id);
				$prev_insulin_rows = $this->input->post('prev_insulin_row');
				if($this->input->post('prev_is_insulin') == '1' && !empty($prev_insulin_rows)):
				foreach($prev_insulin_rows as $row)
				{
					$prev_insulin_name = html_escape($this->input->post('prev_insulin_name_'.$row));
					$prev_insulin_dose = html_escape($this->input->post('prev_insulin_value_'.$row));
					
					if($prev_insulin_name && $prev_insulin_dose)
					{
						$prev_insulin_data = array(
										'insulin_patient_id' => $patient_id,
										'insulin_visit_id'   => $visit_id,
										'insulin_name'       => $prev_insulin_name,
										'insulin_dose'       => $prev_insulin_dose,
									);
						$this->Visit_model->save_visitprev_insulin($prev_insulin_data);
					}
				}
				endif;
				
				// prev anti htn
				$this->Visit_model->delete_visitprev_anti_htn($visit_id, $patient_id);
				$anti_htn_row_rows = $this->input->post('anti_htn_row');
				if($this->input->post('prev_is_anti_htn') == '1' && !empty($anti_htn_row_rows)):
				foreach($anti_htn_row_rows as $row)
				{
					$anti_htn_name = html_escape($this->input->post('anti_htn_name_'.$row));
					$anti_htn_dose = html_escape($this->input->post('anti_htn_value_'.$row));
					
					if($anti_htn_name && $anti_htn_dose)
					{
						$anti_htn_dose_data = array(
										'anti_htn_patient_id' => $patient_id,
										'anti_htn_visit_id'   => $visit_id,
										'anti_htn_name'       => $anti_htn_name,
										'anti_htn_dose'       => $anti_htn_dose,
									);
						$this->Visit_model->save_visitprev_anti_htn($anti_htn_dose_data);
					}
				}
				endif;
				
				// prev anti lipids
				$this->Visit_model->delete_visitprev_anti_lipids($visit_id, $patient_id);
				$lipids_rows = $this->input->post('lipids_row');
				if($this->input->post('prev_is_anti_lipids') == '1' && !empty($lipids_rows)):
				foreach($lipids_rows as $row)
				{
					$anti_lipid_name = html_escape($this->input->post('lipids_name_'.$row));
					$anti_lipid_dose = html_escape($this->input->post('lipids_value_'.$row));
					
					if($anti_lipid_name && $anti_lipid_dose)
					{
						$prev_anti_lipids_data = array(
										'anti_lipid_patient_id' => $patient_id,
										'anti_lipid_visit_id'   => $visit_id,
										'anti_lipid_name'       => $anti_lipid_name,
										'anti_lipid_dose'       => $anti_lipid_dose,
									);
						$this->Visit_model->save_visitprev_anti_lipids($prev_anti_lipids_data);
					}
				}
				endif;
				
				// prev antiplatelets
				$this->Visit_model->delete_visitprev_antiplatelets($visit_id, $patient_id);
				$aspirine_rows = $this->input->post('aspirine_row');
				if($this->input->post('prev_is_aspirine') == '1' && !empty($aspirine_rows)):
				foreach($aspirine_rows as $row)
				{
					$prev_antiplatelets_name = html_escape($this->input->post('aspirine_name_'.$row));
					$prev_antiplatelets_dose = html_escape($this->input->post('aspirine_value_'.$row));
					
					if($prev_antiplatelets_name && $prev_antiplatelets_dose)
					{
						$prev_antiplatelets_data = array(
										'antiplatelets_patient_id' => $patient_id,
										'antiplatelets_visit_id'   => $visit_id,
										'antiplatelets_name'       => $prev_antiplatelets_name,
										'antiplatelets_dose'       => $prev_antiplatelets_dose,
									);
						$this->Visit_model->save_visitprev_antiplatelets($prev_antiplatelets_data);
					}
				}
				endif;
				
				// prev cardiac medication
				$this->Visit_model->delete_visitprev_cardiac_medication($visit_id, $patient_id);
				$cardiac_medication_rows = $this->input->post('cardiac_medication_row');
				if($this->input->post('prev_is_cardiac_medication') == '1' && !empty($cardiac_medication_rows)):
				foreach($cardiac_medication_rows as $row)
				{
					$cardiac_medication_name = html_escape($this->input->post('cardiac_medication_name_'.$row));
					$cardiac_medication_dose = html_escape($this->input->post('cardiac_medication_value_'.$row));
					
					if($cardiac_medication_name && $cardiac_medication_dose)
					{
						$prev_cardiac_medication_data = array(
										'cardiac_medication_patient_id' => $patient_id,
										'cardiac_medication_visit_id'   => $visit_id,
										'cardiac_medication_name'       => $cardiac_medication_name,
										'cardiac_medication_dose'       => $cardiac_medication_dose,
									);
						$this->Visit_model->save_visitprev_cardiac_medication($prev_cardiac_medication_data);
					}
				}
				endif;
				
				
				// prev anti obesity
				$this->Visit_model->delete_visitprev_anti_obesity($visit_id, $patient_id);
				$obesity_rows = $this->input->post('obesity_row');
				if($this->input->post('prev_is_anti_obesity') == '1' && !empty($obesity_rows)):
				foreach($obesity_rows as $row)
				{
					$anti_obesity_name = html_escape($this->input->post('obesity_name_'.$row));
					$anti_obesity_dose = html_escape($this->input->post('obesity_value_'.$row));
					
					if($anti_obesity_name && $anti_obesity_dose)
					{
						$prev_anti_obesity_data = array(
										'anti_obesity_patient_id' => $patient_id,
										'anti_obesity_visit_id'   => $visit_id,
										'anti_obesity_name'       => $anti_obesity_name,
										'anti_obesity_dose'       => $anti_obesity_dose,
									);
						$this->Visit_model->save_visitprev_anti_obesity($prev_anti_obesity_data);
					}
				}
				endif;
				
				// prev other medication other
				$this->Visit_model->delete_visitprev_omedication_other($visit_id, $patient_id);
				$other_rows = $this->input->post('other_row');
				if($this->input->post('prev_is_others') == '1' && !empty($other_rows)):
				foreach($other_rows as $row)
				{
					$other_name = $this->input->post('other_name_'.$row);
					$other_dose = $this->input->post('other_value_'.$row);
					
					if($other_name && $other_dose)
					{
						$prev_omedication_other = array(
										'other_patient_id' => $patient_id,
										'other_visit_id'   => $visit_id,
										'other_name'       => $other_name,
										'other_dose'       => $other_dose,
									);
						$this->Visit_model->save_visitprev_omedication_other($prev_omedication_other);
					}
				}
				endif;
			
			//Save visit Current advice diatory history
			$this->Visit_model->delete_visit_crnt_diatory_history($visit_id, $patient_id);
			$crnt_diatory_rows = $this->input->post('crnt_diatory_history_row');
			if(!empty($crnt_diatory_rows)):
			foreach($crnt_diatory_rows as $row)
			{
				$diehist_name       = html_escape($this->input->post('crnt_diatory_history_row_name_'.$row));
				$diehist_daily      = html_escape($this->input->post('crnt_diatory_history_daily_'.$row));
				$diehist_weekly     = html_escape($this->input->post('crnt_diatory_history_weekly_'.$row));
				$diehist_monthly    = html_escape($this->input->post('crnt_diatory_history_monthly_'.$row));
				$diehist_calore     = html_escape($this->input->post('crnt_diatory_history_calorie_'.$row));
				$diehist_diet_chart = html_escape($this->input->post('crnt_diatory_history_diet_'.$row));
				
				if($diehist_name && $diehist_daily)
				{
					$crnt_diatory_history = array(
									'diehist_patient_id'  => $patient_id,
									'diehist_visit_id'    => $visit_id,
									'diehist_name'        => $diehist_name,
									'diehist_daily'       => $diehist_daily,
									'diehist_weekly'      => $diehist_weekly,
									'diehist_monthly'     => $diehist_monthly,
									'diehist_calore'      => $diehist_calore,
									'diehist_diet_chart'  => $diehist_diet_chart,
								);
					$this->Visit_model->save_visit_crnt_diatory_history($crnt_diatory_history);
				}
			}
			endif;
			
			//Save visit current advice type of cooking oil
			$this->Visit_model->delete_visit_crnt_cookingoil($visit_id, $patient_id);
			$cookingoil_rows = $this->input->post('crnt_cookoil_row');
			if(!empty($cookingoil_rows)):
			foreach($cookingoil_rows as $row)
			{
				$cooking_oil_name = html_escape($this->input->post('crnt_cookoil_row_name_'.$row));
				$cooking_oil_has_used = html_escape($this->input->post('crnt_cookoil_'.$row));
				$cooking_oil_litr_permonth = html_escape($this->input->post('crnt_cookoil_amount_'.$row));
				
				if($cooking_oil_name && $cooking_oil_has_used)
				{
					$crnt_type_of_cooking = array(
									'cooking_oil_patient_id'    => $patient_id,
									'cooking_oil_visit_id'      => $visit_id,
									'cooking_oil_name'          => $cooking_oil_name,
									'cooking_oil_has_used'      => $cooking_oil_has_used,
									'cooking_oil_litr_permonth' => $cooking_oil_litr_permonth,
								);
					$this->Visit_model->save_visit_crnt_cookingoil($crnt_type_of_cooking);
				}
			}
			endif;
			
			
			//Save visit current advice phisical activity
			$this->Visit_model->delete_visitcrnt_phisical_actitivites($visit_id, $patient_id);
			$phisical_acitivity_rows = $this->input->post('crnt_phisical_acitivity_row');
			if(!empty($phisical_acitivity_rows)):
			foreach($phisical_acitivity_rows as $row)
			{
				$physical_act_type = html_escape($this->input->post('crnt_phisical_acitivity_row_name_'.$row));
				$physical_act_duration_a_day = html_escape($this->input->post('crnt_phisical_acitivity_value_'.$row));
				
				if($physical_act_type && $physical_act_duration_a_day)
				{
					$crnt_phisical_activity = array(
									'physical_act_patient_id'     => $patient_id,
									'physical_act_visit_id'       => $visit_id,
									'physical_act_type'           => $physical_act_type,
									'physical_act_duration_a_day' => $physical_act_duration_a_day,
								);
					$this->Visit_model->save_visitcrnt_phisical_actitivites($crnt_phisical_activity);
				}
			}
			endif;
			
			//Save Management
			if($this->input->post('life_style') || $this->input->post('mangemnt_medication'))
			{
				$this->Visit_model->delete_management_data($visit_id, $patient_id);
				$this->Visit_model->delete_exercise_data($visit_id, $patient_id);
				$management_data = array(
									'management_visit_id'       => $visit_id,
									'management_patient_id'     => $patient_id,
									'management_has_lifestyle'  => $this->input->post('life_style'),
									'management_has_medication' => $this->input->post('mangemnt_medication'),
									'management_calorie_perday' => html_escape($this->input->post('total_calorie_perday')),
								);
				$mngmnt_ins_id = $this->Visit_model->save_management_data($management_data);
				$management_id = $this->db->insert_id($mngmnt_ins_id);
				
				if($this->input->post('life_style'))
				{
					$total_exercise = $this->input->post('crnt_exercise_row');
					foreach($total_exercise as $row)
					{
						$exercise_method = html_escape($this->input->post('crnt_exercise_value_'.$row));
						if($exercise_method)
						{
							$exercise_data = array(
												'exercise_visit_id'      => $visit_id,
												'exercise_patient_id'    => $patient_id,
												'exercise_management_id' => $management_id,
												'exercise_method'        => $exercise_method,
											);
							$this->Visit_model->save_exercise_data($exercise_data);
						}
					}
				}
			}
			
				
			//Save Current Medication
				
				// current OADs
				$this->Visit_model->delete_visitcrnt_oads($visit_id, $patient_id);
				$crnt_oads_rows = $this->input->post('crnt_oads_row');
				if($this->input->post('crnt_is_oads') == '1' && !empty($crnt_oads_rows)):
				foreach($crnt_oads_rows as $row)
				{
					$crnt_oads_name = html_escape($this->input->post('crnt_oads_name_'.$row));
					$crnt_oads_dose = html_escape($this->input->post('crnt_oads_value_'.$row));
					
					if($crnt_oads_name && $crnt_oads_dose)
					{
						$crnt_oads_data = array(
										'oads_patient_id' => $patient_id,
										'oads_visit_id'   => $visit_id,
										'oads_name'       => $crnt_oads_name,
										'oads_dose'       => $crnt_oads_dose,
									);
						$this->Visit_model->save_visitcrnt_oads($crnt_oads_data);
					}
				}
				endif;
				
				// current insulin
				$this->Visit_model->delete_visitcrnt_insulin($visit_id, $patient_id);
				$crnt_insulin_rows = $this->input->post('crnt_insulin_row');
				if($this->input->post('crnt_is_insulin') == '1' && !empty($crnt_insulin_rows)):
				foreach($crnt_insulin_rows as $row)
				{
					$crnt_insulin_name = html_escape($this->input->post('crnt_insulin_name_'.$row));
					$crnt_insulin_dose = html_escape($this->input->post('crnt_insulin_value_'.$row));
					
					if($crnt_insulin_name && $crnt_insulin_dose)
					{
						$crnt_insulin_data = array(
										'insulin_patient_id' => $patient_id,
										'insulin_visit_id'   => $visit_id,
										'insulin_name'       => $crnt_insulin_name,
										'insulin_dose'       => $crnt_insulin_dose,
									);
						$this->Visit_model->save_visitcrnt_insulin($crnt_insulin_data);
					}
				}
				endif;
				
				// current anti htn
				$this->Visit_model->delete_visitcrnt_anti_htn($visit_id, $patient_id);
				$crnt_anti_htn_row_rows = $this->input->post('crnt_anti_htn_row');
				if($this->input->post('crnt_is_anti_htn') == '1' && !empty($crnt_anti_htn_row_rows)):
				foreach($crnt_anti_htn_row_rows as $row)
				{
					$anti_htn_name = html_escape($this->input->post('crnt_anti_htn_name_'.$row));
					$anti_htn_dose = html_escape($this->input->post('crnt_anti_htn_value_'.$row));
					
					if($anti_htn_name && $anti_htn_dose)
					{
						$crnt_anti_htn_dose_data = array(
										'anti_htn_patient_id' => $patient_id,
										'anti_htn_visit_id'   => $visit_id,
										'anti_htn_name'       => $anti_htn_name,
										'anti_htn_dose'       => $anti_htn_dose,
									);
						$this->Visit_model->save_visitcrnt_anti_htn($crnt_anti_htn_dose_data);
					}
				}
				endif;
				
				// current anti lipids
				$this->Visit_model->delete_visitcrnt_anti_lipids($visit_id, $patient_id);
				$crnt_lipids_rows = $this->input->post('crnt_lipids_row');
				if($this->input->post('crnt_is_anti_lipids') == '1' && !empty($crnt_lipids_rows)):
				foreach($crnt_lipids_rows as $row)
				{
					$anti_lipid_name = html_escape($this->input->post('crnt_lipids_name_'.$row));
					$anti_lipid_dose = html_escape($this->input->post('crnt_lipids_value_'.$row));
					
					if($anti_lipid_name && $anti_lipid_dose)
					{
						$crnt_anti_lipids_data = array(
										'anti_lipid_patient_id' => $patient_id,
										'anti_lipid_visit_id'   => $visit_id,
										'anti_lipid_name'       => $anti_lipid_name,
										'anti_lipid_dose'       => $anti_lipid_dose,
									);
						$this->Visit_model->save_visitcrnt_anti_lipids($crnt_anti_lipids_data);
					}
				}
				endif;
				
				// current antiplatelets
				$this->Visit_model->delete_visitcrnt_antiplatelets($visit_id, $patient_id);
				$crnt_aspirine_rows = $this->input->post('crnt_aspirine_row');
				if($this->input->post('crnt_is_aspirine') == '1' && !empty($crnt_aspirine_rows)):
				foreach($crnt_aspirine_rows as $row)
				{
					$antiplatelets_name = html_escape($this->input->post('crnt_aspirine_name_'.$row));
					$antiplatelets_dose = html_escape($this->input->post('crnt_aspirine_value_'.$row));
					
					if($antiplatelets_name && $antiplatelets_dose)
					{
						$crnt_antiplatelets_data = array(
										'antiplatelets_patient_id' => $patient_id,
										'antiplatelets_visit_id'   => $visit_id,
										'antiplatelets_name'       => $antiplatelets_name,
										'antiplatelets_dose'       => $antiplatelets_dose,
									);
						$this->Visit_model->save_visitcrnt_antiplatelets($crnt_antiplatelets_data);
					}
				}
				endif;
				
				// current cardiac medication
				$this->Visit_model->delete_visitcrnt_cardiac_medication($visit_id, $patient_id);
				$crnt_cardiac_medication_rows = $this->input->post('crnt_cardiac_medication_row');
				if($this->input->post('crnt_is_cardiac_medication') == '1' && !empty($crnt_cardiac_medication_rows)):
				foreach($crnt_cardiac_medication_rows as $row)
				{
					$crnt_cardiac_medication_name = html_escape($this->input->post('crnt_cardiac_medication_name_'.$row));
					$crnt_cardiac_medication_dose = html_escape($this->input->post('crnt_cardiac_medication_value_'.$row));
					
					if($crnt_cardiac_medication_name && $crnt_cardiac_medication_dose)
					{
						$crnt_cardiac_medication_data = array(
										'cardiac_medication_patient_id' => $patient_id,
										'cardiac_medication_visit_id'   => $visit_id,
										'cardiac_medication_name'       => $crnt_cardiac_medication_name,
										'cardiac_medication_dose'       => $crnt_cardiac_medication_dose,
									);
						$this->Visit_model->save_visitcrnt_cardiac_medication($crnt_cardiac_medication_data);
					}
				}
				endif;
				
				// current anti obesity
				$this->Visit_model->delete_visitcrnt_anti_obesity($visit_id, $patient_id);
				$crnt_obesity_rows = $this->input->post('crnt_obesity_row');
				if($this->input->post('crnt_is_anti_obesity') == '1' && !empty($crnt_obesity_rows)):
				foreach($crnt_obesity_rows as $row)
				{
					$anti_obesity_name = html_escape($this->input->post('crnt_obesity_name_'.$row));
					$anti_obesity_dose = html_escape($this->input->post('crnt_obesity_value_'.$row));
					
					if($anti_obesity_name && $anti_obesity_dose)
					{
						$crnt_anti_obesity_data = array(
										'anti_obesity_patient_id' => $patient_id,
										'anti_obesity_visit_id'   => $visit_id,
										'anti_obesity_name'       => $anti_obesity_name,
										'anti_obesity_dose'       => $anti_obesity_dose,
									);
						$this->Visit_model->save_visitcrnt_anti_obesity($crnt_anti_obesity_data);
					}
				}
				endif;
				
				// current other medication other
				$this->Visit_model->delete_visitcrnt_omedication_other($visit_id, $patient_id);
				$crnt_other_rows = $this->input->post('crnt_other_row');
				if($this->input->post('crnt_is_others') == '1' && !empty($crnt_other_rows)):
				foreach($crnt_other_rows as $row)
				{
					$other_name = html_escape($this->input->post('crnt_other_name_'.$row));
					$other_dose = html_escape($this->input->post('crnt_other_value_'.$row));
					
					if($other_name && $other_dose)
					{
						$crnt_omedication_other = array(
										'other_patient_id' => $patient_id,
										'other_visit_id'   => $visit_id,
										'other_name'       => $other_name,
										'other_dose'       => $other_dose,
									);
						$this->Visit_model->save_visitcrnt_omedication_other($crnt_omedication_other);
					}
				}
				endif;
				
				//Save Diagonosis
				if($this->input->post('diabetes_type'))
				{
					$this->Visit_model->delete_diagonosis_data($visit_id, $patient_id);
					if($this->input->post('diabetes_type') == '1')
					{
						$diagonosis_diabetes_types = json_encode($this->input->post('diabetes_keywords'));
					}else
					{
						$diagonosis_diabetes_types = null;
					}
					$diagonosis_data = array(
										'diagonosis_visit_id'       => $visit_id,
										'diagonosis_patient_id'     => $patient_id,
										'diagonosis_has_diabetes'   => $this->input->post('diabetes_type'),
										'diagonosis_diabetes_types' => $diagonosis_diabetes_types,
									   );
					$this->Visit_model->save_diagonosis_data($diagonosis_data);
				}
				
				//Save Payments
				$this->Visit_model->delete_payment_data($visit_id, $patient_id);
				$payment_satatus = $this->input->post('payment');
				$payment_data = array(
									'payment_visit_id'           => $visit_id,
									'payment_patient_id'         => $patient_id,
									'payment_patient_fee_amount' => $this->input->post('fee_amount'),
									'payment_patient_status'     => $payment_satatus,
								);
				$this->Visit_model->save_payment_data($payment_data);
			
			
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
