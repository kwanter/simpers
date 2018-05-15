<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tunjangan extends MY_Model
{
    var $table = 'vw_tunjangan';
    var $table_tj = 'm_tunjangan';
    var $column_order = array('tunjangan', null, null,null,null,null,null,null,null,null,null,null,null); //set column field database for datatable orderable
    var $column_search = array('tunjangan'); //set column field database for datatable searchable
    var $order = array('id' => 'asc'); // default order

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function saveData($post)
    {
        $id = $this->db->escape_str($post['id_tunjangan']);
        $nama = strtoupper($this->db->escape_str($post['nama_tunjangan']));
        $tunjangan = $this->db->escape_str($post['tunjangan']);
        $kelasjabatan = $this->db->escape_str($post['kelas_jabatan']);
        $jt = substr($id, 0, -5);

        $data = array(
            'kode_tunjangan'    => $id,
            'nama_tunjangan'    => $nama,
            'besaran_tunjangan' => $tunjangan,
            'id_kelasjabatan'   => $kelasjabatan,
            'jenis_tunjangan'   => $jt,
        );

        $result = $this->save_where($this->table_tj, $data);

        if ($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        $besaran_tunjangan = $this->db->escape_str($post['besaran_tunjangan']);

        $where = array(
            'id_tunjangan' => $this->db->escape_str($post['id_tunjangan']),
        );

        $data = array(
            'besaran_tunjangan' => $besaran_tunjangan,
        );

        $result = $this->update_where($this->table_tj,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function getTunjanganData(){
        $this->db->select('id_tunjangan,kode_tunjangan');
        $this->db->from($this->table_tj);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getTunjanganDetail($id){
        $this->db->select('nama_tunjangan,besaran_tunjangan,id_kelasjabatan,kode_tunjangan');
        $this->db->from($this->table_tj);
        $this->db->where('id_tunjangan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }
}
?>
