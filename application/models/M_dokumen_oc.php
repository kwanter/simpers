<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dokumen_oc extends MY_Model {
    var $table     = 'm_karyawan_oc_kartu';

    var $column_order     = array('id_kartu_karyawan_oc'); //set column field database for datatable orderable
    var $column_search    = array('kartu_deskripsi','kartu_no'); //set column field database for datatable searchable
    var $order            = array('id_kartu_karyawan_oc' => 'asc'); // default order

    public function get_datatable(){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll(){
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function saveData($post){
        $result = $this->save_where($this->table,$post);

        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        $where = array(
            'id_karyawan_kartu' => $this->db->escape_str($post['id_karyawan_kartu'])
        );

        $data = array(
            'id_karyawan_oc'        => $post['tgl_mulai_cuti'],
            'id_keluarga_oc'        => $post['tgl_selesai_cuti'],
            'kartu_deskripsi'       => $post['tgl_kembali'],
            'kartu_singkat'         => $post['tgl_dokumen_formulir'],
            'kartu_no'              => $post['jumlah_cuti'],
            'kartu_tgl_awal'        => $post['pejabat_setuju'],
            'kartu_tgl_akhir'       => $post['pejabat_wewenang'],
            'penerbit'              => $post['kota_cuti'],
            'file'                  => $post['kota_cuti'],
            'tgl_upload'            => $post['alasan_pengajuan'],
            );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function saveDataDokumen($post){
        $result = $this->save_where($this->table_dokumen, $post);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateDataDokumen($post){
        $where = array(
            'id_dokumen' => $this->db->escape_str($post['id_dokumen'])
        );

        $data = array(
            'tgl_libur' => $post['tgl_libur'],
            'deskripsi_libur' => $post['deskripsi_libur'],
        );

        $result= $this->update_where($this->table_dokumen,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_datacuti', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function deleteDataDokumen($id){
        $this->db->where('id_harilibur', $id);
        $this->db->delete($this->table_libur);

        return $this->db->affected_rows();
    }

    public function getData($id){
        $query = $this->db->select('*')
                 ->from($this->table_cuti)
                 ->where('id_datacuti',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row();
        } 

        return $result;
    }

}
?>
