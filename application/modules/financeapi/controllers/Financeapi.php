<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financeapi extends CI_Controller {
	
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
	  
	  $check_permission = $this->Perm_model->check_permissionby_admin($this->session->userdata('active_user'), 8);
	  if($this->session->userdata('user_type') === 'Administrator' && $check_permission != true){
		  redirect('not-found', 'refresh', true);
	  }
	  
	  $this->perPage = 10;
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Financeapi_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function get_todays_payments()
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
		$year = $this->input->post('year');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		//total rows count
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
			$totalRec = $this->Financeapi_model->count_total_records_of_center($conditions);
		
		}else {
			$totalRec = $this->Financeapi_model->count_total_records_of_orgs($conditions);
		}
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'financeapi/get_todays_payments';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
		$data['items'] = $this->Financeapi_model->get_total_records_of_center($conditions);
		}else{
		$data['items'] = $this->Financeapi_model->get_total_records_of_orgs($conditions);
		}
		$data['sl'] = $page;
		$data['keywords'] = $keywords;
		$content = $this->load->view('finance_view_today', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_payments()
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
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		//total rows count
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
			$totalRec = $this->Financeapi_model->count_total_records_of_center($conditions);
		
		}else {
			$totalRec = $this->Financeapi_model->count_total_records_of_orgs($conditions);
		}
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'financeapi/get_all_payments';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
		$data['items'] = $this->Financeapi_model->get_total_records_of_center($conditions);
		}else{
		$data['items'] = $this->Financeapi_model->get_total_records_of_orgs($conditions);
		}
		$data['sl'] = $page;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['keywords'] = $keywords;
		if($month == 'All'){
			$content = $this->load->view('finance_view_all', $data, true);
		}else{
			$content = $this->load->view('finance_view_all_daily', $data, true);
		}
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_paids()
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
		$year = $this->input->post('year');
		$month = $this->input->post('month');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		
		//total rows count
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
			$totalRec = $this->Financeapi_model->count_total_records_of_center($conditions);
		
		}else {
			$totalRec = $this->Financeapi_model->count_total_records_of_orgs($conditions);
		}
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'financeapi/get_all_paids';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
		$data['items'] = $this->Financeapi_model->get_total_records_of_center($conditions);
		}else{
		$data['items'] = $this->Financeapi_model->get_total_records_of_orgs($conditions);
		}
		$data['sl'] = $page;
		$data['year'] = $year;
		$data['month'] = $month;
		$data['keywords'] = $keywords;
		if($month == 'All'){
			$content = $this->load->view('finance_view_paids', $data, true);
		}else{
			$content = $this->load->view('finance_view_paids_daily', $data, true);
		}
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_unpaids()
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
		$year = $this->input->post('year');
		$month = $this->input->post('month');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		
		//total rows count
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
			$totalRec = $this->Financeapi_model->count_total_records_of_center($conditions);
		
		}else {
			$totalRec = $this->Financeapi_model->count_total_records_of_orgs($conditions);
		}
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'financeapi/get_all_unpaids';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
		$data['items'] = $this->Financeapi_model->get_total_records_of_center($conditions);
		}else{
		$data['items'] = $this->Financeapi_model->get_total_records_of_orgs($conditions);
		}
		$data['sl'] = $page;
		$data['month'] = $month;
		$data['year'] = $year;
		$data['keywords'] = $keywords;
		if($month == 'All'){
			$content = $this->load->view('finance_view_unpaids', $data, true);
		}else{
			$content = $this->load->view('finance_view_unpaids_daily', $data, true);
		}
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function download()
	{
		$param = $_GET['RPTYPE'];
		if(isset($param) && $param == 'TODAY'){
			
			//set conditions for search
			$conditions = array();
			$keywords = $_GET['keywords'];
			if(isset($keywords) && $keywords !== ''){
				$conditions['search']['keywords'] = html_escape($keywords);
			}
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				$data['items'] = $this->Financeapi_model->get_total_records_of_visit_excelreport($conditions);
				$data['keywords'] = $keywords;
				
			}else {
			$data['items'] = $this->Financeapi_model->get_total_records_of_orgs_excelreport($conditions); 
			}
			$this->load->view('download/excel_report_today', $data);
			
		}elseif(isset($param) && $param == 'ALL'){
			
			//set conditions for search
			$conditions = array();
			$keywords = $_GET['keywords'];
			$year     = $_GET['year'];
			$month    = $_GET['month'];
			if(isset($keywords) && $keywords !== ''){
				$conditions['search']['keywords'] = html_escape($keywords);
			}
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				$data['items'] = $this->Financeapi_model->get_total_records_of_visit_excelreport($conditions);
				$data['keywords'] = $keywords;
			}else {
			$data['items'] = $this->Financeapi_model->get_total_records_of_orgs_excelreport($conditions); 
			}
			$data['year']  = $year;
			$data['month'] = $month;
			if($month == 'All'){
				$this->load->view('download/excel_report_all', $data);
			}else{
				$this->load->view('download/daily/excel_report_all_daily', $data);
			}
			
		}elseif(isset($param) && $param == 'PAID'){
			//set conditions for search
			$conditions = array();
			$keywords = $_GET['keywords'];
			$year     = $_GET['year'];
			$month    = $_GET['month'];
			if(isset($keywords) && $keywords !== ''){
				$conditions['search']['keywords'] = html_escape($keywords);
			}
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				$data['items'] = $this->Financeapi_model->get_total_records_of_visit_excelreport($conditions);
				$data['keywords'] = $keywords;
			}else {
			$data['items'] = $this->Financeapi_model->get_total_records_of_orgs_excelreport($conditions); 
			}
			$data['year']  = $year;
			$data['month'] = $month;
			if($month == 'All'){
				$this->load->view('download/excel_report_paid', $data);
			}else{
				$this->load->view('download/daily/excel_report_paid_daily', $data);
			}
			
		}elseif(isset($param) && $param == 'UNPAID'){
			//set conditions for search
			$conditions = array();
			$keywords = $_GET['keywords'];
			$year     = $_GET['year'];
			$month    = $_GET['month'];
			if(isset($keywords) && $keywords !== ''){
				$conditions['search']['keywords'] = html_escape($keywords);
			}
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			if($keywords && $this->session->userdata('user_type') === 'Org Admin') {
				$data['items'] = $this->Financeapi_model->get_total_records_of_visit_excelreport($conditions);
				$data['keywords'] = $keywords;
			}else {
				$data['items'] = $this->Financeapi_model->get_total_records_of_orgs_excelreport($conditions); 
			}
			$data['year']  = $year;
			$data['month'] = $month;
			if($month == 'All'){
				$this->load->view('download/excel_report_unpaid', $data);
			}else{
				$this->load->view('download/daily/excel_report_unpaid_daily', $data);
			}
			
		}else{
			redirect('not-found', 'refresh', true);
		}
	}
	
	
}
