<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelasjabatan extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->navmenu('Input Data Merit','vw_input_data_kj','','','');
    }

    public function edit(){
        $data['data'] = $this->kelasjabatan->getKJData();
        $this->navmenu('Edit Data Merit','vw_edit_data_kj','','',$data);
    }

    public function delete($id){
        $where = array(
            'id_kelasjabatan' => $id,
        );
        $this->kelasjabatan->deleteData($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list(){
        $list = $this->kelasjabatan->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $kj) {
            $no++;
            $row = array();
            $row[] = '<center>'.$kj->id;
            $row[] = '<center>'.$this->rupiah($kj->periodik_0);
            $row[] = '<center>'.$this->rupiah($kj->periodik_1);
            $row[] = '<center>'.$this->rupiah($kj->periodik_2);
            $row[] = '<center>'.$this->rupiah($kj->periodik_3);
            $row[] = '<center>'.$this->rupiah($kj->periodik_4);
            $row[] = '<center>'.$this->rupiah($kj->periodik_5);
            $row[] = '<center>'.$this->rupiah($kj->periodik_6);
            $row[] = '<center>'.$this->rupiah($kj->periodik_7);
            $row[] = '<center>'.$this->rupiah($kj->periodik_8);
            $row[] = '<center>'.$this->rupiah($kj->periodik_9);
            $row[] = '<center>'.$this->rupiah($kj->periodik_10);
            $row[] = '<center>'.$this->rupiah($kj->periodik_11);
            $row[] = '<center>'.$this->rupiah($kj->periodik_12);
            $row[] = '<center>'.$this->rupiah($kj->periodik_13);
            $row[] = '<center>'.$this->rupiah($kj->periodik_14);
            $row[] = '<center>'.$this->rupiah($kj->periodik_15);

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kelasjabatan->countAll(),
            "recordsFiltered" => $this->kelasjabatan->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $result = $this->kelasjabatan->saveData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
        $result = $this->kelasjabatan->updateData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Di Update <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Di Update..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->edit();
    }

    public function getData(){
        $id = $this->input->post('id_kj');
        $result = $this->kelasjabatan->getKJDetail($id);

        $data = array(
            'nama_kj' => $result->nama_kelasjabatan,
            'periode'  => $result->periodik,
            'besaran_merit' => $result->merit
        );

        echo json_encode($data);
    }
}
?>
