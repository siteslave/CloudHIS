<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Basic_model extends CI_Model {
	// construction method
	public function __construct(){
		parent::__construct();
	}
	// return @clinics array()
	public function _get_clinics_dropdown(){
		$query = $this->db->get('clinics');

		foreach ($query->result_array() as $row) {
			$clinics[$row['id']] = $row['name'];
		}
		return $clinics;
	}
	
	// return @smokings array()
	public function _get_smokings_dropdown(){
		$query = $this->db->get('smokings');

		foreach ($query->result_array() as $row) {
			$smokings[$row['id']] = $row['name'];
		}
		return $smokings;
	}
	
	// return @drinkings array()
	public function _get_drinkings_dropdown(){
		$query = $this->db->get('drinkings');

		foreach ($query->result_array() as $row) {
			$drinkings[$row['id']] = $row['name'];
		}
		return $drinkings;
	}
	
	// return @allergics array()
	public function _get_allergics_dropdown(){
		$query = $this->db->get('drug_allergics');

		foreach ($query->result_array() as $row) {
			$allergics[$row['id']] = $row['name'];
		}
		return $allergics;
	}
	// @return	array()
	public function _get_pttypes_dropdown(){
		$query = $this->db->get('pttypes');

		foreach ($query->result_array() as $row) {
			$pttypes[$row['id']] = $row['name'];
		}
		return $pttypes;
	}
	// @return	array()
	public function _get_locations_dropdown(){
		$query = $this->db->get('locations');

		foreach ($query->result_array() as $row) {
			$locations[$row['id']] = $row['name'];
		}
		return $locations;
	}
	// @return	array()
	public function _get_places_dropdown(){
		$query = $this->db->get('service_places');

		foreach ($query->result_array() as $row) {
			$places[$row['id']] = $row['name'];
		}
		return $places;
	}
	// @return	array()
	public function _get_appoint_dropdown(){
		$query = $this->db->get('appoints');

		foreach ($query->result_array() as $row) {
			$appoints[$row['id']] = $row['name'];
		}
		return $appoints;
	}
	// @return string
	public function _search_icd($query)
	{
		$result = $this->db->select(array('code', 'name'))
												->like('name', $query)
												->or_like('code', $query)
												->where('valid', 'T')
												->limit(20)
												->get('icd10')->result();
		return $result;	
	}
	/**
	* Search Proced
	*
	**/
	public function _search_proced($query)
	{
		$result = $this->db->select(array('code', 'name'))
												->like('name', $query)
												->or_like('code', $query)
												->where('valid', 'T')
												->limit(20)
												->get('icd9')->result();
		return $result;	
	}
	/**
	* Get Diag type
	*
	**/
	public function _get_diagtype_dropdown(){
		$query = $this->db->get('diag_types');
		
		foreach ($query->result_array() as $row) {
			$diag_types[$row['code']] = $row['name'];
		}
		
		return $diag_types;	
	}
	/*
	* Search Hospital
	*
	**/
	public function _search_hospitals($query){
		$result = $this->db->like('code', $query)
			 								->or_like('name', $query)
			 								->limit(20)
											->get('hospitals')
											->result();
		return $result;
		
	}
	/*
	* Search Drug
	*
	**/
	public function _search_drug($query){
		$result = $this->db->like('name', $query)
											->limit(20)
											->get('drugitems')
											->result();
		return $result;
		
	}
	/*
	* Search Drug FP
	*
	**/
	public function _search_drug_fp($query){
		$result = $this->db->like('name', $query)
											->where('fp_drug', 'Y')
											->limit(20)
											->get('drugitems')
											->result();
		return $result;
		
	}
	/*
	* Search Usage
	*
	**/
	public function _search_usage($query){
		$result = $this->db->select(array('id', 'name1 as name'))
		 									->like('name1', $query)
											->limit(20)
											->get('drugusages')
											->result();
		return $result;
		
	}
	/*
	* Search Usage
	*
	**/
	public function _search_income($query){
		$result = $this->db->like('name', $query)
											->limit(20)
											->get('incomes')
											->result();
		return $result;
	}
	/*
	* Get Changwat
	*
	**/
	public function _getchw($query){
		$result = $this->db->like('name', $query)
											->where('amp', '00')
											->where('tmb', '00')
											->where('moo', '00')
											->limit(20)
											->get('catms')
											->result();
		return $result;
	}
	/*
	* Get Ampur
	*
	**/
	public function _getamp($query, $chw_code){
		$result = $this->db->like('name', $query)
											->where('chw', $chw_code)
											->where('amp !=' ,'00')
											->where('tmb', '00')
											->where('moo', '00')
											->limit(20)
											->get('catms')
											->result();
		return $result;
	}
	/*
	* Get Tambon
	*
	**/
	public function _gettmb($query, $chw_code, $amp_code){
		$result = $this->db->like('name', $query)
											->where('chw', $chw_code)
											->where('amp' , $amp_code)
											->where('tmb !=', '00')
											->where('moo', '00')
											->limit(20)
											->get('catms')
											->result();
		return $result;
	}
	/*
	* Get Tambon
	*
	**/
	public function _getmooban($chw_code, $amp_code, $tmb_code){
		$result = $this->db->where('chw', $chw_code)
											->where('amp' , $amp_code)
											->where('tmb', $tmb_code)
											->where('moo !=', '00')
											->where_not_in('moo', array('00', '77'))
											->order_by('moo')
											//->limit(20)
											->get('catms')
											->result();
		return $result;
	}
	/*
	* Search Surveil Complication
	*
	**/
	public function _search_surveil_comp($query){
		$result = $this->db->select(array('id', 'name'))
		 									->like('name', $query)
											->limit(20)
											->get('surveil_complicates')
											->result();
		return $result;
		
	}
	/*
	* Search Surveil Organism
	*
	**/
	public function _search_surveil_organ($query){
		$result = $this->db->select(array('id', 'name'))
		 									->like('name', $query)
											->limit(20)
											->get('surveil_organisms')
											->result();
		return $result;
		
	}
	/*
	* Search Surveil Code
	*
	**/
	public function _search_surveil($query){
		$result = $this->db->select(array('id', 'tname'))
		 									->like('tname', $query)
											->limit(20)
											->get('surveils')
											->result();
		return $result;
		
	}
	/*
	* Get surveil patient status
	*
	**/
	public function _get_surveil_patient_status_dropdown(){
		$query = $this->db->get('surveil_patient_status');

		foreach ($query->result_array() as $row) {
			$patient_status[$row['id']] = $row['name'];
		}
		return $patient_status;
		
	}
	/*
	* Get FP type list
	*
	**/
	public function _get_fptype_dropdown(){
		$query = $this->db->get('fp_types');

		foreach ($query->result_array() as $row) {
			$fptypes[$row['id']] = $row['name'];
		}
		return $fptypes;
	}
	/*
	* Get FP type list
	*
	**/
	public function _get_fpplace_dropdown(){
		$query = $this->db->get('fp_places');

		foreach ($query->result_array() as $row) {
			$fpplaces[$row['id']] = $row['name'];
		}
		return $fpplaces;
	}
	/*
	* Get vaccine place
	*
	**/
	public function _get_vccplace_dropdown(){
		$query = $this->db->get('epi_places');

		foreach ($query->result_array() as $row) {
			$vccplaces[$row['id']] = $row['name'];
		}
		return $vccplaces;
	}
	/*
	* Get vaccine type
	*
	**/
	public function _get_vcctype_dropdown(){
		$query = $this->db->get('epi_vaccines');

		foreach ($query->result_array() as $row) {
			$vcctypes[$row['id']] = $row['eng_name'];
		}
		return $vcctypes;
	}
	/*
	* Get ncd screening smoke type
	*
	**/
	public function _get_smoke_dropdown(){
		$query = $this->db->get('ncd_screening_smokes');

		foreach ($query->result_array() as $row) {
			$result[$row['id']] = $row['name'];
		}
		return $result;
	}
	/*
	* Get ncd screening alcohol type
	*
	**/
	public function _get_alcohol_dropdown(){
		$query = $this->db->get('ncd_screening_alcohols');

		foreach ($query->result_array() as $row) {
			$result[$row['id']] = $row['name'];
		}
		return $result;
	}
	/*
	* Get ncd screening alcohol type
	*
	**/
	public function _get_blood_screen_dropdown(){
		$query = $this->db->get('ncd_screening_bloods');

		foreach ($query->result_array() as $row) {
			$result[$row['id']] = $row['name'];
		}
		return $result;
	}
	/*
	* Get ncd screening alcohol type
	*
	**/
	public function _getlab_orders_list(){
		$result = $this->db->order_by('name', 'desc')->get('lab_groups')->result();
		return $result;
	}
}
/* End of file basic_model.php */
/* Location: ./application/models/basic_model.php */