<?php

/**
 * @property Admin_Model $admin_model
 */
Class Admin extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'admin';
        $this->data['role_details'] = array(
            'category' => 'Danh mục', 'order' => 'Đơn hàng',
            'export_shipping' => 'In đơn hàng',
            'update_shipping' => 'Xuất đơn hàng', 'gallery' => 'Banner',
            'product' => 'Sản phẩm', 'attribute_type' => 'Thuộc tính',
            'report' => 'Thống kê', 'cache' => 'Xóa cache',
            'amdin' => 'Tài khoản', 'page' => 'Page', 'homeinfo' => 'SEO HOME',
            'project' => 'Mannager Project','projectdetails' => 'Mannager ProjectDetails',

        );
    }

    public function index() {
        $this->data['results'] = $this->admin_model->get_all();
        $this->template->write_view('content_block', 'admin/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[12]|alpha_dash');
            $this->form_validation->set_rules('password', 'Password', 'required|matches[repassword]');
            $this->form_validation->set_rules('repassword', 'Password Confirmation', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $username = $this->input->post('username');
                $user = $this->admin_model->get_row_by(array('username' => $username));

                if (empty($user)) {
                    $insert = array(
                        'username' => $this->input->post('username'),
                        'role' => $this->input->post('role'),
                        'password' => md5($this->input->post('password')),
                        'fullname' => $this->input->post('fullname'),
                        'roles' => @implode(',', $this->input->post('roles'))
                    );

                    $this->admin_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đăng nhập đã tồn tại';
                }
            }
        }
        $this->template->write_view('content_block', 'admin/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['admin'] = $this->admin_model->get_by_key($id);
        if (empty($this->data['admin'])) {
            redirect(base_url() . ADMIN_URL . 'admin');
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
                    'roles' => @implode(',', $this->input->post('roles'))
                );
                if ($_POST['password']) {
                    $update['password'] = md5($_POST['password']);
                }

                $this->admin_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['admin'] = $this->admin_model->get_by_key($id);
            }
        }

        $this->template->write_view('content_block', 'admin/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->admin_model->delete($id);
    }

}
