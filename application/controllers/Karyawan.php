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
        $list = $this->karyawan_oc->get_datatable();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $pegawai) {
            $no++;
            $row = array();
            $row[] = '<center><a style="font-size: small" href="javascript:void(0)" >'.$pegawai->nik.'</a>';
            $row[] = '<center style="font-size: small">'.$pegawai->nama_karyawan;
            $row[] = '<center style="font-size: small">'.$pegawai->tmpt_lahir.'/'.$this->indonesian_date('d M Y',$pegawai->tgl_lahir,'');
            $row[] = '<center style="font-size: small"><a href="javascript:void(0)" title="Alamat" onclick="alamat_ktp('."'".$pegawai->id_karyawan_oc."'".')">'.$pegawai->alamat_ktp.'</a>';
            $row[] = '<center style="font-size: small">'.$pegawai->no_hp;

            if($pegawai->jenis_kelamin == 'P')
                $pegawai->jenis_kelamin = 'PRIA';
            else
                $pegawai->jenis_kelamin = 'WANITA';

            $row[] = '<center style="font-size: small">'.$pegawai->jenis_kelamin;
            $row[] = '<center style="font-size: small">'.$this->main->getAgama($pegawai->agama);
            
            $cek_pendidikan = $this->pendidikan_oc->checkEdu($pegawai->id_karyawan_oc); 

            if($cek_pendidikan){
                $row[] = '<center style="font-size: small"><a href="javascript:void(0)" title="Pendidikan" onclick="edu('."'".$pegawai->id_karyawan_oc."'".')">'.$cek_pendidikan->id_jenjangpendidikan.' '.$cek_pendidikan->nama_jurusan.'</a>';
            }else{
                $row[] = '<center style="font-size: small"><a href="javascript:void(0)" title="Pendidikan" onclick="edu('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">book</i></a>';
            }

            //$row[] = '<center style="font-size: small">'.$this->main->getStatusNikah($pegawai->status_nikah).'/'.$pegawai->jmlh_anak.' Anak';
            $row[] = '<center style="font-size: small">'.$pegawai->status_nikah.'/'.$pegawai->jmlh_anak;
            
            $cek_kontrak = $this->riwayatkontrak->cekKontrak($pegawai->id_karyawan_oc);

            if($cek_kontrak){
                $row[] = '<center style="font-size: small"><a href="javascript:void(0)" title="Riwayat Kontrak" onclick="kontrak('."'".$pegawai->id_karyawan_oc."'".')">'.$this->indonesian_date('d M Y',$cek_kontrak->tmt_berlaku).'</a>';
            }else{
                $row[] = '<center style="font-size: small"><a href="javascript:void(0)" title="Riwayat Kontrak" onclick="kontrak('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">work</i></a>';
            }

            //add html for action
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">launch</i></a>
                              <a href="javascript:void(0)" title="Dokumen" onclick="doc('."'".$pegawai->id_karyawan_oc."'".')"><i class="material-icons">assignment</i></a>
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

    public function getDataKaryawan($id){
        $data = $this->karyawan_oc->getData($id);
        echo json_encode($data);
    }

    public function getPilihanData($pilihan){
        $result = $this->karyawan_oc->getPilihanData($pilihan);
        echo json_encode($result);
    }

    public function delete($id){
        $result = $this->karyawan_oc->deleteData($id);
        if($result)
            echo json_encode(array("status" => TRUE,"info" => "Hapus data sukses"));
        else
            echo json_encode(array("status" => FALSE,"info" => "Hapus data gagal"));
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

    public function getAlamatLengkap($id) {
        $where = array(
            'id_karyawan_oc' => $id,
        );
        $table = 'm_karyawan_oc';
        $data = $this->karyawan_oc->get_by_id($where,$table);
        echo json_encode($data);
    }

    function pdf(){
        $data['data'] = $this->karyawan_oc->getPdfData();
        $this->load->view('vw_pdf_karyawan_oc',$data);
    }

    function excel() {
        $result = $this->karyawan_oc->getPdfData();

        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );
        $object->getActiveSheet()->getStyle("A7:H7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:H7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:H7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator('KKT')
            ->setLastModifiedBy('KKT')
            ->setCategory("Approve by ");
        // Add some data
        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
        $object->getActiveSheet()->mergeCells('A1:H1');
        $object->getActiveSheet()->mergeCells('A2:H2');
        $object->getActiveSheet()->mergeCells('A3:H3');
        $object->getActiveSheet()->mergeCells('A4:H4');
        $object->getActiveSheet()->mergeCells('A5:H5');

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.'KKT')
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Rekap Data Karyawan Outsourcing PT. Kaltim Kariangau Terminal')
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Nama Karyawan')
            ->setCellValue('C7', 'Tempat, Tanggal Lahir')
            ->setCellValue('D7', 'No Handphone')
            ->setCellValue('E7', 'Jenis Kelamin')
            ->setCellValue('F7', 'Nama Jabatan')
            ->setCellValue('G7', 'Nama PJTK')
            ->setCellValue('H7', 'TMT Kontrak')
        ;
        $no=0;
        //add data
        $counter=8;
        $ex = $object->setActiveSheetIndex(0);

        foreach($result as $row){
            $no++;
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);

            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->nama");
            $ex->setCellValue("C".$counter,"$row->tmpt_lahir, $row->tgl_lahir");
            $ex->setCellValue("D".$counter,"$row->no_hp");
            $ex->setCellValue("E".$counter,"$row->jenis_kelamin");
            $ex->setCellValue("F".$counter,"$row->jabatan");
            $ex->setCellValue("G".$counter,"$row->pjtk");
            $ex->setCellValue("H".$counter,"$row->tmt_kontrak");
            $counter=$counter+1;
        }

        // Rename sheet
        $object->getActiveSheet()->setTitle('Rekap_Data_Karyawan_OC_PT_KKT');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap_Data_Karyawan_OC_PT_KKT.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

}
?>
