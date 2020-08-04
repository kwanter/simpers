<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_main extends MY_Model{
    var $table = 'm_pilihan';

    public function getStatusNikah($id){
        $this->db->select('subID,value');
        $this->db->from($this->table);
        $this->db->where('nama_grup','status_nikah');
        $this->db->where('subID',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->value;
    }

    public function getPilihan($nama_grup){
        $this->db->select('subID,value');
        $this->db->from($this->table);
        $this->db->where('nama_grup',$nama_grup);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getAgama($id){
        $this->db->select('subID,value');
        $this->db->from($this->table);
        $this->db->where('nama_grup','agama');
        $this->db->where('subID',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->value;
    }
}
?>
