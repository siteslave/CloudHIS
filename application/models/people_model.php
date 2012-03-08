<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class People_model extends CI_Model {

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
	/**
	 * Get person in house
	 *
	 * @param int $house_id
	 **/
	public function _get_people_in_house( $house_id )
	{
		$result = $this->db->select( array(
																			'people.fname', 'people.lname', 'people.sex', 'people.cid',
																			'people.birthdate',
																			'year(current_date()) - year(people.birthdate) as age'), TRUE )
												->where( 'house_id', $house_id )
												->get( 'people' )
												->result();
		return $result;
	}
	
	/**
	 * Save new person
	 *
	 * @param mixed $data Person detail
	 *
	 **/
	public function _dosave( $data )
	{
		$result = $this->db->insert( 'people', $data );
		
		return $result;
	}
	/**
	 * Check if cid exist
	 *
	 * @param string $cid
	 *
	 **/
	public function _check_exist( $cid )
	{
		$result = $this->db->where( 'cid', $cid )->count_all_results( 'people' );
		
		return $result == 0 ? FALSE : TRUE;
	}
}