<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Drugusages_model extends CI_Model {

  public function dosave($name1, $name2)
  {
    $result = $this->db->set('name1', $name1)
                        ->set('name2', $name2)
                        ->insert('drugusages');
    return $result;
  }
}