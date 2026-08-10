<?php

/**
 * @property Difficulty_model $Difficulty_model
 */
Class Difficulty extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Difficulty_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'Difficulty';
        $this->data['pre2'] = 'Difficulty';

    }

    public function index() {
        $this->data['results'] = $this->Difficulty_model->get_all();
        $this->template->write_view('content_block', 'difficulty/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $difficulty_name = $this->input->post('difficulty_name');
                $Difficulty = $this->Difficulty_model->get_row_by(array('difficulty_name' => $difficulty_name));

                if (empty($Difficulty)) {
                    $insert = array(
                        'difficulty_name' => $this->input->post('difficulty_name'),
                        'image' => $this->input->post('image'),
                        'description' => $this->input->post('description'),
                    );

                    $this->Difficulty_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }

        }
        $this->template->write_view('content_block', 'difficulty/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['difficulty'] = $this->Difficulty_model->get_by_key($id);
        if (empty($this->data['difficulty'])) {
            redirect(base_url() . ADMIN_URL . 'Difficulty');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'Difficulty_name' => $this->input->post('difficulty_name'),
                    'image' => $this->input->post('image'),
                    'description' => $this->input->post('description')
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Difficulty_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['difficulty'] = $this->Difficulty_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'difficulty');

        }

        $this->template->write_view('content_block', 'difficulty/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Difficulty_model->delete($id);
    }

}
