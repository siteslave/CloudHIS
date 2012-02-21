<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * */
class Refer_model extends CI_Model {
	// search patient for register
	function _search_patient_service($query, $date_serv)
	{
		$sql = '
		select concat(p.fname, " ", p.lname) as patient_name, v.vn, v.date_serv, v.cid
		from people p
		inner join visits v on v.cid=p.cid
		where v.date_serv = "'.to_mysql_date($date_serv).'" and 
		(p.cid like "%'.$query.'%" or p.fname like "%'.$query.'%") 
		group by v.vn order by v.vn;
		';
		$result = $this->db->query($sql)->result();
		return $result;
	}
}