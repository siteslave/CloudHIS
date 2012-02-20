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
	public function _get_order_list($vn)
	{
		$result = $this->db->select(array(
			'lab_orders.vn', 'lab_groups.name', 'lab_groups.id'
			))
			->where('lab_orders.vn', $vn)
			->join('lab_groups', 'lab_groups.id=lab_orders.lab_group_id')
			->get('lab_orders')
			->result();
		return $result;
	}
	public function _get_lab_items_services($group_id)
	{
		$result = $this->db->select(array(
			'lab_results.id', 'lab_results.lab_item_id', 'lab_results.lab_result',
			'lab_items.name', 'lab_items.lab_unit'
			))
			->where('lab_orders.lab_group_id', $group_id)
			->join('lab_results', 'lab_results.lab_order_id=lab_orders.id')
			->join('lab_items', 'lab_items.id=lab_results.lab_item_id')
			->get('lab_orders')
			->result();
		return $result;
	}
	public function _check_order_duplicate($group_id, $vn)
	{
		$result = $this->db->where('vn', $vn)->where('lab_group_id', $group_id)->get('lab_orders')->result();
		return $result;
	}
	public function _get_order_visit_history($vn)
	{
		$result = $this->db->select(array('lab_orders.id', 'lab_groups.name'))
		 										->where('lab_orders.vn', $vn)
		 										->join('lab_groups', 'lab_groups.id=lab_orders.lab_group_id')
		 										->get('lab_orders')
			 									->result();
		return $result;
	}
	public function _remove_order($order_id)
	{
		$result = $this->db->where('id', $order_id)->delete('lab_orders');
		// clear order items
		$this->_remove_order_items($order_id);
		// return reslt
		return $result;
	}
	
	private function _remove_order_items($order_id) {
		$this->db->where('lab_order_id', $order_id)->delete('lab_results');
	}
	
	public function _remove_order_item_result($id)
	{
		$result = $this->db->where('id', $id)->delete('lab_results');
		return $result;
	}
	
}
/* End of file lab_model.php */
/* Location: ./application/models/lab_model.php */