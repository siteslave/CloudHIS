<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class House_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}

	/**
	 * Get House list for edit
	 *
	 * @param string $village_code
	 *
	 **/
	public function _get_house_in_village( $village_code )
	{
		$sql = '
			select h.id, h.address, h.house_code,
			( select count(id) from people where house_id=h.id and sex="1" ) as m,
			( select count(id) from people where house_id=h.id and sex="2" ) as f,
			( select count(id) from people where house_id=h.id ) as total
			from house h where h.village_code="'.$village_code.'"
			order by h.address
		';
		$result = $this->db->query( $sql )->result();
		return $result;
		
	}
	
}
/* End of file epi_model.php */
/* Location: ./application/models/epi_model.php */