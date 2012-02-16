<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Person_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}
	// search people with cid or first name	
	public function _search($query)
	{
		$result = $this->db->select('cid, fname, lname')
							->like('cid', $query, 'after')
							->or_like('fname', $query)
							->get('people')->result();
		return $result;
	}
	/**
	*	Get patient detail
	*
	*	@param  	string
	*	@return 	array
	*
	**/
	public function _detail($cid = '')
	{
		$result = $this->db->where('cid', $cid)
							->get('people')->result();
		return $result;
	}
}