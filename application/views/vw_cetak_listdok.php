    <?php
 

    /* setting zona waktu */
    date_default_timezone_set('Asia/Makassar');
    $this->fpdf->FPDF("P","cm","A4");

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
	
    $this->fpdf->Cell(18,0.6,'LEMBAR VERIFIKASI',0,0,'C');
	//Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
	
	/* Fungsi Line untuk membuat garis border halaman */
	//Line(float x1, float y1, float x2, float y2)	
	/*
	$this->fpdf->Line(0.5,0.5,29,0.5);//top
	$this->fpdf->Line(0.5,0.5,0.5,20);//left
	$this->fpdf->Line(29,0.5,29,20);//rigth
	$this->fpdf->Line(0.5,20,29,20);//bottom
	
	$this->fpdf->Line(11.3,1.7,17.75,1.7);
	$this->fpdf->Line(11.3,1.75,17.75,1.75);
	*/
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
	
	/*
	$uid=$this->session->userdata('uid');
		if (!$idkar=='') 
			$query = $this->db->query("select * from vw_biokaryawan where id_karyawan='".$idkar."'");
		else
			$query = $this->db->query("select * from vw_biokaryawan where user_id='".$uid."'");
		*/	
	$query = $this->db->query("select * from vw_permohonan where id_permohonan=".$id);
	
		//$query = $this->db->query("select * from bio_karyawan where user_id='".$uid."'");
		foreach ($query->result_array() as $row)
		{
			$nama=$row['nama_pekerjaan']."  [".$row['kode_permohonan']."]";
			$rekanan=$row['nama_rekanan'];
			$klasifikasi=$row['nama_klasifikasi'];
			$divisi=$row['singkat'];
		}
	

	
	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
    $wdtlabel=3.2;
	$wdtseparator=0.3;
	$wdtdata=10.5;
	$height=0.65;
	$border=0;
		
	$this->fpdf->Cell($wdtlabel,$height,'Nama Pekerjaan',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$nama,$border,0,'L');
	$this->fpdf->Ln();
	//$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	
	$this->fpdf->Cell($wdtlabel,$height,'Nama Perusahaan',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$rekanan,$border,0,'L');
	$this->fpdf->Ln();
	//$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	
	$this->fpdf->Cell($wdtlabel,$height,'Klasifikasi/Divisi',$border,0,'L');
	$this->fpdf->Cell($wdtseparator,$height,':',$border,0,'C');
	$this->fpdf->Cell($wdtdata,$height,$klasifikasi." / ".$divisi,$border,0,'L');
	$this->fpdf->Ln();
	//$this->fpdf->Line(1.5,$this->fpdf->GetY(),10,$this->fpdf->GetY());
	
	//HEADER TABLE
	$this->fpdf->SetFont('helvetica','B',8);
	$this->fpdf->Cell(1,0.5,'No',1,0,'C');
	
	$this->fpdf->Cell(5,0.5,'Nomor',1,0,'C');
	$this->fpdf->Cell(2,0.5,'Tanggal',1,0,'C');
	$this->fpdf->Cell(1,0.5,'ADA',1,0,'C');
	$this->fpdf->Cell(9,0.5,'Nama Dokumen',1,0,'C');
	$this->fpdf->Ln();
	$this->fpdf->SetFont('helvetica','',8);
	
	$query = $this->db->query("select * from vw_permohonan_dok where id_permohonan=".$id);
	/*
	foreach ($query->result_array() as $row)
	{
		$idkaryawan=$row['id_karyawan'];	
	}
	
	if (!$idkar=='') 
		$query = $this->db->query("SELECT * from vw_rwypendidikan where id_karyawan='".$idkar."' order by ordernum");
	else
		$query = $this->db->query("SELECT * from vw_rwypendidikan where id_karyawan='".$idkaryawan."' order by ordernum");
	*/	
	
	
	if ($query->num_rows() > 0)
	{	
		$a=1;
		foreach ($query->result() as $dokumen)
		{				
			$tgl='';
			if ($dokumen->tgl!=''){
				$tgldok = new DateTime($dokumen->tgl); 
				$tgl=$tgldok->format('d M y');
			}
			
			$this->fpdf->Cell(1,0.5,$a,0,0,'C');
			
			if ($dokumen->is_available=='Y')
				$ada='YA';
			else
				$ada='TDK';
			
			$this->fpdf->Cell(5,0.5,$dokumen->nodok,0,0,'C');
			$this->fpdf->Cell(2,0.5,$tgl,0,0,'C');
			$this->fpdf->Cell(1,0.5,$ada,0,0,'C');
			
			if ($dokumen->stat=='W')
				$this->fpdf->MultiCell(9,0.5,$dokumen->nama_dokumen,0,'L');
			else
				$this->fpdf->MultiCell(9,0.5,$dokumen->nama_dokumen."  [opsional]",0,'L');
			//$this->fpdf->Ln();
			
			$this->fpdf->Line(1.5,$this->fpdf->GetY(),19.5,$this->fpdf->GetY());
			
			$a++;
		}
	}

	$this->fpdf->Ln();$this->fpdf->Ln();
	
	$this->fpdf->SetFont('Times','B',10);
    $this->fpdf->Cell(13,0.8,'Verifikator Dokumen,',0,0,'C');
	
	$this->fpdf->SetFont('Times','',9);
	$this->fpdf->Ln();$this->fpdf->Ln();
	
	$this->fpdf->Cell(2,0.8,'',0,0,'L');
	$this->fpdf->Cell(7.5,0.8,'1. Pelaksana Senior Adm Keuangan & Perbendaharaan',0,0,'L');
	$this->fpdf->Cell(3,0.8,'...................',0,0,'L');
	$this->fpdf->Ln();$this->fpdf->Ln();
	
	$this->fpdf->Cell(2,0.8,'',0,0,'L');
	$this->fpdf->Cell(7.5,0.8,'2. Pelaksana Senior Perpajakan',0,0,'L');
	$this->fpdf->Cell(3,0.8,'...................',0,0,'L');
	
    
    $this->fpdf->Output("isidok.pdf","I");
    ?>