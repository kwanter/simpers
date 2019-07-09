<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_keluarga extends MY_Model {
    var $table             = 'm_keluarga';
    var $table_hubkeluarga = 'm_hubungankeluarga';
    var $table_keluarga    = 'vw_keluarga_cv';

    var $column_order     = array('id_keluarga'); //set column field database for datatable orderable
    var $column_search    = array('nama_keluarga'); //set column field database for datatable searchable
    var $order            = array('id_keluarga' => 'asc'); // default order

    public function get_datatable($id)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan',$id);
        $this->db->where('status','hidup');
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered($id)
    {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan',$id);
        $this->db->where('status','hidup');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        $this->db->where('status','hidup');
        return $this->db->count_all_results();
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_keluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row_array();
    }

    public function getHubKeluarga(){
        $this->db->from($this->table_hubkeluarga);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getKetHubKeluarga($id){
        $this->db->from($this->table_hubkeluarga);
        $this->db->where('id_hubungankeluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->desc_hubungan;
    }

    public function saveData($post){
        //informasi dasar data keluarga
        $id_karyawan = $this->db->escape_str($post['nik']);
        $nama = $this->db->escape_str($post['nama_keluarga']);
        $hub_keluarga = $this->db->escape_str($post['hub_keluarga']);
        $tmpt_lahir = $this->db->escape_str($post['tmpt_lahir']);
        $tgl_lahir = $this->db->escape_str($post['tgl_lahir']);
        $agama = $this->db->escape_str($post['agama']);
        $suku = $this->db->escape_str($post['suku']);
        $jk = $this->db->escape_str($post['jk']);

        //informasi data keluarga untuk alamat
        $alamat = $this->db->escape_str($post['alamat']);
        $kelurahan = $this->db->escape_str($post['kelurahan']);
        $kecamatan = $this->db->escape_str($post['kecamatan']);
        $kota = $this->db->escape_str($post['kota']);
        $provinsi = $this->db->escape_str($post['provinsi']);
        $kode_pos = str_replace("_","",$this->db->escape_str($post['kode_pos']));

        //informasi data keluarga untuk komunikasi
        $no_hp = str_replace("_","",$this->db->escape_str($post['no_hp']));
        $pekerjaan = $this->db->escape_str($post['pekerjaan']);

        if($tgl_lahir == '' || $tgl_lahir == '0000-00-00' || $tgl_lahir == NULL){
            $tgl_lahir = '1970-01-01';
        }

        $data = array(
            'id_karyawan'           => $id_karyawan,
            'nama_keluarga'         => $nama,
            'id_hubungankeluarga'   => $hub_keluarga,
            'tmpt_lahir'            => $tmpt_lahir,
            'tgl_lahir'             => $tgl_lahir,
            'jenis_kelamin'         => $jk,
            'agama'                 => $agama,
            'suku'                  => $suku,
            'alamat'                => $alamat,
            'kelurahan'             => $kelurahan,
            'kecamatan'             => $kecamatan,
            'kota'                  => $kota,
            'provinsi'              => $provinsi,
            'kode_pos'              => $kode_pos,
            'no_hp'                 => $no_hp,
            'pekerjaan'             => $pekerjaan
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar data keluarga
        $nama = $this->db->escape_str($post['nama_keluarga']);
        $hub_keluarga = $this->db->escape_str($post['hub_keluarga']);
        $tmpt_lahir = $this->db->escape_str($post['tmpt_lahir']);
        $tgl_lahir = $this->db->escape_str($post['tgl_lahir']);
        $agama = $this->db->escape_str($post['agama']);
        $suku = $this->db->escape_str($post['suku']);
        $jk = $this->db->escape_str($post['jk']);

        //informasi data keluarga untuk alamat
        $alamat = $this->db->escape_str($post['alamat']);
        $kelurahan = $this->db->escape_str($post['kelurahan']);
        $kecamatan = $this->db->escape_str($post['kecamatan']);
        $kota = $this->db->escape_str($post['kota']);
        $provinsi = $this->db->escape_str($post['provinsi']);
        $kode_pos = str_replace("_","",$this->db->escape_str($post['kode_pos']));

        //informasi data keluarga untuk komunikasi
        $no_hp = str_replace("_","",$this->db->escape_str($post['no_hp']));
        $pekerjaan = $this->db->escape_str($post['pekerjaan']);

        if($tgl_lahir == '' || $tgl_lahir == '0000-00-00' || $tgl_lahir == NULL){
            $tgl_lahir = '1970-01-01';
        }

        $where = array(
            'id_keluarga' => $this->db->escape_str($post['id_keluarga'])
        );

        $data = array(
            'nama_keluarga'         => $nama,
            'id_hubungankeluarga'   => $hub_keluarga,
            'jenis_kelamin'         => $jk,
            'tmpt_lahir'            => $tmpt_lahir,
            'tgl_lahir'             => $tgl_lahir,
            'agama'                 => $agama,
            'suku'                  => $suku,
            'alamat'                => $alamat,
            'kelurahan'             => $kelurahan,
            'kecamatan'             => $kecamatan,
            'kota'                  => $kota,
            'provinsi'              => $provinsi,
            'kode_pos'              => $kode_pos,
            'no_hp'                 => $no_hp,
            'pekerjaan'             => $pekerjaan
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->where('id_keluarga', $id);
        $this->db->delete($this->table);
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_keluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan;
    }

    public function get_keluarga_cv($id){
        $this->db->from($this->table_keluarga);
        $this->db->where('id_karyawan',$id);
        $this->db->order_by('level','asc');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getNama($id){
        $this->db->from($this->table);
        $this->db->where('id_keluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->nama_keluarga;
    }

    public function getDesc($id){
        $this->db->from($this->table_hubkeluarga);
        $this->db->where('id_hubungankeluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->desc_hubungan;
    }

    public function getKeterangan($id){
        $this->db->from($this->table);
        $this->db->where('id_keluarga',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $query_hub = $this->db->from($this->table_hubkeluarga)
                     ->where('id_hubungankeluarga',$query->row()->id_hubungankeluarga)
                     ->get();
            if($query_hub->num_rows() > 0)
                return $query_hub->row()->desc_hubungan;
        }
    }
    
}
?>
