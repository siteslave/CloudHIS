<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Anc_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	#return @fps array()
	public function _getlist( $cid ){
		$result = $this->db->select(array(
																			'visits.date_serv', 'hospitals.name as place_name', 
																			'anc_visits.gravida', 'anc_visits.ga', 'anc_visits.anc_res', 'anc_visits.id'))
											->where('visits.cid', $cid)
											->join('visits', 'visits.vn=anc_visits.vn')
											->join('hospitals', 'hospitals.code=anc_visits.anc_place', 'left')
											->get('anc_visits')
											->result();
		return $result;
	}
	/**
	* Save ANC service
	*
	*/
	public function _save_service( $vn, $anc_place, $gravida, $ga, $anc_res )
	{
		$result = $this->db->set('vn', $vn)
											->set('anc_place', $anc_place)
											->set('gravida', $gravida)
											->set('ga', $ga)
											->set('anc_res', $anc_res)
											->insert('anc_visits');
		return $result;
	}
	/**
	* Check FP service duplicate
	*
	*/
	public function _check_duplicate( $cid, $date_serv )
	{
		$result = $this->db->where('visits.cid', $cid)
											->where('visits.date_serv', $date_serv)
											->join('anc_visits', 'anc_visits.vn=visits.vn')
											->get('visits')->result();
		return $result;
	}
	/**
	* Remove EPI
	*
	*/
	public function _remove( $id )
	{
		$result = $this->db->where('id', $id)
												->delete('anc_visits');
		return $result;
	}
	
}
/* End of file epi_model.php */
/* Location: ./application/models/epi_model.php */