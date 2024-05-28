<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistants extends CI_Controller {
	
	private $sqtoken;
	private $sqtoken_hash;
	
	public function __construct()
	{
      parent::__construct();
	  $this->sqtoken = $this->security->get_csrf_token_name();
	  $this->sqtoken_hash = $this->security->get_csrf_hash();
	}
	
	public function index()
	{
		$this->load->view('assistants');
	}
	
}
