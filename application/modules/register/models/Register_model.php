<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {
	
	public function get_all_organizations()
	{
		$query = $this->db->query("SELECT org_id, org_name FROM starter_organizations ORDER BY starter_organizations.org_id ASC");
		return $query->result_array();
	}
	
	public function get_all_divisions()
	{
		$query = $this->db->query("SELECT * FROM starter_divisions ORDER BY starter_divisions.division_id ASC");
		return $query->result_array();
	}
	
	public function get_patient($bndr)
	{
		$query = $this->db->query("SELECT * FROM `starter_patients` where patient_entryid = '$bndr'");
		return $query->row_array();
	}
	
	public function qr_printed($bndrID,$qrNumber,$userId,$userType,$date)
	{
		$query = $this->db->query("update starter_patients set qr_code = '$qrNumber' , qrcode_userid = '$userId' , qrcode_usertype = '$userType' , qr_time = '$date'  WHERE patient_entryid  = '$bndrID' ");
		
	}
	public function get_all_centers($org_id)
	{
		$query = $this->db->query("SELECT orgcenter_id, orgcenter_name FROM starter_centers WHERE starter_centers.orgcenter_org_id='$org_id' ORDER BY starter_centers.orgcenter_id ASC");
		return $query->result_array();
	}
	
	public function get_ch($pid)
	{
		$query = $this->db->query("SELECT * FROM `starter_patient_visit`
			where visit_is = 'CASE_HISTORY' and visit_patient_id = $pid and visit_form_version = 'v1' order by visit_admit_date desc  ");
		return $query->result_array();
	}
	
	public function update_multiplevisit($pid,$vid2,$data)
	{
		$query = $this->db->query("update starter_patient_visit2 set compile_info = 'yes' where visit_patient_id = $pid ");
		if ($this->db->affected_rows() > 0)
			{
			  $this->db->query("delete from starter_patient_visit where visit_id = $vid2 ");
			  $this->db->insert('starter_patient_visit_deleted', $data);
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
	}
	
	public function insert_visit($data,$vid2)
	{
		$this->db->query("delete from starter_patient_visit where visit_id = $vid2 ");
		$query = $this->db->insert('starter_patient_visit_deleted', $data);
	}
	
	public function get_general_examinations_old($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations WHERE starter_visit_general_examinations.generalexam_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	
	public function get_general_examinations_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_general_examinations WHERE starter_visit_general_examinations.generalexam_visit_id='$vid2' and generalexam_name = '$name' ");
		return $query->result_array();
	}
	
	public function insert_gm($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_visit_general_examinations_compile', $data);
		$this->db->query("delete from starter_visit_general_examinations where generalexam_name = '$name' and generalexam_visit_id = $vid ");
		
	}
	
	public function update_gm($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_general_examinations_compile', $data);
		$this->db->query("update starter_visit_general_examinations set generalexam_visit_id = $vid1 where generalexam_name = '$name' and generalexam_visit_id = $vid2 ");
		
	}
	
	public function delete_gm($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_general_examinations_compile', $data);
		$this->db->query("delete from starter_visit_general_examinations where generalexam_name = '$name' and generalexam_visit_id = $vid2 ");
		
	}
	
	public function get_laboratory($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_investigations WHERE labinvs_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_lab_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_investigations WHERE labinvs_visit_id='$vid2' and labinvs_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_lab($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_visit_laboratory_investigations_compile', $data);
		$this->db->query("delete from starter_visit_laboratory_investigations where labinvs_name = '$name' and labinvs_visit_id = $vid ");
		
	}
	
	public function delete_lab($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_laboratory_investigations_compile', $data);
		$this->db->query("delete from starter_visit_laboratory_investigations where labinvs_name = '$name' and labinvs_visit_id = $vid2 ");
		
	}
	
	public function update_lab($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_laboratory_investigations_compile', $data);
		$this->db->query("update starter_visit_laboratory_investigations set labinvs_visit_id = $vid1 where labinvs_name = '$name' and labinvs_visit_id = $vid2 ");
		
	}
	
	public function get_ecg($vid1)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_laboratory_ecg WHERE ecg_visit_id='$vid1' ");
		return $query->row_array();
	}
	
	public function delete_ecg($data,$vid1,$vid2)
	{
		
		$query = $this->db->insert('starter_visit_laboratory_ecg_compile', $data);
		$this->db->query("delete from starter_visit_laboratory_ecg where ecg_visit_id = $vid2 ");
		
	}
	
	public function update_ecg($data,$vid1,$vid2)
	{
		
		$query = $this->db->insert('starter_visit_laboratory_ecg_compile', $data);
		$this->db->query("update starter_visit_laboratory_ecg set ecg_visit_id = $vid1 where ecg_visit_id = $vid2 ");
		
	}
	
	public function get_complications($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_visit_complication WHERE vcomplication_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_complication_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_complication WHERE vcomplication_visit_id = '$vid2' and vcomplication_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_complication($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_visit_complication_compile', $data);
		$this->db->query("delete from starter_visit_complication where vcomplication_name = '$name' and vcomplication_visit_id = $vid ");
		
	}
	
	public function update_complication($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_complication_compile', $data);
		$this->db->query("update starter_visit_complication set vcomplication_visit_id = $vid1 where vcomplication_name = '$name' and vcomplication_visit_id = $vid2 ");
		
	}
	
	public function get_p_habit($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_visit_personal_habits WHERE phabit_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_p_habit_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_personal_habits WHERE phabit_visit_id = '$vid2' and phabit_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_p_habit($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_visit_personal_habits_compile', $data);
		$this->db->query("delete from starter_visit_personal_habits where phabit_name = '$name' and phabit_visit_id = $vid ");
		
	}
	
	public function update_p_habit($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_personal_habits_compile', $data);
		$this->db->query("update starter_visit_personal_habits set phabit_visit_id = $vid1 where phabit_name = '$name' and phabit_visit_id = $vid2 ");
		
	}
	
	public function get_f_histories($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_visit_family_history WHERE fmhistory_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_f_history_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_visit_family_history WHERE fmhistory_visit_id = '$vid2' and fmhistory_label = '$name' ");
		return $query->row_array();
	}
	
	public function insert_f_history($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_visit_family_history_compile', $data);
		$this->db->query("delete from starter_visit_family_history where fmhistory_label = '$name' and fmhistory_visit_id = $vid ");
		
	}
	
	public function update_f_history_field($field,$value,$name,$vid)
	{
		
		$this->db->query("update  starter_visit_family_history set $field = '$value'  where fmhistory_label = '$name' and fmhistory_visit_id = $vid ");
		
	}
	
	public function update_f_history($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_visit_family_history_compile', $data);
		$this->db->query("update starter_visit_family_history set fmhistory_visit_id = $vid1 where fmhistory_label = '$name' and fmhistory_visit_id = $vid2 ");
		
	}
	
	public function get_prv_d_histories($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_dietary_history WHERE diehist_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_d_history_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_dietary_history WHERE diehist_visit_id = '$vid2' and diehist_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_d_history($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvadv_dietary_history_compile', $data);
		$this->db->query("delete from starter_prvadv_dietary_history where diehist_name = '$name' and diehist_visit_id = $vid ");
		
	}
	
	public function update_prv_d_history($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvadv_dietary_history_compile', $data);
		$this->db->query("update starter_prvadv_dietary_history set diehist_visit_id = $vid1 where diehist_name = '$name' and diehist_visit_id = $vid2 ");
		
	}
	
	public function get_prv_co($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_cooking_oil WHERE cooking_oil_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_coil_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_cooking_oil WHERE cooking_oil_visit_id = '$vid2' and cooking_oil_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_coil($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvadv_cooking_oil_compile', $data);
		$this->db->query("delete from starter_prvadv_cooking_oil where cooking_oil_name = '$name' and cooking_oil_visit_id = $vid ");
		
	}
	
	public function update_prv_coil($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvadv_cooking_oil_compile', $data);
		$this->db->query("update starter_prvadv_cooking_oil set cooking_oil_visit_id = $vid1 where cooking_oil_name = '$name' and cooking_oil_visit_id = $vid2 ");
		
	}
	
	public function get_prv_p_activity($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_physical_activity WHERE physical_act_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_p_activity_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvadv_physical_activity WHERE physical_act_visit_id = '$vid2' and physical_act_type = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_p_activity($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvadv_physical_activity_compile', $data);
		$this->db->query("delete from starter_prvadv_physical_activity where physical_act_type = '$name' and physical_act_visit_id = $vid ");
		
	}
	
	public function update_prv_p_activity($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvadv_physical_activity_compile', $data);
		$this->db->query("update starter_prvadv_physical_activity set physical_act_visit_id = $vid1 where physical_act_type = '$name' and physical_act_visit_id = $vid2 ");
		
	}
	
	public function get_prv_anti_htns($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_htn WHERE anti_htn_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_anti_htn_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_htn WHERE anti_htn_visit_id = '$vid2' and anti_htn_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_anti_htn($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_htn_compile', $data);
		$this->db->query("delete from starter_prvomedication_anti_htn where anti_htn_name = '$name' and anti_htn_visit_id = $vid ");
		
	}
	
	public function update_prv_anti_htn($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_htn_compile', $data);
		$this->db->query("update starter_prvomedication_anti_htn set anti_htn_visit_id = $vid1 where anti_htn_name = '$name' and anti_htn_visit_id = $vid2 ");
		
	}
	
	public function get_prv_anti_lipids($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_lipids WHERE anti_lipid_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_anti_lipid_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_lipids WHERE anti_lipid_visit_id = '$vid2' and anti_lipid_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_anti_lipid($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_lipids_compile', $data);
		$this->db->query("delete from starter_prvomedication_anti_lipids where anti_lipid_name = '$name' and anti_lipid_visit_id = $vid ");
		
	}
	
	public function update_prv_anti_lipid($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_lipids_compile', $data);
		$this->db->query("update starter_prvomedication_anti_lipids set anti_lipid_visit_id = $vid1 where anti_lipid_name = '$name' and anti_lipid_visit_id = $vid2 ");
		
	}
	
	public function get_prv_anti_obesity($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_obesity WHERE anti_obesity_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_anti_obesity_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_anti_obesity WHERE anti_obesity_visit_id = '$vid2' and anti_obesity_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_anti_obesity($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_obesity_compile', $data);
		$this->db->query("delete from starter_prvomedication_anti_obesity where anti_obesity_name = '$name' and anti_obesity_visit_id = $vid ");
		
	}
	
	public function update_prv_anti_obesity($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvomedication_anti_obesity_compile', $data);
		$this->db->query("update starter_prvomedication_anti_obesity set anti_obesity_visit_id = $vid1 where anti_obesity_name = '$name' and anti_obesity_visit_id = $vid2 ");
		
	}
	
	public function get_prv_other($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_other WHERE other_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_prv_other_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_prvomedication_other WHERE other_visit_id = '$vid2' and other_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_prv_other($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_prvomedication_other_compile', $data);
		$this->db->query("delete from starter_prvomedication_other where other_name = '$name' and other_visit_id = $vid ");
		
	}
	
	public function update_prv_other($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_prvomedication_other_compile', $data);
		$this->db->query("update starter_prvomedication_other set other_visit_id = $vid1 where other_name = '$name' and other_visit_id = $vid2 ");
		
	}
	
	
	public function get_crnt_d_histories($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_dietary_history WHERE diehist_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_d_history_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_dietary_history WHERE diehist_visit_id = '$vid2' and diehist_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_d_history($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntadv_dietary_history_compile', $data);
		$this->db->query("delete from starter_crntadv_dietary_history where diehist_name = '$name' and diehist_visit_id = $vid ");
		
	}
	
	public function update_crnt_d_history($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntadv_dietary_history_compile', $data);
		$this->db->query("update starter_crntadv_dietary_history set diehist_visit_id = $vid1 where diehist_name = '$name' and diehist_visit_id = $vid2 ");
		
	}
	
	public function get_crnt_co($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_cooking_oil WHERE cooking_oil_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_coil_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_cooking_oil WHERE cooking_oil_visit_id = '$vid2' and cooking_oil_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_coil($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntadv_cooking_oil_compile', $data);
		$this->db->query("delete from starter_crntadv_cooking_oil where cooking_oil_name = '$name' and cooking_oil_visit_id = $vid ");
		
	}
	
	public function update_crnt_coil($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntadv_cooking_oil_compile', $data);
		$this->db->query("update starter_crntadv_cooking_oil set cooking_oil_visit_id = $vid1 where cooking_oil_name = '$name' and cooking_oil_visit_id = $vid2 ");
		
	}
	
	public function get_crnt_p_activity($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_physical_activity WHERE physical_act_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_p_activity_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntadv_physical_activity WHERE physical_act_visit_id = '$vid2' and physical_act_type = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_p_activity($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntadv_physical_activity_compile', $data);
		$this->db->query("delete from starter_crntadv_physical_activity where physical_act_type = '$name' and physical_act_visit_id = $vid ");
		
	}
	
	public function update_crnt_p_activity($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntadv_physical_activity_compile', $data);
		$this->db->query("update starter_crntadv_physical_activity set physical_act_visit_id = $vid1 where physical_act_type = '$name' and physical_act_visit_id = $vid2 ");
		
	}
	
	
	public function get_crnt_anti_htns($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn WHERE anti_htn_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_anti_htn_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_htn WHERE anti_htn_visit_id = '$vid2' and anti_htn_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_anti_htn($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_htn_compile', $data);
		$this->db->query("delete from starter_crntomedication_anti_htn where anti_htn_name = '$name' and anti_htn_visit_id = $vid ");
		
	}
	
	public function update_crnt_anti_htn($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_htn_compile', $data);
		$this->db->query("update starter_crntomedication_anti_htn set anti_htn_visit_id = $vid1 where anti_htn_name = '$name' and anti_htn_visit_id = $vid2 ");
		
	}
	
	
	public function get_crnt_anti_lipids($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids WHERE anti_lipid_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_anti_lipid_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_lipids WHERE anti_lipid_visit_id = '$vid2' and anti_lipid_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_anti_lipid($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_lipids_compile', $data);
		$this->db->query("delete from starter_crntomedication_anti_lipids where anti_lipid_name = '$name' and anti_lipid_visit_id = $vid ");
		
	}
	
	public function update_crnt_anti_lipid($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_lipids_compile', $data);
		$this->db->query("update starter_crntomedication_anti_lipids set anti_lipid_visit_id = $vid1 where anti_lipid_name = '$name' and anti_lipid_visit_id = $vid2 ");
		
	}
	
	public function get_crnt_anti_obesity($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity WHERE anti_obesity_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_anti_obesity_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_anti_obesity WHERE anti_obesity_visit_id = '$vid2' and anti_obesity_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_anti_obesity($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_obesity_compile', $data);
		$this->db->query("delete from starter_crntomedication_anti_obesity where anti_obesity_name = '$name' and anti_obesity_visit_id = $vid ");
		
	}
	
	public function update_crnt_anti_obesity($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntomedication_anti_obesity_compile', $data);
		$this->db->query("update starter_crntomedication_anti_obesity set anti_obesity_visit_id = $vid1 where anti_obesity_name = '$name' and anti_obesity_visit_id = $vid2 ");
		
	}
	
	
	public function get_crnt_other($visit_id )
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_others WHERE other_visit_id='$visit_id' ");
		return $query->result_array();
	}
	
	public function get_crnt_other_vid2($vid2, $name)
	{
		$query = $this->db->query("SELECT * FROM starter_crntomedication_others WHERE other_visit_id = '$vid2' and other_name = '$name' ");
		return $query->row_array();
	}
	
	public function insert_crnt_other($data,$name,$vid)
	{
		
		$query = $this->db->insert('starter_crntomedication_others_compile', $data);
		$this->db->query("delete from starter_crntomedication_others where other_name = '$name' and other_visit_id = $vid ");
		
	}
	
	public function update_crnt_other($data,$vid1,$vid2,$name)
	{
		
		$query = $this->db->insert('starter_crntomedication_others_compile', $data);
		$this->db->query("update starter_crntomedication_others set other_visit_id = $vid1 where other_name = '$name' and other_visit_id = $vid2 ");
		
	}
	
	public function update_visit($vid1,$visit_has_symptomatic,$visit_symptomatic_type,$visit_patient_type,$visit_diabetes_duration,$visit_types_of_diabetes,$visit_guidebook_no)
	{
		$query = $this->db->query("update starter_patient_visit set  visit_has_symptomatic = $visit_has_symptomatic , visit_symptomatic_type = '$visit_symptomatic_type' , visit_patient_type = '$visit_patient_type' ,
			visit_diabetes_duration = '$visit_diabetes_duration' , visit_types_of_diabetes = '$visit_types_of_diabetes' , visit_guidebook_no = '$visit_guidebook_no' where visit_id = $vid1 ");
		//return $query->result_array();
		if ($this->db->affected_rows() > 0)
			{
			  return TRUE;
			}
			else
			{
			  return FALSE;
			}
	}
	
	
	
	
	public function get_all_doctors($center_id)
	{
		$query = $this->db->query("SELECT doctor_org_centerid , doctor_full_name  FROM starter_doctors WHERE starter_doctors.doctor_org_centerid='$center_id' ORDER BY starter_doctors.doctor_full_name ASC");
		return $query->result_array();
	}
	
	public function get_all_operators($center_id)
	{
		$query = $this->db->query("SELECT operator_org_centerid , operator_full_name  FROM starter_operators WHERE starter_operators.operator_org_centerid='$center_id' ORDER BY starter_operators.operator_full_name ASC");
		return $query->result_array();
	}
	
	public function get_all_districts($division_id)
	{
		$query = $this->db->query("SELECT * FROM starter_districts WHERE starter_districts.district_division_id='$division_id' ORDER BY starter_districts.district_id ASC");
		return $query->result_array();
	}
	
	public function get_all_upazilas($district_id)
	{
		$query = $this->db->query("SELECT * FROM starter_upazilas WHERE starter_upazilas.upazila_district_id='$district_id' ORDER BY starter_upazilas.upazila_id ASC");
		return $query->result_array();
	}
	
	public function get_total_doctortoday($date)
	{
		$query = $this->db->query("SELECT doctor_id FROM starter_doctors WHERE doctor_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
	public function get_total_assistanttoday($date)
	{
		$query = $this->db->query("SELECT assistant_id FROM starter_doctor_assistants WHERE assistant_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
	public function get_total_operatortoday($date)
	{
		$query = $this->db->query("SELECT operator_id FROM starter_operators WHERE operator_create_date LIKE '%$date%'");
		return $query->num_rows();
	}
	
	public function create_doctor_account($data)
	{
		$this->db->insert('starter_doctors', $data);
	}
	
	public function create_assistant_account($data)
	{
		$this->db->insert('starter_doctor_assistants', $data);
	}
	
	public function create_operator_account($data)
	{
		$this->db->insert('starter_operators', $data);
	}
	
}