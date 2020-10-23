<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendidikan_oc extends MY_Controller {

    public function index(){
        
    }

    public function ajax_edit($id){
        $data = $this->pendidikan_oc->getData($id);
        echo json_encode($data);
    }

    public function ajax_list($id){
        //$id = $this->input->post('id');
        $list = $this->pendidikan_oc->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $pendidikan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$this->pendidikan_oc->getJenjangPendidikan($pendidikan->id_jenjangpendidikan);
            $row[] = '<center style="font-size: small">'.$pendidikan->nama_jurusan;
            $row[] = '<center style="font-size: small">'.$pendidikan->tgl_kelulusan;

            //add html for action
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit_edu('."'".$pendidikan->id_riwayatpendidikan_oc."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del_edu('."'".$pendidikan->id_riwayatpendidikan_oc."'".')"><i class="material-icons">delete_forever</i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pendidikan_oc->countAll($id),
            "recordsFiltered" => $this->pendidikan_oc->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->pendidikan_oc->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_add()
    {
        $result = $this->pendidikan_oc->saveData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
    }

    public function ajax_update()
    {
        $result = $this->pendidikan_oc->updateData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Update data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Update data gagal"));
    }

    public function getLevel(){
        $id     = $this->input->post('id');
        $result = $this->pendidikan_oc->getLevel($id);

        if($result == NULL || $result == "")
            $result = '';

        echo json_encode($result,JSON_NUMERIC_CHECK);
    }

    public function getJenjangPendidikan(){
        $result = $this->pendidikan_oc->getJenjang();
        echo json_encode($result);
    }
}
?>
