<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drugs extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	private $perPage;
	
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
	  $this->perPage = 15;
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  $this->load->library('ajax_pagination');
	  $this->load->model('Drugs_model');
	}
	
	public function index()
	{
		//total rows count
		$totalRec = $this->Drugs_model->count_all_items();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_drugs';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Drugs_model->get_all_items(array('limit'=>$this->perPage));
		$this->load->view('drug/drugs', $data);
	}
	
	public function create()
	{
		$this->load->view('drug/create');
	}
	
	public function save()
	{
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
	
	public function edit($id)
	{
		$data['id'] = intval($id);
		$this->load->view('drug/edit', $data);
	}
	
	public function update()
	{
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
