<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_karyawan extends MY_Model {
    var $table             = 'm_karyawan_oc';
    var $table_pilihan     = 'm_pilihan';

    var $column_order      = array('id_karyawan_oc'); //set column field database for datatable orderable
    var $column_search     = array(null); //set column field database for datatable searchable
    var $order             = array('id_karyawan_oc' => 'desc'); // default order

    public function get_datatable(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered() {
        $this->_get_datatables_query();
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll(){
        $this->db->from($this->table);
        $this->db->where('soft_delete','not-deleted');
        return $this->db->count_all_results();
    }


    public function saveData($post){
        if (!empty($post['pilihan_domisili']))
            $pilihan = $this->db->escape_str($post['pilihan_domisili']);
        else
            $pilihan = '0';

        //informasi dasar data pegawai
        $nik = $this->db->escape_str($post['nik']);
        $nama = $this->db->escape_str($post['nama_karyawan']);
        $jk = $this->db->escape_str($post['jk']);
        $tmpt_lahir = $this->db->escape_str($post['tmpt_lahir']);
        $tgl_lahir = $this->db->escape_str($post['tgl_lahir']);
        $agama = $this->db->escape_str($post['agama']);
        $status_nikah = $this->db->escape_str($post['status_nikah']);
        $jumlah_anak = $this->db->escape_str($post['jumlah_anak']);

        //informasi data pegawai untuk komunikasi
        $no_telp = str_replace("_","",$this->db->escape_str($post['no_telp']));
        $no_hp = str_replace("_","",$this->db->escape_str($post['no_hp']));
        $no_hp_2 = str_replace("_","",$this->db->escape_str($post['no_hp2']));

        if($tgl_lahir == '0000-00-00' || $tgl_lahir == '' || $tgl_lahir == NULL){
            $tgl_lahir = '1970-01-01';
        }

        //informasi data pegawai untuk alamat
        $alamat_domisili = $this->db->escape_str($post['alamat_domisili']);
        $kelurahan_domisili = $this->db->escape_str($post['kelurahan_domisili']);
        $kecamatan_domisili = $this->db->escape_str($post['kecamatan_domisili']);
        $kota_domisili = $this->db->escape_str($post['kota_domisili']);
        $provinsi_domisili = $this->db->escape_str($post['provinsi_domisili']);
        $kode_pos_domisili = str_replace("_","",$this->db->escape_str($post['kode_pos_domisili']));
        $alamat_ktp = $this->db->escape_str($post['alamat_ktp']);
        $kelurahan_ktp = $this->db->escape_str($post['kelurahan_ktp']);
        $kecamatan_ktp = $this->db->escape_str($post['kecamatan_ktp']);
        $kota_ktp = $this->db->escape_str($post['kota_ktp']);
        $provinsi_ktp = $this->db->escape_str($post['provinsi_ktp']);
        $kode_pos_ktp = str_replace("_","",$this->db->escape_str($post['kode_pos_ktp']));
        
        $data = array(
            'nik'                   => $nik,
            'nama_karyawan'         => $nama,
            'jenis_kelamin'         => $jk,
            'tmpt_lahir'            => $tmpt_lahir,
            'tgl_lahir'             => $tgl_lahir,
            'agama'                 => $agama,
            'status_nikah'          => $status_nikah,
            'jmlh_anak'           => $jumlah_anak,
            'alamat_domisili'       => $alamat_domisili,
            'alamat_ktp'            => $alamat_ktp,
            'kelurahan_domisili'    => $kelurahan_domisili,
            'kelurahan_ktp'         => $kelurahan_ktp,
            'kecamatan_domisili'    => $kecamatan_domisili,
            'kecamatan_ktp'         => $kecamatan_ktp,
            'kota_domisili'         => $kota_domisili,
            'kota_ktp'              => $kota_ktp,
            'provinsi_domisili'     => $provinsi_domisili,
            'provinsi_ktp'          => $provinsi_ktp,
            'kode_pos_domisili'     => $kode_pos_domisili,
            'kode_pos_ktp'          => $kode_pos_ktp,
            'no_telp'               => $no_telp,
            'no_hp'                 => $no_hp,
            'no_hp_2'               => $no_hp_2,
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        if (!empty($post['pilihan_domisili']))
            $pilihan = $this->db->escape_str($post['pilihan_domisili']);
        else
            $pilihan = '0';

        //informasi dasar data pegawai
        $nik = $this->db->escape_str($post['nik']);
        $nama = $this->db->escape_str($post['nama_karyawan']);
        $jk = $this->db->escape_str($post['jk']);
        $tmpt_lahir = $this->db->escape_str($post['tmpt_lahir']);
        $tgl_lahir = $this->db->escape_str($post['tgl_lahir']);
        $agama = $this->db->escape_str($post['agama']);
        $status_nikah = $this->db->escape_str($post['status_nikah']);
        $jumlah_anak = $this->db->escape_str($post['jumlah_anak']);

        //informasi data pegawai untuk komunikasi
        $no_telp = str_replace("_","",$this->db->escape_str($post['no_telp']));
        $no_hp = str_replace("_","",$this->db->escape_str($post['no_hp']));
        $no_hp_2 = str_replace("_","",$this->db->escape_str($post['no_hp2']));

        if($tgl_lahir == '0000-00-00' || $tgl_lahir == '' || $tgl_lahir == NULL){
            $tgl_lahir = '1970-01-01';
        }

        //informasi data pegawai untuk alamat
        $alamat_domisili = $this->db->escape_str($post['alamat_domisili']);
        $kelurahan_domisili = $this->db->escape_str($post['kelurahan_domisili']);
        $kecamatan_domisili = $this->db->escape_str($post['kecamatan_domisili']);
        $kota_domisili = $this->db->escape_str($post['kota_domisili']);
        $provinsi_domisili = $this->db->escape_str($post['provinsi_domisili']);
        $kode_pos_domisili = str_replace("_","",$this->db->escape_str($post['kode_pos_domisili']));
        $alamat_ktp = $this->db->escape_str($post['alamat_ktp']);
        $kelurahan_ktp = $this->db->escape_str($post['kelurahan_ktp']);
        $kecamatan_ktp = $this->db->escape_str($post['kecamatan_ktp']);
        $kota_ktp = $this->db->escape_str($post['kota_ktp']);
        $provinsi_ktp = $this->db->escape_str($post['provinsi_ktp']);
        $kode_pos_ktp = str_replace("_","",$this->db->escape_str($post['kode_pos_ktp']));

        if($post['no_hp2'] == NULL)
            $no_hp_2 = '';
        else
            $no_hp_2 = str_replace("_","",$this->db->escape_str($post['no_hp2']));

        $where = array(
            'id_karyawan_oc' => $this->db->escape_str($post['id_karyawan']),
        );

        $data = array(
            'nik'                   => $nik,
            'nama_karyawan'         => $nama,
            'jenis_kelamin'         => $jk,
            'tmpt_lahir'            => $tmpt_lahir,
            'tgl_lahir'             => $tgl_lahir,
            'agama'                 => $agama,
            'status_nikah'          => $status_nikah,
            'jmlh_anak'             => $jumlah_anak,
            'alamat_domisili'       => $alamat_domisili,
            'alamat_ktp'            => $alamat_ktp,
            'kelurahan_domisili'    => $kelurahan_domisili,
            'kelurahan_ktp'         => $kelurahan_ktp,
            'kecamatan_domisili'    => $kecamatan_domisili,
            'kecamatan_ktp'         => $kecamatan_ktp,
            'kota_domisili'         => $kota_domisili,
            'kota_ktp'              => $kota_ktp,
            'provinsi_domisili'     => $provinsi_domisili,
            'provinsi_ktp'          => $provinsi_ktp,
            'kode_pos_domisili'     => $kode_pos_domisili,
            'kode_pos_ktp'          => $kode_pos_ktp,
            'no_telp'               => $no_telp,
            'no_hp'                 => $no_hp,
            'no_hp_2'               => $no_hp_2,
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function cekFoto($nik){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$nik);
        $this->db->like('foto',$nik);
        $this->db->order_by('foto','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_karyawan_oc', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function getPilihanData($pilihan){
        $this->db->from($this->table_pilihan);
        $this->db->where('nama_grup',$pilihan);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }  
    }

}
?>
