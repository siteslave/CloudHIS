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
		if(! $this->session->userdata('logged')){
				$this->login();
		} else {
			$this->layout->view('users/index_view');
		}
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
			
			if($result)
			{
				$users = $this->Users->get_userdetail($user_name);
				$data_session = array(
															'user_name' => $user_name,
															'logged' => TRUE,
															'user_fullname' => $users['fullname'],
															'user_id' => $users['id'],
															'user_hospital_name' => $users['hospital_name'],
															'pcucode' => $users['pcucode']
															);
				
				$this->session->set_userdata($data_session);
				// logging
				$logs = array(
											'log_level' => 'info',
											'log_message' => '[LOGGING] Login for ' . $user_name . ' from '. $_SERVER['REMOTE_ADDR'],
											'log_agent' => get_user_agent(),
											'log_ip' => $_SERVER['REMOTE_ADDR']
											);
				logging( $logs );
				
				$json = '{"success": true}';
			}
			else
			{
				// logging
				$logs = array(
											'log_level' => 'error',
											'log_message' => '[LOGGING] Login for ' . $user_name . ' from '. $_SERVER['REMOTE_ADDR'],
											'log_agent' => get_user_agent(),
											'log_ip' => $_SERVER['REMOTE_ADDR']
											);
				logging( $logs );
				
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
		$user_name = $this->session->userdata('user_name');
		
		// logging
		$logs = array(
									'log_level' => 'info',
									'log_message' => '[LOGGING] Logout for ' . $user_name . ' from '. $_SERVER['REMOTE_ADDR'],
									'log_agent' => get_user_agent(),
									'log_ip' => $_SERVER['REMOTE_ADDR']
									);
		logging( $logs );
		
		$this->session->sess_destroy();

		redirect('users');  
	}
}