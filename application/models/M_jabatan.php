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
        $tanggal = $this->db->escape_str($post['tanggal']);
        $id_nomen = $this->db->escape_str($post['id_nomen']);
        $jabatan = $this->db->escape_str($post['jabatan']);
        $job_title = $this->db->escape_str($post['job_title']);
        $status_karyawan = $this->db->escape_str($post['status_karyawan']);
        $kj = $this->db->escape_str($post['kj']);
        $periode = $this->db->escape_str($post['periode']);

        $data = array(
            'id_karyawan'       => $id_karyawan,
            'no_surat'          => $no_surat,
            'tgl_berlaku'       => $tanggal,
            'id_nomenklatur'    => $id_nomen,
            'nama_jabatan'      => $jabatan,
            'job_title'         => $job_title,
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
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan = $this->db->escape_str($post['nik']);
        $no_surat = $this->db->escape_str($post['no_surat']);
        $tanggal = $this->db->escape_str($post['tanggal']);
        $id_nomen = $this->db->escape_str($post['id_nomen']);
        $jabatan = $this->db->escape_str($post['jabatan']);
        $job_title = $this->db->escape_str($post['job_title']);
        $status_karyawan = $this->db->escape_str($post['status_karyawan']);
        $kj = $this->db->escape_str($post['kj']);
        $periode = $this->db->escape_str($post['periode']);
        $status = $this->db->escape_str($post['status']);

        $where = array(
            'id_riwayatjabatan' => $this->db->escape_str($post['id_riwayat'])
        );

        $data = array(
            'no_surat'          => $no_surat,
            'tgl_berlaku'       => $tanggal,
            'id_nomenklatur'    => $id_nomen,
            'nama_jabatan'      => $jabatan,
            'job_title'         => $job_title,
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
        $this->db->where('id_riwayatjabatan', $id);
        $this->db->delete($this->table);
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
}
?>
