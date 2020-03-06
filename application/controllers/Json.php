<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('md_klasifikasi','klasifikasi');
		$this->load->model('md_divisi','divisi');
	} 
	
	public function index()	{

	}
	
	public function list_klasifikasi(){
		$list = $this->klasifikasi->getAll();
		foreach ($list as $klasifikasi) {
			$output[] = array(
					"id" => $klasifikasi->id_klasifikasi,
					"nama" => $klasifikasi->nama_klasifikasi,
					"kategori" => $klasifikasi->kategori,
					);
		}
		
		echo json_encode($output);
	}
	
	public function list_divisi(){
		$list = $this->divisi->getAll();
		foreach ($list as $divisi) {
			$output[] = array(
					"id" => $divisi->id_divisi,
					"nama" => $divisi->nama_divisi,
					"singkat" => $divisi->singkat,
					);
		}
		
		echo json_encode($output);
	}
	
	
}
