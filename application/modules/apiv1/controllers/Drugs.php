<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drugs extends CI_Controller {
	
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
	  
	  $this->load->model('setup/Drugs_model', 'Drugs_model', true);
	  $this->load->model('Common_model');
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
		$data = array(
					'company'    => html_escape($this->input->post('company_id')),
					'brand'      => html_escape($this->input->post('brand')),
					'generic'    => html_escape($this->input->post('generic')),
					'strength'   => html_escape($this->input->post('strength')),
					'dosages'    => html_escape($this->input->post('dosages')),
					'used_for'   => 'Human',
					'DAR'        => html_escape($this->input->post('dar')),
					'Type'       => 'Allopathic',
				);
		$validate = array(
						array(
							'field' => 'company_id', 
							'label' => 'Company', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Drugs_model->create($data);
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
		$data = array(
					'company'    => html_escape($this->input->post('company_id')),
					'brand'      => html_escape($this->input->post('brand')),
					'generic'    => html_escape($this->input->post('generic')),
					'strength'   => html_escape($this->input->post('strength')),
					'dosages'    => html_escape($this->input->post('dosages')),
					'used_for'   => 'Human',
					'DAR'        => html_escape($this->input->post('dar')),
					'Type'       => 'Allopathic',
				);
		$validate = array(
						array(
							'field' => 'company_id', 
							'label' => 'Company', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Drugs_model->update($id, $data);
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
		$this->db->where('id', $id);
		$this->db->delete('starter_dgds');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
