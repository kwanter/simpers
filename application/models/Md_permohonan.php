<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_permohonan extends CI_Model {

	var $table = 'permohonan';
	var $view = 'vw_permohonan';
	

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
		$where = "num_state=1 OR num_state=2 OR num_state=3";
		$this->db->where($where);
		//$this->db->where('num_state',1);
		
		$this->db->order_by('id_permohonan', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	function getdata2()
	{
		$this->db->select('*');
		$this->db->from($this->view);
		$where = "num_state=3 OR num_state=4";
		$this->db->where($where);
		//$this->db->where('num_state',1);
		
		$this->db->order_by('id_permohonan', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	function getdata3 ()
	{
		$this->db->select('*');
		$this->db->from($this->view);
		$this->db->order_by('id_permohonan', 'DESC');
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_permohonan',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function deletebyid($id)
	{
		$this->db->where('id_permohonan', $id);
		$this->db->delete($this->table);
	}
	
	public function filldok($id)
	{
		$query = $this->getbyid($id);
		foreach ($query as $row){
			$idreq = $row->id_permohonan;
			$idklas = $row->id_klasifikasi;
		}
		
		$insert_user_stored_proc = "CALL proc_fill_dok(?, ?)";
        $data = array('idreq' => $idreq, 'idklas' => $idklas);
        $result = $this->db->query($insert_user_stored_proc, $data);
        if ($result !== NULL) {
            return TRUE;
        }
        return FALSE;
		
	}

}
