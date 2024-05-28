<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {
	
	public function count_all_items()
	{
		$query = $this->db->query("SELECT company_id FROM starter_pharmaceuticals");
		return $query->num_rows();
	}
	
	public function get_all_items($params=array())
	{
		$query = "SELECT * FROM starter_pharmaceuticals ";
		$query .= "ORDER BY company_id DESC ";
		
        if(isset($params['limit'])){
			$limit = $params['limit'];
            $query .= "LIMIT {$limit}";
        }
		
		$query = $this->db->query($query);
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_pharmaceuticals', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('company_id', $id);
		$this->db->update('starter_pharmaceuticals', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_pharmaceuticals WHERE company_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}