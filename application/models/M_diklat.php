  <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_diklat extends MY_Model{
    var $table            = 'm_diklatkaryawan';
    var $table_jnsdiklat  = 'm_jenisdiklat';
    var $table_cv         = 'vw_diklatkaryawan';

    var $column_order     = array('id_diklatkaryawan'); //set column field database for datatable orderable
    var $column_search    = array('jenis_diklat,tema_diklat,penyelenggara,no_sertfikat'); //set column field database for datatable searchable
    var $order            = array('id_diklatkaryawan' => 'asc'); // default order

    var $column_jnsdiklat = array('id_jenisdiklat');
    var $search_jnsdiklat = array('jenis_diklat');
    var $order_jnsdiklat  = array('id_jenisdiklat' => 'asc');

    public function get_datatable($id)
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where('id_karyawan',$id);
        $query = $this->db->get();

        return $query->result();
    }

    function get_datatables_query()
    {
        $this->db->from($this->table_jnsdiklat);

        $i = 0;

        foreach ($this->search_jnsdiklat as $item) // loop column
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

                if(count($this->search_jnsdiklat) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_jnsdiklat[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_jnsdiklat))
        {
            $order = $this->order_jnsdiklat;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_table()
    {
        $this->get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
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

    function count_filteredJenisDK()
    {
        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_allJenisDK()
    {
        $this->db->from($this->table_jnsdiklat);
        return $this->db->count_all_results();
    }

    public function getData($id){
        $this->db->from($this->table);
        $this->db->where('id_diklatkaryawan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row_array();
    }

    public function getJenisData(){
        $this->db->from($this->table_jnsdiklat);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->result();
    }

    public function getNama($id){
        $this->db->from($this->table_jnsdiklat);
        $this->db->where('id_jenisdiklat',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->jenis_diklat;
    }

    public function saveData($post){
        //informasi dasar riwayat pendidikan non formal
        $id_karyawan    = $this->db->escape_str($post['nik']);
        $jenis_diklat   = $this->db->escape_str($post['jenis_diklat']);
        $tgl_diklat     = $this->db->escape_str($post['tgl_diklat']);
        $tgl_mulai      = substr($tgl_diklat,0,15);
        $tgl_akhir      = substr($tgl_diklat,-10);
        $tema_diklat    = $this->db->escape_str($post['tema_diklat']);
        $lokasi         = $this->db->escape_str($post['lokasi']);
        $penyelenggara  = $this->db->escape_str($post['penyelenggara']);
        $no_sertifikat  = $this->db->escape_str($post['no_sertifikat']);
        $nilai          = $this->db->escape_str($post['nilai']);
        $skala          = $this->db->escape_str($post['skala_nilai']);

        $data = array(
            'id_karyawan'               => $id_karyawan,
            'jenis_diklat'              => $jenis_diklat,
            'tgl_mulaidiklat'           => $tgl_mulai,
            'tgl_akhirdiklat'           => $tgl_akhir,
            'tema_diklat'               => $tema_diklat,
            'lokasi'                    => $lokasi,
            'penyelenggara'             => $penyelenggara,
            'no_sertifikat'             => $no_sertifikat,
            'nilai'                     => $nilai,
            'skala_nilai'               => $skala,
        );

        $result = $this->save_where($this->table,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar riwayat pendidikan non formal
        $jenis_diklat   = $this->db->escape_str($post['jenis_diklat']);
        $tgl_diklat     = $this->db->escape_str($post['tgl_diklat']);
        $tgl_mulai      = substr($tgl_diklat,0,15);
        $tgl_akhir      = substr($tgl_diklat,-10);
        $tema_diklat    = $this->db->escape_str($post['tema_diklat']);
        $lokasi         = $this->db->escape_str($post['lokasi']);
        $penyelenggara  = $this->db->escape_str($post['penyelenggara']);
        $no_sertifikat  = $this->db->escape_str($post['no_sertifikat']);
        $nilai          = $this->db->escape_str($post['nilai']);
        $skala          = $this->db->escape_str($post['skala_nilai']);

        $where = array(
            'id_diklatkaryawan' => $this->db->escape_str($post['id_diklat'])
        );

        $data = array(
            'jenis_diklat'              => $jenis_diklat,
            'tgl_mulaidiklat'           => $tgl_mulai,
            'tgl_akhirdiklat'           => $tgl_akhir,
            'tema_diklat'               => $tema_diklat,
            'lokasi'                    => $lokasi,
            'penyelenggara'             => $penyelenggara,
            'no_sertifikat'             => $no_sertifikat,
            'nilai'                     => $nilai,
            'skala_nilai'               => $skala,
        );
        $result= $this->update_where($this->table,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    function simpan_upload($id,$gambar){
        $where = array('id_diklatkaryawan' => $id);
        $data = array(
            'sertifikat' => $gambar,
        );
        $this->db->update($this->table,$data,$where);

        return $this->db->affected_rows();
    }

    public function deleteData($id){
        $this->db->where('id_diklatkaryawan', $id);
        $this->db->delete($this->table);
    }

    public function getIdKaryawan($id){
        $this->db->from($this->table);
        $this->db->where('id_diklatkaryawan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->id_karyawan;
    }

    public function save_Data($post){
        $jenis_diklat    = $this->db->escape_str($post['jenis_diklat']);

        $data = array(
            'jenis_diklat' => $jenis_diklat,
        );

        $result = $this->save_where($this->table_jnsdiklat,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function update_Data($post){
        $jenis_diklat    = $this->db->escape_str($post['jenis_diklat']);

        $where = array(
            'id_jenisdiklat' => $this->db->escape_str($post['id_jenisdiklat'])
        );

        $data = array(
            'jenis_diklat' => $jenis_diklat,
        );

        $result= $this->update_where($this->table_jnsdiklat,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function delete_data($id){
        $this->db->where('id_jenisdiklat', $id);
        $this->db->delete($this->table_jnsdiklat);
    }

    public function get_data($id){
        $this->db->from($this->table_jnsdiklat);
        $this->db->where('id_jenisdiklat',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function get_diklat_cv($id){
        $this->db->from($this->table_cv);
        $this->db->where('id_karyawan',$id);
        $this->db->order_by('tgl_mulaidiklat','ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0 )
            return $query->result();
    }

    public function cekSertifikat($nik,$waktu){
        $this->db->from($this->table);
        $this->db->where('id_karyawan',$nik);
        $this->db->like('sertifikat','_cert_'.$waktu.$nik);
        $this->db->order_by('sertifikat','DESC');
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->sertifikat;
    }
}
?>
