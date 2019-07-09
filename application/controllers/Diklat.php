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
            $d2 = $d2->add(new DateInterval('P1D'));
            $interval = $d2->diff($d1);
            $row[] = '<center style="font-size: small">'.$interval->format('%a').' Hari';
            $row[] = '<center style="font-size: small">'.$diklat->tema_diklat;
            $row[] = '<center style="font-size: small">'.$diklat->lokasi;
            $row[] = '<center style="font-size: small">'.$diklat->penyelenggara;
            $row[] = '<center style="font-size: small">'.$diklat->no_sertifikat;
            $row[] = '<center style="font-size: small">'.$diklat->nilai;
            $row[] = '<center style="font-size: small">'.$diklat->skala_nilai;

            $waktu = (new DateTime($diklat->tgl_akhirdiklat));
            $tahun = $waktu->format('Y');
            $bulan = $waktu->format('M');
            $link = $diklat->id_karyawan."/cert/".$tahun."/".$bulan."/".$diklat->sertifikat;

            if($diklat->sertifikat != NULL || $diklat->sertifikat != ''){
                //add html for action
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$diklat->id_diklatkaryawan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$diklat->id_diklatkaryawan."'".')"><i class="material-icons">delete_forever</i></a>
                              <a href="javascript:void(0)" title="Cetak Sertifikat" onclick="print('."'".$link."'".')"><i class="material-icons">print</i></a>';
            }else{
                //add html for action
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$diklat->id_diklatkaryawan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$diklat->id_diklatkaryawan."'".')"><i class="material-icons">delete_forever</i></a>';
            }

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
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$diklat->id_jenisdiklat."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$diklat->id_jenisdiklat."'".')"><i class="material-icons">delete_forever</i></a>';

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
        $this->upload_sertifikat($result['insert_id'],$_POST['nik'],$_POST['tgl_diklat']);

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
        $this->upload_sertifikat($id,$_POST['id_karyawan'],$_POST['tgl_diklat']);

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

    function upload_sertifikat($id,$nik,$tgl){
        $new_tgl = substr($tgl,-12);
        $tahun   = (new DateTime($new_tgl))->format('Y');
        $bulan   = (new DateTime($new_tgl))->format('M');

        $check   = $this->diklat->cekSertifikat($nik,$bulan.'_'.$tahun.'_');
        $type    = 'cert';

        if($check != NULL){
            $temp = substr($check,0,3);
            //$temp = ltrim($check,$nik.'_cert_'.$bulan.'_'.$tahun.'_');
            $num  = (int)$temp;
            $num += 1;
        }else{
            $num = 1;
        }

        $path = $_FILES['sertifikat']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $new_name   = $num."_cert_".$bulan.'_'.$tahun.'_'.$nik;
        $folderName = $nik;

        if(!is_dir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan))
        {
            mkdir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan,0777,true);
        }

        $config['file_name']   = $new_name;
        $config['upload_path'] = './edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan;
        $config['allowed_types'] = 'pdf|jpg|jpeg|png'; //type yang dapat diakses bisa anda sesuaikan
        $this->upload->initialize($config);

        if($this->upload->do_upload('sertifikat'))
        {
            $gbr     = $this->upload->data();
            $gambar  = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
            $this->diklat->simpan_upload($id,$gambar);
            return TRUE;
        }
        else{
            //$this->diklat->simpan_upload($id,'');
            echo $this->upload->display_errors('<p>', '</p>');
            return FALSE;
        }
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

    public function riwayat_diklat(){
        $data['tanggal'] = $this->indonesian_date('d F Y','','');
        $data['diklat'] = $this->diklat->getRiwayatDiklatAll();
        $this->load->view('vw_pdf_riwayat_diklat',$data);
    }
}
?>
