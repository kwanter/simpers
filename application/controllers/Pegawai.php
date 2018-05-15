<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pegawai extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['agama'] = $this->main->getPilihan('agama');
        $data['identitas'] = $this->main->getPilihan('identitas');
        $data['status_nikah'] = $this->main->getPilihan('status_nikah');
        $this->navmenu('Input Data Karyawan','vw_input_data_pegawai','','',$data);
    }

    public function edit($id){
        $data['agama'] = $this->main->getPilihan('agama');
        $data['identitas'] = $this->main->getPilihan('identitas');
        $data['status_nikah'] = $this->main->getPilihan('status_nikah');
        $data['pegawai'] = $this->pegawai->getData($id);
        $this->navmenu('Edit Data Karyawan','vw_edit_data_pegawai','','',$data);
    }

    public function delete($id){
        $where = array(
            'id_karyawan' => $id,
        );
        $this->pegawai->deleteData($where);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list(){
        $list = $this->pegawai->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $pegawai) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$pegawai->id_karyawan;
            $row[] = '<center><a style="font-size: small" class="btn btn-outline-info" href="javascript:void(0)" title="NIPP : '.$pegawai->nipp.'" >'.$pegawai->nik.'</a>';
            $row[] = '<center style="font-size: small">'.$pegawai->nama_karyawan;
            $row[] = '<center><a style="font-size: small" class="btn btn-outline-info" href="javascript:void(0)" title="Alamat KTP Lengkap" onclick="alamat_ktp('."'".$pegawai->id_karyawan."'".')">'.$pegawai->alamat_ktp.'</a>';
            $row[] = '<center><a style="font-size: small" class="btn btn-outline-info" href="javascript:void(0)" title="Alamat Domisili Lengkap" onclick="alamat_domisili('."'".$pegawai->id_karyawan."'".')">'.$pegawai->alamat_domisili.'</a>';
            $row[] = '<center style="font-size: small">'.$pegawai->tmpt_lahir;
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$pegawai->tgl_lahir,'');

            if($pegawai->jenis_kelamin == 'P')
                $pegawai->jenis_kelamin = 'PRIA';
            else
                $pegawai->jenis_kelamin = 'WANITA';

            $row[] = '<center style="font-size: small">'.$pegawai->jenis_kelamin;
            $row[] = '<center style="font-size: small">'.$this->main->getAgama($pegawai->agama);
            $row[] = '<center style="font-size: small">'.$pegawai->suku;
            $row[] = '<center style="font-size: small">'.$pegawai->no_telp;
            $row[] = '<center style="font-size: small">'.$pegawai->no_hp;
            $row[] = '<center style="font-size: small">'.$pegawai->no_hp_2;
            $row[] = '<center style="font-size: small">'.$pegawai->email;
            $row[] = '<center style="font-size: small">'.$this->main->getStatusNikah($pegawai->status_nikah);
            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit('."'".$pegawai->id_karyawan."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                              <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$pegawai->id_karyawan."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawai->countAll(),
            "recordsFiltered" => $this->pegawai->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $result = $this->pegawai->saveData($_POST);

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
        $id = $this->input->post('id_karyawan');
        $result = $this->pegawai->updateData($_POST);

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
            'id_karyawan' => $id,
        );
        $table = 'm_karyawan';
        $data = $this->pegawai->get_by_id($where,$table);
        echo json_encode($data);
    }

}
?>
