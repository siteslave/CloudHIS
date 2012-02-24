<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Anc extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(! $this->session->userdata('logged')){
			redirect('users', 'refresh');
		}
		// set layout
		$this->layout->setLayout('services_layout');
		// load model
		$this->load->model('Basic_model', 'Basic');
		//$this->load->model('Anc_model', 'ANC');
		//$this->load->model('Service_model', 'Services');
	}
	// display anc list
	public function index()
	{
		$this->layout->view('anc/index_view');
	}
}

/* End of file fp.php */
/* Location: ./application/controllers/fp.php */
