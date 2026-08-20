<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

    public function __construct() {

        parent::__construct();
        // die('goto /api/auth/construct of AUth.php');
        // $this->load->model('User_model');
        // Thiết lập header trả về chuẩn JSON RESTful
        header('Content-Type: application/json; charset=utf-8');
    }
    public function index() {
        die('goto /api/auth/index of AUth.php');
    }

}
