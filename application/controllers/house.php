<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class House extends CI_Controller {

	public function __construct(){
		parent::__construct();
    // set layout
		$this->layout->setLayout('basic_layout');
		// load models
		$this->load->model('Village_model', 'Village');
		$this->load->model( 'House_model', 'House' );
		$this->load->model( 'Basic_model', 'Basic' );
	}
  
  /**
   * Main page
   *
   **/
  public function index()
  {
    $owner_code = get_user_hospital_code();
    
    $data['villages_dropdown'] = $this->Village->_get_villages_dropdown();
    $data['villages'] = $this->Village->_getlist( $owner_code );
		$data['titles'] = $this->Basic->_get_title_dropdown();
    $data['blood_groups'] = $this->Basic->_get_blood_group_dropdown();
    $data['married_status'] = $this->Basic->_get_married_dropdown();
    $data['occupations'] = $this->Basic->_get_occupation_dropdown();
    $data['races'] = $this->Basic->_get_race_dropdown();
    $data['nations'] = $this->Basic->_get_nation_dropdown();
    $data['educations'] = $this->Basic->_get_education_dropdown();
    $data['religions'] = $this->Basic->_get_religion_dropdown();
    $data['changwats'] = $this->Basic->_get_changwat_dropdown();
    $data['discharge_status'] = $this->Basic->_get_discharge_status_dropdown();
    $data['type_areas'] = $this->Basic->_get_type_area_dropdown();
    $data['labor_types'] = $this->Basic->_get_labor_type_dropdown();
    
    $this->layout->view( '/house/index_view', $data );
  }
  
  /**
   * Get house in village
   *
   * @param string $village_code
   **/
  public function get_house()
  {
    $village_code = $this->input->post( 'village_code' );
    
    if( ! empty($village_code) )
    {
      $result = $this->Village->_get_house_list( $village_code );
      
      if ( $result )
      {
        $json = '{"success": true, "rows": ' . json_encode( $result ) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "Model error or not found."}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();
    }
  }
	/**
	 * Get house in village for edit
	 *
	 * @param string $village_code
	 * 
	 **/
	public function get_house_list()
	{
		$village_code = $this->input->post( 'village_code' );
		
    if( ! empty($village_code) )
    {
      $result = $this->House->_get_house_in_village( $village_code );
      
      if ( $result )
      {
        $json = '{"success": true, "rows": ' . json_encode( $result ) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "Model error or not found."}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();
    }
	}
}
/* End of file house.php */
/* Location: ./application/controllers/house.php */