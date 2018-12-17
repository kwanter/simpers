<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('./vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nomenklatur extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data['uker'] = $this->divisi->get_uker();
        $data['kj'] = $this->kelasjabatan->getNamaKJ();
        $this->navmenu('Input Data Nomenklatur','vw_input_data_nomenklatur','','',$data);
    }

    public function edit($id){
        $data['uker'] = $this->divisi->get_uker();
        $data['nomenklatur'] = $this->nomenklatur->getData($id);
        $data['nama'] = $this->nomenklatur->getAtasanName($id);
        $data['kj'] = $this->kelasjabatan->getNamaKJ();
        $this->navmenu('Edit Data Nomenklatur','vw_edit_data_nomenklatur','','',$data);
    }

    public function delete($id){
        $this->nomenklatur->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_list(){
        $uker = $this->db->escape_str($this->input->post('uker'));
        $list = $this->nomenklatur->get_datatable($uker);
        $caption = $this->db->escape_str($this->input->post('uker'));
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $jabatan) {
            $no++;
            $separator = $this->nomenklatur->countJabatan($jabatan->id_parent,'>');
            $row = array();
            $row[] = '<p style="font-size: small" title="'.$jabatan->job_title.'">'.$jabatan->jabatan;
            $row[] = '<center style="font-size: small">'.trim($jabatan->kelas_jabatan,'KJ');
            $row[] = '<center style="font-size: small">'.$jabatan->jumlah_tersedia;
            $row[] = '<center style="font-size: small">'.$jabatan->jumlah_nomenklatur_terisi;
            $row[] = '<center style="font-size: small">'.$jabatan->selisih;
            //add html for action
            $row[] = '<center><a href="javascript:void(0)" title="Edit" onclick="edit('."'".$jabatan->id_nomenklatur."'".')"><i class="material-icons">launch</i></a>
                              <a class="js-sweetalert waves-effect" data-type="confirm" href="javascript:void(0)" title="Hapus" onclick="del('."'".$jabatan->id_nomenklatur."'".')"><i class="material-icons">delete_forever</i></a>
                              ';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->nomenklatur->countAllUker($uker),
            "recordsFiltered" => $this->nomenklatur->countFilteredUker($uker),
            "caption" => $caption,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $result = $this->nomenklatur->saveData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Ditambahkan , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a>
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Ditambahkan..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->index();
    }

    public function updateData()
    {
        $id = $this->input->post('id_nomenklatur');
        $result = $this->nomenklatur->updateData($_POST);

        if ($result)
            $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert"> Data Berhasil Di Update , <a href="javascript:void(0)" title="Kembali Ke Halaman Depan" onclick="master();"> Kembali...</a><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        else
            $this->session->set_flashdata('notif',
                '<div class="alert alert-danger" role="alert"> Data Gagal Di Update..Silahkan Periksa Kembali Inputan Anda 
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                       </div>');

        $this->edit($id);
    }

    public function getAtasan($id){
        $search = $this->input->post('search');
        $data = $this->nomenklatur->getAtasan($id,$search);
        if(isset($search)){
            if(count($data) > 0){
                foreach ($data as $row) {
                    $arr_result[] = array(
                        'label'     => $row->jabatan,
                        'parent'    => $row->id_nomenklatur,
                    );
                }
                echo json_encode($arr_result);
            }
        }
    }

    public function excel(){
        $object = new Spreadsheet();
        $date = (new DateTime(''))->format('d-M-Y');
        $filename = 'nomenklatur_'.$date;

        $result = $this->nomenklatur->getDataLaporan();
        $data = $this->nomenklatur->getCountUker();
        // Create new PHPExcel object
        $style_title = array(
            'alignment' => array(
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        );
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        );
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                )
            )
        );
        $font_title = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 14,
                'name'  => 'Times New Roman'
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A5:AB6")->applyFromArray($styleArray);
        $object->getActiveSheet()->getStyle("A1:A2")->applyFromArray($style_title);
        $object->getActiveSheet()->getStyle("A5:AB6")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A5:AB6")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:A2")->applyFromArray($font_title);
        $object->getActiveSheet()->getStyle('A5:AB6')->getAlignment()->setWrapText(true);

        $object->getActiveSheet()->mergeCells('A1:J1');
        $object->getActiveSheet()->mergeCells('A2:J2');
        $object->getActiveSheet()->mergeCells('A3:J3');
        $object->getActiveSheet()->mergeCells('A4:J4');
        $object->getActiveSheet()->mergeCells('A5:A6');
        $object->getActiveSheet()->mergeCells('B5:F6');
        $object->getActiveSheet()->mergeCells('G5:G6');
        $object->getActiveSheet()->mergeCells('H5:H6');
        $object->getActiveSheet()->mergeCells('I5:K6');
        $object->getActiveSheet()->mergeCells('L5:L6');
        $object->getActiveSheet()->mergeCells('M5:N6');
        $object->getActiveSheet()->mergeCells('O5:O6');
        $object->getActiveSheet()->mergeCells('P5:P6');
        $object->getActiveSheet()->mergeCells('Q5:Q6');
        $object->getActiveSheet()->mergeCells('R5:R6');
        $object->getActiveSheet()->mergeCells('S5:S6');
        $object->getActiveSheet()->mergeCells('T5:T6');
        $object->getActiveSheet()->mergeCells('U5:U6');
        $object->getActiveSheet()->mergeCells('V5:V6');
        $object->getActiveSheet()->mergeCells('W5:W6');
        $object->getActiveSheet()->mergeCells('X5:X6');
        $object->getActiveSheet()->mergeCells('Y5:Y6');
        $object->getActiveSheet()->mergeCells('Z5:Z6');
        $object->getActiveSheet()->mergeCells('AA5:AA6');
        $object->getActiveSheet()->mergeCells('AB5:AB6');

        // Set properties
        // Add some data
        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $object->getActiveSheet()->getColumnDimension('G')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('H')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $object->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $object->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('P')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('Q')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('R')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('S')->setWidth(12);
        $object->getActiveSheet()->getColumnDimension('T')->setWidth(12);
        $object->getActiveSheet()->getColumnDimension('U')->setWidth(12);
        $object->getActiveSheet()->getColumnDimension('V')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('W')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('X')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('Y')->setWidth(9);
        $object->getActiveSheet()->getColumnDimension('Z')->setWidth(14);
        $object->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $object->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
        $object->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $object->getActiveSheet()->getRowDimension('2')->setRowHeight(30);

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NAMA JABATAN, KELAS JABATAN DAN FORMASI JABATAN KARYAWAN')
            ->setCellValue('A2', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A3', '')
            ->setCellValue('A4', '')
            ->setCellValue('A5', 'No')
            ->setCellValue('B5', 'NAMA JABATAN')
            ->setCellValue('G5', 'KJ')
            ->setCellValue('H5', 'PJTK')
            ->setCellValue('I5', 'NAMA KARYAWAN')
            ->setCellValue('L5', 'NIK')
            ->setCellValue('M5', 'TUGAS JABATAN')
            ->setCellValue('O5', 'TMT JABATAN')
            ->setCellValue('P5', 'KJ BERLAKU')
            ->setCellValue('Q5', 'TMT KJ')
            ->setCellValue('R5', 'PERIODE')
            ->setCellValue('S5', 'FORMASI')
            ->setCellValue('T5', 'TERISI')
            ->setCellValue('U5', 'SELISIH')
            ->setCellValue('V5', 'PENDIDIKAN')
            ->setCellValue('W5', 'TEMPAT LAHIR')
            ->setCellValue('X5', 'TANGGAL LAHIR')
            ->setCellValue('Y5', 'UMUR (Tahun)')
            ->setCellValue('Z5', 'SISA MASA KERJA (Tahun)')
            ->setCellValue('AA5', 'TMT PENSIUN')
            ->setCellValue('AB5', 'SK JABATAN')
        ;
        $no=0;
        $no_utama = 0;
        //add data
        $counter=7;

        foreach($data as $count){
            $no_utama++;
            $romawi = $this->Romawi($no_utama);
            $ex = $object->setActiveSheetIndex(0);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($styleArray);
            $object->getActiveSheet()->mergeCells('A'.$counter.':AB'.$counter);
            $ex->setCellValue("A".$counter,"$romawi. $count->unit_kerja");
            $counter++;
            $total   = 0;
            $terisi  = 0;
            $selisih = 0;

            foreach($result as $row){
                if($row->unit_kerja == $count->unit_kerja){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($styleArray);
                $object->getActiveSheet()->getStyle("C".$counter.":AB".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter.":AB".$counter)->applyFromArray($styleArray);
                $ex->setCellValue("A".$counter,"$no");
                $object->getActiveSheet()->mergeCells('B'.$counter.':F'.$counter);
                $separator = $this->nomenklatur->countParent($row->id_parent,'>');
                $ex->setCellValue("B".$counter,"$row->jabatan");
                $kj = trim($row->kelas_jabatan,'KJ');
                $ex->setCellValue("G".$counter,"$kj");
                $total += $row->jumlah_tersedia;
                $ex->setCellValue("H".$counter,"");
                $object->getActiveSheet()->mergeCells('I'.$counter.':K'.$counter);
                $ex->setCellValue("I".$counter,"$row->nama_karyawan");
                $ex->setCellValue("L".$counter,"$row->nik");
                $object->getActiveSheet()->mergeCells('M'.$counter.':N'.$counter);
                $ex->setCellValue("M".$counter,"$row->tugas_jabatan");

                if($row->tmt_jabatan == '' || $row->tmt_jabatan == NULL)
                    $tmt_jabatan = '';
                else
                    $tmt_jabatan = (new DateTime($row->tmt_jabatan))->format('d-m-Y');

                $ex->setCellValue("O".$counter,"$tmt_jabatan");
                $kj_berlaku = trim($row->kj_berlaku,'KJ');
                $ex->setCellValue("P".$counter,"$kj_berlaku");

                if($row->tmt_kj == '' || $row->tmt_kj == NULL)
                    $tmt_kj = '';
                else
                    $tmt_kj = (new DateTime($row->tmt_kj))->format('d-m-Y');

                $ex->setCellValue("Q".$counter,"$tmt_kj");
                $ex->setCellValue("R".$counter,"$row->periode");
                $ex->setCellValue("S".$counter,"$row->jumlah_tersedia");
                $ex->setCellValue("T".$counter,"$row->jumlah_terisi");
                $terisi += $row->jumlah_terisi;
                $ex->setCellValue("U".$counter,"$row->selisih");
                $selisih += $row->selisih;
                $ex->setCellValue("V".$counter,"$row->jenjang_pendidikan $row->jurusan");
                $ex->setCellValue("W".$counter,"$row->tmpt_lahir");
                $tanggal_lahir = (new DateTime($row->tgl_lahir))->format('d-m-Y');

                if($row->tgl_lahir == NULL || $row->tgl_lahir == '')
                    $tanggal_lahir = '';

                $ex->setCellValue("X".$counter,"$tanggal_lahir");
                $ex->setCellValue("Y".$counter,"$row->umur");
                $sisa_masa_kerja = (56 - (int)$row->umur);

                if($sisa_masa_kerja == 56){
                    $sisa_masa_kerja = '';
                }else{
                    $tmt_pensiun = (new DateTime())->add(new DateInterval('P'.$sisa_masa_kerja.'Y'));
                }

                $ex->setCellValue("Z".$counter,"$sisa_masa_kerja");

                if($sisa_masa_kerja == NULL || $sisa_masa_kerja == '')
                    $pensiun = '';
                else
                    $pensiun = $tmt_pensiun->format('d-m-Y');

                $ex->setCellValue("AA".$counter,"$pensiun");
                $ex->setCellValue("AB".$counter,"$row->no_surat");
                $counter=$counter+1;
                }
            }

            $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($styleArray);
            $object->getActiveSheet()->mergeCells('A'.$counter.':G'.$counter);
            $ex->setCellValue("A".$counter,"Total");
            $object->getActiveSheet()->mergeCells('H'.$counter.':R'.$counter);
            $ex->setCellValue("S".$counter,"$total");
            $ex->setCellValue("T".$counter,"$terisi");
            $ex->setCellValue("U".$counter,"$selisih");
            $object->getActiveSheet()->mergeCells('V'.$counter.':AB'.$counter);
            $counter = $counter+1;
            $total_seluruh += $total;
            $selisih_seluruh += $selisih;
            $terisi_seluruh += $terisi;
        }

        $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A".$counter.":AB".$counter)->applyFromArray($styleArray);
        $object->getActiveSheet()->mergeCells('A'.$counter.':G'.$counter);
        $ex->setCellValue("A".$counter,"Total Keseluruhan");
        $object->getActiveSheet()->mergeCells('H'.$counter.':R'.$counter);
        $ex->setCellValue("S".$counter,"$total_seluruh");
        $ex->setCellValue("T".$counter,"$terisi_seluruh");
        $ex->setCellValue("U".$counter,"$selisih_seluruh");
        $object->getActiveSheet()->mergeCells('V'.$counter.':AB'.$counter);
        $object->getActiveSheet()->getStyle('A'.$counter.':AB'.$counter)->getAlignment()->setWrapText(true);

        // Rename sheet
        $object->getActiveSheet()->setTitle('Formasi_Jabatan');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($object);
        ob_end_clean();
        $writer->save('php://output'); // download file
    }

    public function pdf(){
        $data['data'] = $this->nomenklatur->getCountUker();
        $data['nomenklatur'] = $this->nomenklatur->getDataLaporan();
        $this->load->view('vw_pdf_karyawan',$data);
    }
}

?>
