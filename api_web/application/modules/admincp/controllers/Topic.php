<?php

/**
 * @property topic_Model $topic_model
 */
Class Topic extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('topic_model');
        $this->load->model('catalog_model');
        $this->data['catalogs'] = $this->catalog_model->get_all();
        $this->load->library('form_validation');
        $this->data['pre1'] = 'topic';
        $this->data['pre2'] = 'topic';

    }

    public function index() {
        $this->data['results'] = $this->topic_model->get_all();
        $this->template->write_view('content_block', 'topic/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $topic_name = $this->input->post('topic_name');
                $topic = $this->topic_model->get_row_by(array('topic_name' => $topic_name));

                if (empty($topic)) {
                    $insert = array(
                        'topic_name' => $this->input->post('topic_name'),
                        'image' => $this->input->post('image'),
                        'description' => $this->input->post('description'),
                        'catalog_name' => $this->input->post('catalog_name'),
                    );

                    $this->topic_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }
        }
        $this->template->write_view('content_block', 'topic/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['topic'] = $this->topic_model->get_by_key($id);
        if (empty($this->data['topic'])) {
            redirect(base_url() . ADMIN_URL . 'topic');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'topic_name' => $this->input->post('topic_name'),
                    'image' => $this->input->post('image'),
                    'description' => $this->input->post('description'),
                    'catalog_name' => $this->input->post('catalog_name'),
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->topic_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['topic'] = $this->topic_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'topic');

        }

        $this->template->write_view('content_block', 'topic/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->topic_model->delete($id);
    }

}
