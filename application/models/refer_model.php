<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 **/
class Refer_model extends CI_Model {
	/**
	 * Set autocomplete for search patient
	 *
	 * @param string @query Word for search
	 * @param date $date_serv Visit date
	 * @return array The result set
	 **/
	public function _search_patient_service( $query, $date_serv )
	{
		$sql = '
			select concat(p.fname, " ", p.lname) as patient_name, v.vn, v.date_serv, v.cid, v.time_serv
			from people p
			inner join visits v on v.cid=p.cid
			where v.date_serv = "'.to_mysql_date($date_serv).'" and 
			(p.cid like "%'.$query.'%" or p.fname like "%'.$query.'%") 
			group by v.vn order by v.vn
			limit 20;
		';
		
		$result = $this->db->query($sql)->result();
		
		return $result;
	}
	/**
	 * Get visit detail
	 *
	 * @param string $vn Visit number
	 * @return array The result set of service
	 **/
	public function _get_register_service($vn)
	{
		$result = $this->db->select(array(
												'people.cid', 'people.fname', 'people.lname','year(current_date()) - year(birthdate) as age',
												'people.hn', 'people.sex', 'people.birthdate',
												'visits.date_serv', 'visits.time_serv', 'visits.vn', 'visits.ins_code',
												'clinics.name as clinic_name', 'insurances.name as ins_name', 
												'doctors.name as doctor_name'))
												->where('visits.vn', $vn)
												->join('people', 'people.cid=visits.cid')
												->join('clinics', 'clinics.id=visits.clinic_id', 'left')
												->join('insurances', 'insurances.id=visits.ins_id', 'left')
												->join('doctors', 'doctors.id=visits.doctor_id', 'left')
												->get('visits')->result();
												
		return $result;
	}
	/**
	 * Save new refer out detail
	 *
	 * @param string $vn Visit number
	 * @param string $diag Diagnosis code
	 * @param string $treatment Basic treatment
	 * @param string $refer_cause Cause to refer
	 * @param date $refer_date Date to refer
	 * @param string $refer_type Type of refer
	 * @param date $appoint_date Appoint date
	 * @param string $other_detail Other detail
	 * @param string $to_hospital The destination hospital code
	 * @param int $user_id ID of user
	 * @return array The result set
	 **/
	public function _save_refer_out( $vn, $appoint_date, $diag, $other_detail, $refer_cause, $refer_date, $refer_type, $to_hospital, $treatment, $user_id )
	{
		$result = $this->db->set('vn', $vn)
		 										->set('diag', $diag)
		 										->set('treatment', $treatment)
		 										->set('refer_cause', $refer_cause)
		 										->set('refer_date', $refer_date)
		 										->set('refer_type', $refer_type)
		 										->set('appoint_date', $appoint_date)
		 										->set('other_detail', $other_detail)
		 										->set('to_hospital', $to_hospital)
		 										->set('user_id', $user_id)
			 									->insert('refer_out');
		return $result;
	}
	/**
	 * Check visit exist
	 *
	 * @param string $vn Visit number
	 * @return array The result set
	 **/
	public function _check_exist( $vn ) {
		$result = $this->db->where('vn', $vn)->get('refer_out')->result();
		return count( $result ) > 0 ? TRUE : FALSE;
	}
	public function _update_refer_out( $vn, $appoint_date, $diag, $other_detail, $refer_cause, $refer_date, $refer_type, $to_hospital, $treatment, $user_id )
	{
		$result = $this->db->where('vn', $vn)
		 										->set('diag', $diag)
		 										->set('treatment', $treatment)
		 										->set('refer_cause', $refer_cause)
		 										->set('refer_date', $refer_date)
		 										->set('refer_type', $refer_type)
		 										->set('appoint_date', $appoint_date)
		 										->set('other_detail', $other_detail)
		 										->set('to_hospital', $to_hospital)
		 										->set('user_id', $user_id)
			 									->update('refer_out');
		return $result;
	}
	
	/**
	 * Check refer out exist if exist return the referal id
	 * 
	 * @access public
	 * @param string $vn Visit number
	 * @return array The result set
	 **/
	public function _check_referout_exist( $vn ) {
		$result = $this->db->select('id')->where('vn', $vn)->get('refer_out');
		if ( $result->num_rows() > 0 )
		{
			return $result->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Get refer out detail
	 *
	 * @access public
	 * @param int $id The refer out id
	 * @return array The result set
	 **/
	public function _get_refer_out_detail( $id )
	{
		$result = $this->db->select( array(
																			'people.fname', 'people.lname', 'people.cid',
																			'insurances.name', 'visits.vn', 'visits.date_serv', 'visits.time_serv',
																			'refer_out.*','hospitals.name', 'icd10.name'
																			 ) )
												->where( 'refer_out.id', $id )
												->join( 'visits', 'visits.vn=refer_out.vn' )
												->join( 'insurances', 'insurances.id=refer_out.ins_id', 'left' )
												->join( 'icd10', 'icd10.code=refer_out.diag', 'left' )
												->join( 'hospitals', 'hospitals.code=refer_out.pcucode', 'left' )
												->get( 'refer_out' )
												->result();
		return $result;
	}
	
	/**
	 * Get refer out list
	 *
	 * @param date $refer_date
	 * @return array Result set
	 **/
	public function _get_refer_out_list( $refer_date )
	{
		$user_name = $this->session->userdata('user_name');
		
		$result = $this->db->select( array(
																			'visits.date_serv', 'visits.time_serv',
																			'concat(people.fname, " ", people.lname) as fullname', 'people.cid',
																			'year(current_date()) - year(people.birthdate) as age', 'hospitals.name as to_hospital_name',
																			'refer_out.id', 'refer_out.refer_date'
																			 ), FALSE )
												->where('refer_out.refer_date', to_mysql_date( $refer_date ))
												//->where('visits.pcucode', $this->session->userdata('pcucode'))
												->join('visits', 'visits.vn=refer_out.vn')
												->join('hospitals', 'hospitals.code=refer_out.to_hospital', 'left')
												->join('people', 'people.cid=visits.cid')
												->get('refer_out')
												->result();
		return $result;
	}
}