<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_nomenklatur extends MY_Model {
    var $table          = 'vw_jabatan';
    var $table_jabatan  = 'm_nomenklatur';
    var $table_uker     = 'm_uker';
    var $column_order   = array('id_nomenklatur'); //set column field database for datatable orderable
    var $column_search  = array('jabatan','job_title'); //set column field database for datatable searchable
    var $order          = array(null); // default order
    var $data           = array();
    var $where          = array('I','II','IV');


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $this->db->where_not_in('level',$this->where);
        $query = $this->db->get();

        return $query->result();
    }

    function countFiltered()
    {
        $this->_get_datatables_query();
        $this->db->where_not_in('level',$this->where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll()
    {
        $this->db->from($this->table);
        $this->db->where_not_in('level',$this->where);
        return $this->db->count_all_results();
    }

    public function saveData($post){
        //informasi dasar data nomenklatur
        $kode_jabatan = str_replace("_","",$this->db->escape_str($post['kode_jabatan']));
        $jabatan = str_replace("_","",$this->db->escape_str($post['nama_jabatan']));
        $parent = $this->db->escape_str($post['parent']);
        $job_title = $this->db->escape_str($post['job_title']);
        $jumlah = $this->db->escape_str($post['jumlah']);
        $grup = $this->db->escape_str($post['grup']);
        $id_subdivisi = $this->db->escape_str($post['uker']);

        $data = array(
                'id_parent'     => $parent,
                'kode_jabatan'  => $kode_jabatan,
                'jabatan'       => $jabatan,
                'job_title'     => $job_title,
                'jumlah'        => $jumlah,
                'id_uker'       => $id_subdivisi,
                'grup'          => $grup,
        );

        $result = $this->save_where($this->table_jabatan,$data);

        if($result['status'])
            return TRUE;
        else
            return FALSE;
    }

    public function updateData($post){
        //informasi dasar data nomenklatur
        $kode_jabatan = str_replace("_","",$this->db->escape_str($post['kode_jabatan']));
        $jabatan = str_replace("_","",$this->db->escape_str($post['nama_jabatan']));
        $parent = $this->db->escape_str($post['parent']);
        $job_title = $this->db->escape_str($post['job_title']);
        $jumlah = $this->db->escape_str($post['jumlah']);
        $grup = $this->db->escape_str($post['grup']);
        $id_subdivisi = $this->db->escape_str($post['uker']);

        $data = array(
            'id_parent'     => $parent,
            'kode_jabatan'  => $kode_jabatan,
            'jabatan'       => $jabatan,
            'job_title'     => $job_title,
            'jumlah'        => $jumlah,
            'id_uker'       => $id_subdivisi,
            'grup'          => $grup,
        );

        $where = array(
            'id_nomenklatur' => $this->db->escape_str($post['id_nomenklatur']),
        );

        $result= $this->update_where($this->table_jabatan,$where,$data);

        if($result)
            return TRUE;
        else
            return FALSE;
    }

    public function getData($id){
        $this->db->from($this->table_jabatan);
        $this->db->where('id_nomenklatur',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
    }

    public function searchData($data){
        $this->db->from($this->table_jabatan);
        $this->db->like('jabatan',$data,'both');
        $this->db->order_by('jabatan','ASC');
        $this->db->limit(10);

        return $this->db->get()->result();
    }

    public function deleteData($id){
        $this->db->where('id_nomenklatur', $id);
        $this->db->delete($this->table_jabatan);
    }

    public function getParent($id){
        $this->data[] = $id;
        $this->db->where('id_parent', $id);
        $result = $this->db->get($this->table_uker);
        foreach ($result->result() as $row)
        {
            $this->data[] = $row->id_uker;
            $this->getParent($row->id_uker);
        }
        return $this->data;
    }

    public function getIDParent($id){
        $this->db->where('id_uker',$id);
        $query = $this->db->get($this->table_jabatan);

        if($query->num_rows() > 0)
            return $query->row()->id_parent;
    }

    function getParentID($id){
        $this->db->where('id_nomenklatur',$id);
        $query = $this->db->get($this->table_jabatan);

        if($query->num_rows() > 0)
            return $query->row()->id_parent;
    }

    public function getAtasan($id,$search){
        //$id_parent = $this->getIDParent($id);
        $id_result = $this->getParent($id);

        $this->db->from($this->table_jabatan);
        $this->db->or_where_in('id_uker',$id_result);
        $this->db->like('jabatan',$search,'both');
        $this->db->order_by('jabatan','ASC');

        return $this->db->get()->result();
    }

    public function getAtasanName($id){
        $data = $this->getParentID($id);
        $this->db->from($this->table_jabatan);
        $this->db->where('id_nomenklatur',$data);
        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row()->jabatan;
      }
}
?>
