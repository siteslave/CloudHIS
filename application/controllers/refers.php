<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * The referal system
 * 
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
    
    if(! $this->session->userdata('logged'))
    {
			redirect('users', 'refresh');
		}
    
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
    
		if( ! empty($query) )
    {
			$date_serv = $this->input->post('date_serv');
			$result = $this->Refer->_search_patient_service($query, $date_serv);
		
			if ($result)
      {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			}
      else
      {
				$json = '{"success": false, "status": "Database error."}';
			}
      
			printjson($json);
      
		}
    else
    {
			show_404();
		}
	}
	public function getregister_service()
	{
		$vn = $this->input->post('vn');
    
		if( ! empty($vn) )
    {
			$result = $this->Refer->_get_register_service($vn);
      
			if ($result)
      {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			}
      else
      {
				$json = '{"success": false}';
			}
      
			printjson( $json );
      
		}
    else
    {
			show_404();
		}
	}
  /**
   * @method json doout() Create new refer out
   * 
   * Save refer data
   * 
   * @param string  $vn Visit number
   * @param date  $appoint_date Appoint date
   * @param string $diag Diagnosis
   * @param string $other_detail Other detail for mor information
   * @param string $refer_cause The cause to refer
   * @param date $refer_date Refer date
   * @param string $refer_type Type of refer
   * @param string $to_hospital Hospital code for destination hospital
   * @param string $treatment Basic Treatment
   * @param string $user_id The id of user
   * @return json
   **/
	public function doout()
	{
		$vn = $this->input->post('vn');
		
		if( ! empty( $vn ) )
    {
			$appoint_date = $this->input->post('appoint_date');
			$appoint_date = ! empty( $appoint_date ) ? to_mysql_date( $appoint_date ) : null;
			$diag 				= $this->input->post('diag');
			$other_detail = $this->input->post('other_detail');
			$refer_cause 	= $this->input->post('refer_cause');
			$refer_date 	= $this->input->post('refer_date');
			$refer_date 	= ! empty( $refer_date ) ? to_mysql_date( $refer_date  ) : null;
			$refer_type 	= $this->input->post('refer_type');
			$to_hospital 	= $this->input->post('to_hospital');
			$treatment 		= $this->input->post('treatment');
			$user_id 			= get_user_id();
			
      $data = array(
              'appoint_date'  => $appoint_date,
              'diag'          => $diag,
              'other_detail'  => $other_detail,
              'refer_cause'   => $refer_cause,
              'refer_date'    => $refer_date,
              'refer_type'    => $refer_type,
              'to_hospital'   => $to_hospital,
              'treatment'     => $treatment,
              'user_id'       => $user_id,
              'owner'         => get_user_hospital_code()
              );
              
			if ( ! $this->Refer->_check_exist( $vn ) )
      {
        $data['vn'] = $vn;
        
				$result = $this->Refer->_save_refer_out( $data );

				if ( $result )
        {
          // logging
          $logs = array(
                        'log_level' => 'info',
                        'log_message' => '[REFEROUT] Create new refer out for vn: ' . $vn,
                        'log_agent' => get_user_agent(),
                        'log_ip' => $_SERVER['REMOTE_ADDR']
                        );
          logging( $logs );
					$json = '{"success": true, "status": "New"}';
				}
        else
        {
        // logging
        $logs = array(
                      'log_level' => 'error',
                      'log_message' => '[REFEROUT] Create new refer out for vn: ' . $vn,
                      'log_agent' => get_user_agent(),
                      'log_ip' => $_SERVER['REMOTE_ADDR']
                      );
        logging( $logs );
        
					$json = '{"success": false, "status": "Database error"}';
				}
			}
      else
      {
        
				$result = $this->Refer->_update_refer_out( $vn, $data );
        
				if ( $result )
        {
          // logging
          $logs = array(
                        'log_level' => 'info',
                        'log_message' => '[REFEROUT] Update refer for vn: ' . $vn,
                        'log_agent' => get_user_agent(),
                        'log_ip' => $_SERVER['REMOTE_ADDR']
                        );
          logging( $logs );
          
					$json = '{"success": true, "status": "Update"}';
				}
        else
        {
          // logging
          $logs = array(
                        'log_level' => 'error',
                        'log_message' => '[REFEROUT] Update refer out for vn: ' . $vn,
                        'log_agent' => get_user_agent(),
                        'log_ip' => $_SERVER['REMOTE_ADDR']
                        );
          logging( $logs );
          
					$json = '{"success": false, "status": "Database error"}';
				}
			}
      
			printjson($json);
			
		}
    else
    {
			show_404();
		}
	}
  /**
   * @method json checkout() Check refer out exist
   * 
   * Check refer out exist
   * 
   * @param string $vn The visit number
   * @return int The referal id
   * 
   **/
  public function checkout()
  {
    $vn = $this->input->post('vn');
    
    if ( ! empty ($vn) )
    {
      /**
       * Check referout with $vn if exist the function return refer_id
       * if don't exist it return FALSE
       **/
      $result = $this->Refer->_check_referout_exist( $vn );
      
      if ( $result )
      {
        $json = '{"success": true, "refer_id": ' . $result->id . '}';
      }
      else
      {
        $json = '{"success": false}';
      }
    }
    else
    {
      $json = '{"success": false, "status": "No vn defined."}';
    }
    
    printjson( $json );
    
  }
  
  /**
   * Get refer out detail
   *
   * @param int $id The refer out id
   * @return array The result set
   **/
  public function get_refer_out_detail()
  {
    $id = $this->input->post( 'id' );
    
    if ( ! empty( $id ) )
    {
      $result = $this->Refer->_get_refer_out_detail( $id );
      
      if ( $result )
      {
        // logging
        $logs = array(
                      'log_level' => 'info',
                      'log_message' => '[REFEROUT] Get detail for refer id: ' . $id,
                      'log_agent' => get_user_agent(),
                      'log_ip' => $_SERVER['REMOTE_ADDR']
                      );
        logging( $logs );
        
        $json = '{"success": true, "rows": ' . json_encode( $result ) . '}';
      }
      else
      {
        // logging
        $logs = array(
                      'log_level' => 'error',
                      'log_message' => '[REFEROUT] Get detail for refer id: ' . $id ,
                      'log_agent' => get_user_agent(),
                      'log_ip' => $_SERVER['REMOTE_ADDR']
                      );
        logging( $logs );
        
        $json = '{"success": false}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();  
    }
  }
  
  /**
   * Get refer out list
   *
   * @param date $refer_date
   * @return mixed The result set
   **/
  public function get_refer_out_list()
  {
    $refer_date = $this->input->post('refer_date');
    $refer_date = to_mysql_date( $refer_date );
    $pcucode    = get_user_hospital_code();
    
    $result = $this->Refer->_get_refer_out_list( $pcucode, $refer_date );
    
    if ( $result )
    {
      $json = '{"success": true, "rows": ' . json_encode( $result ) . '}';
    }
    else
    {
      $json = '{"success": false}';
    }
    
    printjson( $json );
    
  }
  /**
   * Remove refer out
   *
   * @param int $id The refer out id
   **/
  public function remove_out()
  {
    $id = $this->input->post( 'id' );
    
    if( ! empty ( $id ) )
    {
      // check owner
      $pcucode = get_user_hospital_code();
      $chk = $this->Refer->_check_refer_out_owner( $id, $pcucode );
      
      if ( $chk )
      {
        $result = $this->Refer->_remove_refer_out( $id );
      
        if( $result )
        {
          $json = '{"success": true}';
        }
        else
        {
          $json = '{"success": false, "status": "database error."}';
        }
      }
      else
      {
        $json = '{"success": false, "status": "คุณไม่มีสิทธิในการลบข้อมูลการส่งต่อนี้"}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();
    }
  }
  /**
   * Get refer in list
   *
   * @param date $refer_date
   * @param string $approve
   * @return array The result set
   **/
  public function get_refer_in_list()
  {
    // get pcucode for current user
    $pcucode = get_user_hospital_code();
    // confirm status
    $confirm_status = $this->input->post('confirm_status');
    $refer_date = $this->input->post( 'refer_date' );
    
    // if $refer_date is empty return current date.
    $refer_date = ! empty ($refer_date) ? to_mysql_date( $refer_date ) : date('Y-m-d');
    // if $current_status is empty return 'N'
    $confirm_status = ! empty ( $confirm_status ) ? $confirm_status : 'N';
    
    $result = $this->Refer->_get_refer_in_list( $pcucode, $refer_date, $confirm_status );
    if( $result )
    {
      $json = '{"success": true, "rows": ' . json_encode($result) . ' }';
    }
    else
    {
      $json = '{"success": false}';
    }
    
    printjson( $json );

  }
  /**
   * Save refer confirmation
   *
   * @param int $refer_id The Refer-out id
   * @param date $confirm_date
   * @param string $other_detail
   **/
  public function doconfirm()
  {
    $refer_id = $this->input->post( 'refer_id' );
    $confirm_date = $this->input->post( 'confirm_date' );
    $other_detail = $this->input->post( 'other_detail' );
    
    $confirm_date = ! empty( $confirm_date ) ? to_mysql_date( $confirm_date ) : null;
    
    if ( ! empty ( $refer_id ) )
    {
      // do save
      
      $user_id = get_user_id();
      
      date_default_timezone_set('Asia/Bangkok');
      
      $data = array(
                    'confirm_date' => $confirm_date,
                    'confirm_detail' => $other_detail,
                    'confirm_user_id' => $user_id,
                    'confirm_status' => 'Y',
                    'confirm_datetime' => date('Y-m-d H:i:s')
                    );
      
      $result = $this->Refer->_save_confirm( $refer_id,  $data);
      
      if ( $result )
      {
        $json = '{"success": true}';
      }
      else
      {
        $json = '{"success": false, "statusText": "Database error"}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();
    }
  }
  /**
   * Get confirm detail
   *
   * @param int $id
   **/
  public function get_confirm()
  {
    $refer_id = $this->input->post( 'id' );
    
    if ( ! empty($refer_id) )
    {
      $result = $this->Refer->_get_confirm( $refer_id );
      
      if ( $result )
      {
        $json = '{"success": true, "rows": ' . json_encode($result) . '}';
      }
      else
      {
        $json = '{"success": false, "statusText": "Database error"}';
      }
      
      printjson( $json );
    }
    else
    {
      show_404();
    }
    
  }
}