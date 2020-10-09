<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends MY_Controller{
    public function index(){
        $data['karyawan']  = $this->pegawai->getKaryawanData();
        $this->load->view('vw_input_data_karyawan_oc',$data);
        //$this->navmenu('Pengajuan Cuti Karyawan','vw_input_data_karyawan_oc','','',$data);
    }

    public function ajax_edit($id){
        $data = $this->karyawan_oc->getData($id);
        echo json_encode($data);
        //$this->navmenu('Ubah Data Pengajuan Cuti Karyawan','vw_edit_data_karyawan_oc','','',$data);
    }

    public function ajax_list(){
        $list = $this->karyawan_oc->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $pegawai) {
            $no++;
            $row = array();
            $row[] = '<center><a style="font-size: small" href="javascript:void(0)" >'.$pegawai->nik.'</a>';
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
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">launch</i></a>
                              <a class="js-sweetalert waves-effect" data-type="confirm" href="javascript:void(0)" title="Hapus" onclick="del('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">delete_forever</i></a>
                              
                              ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->karyawan_oc->countAll(),
            "recordsFiltered" => $this->karyawan_oc->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function getPilihanData($pilihan){
        $result = $this->karyawan_oc->getPilihanData($pilihan);
        echo json_encode($result);
    }

    public function delete($id){
        $this->karyawan_oc->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_add() {
        $result = $this->karyawan_oc->saveData($this->input->post());
        
        if(!empty($_POST['foto']))
            $this->upload_image($result['insert_id']);

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
    }

    public function ajax_update() {
        $id = $this->input->post('id_karyawan');
        
        if(!empty($_POST['foto']))
            $this->upload_image($id);

        $result = $this->karyawan_oc->updateData($this->input->post());

        if ($result)
            echo json_encode(array("status" => TRUE,"info" => "Update data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Update data gagal"));
    }

    function upload_image($id){
        $check = $this->karyawan_oc->cekFoto($id);
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

        if(!is_dir('./edok_oc/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan))
        {
            mkdir('./edok_oc/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan, 0777,true);
        }

        if(!is_dir('./edok_oc/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail'))
        {
            mkdir('./edok_oc/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail',0777,true);
        }

        $this->upload->initialize($config);

        if($this->upload->do_upload('foto'))
        {
            $source_image = imagecreatefromjpeg($_FILES['foto']['tmp_name']);
            $width = imagesx($source_image);
            $height = imagesy($source_image);
            $desired_width = 200;
            $desired_height = floor($height * ($desired_width / $width));

            $gbr     = $this->upload->data();
            $configer =  array(
                'image_library'   => 'gd2',
                'source_image'    =>  $gbr['full_path'],
                'new_image'       => './edok_oc/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/'.'thumbnail/',
                'maintain_ratio'  =>  TRUE,
                'create_thumb'    => TRUE,
                'width'           =>  $desired_width,
                'height'          =>  $desired_height,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $gambar  = $gbr['file_name']; //Mengambil file name dari gambar yang diupload
            $type    = $gbr['image_type'];
            /*
            if($_FILES['foto']['type'] == 'image/jpg' || $_FILES['foto']['type'] == 'image/jpeg'){
                $source_path = $_SERVER['DOCUMENT_ROOT'] . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/'.$new_name;
                $target_path = $_SERVER['DOCUMENT_ROOT'] . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/'.'thumbnail/'.$new_name;
                $this->imageThumbnail($source_path,$target_path);
            }
            */
            $now = (new DateTime())->format('Y-m-d');
            $this->karyawan_oc->simpan_upload($id,$gambar,$type);
            $this->karyawan_oc->upload_time($id,$now);

            return TRUE;
        }
        else{
            //$this->pegawai->simpan_upload($id,'','');
            echo $this->upload->display_errors('<p>', '</p>');
            return FALSE;
        }
    }

}
?>
