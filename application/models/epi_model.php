<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Epi_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	#return @fps array()
	public function _getlist( $cid ){
		$result = $this->db->select(array(
																			'visits.date_serv', 'epi_vaccines.eng_name', 'epi_vaccines.description',
																			'hospitals.name as place_name', 'epi_visits.*'))
											->where('visits.cid', $cid)
											->join('visits', 'visits.vn=epi_visits.vn')
											->join('epi_vaccines', 'epi_vaccines.id=epi_visits.vcctype', 'left')
											->join('hospitals', 'hospitals.code=epi_visits.vccplace', 'left')
                      ->order_by('epi_visits.id')
											->get('epi_visits')
											->result();
		return $result;
	}
	/**
	* Save FP service
	*
	*/
	public function _save_service( $vn, $vcctype, $vccplace )
	{
		$result = $this->db->set('vn', $vn)
											->set('vcctype', $vcctype)
											->set('vccplace', $vccplace)
											->insert('epi_visits');
		return $result;
	}

  public function _update_service( $id, $vccplace )
	{
		$result = $this->db->where('id', $id)
											->set('vccplace', $vccplace)
											->update('epi_visits');
		return $result;
	}
	/**
	* Check FP service duplicate
	*
	*/
	public function _check_duplicate( $cid, $vcctype, $date_serv )
	{
		$result = $this->db->where('visits.cid', $cid)
											->where('visits.date_serv', $date_serv)
											->where('epi_visits.vcctype', $vcctype)
											->join('epi_visits', 'epi_visits.vn=visits.vn')
											->get('visits')->result();
		return $result;
	}
	/**
	* Remove EPI
	*
	*/
	public function _remove( $id )
	{
		$result = $this->db->where('id', $id)->delete('epi_visits');
		return $result;
	}
	
}
/* End of file epi_model.php */
/* Location: ./application/models/epi_model.php */