<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  
	  $active_user = $this->session->userdata('active_user');
	  $userLogin = $this->session->userdata('userLogin');
	  if($active_user !== NULL && $userLogin === TRUE)
	  {
		redirect('administrator/dashboard', 'refresh', true);
	  }
	  
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Login_model');
	}
	
	public function index()
	{
		$this->load->view('login');
		//$this->load->view('maintenance');
	}
	
	public function type()
	{
		$param = $this->uri->segment(3);
		if(isset($param) && $param !== null && $param === 'user')
		{
			$this->load->view('user_login');
		}else
		{
			redirect('login');
		}
	}
	
	
	public function credentials()
	{
		$this->load->library('form_validation');
		$email_or_phone = html_escape($this->input->post('email_or_phone'));
		if(strpos($email_or_phone, '@') !== false)
		{
			$email = $email_or_phone;
			$password = sha1(html_escape($this->input->post('password')));
			
			//check with email & password
			$is_user = $this->Login_model->check_user_credentials($email, $password);
			if($is_user == true)
			{
				//Check user status (active OR deactive)
				if($is_user->owner_activate !== '1')
				{
					$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
					$result = array("status" => "warning", "warning" => $warning_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}else
				{
					$show_last['last_login_time'] = $is_user->owner_last_login;
					$show_last['last_login_ip'] = $is_user->owner_login_ip;
					$this->session->set_userdata($show_last);
					$logg['owner_login_ip'] = $this->input->ip_address();
					$logg['owner_last_login'] = date("Y-m-d H:i:s");
					$this->Login_model->update_admin($is_user->owner_id, $logg);
					$activate['full_name'] = $is_user->owner_name;
					$activate['active_user'] = $is_user->owner_id;
					$activate['user_type'] = $is_user->owner_user_type;
					$activate['user_org'] = $is_user->owner_org_id;
					$activate['admin_photo'] = $is_user->owner_photo;
					$activate['role'] = $is_user->owner_role_id;
					$activate['userLogin'] = TRUE;
					$this->session->set_userdata($activate);
					$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
					$result = array("status" => "ok", "success" => $success_alert);
					echo json_encode($result);
					exit;
				}
			}else
			{
				$error_alert = '<div class="alert alert-danger" role="alert">Email Or Password incorrect!</div>';
				$result = array("status" => "error", "error" => $error_alert);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}else
		{
			$phone = $email_or_phone;
			
			$password = sha1(html_escape($this->input->post('password')));
			
			//check with phone & password
			$is_user = $this->Login_model->check_user_phone_credentials($phone, $password);
			if($is_user == true)
			{
				//Check user status (active OR deactive)
				if($is_user->owner_activate !== '1')
				{
					$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
					$result = array("status" => "warning", "warning" => $warning_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
					echo json_encode($result);
					exit;
				}else
				{
					$show_last['last_login_time'] = $is_user->owner_last_login;
					$show_last['last_login_ip'] = $is_user->owner_login_ip;
					$this->session->set_userdata($show_last);
					$logg['owner_login_ip'] = $this->input->ip_address();
					$logg['owner_last_login'] = date("Y-m-d H:i:s");
					$this->Login_model->update_admin($is_user->owner_id, $logg);
					$activate['full_name'] = $is_user->owner_name;
					$activate['active_user'] = $is_user->owner_id;
					$activate['user_type'] = $is_user->owner_user_type;
					$activate['user_org'] = $is_user->owner_org_id;
					$activate['admin_photo'] = $is_user->owner_photo;
					$activate['role'] = $is_user->owner_role_id;
					$activate['userLogin'] = TRUE;
					$this->session->set_userdata($activate);
					$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
					$result = array("status" => "ok", "success" => $success_alert);
					echo json_encode($result);
					exit;
				}
			}else
			{
				$error_alert = '<div class="alert alert-danger" role="alert">Email/Phone Or Password incorrect!</div>';
				$result = array("status" => "error", "error" => $error_alert);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
		}
	}
	
	
}
