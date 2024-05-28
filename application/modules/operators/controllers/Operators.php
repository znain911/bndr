<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operators extends CI_Controller {
	
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
	  $this->load->model('Operator_model');
	  $this->load->model('Organization_model');
	}
	
	public function index()
	{
		$this->load->view('operators');
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
	
	public function delete()
	{
		$id = $this->input->post('id');
		
		//Delete coordinator
		$this->db->where('operator_id', $id);
		$this->db->delete('starter_operators');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function change_password()
	{
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
