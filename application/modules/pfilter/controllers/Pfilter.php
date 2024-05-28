<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pfilter extends CI_Controller {
	
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
	  // if($this->session->userdata('user_type') === 'Doctor'){
		  // $this->perPage = 8;
	  // }else{
	  $this->perPage = 8;
	  //}
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Dashboard_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	// public function dashboard_filter()
	// {
		// $conditions = array();
		// $from = null;
		// $to = null;
		//set conditions for search
        // $yeartgi = $this->input->post('yeartgi');
        // $tgiMonth = $this->input->post('tgiMonth');
        // $tgiweek = $this->input->post('tgiweek');
		// if($yeartgi){
            // $conditions['search']['yeartgi'] = $yeartgi;
        // }
		// if($tgiweek){
            // $conditions['search']['tgiweek'] = $tgiweek;
			// list($y,$w)= explode('-',$tgiweek);
			// $dto = new DateTime();
			// $y = intval($y);
			// $w = substr($w, 1);
			// $w= intval($w);
			// $from = $dto->setISODate($y, $w, 0)->format('d-m-Y');
			// $to = $dto->setISODate($y, $w, 6)->format('d-m-Y');
        // }
		// if($tgiMonth){
            // $conditions['search']['tgiMonth'] = $tgiMonth;
        // }
		
		// $tgi = $this->Dashboard_model->get_tgi($conditions);
		// $type2dm = [];
	  // $type1dm = [];
	  // $igt = [];
	  // $ifg = [];
	  // $gdm = [];
	  // $others = [];
		
		// foreach($tgi as $key => $value) {
			// if($value['dhistory_type_of_glucose'] === 'Type 2 DM') {
        // array_push($type2dm, [$key => $value]);
			
		// }
		// if($value['dhistory_type_of_glucose'] === 'Type 1 DM') {
        // array_push($type1dm, [$key => $value]);
		// }
		// if($value['dhistory_type_of_glucose'] === 'IGT') {
			// array_push($igt, [$key => $value]);
		// }
		// if($value['dhistory_type_of_glucose'] === 'IFG') {
			// array_push($ifg, [$key => $value]);
		// }
		// if($value['dhistory_type_of_glucose'] === 'GDM') {
			// array_push($gdm, [$key => $value]);
		// }
		// if($value['dhistory_type_of_glucose'] === 'Others') {
			// array_push($others, [$key => $value]);
		// }
		// }
		// $type2dm_count = count($type2dm);
		// $type1dm_count = count($type1dm);
	  // $igt_count = count($igt);
	  // $ifg_count = count($ifg);
	  // $gdm_count = count($gdm);
	  // $others_count = count($others);
		// $result = array('status' => 'ok', 'type2dm_count' => $type2dm_count,'type1dm_count' => $type1dm_count,'igt_count' => $igt_count,
		// 'ifg_count' => $ifg_count,'gdm_count' => $gdm_count,'others_count' => $others_count,'yeartgi' => $yeartgi,'tgiMonth' => $tgiMonth,
		// 'tgifrom' => $from,'tgito' => $to);
		// echo json_encode($result);
		// exit;
	// }
	
	public function dash_org(){
		$conditions = array();
		$from = null;
		$to = null;
		//set conditions for search
        $yeartgi = $this->input->post('yeartgi');
        $tgiMonth = $this->input->post('tgiMonth');
        $tgiweek = $this->input->post('tgiweek');
        $organization = $this->input->post('selectedOrganization');
        $cenTers = $this->input->post('cenTers');
		
		if($organization){
            $conditions['search']['organization'] = $organization;
        }
		if($cenTers){
            $conditions['search']['cenTers'] = $cenTers;
        }
		if($yeartgi){
            $conditions['search']['yeartgi'] = $yeartgi;
        }
		if($tgiweek){
            $conditions['search']['tgiweek'] = $tgiweek;
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('d-m-Y');
			$to = $dto->setISODate($y, $w, 6)->format('d-m-Y');
        }
		if($tgiMonth){
            $conditions['search']['tgiMonth'] = $tgiMonth;
        }
		$totalRec = $this->Dashboard_model->total_patient($conditions);
		$reg_visit1_2022 = $this->Dashboard_model->reg_visit1_2022($conditions);
		$total_distinct_patient = $this->Dashboard_model->total_distinct_patient($conditions);
		$get_tgi = $this->Dashboard_model->get_tgi_org($conditions);
		
		$data['total_items'] = $totalRec;
		$data['get_tgi'] = $get_tgi;
		$data['reg_visit1_2022'] = $reg_visit1_2022;
		$data['total_distinct_patient'] = $total_distinct_patient;
		$data['yeartgi'] = $yeartgi;
		$data['tgiMonth'] = $tgiMonth;
		$data['from'] = $from;
		$data['to'] = $to;
		
		$content = $this->load->view('dash_org', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	public function dashboard_filter()
	{
		$conditions = array();
		$from = null;
		$to = null;
		//set conditions for search
        $yeartgi = $this->input->post('yeartgi');
        $tgiMonth = $this->input->post('tgiMonth');
        $tgiweek = $this->input->post('tgiweek');
		if($yeartgi){
            $conditions['search']['yeartgi'] = $yeartgi;
        }
		if($tgiweek){
            $conditions['search']['tgiweek'] = $tgiweek;
			list($y,$w)= explode('-',$tgiweek);
			$dto = new DateTime();
			$y = intval($y);
			$w = substr($w, 1);
			$w= intval($w);
			$from = $dto->setISODate($y, $w, 0)->format('d-m-Y');
			$to = $dto->setISODate($y, $w, 6)->format('d-m-Y');
        }
		if($tgiMonth){
            $conditions['search']['tgiMonth'] = $tgiMonth;
        }
		$get_tgi = $this->Dashboard_model->get_tgi($conditions);
		$data['get_tgi'] = $get_tgi;
		$data['yeartgi'] = $yeartgi;
		$data['tgiMonth'] = $tgiMonth;
		$data['from'] = $from;
		$data['to'] = $to;
		$content = $this->load->view('only_tgi', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
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
		if ($this->session->userdata('user_type') === 'Administrator' ){
		$keywords = $this->input->post('keywords');
		}else{
		$keywords = null;
		}
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
		if($center){
            $conditions['search']['center'] = $center;
        }
		
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
		$config['base_url']    = base_url().'pfilter/get_all_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_items($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('dash_view_all', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_imported_patients()
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
		if($center){
            $conditions['search']['center'] = $center;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_imported_items($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_imported_items($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('dash_view_all', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_drugs()
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
		
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_drugs_items($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_drugs';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_drugs_items($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('all_drugs', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_todays_patients()
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
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		$center = $this->input->post('center');
		if($center){
            $conditions['search']['center'] = $center;
        }
		
		//total rows count
		$totalRec = count($this->Dashboard_model->today_all_items($conditions));
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_todays_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->today_all_items($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('dash_view_today', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_payment_rpendins()
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

		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_payment_rpendins($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_payment_rpendins';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_payment_rpendins($conditions);
		$data['sl'] = $page;
		
		if($this->session->userdata('user_type') == 'Administrator'){
			$content = $this->load->view('dash_view_rpendings', $data, true);
		}else{
			$content = $this->load->view('dash_view_rpendings_otherview', $data, true);
		}
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_payment_rpaids()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
        //set conditions for search
        $keywords = $this->input->post('keywords');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_payment_rpaids($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_todays_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_payment_rpaids($conditions);
		$data['sl'] = $page;
		
		if($this->session->userdata('user_type') == 'Administrator'){
			$content = $this->load->view('dash_view_rppaid', $data, true);
		}else{
			$content = $this->load->view('dash_view_rppaid_otherview', $data, true);
		}
		
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_payment_pendins()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_payment_pendins($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_payment_pendins';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_payment_pendins($conditions);
		$data['sl'] = $page;
		
		if($this->session->userdata('user_type') == 'Administrator'){
			$content = $this->load->view('dash_view_ppendings', $data, true);
		}else{
			$content = $this->load->view('dash_view_ppendings_otherview', $data, true);
		}
		
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_payment_paids()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
        //set conditions for search
        $keywords = $this->input->post('keywords');
		$sortby = $this->input->post('sortby');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRecRow = $this->Dashboard_model->count_payment_paids($conditions);
		$filteredCount = array_values(array_column($totalRecRow, null, 'visit_patient_id'));
		$totalRec = count($filteredCount);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_payment_paids';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$allItems = $this->Dashboard_model->get_payment_paids($conditions);
		$filteredItems = array_values(array_column($allItems, null, 'visit_patient_id'));
		$data['items'] = $filteredItems;
		$data['sl'] = $page;
		
		if($this->session->userdata('user_type') == 'Administrator'){
			$content = $this->load->view('dash_view_ppaid', $data, true);
		}else if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
				$content =	$this->load->view('dash_view_ppaid_doctor', $data,true);
		}else{
			$content = $this->load->view('dash_view_ppaid_otherview', $data, true);
		}
		
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
		$sortby = $this->input->post('sortby');
		$gtid = $this->input->post('gtid');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		if($gtid){
            $conditions['patient_id'] = $gtid;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = count($this->Dashboard_model->get_all_visits($conditions));
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_patient_visits';
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
	
	public function image_patient_list_upload()
	{
		$conditions = array();
		
		$doc = $this->input->post('doc');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
		
	   
		$conditions['doc'] = $doc;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }else {
			$conditions['month'] = null;
		}
		if($year){
            $conditions['year'] = $year;
        }else {
			$conditions['year'] = null;
		}
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}else {
			$conditions['to_date'] = null;
		}
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}
		
		$progress = $this->Dashboard_model->patient_wise_image_upload_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_upload_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		$data['entry'] = null;		
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function image_patient_list_entry_today()
	{
		$conditions = array();
		
		$doc = $this->input->post('doc');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
	   
		$conditions['doc'] = $doc;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }else {
			$conditions['month'] = null;
		}
		if($year){
            $conditions['year'] = $year;
        }else {
			$conditions['year'] = null;
		}
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}else {
			$conditions['to_date'] = null;
		}
		
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}else{
			$conditions['today'] = 'filtered';
		}
		$progress = $this->Dashboard_model->patient_wise_image_entry_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_entry_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		
		$data['entry'] = 'yes';
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function image_patient_list_upload_today()
	{
		$conditions = array();
		
		$doc = $this->input->post('doc');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
		
	   
		$conditions['doc'] = $doc;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }else {
			$conditions['month'] = null;
		}
		if($year){
            $conditions['year'] = $year;
        }else {
			$conditions['year'] = null;
		}
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}else {
			$conditions['to_date'] = null;
		}
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}else{
			$conditions['today'] = 'filtered';
		}
		
		$progress = $this->Dashboard_model->patient_wise_image_upload_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_upload_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		$data['entry'] = null;		
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function image_patient_list_upload_operator()
	{
		$conditions = array();
		
		$oprtr = $this->input->post('oprtr');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
	   
		$conditions['doc'] = $oprtr;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }
		if($year){
            $conditions['year'] = $year;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}
		
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}
		
		$progress = $this->Dashboard_model->patient_wise_image_upload_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_upload_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		$data['entry'] = null;		
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload_oprtr', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function image_patient_list_entry()
	{
		$conditions = array();
		
		$doc = $this->input->post('doc');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
	   
		$conditions['doc'] = $doc;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }
		if($year){
            $conditions['year'] = $year;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}
		
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}
		$progress = $this->Dashboard_model->patient_wise_image_entry_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_entry_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		
		$data['entry'] = 'yes';
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
	
	public function image_patient_list_entry_oprtr()
	{
		$conditions = array();
		
		$oprtr = $this->input->post('oprtr');
		$center = $this->input->post('center');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$today = $this->input->post('today');
	   
		$conditions['doc'] = $oprtr;
		$conditions['center'] = $center;
		
		if($month){
            $conditions['month'] = $month;
        }
		if($year){
            $conditions['year'] = $year;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date)
		{
			$conditions['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['to_date'] = db_formated_date($to_date);
		}
		
		if($today)
		{
			$conditions['today'] = db_formated_date($today);
		}
		
		$progress = $this->Dashboard_model->patient_wise_image_entry_p($conditions);	
		$ch = $this->Dashboard_model->patient_wise_image_entry_ch($conditions);	
		$filterP = array_values(array_column($progress, null, 'time'));		
		$filterCh = array_values(array_column($ch, null, 'patient_id'));	
		
		$data['entry'] = 'yes';
		$data['progresses'] = $filterP;
		$data['chs'] = $filterCh;
		$content = $this->load->view('dash_view_image_upload_oprtr', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function oprtr_image()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$org = $this->input->post('org');
		if($org){
			$conditions['search']['org'] = $org;
		}
		
		
		$center = $this->input->post('centers');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		$operator = $this->input->post('operator');
		if($operator){
			$conditions['search']['operator'] = $operator;
		}
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if(!empty($to_date)){
		$segments = explode('/', $to_date);
		
		list($day, $month, $year) = $segments;
		$day++;
		$to_date = $day.'/'.$month.'/'.$year;
		}
		if($from_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		//total rows count
		$totalRec = $this->Dashboard_model->oprtr_image_all($conditions);
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		
		//get the posts data
		$items = $this->Dashboard_model->oprtr_image_all($conditions);
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$data['items'] = $filteredItems;
		$data['conditions'] = $conditions;
		$data['totalRec'] = $totalRec;
		$data['sl'] = $page;
		$content = $this->load->view('oprtr_image_count', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function oprtr_image_today()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$org = $this->input->post('org');
		if($org){
			$conditions['search']['org'] = $org;
		}
		
		$center = $this->input->post('centers');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		$operator = $this->input->post('operator');
		if($operator){
			$conditions['search']['operator'] = $operator;
		}
		
		$from_date = $this->input->post('from_date');
		if($from_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->oprtr_image_all_today($conditions);
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		
		//get the posts data
		$items = $this->Dashboard_model->oprtr_image_all_today($conditions);
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$data['items'] = $filteredItems;
		$data['conditions'] = $conditions;
		$data['totalRec'] = $totalRec;
		$data['sl'] = $page;
		$content = $this->load->view('oprtr_image_count_today', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function doc_image()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$org = $this->input->post('org');
		if($org){
			$conditions['search']['org'] = $org;
		}
		
		
		$center = $this->input->post('centers');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		
		
		$doctor = $this->input->post('doctor');
		if($doctor){
			$conditions['search']['doctor'] = $doctor;
		}
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if(!empty($to_date)){
		$segments = explode('/', $to_date);
		
		list($day, $month, $year) = $segments;
		$day++;
		$to_date = $day.'/'.$month.'/'.$year;
		}
		if($from_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
		}
		
		if($to_date)
		{
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		//total rows count
		$totalRec = $this->Dashboard_model->doc_image_all($conditions);
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		
		//get the posts data
		$items = $this->Dashboard_model->doc_image_all($conditions);
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$data['items'] = $filteredItems;
		$data['conditions'] = $conditions;
		$data['totalRec'] = $totalRec;
		$data['sl'] = $page;
		$content = $this->load->view('doctor_image_count', $data, true);
		$result = array('status' => 'ok', 'content' => $content ,'to' => $to_date);
		echo json_encode($result);
		exit;
	}
	
	public function doc_image_today()
	{
		$conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
		
		$org = $this->input->post('org');
		if($org){
			$conditions['search']['org'] = $org;
		}
		
		
		$center = $this->input->post('centers');
		if($center){
			$conditions['search']['center'] = $center;
		}
		
		$doctor = $this->input->post('doctor');
		if($doctor){
			$conditions['search']['doctor'] = $doctor;
		}
		
		$from_date = $this->input->post('from_date');
		if($from_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
		}
		
		
		//total rows count
		$totalRec = $this->Dashboard_model->doc_image_all_today($conditions);
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		
		//get the posts data
		$items = $this->Dashboard_model->doc_image_all_today($conditions);
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$data['items'] = $filteredItems;
		$data['conditions'] = $conditions;
		$data['totalRec'] = $totalRec;
		$data['sl'] = $page;
		$content = $this->load->view('doctor_image_count_today', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
	public function get_all_visit()
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
        $keywords = null;
		//$sortby = $this->input->post('sortby');
		//$gtid = $this->input->post('gtid');
		$type = $this->input->post('type');
        // if($keywords){
            // $conditions['search']['keywords'] = $keywords;
        // }
		if($type){
            $conditions['search']['type'] = $type;
        }
		$center = $this->input->post('center');
		if($center){
			$conditions['search']['center'] = $center;
		}
		$operator = $this->input->post('operator');
		if($operator){
			$conditions['search']['operator'] = $operator;
		}
		$doctor = $this->input->post('doctor');
		if($doctor){
			$conditions['search']['doctor'] = $doctor;
		}
		$year = $this->input->post('year');
		$month = $this->input->post('month');
		if($month && $month !== 'All'){
            $conditions['search']['month'] = $month;
        }
		
		if($year){
            $conditions['search']['year'] = $year;
        }
		
		// if($sortby){
            // $conditions['search']['sortby'] = $sortby;
        // }
		
		// if($gtid){
            // $conditions['patient_id'] = $gtid;
        // }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = count($this->Dashboard_model->get_all_visit($conditions));
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_visit';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_visit($conditions);
		$data['conditions'] = $conditions;
		$data['totalRec'] = $totalRec;
		$data['sl'] = $page;
		$content = $this->load->view('dash_view_visit', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_all_organaizations()
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
		$gtid = $this->input->post('gtid');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_organaizations($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_organaizations';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_organaizations($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('organizations', $data, true);
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
		$sortby = $this->input->post('sortby');
		$gtid = $this->input->post('gtid');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_centers($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_centers';
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
	
	public function get_all_companies()
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
		$gtid = $this->input->post('gtid');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = $this->Dashboard_model->count_all_companies($conditions);
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_companies';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_companies($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('companies', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function get_reports()
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
		$gtid = $this->input->post('gtid');
        if($keywords){
            $conditions['search']['keywords'] = $keywords;
        }
		
		if($sortby){
            $conditions['search']['sortby'] = $sortby;
        }
		
		$from_date = $this->input->post('from_date');
		$to_date   = $this->input->post('to_date');
		if($from_date && $to_date)
		{
			$conditions['search']['from_date'] = db_formated_date($from_date);
			$conditions['search']['to_date'] = db_formated_date($to_date);
		}
		
		//total rows count
		$totalRec = count($this->Dashboard_model->get_all_reports($conditions));
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_reports';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//set start and limit
        $conditions['start'] = $offset;
		$conditions['limit'] = $this->perPage;
		
		//get the posts data
		$data['items'] = $this->Dashboard_model->get_all_reports($conditions);
		$data['sl'] = $page;
		$content = $this->load->view('reports', $data, true);
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
}
