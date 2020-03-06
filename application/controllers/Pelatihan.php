<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelatihan extends CI_Controller {

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
		$this->load->model('Md_karyawan','karyawan');
		$this->load->model('Md_pelatihan','pelatihan');
	} 
	
	public function index()
	{
		//$this->pagenav('vw_keluarga');
	}
	
	public function data($id=0)
	{
		$data['id']=$id;
		$data['info'] = $this->karyawan->getbyid($id);
		$this->pagenav('vw_pelatihan',$data);
	}
	
	private function pagenav($content,$data='')
	{
		$this->load->view('vw_header');
		$this->load->view($content,$data);
	}
		
	public function ajax_add($id=0)
	{
		$this->_validate();
		
		$data = array(
				'id_karyawan' => $id,
				'tema_pelatihan' => $this->input->post('tema'),
				'penyelenggara' => $this->input->post('penyelenggara'),
				'kota' => $this->input->post('kota'),
				'tahun' => $this->input->post('tahun'),
				
				'created_date' => date('Y-m-d H:i:s')
			);

		
		if ($this->pelatihan->save($data) > 0){
			echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
		}else{
			echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
		}
		
	}
	
	public function ajax_list($id=0)
	{
		  // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $wrp = $this->pelatihan->getdata($id);
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_karyawan."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_karyawan."'>Hapus</a>";
				*/
				$action ="<a onclick='edit(this.id)' class='btn btn-info btn-xs' title='Edit' id=". $r->id_rwpelatihan."><i class='fa fa-pencil'></i></a>&nbsp;";
				$action .="<a onclick='deldata(this.id)' class='btn btn-danger btn-xs' title='Hapus' id=". $r->id_rwpelatihan."><i class='fa fa-trash'></i></a>&nbsp;";

				$data[] = array(
			   		$a,
					$r->tema_pelatihan,
					$r->penyelenggara,
					$r->kota,
					$r->tahun,
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
		$data = $this->pelatihan->getbyid($id);
		echo json_encode($data);
	}
	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('tema') == '')
		{
			$data['inputerror'][] = 'tema';
			$data['error_string'][] = 'Tema Pelatihan wajib diisi';
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
				'tema_pelatihan' => $this->input->post('tema'),
				'penyelenggara' => $this->input->post('penyelenggara'),
				'kota' => $this->input->post('kota'),
				'tahun' => $this->input->post('tahun'),
			);

		if ($this->pelatihan->update(array('id_rwpelatihan' => $this->input->post('id')), $data)) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	
	public function ajax_delete($id)
	{
		$this->pelatihan->deletebyid($id);
		echo json_encode(array("status" => TRUE, "info" => "Data telah dihapus"));
	}
	
		
}
