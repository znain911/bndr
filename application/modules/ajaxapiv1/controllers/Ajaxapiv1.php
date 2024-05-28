<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxapiv1 extends CI_Controller {
	
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
	  
	  $this->load->model('Dashboard_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function get_all_patients()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		$center = $this->input->post('center');
		$operator = $this->input->post('operator');
		$conditions['search']['center'] = $center;
		$conditions['search']['operator'] = $operator;
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_items($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'ajaxapiv1/get_all_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_items($conditions);
		$data['center'] = $center;
		$data['sl'] = $page;
		$content = $this->load->view('patients', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_patient_visits()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby   = $this->input->post('sortby');
		$year     = $this->input->post('year');
		$month    = $this->input->post('month');
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$patient = $this->input->post('patient');
		$center = $this->input->post('center');
		$conditions['patient'] = $patient;
		$conditions['center'] = $center;
		
		if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($month && $month !== 'All'){
			$conditions['search']['month'] = $month;
		}
		if($year){
			$conditions['search']['year'] = $year;
		}
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_visits($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'ajaxapiv1/get_patient_visits';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_visits($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('visits', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_centers()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby   = $this->input->post('sortby');
		$year     = $this->input->post('year');
		$month    = $this->input->post('month');
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		
		if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($month && $month !== 'All'){
			$conditions['search']['month'] = $month;
			$data['month']     = $month;
		}else{
			$data['month']     = $month;
		}
		if($year){
			$conditions['search']['year'] = $year;
			$data['year']      = $year;
		}else{
			$data['year']      = $year;
		}
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
			$data['from_date'] = db_formated_date($from_date);
			$data['to_date']   = db_formated_date($to_date);
		}else{
			$data['from_date'] = null;
			$data['to_date']   = null;
		}
		
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_centers($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'ajaxapiv1/get_all_centers';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_centers($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('centers', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_operators()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby   = $this->input->post('sortby');
		$year     = $this->input->post('year');
		$month    = $this->input->post('month');
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		$center = $this->input->post('center');
		$conditions['search']['center'] = $center;
		
		if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		if($month && $month !== 'All'){
			$conditions['search']['month'] = $month;
			$data['month']     = $month;
		}else{
			$data['month']     = null;
		}
		if($year){
			$conditions['search']['year'] = $year;
			$data['year']      = $year;
		}else{
			$data['year']      = null;
		}
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
			$data['from_date'] = db_formated_date($from_date);
			$data['to_date']   = db_formated_date($to_date);
		}else{
			$data['from_date'] = null;
			$data['to_date']   = null;
		}
		
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_operators($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'ajaxapiv1/get_all_operators';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_operators($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('operators', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
}