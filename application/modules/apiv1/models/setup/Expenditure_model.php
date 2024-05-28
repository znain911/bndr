<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditure_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_monthly_expenditures ORDER BY starter_monthly_expenditures.expenditure_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_monthly_expenditures', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('expenditure_id', $id);
		$this->db->update('starter_monthly_expenditures', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_monthly_expenditures WHERE starter_monthly_expenditures.expenditure_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}