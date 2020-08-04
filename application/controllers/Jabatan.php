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
            $row[] = '<center style="font-size: small">'.$jabatan->unit_kerja;

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

            $waktu = (new DateTime($jabatan->tgl_berlaku));
            $tahun = $waktu->format('Y');
            $bulan = $waktu->format('M');
            $link = $jabatan->id_karyawan."/sk/".$tahun."/".$bulan."/".$jabatan->sk;

            if($jabatan->sk != NULL || $jabatan->sk != ''){
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$jabatan->id_riwayatjabatan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$jabatan->id_riwayatjabatan."'".')"><i class="material-icons">delete_forever</i></a>
                              <a href="javascript:void(0)" title="Lihat SK" onclick="print('."'".$link."'".')"><i class="material-icons">print</i></a>';
            }
            else{
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$jabatan->id_riwayatjabatan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$jabatan->id_riwayatjabatan."'".')"><i class="material-icons">delete_forever</i></a>';
            }
            //add html for action

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
        $this->upload_sk($result['insert_id'],$_POST['nik'],$_POST['tanggal']);

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
        $this->upload_sk($id,$_POST['id_karyawan'],$_POST['tanggal']);

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
                        'label'         => $row->jabatan,
                        'job_title'     => $row->job_title,
                        'id'            => $row->id_nomenklatur,
                        'uker'          => $row->nama_uker,
                        'kelas_jabatan' => $row->kelas_jabatan
                    );
                }
                echo json_encode($arr_result);
            }
        }
    }

    function upload_sk($id,$nik,$tgl){
        $tahun      = (new DateTime($tgl))->format('Y');
        $bulan      = (new DateTime($tgl))->format('M');

        $check = $this->jabatan->cekSK($nik,$bulan.'_'.$tahun.'_');
        $type       = 'sk';

        if($check != NULL){
            $temp = substr($check,0,3);
            //$temp = ltrim($check,$nik.'_sk_'.$bulan.'_'.$tahun.'_');
            $num  = (int)$temp;
            $num += 1;
        }else{
            $num = 1;
        }

        $path = $_FILES['sk']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $new_name   = $num."_sk_".$bulan."_".$tahun."_".$nik;
        $folderName = $nik;

        if(!is_dir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan))
        {
            mkdir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan,0777,true);
        }

        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx'; //type yang dapat diakses bisa anda sesuaikan
        $config['file_name']   = $new_name;
        $config['upload_path'] = './edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan;
        $this->upload->initialize($config);

        if($this->upload->do_upload('sk'))
        {
            $gbr     = $this->upload->data();
            $gambar  = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
            $this->jabatan->simpan_upload($id,$gambar);

            return TRUE;
        }
        else{
            //$this->jabatan->simpan_upload($id,'');
            echo $this->upload->display_errors('<p>', '</p>');
            return FALSE;
        }
    }

}
?>
