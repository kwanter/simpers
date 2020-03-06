<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

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
	 
	private $pathPhoto='edoc/images/';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Md_karyawan','karyawan');
		$this->load->model('Md_agama','agama');
		$this->load->model('Md_jenjang','jenjang');
	} 
	
	public function index()
	{
		$this->pagenav('vw_karyawan');
	}
	
	private function pagenav($content,$data='')
	{
		$data['lsagama'] = $this->agama->getAll();
		$this->load->view('vw_header');
		$this->load->view($content,$data);
	}
	
	public function biodata($id=0)
	{
		//$data['list'] = $this->karyawan->getbyid($id);
		$data['lsagama'] = $this->agama->getAll();
		$data['lsjenjang'] = $this->jenjang->getAll();
		$data['id']=$id;
		$this->pagenav('vw_biodata',$data);
	}
	
	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'wilayah' => $this->input->post('wilayah'),
				'nama_karyawan' => $this->input->post('nama'),
				'jk' => $this->input->post('jk'),
				'status' => $this->input->post('status'),
				'jml_anak' => $this->input->post('anak'),
				'id_agama' => $this->input->post('agama'),
				'uker' => $this->input->post('uker'),
				'jabatan' => $this->input->post('jabatan'),
				'stat_pegawai' => $this->input->post('status2'),
				'photo' => 'edoc/nophoto.jpg',
				'created_date' => date('Y-m-d H:i:s')
			);

		if ($this->karyawan->save($data) > 0){
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
		  
		  $wrp = $this->karyawan->getdata();
		  $data = array();
		  $a=1;
		  foreach($wrp->result() as $r) {
				$action ="&nbsp;";
		  		/*
				$action = "<a href='#' onclick='edit(this.id)' class='btn btn-info btn-xs' id='". $r->id_karyawan."'>Edit</a>&nbsp;";
				$action .= "<a href='#' onclick='delete(this.id)' class='btn btn-danger btn-xs' id='".$r->id_karyawan."'>Hapus</a>";
				*/
				$action ="<a onclick='edit(this.id)' class='btn btn-info btn-xs' title='Edit' id=". $r->id_karyawan."><i class='fa fa-pencil'></i></a>&nbsp;";
				$action .="<a onclick='deldata(this.id)' class='btn btn-danger btn-xs' title='Hapus' id=". $r->id_karyawan."><i class='fa fa-trash'></i></a>&nbsp;";
				$action .="<a class='btn btn-warning btn-xs' title='Biodata' href='".base_url()."karyawan/biodata/".$r->id_karyawan."'><i class='fa fa-user'></i></a>";
				
				$data[] = array(
			   		$a,
					//$r->wilayah,
					$r->lokasi,
					"<a title='Biodata' href='".base_url()."karyawan/biodata/".$r->id_karyawan."'>".$r->nama_karyawan."</a>",
					$r->jk,
					$r->status."/".$r->jml_anak,
					$r->nama_agama,
					$r->nama_uker,
					$r->jabatan,
					$r->status2,
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
		$data = $this->karyawan->getbyid($id);
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
			$data['error_string'][] = 'Nama Karyawan wajib diisi';
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
				'wilayah' => $this->input->post('wilayah'),
				'nama_karyawan' => $this->input->post('nama'),
				'jk' => $this->input->post('jk'),
				'status' => $this->input->post('status'),
				'jml_anak' => $this->input->post('anak'),
				'id_agama' => $this->input->post('agama'),
				'uker' => $this->input->post('uker'),
				'jabatan' => $this->input->post('jabatan'),
				'stat_pegawai' => $this->input->post('status2'),
			);

		if ($this->karyawan->update(array('id_karyawan' => $this->input->post('id')), $data)) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	public function ajax_update2()
	{
		$this->_validate();
		$data = array(
				'nama_karyawan' => $this->input->post('nama'),
				'wilayah' => $this->input->post('wilayah'),
				'tempat_lahir' => $this->input->post('tempat'),
				'nik' => $this->input->post('nik'),
				'tgl_lahir' => $this->input->post('tgl'),
				'noktp' => $this->input->post('noktp'),
				'jk' => $this->input->post('jk'),
				'npwp' => $this->input->post('npwp'),				
				'uker' => $this->input->post('uker'),
				'jabatan' => $this->input->post('jabatan'),
				'telp' => $this->input->post('telp'),
				'status' => $this->input->post('status'),
				'email' => $this->input->post('email'),
				'jml_anak' => $this->input->post('anak'),
				'id_jenjang' => $this->input->post('jenjang'),
				'id_agama' => $this->input->post('agama'),
				'pend_jurusan' => $this->input->post('jurusan'),
				'alamat' => $this->input->post('alamat'),
				'kota' => $this->input->post('kota'),
				'tgl_masuk' => $this->input->post('tgl2'),
				
				'stat_pegawai' => $this->input->post('status2'),
				'nobpjs_kes' => $this->input->post('nobpjs1'),
				'nobpjs_tk' => $this->input->post('nobpjs2'),
			);

		if ($this->karyawan->update(array('id_karyawan' => $this->input->post('id')), $data)) {
			echo json_encode(array("status" => TRUE, "info" => "Update data sukses"));
		}else{
			echo json_encode(array("status" => FALSE, "info" => "Update data gagal"));
		}
	}
	
	public function ajax_delete($id)
	{
		$this->karyawan->deletebyid($id);
		echo json_encode(array("status" => TRUE, "info" => "Data telah dihapus"));
	}
	
	public function addphoto($id=0)
	{
		$fname = $_FILES['file']['name'];
		//$lokasi = $this->pathPhoto.$id.$fname;
		
		$uploadOK=1;
		$ftype = pathinfo($fname,PATHINFO_EXTENSION);
		
		$filename = 'photo'.$id.'.'.$ftype;
		$lokasi = "./".$this->pathPhoto.$filename;
		$imgurl = base_url().$this->pathPhoto.$filename;				
		
		if($ftype!='jpg' && $ftype!='jpeg' && $ftype!='png' && $ftype!='gif'){
			$uploadOK=0;
		}
		
		if ($uploadOK==0){
			echo json_encode(array("status" => FALSE, "info" => "File Extension Not Match"));
		}else{
			if (move_uploaded_file($_FILES['file']['tmp_name'],$lokasi)){
				//$data = array('photo' => "photo".$id.'.'.$ftype);
				
				$data = array('photo' => $this->pathPhoto.$filename);
				
				if ($this->karyawan->update(array('id_karyawan' => $id), $data)) {
					echo json_encode(array("status" => TRUE, "info" => "Upload Success" ,"url" => $imgurl));
				}else{
					echo json_encode(array("status" => FALSE, "info" => "Save Failed"));
				}
			}else{
				echo json_encode(array("status" => FALSE, "info" => "Upload Failed"));
			}
		}
	}
		
	public function delphoto($id=0){
		$data = $this->karyawan->getbyid($id);
		$fname='';
		foreach ($data as $r){
			$fname = $r->photo;
		}
		$lokasi = "./".$fname;
		if($fname!='' && $fname!='edoc/nophoto.jpg' ){
			if(unlink($lokasi)){
				$data = array('photo' => 'edoc/nophoto.jpg');
				if ($this->karyawan->update(array('id_karyawan' => $id), $data)) {
					echo json_encode(array("status" => TRUE, "info" => "Remove photo Success") );
				}else{
					echo json_encode(array("status" => FALSE, "info" => "Remove photo Failed"));
				}
			}else{
				echo json_encode(array("status" => FALSE, "info" => "Delete file Failed"));
			}
		}else{
			echo json_encode(array("status" => FALSE, "info" => "There is no Photo File"));
		}
		
	}

	
}
