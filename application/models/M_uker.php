<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_uker extends MY_Model {
    var $table        = 'm_uker';
    var $table_uker   = 'vw_uker';
    var $data         = array();

    function getNamaDivisi($id){
        $this->db->from($this->table_uker);
        $this->db->where('id_subdiv',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->nama_divisi;
    }

    public function getSubdiv(){
        $this->db->from($this->table_uker);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function get_uker(){
        //$data = $this->uker_list(0);
        $this->db->where('level','III');
        $query = $this->db->get($this->table);

        if($query->num_rows() > 0)
            //return $data;
            return $query->result_array();
    }

    function uker_list($idparent = -1, $str='')
    {
        $this->db->where('id_parent', $idparent);
        $this->db->where('level','III');
        $result = $this->db->get($this->table);
        $str=$str."&raquo; ";
        foreach ($result->result() as $row)
        {
            $this->data[] = array(
                'id'   => $row->id_uker,
                'nama' => $str.$row->nama_uker,
            );
            $this->uker_list($row->id_uker,$str);
        }
        return $this->data;
    }
}
?>
