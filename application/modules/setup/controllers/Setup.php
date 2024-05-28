<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
	
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
	  $this->load->model('Setup_model');
	}
	
	public function config()
	{
		$this->load->view('config');
	}
	
	public function update_config()
	{
		$data = array(
					'config_option' => html_escape($this->input->post('reg_fee')),
					'config_option_two' => html_escape($this->input->post('followup_fee')),
				);
		$this->Setup_model->update($data);
		$success = '<div class="alert alert-success text-center">Configuration has been successfully updated!</div>';
		$result = array('status' => 'ok', 'success' => $success);
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
}
