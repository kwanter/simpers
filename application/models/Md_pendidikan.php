<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_pendidikan extends CI_Model {

	var $table = 'rw_pendidikan';
	var $view = 'vw_pendidikan';
	

	public function __construct()
	{
		parent::__construct();
		//$this->load->database();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function update($where, $data)
	{
		return $this->db->update($this->table, $data, $where);
		//return $this->db->affected_rows();
	}
	
	function getdata($id=0)
	{
		$this->db->select('*');
		$this->db->from($this->view);
		//$where = "num_state=1 OR num_state=2 OR num_state=3";
		//$this->db->where($where);
		$this->db->where('id_karyawan',$id);
		
		$this->db->order_by('num_level', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_rwpendidikan',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function deletebyid($id)
	{
		$this->db->where('id_rwpendidikan', $id);
		$this->db->delete($this->table);
	}
	
	

}
