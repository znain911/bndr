<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	
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
	  
	  $this->load->model('Report_model');
	  $this->load->model('Organization_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function all()
	{
		//total rows count
		$totalRec = count($this->Report_model->get_all_visits());
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_reports';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$data['items'] = $this->Report_model->get_all_visits(array('limit'=>$this->perPage));
		$this->load->view('reports', $data);
	}
	
	public function cntrpatients()
	{
		$this->load->view('cntrpatients');
	}
	
	public function cntrdoctors()
	{
		$this->load->view('cntrdoctors');
	}
	
	public function visits()
	{
		$this->load->view('visits');
	}
	
	public function get_centerwise_patients()
	{
		$org_id = $this->input->post('organization');
		$center_id = $this->input->post('center');
		$data['org_id'] = $org_id;
		$data['center_id'] = $center_id;
		$content = $this->load->view('center_wise_patients', $data, true);
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_centerwise_doctors()
	{
		$org_id = $this->input->post('organization');
		$center_id = $this->input->post('center');
		$data['org_id'] = $org_id;
		$data['center_id'] = $center_id;
		$content = $this->load->view('get_centerwise_doctors', $data, true);
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function get_centerwise_visits()
	{
		$org_id = $this->input->post('organization');
		$center_id = $this->input->post('center');
		$data['org_id'] = $org_id;
		$data['center_id'] = $center_id;
		$content = $this->load->view('get_centerwise_visits', $data, true);
		$result = array("status" => "ok", "content" => $content);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function expexcel()
	{
		$date = date('d-m-Y');
        $file = 'Reports_'.$date.'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        $data['items'] = $this->Report_model->get_all_visits();      
        $this->load->view('export/report_export_to_excel', $data);
	}
	
	public function limitreport()
	{
		exit;
	}
	
}
