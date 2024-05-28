<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditure extends CI_Controller {
	
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
	  
	  $this->load->model('Expenditure_model');
	}
	
	public function index()
	{
		$this->load->view('expenditure/expenditures');
	}
	
	public function create()
	{
		$this->load->view('expenditure/create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(
					'expenditure_title'       => html_escape($this->input->post('title')),
					'expenditure_created_by'  => $this->session->userdata('active_user'),
					'expenditure_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Monthly Expenditure', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Expenditure_model->create($data);
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
		$this->load->view('expenditure/edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'expenditure_title'       => html_escape($this->input->post('title')),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Monthly Expenditure', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Expenditure_model->update($id, $data);
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
		$this->db->where('expenditure_id', $id);
		$this->db->delete('starter_monthly_expenditures');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
