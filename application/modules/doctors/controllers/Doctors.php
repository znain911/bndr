<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doctors extends CI_Controller {
	
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
	  
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Doctor_model');
	  $this->load->model('Organization_model');
	}
	
	public function index()
	{
		$this->load->view('doctors');
	}
	
	public function create()
	{
		$this->load->view('create');
	}
	
	public function save()
	{
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
	
	public function edit($id)
	{
		$data['id'] = intval($id);
		$this->load->view('edit', $data);
	}
	
	public function update()
	{
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
	
	public function delete()
	{
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
