<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class User_model extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
  /**
   * @access public
   * @method int dologin() Check user login.
   * @params string $user_name, $user_pass User name and Password for login.
   * */
  public function dologin($user_name, $user_pass) {
    $result = $this->db->where('user_name', $user_name)
                        ->where('user_pass', md5($user_pass))
                        ->get('users')->result();
    // return result
    return count($result) > 0 ? TRUE : FALSE;
  }
  /**
   * @access public
   * @method array() get_userdetail() Get user information.
   * @param string $user_name User name.
   * @return array User detail.
   **/
  public function get_userdetail($user_name) {
    $result = $this->db->select(array(
                                      'concat(users.fname, " ", users.lname) as fullname', 'users.id', 'users.pcucode', 'users.last_login',
                                      'hospitals.name', 'users.license_no', 'users.user_type'
                                      ), FALSE)
                        ->join('hospitals', 'hospitals.code=users.pcucode', 'left')
                        ->where('users.user_name', $user_name)
                        ->limit(1)
                        ->get('users')->row();
    // generate result array
    $data['fullname'] = $result->fullname;
    $data['id'] = $result->id;
    $data['pcucode'] = $result->pcucode;
    $data['last_login'] = $result->last_login;
    $data['license_no'] = $result->license_no;
    $data['hospital_name'] = $result->name;
    // return data
    return $data;
  }
}