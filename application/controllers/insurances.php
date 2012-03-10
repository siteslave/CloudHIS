<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Insurances extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// load models
		$this->load->model('Insurance_model', 'Ins');
	}
	// @url			POST /insurances/search
	// @params	string
	public function search(){
		$query = $this->input->post('query');
		// check if not POST method
		if(empty($query)){
			show_404();
		}else{
			$rows = $this->Ins->_search($query);	
			$json = json_encode($rows);
			// render json
			printjson($json);
		}
	}
}
/* End of file insurances.php */
/* Location: ./application/controllers/insurances.php */