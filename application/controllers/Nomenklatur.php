<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nomenklatur extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['uker'] = $this->divisi->get_uker();
        $this->navmenu('Input Data Nomenklatur','vw_input_data_nomenklatur','','',$data);
    }

    public function edit($id){
        $data['uker'] = $this->divisi->get_uker();
        $data['nomenklatur'] = $this->nomenklatur->getData($id);
        $data['nama'] = $this->nomenklatur->getAtasanName($id);
        $this->navmenu('Edit Data Nomenklatur','vw_edit_data_nomenklatur','','',$data);
    }

    public function delete($id){
        $this->nomenklatur->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list(){
        $list = $this->nomenklatur->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $jabatan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$jabatan->jabatan;
            $row[] = '<center style="font-size: small">'.$jabatan->job_title;
            $row[] = '<center style="font-size: small">'.$jabatan->unit_kerja;
            $row[] = '<center style="font-size: small">'.$jabatan->grup;
            $row[] = '<center style="font-size: small">'.$jabatan->jumlah_tersedia;
            $row[] = '<center style="font-size: small">'.$jabatan->jumlah_nomenklatur_terisi;
            $row[] = '<center style="font-size: small">'.$jabatan->selisih;
            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$jabatan->id_nomenklatur."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$jabatan->id_nomenklatur."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->nomenklatur->countAll(),
            "recordsFiltered" => $this->nomenklatur->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $result = $this->nomenklatur->saveData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Ditambahkan , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Ditambahkan..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->index();
    }

    public function updateData()
    {
        $id = $this->input->post('id_nomenklatur');
        $result = $this->nomenklatur->updateData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Di Update , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Di Update..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->edit($id);
    }

    public function getAtasan($id){
        $search = $this->input->post('search');
        $data = $this->nomenklatur->getAtasan($id,$search);
        if(isset($search)){
            if(count($data) > 0){
                foreach ($data as $row) {
                    $arr_result[] = array(
                        'label'     => $row->jabatan,
                        'parent'    => $row->id_nomenklatur,
                    );
                }
                echo json_encode($arr_result);
            }
        }
    }
}

?>
