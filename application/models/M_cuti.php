<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cuti extends MY_Model {
    var $table             = 'm_datacuti';
    var $table_libur       = 'm_harilibur';
    var $table_jenis       = 'm_jeniscuti';
    var $table_cuti        = 'vw_data_cuti_karyawan';

    var $column_order      = array('id_datacuti'); //set column field database for datatable orderable
    var $column_search     = array(null); //set column field database for datatable searchable
    var $order             = array('id_datacuti' => 'desc'); // default order

    var $column_order_libur      = array('id_harilibur'); //set column field database for datatable orderable
    var $column_search_libur     = array('tgl_libur','deskripsi_libur'); //set column field database for datatable searchable
    var $order_libur             = array('tgl_libur' => 'asc'); // default order

    var $column_order_cuti      = array('id_datacuti','nama_karyawan','nama_karyawan_pengganti','jenis_cuti','tgl_mulai_cuti','tgl_selesai_cuti'); //set column field database for datatable orderable
    var $column_search_cuti     = array('nama_karyawan','nama_karyawan_pengganti','jenis_cuti','tgl_mulai_cuti','tgl_selesai_cuti'); //set column field database for datatable searchable
    var $order_cuti             = array('nama_karyawan' => 'asc'); // default order

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

    function _get_datatables_query_cuti() {
        $this->db->from($this->table_cuti);
        $i = 0;

        foreach ($this->column_search_cuti as $item) // loop column
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

                if(count($this->column_search_cuti) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_cuti[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_cuti))
        {
            $order = $this->order_cuti;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable_cuti(){
        $this->_get_datatables_query_cuti();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('disetujui',NULL);
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredCuti() {
        $this->_get_datatables_query_cuti();
        $this->db->where('disetujui',NULL);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllCuti(){
        $this->db->from($this->table_cuti);
        $this->db->where('disetujui',NULL);
        return $this->db->count_all_results();
    }

    public function get_datatable_riwayat_cuti($id)
    {
        $this->_get_datatables_query_cuti();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredRiwayatCuti($id)
    {
        $this->_get_datatables_query();
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllRiwayatCuti($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$id);
        return $this->db->count_all_results();
    }

    function _get_datatables_query_libur(){
        $this->db->from($this->table_libur);

        $i = 0;

        foreach ($this->column_search_libur as $item) // loop column
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

                if(count($this->column_search_libur) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_libur[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_libur))
        {
            $order = $this->order_libur;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable_libur(){
        $this->_get_datatables_query_libur();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function countFilteredLibur() {
        $this->_get_datatables_query_libur();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllLibur(){
        $this->db->from($this->table_libur);
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
            'id_datacuti' => $this->db->escape_str($post['id_datacuti'])
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
            'kota_cuti'             => $post['kota_cuti']
            );

        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function saveDataLibur($post){
        $result = $this->db->insert_batch($this->table_libur,$post);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function saveDataLiburSingle($post){
        $result = $this->save_where($this->table_libur, $post);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateDataLibur($post){
        $where = array(
            'id_harilibur' => $this->db->escape_str($post['id_harilibur'])
        );

        $data = array(
            'tgl_libur' => $post['tgl_libur'],
            'deskripsi_libur' => $post['deskripsi_libur'],
        );

        $result= $this->update_where($this->table_libur,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function updatePersetujuanCuti($data){
        $where = array(
            'id_datacuti' => $data['id_cuti']
        );

        if($data['disetujui'] == "1"){
            $data = array(
                'disetujui'         => $data['disetujui'],
                'no_surat_cuti'     => $data['no_surat_cuti'],
                'tgl_dokumen_surat' => $data['tgl_dokumen_surat'],
                'pejabat_ttd'       => $data['pejabat_ttd']
            );
        }else{
            $data = array(
                'disetujui'         => $data['disetujui'],
                'tgl_dokumen_surat' => $data['tgl_dokumen_surat'],
                'pejabat_ttd'       => $data['pejabat_ttd']
            );
        }

        $result= $this->update_where($this->table,$where,$data);
        
        return $result;
    }

    public function deleteData($id){
        $this->db->set('soft_delete','deleted');
        $this->db->where('id_datacuti', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function deleteDataLibur($id){
        $this->db->where('id_harilibur', $id);
        $this->db->delete($this->table_libur);

        return $this->db->affected_rows();
    }

    public function getJenisCuti(){
        $this->db->from($this->table_jenis);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function cekHariLibur($tgl){
        $query = $this->db->select('tgl_libur')
                 ->from($this->table_libur)
                 ->where('tgl_libur',$tgl)
                 ->get();
        
        if($query->num_rows() === 1){
            return TRUE;
        } else{
            return FALSE;
        }
    }

    public function getIDPegawai($id){
         $query = $this->db->select('id_karyawan')
                 ->from($this->table)
                 ->where('id_datacuti',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row()->id_karyawan;
        } 

        return $result;
    }

    public function getDataCuti($id){
        $query = $this->db->select('*')
                 ->from($this->table)
                 ->where('id_datacuti',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row();
        } 

        return $result;
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

    public function getDataLibur($id){
        $query = $this->db->select('*')
                 ->from($this->table_libur)
                 ->where('id_harilibur',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row();
        } 

        return $result;
    }

    public function getIDPejabatTTD($id){
        $query = $this->db->select('pejabat_ttd')
                 ->from($this->table)
                 ->where('id_datacuti',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row();
        } 

        return $result;
    }

    public function getJmlhCutiLama($id){
        $query = $this->db->select('jumlah_cuti')
                 ->from($this->table)
                 ->where('id_datacuti',$id)
                 ->get();
        
        if($query->num_rows() === 1){
            $result = $query->row()->jumlah_cuti;
        } 

        return $result;
    }
}
?>
