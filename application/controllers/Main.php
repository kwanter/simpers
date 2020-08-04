<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends MY_Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->navmenu('Simpers','vw_page_maintenance','','','');
    }

    public function login(){

    }

    public function logout(){

    }


}
?>