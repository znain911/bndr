<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finance extends CI_Controller {
	
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
	  
	  $this->load->model('Finance_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function index()
	{
		//total rows count
		$totalRec = $this->Finance_model->count_total_records_of_orgs();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'financeapi/get_all_payments';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Finance_model->get_total_records_of_orgs(array('limit'=>$this->perPage));
		$this->load->view('finance_view_all', $data);
	}
	
	public function shw($param=null)
	{
		if(!is_null($param))
		{
			if(isset($param) && $param === 'todays')
			{
				//total rows count
				$totalRec = $this->Finance_model->count_total_records_of_orgs();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'financeapi/get_todays_payments';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Finance_model->get_total_records_of_orgs(array('limit'=>$this->perPage));
				$this->load->view('finance_view_today', $data);
			
			}elseif(isset($param) && $param === 'all'){
				//total rows count
				$totalRec = $this->Finance_model->count_total_records_of_orgs();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'financeapi/get_all_payments';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Finance_model->get_total_records_of_orgs(array('limit'=>$this->perPage));
				$this->load->view('finance_view_all', $data);
				
			}elseif(isset($param) && $param === 'paids'){
				
				//total rows count
				$totalRec = $this->Finance_model->count_total_records_of_orgs();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'financeapi/get_all_paids';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Finance_model->get_total_records_of_orgs(array('limit'=>$this->perPage));
				$this->load->view('finance_view_paids', $data);
				
			}elseif(isset($param) && $param === 'unpaids'){
				
				//total rows count
				$totalRec = $this->Finance_model->count_total_records_of_orgs();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'financeapi/get_all_unpaids';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Finance_model->get_total_records_of_orgs(array('limit'=>$this->perPage));
				$this->load->view('finance_view_unpaids', $data);
			}
		}
	}
	
	public function download()
	{
		$param = $_GET['RPTYPE'];
		if(isset($param) && $param == 'TODAY'){
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['items'] = $this->Finance_model->get_total_records_of_orgs_toexcel();      
			$this->load->view('download/excel_report_today', $data);
			
		}elseif(isset($param) && $param == 'ALL'){
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['items'] = $this->Finance_model->get_total_records_of_orgs_toexcel();      
			$this->load->view('download/excel_report_all', $data);
			
		}elseif(isset($param) && $param == 'PAID'){
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['items'] = $this->Finance_model->get_total_records_of_orgs_toexcel();       
			$this->load->view('download/excel_report_paid', $data);
			
		}elseif(isset($param) && $param == 'UNPAID'){
			
			$date = date('d-m-Y');
			$file = 'Finance_Report_'.$date.'.xls';
			header("Content-type: application/vnd.ms-excel");
			header("Content-Disposition: attachment; filename=$file");
			$data['items'] = $this->Finance_model->get_total_records_of_orgs_toexcel();      
			$this->load->view('download/excel_report_unpaid', $data);
			
		}else{
			redirect('not-found', 'refresh', true);
		}
	}
	
	public function get_org_by_keywords()
	{
		$term = html_escape($this->input->get('q'));
		$get_datas = $this->Finance_model->get_orgs_by_keywords($term);
		$content = array();
		foreach($get_datas as $data):
			$content[] = array("label" => $data['org_name'], "value" => intval($data['org_id']));
		endforeach;
		echo json_encode(array('content' => $content));
		exit;
	}
	
}
