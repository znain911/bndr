<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function current_url()
{
    $CI =& get_instance();
    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
}

// function for sms
function sendsms($number, $message)
{
	$user = "cthealth";
	$pass = "CT@ihUHCC11";
	$sid = "BNDREng";
	$url="http://sms.sslwireless.com/pushapi/dynamic/server.php";
	$param="user=$user&pass=$pass&sms[0][0]=$number&sms[0][1]=".urlencode($message)."&sid=$sid";
	$crl = curl_init();
	curl_setopt($crl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($crl,CURLOPT_SSL_VERIFYHOST,2);
	curl_setopt($crl,CURLOPT_URL,$url); 
	curl_setopt($crl,CURLOPT_HEADER,0);
	curl_setopt($crl,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($crl,CURLOPT_POST,1);
	curl_setopt($crl,CURLOPT_POSTFIELDS,$param); 
	$response = curl_exec($crl);
	curl_close($crl);
}

function menu_item_activate($url_param)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(1);
	
	if($segment == $url_param)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_item_activate($url_param, $url_param2)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	$segment2 = $url->uri->segment(3);
	
	if($segment == $url_param && $segment2 == $url_param2)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_singleitem_queryactivate($url_param, $key, $value)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	
	if($segment == $url_param && isset($_GET[$key]) && $_GET[$key] === $value)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function submenu_item_queryactivate($url_param, $url_param2, $key, $value)
{
	$CI =& get_instance();
	$url = $CI->load->helper('url');
	
	$segment = $url->uri->segment(2);
	$segment2 = $url->uri->segment(3);
	
	if($segment == $url_param && $segment2 == $url_param2 && isset($_GET[$key]) && $_GET[$key] === $value)
	{
		return 'active';
	}else
	{
		return null;
	}
	
}

function active_chat_link($param, $value, $param3=false)
{
	if(isset($_GET[$param]) && $_GET[$param] === $value)
	{
		$class = 'btn-success active';
	}elseif(!isset($_GET[$param]) && $param3 !== false){
		$class = 'btn-success active';
	}else{
		$class = null;
	}
	return $class;
}

/******For Local Environment******/
/*
function attachment_dir($param=null)
{
	if($param !== null)
	{
		$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/".$param;
	}else
	{
		$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/";
	}
	
	return $dir;
}

function attachment_url($param=null)
{
	if($param !== null)
	{
		$url = "https://registry.elitjobs.com/attachments/".$param;
	}else
	{
		$url = "https://registry.elitjobs.com/attachments/";
	}
	
	return $url;
}
*/


/******For Local Environment******/

function attachment_dir($param=null)
{
	if($param !== null)
	{
		if ($_SERVER['HTTP_HOST']=='app.bndr-org.com.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/".$param;
		}
		else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/registry/attachments/".$param;
		}
	}else
	{
		if ($_SERVER['HTTP_HOST']=='app.bndr-org.com.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/attachments/";
		}
		else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/registry/attachments/";
		}
	}
	
	return $dir;
}

function import_dir($param=null)
{
	if($param !== null)
	{
		if ($_SERVER['HTTP_HOST']=='staging.bndr-org.com.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/excels/".$param;
		}
		else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/registry/excels/".$param;
		}
	}else{
		if ($_SERVER['HTTP_HOST']=='staging.bndr-org.com.bd') {
			$dir = $_SERVER['DOCUMENT_ROOT']."/excels/";
		}
		else{
			$dir = $_SERVER['DOCUMENT_ROOT']."/registry/excels/";
		}
	}
	
	return $dir;
}

function attachment_url($param=null)
{
	if($param !== null)
	{
		if ($_SERVER['HTTP_HOST']=='app.bndr-org.com.bd') {
			$url = "https://app.bndr-org.com.bd/attachments/".$param;
		}
		else{
			$url = "http://localhost/registry/attachments/".$param;
		}
	}else
	{
		if ($_SERVER['HTTP_HOST']=='app.bndr-org.com.bd') {
			$url = "https://app.bndr-org.com.bd/attachments/";
		}
		else{
			$url = "http://localhost/registry/attachments/";
		}
	}
	
	return $url;
}

function get_age($birth_date=null)
{
	if($birth_date !== null)
	{
		$birthDate = $birth_date;
		//explode the date to get month, day and year
		$birthDate = explode("-", $birthDate);
		if(isset($birthDate[0]) && isset($birthDate[1]) && isset($birthDate[2]))
		{
			//get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")? ((date("Y") - $birthDate[0]) - 1): (date("Y") - $birthDate[0]));
		}else{
			$age = null;
		}
	}else
	{
		$age = null;
	}
	return $age;
}

function get_birth_date($age=null)
{
	if($age !== null)
	{
		$year = $age;
		$birth_date = date('Y-m-d',strtotime(date("Y-m-d", time()) . " - {$year} year"));
	}else
	{
		$birth_date = null;
	}
	
	return $birth_date;
}

function formated_date($date=null)
{
	if($date !== null)
	{
		$format_date = date("d/m/Y", strtotime($date));
		return $format_date;
	}else{
		return null;
	}
}

function db_formated_date($date=null)
{
	if($date !== null)
	{
		$string = str_replace('/', '-', $date);
		$format_date = date("Y-m-d", strtotime($string));
		return $format_date;
	}else{
		return null;
	}
}

function payment_config($type)
{
	$CI =& get_instance();
	if($type == 'reg')
	{
		$tpe = 'config_option';
	}elseif($type == 'visit'){
		$tpe = 'config_option_two';
	}else{
		$tpe = 'config_option';
	}
	$query = $CI->db->query("SELECT $tpe FROM starter_configuration WHERE starter_configuration.config_key='REG_FEE' LIMIT 1");
	return $query->row_array();
}

function get_month_wise_fees($month, $org_id,$type=null,$keywords=null)
{
	if($month && $org_id && $keywords !== null)
	{
		//$total_reg_fee   = get_reg_fees_of_month_of_org($month, $org_id, $type);
		//$total_visit_fee = get_visit_fees_of_month_of_org($month, $org_id, $type);
		
		$total_regs      = get_regs_of_month_of_center($month, $org_id, $type);
		$total_visits    = get_visits_of_month_of_center($month, $org_id, $type);
		
		$reg_fee = payment_config('reg');
		$visit_fee = payment_config('visit');
		
		$total_reg_fee   = $total_regs * $reg_fee['config_option'];
		$total_visit_fee = $total_visits * $visit_fee['config_option_two'];
		
		$total_amount    = $total_reg_fee + $total_visit_fee;
		
		return array(
					'total_reg_fee'   => $total_reg_fee,
					'total_visit_fee' => $total_visit_fee,
					'total_regs'      => $total_regs,
					'total_visits'    => $total_visits,
					'total_amount'    => $total_amount,
				);
	}else if($month && $org_id )
	{
		//$total_reg_fee   = get_reg_fees_of_month_of_org($month, $org_id, $type);
		//$total_visit_fee = get_visit_fees_of_month_of_org($month, $org_id, $type);
		
		$total_regs      = get_regs_of_month_of_org($month, $org_id, $type);
		$total_visits    = get_visits_of_month_of_org($month, $org_id, $type);
		
		$reg_fee = payment_config('reg');
		$visit_fee = payment_config('visit');
		
		$total_reg_fee   = $total_regs * $reg_fee['config_option'];
		$total_visit_fee = $total_visits * $visit_fee['config_option_two'];
		
		$total_amount    = $total_reg_fee + $total_visit_fee;
		
		return array(
					'total_reg_fee'   => $total_reg_fee,
					'total_visit_fee' => $total_visit_fee,
					'total_regs'      => $total_regs,
					'total_visits'    => $total_visits,
					'total_amount'    => $total_amount,
				);
	}else{
		return array();
	}
}

function get_orgs_by_keywords($keywords)
{
	$CI =& get_instance();
	$query = "SELECT org_id FROM starter_organizations ";
		
	if($keywords !== ''){
		$search_term = $keywords;
		$query .= "WHERE (org_name LIKE '%$search_term%' ";
		$query .= "OR org_code LIKE '%$search_term%') ";
	}
	$query = $CI->db->query($query);
	return $query->result_array();
}
function get_centers_by_keywords($keywords)
{
	$CI =& get_instance();
	$query = "SELECT  orgcenter_id as org_id FROM starter_centers ";
		
	if($keywords !== ''){
		$search_term = $keywords;
		$query .= "WHERE (orgcenter_name LIKE '%$search_term%' ";
		$query .= "OR orgcenter_code LIKE '%$search_term%') ";
	}
	$query = $CI->db->query($query);
	return $query->result_array();
}

function get_year_wise_total_amount($year, $keywords, $type=null,$admin = null)
{
	if($year && $admin !== null)
	{
		$orgs = get_centers_by_keywords($keywords);
		$total_amount = 0;
		$reg_fee = payment_config('reg');
		$visit_fee = payment_config('visit');
		foreach($orgs as $org)
		{
			$org_id = $org['org_id'];
			
			$total_reg = get_reg_fees_of_the_year_of_center($year, $org_id, $type);
			$total_visit = get_visit_fees_of_the_year_of_center($year, $org_id, $type);
		
			$total_reg_fee   = $total_reg * $reg_fee['config_option'];
			$total_visit_fee = $total_visit * $visit_fee['config_option_two'];
			$total_amount += $total_reg_fee + $total_visit_fee;
		}
		
		return $total_amount;
	}else if($year)
	{
		$orgs = get_orgs_by_keywords($keywords);
		$total_amount = 0;
		$reg_fee = payment_config('reg');
		$visit_fee = payment_config('visit');
		foreach($orgs as $org)
		{
			$org_id = $org['org_id'];
			
			$total_reg = get_reg_fees_of_the_year_of_org($year, $org_id, $type);
			$total_visit = get_visit_fees_of_the_year_of_org($year, $org_id, $type);
		
			$total_reg_fee   = $total_reg * $reg_fee['config_option'];
			$total_visit_fee = $total_visit * $visit_fee['config_option_two'];
			$total_amount += $total_reg_fee + $total_visit_fee;
		}
		
		return $total_amount;
	}else{
		return 0;
	}
}

function get_reg_fees_of_month_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND patient_payment_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND patient_payment_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT patient_id FROM starter_patients 
							   WHERE patient_create_date LIKE '%$the_month%'
							   AND patient_org_id='$org_id' $where_cls");
	return $query->num_rows();
}

function get_reg_fees_of_the_year_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND patient_payment_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND patient_payment_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT patient_id FROM starter_patients 
							   WHERE patient_create_date LIKE '%$the_month%'
							   AND patient_org_id='$org_id' $where_cls");
	return $query->num_rows();
}
function get_reg_fees_of_the_year_of_center($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND patient_payment_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND patient_payment_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT patient_id FROM starter_patients 
							   WHERE patient_create_date LIKE '%$the_month%'
							   AND patient_org_centerid='$org_id' $where_cls");
	return $query->num_rows();
}

function get_regs_of_month_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND patient_payment_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND patient_payment_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT patient_id FROM starter_patients 
							   WHERE patient_create_date LIKE '%$the_month%'
							   AND patient_org_id='$org_id' $where_cls");
	$results = $query->num_rows();
	return $results;
}
function get_regs_of_month_of_center($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND patient_payment_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND patient_payment_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT patient_id FROM starter_patients 
							   WHERE patient_create_date LIKE '%$the_month%'
							   AND patient_org_centerid= '$org_id' $where_cls");
	$results = $query->num_rows();
	return $results;
}

function get_visit_fees_of_month_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND payment_patient_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND payment_patient_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT payment_patient_status 
							   FROM starter_patient_visit 
							   
							   LEFT JOIN starter_visit_payments ON
							   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
							   
							   WHERE visit_admit_date LIKE '%$the_month%'
							   AND visit_org_id='$org_id' $where_cls");
	return $query->num_rows();
}

function get_visit_fees_of_the_year_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND payment_patient_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND payment_patient_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT payment_patient_status 
							   FROM starter_patient_visit 
							   
							   LEFT JOIN starter_visit_payments ON
							   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
							   
							   WHERE visit_admit_date LIKE '%$the_month%'
							   AND visit_org_id='$org_id' $where_cls");
	return $query->num_rows();
}

function get_visit_fees_of_the_year_of_center($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND payment_patient_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND payment_patient_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT payment_patient_status 
							   FROM starter_patient_visit 
							   
							   LEFT JOIN starter_visit_payments ON
							   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
							   
							   WHERE visit_admit_date LIKE '%$the_month%'
							   AND visit_org_centerid='$org_id' $where_cls");
	return $query->num_rows();
}

function get_visits_of_month_of_org($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND payment_patient_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND payment_patient_status='0'";
		}
	}else{
		$where_cls = null;
	}
	
	$the_month = $month;
	$query = $CI->db->query("SELECT visit_id, payment_patient_status 
							   FROM starter_patient_visit 
							   
							   LEFT JOIN starter_visit_payments ON
							   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
							   
							   WHERE visit_admit_date LIKE '%$the_month%'
							   AND visit_org_id='$org_id'  $where_cls");
	$results = $query->num_rows();
	return $results;
}

function get_visits_of_month_of_center($month, $org_id, $type=null)
{
	$CI =& get_instance();
	
	if($type !== null)
	{
		if($type == 'PAID')
		{
			$where_cls = "AND payment_patient_status='1'";
		}elseif($type == 'UNPAID'){
			$where_cls = "AND payment_patient_status='0'";
		}
	}else{
		$where_cls = null;
	}
	$the_month = $month;
	$query = $CI->db->query("SELECT visit_id, payment_patient_status 
							   FROM starter_patient_visit 
							   
							   LEFT JOIN starter_visit_payments ON
							   starter_visit_payments.payment_visit_id=starter_patient_visit.visit_id
							   
							   WHERE visit_admit_date LIKE '%$the_month%'
							   AND visit_org_centerid = '$org_id' $where_cls");
	$results = $query->num_rows();
	return $results;
}

function get_admitted_by($user_id, $user_type, $sync_id=null)
{
	$CI =& get_instance();
	
	//Check if the user is Administrator
	if(isset($user_id) && $user_type == 'Administrator'){
		$query = $CI->db->query("SELECT owner_name FROM starter_owner WHERE owner_id='$user_id'");
		$result = $query->row_array();
		if($result['owner_name'])
		{
			return $result['owner_name'].'<strong>(Administrator)</strong>';
		}else{
			return null;
		}
	}
	//Check if the user is Operator
	if(isset($user_id) && $user_type == 'Operator'){
		if($sync_id !== null && $sync_id !== '')
		{
			$query = $CI->db->query("SELECT operator_full_name FROM starter_operators WHERE operator_sync_id='$sync_id'");
			$result = $query->row_array();
		}else{
			$query = $CI->db->query("SELECT operator_full_name FROM starter_operators WHERE operator_id='$user_id'");
			$result = $query->row_array();
		}
		if($result['operator_full_name'])
		{
			return $result['operator_full_name'].'<strong>(Operator)</strong>';
		}else{
			return null;
		}
	}
	
	if(isset($user_id) && $user_type == 'Super Operator'){
		if($sync_id !== null && $sync_id !== '')
		{
			$query = $CI->db->query("SELECT operator_full_name FROM starter_operators WHERE operator_sync_id='$sync_id'");
			$result = $query->row_array();
		}else{
			$query = $CI->db->query("SELECT operator_full_name FROM starter_operators WHERE operator_id='$user_id'");
			$result = $query->row_array();
		}
		if($result['operator_full_name'])
		{
			return $result['operator_full_name'].'<strong>(Operator)</strong>';
		}else{
			return null;
		}
	}
	
	//Check if the user is Doctor
	if(isset($user_id) && $user_type == 'Doctor'){
		$query = $CI->db->query("SELECT doctor_full_name FROM starter_doctors WHERE doctor_id='$user_id'");
		$result = $query->row_array();
		if($result['doctor_full_name'])
		{
			return $result['doctor_full_name'].'<strong>(Doctor)</strong>';
		}else{
			return null;
		}
	}
	//Check if the user is Doctor Assistant
	if(isset($user_id) && $user_type == 'Assistant'){
		$query = $CI->db->query("SELECT assistant_full_name FROM starter_doctor_assistants WHERE assistant_id='$user_id'");
		$result = $query->row_array();
		if($result['assistant_full_name'])
		{
			return $result['assistant_full_name'].'<strong>(Doctor Assistant)</strong>';
		}else{
			return null;
		}
	}
	
	return null;
}

function has_no_case_history($patient_id)
{
	$CI =& get_instance();
	$query = $CI->db->query("SELECT visit_id FROM starter_patient_visit WHERE visit_patient_id='$patient_id' and visit_is = 'CASE_HISTORY'");
	$result = $query->row_array();
	if($result == true)
	{
		return false;
	}else{
		return true;
	}
}

function total_patients_of_the_center($params, $center)
{
	$CI =& get_instance();
	$query = "SELECT patient_id FROM starter_patients WHERE patient_org_centerid='$center'";
	
	if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
		$from_date = $params['search']['from_date'];
		$stop_date = $params['search']['to_date'];
		$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
		$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
	
	}
	
	if(!empty($params['search']['month']) && !empty($params['search']['year'])){
		$month = $params['search']['month'];
		$year = $params['search']['year'];
		$date = $year.'-'.$month.'-';
		$query .= "AND patient_create_date LIKE '%$date%' ";
	}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
		if(!empty($params['search']['month']))
		{
			$month = $params['search']['month'];
			$year = date("Y");
			$date = $year.'-'.$month.'-'; 
			$query .= "AND patient_create_date LIKE '%$date%' ";
		}elseif(!empty($params['search']['year'])){
			$year = $params['search']['year'];
			$date = $year.'-'; 
			$query .= "AND patient_create_date LIKE '%$date%' ";
		}
	}
	
	$result = $CI->db->query($query);
	return $result->num_rows();
}

function total_visits_of_the_center($params, $center)
{
	$CI =& get_instance();
	$query = "SELECT visit_id FROM starter_patient_visit WHERE visit_org_centerid='$center' ";
	
	if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
		$from_date = $params['search']['from_date'];
		$stop_date = $params['search']['to_date'];
		$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
		$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
	
	}
	
	if(!empty($params['search']['month']) && !empty($params['search']['year'])){
		$month = $params['search']['month'];
		$year = $params['search']['year'];
		$date = $year.'-'.$month.'-';
		$query .= "AND visit_admit_date LIKE '%$date%' ";
	}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
		if(!empty($params['search']['month']))
		{
			$month = $params['search']['month'];
			$year = date("Y");
			$date = $year.'-'.$month.'-'; 
			$query .= "AND visit_admit_date LIKE '%$date%' ";
		}elseif(!empty($params['search']['year'])){
			$year = $params['search']['year'];
			$date = $year.'-'; 
			$query .= "AND visit_admit_date LIKE '%$date%' ";
		}
	}
	
	$result = $CI->db->query($query);
	return $result->num_rows();
}

function total_patients_of_the_operator($params, $center, $operator)
{
	$CI =& get_instance();
	$query = "SELECT patient_id FROM starter_patients 
			 WHERE patient_admitted_by='$operator' 
			 AND patient_admitted_user_type='Operator'
			 AND patient_org_centerid='$center' ";
	
	if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
		$from_date = $params['search']['from_date'];
		$stop_date = $params['search']['to_date'];
		$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
		$query .= "AND patient_create_date BETWEEN '$from_date' AND '$to_date' ";
	
	}
	
	if(!empty($params['search']['month']) && !empty($params['search']['year'])){
		$month = $params['search']['month'];
		$year = $params['search']['year'];
		$date = $year.'-'.$month.'-';
		$query .= "AND patient_create_date LIKE '%$date%' ";
	}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
		if(!empty($params['search']['month']))
		{
			$month = $params['search']['month'];
			$year = date("Y");
			$date = $year.'-'.$month.'-'; 
			$query .= "AND patient_create_date LIKE '%$date%' ";
		}elseif(!empty($params['search']['year'])){
			$year = $params['search']['year'];
			$date = $year.'-'; 
			$query .= "AND patient_create_date LIKE '%$date%' ";
		}
	}
	
	$result = $CI->db->query($query);
	return $result->num_rows();
}

function total_visits_of_the_operator($params, $center, $operator)
{
	$CI =& get_instance();
	$query = "SELECT visit_id FROM starter_patient_visit 
			 WHERE visit_admited_by='$operator' 
			 AND visit_admited_by_usertype='Operator'
			 AND visit_org_centerid='$center' ";
							 
	if(!empty($params['search']['from_date']) && !empty($params['search']['to_date'])){
		$from_date = $params['search']['from_date'];
		$stop_date = $params['search']['to_date'];
		$to_date   = date("Y-m-d", strtotime($stop_date . ' +1 day'));
		$query .= "AND visit_admit_date BETWEEN '$from_date' AND '$to_date' ";
	
	}
	
	if(!empty($params['search']['month']) && !empty($params['search']['year'])){
		$month = $params['search']['month'];
		$year = $params['search']['year'];
		$date = $year.'-'.$month.'-';
		$query .= "AND visit_admit_date LIKE '%$date%' ";
	}elseif(!empty($params['search']['month']) || !empty($params['search']['year'])){
		if(!empty($params['search']['month']))
		{
			$month = $params['search']['month'];
			$year = date("Y");
			$date = $year.'-'.$month.'-'; 
			$query .= "AND visit_admit_date LIKE '%$date%' ";
		}elseif(!empty($params['search']['year'])){
			$year = $params['search']['year'];
			$date = $year.'-'; 
			$query .= "AND visit_admit_date LIKE '%$date%' ";
		}
	}
	$result = $CI->db->query($query);
	return $result->num_rows();
}

function total_visits_of_the_patients($center, $patient_id)
{
	$CI =& get_instance();
	$query = $CI->db->query("SELECT visit_id FROM starter_patient_visit 
							 WHERE visit_patient_id='$patient_id' AND visit_org_centerid='$center' ");
	return $query->num_rows();
}