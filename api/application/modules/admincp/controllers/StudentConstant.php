<?php

/**
 * @property Studentconstant_Model $Studentconstant_model
 */
Class StudentConstant extends BACKEND_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Studentconstant_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'Studentconstant';
        // $this->data['role_details'] = array(
        //     'student' => 'Quản Lý Sinh Viên',
        //     'student_transaction' => 'Phiên Làm Việc Sinh Viên',
        //     'category' => 'Danh mục',
        //     'order' => 'Đơn hàng',
        //     'export_shipping' => 'In đơn hàng',
        //     'update_shipping' => 'Xuất đơn hàng',
        //     'gallery' => 'Banner',
        //     'product' => 'Sản phẩm',
        //     'attribute_type' => 'Thuộc tính',
        //     'report' => 'Thống kê',
        //     'cache' => 'Xóa cache',
        //     'amdin' => 'Tài khoản',
        //     'page' => 'Page',
        //     'homeinfo' => 'SEO HOME'
        // );
    }

    public function index() {
        $this->data['results'] = $this->Studentconstant_model->get_all();
        $this->template->write_view('content_block', 'studentconstant/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[12]|alpha_dash');
            // $this->form_validation->set_rules('password', 'Password', 'required|matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation', 'required');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                // $username = $this->input->post('username');
                // $user = $this->Studentconstant_model->get_row_by(array('username' => $username));

                // if (empty($user)) {
                    $insert = array(
                        'constant_name' => $this->input->post('name'),
                        'constant_value' => $this->input->post('value'),
                        'note' => $this->input->post('note'));

                      // var_dump($insert);
                      // die;
                    $this->Studentconstant_model->insert($insert);
                    $this->data['check_error'] = 0;
                // } else {
                //     $this->data['check_error'] = 1;
                //     $this->data['msg'] = 'Tên đăng nhập đã tồn tại';
                // }
            // }
        }
        $this->template->write_view('content_block', 'studentconstant/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['constant'] = $this->Studentconstant_model->get_by_key($id);
        if (empty($this->data['constant'])) {
            redirect(base_url() . ADMIN_URL . 'StudentConstant');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    // 'constant_name' => $this->input->post('name'),
                    'constant_value' => $this->input->post('value'),
                    'note' => $this->input->post('note'),
                );

                $this->Studentconstant_model->update($update, $id);
                $this->data['check_error'] = 0;
            // }
        }

        $this->template->write_view('content_block', 'studentconstant/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_REQUEST['id']);
        $this->Studentconstant_model->delete($id);
    }

}
