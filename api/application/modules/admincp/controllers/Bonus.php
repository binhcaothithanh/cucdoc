<?php

class Bonus extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bonus_model');
        $this->load->library(array('alias', 'form_validation'));
        $this->data['pre1'] = 'report';
        $this->data['pre2'] = 'bonus';
    }

    public function index() {
        $this->data['date'] = '01/' . date('m/Y') . ' - ' . date('d/m/Y');
        $this->template->write_view('content_block', 'bonus/index', $this->data);
        $this->template->render();
    }

    function page() {
        if (isset($_POST['date_install'])) {
            $date_install = (@$_POST['date_install']);
            $date_install = explode(' - ', $date_install);
            $from = $this->revert_time($date_install[0]) . ' 00:00:00';
            $to = $this->revert_time($date_install[1]) . ' 23:59:59';
            $cond = 'date_create >= "' . $from . '" and date_create <= "' . $to . '"';
            $data['results'] = $this->bonus_model->get_report($cond);
            $this->load->view('bonus/list', $data);
        }
    }

 

}
