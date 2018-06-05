<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pendidikan extends MY_Model {
    var $table             = 'm_riwayatpendidikan';
    var $table_pendidikan  = 'm_jenjangpendidikan';

    var $column_order     = array('id_riwayatpendidikan'); //set column field database for datatable orderable
    var $column_search    = array('nama_jurusan,peminatan,id_jenjangpendidikan,asal_lembagapendidikan,asal_kota_lp'); //set column field database for datatable searchable
    var $order            = array('level' => 'asc'); // default order

    public function get_datatable($id)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered($id)
    {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        return $this->db->count_all_results();
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_riwayatpendidikan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row_array();
    }

    public function saveData($post){
        //informasi dasar riwayat pendidikan
        $id_karyawan    = $this->db->escape_str($post['nik']);
        $jurusan        = $this->db->escape_str($post['jurusan']);
        $peminatan      = $this->db->escape_str($post['peminatan']);
        $id_jenjang     = $this->db->escape_str($post['jenjang']);
        $asal_lp        = $this->db->escape_str($post['asal_lp']);
        $asal_kota      = $this->db->escape_str($post['asal_kota']);
        $tgl_lulus      = $this->db->escape_str($post['tgl_lulus']);
        $nilai          = $this->db->escape_str($post['nilai']);
        $skala          = $this->db->escape_str($post['skala_nilai']);
        $level          = $this->db->escape_str($post['level']);

        $data = array(
            'id_karyawan'               => $id_karyawan,
            'nama_jurusan'              => $jurusan,
            'peminatan'                 => $peminatan,
            'id_jenjangpendidikan'      => $id_jenjang,
            'asal_lembaga_pendidikan'   => $asal_lp,
            'asal_kota_lp'              => $asal_kota,
            'tgl_kelulusan'             => $tgl_lulus,
            'nilai_kelulusan'           => $nilai,
            'skala_nilai'               => $skala,
            'level'                     => $level,
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat pendidikan
        $jurusan    = $this->db->escape_str($post['jurusan']);
        $peminatan  = $this->db->escape_str($post['peminatan']);
        $id_jenjang = $this->db->escape_str($post['jenjang']);
        $asal_lp    = $this->db->escape_str($post['asal_lp']);
        $asal_kota  = $this->db->escape_str($post['asal_kota']);
        $tgl_lulus  = $this->db->escape_str($post['tgl_lulus']);
        $nilai      = $this->db->escape_str($post['nilai']);
        $skala      = $this->db->escape_str($post['skala_nilai']);
        $level      = $this->db->escape_str($post['level']);

        $where = array(
            'id_riwayatpendidikan' => $this->db->escape_str($post['id_riwayat'])
        );

        $data = array(
            'nama_jurusan'              => $jurusan,
            'peminatan'                 => $peminatan,
            'id_jenjangpendidikan'      => $id_jenjang,
            'asal_lembaga_pendidikan'   => $asal_lp,
            'asal_kota_lp'              => $asal_kota,
            'tgl_kelulusan'             => $tgl_lulus,
            'nilai_kelulusan'           => $nilai,
            'skala_nilai'               => $skala,
            'level'                     => $level,
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->where('id_riwayatpendidikan', $id);
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
        $this->db->where('id_riwayatpendidikan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan;
    }

    public function getLevel($id){
        $this->db->from($this->table_pendidikan);
        $this->db->where('id_jenjangpendidikan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->level;
    }

    public function get_pendidikan_cv($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }
}
?>
