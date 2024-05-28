<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orgreports extends CI_Controller {
	
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
	  
	  $this->load->model('Nestedreports_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function index()
	{
		//total rows count
		$totalRec = $this->Nestedreports_model->count_org_centers();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'ajaxapiv1/get_all_centers';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Nestedreports_model->get_org_centers(array('limit'=>$this->perPage));
		$this->load->view('centers', $data);
	}
	
	public function operators()
	{
		$center = $_GET['CENTER'];
		if(isset($center) && is_numeric($center))
		{
			//total rows count
			$totalRec = $this->Nestedreports_model->count_center_operators($center);
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'ajaxapiv1/get_all_centers';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Nestedreports_model->get_center_operators(array('limit'=>$this->perPage, 'center' => $center));
			$data['center'] = $center;
			$this->load->view('operators', $data);
		}else{
			redirect('not-found', 'refresh', true);
		}
	}
	
	public function patients()
	{
		$center = $_GET['CENTER'];
		$operator = $_GET['OPERATOR'];
		if(isset($center) && is_numeric($center) && isset($operator) && is_numeric($operator))
		{
			//total rows count
			$totalRec = $this->Nestedreports_model->count_operator_patients($center, $operator);
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'ajaxapiv1/get_all_centers';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Nestedreports_model->get_operator_patients(array('limit'=>$this->perPage, 'center' => $center, 'operator' => $operator));
			$data['center'] = $center;
			$data['operator'] = $operator;
			$this->load->view('patients', $data);
		}else{
			redirect('not-found', 'refresh', true);
		}
	}
	
	public function visits()
	{
		$center = $_GET['CENTER'];
		$patient = $_GET['PATIENT'];
		if(isset($center) && is_numeric($center) && isset($patient) && is_numeric($patient))
		{
			//total rows count
			$totalRec = $this->Nestedreports_model->count_patient_visits($patient, $center);
			
			//pagination configuration
			$config['target']      = '#postList';
			$config['base_url']    = base_url().'ajaxapiv1/get_all_centers';
			$config['total_rows']  = $totalRec;
			$config['per_page']    = $this->perPage;
			$config['link_func']   = 'searchFilter';
			$this->ajax_pagination->initialize($config);
			
			//get the posts data
			$data['items'] = $this->Nestedreports_model->get_patient_visits(array('limit'=>$this->perPage, 'patient' => $patient, 'center' => $center));
			$data['patient'] = $patient;
			$data['center'] = $center;
			$this->load->view('visits', $data);
		}else{
			redirect('not-found', 'refresh', true);
		}
	}
	
}
