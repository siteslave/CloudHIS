<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Basic extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// load model
		$this->load->model('Basic_model', 'Basic');
	}
	/**
	* Search icd10
	* 
	* @method 	POST
	* @url 		/basic/search_icd
	* @return 	json
	*
	**/
	public function search_diag()
	{
		$query = $this->input->post('query');
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_icd( $query );
			$json = json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search icd9
	* 
	* @method 	POST
	* @url 		/basic/search_proced
	* @return 	json
	*
	**/
	public function search_proced()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_proced( $query );
			$json = json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search Hospital
	* 
	* @method 	POST
	* @url 		/basic/search_hospital
	* @return 	json
	*
	**/
	public function search_hospital()
	{
		$query = $this->input->post('query');
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_hospitals($query);
			$json = json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search Drug
	* 
	* @method 	POST
	* @url 		/basic/search_drug
	* @return 	json
	*
	**/
	public function search_drug()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_drug($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search Drug
	* 
	* @method 	POST
	* @url 		/basic/search_drug
	* @return 	json
	*
	**/
	public function search_drug_fp()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_drug_fp($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search Drug Usage
	* 
	* @method 	POST
	* @url 			/basic/search_usage
	* @return 	json
	*
	**/
	public function search_usage()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_usage($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Search Drug Usage
	* 
	* @method 	POST
	* @url 			/basic/search_usage
	* @return 	json
	*
	**/
	public function search_income()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_search_income($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Changwat
	* 
	* @method 	POST
	* @url 			/basic/getchw
	* @return 	json
	*
	**/
	public function getchw()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$result = $this->Basic->_getchw($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Ampur
	* 
	* @method 	POST
	* @url 			/basic/getamp
	* @return 	json
	*
	**/
	public function getamp()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$chw_code = $this->input->post('chw_code');
			
			$result = $this->Basic->_getamp($query, $chw_code);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Tambon
	* 
	* @method 	POST
	* @url 			/basic/gettmb
	* @return 	json
	*
	**/
	public function gettmb()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {
			$chw_code = $this->input->post('chw_code');
			$amp_code = $this->input->post('amp_code');
			
			$result = $this->Basic->_gettmb($query, $chw_code, $amp_code);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Mooban
	* 
	* @method 	POST
	* @url 			/basic/getmooban
	* @return 	json
	*
	**/
	public function getmooban()
	{
		$chw_code = $this->input->post('chw_code');
		
		if( empty($chw_code) ) {
			show_404();
		} else {
			//$chw_code = $this->input->post('chw_code');
			$amp_code = $this->input->post('amp_code');
			$tmb_code = $this->input->post('tmb_code');
			
			$result = $this->Basic->_getmooban($chw_code, $amp_code, $tmb_code);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Surveil Complication
	* 
	* @method 	POST
	* @url 			/basic/getsurveil_comp
	* @return 	json
	*
	**/
	public function search_surveil_comp()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {			
			$result = $this->Basic->_search_surveil_comp($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Surveil Organism
	* 
	* @method 	POST
	* @url 			/basic/getsurveil_organ
	* @return 	json
	*
	**/
	public function search_surveil_organ()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {			
			$result = $this->Basic->_search_surveil_organ($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Surveil
	* 
	* @method 	POST
	* @url 			/basic/getsurveil
	* @return 	json
	*
	**/
	public function search_surveil()
	{
		$query = $this->input->post('query');
		
		if( empty($query) ) {
			show_404();
		} else {			
			$result = $this->Basic->_search_surveil($query);
			$json 	= json_encode($result);
			printjson($json);
		}
	}
	/**
	* Get Lab order list
	* 
	* @method 	POST
	* @url 			/basic/getlaborders
	* @return 	json
	*
	**/
	public function getlaborders()
	{
		$result = $this->Basic->_getlab_orders_list();
		$json 	= json_encode($result);
		printjson($json);
	}
  
	/**
	* Get Ampur dropdown
	* 
	* @param  string $chw
	* @return json
	*
	**/
	public function get_amp_dropdown()
	{
		$chw = $this->input->post('chw');
		
		if( empty($chw) ) 
    {
			show_404();
		} 
    else 
    {
			$result = $this->Basic->_get_amp_dropdown( $chw );
      if ( $result )
      {
        $json = '{"success": true, "rows": '. json_encode( $result ) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "ไม่พบข้อมูล"}';
      }
      
			printjson( $json );
		}
	}
	/**
	* Get Tambon dropdown
	* 
	* @param  string $chw
  * @param  string $amp
	* @return json
	*
	**/
	public function get_tmb_dropdown()
	{
		$chw = $this->input->post('chw');
		$amp = $this->input->post('amp');
    
		if( empty( $chw ) || empty( $amp ) ) 
    {
			show_404();
		} 
    else 
    {
			$result = $this->Basic->_get_tmb_dropdown( $chw, $amp );
      if ( $result )
      {
        $json = '{"success": true, "rows": '. json_encode( $result ) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "ไม่พบข้อมูล"}';
      }
      
			printjson( $json );
		}
	}
	/**
	* Get Mooban dropdown
	* 
	* @param  string $chw
  * @param  string $amp
  * @param  string $tmb
  *
	* @return json
	*
	**/
	public function get_moo_dropdown()
	{
		$chw = $this->input->post('chw');
		$amp = $this->input->post('amp');
    $tmb = $this->input->post('tmb');
    
		if( empty( $chw ) || empty( $amp ) ) 
    {
			show_404();
		} 
    else 
    {
			$result = $this->Basic->_get_moo_dropdown( $chw, $amp, $tmb );
      if ( $result )
      {
        $json = '{"success": true, "rows": '. json_encode( $result ) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "ไม่พบข้อมูล"}';
      }
      
			printjson( $json );
		}
	}
}
