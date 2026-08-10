<?php

/**
 * @property Muscle_model $Muscle_model
 */
Class Muscle extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Muscle_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'muscle';
        $this->data['pre2'] = 'muscle';
        
    }

    public function index() {
        $this->data['results'] = $this->Muscle_model->get_all();
        $this->template->write_view('content_block', 'muscle/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $muscle_name = $this->input->post('muscle_name');
                $muscle = $this->Muscle_model->get_row_by(array('muscle_name' => $muscle_name));
                
                if (empty($muscle)) {
                    $insert = array(
                        'muscle_name' => $this->input->post('muscle_name'),
                        'image' => $this->input->post('image'),
                        'description' => $this->input->post('description'),
                    );

                    $this->Muscle_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }
         
        }
        $this->template->write_view('content_block', 'muscle/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['muscle'] = $this->Muscle_model->get_by_key($id);
        if (empty($this->data['muscle'])) {
            redirect(base_url() . ADMIN_URL . 'muscle');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'muscle_name' => $this->input->post('muscle_name'),
                    'image' => $this->input->post('image'),
                    'description' => $this->input->post('description')
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Muscle_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['muscle'] = $this->Muscle_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'muscle');

        }

        $this->template->write_view('content_block', 'muscle/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Muscle_model->delete($id);
    }

}
