<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class People extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		#load model
		$this->load->model('Person_model', 'Person');
	}
		
	function index()
	{
		
	}
	/**
	* Search patient
	*
	* @url 		POST /people/search
	* @return 	json
	*
	**/
	public function search()
	{
		$query = $this->input->post('query');

		if(empty($query)){
			show_404();
			//log_message('error', 'Not allowed for GET method or no parameters.');
		}else{
			$result = $this->Person->_search($query);
			$json = json_encode($result);

			// render as json
			printjson($json);	
		}
	}
	/**
	* Search patient
	*
	* @url 		GET /people/detail/:cid
	* @param 	string
	* @return 	json
	*
	**/
	public function detail()
	{
		$cid = $this->input->post('cid');
		
		if(empty($cid)){
			show_404();
		}else{
			$result = $this->Person->_detail($cid);
			$json = json_encode($result);

			// render json
			printjson($json);
		}
	}

}