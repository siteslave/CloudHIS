<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Pttype extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model('Pttype_model', 'Pttype');
	}
	/**
	* Get patient detail
	* 
	* @method 	POST
	* @url 		/pttype/getcombo
	* @return 	json
	*
	**/
	public function getcombo()
	{
		
	}
}