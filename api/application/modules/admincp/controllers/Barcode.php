<?php

class Barcode extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    private function set_barcode($code) {
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        Zend_Barcode::render('code128', 'image', array('text' => $code,'barHeight'=>30,'factor'=>1), array());
    }

    function index() {
        $text = (isset($_GET["text"]) ? $_GET["text"] : "0");
        $this->set_barcode($text);
    }

   
}
