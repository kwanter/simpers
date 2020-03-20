<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetTitle('Permohonan Cuti');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
$pdf->SetAuthor('PT Kaltim Kariangau Terminal');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('P','A4');

$mid_x = 105; // the middle of the "PDF screen", fixed by now.

$pdf->SetFont('times','',12,'',false);
$kop2 = "Balikpapan, ".$tanggal;
$pdf->Text(105, 12, $kop2);
$kop3 = "K e p a d  a";
$pdf->Text(105, 22, $kop3);
$kop4 = "Yth.     ".$cuti->jabatan_pejabat_wewenang;
$pdf->Text(92, 32, $kop4);
$kop7 = "PT. KALTIM KARIANGAU TERMINAL";
$pdf->Text(105, 37, $kop7);
$kop8 = "di";
$pdf->Text(105, 42, $kop8);
$kop9 = "Balikpapan";
$pdf->Text(105, 52, $kop9);

$pdf->SetFont('times','',12,'',false);
$isi = "Yang bertanda tangan dibawah ini : ";
$pdf->Text(10, 62, $isi);

$html = '<br><br><br>
    <style type="text/css">
        .td1 {
            width : 25% !important;
            text-align  : left !important;
        }  
        .td2 {
            width : 5% !important;
            text-align  : center !important;
        }  
        .td3 {
            width : 70% !important;
            text-align  : left !important;
        }
    </style>
    <table border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td class="td1">Nama </td>
            <td class="td2"> : </td>
            <td class="td3">'.$cuti->nama_karyawan.'</td>
        </tr>
        <tr>
            <td class="td1">NIK </td>
            <td class="td2"> : </td>
            <td class="td3">'.$cuti->nik.'</td>
        </tr>
        <tr>
            <td class="td1">Jabatan/Posisi </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->jabatan_terakhir.'</td>
        </tr>
        <tr>
            <td class="td1">Unit Kerja </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->unit_kerja.'</td>
        </tr>
    </table>';
    
$pdf->SetFont('times', '', 12, '', 'false');
$pdf->writeHTML($html, true, true, true, false, '');
$tgl_awal_cuti = date("d-m-Y", strtotime($cuti->tgl_mulai_cuti));
$tgl_akhir_cuti = date("d-m-Y", strtotime($cuti->tgl_selesai_cuti));
$html2 = '
        <table cellspacing="2">
            <tr>
                <td>Dengan ini mengajukan permintaan '.$cuti->jenis_cuti.' selama '.$cuti->jumlah_cuti.' hari kerja, 
                    terhitung mulai tanggal '.$tgl_awal_cuti.' s.d '.$tgl_akhir_cuti.'.</td>
            </tr>
            <tr>
                <td>Selama menjalankan cuti alamat saya adalah di '.$cuti->kota_cuti.' dan nomor telepon yang dapat dihubungi adalah '.$data->no_hp.'</td>
            </tr>
            <tr>
                <td>Demikian permintaan cuti ini saya buat mohon pertimbangan selanjutnya</td>
            </tr>
        </table>
';
$pdf->writeHTML($html2, true, true, true, false, '');

$html3 = '
        <br>
        <table width="100%" border="0">
            <tr>
                <td style="text-align: center !important; width:47.5% !important;">Yang Menerima Pekerjaan,</td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important; width:47.5% !important;">Hormat saya,</td>
            </tr>
            <tr>
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="width:47.5% !important;"></td>
            </tr>
            <tr>
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="width:47.5% !important;"></td>
            </tr>
            <tr>
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="width:47.5% !important;"></td>
            </tr>
            <tr>
                <td style="text-align: center !important; text-decoration: underline !important;"width:47.5% !important;"">'.$cuti->nama_karyawan_pengganti.'</td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important; text-decoration: underline !important;"width:47.5% !important;"">'.$cuti->nama_karyawan.'</td>
            </tr>
            <tr>
                <td style="text-align: center !important;"width:47.5% !important;"">'.$cuti->nik_pengganti.'</td>
                <td style="text-align: center !important;"width:5% !important;""></td>
                <td style="text-align: center !important;"width:47.5% !important;"">'.$cuti->nik.'</td>
            </tr>
        </table>
';
$pdf->writeHTML($html3, true, true, true, false, '');
if($cuti->jenis_cuti != "Cuti Tahunan")
    $karyawan->sisa_cuti = "";

$html4 = '<br>
<style>
    .firstLine td{
       border-bottom: 1px solid black;
    }
</style>
<table border="1">
    <tr>
        <td>
            <table border="0">
                <tr>
                    <td>Catatan Pejabat Kepegawaian : </td>
                </tr>
                <tr>
                    <td>Cuti yang telah dilaksanakan</td>
                </tr>
                <tr>
                    <td>dalam tahun yang bersangkutan : </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <table border="0">
                <tr>
                    <td style="width:5% !important;"></td>
                    <td style="width:60% !important;">Sisa Cuti Tahun Berjalan</td>
                    <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$karyawan->sisa_cuti.'</td>
                    <td style="width:25% !important;"> hari</td>
                </tr>
                <tr>';
                    if($cuti->jenis_cuti == "Cuti Tahunan") {
                        $html4 .= '<tr>
                            <td style="width:5% !important;">1.</td>
                            <td style="width:60% !important;">Cuti Tahunan </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$cuti->jumlah_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .= '<tr>
                            <td style="width:5% !important;">1.</td>
                            <td style="width:60% !important;">Cuti Tahunan </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    if($cuti->jenis_cuti == "Cuti Besar") {
                        $html4 .='<tr>
                            <td style="width:5% !important;">2.</td>
                            <td style="width:60% !important;">Cuti Besar </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$cuti->jumlah_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .='<tr>
                            <td style="width:5% !important;">2.</td>
                            <td style="width:60% !important;">Cuti Besar </td>
                            <td style="width:10% !important; text-align : center !important;">:</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    if($cuti->jenis_cuti == "Cuti Sakit") {
                        $html4 .='<tr>
                            <td style="width:5% !important;">3.</td>
                            <td style="width:60% !important;">Cuti Sakit </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$cuti->jumlah_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .='<tr>
                            <td style="width:5% !important;">3.</td>
                            <td style="width:60% !important;">Cuti Sakit </td>
                            <td style="width:10% !important; text-align : center !important;">:</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    if($cuti->jenis_cuti == "Cuti Bersalin") {
                        $html4 .='<tr>
                            <td style="width:5% !important;">4.</td>
                            <td style="width:60% !important;">Cuti Bersalin </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$cuti->jumlah_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .='<tr>
                            <td style="width:5% !important;">4.</td>
                            <td style="width:60% !important;">Cuti Bersalin </td>
                            <td style="width:10% !important; text-align : center !important;">:</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    if($cuti->jenis_cuti == "Cuti Karena Alasan Penting") {
                        $html4 .='<tr>
                            <td style="width:5% !important;">5.</td>
                            <td style="width:60% !important; text-decoration: underline !important;">Cuti Karena Alasan Penting </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$cuti->jumlah_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .='<tr>
                            <td style="width:5% !important;">5.</td>
                            <td style="width:60% !important; text-decoration: underline !important;">Cuti Karena Alasan Penting </td>
                            <td style="width:10% !important; text-align : center !important;">:</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    if($cuti->jenis_cuti == "Cuti Tahunan") {
                        $sisa_cuti = $karyawan->sisa_cuti - $cuti->jumlah_cuti;
                        $html4 .='<tr>
                            <td style="width:5% !important;"></td>
                            <td style="width:60% !important;">Sisa Cuti </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;'.$sisa_cuti.'</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }else{
                        $html4 .='<tr>
                            <td style="width:5% !important;"></td>
                            <td style="width:60% !important;">Sisa Cuti </td>
                            <td style="width:10% !important; text-align : center !important;">: &nbsp;&nbsp;</td>
                            <td style="width:25% !important;"> hari</td>
                        </tr>';
                    }

                    $html4 .='</table>
                </tr>
            </table>
        </td>
        <td>
            <table border="0">
                <tr>
                    <td style="text-align:center !important;">
                        Catatan/Pertimbangan Atasan Langsung : <br><br>
                        '.$cuti->jabatan_pejabat_menyetujui.'
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                 <tr>
                    <td></td>
                </tr>
                 <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:center !important;text-decoration: underline !important;">'.$cuti->pejabat_menyetujui.'</td>
                </tr>
                <tr class="firstLine">
                    <td style="text-align:center !important;">'.$cuti->nik_pejabat_setuju.'</td>
                </tr>

                <tr>
                    <td style="text-align:center !important;">
                    Keputusan Pejabat yang berwenang memberikan cuti <br>
                        '.$cuti->jabatan_pejabat_wewenang.'
                    </td>
                </tr>
                 <tr>
                    <td></td>
                </tr>
                 <tr>
                    <td></td>
                </tr>
                 <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:center !important;text-decoration: underline !important;">'.$cuti->pejabat_berwenang.'</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';

$pdf->writeHTML($html4, true, true, true, false, '');
ob_end_clean();
$pdf->Output('formulir_cuti_.pdf', 'I');
exit;
?>
