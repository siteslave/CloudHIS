<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		Thai traditional medicine
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Ttms extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// load model
		//$this->load->model('Ttm_model', 'TTM');
		// set layout
		$this->layout->setLayout('services_layout');
	}
	//default action
	public function index(){
		$this->layout->view('/ttms/index_view');
	}
}
/* End of file ttm.php */
/* Location: ./application/controllers/ttm.php */
