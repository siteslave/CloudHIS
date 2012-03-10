<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Location_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	#return @data array()
	public function _getdropdown(){
		$query = $this->db->get('locations');

		foreach ($query->result_array() as $row) {
			$data[$row['id']] = $row['name'];
		}
		return $data;
	}
}