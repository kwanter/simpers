<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_nomenklatur extends MY_Model {
    var $table          = 'vw_jabatan';
    var $table_nomen    = 'vw_nomenklatur';
    var $table_jabatan  = 'm_nomenklatur';
    var $table_formasi  = 'vw_formasi_nomenklatur';
    var $table_uker     = 'm_uker';
    var $table_pejabat_cuti = 'vw_pejabat_cuti';

    var $column_order   = array('id_nomenklatur'); //set column field database for datatable orderable
    var $column_search  = array('jabatan','job_title'); //set column field database for datatable searchable
    var $order          = array(null); // default order
    var $data           = array();
    var $where          = array('I','II','IV');
    var $separator      = '';


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where_not_in('level',$this->where);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered()
    {
        $this->_get_datatables_query();
        $this->db->where_not_in('level',$this->where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        $this->db->where_not_in('level',$this->where);
        return $this->db->count_all_results();
    }

    public function get_datatable($uker)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('unit_kerja',$uker);
        $this->db->where_not_in('level',$this->where);
        $this->db->order_by('kelas_jabatan','ASC');
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredUker($uker)
    {
        $this->_get_datatables_query();
        $this->db->where('unit_kerja',$uker);
        $this->db->where_not_in('level',$this->where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllUker($uker)
    {
        $this->db->from($this->table);
        $this->db->where('unit_kerja',$uker);
        $this->db->where_not_in('level',$this->where);
        return $this->db->count_all_results();
    }

    public function saveData($post){
        //informasi dasar data nomenklatur
        $kode_jabatan = str_replace("_","",$this->db->escape_str($post['kode_jabatan']));
        $jabatan = str_replace("_","",$this->db->escape_str($post['nama_jabatan']));
        $parent = $this->db->escape_str($post['parent']);
        $job_title = $this->db->escape_str($post['job_title']);
        $jumlah = $this->db->escape_str($post['jumlah']);
        $kj = $this->db->escape_str($post['kj']);
        $grup = $this->db->escape_str($post['grup']);
        $id_subdivisi = $this->db->escape_str($post['uker']);

        $data = array(
                'id_parent'         => $parent,
                'kode_jabatan'      => $kode_jabatan,
                'jabatan'           => $jabatan,
                'job_title'         => $job_title,
                'id_kelasjabatan'   => $kj,
                'jumlah'            => $jumlah,
                'id_uker'           => $id_subdivisi,
                'grup'              => $grup,
        );

        $result = $this->save_where($this->table_jabatan,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar data nomenklatur
        $kode_jabatan = str_replace("_","",$this->db->escape_str($post['kode_jabatan']));
        $jabatan = str_replace("_","",$this->db->escape_str($post['nama_jabatan']));
        $parent = $this->db->escape_str($post['parent']);
        $job_title = $this->db->escape_str($post['job_title']);
        $kj = $this->db->escape_str($post['kj']);
        $jumlah = $this->db->escape_str($post['jumlah']);
        $grup = $this->db->escape_str($post['grup']);
        $id_subdivisi = $this->db->escape_str($post['uker']);

        $data = array(
            'id_parent'     => $parent,
            'kode_jabatan'  => $kode_jabatan,
            'jabatan'       => $jabatan,
            'job_title'     => $job_title,
            'id_kelasjabatan'   => $kj,
            'jumlah'        => $jumlah,
            'id_uker'       => $id_subdivisi,
            'grup'          => $grup,
        );

        $where = array(
            'id_nomenklatur' => $this->db->escape_str($post['id_nomenklatur']),
        );

        $result= $this->update_where($this->table_jabatan,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function getData($id){
        $this->db->from($this->table_jabatan);
        $this->db->where('id_nomenklatur',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function getPejabatData(){
        $this->db->from($this->table_pejabat_cuti);
        $this->db->order_by('nama_karyawan','ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function searchData($data){
        $this->db->from($this->table_nomen);
        $this->db->like('jabatan',$data,'both');
        $this->db->order_by('jabatan','ASC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function searchDataCuti($data){
        $this->db->from($this->table_pejabat_cuti);
        $this->db->like('nama_karyawan',$data,'both');
        $this->db->order_by('kelas_jabatan','ASC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function deleteData($id){
        $this->db->where('id_nomenklatur', $id);
        $this->db->delete($this->table_jabatan);
    }

    public function getParent($id){
        $this->data[] = $id;
        $this->db->where('id_parent', $id);
        $result = $this->db->get($this->table_uker);
        foreach ($result->result() as $row)
        {
            $this->data[] = $row->id_uker;
            $this->getParent($row->id_uker);
        }
        return $this->data;
    }

    public function getIDParent($id){
        $this->db->where('id_uker',$id);
        $query = $this->db->get($this->table_jabatan);

        if($query->num_rows() > 0)
            return $query->row()->id_parent;
    }

    function getParentID($id){
        $this->db->where('id_nomenklatur',$id);
        $query = $this->db->get($this->table_jabatan);

        if($query->num_rows() > 0)
            return $query->row()->id_parent;
    }

    public function getAtasan($id,$search){
        //$id_parent = $this->getIDParent($id);
        $id_result = $this->getParent($id);

        $this->db->from($this->table_jabatan);
        $this->db->or_where_in('id_uker',$id_result);
        $this->db->like('jabatan',$search,'both');
        $this->db->order_by('jabatan','ASC');

        return $this->db->get()->result();
    }

    public function getAtasanName($id){
        $data = $this->getParentID($id);
        $this->db->from($this->table_jabatan);
        $this->db->where('id_nomenklatur',$data);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->jabatan;
    }

    public function getDataLaporan(){
        $this->db->from($this->table_formasi);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function countParent($id,$separator){
        $this->separator = '';
        $result = $this->getCountParent($id,$separator);

        return $result;
    }

    public function getCountParent($id,$separator){
        $this->db->where('id_nomenklatur', $id);
        $result = $this->db->get($this->table_formasi);
        $this->separator .= $separator;
        foreach ($result->result() as $row)
        {
            $this->getCountParent($row->id_parent,$separator);
        }
        return $this->separator;
    }

    public function countUker(){
        $this->db->from($this->table_uker);
        $this->db->where('level','III');
        $query = $this->db->get();

        return $query->num_rows();
    }

    function countJabatan($id,$separator){
        $this->separator = '';
        $result = $this->getCountParent($id,$separator);

        return $result;
    }

    function getcountJabatan($id,$separator){
        $this->db->where('id_nomenklatur', $id);
        $result = $this->db->get($this->table);
        $this->separator .= $separator;
        foreach ($result->result() as $row)
        {
            $this->getCountParent($row->id_parent,$separator);
        }
        return $this->separator;
    }

    function getUker(){
        $this->db->select('nama_uker');
        $this->db->from($this->table_uker);
        $this->db->where('level','III');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    function getCountUker(){
        $this->db->select('unit_kerja');
        $this->db->from($this->table_formasi);
        $this->db->group_by('unit_kerja');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    function getPejabatTTD($id){
        $this->db->select('jabatan,job_title,nama_karyawan,nik,tugas_jabatan,level');
        $this->db->from($this->table_pejabat_cuti);
        //$this->db->where('id_nomenklatur','6'); //id nomenklatur manajer sdm di database
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }
}
?>
