<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Services extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// set layout
		$this->layout->setLayout('services_layout');
		// load model
		$this->load->model('Basic_model', 'Basic');
		$this->load->model('Service_model', 'Services');
		$this->load->model('Fp_model', 'FP');
		$this->load->model('Epi_model', 'EPI');
		$this->load->model('Anc_model', 'ANC');
		$this->load->model('Ncd_model', 'NCD');
		$this->load->model('Lab_model', 'LAB');
	}

	/**
	* Main service page
	*
	* @url 	GET /services, /services/index
	*
	**/
	public function index(){
		$date = date('Y-m-d');
		$data['services'] = $this->Services->_getList($date);
		// render view
		$this->layout->view('/services/index_view', $data);
	}
	/**
	* Register new service
	* 
	* @url 	GET /services/register
	* 
	**/
	public function register()
	{
		$data['pttypes']	= $this->Basic->_get_pttypes_dropdown();
		$data['clinics']	= $this->Basic->_get_clinics_dropdown();
		$data['locations']	= $this->Basic->_get_locations_dropdown();
		$data['places']		= $this->Basic->_get_places_dropdown();

		$this->layout->view('/services/register_view', $data);
	}
	/**
	* Save service register
	* 
	* @url 	POST /services/doregister
	* 
	**/
	public function doregister()
	{
		$cid = $this->input->post('cid');
		// check if not POST method or cid empty
		if(empty($cid)){
			show_404();
		}else{
			// get input
			$cid		= $this->input->post('cid');
			$clinic_id	= $this->input->post('clinic_id');
			$date_serv	= $this->input->post('date_serv');
			$hmain_code	= $this->input->post('hmain_code');
			$hsub_code 	= $this->input->post('hsub_code');
			$ins_expire	= $this->input->post('ins_expire');
			$ins_start	= $this->input->post('ins_start');
			
			if( ! empty($ins_expire) ) {
				$ins_expire = to_mysql_date( $ins_expire );
			}
			if( ! empty($ins_start) ) {
				$ins_start = to_mysql_date( $ins_start );
			}
			
			$ins_code			= $this->input->post('ins_code');
			$ins_id				= $this->input->post('ins_id');
			$intime				= $this->input->post('intime');
			$location_id		= $this->input->post('location_id');
			$pttype_id			= $this->input->post('pttype_id');
			$service_place_id	= $this->input->post('service_place_id');
			$time_serv			= $this->input->post('time_serv');
			
			// save service register
			$result = $this->Services->_save( 
				$cid, $clinic_id, to_mysql_date( $date_serv ), $hmain_code,
				$hsub_code, $ins_expire, $ins_start,
				$ins_code, $ins_id, $intime, $location_id,
				$pttype_id, $service_place_id, $time_serv );
			// check if result is success.
			if( $result ) {
				$json = '{"success": true}';
				printjson( $json );
			} else {
				show_404();
			}
		}
	}

	/**
	* Visit detail
	*
	* @url			GET /services/detail/:vn
	* 
	**/
	public function detail($vn = '')
	{
		if( ! empty($vn) ) {
			$data['rows'] = $this->Services->_getDetail($vn);
			// if id not match return error 404
			if( count($data['rows']) ) {
				$data['screenings'] = $this->Services->_getScreening($vn);
				// basic data
				$data['allergics'] 	= $this->Basic->_get_allergics_dropdown();
				$data['diag_types']	= $this->Basic->_get_diagtype_dropdown();
				$data['appoints']		= $this->Basic->_get_appoint_dropdown();
				$data['fptypes']		= $this->Basic->_get_fptype_dropdown();
				$data['fpplaces']		= $this->Basic->_get_fpplace_dropdown();
				$data['vccplaces']		= $this->Basic->_get_vccplace_dropdown();
				$data['vcctypes']		= $this->Basic->_get_vcctype_dropdown();
				// screening
				$data['smokes']				= $this->Basic->_get_smoke_dropdown();
				$data['alcohols']			= $this->Basic->_get_alcohol_dropdown();
				$data['blood_screens']= $this->Basic->_get_blood_screen_dropdown();
				
				$data['patient_status'] = $this->Basic->_get_surveil_patient_status_dropdown();
				
				$data['diags']			= $this->Services->_getDiag($vn);
				$data['procedures']	= $this->Services->_get_procedure($vn);
				$data['drugs']			= $this->Services->_get_drugs($vn);
				$data['incomes']		= $this->Services->_get_income($vn);
				
				$this->layout->view('/services/detail_view', $data);
			} else {
				show_404();
			}
			
		} else {
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save Screening detail
	*
	* @url			POST /services/doscreening
	* 
	**/
	public function doscreening()
	{
		$vn = $this->input->post('vn');
		
		if( ! empty($vn) ) {
			
			$vn 					= $this->input->post('vn');
			$weight 			= $this->input->post('weight');
			$height 			= $this->input->post('height');
			$heartbeat 		= $this->input->post('heartbeat');
			$pulse 				= $this->input->post('pulse');
			$waistline 		= $this->input->post('waistline');
			$temperature	= $this->input->post('temperature');
			$fbs 					= $this->input->post('fbs');
			$bp1 					= $this->input->post('bp1');
			$bp2 					= $this->input->post('bp2');
			$dtx1 				= $this->input->post('dtx1');
			$dtx2 				= $this->input->post('dtx2');
			$smoking 			= $this->input->post('smoking');
			$drinking 		= $this->input->post('drinking');
			$allergic 		= $this->input->post('allergic');
			$cc 					= $this->input->post('cc');
			$bmi 					= $this->input->post('bmi');

		$c = count( $this->Services->_checkScreeningExist( $vn ) );
			// if screening exist. 
			if($c == 0) {
				// insert new screening
				$result = $this->Services->_saveScreening(
																									$vn, $weight, $height, $heartbeat, $pulse, $waistline, 
																									$temperature, $fbs, $bp1, $bp2, $dtx1, $dtx2, $smoking, 
																									$drinking, $allergic, $cc, $bmi);
				if ( $result ) {
					$json = '{"success": true, "msg": "Insert"}';
					printjson($json);
				} else {
					// $json = '{"success": false}';
					show_404();
				}
			}else { // if screening dosn't exist.
				// update screening
				$result = $this->Services->_updateScreening(
																										$vn, $weight, $height, $heartbeat, $pulse, $waistline, 
																										$temperature, $fbs, $bp1, $bp2, $dtx1, $dtx2, $smoking, 
																										$drinking, $allergic, $cc, $bmi);
					
				if ( $result ) {
					$json = '{"success": true, "msg": "Update"}';
					printjson($json);
				} else {
					// $json = '{"success": false}';
					show_404();
				}
			}	
		} else {
			// show error 404 if no id
			show_404();
		}
	}
	
	/**
	* Screening detail
	*
	* @url			GET /services/screening
	* 
	**/
	public function screening()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$result = $this->Services->_getScreening($vn);
			// json encode
			$json = '{"success": true, "rows": '.json_encode($result).'}';
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save diag
	*
	* @url			POST /services/dodiag
	* 
	**/
	public function dodiag()
	{
		$vn 				= $this->input->post('vn');
		$diag_code 	= $this->input->post('diag_code');
		$diag_type 	= $this->input->post('diag_type');
			
		$json = '';
		
		// vn not empty
		if( ! empty($vn) || ! empty($diag_code) || ! empty($diag_type) ) {

			// check if principle diag exist
			if ( $diag_type == '1') {
				$c = count( $this->Services->_checkPrincipleExist($vn) );
				if ( $c == 0) {
					// check if double diag
					$double_diag = count( $this->Services->_checkDoubleDiag($vn, $diag_code, $diag_type) );
					if( $double_diag == 0 ) {
						$result = $this->Services->_saveDiag($vn, $diag_code, $diag_type);
						// json encode
						if ( $result ) {
							$json = '{"success": true}';
						} else {
							$json = '{"success": false, "status": "Database error"}';
							}
					} else { // double diag
						$json = '{"success": false, "status": "You use double diag, please use other diag."}';
					}
				} else { // principle diag exist
					$json = '{"success": false, "status": "Principle diag exist, please use other diag"}';
				}
			}else {
				// check if double diag
				$double_diag = count( $this->Services->_checkDoubleDiag($vn, $diag_code, $diag_type) );
				if( $double_diag == 0 ) {
					$result = $this->Services->_saveDiag($vn, $diag_code, $diag_type);
					// json encode
					if ( $result ) {
						$json = '{"success": true}';
					} else {
						$json = '{"success": false, "status": "Database error"}';
						}
				} else { // double diag
					$json = '{"success": false, "status": "You use double diag, please use other diag."}';
				}
			}
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			//$json = '{"success": false, "status": "VN dosn\'t exist"}';
			show_404();
		}
	}// dodiag()
	
	/**
	* Remove diag
	*
	* @url			POST /services/removediag
	* 
	**/
	public function removediag()
	{
		$vn 				= $this->input->post('vn');
		$diag_code 	= $this->input->post('diag_code');
				
		if ( ! empty( $vn ) || ! empty( $diag_code )  ) {
			$result = $this->Services->_remove_diag($vn, $diag_code);		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	
	/**
	* Screening detail
	*
	* @url			GET /services/doproced
	* 
	**/
	public function doproced()
	{
		$vn 			= $this->input->post('vn');
		$code 		= $this->input->post('code');
		$price 		= $this->input->post('price');
		$user_id	= '1001';
		
		// vn not empty
		if( ! empty($vn) || ! empty($code) || ! empty($price) ) {
			if ( $this->Services->_check_procedure_exist($vn, $code) ) {
				$json = '{"success": false, "status": "รายการซ้ำ"}';
			} else {
				$result = $this->Services->_save_procedure($vn, $code, $price, $user_id);
				// json encode
				if( $result ) {
					$json = '{"success": true, "username": "' . get_username($user_id) . '"}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}

			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Remove diag
	*
	* @url			POST /services/removediag
	* 
	**/
	public function removeproced()
	{
		$vn 	= $this->input->post('vn');
		$code 	= $this->input->post('code');
				
		if ( ! empty( $vn ) || ! empty( $code )  ) {
			$result = $this->Services->_remove_procedure($vn, $code);		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save Drug
	*
	* @url			POST /services/dodrug
	* 
	**/
	public function dodrug()
	{
		$vn 			= $this->input->post('vn');
		$drug_id 	= $this->input->post('drug_id');
		$usage_id = $this->input->post('usage_id');
		$price 		= $this->input->post('price');
		$qty 			= $this->input->post('qty');
		
		$json = '';
				
		if ( ! empty( $vn ) || ! empty( $drug_id ) || ! empty( $usage_id ) || ! empty( $price ) || ! empty( $qty )  ) {
			if ( $this->Services->_check_drug_exist($vn, $drug_id) ) {
				$json = '{"success": false, "status": "รายการซ้ำ"}';
			} else {
				$result = $this->Services->_save_drug($vn, $drug_id, $usage_id, $price, $qty);		
				if ( $result ) {
					$json = '{"success": true}';	
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Remove drug
	*
	* @url			POST /services/removedrug
	* 
	**/
	public function removedrug()
	{
		$vn 		= $this->input->post('vn');
		$drug_id 	= $this->input->post('drug_id');

		if ( ! empty( $vn ) || ! empty( $drug_id )  ) {
			$result = $this->Services->_remove_drug($vn, $drug_id);		
			if ( $result ) {
				$json = '{"success": true, "msg": "'.$drug_id.'"}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save Income
	*
	* @url			POST /services/doincome
	* 
	**/
	public function doincome()
	{
		$vn 				= $this->input->post('vn');
		$income_id 	= $this->input->post('income_id');
		$price 			= $this->input->post('price');
		$qty 				= $this->input->post('qty');

		if ( ! empty( $vn ) || ! empty( $income_id ) || ! empty( $price ) || ! empty( $qty )  ) {
			if ( $this->Services->_check_income_exist($vn, $income_id) ) {
				$json = '{"success": false, "status": "รายการซ้ำ"}';
			} else {
				$result = $this->Services->_save_income($vn, $income_id, $price, $qty);		
				if ( $result ) {
					$json = '{"success": true}';	
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			
			printjson($json);
			
		} else {
			show_404();
		}
	}
	/**
	* Remove income
	*
	* @url			POST /services/removeincome
	* 
	**/
	public function removeincome()
	{
		$vn 		= $this->input->post('vn');
		$income_id 	= $this->input->post('income_id');

		if ( ! empty( $vn ) || ! empty( $income_id )  ) {
			$result = $this->Services->_remove_income($vn, $income_id);		
			if ( $result ) {
				$json = '{"success": true, "msg": "'.$income_id.'"}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save Appointment
	*
	* @url			POST /services/doappoint
	* 
	**/
	public function doappoint()
	{
		$vn						= $this->input->post('vn');
		$appoint_id 	= $this->input->post('appoint_id');
		$appoint_date = $this->input->post('appoint_date');
		$appoint_diag	= $this->input->post('appoint_diag');

		if ( ! empty( $vn ) || ! empty( $appoint_id ) || ! empty( $appoint_date ) || ! empty( $appoint_diag )  ) {
			
			$appoint_date = to_mysql_date( $appoint_date );
			
			if ( $this->Services->_check_appoint_exist($vn, $appoint_id, $appoint_date) ) {
				$json = '{"success": false, "status": "รายการซ้ำ"}';
			} else {
				$result = $this->Services->_save_appoint($vn, $appoint_id, $appoint_date, $appoint_diag);		
				if ( $result ) {
					$json = '{"success": true}';	
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			
			printjson($json);
			
		} else {
			show_404();
		}
	}	
	/**
	* Get Appointment list
	*
	* @url			GET /services/getappoint
	* 
	**/
	public function getappoint()
	{
		$cid = $this->input->post('cid');
		// vn not empty
		if( ! empty($cid) ) {
			$result = $this->Services->_get_appoint( $cid );
			$json = '{"success": true, "rows": '.json_encode($result).'}';	
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Remove Appointment
	*
	* @url			POST /services/removeappoint
	* 
	**/
	public function removeappoint()
	{
		$vn 				= $this->input->post('vn');
		$id	= $this->input->post('id');

		if ( ! empty( $vn ) || ! empty( $id )  ) {
			$result = $this->Services->_remove_appoint($vn, $id);		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save Surveil
	*
	* @url 		POST	/services/dosurveil
	* @params	$vn, $code_506, $diag_code, $ill_date, $ill_address, $ill_moo, $ill_tmb, $ill_amp, $ill_chw, $patient_status, $death_date, $comp, $organ
	*
	**/
	public function dosurveil()
	{
		$vn = $this->input->post('vn');
		if ( ! empty( $vn ) ) {
			
			$diag_code = $this->input->post('diag_code');
			$code_506 = $this->input->post('code_506');
			$ill_date = $this->input->post('ill_date');
			$ill_address = $this->input->post('ill_address');
			$ill_moo = $this->input->post('ill_moo');
			$ill_tmb = $this->input->post('ill_tmb');
			$ill_amp = $this->input->post('ill_amp');
			$ill_chw = $this->input->post('ill_chw');
			$patient_status = $this->input->post('patient_status');
			$death_date = $this->input->post('death_date');
			$comp = $this->input->post('comp');
			$organ = $this->input->post('organ');
			// convert date
			$ill_date = to_mysql_date( $ill_date );
						
			if ( $patient_status == '2') { //death
				$death_date = to_mysql_date( $death_date );
			}
			
			// check duplicate
			$c = $this->Services->_check_surveil_exist( $vn, $diag_code );
			if ( count($c) > 0 ) { // duplicate
				$json = '{"success": false, "status": "Duplicate diag."}';
			} else { // save surveil
				$result = $this->Services->_save_surveil($vn, $code_506, $diag_code, $ill_date, $ill_address, $ill_moo, $ill_tmb, $ill_amp, $ill_chw, $patient_status, $death_date, $comp, $organ);
				if ( $result ) {
					$json = '{"success": true}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			
			printjson( $json );
			
		} else {
			show_404();
		}
	}
	/**
	* Get Surveil list
	*
	* @url		POST /services/getsurveil
	* @param	$cid
	* 
	**/
	public function getsurveil()
	{
		$cid = $this->input->post('cid');
		// cid not empty
		if( ! empty($cid) ) {
			$result = $this->Services->_get_surveil_list( $cid );
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Get FP list
	*
	* @url		POST /services/getfp
	* @param	$cid
	* 
	**/
	public function getfp()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$cid = get_visit_cid($vn);
			$result = $this->FP->_getlist( $cid );
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save FP
	*
	* @url		POST /services/dofp
	* @params	$vn, $drug_id, $amount, $fp_type_id, $fp_place_id
	* 
	**/
	public function dofp()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$drug_id = $this->input->post('drug_id');
			$amount = $this->input->post('amount');
			$fp_type_id = $this->input->post('fp_type_id');
			$fp_place_id = $this->input->post('fp_place_id');
			
			// check duplicate
			$c = $this->FP->_check_duplicate( $vn, $fp_type_id );
			if ( count($c) > 0 ) {
				$json = '{"success": false, "status": "ข้อมูลซ้ำ กรุณาตรวจสอบ."}';
			} else {
				$result = $this->FP->_save_service( $vn, $drug_id, $amount, $fp_type_id, $fp_place_id );
				// json encode
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Get Epi list
	*
	* @url		POST /services/getepi
	* @param	$cid
	* 
	**/
	public function getepi()
	{
		$cid = $this->input->post('cid');
		// cid not empty
		if( ! empty($cid) ) {
			$result = $this->EPI->_getlist( $cid );
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save EPI
	*
	* @url		POST /services/doepi
	* @params	$vn, $vcctype, $vccplace
	* 
	**/
	public function doepi()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$drug_id = $this->input->post('drug_id');
			$vcctype = $this->input->post('vcctype');
			$vccplace = $this->input->post('vccplace');
			
			// check duplicate
			$cid = get_visit_cid($vn);
			$date_serv = get_visit_date($vn);
			
			$c = $this->EPI->_check_duplicate( $cid, $vcctype, $date_serv );
			if ( count($c) > 0 ) {
				$json = '{"success": false, "status": "ข้อมูลซ้ำ กรุณาตรวจสอบ."}';
			} else {
				$result = $this->EPI->_save_service( $vn, $vcctype, $vccplace );
				// json encode
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Remove EPI
	*
	* @url			POST /services/removeepi
	* 
	**/
	public function removeepi()
	{
		$vn 				= $this->input->post('vn');
		$vcctype		= $this->input->post('vcctype');

		if ( ! empty( $vn ) || ! empty( $vcctype )  ) {
			$result = $this->EPI->_remove($vn, $vcctype);		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Get ANC list
	*
	* @url		POST /services/getanc
	* @param	$cid
	* 
	**/
	public function getanc()
	{
		$cid = $this->input->post('cid');
		// cid not empty
		if( ! empty($cid) ) {
			$result = $this->ANC->_getlist( $cid );
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save ANC
	*
	* @url		POST /services/doanc
	* @params	$vn, $anc_place, $gravida, $ga, $anc_res
	* 
	**/
	public function doanc()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$anc_place = $this->input->post('anc_place');
			$gravida = $this->input->post('gravida');
			$ga = $this->input->post('ga');
			$anc_res = $this->input->post('anc_res');
			
			// check duplicate
			$cid = get_visit_cid($vn);
			$date_serv = get_visit_date($vn);
			
			$c = $this->ANC->_check_duplicate( $cid, $date_serv );
			if ( count($c) > 0 ) {
				$json = '{"success": false, "status": "ข้อมูลซ้ำ กรุณาตรวจสอบ."}';
			} else {
				$result = $this->ANC->_save_service( $vn, $anc_place, $gravida, $ga, $anc_res );
				// json encode
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Remove ANC
	*
	* @url			POST /services/removeanc
	* 
	**/
	public function removeanc() {
		$id	= $this->input->post('id');

		if ( ! empty( $id ) ) {
			$result = $this->ANC->_remove( $id );		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save NCD Screen service
	*
	* @url		POST /services/doncd
	* @params	$vn = '', $date_exam, $service_place_id, $smoke, $alcohol, $dmfamily, $htfamily, $weight, $height, $waist, $bph1, $bph2, $bpl1, $bpl2, $bslevel, $bstest, $screen_place = '11053', $screen_year = '2555'
	* 
	**/
	public function doncd()
	{
		$vn = $this->input->post('vn');
		$cid = get_visit_cid($vn);
		$date_exam = $this->input->post('date_exam');
		$service_place_id = $this->input->post('service_place_id'); 
		$smoke = $this->input->post('smoke'); 
		$alcohol = $this->input->post('alcohol');
		$dmfamily = $this->input->post('dmfamily'); 
		$htfamily = $this->input->post('htfamily');
		$weight = $this->input->post('weight'); 
		$height = $this->input->post('height');
		$waist = $this->input->post('waist');
		$bph1 = $this->input->post('bph1');
		$bph2 = $this->input->post('bph2'); 
		$bpl1 = $this->input->post('bpl1');
		$bpl2 = $this->input->post('bpl2');
		$bslevel = $this->input->post('bslevel');
		$bstest = $this->input->post('bstest');
		$screen_place = '11053';
		$screen_year = '2555';
		// vn not empty
		if( ! empty($date_exam) ) {
			// check duplicate
			//$cid = get_visit_cid($vn);
			//$date_serv = get_visit_date($vn);
			
			//$c = $this->ANC->_check_duplicate( $cid, $date_serv );
			/*
			if ( count($c) > 0 ) {
				$json = '{"success": false, "status": "ข้อมูลซ้ำ กรุณาตรวจสอบ."}';
			} else {
				$result = $this->ANC->_save_service( $vn, $anc_place, $gravida, $ga, $anc_res );
				// json encode
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			*/
			$age = $this->NCD->_check_age($cid);
			if ( $age < 15 ) {
				$json = '{"success": false, "status": "อายุไม่อยู่ในเกณฑ์ อายุต้องมากว่าหรือเท่ากับ 15 ปี ขึ้นไป"}';
			} else {
				$result = $this->NCD->_save_screen( $cid, $vn, $date_exam, $service_place_id, $smoke, $alcohol, 
															$dmfamily, $htfamily, $weight, $height, $waist, $bph1, $bph2, 
															$bpl1, $bpl2, $bslevel, $bstest, $screen_place, 
																$screen_year);
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}

			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Get NCD  list
	*
	* @url		POST /services/getncd
	* @param	$cid
	* 
	**/
	public function getncd()
	{
		$cid = $this->input->post('cid');
		// cid not empty
		if( ! empty($cid) ) {
			$result = $this->NCD->_getlist( $cid );
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Save Chronic follow up
	*
	* @url		POST /services/dochronicfu
	* @params	$vn, $weight, $height, $waist, $sbp, $dbp, $foot, $eye
	* 
	**/
	public function dochronicfu()
	{
		$vn = $this->input->post('vn');
		// vn not empty
		if( ! empty($vn) ) {
			$weight = $this->input->post('weight');
			$height = $this->input->post('height');
			$waist = $this->input->post('waist');
			$sbp = $this->input->post('sbp');
			$dbp = $this->input->post('dbp');
			$foot = $this->input->post('foot');
			$eye = $this->input->post('eye');
			// check duplicate
			$c = $this->NCD->_check_chronicfu_duplicate( $vn );
			if ( count($c) > 0 ) { // duplicate
				$json = '{"success": false, "status": "ข้อมูลซ้ำ เนื่องจากมีการมารับบริการหลายครั้ง"}';
			} else {
				$result = $this->NCD->_save_chronicfu( $vn, $weight, $height, $waist, $sbp, $dbp, $foot, $eye );
				// json encode
				if ( $result ) {
					$json = '{"success": true, "rows": '.json_encode($result).'}';
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Get Chronic follow up  list
	*
	* @url		POST /services/getchronicfu
	* @param	$cid
	* 
	**/
	public function getchronicfu()
	{
		$cid = $this->input->post('cid');
		// cid not empty
		if( ! empty($cid) ) {
			$result = $this->NCD->_get_chronicfu_list($cid);
			// json encode
			if ( $result ) {
				$json = '{"success": true, "rows": '.json_encode($result).'}';
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			
			// render json
			printjson($json);
			
		} else { // vn empty
			// show error 404 if no id
			show_404();
		}
	}
	/**
	* Remove Chronic fu
	*
	* @url			POST /services/removechronicfu
	* @params 	$id
	**/
	public function removechronicfu() {
		$id	= $this->input->post('id');

		if ( ! empty( $id ) ) {
			$result = $this->NCD->_remove_chronicfu( $id );		
			if ( $result ) {
				$json = '{"success": true}';	
			} else {
				$json = '{"success": false, "status": "Database error."}';
			}
			printjson($json);
		} else {
			show_404();
		}
	}
	/**
	* Save lab orders
	*
	* @url			POST /services/dolaborder
	* @params 	$id
	**/
	public function dolaborder() {
		$vn	= $this->input->post('vn');

		if ( ! empty( $vn ) ) {
			$group_id = $this->input->post('group_id');
			// check duplicate
			$c = $this->LAB->_check_order_duplicate($group_id, $vn);
			if (count($c)) {
				$json = '{"success": false, "status": "รายการซ้ำ : รายการนี้ถูกสั่งแล้วสำหรับบริการในครั้งนี้"}';
			} else {
				$result = $this->LAB->_save_order($vn, $group_id);		
				if ( $result ) {
					$json = '{"success": true}';	
				} else {
					$json = '{"success": false, "status": "Database error."}';
				}
			}
			printjson($json);
		} else {
			show_404();
		}
	}
}	
/* End of file services.php */
/* Location: ./application/controllers/services.php */