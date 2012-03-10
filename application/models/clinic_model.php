<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Clinic_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	#return @clinics array()
	public function _getdropdown(){
		$query = $this->db->get('clinics');

		foreach ($query->result_array() as $row) {
			$clinics[$row['id']] = $row['name'];
		}
		return $clinics;
	}
}
/* End of file clinics_model.php */
/* Location: ./application/models/clinics_model.php */