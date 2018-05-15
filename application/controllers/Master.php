<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master extends MY_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->navmenu('Simpers','vw_page_maintenance','','','');
    }

    public function page($page){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        if($page == 'pegawai')
            $this->navmenu('Data Karyawan','vw_data_'.$page,'','',$data);
        else
            $this->navmenu('Data '.ucwords($page).' Karyawan','vw_data_'.$page,'','',$data);
    }

    public function login(){
        $data['title'] = 'Login';
        $this->load->view('vw_login',$data,'');
    }

    /*
    public function tunjangan(){
        $this->navmenu('Simpers','vw_data_tunjangan','','','');
    }

    public function kj(){
        $this->navmenu('Data Kelas Jabatan','vw_data_kj','','','');
    }

    public function pegawai(){
        $this->navmenu('Data Pegawai','vw_data_pegawai','','','');
    }
    public function nomenklatur(){
        $this->navmenu('Data Nomenklatur','vw_data_nomenklatur','','','');
    }

    public function keluarga(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $this->navmenu('Hubungan Keluarga Kepagawaian','vw_data_keluarga','','',$data);
    }

    public function pendidikan(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $this->navmenu('Riwayat Pendidikan Karyawan','vw_data_pendidikan','','',$data);
    }

    public function jabatan(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $this->navmenu('Riwayat Jabatan Karyawan','vw_data_jabatan','','',$data);
    }

    public function diklat(){
        $data['karyawan'] = $this->pegawai->getKaryawanData();
        $this->navmenu('Riwayat Diklat Karyawan','vw_data_diklat','','',$data);
    }
    */
}
?>
