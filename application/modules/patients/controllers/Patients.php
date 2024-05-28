<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  
	  $active_user = $this->session->userdata('active_user');
	  $userLogin = $this->session->userdata('userLogin');
	  if($active_user === NULL && $userLogin !== TRUE)
	  {
		redirect('login', 'refresh', true);
	  }
	  $this->perPage = 15;
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Organization_model');
	  $this->load->model('Patient_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=1&TO=5000
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=5001&TO=10000
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=10001&TO=15000
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=15001&TO=20000
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=20001&TO=25000
	//https://app.bndr-org.com.bd/patients/set_visit_json_data?FROM=25001&TO=30000
	public function set_visit_json_data()
	{
		$from = $_GET['FROM'];
		$to = $_GET['TO'];
		$query = $this->db->query("SELECT * FROM starter_patient_visit WHERE visit_id BETWEEN $from AND $to");
		$results = $query->result_array();
		foreach($results as $result)
		{
			$json_visit_details         = json_encode($result);
			$json_patient_details       = $this->get_json_data_result_by_id('patient_id', $result['visit_patient_id'], 'starter_patients');
			$json_acute_complication    = $this->get_json_data_result_by_id('vcomplication_visit_id', $result['visit_id'], 'starter_visit_acute_complication');
			$json_complication          = $this->get_json_data_result_by_id('vcomplication_visit_id', $result['visit_id'], 'starter_visit_complication');
			$json_diabetes_histories    = $this->get_json_data_result_by_id('dhistory_visit_id', $result['visit_id'], 'starter_visit_diabetes_histories');
			$json_diagonosis            = $this->get_json_data_result_by_id('diagonosis_visit_id', $result['visit_id'], 'starter_visit_diagonosis');
			$json_dietary_history       = $this->get_json_data_result_by_id('diehist_visit_id', $result['visit_id'], 'starter_visit_dietary_history');
			$json_drug_histories        = $this->get_json_data_result_by_id('drughistory_visit_id', $result['visit_id'], 'starter_visit_drug_histories');
			
			$json_exercise                           = $this->get_json_data_result_by_id('exercise_visit_id', $result['visit_id'], 'starter_visit_exercise');
			$json_eye_examinations                   = $this->get_json_data_result_by_id('eyeexam_visit_id', $result['visit_id'], 'starter_visit_eye_examinations');
			$json_family_history                     = $this->get_json_data_result_by_id('fmhistory_visit_id', $result['visit_id'], 'starter_visit_family_history');
			$json_final_treatment_infos              = $this->get_json_data_result_by_id('finaltreat_visit_id', $result['visit_id'], 'starter_visit_final_treatment_infos');
			$json_foot_examinations                  = $this->get_json_data_result_by_id('footexm_visit_id', $result['visit_id'], 'starter_visit_foot_examinations');
			$json_foot_examinations_periferals       = $this->get_json_data_result_by_id('footexmprfl_visit_id', $result['visit_id'], 'starter_visit_foot_examinations_periferals');
			$json_foot_examinations_sensation        = $this->get_json_data_result_by_id('footexmsns_visit_id', $result['visit_id'], 'starter_visit_foot_examinations_sensation');
			$json_general_examinations               = $this->get_json_data_result_by_id('generalexam_visit_id', $result['visit_id'], 'starter_visit_general_examinations');
			$json_general_examinations_others        = $this->get_json_data_result_by_id('gexamother_visit_id', $result['visit_id'], 'starter_visit_general_examinations_others');
			$json_laboratory_ecg                     = $this->get_json_data_result_by_id('ecg_visit_id', $result['visit_id'], 'starter_visit_laboratory_ecg');
			$json_laboratory_investigations          = $this->get_json_data_result_by_id('labinvs_visit_id', $result['visit_id'], 'starter_visit_laboratory_investigations');
			$json_laboratory_usg                     = $this->get_json_data_result_by_id('usg_visit_id', $result['visit_id'], 'starter_visit_laboratory_usg');
			$json_management                         = $this->get_json_data_result_by_id('management_visit_id', $result['visit_id'], 'starter_visit_management');
			$json_menstrual_cycle                    = $this->get_json_data_result_by_id('menstrlc_visit_id', $result['visit_id'], 'starter_visit_menstrual_cycle');
			$json_obstetric_history                  = $this->get_json_data_result_by_id('obstetric_visit_id', $result['visit_id'], 'starter_visit_obstetric_history');
			$json_payments                           = $this->get_json_data_result_by_id('payment_visit_id', $result['visit_id'], 'starter_visit_payments');
			$json_personal_habits                    = $this->get_json_data_result_by_id('phabit_visit_id', $result['visit_id'], 'starter_visit_personal_habits');
			$json_physical_activities                = $this->get_json_data_result_by_id('physical_act_visit_id', $result['visit_id'], 'starter_visit_physical_activities');
			
			$json_crntadv_cooking_oil                = $this->get_json_data_result_by_id('cooking_oil_visit_id', $result['visit_id'], 'starter_crntadv_cooking_oil');
			$json_crntadv_dietary_history            = $this->get_json_data_result_by_id('diehist_visit_id', $result['visit_id'], 'starter_crntadv_dietary_history');
			$json_crntadv_physical_activity          = $this->get_json_data_result_by_id('physical_act_visit_id', $result['visit_id'], 'starter_crntadv_physical_activity');
			$json_crntomedication_anti_htn           = $this->get_json_data_result_by_id('anti_htn_visit_id', $result['visit_id'], 'starter_crntomedication_anti_htn');
			$json_crntomedication_anti_lipids        = $this->get_json_data_result_by_id('anti_lipid_visit_id', $result['visit_id'], 'starter_crntomedication_anti_lipids');
			$json_crntomedication_anti_obesity       = $this->get_json_data_result_by_id('anti_obesity_visit_id', $result['visit_id'], 'starter_crntomedication_anti_obesity');
			$json_crntomedication_antiplatelets      = $this->get_json_data_result_by_id('antiplatelets_visit_id', $result['visit_id'], 'starter_crntomedication_antiplatelets');
			$json_crntomedication_cardiac_medication = $this->get_json_data_result_by_id('cardiac_medication_visit_id', $result['visit_id'], 'starter_crntomedication_cardiac_medication');
			$json_crntomedication_insulin            = $this->get_json_data_result_by_id('insulin_visit_id', $result['visit_id'], 'starter_crntomedication_insulin');
			$json_crntomedication_oads               = $this->get_json_data_result_by_id('oads_visit_id', $result['visit_id'], 'starter_crntomedication_oads');
			$json_crntomedication_others             = $this->get_json_data_result_by_id('other_visit_id', $result['visit_id'], 'starter_crntomedication_others');
			
			$json_prvadv_cooking_oil                 = $this->get_json_data_result_by_id('cooking_oil_visit_id', $result['visit_id'], 'starter_prvadv_cooking_oil');
			$json_prvadv_dietary_history             = $this->get_json_data_result_by_id('diehist_visit_id', $result['visit_id'], 'starter_prvadv_dietary_history');
			$json_prvadv_physical_activity           = $this->get_json_data_result_by_id('physical_act_visit_id', $result['visit_id'], 'starter_prvadv_physical_activity');
			$json_prvomedication_anti_htn            = $this->get_json_data_result_by_id('anti_htn_visit_id', $result['visit_id'], 'starter_prvomedication_anti_htn');
			$json_prvomedication_anti_lipids         = $this->get_json_data_result_by_id('anti_lipid_visit_id', $result['visit_id'], 'starter_prvomedication_anti_lipids');
			$json_prvomedication_anti_obesity        = $this->get_json_data_result_by_id('anti_obesity_visit_id', $result['visit_id'], 'starter_prvomedication_anti_obesity');
			$json_prvomedication_antiplatelets       = $this->get_json_data_result_by_id('antiplatelets_visit_id', $result['visit_id'], 'starter_prvomedication_antiplatelets');
			$json_prvomedication_cardiac_medication  = $this->get_json_data_result_by_id('cardiac_medication_visit_id', $result['visit_id'], 'starter_prvomedication_cardiac_medication');
			$json_prvomedication_insulin             = $this->get_json_data_result_by_id('insulin_visit_id', $result['visit_id'], 'starter_prvomedication_insulin');
			$json_prvomedication_oads                = $this->get_json_data_result_by_id('oads_visit_id', $result['visit_id'], 'starter_prvomedication_oads');
			$json_prvomedication_other               = $this->get_json_data_result_by_id('other_visit_id', $result['visit_id'], 'starter_prvomedication_other');
			
			$data = array(
						'json_visit_details'                      => $json_visit_details,
						'json_patient_details'                    => $json_patient_details,
						'json_acute_complication'                 => $json_acute_complication,
						'json_complication'                       => $json_complication,
						'json_diabetes_histories'                 => $json_diabetes_histories,
						'json_diagonosis'                         => $json_diagonosis,
						'json_dietary_history'                    => $json_dietary_history,
						'json_drug_histories'                     => $json_drug_histories,
						'json_exercise'                           => $json_exercise,
						'json_eye_examinations'                   => $json_eye_examinations,
						'json_family_history'                     => $json_family_history,
						'json_final_treatment_infos'              => $json_final_treatment_infos,
						'json_foot_examinations'                  => $json_foot_examinations,
						'json_foot_examinations_periferals'       => $json_foot_examinations_periferals,
						'json_foot_examinations_sensation'        => $json_foot_examinations_sensation,
						'json_general_examinations'               => $json_general_examinations,
						'json_general_examinations_others'        => $json_general_examinations_others,
						'json_laboratory_ecg'                     => $json_laboratory_ecg,
						'json_laboratory_investigations'          => $json_laboratory_investigations,
						'json_laboratory_usg'                     => $json_laboratory_usg,
						'json_management'                         => $json_management,
						'json_menstrual_cycle'                    => $json_menstrual_cycle,
						'json_obstetric_history'                  => $json_obstetric_history,
						'json_payments'                           => $json_payments,
						'json_personal_habits'                    => $json_personal_habits,
						'json_physical_activities'                => $json_physical_activities,
						'json_crntadv_cooking_oil'                => $json_crntadv_cooking_oil,
						'json_crntadv_dietary_history'            => $json_crntadv_dietary_history,
						'json_crntadv_physical_activity'          => $json_crntadv_physical_activity,
						'json_crntomedication_anti_htn'           => $json_crntomedication_anti_htn,
						'json_crntomedication_anti_lipids'        => $json_crntomedication_anti_lipids,
						'json_crntomedication_anti_obesity'       => $json_crntomedication_anti_obesity,
						'json_crntomedication_antiplatelets'      => $json_crntomedication_antiplatelets,
						'json_crntomedication_cardiac_medication' => $json_crntomedication_cardiac_medication,
						'json_crntomedication_insulin'            => $json_crntomedication_insulin,
						'json_crntomedication_oads'               => $json_crntomedication_oads,
						'json_crntomedication_others'             => $json_crntomedication_others,
						'json_prvadv_cooking_oil'                 => $json_prvadv_cooking_oil,
						'json_prvadv_dietary_history'             => $json_prvadv_dietary_history,
						'json_prvadv_physical_activity'           => $json_prvadv_physical_activity,
						'json_prvomedication_anti_htn'            => $json_prvomedication_anti_htn,
						'json_prvomedication_anti_lipids'         => $json_prvomedication_anti_lipids,
						'json_prvomedication_anti_obesity'        => $json_prvomedication_anti_obesity,
						'json_prvomedication_antiplatelets'       => $json_prvomedication_antiplatelets,
						'json_prvomedication_cardiac_medication'  => $json_prvomedication_cardiac_medication,
						'json_prvomedication_insulin'             => $json_prvomedication_insulin,
						'json_prvomedication_oads'                => $json_prvomedication_oads,
						'json_prvomedication_other'               => $json_prvomedication_other
					);
			$this->create_visit_json_data($data);
		}
		
		echo "json has been inserted";
	}
	private function get_json_data_result_by_id($field, $id, $table)
	{
		$query = $this->db->query("SELECT * FROM $table WHERE $field=$id LIMIT 1");
		return json_encode($query->result_array());
	}
	private function create_visit_json_data($data)
	{
		$this->db->insert('starter_visit_json_data', $data);
	}
	
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_emgcontacts&PATIENT_ID_FIELD=emgcontact_patient_id&UPDATE_COLUNM=patient_emgcontacts&PRIMARY_KEY=emgcontact_id&FROM=1&TO=5000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_emgcontacts&PATIENT_ID_FIELD=emgcontact_patient_id&UPDATE_COLUNM=patient_emgcontacts&PRIMARY_KEY=emgcontact_id&FROM=5001&TO=10000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_emgcontacts&PATIENT_ID_FIELD=emgcontact_patient_id&UPDATE_COLUNM=patient_emgcontacts&PRIMARY_KEY=emgcontact_id&FROM=10001&TO=15000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_emgcontacts&PATIENT_ID_FIELD=emgcontact_patient_id&UPDATE_COLUNM=patient_emgcontacts&PRIMARY_KEY=emgcontact_id&FROM=15001&TO=20000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_emgcontacts&PATIENT_ID_FIELD=emgcontact_patient_id&UPDATE_COLUNM=patient_emgcontacts&PRIMARY_KEY=emgcontact_id&FROM=20001&TO=25000
	
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_familyinfo&PATIENT_ID_FIELD=familyinfo_patient_id&UPDATE_COLUNM=patient_familyinfo&PRIMARY_KEY=familyinfo_id&FROM=1&TO=5000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_familyinfo&PATIENT_ID_FIELD=familyinfo_patient_id&UPDATE_COLUNM=patient_familyinfo&PRIMARY_KEY=familyinfo_id&FROM=5001&TO=10000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_familyinfo&PATIENT_ID_FIELD=familyinfo_patient_id&UPDATE_COLUNM=patient_familyinfo&PRIMARY_KEY=familyinfo_id&FROM=10001&TO=15000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_familyinfo&PATIENT_ID_FIELD=familyinfo_patient_id&UPDATE_COLUNM=patient_familyinfo&PRIMARY_KEY=familyinfo_id&FROM=15001&TO=20000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_familyinfo&PATIENT_ID_FIELD=familyinfo_patient_id&UPDATE_COLUNM=patient_familyinfo&PRIMARY_KEY=familyinfo_id&FROM=20001&TO=25000
	
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_profinfo&PATIENT_ID_FIELD=profinfo_patient_id&UPDATE_COLUNM=patient_profinfo&PRIMARY_KEY=profinfo_id&FROM=1&TO=5000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_profinfo&PATIENT_ID_FIELD=profinfo_patient_id&UPDATE_COLUNM=patient_profinfo&PRIMARY_KEY=profinfo_id&FROM=5001&TO=10000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_profinfo&PATIENT_ID_FIELD=profinfo_patient_id&UPDATE_COLUNM=patient_profinfo&PRIMARY_KEY=profinfo_id&FROM=10001&TO=15000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_profinfo&PATIENT_ID_FIELD=profinfo_patient_id&UPDATE_COLUNM=patient_profinfo&PRIMARY_KEY=profinfo_id&FROM=15001&TO=20000
	//https://app.bndr-org.com.bd/patients/update_patient_others_info_json?TABLE=starter_patient_profinfo&PATIENT_ID_FIELD=profinfo_patient_id&UPDATE_COLUNM=patient_profinfo&PRIMARY_KEY=profinfo_id&FROM=20001&TO=25000
	public function update_patient_others_info_json()
	{
		$primary_key = $_GET['PRIMARY_KEY'];
		$from = $_GET['FROM'];
		$to = $_GET['TO'];
		$table = $_GET['TABLE'];
		$patient_id_field = $_GET['PATIENT_ID_FIELD'];
		$update_colunm = $_GET['UPDATE_COLUNM'];
		$query = $this->db->query("SELECT * FROM $table WHERE $primary_key BETWEEN $from AND $to");
		$results = $query->result_array();
		foreach($results as $result)
		{
			$patient_id = $result[$patient_id_field];
			$data = json_encode($result);
			$this->update_p_table($patient_id, array($update_colunm => $data));
		}
		
		echo "Patients json data has been updated.";
	}
	private function update_p_table($patient_id, $data)
	{
		$this->db->where('patient_id', $patient_id);
		$this->db->update('starter_patients', $data);
	}
	
	public function index()
	{
		if(isset($_GET['src']) && $_GET['src'] !== null)
		{
			//total rows count
			$src = html_escape($_GET['src']);
			$data['src_input'] = $_GET['src'];
			$totalRec = $this->Patient_model->count_srcall_items(array('src' => $src));
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'pfilter/get_all_patients';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Patient_model->get_srcall_items(array('src' => $src, 'limit'=>$this->perPage));
			$data['total_items'] = $totalRec;
			$this->load->view('patients', $data);
		}else
		{
			//total rows count
			$totalRec = $this->Patient_model->count_all_items();
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'pfilter/get_all_patients';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Patient_model->get_all_items(array('limit'=>$this->perPage));
			$data['total_items'] = $totalRec;
			$this->load->view('patients', $data);
		}
	}
	
	public function imported()
	{
		//total rows count
		$totalRec = $this->Patient_model->count_all_imported_items();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_imported_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Patient_model->get_all_imported_items(array('limit'=>$this->perPage));
		$data['total_items'] = $totalRec;
		$this->load->view('imported_patients', $data);
	}
	
	public function create()
	{
		$this->load->view('create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		
		$today = date("Y-m-d");
		$total_items = $this->Patient_model->get_centerwise_count($this->input->post('center'));
		
		$get_org_code = $this->Patient_model->get_center_code($this->input->post('center'));
		
		$counter_digit = str_pad($total_items, 7, '0', STR_PAD_LEFT);
		
		$entry_ID = $get_org_code.date('dmy').'BNDR'.$counter_digit;
		
		$phn = html_escape($this->input->post('phone'));
		if(substr($phn, 0, 2) !== '88')
		{
			$phone_number = '88'.$phn;
		}else
		{
			$phone_number = $phn;
		}
		$email = html_escape($this->input->post('email'));
		
		if($this->session->userdata('user_type') === 'Doctor'){
			$dob = html_escape($this->input->post('dateof_birth'));
			if (substr_count( $dob,"/") === 2){
					list($day, $month,$year) = explode('/', $dob);
					$mdob= $year.'-'.$month.'-'.$day;
				}else {
					$mdob= null;
				}
			$data = array(
					'patient_entryid'       => $entry_ID,
					'patient_form_version'  => 'v2',
					'patient_idby_center'   => html_escape($this->input->post('patient_center_id')),
					'patient_gender'        => html_escape($this->input->post('gender')),
					'patient_blood_group'   => html_escape($this->input->post('blood_group')),
					'patient_email'         => $email,
					'patient_phone'         => $phone_number,
					'patient_org_id'        => html_escape($this->input->post('organization')),
					'patient_org_centerid'  => html_escape($this->input->post('center')),
					'patient_name'          => html_escape($this->input->post('full_name')),
					'patient_address'       => html_escape($this->input->post('address')),
					'patient_nid'           => html_escape($this->input->post('nid')),
					'patient_guide_book'    => html_escape($this->input->post('guide_book')),
					'patient_division_id'   => html_escape($this->input->post('division')),
					'patient_district_id'   => html_escape($this->input->post('district')),
					'patient_upazila_id'    => html_escape($this->input->post('upazila')),
					'patient_postal_code'   => html_escape($this->input->post('postal_code')),
					'patient_dateof_birth'  => $mdob,
					'patient_registration_date' => db_formated_date(html_escape($this->input->post('registration_date'))),
					'patient_age'           => html_escape($this->input->post('age')),
					'patient_admitted_by'   => $this->session->userdata('active_user'),
					'patient_admitted_user_type' => $this->session->userdata('user_type'),
					'patient_regfee_amount' => html_escape($this->input->post('fee_amount')),
					'patient_payment_status'=> html_escape($this->input->post('payment')),
					'patient_create_date'   => date("Y-m-d H:i:s"),
					'patient_is_registered'   => 'YES',
				);
		}else{
		$data = array(
					'patient_entryid'       => $entry_ID,
					'patient_form_version'  => 'v2',
					'patient_idby_center'   => html_escape($this->input->post('patient_center_id')),
					'patient_gender'        => html_escape($this->input->post('gender')),
					'patient_blood_group'   => html_escape($this->input->post('blood_group')),
					'patient_email'         => $email,
					'patient_phone'         => $phone_number,
					'patient_org_id'        => html_escape($this->input->post('organization')),
					'patient_org_centerid'  => html_escape($this->input->post('center')),
					'patient_name'          => html_escape($this->input->post('full_name')),
					'patient_address'       => html_escape($this->input->post('address')),
					'patient_nid'           => html_escape($this->input->post('nid')),
					'patient_guide_book'    => html_escape($this->input->post('guide_book')),
					'patient_division_id'   => html_escape($this->input->post('division')),
					'patient_district_id'   => html_escape($this->input->post('district')),
					'patient_upazila_id'    => html_escape($this->input->post('upazila')),
					'patient_postal_code'   => html_escape($this->input->post('postal_code')),
					'patient_dateof_birth'  => html_escape($this->input->post('dateof_birth')),
					'patient_registration_date' => db_formated_date(html_escape($this->input->post('registration_date'))),
					'patient_age'           => html_escape($this->input->post('age')),
					'patient_admitted_by'   => $this->session->userdata('active_user'),
					'patient_admitted_user_type' => $this->session->userdata('user_type'),
					'patient_regfee_amount' => html_escape($this->input->post('fee_amount')),
					'patient_payment_status'=> html_escape($this->input->post('payment')),
					'patient_create_date'   => date("Y-m-d H:i:s"),
					'patient_is_registered'   => 'YES',
				);
		}
		$validate = array(
						array(
							'field' => 'gender', 
							'label' => 'Gender', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules('nid', 'NID', 'trim|is_unique[starter_patients.patient_nid]', array('is_unique' => 'The NID number is already exist!'));
		$this->form_validation->set_rules('guide_book', 'Guide book number', 'trim|is_unique[starter_patients.patient_guide_book]', array('is_unique' => 'The Guide book number is already exist!'));
		//Phone & email valiation
		$check_email = $this->Patient_model->check_email($email);
		$check_phone = $this->Patient_model->check_phone($phone_number);
		if($email !== '' && $check_email == true)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($check_phone == true)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The mobile number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save patient information
			$ins_id = $this->Patient_model->create($data);
			$patient_id = $this->db->insert_id($ins_id);
			
$message ='Thank you for registration
Your BNDR ID: '.$entry_ID.'
Please save this ID for further service.
';
		sendsms($phone_number, $message);			
			
			//save patient professional info
			$professional_data = array(
								'profinfo_patient_id'    => $patient_id,
								'profinfo_mothly_income' => html_escape($this->input->post('income')),
								'profinfo_education'     => html_escape($this->input->post('education')),
								'profinfo_profession'    => html_escape($this->input->post('profession')),
							);
			$this->Patient_model->save_professional_info($professional_data);
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
			//require_once APPPATH.'modules/barcode/vendor/autoload.php';
			//$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
			//$barcode = '<div class="col-lg-12" style = "margin: auto;justify-content: center;display: flex;">
			//<h4 style = "margin-right: 2%">'.
			
			 //$generator->getBarcode($entry_ID, $generator::TYPE_CODE_128).' </h4>
			
			//<button type="button" class="btn btn-success">Print Barcode</button>
			//</div>';
			$inputEntry = '<input type="hidden" id = "entry" value="'.$entry_ID.'" name="" />';
			$success = '<div class="alert alert-success text-center">Patient has been successfully registered!</div>';
			$addvisit = '<a class="add-vst-button pull-right" href="'.base_url('patients/visit/add/'.$patient_id.'/'.$entry_ID).'"><i class="fa fa-plus-square"></i> ADD NEW VISIT</a>';
			$result = array('status' => 'ok', 'success' => $success, 'exit' => $exit, 'addvisit' => $addvisit,'patient_id' => $patient_id,'entry_ID' => $entry_ID,'inputEntry' => $inputEntry);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function edit($id)
	{
		$data['id'] = intval($id);
		$this->load->view('edit', $data);
	}
	
	public function moneyreceipt($id, $two)
	{
		$patient_id = intval($id);
		$data['receipt'] = $this->Patient_model->get_receipt_information($patient_id);
		$this->load->view('moneyreceipt', $data);
	}
	
	public function update()
	{
		//Check patient center before update
		$patient_org_centerid = html_escape($this->input->post('center'));
		$operator_centerid = $this->session->userdata('user_org_center_id');
		if($patient_org_centerid !== $operator_centerid)
		{
			$error = '<div class="alert alert-danger">Sorry! you are not eligible to update this patient.</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$email = html_escape($this->input->post('email'));
		$phn = html_escape($this->input->post('phone'));
		if(substr($phn, 0, 2) !== '88')
		{
			$phone_number = '88'.$phn;
		}else
		{
			$phone_number = $phn;
		}
		$data = array(
					'patient_idby_center'   => html_escape($this->input->post('patient_idby_center')),
					'patient_gender'        => html_escape($this->input->post('gender')),
					'patient_blood_group'   => html_escape($this->input->post('blood_group')),
					'patient_email'         => $email,
					'patient_phone'         => $phone_number,
					'patient_org_id'        => html_escape($this->input->post('organization')),
					'patient_org_centerid'  => html_escape($this->input->post('center')),
					'patient_name'          => html_escape($this->input->post('full_name')),
					'patient_address'       => html_escape($this->input->post('address')),
					'patient_nid'           => html_escape($this->input->post('nid')),
					'patient_guide_book'    => html_escape($this->input->post('guide_book')),
					'patient_division_id'   => html_escape($this->input->post('division')),
					'patient_district_id'   => html_escape($this->input->post('district')),
					'patient_upazila_id'    => html_escape($this->input->post('upazila')),
					'patient_postal_code'   => html_escape($this->input->post('postal_code')),
					'patient_dateof_birth'  => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'patient_registration_date' => db_formated_date(html_escape($this->input->post('registration_date'))),
					'patient_age'           => html_escape($this->input->post('age')),
					'patient_regfee_amount' => html_escape($this->input->post('fee_amount')),
					'patient_payment_status'=> html_escape($this->input->post('payment')),
				);
		if($this->input->post('payment') == '1')
		{
			$data['patient_is_registered'] = 'YES';
		}
		$validate = array(
						array(
							'field' => 'gender', 
							'label' => 'Gender', 
							'rules' => 'required|trim', 
						),
					);
		//Nid & email Guide book
		$check_nid = $this->Patient_model->check_nid(html_escape($this->input->post('nid')));
		$check_guidebook = $this->Patient_model->check_guidebook(html_escape($this->input->post('guide_book')));
		if($check_nid == true && $check_nid['patient_nid'] !== '' && $check_nid['patient_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The NID number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($check_guidebook == true && $check_guidebook['patient_guide_book'] !== '' && $check_guidebook['patient_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The Guide book number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		//Phone & email valiation
		$check_email = $this->Patient_model->check_email($email);
		$check_phone = $this->Patient_model->check_phone($phone_number);
		if($email !== '' && $check_email == true && $check_email['patient_email'] !== '' && $check_email['patient_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($phn !== '' && $check_phone == true && $check_phone['patient_phone'] !== '' && $check_phone['patient_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The mobile number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//update
			$this->Patient_model->update($id, $data);
			
			//save patient professional info
			$professional_data = array(
								'profinfo_mothly_income' => html_escape($this->input->post('income')),
								'profinfo_education'     => html_escape($this->input->post('education')),
								'profinfo_profession'    => html_escape($this->input->post('profession')),
							);
			$this->Patient_model->update_professional_info($id, $professional_data);
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
			$success = '<div class="alert alert-success text-center">Patient has been successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'exit' => $exit);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function delete()
	{
		$id = $this->input->post('id');
		$patient_id = $id;
		
		$this->db->where('vcomplication_patient_id', $patient_id);
		$this->db->delete('starter_visit_complication');
		
		$this->db->where('diagonosis_patient_id', $patient_id);
		$this->db->delete('starter_visit_diagonosis');
		
		$this->db->where('exercise_patient_id', $patient_id);
		$this->db->delete('starter_visit_exercise');
		
		$this->db->where('fmhistory_patient_id', $patient_id);
		$this->db->delete('starter_visit_family_history');
		
		$this->db->where('generalexam_patient_id', $patient_id);
		$this->db->delete('starter_visit_general_examinations');
		
		$this->db->where('ecg_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_ecg');
		
		$this->db->where('labinvs_patient_id', $patient_id);
		$this->db->delete('starter_visit_laboratory_investigations');
		
		$this->db->where('management_patient_id', $patient_id);
		$this->db->delete('starter_visit_management');
		
		$this->db->where('menstrlc_patient_id', $patient_id);
		$this->db->delete('starter_visit_menstrual_cycle');
		
		$this->db->where('payment_patient_id', $patient_id);
		$this->db->delete('starter_visit_payments');
		
		$this->db->where('phabit_patient_id', $patient_id);
		$this->db->delete('starter_visit_personal_habits');
		
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_cooking_oil');
		
		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_dietary_history');
		
		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_prvadv_physical_activity');
		
		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_antiplatelets');
		
		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_htn');
		
		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_lipids');
		
		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_anti_obesity');
		
		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_cardiac_medication');
		
		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_insulin');
		
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_oads');
		
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_prvomedication_other');
		
		$this->db->where('cooking_oil_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_cooking_oil');

		$this->db->where('diehist_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_dietary_history');

		$this->db->where('physical_act_patient_id', $patient_id);
		$this->db->delete('starter_crntadv_physical_activity');

		$this->db->where('antiplatelets_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_antiplatelets');

		$this->db->where('anti_htn_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_htn');

		$this->db->where('anti_lipid_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_lipids');

		$this->db->where('anti_obesity_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_anti_obesity');

		$this->db->where('cardiac_medication_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_cardiac_medication');

		$this->db->where('insulin_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_insulin');
		
		$this->db->where('oads_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_oads');
		
		$this->db->where('other_patient_id', $patient_id);
		$this->db->delete('starter_crntomedication_others');
		
		$this->db->where('visit_patient_id', $patient_id);
		$this->db->delete('starter_patient_visit');
		
		$this->db->where('emgcontact_patient_id', $id);
		$this->db->delete('starter_patient_emgcontacts');
		
		$this->db->where('familyinfo_patient_id', $id);
		$this->db->delete('starter_patient_familyinfo');
		
		$this->db->where('profinfo_patient_id', $id);
		$this->db->delete('starter_patient_profinfo');
		
		//Delete coordinator
		$this->db->where('patient_id', $id);
		$this->db->delete('starter_patients');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_age()
	{
		$get_date = $this->input->post('date_digit');
		$content = get_age(db_formated_date($get_date));
		$result = array("status" => "ok", 'content' => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_birth_date()
	{
		$get_age = $this->input->post('age');
		if($get_age)
		{
			$content = get_birth_date($get_age);
			$result = array("status" => "ok", 'content' => $content);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			exit;
		}
	}
	
	public function import()
	{
		$this->load->view('import');
	}
	
	public function importstart()
	{
		$this->load->library('PHPExcel');
		
		$this->load->library('upload');
	    $config['upload_path']          = 'excels/';
	    $config['allowed_types']        = 'xlsx|xls';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('import_file')){
		  $upload_error = $this->upload->display_errors();
		  $failed_content = '<p><strong style="color:#b00">'.$upload_error.'</strong></p>';
		  $result = array('status' => 'error', 'failed_content' => $failed_content);
		  echo json_encode($result);
		  exit;
	    }else{
			$fileData = $this->upload->data();
			$import_file_name = $fileData['file_name'];
		}
		
		if(isset($import_file_name))
		{
			$inputFileName = import_dir().$import_file_name;
		
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			
			//  Get worksheet dimensions
			$sheet = $objPHPExcel->getSheet(0); 
			$highestRow = $sheet->getHighestDataRow(); 
			$highestColumn = $sheet->getHighestColumn();

			//  Loop through each row of the worksheet in turn
			$rowData = array();
			for ($row = 1; $row <= $highestRow; $row++){ 
				//  Read a row of data into an array
				$rowData[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
												NULL,
												TRUE,
												FALSE);
				//  Insert row data array into your database of choice here
			}
			foreach($rowData as $key => $array)
			{
				if($rowData[$key][0] == '')
				{
					break;
				}
				foreach($array as $data)
				{
					$today = date("Y-m-d");
					$total_items   = $this->Patient_model->get_todaytotal_items($today);
					$get_org_code = $this->Patient_model->get_center_code($this->input->post('center'));
					$counter_digit = str_pad($total_items, 7, '0', STR_PAD_LEFT);
					$entry_ID      = $get_org_code.date('dmy').'BNDR'.$counter_digit;
					
					$patient_center_id  = trim(html_escape($data[0]));
					if($patient_center_id !== 'PID' && !empty($patient_center_id))
					{
						$name        = trim(html_escape($data[1]));
						$gender      = trim(html_escape($data[2]));
						if($gender == 'Male')
						{
							$patient_gender = 0;
						}elseif($gender == 'Female')
						{
							$patient_gender = 1;
						}else
						{
							$patient_gender = 2;
						}
						$phone       = trim(html_escape($data[3]));
						$blood_group = trim(html_escape($data[4]));
						$guide_book  = trim(html_escape($data[5]));
						$age         = trim(html_escape(intval($data[6])));
						$address     = trim(html_escape($data[8]));
						
						$imp_data = array(
									'patient_entryid'      => $entry_ID,
									'patient_idby_center'  => html_escape($patient_center_id),
									'patient_guide_book'   => $guide_book,
									'patient_org_id'       => html_escape($this->input->post('organization')),
									'patient_org_centerid' => html_escape($this->input->post('center')),
									'patient_name'         => $name,
									'patient_gender'       => $patient_gender,
									'patient_blood_group'  => $blood_group,
									'patient_phone'        => $phone,
									'patient_age'          => $age,
									'patient_address'      => $address,
									'patient_regfee_amount' => html_escape($this->input->post('fee_amount')),
									'patient_payment_status'=> html_escape($this->input->post('payment')),
									'patient_create_date'   => date("Y-m-d H:i:s"),
								);
						$this->Patient_model->import_patient($imp_data);
					}
				}
			}
			
			if(file_exists($inputFileName)){
				unlink($inputFileName);
			}else{
				echo null;
			}
			
			$success = '<p><strong style="color:#0b0">Data has been imported!</strong></p>';
			$result = array('status' => 'ok', 'success' => $success);
			echo json_encode($result);
			exit;
		}else
		{
			$failed_content = '<p><strong style="color:#b00">Failed to import! check your excel file.</strong></p>';
			$result = array('status' => 'error', 'error' => $failed_content);
			echo json_encode($result);
			exit;
		}
	}
	
	public function export($param=null)
	{
		if($param !== null)
		{
			if($param == 'excel'){
				$this->load->view('export/excel');
			}elseif($param == 'csv'){
				$this->load->view('export/csv');
			}else{
				redirect('patients');
			};;;;
		}else{
			redirect('patients');
		}
	}
	
	public function exportexcel()
	{
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));
		$is_registered = $this->input->post('is_registered');

		/*print_r($from_date,$to_date);exit;*/
		
		$dates = array();
		if($from_date && $to_date)
		{
			$dates['from_date'] = $from_date;
			$dates['to_date'] = $to_date;
		}
		$dates['is_registered'] = $is_registered;
		
		$date = date('d-m-Y');
        $file = 'Patients_'.$date.'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        $data['items'] = $this->Patient_model->get_excel_items($dates);  
		if($this->session->userdata('user_type') === 'Org Admin') {
			$this->load->view('export/excel_visit', $data);
		}else{
        $this->load->view('export/report_export_to_excel', $data);
		}
	}
	
	public function get_excel_items()
	{;
		$dates['from_date'] = '2018-09-01';
		$dates['to_date'] = '2018-10-01';
		$items = $this->Patient_model->get_excel_items($dates);
		print_r($items);
	}
	
	public function exportcsv(){
		
		$from_date = html_escape($this->input->post('from_date'));
		$to_date = html_escape($this->input->post('to_date'));
		$year = html_escape($this->input->post('year'));
		$month = html_escape($this->input->post('month'));
		$center = html_escape($this->input->post('center'));
		$operator = html_escape($this->input->post('operator'));
		$is_registered = $this->input->post('is_registered');
		
		
		$dates = array();
		if($from_date && $to_date)
		{
			$dates['from_date'] = $from_date;
			$dates['to_date'] = $to_date;
		}
		if($month)
		{
			$dates['month'] = $month;
		}
		if($year)
		{
			$dates['year'] = $year;
		}
		if($center)
		{
			$dates['center'] = $center;
		}
		if($operator)
		{
			$dates['operator'] = $operator;
		}
		$dates['is_registered'] = $is_registered;
		
		// file name
		if($this->session->userdata('user_type') === 'Org Admin') {
			$csv_type = $this->input->post('csv_type');
			
				if($from_date && $to_date && $center){
					$filename = 'Visit_'.$from_date.' to '.$to_date.' '.$center.'.csv';
				}elseif($from_date && $to_date && $operator){
					$filename = 'Visit_'.$from_date.' to '.$to_date.' '.$operator.'.csv';
				}elseif ($month || $year || $center|| $operator){
					if ($month && $year && $center){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$center.' '.$year.'-'.$month_name.'.csv';
					}elseif ($month && $year && $operator){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$operator.' '.$year.'-'.$month_name.'.csv';
					}elseif($month && $year){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$year.'-'.$month_name.'.csv';
					}elseif($year && $center){
						$filename = 'Visit_'.$center.' '.$year.'.csv';
						
					}elseif($year){
						$filename = 'Visit_'.$year.'.csv';
						
					}elseif($month && $center){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$center.' '.$month_name.'.csv';
					}elseif($month && $operator){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$operator.' '.$month_name.'.csv';
					}elseif($year && $operator){
						$filename = 'Visit_'.$center.' '.$operator.'.csv';
						
					}elseif($month){
						$mname = array('January' => '01', 'February' => '02', 'March' => '03', 'April' => '04', 'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08', 'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12');
						$month_name = array_search($month, $mname);
						$filename = 'Visit_'.$month_name.'.csv';
					}elseif($center){
						$filename = 'Visit_'.$center.'.csv';
					}elseif($operator){
						$filename = 'Visit_'.$operator.'.csv';
					}
					
				}elseif($from_date && $to_date){
					$filename = 'Visit_'.$from_date.' to '.$to_date.'.csv';
				}else {
					$filename = 'Visit_all'.'.csv';
				}
				
			
		}else{
		$filename = 'patients_'.date('Ymd').'.csv';
		}
		
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Type: application/csv; "); 

		// get data
		$items = $this->Patient_model->get_csv_items($dates);

		// file creation
		$file = fopen('php://output', 'w');
		if($this->session->userdata('user_type') === 'Org Admin') {
			if($csv_type === '3' || $csv_type === '2'){
				$header = array("ID", "Gender","Name", "Center", "Phone", "Date Of Birth", "Age" , "Register Date", "Visit Date" ,"Visit Input Date" , "Visit Type" , "Submitted By");
				$item_count = count($items);
				fputcsv($file, $header);

				foreach ($items as $key=>$line){
				 fputcsv($file,$line);
				}
			}else{
				$item_count = count($items);
			}
		}else {
			$header = array("patient_entryid", "patient_guide_book", "patient_idby_center", "patient_name", "patient_gender", "patient_phone", "patient_blood_group", "patient_address","patient_create_date");
			fputcsv($file, $header);

				foreach ($items as $key=>$line){
				 fputcsv($file,$line);
				}
		}
		
		 if($this->session->userdata('user_type') === 'Org Admin') {
			if($csv_type === '3' || $csv_type === '1'){
			 fputcsv($file, array(''));
			 fputcsv($file, array('Total Count', $item_count));
			 
			 if(empty($operator)){
				 $so = $this->Patient_model->get_sp();
				$operators = $this->Patient_model->get_operators();
				
				foreach($so as $super){
					$filter = array_filter($items,function ($var) use ($super) {
						return ($var['submitted_by'] == $super['operator_full_name']);
					});
					$filter_count = count($filter);
					fputcsv($file, array($super['operator_full_name'], $filter_count));
				}
				
				foreach($operators as $operator){
					$filter = array_filter($items,function ($var) use ($operator) {
						return ($var['submitted_by'] == $operator['operator_full_name']);
					});
					$filter_count = count($filter);
					fputcsv($file, array($operator['operator_full_name'], $filter_count));
				}
			 }
			}
		 }
		fclose($file);
		exit;
	}
	
} 
