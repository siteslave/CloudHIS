<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Fp extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// set layout
		$this->layout->setLayout('services_layout');
		// load model
		$this->load->model('Basic_model', 'Basic');
		$this->load->model('FP_model', 'FP');
		$this->load->model('Service_model', 'Services');
	}
	
	public function detail( $vn )
	{
		if( ! empty ($vn) ) {
			$data['rows'] = $this->Services->_getDetail($vn);
			if( count($data['rows']) ) {
				// get fp list
				$cid = get_visit_cid( $vn );
				
				$data['fps'] = $this->FP->_getlist( $cid );
				
				// load view
				$this->layout->view('fp/index_view');
			} else {
				show_404();
			}
		} else {
			show_404();
		}
	}
}

/* End of file fp.php */
/* Location: ./application/controllers/fp.php */
