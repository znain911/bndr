<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
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
	  $this->load->model('Administrator_model');
	  $this->load->model('Assistant_model');
	  $this->load->model('Doctor_model');
	  $this->load->model('Operator_model');
	  $this->load->model('Organization_model');
	  $this->load->library('ajax_pagination');
	  $this->load->helper('custom_string');
	}
	
	public function index()
	{
		if( $this->session->userdata('user_type') === 'Org Admin'){
			//total rows count
		$totalRec = $this->Dashboard_model->count_visit();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_all_visit';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = $this->Dashboard_model->get_all_visit(array('limit'=>$this->perPage));
		$items_count = $totalRec;
		$data['items'] = $items;
		$data['items_count'] = $items_count;
		$data['total_items'] = $totalRec;
		$this->load->view('dash_view_visit', $data);
		}else if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
			//total rows count
				//$totalRec = $this->Dashboard_model->count_all_items();
				$totalRec = $this->Dashboard_model->count_today_all_items();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_all_patients';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				//$data['items'] = $this->Dashboard_model->get_all_items(array('limit'=>$this->perPage));
				$data['items'] = $this->Dashboard_model->today_all_items(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				$this->load->view('dash_view_all', $data);
		}else if( $this->session->userdata('user_type') === 'Super Operator'){
			
				//get the posts data
				$one = $this->Dashboard_model->caseHistoryPicId();
				$items = array_values(array_column($one, null, 'patient_id'));
				$data['items'] = $items;
				$two = $this->Dashboard_model->progressPicId();
				$progressess = array_values(array_column($two, null, 'patient_id'));
				$data['progressess'] = $progressess;
				$this->load->view('dash_super_operator', $data);
		}
		else if( $this->session->userdata('user_type') === 'API'){
			
				$this->load->view('api');
		}else{
		//total rows count
		$totalRec = $this->Dashboard_model->count_today_all_items();
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/get_todays_patients';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = 
		$data['items'] = $this->Dashboard_model->today_all_items(array('limit'=>$this->perPage));
		$data['total_items'] = $totalRec;
		$this->load->view('dash_view_today', $data);
		}
	}
	public function compile()
	{
		$chlistv1 = $this->Dashboard_model->multiplev1();
		$data['chlist'] = $chlistv1;
		$this->load->view('compile',$data);
	}
	public function doc_image()
	{
		//total rows count
		$totalRec = $this->Dashboard_model->doc_image_all(array('limit'=> null));
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		
		//get the posts data
		$items = $this->Dashboard_model->doc_image_all(array('limit'=>$this->perPage));
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$items_count = $totalRec;
		$data['items'] = $filteredItems;
		$data['items_count'] = $items_count;	
		$data['total_items'] = $totalRec;
		if($this->session->userdata('user_type') == 'Administrator'){
			$this->load->view('doctor_image_count_ad', $data);
		}else{
			$this->load->view('doctor_image_count', $data);
		}
	}
	
	public function doc_image_today()
	{
		//total rows count
		$totalRec = $this->Dashboard_model->doc_image_today();
		$filteredCount = array_values(array_column($totalRec, null, 'patient_id'));
		$totalRec = count($filteredCount);
		
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/doc_image';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = $this->Dashboard_model->doc_image_all_today(array('limit'=>$this->perPage));
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$items_count = $totalRec;
		$data['items'] = $filteredItems;
		$data['items_count'] = $items_count;	
		$data['total_items'] = $totalRec;
		if($this->session->userdata('user_type') == 'Administrator'){
			$this->load->view('doctor_image_count_ad_today', $data);
		}else{
			$this->load->view('doctor_image_count_today', $data);
		}
	}
	
	public function hide()
	{
		$patient_id = $this->input->post('pid');
		$update = $this->Dashboard_model->hide_ch_pic($patient_id);
		
		echo $update;
			exit;
	}
	
	public function rp()
	{
		$patient_id = $this->input->post('pid');
		$update = $this->Dashboard_model->rp_ch_pic($patient_id);
		
		echo $update;
			exit;
	}
	
	public function hideProgress()
	{
		$patient_id = $this->input->post('pid');
		$vid = $this->input->post('vid');
		$update = $this->Dashboard_model->hide_pr_pic($patient_id,$vid);
		
		echo $update;
			exit;
	}
	
	public function rpProgress()
	{
		$patient_id = $this->input->post('pid');
		$vid = $this->input->post('vid');
		$update = $this->Dashboard_model->rp_pr_pic($patient_id,$vid);
		
		echo $update;
			exit;
	}
	
	public function hideList()
	{
		$ch = $this->Dashboard_model->hidePicCh();
		$items = array_values(array_column($ch, null, 'patient_id'));
		$pr = $this->Dashboard_model->hidePicPr();
		$hideprogressess = array_values(array_column($pr, null, 'patient_id'));
		
		$data['items'] = $items;
		$data['hideprogressess'] = $hideprogressess;
		
		$content = $this->load->view('hide', $data, true);
		
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	public function rpList()
	{
		$all = $this->Dashboard_model->rpPic();
		$items = array_values(array_column($all, null, 'patient_id'));
		
		
		$data['items'] = $items;
		
		$content = $this->load->view('rp', $data, true);
		
		$result = array('status' => 'ok', 'content' => $content);
		echo json_encode($result);
		exit;
	}
	
	
	
	
	public function oprtr_image()
	{
		//total rows count
		$totalRec = $this->Dashboard_model->oprtr_image_all(array('limit'=> null));
		$filteredCount = array_values(array_column($totalRec, null, 'time'));
		$totalRec = count($filteredCount);
		
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/oprtr_image';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = $this->Dashboard_model->oprtr_image_all(array('limit'=>$this->perPage));
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$items_count = $totalRec;
		$data['items'] = $filteredItems;
		$data['items_count'] = $items_count;	
		$data['total_items'] = $totalRec;
		if($this->session->userdata('user_type') == 'Administrator'){
			$this->load->view('operator_image_count_ad', $data);
		}else{
			$this->load->view('operator_image_count', $data);
		}
	}
	
	public function oprtr_image_today()
	{
		//total rows count
		$totalRec = $this->Dashboard_model->oprtr_image_today();
		$filteredCount = array_values(array_column($totalRec, null, 'patient_id'));
		$totalRec = count($filteredCount);
		
		
		//pagination configuration
		$config['target']      = '#postList';
		$config['base_url']    = base_url().'pfilter/oprtr_image';
		$config['total_rows']  = $totalRec;
		$config['per_page']    = $this->perPage;
		$config['link_func']   = 'searchFilter';
		$this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = $this->Dashboard_model->oprtr_image_all_today(array('limit'=>$this->perPage));
		$filteredItems = array_values(array_column($items, null, 'submitted_by'));
		$items_count = $totalRec;
		$data['items'] = $filteredItems;
		$data['items_count'] = $items_count;	
		$data['total_items'] = $totalRec;
		if($this->session->userdata('user_type') == 'Administrator'){
			$this->load->view('operator_image_count_ad_today', $data);
		}else{
			$this->load->view('operator_image_count_today', $data);
		}
	}
	public function graph()
	{
		ini_set("memory_limit", "-1");
		
		//total rows count
		$totalRec = $this->Dashboard_model->total_patient();
		$total_distinct_patient = $this->Dashboard_model->total_distinct_patient();
		$total_followup = $this->Dashboard_model->total_followup();
		$get_tgi = $this->Dashboard_model->get_tgi();
		
		
		
		//pagination configuration
		// $config['target']      = '#postList';
		// $config['base_url']    = base_url().'pfilter/get_todays_patients';
		// $config['total_rows']  = $totalRec;
		// $config['per_page']    = $this->perPage;
		// $config['link_func']   = 'searchFilter';
		// $this->ajax_pagination->initialize($config);
		
		//get the posts data
		$items = 
		$reg_visit1_2022 = $this->Dashboard_model->reg_visit1_2022();
		$all_comorbidity = $this->Dashboard_model->all_comorbidity();
		$blood_sugar = $this->Dashboard_model->blood_sugar();
		$bmi = $this->Dashboard_model->bmi();
		$ls = $this->Dashboard_model->life_style();
		// $su_o = $this->Dashboard_model->summary_oads();
		$all_med = $this->Dashboard_model->summary_all_meds();
		$data['total_items'] = $totalRec;
		$data['total_distinct_patient'] = $total_distinct_patient;
		$data['followUp'] = $total_followup;
		$data['get_tgi'] = $get_tgi;
		$data['reg_visit1_2022'] = $reg_visit1_2022;
		$data['all_comorbidity'] = $all_comorbidity;
		$data['bs'] = $blood_sugar;
		$data['ls'] = $ls;
		$data['bmi'] = $bmi;
		$data['all_med'] = $all_med;
		// $data['su_o'] = $su_o;
		
		$this->load->view('dashboard', $data);
		
	}
	
	public function shw($param=null)
	{
		if(!is_null($param))
		{
			if(isset($param) && $param === 'todays')
			{
				//total rows count
				$totalRec = $this->Dashboard_model->count_today_all_items();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_todays_patients';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Dashboard_model->today_all_items(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				$this->load->view('dash_view_today', $data);
			
			}elseif(isset($param) && $param === 'all'){
				//total rows count
				$totalRec = $this->Dashboard_model->count_all_items();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_all_patients';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Dashboard_model->get_all_items(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				$this->load->view('dash_view_all', $data);
				
			}elseif(isset($param) && $param === 'rppendings'){
				
				//total rows count
				$totalRec = $this->Dashboard_model->count_payment_rpendins();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_payment_rpendins';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Dashboard_model->get_payment_rpendins(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				if($this->session->userdata('user_type') == 'Administrator'){
					$this->load->view('dash_view_rpendings', $data);
				}else{
					$this->load->view('dash_view_rpendings_otherview', $data);
				}
				
			}elseif(isset($param) && $param === 'rppaids'){
				
				//total rows count
				$totalRec = $this->Dashboard_model->count_payment_rpaids();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_payment_rpaids';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Dashboard_model->get_payment_rpaids(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				
				if($this->session->userdata('user_type') == 'Administrator'){
					$this->load->view('dash_view_rppaid', $data);
				}else{
					$this->load->view('dash_view_rppaid_otherview', $data);
				}
				
			}elseif(isset($param) && $param === 'ppendings'){
				
				//total rows count
				$totalRec = $this->Dashboard_model->count_all_visits();
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_payment_pendins';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$data['items'] = $this->Dashboard_model->get_all_visits(array('limit'=>$this->perPage));
				$data['total_items'] = $totalRec;
				
				if($this->session->userdata('user_type') == 'Administrator'){
					$this->load->view('dash_view_ppendings', $data);
				}else{
					$this->load->view('dash_view_ppendings_otherview', $data);
				}
			
			}elseif(isset($param) && $param === 'ppaids'){
				
				//total rows count
				$totalRecRow = $this->Dashboard_model->count_allpaid_visits();
				$filteredCount = array_values(array_column($totalRecRow, null, 'visit_patient_id'));
				$totalRec = count($filteredCount);
				
				//pagination configuration
				$config['target']      = '#postList';
				$config['base_url']    = base_url().'pfilter/get_payment_paids';
				$config['total_rows']  = $totalRec;
				$config['per_page']    = $this->perPage;
				$config['link_func']   = 'searchFilter';
				$this->ajax_pagination->initialize($config);
				
				//get the posts data
				$allItems = $this->Dashboard_model->get_allpaid_visits(array('limit'=>$this->perPage));
				$filteredItems = array_values(array_column($allItems, null, 'visit_patient_id'));
				$data['items'] = $filteredItems;
				$data['total_items'] = $totalRec;
				
				if($this->session->userdata('user_type') == 'Administrator'){
					$this->load->view('dash_view_ppaid', $data);
				}else if( $this->session->userdata('user_type') === 'Doctor' || $this->session->userdata('user_type') === 'Foot Doctor'|| $this->session->userdata('user_type') === 'Eye Doctor'){
					$this->load->view('dash_view_ppaid_doctor', $data);
				}else{
					$this->load->view('dash_view_ppaid_otherview', $data);
				}
			}
		}
	}
	
	
	public function profile()
	{
		$admin_id = $this->session->userdata('active_user');
		$admin_user_type = $this->session->userdata('user_type');
		
		if($admin_user_type == 'Administrator' || $admin_user_type == 'Org Admin'){
			
			$data['id'] = $admin_id;
			$this->load->view('profile/administrator_profile', $data);
			
		}elseif($admin_user_type == 'Doctor'){
			
			$data['id'] = $admin_id;
			$this->load->view('profile/doctor_profile', $data);
			
		}elseif($admin_user_type == 'Operator'){
			
			$data['id'] = $admin_id;
			$this->load->view('profile/operator_profile', $data);
			
		}elseif($admin_user_type == 'Assistant'){
			
			$data['id'] = $admin_id;
			$this->load->view('profile/assistant_profile', $data);
			
		}
	}
	
	public function change_password()
	{
		$admin_id = $this->input->post('admin');
		$update_pass = array(
							'owner_password' => sha1(html_escape($this->input->post('password'))),
						);
		$this->db->where('owner_id', $admin_id);
		$this->db->update('starter_owner', $update_pass);
		$result = array('status' => 'ok');
		echo json_encode($result);
		exit;
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh', true);
	}
	
}
