<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctors extends CI_Controller {
	
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
	  
	  $this->load->model('doctors/Doctor_model', 'Doctor_model', true);
	  $this->load->model('doctors/Organization_model', 'Organization_model', true);
	  $this->load->model('Common_model');
	}
	
	public function sync()
	{
		$params = array(
							'doctor_phone'            => $this->input->post('doctor_phone'),
							'doctor_org_id'           => $this->input->post('doctor_org_id'),
							'doctor_org_centerid'     => $this->input->post('doctor_org_centerid'),
							'doctor_full_name'        => $this->input->post('doctor_full_name'),
							'doctor_address'          => $this->input->post('doctor_address'),
							'doctor_division_id'      => $this->input->post('doctor_division_id'),
							'doctor_district_id'      => $this->input->post('doctor_district_id'),
							'doctor_upazila_id'       => $this->input->post('doctor_upazila_id'),
							'doctor_postal_code'      => $this->input->post('doctor_postal_code'),
							'doctor_bmdc_no'          => $this->input->post('doctor_bmdc_no'),
							'doctor_dateof_birth'     => $this->input->post('doctor_dateof_birth'),
							'doctor_username'         => $this->input->post('doctor_username'),
							'doctor_email'            => $this->input->post('doctor_email'),
							'doctor_password'         => $this->input->post('doctor_password'),
							'doctor_ip_address'       => $this->input->post('doctor_ip_address'),
							'doctor_login_ip'         => $this->input->post('doctor_login_ip'),
							'doctor_last_login'       => $this->input->post('doctor_last_login'),
							'doctor_password_resetcde'=> $this->input->post('doctor_password_resetcde'),
							'doctor_applied_by'       => $this->input->post('doctor_applied_by'),
							'doctor_approved_by'      => $this->input->post('doctor_approved_by'),
							'doctor_status'           => $this->input->post('doctor_status'),
							'doctor_create_date'      => $this->input->post('doctor_create_date'),
							'doctor_user_type'        => $this->input->post('doctor_user_type'),
							'doctor_sync_id'          => $this->input->post('doctor_sync_id'),
						);
						
		$get_id = $this->Doctor_model->create($params);
		$doctor_id = $this->db->insert_id($get_id);
		
		//create directory for the student
		$dirpath = attachment_dir()."doctors/".$doctor_id;
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
							'doctor_phone'            => $this->input->post('doctor_phone'),
							'doctor_org_id'           => $this->input->post('doctor_org_id'),
							'doctor_org_centerid'     => $this->input->post('doctor_org_centerid'),
							'doctor_full_name'        => $this->input->post('doctor_full_name'),
							'doctor_address'          => $this->input->post('doctor_address'),
							'doctor_division_id'      => $this->input->post('doctor_division_id'),
							'doctor_district_id'      => $this->input->post('doctor_district_id'),
							'doctor_upazila_id'       => $this->input->post('doctor_upazila_id'),
							'doctor_postal_code'      => $this->input->post('doctor_postal_code'),
							'doctor_bmdc_no'          => $this->input->post('doctor_bmdc_no'),
							'doctor_dateof_birth'     => $this->input->post('doctor_dateof_birth'),
							'doctor_username'         => $this->input->post('doctor_username'),
							'doctor_email'            => $this->input->post('doctor_email'),
							'doctor_password'         => $this->input->post('doctor_password'),
							'doctor_ip_address'       => $this->input->post('doctor_ip_address'),
							'doctor_login_ip'         => $this->input->post('doctor_login_ip'),
							'doctor_last_login'       => $this->input->post('doctor_last_login'),
							'doctor_password_resetcde'=> $this->input->post('doctor_password_resetcde'),
							'doctor_applied_by'       => $this->input->post('doctor_applied_by'),
							'doctor_approved_by'      => $this->input->post('doctor_approved_by'),
							'doctor_status'           => $this->input->post('doctor_status'),
							'doctor_create_date'      => $this->input->post('doctor_create_date'),
							'doctor_user_type'        => $this->input->post('doctor_user_type'),
						);
						
		$doctor_sync_id = $this->input->post('doctor_sync_id');
		$this->Doctor_model->update_sync($doctor_sync_id, $params);
		
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
					'doctor_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'doctor_email' => html_escape($this->input->post('email')),
					'doctor_password' => sha1(html_escape($this->input->post('password'))),
					'doctor_status' => $this->input->post('status'),
					'doctor_create_date' => date("Y-m-d H:i:s"),
				);
		$this->form_validation->set_rules('email', 'Email Address', 'required|trim|is_unique[starter_doctors.doctor_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_doctors.doctor_phone]', array('is_unique' => 'The phone number is already exist!'));
		if($this->form_validation->run() == true)
		{
			$get_id = $this->Doctor_model->create($data);
			$doctor_id = $this->db->insert_id($get_id);
			
			//create directory for the student
			$dirpath = attachment_dir()."doctors/".$doctor_id;
			if(file_exists($dirpath))
			{
				echo null;
			}else
			{
				mkdir($dirpath);
			}
			
			$success_alert = '<div class="alert alert-success" role="alert">Doctor has been successfully registered!</div>';
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
		$check_email = $this->Doctor_model->check_email(html_escape($this->input->post('email')));
		$check_phone = $this->Doctor_model->check_phone($phone_number);
		$data = array(
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
					'doctor_dateof_birth' => db_formated_date(html_escape($this->input->post('dateof_birth'))),
					'doctor_email' => html_escape($this->input->post('email')),
					'doctor_status' => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'full_name',
							'label' => 'Full Name',
							'rules' => 'required|trim',
						),
					);
		if($check_email == true && $check_email['doctor_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		if($check_phone == true && $check_phone['doctor_id'] !== $id)
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
			$this->Doctor_model->update($id, $data);
			
			$success_alert = '<div class="alert alert-success" role="alert">Doctor has been successfully updated!</div>';
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
		
		$sync_id = $this->input->post('doctor_sync_id');
		
		//Delete coordinator
		$this->db->where('doctor_sync_id', $sync_id);
		$this->db->delete('starter_doctors');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
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
		
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('doctor_id', $id);
		$this->db->delete('starter_doctors');
		
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
							'doctor_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('doctor_id', $admin_id);
		$this->db->update('starter_doctors', $update_pass);
		$result = array('status' => 'ok');
		echo json_encode($result);
		exit;
	}
	
}
