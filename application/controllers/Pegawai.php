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
            $row[] = '<center><a style="font-size: small" href="javascript:void(0)" title="NIPP : '.$pegawai->nipp.'" >'.$pegawai->nik.'</a>';
            $row[] = '<center style="font-size: small">'.$pegawai->nama_karyawan;
            $row[] = '<center style="font-size: small">'.$pegawai->tmpt_lahir;
            $row[] = '<center style="font-size: small">'.$this->indonesian_date('d M Y',$pegawai->tgl_lahir,'');

            if($pegawai->jenis_kelamin == 'P')
                $pegawai->jenis_kelamin = 'PRIA';
            else
                $pegawai->jenis_kelamin = 'WANITA';

            $row[] = '<center style="font-size: small">'.$pegawai->jenis_kelamin;
            $row[] = '<center style="font-size: small">'.$this->main->getAgama($pegawai->agama);
            $row[] = '<center style="font-size: small">'.$this->main->getStatusNikah($pegawai->status_nikah);

            //add html for action
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$pegawai->id_karyawan."'".')"><i class="material-icons">launch</i></a>
                              <a class="js-sweetalert waves-effect" data-type="confirm" href="javascript:void(0)" title="Hapus" onclick="del('."'".$pegawai->id_karyawan."'".')"><i class="material-icons">delete_forever</i></a>
                              <a href="javascript:void(0)" title="Cetak CV" onclick="cetak_cv('."'".$pegawai->id_karyawan."'".')"><i class="material-icons">print</i></a>
                              ';

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
        $this->upload_image($result['insert_id']);

        if ($result['status'])
            $this->session->set_flashdata('notif', '<div class="alert bg-green alert-dismissible" role="alert"> 
                                                                    Data Berhasil Ditambahkan , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                    <button type="button" class="close alert-link" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert bg-red alert-dismissible" role="alert"> Data Gagal Ditambahkan..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close alert-link" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->index();
    }

    public function updateData()
    {
        $id = $this->input->post('id_karyawan');

        $this->upload_image($id);

        $result = $this->pegawai->updateData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert bg-green alert-dismissible" role="alert"> 
                                                                    Data Berhasil Di Update, <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                    <button type="button" class="close alert-link" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert bg-red alert-dismissible" role="alert"> Data Gagal Di Update..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close alert-link" data-dismiss="alert" aria-label="Close">
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

    function upload_image($id){
        $check = $this->pegawai->cekFoto($id);
        $tahun = (new DateTime())->format('Y');
        $bulan = (new DateTime())->format('M');
        $type  = 'foto';
        $path  = $_FILES['foto']['name'];
        $ext   = pathinfo($path, PATHINFO_EXTENSION);

        if($check != NULL){
            if($check->foto != NULL){
                //$temp = rtrim($check->foto,'_foto_'.$old_bulan.'_'.$old_tahun.'_'.$id);
                $temp = substr($check->foto,0,3);
                $num  = (int)$temp;
                $num += 1;
            }
        }else{
            $num = 1;
        }

        $new_name   = $num."_foto_".$bulan."_".$tahun."_".$id;
        $folderName = $id;
        $config['file_name']   = $new_name;
        $config['upload_path'] = './edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['quality'] = '75';

        if(!is_dir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan))
        {
            mkdir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan, 0777,true);
        }

        $this->upload->initialize($config);

        if($this->upload->do_upload('foto'))
        {
            $gbr     = $this->upload->data();
            $configer =  array(
                'image_library'   => 'gd2',
                'source_image'    =>  $gbr['full_path'],
                'maintain_ratio'  =>  TRUE,
                'width'           =>  1440,
                'height'          =>  1920,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $gambar  = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
            $type    = $gbr['image_type'];
            $now = (new DateTime())->format('Y-m-d');
            $this->pegawai->simpan_upload($id,$gambar,$type);
            $this->pegawai->upload_time($id,$now);

            return TRUE;
        }
        else{
            //$this->pegawai->simpan_upload($id,'','');
            echo $this->upload->display_errors('<p>', '</p>');
            return FALSE;
        }
    }

    public function cetak_cv($id){
        $data['tanggal'] = $this->indonesian_date('d M Y','','');
        $data['pegawai'] = $this->pegawai->getData($id);
        $data['biodata'] = $this->pegawai->get_biodata_cv_karyawan($id);
        $data['mk'] = $this->pegawai->get_masa_kerja_cv($id);
        $data['pendidikan'] = $this->pendidikan->get_pendidikan_cv($id);
        $data['diklat'] = $this->diklat->get_diklat_cv($id);
        $data['keluarga'] = $this->keluarga->get_keluarga_cv($id);
        $data['jabatan'] = $this->jabatan->get_jabatan_cv($id);
        $this->load->view('vw_cv_karyawan',$data);
    }

    public function pdf(){

    }

    public function excel(){

    }

    public function getDataKaryawanCuti(){
        $id = $this->input->post('data');
        $result = $this->pegawai->getDataKaryawanCuti($id);
        $data['status'] = 'ok';
        $data['result'] = $result;

        if($data != NULL)
            echo json_encode($data);
    }
}
?>
