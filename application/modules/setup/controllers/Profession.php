<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profession extends CI_Controller {
	
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
	  
	  $this->load->model('Profession_model');
	}
	
	public function index()
	{
		$this->load->view('profession/professions');
	}
	
	public function create()
	{
		$this->load->view('profession/create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(
					'profession_title'       => html_escape($this->input->post('title')),
					'profession_created_by'  => $this->session->userdata('active_user'),
					'profession_create_date' => date("Y-m-d H:i:s"),
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Profession', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Profession_model->create($data);
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
		$this->load->view('profession/edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'profession_title'       => html_escape($this->input->post('title')),  
				);
		$validate = array(
						array(
							'field' => 'title', 
							'label' => 'Profession', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Profession_model->update($id, $data);
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
		$this->db->where('profession_id', $id);
		$this->db->delete('starter_professions');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
