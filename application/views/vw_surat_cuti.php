<?php
function indonesian_date ($date_format = 'D, j-M-Y',$timestamp = '', $suffix = '') {
        if (trim ($timestamp) == '')
        {
            $timestamp = time ();
        }
        elseif (!ctype_digit ($timestamp))
        {
            $timestamp = strtotime ($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date} {$suffix}";

        return $date;
    }

ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetTitle('Surat Cuti');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
$pdf->SetAuthor('PT Kaltim Kariangau Terminal');
$pdf->SetDisplayMode('real', 'default');
$pdf->SetMargins(16, 20, 14, true);
$pdf->AddPage('P','A4');

$mid_x = 105; // the middle of the "PDF screen", fixed by now.
if($cuti->jenis_cuti == "Cuti Tahunan"){
    $kop2 = "SURAT IJIN CUTI TAHUNAN";
} else if($cuti->jenis_cuti == "Cuti Besar"){
    $kop2 = "SURAT IJIN CUTI BESAR";
} else if($cuti->jenis_cuti == "Cuti Sakit"){
    $kop2 = "SURAT IJIN CUTI SAKIT";
} else if($cuti->jenis_cuti == "Cuti Karena Alasan Penting"){
    $kop2 = "SURAT IJIN CUTI KARENA ALASAN PENTING";
} else if($cuti->jenis_cuti == "Cuti Bersalin"){
    $kop2 = "SURAT IJIN CUTI BERSALIN";
} else{
    $kop2 = "SURAT IJIN CUTI DI LUAR TANGGUNGAN PERSEROAN";
}

$tahun = (new DateTime($cuti->tgl_mulai_cuti))->format('Y');

$pdf->SetFont('times','',12,'',false);
$kop3 = "Nomor : ".$cuti->no_surat_cuti;

$kop_surat = '
    <br><br>
    <table border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td style="text-align: center !important;text-decoration: underline !important;"><strong>'.$kop2.'</strong></td>
        </tr>
        <tr>
            <td style="text-align: center !important;">'.$kop3.'</td>
        </tr>
    </table>
';
$pdf->writeHTML($kop_surat, true, true, true, false, '');
if($cuti->jenis_cuti == 'Cuti Tahunan'){
    $html = '<br><br>
    <table border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td>Diberikan Cuti Tahunan untuk Tahun '.$tahun.' kepada karyawan PT. Kaltim Kariangau Terminal : </td>
        </tr>
    </table>
    <br><br>
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
            <td class="td3"><strong>'.$cuti->nama_karyawan.'</strong></td>
        </tr>
        <tr>
            <td class="td1">NIK </td>
            <td class="td2"> : </td>
            <td class="td3">'.$cuti->nik.'</td>
        </tr>
        <tr>
            <td class="td1">Jabatan/KJ </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->jabatan_terakhir.'/'.$karyawan->kelas_jabatan.'</td>
        </tr>
        <tr>
            <td class="td1">Unit Kerja </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->unit_kerja.'</td>
        </tr>
    </table>';
}else if($cuti->jenis_cuti == 'Cuti Karena Alasan Penting'){
    $html = '<br><br>
    <table border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td>Diberikan Cuti Alasan Penting kepada karyawan PT. Kaltim Kariangau Terminal : </td>
        </tr>
    </table>
    <br><br>
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
            <td class="td3"><strong>'.$cuti->nama_karyawan.'</strong></td>
        </tr>
        <tr>
            <td class="td1">NIK </td>
            <td class="td2"> : </td>
            <td class="td3">'.$cuti->nik.'</td>
        </tr>
        <tr>
            <td class="td1">Jabatan/KJ </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->jabatan_terakhir.'/'.$karyawan->kelas_jabatan.'</td>
        </tr>
        <tr>
            <td class="td1">Unit Kerja </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->unit_kerja.'</td>
        </tr>
    </table>';
}else if($cuti->jenis_cuti == 'Cuti Bersalin'){
    $html = '<br><br>
    <table border="0" cellpadding="1" cellspacing="1">
        <tr>
            <td>Diberikan Cuti Bersalin kepada karyawan PT. Kaltim Kariangau Terminal : </td>
        </tr>
    </table>
    <br><br>
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
            <td class="td3"><strong>'.$cuti->nama_karyawan.'</strong></td>
        </tr>
        <tr>
            <td class="td1">NIK </td>
            <td class="td2"> : </td>
            <td class="td3">'.$cuti->nik.'</td>
        </tr>
        <tr>
            <td class="td1">Jabatan/KJ </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->jabatan_terakhir.'/'.$karyawan->kelas_jabatan.'</td>
        </tr>
        <tr>
            <td class="td1">Unit Kerja </td>
            <td class="td2"> : </td>
            <td class="td3">'.$karyawan->unit_kerja.'</td>
        </tr>
    </table>';
}else{

}
$pdf->SetFont('times', '', 12, '', 'false');
$pdf->writeHTML($html, true, true, true, false, '');

$tgl_awal_cuti = indonesian_date("d F Y", strtotime($cuti->tgl_mulai_cuti),'');
$tgl_akhir_cuti = indonesian_date("d F Y", strtotime($cuti->tgl_selesai_cuti),'');
$tgl_kembali  = indonesian_date("d F Y", strtotime($cuti->tgl_kembali));
if($cuti->jenis_cuti == 'Cuti Tahunan'){
    $html2 = '
        <br>
        <table border="0" cellpadding="1" cellspacing="1">
            <tr>
                <td>Selama '.$cuti->jumlah_cuti.' hari kerja terhitung mulai tanggal '.$tgl_awal_cuti.' s.d '.$tgl_akhir_cuti.' dengan ketentuan sebagai berikut : </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td>a. 
                    <table>
                        <tr>
                            <td>Sebelum menjalankan '.$cuti->jenis_cuti.', wajib menyerahkan pekerjaannya kepada atasan langsung atau kepada pejabat lain yang ditunjuk. </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>b. 
                    <table>
                        <tr>
                            <td>Setelah selesai menjalankan '.$cuti->jenis_cuti.', wajib melaporkan diri kepada atasan langsung dan bekerja kembali sebagaimana mestinya.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>c. 
                    <table>
                        <tr>
                            <td>Adapun tanggal kembali bekerja yaitu pada tanggal '.$tgl_kembali.'.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>Demikian Surat Izin '.$cuti->jenis_cuti.' ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
            </tr>
        </table>';
}elseif($cuti->jenis_cuti == 'Cuti Karena Alasan Penting'){
    $html2 = '
        <br>
        <table border="0" cellpadding="1" cellspacing="1">
            <tr>
                <td>Selama '.$cuti->jumlah_cuti.' hari untuk '.$cuti->alasan_pengajuan.' pada tanggal '.$tgl_awal_cuti.' s.d '.$tgl_akhir_cuti.' dengan ketentuan sebagai berikut : </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td>a. 
                    <table>
                        <tr>
                            <td>Sebelum menjalankan '.$cuti->jenis_cuti.', wajib menyerahkan pekerjaannya kepada atasan langsung atau kepada pejabat lain yang ditunjuk. </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>b. 
                    <table>
                        <tr>
                            <td>Setelah selesai menjalankan '.$cuti->jenis_cuti.', wajib melaporkan diri kepada atasan langsung dan bekerja kembali sebagaimana mestinya.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>Demikian Surat Izin '.$cuti->jenis_cuti.' ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
            </tr>
        </table>';
}elseif($cuti->jenis_cuti == 'Cuti Bersalin'){
    $html2 = '
        <br>
        <table border="0" cellpadding="1" cellspacing="1">
            <tr>
                <td>Terhitung mulai tanggal '.$tgl_awal_cuti.' dengan ketentuan sebagai berikut : </td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td>a. 
                    <table>
                        <tr>
                            <td>Sebelum menjalankan '.$cuti->jenis_cuti.', wajib menyerahkan pekerjaannya kepada atasan langsung atau kepada pejabat lain yang ditunjuk. </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>b. 
                    <table>
                        <tr>
                            <td>Setelah selesai menjalankan '.$cuti->jenis_cuti.', wajib melaporkan diri kepada atasan langsung dan bekerja kembali sebagaimana mestinya.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>c. 
                    <table>
                        <tr>
                            <td>Adapun tanggal kembali bekerja di hitung selama 2 (dua) bulan sejak tanggal persalinan.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>Demikian Surat Izin '.$cuti->jenis_cuti.' ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</td>
            </tr>
        </table>';
}else{

}
$pdf->writeHTML($html2, true, true, true, false, '');

$html3 = '
        <br><br>
        <table width="100%" border="0">
            <tr>
                <td style="text-align: center !important; width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important; width:47.5% !important;">Balikpapan, '.$tanggal.'</td>
            </tr>
            <tr>
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important;width:47.5% !important;"></td>
            </tr>
            <tr>
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important;width:47.5% !important;">'.$ttd->jabatan.', </td>
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
                <td style="width:47.5% !important;"></td>
                <td style="width:5% !important;"></td>
                <td style="width:47.5% !important;"></td>
            </tr>
            <tr>
                <td style="text-align: center !important; text-decoration: underline !important;"width:47.5% !important;""></td>
                <td style="width:5% !important;"></td>
                <td style="text-align: center !important; text-decoration: underline !important;"width:47.5% !important;""><strong>'.$ttd->nama_karyawan.'</strong></td>
            </tr>';
            if($ttd->level != "III"){
                $html3 .= '<tr>
                                    <td style="text-align: center !important;"width:47.5% !important;""></td>
                                    <td style="text-align: center !important;"width:5% !important;""></td>
                                    <td style="text-align: center !important;"width:47.5% !important;""></td>
                                </tr>
                                </table>';
            }else {
                    $html3 .= '<tr>
                                    <td style="text-align: center !important;"width:47.5% !important;""></td>
                                    <td style="text-align: center !important;"width:5% !important;""></td>
                                    <td style="text-align: center !important;"width:47.5% !important;"">NIK. ' . $ttd->nik . '</td>
                                </tr>
                                </table>';
            }
$pdf->writeHTML($html3, true, true, true, false, '');

ob_end_clean();
$pdf->Output('surat_cuti_.pdf', 'I');
exit;
?>
