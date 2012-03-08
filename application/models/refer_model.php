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
	 * @param array $data The set of refer data
	 * @return array The result set
	 **/
	public function _save_refer_out( $data )
	{
		$result = $this->db->insert( 'refer_out', $data );
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
	/**
	 * Update refer detail
	 *
	 * @param string $vn Visit number
	 * @param array $data The set of refer data
	 * @return bool
	 **/
	public function _update_refer_out( $vn, $data )
	{
		$result = $this->db->where( 'vn', $vn )
			 								->update( 'refer_out', $data );
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
																			'insurances.name as ins_name', 'visits.vn', 'visits.date_serv', 'visits.time_serv',
																			'refer_out.*','hospitals.name as hospital_name', 'icd10.name as diag_name'
																			 ) )
												->where( 'refer_out.id', $id )
												->join( 'visits', 'visits.vn=refer_out.vn' )
												->join( 'insurances', 'insurances.id=visits.ins_id', 'left' )
												->join( 'icd10', 'icd10.code=refer_out.diag', 'left' )
												->join( 'hospitals', 'hospitals.code=refer_out.to_hospital', 'left' )
												->join( 'people', 'people.cid=visits.cid' )
												->get( 'refer_out' )
												->result();
		return $result;
	}
	
	/**
	 * Get refer-out list
	 *
	 * @param date $refer_date
	 * @return array Result set
	 **/
	public function _get_refer_out_list( $pcucode, $refer_date )
	{
		
		$result = $this->db->select( array(
																			'visits.date_serv', 'visits.time_serv',
																			'concat(people.fname, " ", people.lname) as fullname', 'people.cid',
																			'year(current_date()) - year(people.birthdate) as age', 'hospitals.name as to_hospital_name',
																			'refer_out.id', 'refer_out.refer_date'
																			 ), FALSE )
												->where( 'refer_out.refer_date', $refer_date )
												->where( 'refer_out.owner', $pcucode )
												->join( 'visits', 'visits.vn=refer_out.vn' )
												->join( 'hospitals', 'hospitals.code=refer_out.to_hospital', 'left' )
												->join( 'people', 'people.cid=visits.cid' )
												->get( 'refer_out' )
												->result();
		return $result;
	}
	/**
	 * Get refer-in list
	 *
	 * @param string $pcucode
	 * @param date $refer_date
	 * @param string $confirm_status
	 * @return array Result set
	 **/
	public function _get_refer_in_list( $pcucode, $refer_date, $confirm_status = 'N' )
	{
		$result = $this->db->select( array(
																			'visits.date_serv', 'visits.time_serv',
																			'concat(people.fname, " ", people.lname) as fullname', 'people.cid',
																			'year(current_date()) - year(people.birthdate) as age', 'hospitals.name as to_hospital_name',
																			'refer_out.id', 'refer_out.refer_date', 'refer_out.confirm_status'
																			 ), FALSE )
												->where( 'refer_out.refer_date', $refer_date )
												->where( 'refer_out.to_hospital', $pcucode )
												//->where( 'confirm_status', $confirm_status )
												->join( 'visits', 'visits.vn=refer_out.vn' )
												->join( 'hospitals', 'hospitals.code=refer_out.owner', 'left' )
												->join( 'people', 'people.cid=visits.cid' )
												->get( 'refer_out' )
												->result();
		return $result;
	}
	/**
	 * Check refer out owner
	 *
	 * @param int $id Refer out id
	 * @param string $pcucode Hospital code of owner
	 * @return boolean
	 **/
	public function _check_refer_out_owner( $id, $pcucode )
	{
		$result = $this->db->select( 'owner' )->where( 'id', $id )->get('refer_out')->row();
		
		return $pcucode == $result->owner ? TRUE : FALSE;
	}
	/**
	 * Remove refer out
	 *
	 * @param int $id The refer out number
	 * @return boolean
	 **/
	public function _remove_refer_out( $id )
	{
		$result = $this->db->where( 'id', $id )->delete( 'refer_out' );
		return $result;
	}
	/**
	 * Save refer confirmation
	 *
	 * @param int $refer_id
	 * @param date $confirm_date
	 * @param string $other_detail
	 * @return bool
	 **/
	public function _save_confirm( $refer_id, $data )
	{
		$result = $this->db->where( 'id', $refer_id )->update( 'refer_out', $data );
		return $result;
	}
	/**
	 * Get confirm detail
	 *
	 * @param int $refer_id
	 **/
	public function _get_confirm( $refer_id )
	{
		$result = $this->db->select( array(
																			 'refer_out.confirm_date', 'refer_out.confirm_detail',
																			 'concat(users.fname, " ", users.lname) as user_fullname',
																			 'refer_out.confirm_datetime'
																			 ), FALSE )
											->where( 'refer_out.id', $refer_id )
											->join( 'users', 'users.id=refer_out.confirm_user_id', 'left' )
											->get('refer_out')
											->result();
		return $result;
	}
}