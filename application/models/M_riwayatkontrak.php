<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_riwayatkontrak extends MY_Model {
    var $table             = 'm_riwayatkontrak';

    var $column_order      = array('id_riwayatkontrak'); //set column field database for datatable orderable
    var $column_search     = array('no_kontrak,tmt_berakhir,tmt_berlaku,nama_jabatan'); //set column field database for datatable searchable
    var $order             = array('id_riwayatkontrak' => 'desc'); // default order

    public function get_datatable($id)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
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
        $this->db->where('id_riwayatkontrak',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function saveData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan_oc = $this->db->escape_str($post['id_karyawan_kontrak']);
        $no_kontrak = $this->db->escape_str($post['no_kontrak']);
        $nama_pjtk = $this->db->escape_str($post['nama_pjtk']);
        $nama_jabatan = $this->db->escape_str($post['nama_jabatan']);
        $tmt_kontrak = $this->db->escape_str($post['tmt_kontrak']);

        if($tmt_kontrak == '0000-00-00' || $tmt_kontrak == '' || $tmt_kontrak == NULL){
            $tmt_kontrak = '1970-01-01';
        }
            
        $data = array(
            'id_karyawan_oc'  => $id_karyawan_oc,
            'no_kontrak'      => $no_kontrak,
            'nama_pjtk'       => $nama_pjtk,
            'nama_jabatan'    => $nama_jabatan,
            'tmt_berlaku'     => $tmt_kontrak,
        );
    
        $result = $this->save_where($this->table,$data);
        
        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan_oc = $this->db->escape_str($post['id_karyawan_kontrak']);
        $no_kontrak = $this->db->escape_str($post['no_kontrak']);
        $nama_pjtk = $this->db->escape_str($post['nama_pjtk']);
        $nama_jabatan = $this->db->escape_str($post['nama_jabatan']);
        $tmt_kontrak = $this->db->escape_str($post['tmt_kontrak']);

        if($tmt_kontrak == '0000-00-00' || $tmt_kontrak == '' || $tmt_kontrak == NULL){
            $tmt_kontrak = '1970-01-01';
        }

        $where = array(
            'id_riwayatkontrak' => $this->db->escape_str($post['id_riwayatkontrak'])
        );

        $data = array(
            'id_karyawan_oc'  => $id_karyawan_oc,
            'no_kontrak'      => $no_kontrak,
            'nama_pjtk'       => $nama_pjtk,
            'nama_jabatan'    => $nama_jabatan,
            'tmt_berlaku'     => $tmt_kontrak,
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_riwayatkontrak', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_riwayatkontrak',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan_oc;
    }

    public function cek($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $result = $this->db->get();

        if($result->num_rows() > 0)
            return $result->last_row()->id_riwayatkontrak;
        else
            return FALSE;
    }

    public function cekKontrak($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->order_by('tmt_berlaku','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }
}
?>
