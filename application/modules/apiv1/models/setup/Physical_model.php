<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Physical_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_physical_activities ORDER BY starter_physical_activities.activity_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_physical_activities', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('activity_id', $id);
		$this->db->update('starter_physical_activities', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_physical_activities WHERE starter_physical_activities.activity_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}