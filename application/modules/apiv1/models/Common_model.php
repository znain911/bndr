<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	
	public function get_local_app_centers()
	{
		$query = $this->db->query("SELECT api_app_center_id FROM starter_local_app_centers WHERE api_app_is_active='YES'");
		$results = $query->result_array();
		$centers = array();
		foreach($results as $result)
		{
			$centers[] = $result['api_app_center_id'];
		}
		
		return $centers;
	}
	
}