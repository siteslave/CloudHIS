<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Ncd_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	#return array()
	public function _get_target( $year = '2555' ){
		$result = $this->db->select(array(
			'people.cid', 'people.fname', 'people.lname', 'people.birthdate', 'people.sex',
			'year(current_date()) - year(birthdate) as age'
														))
											->where('year(current_date()) - year(birthdate) >=', 15)
											->limit(20)
											->order_by('fname')
											->get('people')
											->result();
		return $result;
	}
	public function _getlist( $cid ){
		$result = $this->db->select(array(
			'visits.date_serv', 'ncd_screenings.screen_year',
			'hospitals.name as hospital_name', 'service_places.name as place_name'
																))
																->where('ncd_screenings.cid', $cid)
																->join('visits', 'visits.vn=ncd_screenings.vn', 'left')
																->join('service_places', 'service_places.id=ncd_screenings.service_place_id', 'left')
																->join('hospitals', 'hospitals.code=ncd_screenings.screen_place', 'left')
																->get('ncd_screenings')
																->result();
		return $result;
	}
	public function _save_screen( $cid, $vn = '', $date_exam, $service_place_id, $smoke, $alcohol, 
																$dmfamily, $htfamily, $weight, $height, $waist, $bph1, $bph2, 
																$bpl1, $bpl2, $bslevel, $bstest, $screen_place = '11053', 
																$screen_year = '2555' )
	{
		$result = $this->db->set('vn', $vn)
												->set('cid', $cid)
												->set('date_exam', $date_exam)
												->set('service_place_id', $service_place_id)
												->set('smoke', $smoke)
												->set('alcohol', $alcohol)
												->set('dmfamily', $dmfamily)
												->set('htfamily', $htfamily)
												->set('weight', $weight)
												->set('height', $height)
												->set('waist', $waist)
												->set('bph_1', $bph1)
												->set('bph_2', $bph2)
												->set('bpl_1', $bpl1)
												->set('bpl_2', $bpl2)
												->set('bslevel', $bslevel)
												->set('bstest', $bstest)
												->set('screen_place', $screen_place)
												->set('screen_year', $screen_year)
												->insert('ncd_screenings');
		return $result;
	}
	public function _check_age($cid)
	{
		$result = $this->db->select('year(current_date()) - year(birthdate) as age')
												->where('cid', $cid)
												->get('people')
												->row();
		return $result->age;
	}
	
}
/* End of file ncd_model.php */
/* Location: ./application/models/ncd_model.php */