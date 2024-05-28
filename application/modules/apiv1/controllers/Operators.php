<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operators extends CI_Controller {
	
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
	  
	  $this->load->model('operators/Operator_model', 'Operator_model', true);
	  $this->load->model('operators/Organization_model', 'Organization_model', true);
	  $this->load->model('Common_model');
	}
	
	public function sync()
	{
		$params = array(
				'operator_phone' => $this->input->post('operator_phone'), 
				'operator_dateof_birth' => $this->input->post('operator_dateof_birth'), 
				'operator_org_id' => $this->input->post('operator_org_id'), 
				'operator_org_centerid' => $this->input->post('operator_org_centerid'), 
				'operator_full_name' => $this->input->post('operator_full_name'), 
				'operator_address' => $this->input->post('operator_address'), 
				'operator_division_id' => $this->input->post('operator_division_id'), 
				'operator_district_id' => $this->input->post('operator_district_id'), 
				'operator_upazila_id' => $this->input->post('operator_upazila_id'), 
				'operator_postal_code' => $this->input->post('operator_postal_code'), 
				'operator_email' => $this->input->post('operator_email'), 
				'operator_password' => $this->input->post('operator_password'), 
				'operator_ip_address' => $this->input->post('operator_ip_address'), 
				'operator_login_ip' => $this->input->post('operator_login_ip'), 
				'operator_last_login' => $this->input->post('operator_last_login'), 
				'operator_password_resetcde' => $this->input->post('operator_password_resetcde'), 
				'operator_applied_by' => $this->input->post('operator_applied_by'), 
				'operator_approved_by' => $this->input->post('operator_approved_by'), 
				'operator_status' => $this->input->post('operator_status'), 
				'operator_user_type' => $this->input->post('operator_user_type'), 
				'operator_create_date' => $this->input->post('operator_create_date'),
				'operator_sync_id'   => $this->input->post('operator_sync_id'),
			  );
						
		$get_id = $this->Operator_model->create($params);
		$operator_id = $this->db->insert_id($get_id);
		
		//create directory for the student
		$dirpath = attachment_dir()."operators/".$operator_id;
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
				'operator_phone' => $this->input->post('operator_phone'), 
				'operator_dateof_birth' => $this->input->post('operator_dateof_birth'), 
				'operator_org_id' => $this->input->post('operator_org_id'), 
				'operator_org_centerid' => $this->input->post('operator_org_centerid'), 
				'operator_full_name' => $this->input->post('operator_full_name'), 
				'operator_address' => $this->input->post('operator_address'), 
				'operator_division_id' => $this->input->post('operator_division_id'), 
				'operator_district_id' => $this->input->post('operator_district_id'), 
				'operator_upazila_id' => $this->input->post('operator_upazila_id'), 
				'operator_postal_code' => $this->input->post('operator_postal_code'), 
				'operator_email' => $this->input->post('operator_email'), 
				'operator_password' => $this->input->post('operator_password'), 
				'operator_ip_address' => $this->input->post('operator_ip_address'), 
				'operator_login_ip' => $this->input->post('operator_login_ip'), 
				'operator_last_login' => $this->input->post('operator_last_login'), 
				'operator_password_resetcde' => $this->input->post('operator_password_resetcde'), 
				'operator_applied_by' => $this->input->post('operator_applied_by'), 
				'operator_approved_by' => $this->input->post('operator_approved_by'), 
				'operator_status' => $this->input->post('operator_status'), 
				'operator_user_type' => $this->input->post('operator_user_type'), 
				'operator_create_date' => $this->input->post('operator_create_date'),
			  );
						 
		$operator_sync_id = $this->input->post('operator_sync_id');
		$this->Operator_model->update_sync($operator_sync_id, $params);
		
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
					'operator_phone' => $phone_number,
					'operator_org_id' => html_escape($this->input->post('organization')),
					'operator_org_centerid' => html_escape($this->input->post('center')),
					'operator_full_name' => html_escape($this->input->post('full_name')),
					'operator_address' => html_escape($this->input->post('address')),
					'operator_division_id' => html_escape($this->input->post('division')),
					'operator_district_id' => html_escape($this->input->post('district')),
					'operator_upazila_id' => html_escape($this->input->post('upazila')),
					'operator_postal_code' => html_escape($this->input->post('postal_code')),
					'operator_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'operator_email' => html_escape($this->input->post('email')),
					'operator_password' => sha1(html_escape($this->input->post('password'))),
					'operator_status' => $this->input->post('status'),
					'operator_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_operators.operator_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_operators.operator_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$get_id = $this->Operator_model->create($data);
			$operator_id = $this->db->insert_id($get_id);
			
			//create directory for the student
			$dirpath = attachment_dir()."operators/".$operator_id;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Data-entry operator has been successfully registered!</div>';
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
		$check_email = $this->Operator_model->check_email(html_escape($this->input->post('email')));
		$check_phone = $this->Operator_model->check_phone($phone_number);
		
		$data = array(
					'operator_phone' => $phone_number,
					'operator_org_id' => html_escape($this->input->post('organization')),
					'operator_org_centerid' => html_escape($this->input->post('center')),
					'operator_full_name' => html_escape($this->input->post('full_name')),
					'operator_address' => html_escape($this->input->post('address')),
					'operator_division_id' => html_escape($this->input->post('division')),
					'operator_district_id' => html_escape($this->input->post('district')),
					'operator_upazila_id' => html_escape($this->input->post('upazila')),
					'operator_postal_code' => html_escape($this->input->post('postal_code')),
					'operator_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'operator_email' => html_escape($this->input->post('email')),
					'operator_status' => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),
					);
		if($check_email == true && $check_email['operator_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($check_phone == true && $check_phone['operator_id'] !== $id)
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
			$this->Operator_model->update($id, $data);
			$success_alert = '<div class="alert alert-success" role="alert">Data-entry operator has been successfully updated!</div>';
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
		
		$sync_id = $this->input->post('operator_sync_id');
		
		//Delete coordinator
		$this->db->where('operator_sync_id', $sync_id);
		$this->db->delete('starter_operators');
		
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
							'operator_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('operator_id', $admin_id);
		$this->db->update('starter_operators', $update_pass);
		$result = array('status' => 'ok');
		echo json_encode($result);
		exit;
	}
	
}
