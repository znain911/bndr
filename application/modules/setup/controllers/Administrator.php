<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {
	
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
	  
	  $this->load->model('Administrator_model');
	}
	
	public function index()
	{
		$this->load->view('admins/administrators');
	}
	
	public function create()
	{
		$this->load->view('admins/create');
	}
	
	public function save()
	{
		$this->load->library('form_validation');
		$data = array(  
					'owner_role_id'      => $this->input->post('role_id'),  
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_email'        => html_escape($this->input->post('email')),  
					'owner_phone'        => html_escape($this->input->post('phone')),  
					'owner_password'     => sha1(html_escape($this->input->post('password'))),  
					'owner_role'         => md5($this->input->post('role_id')),  
					'owner_create_date'  => Date("Y-m-d H:i:s"),  
					'owner_activate'     => $this->input->post('status'),  
				);
		if($this->input->post('role_id') == '4')
		{
			if($this->input->post('org_id') == '')
			{
				$error = '<div class="alert alert-danger">Please select the organization</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			$data['owner_org_id'] = $this->input->post('org_id');
		}
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'role_id', 
							'label' => 'Role', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'password', 
							'label' => 'Password', 
							'rules' => 'required|trim', 
						),
					);
		$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[starter_owner.owner_email]', array('is_unique' => 'The email is already exist!'));
		$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|is_unique[starter_owner.owner_phone]', array('is_unique' => 'The phone number is already exist!'));
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/administrators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
		  $error = '<div class="alert alert-danger">'.$upload_error.'</div>';
		  $result = array('status' => 'error', 'error' => $error);
		  $result[$this->sqtoken] = $this->sqtoken_hash;
		  echo json_encode($result);
		  exit;
	    }else{
			$fileData = $this->upload->data();
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  true,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//save
			$ins_id = $this->Administrator_model->create($data);
			$admin_id = $this->db->insert_id($ins_id);
			
			//save manages
			$total_permissions = $this->input->post('permission');
			foreach($total_permissions as $key => $permission)
			{
				if($permission)
				{
					$perm_data = array(
									'permission_adminid' => $admin_id,
									'permission_permission_id' => $permission,
								);
					$this->Administrator_model->save_permissions($perm_data);
				}
			}
			
			$success = '<div class="alert alert-success">Account has been successfully created!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function edit($id)
	{
		$data['id'] = intval($id);
		$this->load->view('admins/edit', $data);
	}
	
	public function update()
	{
		$this->load->library('form_validation');
		$id = $this->input->post('id');
		
		$check_email = $this->Administrator_model->check_email(html_escape($this->input->post('email')));
		$check_phone = $this->Administrator_model->check_phone(html_escape($this->input->post('phone')));
		
		$data = array(
					'owner_role_id'      => $this->input->post('role_id'),  
					'owner_name'         => html_escape($this->input->post('full_name')),  
					'owner_email'        => html_escape($this->input->post('email')),
					'owner_phone'        => html_escape($this->input->post('phone')),
					'owner_role'         => md5($this->input->post('role_id')),  
					'owner_activate'     => $this->input->post('status'),  
				);
		if($this->input->post('role_id') == '4')
		{
			if(!$this->input->post('org_id'))
			{
				$error = '<div class="alert alert-danger">Please select the organization</div>';
				$result = array('status' => 'error', 'error' => $error);
				$result[$this->sqtoken] = $this->sqtoken_hash;
				echo json_encode($result);
				exit;
			}
			$data['owner_org_id'] = $this->input->post('org_id');
		}
		$validate = array(
						array(
							'field' => 'full_name', 
							'label' => 'Full Name', 
							'rules' => 'required|trim', 
						),array(
							'field' => 'role_id', 
							'label' => 'Role', 
							'rules' => 'required|trim', 
						),
					);
		if($check_email == true && $check_email['owner_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The email is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		
		if($check_phone == true && $check_phone['owner_id'] !== $id)
		{
			$error_alert = '<div class="alert alert-danger" role="alert">The phone number is already exist!</div>';
			$result = array("status" => "error", "error" => $error_alert);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
		$this->form_validation->set_rules($validate);
		
		$this->load->library('upload');
	    $this->load->library('image_lib');
	    $config['upload_path']          = 'attachments/administrators/';
	    $config['allowed_types']        = 'gif|jpg|png|jpeg';
	    $config['detect_mime']          = TRUE;
	    $config['remove_spaces']        = TRUE;
	    $config['encrypt_name']         = TRUE;
	    $config['max_size']             = '0';
	    $this->upload->initialize($config);
		if (!$this->upload->do_upload('recent_photo')){
		  $upload_error = $this->upload->display_errors();
	    }else{
			$exist_image = $this->Administrator_model->get_info($id);
			if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
				$file_name = attachment_dir("administrators/".$exist_image['owner_photo']);
				if(file_exists($file_name)){
					unlink($file_name);
				}else{
					echo null;
				}
			}else{
				echo null;
			}
			$fileData = $this->upload->data();
			$data['owner_photo'] = $fileData['file_name'];
			$configer =  array(
			  'image_library'   => 'gd2',
			  'source_image'    =>  $config['upload_path'].$fileData['file_name'],
			  'create_thumb'    =>  FALSE,
			  'maintain_ratio'  =>  FALSE,
			  'width'           =>  150,
			  'height'          =>  150,
			);
			$this->image_lib->clear();
			$this->image_lib->initialize($configer);
			$this->image_lib->resize();
		}
		
		if($this->form_validation->run() == true)
		{
			//Update
			$this->Administrator_model->update($id, $data);
			
			//delete permissions first
			$this->db->where('permission_adminid', $id);
			$this->db->delete('starter_admin_permission');
			
			//save manages
			$total_permissions = $this->input->post('permission');
			foreach($total_permissions as $key => $permission)
			{
				if($permission)
				{
					$perm_data = array(
									'permission_adminid' => $id,
									'permission_permission_id' => $permission,
								);
					$this->Administrator_model->save_permissions($perm_data);
				}
			}
			
			
			$success = '<div class="alert alert-success">successfully updated!</div>';
			$result = array('status' => 'ok', 'success' => $success);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}else
		{
			$error = '<div class="alert alert-danger">'.validation_errors().'</div>';
			$result = array('status' => 'error', 'error' => $error);
			$result[$this->sqtoken] = $this->sqtoken_hash;
			echo json_encode($result);
			exit;
		}
	}
	
	public function delete()
	{
		$id = $this->input->post('id');
		
		//delete permission
		$this->db->where('permission_adminid', $id);
		$this->db->delete('starter_admin_permission');
		
		$exist_image = $this->Administrator_model->get_info($id);
		if(!empty($exist_image['owner_photo']) && $exist_image['owner_photo'] !== NULL){
			$file_name = attachment_dir("administrators/".$exist_image['owner_photo']);
			if(file_exists($file_name)){
				unlink($file_name);
			}else{
				echo null;
			}
		}else{
			echo null;
		}
		
		//Delete coordinator
		$this->db->where('owner_id', $id);
		$this->db->delete('starter_owner');
		
		$result = array("status" => "ok");
		$result[$this->sqtoken] = $this->sqtoken_hash;
		echo json_encode($result);
		exit;
	}
	
	public function getorg()
	{
		
		$orgs = $this->Administrator_model->get_all_orgs();
		$org_content = '';
		foreach($orgs as $org):
			$org_content .= '<option value="'.$org['org_id'].'">'.$org['org_name'].'</option>';
		endforeach;
		$content = '<div class="form-group">
						<label class="col-md-8 control-label">Organization <span style="color:#f00">*</span></label>
						<div class="col-md-4">
							<select name="org_id" class="form-control">
								<option value="">Select Organization</option>
								'.$org_content.'
							</select>
						</div>
					</div>';
		$result = array("status" => "ok", "content" => $content);
		echo json_encode($result);
		exit;
	}
	
}
