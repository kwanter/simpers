<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendidikan_oc extends MY_Model {
    var $table             = 'm_riwayatpendidikan_oc';
    var $table_pendidikan  = 'm_jenjangpendidikan';

    var $column_order     = array('id_riwayatpendidikan_oc'); //set column field database for datatable orderable
    var $column_search    = array('nama_jurusan,peminatan,id_jenjangpendidikan,asal_lembagapendidikan,asal_kota_lp'); //set column field database for datatable searchable
    var $order            = array('level' => 'desc'); // default order

    public function get_datatable($id)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $this->db->order_by('tgl_kelulusan','desc');
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered($id)
    {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        return $this->db->count_all_results();
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_riwayatpendidikan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row_array();
    }

    public function saveData($post){
        //informasi dasar riwayat pendidikan
        $id_karyawan     = $this->db->escape_str($post['id_karyawan_edu']);
        $level           = $this->db->escape_str($post['level_pendidikan']);
        $jenjang         = $this->db->escape_str($post['jenjang_pendidikan']);
        $nama_jurusan    = $this->db->escape_str($post['nama_jurusan']);
        $tahun_kelulusan = $this->db->escape_str($post['tahun_kelulusan']);
        
        $data = array(
            'id_karyawan_oc'        => $id_karyawan,
            'nama_jurusan'          => $nama_jurusan,
            'id_jenjangpendidikan'  => $jenjang,
            'level'                 => $level,
            'tgl_kelulusan'         => $tahun_kelulusan,
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat pendidikan
        $id_karyawan     = $this->db->escape_str($post['id_karyawan_edu']);
        $level           = $this->db->escape_str($post['level_pendidikan']);
        $jenjang         = $this->db->escape_str($post['jenjang_pendidikan']);
        $nama_jurusan    = $this->db->escape_str($post['nama_jurusan']);
        $tahun_kelulusan = $this->db->escape_str($post['tahun_kelulusan']);

        $where = array(
            'id_riwayatpendidikan_oc' => $this->db->escape_str($post['id_riwayatpendidikan'])
        );

        $data = array(
            'id_karyawan_oc'        => $id_karyawan,
            'nama_jurusan'          => $nama_jurusan,
            'id_jenjangpendidikan'  => $jenjang,
            'level'                 => $level,
            'tgl_kelulusan'         => $tahun_kelulusan,
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->where('id_riwayatpendidikan_oc', $id);
        $this->db->delete($this->table);
    }

    public function getJenjang(){
        $this->db->from($this->table_pendidikan);
        $this->db->order_by('level','ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getJenjangPendidikan($id){
        $this->db->from($this->table_pendidikan);
        $this->db->where('id_jenjangpendidikan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->jenjang_pendidikan;
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_riwayatpendidikan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan_oc;
    }

    public function getLevel($id){
        $this->db->from($this->table_pendidikan);
        $this->db->where('id_jenjangpendidikan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->level;
    }

    public function checkEdu($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $this->db->order_by('level','DESC');
        $this->db->order_by('tgl_kelulusan','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }
}
?>
