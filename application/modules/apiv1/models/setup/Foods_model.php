<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Foods_model extends CI_Model {
	
	public function get_all_items()
	{
		$query = $this->db->query("SELECT * FROM starter_food_items ORDER BY starter_food_items.food_id DESC");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('starter_food_items', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('food_id', $id);
		$this->db->update('starter_food_items', $data);
	}

	public function get_info($id)
	{
		$query = $this->db->query("SELECT * FROM starter_food_items WHERE starter_food_items.food_id='$id' LIMIT 1");
		return $query->row_array();
	}
	
}