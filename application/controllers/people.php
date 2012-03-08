<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class People extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		#load model
		$this->load->model('People_model', 'People');
	}
		
	function index()
	{
		
	}
	/**
	* Search patient
	*
	* @url 		POST /people/search
	* @return 	json
	*
	**/
	public function search()
	{
		$query = $this->input->post('query');

		if(empty($query)){
			show_404();
			//log_message('error', 'Not allowed for GET method or no parameters.');
		}else{
			$result = $this->People->_search($query);
			$json = json_encode($result);

			// render as json
			printjson($json);	
		}
	}
	/**
	* Search patient
	*
	* @url 		GET /people/detail/:cid
	* @param 	string
	* @return 	json
	*
	**/
	public function detail()
	{
		$cid = $this->input->post('cid');
		
		if(empty($cid)){
			show_404();
		}else{
			$result = $this->People->_detail($cid);
			$json = json_encode($result);

			// render json
			printjson($json);
		}
	}
  /**
   * Get people in house
   *
   * @param string $house_id
   **/
  public function getlist()
  {
    $house_id = $this->input->post( 'house_id' );
    
    if( ! empty($house_id) )
    {
      $result = $this->People->_get_people_in_house( $house_id );
      
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
	 * Register new person
	 *
	 * @param mixed $data Person detail
	 *
	 **/
	public function dosave()
	{
		$cid = $this->input->post( 'cid' );
		
		if ( ! empty ($cid) )
		{
			$house_id = $this->input->post( 'house_id' );
			$title_id = $this->input->post( 'title_id' );
			$fname = $this->input->post( 'fname' );
			$lname = $this->input->post( 'lname' );
			$sex = $this->input->post( 'sex' );
			$birthdate = $this->input->post( 'birthdate' );
			$address = $this->input->post( 'address' );
			//$moo = $this->input->post( 'moo' );
			//$tambon = $this->input->post( 'tambon' );
			//$ampur = $this->input->post( 'ampur' );
			//$changwat = $this->input->post( 'changwat' );
			$village_code = $this->input->post( 'village_code' );
			$marry_status_id = $this->input->post( 'marry_status_id' );
			$occupation_id = $this->input->post( 'occupation_id' );
			$race_id = $this->input->post( 'race_id' );
			$nation_id = $this->input->post( 'nation_id' );
			$religion_id = $this->input->post( 'religion_id' );
			$education_id = $this->input->post( 'education_id' );
			$family_status_id = $this->input->post( 'family_status_id' );
			$father_cid = $this->input->post( 'father_cid' );
			$mother_cid = $this->input->post( 'mother_cid' );
			$couple_cid = $this->input->post( 'couple_cid' );
			$move_in_date = $this->input->post( 'move_in_date' );
			$discharge_date = $this->input->post( 'discharge_date' );
			$discharge_status_id = $this->input->post( 'discharge_status_id' );
			$blood_group_id = $this->input->post( 'blood_group_id' );
			$labor_id = $this->input->post( 'labor_id' );
			$type_area_id = $this->input->post( 'type_area_id' );
			
			$birthdate = ! empty( $birthdate ) ? to_mysql_date( $birthdate ) : null;
			$move_in_date = ! empty( $move_in_date ) ? to_mysql_date( $move_in_date ) : null;
			$discharge_date = ! empty( $discharge_date ) ? to_mysql_date( $discharge_date ) : null;
			
			
			$data = array(
										'cid' => $cid,
										'house_id' => $house_id,
										'title_id' => $title_id,
										'fname' => $fname,
										'lname' => $lname,
										'sex' => $sex,
										'birthdate' => $birthdate,
										'address' => $address,
										'village_code' => $village_code,
										'marry_status_id' => $marry_status_id,
										'occupation_id' => $occupation_id,
										'race_id' => $race_id,
										'nation_id' => $nation_id,
										'religion_id' => $religion_id,
										'education_id' => $education_id,
										'family_status_id' => $family_status_id,
										'father_cid' => $father_cid,
										'mother_cid' => $mother_cid,
										'couple_cid' => $couple_cid,
										'move_in_date' => $move_in_date,
										'discharge_date' => $discharge_date,
										'discharge_status_id' => $discharge_status_id,
										'blood_group_id' => $blood_group_id,
										'labor_id' => $labor_id,
										'type_area_id' => $type_area_id
										);
			
			if ( ! $this->People->_check_exist( $cid ) )
			{
				$result = $this->People->_dosave( $data );
			
				if ( $result )
				{
					$json = '{"success": true}';
				}
				else
				{
					$json = '{"success": false, "statusText": "Model error"}';
				}
			}
			else
			{
				$json = '{"success": false, "statusText": "ข้อมูลเลขบัตรประจำตัวประชาชน ซ้ำ"}';
			}
			
			printjson( $json );
		}
		else
		{
			show_404();
		}
	}
}