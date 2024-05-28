<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportapp extends CI_Controller {
	
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
	
	public function patienthistory()
	{
		$this->load->view('reports');
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
        /*$this->load->view('export/report_export_to_excel', $data);*/
        $this->load->view('export/export_without_heading', $data);
        /*$this->load->view('table', $data);*/
	}

	public function expexcelwithcenter()
	{
		$cntrid = $this->input->post('center');
		$date = date('d-m-Y');
        $file = 'Reports_'.$cntrid.'_'.$date.'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");
        
        /*print_r($cntrid);exit;*/
        $data['items'] = $this->Report_model->get_cntr_visits($cntrid); 

        /*$this->load->view('export/report_export_to_excel', $data);*/
        $this->load->view('export/export_without_heading', $data);
        /*$this->load->view('table', $data);*/
	}



	public function expexcelnew()
	{
		$date = date('d-m-Y');
        $file = 'Reports_'.$date.'.xls';
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$file");


        $visit_id = $this->uri->segment(3);
		$patient_id = $this->uri->segment(4);
		$visit_entryid = $this->uri->segment(5);
		$data['visit_id'] = intval($visit_id);
		$data['patient_id'] = intval($patient_id);
		$data['visit_entryid'] = intval($visit_entryid);

        /*$data['items'] = $this->Report_model->get_all_visits(); 
        $this->load->view('table_exl', $data);*/
        /*$check_visit = $this->Visit_model->check_visit(intval($visit_id), intval($patient_id), html_escape($visit_entryid));
		if($check_visit == true)
		{
			
			$this->load->view('table_exl', $data);
		}else
		{
			redirect('not-found');
		}*/
		$this->load->view('table_exl', $data);
	}


	
	public function view()
	{
		$visit_id = $this->uri->segment(4);
		$patient_id = $this->uri->segment(5);
		$visit_entryid = $this->uri->segment(6);
		$data['visit_id'] = intval($visit_id);
		$data['patient_id'] = intval($patient_id);
		$data['visit_entryid'] = intval($visit_entryid);
		
		$check_visit = $this->Visit_model->check_visit(intval($visit_id), intval($patient_id), html_escape($visit_entryid));
		if($check_visit == true)
		{
			if($check_visit['visit_form_version'] == 'v2'){
				$this->load->view('visit/visit_preview_v2', $data);
			}elseif($check_visit['visit_form_version'] == 'v1'){
				$this->load->view('visit/visit_preview', $data);
			}else{
				redirect('not-found');
			}
		}else
		{
			redirect('not-found');
		}
		
	}




	
	public function limitreport()
	{
		exit;
	}
	
}
