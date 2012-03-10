<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Villages extends CI_Controller {

	public function __construct(){
		parent::__construct();
    // set layout
		//$this->layout->setLayout('basic_layout');
		// load models
		$this->load->model('Village_model', 'Village');
	}
	
	/*********************************************************************
	* Get village list
	* @param  string  $owner_code Hospital code or PCU Code
	*********************************************************************/
	public function get_villages()
	{
	  $owner_code = get_user_hospital_code();
	  $result = $this->Village->_get_village( $owner_code );
	  
	  if( $result ) $json = '{"success": true, "rows": ' . json_encode( $result ) . '}';
	  else $json = '{"success": false, "statusText": "Model error."}';
	  
	  printjson( $json );
	}
	
	}
	
