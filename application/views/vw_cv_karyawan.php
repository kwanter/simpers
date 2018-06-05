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
$pdf->Image('pictures/logo_kkt.jpg', 10, 15, 32, 16, 'jpg', '', '', false, 300, '', false, false, 0, false, false, false);
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
                <td>'.substr($biodata['kelas_jabatan'],14).' / '.$biodata['periode'].'</td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>'.$biodata['unit_kerja'].'</td>
            </tr>
       </table>';
$pdf->writeHTML($table, true, true, true, false, '');
$style = array('width' => 0.7, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(220, 42.7, 285, 42.7, $style);
$pdf->Line(220, 113.25, 285, 113.25, $style);
$pdf->Line(285, 42.7, 285, 113.25, $style);
$pdf->setJPEGQuality(75);
$pas_foto = 'pictures/'.$pegawai['foto'];
$jenis_foto = $pegawai['type_foto'];
$awal_kelas  = date_create($mk['tgl_berlaku_kj']);
$akhir = date_create();
$diff_kelas  = date_diff($awal_kelas, $akhir);
$awal_jabatan  = date_create($mk['tgl_berlaku']);
$diff_jabatan  = date_diff($awal_jabatan, $akhir);
$pensiun = new DateTime($biodata['tgl_lahir']);
$sisa_umur = 56 - $umur->y;
$str_umur = strval($sisa_umur);
$pensiun->add(new DateInterval('P'.$str_umur.'Y'));
$awal_mk  = date_create($biodata['tmt_calpeg']);
$diff_mk  = date_diff($awal_mk, $akhir);
$awal_sk  = date_create($pensiun->format('d/m/Y'));
$diff_sk  = date_diff($awal_sk, $akhir);
$awal_umur = date_create($biodata['tgl_lahir']);
$umur = date_diff($awal_umur,$akhir);
$pdf->Image($pas_foto, 232.4, 47, 46.5, 62, $jenis_foto, '', '', true, 300, '', false, false, 0, false, false, true);
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
                <td style="text-align: center;">'.substr($biodata['kelas_jabatan'],14).'</td>
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
$html2 =  '<h5>C. DATA PENDIDIKAN FORMAL</h5>
           <table border="1" cellpadding="1" cellspacing="1">
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
                $html2.='
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
$html2 .=  '</table>
            <br>
            <h5>D. DATA PENDIDIKAN NON FORMAL</h5>
            <table border="1" cellspacing="1" cellpadding="1">
                <tr nobr="true">
                    <td width="3%" style="text-align: center;background-color: #00aeef;">No</td>        
                    <td width="16%" style="text-align: center;background-color: #00aeef;">Nama Pendidikan Non Formal</td>
                    <td width="16%" style="text-align: center;background-color: #00aeef;">Tema Diklat</td>
                    <td style="text-align: center;background-color: #00aeef;">Mulai</td>
                    <td style="text-align: center;background-color: #00aeef;">Selesai</td>
                    <td width="5%" style="text-align: center;background-color: #00aeef;">Day</td>
                    <td width="13%" style="text-align: center;background-color: #00aeef;">Lokasi</td>
                    <td width="13%" style="text-align: center;background-color: #00aeef;">Penyelenggara</td>
                    <td style="text-align: center;background-color: #00aeef;">No Sertifikat</td>
                </tr>';
            $no = 1;
            foreach ($diklat as $row){
                $awal = date_create($row->tgl_mulaidiklat);
                $akhir = date_create($row->tgl_akhirdiklat);
                $diff = date_diff($awal,$akhir);
                $html2 .= '
                    <tr nobr="true">
                        <td style="text-align: center;">'.$no.'</td>
                        <td style="text-align: center;">'.$row->jenis_diklat.'</td>
                        <td style="text-align: center;">'.$row->tema_diklat.'</td>
                        <td style="text-align: center;">'.date('d/m/Y',strtotime($row->tgl_mulaidiklat)).'</td>
                        <td style="text-align: center;">'.date('d/m/Y',strtotime($row->tgl_akhirdiklat)).'</td>
                        <td style="text-align: center;">'.$diff->days.'</td>
                        <td style="text-align: center;">'.$row->lokasi.'</td>
                        <td style="text-align: center;">'.$row->penyelenggara.'</td>
                        <td style="text-align: center;">'.$row->no_sertifikat.'</td>
                    </tr>
                ';
                $no++;
            }
$html2 .= '</table>
    <br>
    <h5>E. RIWAYAT JABATAN</h5>
    <table border="1" cellspacing="1" cellpadding="1">
        <tr nobr="true">
            <th rowspan="2" width="3%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">No</th>        
            <th rowspan="2" width="40%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">Nama Jabatan</th>
            <th colspan="4" width="56.5%" style="text-align: center; vertical-align : middle; background-color: #00aeef;">Penetapan / Surat Keputusan</th>
         </tr>
         <tr nobr="true">
            <th width="5%" style="text-align: center;background-color: #00aeef;">KJ</th>
            <th width="11.5%" style="text-align: center;background-color: #00aeef;">TMT</th>
            <th width="20%" style="text-align: center;background-color: #00aeef;">Nomor</th>
            <th width="20%" style="text-align: center;background-color: #00aeef;">Unit Kerja</th>
         </tr>
         ';
        $no = 1;
        foreach ($jabatan as $row){
            $html2.='
                <tr>
                    <td style="text-align: center">'.$no.'</td>
                    <td style="text-align: center">'.$row->nama_jabatan.'</td>
                    <td style="text-align: center">'.substr($row->kelas_jabatan,14).'</td>
                    <td style="text-align: center">'.date('d/m/Y',strtotime($row->tgl_berlaku)).'</td>
                    <td style="text-align: center">'.$row->no_surat.'</td>
                    <td style="text-align: center">'.$row->unit_kerja.'</td>
                </tr>
            ';
            $no++;
        }
$html2.= '</table>';
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->AddPage('L','A4');
$pdf->writeHTML($html2,true,false,false,false,'');
$html3 = '<br>
            <h5>F. DATA KELUARGA</h5>
            <table border="1" cellspacing="1" cellpadding="1">
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
    $html3.='
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
$html3 .=' </table>';
$pdf->writeHTML($html3,true,false,false,false,'');
ob_end_clean();
$pdf->Output('cv_.pdf', 'I');
exit;
?>
