<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayatkontrak extends MY_Controller{
    public function index(){
    
    }

    public function ajax_edit($id){
        $data = $this->riwayatkontrak->getData($id);
        echo json_encode($data);
    }

    public function ajax_list($id){
        $list = $this->riwayatkontrak->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $jabatan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$jabatan->no_kontrak;
            $row[] = '<center style="font-size: small">'.$jabatan->nama_pjtk;
            $row[] = '<center style="font-size: small">'.$jabatan->nama_jabatan;
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$jabatan->tmt_berlaku,'');
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit_con('."'".$jabatan->id_riwayatkontrak."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del_con('."'".$jabatan->id_riwayatkontrak."'".')"><i class="material-icons">delete_forever</i></a>';
            
            //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayatkontrak->countAll($id),
            "recordsFiltered" => $this->riwayatkontrak->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->riwayatkontrak->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_add()
    {
        $result = $this->riwayatkontrak->saveData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
    }

    public function ajax_update()
    {
        $id = $this->input->post('id_riwayatkontrak');
        $result = $this->riwayatkontrak->updateData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Update data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Update data gagal"));
    }

}
?>
