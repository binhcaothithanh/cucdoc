<?php

class Auth extends FONTEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('location_model');
    }

    function login() {
        if ($this->data['user'])
            redirect(base_url());
        $this->data['check_error'] = -1;
        if (isset($_POST['phone'])) {
            $this->data['check_error'] = 1;
            $password = md5($_POST['password']);
            $user = $this->user_model->get_row_by('phone = "' . $_POST['phone'] . '" and password = "' . $password . '"');
            if (!empty($user)) {
                $this->session->set_userdata('user_fontend_id', $user['id']);
                redirect(base_url());
            }
        }
        $this->data['action_type'] = 'login';
        $this->data['cities'] = $this->location_model->get_by('parent = ""', 'priority DESC,name ASC');
        $this->template->write_view('content_block', 'all/reg_login', $this->data);
        $this->template->render();
    }

    function logout() {
        $this->session->unset_userdata('user_fontend_id');
        redirect(base_url());
    }

    function reg() {
        if ($this->data['user'])
            redirect(base_url());
        $this->data['action_type'] = 'reg';
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->data['check_error'] = 1;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fullname', 'fullname', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('phone', 'phone', 'required|is_natural');
            $this->form_validation->set_rules('email', 'email', 'required|valid_email');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_rules('district', 'district', 'required');
            if ($this->form_validation->run() == true) {
                $this->load->model('user_model');
                $phone = $this->input->post('phonenumber');
                $email = $this->input->post('email');
                $user = $this->user_model->get_row_by("phone = '$phone' or email = '$email'");
                if (empty($user)) {
                    $city = $this->location_model->get_by_key(intval($_POST['city']));
                    $district = $this->location_model->get_by_key(intval($_POST['district']));
                    if ($city && $district && @$city['id'] == @$district['parent']) {
                        $insert = array(
                            'fullname' => $this->input->post('fullname'),
                            'phone' => $this->input->post('phone'),
                            'email' => $this->input->post('email'),
                            'address' => $this->input->post('address'),
                            'password' => md5($this->input->post('password')),
                            'city' => $city['id'],
                            'district' => $district['id'],
                            'date_create' => date('Y-m-d H:i:s')
                        );
                        $id = $this->user_model->insert($insert);
                        $this->data['check_error'] = 0;
                        $this->session->set_userdata('user_fontend_id', $id);
                        redirect(base_url());
                    } else {
                        $this->data['msg'] = 'Dữ liệu không hợp lệ';
                    }
                } else {
                    $this->data['msg'] = 'Email hoặc số điện thoại này đã đăng ký';
                }
            }
        }
        $this->data['cities'] = $this->location_model->get_by('parent = ""', 'priority DESC,name ASC');
        $this->template->write_view('content_block', 'all/reg_login', $this->data);
        $this->template->render();
    }

}
