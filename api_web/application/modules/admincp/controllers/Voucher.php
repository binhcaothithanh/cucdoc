<?php

/**
 * @property Voucher_Model $voucher_model
 */
Class Voucher extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('voucher_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'voucher';
    }

    function index() {
        $this->data['pos'] = intval(@$_COOKIE['pos_voucher']);
        $this->template->write_view('content_block', 'voucher/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $count = intval($this->input->post('count'));
            $price = intval($this->input->post('price'));
            $type = ($this->input->post('type'));
            $count = $count < 1 ? 1 : $count;
            $date_create = date('Y-m-d H:i:s');
            for ($i = 0; $i < $count; $i++) {
                $insert[] = array(
                    'code' => strtoupper(random_string('alnum', 6)),
                    'date_create' => $date_create,
                    'price' => $price,
                    'type' => $type
                );
            }
            $this->data['check_error'] = 0;
            $this->voucher_model->insert_batch($insert);
        }
        $this->template->write_view('content_block', 'voucher/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['voucher'] = $this->voucher_model->get_by_key($id);
        if (empty($this->data['voucher'])) {
            redirect(base_url() . ADMIN_URL . 'voucher');
        }
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            $this->form_validation->set_rules('repassword', 'Password Confirmation');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $update = array(
                    'fullname' => $this->input->post('fullname'),
                    'role' => $this->input->post('role'),
                );
                if ($_POST['password']) {
                    $update['password'] = md5($_POST['password']);
                }

                $this->voucher_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['voucher'] = $this->voucher_model->get_by_key($id);
            }
        }

        $this->template->write_view('content_block', 'voucher/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->voucher_model->delete($id);
    }

    function page() {
        $pos = intval(@$_POST['pos']);
        $cond = null;
        if ($_POST['status']) {
            $cond['status'] = $_POST['status'];
        }
        $data['results'] = $this->voucher_model->get_for_page($this->limit, $pos, $cond);
        $total = $this->voucher_model->get_total_rows($cond);
        setcookie("pos_voucher", $pos, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        $data['links'] = $this->get_page($pos, $total, $this->limit);
        $this->load->view('voucher/list', $data);
        return false;
    }

}
