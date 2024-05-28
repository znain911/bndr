<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Progress extends CI_Controller {
	
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
	  $this->load->model('Progress_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	  $this->load->model('Visit_model');
	}
	
	public function add($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry;
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id));
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/create_dr', $data);
		}else
		{
			redirect('not-found');
		}
		}else{
		if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['vid'] = 'SO';
			$data['patient_entry_id'] = $entry;
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/create', $data);
		}else
		{
			redirect('not-found');
		}
	}
	}
	
	public function add_super($patient_id, $entry,$vid)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		
		if($check_patient_exist == true)
		{
			
			$data['patient_id'] = $patient_id;
			$data['vid'] = $vid;
			$data['patient_entry_id'] = $entry;
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/create', $data);
		}else
		{
			redirect('not-found');
		}
	
	}
	
	public function image_progress($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry;
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/image', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	
	public function p_image($patient_id, $entry,$vid)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['entryid'] = $entry;
			$data['vid'] = $vid;
			
			
			$images = $this->Progress_model->get_p_image($patient_id , $vid);
			$data['item'] = $images;
			
			$this->load->view('progress/p_image', $data);
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function view_visit($visit_id, $entry, $patient_id)
	{
		$patient_id = intval($patient_id);
		$visit_id = intval($visit_id);
		$entry = html_escape($entry);
		//check patient exits

		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['entry'] = $entry;
			$data['patient_entry_id'] = $this->Visit_model->get_entryid_view($patient_id);
			$data['complication'] = $this->Visit_model->get_complication(array('visit_id' => $visit_id, 'patient_id' => $patient_id));
			$data['investigation'] = $this->Visit_model->get_investigation($visit_id,$patient_id);
			$data['oads'] = $this->Visit_model->get_oads_v($visit_id,$patient_id);
			$data['insuline'] = $this->Visit_model->get_ins($visit_id,$patient_id);
			$data['lipid'] = $this->Visit_model->get_anti_lipid_v($visit_id,$patient_id);
			$data['htn'] = $this->Visit_model->get_anti_htn_v($visit_id,$patient_id);
			$data['antiplatelet'] = $this->Visit_model->get_antiplatelet($visit_id,$patient_id);
			$data['obesity'] = $this->Visit_model->get_obesity($visit_id,$patient_id);
			$data['other'] = $this->Visit_model->get_other($visit_id,$patient_id);
			$data['lab_add'] = $this->Visit_model->get_lab_additional($visit_id,$patient_id);
			$data['lab'] = $this->Visit_model->get_lab($visit_id,$patient_id);
			$data['glucose'] = $this->Visit_model->get_glucose($visit_id,$patient_id);
			$data['general'] = $this->Visit_model->get_general($visit_id,$patient_id);
			$data['visit'] = $this->Visit_model->get_a_visit($visit_id,$patient_id);
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id));
			$sess['visit_patient'] = $patient_id;
			$data['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/view_visit', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	public function duplicate_visit($visit_id, $entry, $patient_id)
	{
		$patient_id = intval($patient_id);
		$visit_id = intval($visit_id);
		$entry = html_escape($entry);
		//check patient exits

		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry;
			$data['investigation'] = $this->Visit_model->get_investigation($visit_id,$patient_id);
			$data['oads'] = $this->Visit_model->get_oads_v($visit_id,$patient_id);
			$data['insuline'] = $this->Visit_model->get_ins($visit_id,$patient_id);
			$data['lipid'] = $this->Visit_model->get_anti_lipid_v($visit_id,$patient_id);
			$data['htn'] = $this->Visit_model->get_anti_htn_v($visit_id,$patient_id);
			$data['antiplatelet'] = $this->Visit_model->get_antiplatelet($visit_id,$patient_id);
			$data['obesity'] = $this->Visit_model->get_obesity($visit_id,$patient_id);
			$data['other'] = $this->Visit_model->get_other($visit_id,$patient_id);
			//$data['lab_add'] = $this->Visit_model->get_lab_additional($visit_id,$patient_id);
			//$data['lab'] = $this->Visit_model->get_lab($visit_id,$patient_id);
			$data['glucose'] = $this->Visit_model->get_glucose($visit_id,$patient_id);
			$data['general'] = $this->Visit_model->get_general($visit_id,$patient_id);
			$data['visit'] = $this->Visit_model->get_a_visit($visit_id,$patient_id);
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id));
			$sess['visit_patient'] = $patient_id;
			$data['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/duplicate_visit', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	public function print_visit($visit_id, $entry, $patient_id)
	{
		$patient_id = intval($patient_id);
		$visit_id = intval($visit_id);
		$entry = html_escape($entry);
		//check patient exits
		
		$check_patient_exist = $this->Progress_model->check_patient_exist($patient_id, $entry);
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $this->Visit_model->get_entryid_view($patient_id);
			$data['complication'] = $this->Visit_model->get_complication(array('visit_id' => $visit_id, 'patient_id' => $patient_id));
			$data['investigation'] = $this->Visit_model->get_investigation($visit_id,$patient_id);
			$data['oads'] = $this->Visit_model->get_oads_v($visit_id,$patient_id);
			$data['insuline'] = $this->Visit_model->get_ins($visit_id,$patient_id);
			$data['lipid'] = $this->Visit_model->get_anti_lipid_v($visit_id,$patient_id);
			$data['htn'] = $this->Visit_model->get_anti_htn_v($visit_id,$patient_id);
			$data['antiplatelet'] = $this->Visit_model->get_antiplatelet($visit_id,$patient_id);
			$data['obesity'] = $this->Visit_model->get_obesity($visit_id,$patient_id);
			$data['other'] = $this->Visit_model->get_other($visit_id,$patient_id);
			$data['lab_add'] = $this->Visit_model->get_lab_additional($visit_id,$patient_id);
			$data['lab'] = $this->Visit_model->get_lab($visit_id,$patient_id);
			$data['glucose'] = $this->Visit_model->get_glucose($visit_id,$patient_id);
			$data['general'] = $this->Visit_model->get_general($visit_id,$patient_id);
			$data['visit'] = $this->Visit_model->get_a_visit($visit_id,$patient_id);
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id));
			$sess['visit_patient'] = $patient_id;
			$data['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/print_visit', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	
	
	public function edit($visit_id, $entry, $patient_id)
	{
		$visit_id = intval($visit_id);
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Progress_model->check_visit_exist($visit_id, $entry, $patient_id);
		if($check_patient_exist == true)
		{
			$entry_id = $this->Progress_model->get_entryid($patient_id);
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry_id;
			$data['visit_id'] = $visit_id;
			$data['visit_entryid'] = $entry;
			$sess['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			
			$this->load->view('progress/edit', $data);
		}else
		{
			redirect('not-found');
		}
	}
	
	private function get_visit_org_id($center_id)
	{
		$og_id = $this->Progress_model->get_org_by_centerid($center_id);
		return $og_id;
	}
	
	public function image($patient_id)
	{
			$display = null;
			$subBy = null;
			$docName = null;
			$vid = $this->input->post('finaltreat_date');
			$name = $this->session->userdata('full_name');
			$cid = $this->session->userdata('user_org_center_id');
			$org = $this->Progress_model->get_org_by_centerid($cid);
			$imageNum = $this->Visit_model->image_number();
			$imageNum++;
			
			if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
					$subBy = $name.' (Doctor)';
					$docName = $this->session->userdata('full_name');
				}else {
					$subBy = $name.' (Operator)';
					$docName = $this->input->post('finaltreat_doctor_name');
				}
			if (!file_exists('./progress/'.$patient_id)) {
					mkdir('./progress/'.$patient_id , 0777, true);
				}
			$array = $this->input->post('image_array');
			$getvid = $this->Progress_model->getImageVid($patient_id);
			$visitId  = null;
			if(!empty($getvid)){
				$visitId = $getvid['visit_number'];
				$visitId = intval($visitId);
				$visitId++;
			}else{
				$visitId = 1;
			}
			if(!empty($array)){
				foreach($array as $row)
			{
			 
				
				
				$image = $_FILES["image".$row]["name"];
				//$size=$_FILES['image']['size'];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './progress/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image'.$row))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 if( $this->session->userdata('user_type') === 'Foot Doctor'){
						 $this->Progress_model->image_insert_foot($patient_id,$imageName,$subBy,$vid,$docName,$cid,$visitId,$org);
					 }elseif( $this->session->userdata('user_type') === 'Eye Doctor'){
						 $this->Progress_model->image_insert_eye($patient_id,$imageName,$subBy,$vid,$docName,$cid,$visitId,$org);
					 }else{
						$this->Progress_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$visitId,$org);
					 }
					 $imageNum++;
					 if($row === '1'){
                     $display ='<div class="alert alert-success text-center" style = "color: black;font-weight: bold;">Image diplayed below has been successfully Uploaded</div>';  
					 }
                     $display .='<img src="'.base_url().'progress/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }
			}
           } 
		   echo $display;
	}
	
	public function imageLock()
	{
		$status = null;
		$patient_id = $this->input->post('pid');
		$vid = $this->input->post('vid');
		$patient = $this->Visit_model->patientDetailImage($patient_id);
		
		$lock_status = $this->Progress_model->image_lock_status($patient_id,$vid);
		
		if($lock_status['locked_by'] === null){
			$status = $patient_id.'/'.$patient['patient_entryid'].'/'.$vid;
			$name = $this->session->userdata('full_name');
			
			$lock = $this->Progress_model->lock_image($patient_id,$name,$vid);
		}elseif($lock_status['locked_by'] === $this->session->userdata('full_name')){
			$status = $patient_id.'/'.$patient['patient_entryid'].'/'.$vid;
		}else {
			$status = 'This Patient is locked';
		}
		
		
		//$result = array('status' => $patient_id);
			//echo json_encode($result);
			echo $status;
			exit;
	}
	
	public function transferProgress()
	{
		$status = null;
		$patient_id = $this->input->post('pid');
		$vid = $this->input->post('vid');
		
		if(has_no_case_history($patient_id)){
		$pictures = $this->Progress_model->progressPic($patient_id , $vid);
		
		if (!file_exists('./caseHistory/'.$patient_id)) {
					mkdir('./caseHistory/'.$patient_id , 0777, true);
				}
				
		foreach($pictures as $picture){
			$file = $picture['image_name'];

			$oldDir = FCPATH . 'progress/'.$patient_id.'/';
			$newDir = FCPATH . 'caseHistory/'.$patient_id.'/';

			rename($oldDir.$file, $newDir.$file);
			//$this->load->library('ftp');
			//$this->ftp->upload('../'.$picture['image_name'],$picture['image_name'], 'ascii', 0775);
		}
		
		$patient = $this->Progress_model->transfer($patient_id,$vid);
		//echo base_url().'caseHistory/'.$patient_id.'/'.$picture['image_name'];
		echo 'Success';
		exit;
		
		
		}else {
			echo 'block';
			exit;
		}
	}
	
	public function create_progress_report()
	{
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
						'visit_date'               => db_formated_date($this->input->post('visit_date1')),
						'visit_patient_type'       => $visit_patient_type,
						'visit_registration_center'=> html_escape($this->input->post('registration_center_id')),
						'visit_org_id'             => $this->get_visit_org_id(html_escape($this->input->post('visit_center_id'))),
						'visit_doctor'             => html_escape($this->input->post('finaltreat_doctor_name')),
						'visit_admit_date'         => date("Y-m-d H:i:s"),
						'visit_admited_by'         => $this->session->userdata('active_user'),
						'visit_admited_by_usertype'=> $this->session->userdata('user_type'),
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
			//update marital status, gender, age,nid and address
			$gender = html_escape($this->input->post('gender'));
			$marital_info = html_escape($this->input->post('marital_info'));
			$age = html_escape($this->input->post('age'));
			$nid = html_escape($this->input->post('nid'));
			$address = html_escape($this->input->post('address'));
			$dob = html_escape($this->input->post('dateof_birth'));
			 if ($gender){
				 $this->Progress_model->update_gender($gender,$patient_id);
			 }
			 if ($marital_info){
				 $this->Progress_model->update_marital_info($marital_info,$patient_id);
			 }
			 if ($age){
				 $this->Progress_model->update_age($age,$dob,$patient_id);
			 }
			 if ($nid){
				 $this->Progress_model->update_nid($nid,$patient_id);
			 }
			 if ($address){
				 $this->Progress_model->update_address($address,$patient_id);
			 }
			//Save basic visit informations
			$ins_id = $this->Progress_model->save_visit_information($basic_data);
			$visit_id = $this->db->insert_id($ins_id);
			if($this->session->userdata('user_type') === 'Super Operator'){
				$name = $this->session->userdata('full_name');
				$vid = html_escape($this->input->post('vid'));
				$this->Progress_model->image_update($patient_id,$name,$vid);
			}
			//Save visit diabetes history
			$dhistory_type_of_glucose = html_escape($this->input->post('type_of_glucose'));
			if( $this->session->userdata('user_type') === 'Doctor'){
				$duration_of_glucose = html_escape($this->input->post('duration_of_glucose'));
				$duration_time = html_escape($this->input->post('duration_time'));
				if($duration_of_glucose){
				$dhistory_duration_of_glucose = $duration_of_glucose . ' ' . $duration_time;
				}else {
					$dhistory_duration_of_glucose = null;
				}
			}else {
				$dhistory_duration_of_glucose = html_escape($this->input->post('duration_of_glucose'));
			}
			$dhistory_prev_bad_obstetric_history = html_escape($this->input->post('prev_bad_obstetric_history'));
			$dhistory_prev_history_of_gdm = html_escape($this->input->post('prev_history_of_gdm'));
			$dhistory_past_medical_history = html_escape($this->input->post('past_medical_history'));
			if($dhistory_type_of_glucose || $dhistory_duration_of_glucose || $dhistory_prev_bad_obstetric_history || $dhistory_prev_history_of_gdm
			 || $dhistory_past_medical_history)
				{
					$diabetes_history_data = array(
												'dhistory_patient_id'                 => $patient_id,
												'dhistory_visit_id'                   => $visit_id,
												'dhistory_type_of_glucose'            => $dhistory_type_of_glucose,
												'dhistory_duration_of_glucose'        => $dhistory_duration_of_glucose,
												'dhistory_prev_bad_obstetric_history' => $dhistory_prev_bad_obstetric_history,
												'dhistory_prev_history_of_gdm'        => $dhistory_prev_history_of_gdm,
												'dhistory_past_medical_history'       => $dhistory_past_medical_history,
											);
					$this->Progress_model->save_diabetes_history($diabetes_history_data);
				}
			
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
			$gexam_weight_unit = $this->input->post('gexam_weight_unit');
			$gexam_weight_value = $this->input->post('gexam_weight_value');
			$gexam_height_unit = $this->input->post('gexam_height_unit');
			$gexam_height_value = $this->input->post('gexam_height_value');
			$gexam_si_sbp_unit = $this->input->post('gexam_si_sbp_unit');
			$gexam_si_sbp_value = $this->input->post('gexam_si_sbp_value');
			$gexam_si_dbp_unit = $this->input->post('gexam_si_dbp_unit');
			$gexam_si_dbp_value = $this->input->post('gexam_si_dbp_value');
			
			if(!empty($this->input->post('gexam_height_value')) || !empty($this->input->post('gexam_height_value_ft')) || empty($this->input->post('gexam_height_value_inch') )){
				if($gexam_height_unit === "ft/inch"){
					$ft = $this->input->post('gexam_height_value_ft');
					$inch  = $this->input->post('gexam_height_value_inch');
					
					$height = $ft .' ft '.$inch.' inch';
				}elseif($gexam_height_value){
					$height = $gexam_height_value. ' '.$gexam_height_unit;
				}else {
					$height = null;
				}
			}else{
				$height = null;
			}
		
			
			if(!empty($gexam_weight_value) ){
				$weight = $gexam_weight_value. ' '.$gexam_weight_unit;
			}else {
				$weight = null;
			}
			
			if(!empty($gexam_si_sbp_value) ){
				$si_sbp = $gexam_si_sbp_value. ' '.$gexam_si_sbp_unit;
			}else {
				$si_sbp = null;
			}
			
			if(!empty($gexam_si_dbp_value) ){
				$si_dbp = $gexam_si_dbp_value. ' '.$gexam_si_dbp_unit;
			}else {
				$si_dbp = null;
			}
			
			
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'height'   => $height,
										'weight'   => $weight,
										'sitting_sbp'   => $si_sbp,
										'sitting_dbp'   => $si_dbp,
									);
					$this->Progress_model->save_visit_general_examination($general_exam_data);
				
			
			//Save visit laboratory investigation main
			$after_meal_value = html_escape($this->input->post('after_meal'));
			$after_meal_unit = html_escape($this->input->post('after_meal_unit'));
			
			$fbg_value = html_escape($this->input->post('fbg'));
			$fbg_unit = html_escape($this->input->post('fbg_unit'));
			
			$ags_value = html_escape($this->input->post('ags'));
			$ags_unit = html_escape($this->input->post('ags_unit'));
			
			$sc_name = html_escape($this->input->post('sc'));
			$sc_unit = html_escape($this->input->post('sc_unit'));
			
			$twohag_name = html_escape($this->input->post('2hag'));
			$twohag_unit = html_escape($this->input->post('2hag_unit'));
			
			$sgpt_name = html_escape($this->input->post('sgpt'));
			$sgpt_unit = html_escape($this->input->post('sgpt_unit'));
			
			
			$rbg_name = html_escape($this->input->post('rbg'));
			$rbg_unit = html_escape($this->input->post('rbg_unit'));
			
			$hba1c_name = html_escape($this->input->post('hba1c'));
			$hba1c_unit = html_escape($this->input->post('hba1c_unit'));
			
			$t_chol_name = html_escape($this->input->post('t_chol'));
			$t_chol_unit = html_escape($this->input->post('t_chol_unit'));
			
			$ldlc_name = html_escape($this->input->post('ldlc'));
			$ldlc_unit = html_escape($this->input->post('ldlc_unit'));
			
			$ua_name = html_escape($this->input->post('ua'));
			
			if($ua_name){
			$ua = html_escape($this->input->post('ua'));
			}else {
				$ua = null;
			}
			$hdlc_name = html_escape($this->input->post('hdlc'));
			$hdlc_unit = html_escape($this->input->post('hdlc_unit'));
			
			$tg_name = html_escape($this->input->post('tg'));
			if($tg_name){
			$tg = html_escape($this->input->post('tg'));
			}else {
				$tg = null;
			}
			$uac_name = html_escape($this->input->post('uac'));
			$uac_unit = html_escape($this->input->post('uac_unit'));
			
			$ecg_abnormals = $this->input->post('abn_keywords');
			$usg_abnormals = $this->input->post('usg_abnormal_value');
			
			if($uac_name){
			$uac = $uac_name.'  '.$uac_unit;
			}else{
				$uac =null;
			}
			if($hdlc_name){
			$hdlc = $hdlc_name.'  '.$hdlc_unit;
			}else{
				$hdlc = null;
			}
			if($ldlc_name){
			$ldlc = $ldlc_name.'  '.$ldlc_unit;
			}else{
				$ldlc = null;
			}
			if($t_chol_name){
			$t_chol = $t_chol_name.'  '.$t_chol_unit;
			}else{
				$t_chol = null;
			}
			if($hba1c_name){
			$hba1c = $hba1c_name.'  '.$hba1c_unit;
			}else {
				$hba1c = null;
			}
			
			if($rbg_name){
			$rbg = $rbg_name.'  '.$rbg_unit;
			}else {
				$rbg = null;
			}
			
			if($sgpt_name){
			$sgpt = $sgpt_name.'  '.$sgpt_unit;
			}else{
				$sgpt = null;
			}
			if($twohag_name){
			$twohag = $twohag_name.'  '.$twohag_unit;
			}else{
				$twohag = null;
			}
			if($sc_name){
			$sc = $sc_name.'  '.$sc_unit;
			}else {
				$sc = null;
			}
			if($after_meal_value){
			$after_meal = $after_meal_value.'  '.$after_meal_unit;
			}else {
				$after_meal =null;
			}
			
			if($fbg_value){
			$fbg = $fbg_value.'  '.$fbg_unit;
			}else {
				$fbg =null;
			}
			
			if($ags_value){
			$ags = $ags_value.'  '.$ags_unit;
			}else {
				$ags =null;
			}
			
			$laboratory_investigation = array(
										'labinvs_patient_id' => $patient_id,
										'labinvs_visit_id'   => $visit_id,
										'fbg'       => $fbg,
										's_creatinine'       => $sc,
										'2hag'       => $twohag,
										'sgpt'       => $sgpt,
										'rbg'       => $rbg,
										'hba1c'       => $hba1c,
										't_chol'       => $t_chol,
										'ldl_c'       => $ldlc,
										'urine_albumin'       => $ua,
										'hdl_c'       => $hdlc,
										'tg'       => $tg,
										'urine_acetone'       => $uac,
										'ecg_type'       => html_escape($this->input->post('ecg_type')),
										'ecg_abnormals'  => json_encode($ecg_abnormals),
										'usg_type'       => html_escape($this->input->post('usg_type')),
										'usg_abnormals'  => html_escape($usg_abnormals),
										'ags'       => $ags,
										'after_meal'       => $after_meal,
										
									);
					$this->Visit_model->save_visit_laboratory_investigation_main($laboratory_investigation);
			
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
			// $ecg_abnormals = $this->input->post('abn_keywords');
			// if ($ecg_abnormals){
			// $ecg_data = array(
							// 'ecg_patient_id' => $patient_id,
							// 'ecg_visit_id'   => $visit_id,
							// 'ecg_type'       => html_escape($this->input->post('ecg_type')),
							// 'ecg_abnormals'  => json_encode($ecg_abnormals),
						// );
			// $this->Progress_model->save_visit_laboratory_ecg($ecg_data);
			// }
			
			//Save visit laboratory investigation USG
			// $usg_abnormals = $this->input->post('usg_abnormal_value');
			// if ($usg_abnormals){
			// $ecg_data = array(
							// 'usg_patient_id' => $patient_id,
							// 'usg_visit_id'   => $visit_id,
							// 'usg_type'       => html_escape($this->input->post('usg_type')),
							// 'usg_abnormals'  => html_escape($usg_abnormals),
						// );
			// $this->Visit_model->save_visit_laboratory_usg($ecg_data);
			// }
			
			//Save Final Treatment
			if($this->session->userdata('user_type') === 'Doctor'){
				$nvd = html_escape($this->input->post('finaltreat_next_visit_date'));
				if (substr_count( $nvd,"/") === 2){
					list($day, $month,$year) = explode('/', $nvd);
					$fnvd= $year.'-'.$month.'-'.$day;
				}else {
					$fnvd= null;
				}
				$refer_input = null;
				$refer = html_escape($this->input->post('refer_input'));
				if($refer){
					$refer_row = html_escape($this->input->post('refer_row'));
					if(!empty($refer_row)){
						foreach($refer_row as $row)
						{
							$refer_item = html_escape($this->input->post('refer_'.$row));
							
							if($refer_item){
								$refer_input = $refer_input.' '.$refer_item;
							}
							
						}
					}
					
				}
				
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
										'finaltreat_next_visit_date'   => $fnvd,
										'finaltreat_next_investigation'=> html_escape($this->input->post('finaltreat_next_investigation')),
										'finaltreat_clinical_info'     => html_escape($this->input->post('added_clinical_info')),
										'finaltreat_other_advice'      => html_escape($this->input->post('finaltreat_other_advice')),
										'finaltreat_refer_to'          => $refer_input,
									);
			}else {
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
										'finaltreat_next_visit_date'   => html_escape($this->input->post('finaltreat_next_visit_date')),
										'finaltreat_next_investigation'=> html_escape($this->input->post('finaltreat_next_investigation')),
									);
			}
			$this->Progress_model->save_final_treatment_infos($final_treatment_data);
				
			// current OADs
			$crnt_oads_rows = $this->input->post('crnt_oads_row');
			if(!empty($crnt_oads_rows)):
			foreach($crnt_oads_rows as $row)
			{
				$crnt_oads_name = html_escape($this->input->post('crnt_oads_name_'.$row));
				$crnt_oads_dose = html_escape($this->input->post('crnt_oads_value_'.$row));
				
				$crnt_oads_condition_time      = html_escape($this->input->post('crnt_oads_condition_time_'.$row));
				$crnt_oads_condition_time_type = html_escape($this->input->post('crnt_oads_condition_time_type_'.$row));
				$crnt_oads_condition_apply     = html_escape($this->input->post('crnt_oads_condition_apply_'.$row));
				$crnt_oads_duration            = html_escape($this->input->post('crnt_oads_duration_'.$row));
				$crnt_oads_duration_type       = html_escape($this->input->post('crnt_oads_duration_type_'.$row));
				
				if( $crnt_oads_condition_time){
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
				
				if($crnt_oads_name)
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
			if(!empty($crnt_insulin_rows)):
			foreach($crnt_insulin_rows as $row)
			{
				$crnt_insulin_name = html_escape($this->input->post('crnt_insulin_name_'.$row));
				$crnt_insulin_dose = html_escape($this->input->post('crnt_insulin_value_'.$row));
				
				$crnt_insulin_condition_time      = html_escape($this->input->post('crnt_insulin_condition_time_'.$row));
				$crnt_insulin_condition_time_type = html_escape($this->input->post('crnt_insulin_condition_time_type_'.$row));
				$crnt_insulin_condition_apply     = html_escape($this->input->post('crnt_insulin_condition_apply_'.$row));
				$crnt_insulin_duration            = html_escape($this->input->post('crnt_insulin_duration_'.$row));
				$crnt_insulin_duration_type       = html_escape($this->input->post('crnt_insulin_duration_type_'.$row));
				$before_sleeping                  = html_escape($this->input->post('before_sleeping_'.$row));
				$week                             = html_escape($this->input->post('week_'.$row));
				$week_days                        = null;
				$totat_days                              = null;
				$any_day                              = null;
				
				if($before_sleeping){
					$week = null;
					$week_days = null;
				}
				if($week){
					$week_days                        = html_escape($this->input->post('crnt_insulin_week_'.$row));
					$any_day                        = html_escape($this->input->post('jekonodin_'.$row));
					if($any_day){
						$totat_days = $any_day;
						
					}else{
						$day_array = $this->input->post('day_array');
						if(!empty($day_array)){
							foreach($day_array as $day_row)
							{
								$day_name = html_escape($this->input->post('day_'.$row.'_'.$day_row));
								if($day_name){
								$totat_days = $totat_days . ' '.$day_name;
								}
							}
						}
					}
					
				}
				
				if($crnt_insulin_condition_time){
					$insulin_advice_codition_time      = $crnt_insulin_condition_time;
					$insulin_advice_codition_time_type = $crnt_insulin_condition_time_type;
					$insulin_advice_codition_apply     = $crnt_insulin_condition_apply;
					$insulin_duration                  = $crnt_insulin_duration;
					$insulin_duration_type             = $crnt_insulin_duration_type;
					
					if($this->session->userdata('user_type') === 'Doctor'){
						$before_sleeping = null;
						$week = null;
						$week_days = null;
					}
					
				}else{
					$insulin_advice_codition_time      = null;
					$insulin_advice_codition_time_type = null;
					$insulin_advice_codition_apply     = null;
					$insulin_duration                  = null;
					$insulin_duration_type             = null;
				} 
				
				if($crnt_insulin_name)
				{
					if($this->session->userdata('user_type') === 'Doctor'){
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
									'insulin_before_sleep'              => $before_sleeping,
									'insulin_week_days'                 => $week_days,
									'insulin_days_list'                 => $totat_days,
								);
					}else{
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
						
					}
					$this->Progress_model->save_visitcrnt_insulin($crnt_insulin_data);
				}
			}
			endif;
			
			// current anti htn
			$crnt_anti_htn_row_rows = $this->input->post('crnt_anti_htn_row');
			if(!empty($crnt_anti_htn_row_rows)):
			foreach($crnt_anti_htn_row_rows as $row)
			{
				$anti_htn_name = html_escape($this->input->post('crnt_anti_htn_name_'.$row));
				$anti_htn_dose = html_escape($this->input->post('crnt_anti_htn_value_'.$row));
				
				$crnt_anti_htn_condition_time      = html_escape($this->input->post('crnt_anti_htn_condition_time_'.$row));
				$crnt_anti_htn_condition_time_type = html_escape($this->input->post('crnt_anti_htn_condition_time_type_'.$row));
				$crnt_anti_htn_condition_apply     = html_escape($this->input->post('crnt_anti_htn_condition_apply_'.$row));
				$crnt_anti_htn_duration            = html_escape($this->input->post('crnt_anti_htn_duration_'.$row));
				$crnt_anti_htn_duration_type       = html_escape($this->input->post('crnt_anti_htn_duration_type_'.$row));
				
				if($crnt_anti_htn_condition_time ){
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
				
				if($anti_htn_name )
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
			if( !empty($crnt_lipids_rows)):
			foreach($crnt_lipids_rows as $row)
			{
				$anti_lipid_name = html_escape($this->input->post('crnt_lipids_name_'.$row));
				$anti_lipid_dose = html_escape($this->input->post('crnt_lipids_value_'.$row));
				
				$crnt_anti_lipid_condition_time      = html_escape($this->input->post('crnt_lipids_condition_time_'.$row));
				$crnt_anti_lipid_condition_time_type = html_escape($this->input->post('crnt_lipids_condition_time_type_'.$row));
				$crnt_anti_lipid_condition_apply     = html_escape($this->input->post('crnt_lipids_condition_apply_'.$row));
				$crnt_anti_lipid_duration            = html_escape($this->input->post('crnt_lipids_duration_'.$row));
				$crnt_anti_lipid_duration_type       = html_escape($this->input->post('crnt_lipids_duration_type_'.$row));
				
				if($crnt_anti_lipid_condition_time){
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
				
				if($anti_lipid_name)
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
			if( !empty($crnt_aspirine_rows)):
			foreach($crnt_aspirine_rows as $row)
			{
				$antiplatelets_name = html_escape($this->input->post('crnt_aspirine_name_'.$row));
				$antiplatelets_dose = html_escape($this->input->post('crnt_aspirine_value_'.$row));
				
				$crnt_antiplatelets_condition_time      = html_escape($this->input->post('crnt_aspirine_condition_time_'.$row));
				$crnt_antiplatelets_condition_time_type = html_escape($this->input->post('crnt_aspirine_condition_time_type_'.$row));
				$crnt_antiplatelets_condition_apply     = html_escape($this->input->post('crnt_aspirine_condition_apply_'.$row));
				$crnt_antiplatelets_duration            = html_escape($this->input->post('crnt_aspirine_duration_'.$row));
				$crnt_antiplatelets_duration_type       = html_escape($this->input->post('crnt_aspirine_duration_type_'.$row));
				
				if($crnt_antiplatelets_condition_time){
				//if($crnt_antiplatelets_condition_time & $crnt_antiplatelets_duration){
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
				
				if($antiplatelets_name)
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
			if(!empty($crnt_obesity_rows)):
			foreach($crnt_obesity_rows as $row)
			{
				$anti_obesity_name = html_escape($this->input->post('crnt_obesity_name_'.$row));
				$anti_obesity_dose = html_escape($this->input->post('crnt_obesity_value_'.$row));
				
				$crnt_obesity_condition_time      = html_escape($this->input->post('crnt_obesity_condition_time_'.$row));
				$crnt_obesity_condition_time_type = html_escape($this->input->post('crnt_obesity_condition_time_type_'.$row));
				$crnt_obesity_condition_apply     = html_escape($this->input->post('crnt_obesity_condition_apply_'.$row));
				$crnt_obesity_duration            = html_escape($this->input->post('crnt_obesity_duration_'.$row));
				$crnt_obesity_duration_type       = html_escape($this->input->post('crnt_obesity_duration_type_'.$row));
				
				if($crnt_obesity_condition_time ){
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
				
				if($anti_obesity_name)
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
			if(!empty($crnt_other_rows)):
			foreach($crnt_other_rows as $row)
			{
				$other_name = html_escape($this->input->post('crnt_other_name_'.$row));
				$other_dose = html_escape($this->input->post('crnt_other_value_'.$row));
				
				$crnt_other_condition_time      = html_escape($this->input->post('crnt_other_condition_time_'.$row));
				$crnt_other_condition_time_type = html_escape($this->input->post('crnt_other_condition_time_type_'.$row));
				$crnt_other_condition_apply     = html_escape($this->input->post('crnt_other_condition_apply_'.$row));
				$crnt_other_duration            = html_escape($this->input->post('crnt_other_duration_'.$row));
				$crnt_other_duration_type       = html_escape($this->input->post('crnt_other_duration_type_'.$row));
				
				if($crnt_other_condition_time){
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
				
				if($other_name)
				{
					$crnt_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
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
			
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
		$phone_number = $this->input->post('visit_patient_phone');
		$checkPhone = $phone_number;
		$checkPhone =  str_replace('-', '', $checkPhone);
		$checkPhone =  str_replace(' ', '', $checkPhone);
		if(substr($checkPhone, 0, 2) !== '88')
		{
			$phone = '88'.$checkPhone;
		}else
		{
			$phone = $checkPhone;
		}
		
		$BNDR_ID = $this->input->post('visit_patient_bndr_ID');
		$next_visit_date = $this->input->post('finaltreat_next_visit_date');
$message ='BNDR ID: '.$BNDR_ID.'
FBS: '.$sms_array['FBS'].'
ABF: '.$sms_array['ABF'].'
HbA1c: '.$sms_array['HbA1c'].'
BP: '.$sms_array['BP'].'
Weight: '.$sms_array['Weight'].'
Next Visit: '.$next_visit_date.'
';
		sendsms($phone, $message);
			
			$success = '<div class="alert alert-success text-center">Progress report has been successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'exit' => $exit, 'visit_id' => $visit_id, 'visit_patient_id' => $patient_id, 'visit_entryid' => $entry_ID);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger text-center">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function update_progress_report()
	{
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
			$gexam_weight_unit = $this->input->post('gexam_weight_unit');
			$gexam_weight_value = $this->input->post('gexam_weight_value');
			$gexam_height_unit = $this->input->post('gexam_height_unit');
			$gexam_height_value = $this->input->post('gexam_height_value');
			$gexam_si_sbp_unit = $this->input->post('gexam_si_sbp_unit');
			$gexam_si_sbp_value = $this->input->post('gexam_si_sbp_value');
			$gexam_si_dbp_unit = $this->input->post('gexam_si_dbp_unit');
			$gexam_si_dbp_value = $this->input->post('gexam_si_dbp_value');
			
			if(!empty($this->input->post('gexam_height_value')) || !empty($this->input->post('gexam_height_value_ft')) || empty($this->input->post('gexam_height_value_inch') )){
				if($gexam_height_unit === "ft/inch"){
					$ft = $this->input->post('gexam_height_value_ft');
					$inch  = $this->input->post('gexam_height_value_inch');
					
					$height = $ft .' ft '.$inch.' inch';
				}else{
					$height = $gexam_height_value. ' '.$gexam_height_unit;
				}
			}else{
				$height = null;
			}
		
			
			if(!empty($gexam_weight_value) ){
				$weight = $gexam_weight_value. ' '.$gexam_weight_unit;
			}else {
				$weight = null;
			}
			
			if(!empty($gexam_si_sbp_value) ){
				$si_sbp = $gexam_si_sbp_value. ' '.$gexam_si_sbp_unit;
			}else {
				$si_sbp = null;
			}
			
			if(!empty($gexam_si_dbp_value) ){
				$si_dbp = $gexam_si_dbp_value. ' '.$gexam_si_dbp_unit;
			}else {
				$si_dbp = null;
			}
			
			
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'height'   => $height,
										'weight'   => $weight,
										'sitting_sbp'   => $si_sbp,
										'sitting_dbp'   => $si_dbp,
									);
					$visit_general = $this->Visit_model->get_visit_general($visit_id); 
					if($visit_general){
					$this->Progress_model->update_general_information($general_exam_data,$visit_id, $patient_id);
					}else {
					$this->Progress_model->save_visit_general_examination($general_exam_data);
					}
			
			//Save visit laboratory investigation main
			$fbg_value = html_escape($this->input->post('fbg'));
			$fbg_unit = html_escape($this->input->post('fbg_unit'));
			$sc_name = html_escape($this->input->post('sc'));
			$sc_unit = html_escape($this->input->post('sc_unit'));
			$twohag_name = html_escape($this->input->post('2hag'));
			$twohag_unit = html_escape($this->input->post('2hag_unit'));
			$sgpt_name = html_escape($this->input->post('sgpt'));
			$sgpt_unit = html_escape($this->input->post('sgpt_unit'));
			
			
			$rbg_name = html_escape($this->input->post('rbg'));
			$rbg_unit = html_escape($this->input->post('rbg_unit'));
			
			$hba1c_name = html_escape($this->input->post('hba1c'));
			$hba1c_unit = html_escape($this->input->post('hba1c_unit'));
			
			$t_chol_name = html_escape($this->input->post('t_chol'));
			$t_chol_unit = html_escape($this->input->post('t_chol_unit'));
			
			$ldlc_name = html_escape($this->input->post('ldlc'));
			$ldlc_unit = html_escape($this->input->post('ldlc_unit'));
			$ua_name = html_escape($this->input->post('ua'));
			if($ua_name){
			$ua = html_escape($this->input->post('ua'));
			}else {
				$ua = null;
			}
			$hdlc_name = html_escape($this->input->post('hdlc'));
			$hdlc_unit = html_escape($this->input->post('hdlc_unit'));
			
			$tg_name = html_escape($this->input->post('tg'));
			if($tg_name){
			$tg = html_escape($this->input->post('tg'));
			}else {
				$tg = null;
			}
			$uac_name = html_escape($this->input->post('uac'));
			$uac_unit = html_escape($this->input->post('uac_unit'));
			
			$ecg_abnormals = $this->input->post('abn_keywords');
			$usg_abnormals = $this->input->post('usg_abnormal_value');
			
			if($uac_name){
			$uac = $uac_name.'  '.$uac_unit;
			}else{
				$uac =null;
			}
			if($hdlc_name){
			$hdlc = $hdlc_name.'  '.$hdlc_unit;
			}else{
				$hdlc = null;
			}
			if($ldlc_name){
			$ldlc = $ldlc_name.'  '.$ldlc_unit;
			}else{
				$ldlc = null;
			}
			if($t_chol_name){
			$t_chol = $t_chol_name.'  '.$t_chol_unit;
			}else{
				$t_chol = null;
			}
			if($hba1c_name){
			$hba1c = $hba1c_name.'  '.$hba1c_unit;
			}else {
				$hba1c = null;
			}
			
			if($rbg_name){
			$rbg = $rbg_name.'  '.$rbg_unit;
			}else {
				$rbg = null;
			}
			
			if($sgpt_name){
			$sgpt = $sgpt_name.'  '.$sgpt_unit;
			}else{
				$sgpt = null;
			}
			if($twohag_name){
			$twohag = $twohag_name.'  '.$twohag_unit;
			}else{
				$twohag = null;
			}
			if($sc_name){
			$sc = $sc_name.'  '.$sc_unit;
			}else {
				$sc = null;
			}
			if($fbg_value){
			$fbg = $fbg_value.'  '.$fbg_unit;
			}else {
				$fbg =null;
			}
			
			$laboratory_investigation = array(
										'labinvs_patient_id' => $patient_id,
										'labinvs_visit_id'   => $visit_id,
										'fbg'       => $fbg,
										's_creatinine'       => $sc,
										'2hag'       => $twohag,
										'sgpt'       => $sgpt,
										'rbg'       => $rbg,
										'hba1c'       => $hba1c,
										't_chol'       => $t_chol,
										'ldl_c'       => $ldlc,
										'urine_albumin'       => $ua,
										'hdl_c'       => $hdlc,
										'tg'       => $tg,
										'urine_acetone'       => $uac,
										'ecg_type'       => html_escape($this->input->post('ecg_type')),
										'ecg_abnormals'  => json_encode($ecg_abnormals),
										'usg_type'       => html_escape($this->input->post('usg_type')),
										'usg_abnormals'  => html_escape($usg_abnormals),
										
									);
					$visit_laboratory_investigation_main = $this->Visit_model->get_visit_laboratory_investigation_main($visit_id); 
					if($visit_laboratory_investigation_main){
					$this->Visit_model->update_visit_laboratory_investigation_main($laboratory_investigation,$visit_id, $patient_id);
					}else {
					$this->Visit_model->save_visit_laboratory_investigation_main($laboratory_investigation);
					}
					
			//Save visit laboratory investigation
			$labinv_rows = $this->input->post('labinv_row');
			if(!empty($labinv_rows)):
			foreach($labinv_rows as $row)
			{
				$labinv_name = html_escape($this->input->post('labinv_row_name_'.$row));
				$labinv_value = html_escape($this->input->post('labinv_row_value_'.$row));
				$labinv_unit = html_escape($this->input->post('labinv_row_unit_'.$row));
				
				$check_lab = $this->Visit_model->check_lab_exist($visit_id,$labinv_name);
				
				if($check_lab){
					$laboratory_investigation = array(
										
										'labinvs_value'      => $labinv_value,
					
					);
						$this->Visit_model->update_visit_laboratory_investigation_additional($laboratory_investigation, $visit_id, $patient_id,$labinv_name);
				}elseif($labinv_name && $labinv_value)
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
										'finaltreat_next_visit_date'   => html_escape($this->input->post('finaltreat_next_visit_date')),
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
				
				if($crnt_oads_duration){
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
				
				if($crnt_oads_name)
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
				
				if($crnt_insulin_name)
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
				
				if($anti_htn_name)
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
				
				if($anti_lipid_name)
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
				
				if($antiplatelets_name)
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
				
				if($anti_obesity_name)
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
				
				if($other_name)
				{
					$crnt_omedication_other = array(
									'other_patient_id' => $patient_id,
									'other_visit_id'   => $visit_id,
									'other_name'       => $other_name,
									'other_dose'       => $other_dose,
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
			
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
			$success = '<div class="alert alert-success text-center">Progress report has been successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'exit' => $exit, 'visit_id' => $visit_id, 'visit_patient_id' => $patient_id, 'visit_entryid' => $entry_ID);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger text-center">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function view()
	{
		$visit_id = $this->uri->segment(4);
		$patient_id = $this->uri->segment(5);
		$visit_entryid = $this->uri->segment(6);
		$data['visit_id'] = intval($visit_id);
		$data['patient_id'] = intval($patient_id);
		$data['visit_entryid'] = intval($visit_entryid);
		
		$check_visit = $this->Progress_model->check_visit(intval($visit_id), intval($patient_id), html_escape($visit_entryid));
		if($check_visit == true)
		{
			$date = $check_visit['visit_date'];
			if($date && substr_count( $date,"-") === 2){
					
					$check_visit_image = $this->Progress_model->check_visit_image($date,$patient_id);
					
					if($check_visit_image == false)
					{
						list($year, $month,$day) = explode('-', $date);
						$vdate= $day.'/'.$month.'/'.$year;
						$check_visit_image = $this->Progress_model->check_visit_image($vdate,$patient_id);
					}
					
					
					$data['images'] = $check_visit_image;
				}else{
					$data['images'] = null;
				}
				
			$this->load->view('progress/preview', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	public function view_visit_preview()
	{
		$patient_id = $this->uri->segment(6);
		$visit_id = $this->uri->segment(4);
		$entry = $this->uri->segment(5);
		$data['visit_id'] = intval($visit_id);
		$data['patient_id'] = intval($patient_id);
		$data['entry'] = $entry;
		//check patient exits
		
		$check_patient_exist = $this->Progress_model->check_visit(intval($visit_id), intval($patient_id), html_escape($entry));
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $this->Visit_model->get_entryid_view($patient_id);
			$data['complication'] = $this->Visit_model->get_complication(array('visit_id' => $visit_id, 'patient_id' => $patient_id));
			$data['investigation'] = $this->Visit_model->get_investigation($visit_id,$patient_id);
			$data['oads'] = $this->Visit_model->get_oads_v($visit_id,$patient_id);
			$data['insuline'] = $this->Visit_model->get_ins($visit_id,$patient_id);
			$data['lipid'] = $this->Visit_model->get_anti_lipid_v($visit_id,$patient_id);
			$data['htn'] = $this->Visit_model->get_anti_htn_v($visit_id,$patient_id);
			$data['antiplatelet'] = $this->Visit_model->get_antiplatelet($visit_id,$patient_id);
			$data['obesity'] = $this->Visit_model->get_obesity($visit_id,$patient_id);
			$data['other'] = $this->Visit_model->get_other($visit_id,$patient_id);
			$data['lab_add'] = $this->Visit_model->get_lab_additional($visit_id,$patient_id);
			$data['lab'] = $this->Visit_model->get_lab($visit_id,$patient_id);
			$data['glucose'] = $this->Visit_model->get_glucose($visit_id,$patient_id);
			$data['general'] = $this->Visit_model->get_general($visit_id,$patient_id);
			$data['visit'] = $this->Visit_model->get_a_visit($visit_id,$patient_id);
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id));
			$sess['visit_patient'] = $patient_id;
			$data['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			$this->load->view('progress/view_visit', $data);
		}else
		{
			redirect('not-found');
		}
		
	}
	
	public function get_drugs()
	{
		$term = html_escape($this->input->get('q'));
		$get_drugs = $this->Progress_model->get_drugs_bysrc($term);
		$content = array();
		foreach($get_drugs as $drug):
			$content[] = $drug['brand'];
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	public function get_insulin()
	{
		$term = html_escape($this->input->get('q'));
		$get_drugs = $this->Progress_model->get_insulin($term);
		$content = array();
		foreach($get_drugs as $drug):
			$content[] = $drug['insuline_brand'];
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	
	public function get_registration_centers()
	{
		$term = html_escape($this->input->get('q'));
		$get_datas = $this->Progress_model->get_registration_centers($term);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['orgcenter_name'], "value" => intval($data['orgcenter_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	public function get_visit_centers()
	{
		$term = html_escape($this->input->get('q'));
		$get_datas = $this->Progress_model->get_registration_centers($term);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['orgcenter_name'], "value" => intval($data['orgcenter_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	public function load_doctors()
	{
		$term = html_escape($this->input->get('q'));
		$get_datas = $this->Progress_model->load_doctors($term);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['doctor_full_name'], "value" => intval($data['doctor_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	public function load_doctors_with_center_wise()
	{
		$term = html_escape($this->input->get('q'));
		$centerId = html_escape($this->input->get('centerId'));
		$get_datas = $this->Progress_model->load_doctors_with_center_wise($term, $centerId);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['doctor_full_name'], "value" => intval($data['doctor_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
	public function drug_info()
	{
		$inp_name = html_escape($this->input->get('q'));
		$inp_value = html_escape($this->input->get('inp_val'));
		$row = html_escape($this->input->get('inp_row'));
		$drug_info = $this->Progress_model->get_drug_info($inp_name);
		if($drug_info == true){
			$content = '<div class="col-lg-3 put-relative">
							<div class="medic-over-show" style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">
								<p><strong>'.$inp_name.':</strong></p>
								<p>
									<strong>'.$inp_value.'</strong>
									<input type="hidden" name="prev_medication_value_'.$row.'" value="'.$inp_value.'" />
								</p>
								<input type="hidden" name="prev_medication_row[]" value="'.$row.'" />
								<input type="hidden" name="prev_medication_row_name_'.$row.'" value="'.$drug_info['id'].'" />
								
								<div class="medic-over-hidden" style="text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; padding: 10px;">
									<p><strong>'.$inp_name.':</strong></p>
									<p>
										<strong>'.$inp_value.'</strong>
										<input type="hidden" name="prev_medication_value_'.$row.'" value="'.$inp_value.'" />
									</p>
									<div class="show-cmp-genrc">
										<p><strong>Company : </strong>'.$drug_info['company'].'</p>
										<p><strong>Generic : </strong>'.$drug_info['generic'].'</p>
									</div>
								</div>
							</div>
							<span class="rmv-itm mdi mdi-delete"></span>
						</div>';
				$table_content = '<tr>
									<td class="text-center">'.$row.'</td>
									<td>'.$inp_name.'</td>
									<td class="text-center">'.$inp_value.'</td>
									<td>'.$drug_info['company'].'</td>
									<td>'.$drug_info['generic'].'</td>
								 </tr>
								';
			
			echo json_encode(array('status' => 'ok', 'content' => $content, 'table_content' => $table_content));
			exit;
		}else
		{
			echo json_encode(array('status' => 'notok'));
			exit;
		}
	}
	
	public function drug_info_currentadvice()
	{
		$inp_name = html_escape($this->input->get('q'));
		$inp_value = html_escape($this->input->get('inp_val'));
		$row = html_escape($this->input->get('inp_row'));
		$drug_info = $this->Progress_model->get_drug_info($inp_name);
		if($drug_info == true)
		{
			$content = '<div class="col-lg-3 put-relative">
							<div class="medic-over-show" style="margin-bottom: 15px; text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; height: 80px; padding: 10px;">
								<p><strong>'.$inp_name.':</strong></p>
								<p>
									<strong>'.$inp_value.'</strong>
									<input type="hidden" name="crnt_medication_value_'.$row.'" value="'.$inp_value.'" />
								</p>
								<input type="hidden" name="crnt_medication_row[]" value="'.$row.'" />
								<input type="hidden" name="crnt_medication_row_name_'.$row.'" value="'.$drug_info['id'].'" />
								
								<div class="medic-over-hidden" style="text-align: center; border: 1px solid rgb(238, 238, 238); border-radius: 4px; line-height: 15px; padding: 10px;">
									<p><strong>'.$inp_name.':</strong></p>
									<p>
										<strong>'.$inp_value.'</strong>
									</p>
									<div class="show-cmp-genrc">
										<p><strong>Company : </strong>'.$drug_info['company'].'</p>
										<p><strong>Generic : </strong>'.$drug_info['generic'].'</p>
									</div>
								</div>
							</div>
							<span class="rmv-itm mdi mdi-delete"></span>
						</div>';
			$table_content = '<tr>
								<td class="text-center">'.$row.'</td>
								<td>'.$inp_name.'</td>
								<td class="text-center">'.$inp_value.'</td>
								<td>'.$drug_info['company'].'</td>
								<td>'.$drug_info['generic'].'</td>
							  </tr>
							';
			
			echo json_encode(array('status' => 'ok', 'content' => $content, 'table_content' => $table_content));
			exit;
		}else
		{
			echo json_encode(array('status' => 'notok'));
			exit;
		}
	}
	
	public function delete()
	{
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
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function moneyreceipt($id, $two, $three)
	{
		$visit_id = intval($id);
		$patient_id = intval($three);
		$data['receipt'] = $this->Progress_model->get_receipt_information($visit_id, $patient_id);
		$this->load->view('progress/moneyreceipt', $data);
	}
}
