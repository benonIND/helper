<?php

/**
 * name : Zx helper
 * team : ZoneXploiter
 * author/coded : BENON_
 * 
 * NOTE!:
 * tempatkan file ini pada root home
 * 
 * panggil helper ini di awal file dengan syntax
 * - require('helper.php');
 * 
 * lalu panggil method/function yang mau di gunakan
 * - security::method/function
 */
 
class security {
  
  /**
  |--------------------------------------------------------------------------
  | KONFIGURASI DATABASE DENGAN HELPER ZX
  |--------------------------------------------------------------------------
  |
  | konfigurasi database mu disini
  | sesuikan nama database, password dan username nya
  |
  */
  public static function config_db(){
    
    $db['host']    = 'localhost'; # default
    $db['user']    = '';
    $db['pass']    = '';
    $db['db_name'] = '';
    
    define("DB_HOST", $db['host']);
    define("DB_USER", $db['user']);
    define("DB_PASS", $db['pass']);
    define("DB_NAME", $db['db_name']);
  }
  
 /**
  |--------------------------------------------------------------------------
  | MENGAMANKAN PARAMETER ID KHUSUS INTERGER/ANGKA
  |--------------------------------------------------------------------------
  |
  | Penggunaan :
  | - panggil methodnya -> security::sec_id();
  |
  | NOTE! :
  | Cara menggunakan nya adalah dengan cara membungkus
  | parameter id dengan method ini
  |
  | CONTOH:
  | $id = $_GET['id']; #sebelum -> vuln
  | $id = security::sec_id( $_GET['id'] ); #sesudah -> secure
  |
  */
  public static function sec_id($ambil){
  	$secure = abs($ambil);
  	return $secure;
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | MENGAMANKAN PARAMETER STRING 
  |--------------------------------------------------------------------------
  |
  | Tata cara Penggunaan :
  | - panggil methodnya -> security::sec_blind();
  | - bungkus parameter $_GET[] dengan methodnya
  | 
  | CONTOH:
  | - $param = $_GET['user'];  #sebelum -> vuln
  | - $param = security::sec_blind( $_GET['user'] ) #sesudah -> secure
  |
  */
  public static function sec_blind($tampung){
    $array = ['%3C','%3E','%27','*','1=1','1=0','%22'];
    $replace = str_replace($array, '', $tampung);
  	$secure = preg_replace("/[^0-9a-zA-Z\-_]/", $tampung);
  	return $secure;
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | MENGAMANKAN FORM REGISTRASI
  |--------------------------------------------------------------------------
  |
  | Penggunaan:
  | 
  | Bungkus variable globas post yang di gunakan dengan method ini
  |
  | CONTOH:
  | - $user = $_POST['user']; #sebelum -> vuln XSS
  | - $pass = $_POST['pass']; #sebelum -> vuln XSS
  | 
  | - $user = security::sec_form( $_POST['user'] ); #sesudah -> secure
  | - $pasa = security::sec_form( $_POST['pass'] ); #sesudah -> secure
  |
  */
  public static function sec_form($string){
  	$secure = strip_tags(trim($string));
  	return $secure;
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | MENGAMANKAN BYPASS LOGIN PADA FORM LOGIN
  |--------------------------------------------------------------------------
  |
  | Penggunaan:
  | 
  | panggil method ini lalu bungkus pada variable globals post
  |
  | CONTOH:
  | - $member = $_POST['member']; #sebelum -> vuln BYPASS
  | - $pass   = $_POST['password']; #sebelum -> vuln BYPASS
  |
  | - $member = security::sec_login( $_POST['member'] ); #sesudah -> secure
  | - $pass   = security::sec_login( $_POST['password'] ); #sesudah -> secure
  */
  public static function sec_login($string){
  	$secure = addslashes(strip_tags($string));
  	return $secure;
  }
  
  
  /*
  |--------------------------------------------------------------------------
  | KONEKSI DATABASE DENGAN DRIVER MYSQLI
  |--------------------------------------------------------------------------
  |
  | Gunakan method ini untuk memudahkan anda konek DATABASE
  | pada method ini dikhususkan konek dengan driver MYSQLI
  | 
  | saya berharap method ini dapat memudahkan ada koneksi dengan MSQLI
  | 
  | untuk dapat menggunakam method ini get terlebih dahulu file ini
  | get dengan require -> require('helper.php');
  | lalu panggil methodnya dengan syntax -> security::db_mysqli_konek()
  |
  | CONTOH:
  | jika helper sudah di panggil -> require('helper.php');
  | pada file maka tidak perlu di panggil lagi cukup pake syntax ini
  | 
  | security::db_mysqli_konek();
  |
  */
  public static function db_mysqli_konek(){
    self::config_db();
  	$konek = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  	if(!$konek){
  		return "database tidak konek bosku";
  	}
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | KONEKSI DATABASE DENGAN PDO
  |--------------------------------------------------------------------------
  |
  | Penggunaan:
  | 
  | panggil methodnya pada pada bagian atas setelah require('helper.php');
  | agar dapat menggunakan PDO
  |
  */
  public static function db_pdo_konek(){
    self::config_db();
    try {
      $konek = new PDO('mysqli:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USER, DB_PASS);
    }
    catch(PDOException $e){
      return 'Error: ' . $e->getMessage();
      exit();
    }
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | MENULIS QUERY SQL DENGAN ZX HELPER
  |--------------------------------------------------------------------------
  |
  | Penggunaan:
  | $sql = security::db_query('SELECT * FROM table');
  | 
  */
  public static function db_query($string){
  	$get_data = mysqli_query($konek, $string);
  	return $get_data;
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | MELAKUKAN REDIRECT HALAMAN
  |--------------------------------------------------------------------------
  |
  | Penggunaan:
  |
  | isikan tujuan redirect pada method ini
  |
  | CONTOH:
  | security::redirect('http://google.com');
  */
  public static function redirect( $input=NULL ){
    header('location:'.$input.'');
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | SET TANGGAL KE WAKTU INDONESIA
  |--------------------------------------------------------------------------
  |
  | Meangatur waktu INDONESIA
  | ketika memggunakan function date("Y-m-d");
  |
  */
  public static function set_date( $default='Asia/Jakarta' ){
    date_default_timezone_set($default);
  }
  
  
 /**
  |--------------------------------------------------------------------------
  | FILTER URI, URL USING SQLI OR XSS
  |--------------------------------------------------------------------------
  |
  | Panggil method ini di file manapun yang ingin anda filter
  | 
  | Penggunaan Syntax:
  | security::filter_uri();
  */
  public static function filter_uri(){
    $uri = $_SERVER['REQUEST_URI'];
    $ip  = $_SERVER['REMOTE_ADDR'];
    $url = '';
    $sess = $_GET['session'];
    session_start();
    if( $sess == "destroy" ) {
      session_destroy();
      clearstatcache();
      echo '<script> alert("Ip unlocked!"); </script>';
    }else{
      if( $_SESSION['ip_user'] !== NULL ){
        echo '
        <script>
          alert("your ip is banned!");
          window.location ="'.$url.'";
        </script>
        ';
      }
      else{
        if( strpos($uri, "%27") || strpos($uri,'%22') || strpos($uri,"%3C") || strpos($uri,"%3E") || strpos($uri,"*") || strpos($uri,"1=1") || strpos($uri,"1=0") || preg_match('/(union)/i',$uri) || preg_match('/(select)/i', $uri)){
          $_SESSION['ip_user'] = $ip;
          echo '<script> alert("your ip is banned!"); </script>';
        }
      }
    }
  }
}
?>
