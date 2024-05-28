<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Centers extends CI_Controller {
	
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
	  
	  $this->load->model('Centers_model');
	}
	
	public function index()
	{
		$this->load->view('localapps/app_centers');
	}
	
	public function create()
	{
		$this->load->view('localapps/create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(
					'api_app_org_id'       => html_escape($this->input->post('organization')),
					'api_app_center_id'    => html_escape($this->input->post('center')),
					'api_app_create_date'  => date("Y-m-d H:i:s"),
					'api_app_is_active'    => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'organization', 
							'label' => 'Organization', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Centers_model->create($data);
			$success = '<div class="alert alert-success">Successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
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
		$this->load->view('localapps/edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'api_app_org_id'       => html_escape($this->input->post('organization')),
					'api_app_center_id'    => html_escape($this->input->post('center')),
					'api_app_is_active'    => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'organization', 
							'label' => 'Organization', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Centers_model->update($id, $data);
			$success = '<div class="alert alert-success">Successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
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
		
		//Delete coordinator
		$this->db->where('role_id', $id);
		$this->db->delete('starter_admin_role');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
