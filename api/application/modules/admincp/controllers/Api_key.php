<?php

/**
 * @property Api_key_model $Api_key_model
 */
Class Api_key extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Api_key_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'api_key';
        $this->data['pre2'] = 'api_key';
        
    }

    public function index() {
        $this->data['results'] = $this->Api_key_model->get_all();
        $this->template->write_view('content_block', 'api_key/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $key = $this->input->post('key');
                $api_key = $this->Api_key_model->get_row_by(array('key' => $key));
                
                if (empty($api_key)) {
                    $insert = array(
                        'key' => $this->input->post('key'),
                        'function' => $this->input->post('function'),
                        'description' => $this->input->post('description'),
                    );

                    $this->Api_key_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }
         
        }
        $this->template->write_view('content_block', 'api_key/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['api_key'] = $this->Api_key_model->get_by_key($id);
        if (empty($this->data['api_key'])) {
            redirect(base_url() . ADMIN_URL . 'api_key');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'key' => $this->input->post('key'),
                    'function' => $this->input->post('function'),
                    'description' => $this->input->post('description')
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Api_key_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['api_key'] = $this->Api_key_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'api_key');

        }

        $this->template->write_view('content_block', 'api_key/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Api_key_model->delete($id);
    }

}
