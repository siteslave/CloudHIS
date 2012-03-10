<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Ncd extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// load model
		$this->load->model('Ncd_model', 'NCD');
		// set layout
		$this->layout->setLayout('services_layout');
	}
	//default action
	public function index(){
		$this->layout->view('/ncd/index_view');
	}
	
	// screening
	public function screening()
	{
		$data['targets'] = $this->NCD->_get_target();
		
		$this->layout->view('/ncd/screening_view', $data);
	}
}
/* End of file ncd.php */
/* Location: ./application/controllers/ncd.php */