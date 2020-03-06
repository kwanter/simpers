<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Isidok extends CI_Controller {

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
		$this->load->model('Md_isidok','isidok');
	} 
	
	public function index()
	{
		//$this->pagenav('vw_isidok',$data);
		
		
	}
		
	private function pagenav($content,$data='')
	{
		$this->load->view('vw_header');
		$this->load->view($content,$data);
	}
	
	public function ajax_list($id=0)
	{
		  // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $wrp = $this->isidok->getdata($id);
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
				$ada='';
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_isidok."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_isidok."'>Hapus</a>";
				*/
				
				if ($r->num_state==2){
					$action ="<a onclick='edit_dok(this.id)' class='btn btn-info btn-xs' title='Edit' id=". $r->id_permohonan_dok."><i class='fa fa-pencil'></i></a>&nbsp;";
					$action .="<a onclick='resetdok(this.id)' class='btn btn-danger btn-xs' title='Reset' id=". $r->id_permohonan_dok."><i class='fa fa-eraser'></i></a>";
				}
				
				if ($r->is_available=='N')
					$ada='TIDAK';
				else
					$ada='YA';
			
				
				if ($r->stat=='W')
					$stat="<span class='label label-warning'>".$r->stat."</span>";
				else
					$stat="<span class='label label-default'>".$r->stat."</span>";
				
				$tgl = new DateTime($r->tgldok); 
				$tgldok=$tgl->format('d M Y');
				if($r->tgldok=='1901-01-01') $tgldok='&nbsp;';
				
				if ($r->notes)
					$nama=$r->nama_dokumen."<br /><span style='color:red;'>[<i>".$r->notes."</i>]</span>";
				else
					$nama=$r->nama_dokumen;
					
				$data[] = array(
			   		$a,
					"&nbsp;&nbsp;".$stat,
					//$r->nama_dokumen,
					$nama,
					$ada,
					$r->nodok,
					//$r->tgldok,
					$tgldok,
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
	
	public function ajax_list2($id=0)
	{
		  // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $wrp = $this->isidok->getdata($id);
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_isidok."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_isidok."'>Hapus</a>";
				*/
				
				if ($r->num_state==3){
					if ($r->is_available=='N'){
						$action ="<a onclick='edit_ya(this.id)' class='btn btn-default btn-xs' title='Ubah' id=". $r->id_permohonan_dok.">TIDAK</a>";
					}else{
						$action ="<a onclick='edit_tdk(this.id)' class='btn btn-success btn-xs' title='Ubah' id=". $r->id_permohonan_dok.">YA</a>";
					}
				}
				
				if ($r->num_state==4){
					if ($r->is_available=='N')
						$action='TIDAK';
					else
						$action='YA';
				}
				
				if ($r->stat=='W')
					$stat="<span class='label label-warning'>".$r->stat."</span>";
				else
					$stat="<span class='label label-default'>".$r->stat."</span>";
				
				$tgl = new DateTime($r->tgldok); 
				$tgldok=$tgl->format('d M Y');
				if($r->tgldok=='1901-01-01') $tgldok='&nbsp;';
				
				if ($r->notes)
					$nama=$r->nama_dokumen."<br /><span style='color:red;'>[<i>".$r->notes."</i>]</span>";
				else
					$nama=$r->nama_dokumen;
				
				$data[] = array(
			   		$a,
					"&nbsp;&nbsp;".$stat,
					//$r->nama_dokumen,
					$nama,
					$r->nodok,
					//$r->tgldok,
					$tgldok,
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
	
	public function ajax_list3($id=0)
	{
		  // Datatables Variables
          $draw = intval($this->input->get("draw"));
          $start = intval($this->input->get("start"));
          $length = intval($this->input->get("length"));
		  
		  $wrp = $this->isidok->getdata($id);
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_isidok."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_isidok."'>Hapus</a>";
				*/
				
				if ($r->num_state==4){
					$action ="<a onclick='edit_dok(this.id)' class='btn btn-info btn-xs' title='Catatan' id=". $r->id_permohonan_dok."><i class='fa fa-pencil'></i></a>&nbsp;";
					$action .="<a onclick='resetdok(this.id)' class='btn btn-danger btn-xs' title='Reset' id=". $r->id_permohonan_dok."><i class='fa fa-eraser'></i></a>";
				}
								
				if ($r->stat=='W')
					$stat="<span class='label label-warning'>".$r->stat."</span>";
				else
					$stat="<span class='label label-default'>".$r->stat."</span>";
				
				if ($r->is_available=='Y')
					$avail='YA';
				else
					$avail='TIDAK';
					
				$tgl = new DateTime($r->tgldok); 
				$tgldok=$tgl->format('d M Y');
				if($r->tgldok=='1901-01-01') $tgldok='&nbsp;';
				
				if ($r->notes)
					$nama=$r->nama_dokumen."<br /><span style='color:red;'>[<i>".$r->notes."</i>]</span>";
				else
					$nama=$r->nama_dokumen;
					
				$data[] = array(
			   		$a,
					"&nbsp;&nbsp;".$stat,
					$nama,
					$r->nodok,
					//$r->tgldok,
					$tgldok,
					$avail,
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
		$data = $this->isidok->getbyid($id);
		echo json_encode($data);
	}
	
	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nodok') == '')
		{
			$data['inputerror'][] = 'nodok';
			$data['error_string'][] = 'Nomor Dokumen harus diisi';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
	private function _validate2()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('notes') == '')
		{
			$data['inputerror'][] = 'notes';
			$data['error_string'][] = 'Catatan harus diisi';
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
				'nodok' => $this->input->post('nodok'),
				'tgldok' => $this->input->post('tgl'),
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $this->input->post('id')), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	public function ajax_update2()
	{
		$this->_validate2();
		$data = array(
				'notes' => $this->input->post('notes')
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $this->input->post('id')), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	
	public function ajax_resetdok($id)
	{
		$data = array(
				'nodok' => NULL,
				'tgldok' => '1901-01-01',
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $id), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Reset sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Reset gagal"));
		}
	}
	
	public function ajax_resetnote($id)
	{
		$data = array(
				'notes' => NULL
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $id), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Reset sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Reset gagal"));
		}
	}
	
	public function ajax_edit_ya($id)
	{
		$data = array(
				'is_available' => 'Y',
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $id), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update gagal"));
		}
	}
	
	public function ajax_edit_tdk($id)
	{
		$data = array(
				'is_available' => 'N',
			);

		if ($this->isidok->update(array('id_permohonan_dok' => $id), $data) > 0) {
			echo json_encode(array("status" => TRUE, "info" => "Update sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update gagal"));
		}
	}
	
	public function ajax_deldok($id)
	{
		if ($this->isidok->delete($id)){
			echo json_encode(array("status" => TRUE, "info" => "Pembatalan sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Pembatalan gagal"));
		}

	}
	
	
	
}
