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
	#return @fps array()
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
	
}
/* End of file epi_model.php */
/* Location: ./application/models/epi_model.php */