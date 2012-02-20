<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package		CloudHIS
 * @author		Satit Rianpit
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @website		http://codeigniter.com
 * 
 **/
class Lab_model extends CI_Model {
	#construction method
	public function __construct(){
		parent::__construct();
	}
	
	/* *
	* Save service orders
	*/
	public function _save_order($vn ,$group_id)
	{
		$result = $this->db->set('vn', $vn)->set('lab_group_id', $group_id)->insert('lab_orders');
		$order_id = $this->db->insert_id();
		
		// generate item for lab result
		$this->_generate_lab_result($order_id, $group_id);		
		
		return $result;
	}
	// generate item for lab result
	private function _generate_lab_result($order_id, $group_id)
	{
		$lab_items = $this->db->where('lab_group_id', $group_id)->get('lab_items')->result();
		
		foreach ($lab_items as $item) {
			$this->db->set('lab_item_id', $item->id)
			 					->set('lab_order_id', $order_id)
			 					->insert('lab_results');
		}	
	}
}
/* End of file lab_model.php */
/* Location: ./application/models/lab_model.php */