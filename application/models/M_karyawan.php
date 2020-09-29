<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_karyawan extends MY_Model {
    var $table             = 'm_karyawan_oc';
    var $table_dokumen     = 'm_karyawan_oc_kartu';

    var $column_order      = array('id_karyawan'); //set column field database for datatable orderable
    var $column_search     = array(null); //set column field database for datatable searchable
    var $order             = array('id_karyawan' => 'desc'); // default order

    var $column_order_dokumen      = array('id_harilibur'); //set column field database for datatable orderable
    var $column_search_dokumen     = array('tgl_libur','deskripsi_libur'); //set column field database for datatable searchable
    var $order_dokumen             = array('tgl_libur' => 'asc'); // default order

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

    function _get_datatables_query_dokumen() {
        $this->db->from($this->table_dokumen);
        $i = 0;

        foreach ($this->column_search_dokumen as $item) // loop column
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

                if(count($this->column_search_dokumen) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_dokumen[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_dokumen))
        {
            $order = $this->order_dokumen;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable_dokumen(){
        $this->_get_datatables_query_dokumen();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredDokumen() {
        $this->_get_datatables_query_dokumen();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllCuti(){
        $this->db->from($this->table_cuti);
        $this->db->where('disetujui',NULL);
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
            'id_karyawan' => $this->db->escape_str($post['id_karyawan'])
        );

        $data = array(
            'id_karyawan_pengganti' => $post['id_karyawan_pengganti'],
            'tgl_mulai_cuti'        => $post['tgl_mulai_cuti'],
            'tgl_selesai_cuti'      => $post['tgl_selesai_cuti'],
            'tgl_kembali'           => $post['tgl_kembali'],
            'tgl_dokumen_formulir'  => $post['tgl_dokumen_formulir'],
            'jumlah_cuti'           => $post['jumlah_cuti'],
            'pejabat_setuju'        => $post['pejabat_setuju'],
            'pejabat_wewenang'      => $post['pejabat_wewenang'],
            'kota_cuti'             => $post['kota_cuti'],
            'alasan_pengajuan'      => $post['alasan_pengajuan'],
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
