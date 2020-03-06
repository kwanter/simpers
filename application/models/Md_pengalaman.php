<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_pengalaman extends CI_Model {

	var $table = 'rw_pengalaman';
	var $view = 'vw_pengalaman';
	

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
		
		$this->db->order_by('tgl_mulai', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_rwpengalaman',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function deletebyid($id)
	{
		$this->db->where('id_rwpengalaman', $id);
		$this->db->delete($this->table);
	}
	
	

}
