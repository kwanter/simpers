<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=mkaryawan.xls");
 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
}
h3 {
	font-size: 18px;
}
</style>
</head>

<body>

<h3>DAFTAR KARYAWAN : 
<?php
echo "<br />Per Tanggal : ".date('d M Y');
$query = $this->db->query("select * from vw_mkaryawan");
?>
</h3>

<table border="1" cellspacing="0" cellpadding="0" style="font-size:12px;">
    <tr>
		<td align="center" valign="middle" bgcolor="#CCCCCC">No</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Wilayah</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Nama Karyawan</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Tempat Lahir</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Tgl Lahir</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">JK</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Status</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Agama</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Uker</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Jabatan</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">St. Pegawai</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Pendidikan</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Jurusan</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">NIK</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">No KTP</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">NPWP</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">No BPJS Kes</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">No BPJS TK</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Tgl Masuk</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Telp</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Email</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Alamat</td>
		<td align="center" valign="middle" bgcolor="#CCCCCC">Kota</td>
      </tr>
    <?php
	$a=1;
	if ($query->num_rows() > 0)
	{
	   foreach ($query->result() as $r)
	   {
		$t = new DateTime($r->tgl_lahir); 
		$tgl =$t->format('d M Y');
		if($r->tgl_lahir=='1900-01-01') $tgl='';
		
		$t2 = new DateTime($r->tgl_masuk); 
		$tgl2=$t2->format('d M Y');
		if($r->tgl_masuk=='1900-01-01') $tgl2='';
	?>
    
    <tr valign="top">
      <td align="center" style="padding-left:5px;padding-right:5px"><?php echo $a;?></td>
      <td align="center" style="padding-left:5px;padding-right:5px" ><?php echo $r->lokasi;?></td>
      <td style="padding-left:10px;padding-right:5px;"><?php echo $r->nama_karyawan;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->tempat_lahir;?></td>
      <td align="center" ><?php echo $tgl;?></td>
	  <td align="center" ><?php echo $r->jk;?></td>
      <td align="center" ><?php echo $r->status."/".$r->jml_anak;?></td>
	  <td align="center" ><?php echo $r->nama_agama;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->nama_uker;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->jabatan;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->status2;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->nama_jenjang;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->pend_jurusan;?></td>
	  <td align="center" >'<?php echo $r->nik;?></td>
	  <td align="center" >'<?php echo $r->noktp;?></td>
	  <td align="center" >'<?php echo $r->npwp;?></td>
	  <td align="center" >'<?php echo $r->nobpjs_kes;?></td>
	  <td align="center" >'<?php echo $r->nobpjs_tk;?></td>
	  <td align="center" ><?php echo $tgl2;?></td>
	  <td align="center" >'<?php echo $r->telp;?></td>
	  <td align="center" ><?php echo $r->email;?></td>
	  <td style="padding-left:10px;padding-right:5px;"><?php echo $r->alamat;?></td>
	  <td align="center" ><?php echo $r->kota;?></td>
      </tr>
    <?php

		$a++;
	  }
	}
	?>
  </table>

</body>
</html>