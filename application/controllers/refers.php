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
    $this->load->model('Basic_model', 'Basic');
    
		$this->layout->setLayout('services_layout');
	}
		
	function index()
	{
    $data['refer_causes'] = $this->Basic->_get_refer_cause_dropdown();
		$this->layout->view('refers/index_view', $data);
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
	public function getregister_service()
	{
		$vn = $this->input->post('vn');
		if( ! empty($vn) ) {
			$result = $this->Refer->_get_register_service($vn);
			if ($result) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	public function doout()
	{
		$vn = $this->input->post('vn');
		
		if( ! empty($vn) ) {
			$appoint_date = $this->input->post('appoint_date');
			$appoint_date = !empty($appoint_date) ? to_mysql_date($appoint_date) : null;
			$diag = $this->input->post('diag');
			$other_detail = $this->input->post('other_detail');
			$refer_cause = $this->input->post('refer_cause');
			$refer_date = $this->input->post('refer_date');
			$refer_date = !empty($refer_date) ? to_mysql_date($refer_date) : null;
			$refer_type = $this->input->post('refer_type');
			$to_hospital = $this->input->post('to_hospital');
			$treatment = $this->input->post('treatment');
			$user_id = get_user_id( $this->session->userdata('user_name') );
			
			if ( ! $this->Refer->_check_exist( $vn ) ) {
				// create
				$result = $this->Refer->_save_refer_out( $vn, $appoint_date, $diag, $other_detail, $refer_cause, $refer_date, $refer_type, $to_hospital, $treatment, $user_id );
				if ( $result ) {
					$json = '{"success": true, "status": "New"}';
				} else {
					$json = '{"success": false, "status": "Database error"}';
				}
			} else { // if exist update.
				// update
				$result = $this->Refer->_update_refer_out( $vn, $appoint_date, $diag, $other_detail, $refer_cause, $refer_date, $refer_type, $to_hospital, $treatment, $user_id );
				if ( $result ) {
					$json = '{"success": true, "status": "Update"}';
				} else {
					$json = '{"success": false, "status": "Database error"}';
				}
			}

			
			printjson($json);
			
		} else {
			show_404();
		}
	}
}