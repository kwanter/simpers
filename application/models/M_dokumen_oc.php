<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dokumen_oc extends MY_Model {
    var $table     = 'm_karyawan_kartu_oc';

    var $column_order     = array('id_kartu_karyawan_oc'); //set column field database for datatable orderable
    var $column_search    = array('kartu_deskripsi','kartu_no'); //set column field database for datatable searchable
    var $order            = array('id_kartu_karyawan_oc' => 'asc'); // default order

    public function get_datatable($id = ''){
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered($id = '') {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll($id = ''){
        $this->db->from($this->table);
        $this->db->where('id_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        return $this->db->count_all_results();
    }

    public function saveData($post){
        //informasi dasar data pegawai
        $id_karyawan   = $this->db->escape_str($post['id_karyawan_oc']);
        $jenis_doc     = $this->db->escape_str($post['jenis_doc']);
        $no_dokumen    = $this->db->escape_str($post['no_dokumen']);
        $masa_berakhir = $this->db->escape_str($post['masa_berakhir_dokumen']);
        
        $data = array(
            'id_karyawan_oc'   => $id_karyawan,
            'kartu_singkat'    => $jenis_doc,
            'kartu_no'         => $no_dokumen,
            'kartu_tgl_akhir'  => $masa_berakhir,
        );
        
        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        $where = array(
            'id_kartu_karyawan_oc' => $this->db->escape_str($post['id_doc'])
        );

        $data = array(
            'id_karyawan_oc'         => $this->input->post('id_karyawan_oc'),
            'kartu_singkat'          => $this->input->post('jenis_doc'),
            'kartu_no'               => $this->input->post('no_dokumen'),
            'kartu_tgl_akhir'        => $this->input->post('masa_berakhir_dokumen'),
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_kartu_karyawan_oc', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function getJenisDokumen(){
        $query = $this->db->select('*')
                 ->from('m_jeniskartu')
                 ->get();
        
        if($query->num_rows() > 0){
            $result = $query->result();
        } 

        return $result;
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_kartu_karyawan_oc',$id);
        $this->db->where('soft_delete','not-deleted');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

}
?>
