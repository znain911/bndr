<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Patients extends CI_Controller {
	
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
	  $this->load->helper('custom_string');
	  $this->load->model('Common_model');
	}
	
	public function sync()
	{
		$params = array( 
			'patient_form_version' => $this->input->post('patient_form_version'), 
			'patient_entryid' => $this->input->post('patient_entryid'), 
			'patient_idby_center' => $this->input->post('patient_idby_center'), 
			'patient_gender' => $this->input->post('patient_gender'), 
			'patient_blood_group' => $this->input->post('patient_blood_group'), 
			'patient_email' => $this->input->post('patient_email'), 
			'patient_phone' => $this->input->post('patient_phone'), 
			'patient_org_id' => $this->input->post('patient_org_id'), 
			'patient_org_centerid' => $this->input->post('patient_org_centerid'), 
			'patient_name' => $this->input->post('patient_name'), 
			'patient_address' => $this->input->post('patient_address'), 
			'patient_nid' => $this->input->post('patient_nid'), 
			'patient_marital_status' => $this->input->post('patient_marital_status'), 
			'patient_guide_book' => $this->input->post('patient_guide_book'), 
			'patient_division_id' => $this->input->post('patient_division_id'), 
			'patient_district_id' => $this->input->post('patient_district_id'), 
			'patient_upazila_id' => $this->input->post('patient_upazila_id'), 
			'patient_postal_code' => $this->input->post('patient_postal_code'), 
			'patient_dateof_birth' => $this->input->post('patient_dateof_birth'), 
			'patient_registration_date' => $this->input->post('patient_registration_date'), 
			'patient_age' => $this->input->post('patient_age'), 
			'patient_admitted_by' => $this->input->post('patient_admitted_by'), 
			'patient_admitted_user_type' => $this->input->post('patient_admitted_user_type'), 
			'patient_admitted_user_syncid' => $this->input->post('patient_admitted_user_syncid'), 
			'patient_approved_by' => $this->input->post('patient_approved_by'), 
			'patient_regfee_amount' => $this->input->post('patient_regfee_amount'), 
			'patient_payment_status' => $this->input->post('patient_payment_status'), 
			'patient_create_date' => $this->input->post('patient_create_date'),
			'patient_is_registered' => $this->input->post('patient_is_registered'),
			'patient_sync_id'   => $this->input->post('patient_sync_id')
		  );
		//save patient information
		$ins_id = $this->Patient_model->create($params);
		$patient_id = $this->db->insert_id($ins_id);
		
		//save patient professional info
		$professional_data = array(
							'profinfo_patient_id' => $patient_id, 
							'profinfo_mothly_income' => $this->input->post('profinfo_mothly_income'), 
							'profinfo_education' => $this->input->post('profinfo_education'), 
							'profinfo_profession' => $this->input->post('profinfo_profession'),
						);
		$this->Patient_model->save_professional_info($professional_data);
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sync_update()
	{
		$params = array( 
			'patient_form_version' => $this->input->post('patient_form_version'), 
			'patient_entryid' => $this->input->post('patient_entryid'), 
			'patient_idby_center' => $this->input->post('patient_idby_center'), 
			'patient_gender' => $this->input->post('patient_gender'), 
			'patient_blood_group' => $this->input->post('patient_blood_group'), 
			'patient_email' => $this->input->post('patient_email'), 
			'patient_phone' => $this->input->post('patient_phone'), 
			'patient_org_id' => $this->input->post('patient_org_id'), 
			'patient_org_centerid' => $this->input->post('patient_org_centerid'), 
			'patient_name' => $this->input->post('patient_name'), 
			'patient_address' => $this->input->post('patient_address'), 
			'patient_nid' => $this->input->post('patient_nid'), 
			'patient_marital_status' => $this->input->post('patient_marital_status'), 
			'patient_guide_book' => $this->input->post('patient_guide_book'), 
			'patient_division_id' => $this->input->post('patient_division_id'), 
			'patient_district_id' => $this->input->post('patient_district_id'), 
			'patient_upazila_id' => $this->input->post('patient_upazila_id'), 
			'patient_postal_code' => $this->input->post('patient_postal_code'), 
			'patient_dateof_birth' => $this->input->post('patient_dateof_birth'), 
			'patient_registration_date' => $this->input->post('patient_registration_date'), 
			'patient_age' => $this->input->post('patient_age'), 
			'patient_admitted_by' => $this->input->post('patient_admitted_by'), 
			'patient_admitted_user_type' => $this->input->post('patient_admitted_user_type'), 
			'patient_approved_by' => $this->input->post('patient_approved_by'), 
			'patient_regfee_amount' => $this->input->post('patient_regfee_amount'), 
			'patient_payment_status' => $this->input->post('patient_payment_status'), 
			'patient_create_date' => $this->input->post('patient_create_date')
		  );
		//save patient information
		$patient_entryid = $this->input->post('patient_entryid');
		$patient_id = $this->Patient_model->get_rowid($patient_entryid);
		
		$this->Patient_model->update_sync($patient_entryid, $params);
		//save patient professional info
		$professional_data = array(
							'profinfo_mothly_income' => $this->input->post('profinfo_mothly_income'), 
							'profinfo_education' => $this->input->post('profinfo_education'), 
							'profinfo_profession' => $this->input->post('profinfo_profession'),
						);
		$this->Patient_model->update_professional_info($patient_id, $professional_data);
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function save()
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
		
		$this->load->library('form_validation');
		
		$today = date("Y-m-d");
		$total_items = $this->Patient_model->get_todaytotal_items($today);
		
		$get_org_code = $this->Patient_model->get_org_code($this->input->post('organization'));
		
		$counter_digit = str_pad($total_items, 7, '0', STR_PAD_LEFT);
		
		$entry_ID = $get_org_code.date('dmy').'BNDR'.$counter_digit;
		$data = array(
					'patient_entryid'       => $entry_ID,
					'patient_form_version'  => 'v2',
					'patient_idby_center'   => html_escape($this->input->post('patient_center_id')),
					'patient_gender'        => html_escape($this->input->post('gender')),
					'patient_blood_group'   => html_escape($this->input->post('blood_group')),
					'patient_email'         => html_escape($this->input->post('email')),
					'patient_phone'         => html_escape($this->input->post('phone')),
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
					'patient_registration_date'  => db_formated_date(html_escape($this->input->post('registration_date'))),
					'patient_age'                => html_escape($this->input->post('age')),
					'patient_admitted_by'        => $this->active_user,
					'patient_admitted_user_type' => $this->active_user_type,
					'patient_regfee_amount' => html_escape($this->input->post('fee_amount')),
					'patient_payment_status'=> html_escape($this->input->post('payment')),
					'patient_create_date'   => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'gender', 
							'label' => 'Gender', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save patient information
			$ins_id = $this->Patient_model->create($data);
			$patient_id = $this->db->insert_id($ins_id);			
			
			//save patient professional info
			$professional_data = array(
								'profinfo_patient_id'    => $patient_id,
								'profinfo_mothly_income' => html_escape($this->input->post('income')),
								'profinfo_education'     => html_escape($this->input->post('education')),
								'profinfo_profession'    => html_escape($this->input->post('profession')),
							);
			$this->Patient_model->save_professional_info($professional_data);
			
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
		$data = array(
					'patient_idby_center'   => html_escape($this->input->post('patient_idby_center')),
					'patient_gender'        => html_escape($this->input->post('gender')),
					'patient_blood_group'   => html_escape($this->input->post('blood_group')),
					'patient_email'         => html_escape($this->input->post('email')),
					'patient_phone'         => html_escape($this->input->post('phone')),
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
		$validate = array(
						array(
							'field' => 'gender', 
							'label' => 'Gender', 
							'rules' => 'required|trim', 
						),
					);
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
		$this->active_center = $this->input->post('active_center');
		$local_app_centers = $this->Common_model->get_local_app_centers();
		if(!in_array($this->active_center, $local_app_centers))
		{
			$result = array('status' => 'error', 'content' => 'This api is to be used in registered centers!');
			echo json_encode($result);
			exit;
		}
		
		$patient_entryid = $this->input->post('patient_entryid');
		$patient_id = $this->Patient_model->get_rowid($patient_entryid);
		
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
		$this->db->where('patient_entryid', $patient_entryid);
		$this->db->delete('starter_patients');
		
		$result = array("has_been_deleted" => "YES");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function importstart()
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
					$get_org_code  = $this->Patient_model->get_org_code($this->input->post('organization'));
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
			
			$result = array('has_been_imported' => 'YES');
			echo json_encode($result);
			exit;
		}else
		{
			$result = array('has_been_imported' => 'NO');
			echo json_encode($result);
			exit;
		}
	}
	
	public function src()
	{
		$src = html_escape($this->input->post('src'));
		//get the posts data
		$items = $this->Patient_model->get_srcall_items(array('src' => $src, 'limit'=>100));
		echo json_encode($items);
		exit;
	}
	
	public function get_patient_data()
	{
		$bndr_id = html_escape($this->input->post('bndr_id'));
		//get the posts data
		$item = $this->Patient_model->get_patient_data($bndr_id);
		echo json_encode($item);
		exit;
	}
	
}
