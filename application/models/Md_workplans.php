<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_workplans extends CI_Model {

	var $table = 'workplans';
	var $view = 'vw_workplans';
	
	

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
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}
	
	function getdata()
	{

		$this->db->select('*');
		$this->db->from($this->view);
		$this->db->order_by('id_workplans', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_workplans',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function deletebyid($id)
	{
		$this->db->where('id_workplans', $id);
		$this->db->delete($this->table);
	}

}
