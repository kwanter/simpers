<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen_oc extends MY_Controller{
    public function index(){
        
    }

    public function ajax_edit($id){
        $data = $this->dokumen_oc->getData($id);
        echo json_encode($data);
    }

    public function ajax_list($id){
        $list = $this->dokumen_oc->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $r) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$r->kartu_singkat;
            $row[] = '<center style="font-size: small">'.$r->kartu_no;
            $row[] = '<center style="font-size: small">'.$r->kartu_tgl_akhir;
            
            $row[] = '<center>
            <button class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_doc('."'".$r->id_kartu_karyawan_oc."'".')">E</button>
            <button class="btn btn-danger" href="javascript:void(0)" title="Hapus" onclick="del_doc('."'".$r->id_kartu_karyawan_oc."'".')">X</button>
            ';
              
            //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dokumen_oc->countAll($id),
            "recordsFiltered" => $this->dokumen_oc->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $result = $this->dokumen_oc->deleteData($id);
        if($result)
            echo json_encode(array("status" => TRUE,"info" => "Hapus data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Hapus data gagal"));
    }

    public function ajax_add() {
        $result = $this->dokumen_oc->saveData($this->input->post());
        
        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
    }

    public function ajax_update() {
        $id = $this->input->post('id_doc');

        $result = $this->dokumen_oc->updateData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Update data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Update data gagal"));
    }

}
?>
