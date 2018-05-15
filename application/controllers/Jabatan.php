<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends MY_Controller{
    public function index(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $data['kj'] = $this->kelasjabatan->getNamaKJ();
        $data['periode'] = $this->kelasjabatan->getPeriode();
        $this->navmenu('Input Riwayat Jabatan Karyawan','vw_input_data_jabatan','','',$data);
    }

    public function edit($id){
        $data['karyawan'] = $this->pegawai->getData($this->jabatan->getIdKaryawan($id));
        $data['kj'] = $this->kelasjabatan->getNamaKJ();
        $data['periode'] = $this->kelasjabatan->getPeriode();
        $data['jabatan'] = $this->jabatan->getData($id);
        $this->navmenu('Edit Riwayat Jabatan Karyawan','vw_edit_data_jabatan','','',$data);
    }

    public function ajax_list(){
        $id = $this->input->post('id');
        $list = $this->jabatan->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $jabatan) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small" >'.$this->pegawai->getNama($jabatan->id_karyawan);
            $row[] = '<center style="font-size: small">'.$jabatan->no_surat;
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$jabatan->tgl_berlaku,'');
            $row[] = '<center style="font-size: small">'.$jabatan->nama_jabatan;
            $row[] = '<center style="font-size: small">'.$jabatan->job_title;

            if($jabatan->status_karyawan == 'CK')
                $jabatan->status_karyawan = 'Calon Karyawan';
            elseif($jabatan->status_karyawan == 'K')
                $jabatan->status_karyawan = 'Karyawan';
            else
                $jabatan->status_karyawan = 'Perbantuan';

            $row[] = '<center style="font-size: small">'.$jabatan->status_karyawan;
            $row[] = '<center style="font-size: small">'.$jabatan->kelas_jabatan;
            $row[] = '<center style="font-size: small">'.$jabatan->periode;

            if($jabatan->status == 'aktif')
                $jabatan->status = 'Berlaku';
            else
                $jabatan->status = 'Tidak Berlaku';

            $row[] = '<center style="font-size: small">'.$jabatan->status;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$jabatan->id_riwayatjabatan."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$jabatan->id_riwayatjabatan."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan->countAll($id),
            "recordsFiltered" => $this->jabatan->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->jabatan->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData()
    {
        $result = $this->jabatan->saveData($_POST);

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
        $result = $this->jabatan->updateData($_POST);

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

    public function getJabatan(){
        if(isset($_POST['search'])){
            $result = $this->nomenklatur->searchData($_POST['search']);
            if(count($result) > 0){
                foreach ($result as $row) {
                    $arr_result[] = array(
                        'label'     => $row->jabatan,
                        'job_title' => $row->job_title,
                        'id'        => $row->id_nomenklatur
                    );
                }
                echo json_encode($arr_result);
            }
        }
    }
}
?>
