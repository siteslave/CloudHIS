<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * */
class Refer_model extends CI_Model {
	// search patient for register
	public function _search_patient_service($query, $date_serv)
	{
		$sql = '
		select concat(p.fname, " ", p.lname) as patient_name, v.vn, v.date_serv, v.cid, v.time_serv
		from people p
		inner join visits v on v.cid=p.cid
		where v.date_serv = "'.to_mysql_date($date_serv).'" and 
		(p.cid like "%'.$query.'%" or p.fname like "%'.$query.'%") 
		group by v.vn order by v.vn;
		';
		$result = $this->db->query($sql)->result();
		return $result;
	}
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
}