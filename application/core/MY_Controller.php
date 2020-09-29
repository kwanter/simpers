<?php
//error_reporting(0);
//ini_set('display_errors', 0);
if (isset($_SERVER["HTTP_ORIGIN"]) === true) {
	$origin = $_SERVER["HTTP_ORIGIN"];
	$allowed_origins = array(
		"http://localhost/simpers",
        "https://localhost/simpers",
        "http://192.168.19.21/simpers",
        "https://192.168.19.21/simpers",
        "http://dev.kkt/simpers",
        "https://dev.kkt/simpers"
	);
	if (in_array($origin, $allowed_origins, true) === true) {
		header('Access-Control-Allow-Origin: ' . $origin);
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Methods: POST');
		header('Access-Control-Allow-Headers: Content-Type');
	}
	if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
		exit; // OPTIONS request wants only the policy, we can stop here
	}
}

date_default_timezone_set("Asia/Makassar");
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    var $md5_key = '#PTKKT#';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_pegawai','pegawai');
        $this->load->model('M_main','main');
        $this->load->model('M_kelasjabatan','kelasjabatan');
        $this->load->model('M_tunjangan','tunjangan');
        $this->load->model('M_nomenklatur','nomenklatur');
        $this->load->model('M_uker','divisi');
        $this->load->model('M_keluarga','keluarga');
        $this->load->model('M_pendidikan','pendidikan');
        $this->load->model('M_jabatan','jabatan');
        $this->load->model('M_diklat','diklat');
        $this->load->model('M_dokumen','dokumen');
        $this->load->model('M_cuti','cuti');
        $this->load->library('email');
    }

    public function imageThumbnail($source_path,$target_path) {
       $config_manip = array(
           'image_library' => 'gd2',
           'source_image' => $source_path,
           'new_image' => $target_path,
           'maintain_ratio' => TRUE,
           'create_thumb' => TRUE,
           'thumb_marker' => '_thumb',
           'width' => 150,
           'height' => 150
       );
 
 
       $this->load->library('image_lib', $config_manip);
       if (!$this->image_lib->resize()) {
           echo $this->image_lib->display_errors();
       }
 
 
       $this->image_lib->clear();
    }

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

    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,2,',','.');
        return $hasil_rupiah;
    }

    function convert_number_to_words($number) {
   
        $hyphen      = '-';
        $conjunction = '  ';
        $separator   = ' ';
        $negative    = 'negative ';
        $decimal     = ' point ';

        $dictionary = array(
            0 => 'Nol',
            1 => 'satu',
            2 => 'dua',
            3 => 'tiga',
            4 => 'empat',
            5 => 'lima',
            6 => 'enam',
            7 => 'tujuh',
            8 => 'delapan',
            9 => 'sembilan',
            10 => 'sepuluh',
            11 => 'sebelas',
            12 => 'dua belas',
            13 => 'tiga belas',
            14 => 'empat belas',
            15 => 'lima belas',
            16 => 'enam belas',
            17 => 'tujuh belas',
            18 => 'delapan belas',
            19 => 'sembilan belas',
            20 => 'dua puluh',
            30 => 'tiga puluh',
            40 => 'empat puluh',
            50 => 'lima puluh',
            60 => 'enam puluh',
            70 => 'tujuh puluh',
            80 => 'delapan puluh',
            90 => 'sembilan puluh',
            100 => 'seratus',
            1000 => 'seribu',
            1000000 => 'sejuta',
            1000000000 => 'semiliar',
        );
        /*
        $dictionary  = array(
            0                   => 'Zero',
            1                   => 'One',
            2                   => 'Two',
            3                   => 'Three',
            4                   => 'Four',
            5                   => 'Five',
            6                   => 'Six',
            7                   => 'Seven',
            8                   => 'Eight',
            9                   => 'Nine',
            10                  => 'Ten',
            11                  => 'Eleven',
            12                  => 'Twelve',
            13                  => 'Thirteen',
            14                  => 'Fourteen',
            15                  => 'Fifteen',
            16                  => 'Sixteen',
            17                  => 'Seventeen',
            18                  => 'Eighteen',
            19                  => 'Nineteen',
            20                  => 'Twenty',
            30                  => 'Thirty',
            40                  => 'Fourty',
            50                  => 'Fifty',
            60                  => 'Sixty',
            70                  => 'Seventy',
            80                  => 'Eighty',
            90                  => 'Ninety',
            100                 => 'Hundred',
            1000                => 'Thousand',
            1000000             => 'Million',
            1000000000          => 'Billion',
            1000000000000       => 'Trillion',
            1000000000000000    => 'Quadrillion',
            1000000000000000000 => 'Quintillion'
        );*/
       
        if (!is_numeric($number)) {
            return false;
        }
       
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
     
        if ($number < 0) {
            return $negative .'ke'. convert_number_to_words(abs($number));
        }
       
        $string = $fraction = null;
       
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
       
        switch (true) {
            case $number == 1:
                $string = 'pertama';
                break;
            case $number > 1 && $number < 21:
                $string = 'ke'.$dictionary[$number];
                break;
            case $number > 1 && $number > 21 && $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = 'ke'.$dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number > 1 && $number > 21 && $number > 100 && $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = 'ke'.$dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = 'Ke'.convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }
       
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
       
        return $string;
    }

    public function navmenu($title,$page,$err='',$info='',$attr=''){
        $data['title']=$title;
        $data['err']=$err;
        $data['info']=$info;
        $data['attr']=$attr;

        $this->load->template($page,$data);
    }

    public function ceksesi(){
        if($this->session->has_userdata('uid','sesi')){
            $uid = $this->session->userdata('uid');
            $sesi = $this->session->userdata('sesi');
            $role = $this->session->userdata('unit');
            $level = $this->session->userdata('level');
            $result = $this->cekUser($uid,$sesi,$role,$level);

            if ($result == FALSE) {
                $this->logout();
            }
        }
    }

    public function cekUser($uid,$sesi,$role,$level){
        $result = $this->admin->cekUID($uid,$sesi,$role,$level);
        return $result;
    }

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public function Romawi($angka)
    {
        $hsl = "";
        if ($angka < 1 || $angka > 5000) {
            // Statement di atas buat nentuin angka ngga boleh dibawah 1 atau di atas 5000
            $hsl = "Batas Angka 1 s/d 5000";
        } else {
            while ($angka >= 1000) {
                // While itu termasuk kedalam statement perulangan
                // Jadi misal variable angka lebih dari sama dengan 1000
                // Kondisi ini akan di jalankan
                $hsl .= "M";
                // jadi pas di jalanin , kondisi ini akan menambahkan M ke dalam
                // Varible hsl
                $angka -= 1000;
                // Lalu setelah itu varible angka di kurangi 1000 ,
                // Kenapa di kurangi
                // Karena statment ini mengambil 1000 untuk di konversi menjadi M
            }
        }
        if ($angka >= 500) {
            // statement di atas akan bernilai true / benar
            // Jika var angka lebih dari sama dengan 500
            if ($angka > 500) {
                if ($angka >= 900) {
                    $hsl .= "CM";
                    $angka -= 900;
                } else {
                    $hsl .= "D";
                    $angka-=500;
                }
            }
        }
        while ($angka>=100) {
            if ($angka>=400) {
                $hsl .= "CD";
                $angka -= 400;
            } else {
                $angka -= 100;
            }
        }
        if ($angka>=50) {
            if ($angka>=90) {
                $hsl .= "XC";
                $angka -= 90;
            } else {
                $hsl .= "L";
                $angka-=50;
            }
        }
        while ($angka >= 10) {
            if ($angka >= 40) {
                $hsl .= "XL";
                $angka -= 40;
            } else {
                $hsl .= "X";
                $angka -= 10;
            }
        }
        if ($angka >= 5) {
            if ($angka == 9) {
                $hsl .= "IX";
                $angka-=9;
            } else {
                $hsl .= "V";
                $angka -= 5;
            }
        }
        while ($angka >= 1) {
            if ($angka == 4) {
                $hsl .= "IV";
                $angka -= 4;
            } else {
                $hsl .= "I";
                $angka -= 1;
            }
        }
        return ($hsl);
    }

    public function kirim(){
        $config = Array(
                  'protocol'  => 'smtp',
                  'smtp_host' => 'ssl://smtp.googlemail.com',
                  'smtp_port' => 465,
                  'smtp_user' => 'xxxxxxxxxxxxxxxxxxxx',
                  'smtp_pass' => 'xxxxxxxxxxxxxxxxxxxx',
                  'mailtype'  => 'html',
                  'starttls'  => true,
                  'newline'   => "\r\n"
        );
        
        $this->email->initialize($config);
        $this->email->from('xxxxxxxxxxxxxxxxxxxx','KKT System');
        $this->email->to('xxxxxxxxxxxxxxxxxxxx');
        $this->email->subject('Coba aja');
        $this->email->message('Hello world !');
        
        if ($this->email->send())
            echo "Sukses kirim email";
        else
            echo "Gagal kirim email";
    }

}
?>