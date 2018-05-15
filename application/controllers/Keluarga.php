<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluarga extends MY_Controller {
    public function index(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $data['hk'] = $this->keluarga->getHubKeluarga();
        $data['agama'] = $this->main->getPilihan('agama');
        $this->navmenu('Input Data Keluarga','vw_input_data_keluarga','','',$data);
    }

    public function edit($id){
        $data['karyawan'] = $this->pegawai->getData($this->keluarga->getIdKaryawan($id));
        $data['hk']       = $this->keluarga->getHubKeluarga();
        $data['agama']    = $this->main->getPilihan('agama');
        $data['keluarga'] = $this->keluarga->getData($id);
        $this->navmenu('Edit Data Keluarga','vw_edit_data_keluarga','','',$data);
    }

    public function ajax_list(){
        $id = $this->input->post('id');
        $list = $this->keluarga->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $keluarga) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$keluarga->nama_keluarga;
            $row[] = '<center style="font-size: small">'.$this->keluarga->getKetHubKeluarga($keluarga->id_hubungankeluarga);
            $row[] = '<center style="font-size: small">'.$keluarga->tmpt_lahir;
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d-m-Y',$keluarga->tgl_lahir,'');
            if($keluarga->jenis_kelamin == 'P')
                $keluarga->jenis_kelamin = 'PRIA';
            else
                $keluarga->jenis_kelamin = 'WANITA';

            $row[] = '<center style="font-size: small">'.$keluarga->jenis_kelamin;
            $row[] = '<center style="font-size: small">'.$keluarga->suku;
            $row[] = '<center style="font-size: small">'.$this->main->getAgama($keluarga->agama);
            $row[] = '<center><a style="font-size: small" class="btn btn-outline-info" href="javascript:void(0)" title="Alamat Lengkap" onclick="alamat('."'".$keluarga->id_keluarga."'".')">'.$keluarga->alamat.'</a>';
            $row[] = '<center style="font-size: small">'.$keluarga->no_hp;
            $row[] = '<center style="font-size: small">'.$keluarga->pekerjaan;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$keluarga->id_keluarga."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$keluarga->id_keluarga."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->keluarga->countAll($id),
            "recordsFiltered" => $this->keluarga->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->keluarga->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData()
    {
        $result = $this->keluarga->saveData($_POST);

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
        $id = $this->input->post('id_keluarga');
        $result = $this->keluarga->updateData($_POST);

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

    public function getAlamatLengkap($id) {
        $where = array(
            'id_keluarga' => $id,
        );
        $table = 'm_keluarga';
        $data = $this->keluarga->get_by_id($where,$table);
        echo json_encode($data);
    }
}
?>
