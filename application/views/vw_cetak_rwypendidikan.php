    <?php
    /*
    *
    * @author M.Fadli Prathama (09081003031)
    * email : m.fadliprathama@gmail.com
    *
    */

    /* setting zona waktu */
    date_default_timezone_set('Asia/Jakarta');
    $this->fpdf->FPDF("L","cm","A4");

    //SetMargins(float left, float top [, float right])
	$this->fpdf->SetMargins(1.5,1,1);

    $this->fpdf->AliasNbPages();

    // AddPage merupakan fungsi untuk membuat halaman baru
    $this->fpdf->AddPage();

    // Setting Font : String Family, String Style, Font size
    $this->fpdf->SetFont('Times','B',14);

    /* Kita akan membuat header dari halaman pdf yang kita buat
    ————– Header Halaman dimulai dari baris ini —————————–
    */
	
    $this->fpdf->Cell(26,0.8,'RIWAYAT PENDIDIKAN',0,0,'C');
	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
	
	/* Fungsi Line untuk membuat garis border halaman */
	//Line(float x1, float y1, float x2, float y2)	
	$this->fpdf->Line(0.5,0.5,29,0.5);//top
	$this->fpdf->Line(0.5,0.5,0.5,20);//left
	$this->fpdf->Line(29,0.5,29,20);//rigth
	$this->fpdf->Line(0.5,20,29,20);//bottom
	
	$this->fpdf->Line(11.3,1.7,17.75,1.7);
	$this->fpdf->Line(11.3,1.75,17.75,1.75);

    // fungsi Ln untuk membuat baris baru
    $this->fpdf->Ln();

    $this->fpdf->Ln();
	
    /*Setting ulang Font : String Family, String Style, Font size
    kenapa disetting ulang ???
    jika tidak disetting ulang, ukuran font akan mengikuti settingan sebelumnya.
    tetapi karena kita menginginkan settingan untuk penulisan alamatnya berbeda,
    maka kita harus mensetting ulang Font nya.
    jika diatas settingannya : helvetica, 'B', '12'
    khusus untuk penulisan alamat, kita setting : helvetica, ", 10
    yang artinya string stylenya normal / tidak Bold dan ukurannya 10
    */
    $this->fpdf->SetFont('helvetica','',9);
	
	$uid=$this->session->userdata('uid');
		if (!$idkar=='') 
			$query = $this->db->query("select * from vw_biokaryawan where id_karyawan='".$idkar."'");
		else
			$query = $this->db->query("select * from vw_biokaryawan where user_id='".$uid."'");
			
	
		//$query = $this->db->query("select * from bio_karyawan where user_id='".$uid."'");
		foreach ($query->result_array() as $row)
		{
		   
		   	$pjtk=$row['nama_pjtk'];
			$jabatan=$row['jabatan_pjtk'];
			$nama=$row['nama_karyawan'];
			$noktp=$row['no_ktp'];
			$tmplahir=$row['tmp_lahir'];
	
			$tgldok = new DateTime($row['tgl_lahir']); 
			$tgl=$tgldok->format('d');
			//$bln=$tgldok->format('M');
			if($tgldok->format('m')=='01') $bln='JANUARI';
			if($tgldok->format('m')=='02') $bln='FEBRUARI';
			if($tgldok->format('m')=='03') $bln='MARET';
			if($tgldok->format('m')=='04') $bln='APRIL';
			if($tgldok->format('m')=='05') $bln='MEI';
			if($tgldok->format('m')=='06') $bln='JUNI';
			if($tgldok->format('m')=='07') $bln='JULI';
			if($tgldok->format('m')=='08') $bln='AGUSTUS';
			if($tgldok->format('m')=='09') $bln='SEPTEMBER';
			if($tgldok->format('m')=='10') $bln='OKTOBER';
			if($tgldok->format('m')=='11') $bln='NOPEMBER';
			if($tgldok->format('m')=='12') $bln='DESEMBER';
			$thn=$tgldok->format('Y');
			
			if ($row['jns_kelamin']=='P') $jnskelamin='PRIA';
			if ($row['jns_kelamin']=='W') $jnskelamin='WANITA';
			
			if ($row['agama']=='I') $agama='ISLAM';
			if ($row['agama']=='K') $agama='KATOLIK';
			if ($row['agama']=='P') $agama='PROTESTAN';
			if ($row['agama']=='H') $agama='HINDU';
			if ($row['agama']=='B') $agama='BUDHA';
			
			if ($row['stat_nikah']=='N') $status='MENIKAH';
			if ($row['stat_nikah']=='B') $status='BELUM MENIKAH';
			
			if ($row['pendidikan_akhir']=='SD') $pendidikan='SD';
			if ($row['pendidikan_akhir']=='SMP') $pendidikan='SMP/SLTP';
			if ($row['pendidikan_akhir']=='SMA') $pendidikan='SMA/SMK';
			if ($row['pendidikan_akhir']=='D1') $pendidikan='DIPLOMA-1';
			if ($row['pendidikan_akhir']=='D2') $pendidikan='DIPLOMA-2';
			if ($row['pendidikan_akhir']=='D3') $pendidikan='DIPLOMA-3';
			if ($row['pendidikan_akhir']=='D4') $pendidikan='DIPLOMA-4';
			if ($row['pendidikan_akhir']=='S1') $pendidikan='STRATA-1';
			if ($row['pendidikan_akhir']=='S2') $pendidikan='STRATA-2';
			if ($row['pendidikan_akhir']=='S3') $pendidikan='STRATA-3';
			
			$jurusan=$row['jurusan'];
			$nilai=$row['nilai_ijasah'];
			$alamat=$row['alamat'];
			$kota=$row['kota'];
			$telepon=$row['telepon'];
			$email=$row['email'];
			$ayah=$row['nama_ayah'];
			$ibu=$row['nama_ibu'];
			$userid=$row['user_id'];
			$photourl=base_url()."photo/".$row['photo_url'];
		}
	

	
	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
    $wdtlabel=3.2;
	$wdtseparator=0.3;
	$wdtdata=10.5;
	$height=0.7;
	$border=0;
		
	$this->fpdf->Cell($wdtlabel,$height,'Nama Karyawan',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$nama,$border,0,'L');
	$this->fpdf->Ln();
	$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	
	$this->fpdf->Cell($wdtlabel,$height,'User ID',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$userid,$border,0,'L');
	$this->fpdf->Ln();
	$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	
	$this->fpdf->Cell($wdtlabel,$height,'Tempat, Tgl. Lahir',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$tmplahir.", ".$tgl." ".$bln." ".$thn,$border,0,'L');
	$this->fpdf->Ln();
	$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	$this->fpdf->Ln();
	
	//HEADER TABLE
	$this->fpdf->SetFont('helvetica','B',8);
	$this->fpdf->Cell(1,0.5,'No',1,0,'C');
	$this->fpdf->Cell(2,0.5,'Level',1,0,'C');
	$this->fpdf->Cell(8,0.5,'Nama Sekolah/Universitas/PT',1,0,'C');
	$this->fpdf->Cell(7,0.5,'Jurusan/Peminatan',1,0,'C');
	$this->fpdf->Cell(5,0.5,'No Ijasah',1,0,'C');
	$this->fpdf->Cell(2.2,0.5,'Nilai Ijasah/IPK',1,0,'C');
	$this->fpdf->Cell(2,0.5,'Periode',1,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->SetFont('helvetica','',8);
	//get id_karyawan
	$uid=$this->session->userdata('uid');
	$query = $this->db->query("select * from bio_karyawan where user_id='".$uid."'");
	foreach ($query->result_array() as $row)
	{
		$idkaryawan=$row['id_karyawan'];	
	}
	
	if (!$idkar=='') 
		$query = $this->db->query("SELECT * from vw_rwypendidikan where id_karyawan='".$idkar."' order by ordernum");
	else
		$query = $this->db->query("SELECT * from vw_rwypendidikan where id_karyawan='".$idkaryawan."' order by ordernum");
			
	
	
	if ($query->num_rows() > 0)
	{	
		$a=1;
		foreach ($query->result() as $dokumen)
		{				
			$pendidikan=$dokumen->level_name;
						
			$this->fpdf->Cell(1,0.5,$a,0,0,'C');
			$this->fpdf->Cell(2,0.5,$pendidikan,0,0,'C');
			$this->fpdf->Cell(8,0.5,$dokumen->nama_lembaga,0,0,'L');
			$this->fpdf->Cell(7,0.5,$dokumen->jurusan,0,0,'L');
			$this->fpdf->Cell(5,0.5,$dokumen->nomor_ijasah,0,0,'C');
			$this->fpdf->Cell(2.2,0.5,$dokumen->nilai_ijasah,0,0,'C');
			$this->fpdf->Cell(2,0.5,$dokumen->thn_mulai." - ".$dokumen->thn_selesai,0,0,'C');
			$this->fpdf->Ln();
			$this->fpdf->Cell(1,0.5,'',0,0,'C');
			$this->fpdf->Cell(2,0.5,'',0,0,'C');
			$this->fpdf->Cell(8,0.5,$dokumen->kota,0,0,'L');
			$this->fpdf->Cell(7,0.5,$dokumen->peminatan,0,0,'L');
			$this->fpdf->Ln();
			$this->fpdf->Cell(1,0.5,'',0,0,'C');
			$this->fpdf->Cell(2,0.5,'',0,0,'C');
			$this->fpdf->MultiCell(24,0.5,"Judul TA/Skripsi/Tesis/Disertasi : ".$dokumen->judul_ta,0,'L');
			$this->fpdf->Line(1.5,$this->fpdf->GetY(),28.7,$this->fpdf->GetY());
			
			$a++;
		}
	}
	
	

	$this->fpdf->Ln();
	$this->fpdf->MultiCell(25,0.5,'Saya yang bertanda tangan di bawah ini menyatakan bahwa data di atas adalah benar dan sesuai dengan dokumen pendukungnya. Serta, saya bertanggung jawab jika terdapat kekeliruan atas data tersebut.',0,'L');
    //$this->fpdf->Ln();
	$this->fpdf->Cell(18,$height,'',$border,0,'L');
	
	if(date('m')=='01') $blnprint='Januari';
	if(date('m')=='02') $blnprint='Februari';
	if(date('m')=='03') $blnprint='Maret';
	if(date('m')=='04') $blnprint='April';
	if(date('m')=='05') $blnprint='Mei';
	if(date('m')=='06') $blnprint='Juni';
	if(date('m')=='07') $blnprint='Juli';
	if(date('m')=='08') $blnprint='Agustus';
	if(date('m')=='09') $blnprint='September';
	if(date('m')=='10') $blnprint='Oktober';
	if(date('m')=='11') $blnprint='Nopember';
	if(date('m')=='12') $blnprint='Desember';
    $this->fpdf->Cell(5,$height,'Balikpapan, '.date('d')." ".$blnprint." ".date('Y'),$border,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->Cell(18,$height,'',$border,0,'L');
    $this->fpdf->Cell(5,$height,'Tertanda,',$border,0,'C');
	$this->fpdf->Ln();$this->fpdf->Ln();$this->fpdf->Ln();
	$this->fpdf->Cell(18,$height,'',$border,0,'L');
	$this->fpdf->SetFont('helvetica','UB',9);
    $this->fpdf->Cell(5,$height,$nama,$border,0,'C');
	$this->fpdf->Ln();
  

    
    $this->fpdf->Output("rwypendidikan.pdf","I");
    ?>