<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tunjangan extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['kj'] = $this->kelasjabatan->getKJ();
        $this->navmenu('Input Data Tunjangan','vw_input_data_tunjangan','','',$data);
    }

    public function edit(){
        $data['data'] = $this->tunjangan->getTunjanganData();
        $this->navmenu('Edit Data Tunjangan','vw_edit_data_tunjangan','','',$data);
    }

    public function delete($id){
        $where = array(
            'id_karyawan' => $id,
        );
        $this->tunjangan->deleteData($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list(){
        $list = $this->tunjangan->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $tunjangan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$tunjangan->tunjangan;
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_1);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_2);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_3);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_4);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_5);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_6);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_7);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_8);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_9);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_10);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_11);
            $row[] = '<center>'.$this->rupiah($tunjangan->kelas_jabatan_12);
           
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tunjangan->countAll(),
            "recordsFiltered" => $this->tunjangan->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $result = $this->tunjangan->saveData($_POST);

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
        $id = $this->input->post('id_tunjangan');
        $result = $this->tunjangan->updateData($_POST);

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
        $id = $this->input->post('id_tunjangan');
        $result = $this->tunjangan->getTunjanganDetail($id);
        $kj = $this->kelasjabatan->getKelasJabatan($result->id_kelasjabatan);

        $data = array(
            'nama_tunjangan' => $result->nama_tunjangan,
            'kelas_jabatan'  => $kj,
            'besaran_tunjangan' => $result->besaran_tunjangan
        );

        echo json_encode($data);
    }
}
?>
