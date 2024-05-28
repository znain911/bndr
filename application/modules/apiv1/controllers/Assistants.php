<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistants extends CI_Controller {
	
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
	  
	  $this->load->model('assistants/Assistant_model', 'Assistant_model', true);
	  $this->load->model('assistants/Organization_model', 'Organization_model', true);
	  $this->load->model('Common_model');
	}
	
	public function sync()
	{
		$params = array(
					'assistant_phone' => $this->input->post('assistant_phone'), 
					'assistant_dateof_birth' => $this->input->post('assistant_dateof_birth'), 
					'assistant_org_id' => $this->input->post('assistant_org_id'), 
					'assistant_org_centerid' => $this->input->post('assistant_org_centerid'), 
					'assistant_full_name' => $this->input->post('assistant_full_name'), 
					'assistant_address' => $this->input->post('assistant_address'), 
					'assistant_division_id' => $this->input->post('assistant_division_id'), 
					'assistant_district_id' => $this->input->post('assistant_district_id'), 
					'assistant_upazila_id' => $this->input->post('assistant_upazila_id'), 
					'assistant_postal_code' => $this->input->post('assistant_postal_code'), 
					'assistant_email' => $this->input->post('assistant_email'), 
					'assistant_password' => $this->input->post('assistant_password'), 
					'asistant_ip_address' => $this->input->post('asistant_ip_address'), 
					'assistant_login_ip' => $this->input->post('assistant_login_ip'), 
					'assistant_last_login' => $this->input->post('assistant_last_login'), 
					'assistant_password_resetcde' => $this->input->post('assistant_password_resetcde'), 
					'assistant_applied_by' => $this->input->post('assistant_applied_by'), 
					'assistant_approved' => $this->input->post('assistant_approved'), 
					'assistant_approved_by' => $this->input->post('assistant_approved_by'), 
					'assistant_status' => $this->input->post('assistant_status'), 
					'assistant_create_date' => $this->input->post('assistant_create_date'), 
					'assistant_user_type' => $this->input->post('assistant_user_type'),
					'assistant_sync_id'   => $this->input->post('assistant_sync_id'),
				  );
						
		$get_id = $this->Assistant_model->create($params);
		$assistant_id = $this->db->insert_id($get_id);
		
		//create directory for the student
		$dirpath = attachment_dir()."assistants/".$assistant_id;
		if(file_exists($dirpath))
		{
			echo null;
		}else
		{
			mkdir($dirpath);
		}
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function sync_update()
	{
		$params = array(
					'assistant_phone' => $this->input->post('assistant_phone'), 
					'assistant_dateof_birth' => $this->input->post('assistant_dateof_birth'), 
					'assistant_org_id' => $this->input->post('assistant_org_id'), 
					'assistant_org_centerid' => $this->input->post('assistant_org_centerid'), 
					'assistant_full_name' => $this->input->post('assistant_full_name'), 
					'assistant_address' => $this->input->post('assistant_address'), 
					'assistant_division_id' => $this->input->post('assistant_division_id'), 
					'assistant_district_id' => $this->input->post('assistant_district_id'), 
					'assistant_upazila_id' => $this->input->post('assistant_upazila_id'), 
					'assistant_postal_code' => $this->input->post('assistant_postal_code'), 
					'assistant_email' => $this->input->post('assistant_email'), 
					'assistant_password' => $this->input->post('assistant_password'), 
					'asistant_ip_address' => $this->input->post('asistant_ip_address'), 
					'assistant_login_ip' => $this->input->post('assistant_login_ip'), 
					'assistant_last_login' => $this->input->post('assistant_last_login'), 
					'assistant_password_resetcde' => $this->input->post('assistant_password_resetcde'), 
					'assistant_applied_by' => $this->input->post('assistant_applied_by'), 
					'assistant_approved' => $this->input->post('assistant_approved'), 
					'assistant_approved_by' => $this->input->post('assistant_approved_by'), 
					'assistant_status' => $this->input->post('assistant_status'), 
					'assistant_create_date' => $this->input->post('assistant_create_date'), 
					'assistant_user_type' => $this->input->post('assistant_user_type'),
				  );
						
		$assistant_sync_id = $this->input->post('assistant_sync_id');
		$this->Assistant_model->update_sync($assistant_sync_id, $params);
		
		$result = array('has_synced' => 'YES');
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function save()
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
		$phone_number = html_escape($this->input->post('phone'));
		
		$data = array(
					'assistant_phone' => $phone_number,
					'assistant_org_id' => html_escape($this->input->post('organization')),
					'assistant_org_centerid' => html_escape($this->input->post('center')),
					'assistant_full_name' => html_escape($this->input->post('full_name')),
					'assistant_address' => html_escape($this->input->post('address')),
					'assistant_division_id' => html_escape($this->input->post('division')),
					'assistant_district_id' => html_escape($this->input->post('district')),
					'assistant_upazila_id' => html_escape($this->input->post('upazila')),
					'assistant_postal_code' => html_escape($this->input->post('postal_code')),
					'assistant_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'assistant_email' => html_escape($this->input->post('email')),
					'assistant_password' => sha1(html_escape($this->input->post('password'))),
					'assistant_status' => $this->input->post('status'),
					'assistant_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_doctor_assistants.assistant_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_doctor_assistants.assistant_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$get_id = $this->Assistant_model->create($data);
			$assistant_id = $this->db->insert_id($get_id);
			
			//create directory for the student
			$dirpath = attachment_dir()."assistants/".$assistant_id;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Doctor assistant has been successfully registered!</div>';
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
		$id = $this->input->post('id');
		
		$phone_number = html_escape($this->input->post('phone'));
		$check_email = $this->Assistant_model->check_email(html_escape($this->input->post('email')));
		$check_phone = $this->Assistant_model->check_phone($phone_number);
		
		$data = array(
					'assistant_phone' => $phone_number,
					'assistant_org_id' => html_escape($this->input->post('organization')),
					'assistant_org_centerid' => html_escape($this->input->post('center')),
					'assistant_full_name' => html_escape($this->input->post('full_name')),
					'assistant_address' => html_escape($this->input->post('address')),
					'assistant_division_id' => html_escape($this->input->post('division')),
					'assistant_district_id' => html_escape($this->input->post('district')),
					'assistant_upazila_id' => html_escape($this->input->post('upazila')),
					'assistant_postal_code' => html_escape($this->input->post('postal_code')),
					'assistant_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'assistant_email' => html_escape($this->input->post('email')),
					'assistant_status' => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),
					);
		if($check_email == true && $check_email['assistant_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($check_phone == true && $check_phone['assistant_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The phone number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			$this->Assistant_model->update($id, $data);
			
			$success_alert = '<div class="alert alert-success" role="alert">Doctor assistant has been successfully updated!</div>';
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
	
	public function sync_delete()
	{
		$this->active_center = $this->input->post('active_center');
		$local_app_centers = $this->Common_model->get_local_app_centers();
		if(!in_array($this->active_center, $local_app_centers))
		{
			$result = array('status' => 'error', 'content' => 'This api is to be used in registered centers!');
			echo json_encode($result);
			exit;
		}
		
		$sync_id = $this->input->post('assistant_sync_id');
		
		//Delete coordinator
		$this->db->where('assistant_sync_id', $sync_id);
		$this->db->delete('starter_doctor_assistants');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function change_password()
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
		
		$admin_id = $this->input->post('admin');
		$update_pass = array(
							'assistant_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('assistant_id', $admin_id);
		$this->db->update('starter_doctor_assistants', $update_pass);
		$result = array('status' => 'ok');
		echo json_encode($result);
		exit;
	}
	
}
