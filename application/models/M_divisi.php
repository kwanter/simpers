<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_divisi extends MY_Model {
    var $table        = 'm_divisi';
    var $table_divisi = 'vw_divisi';
    var $table_subdiv = 'm_subdivisi';

    function getNamaDivisi($id){
        $this->db->from($this->table_divisi);
        $this->db->where('id_subdiv',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->nama_divisi;
    }

    public function getSubdiv(){
        $this->db->from($this->table_divisi);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

}
?>
