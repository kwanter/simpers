<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendidikan extends MY_Controller {

    public function index(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $data['jenjang'] = $this->pendidikan->getJenjang();
        $this->navmenu('Input Riwayat Pendidikan Karyawan','vw_input_data_pendidikan','','',$data);
    }

    public function edit($id){
        $data['karyawan'] = $this->pegawai->getData($this->pendidikan->getIdKaryawan($id));
        $data['pendidikan'] = $this->pendidikan->getData($id);
        $data['jenjang'] = $this->pendidikan->getJenjang();
        $this->navmenu('Edit Riwayat Pendidikan Karyawan','vw_edit_data_pendidikan','','',$data);
    }

    public function ajax_list(){
        $id = $this->input->post('id');
        $list = $this->pendidikan->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $pendidikan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$this->pegawai->getNama($pendidikan->id_karyawan);
            $row[] = '<center style="font-size: small">'.$this->pendidikan->getJenjangPendidikan($pendidikan->id_jenjangpendidikan);
            $row[] = '<center style="font-size: small">'.$pendidikan->nama_jurusan;
            $row[] = '<center style="font-size: small">'.$pendidikan->peminatan;
            $row[] = '<center style="font-size: small">'.$pendidikan->asal_lembaga_pendidikan;
            $row[] = '<center style="font-size: small">'.$pendidikan->asal_kota_lp;
            $row[] = '<center style="font-size: small">'.$pendidikan->tgl_kelulusan;
            $row[] = '<center style="font-size: small">'.$pendidikan->nilai_kelulusan;
            $row[] = '<center style="font-size: small">'.$pendidikan->skala_nilai;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$pendidikan->id_riwayatpendidikan."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$pendidikan->id_riwayatpendidikan."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pendidikan->countAll($id),
            "recordsFiltered" => $this->pendidikan->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->pendidikan->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData()
    {
        $result = $this->pendidikan->saveData($_POST);

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
        $id = $this->input->post('id_riwayat');
        $result = $this->pendidikan->updateData($_POST);

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

    public function getLevel(){
        $id     = $this->input->post('id');
        $result = $this->pendidikan->getLevel($id);

        if($result == NULL || $result == "")
            $result = '';

        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
}
?>
