<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_karyawan extends CI_Model {

	var $table = 'm_karyawan';
	//var $view = 'vw_karyawan';
	var $view = 'vw_mkaryawan';
	

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
	
	function getdata()
	{
		$this->db->select('*');
		$this->db->from($this->view);
		//$where = "num_state=1 OR num_state=2 OR num_state=3";
		//$this->db->where($where);
		//$this->db->where('num_state',1);
		
		//$this->db->order_by('id_karyawan', 'DESC');
		$this->db->order_by('lokasi' );
		$this->db->order_by('nama_uker' );
		$this->db->order_by('nama_karyawan' );
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_karyawan',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function deletebyid($id)
	{
		$this->db->where('id_karyawan', $id);
		$this->db->delete($this->table);
	}
	
	

}
