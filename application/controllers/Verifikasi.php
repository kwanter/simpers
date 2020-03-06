<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifikasi extends CI_Controller {

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
		$this->load->model('Md_permohonan','permohonan');
		$this->load->model('Md_isidok','isidok');
		$this->load->model('Md_klasifikasi','klasifikasi');
		$this->load->model('Md_divisi','divisi');
	} 
	
	public function index()
	{
		$this->pagenav('vw_verifikasi');
	}
	
	public function dok($id=0)
	{
		$data['id']=$id;
		$dokdata = $this->permohonan->getbyid($id);
		foreach($dokdata as $r) {
			$data['nama']=$r->nama_pekerjaan;
			$data['rekanan']=$r->nama_rekanan;
			$data['klasifikasi']=$r->nama_klasifikasi;
			$data['divisi']=$r->singkat;
			$data['kode']=$r->kode_permohonan;
			$data['numstat']=$r->num_state;
		}
		
		$this->pagenav('vw_verifdok',$data);
	}
	
	public function dok2($id=0)
	{
		$data['id']=$id;
		$dokdata = $this->permohonan->getbyid($id);
		foreach($dokdata as $r) {
			$data['nama']=$r->nama_pekerjaan;
			$data['rekanan']=$r->nama_rekanan;
			$data['klasifikasi']=$r->nama_klasifikasi;
			$data['divisi']=$r->singkat;
			$data['kode']=$r->kode_permohonan;
			$data['numstat']=$r->num_state;
		}
		
		$this->pagenav('vw_validdok',$data);
	}
	
	
	private function pagenav($content,$data='')
	{
		$this->load->view('vw_header');
		$this->load->view($content,$data);
	}
	
	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_pekerjaan' => $this->input->post('nama'),
				'nama_rekanan' => $this->input->post('perusahaan'),
				'id_klasifikasi' => $this->input->post('klasifikasi'),
				'id_divisi' => $this->input->post('divisi'),
				'created_date' => date('Y-m-d H:i:s')
			);

		if ($this->permohonan->save($data) > 0){
			echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
		}else{
			echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
		}
		
	}
	
	public function ajax_list()
	{
		  // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $wrp = $this->permohonan->getdata();
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_permohonan."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_permohonan."'>Hapus</a>";
				*/
				
				if ($r->num_state==1){
					$action ="<a onclick='edit_permohonan(this.id)' class='btn btn-info btn-xs' title='Edit' id=". $r->id_permohonan."><i class='fa fa-pencil'></i></a>&nbsp;";
					$action .="<a onclick='deldata(this.id)' class='btn btn-danger btn-xs' title='Hapus' id=". $r->id_permohonan."><i class='fa fa-trash'></i></a>&nbsp;";
					$action .="<a onclick='filldok(this.id)' class='btn btn-success btn-xs' title='Submit' id=". $r->id_permohonan."><i class='fa fa-check-square-o'></i></a>&nbsp;";
					$kode="<span class='label label-default'>R</span>";
				}
				if ($r->num_state==2){
					$action .="<a href='".base_url()."permohonan/dok/".$r->id_permohonan."' class='btn btn-warning btn-sm' title='Input Dokumen' id=". $r->id_permohonan."><i class='fa fa-file-text-o'></i></a>&nbsp;";
					$action .="<a onclick='cancel(this.id)' class='btn btn-danger btn-sm' title='Batalkan' id=". $r->id_permohonan."><i class='fa fa-close'></i></a>&nbsp;";
					$kode="<span class='label label-warning'>D</span>";
				}
				
				if ($r->num_state==3){
					$action .="<a href='".base_url()."permohonan/dok/".$r->id_permohonan."' class='btn btn-warning btn-sm' title='List Dokumen' id=". $r->id_permohonan."><i class='fa fa-file-text-o'></i></a>&nbsp;";
					$kode="<span class='label label-success'>C</span>";
				}
				
               $data[] = array(
			   		$a,
					//$r->kode_permohonan."<br />"."<span class='label label-success'>P</span>",
					$kode,
					$r->kode_permohonan,
					$r->nama_pekerjaan,
					$r->nama_rekanan,
					$r->nama_klasifikasi,
					$r->singkat,
					$action
               );
			   $a++;
          }
		  
		  $output = array(
               "draw" => $draw,
                 "recordsTotal" => $wrp->num_rows(),
                 "recordsFiltered" => $wrp->num_rows(),
                 "data" => $data
            );
          echo json_encode($output);
          exit();

	}
	
	public function ajax_edit($id)
	{
		$data = $this->permohonan->getbyid($id);
		echo json_encode($data);
	}
	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama') == '')
		{
			$data['inputerror'][] = 'nama';
			$data['error_string'][] = 'Nama Pekerjaan harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('perusahaan') == '')
		{
			$data['inputerror'][] = 'perusahaan';
			$data['error_string'][] = 'Nama Perusahaan harus diisi';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_pekerjaan' => $this->input->post('nama'),
				'nama_rekanan' => $this->input->post('perusahaan'),
				'id_klasifikasi' => $this->input->post('klasifikasi'),
				'id_divisi' => $this->input->post('divisi'),	
			);

		if ($this->permohonan->update(array('id_permohonan' => $this->input->post('id')), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	public function ajax_delete($id)
	{
		$this->permohonan->deletebyid($id);
		echo json_encode(array("status" => TRUE, "info" => "Data telah dihapus"));		
	}
	
	public function ajax_filldok($id)
	{
		if ($this->permohonan->filldok($id)){
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}

	}
	
	public function ajax_submitdok($id=0)
	{
		$nofill=$this->isidok->cekuncomplete($id);
		//$nofill=0;
		if ($nofill){
			$data = array(
					'num_state' => 3,
				);

			if ($this->permohonan->update(array('id_permohonan' => $id), $data) > 0) {
				echo json_encode(array("status" => TRUE, "info" => "Submit sukses"));
			}else{
				echo json_encode(array("status" => FALSE, "info" => "Submit gagal"));
			}
		}else{
			echo json_encode(array("status" => FALSE, "info" => "GAGAL. Masih ada informasi dokumen yang belum diisi"));
		}
	}
}
