<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * */
class Users extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model('User_model', 'Users');
	}
	public function index() {
		$this->login();
	}
  /**
   * @url POST /users/login
   * @param string $user_name, $user_pass Login system.
   **/
  public function login() {
		$user_name = $this->input->post('user_name');
    if( ! empty ($user_name) ) {
      // do login.
			$user_name = $this->input->post('user_name');
			$user_pass = $this->input->post('user_pass');
			// check login
			$result = $this->Users->dologin($user_name, $user_pass);
			if($result) {
				$users = $this->Users->get_userdetail($user_name);
				$data_session = array(
					'user_id' 			=> $users['id'],
					'username' 			=> $user_name,
					'fullname' 			=> $users['fullname'],
					'last_login' 		=> $users['last_login'],
					'pcucode' 			=> $users['pcucode'],
					'license_no' 		=> $users['license_no'],
					'hospital_name' => $users['hospital_name'],
					'logged'   			=> TRUE
				);
				$this->session->set_userdata($data_session);
				// logging
				log_message('info', 'Login for ' . $user_name . ' from '. $_SERVER['REMOTE_ADDR'].' [Success]');

				$json = '{"success": true}';
			} else {
				$json = '{"success": false}';
			}
			// render json
			printjson($json);
    } else {
      // show login for.
      $this->layout->view('users/login_view');
    }
    
  }
	
	public function logout() {
		$user_name = $this->session->userdata('username');
		log_message('info', 'Loggout for ' . $user_name . ' from '. $_SERVER['REMOTE_ADDR'].'  [Success]');
		$this->session->sess_destroy();

		redirect('users');  
	}
}