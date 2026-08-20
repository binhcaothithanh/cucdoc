<?php

class Report extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->data['pre1'] = 'report';
    }

    function index() {
        $this->data['pre'] = 'report';
        $this->data['month_now'] = date('m');
        $this->template->write_view('content_block', 'report/global', $this->data);
        $this->template->render();
    }

    function get_global_report() {     
        if (isset($_POST['month'])) {
            $month = intval($_POST['month']);
            $year = intval($_POST['year']);
            if ($month == date('m')) {
                $data['max_day'] = date('d');
            } else {
                $data['max_day'] = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
            }
            if ($month < 1 && $month > 12) {
                $month = date('m');
            } else {
                if ($month < 10) {
                    $month = '0' . $month;
                }
            }
            $data['my'] = $month . '-' . $year;
            $month = $year . $month;
            $this->load->model(array('report_product_model'));
            $data['online'] = $this->report_product_model->get_global_report($month);
            echo json_encode($data);
        }
    }

    function traffic() {
        $this->data['date'] = '01/' . date('m/Y') . ' - ' . date('d/m/Y');
        $this->data['pre2'] = 'traffic';
        $this->template->write_view('content_block', 'report/traffic/index', $this->data);
        $this->template->render();
    }

    function get_list_traffic() {

        if (isset($_POST['date_install']) && isset($_POST['order'])) {
            $date_install = (@$_POST['date_install']);
            $date_install = explode(' - ', $date_install);
            $from = $this->revert_time($date_install[0]);
            $to = $this->revert_time($date_install[1]) . ' 1';
            $cond = 'date >= "' . $from . '" and date <= "' . $to . '"';            
            $this->load->model('report_product_model');
            $data['orders'] = $this->report_product_model->get_order_report($cond);
            $data['results'] = $this->report_product_model->get_by($cond, $_POST['order']);
            $this->load->view('report/traffic/list', $data);
        }
    }

}
