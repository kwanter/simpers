<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
$pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
$pdf->SetTitle('Formasi Nomenklatur');
$pdf->SetHeaderMargin(30);
$pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true,35);
$pdf->SetAuthor('PT KKT');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage('L','F4');
$pdf->setJPEGQuality(75);
$no=1;
$table = '
    <p style="font-weight: bold;font-size: 16px">Tabel Formasi Jabatan</p>
    <table border="1" cellspacing="1" cellpadding="1" width="100%">
        <thead>
            <tr>
                <td style="text-align: center;width: 3%;">No.</td>
                <td style="text-align: center;width: 13%;">Nama Jabatan</td>
                <td style="text-align: center;width: 3%;">KJ</td>
                <td style="text-align: center;width: 15%;">Nama Karyawan</td>
                <td style="text-align: center;width: 10%;">NIK</td>
                <td style="text-align: center;width: 15%;">Tugas Jabatan</td>
                <td style="text-align: center;width: 8%;">TMT Jabatan</td>
                <td style="text-align: center;width: 5%;">KJ Berlaku</td>
                <td style="text-align: center;width: 8%;">TMT KJ</td>
                <td style="text-align: center;width: 5%;">Periode</td>
                <td style="text-align: center;width: 5%;">Formasi</td>
                <td style="text-align: center;width: 5%;">Terisi</td>
                <td style="text-align: center;width: 5%;">Selisih</td>
            </tr>
        </thead>
        <tbody>';

        $total_tersedia = 0;
        $total_terisi   = 0;
        $total_selisih  = 0;

        foreach ($data as $column){
            $table .= '
                <tr>
                    <td style="width: 100%;font-weight: bold" colspan="13">'.$column->unit_kerja.'</td>
                </tr>
            ';
            $jumlah_tersedia = 0;
            $jumlah_terisi   = 0;
            $jumlah_selisih  = 0;
            $tmp_jabatan = "";
            foreach ($nomenklatur as $row){
                if($row->unit_kerja == $column->unit_kerja){
                    $table .=  '
                <tr>
                    <td style="text-align: center;width: 3%;">'.$no.'</td>
                    <td style="text-align: center;width: 13%;">'.$row->jabatan.'</td>
                    <td style="text-align: center;width: 3%;">'.trim($row->kelas_jabatan,'KJ').'</td>
                    <td style="text-align: center;width: 15%;">'.$row->nama_karyawan.'</td>
                    <td style="text-align: center;width: 10%;">'.$row->nik.'</td>
                    <td style="text-align: center;width: 15%;">'.$row->tugas_jabatan.'</td>
                    <td style="text-align: center;width: 8%;">'.$row->tmt_jabatan.'</td>
                    <td style="text-align: center;width: 5%;">'.trim($row->kj_berlaku,'KJ').'</td>
                    <td style="text-align: center;width: 8%;">'.$row->tmt_kj.'</td>
                    <td style="text-align: center;width: 5%;">'.$row->periode.'</td>
                    <td style="text-align: center;width: 5%;">'.$row->jumlah_tersedia.'</td>
                    <td style="text-align: center;width: 5%;">'.$row->jumlah_terisi.'</td>
                    <td style="text-align: center;width: 5%;">'.$row->selisih.'</td>
                </tr>';
                    $no++;
                    if($row->jabatan != $tmp_jabatan){
                        $jumlah_tersedia += $row->jumlah_tersedia;
                        $jumlah_terisi   += $row->jumlah_terisi;
                        $jumlah_selisih  += $row->selisih;
                    }
                }
                $tmp_jabatan = $row->jabatan;
            }
            $table.='
                <tr>
                    <td colspan="3" style="font-weight: bold;font-size: 12;text-align: center">Jumlah</td>
                    <td colspan="7"></td>
                    <td style="text-align: center">'.$jumlah_tersedia.'</td>
                    <td style="text-align: center">'.$jumlah_terisi.'</td>
                    <td style="text-align: center">'.$jumlah_selisih.'</td>    
                </tr>';
                $total_terisi   += $jumlah_terisi;
                $total_tersedia += $jumlah_tersedia;
                $total_selisih  += $jumlah_selisih;
        }
        $table.='<tr>
                    <td colspan="3" style="font-weight: bold;font-size: 12;text-align: center">Total</td>
                    <td colspan="7"></td>
                    <td style="text-align: center">'.$total_tersedia.'</td>
                    <td style="text-align: center">'.$total_terisi.'</td>
                    <td style="text-align: center">'.$total_selisih.'</td>    
                </tr>';
$table.='</tbody>
    </table>';
$pdf->SetFont('times', '', 12, '', 'false');
$pdf->writeHTML($table, true, false, true, false, '');
ob_end_clean();
$pdf->Output('nomenklatur_karyawan.pdf', 'I');
exit;
?>
