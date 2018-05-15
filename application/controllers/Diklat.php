<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diklat extends MY_Controller{
    public function index(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $data['jenis_diklat'] = $this->diklat->getJenisData();
        $this->navmenu('Input Riwayat Diklat Karyawan','vw_input_data_diklat','','',$data);
    }

    public function edit($id){
        $data['karyawan'] = $this->pegawai->getData($this->diklat->getIdKaryawan($id));
        $data['jenis_diklat'] = $this->diklat->getJenisData();
        $data['diklat'] = $this->diklat->getData($id);
        $this->navmenu('Edit Riwayat Diklat Karyawan','vw_edit_data_diklat','','',$data);
    }

    public function ajax_list(){
        $id = $this->input->post('id');
        $list = $this->diklat->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $diklat) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$this->pegawai->getNama($diklat->id_karyawan);
            $row[] = '<center style="font-size: small">'.$this->diklat->getNama($diklat->jenis_diklat);
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$diklat->tgl_mulaidiklat);
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$diklat->tgl_akhirdiklat);
            $d1 = new DateTime($diklat->tgl_mulaidiklat);
            $d2 = new DateTime($diklat->tgl_akhirdiklat);
            $interval = $d2->diff($d1);
            $row[] = '<center style="font-size: small">'.$interval->format('%a').' Hari';
            $row[] = '<center style="font-size: small">'.$diklat->tema_diklat;
            $row[] = '<center style="font-size: small">'.$diklat->penyelenggara;
            $row[] = '<center style="font-size: small">'.$diklat->no_sertifikat;
            $row[] = '<center style="font-size: small">'.$diklat->nilai;
            $row[] = '<center style="font-size: small">'.$diklat->skala_nilai;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$diklat->id_diklatkaryawan."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$diklat->id_diklatkaryawan."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->diklat->countAll($id),
            "recordsFiltered" => $this->diklat->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function list_jenisdk(){
        $list = $this->diklat->get_table();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $diklat) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$diklat->jenis_diklat;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$diklat->id_jenisdiklat."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$diklat->id_jenisdiklat."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->diklat->count_AllJenisDK(),
            "recordsFiltered" => $this->diklat->count_FilteredJenisDK(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->diklat->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData()
    {
        $result = $this->diklat->saveData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> 
                                                                    Data Berhasil Ditambahkan , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
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
        $id = $this->input->post('id_diklat');
        $result = $this->diklat->updateData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> 
                                                                    Data Berhasil Di Update, <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Di Update..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->edit($id);
    }

    public function add_data(){
        $result = $this->diklat->save_data($_POST);

        if($result){
            $response = array(
                'error' => false,
            );
        }else{
            $response = array(
                'error' => true,
            );
        }

        echo json_encode($response);
    }

    public function update_data(){
        $result = $this->diklat->update_data($_POST);

        if($result){
            $response = array(
                'error' => false,
            );
        }else{
            $response = array(
                'error' => true,
            );
        }

        echo json_encode($response);
    }

    public function delete_data($id){
        $this->diklat->delete_data($id);
        echo json_encode(array("status" => TRUE));
    }

    public function get_data($id){
        $result = $this->diklat->get_data($id);
        echo json_encode($result);
    }
}
?>
