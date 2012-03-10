<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Insurance_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	// @return array()
	public function _search($query){
		$result = $this->db->like('name', $query, 'both')
											->limit(20)
											->get('insurances')
											->result();
		return $result;	
	}
}
/* End of file insurance_model.php */
/* Location: ./application/models/insurance_model.php */