<?php

/**
 * @property Group_model $Group_model
 */
Class Group extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Group_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'group';
        $this->data['pre2'] = 'group';
        // $this->data['muscles'] = $this->Muscle_model->get_all();
        // $this->data['topics'] = $this->Topic_model->get_all();

    }

    public function index() {
        $this->data['results'] = $this->Group_model->get_all();
        $this->template->write_view('content_block', 'group/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $group_name = $this->input->post('group_name');
            // $group = $this->Group_model->get_row_by(array('group_name' => $group_name));
                if (empty($group)) {
                    $insert = array(
                        'group_name' => $this->input->post('group_name'),
                        'money' => $this->input->post('money'),
                        'note' => $this->input->post('note'),
                    );

                    $this->Group_model->insert($insert);
                    $this->data['check_error'] = 0;
                }else{ // error dupplicate group name:

                }
        }

        $this->template->write_view('content_block', 'group/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['group'] = $this->Group_model->get_by_key($id);
        if (empty($this->data['group'])) {
            redirect(base_url() . ADMIN_URL . 'group');
        }
        if (isset($_POST['submit'])) {
            
                $update = array(
                    'group_name' => $this->input->post('group_name'),
                    'money' => $this->input->post('money'),
                    'note' => $this->input->post('note'),
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Group_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['group'] = $this->Group_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'group');
        }
        $this->template->write_view('content_block', 'group/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Group_model->delete($id);
    }

}
