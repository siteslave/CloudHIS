<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Fp_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	#return @fps array()
	public function _getlist( $cid ){
		$result = $this->db->select(array(
																			'visits.date_serv', 'fp_types.name as type_name', 
																			'fp_places.name as place_name', 'drugitems.name as drug_name',
																			'fp_visits.amount'))
											->where('visits.cid', $cid)
											->join('visits', 'visits.vn=fp_visits.vn')
											->join('fp_types', 'fp_types.id=fp_visits.fp_type_id', 'left')
											->join('fp_places', 'fp_places.id=fp_visits.fp_place_id', 'left')
											->join('drugitems' , 'drugitems.id=fp_visits.drug_id', 'left')
											->get('fp_visits')
											->result();
		return $result;
	}
	/**
	* Save FP service
	*
	*/
	public function _save_service( $vn, $drug_id, $amount, $fp_type_id, $fp_place_id )
	{
		$result = $this->db->set('vn', $vn)
											->set('drug_id', $drug_id)
											->set('amount', $amount)
											->set('fp_type_id', $fp_type_id)
											->set('fp_place_id', $fp_place_id)
											->insert('fp_visits');
		return $result;
	}
	/**
	* Check FP service duplicate
	*
	*/
	public function _check_duplicate( $vn, $fp_type_id )
	{
		$result = $this->db->where('vn', $vn)
											->where('fp_type_id', $fp_type_id)
											->get('fp_visits')->result();
		return $result;
	}
}
/* End of file fp_model.php */
/* Location: ./application/models/fp_model.php */