<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Md_isidok extends CI_Model {

	var $table = 'permohonan_dok';
	var $view = 'vw_permohonan_dok';
	

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
	
	function getdata($id=0)
	{
		$this->db->select('*');
		$this->db->from($this->view);
		$this->db->where('id_permohonan',$id);
		$this->db->order_by('order_num', 'ASC');
		$query = $this->db->get();

		return $query;
	}
	
	public function getbyid($id)
	{
		$this->db->from($this->view);
		$this->db->where('id_permohonan_dok',$id);
		$query = $this->db->get();

		return $query->result();
	}
	
	public function delete($id)
	{
		$insert_user_stored_proc = "CALL proc_del_dok(?)";
        $data = array('idreq' => $id);
        $result = $this->db->query($insert_user_stored_proc, $data);
        if ($result !== NULL) {
            return TRUE;
        }
        return FALSE;
	}
	
	public function cekuncomplete($id)
	{
		$insert_user_stored_proc = "CALL proc_cek_uncomplete(?)";
        $data = array('idreq' => $id);
        $result = $this->db->query($insert_user_stored_proc, $data);
		$qty=0;
        foreach ($result->result() as $r){
			$qty=$r->qty;
		}
		$result->free_result();
		$result->next_result();
		//return $qty;
		/*
		if ($result !== NULL) {
            return TRUE;
        }
        return FALSE;
		*/
		if ($qty == 0) {
            return TRUE;
        }
        return FALSE;
	}
	
	public function cekuncompletedok($id)
	{
		$insert_user_stored_proc = "CALL proc_cek_uncompletedok(?)";
        $data = array('idreq' => $id);
        $result = $this->db->query($insert_user_stored_proc, $data);
		$qty=0;
        foreach ($result->result() as $r){
			$qty=$r->qty;
		}
		$result->free_result();
		$result->next_result();
		//return $qty;
		/*
		if ($result !== NULL) {
            return TRUE;
        }
        return FALSE;
		*/
		if ($qty == 0) {
            return TRUE;
        }
        return FALSE;
	}
}
