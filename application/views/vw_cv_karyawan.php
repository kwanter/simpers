<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Curriculum Vitae');
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
       <h4 style="text-align: center">DAFTAR RIWAYAT HIDUP (CURRICULUM VITAE)</h4>
       <h5 style="text-align: center">Posisi Per '.$tanggal.'</h5>
       <h5>A. BIODATA</h5>
       <table border="1" cellpadding="2" cellspacing="1">
            <tr style="border: 0">';

if($biodata['nipp'] != NULL || $biodata['nipp'] != ''){
    $table.=
        '<td width="20%">NIK / NIPP</td>
                <td width="58%">'.$biodata['nik'].' / '.$biodata['nipp'].'</td>';
}
else{
    $table.=
        '<td width="20%">NIK / NIPP</td>
                <td width="58%">'.$biodata['nik'].'</td>';
}

$table.=    '</tr>
            <tr>
                <td>Nama</td>
                <td>'.$biodata['nama_karyawan'].'</td>
            </tr>
            <tr>
                <td>Tempat, Tgl.Lahir</td>
                <td>'.$biodata['tmpt_lahir'].' / '.date('d-m-Y',strtotime($biodata['tgl_lahir'])).'</td>
            </tr>
            <tr>
                <td>Gender / Usia</td>
                <td>'.$biodata['gender'].' / '.$biodata['umur_tahun'].' Tahun, '.$biodata['umur_bulan'].' Bulan</td>
            </tr>
            <tr>
                <td>TMT Calon Pegawai</td>
                <td>'.date('d-m-Y',strtotime($biodata['tmt_calpeg'])).'</td>
            </tr>
            <tr>
                <td>Pend. Formal Calpeg</td>
                <td>'.$biodata['jenjang_pend_calpeg'].' / '.$biodata['jurusan_pend_calpeg'].'</td>
            </tr>
            <tr>
                <td>TMT Peg. Penuh</td>
                <td>'.date('d-m-Y',strtotime($biodata['tmt_peg'])).'</td>
            </tr>
            <tr>
                <td>Jabatan Terakhir</td>
                <td>'.$biodata['jabatan_terakhir'].'</td>
            </tr>
            <tr>
                <td>Kelas Jabatan / Periodik</td>
                <td>'.substr($biodata['kelas_jabatan'],2).' / '.$biodata['periode'].'</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>'.$biodata['unit_kerja'].'</td>
            </tr>
       </table>';
$pdf->SetFont('helvetica', '', 11, '', 'false');
$pdf->writeHTML($table, true, true, true, false, '');

$style = array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(220, 40.6, 285, 40.6, $style);
$pdf->Line(220, 106.8, 285, 106.8, $style);
$pdf->Line(285, 40.6, 285, 106.8, $style);
$pdf->setJPEGQuality(75);
$waktu = (new DateTime($pegawai['last_upload']));
$tahun = $waktu->format('Y');
$bulan = $waktu->format('M');
$link = $pegawai['id_karyawan']."/foto/".$tahun."/".$bulan."/".$pegawai['foto'];
$pas_foto = 'edok/'.$link;
$jenis_foto = $pegawai['type_foto'];
$awal_kelas  = date_create($mk['tgl_berlaku_kj']);
$akhir = date_create();
$diff_kelas  = date_diff($awal_kelas, $akhir);
$awal_jabatan  = date_create($mk['tgl_berlaku']);
$diff_jabatan  = date_diff($awal_jabatan, $akhir);
$pensiun = new DateTime($biodata['tgl_lahir']);
$awal_umur = date_create($biodata['tgl_lahir']);
$umur = date_diff($awal_umur,$akhir);
//$sisa_umur = 56 - $umur->y;
$sisa_umur = 56;
$str_umur = strval($sisa_umur);
$pensiun->add(new DateInterval('P'.$str_umur.'Y'));
$awal_mk  = date_create($biodata['tmt_calpeg']);
$diff_mk  = date_diff($awal_mk, $akhir);
$awal_sk  = date_create($pensiun->format('Y/m/d'));
$diff_sk  = date_diff($awal_sk, $akhir);
$pdf->Image($pas_foto, $pdf->GetX()+226, $pdf->GetY()-67, 40, 55, $jenis_foto, '', '', true, 300, '', false, false, 0, false, false, true);

$html =  '<h5>B. PERHITUNGAN MASA KERJA</h5>
          <table border="1" cellpadding="1" cellspacing="1">
            <tr>
                <td style="text-align: center; background-color: #00aeef;">Kelas Jabatan</td>        
                <td style="text-align: center; background-color: #00aeef;">T.M.T Jabatan</td>
                <td style="text-align: center; background-color: #00aeef;">Lama Menjabat <br>(Thn - Bln)</td>
                <td style="text-align: center; background-color: #00aeef;">Tanggal Lahir</td>
                <td style="text-align: center; background-color: #00aeef;">Umur <br>(Thn - Bln)</td>
                <td style="text-align: center; background-color: #00aeef;">T.M.T Pensiun</td>
                <td style="text-align: center; background-color: #00aeef;">T.M.T Calpeg</td>
                <td style="text-align: center; background-color: #00aeef;">Masa Kerja <br>(Thn - Bln)</td>
                <td style="text-align: center; background-color: #00aeef;">Sisa Masa Kerja <br>(Thn - Bln)</td>
                <td style="text-align: center; background-color: #00aeef;">T.M.T Kelas</td>
                <td style="text-align: center; background-color: #00aeef;">Masa Kelas<br>(Thn - Bln)</td>
            </tr>
            <tr>
                <td style="text-align: center;">'.substr($biodata['kelas_jabatan'],2).'</td>
                <td style="text-align: center;">'.date('d/m/Y',strtotime($mk['tgl_berlaku'])).'</td>
                <td style="text-align: center;">'.$diff_jabatan->y.' / '.$diff_jabatan->m.'</td>
                <td style="text-align: center;">'.date('d/m/Y',strtotime($biodata['tgl_lahir'])).'</td>
                <td style="text-align: center;">'.$biodata['umur_tahun'].' / '.$biodata['umur_bulan'].'</td>
                <td style="text-align: center;">'.$pensiun->format('d/m/Y').'</td>
                <td style="text-align: center;">'.date('d/m/Y',strtotime($biodata['tmt_calpeg'])).'</td>
                <td style="text-align: center;">'.$diff_mk->y.' / '.$diff_mk->m.'</td>
                <td style="text-align: center;">'.$diff_sk->y.' / '.$diff_sk->m.'</td>
                <td style="text-align: center;">'.date('d/m/Y',strtotime($mk['tgl_berlaku_kj'])).'</td>
                <td style="text-align: center;">'.$diff_kelas->y.' - '.$diff_kelas->m.'</td>
            </tr>
           </table>
           <h6>Catatan : Masa Kerja sudah termasuk masa kerja bawaan sebelum diangkat menjadi Calon Pegawai (jika ada).</h6>
           <br>
           <br>';

$html2 =  '<h5>C. DATA PENDIDIKAN FORMAL</h5><br>';
$html3 =  '<table border="1" cellpadding="1" cellspacing="1">
                <tr nobr="true">
                    <td width="3%" style="text-align: center;background-color: #00aeef;">No</td>        
                    <td width="20%" style="text-align: center;background-color: #00aeef;">Nama Pendidikan Formal</td>
                    <td width="27%" style="text-align: center;background-color: #00aeef;">Nama Sekolah</td>
                    <td width="20%" style="text-align: center;background-color: #00aeef;">Jurusan</td>
                    <td width="20%" style="text-align: center;background-color: #00aeef;">Kota Sekolah</td>
                    <td width="9.5%" style="text-align: center;background-color: #00aeef;">Tahun</td>
            </tr>';
$no = 1;
foreach ($pendidikan as $row){
    $html3 .='
                    <tr nobr="true">
                        <td style="text-align: center;">'.$no.'</td>
                        <td style="text-align: center;">'.$row->id_jenjangpendidikan.'</td>
                        <td style="text-align: center;">'.$row->asal_lembaga_pendidikan.'</td>
                        <td style="text-align: center;">'.$row->nama_jurusan.'</td>
                        <td style="text-align: center;">'.$row->asal_kota_lp.'</td>
                        <td style="text-align: center;">'.$row->tgl_kelulusan.'</td>
                    </tr>
                ';
    $no++;
}
$html3 .= '</table>';
$html4 =  '<h5>D. DATA PENDIDIKAN NON FORMAL</h5><br>';
$html5 =  '<table border="1" cellspacing="1" cellpadding="1">
                <tr nobr="true">
                    <td width="3%" style="text-align: center;background-color: #00aeef;">No</td>        
                    <td width="30%" style="text-align: center;background-color: #00aeef;">Nama Pendidikan Non Formal</td>
                    <td width="52%" style="text-align: center;background-color: #00aeef;">Perihal Diklat</td>
                    <td width="15%" style="text-align: center;background-color: #00aeef;">No Sertifikat</td>
            </tr>';
$no = 1;
foreach ($diklat as $row){
    $awal = date_create($row->tgl_mulaidiklat);
    $akhir = date_create($row->tgl_akhirdiklat);
    $diff = date_diff($awal,$akhir);
    $selisih = $diff->days;
    $selisih += 1;

    $html5 .= '
                    <tr nobr="true">
                        <td style="text-align: center;">'.$no.'</td>
                        <td style="text-align: left;">'.$row->jenis_diklat.'</td>
                        <td style="text-align: left;"><b><i>'
        .$row->tema_diklat.'</i></b><br>Lokasi : <b>'.$row->lokasi.'</b>, Penyelenggara : <b>'.$row->penyelenggara.'</b><br>'.
        'Tgl Mulai : <b>'.$awal->format('d/m/Y').'</b>, Tgl Akhir : <b>'.$akhir->format('d/m/Y').'</b>, Day : <b>'.$selisih.' Hari</b>'.
        '</td>
                        <td style="text-align: center;">'.$row->no_sertifikat.'</td>
                    </tr>
                ';
    $no++;
}
$html5 .='</table>';
$html6 = '<h5>E. RIWAYAT JABATAN</h5><br>';
$html7 = '<table border="1" cellspacing="1" cellpadding="1">
        <tr nobr="true">
            <th rowspan="2" width="3%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">No</th>        
            <th rowspan="2" width="20%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">Nama Jabatan</th>
            <th colspan="4" width="62%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">Penetapan / Surat Keputusan</th>
            <th rowspan="2" width="15%" style="text-align: center;background-color: #00aeef;">Lama Menjabat</th>
         </tr>
         <tr nobr="true">
            <th width="5%" style="text-align: center;background-color: #00aeef;">KJ</th>
            <th width="10%" style="text-align: center;background-color: #00aeef;">TMT</th>
            <th width="10%" style="text-align: center;background-color: #00aeef;">Selesai</th>
            <th width="15%" style="text-align: center;background-color: #00aeef;">Nomor</th>
            <th width="21.9%" style="text-align: center;background-color: #00aeef;">Unit Kerja</th>
     </tr>';
$no = 1;
$max = count($jabatan);

for($i=0;$i<$max;$i++){
    $next = $jabatan[$i+1];
    $lama_jabatan = '';

    if($next != NULL){
        $awal  = date_create($jabatan[$i]['tgl_berlaku']);
        $akhir = date_create($jabatan[$i]['tgl_selesai']);
        $lama_jabatan = date_diff($awal,$akhir);
    }
    else{
        $awal  = date_create($jabatan[$i]['tgl_berlaku']);
        $akhir = date_create();
        $lama_jabatan = date_diff($awal,$akhir);
    }

    $tgl_selesai = date('d/m/Y',strtotime($jabatan[$i]['tgl_selesai']));

    if($tgl_selesai == '01/01/1970')
        $tgl_selesai = '';

    if($lama_jabatan->y == 0){
        $html7 .='
                <tr>
                    <td style="text-align: center">'.$no.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['tugas_jabatan'].'</td>
                    <td style="text-align: center">'.substr($jabatan[$i]['kelas_jabatan'],2).'</td>
                    <td style="text-align: center">'.date('d/m/Y',strtotime($jabatan[$i]['tgl_berlaku'])).'</td>
                    <td style="text-align: center">'.$tgl_selesai.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['no_surat'].'</td>
                    <td style="text-align: center">'.$jabatan[$i]['unit_kerja'].'</td>
                    <td style="text-align: center">'.$lama_jabatan->m.' Bulan</td>
                </tr>
            ';
    } else if($lama_jabatan->m == 0){
        $html7 .='
                <tr>
                    <td style="text-align: center">'.$no.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['tugas_jabatan'].'</td>
                    <td style="text-align: center">'.substr($jabatan[$i]['kelas_jabatan'],2).'</td>
                    <td style="text-align: center">'.date('d/m/Y',strtotime($jabatan[$i]['tgl_berlaku'])).'</td>
                    <td style="text-align: center">'.$tgl_selesai.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['no_surat'].'</td>
                    <td style="text-align: center">'.$jabatan[$i]['unit_kerja'].'</td>
                    <td style="text-align: center">'.$lama_jabatan->y.' Tahun</td>
                </tr>
            ';
    }
    else{
        $html7 .='
                <tr>
                    <td style="text-align: center">'.$no.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['tugas_jabatan'].'</td>
                    <td style="text-align: center">'.substr($jabatan[$i]['kelas_jabatan'],2).'</td>
                    <td style="text-align: center">'.date('d/m/Y',strtotime($jabatan[$i]['tgl_berlaku'])).'</td>
                    <td style="text-align: center">'.$tgl_selesai.'</td>
                    <td style="text-align: center">'.$jabatan[$i]['no_surat'].'</td>
                    <td style="text-align: center">'.$jabatan[$i]['unit_kerja'].'</td>
                    <td style="text-align: center">'.$lama_jabatan->y.' Tahun '.$lama_jabatan->m.' Bulan</td>
                </tr>
            ';
    }


    $no++;
}
$html7 .= '</table>';
$html8 = '<h5>F. DATA KELUARGA</h5><br>';
$html9 = '<table border="1" cellspacing="1" cellpadding="1">
                <tr nobr="true">
                    <td width="3%" style="text-align: center;background-color: #00aeef;">No</td>        
                    <td width="25%" style="text-align: center;background-color: #00aeef;">Nama</td>
                    <td width="15%" style="text-align: center;background-color: #00aeef;">Tempat Lahir</td>
                    <td width="12%" style="text-align: center;background-color: #00aeef;">Tanggal Lahir</td>
                    <td width="9%" style="text-align: center;background-color: #00aeef;">Jenis Kelamin</td>
                    <td width="17%" style="text-align: center;background-color: #00aeef;">Pekerjaan</td>
                    <td width="19%" style="text-align: center;background-color: #00aeef;">Keterangan</td>
           </tr>';
$no = 1;
foreach ($keluarga as $row){
    if($row->jenis_kelamin == 'W')
        $jk = 'WANITA';
    else
        $jk = 'PRIA';
    $html9 .='
                    <tr nobr="true">
                        <td style="text-align: center;">'.$no.'</td>
                        <td style="text-align: center;">'.$row->nama_keluarga.'</td>
                        <td style="text-align: center;">'.$row->tmpt_lahir.'</td>
                        <td style="text-align: center;">'.date('d/m/Y',strtotime($row->tgl_lahir)).'</td>
                        <td style="text-align: center;">'.$jk.'</td>
                        <td style="text-align: center;">'.$row->pekerjaan.'</td>
                        <td style="text-align: center;">'.$row->desc_hubungan.'</td>
                    </tr>
                ';
    $no++;
}
$html9 .=' </table>';
$pdf->SetFont('helvetica', '', 11, '', 'false');
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->AddPage('L','A4');
$pdf->writeHTML($html2,true,false,true,false,'');
$pdf->SetFont('helvetica', '', 10, '', 'false');
$pdf->writeHTML($html3,true,false,true,false,'');
$pdf->SetFont('helvetica', '', 11, '', 'false');
$pdf->writeHTML($html4,true,false,true,false,'');
$pdf->SetFont('helvetica', '', 10, '', 'false');
$pdf->writeHTML($html5,true,false,true,false,'');
$pdf->AddPage('L','A4');
$pdf->SetFont('helvetica', '', 11, '', 'false');
$pdf->writeHTML($html6,true,false,true,false,'');
$pdf->SetFont('helvetica', '', 10, '', 'false');
$pdf->writeHTML($html7,true,false,true,false,'');
$pdf->AddPage('L','A4');
$pdf->SetFont('helvetica', '', 11, '', 'false');
$pdf->writeHTML($html8,true,false,true,false,'');
$pdf->SetFont('helvetica', '', 10, '', 'false');
$pdf->writeHTML($html9,true,false,true,false,'');

ob_end_clean();
$pdf->Output('cv_.pdf', 'I');
exit;
?>
