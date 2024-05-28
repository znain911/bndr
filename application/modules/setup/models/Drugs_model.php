<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drugs_model extends CI_Model {
	
	public function count_all_items()
	{
		$query = $this->db->query("SELECT id FROM starter_dgds");
		return $query->num_rows();
	}
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_dgds 
								   
								   LEFT JOIN starter_pharmaceuticals ON
								   starter_pharmaceuticals.company_id=starter_dgds.company
								   
								   ORDER BY starter_dgds.id DESC LIMIT 15");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_dgds', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('starter_dgds', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_dgds WHERE starter_dgds.id='$id' LIMIT 1");
		return $query->row_array();
	}
	
	public function get_companies()
	{
		$query = $this->db->query("SELECT company_id, company_name FROM starter_pharmaceuticals ORDER BY company_name ASC");
		return $query->result_array();
	}
	
}