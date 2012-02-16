<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Pages extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//set layout
		$this->layout->setLayout('default_layout');
		// load spark
		//$this->load->spark('assets/0.6.3');

	}
	//default action
	public function index(){
		$this->layout->view('/pages/index_view');
	}

	public function about(){}
}
/* End of file pages.php */
/* Location: ./application/controllers/pages.php */