<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Lab extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// load model
		$this->load->model('Lab_model', 'LAB');
	}
	public function getorders(){
		$vn = $this->input->post('vn');
		if( ! empty($vn) ) {
			$result = $this->LAB->_get_order_list($vn);
			if ($result) {
				$json = '{"success": true, "rows": '. json_encode($result) .'}';
			} else {
				$json = '{"success": false, "status": '. $this->db->_error_message() . '}';
			}
			printjson($json);		
		} else {
			show_404();
		}
	}
	public function getlabitems(){
		$group_id = $this->input->post('group_id');
		if( ! empty($group_id) ) {
			$result = $this->LAB->_get_lab_items_services($group_id);
			if ($result) {
				$json = '{"success": true, "rows": '. json_encode($result) .'}';
			} else {
				$json = '{"success": false, "status": '. $this->db->_error_message() .'}';
			}
			printjson($json);		
		} else {
			show_404();
		}
	}
}
/* End of file lab.php */
/* Location: ./application/controllers/lab.php */