<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Village_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
  /**
   * Get village list
   **/
	public function _getlist( $owner_code ){
    $sql = '
      select v.*,
      (select count(h.id) from house h where h.village_code=v.village_code) as total_house
      from villages v
    ';
		$result = $this->db->query( $sql )->result();
		return $result;
	}
	/**
	 * Get Villages combo box
	 * @return array()
	 **/
	public function _get_villages_dropdown() {
		$query = $this->db->get('villages');

		foreach ($query->result_array() as $row) {
			$result[$row['village_code']] = ' หมู่ ' . substr( $row['village_code'], -2 ) . ' ' . $row['village_name'];
		}
		return $result;
	}
  
  /**
   * Get house in village
   *
   * @param string $village_code
   * @return array House list
   **/
  public function _get_house_list( $village_code )
  {
    $result = $this->db->select(array('house.id', 'house.address'))
                    ->where( 'village_code', $village_code )
                    ->get('house')
                    ->result();
    return $result;
  }
	
}
/* End of file epi_model.php */
/* Location: ./application/models/epi_model.php */