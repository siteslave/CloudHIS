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
                                      'fp_visits.*',
																			'hospitals.name as pcu_name'))
											->where('visits.cid', $cid)
											->join('visits', 'visits.vn=fp_visits.vn')
											->join('fp_types', 'fp_types.id=fp_visits.fp_type_id', 'left')
											->join('hospitals', 'hospitals.code=fp_visits.fp_pcucode', 'left')
                      ->order_by('fp_visits.id')
											->get('fp_visits')
											->result();
		return $result;
	}
	/**
	* Save FP service
	*
	*/
	public function _save_service( $vn, $fp_type_id, $fp_pcucode )
	{
		$result = $this->db->set('vn', $vn)
											->set('fp_type_id', $fp_type_id)
											->set('fp_pcucode', $fp_pcucode)
											->insert('fp_visits');
		return $result;
	}

  public function _update_service( $id, $fp_pcucode )
	{
		$result = $this->db->where('id', $id)
											->set('fp_pcucode', $fp_pcucode)
											->update('fp_visits');
		return $result;
	}

  public function _remove( $id )
  {
    $result = $this->db->where('id', $id)->delete('fp_visits');
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