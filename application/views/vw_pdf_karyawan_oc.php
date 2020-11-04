<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Rekap Data Karyawan OC PT. Kaltim Kariangau Terminal');
//$pdf->SetHeaderMargin(30);
$pdf->SetTopMargin(20);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true,35);
$pdf->SetAuthor('PT KKT');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L','A4');
//Logo KKT
$pdf->setJPEGQuality(75);
$pdf->Image('edok/logo_kkt.jpg', 10, 15, 32, 16, 'jpg', '', '', false, 300, '', false, false, 0, false, false, false);
$table='
        <br><br><br>
       <h4 style="text-align: center">DAFTAR KARYAWAN OUTSOURCING</h4>
       <br><br>
       <table border="1" cellpadding="2" cellspacing="1">
            <tr>
                <td width="3%">No</td>
                <td width="14%">Nama</td>
                <td width="15%">Tempat, Tgl.Lahir</td>
                <td width="10%">No Handphone</td>
                <td width="10%">Jenis Kelamin</td>
                <td width="12%">Pendidikan</td>
                <td width="13%">Nama Jabatan</td>
                <td width="13%">Nama PJTK</td>
                <td width="10%">TMT Kontrak</td>
            </tr>';
$no = 0;
foreach($data as $karyawan){
    $no++;
    $table .= '<tr>';
    $table .= '<td>'.$no.'</td>';
    $table .= '<td>'.$karyawan->nama.'</td>';
    $table .= '<td>'.$karyawan->tmpt_lahir.', '.$karyawan->tgl_lahir.'</td>';
    $table .= '<td>'.$karyawan->no_hp.'</td>';
    $table .= '<td>'.$karyawan->jenis_kelamin.'</td>';
    $table .= '<td>'.$karyawan->jurusan.'</td>';
    $table .= '<td>'.$karyawan->jabatan.'</td>';
    $table .= '<td>'.$karyawan->pjtk.'</td>';
    $table .= '<td>'.$karyawan->tmt_kontrak.'</td>';
    $table .= '</tr>';
}
$table .='</table>';

$pdf->SetFont('helvetica', '', 9, '', 'false');
$pdf->writeHTML($table, true, false, true, false, '');
ob_end_clean();
$pdf->Output('cv_.pdf', 'I');
exit;
?>
