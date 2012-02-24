<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * */
class Refers extends CI_Controller {

	function __construct()
	{
		parent::__construct();
    
    if(! $this->session->userdata('logged')){
				redirect('users', 'refresh');
		}
		// load model
		$this->load->model('Refer_model', 'Refer');
		$this->layout->setLayout('services_layout');
	}
		
	function index()
	{
		$this->layout->view('refers/index_view');
	}
	public function search_patient_service()
	{
		$query = $this->input->post('query');
		if( ! empty($query) ) {
			$date_serv = $this->input->post('date_serv');
			$result = $this->Refer->_search_patient_service($query, $date_serv);
		
			if ($result) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
}