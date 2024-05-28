<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organizations extends CI_Controller {
	
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
	  $this->perPage = 15;
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Organization_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function index()
	{	
		//total rows count
		$totalRec = $this->Organization_model->count_all_items();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_organaizations';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Organization_model->get_all_items(array('limit'=>$this->perPage));
		$this->load->view('organizations', $data);
	}
	
	public function create()
	{
		$this->load->view('create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(
					'org_name'        => html_escape($this->input->post('name')),
					'org_division_id' => html_escape($this->input->post('division')),
					'org_district_id' => html_escape($this->input->post('district')),
					'org_upazila_id'  => html_escape($this->input->post('upazila')),
					'org_create_date' => date("Y-m-d H:i:s"),
					'org_applied_by'  => $this->session->userdata('active_user'),
				);
		$validate = array(
						array(
							'field' => 'name', 
							'label' => 'Organization name', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$get_insert_id = $this->Organization_model->create($data);
			$org_id = $this->db->insert_id($get_insert_id);
			
			//Save Org Code
			$org_code = 'ORG'.str_pad($org_id, 3, '0', STR_PAD_LEFT);
			$this->Organization_model->update($org_id, array('org_code' => $org_code));
			
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
		$this->load->view('edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		$data = array(
					'org_name'        => html_escape($this->input->post('name')),
					'org_code'        => html_escape($this->input->post('org_code')),
					'org_division_id' => html_escape($this->input->post('division')),
					'org_district_id' => html_escape($this->input->post('district')),
					'org_upazila_id'  => html_escape($this->input->post('upazila')),
				);
		$validate = array(
						array(
							'field' => 'org_code', 
							'label' => 'Organization Code', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules($validate);
		if($this->form_validation->run() == true)
		{
			//save
			$this->Organization_model->update($id, $data);
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
		$this->db->where('org_id', $id);
		$this->db->delete('starter_organizations');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
}
