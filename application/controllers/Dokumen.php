<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokumen extends MY_Controller{
    public function index(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $data['jenis_dok'] = $this->dokumen->getJenisKartu();
        $this->navmenu('Input Data Dokumen Karyawan','vw_input_dokumen','','',$data);
    }

    public function edit($id){
        $data['karyawan'] = $this->pegawai->getData($this->dokumen->getIdKaryawan($id));
        $data['jenis_dok'] = $this->dokumen->getJenisKartu();
        $data['dok'] = $this->dokumen->getData($id);
        $this->navmenu('Edit Data Dokumen Karyawan','vw_edit_dokumen','','',$data);
    }

    public function ajax_list(){
        $id = $this->input->post('id');
        $list = $this->dokumen->get_datatable($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $dokumen) {
            $no++;
            $row = array();
            
            if($dokumen->id_keluarga == 0){
                $row[] = '<center style="font-size: small" >'.$this->pegawai->getNama($dokumen->id_karyawan);
            } else{
                $row[] = '<center style="font-size: small" >'.$this->keluarga->getNama($dokumen->id_keluarga);
            }
            
            $row[] = '<center style="font-size: small">'.$this->dokumen->getDesc($dokumen->kartu_singkat);
            $row[] = '<center style="font-size: small">'.$dokumen->kartu_no;
            
            if($dokumen->kartu_tgl_akhir == '1970-01-01'){
                $dokumen->kartu_tgl_akhir = '';
            }else{
                $dokumen->kartu_tgl_akhir = $this->indonesian_date('d M Y',$dokumen->kartu_tgl_akhir,'');
            }
            
            $row[] = '<center style="font-size: small">'.$dokumen->kartu_tgl_akhir;
            
            $row[] = '<center style="font-size: small">'.$this->keluarga->getDesc($dokumen->id_hubungankeluarga);

            $waktu = (new DateTime($dokumen->tgl_upload));
            $tahun = $waktu->format('Y');
            $bulan = $waktu->format('M');
            $link = $dokumen->id_karyawan."/dok/".$tahun."/".$bulan."/".$dokumen->file;

            if($dokumen->file != NULL || $dokumen->file != ''){
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$dokumen->id_kartu_karyawan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$dokumen->id_kartu_karyawan."'".')"><i class="material-icons">delete_forever</i></a>
                              <a href="javascript:void(0)" title="Lihat Dokumen" onclick="print('."'".$link."'".')"><i class="material-icons">print</i></a>';
            }
            else{
                $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$dokumen->id_kartu_karyawan."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$dokumen->id_kartu_karyawan."'".')"><i class="material-icons">delete_forever</i></a>';
            }
            //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dokumen->countAll($id),
            "recordsFiltered" => $this->dokumen->countFiltered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_formasi(){
        $list = $this->dokumen->get_datatable_formasi();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $dokumen) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: 10;" >'.$this->pegawai->getNama($dokumen->id_karyawan);
            
            if($dokumen->kartu_keluarga != "0"){
                $dokumen->kartu_keluarga = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->kartu_keluarga = '';
            }
            
            if($dokumen->ktp != "0"){
                $dokumen->ktp = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ktp = '';
            }
            
            if($dokumen->akta_lahir != "0"){
                $dokumen->akta_lahir = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir = '';
            }
            
            if($dokumen->akta_lahir_istri != "0"){
                $dokumen->akta_lahir_istri = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_istri = '';
            }
            
            if($dokumen->akta_lahir_anak_1 != "0"){
                $dokumen->akta_lahir_anak_1 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_anak_1 = '';
            }
            
            if($dokumen->akta_lahir_anak_2 != "0"){
                $dokumen->akta_lahir_anak_2 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_anak_2 = '';
            }
            
            if($dokumen->akta_lahir_anak_3 != "0"){
                $dokumen->akta_lahir_anak_3 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_anak_3 = '';
            }
            
            if($dokumen->akta_lahir_anak_4 != "0"){
                $dokumen->akta_lahir_anak_4 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_anak_4 = '';
            }
            
            if($dokumen->akta_lahir_anak_5 != "0"){
                $dokumen->akta_lahir_anak_5 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_lahir_anak_5 = '';
            }
            
            if($dokumen->akta_nikah != "0"){
                $dokumen->akta_nikah = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->akta_nikah = '';
            }
                        
            if($dokumen->npwp != "0"){
                $dokumen->npwp = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->npwp = '';
            }
            
            if($dokumen->paspor != "0"){
                $dokumen->paspor = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->paspor = '';
            }
            
            if($dokumen->sim != "0"){
                $dokumen->sim = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->sim = '';
            }
            
            if($dokumen->ijazah_sd != "0"){
                $dokumen->ijazah_sd = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_sd = '';
            }
            
            if($dokumen->ijazah_smp != "0"){
                $dokumen->ijazah_smp = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_smp = '';
            }
            
            if($dokumen->ijazah_sma != "0"){
                $dokumen->ijazah_sma = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_sma = '';
            }
            
            if($dokumen->ijazah_d3 != "0"){
                $dokumen->ijazah_d3 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_d3 = '';
            }
            
            if($dokumen->ijazah_s1 != "0"){
                $dokumen->ijazah_s1 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_s1 = '';
            }
            
            if($dokumen->ijazah_s2 != "0"){
                $dokumen->ijazah_s2 = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->ijazah_s2 = '';
            }
            
            if($dokumen->buku_tabungan != "0"){
                $dokumen->buku_tabungan = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->buku_tabungan = '';
            }
            
            if($dokumen->bpjs_kesehatan != "0"){
                $dokumen->bpjs_kesehatan = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->bpjs_kesehatan = '';
            }
            
            if($dokumen->bpjs_ketenagakerjaan != "0"){
                $dokumen->bpjs_ketenagakerjaan = '<span class="glyphicon glyphicon-ok"></span>';
            }else{
                $dokumen->bpjs_ketenagakerjaan = '';
            }
            $row[] = '<center style="font-size: small">'.$dokumen->kartu_keluarga;

            $row[] = '<center style="font-size: small">'.$dokumen->ktp;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_istri;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_anak_1;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_anak_2;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_anak_3;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_anak_4;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_lahir_anak_5;
            $row[] = '<center style="font-size: small">'.$dokumen->akta_nikah;
            $row[] = '<center style="font-size: small">'.$dokumen->npwp;
            $row[] = '<center style="font-size: small">'.$dokumen->paspor;
            $row[] = '<center style="font-size: small">'.$dokumen->sim;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_sd;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_smp;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_sma;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_d3;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_s1;
            $row[] = '<center style="font-size: small">'.$dokumen->ijazah_s2;
            $row[] = '<center style="font-size: small">'.$dokumen->bpjs_kesehatan;
            $row[] = '<center style="font-size: small">'.$dokumen->bpjs_ketenagakerjaan;
            $row[] = '<center style="font-size: small">'.$dokumen->buku_tabungan;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dokumen->countAllFormasi(),
            "recordsFiltered" => $this->dokumen->countFilteredFormasi(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->dokumen->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData() {
        $result = $this->dokumen->saveData($_POST);
        $tanggal = (new DateTime())->format('Y-m-d H:i:s');
        $this->upload_dok($result['insert_id'],$_POST['nik'],$tanggal);
        $this->dokumen->tgl_upload($result['insert_id'],$tanggal);

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

    public function updateData() {
        $id = $this->input->post('id_kartu_karyawan');
        $result = $this->dokumen->updateData($_POST);
        $tanggal = (new DateTime())->format('Y-m-d H:i:s');
        $this->upload_dok($id,$_POST['id_karyawan'],$tanggal );
        $this->dokumen->tgl_upload($id,$tanggal);

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

    function upload_dok($id,$nik,$tgl){
        $tahun = (new DateTime($tgl))->format('Y');
        $bulan = (new DateTime($tgl))->format('M');

        $check = $this->dokumen->cekDok($nik,$bulan.'_'.$tahun.'_');
        $type  = 'dok';

        if($check != NULL){
            $var = strlen($check);
            if($var > 21){
                $temp = substr($check,0,2);
            }else{
                $temp = substr($check,0,1);
            }
            //$temp = ltrim($check,'_dok_'.$bulan.'_'.$tahun.'_'.$nik);
            //var_dump($temp);
            $num  = (int)$temp;
            $num += 1;
        }else{
            $num = 1;
            $temp = 1;
        }

        $path = $_FILES['dokumen']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        //$new_name   = $num."_dok_".$bulan."_".$tahun."_".$nik;
        $new_name   = $num."_dok_".$bulan."_".$tahun."_".$nik;
        $folderName = $nik;

        if(!is_dir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan))
        {
            mkdir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan,0777,true);
        }

        if(!is_dir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail'))
        {
            mkdir('./edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail',0777,true);
        }

        $config['allowed_types'] = 'pdf|jpg|jpeg|png|doc|docx'; //type yang dapat diakses bisa anda sesuaikan
        $config['file_name']   = $new_name;
        $config['upload_path'] = './edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan;
        $this->upload->initialize($config);
        
        if($this->upload->do_upload('dokumen'))
        {
            $gbr     = $this->upload->data();
            $gambar  = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
            $this->dokumen->simpan_upload($id,$gambar);
            /*
            if($_FILES['dokumen']['type'] == 'image/jpg' || $_FILES['dokumen']['type'] == 'image/jpeg'){
                $source_path = site_url() . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/'.$new_name;
                $target_path = site_url() . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail/';
                $this->imageThumbnail($source_path,$target_path);
            }
            */

            return TRUE;
        }
        else{
            //$this->jabatan->simpan_upload($id,'');
            echo $this->upload->display_errors('<p>', '</p>');
            return FALSE;
        }
    }

    public function getDataKeluarga(){ 
        // POST data 
        $postData = $this->input->post();
        
        // get data 
        $data = $this->dokumen->getKeluarga($postData);
        echo json_encode($data); 
    }

}
?>


