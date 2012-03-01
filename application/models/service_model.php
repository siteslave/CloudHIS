<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Service_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	/**
	* Save register service
	*
	* @return 	boolean
	**/
	public function _save($cid, $clinic_id, $date_serv, $hmain_code,
												$hsub_code, $ins_expire, $ins_start,
												$ins_code, $ins_id, $intime, $location_id,
												$pttype_id, $service_place_id, $time_serv, $pcucode){
		// execute query
		$result = $this->db->set('pcucode', $pcucode)
		 										->set('cid', $cid)
		 										->set('clinic_id', $clinic_id)
		 										->set('date_serv', $date_serv)
		 										->set('hmain_code', $hmain_code)
		 										->set('hsub_code', $hsub_code)
		 										->set('ins_expire', $ins_expire)
		 										->set('ins_start', $ins_start)
		 										->set('ins_code', $ins_code)
		 										->set('ins_id', $ins_id)
		 										->set('intime', $intime)
		 										->set('location_id', $location_id)
		 										->set('pttype_id', $pttype_id)
		 										->set('service_place_id', $service_place_id)
		 										->set('time_serv', $time_serv)
			 									->insert('visits');
		// return result
		return $result;
	}
	/**
	* Save register service
	*
	* @return 	boolean
	**/
	public function _saveScreening(
		$vn, $weight, $height, $heartbeat, $pulse, $waistline, 
		$temperature, $fbs, $bp1, $bp2, $dtx1, $dtx2, $smoking, 
		$drinking, $allergic, $cc, $bmi){
		// execute query
		$result = $this->db->set('vn', $vn)
		 										->set('weight', $weight)
		 										->set('height', $height)
		 										->set('heartbeat', $heartbeat)
		 										->set('pulse', $pulse)
		 										->set('waistline', $waistline)
		 										->set('temperature', $temperature)
		 										->set('fbs', $fbs)
		 										->set('bp1', $bp1)
		 										->set('bp2', $bp2)
		 										->set('dtx1', $dtx1)
		 										->set('dtx2', $dtx2)
		 										->set('smoking', $smoking)
		 										->set('drinking', $drinking)
		 										->set('allergic', $allergic)
		 										->set('cc', $cc)
		 										->set('bmi', $bmi)
			 									->insert('screenings');
		// return result
		return $result;
	}
	/**
	* Check exist screening data
	*
	* @param		$vn
	* @return		array
		**/
	public function _checkScreeningExist($vn)
	{
		$result = $this->db->where('vn', $vn)
		                  ->get('screenings')->result();
		return $result;
	}
	/**
	* Save register service
	*
	* @return 	bool
	**/
	public function _updateScreening(
		$vn, $weight, $height, $heartbeat, $pulse, $waistline, 
		$temperature, $fbs, $bp1, $bp2, $dtx1, $dtx2, $smoking, 
		$drinking, $allergic, $cc, $bmi){
		// execute query
		$result = $this->db->where('vn', $vn)
		 										->set('weight', $weight)
		 										->set('height', $height)
		 										->set('heartbeat', $heartbeat)
		 										->set('pulse', $pulse)
		 										->set('waistline', $waistline)
		 										->set('temperature', $temperature)
		 										->set('fbs', $fbs)
		 										->set('bp1', $bp1)
		 										->set('bp2', $bp2)
		 										->set('dtx1', $dtx1)
		 										->set('dtx2', $dtx2)
		 										->set('smoking', $smoking)
		 										->set('drinking', $drinking)
		 										->set('allergic', $allergic)
		 										->set('cc', $cc)
		 										->set('bmi', $bmi)
			 									->update('screenings');
		// return result
		return $result;
	}
	/**
	* Get service list
	*
	* @param		$date
	* @return 	array
	**/
	public function _getList($date)
	{
		$result = $this->db->select(array(
												'people.cid', 'people.fname', 'people.lname','year(current_date()) - year(birthdate) as age',
												'people.hn', 'people.sex', 'people.birthdate',
												'visits.date_serv', 'visits.time_serv', 'visits.vn', 'visits.ins_code',
												'clinics.name as clinic_name', 'insurances.name as ins_name', 
												'doctors.name as doctor_name', 'screenings.cc'))
												->join('people', 'people.cid=visits.cid')
												->join('clinics', 'clinics.id=visits.clinic_id', 'left')
												->join('insurances', 'insurances.id=visits.ins_id', 'left')
												->join('doctors', 'doctors.id=visits.doctor_id', 'left')
												->join('screenings', 'screenings.vn=visits.vn', 'left')
												->order_by('visits.vn', 'ASC')
												->get('visits')->result();
		return $result;
	}
	/**
	* Get service detail
	*
	* @param		$id
	* @return 	array
	**/
	public function _getDetail($vn)
	{
		$result = $this->db->select(array(
												'people.cid', 'people.fname', 'people.lname',
												'people.hn', 'people.sex', 'people.birthdate',
												'year(current_date()) - year(people.birthdate) as age',
												'visits.date_serv', 'visits.time_serv', 'visits.vn', 'visits.ins_code',
												'visits.service_place_id',
												'clinics.name as clinic_name', 'insurances.name as ins_name'))
												->join('people', 'people.cid=visits.cid')
												->join('clinics', 'clinics.id=visits.clinic_id', 'left')
												->join('insurances', 'insurances.id=visits.ins_id', 'left')
												->where('visits.vn', $vn)->get('visits')->result();
		return $result;
	}
	/**
	* Get Screening detail
	* 
	* @param   	$vn
	* @return 	array
	**/
	public function _getScreening($vn) {
		$result = $this->db->where('vn', $vn)->limit(1)->get('screenings')->result();
		return $result;
	}
	
	/**
	* Save Diag
	* 
	* @param   	$vn, $diag_code, $diag_type
	* @return 	array
	**/
	public function _saveDiag($vn, $diag_code, $diag_type) {
		$result = $this->db->set('vn', $vn)
		  									->set('diag_code', $diag_code)
		  									->set('diag_type', $diag_type)
			  								->insert('diags');
		return $result;
	}
	/**
	* Check Principle diag exist
	*
	* @param		$vn
	* @return		array
		**/
	public function _checkPrincipleExist($vn)
	{
		$result = $this->db->where('vn', $vn)
		 									->where('diag_type' ,'1')
		                  ->get('diags')->result();
		return $result;
	}
	/**
	* Check Principle diag exist
	*
	* @param		$vn
	* @return		array
		**/
	public function _checkDoubleDiag($vn, $diag_code, $diag_type)
	{
		$result = $this->db->where('vn', $vn)
											->where('diag_code', $diag_code)
		 									//->where('diag_type !=' , '1')
		                  ->get('diags')->result();
		return $result;
	}
	/**
	* Get diag detail
	*
	* @param		$vn
	* @return		array
		**/
	public function _getDiag($vn)
	{
		$result = $this->db->select(array('diags.diag_code', 'diags.diag_type', 'icd10.name'))
											->where('vn', $vn)
											->join('icd10', 'icd10.code=diags.diag_code', 'left')
											->order_by('diags.diag_type')
		                  ->get('diags')->result();
		return $result;
	}
	/**
	* Remove diag
	*
	* @param		$vn, $diag_code
	* @return		bool
	**/
	public function _remove_diag($vn, $diag_code)
	{
		$result = $this->db->where('vn', $vn)
												->where('diag_code', $diag_code)
												->delete('diags');
		return $result;
	}
	
	/**
	* Get procedure
	*
	* @param		$vn
	* @return		bool
	**/
	public function _get_procedure($vn)
	{
		$result = $this->db->select(array(
											'procedures.code', 'icd9.name', 'procedures.price',
											'concat(users.fname, " ", users.lname) as fullname', 'users.id'), FALSE)
											->where('procedures.vn', $vn)
											->join('icd9', 'icd9.code=procedures.code', 'left')
											->join('users', 'users.id=procedures.user_id', 'left')
											->order_by('procedures.code')
		                  ->get('procedures')->result();
		return $result;
	}
	/**
	* Save procedure
	*
	* @param		$vn, $code, $price, $user_id
	* @return		bool
	**/
	public function _save_procedure($vn, $code, $price, $user_id)
	{
		$result = $this->db->set('vn', $vn)
		  									->set('code', $code)
		  									->set('price', $price)
		  									->set('user_id', $user_id)
			  								->insert('procedures');
		return $result;
	}
	/**
	* Save procedure
	*
	* @param		$vn, $code, $price, $user_id
	* @return		bool
	**/
	public function _remove_procedure($vn, $code)
	{
		$result = $this->db->where('vn', $vn)
												->where('code', $code)
			  								->delete('procedures');
		return $result;
	}
	/** check procedure exist **/
	public function _check_procedure_exist($vn, $code) {
		$result = $this->db->where('vn', $vn)->where('code', $code)->get('procedures')->result();
		return count($result) > 0 ? TRUE : FALSE; 
	}
	/**
	* Save drug
	*
	* @param		$vn, $drug_id, $usage_id, $price, $qty
	* @return		bool
	**/
	public function _save_drug($vn, $drug_id, $usage_id, $price, $qty)
	{
		$result = $this->db->set('vn', $vn)
											->set('drug_id', $drug_id)
											->set('qty', $qty)
											->set('price', $price)
											->set('usage_id', $usage_id)
											->insert('drugs');
		return $result;
	}
	/** check drug exist **/
	public function _check_drug_exist($vn, $drug_id) {
		$result = $this->db->where('vn', $vn)->where('drug_id', $drug_id)->get('drugs')->result();
		return count($result) > 0 ? TRUE : FALSE; 
	}
	/**
	* Get drugs
	*
	* @param		$vn
	* @return		bool
	**/
	public function _get_drugs($vn)
	{
		$result = $this->db->select(array(
											'drugitems.name as drug_name', 'drugusages.name1 as usage_name',
											'drugs.price', 'drugs.qty', 'drugs.drug_id'
																			))
											->where('drugs.vn', $vn)
											->join('drugitems', 'drugitems.id=drugs.drug_id', 'left')
											->join('drugusages', 'drugusages.id=drugs.usage_id', 'left')
		                  ->get('drugs')->result();
		return $result;
	}
	/**
	* Remove Drug
	*
	* @param		$vn, $drug_id
	* @return		bool
	**/
	public function _remove_drug($vn, $drug_id)
	{
		$result = $this->db->where('vn', $vn)
												->where('drug_id', $drug_id)
			  								->delete('drugs');
		return $result;
	}
	/**
	* Get incomes
	*
	* @param		$vn
	* @return		bool
	**/
	public function _get_income($vn)
	{
		$result = $this->db->select(array(
											'incomes.name', 'incomes.unit', 'income_visits.income_id',
											'income_visits.price', 'income_visits.qty'))
											->where('income_visits.vn', $vn)
											->join('incomes', 'incomes.id=income_visits.income_id', 'left')
		                  ->get('income_visits')->result();
		return $result;
	}
	/**
	* Save income
	*
	* @param		$vn, $income_id, $price, $qty
	* @return		bool
	**/
	public function _save_income($vn, $income_id, $price, $qty)
	{
		$result = $this->db->set('vn', $vn)
									->set('income_id', $income_id)
									->set('qty', $qty)
									->set('price', $price)
									->insert('income_visits');

		return $result;
	}
	/** check income exist **/
	public function _check_income_exist($vn, $income_id) {
		$result = $this->db->where('vn', $vn)->where('income_id', $income_id)->get('income_visits')->result();
		return count($result) > 0 ? TRUE : FALSE; 
	}
	
	/**
	* Remove Drug
	*
	* @param		$vn, $drug_id
	* @return		bool
	**/
	public function _remove_income($vn, $income_id)
	{
		$result = $this->db->where('vn', $vn)
												->where('income_id', $income_id)
			  								->delete('income_visits');
		return $result;
	}
	/** check appoint exist **/
	public function _check_appoint_exist($vn, $appoint_id, $appoint_date) {
		$result = $this->db->where('vn', $vn)
											->where('appoint_id', $appoint_id)
											->where('appoint_date', $appoint_date)
											->get('appoint_visits')->result();
		return count($result) > 0 ? TRUE : FALSE; 
	}
	/**
	* Save Appoointment
	*
	* @param		$vn, $appoint_id, $appoint_date, $appoint_diag
	* @return		bool
	**/
	public function _save_appoint($vn, $appoint_id, $appoint_date, $appoint_diag)
	{
		$result = $this->db->set('vn', $vn)
									->set('appoint_id', $appoint_id)
									->set('appoint_date', $appoint_date)
									->set('appoint_diag', $appoint_diag)
									->insert('appoint_visits');

		return $result;
	}
	/**
	* Get Appoointment
	*
	* @param		$vn
	* @return		bool
	**/
	public function _get_appoint( $cid )
	{
		$result = $this->db->select(array(
									'icd10.name as diag_name', 'visits.date_serv', 'visits.time_serv','appoint_visits.appoint_date', 
									'appoint_visits.appoint_diag', 'appoint_visits.id',
									'appoint_visits.appoint_date', 'appoints.name as appoint_name'))
									->where('visits.cid', $cid)
									->join('icd10', 'icd10.code=appoint_visits.appoint_diag', 'left')
									->join('appoints' ,'appoints.id=appoint_visits.appoint_id', 'left')
									->join('visits', 'visits.vn=appoint_visits.vn')
									->get('appoint_visits')
									->result();

		return $result;
	}
	/**
	* Remove Appoointment
	*
	* @param		$vn, $appoint_id
	* @return		bool
	**/
	public function _remove_appoint($vn, $id)
	{
		$result = $this->db->where('vn', $vn)
												->where('id', $id)
			  								->delete('appoint_visits');
		return $result;
	}
	public function _check_surveil_exist( $vn, $diag_code )
	{
		$result = $this->db->where('vn', $vn)
											->where('diag_code', $diag_code)
											->get('surveil_visits')
											->result();
		return $result;
	}
	/**
	* Save surveil
	*
	* @param		$vn, $code_506, $diag_code, $ill_date, $ill_address, $ill_moo, $ill_tmb, $ill_amp, $ill_chw, $patient_status, $death_date, $comp, $organ
	* @return		bool
	**/
	public function _save_surveil($vn, $code_506, $diag_code, $ill_date, $ill_addr, $ill_moo, $ill_tmb, $ill_amp, $ill_chw, $patient_status, $death_date, $comp, $organ)
	{
		$result = $this->db->set('vn', $vn)
											->set('code_506', $code_506)
											->set('diag_code', $diag_code)
											->set('ill_date', $ill_date)
											->set('ill_address', $ill_addr)
											->set('ill_moo', $ill_moo)
											->set('ill_tmb', $ill_tmb)
											->set('ill_amp', $ill_amp)
											->set('ill_chw', $ill_chw)
											->set('patient_status', $patient_status)
											->set('death_date', $death_date)
											->set('complication', $comp)
											->set('organism', $organ)
											->insert('surveil_visits');
	    
		return $result;
	}
	/**
	* Get surveil list
	*
	* @param		$cid
	* @return		array
	**/
	public function _get_surveil_list($cid)
	{
		/*
select v.vn, v.date_serv, s.code_506, vs.tname, s.diag_code, sp.name, s.death_date
from visits v
join surveil_visits s on s.vn=v.vn
left join surveils vs on vs.id=s.code_506
left join surveil_patient_status sp on sp.id=s.patient_status
where v.cid='3440400559995'
		*/
		$result = $this->db->select(array(
												'visits.date_serv', 'surveils.tname', 'surveil_visits.diag_code',
												'surveil_visits.ill_date','surveil_patient_status.name as status_name',
												'surveil_visits.death_date', 'icd10.name as diag_name'))
												->where('visits.cid', $cid)
												->join('visits', 'visits.vn=surveil_visits.vn')
												->join('surveils', 'surveils.id=surveil_visits.code_506', 'left')
												->join('surveil_patient_status', 'surveil_patient_status.id=surveil_visits.patient_status', 'left')
												->join('icd10', 'icd10.code=surveil_visits.diag_code', 'left')
												->get('surveil_visits')
												->result();
	    
		return $result;
	}
}
/* End of file service_model.php */
/* Location: ./application/models/service_model.php */