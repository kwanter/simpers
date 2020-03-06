<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends MY_Controller{
    public function index(){
        $data['karyawan']  = $this->pegawai->getKaryawanData();
        $data['jeniscuti'] = $this->cuti->getJenisCuti();
        $data['pejabat']   = $this->nomenklatur->getPejabatData();
        $this->navmenu('Pengajuan Cuti Karyawan','vw_input_data_cuti','','',$data);
    }

    public function edit($id){
        $data['karyawan']  = $this->pegawai->getKaryawanData();
        $data['jeniscuti'] = $this->cuti->getJenisCuti();
        $data['pejabat']   = $this->nomenklatur->getPejabatData();
        $data['data']      = $this->cuti->getDataCuti($id);
        $data['cuti']      = $this->pegawai->getSisaCuti($this->cuti->getIDPegawai($id));
        $this->navmenu('Ubah Data Pengajuan Cuti Karyawan','vw_edit_data_cuti','','',$data);
    }

    public function ajax_list(){
        $list = $this->cuti->get_datatable_cuti();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $cuti) {
            if($cuti->disetujui == NULL){
                $no++;
                $row = array();
                $tgl_mulai = date("d M Y", strtotime($cuti->tgl_mulai_cuti));
                $tgl_selesai = date("d M Y", strtotime($cuti->tgl_selesai_cuti));

                $row[] = '<center style="font-size: small">'.$cuti->id_datacuti;
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan;
                $row[] = '<center style="font-size: small">'.$tgl_mulai;
                $row[] = '<center style="font-size: small">'.$tgl_selesai;
                $row[] = '<center style="font-size: small">'.$cuti->jenis_cuti;
                $row[] = '<center style="font-size: small">'.$cuti->jumlah_cuti." Hari";
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan_pengganti;
                $row[] = '<center style="font-size: small">'.$cuti->pejabat_menyetujui;
                
                if($cuti->disetujui == 0 || $cuti->disetujui == NULL || $cuti->disetujui == ""){
                    $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$cuti->id_datacuti."'".')"><i class="material-icons">launch</i></a>
                                <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$cuti->id_datacuti."'".')"><i class="material-icons">delete_forever</i></a>
                                <a href="javascript:void(0)" title="Cetak Surat Cuti" onclick="print('."'".$cuti->id_datacuti."'".')"><i class="material-icons">print</i></a>
                                ';
                } else{
                    $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$cuti->id_datacuti."'".')"><i class="material-icons">launch</i></a>
                                <a href="javascript:void(0)" title="Hapus" onclick="del('."'".$cuti->id_datacuti."'".')"><i class="material-icons">delete_forever</i></a>
                                <a href="javascript:void(0)" title="Cetak Formulir Cuti" onclick="print('."'".$cuti->id_datacuti."'".')"><i class="material-icons">print</i></a>
                                ';
                }

                //add html for action
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cuti->countAllCuti(),
            "recordsFiltered" => $this->cuti->countFilteredCuti(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_persetujuan(){
        $list = $this->cuti->get_datatable_cuti();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $cuti) {
            if($cuti->disetujui == NULL || $cuti->disetujui == ""){
                $no++;
                $row = array();
                $tgl_mulai = date("d M Y", strtotime($cuti->tgl_mulai_cuti));
                $tgl_selesai = date("d M Y", strtotime($cuti->tgl_selesai_cuti));

                $row[] = '<center style="font-size: small">'.$cuti->id_datacuti;
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan;
                $row[] = '<center style="font-size: small">'.$tgl_mulai;
                $row[] = '<center style="font-size: small">'.$tgl_selesai;
                $row[] = '<center style="font-size: small">'.$cuti->jenis_cuti;
                $row[] = '<center style="font-size: small">'.$cuti->jumlah_cuti." Hari";
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan_pengganti;
                $row[] = '<center style="font-size: small">'.$cuti->pejabat_menyetujui;
                $row[] = '<center><a href="javascript:void(0)" title="Persetujuan Cuti" class="open-AddDialog" data-target="#myModal" data-toggle="modal" data-id="'.$cuti->id_datacuti.'"><i class="material-icons">gavel</i></a>';
                
                //add html for action
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cuti->countAllCuti(),
            "recordsFiltered" => $this->cuti->countFilteredCuti(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function riwayat_cuti(){
        $id = $this->input->post('id');
        $list = $this->cuti->get_datatable_riwayat_cuti($id);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $cuti) {
            if($cuti->disetujui == 1){
                $no++;
                $row = array();
                $tgl_mulai = date("d M Y", strtotime($cuti->tgl_mulai_cuti));
                $tgl_selesai = date("d M Y", strtotime($cuti->tgl_selesai_cuti));

                $row[] = '<center style="font-size: small">'.$no;
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan;
                $row[] = '<center style="font-size: small">'.$tgl_mulai;
                $row[] = '<center style="font-size: small">'.$tgl_selesai;
                $row[] = '<center style="font-size: small">'.$cuti->jenis_cuti;
                $row[] = '<center style="font-size: small">'.$cuti->jumlah_cuti." Hari";
                $row[] = '<center style="font-size: small">'.$cuti->nama_karyawan_pengganti;
                $row[] = '<center style="font-size: small">'.$cuti->pejabat_menyetujui;
                $row[] = '<center><a href="javascript:void(0)" title="Cetak Formulir Cuti" onclick="print('."'".$cuti->id_datacuti."'".')"><i class="material-icons">folder</i></a>
                                <a href="javascript:void(0)" title="Cetak Surat Cuti" onclick="xprint('."'".$cuti->id_datacuti."'".')"><i class="material-icons">print</i></a>
                                <a href="javascript:void(0)" title="Tanggal Surat Cuti" class="open-AddDialog" data-target="#myModal" data-toggle="modal" data-id="'.$cuti->id_datacuti.'" data-tgl="'.$cuti->tgl_dokumen_surat.'"><i class="material-icons">gavel</i></a>
                ';
                
                //add html for action
                $data[] = $row;
                $no++;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cuti->countAllRiwayatCuti($id),
            "recordsFiltered" => $this->cuti->countFilteredRiwayatCuti($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function rekap_cuti(){
        $list = $this->pegawai->get_datatables_cv();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $karyawan) {
                $no++;
                $row = array();

                $row[] = '<center style="font-size: small">'.$no;
                $row[] = '<center style="font-size: small">'.$karyawan->nama_karyawan;
                $row[] = '<center style="font-size: small">'.$karyawan->sisa_cuti;
                $row[] = '<center><a href="javascript:void(0)" title="Sisa Cuti" class="open-AddDialog" data-target="#myModal" data-toggle="modal" data-id="'.$karyawan->id_karyawan.'" data-cuti="'.$karyawan->sisa_cuti.'"><i class="material-icons">gavel</i></a>';

                //add html for action
                $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawai->countAllCV(),
            "recordsFiltered" => $this->pegawai->countFilteredCV(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_libur(){
        $list = $this->cuti->get_datatable_libur();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $dokumen) {
            $no++;
            $row = array();
            
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$dokumen->tgl_libur;
            $row[] = '<center style="font-size: small">'.$dokumen->deskripsi_libur;

            $row[] = '<center><a disabled href="javascript:void(0)" title="Edit" onclick="edit('."'".$dokumen->id_harilibur."'".')"><i class="material-icons">launch</i></a>
                              <a disabled href="javascript:void(0)" title="Hapus" onclick="del('."'".$dokumen->id_harilibur."'".')"><i class="material-icons">delete_forever</i></a>';
            //add html for action

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cuti->countAllLibur(),
            "recordsFiltered" => $this->cuti->countFilteredLibur(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->cuti->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function addData() {
        $tgl_awal       = $this->input->post('tgl_cuti_awal');
        $tgl_akhir      = $this->input->post('tgl_cuti_akhir');
        $tgl_kembali    = $this->input->post('tgl_cuti_kembali');
        $tgl_formulir   = $this->input->post('tgl_dokumen_formulir');

        if($tgl_awal == NULL || $tgl_awal == "")
            $tgl_awal = "1970-01-01";

        if($tgl_akhir == NULL || $tgl_akhir == "")
            $tgl_akhir = "1970-01-01";

        if($tgl_kembali == NULL || $tgl_kembali == "")
            $tgl_kembali = "1970-01-01";

        $karyawan           = $this->input->post('nik');
        $karyawan_pengganti = $this->input->post('nik_pengganti');
        $jenis_cuti         = $this->input->post('jenis_cuti');
        $tgl_cuti_awal      = new DateTime($tgl_awal);
        $tgl_cuti_akhir     = new DateTime($tgl_akhir);
        $tgl_cuti_kembali   = new DateTime($tgl_kembali);
        $tgl_formulir_cuti  = new DateTime($tgl_formulir);
        $pejabat_setuju     = $this->input->post('pejabat_setuju');
        $pejabat_wewenang   = $this->input->post('pejabat_wewenang');
        $kota_cuti          = $this->input->post('kota_cuti');

        $tanggal_skrg = $tgl_cuti_awal->format('Y-m-d');
        $date_awal  = date_create($tgl_cuti_awal->format('Y-m-d'));
        $date_akhir = date_create($tgl_cuti_akhir->format('Y-m-d'));
        $selisih_tgl = date_diff($date_awal,$date_akhir);
        $jmlh_cuti = (int)($selisih_tgl->format('%a'));
        $jmlh_cuti++;

        for($i=0;$i<(int)($selisih_tgl->format('%a'));$i++){
            $day = (new DateTime($tanggal_skrg))->format('D');
            $cek_libur = $this->cuti->cekHariLibur($tanggal_skrg);
            
            if($day == 'Sat' || $day == 'Sun' || $cek_libur == TRUE){
                $jmlh_cuti-=1;
            }
            
            $new_date = new DateTime($tanggal_skrg);
            $new_date->modify('+1 day');
            $tanggal_skrg = $new_date->format('Y-m-d');
        }

        if($jenis_cuti == 'CUTTAHUNAN'){
            $sisa_cuti = (int)($this->pegawai->getSisaCuti($karyawan));
        
            if($sisa_cuti > $jmlh_cuti){
                $sisa_cuti = $sisa_cuti - $jmlh_cuti;
                $data = array(
                    'id_karyawan'           => $karyawan,
                    'id_karyawan_pengganti' => $karyawan_pengganti,
                    'tgl_mulai_cuti'        => $tgl_cuti_awal->format('Y-m-d'),
                    'tgl_selesai_cuti'      => $tgl_cuti_akhir->format('Y-m-d'),
                    'tgl_kembali'           => $tgl_cuti_kembali->format('Y-m-d'),
                    'tgl_dokumen_formulir'  => $tgl_formulir_cuti->format('Y-m-d'),
                    'jenis_cuti'            => $jenis_cuti,
                    'jumlah_cuti'           => $jmlh_cuti,
                    'pejabat_setuju'        => $pejabat_setuju,
                    'pejabat_wewenang'      => $pejabat_wewenang,
                    'kota_cuti'             => $kota_cuti
                );
                $result = $this->cuti->saveData($data);

                $data_cuti = array(
                    'id_karyawan'  => $karyawan,
                    'cuti_tahunan' => $sisa_cuti
                );
                //$this->pegawai->updateSisaCuti($data_cuti);
                
            } else{
                $result = FALSE;
            }
        }else{
             $data = array(
                    'id_karyawan'           => $karyawan,
                    'id_karyawan_pengganti' => $karyawan_pengganti,
                    'tgl_mulai_cuti'        => $tgl_cuti_awal->format('Y-m-d'),
                    'tgl_selesai_cuti'      => $tgl_cuti_akhir->format('Y-m-d'),
                    'tgl_kembali'           => $tgl_cuti_kembali->format('Y-m-d'),
                    'tgl_dokumen_formulir'  => $tgl_formulir_cuti->format('Y-m-d'),
                    'jenis_cuti'            => $jenis_cuti,
                    'jumlah_cuti'           => $jmlh_cuti,
                    'pejabat_setuju'        => $pejabat_setuju,
                    'pejabat_wewenang'      => $pejabat_wewenang,
                    'kota_cuti'             => $kota_cuti
            );
            $result = $this->cuti->saveData($data);
        }

        
        if ($result)
            $this->session->set_flashdata('notif', 
            '<div class="alert alert-success" role="alert"> 
                    Data Berhasil Ditambahkan , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> 
                    Data Gagal Ditambahkan..Silahkan Periksa Kembali Inputan Anda 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

        $this->index();
    }

    public function updateData() {
        $tgl_awal       = $this->input->post('tgl_cuti_awal');
        $tgl_akhir      = $this->input->post('tgl_cuti_akhir');
        $tgl_kembali    = $this->input->post('tgl_cuti_kembali');
        $tgl_formulir   = $this->input->post('tgl_dokumen_formulir');

        if($tgl_awal == NULL || $tgl_awal == "")
            $tgl_awal = "1970-01-01";

        if($tgl_akhir == NULL || $tgl_akhir == "")
            $tgl_akhir = "1970-01-01";

        if($tgl_kembali == NULL || $tgl_kembali == "")
            $tgl_kembali = "1970-01-01";

        $id_datacuti        = $this->input->post('id_datacuti');
        $karyawan           = $this->input->post('nik');
        $karyawan_pengganti = $this->input->post('nik_pengganti');
        $jenis_cuti         = $this->input->post('jenis_cuti');
        $tgl_cuti_awal      = new DateTime($tgl_awal);
        $tgl_cuti_akhir     = new DateTime($tgl_akhir);
        $tgl_cuti_kembali   = new DateTime($tgl_kembali);
        $tgl_formulir_cuti  = new DateTime($tgl_formulir);
        $pejabat_setuju     = $this->input->post('pejabat_setuju');
        $pejabat_wewenang   = $this->input->post('pejabat_wewenang');
        $kota_cuti          = $this->input->post('kota_cuti');

        $tanggal_skrg = $tgl_cuti_awal->format('Y-m-d');
        $date_awal  = date_create($tgl_cuti_awal->format('Y-m-d'));
        $date_akhir = date_create($tgl_cuti_akhir->format('Y-m-d'));
        $selisih_tgl = date_diff($date_awal,$date_akhir);
        $jmlh_cuti = (int)($selisih_tgl->format('%a'));
        $jmlh_cuti++;
        
        for($i=0;$i<(int)($selisih_tgl->format('%a'));$i++){
            $day = (new DateTime($tanggal_skrg))->format('D');
            $cek_libur = $this->cuti->cekHariLibur($tanggal_skrg);
            
            if($day == 'Sat' || $day == 'Sun' || $cek_libur == TRUE){
                $jmlh_cuti-=1;
            }
            
            $new_date = new DateTime($tanggal_skrg);
            $new_date->modify('+1 day');
            $tanggal_skrg = $new_date->format('Y-m-d');
        }

        if($jenis_cuti == 'CUTTAHUNAN'){
            $sisa_cuti      = (int)($this->pegawai->getSisaCuti($karyawan));
            $jmlh_cuti_lama = (int)($this->cuti->getJmlhCutiLama($id_datacuti)); 
            $sisa_cuti += $jmlh_cuti_lama;
        
            if($sisa_cuti > $jmlh_cuti){
                $sisa_cuti = $sisa_cuti - $jmlh_cuti;
                $data = array(
                    'id_datacuti'           => $id_datacuti,
                    'id_karyawan_pengganti' => $karyawan_pengganti,
                    'tgl_mulai_cuti'        => $tgl_cuti_awal->format('Y-m-d'),
                    'tgl_selesai_cuti'      => $tgl_cuti_akhir->format('Y-m-d'),
                    'tgl_kembali'           => $tgl_cuti_kembali->format('Y-m-d'),
                    'tgl_dokumen_formulir'  => $tgl_formulir_cuti->format('Y-m-d'),
                    'jumlah_cuti'           => $jmlh_cuti,
                    'pejabat_setuju'        => $pejabat_setuju,
                    'pejabat_wewenang'      => $pejabat_wewenang,
                    'kota_cuti'             => $kota_cuti
                );
                $result = $this->cuti->updateData($data);

                $data_cuti = array(
                    'id_karyawan'  => $karyawan,
                    'cuti_tahunan' => $sisa_cuti
                );
                //$this->pegawai->updateSisaCuti($data_cuti);
                
            } else{
                $result = FALSE;
            }
        }else{
             $data = array(
                    'id_datacuti'           => $id_datacuti,
                    'id_karyawan_pengganti' => $karyawan_pengganti,
                    'tgl_mulai_cuti'        => $tgl_cuti_awal->format('Y-m-d'),
                    'tgl_selesai_cuti'      => $tgl_cuti_akhir->format('Y-m-d'),
                    'tgl_kembali'           => $tgl_cuti_kembali->format('Y-m-d'),
                    'tgl_dokumen_formulir'  => $tgl_formulir_cuti->format('Y-m-d'),
                    'jumlah_cuti'           => $jmlh_cuti,
                    'pejabat_setuju'        => $pejabat_setuju,
                    'pejabat_wewenang'      => $pejabat_wewenang,
                    'kota_cuti'             => $kota_cuti
            );
            $result = $this->cuti->updateData($data);
        }

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

        $this->edit($id_datacuti);
    }

    function persetujuan(){
        $persetujuan        = $this->input->post('disetujui');
        $id_cuti            = $this->input->post('id_cuti');
        $tgl_dokumen_surat  = $this->input->post('tgl_dokumen_surat');
        $pejabat_ttd        = $this->input->post('pejabat_ttd');

        if($persetujuan == "1"){
            $no_surat_cuti = $this->input->post('no_surat_cuti');
            $data = array(
                'id_cuti'           => $id_cuti,
                'disetujui'         => $persetujuan,
                'no_surat_cuti'     => $no_surat_cuti,
                'tgl_dokumen_surat' => $tgl_dokumen_surat,
                'pejabat_ttd'       => $pejabat_ttd
            );
        }else{
            $data = array(
                'id_cuti'           => $id_cuti,
                'disetujui'         => $persetujuan,
                'tgl_dokumen_surat' => $tgl_dokumen_surat,
                'pejabat_ttd'       => $pejabat_ttd
            );
        }
        $dataCuti = $this->cuti->getDataCuti($id_cuti);
        $data_cuti_karyawan = array(
            'id_karyawan'  => $dataCuti->id_karyawan,
            'cuti_tahunan' => $dataCuti->jumlah_cuti
        );
        $this->pegawai->updateSisaCuti($data_cuti_karyawan);
        $result = $this->cuti->updatePersetujuanCuti($data);
        print_r($data);
        echo $result;
    }

    function getNamaPejabat(){
        $pejabat = $this->nomenklatur->getPejabatData();
        echo json_encode($pejabat);
    }

    function update_tgl_surat(){
        $id_cuti            = $this->input->post('id_cuti');
        $tgl_dokumen_surat  = $this->input->post('tgl_dokumen_surat');

        $data = array(
            'id_cuti'           => $id_cuti,
            'disetujui'         => "1",
            'tgl_dokumen_surat' => $tgl_dokumen_surat
        );

        $result = $this->cuti->updatePersetujuanCuti($data);
        print_r($data);
        echo $result;
    }

    function update_sisa_cuti(){
        $sisa_cuti      = $this->input->post('sisa_cuti');
        $id_karyawan    = $this->input->post('id_karyawan');

        $data = array(
            'id_karyawan'       => $id_karyawan,
            'cuti_tahunan'      => $sisa_cuti,
        );

        $result = $this->pegawai->updateSisaCuti($data);
        print_r($data);
        echo $result;
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
                $source_path = $_SERVER['DOCUMENT_ROOT'] . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/'.$new_name;
                $target_path = $_SERVER['DOCUMENT_ROOT'] . '/edok/'.$folderName.'/'.$type.'/'.$tahun.'/'.$bulan.'/thumbnail/';
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

    public function getPejabat(){
        if(isset($_POST['search'])){
            $result = $this->nomenklatur->searchDataCuti($_POST['search']);
            if(count($result) > 0){
                foreach ($result as $row) {
                    $arr_result[] = array(
                        'label' => $row->nama_karyawan,
                        'id_karyawan' => $row->id_karyawan
                    );
                }
                echo json_encode($arr_result);
            }
        }
    }

    public function formulir_cuti($id){
        $data['cuti']       = $this->cuti->getData($id);
        $tgl_surat          = $data['cuti']->tgl_dokumen_formulir;
        $data['tanggal']    = $this->indonesian_date('d F Y',$tgl_surat,'');
        $data['karyawan']   = $this->pegawai->getKaryawanDataCuti($data['cuti']->id_karyawan);
        $data['data']       = $this->pegawai->getAlamatKaryawan($data['cuti']->id_karyawan);
        $this->load->view('vw_formulir_cuti',$data);
    }

    public function surat_cuti($id){
        $data['cuti']       = $this->cuti->getData($id);
        $tgl_surat          = $data['cuti']->tgl_dokumen_surat;
        $data['tanggal']    = $this->indonesian_date('d F Y', $tgl_surat,'');
        $data['karyawan']   = $this->pegawai->getKaryawanDataCuti($data['cuti']->id_karyawan);
        $data['data']       = $this->pegawai->getAlamatKaryawan($data['cuti']->id_karyawan);
        $ttd                = $this->cuti->getIDPejabatTTD($id);
        $data['ttd']        = $this->nomenklatur->getPejabatTTD($ttd->pejabat_ttd);
        $this->load->view('vw_surat_cuti',$data);
    }
}
?>
