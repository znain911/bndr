<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Register_model');
	}
	
	public function index()
	{
		$this->load->view('register');
	}
	
	public function account()
	{
		$param = $this->uri->segment(3);
		if(isset($param) && $param !== null && $param === 'type')
		{
			$type = $this->input->post('type');
			if($type === '1')
			{
				$this->load->view('operator_account');
			}elseif($type === '2'){
				$this->load->view('doctor_account');
			}elseif($type === '3'){
				$this->load->view('asistant_account');
			}
			
		}else
		{
			redirect('register');
		}
	}
	
	public function get_centers()
	{
		$org_id = $this->input->post('org_id');
		$centers = $this->Register_model->get_all_centers($org_id);
		$html = '<option value="" selected="selected">Select Center</option>';
		foreach($centers as $center):
		$html .= '<option value="'.$center['orgcenter_id'].'">'.$center['orgcenter_name'].'</option>';
		endforeach;
		
		$result = array('status' => 'ok', 'content' => $html);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_doctors()
	{
		$center_id = $this->input->post('center_id');
		$doctors = $this->Register_model->get_all_doctors($center_id);
		$html = '<option value="" selected="selected">Select Doctor</option>';
		foreach($doctors as $doctor):
		$html .= '<option value="'.$doctor['doctor_full_name'].'">'.$doctor['doctor_full_name'].'</option>';
		endforeach;
		
		$result = array('status' => 'ok', 'content' => $html);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_operators()
	{
		$center_id = $this->input->post('center_id');
		$operators = $this->Register_model->get_all_operators($center_id);
		$html = '<option value="" selected="selected">Select Operator</option>';
		foreach($operators as $operator):
		$html .= '<option value="'.$operator['operator_full_name'].'">'.$operator['operator_full_name'].'</option>';
		endforeach;
		
		$result = array('status' => 'ok', 'content' => $html);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function qr_code()
	{
		$bndrID = $this->input->post('id');
		
		$patient = $this->Register_model->get_patient($bndrID);
		
		date_default_timezone_set("Asia/Dhaka");
		$date = date("Y-m-d H:i:s");
		
		$qrNumber = $patient['qr_code'];
		$qrNumber++;
		
		$userId = $this->session->userdata('active_user');
		$userType = $this->session->userdata('user_type');
		
		$this->Register_model->qr_printed($bndrID,$qrNumber,$userId,$userType,$date);
		$result = array( "id" => $qrNumber);
            
        echo json_encode($result);
        exit;
	}
	
	
	public function get_districts()
	{
		$division_id = $this->input->post('division_id');
		$districts = $this->Register_model->get_all_districts($division_id);
		$html = '<option value="" selected="selected">Select District</option>';
		foreach($districts as $district):
		$html .= '<option value="'.$district['district_id'].'">'.$district['district_name'].'</option>';
		endforeach;
		
		$result = array('status' => 'ok', 'content' => $html);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_upazilas()
	{
		$district_id = $this->input->post('district_id');
		$upazilas = $this->Register_model->get_all_upazilas($district_id);
		$html = '<option value="" selected="selected">Select Upazila</option>';
		foreach($upazilas as $upazila):
		$html .= '<option value="'.$upazila['upazila_id'].'">'.$upazila['upazila_name'].'</option>';
		endforeach;
		
		$result = array('status' => 'ok', 'content' => $html);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	
	/*****Register Doctor****/
	
	public function create_doctor_account()
	{
		$this->load->library('form_validation');
		$date = date("Y-m-d");
		$total_doctor = $this->Register_model->get_total_doctortoday($date);
		$entryid = date("d-m-Y").$total_doctor;
		
		$phone_number = html_escape($this->input->post('phone'));
		
		$data = array(
					'doctor_entryid' => $entryid,
					'doctor_phone' => $phone_number,
					'doctor_org_id' => html_escape($this->input->post('organization')),
					'doctor_org_centerid' => html_escape($this->input->post('center')),
					'doctor_full_name' => html_escape($this->input->post('full_name')),
					'doctor_address' => html_escape($this->input->post('address')),
					'doctor_division_id' => html_escape($this->input->post('division')),
					'doctor_district_id' => html_escape($this->input->post('district')),
					'doctor_upazila_id' => html_escape($this->input->post('upazila')),
					'doctor_postal_code' => html_escape($this->input->post('postal_code')),
					'doctor_bmdc_no' => html_escape($this->input->post('bmdc_no')),
					'doctor_dateof_birth' => html_escape($this->input->post('dateof_birth')),
					'doctor_email' => html_escape($this->input->post('email')),
					'doctor_password' => sha1(html_escape($this->input->post('password'))),
					'doctor_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_doctors.doctor_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_doctors.doctor_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$this->Register_model->create_doctor_account($data);
			
			//create directory for the student
			$dirpath = attachment_dir()."doctors/".$entryid;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Account has been successfully created!</div>';
			$result = array("status" => "ok", "success" => $success_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function create_assistant_account()
	{
		$this->load->library('form_validation');
		$date = date("Y-m-d");
		$total_doctor = $this->Register_model->get_total_assistanttoday($date);
		$entryid = date("d-m-Y").$total_doctor;
		
		$phone_number = html_escape($this->input->post('phone'));
		
		$data = array(
					'assistant_entryid' => $entryid,
					'assistant_phone' => $phone_number,
					'assistant_org_id' => html_escape($this->input->post('organization')),
					'assistant_org_centerid' => html_escape($this->input->post('center')),
					'assistant_full_name' => html_escape($this->input->post('full_name')),
					'assistant_address' => html_escape($this->input->post('address')),
					'assistant_division_id' => html_escape($this->input->post('division')),
					'assistant_district_id' => html_escape($this->input->post('district')),
					'assistant_upazila_id' => html_escape($this->input->post('upazila')),
					'assistant_postal_code' => html_escape($this->input->post('postal_code')),
					'assistant_dateof_birth' => html_escape($this->input->post('dateof_birth')),
					'assistant_email' => html_escape($this->input->post('email')),
					'assistant_password' => sha1(html_escape($this->input->post('password'))),
					'assistant_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_doctor_assistants.assistant_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_doctor_assistants.assistant_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$this->Register_model->create_assistant_account($data);
			
			//create directory for the student
			$dirpath = attachment_dir()."assistants/".$entryid;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Account has been successfully created!</div>';
			$result = array("status" => "ok", "success" => $success_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function create_operator_account()
	{
		$this->load->library('form_validation');
		$date = date("Y-m-d");
		$total_doctor = $this->Register_model->get_total_operatortoday($date);
		$entryid = date("d-m-Y").$total_doctor;
		
		$phone_number = html_escape($this->input->post('phone'));
		
		$data = array(
					'operator_entryid' => $entryid,
					'operator_phone' => $phone_number,
					'operator_org_id' => html_escape($this->input->post('organization')),
					'operator_org_centerid' => html_escape($this->input->post('center')),
					'operator_full_name' => html_escape($this->input->post('full_name')),
					'operator_address' => html_escape($this->input->post('address')),
					'operator_division_id' => html_escape($this->input->post('division')),
					'operator_district_id' => html_escape($this->input->post('district')),
					'operator_upazila_id' => html_escape($this->input->post('upazila')),
					'operator_postal_code' => html_escape($this->input->post('postal_code')),
					'operator_dateof_birth' => html_escape($this->input->post('dateof_birth')),
					'operator_email' => html_escape($this->input->post('email')),
					'operator_password' => sha1(html_escape($this->input->post('password'))),
					'operator_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_operators.operator_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_operators.operator_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$this->Register_model->create_operator_account($data);
			
			//create directory for the student
			$dirpath = attachment_dir()."operators/".$entryid;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Account has been successfully created!</div>';
			$result = array("status" => "ok", "success" => $success_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error_alert = '<div class="alert alert-danger" role="alert">'.validation_errors().'</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	
	public function complie(){
		
		$pid = $this->input->post('pid');
		
		$get_ch = $this->Register_model->get_ch($pid);
		
		if($get_ch[0]['visit_form_version'] === 'V1' && $get_ch[1]['visit_form_version'] === 'V1'){
			$message = 'ready for compilation' ;
			
			$vid1 = $get_ch[0]['visit_id'];
			$vid2 = $get_ch[1]['visit_id'];
			$row_count = intval(count($get_ch));
			
			$visit_has_symptomatic = null;
			$visit_symptomatic_type = null;
			$visit_patient_type = null;
			$visit_diabetes_duration = null;
			$visit_types_of_diabetes = null;
			$visit_guidebook_no = null;
			
			if($get_ch[0]['visit_has_symptomatic'] !== null){
				$visit_has_symptomatic = $get_ch[0]['visit_has_symptomatic'];
			}elseif($get_ch[0]['visit_has_symptomatic'] === null && $get_ch[1]['visit_has_symptomatic'] !== null){
				$visit_has_symptomatic = $get_ch[1]['visit_has_symptomatic'];
			}
			
			if($get_ch[0]['visit_symptomatic_type'] !== null){
				$visit_symptomatic_type = $get_ch[0]['visit_symptomatic_type'];
			}elseif($get_ch[0]['visit_symptomatic_type'] === null && $get_ch[1]['visit_symptomatic_type'] !== null){
				$visit_symptomatic_type = $get_ch[1]['visit_symptomatic_type'];
			}
			
			if($get_ch[0]['visit_diabetes_duration'] !== null){
				$visit_diabetes_duration = $get_ch[0]['visit_diabetes_duration'];
			}elseif($get_ch[0]['visit_diabetes_duration'] === null && $get_ch[1]['visit_diabetes_duration'] !== null){
				$visit_diabetes_duration = $get_ch[1]['visit_diabetes_duration'];
			}
			
			if($get_ch[0]['visit_patient_type'] !== null){
				$visit_patient_type = $get_ch[0]['visit_patient_type'];
			}elseif($get_ch[0]['visit_patient_type'] === null && $get_ch[1]['visit_patient_type'] !== null){
				$visit_patient_type = $get_ch[1]['visit_patient_type'];
			}
			
			if($get_ch[1]['visit_types_of_diabetes'] === 'Type 2'){
				$visit_types_of_diabetes = $get_ch[1]['visit_types_of_diabetes'];
			}elseif($get_ch[0]['visit_types_of_diabetes'] !== null){
				$visit_types_of_diabetes = $get_ch[0]['visit_types_of_diabetes'];
			}elseif($get_ch[0]['visit_types_of_diabetes'] === null && $get_ch[1]['visit_types_of_diabetes'] !== null){
				$visit_types_of_diabetes = $get_ch[1]['visit_types_of_diabetes'];
			}
			
			if($get_ch[0]['visit_guidebook_no'] !== null  ){
				$visit_guidebook_no = $get_ch[0]['visit_guidebook_no'];
			}elseif( $get_ch[1]['visit_guidebook_no'] !== null){
				$visit_guidebook_no = $get_ch[1]['visit_guidebook_no'];
			}
			
			//update visit table 
			
			if($visit_has_symptomatic !== null || $visit_symptomatic_type !== null || $visit_patient_type !== null || $visit_diabetes_duration !== null || $visit_types_of_diabetes !== null || $visit_guidebook_no !== null){
				//$message = 'ready for visit';
				$update_visit = $this->Register_model->update_visit($vid1,$visit_has_symptomatic,$visit_symptomatic_type,$visit_patient_type,$visit_diabetes_duration,$visit_types_of_diabetes,$visit_guidebook_no);
			}
				//general exam update
				//if($update_visit === true || $update_visit === false ){
					
					if($row_count === 2){
						$update_multiplevisit = $this->Register_model->update_multiplevisit($pid,$vid2,$get_ch[1]);
					}else{
						$insert_visit = $this->Register_model->insert_visit($get_ch[1],$vid2);
					}
					
					
					//general examination start
					 $get_ges = $this->Register_model->get_general_examinations_old($vid1);
					 if($get_ges){
						 //$message = 'ready for visit';
						 foreach($get_ges as $get_ge){
							 $check_gm_exist = $this->Register_model->get_general_examinations_vid2($vid2, $get_ge['generalexam_name']);
							 if($check_gm_exist){
								 $insert_gm = $this->Register_model->insert_gm($get_ge,$get_ge['generalexam_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_ge2 = $this->Register_model->get_general_examinations_old($vid2);
					 
					 if($get_ge2){
						 
						 foreach($get_ge2 as $get_ge){
							 $check_gm_exist = $this->Register_model->get_general_examinations_vid2($vid1, $get_ge['generalexam_name']);
							 if($check_gm_exist){
								  $this->Register_model->delete_gm($get_ge,$vid1,$vid2,$get_ge['generalexam_name']);
							 }else{
								 $this->Register_model->update_gm($get_ge,$vid1,$vid2,$get_ge['generalexam_name']);
							 }
							 
						 }
					 }
					 
					//general examination end
					
					
					//laboratory start
					
					$get_labs = $this->Register_model->get_laboratory($vid1);
					
					if($get_labs){
						 //$message = 'ready for visit';
						 foreach($get_labs as $get_lab){
							 $check_lab_exist = $this->Register_model->get_lab_vid2($vid2, $get_lab['labinvs_name']);
							 if($check_lab_exist){
									$this->Register_model->insert_lab($get_lab,$get_lab['labinvs_name'],$vid2);
							 }
						 }
					 }
					 
				 $get_labs2 = $this->Register_model->get_laboratory($vid2);
				 
				 
					 if($get_labs2){
						 
						 foreach($get_labs2 as $get_lab){
							 $check_lab_exist = $this->Register_model->get_lab_vid2($vid1, $get_lab['labinvs_name']);
							 if($check_lab_exist){
								  $this->Register_model->delete_lab($get_lab,$vid1,$vid2,$get_lab['labinvs_name']);
							 }else{
								 $this->Register_model->update_lab($get_lab,$vid1,$vid2,$get_lab['labinvs_name']);
							 }
							 
						 }
					 }
					 
					 $get_ecg = $this->Register_model->get_ecg($vid1);
					 if($get_ecg){
						 $check_ecg_exist = $this->Register_model->get_ecg($vid2);
						 if($check_ecg_exist){
							 $this->Register_model->delete_ecg($check_ecg_exist,$vid1,$vid2);
						 }
						 
					 }else{
						 $check_ecg_exist = $this->Register_model->get_ecg($vid2);
						 if($check_ecg_exist){
							 $this->Register_model->update_ecg($check_ecg_exist,$vid1,$vid2);
						 }
					 }
					 
					 
					
					//laboratory end
					
					
					
					//complications start
					
					$get_complications = $this->Register_model->get_complications($vid1);
					if($get_complications){
						 //$message = 'ready for visit';
						 foreach($get_complications as $get_complication){
							 $check_complication_exist = $this->Register_model->get_complication_vid2($vid2, $get_complication['vcomplication_name']);
							 if($check_complication_exist){
									$this->Register_model->insert_complication($get_complication,$get_complication['vcomplication_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_complications = $this->Register_model->get_complications($vid2);
					 
					 if($get_complications){
						 //$message = 'ready for visit';
						 foreach($get_complications as $get_complication){
							 $this->Register_model->update_complication($get_complication,$vid1,$vid2,$get_complication['vcomplication_name']);
							 
						 }
					 }
					 
					
					
					//complications end
					
					
					//personal habit start
					
					$get_p_habits = $this->Register_model->get_p_habit($vid1);
					if($get_p_habits){
						 //$message = 'ready for visit';
						 foreach($get_p_habits as $get_p_habit){
							 $check_p_habit = $this->Register_model->get_p_habit_vid2($vid2, $get_p_habit['phabit_name']);
							 if($check_p_habit){
									$this->Register_model->insert_p_habit($get_p_habit,$get_p_habit['phabit_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_p_habits = $this->Register_model->get_p_habit($vid2);
					 
					 if($get_p_habits){
						 //$message = 'ready for visit';
						 foreach($get_p_habits as $get_p_habit){
							 $this->Register_model->update_p_habit($get_p_habit,$vid1,$vid2,$get_p_habit['phabit_name']);
							 
						 }
					 }
					
					//personal habit end
					
					
					
					//family history start
					
					$get_f_histories = $this->Register_model->get_f_histories($vid1);
					if($get_f_histories){
						 //$message = 'ready for visit';
						 foreach($get_f_histories as $get_f_history){
							 $check_f_history = $this->Register_model->get_f_history_vid2($vid2, $get_f_history['fmhistory_label']);
							 if($check_f_history){
								 if( empty($check_f_history['fmhistory_diabetes']) && empty($check_f_history['fmhistory_htn']) && empty($check_f_history['fmhistory_ihd']) && 
									empty($check_f_history['fmhistory_stroke']) && empty($check_f_history['fmhistory_amupation'])){
									 $this->Register_model->insert_f_history($check_f_history,$check_f_history['fmhistory_label'],$vid2);
								 }else{
									 if(empty($get_f_history['fmhistory_diabetes']) && !empty($check_f_history['fmhistory_diabetes']) ){
										 $field = 'fmhistory_diabetes';
										 $this->Register_model->update_f_history_field($field,$check_f_history['fmhistory_diabetes'],$check_f_history['fmhistory_label'],$vid1);
									 }
									 
									 if(empty($get_f_history['fmhistory_htn']) && !empty($check_f_history['fmhistory_htn']) ){
										 $field = 'fmhistory_htn';
										 $this->Register_model->update_f_history_field($field,$check_f_history['fmhistory_htn'],$check_f_history['fmhistory_label'],$vid1);
									 }
									 
									 if(empty($get_f_history['fmhistory_ihd']) && !empty($check_f_history['fmhistory_ihd']) ){
										 $field = 'fmhistory_ihd';
										 $this->Register_model->update_f_history_field($field,$check_f_history['fmhistory_ihd'],$check_f_history['fmhistory_label'],$vid1);
									 }
									 
									 if(empty($get_f_history['fmhistory_stroke']) && !empty($check_f_history['fmhistory_stroke']) ){
										 $field = 'fmhistory_stroke';
										 $this->Register_model->update_f_history_field($field,$check_f_history['fmhistory_stroke'],$check_f_history['fmhistory_label'],$vid1);
									 }
									 
									 if(empty($get_f_history['fmhistory_amupation']) && !empty($check_f_history['fmhistory_amupation']) ){
										 $field = 'fmhistory_amupation';
										 $this->Register_model->update_f_history_field($field,$check_f_history['fmhistory_amupation'],$check_f_history['fmhistory_label'],$vid1);
									 }
									 
									 $this->Register_model->insert_f_history($check_f_history,$check_f_history['fmhistory_label'],$vid2);
								 }
									
							 }
						 }
					 }
					 
					 $get_f_histories = $this->Register_model->get_f_histories($vid2);
					 if($get_f_histories){
						 foreach($get_f_histories as $get_f_history){
							 $this->Register_model->update_f_history($get_f_history,$vid1,$vid2,$get_f_history['fmhistory_label']);
						 }
						 
					 }
					
					//family history end
					
					
					//prv ditary history start
					
					$get_prv_d_histories = $this->Register_model->get_prv_d_histories($vid1);
					if($get_prv_d_histories){
						 //$message = 'ready for visit';
						 foreach($get_prv_d_histories as $get_prv_d_history){
							 $check_prv_d_history = $this->Register_model->get_prv_d_history_vid2($vid2, $get_prv_d_history['diehist_name']);
							 if($check_prv_d_history){
									$this->Register_model->insert_prv_d_history($check_prv_d_history,$get_prv_d_history['diehist_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_d_histories = $this->Register_model->get_prv_d_histories($vid2);
					 if($get_prv_d_histories){
						 foreach($get_prv_d_histories as $get_prv_d_history){
							 $this->Register_model->update_prv_d_history($get_prv_d_history,$vid1,$vid2,$get_prv_d_history['diehist_name']);
						 }
						 
					 }
					
					//prv ditary history end
					
					
					//prv cooking oil start
					$get_prv_coils = $this->Register_model->get_prv_co($vid1);
					if($get_prv_coils){
						 //$message = 'ready for visit';
						 foreach($get_prv_coils as $get_prv_coil){
							 $check_prv_coil = $this->Register_model->get_prv_coil_vid2($vid2, $get_prv_coil['cooking_oil_name']);
							 if($check_prv_coil){
									$this->Register_model->insert_prv_coil($check_prv_coil,$check_prv_coil['cooking_oil_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_coils = $this->Register_model->get_prv_co($vid2);
					 if($get_prv_coils){
						 //$message = 'ready for visit';
						 foreach($get_prv_coils as $get_prv_coil){
							 
									$this->Register_model->update_prv_coil($get_prv_coil,$vid1,$vid2,$get_prv_coil['cooking_oil_name']);
							 
						 }
					 }
					
					//prv cooking oil end
					
					
					//prv physical activity start
					$get_prv_p_activities = $this->Register_model->get_prv_p_activity($vid1);
					if($get_prv_p_activities){
						 //$message = 'ready for visit';
						 foreach($get_prv_p_activities as $get_prv_p_activity){
							 $check_prv_p_activity = $this->Register_model->get_prv_p_activity_vid2($vid2, $get_prv_p_activity['physical_act_type']);
							 if($check_prv_p_activity){
									$this->Register_model->insert_prv_p_activity($check_prv_p_activity,$check_prv_p_activity['physical_act_type'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_p_activities = $this->Register_model->get_prv_p_activity($vid2);
					 if($get_prv_p_activities){
							 //$message = 'ready for visit';
							 foreach($get_prv_p_activities as $get_prv_p_activity){
								 
										$this->Register_model->update_prv_p_activity($get_prv_p_activity,$vid1,$vid2,$get_prv_p_activity['physical_act_type']);
								 
							 }
						 }
					
					
					//prv physical activity end
					
					
					//prv Anti HTN start
					$get_prv_anti_htns = $this->Register_model->get_prv_anti_htns($vid1);
					if($get_prv_anti_htns){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_htns as $get_prv_anti_htn){
							 $check_prv_anti_htn = $this->Register_model->get_prv_anti_htn_vid2($vid2, $get_prv_anti_htn['anti_htn_name']);
							 if($check_prv_anti_htn){
									$this->Register_model->insert_prv_anti_htn($check_prv_anti_htn,$check_prv_anti_htn['anti_htn_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_anti_htns = $this->Register_model->get_prv_anti_htns($vid2);
					 if($get_prv_anti_htns){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_htns as $get_prv_anti_htn){
							 
									$this->Register_model->update_prv_anti_htn($get_prv_anti_htn,$vid1,$vid2,$get_prv_anti_htn['anti_htn_name']);
							 
						 }
					 }
					
					
					//prv Anti HTN end
					
					
					
					//prv Anti lipid start
					$get_prv_anti_lipids = $this->Register_model->get_prv_anti_lipids($vid1);
					if($get_prv_anti_lipids){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_lipids as $get_prv_anti_lipid){
							 $check_prv_anti_lipid = $this->Register_model->get_prv_anti_lipid_vid2($vid2, $get_prv_anti_lipid['anti_lipid_name']);
							 if($check_prv_anti_lipid){
									$this->Register_model->insert_prv_anti_lipid($check_prv_anti_lipid,$check_prv_anti_lipid['anti_lipid_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_anti_lipids = $this->Register_model->get_prv_anti_lipids($vid2);
					 if($get_prv_anti_lipids){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_lipids as $get_prv_anti_lipid){
							 
									$this->Register_model->update_prv_anti_lipid($get_prv_anti_lipid,$vid1,$vid2,$get_prv_anti_lipid['anti_lipid_name']);
							 
						 }
					 }
					
					
					//prv Anti lipid end
					
					
					//prv Anti ovesity start
					$get_prv_anti_obesities = $this->Register_model->get_prv_anti_obesity($vid1);
					if($get_prv_anti_obesities){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_obesities as $get_prv_anti_obesity){
							 $check_prv_anti_obesity = $this->Register_model->get_prv_anti_obesity_vid2($vid2, $get_prv_anti_obesity['anti_obesity_name']);
							 if($check_prv_anti_obesity){
									$this->Register_model->insert_prv_anti_obesity($check_prv_anti_obesity,$check_prv_anti_obesity['anti_obesity_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_anti_obesities = $this->Register_model->get_prv_anti_obesity($vid2);
					 if($get_prv_anti_obesities){
						 //$message = 'ready for visit';
						 foreach($get_prv_anti_obesities as $get_prv_anti_obesity){
							 
									$this->Register_model->update_prv_anti_obesity($get_prv_anti_obesity,$vid1,$vid2,$get_prv_anti_obesity['anti_obesity_name']);
							 
						 }
					 }
					//prv Anti ovesity end
					
					
					//prv other start
					$get_prv_other = $this->Register_model->get_prv_other($vid1);
					if($get_prv_other){
						 //$message = 'ready for visit';
						 foreach($get_prv_other as $get_prv_other){
							 $check_prv_other = $this->Register_model->get_prv_other_vid2($vid2, $get_prv_other['other_name']);
							 if($check_prv_other){
									$this->Register_model->insert_prv_other($check_prv_other,$check_prv_other['other_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_prv_other = $this->Register_model->get_prv_other($vid2);
					 if($get_prv_other){
						 //$message = 'ready for visit';
						 foreach($get_prv_other as $get_prv_other){
							 
									$this->Register_model->update_prv_other($get_prv_other,$vid1,$vid2,$get_prv_other['other_name']);
							 
						 }
					 }
					
					//prv other end
					
					//crnt ditary history start
										
					$get_crnt_d_histories = $this->Register_model->get_crnt_d_histories($vid1);
					if($get_crnt_d_histories){
						 //$message = 'ready for visit';
						 foreach($get_crnt_d_histories as $get_crnt_d_history){
							 $check_crnt_d_history = $this->Register_model->get_crnt_d_history_vid2($vid2, $get_crnt_d_history['diehist_name']);
							 if($check_crnt_d_history){
									$this->Register_model->insert_crnt_d_history($check_crnt_d_history,$get_crnt_d_history['diehist_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_d_histories = $this->Register_model->get_crnt_d_histories($vid2);
					 if($get_crnt_d_histories){
						 foreach($get_crnt_d_histories as $get_crnt_d_history){
							 $this->Register_model->update_crnt_d_history($get_crnt_d_history,$vid1,$vid2,$get_crnt_d_history['diehist_name']);
						 }
						 
					 }

					//crnt ditary history end
					
					//crnt cooking oil start
					$get_crnt_coils = $this->Register_model->get_crnt_co($vid1);
					if($get_crnt_coils){
						 //$message = 'ready for visit';
						 foreach($get_crnt_coils as $get_crnt_coil){
							 $check_crnt_coil = $this->Register_model->get_crnt_coil_vid2($vid2, $get_crnt_coil['cooking_oil_name']);
							 if($check_crnt_coil){
									$this->Register_model->insert_crnt_coil($check_crnt_coil,$check_crnt_coil['cooking_oil_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_coils = $this->Register_model->get_crnt_co($vid2);
					 if($get_crnt_coils){
						 //$message = 'ready for visit';
						 foreach($get_crnt_coils as $get_crnt_coil){
							 
									$this->Register_model->update_crnt_coil($get_crnt_coil,$vid1,$vid2,$get_crnt_coil['cooking_oil_name']);
							 
						 }
					 }
					
					//crnt cooking oil end
					
					
					//crnt physical activity start
					$get_crnt_p_activities = $this->Register_model->get_crnt_p_activity($vid1);
					if($get_crnt_p_activities){
						 //$message = 'ready for visit';
						 foreach($get_crnt_p_activities as $get_crnt_p_activity){
							 $check_crnt_p_activity = $this->Register_model->get_crnt_p_activity_vid2($vid2, $get_crnt_p_activity['physical_act_type']);
							 if($check_crnt_p_activity){
									$this->Register_model->insert_crnt_p_activity($check_crnt_p_activity,$check_crnt_p_activity['physical_act_type'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_p_activities = $this->Register_model->get_crnt_p_activity($vid2);
					 if($get_crnt_p_activities){
							 //$message = 'ready for visit';
							 foreach($get_crnt_p_activities as $get_crnt_p_activity){
								 
										$this->Register_model->update_crnt_p_activity($get_crnt_p_activity,$vid1,$vid2,$get_crnt_p_activity['physical_act_type']);
								 
							 }
						 }
					
					
					//crnt physical activity end
					
					
					
					//crnt Anti HTN start
					$get_crnt_anti_htns = $this->Register_model->get_crnt_anti_htns($vid1);
					if($get_crnt_anti_htns){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_htns as $get_crnt_anti_htn){
							 $check_crnt_anti_htn = $this->Register_model->get_crnt_anti_htn_vid2($vid2, $get_crnt_anti_htn['anti_htn_name']);
							 if($check_crnt_anti_htn){
									$this->Register_model->insert_crnt_anti_htn($check_crnt_anti_htn,$check_crnt_anti_htn['anti_htn_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_anti_htns = $this->Register_model->get_crnt_anti_htns($vid2);
					 if($get_crnt_anti_htns){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_htns as $get_crnt_anti_htn){
							 
									$this->Register_model->update_crnt_anti_htn($get_crnt_anti_htn,$vid1,$vid2,$get_crnt_anti_htn['anti_htn_name']);
							 
						 }
					 }
					
					
					//crnt Anti HTN end
					
					
					//crnt Anti lipid start
					$get_crnt_anti_lipids = $this->Register_model->get_crnt_anti_lipids($vid1);
					if($get_crnt_anti_lipids){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_lipids as $get_crnt_anti_lipid){
							 $check_crnt_anti_lipid = $this->Register_model->get_crnt_anti_lipid_vid2($vid2, $get_crnt_anti_lipid['anti_lipid_name']);
							 if($check_crnt_anti_lipid){
									$this->Register_model->insert_crnt_anti_lipid($check_crnt_anti_lipid,$check_crnt_anti_lipid['anti_lipid_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_anti_lipids = $this->Register_model->get_crnt_anti_lipids($vid2);
					 if($get_crnt_anti_lipids){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_lipids as $get_crnt_anti_lipid){
							 
									$this->Register_model->update_crnt_anti_lipid($get_crnt_anti_lipid,$vid1,$vid2,$get_crnt_anti_lipid['anti_lipid_name']);
							 
						 }
					 }
					
					
					//crnt Anti lipid end
					
					
					
					//crnt Anti ovesity start
					$get_crnt_anti_obesities = $this->Register_model->get_crnt_anti_obesity($vid1);
					if($get_crnt_anti_obesities){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_obesities as $get_crnt_anti_obesity){
							 $check_crnt_anti_obesity = $this->Register_model->get_crnt_anti_obesity_vid2($vid2, $get_crnt_anti_obesity['anti_obesity_name']);
							 if($check_crnt_anti_obesity){
									$this->Register_model->insert_crnt_anti_obesity($check_crnt_anti_obesity,$check_crnt_anti_obesity['anti_obesity_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_anti_obesities = $this->Register_model->get_crnt_anti_obesity($vid2);
					 if($get_crnt_anti_obesities){
						 //$message = 'ready for visit';
						 foreach($get_crnt_anti_obesities as $get_crnt_anti_obesity){
							 
									$this->Register_model->update_crnt_anti_obesity($get_crnt_anti_obesity,$vid1,$vid2,$get_crnt_anti_obesity['anti_obesity_name']);
							 
						 }
					 }
					//crnt Anti ovesity end
					
					
					//crnt other start
					$get_crnt_other = $this->Register_model->get_crnt_other($vid1);
					if($get_crnt_other){
						 //$message = 'ready for visit';
						 foreach($get_crnt_other as $get_crnt_other){
							 $check_crnt_other = $this->Register_model->get_crnt_other_vid2($vid2, $get_crnt_other['other_name']);
							 if($check_crnt_other){
									$this->Register_model->insert_crnt_other($check_crnt_other,$check_crnt_other['other_name'],$vid2);
							 }
						 }
					 }
					 
					 $get_crnt_other = $this->Register_model->get_crnt_other($vid2);
					 if($get_crnt_other){
						 //$message = 'ready for visit';
						 foreach($get_crnt_other as $get_crnt_other){
							 
									$this->Register_model->update_crnt_other($get_crnt_other,$vid1,$vid2,$get_crnt_other['other_name']);
							 
						 }
					 }
					
					//crnt other end
					 
				
			
			
		}elseif($get_ch[1]['visit_form_version'] === 'V2' && $get_ch[1]['visit_form_version'] === 'V2'){
			$message = 'Data Compilation is not ready for V2' ;
		}else{
			$message = 'Not verified' ;
		}
		
		$result = array('status' => 'ok', 'content' => $vid1, 'content2' => $update_visit);
		echo json_encode($result);
		exit;
	}
	
	
}
