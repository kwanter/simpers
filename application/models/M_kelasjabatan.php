<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kelasjabatan extends MY_Model{
    var $table         = 'vw_merit';
    var $table_kj      = 'm_kelasjabatan';
    var $column_order  = array('id','periodik_0','periodik_1','periodik_2','periodik_3','periodik_4','periodik_5','periodik_6','periodik_7','periodik_8','periodik_9','periodik_10','periodik_11','periodik_12','periodik_13','periodik_14','periodik_15'); //set column field database for datatable orderable
    var $column_search = array('kelas_jabatan'); //set column field database for datatable searchable
    var $order         = array('id' => 'asc'); // default order

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
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

    public function saveData($post){
        $id         = $this->db->escape_str($post['id_kelasjabatan']);
        $kelas      = strtoupper($this->db->escape_str($post['kelas_jabatan']));
        $periodik   = $this->db->escape_str($post['periodik']);
        $merit      = $this->db->escape_str($post['merit']);
        $kj         = substr($id, 0, -3);

        $data = array(
            'kode_kelasjabatan' => $id,
            'nama_kelasjabatan' => $kelas,
            'periodik'          => $periodik,
            'merit'             => $merit,
            'kelas_jabatan'     => $kj,
        );

        $result = $this->save_where($this->table_kj,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        $besaran_merit = $this->db->escape_str($post['merit']);

        $where = array(
            'id_kelasjabatan' => $this->db->escape_str($post['id_kj']),
        );

        $data = array(
            'merit' => $besaran_merit,
        );

        $result = $this->update_where($this->table_kj,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function getKelasJabatan($id){
        $this->db->select('kelas_jabatan');
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->kelas_jabatan;
    }

    public function getKJData(){
        $this->db->select('id_kelasjabatan,kode_kelasjabatan');
        $this->db->from($this->table_kj);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getKJDetail($id){
        $this->db->select('nama_kelasjabatan,periodik,merit');
        $this->db->from($this->table_kj);
        $this->db->where('id_kelasjabatan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function getKJ(){
        $this->db->select('kelas_jabatan');
        $this->db->from($this->table_kj);
        $this->db->group_by('kelas_jabatan');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getNamaKJ(){
        $this->db->from($this->table_kj);
        $this->db->group_by('nama_kelasjabatan');
        $this->db->order_by('id_kelasjabatan');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getPeriode(){
        $this->db->select('periodik');
        $this->db->from($this->table_kj);
        $this->db->group_by('periodik');
        $this->db->order_by('id_kelasjabatan');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }
}
?>

