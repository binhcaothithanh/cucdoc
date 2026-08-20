<?php

/**
 * @property User_model $User_model
 */
Class User extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'user';
        $this->data['pre2'] = 'user';

    }

    public function index() {
        $this->data['results'] = $this->User_model->get_all();
        $this->template->write_view('content_block', 'user/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $user_name = $this->input->post('user_name');
                $user = $this->User_model->get_row_by(array('user_name' => $user_name));

                if (empty($user)) {
                    $insert = array(
                        'user_name' => $this->input->post('user_name'),
                        'password' => md5($this->input->post('password')),
                        'age' => $this->input->post('age'),
                        'height' => $this->input->post('height'),
                        'weight' => $this->input->post('weight'),
                        'goal' => $this->input->post('goal'),
                        'calorie' => $this->input->post('calorie'),
                        'money' => $this->input->post('money'),
                        'gender' => $this->input->post('gender'),
                    );

                    $this->User_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }

        }
        $this->template->write_view('content_block', 'user/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['userItem'] = $this->User_model->get_by_key($id);
        if (empty($this->data['userItem'])) {
            redirect(base_url() . ADMIN_URL . 'user');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
              if($this->input->post('password') != ''){
                $update = array(
                    'user_name' => $this->input->post('user_name'),
                    'password' => md5($this->input->post('password')),
                    'age' => $this->input->post('age'),
                    'height' => $this->input->post('height'),
                    'weight' => $this->input->post('weight'),
                    'goal' => $this->input->post('goal'),
                    'calorie' => $this->input->post('calorie'),
                    'money' => $this->input->post('money'),
                    'gender' => $this->input->post('gender'),
                );
              }else{
                $update = array(
                    'user_name' => $this->input->post('user_name'),
                    'age' => $this->input->post('age'),
                    'height' => $this->input->post('height'),
                    'weight' => $this->input->post('weight'),
                    'goal' => $this->input->post('goal'),
                    'calorie' => $this->input->post('calorie'),
                    'money' => $this->input->post('money'),
                    'gender' => $this->input->post('gender'),
                );
              }

                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->User_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['userItem'] = $this->User_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'user');

        }

        $this->template->write_view('content_block', 'user/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->User_model->delete($id);
        $this->load->model('Program_model');
        $cond = 'creator_id = ' . $id;
        $this->Program_model->delete_where($cond);
    }

}
