<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak extends CI_Controller {

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
		$this->load->model('Md_keluarga','keluarga');
		$this->load->model('Md_pendidikan','pendidikan');
		$this->load->model('Md_pelatihan','pelatihan');
		$this->load->model('Md_pengalaman','pengalaman');
	} 
	
	public function index()
	{
		
	}
	
	private function bulan($bl)
	{
		if($bl==1)
			$nmbl='JANUARI';
		else if($bl==2)
			$nmbl='FEBRUARI';
		else if($bl==3)
			$nmbl='MARET';
		else if($bl==4)
			$nmbl='APRIL';
		else if($bl==5)
			$nmbl='MEI';
		else if($bl==6)
			$nmbl='JUNI';
		else if($bl==7)
			$nmbl='JULI';
		else if($bl==8)
			$nmbl='AGUSTUS';
		else if($bl==9)
			$nmbl='SEPTEMBER';
		else if($bl==10)
			$nmbl='OKTOBER';
		else if($bl==11)
			$nmbl='NOVEMBER';
		else if($bl==12)
			$nmbl='DESEMBER';
		else 
			$nmbl='';	
		return $nmbl;
	}
	
	public function pdfkaryawan()
	{
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format'=>'A4-L']);
		$mpdf->SetTitle('Daftar Karyawan');
		$html="<html><body style='font-family:arial;'><div style='text-align: center;'>
			<h3>DAFTAR KARYAWAN</h3>
			</div>";
		$html.="<table style='font-size:11px' border='1' width='100%' cellspacing='0' cellpadding='0'>
				<tr bgcolor='yellow'>
					<th width='30px' height='30px' align='center'>No</th>
					<th width='50px' align='center'>Wilayah</th>
					<th align='center'>Nama Karyawan</th>
					<th align='center'>Tempat, Tgl Lahir</th>
					<th width='30px' align='center'>JK</th>
					<th width='50px' align='center'>Status</th>
					<th align='center'>Agama</th>
					<th align='center'>Unit Kerja</th>
					<th align='center'>Jabatan</th>
					<th align='center'>Status<br />Pegawai</th>
					<th width='50px' align='center'>Pendidikan</th>
					
				</tr>";
			$karyawan = $this->karyawan->getdata();
			$a=1;
			foreach($karyawan->result() as $k) {				
				$t = new DateTime($k->tgl_lahir); 
				$tgl = $t->format('d M Y');
				
				if ($k->tgl_lahir == NULL) $tgl='';
				
				$html.="<tr >
							<td height='20px' align='center' valign='top'>".$a."</td>
							<td align='center' valign='top'>".$k->lokasi."</td>
							<td style='padding-left: 10px;' valign='top'>".$k->nama_karyawan."</td>
							<td style='padding-left: 10px;' valign='top'>".$k->tempat_lahir.", ".$tgl."</td>
							<td align='center' valign='top'>".$k->jk."</td>
							<td align='center' valign='top'>".$k->status."/".$k->jml_anak."</td>
							<td align='center' valign='top'>".$k->nama_agama."</td>
							<td style='padding-left: 10px;' valign='top'>".$k->nama_uker."</td>
							<td style='padding-left: 10px;' valign='top'>".$k->jabatan."</td>
							<td width='40px' align='center' valign='top'>".$k->status2."</td>
							<td align='center' valign='top'>".$k->singkat."</td>
						</tr>";
				$a++;
			}
		$html.="</table><br />";
		
		$mpdf->SetHTMLFooter("<hr /><span style='font-size:9px'><i>Tgl Cetak : ".date('d M Y')." [".date('H:i')."]</i></span>");
		$mpdf->WriteHTML($html);
		$html .="</body></html>";
		
        $mpdf->Output('mkaryawan.pdf','I'); // opens in browser
	}
	
	public function cv($idkar)
	{
		$mpdf = new \Mpdf\Mpdf();
        // Write some HTML code:
		$mpdf->SetTitle('Curriculum Vitae');
		
		$karyawan = $this->karyawan->getbyid($idkar);
		foreach($karyawan as $k) {
			
			$t = new DateTime($k->tgl_lahir); 
			$hari=$t->format('d');
			$bln=$this->bulan($t->format('m'));
			$tahun=$t->format('Y');
			$tgl = $hari." ".$bln." ".$tahun;
			
			$now = new DateTime();
			$diff = $now->diff($t);
			$usia = $diff->y." tahun, ".$diff->m." bulan, ".$diff->d." hari";
			
			if($k->tgl_lahir=='1900-01-01')	{
				$tgl="";
				$usia="";
			}
			
			$t2 = new DateTime($k->tgl_masuk); 
			$hari2=$t2->format('d');
			$bln2=$this->bulan($t2->format('m'));
			$tahun2=$t2->format('Y');
			$tgl2 = $hari2." ".$bln2." ".$tahun2;
			
			if($k->tgl_masuk=='1900-01-01')	{
				$tgl2="";
			}
			
			$wilayah = $k->lokasi;
			/*
			if ($k->wilayah=='BPN')
				$wilayah = "BALIKPAPAN";
			else
				$wilayah = "BANYUWANGI";
			*/
			/*
			if ($k->stat_pegawai=='T')
				$status2 = "KARYAWAN TETAP";
			else
				$status2 = "TENAGA OUTSOURCING";
			*/
			$status2 = $k->status2;	
			$nama = $k->nama_karyawan;
			$ttl = $k->tempat_lahir.", ".$tgl;
			$jk = $k->jk2;
			$agama = $k->nama_agama;
			$status = $k->status."/".$k->jml_anak;
			$alamat = $k->alamat;
			$kota = $k->kota;
			$telp = $k->telp;
			$email = $k->email;
			$jenjang = $k->nama_jenjang;
			$jurusan = $k->pend_jurusan;
			$uker = $k->nama_uker;
			$jabatan = $k->jabatan;
			
			$noktp = $k->noktp;
			$bpjs1 = $k->nobpjs_kes;
			$bpjs2 = $k->nobpjs_tk;
			$nik = $k->nik;
			$npwp = $k->npwp;
			$jenjang = $k->nama_jenjang;
			$photo = base_url().$k->photo;
		}
		
		$html="<html><body style='font-family:arial;'>
			<div style='text-align: center;'>
			<h3>CURRICULUM VITAE</h3>
			</div>
			<span><u><b>&raquo;&nbsp;BIODATA :</b></u></span>
			<table style='font-weight:bold;font-size:12px' border='0' width='100%' cellspacing='0' cellpadding='0'>
				<tr>
					<td height='20px' width='150px' valign='top'>Wilayah </td>
					<td valign='top'> : </td>
					<td valign='top'>".$wilayah."</td>
				</tr>
				<tr>
					<td height='20px' valign='top' width='130px'>Nama Karyawan/NIK</td>
					<td valign='top' width='10px'> : </td>
					<td valign='top'>".$nama." / ".$nik."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Tempat, Tgl Lahir </td>
					<td valign='top'> : </td>
					<td valign='top'>".$ttl."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Usia</td>
					<td valign='top'> : </td>
					<td valign='top'>".$usia."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Jenis Kelamin</td>
					<td valign='top'> : </td>
					<td valign='top'>".$jk."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Agama</td>
					<td valign='top'> : </td>
					<td valign='top'>".$agama."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Status / Jml Anak</td>
					<td valign='top'> : </td>
					<td valign='top'>".$status."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Pendidikan</td>
					<td valign='top'> : </td>
					<td valign='top'>".$jenjang."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Jurusan</td>
					<td valign='top'> : </td>
					<td valign='top'>".$jurusan."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Unit Kerja</td>
					<td valign='top'> : </td>
					<td valign='top'>".$uker."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Jabatan</td>
					<td valign='top'> : </td>
					<td valign='top'>".$jabatan."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Status Pegawai</td>
					<td valign='top'> : </td>
					<td valign='top'>".$status2."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>No KTP</td>
					<td valign='top'> : </td>
					<td valign='top'>".$noktp."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>NPWP</td>
					<td valign='top'> : </td>
					<td valign='top'>".$npwp."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>No BPJS Kesehatan</td>
					<td valign='top'> : </td>
					<td valign='top'>".$bpjs1."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>No BPJS Tenaga Kerja</td>
					<td valign='top'> : </td>
					<td valign='top'>".$bpjs2."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Alamat</td>
					<td valign='top'> : </td>
					<td valign='top'>".$alamat."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Kota</td>
					<td valign='top'> : </td>
					<td valign='top'>".$kota."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>No Telepon</td>
					<td valign='top'> : </td>
					<td valign='top'>".$telp."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Email</td>
					<td valign='top'> : </td>
					<td valign='top'>".$email."</td>
				</tr>
				<tr>
					<td height='20px' valign='top'>Tgl Masuk</td>
					<td valign='top'> : </td>
					<td valign='top'>".$tgl2."</td>
				</tr>
				
			</table>
			<div style='position:absolute;top:120;right:60;border:solid;border-width:1px;'><img width=95px height=120px src='".$photo."' /></div>
			<br />";
		
		$html.="<span><u><b>&raquo;&nbsp;ANGGOTA KELUARGA :</b></u></span>
			<table style='font-size:11px' border='1' width='100%' cellspacing='0' cellpadding='0'>
				<tr bgcolor='yellow'>
					<th width='30px' height='30px' align='center'>No</th>
					<th align='center'  width='70px'>Hubungan</th>
					<th width='125px' align='center'>Nama</th>
					<th width='125px' align='center'>Tempat, Tgl Lahir</th>
					<th width='80px' align='center'>Agama</th>
					<th width='70px' align='center'>JK</th>
					<th width='40px' align='center'>TTG</th>
				</tr>";
			$keluarga = $this->keluarga->getdata($idkar);
			$a=1;
			foreach($keluarga->result() as $kl) {				
				$t = new DateTime($kl->tgl_lahir); 
				$hari=$t->format('d');
				$bln=$this->bulan($t->format('m'));
				$tahun=$t->format('Y');
				$tgl = $hari." ".$bln." ".$tahun;
				
				if ($kl->tgl_lahir=='1901-01-01') $tgl='';
				
				if ($kl->jk=='L')
					$jk="LAKI-LAKI";
				else
					$jk="PEREMPUAN";
				
				if ($kl->ttg=='Y')
					$ttg="YA";
				else
					$ttg="TIDAK";
				
				$html.="<tr >
							<td height='20px' align='center' valign='top'>".$a."</td>
							<td align='center' valign='top'>".$kl->nama_hubkel."</td>
							<td style='padding-left: 10px;' valign='top'>".$kl->nama_keluarga."</td>
							<td style='padding-left: 10px;' valign='top'>".$kl->tempat_lahir.", ".$tgl."</td>
							<td align='center' valign='top'>".$kl->nama_agama."</td>
							<td align='center' valign='top'>".$jk."</td>
							<td align='center' valign='top'>".$ttg."</td>
						</tr>";
				$a++;
			}
		$html.="</table><br />";
		
		$html.="<span><u><b>&raquo;&nbsp;PENDIDIKAN :</b></u></span>
			<table style='font-size:11px' border='1' width='100%' cellspacing='0' cellpadding='0'>
				<tr bgcolor='yellow'>
					<th width='30px' height='30px' align='center'>No</th>
					<th width='130px' align='center'>Nama Sekolah/<br />Kampus</th>
					<th width='130px' align='center'>Kota</th>
					<th align='center'>Jenjang/<br />Jurusan</th>
					<th width='130px' align='center'>No Ijasah/<br />Tgl Ijasah</th>
				</tr>";
			$pendidikan = $this->pendidikan->getdata($idkar);
			$a=1;
			foreach($pendidikan->result() as $p) {				
				$t = new DateTime($p->tgl_ijasah); 
				$hari=$t->format('d');
				$bln=$this->bulan($t->format('m'));
				$tahun=$t->format('Y');
				$tgl = $hari." ".$bln." ".$tahun;
				
				if ($p->tgl_ijasah=='1901-01-01') $tgl='';
			
				$html.="<tr >
							<td height='20px' align='center' valign='top'>".$a."</td>
							<td style='padding-left: 10px;' valign='top'>".$p->nama_tempat."</td>
							<td style='padding-left: 10px;' valign='top'>".$p->kota."</td>
							<td style='padding-left: 10px;' valign='top'>".$p->nama_jenjang."<br />".$p->jurusan."</td>
							<td align='center' valign='top'>".$p->no_ijasah."<br />".$tgl."</td>
						</tr>";
				$a++;
			}
		$html.="</table><br />";
		$html.="</body></html>";
		
		$mpdf->SetHTMLFooter("<hr /><span style='font-size:9px'><i>Tgl Cetak : ".date('d M Y')." [".date('H:i')."]</i></span>");
		$mpdf->WriteHTML($html);		
	    
		//$mpdf->AddPage();
		$html2="<html><body style='font-family:arial;'>";
		$html2.="<span><u><b>&raquo;&nbsp;PELATIHAN :</b></u></span>
			<table style='font-size:11px' border='1' width='100%' cellspacing='0' cellpadding='0'>
				<tr bgcolor='yellow'>
					<th width='30px' height='30px' align='center'>No</th>
					<th align='center'>Tema Pelatihan</th>
					<th width='170px' align='center'>Penyelenggara</th>
					<th width='130px' align='center'>Kota</th>
					<th width='80px' align='center'>Tahun</th>
				</tr>";
			$pelatihan = $this->pelatihan->getdata($idkar);
			$a=1;
			foreach($pelatihan->result() as $pl) {				
				
				$html2.="<tr >
							<td height='20px' align='center' valign='top'>".$a."</td>
							<td style='padding-left: 10px;' valign='top'>".$pl->tema_pelatihan."</td>
							<td style='padding-left: 10px;' valign='top'>".$pl->penyelenggara."</td>
							<td align='center' valign='top'>".$pl->kota."</td>
							<td align='center' valign='top'>".$pl->tahun."</td>
						</tr>";
				$a++;
			}
		$html2.="</table><br />";
		
		$html2.="<span><u><b>&raquo;&nbsp;PENGALAMAN :</b></u></span>
			<table style='font-size:11px' border='1' width='100%' cellspacing='0' cellpadding='0'>
				<tr bgcolor='yellow'>
					<th width='30px' height='30px' align='center'>No</th>
					<th align='center'>Nama Tempat</th>
					<th width='130px' align='center'>Kota</th>
					<th width='80px' align='center'>Tgl Mulai</th>
					<th width='80px' align='center'>Tgl Selesai</th>
					<th width='150px' align='center'>Jabatan</th>
				</tr>";
			$pelatihan = $this->pengalaman->getdata($idkar);
			$a=1;
			foreach($pelatihan->result() as $pg) {				
				$t = new DateTime($pg->tgl_mulai); 
				$tgl = $t->format('d M Y');
				$t2 = new DateTime($pg->tgl_selesai); 
				$tgl2 = $t2->format('d M Y');
				
				$html2.="<tr >
							<td height='20px' align='center' valign='top'>".$a."</td>
							<td style='padding-left: 10px;' valign='top'>".$pg->nama_tempat."</td>
							<td align='center' valign='top'>".$pg->kota."</td>
							<td align='center' valign='top'>".$tgl."</td>
							<td align='center' valign='top'>".$tgl2."</td>
							<td style='padding-left: 10px;' valign='top'>".$pg->jabatan."</td>
						</tr>";
				$a++;
			}
		$html2.="</table><br />";
		
		$mpdf->WriteHTML($html2);		
		$html2.="</body></html>";
		
        $mpdf->Output('cv'.$idkar.'.pdf','I'); // opens in browser
		
	}
	
	public function xlskaryawan(){
		$this->load->view('vw_xls_karyawan');
	}
}
