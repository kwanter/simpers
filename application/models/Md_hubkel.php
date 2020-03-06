<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_hubkel extends CI_Model {

	var $table = 'm_hubkel';

	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}

	
	function getAll()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->order_by('num_order', 'ASC');
		$query = $this->db->get();

		return $query->result();
	}
	

}
