<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_jenjang extends CI_Model {

	var $table = 'm_jenjang';

	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}

	
	function getAll()
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$query = $this->db->get();

		return $query->result();
	}
	

}
