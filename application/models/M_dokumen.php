<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dokumen extends MY_Model {
    var $table             = 'm_karyawan_kartu';
    var $view_utama        = 'vw_kartu_karyawan';
    var $table_jenis       = 'm_jeniskartu';
    var $view              = 'vw_formasi_dokumen';
    var $column_order      = array('id_kartu_karyawan'); //set column field database for datatable orderable
    var $column_search     = array('kartu_deskripsi,kartu_singkat,kartu_no'); //set column field database for datatable searchable
    var $order             = array('id_kartu_karyawan' => 'desc'); // default order
    var $column_order_view      = array(null); //set column field database for datatable orderable
    var $column_search_view     = array('nama_karyawan'); //set column field database for datatable searchable
    var $order_view             = array('nama_karyawan' => 'asc'); // default order

    function get_datatables_query() {
        $this->db->from($this->view);

        $i = 0;

        foreach ($this->column_search_view as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search_view) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_view[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_view))
        {
            $order = $this->order_view;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable_formasi(){
        $this->get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredFormasi() {
        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllFormasi() {
        $this->db->from($this->view);
        return $this->db->count_all_results();
    }

    function datatables_query() {
        $this->db->from($this->view_utama);

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable($id){
        $this->datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered($id) {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll($id){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        return $this->db->count_all_results();
    }

    public function getJenisKartu(){
        $this->db->from($this->table_jenis);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();   
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_kartu_karyawan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function getDesc($id){
        $this->db->from('m_jeniskartu');
        $this->db->where('jenis_kartu',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->deskripsi_kartu;
    }

    public function saveData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan = $this->db->escape_str($post['nik']);
        $keluarga   = $this->db->escape_str($post['keluarga']);
        $no_dokumen = $this->db->escape_str($post['no_dok']);
        $masa_berlaku = $this->db->escape_str($post['tanggal']);
        $jenis_dok = $this->db->escape_str($post['jenis_dok']);

        if($masa_berlaku == '' || $masa_berlaku == '0000-00-00' || $masa_berlaku == NULL){
            $masa_berlaku = '1970-01-01';
        }

        $data = array(
            'id_karyawan'      => $id_karyawan,
            'id_keluarga'      => $keluarga,
            'kartu_singkat'    => $jenis_dok,
            'kartu_no'         => $no_dokumen,
            'kartu_tgl_akhir'  => $masa_berlaku,
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return $result;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat jabatan
        $id_karyawan = $this->db->escape_str($post['nik']);
        $no_dokumen = $this->db->escape_str($post['no_dok']);
        $keluarga   = $this->db->escape_str($post['keluarga']);
        $masa_berlaku = $this->db->escape_str($post['tanggal']);
        $jenis_dok = $this->db->escape_str($post['jenis_dok']);

        if($masa_berlaku == '' || $masa_berlaku == '0000-00-00' || $masa_berlaku == NULL){
            $masa_berlaku = '1970-01-01';
        }

        $where = array(
            'id_kartu_karyawan' => $this->db->escape_str($post['id_kartu_karyawan'])
        );

        $data = array(
            'kartu_singkat'    => $jenis_dok,
            'id_keluarga'      => $keluarga,
            'kartu_no'         => $no_dokumen,
            'kartu_tgl_akhir'  => $masa_berlaku,
        );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_kartu_karyawan', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_kartu_karyawan',$id);
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

    public function cekDok($nik,$waktu){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$nik);
        $this->db->like('file','_dok_'.$waktu.$nik);
        $this->db->order_by('tgl_upload','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->file;
    }

    function simpan_upload($id,$gambar){
        $where = array('id_kartu_karyawan' => $id);
        $data = array(
            'file' => $gambar,
        );
        $this->db->update($this->table,$data,$where);

        return $this->db->affected_rows();
    }

    function tgl_upload($id,$tgl){
        $where = array('id_kartu_karyawan' => $id);
        $data = array(
            'tgl_upload' => $tgl,
        );
        $this->db->update($this->table,$data,$where);

        return $this->db->affected_rows();
    }

    function getKeluarga($postData){
        $response = array();
        // Select record
        $this->db->select('id_keluarga,nama_keluarga');
        $this->db->where('id_karyawan', $postData['id_karyawan']);
        $q = $this->db->get('m_keluarga');
        $response = $q->result_array();

        return $response;
    }
}
?>
