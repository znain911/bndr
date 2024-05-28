<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visit extends CI_Controller {
	
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
	  $this->load->model('Visit_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function all($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Visit_model->check_patient_exist($patient_id, $entry);
		if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['entryid'] = $entry;
			
			//total rows count
			$totalRec = count($this->Visit_model->get_all_visits(array('patient_id' => $patient_id)));
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'pfilter/get_patient_visits';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id, 'limit'=>$this->perPage));
			$this->load->view('visits', $data);
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function entry_type($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Visit_model->check_patient_exist($patient_id, $entry);
		if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['entryid'] = $entry;
			
			//total rows count
			$totalRec = count($this->Visit_model->get_all_visits(array('patient_id' => $patient_id)));
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'pfilter/get_patient_visits';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			$data['items'] = $this->Visit_model->get_all_visits(array('patient_id' => $patient_id, 'limit'=>$this->perPage));
			$images = $this->Visit_model->get_image($patient_id);
			$foot = $this->Visit_model->get_foot($patient_id);
			$eye = $this->Visit_model->get_eye($patient_id);
			$filtered = array_values(array_column($images, null, 'visit_date'));
			$data['images'] = $filtered;
			$data['all_images'] = $images;
			$data['foot'] = $foot;
			$data['eye'] = $eye;
			
			$this->load->view('entry_type', $data);
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function ch_image($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Visit_model->check_patient_exist($patient_id, $entry);
		if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['entryid'] = $entry;
			
			
			$images = $this->Visit_model->get_ch_image($patient_id);
			$data['item'] = $images;
			
			$this->load->view('visit/ch_image', $data);
			
		}else
		{
			redirect('not-found');
		}
	}
	public function image($patient_id)
	{
			$display = null;
			$subBy = null;
			$docName = null;
			$eyedoc = null;
			$footdoc = null;
			$vid = $this->input->post('finaltreat_date');
			$name = $this->session->userdata('full_name');
			$cid = $this->session->userdata('user_org_center_id');
			$org = $this->Visit_model->get_org_by_centerid($cid);
			$imageNum = $this->Visit_model->image_number();
			$imageNum++;
			if($this->session->userdata('user_type') === 'Doctor'|| $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
					$subBy = $name.' (Doctor)';
					$docName = $this->session->userdata('full_name');
				}else {
					$subBy = $name.' (Operator)';
					$docName = $this->input->post('finaltreat_doctor_name');
				}
			if (!file_exists('./caseHistory/'.$patient_id)) {
					mkdir('./caseHistory/'.$patient_id , 0777, true);
				}
			if(isset($_FILES["image1"]["name"]))  
           {  
				
				
				$image = $_FILES["image1"]["name"];
				//$size=$_FILES['image']['size'];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image1'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display ='<div class="alert alert-success text-center" style = "color: black;font-weight: bold;">Image diplayed below has been successfully Uploaded</div>';  
                     $display .='<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           } 
			if(isset($_FILES["image2"]["name"]))  
           {  
				
				$image = $_FILES["image2"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image2'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
		   if(isset($_FILES["image3"]["name"]))  
           {  
				$image = $_FILES["image3"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
				if($this->session->userdata('user_type') === 'Foot Doctor'){
					$footdoc = $this->session->userdata('full_name');
				}else{
					$footdoc = $this->input->post('foot_doctor_name');
				}
                if(!$this->upload->do_upload('image3'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert_foot($patient_id,$imageName,$subBy,$vid,$footdoc,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
		   if(isset($_FILES["image4"]["name"]))  
           {  
				$image = $_FILES["image4"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image4'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
		   if(isset($_FILES["image5"]["name"]))  
           {  
				$image = $_FILES["image5"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
				if($this->session->userdata('user_type') === 'Eye Doctor'){
					$eyedoc = $this->session->userdata('full_name');
				}else{
				$eyedoc = $this->input->post('eye_doctor_name');
				}
                if(!$this->upload->do_upload('image5'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert_eye($patient_id,$imageName,$subBy,$vid,$eyedoc,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
			if(isset($_FILES["image6"]["name"]))  
           {  
				$image = $_FILES["image6"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image6'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
		   
		   if(isset($_FILES["image7"]["name"]))  
           {  
				$image = $_FILES["image7"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image7'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
		   
		   if(isset($_FILES["image8"]["name"]))  
           {  
				$image = $_FILES["image8"]["name"];
				$ext = strtolower(substr($image, strrpos($image, '.') + 1));
                $config['upload_path'] = './caseHistory/'.$patient_id;  
                $config['allowed_types'] = 'jpg|jpeg|png|gif';  
				$config['file_name'] = $imageNum;
				$imageName = $imageNum.'.'.$ext;
                $this->load->library('upload', $config);  
				$this->upload->initialize($config);
                if(!$this->upload->do_upload('image8'))  
                {  
                     echo $this->upload->display_errors();  
                }  
                else  
                {  
                     $data = $this->upload->data();  
					 $this->Visit_model->image_insert($patient_id,$imageName,$subBy,$vid,$docName,$cid,$org);
					 $imageNum++;
                     $display .= '<img src="'.base_url().'caseHistory/'.$patient_id.'/'.$data["file_name"].'" width="330" height="225" class="img-thumbnail" />';  
                     //echo '<h4 >'.$config['upload_path'].'</h4>';  
                }  
           }
			
			echo $display;
	}
	
	public function add($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Visit_model->check_patient_exist($patient_id, $entry);
		$case_history = $this->Visit_model->case_history($patient_id);
		if($check_patient_exist == true)
		{
			if($case_history){
				$data['case_history'] = 'yes';
			}else{
				$data['case_history'] = 'no';
			}
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry;
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			if( $this->session->userdata('user_type') === 'Doctor'){
				$this->load->view('visit/create_dr', $data);
			}else{
				$this->load->view('visit/create', $data);
			}
			
		}else
		{
			redirect('not-found');
		}
	}
	
	public function image_visit($patient_id, $entry)
	{
		$patient_id = intval($patient_id);
		$entry = html_escape($entry);
		//check patient exits
		$check_patient_exist = $this->Visit_model->check_patient_exist($patient_id, $entry);
		
			if($check_patient_exist == true)
		{
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry;
			$sess['visit_patient'] = $patient_id;
			$this->session->set_userdata($sess);
			if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor' || $this->session->userdata('user_type') === 'Eye Doctor'){
				$this->load->view('visit/image_dr', $data);
			}else{
			$this->load->view('visit/image', $data);
			}
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
		$check_patient_exist = $this->Visit_model->check_visit_exist($visit_id, $entry, $patient_id);
		
		if($check_patient_exist == true)
		{
			$entry_id = $this->Visit_model->get_entryid($patient_id);
			$data['patient_id'] = $patient_id;
			$data['patient_entry_id'] = $entry_id;
			$data['visit_id'] = $visit_id;
			$data['visit_entryid'] = $entry;
			$sess['visit_id'] = $visit_id;
			$this->session->set_userdata($sess);
			
			if($check_patient_exist['visit_form_version'] == 'V1'){
				$this->load->view('visit/edit', $data);
			}elseif($check_patient_exist['visit_form_version'] == 'V2'){
				$this->load->view('visit/editv2', $data);
			}
		}else
		{
			redirect('not-found');
		}
	}
	
	private function get_visit_org_id($center_id)
	{
		$og_id = $this->Visit_model->get_org_by_centerid($center_id);
		return $og_id;
	}
	public function imageLock()
	{
		$status = null;
		$patient_id = $this->input->post('pid');
		$patient = $this->Visit_model->patientDetailImage($patient_id);
		
		$lock_status = $this->Visit_model->image_lock_status($patient_id);
		
		if($lock_status['locked_by'] === null){
			$status = $patient_id.'/'.$patient['patient_entryid'];
			$name = $this->session->userdata('full_name');
			
			$lock_status = $this->Visit_model->lock_image($patient_id,$name);
		}elseif($lock_status['locked_by'] === $this->session->userdata('full_name')){
			$status = $patient_id.'/'.$patient['patient_entryid'];
		}else {
			$status = 'This Patient is locked';
		}
		
		
		//$result = array('status' => $patient_id);
			//echo json_encode($result);
			echo $status;
			exit;
	}
	
	public function transfer()
	{
		$feedback = null;
		$patient_id = $this->input->post('pid');
		$getvid = $this->Visit_model->getImageVid($patient_id);
		$pictures = $this->Visit_model->caseHistoryPic($patient_id);
		$visitId  = null;
		if(!empty($getvid)){
				$visitId = $getvid['visit_number'];
				$visitId = intval($visitId);
				$visitId++;
			}else{
				$visitId = 1;
			}
		
		if (!file_exists('./progress/'.$patient_id)) {
					mkdir('./progress/'.$patient_id , 0777, true);
				}
		foreach($pictures as $picture){
			$file = $picture['image_name'];

			$oldDir = FCPATH . 'caseHistory/'.$patient_id.'/';
			$newDir = FCPATH . 'progress/'.$patient_id.'/';

			if(rename($oldDir.$file, $newDir.$file) ){
				$feedback = 'success';
				$patient = $this->Visit_model->transfer($patient_id,$visitId);
			}
			//$this->load->library('ftp');
			//$this->ftp->upload('../'.$picture['image_name'],$picture['image_name'], 'ascii', 0775);
		}
		
				
		
		echo $feedback;
		exit;
	}
	
	public function create()
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
						'visit_form_version'       => 'V2',
						'visit_serial_no'          => $serial_no,
						'visit_patient_id'         => $patient_id,
						'visit_org_centerid'       => html_escape($this->input->post('visit_center_id')),
						'visit_date'               => db_formated_date($this->input->post('visit_date')),
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
			//Save basic visit informations
			$ins_id = $this->Visit_model->save_visit_information($basic_data);
			$visit_id = $this->db->insert_id($ins_id);				
			if($this->session->userdata('user_type') === 'Super Operator'){
				$name = $this->session->userdata('full_name');
				$this->Visit_model->image_update($patient_id,$name);
			}
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
			$gexam_weight_unit = $this->input->post('gexam_weight_unit');
			$gexam_weight_value = $this->input->post('gexam_weight_value');
			
			$gexam_height_unit = $this->input->post('gexam_height_unit');
			$gexam_height_value = $this->input->post('gexam_height_value');
			
			$gexam_waist_unit = $this->input->post('gexam_waist_unit');
			$gexam_waist_value = $this->input->post('gexam_waist_value');
			
			$gexam_hip_unit = $this->input->post('gexam_hip_unit');
			$gexam_hip_value = $this->input->post('gexam_hip_value');
			
			$gexam_st_sbp_unit = $this->input->post('gexam_st_sbp_unit');
			$gexam_st_sbp_value = $this->input->post('gexam_st_sbp_value');
			
			$gexam_st_dbp_unit = $this->input->post('gexam_st_dbp_unit');
			$gexam_st_dbp_value = $this->input->post('gexam_st_dbp_value');
			
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
		
			
			if(!empty($gexam_waist_value) ){
				$waist = $gexam_waist_value. ' '.$gexam_waist_unit;
			}else {
				$waist = null;
			}
			if(!empty($gexam_hip_value) ){
				$hip = $gexam_hip_value. ' '.$gexam_hip_unit;
			}else {
				$hip = null;
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
			if(!empty($gexam_st_sbp_value) ){
				$st_sbp = $gexam_st_sbp_value. ' '.$gexam_st_sbp_unit;
			}else {
				$st_sbp = null;
			}
			if(!empty($gexam_st_dbp_value) ){
				$st_dbp = $gexam_st_dbp_value. ' '.$gexam_st_dbp_unit;
			}else {
				$st_dbp = null;
			}
			
			
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'height'   => $height,
										'weight'   => $weight,
										'hip'   => $hip,
										'waist'   => $waist,
										'sitting_sbp'   => $si_sbp,
										'sitting_dbp'   => $si_dbp,
										'standing_sbp'   => $st_sbp,
										'standing_dbp'   => $st_dbp,
									);
					$this->Visit_model->save_visit_general_examination($general_exam_data);
			
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
													'footexmprfl_arteria_dorsalis_predis_present_left' => html_escape($this->input->post('arteria_dorsalis_predis_present_left')),
													'footexmprfl_arteria_dorsalis_predis_present_right' => html_escape($this->input->post('arteria_dorsalis_predis_present_right')),
													'footexmprfl_arteria_dorsalis_predis_absent_left'  => html_escape($this->input->post('arteria_dorsalis_predis_absent_left')),
													'footexmprfl_arteria_dorsalis_predis_absent_right'  => html_escape($this->input->post('arteria_dorsalis_predis_absent_right')),
													'footexmprfl_posterior_tribila_present_left'       => html_escape($this->input->post('posterior_tribila_present_left')),
													'footexmprfl_posterior_tribila_present_right'       => html_escape($this->input->post('posterior_tribila_present_right')),
													'footexmprfl_posterior_tribila_absent_left'        => html_escape($this->input->post('posterior_tribila_absent_left')),
													'footexmprfl_posterior_tribila_absent_right'        => html_escape($this->input->post('posterior_tribila_absent_right')),
												);
			$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);
			
			//Save foot examination sensation
			$foot_examination_sensation_data = array(
													'footexmsns_patient_id'           => $patient_id,
													'footexmsns_visit_id'             => $visit_id,
													'footexmsns_monofilament_present_left' => html_escape($this->input->post('monofilament_present_left')),
													'footexmsns_monofilament_present_right' => html_escape($this->input->post('monofilament_present_right')),
													'footexmsns_monofilament_absent_left'  => html_escape($this->input->post('monofilament_absent_left')),
													'footexmsns_monofilament_absent_right'  => html_escape($this->input->post('monofilament_absent_right')),
													'footexmsns_tuning_fork_present_left'  => html_escape($this->input->post('tuning_fork_present_left')),
													'footexmsns_tuning_fork_present_right'  => html_escape($this->input->post('tuning_fork_present_right')),
													'footexmsns_tuning_fork_absent_left'   => html_escape($this->input->post('tuning_fork_absent_left')),
													'footexmsns_tuning_fork_absent_right'   => html_escape($this->input->post('tuning_fork_absent_right')),
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
				
				if($diehist_name )
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
			
			//Save visit laboratory investigation main
			$fbg_value = html_escape($this->input->post('fbg'));
			$fbg_unit = html_escape($this->input->post('fbg_unit'));
			$sc_name = html_escape($this->input->post('sc'));
			$sc_unit = html_escape($this->input->post('sc_unit'));
			$twohag_name = html_escape($this->input->post('2hag'));
			$twohag_unit = html_escape($this->input->post('2hag_unit'));
			$sgpt_name = html_escape($this->input->post('sgpt'));
			$sgpt_unit = html_escape($this->input->post('sgpt_unit'));
			$pmb_name = html_escape($this->input->post('pmb'));
			$pmb_unit = html_escape($this->input->post('pmb_unit'));
			$hb_name = html_escape($this->input->post('hb'));
			$hb_unit = html_escape($this->input->post('hb_unit'));
			$rbg_name = html_escape($this->input->post('rbg'));
			$rbg_unit = html_escape($this->input->post('rbg_unit'));
			$tc_name = html_escape($this->input->post('tc'));
			$tc_unit = html_escape($this->input->post('tc_unit'));
			$hba1c_name = html_escape($this->input->post('hba1c'));
			$hba1c_unit = html_escape($this->input->post('hba1c_unit'));
			$dcn_name = html_escape($this->input->post('dcn'));
			if($dcn_name){
			$dcn = html_escape($this->input->post('dcn'));
			}else{
				$dcn = null;
			}
			$dcz_name = html_escape($this->input->post('dcz'));
			if($dcz_name){
			$dcz = html_escape($this->input->post('dcz'));
			}else {
				$dcz = null;
			}
			$dcm_name = html_escape($this->input->post('dcm'));
			if($dcm_name){
			$dcm = html_escape($this->input->post('dcm'));
			}else {
				$dcm = null;
			}
			$dce_name = html_escape($this->input->post('dce'));
			if($dce_name){
			$dce = html_escape($this->input->post('dce'));
			}else {
				$dce = null;
			}
			$t_chol_name = html_escape($this->input->post('t_chol'));
			$t_chol_unit = html_escape($this->input->post('t_chol_unit'));
			$esr_name = html_escape($this->input->post('esr'));
			if($esr_name){
			$esr = html_escape($this->input->post('esr'));
			}else {
				$esr = null;
			}
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
			$uma_name = html_escape($this->input->post('uma'));
			if($uma_name){
			$uma = html_escape($this->input->post('uma'));
			}else {
				$uma = null ;
			}
			$tg_name = html_escape($this->input->post('tg'));
			if($tg_name){
			$tg = html_escape($this->input->post('tg'));
			}else {
				$tg = null;
			}
			$uac_name = html_escape($this->input->post('uac'));
			$uac_unit = html_escape($this->input->post('uac_unit'));
			$bg_name = html_escape($this->input->post('bg'));
			if($bg_name){
			$bg = html_escape($this->input->post('bg'));
			}else {
				$bg = null;
			}
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
			if($tc_name){
			$tc = $tc_name.'  '.$tc_unit;
			}else {
				$tc = null;
			}
			if($rbg_name){
			$rbg = $rbg_name.'  '.$rbg_unit;
			}else {
				$rbg = null;
			}
			if($hb_name){
			$hb = $hb_name.'  '.$hb_unit;
			}else {
				$hb = null;
			}
			if($pmb_name){
			$pmb = $pmb_name.'  '.$pmb_unit;
			}else {
				$pmb = null;
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
										'post_meal_bg'       => $pmb,
										'hb'       => $hb,
										'rbg'       => $rbg,
										'tc'       => $tc,
										'hba1c'       => $hba1c,
										'dc_n'       => $dcn,
										'dc_z'       => $dcz,
										'dc_m'       => $dcm,
										'dc_e'       => $dce,
										't_chol'       => $t_chol,
										'esr'       => $esr,
										'ldl_c'       => $ldlc,
										'urine_albumin'       => $ua,
										'hdl_c'       => $hdlc,
										'urine_micro_albumin'       => $uma,
										'tg'       => $tg,
										'urine_acetone'       => $uac,
										'blood_group'       => $bg,
										'ecg_type'       => html_escape($this->input->post('ecg_type')),
										'ecg_abnormals'  => json_encode($ecg_abnormals),
										'usg_type'       => html_escape($this->input->post('usg_type')),
										'usg_abnormals'  => html_escape($usg_abnormals),
										
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
			// $ecg_abnormals = $this->input->post('abn_keywords');
			// $ecg_data = array(
							// 'ecg_patient_id' => $patient_id,
							// 'ecg_visit_id'   => $visit_id,
							// 'ecg_type'       => html_escape($this->input->post('ecg_type')),
							// 'ecg_abnormals'  => json_encode($ecg_abnormals),
						// );
			// $this->Visit_model->save_visit_laboratory_ecg($ecg_data);
			
			//Save visit laboratory investigation USG
			// $usg_abnormals = $this->input->post('usg_abnormal_value');
			// $ecg_data = array(
							// 'usg_patient_id' => $patient_id,
							// 'usg_visit_id'   => $visit_id,
							// 'usg_type'       => html_escape($this->input->post('usg_type')),
							// 'usg_abnormals'  => html_escape($usg_abnormals),
						// );
			// $this->Visit_model->save_visit_laboratory_usg($ecg_data);
			
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
				
				
				
				if( $this->session->userdata('user_type') === 'Doctor'){
					if($prev_oads_condition_time){
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
				}else{
					if($prev_oads_condition_time){
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
				}
				
				if($oads_name)
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
				
				if($prev_insulin_condition_time ){
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
				
				if($prev_insulin_name)
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
				
				if($prev_anti_htn_condition_time ){
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
				
				if($anti_htn_name)
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
				
				if($prev_anti_lipid_condition_time ){
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
				
				if($anti_lipid_name)
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
				
				if($prev_antiplatelets_condition_time ){
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
				
				if($prev_antiplatelets_name)
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
				
				if($prev_obesity_condition_time ){
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
				
				if($anti_obesity_name)
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
				
				if($prev_other_condition_time ){
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
				
				if($other_name)
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
										'finaltreat_next_visit_date'   => html_escape($this->input->post('finaltreat_next_visit_date')),
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
				
				
				
				if( $this->session->userdata('user_type') === 'Doctor'){
					if($crnt_oads_condition_time){
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
				}else{
					if($crnt_oads_condition_time){
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
				
				if($crnt_insulin_condition_time ){
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
				
				if($crnt_anti_lipid_condition_time ){
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
				
				if($crnt_antiplatelets_condition_time ){
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
				
				if($crnt_other_condition_time ){
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
			
			$success = '<div class="alert alert-success text-center">Visit has been successfully created!</div>';
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
	
	public function update_v_2()
	{
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
			$gexam_weight_unit = $this->input->post('gexam_weight_unit');
			$gexam_weight_value = $this->input->post('gexam_weight_value');
			
			$gexam_height_unit = $this->input->post('gexam_height_unit');
			$gexam_height_value = $this->input->post('gexam_height_value');
			
			$gexam_waist_unit = $this->input->post('gexam_waist_unit');
			$gexam_waist_value = $this->input->post('gexam_waist_value');
			
			$gexam_hip_unit = $this->input->post('gexam_hip_unit');
			$gexam_hip_value = $this->input->post('gexam_hip_value');
			
			$gexam_st_sbp_unit = $this->input->post('gexam_st_sbp_unit');
			$gexam_st_sbp_value = $this->input->post('gexam_st_sbp_value');
			
			$gexam_st_dbp_unit = $this->input->post('gexam_st_dbp_unit');
			$gexam_st_dbp_value = $this->input->post('gexam_st_dbp_value');
			
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
		
			
			if(!empty($gexam_waist_value) ){
				$waist = $gexam_waist_value. ' '.$gexam_waist_unit;
			}else {
				$waist = null;
			}
			if(!empty($gexam_hip_value) ){
				$hip = $gexam_hip_value. ' '.$gexam_hip_unit;
			}else {
				$hip = null;
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
			if(!empty($gexam_st_sbp_value) ){
				$st_sbp = $gexam_st_sbp_value. ' '.$gexam_st_sbp_unit;
			}else {
				$st_sbp = null;
			}
			if(!empty($gexam_st_dbp_value) ){
				$st_dbp = $gexam_st_dbp_value. ' '.$gexam_st_dbp_unit;
			}else {
				$st_dbp = null;
			}
			
			
					$general_exam_data = array(
										'generalexam_patient_id' => $patient_id,
										'generalexam_visit_id'   => $visit_id,
										'height'   => $height,
										'weight'   => $weight,
										'hip'   => $hip,
										'waist'   => $waist,
										'sitting_sbp'   => $si_sbp,
										'sitting_dbp'   => $si_dbp,
										'standing_sbp'   => $st_sbp,
										'standing_dbp'   => $st_dbp,
									);
					$visit_general = $this->Visit_model->get_visit_general($visit_id); 
					if($visit_general){
					$this->Visit_model->update_general_information($general_exam_data,$visit_id, $patient_id);
					}else {
					$this->Visit_model->save_visit_general_examination($general_exam_data);
					}
			
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
													'footexmprfl_arteria_dorsalis_predis_present_left' => html_escape($this->input->post('arteria_dorsalis_predis_present_left')),
													'footexmprfl_arteria_dorsalis_predis_present_right' => html_escape($this->input->post('arteria_dorsalis_predis_present_right')),
													'footexmprfl_arteria_dorsalis_predis_absent_left'  => html_escape($this->input->post('arteria_dorsalis_predis_absent_left')),
													'footexmprfl_arteria_dorsalis_predis_absent_right'  => html_escape($this->input->post('arteria_dorsalis_predis_absent_right')),
													'footexmprfl_posterior_tribila_present_left'       => html_escape($this->input->post('posterior_tribila_present_left')),
													'footexmprfl_posterior_tribila_present_right'       => html_escape($this->input->post('posterior_tribila_present_right')),
													'footexmprfl_posterior_tribila_absent_left'        => html_escape($this->input->post('posterior_tribila_absent_left')),
													'footexmprfl_posterior_tribila_absent_right'        => html_escape($this->input->post('posterior_tribila_absent_right')),
												);
			$this->Visit_model->save_foot_exam_periferal_info($foot_examination_periferal_data);
			
			//Save foot examination sensation
			$foot_examination_sensation_data = array(
													'footexmsns_patient_id'           => $patient_id,
													'footexmsns_visit_id'             => $visit_id,
													'footexmsns_monofilament_present_left' => html_escape($this->input->post('monofilament_present_left')),
													'footexmsns_monofilament_present_right' => html_escape($this->input->post('monofilament_present_right')),
													'footexmsns_monofilament_absent_left'  => html_escape($this->input->post('monofilament_absent_left')),
													'footexmsns_monofilament_absent_right'  => html_escape($this->input->post('monofilament_absent_right')),
													'footexmsns_tuning_fork_present_left'  => html_escape($this->input->post('tuning_fork_present_left')),
													'footexmsns_tuning_fork_present_right'  => html_escape($this->input->post('tuning_fork_present_right')),
													'footexmsns_tuning_fork_absent_left'   => html_escape($this->input->post('tuning_fork_absent_left')),
													'footexmsns_tuning_fork_absent_right'   => html_escape($this->input->post('tuning_fork_absent_right')),
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
				
				if($diehist_name)
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
			
			//update visit laboratory investigation main
			$fbg_value = html_escape($this->input->post('fbg'));
			$fbg_unit = html_escape($this->input->post('fbg_unit'));
			$sc_name = html_escape($this->input->post('sc'));
			$sc_unit = html_escape($this->input->post('sc_unit'));
			$twohag_name = html_escape($this->input->post('2hag'));
			$twohag_unit = html_escape($this->input->post('2hag_unit'));
			$sgpt_name = html_escape($this->input->post('sgpt'));
			$sgpt_unit = html_escape($this->input->post('sgpt_unit'));
			$pmb_name = html_escape($this->input->post('pmb'));
			$pmb_unit = html_escape($this->input->post('pmb_unit'));
			$hb_name = html_escape($this->input->post('hb'));
			$hb_unit = html_escape($this->input->post('hb_unit'));
			$rbg_name = html_escape($this->input->post('rbg'));
			$rbg_unit = html_escape($this->input->post('rbg_unit'));
			$tc_name = html_escape($this->input->post('tc'));
			$tc_unit = html_escape($this->input->post('tc_unit'));
			$hba1c_name = html_escape($this->input->post('hba1c'));
			$hba1c_unit = html_escape($this->input->post('hba1c_unit'));
			$dcn_name = html_escape($this->input->post('dcn'));
			if($dcn_name){
			$dcn = html_escape($this->input->post('dcn'));
			}else{
				$dcn = null;
			}
			$dcz_name = html_escape($this->input->post('dcz'));
			if($dcz_name){
			$dcz = html_escape($this->input->post('dcz'));
			}else {
				$dcz = null;
			}
			$dcm_name = html_escape($this->input->post('dcm'));
			if($dcm_name){
			$dcm = html_escape($this->input->post('dcm'));
			}else {
				$dcm = null;
			}
			$dce_name = html_escape($this->input->post('dce'));
			if($dce_name){
			$dce = html_escape($this->input->post('dce'));
			}else {
				$dce = null;
			}
			$t_chol_name = html_escape($this->input->post('t_chol'));
			$t_chol_unit = html_escape($this->input->post('t_chol_unit'));
			$esr_name = html_escape($this->input->post('esr'));
			if($esr_name){
			$esr = html_escape($this->input->post('esr'));
			}else {
				$esr = null;
			}
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
			$uma_name = html_escape($this->input->post('uma'));
			if($uma_name){
			$uma = html_escape($this->input->post('uma'));
			}else {
				$uma = null ;
			}
			$tg_name = html_escape($this->input->post('tg'));
			if($tg_name){
			$tg = html_escape($this->input->post('tg'));
			}else {
				$tg = null;
			}
			$uac_name = html_escape($this->input->post('uac'));
			$uac_unit = html_escape($this->input->post('uac_unit'));
			$bg_name = html_escape($this->input->post('bg'));
			if($bg_name){
			$bg = html_escape($this->input->post('bg'));
			}else {
				$bg = null;
			}
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
			if($tc_name){
			$tc = $tc_name.'  '.$tc_unit;
			}else {
				$tc = null;
			}
			if($rbg_name){
			$rbg = $rbg_name.'  '.$rbg_unit;
			}else {
				$rbg = null;
			}
			if($hb_name){
			$hb = $hb_name.'  '.$hb_unit;
			}else {
				$hb = null;
			}
			if($pmb_name){
			$pmb = $pmb_name.'  '.$pmb_unit;
			}else {
				$pmb = null;
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
										'post_meal_bg'       => $pmb,
										'hb'       => $hb,
										'rbg'       => $rbg,
										'tc'       => $tc,
										'hba1c'       => $hba1c,
										'dc_n'       => $dcn,
										'dc_z'       => $dcz,
										'dc_m'       => $dcm,
										'dc_e'       => $dce,
										't_chol'       => $t_chol,
										'esr'       => $esr,
										'ldl_c'       => $ldlc,
										'urine_albumin'       => $ua,
										'hdl_c'       => $hdlc,
										'urine_micro_albumin'       => $uma,
										'tg'       => $tg,
										'urine_acetone'       => $uac,
										'blood_group'       => $bg,
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
			
			//Save visit laboratory investigation USG
			$usg_abnormals = $this->input->post('usg_abnormal_value');
			$ecg_data = array(
							'usg_patient_id' => $patient_id,
							'usg_visit_id'   => $visit_id,
							'usg_type'       => html_escape($this->input->post('usg_type')),
							'usg_abnormals'  => html_escape($usg_abnormals),
						);
			$this->Visit_model->save_visit_laboratory_usg($ecg_data);
			
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
				
				if($prev_oads_condition_time){
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
				
				if($oads_name)
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
				
				if($prev_insulin_name)
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
				
				if($anti_htn_name)
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
				
				if($anti_lipid_name)
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
				
				if($prev_antiplatelets_name)
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
				
				if($anti_obesity_name)
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
				
				if($other_name)
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
										'finaltreat_next_visit_date'   => html_escape($this->input->post('finaltreat_next_visit_date')),
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
				
				if($crnt_oads_condition_time){
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
				
				if($crnt_insulin_condition_time){
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
				
				if($crnt_anti_lipid_condition_time ){
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
				
				if($crnt_antiplatelets_condition_time ){
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
				
				if($crnt_other_condition_time ){
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
			
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
			$success = '<div class="alert alert-success text-center">Visit has been successfully updated!</div>';
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
	
	
	
	public function update()
	{
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
			
			$check_submit_type = $this->input->post('submitType');
			if($check_submit_type == '0')
			{
				$exit = 1;
			}else
			{
				$exit = 0;
			}
			$success = '<div class="alert alert-success text-center">Visit has been successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success, 'exit' => $exit);
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
	
	public function check_visit_center()
	{
		$centers = $this->Visit_model->get_all_visit_centers();
		foreach($centers as $center)
		{
			echo $center['visit_visit_center'].'<br />';
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
		
		$check_visit = $this->Visit_model->check_visit(intval($visit_id), intval($patient_id), html_escape($visit_entryid));
		if($check_visit == true)
		{
			if($check_visit['visit_form_version'] == 'V2'){
				$date = $check_visit['visit_date'];
				
				if($date && substr_count( $date,"-") === 2){
					
					$check_visit_image = $this->Visit_model->check_visit_image($date,$patient_id);
					
					if($check_visit_image == false)
					{
						list($year, $month,$day) = explode('-', $date);
						$vdate= $day.'/'.$month.'/'.$year;
						$check_visit_image = $this->Visit_model->check_visit_image($vdate,$patient_id);
					}
					
					
					$data['images'] = $check_visit_image;
				}else{
					$data['images'] = null;
				}
				
				
				$this->load->view('visit/visit_preview_v2', $data);
			}elseif($check_visit['visit_form_version'] == 'V1'){
				$this->load->view('visit/visit_preview', $data);
			}else{
				redirect('not-found');
			}
		}else
		{
			redirect('not-found');
		}
		
	}
	
	public function get_drugs()
	{
		$term = html_escape($this->input->get('q'));
		$get_drugs = $this->Visit_model->get_drugs_bysrc($term);
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
		$get_drugs = $this->Visit_model->get_s_insuline($term);
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
		$get_datas = $this->Visit_model->get_registration_centers($term);
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
		$get_datas = $this->Visit_model->get_registration_centers($term);
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
		$get_datas = $this->Visit_model->load_doctors($term);
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
		$get_datas = $this->Visit_model->load_doctors_with_center_wise($term, $centerId);
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
		$drug_info = $this->Visit_model->get_drug_info($inp_name);
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
		$drug_info = $this->Visit_model->get_drug_info($inp_name);
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
		$data['receipt'] = $this->Visit_model->get_receipt_information($visit_id, $patient_id);
		$this->load->view('visit/moneyreceipt', $data);
	}
	
	public function get_investions()
	{
		$term = html_escape($this->input->get('q'));
		$get_datas = $this->Visit_model->get_investions($term);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['inv_name'], "value" => intval($data['inv_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
}
