<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jabatan extends MY_Model {
    var $table             = 'm_riwayatjabatan';

    var $column_order      = array('id_riwayatjabatan'); //set column field database for datatable orderable
    var $column_search     = array('no_surat,tgl_berlaku,nama_jabatan,job_title,kelas_jabatan,periode'); //set column field database for datatable searchable
    var $order             = array('id_riwayatjabatan' => 'desc'); // default order

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
        $this->db->where('id_riwayatjabatan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function saveData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan = $this->db->escape_str($post['nik']);
        $no_surat = $this->db->escape_str($post['no_surat']);
        $tgl_berlaku = $this->db->escape_str($post['tanggal']);
        $tgl_selesai = $this->db->escape_str($post['masa_selesai']);
        $id_nomen = $this->db->escape_str($post['id_nomen']);
        $jabatan = $this->db->escape_str($post['jabatan']);
        $job_title = $this->db->escape_str($post['job_title']);
        $jabatan_existing = $this->db->escape_str($post['jabatan_existing']);
        $status_karyawan = $this->db->escape_str($post['status_karyawan']);
        $unit_kerja = $this->db->escape_str($post['unit_kerja']);
        $kj = $this->db->escape_str($post['kj']);
        $periode = $this->db->escape_str($post['periode']);

        if($tgl_selesai == '0000-00-00' || $tgl_selesai == '' || $tgl_selesai == NULL){
            $tgl_selesai = '1970-01-01';
        }
            
        $data = array(
            'id_karyawan'       => $id_karyawan,
            'no_surat'          => $no_surat,
            'tgl_berlaku'       => $tgl_berlaku,
            'tgl_selesai'       => $tgl_selesai,
            'id_nomenklatur'    => $id_nomen,
            'nama_jabatan'      => $jabatan,
            'job_title'         => $job_title,
            'tugas_jabatan'     => $jabatan_existing,
            'unit_kerja'        => $unit_kerja,
            'status_karyawan'   => $status_karyawan,
            'kelas_jabatan'     => $kj,
            'periode'           => $periode,
        );

        $cek = $this->cek($id_karyawan);

        if($cek){
            $this->updateStatus($cek);
            $result = $this->save_where($this->table,$data);
        }else{
            $result = $this->save_where($this->table,$data);
        }


        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan = $this->db->escape_str($post['nik']);
        $no_surat = $this->db->escape_str($post['no_surat']);
        $tgl_berlaku = $this->db->escape_str($post['tanggal']);
        $tgl_selesai = $this->db->escape_str($post['masa_selesai']);
        $id_nomen = $this->db->escape_str($post['id_nomen']);
        $jabatan = $this->db->escape_str($post['jabatan']);
        $job_title = $this->db->escape_str($post['job_title']);
        $jabatan_existing = $this->db->escape_str($post['jabatan_existing']);
        $unit_kerja = $this->db->escape_str($post['unit_kerja']);
        $status_karyawan = $this->db->escape_str($post['status_karyawan']);
        $kj = $this->db->escape_str($post['kj']);
        $periode = $this->db->escape_str($post['periode']);
        $status = $this->db->escape_str($post['status']);

        if($tgl_selesai == '0000-00-00' || $tgl_selesai == '' || $tgl_selesai == NULL){
            $tgl_selesai = '1970-01-01';
        }

        $where = array(
            'id_riwayatjabatan' => $this->db->escape_str($post['id_riwayat'])
        );

        $data = array(
            'no_surat'          => $no_surat,
            'tgl_berlaku'       => $tgl_berlaku,
            'tgl_selesai'       => $tgl_selesai,
            'id_nomenklatur'    => $id_nomen,
            'nama_jabatan'      => $jabatan,
            'job_title'         => $job_title,
            'tugas_jabatan'     => $jabatan_existing,
            'unit_kerja'        => $unit_kerja,
            'status_karyawan'   => $status_karyawan,
            'kelas_jabatan'     => $kj,
            'periode'           => $periode,
            'status'            => $status
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->set('status','non-aktif');
        $this->db->where('id_riwayatjabatan', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_riwayatjabatan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan;
    }

    public function cek($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->last_row()->id_riwayatjabatan;
        else
            return FALSE;
    }

    public function updateStatus($id){
        $this->db->set('status','non-aktif');
        $this->db->where('id_riwayatjabatan',$id);
        $this->db->update($this->table);
    }

    public function get_jabatan_cv($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        $this->db->order_by('tgl_berlaku','asc');
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->result_array();
    }

    public function cekSK($nik,$waktu){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$nik);
        $this->db->like('sk','_sk_'.$waktu.$nik);
        $this->db->order_by('sk','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->sk;
    }

    function simpan_upload($id,$gambar){
        $where = array('id_riwayatjabatan' => $id);
        $data = array(
            'sk' => $gambar,
        );
        $this->db->update($this->table,$data,$where);

        return $this->db->affected_rows();
    }
}
?>
