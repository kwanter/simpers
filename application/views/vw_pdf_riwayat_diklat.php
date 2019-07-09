<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
$pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
$pdf->SetTitle('Diklat Karyawan');
//$pdf->SetHeaderMargin(30);
//$pdf->setFooterMargin(20);
$pdf->setPrintHeader(false);
// get the current page break margin.
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode.
$auto_page_break = $pdf->getAutoPageBreak();
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
$pdf->SetAuthor('PT KKT');
$pdf->SetMargins(12, 5, 12, true);
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L','F4');
$no=1;
$table = '
    <p style="font-weight: bold;text-align: center;">LAPORAN PELAKSANAAN PELATIHAN DAN PENDIDIKAN KARYAWAN</p>
    <p style="font-weight: bold;text-align: center;">PT KALTIM KARIANGAU TERMINAL</p>
    <table border="1" cellspacing="1" cellpadding="1" width="100%">
        <thead>
            <tr>
                <th style="text-align: center;vertical-align : middle !important;width:2%" rowspan="2">NO</th>
                <th style="text-align: center;vertical-align : middle !important;width:10%" rowspan="2">NAMA KARYAWAN</th>
                <th style="text-align: center;vertical-align : middle !important;width:14%" colspan="2">TANGGAL PELATIHAN & PENDIDIKAN</th>
                <th style="text-align: center;vertical-align : middle !important;width:6%" rowspan="2">JUMLAH HARI</th>
                <th style="text-align: center;vertical-align : middle !important;width:40%" rowspan="2">TEMA</th>
                <th style="text-align: center;vertical-align : middle !important;width:20%" rowspan="2">PENYELENGGARA</th>
                <th style="text-align: center;vertical-align : middle !important;width:8%" rowspan="2">NILAI</th>
            </tr>
            <tr>
                <th style="text-align: center;width:7%">MULAI</th>
                <th style="text-align: center;width:7%">SELESAI</th>
            </tr>
        </thead>
        <tbody>';
        $no = 0;
        $temp_nama = '';
        foreach ($diklat as $row){  
            if($row->nama_karyawan != $temp_nama){
                $no++;
                $temp_nama = $row->nama_karyawan;
                $table .= '<tr>
                    <td style="text-align: center;vertical-align : middle !important;width:2%">'.$no.'</td>
                    <td style="text-align: center;vertical-align : middle !important;width:10%">'.$row->nama_karyawan.'</td>';
            } else{
                $table .= '<tr>
                    <td style="text-align: center;vertical-align : middle !important;width:2%"></td>
                    <td style="text-align: center;vertical-align : middle !important;width:10%"></td>';
            }
            $tgl_mulai = new DateTime($row->tgl_mulaidiklat);
            $tgl_akhir = new DateTime($row->tgl_akhirdiklat);
            $temp_tgl  = $tgl_akhir->add(new DateInterval('P1D'));
            $selisih   = $tgl_mulai->diff($temp_tgl);
            $tmp_day   = new DateInterval('P1D');
            $tmp_day->invert = 1;
            $tgl_akhir = $temp_tgl->add($tmp_day); 
            $table .= 
               '<td style="text-align: center;vertical-align : middle !important;width:7%">'.$tgl_mulai->format('d M Y').'</td>
                <td style="text-align: center;vertical-align : middle !important;width:7%">'.$tgl_akhir->format('d M Y').'</td>
                <td style="text-align: center;vertical-align : middle !important;width:6%">'.$selisih->format('%a hari').'</td>
                <td style="text-align: justify;vertical-align : middle !important;width:40%">'.$row->tema_diklat.'</td>
                <td style="text-align: center;vertical-align : middle !important;width:20%">'.$row->penyelenggara.'</td>
                <td style="text-align: center;vertical-align : middle !important;width:8%">'.$row->nilai.'</td>
            </tr>';
        }
$table .='</tbody></table>';
$pdf->SetFont('times', '', 7, '', 'false');
$pdf->writeHTML($table, true, false, true, false, '');
ob_end_clean();
$pdf->Output('riwayat_diklat_karyawan.pdf', 'I');
exit;
?>
