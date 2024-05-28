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
	  
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  $this->load->model('Dashboard_model');
	}
	
	public function index()
	{
		$this->load->view('dashboard');
	}
	
	public function logout()
	{
		if( $this->session->userdata('user_type') === 'Doctor'){
			$doc_id = $this->session->userdata('active_user');
			$this->Dashboard_model->doc_active($doc_id);
			$this->session->sess_destroy();
			setcookie("name", "", time() + (1), "/");
		redirect('login/type/user', 'refresh', true);
		}else{
		$this->session->sess_destroy();
		redirect('login/type/user', 'refresh', true);
		}
	}
	
}
