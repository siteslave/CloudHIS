<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @module    Surveils
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2012
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @email		  rianpit@gmail.com
 * 
 **/
class Surveils extends CI_Controller {

	public function __construct(){
	  parent::__construct();
	}

  public function service_modal()
  {
    $this->load->view('modals/services_surveil_view');
  }
}