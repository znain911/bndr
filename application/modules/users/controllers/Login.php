<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  date_default_timezone_set('Asia/Dhaka');
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	  
	  $this->load->model('Login_model');
	}
	
	public function credentials()
	{
		$this->load->library('form_validation');
		$email_or_phone = html_escape($this->input->post('email_or_phone'));
		if(strpos($email_or_phone, '@') !== false)
		{
			$email = $email_or_phone;
			$password = sha1(html_escape($this->input->post('password')));
			$user_type = $this->input->post('role_type');
			if($user_type === '1'){
				//check with email & password
				$is_user = $this->Login_model->check_operator_email_credentials($email, $password);
				if($is_user == true)
				{
					//Check user status (active OR deactive)
					if($is_user->operator_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->operator_last_login;
						$show_last['last_login_ip'] = $is_user->operator_login_ip;
						$this->session->set_userdata($show_last);
						$logg['operator_login_ip'] = $this->input->ip_address();
						$logg['operator_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_operator($is_user->operator_id, $logg);
						$activate['full_name'] = $is_user->operator_full_name;
						$activate['active_user'] = $is_user->operator_id;
						$activate['user_type'] = $is_user->operator_user_type;
						$activate['user_org_id'] = $is_user->operator_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->operator_photo;
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
			}elseif($user_type === '2'){
				//check with email & password
				$is_user = $this->Login_model->check_doctor_email_credentials($email, $password);
				
				if($is_user == true)
				{
					if($is_user->doctor_login_info === null)
				{
					setcookie('name', $is_user->doctor_full_name, time() + (86400 * 30), "/"); // 86400 = 1 day
					$doc_id =  $is_user->doctor_id;
					$login= $this->Login_model->doc_active($doc_id);
					//Check user status (active OR deactive)
					if($is_user->doctor_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->doctor_last_login;
						$show_last['last_login_ip'] = $is_user->doctor_login_ip;
						$this->session->set_userdata($show_last);
						$logg['doctor_login_ip'] = $this->input->ip_address();
						$logg['doctor_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_doctor($is_user->doctor_id, $logg);
						$activate['full_name'] = $is_user->doctor_full_name;
						$activate['active_user'] = $is_user->doctor_id;
						$activate['user_type'] = $is_user->doctor_user_type;
						$activate['user_org_id'] = $is_user->doctor_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->doctor_photo;
						$activate['userLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
				}elseif(isset($_COOKIE['name'])) {
					setcookie('name', $is_user->doctor_full_name, time() + (86400 * 30), "/"); // 86400 = 1 day
					if($is_user->doctor_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->doctor_last_login;
						$show_last['last_login_ip'] = $is_user->doctor_login_ip;
						$this->session->set_userdata($show_last);
						$logg['doctor_login_ip'] = $this->input->ip_address();
						$logg['doctor_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_doctor($is_user->doctor_id, $logg);
						$activate['full_name'] = $is_user->doctor_full_name;
						$activate['active_user'] = $is_user->doctor_id;
						$activate['user_type'] = $is_user->doctor_user_type;
						$activate['user_org_id'] = $is_user->doctor_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->doctor_photo;
						$activate['userLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
			
		}
				else{
					$error_alert = '<div class="alert alert-danger" role="alert">Already logged in</div>';
					$result = array("status" => "error", "error" => $error_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
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
			}elseif($user_type === '3'){
				//check with email & password
				$is_user = $this->Login_model->check_assistant_email_credentials($email, $password);
				if($is_user == true)
				{
					//Check user status (active OR deactive)
					if($is_user->assistant_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->assistant_last_login;
						$show_last['last_login_ip'] = $is_user->assistant_login_ip;
						$this->session->set_userdata($show_last);
						$logg['assistant_login_ip'] = $this->input->ip_address();
						$logg['assistant_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_assistant($is_user->assistant_id, $logg);
						$activate['full_name'] = $is_user->assistant_full_name;
						$activate['active_user'] = $is_user->assistant_id;
						$activate['user_type'] = $is_user->assistant_user_type;
						$activate['user_org_id'] = $is_user->assistant_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->assistant_photo;
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
			}
		}else
		{
			$phone = $email_or_phone;
			
			$password = sha1(html_escape($this->input->post('password')));
			
			$user_type = $this->input->post('role_type');
			if($user_type === '1'){
				//check with phone & password
				$is_user = $this->Login_model->check_operator_phone_credentials($phone, $password);
				if($is_user == true)
				{
					//Check user status (active OR deactive)
					if($is_user->operator_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->operator_last_login;
						$show_last['last_login_ip'] = $is_user->operator_login_ip;
						$this->session->set_userdata($show_last);
						$logg['operator_login_ip'] = $this->input->ip_address();
						$logg['operator_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_operator($is_user->operator_id, $logg);
						$activate['full_name'] = $is_user->operator_full_name;
						$activate['active_user'] = $is_user->operator_id;
						$activate['user_type'] = $is_user->operator_user_type;
						$activate['user_org_id'] = $is_user->operator_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->operator_photo;
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
			}elseif($user_type === '2'){
				//check with phone & password
				$is_user = $this->Login_model->check_doctor_phone_credentials($phone, $password);
				if($is_user == true)
				{
					if($is_user->doctor_login_info === null)
				{
					setcookie('name', $is_user->doctor_full_name, time() + (86400 * 7), "/"); // 86400 = 1 day
					$doc_id =  $is_user->doctor_id;
					$login= $this->Login_model->doc_active($doc_id);
					//Check user status (active OR deactive)
					if($is_user->doctor_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->doctor_last_login;
						$show_last['last_login_ip'] = $is_user->doctor_login_ip;
						$this->session->set_userdata($show_last);
						$logg['doctor_login_ip'] = $this->input->ip_address();
						$logg['doctor_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_doctor($is_user->doctor_id, $logg);
						$activate['full_name'] = $is_user->doctor_full_name;
						$activate['active_user'] = $is_user->doctor_id;
						$activate['user_type'] = $is_user->doctor_user_type;
						$activate['user_org_id'] = $is_user->doctor_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->doctor_photo;
						$activate['userLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
				}elseif(isset($_COOKIE['name'])) {
					setcookie('name', $is_user->doctor_full_name, time() + (86400 * 7), "/"); // 86400 = 1 day
					if($is_user->doctor_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->doctor_last_login;
						$show_last['last_login_ip'] = $is_user->doctor_login_ip;
						$this->session->set_userdata($show_last);
						$logg['doctor_login_ip'] = $this->input->ip_address();
						$logg['doctor_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_doctor($is_user->doctor_id, $logg);
						$activate['full_name'] = $is_user->doctor_full_name;
						$activate['active_user'] = $is_user->doctor_id;
						$activate['user_type'] = $is_user->doctor_user_type;
						$activate['user_org_id'] = $is_user->doctor_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->doctor_photo;
						$activate['userLogin'] = TRUE;
						$this->session->set_userdata($activate);
						$success_alert = '<div class="alert alert-success" role="alert">Login Success! Redirecting...</div>';
						$result = array("status" => "ok", "success" => $success_alert);
						echo json_encode($result);
						exit;
					}
			
		}else{
					$error_alert = '<div class="alert alert-danger" role="alert">Already logged in</div>';
					$result = array("status" => "error", "error" => $error_alert);
					$result[$this->sqtoken] = $this->sqtoken_hash;
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
			}elseif($user_type === '3'){
				//check with phone & password
				$is_user = $this->Login_model->check_assistant_phone_credentials($phone, $password);
				if($is_user == true)
				{
					//Check user status (active OR deactive)
					if($is_user->assistant_status !== '1')
					{
						$warning_alert = '<div class="alert alert-warning" role="alert">Account is not activated!</div>';
						$result = array("status" => "warning", "warning" => $warning_alert);
						$result[$this->sqtoken] = $this->sqtoken_hash;
						echo json_encode($result);
						exit;
					}else
					{
						$show_last['last_login_time'] = $is_user->assistant_last_login;
						$show_last['last_login_ip'] = $is_user->assistant_login_ip;
						$this->session->set_userdata($show_last);
						$logg['assistant_login_ip'] = $this->input->ip_address();
						$logg['assistant_last_login'] = date("Y-m-d H:i:s");
						$this->Login_model->update_assistant($is_user->assistant_id, $logg);
						$activate['full_name'] = $is_user->assistant_full_name;
						$activate['active_user'] = $is_user->assistant_id;
						$activate['user_type'] = $is_user->assistant_user_type;
						$activate['user_org_id'] = $is_user->assistant_org_id;
						$activate['user_org_name'] = $is_user->org_name;
						$activate['user_org_center_name'] = $is_user->orgcenter_name;
						$activate['user_org_center_id'] = $is_user->orgcenter_id;
						$activate['admin_photo'] = $is_user->assistant_photo;
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
	
}
