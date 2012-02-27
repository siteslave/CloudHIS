<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('printjson'))
	{
		function printjson($json)
		{
	        ini_set('display_errors', 0);
	        header('Cache-Control: no-cache, must-revalidate');
	        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	        header('Last-Modified: '.gmdate("D, d M Y H:i:s").' GMT');
	        header('Pragma: no-cache');
	        header('Content-Type: application/json');
	        echo $json;
		}
	
	}
	/*
	* Convert date to mysql date format
	*
	* @param			date('d/m/Y')
	* @return			date('Y-m-d')
	*
	**/
	if ( ! function_exists('to_mysql_date'))
	{
		function to_mysql_date($eng_date)
		{
			$new_date = explode('/', $eng_date);
	        $d = $new_date[0];
	        $m = $new_date[1];
	        $y = $new_date[2];
	
	        $mdy = $y.'-'.$m.'-'.$d;
	
			return $mdy;
		}
	
	}
	if ( ! function_exists('to_thai_date'))
	{
		function to_thai_date($thai_date)
		{
			$new_date = explode('-', $thai_date);
	        $d = $new_date[2];
	        $m = $new_date[1];
	        $y = $new_date[0] + 543;
	
	        $mdy = $d.'/'.$m.'/'.$y;
	
			return $mdy;
		}
	
	}
	if ( ! function_exists('get_username') ) {
		function get_username( $user_id ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('fullname')
			   								->where('id', $user_id)
			   								->get('users')
			   								->row();
			return $result->fullname;
		}
	}
	if ( ! function_exists('get_visit_cid') ) {
		function get_visit_cid( $vn ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('cid')
			   								->where('vn', $vn)
			   								->get('visits')
			   								->row();
			return $result->cid;
		}
	}
	if ( ! function_exists('get_visit_date') ) {
		function get_visit_date( $vn ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('date_serv')
			   								->where('vn', $vn)
			   								->get('visits')
			   								->row();
			return $result->date_serv;
		}
	}
	
	if ( ! function_exists('show_brand') ) {
		function show_brand( ) {
			return 'CloudHIS';
		}
	}
	/**
	 * Get Hospital code for user session
	 * @return string Hospital code in session data.
	 * @param  string $user_name User name
	 **/
	if (! function_exists('get_user_hospital_code')) {
		function get_user_hospital_code( $user_name ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('pcucode')
			   								->where('user_name', $user_name)
			   								->get('users')
			   								->row();
			return $result->pcucode;
		}
	}
	/**
	 * Get User id for user session
	 * @return int User id in session data.
	 **/
	if (! function_exists('get_user_id')) {
		function get_user_id( $user_name ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('id')
			   								->where('user_name', $user_name)
			   								->get('users')
			   								->row();
			return $result->id;
		}
	}
	/**
	 * Get User fullname
	 * @return string User name.
	 **/
	if (! function_exists('get_user_fullname')) {
		function get_user_fullname( $user_name ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('concat(fname, " ", lname) as fullname', FALSE)
			   								->where('user_name', $user_name)
			   								->get('users')
			   								->row();
			return $result->fullname;
		}
	}
	/**
	 * Get Hospital name
	 * @return string full hospital name.
	 **/
	if (! function_exists('get_user_hospital_name')) {
		function get_use_hospital_name( $user_name ) {
			$ci =& get_instance();
			
			$result = $ci->db->select('hospitals.name')
			   								->join('hospitals', 'hospitals.code=users.pcucode', 'left')
                        ->where('users.user_name', $user_name)
			   								->get('users')
			   								->row();
			return $result->name;
		}
	}
