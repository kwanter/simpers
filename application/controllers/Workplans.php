<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Workplans extends CI_Controller {

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
		$this->load->model('Md_workplans','workplans');
		$this->load->model('Md_anggaran','anggaran');
	} 
	
	public function index()
	{
		$this->pagenav('vw_workplans');
	}
	
	private function pagenav($content)
	{
		$this->load->view('vw_header');
		$this->load->view($content);
		$this->load->view('vw_footer');
	}
	
	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_pekerjaan' => $this->input->post('nama'),
				'kategori' => $this->input->post('kategori'),
				'id_uker' => $this->input->post('uker'),
				'id_anggaran' => $this->input->post('idanggaran'),
				'pagu' => $this->input->post('pagu'),
				'pembiayaan' => $this->input->post('pembiayaan'),
				'tahun' => $this->input->post('tahun'),
			);

		if ($this->workplans->save($data) > 0){
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
		  
		  $wrp = $this->workplans->getdata();
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_workplans."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_workplans."'>Hapus</a>";
				*/
				
				$action ="<a onclick='edit_workplans(this.id)' class='btn btn-info btn-xs' title='Edit' id=". $r->id_workplans."><i class='fa fa-pencil'></i></a>&nbsp;";
				$action .="<a onclick='deldata(this.id)' class='btn btn-danger btn-xs' title='Hapus' id=". $r->id_workplans."><i class='fa fa-trash'></i></a>&nbsp;";
				$action .="<a onclick='delete(this.id)' class='btn btn-success btn-xs' title='Pengadaan' id=". $r->id_workplans."><i class='fa fa-shopping-cart'></i></a>";
				
               $data[] = array(
			   		$a,
					$r->nama_pekerjaan,
					$r->kode_rekening,
					number_format($r->pagu),
					$r->tahun,
					$r->singkat,
					$r->kategori,
					$r->pembiayaan,
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
		$data = $this->workplans->getbyid($id);
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
		
		if($this->input->post('rekening') == '')
		{
			$data['inputerror'][] = 'rekening';
			$data['error_string'][] = 'Kode Rekening harus diisi';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('pagu') == '')
		{
			$data['inputerror'][] = 'pagu';
			$data['error_string'][] = 'Pagu Anggaran harus diisi';
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
				'kategori' => $this->input->post('kategori'),
				'id_uker' => $this->input->post('uker'),
				'id_anggaran' => $this->input->post('idanggaran'),
				'pagu' => $this->input->post('pagu'),
				'pembiayaan' => $this->input->post('pembiayaan'),
				'tahun' => $this->input->post('tahun'),				
			);

		if ($this->workplans->update(array('id_workplans' => $this->input->post('id')), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	public function ajax_delete($id)
	{
		$this->workplans->deletebyid($id);
		echo json_encode(array("status" => TRUE, "info" => "Data telah dihapus"));		
	}
}
