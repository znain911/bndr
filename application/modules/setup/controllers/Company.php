<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  $this->perPage = 15;
	  $active_user = $this->session->userdata('active_user');
	  $userLogin = $this->session->userdata('userLogin');
	  if($active_user === NULL && $userLogin !== TRUE)
	  {
		redirect('login', 'refresh', true);
	  }
	  
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	   $this->load->library('ajax_pagination');
	  $this->load->model('Company_model');
	}
	
	public function index()
	{
		//total rows count
		$totalRec = $this->Company_model->count_all_items();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_companies';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Company_model->get_all_items(array('limit'=>$this->perPage));
		$this->load->view('company/companies', $data);
	}
	
	public function create()
	{
		$this->load->view('company/create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(
					'company_name'       => html_escape($this->input->post('company')),
					'company_type'          => html_escape($this->input->post('type')),
					'company_create_date' => date("Y-m-d H:i:s"),
					'company_created_by'  => $this->session->userdata('active_user'),
					'company_created_by_user_type'  => $this->session->userdata('user_type'),
					'company_status'  => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'company', 
							'label' => 'Company', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'type', 
							'label' => 'Type', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Company_model->create($data);
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
		$this->load->view('company/edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'company_name'       => html_escape($this->input->post('company')),
					'company_type'          => html_escape($this->input->post('type')),
					'company_status'  => $this->input->post('status'),
				);
		$validate = array(
						array(
							'field' => 'company', 
							'label' => 'Company', 
							'rules' => 'required|trim', 
						),
						array(
							'field' => 'type', 
							'label' => 'Type', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Company_model->update($id, $data);
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
		$this->db->where('company_id', $id);
		$this->db->delete('starter_pharmaceuticals');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
