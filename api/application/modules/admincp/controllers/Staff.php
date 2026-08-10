<?php

/**
 * @property Staff_model $Staff_model
 */
Class Staff extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->model('Group_model');

        $this->load->library('form_validation');
        $this->data['pre1'] = 'staff';
        $this->data['pre2'] = 'staff';
        $this->data['group_list'] = $this->Group_model->get_all();
        // $this->data['topics'] = $this->Topic_model->get_all();

    }

    public function index() {
        $this->data['results'] = $this->Staff_model->get_all();
        $this->template->write_view('content_block', 'staff/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $staff_name = $this->input->post('staff_name');
            // $staff = $this->Staff_model->get_row_by(array('staff_name' => $staff_name));
                // if (empty($staff)) {
                    $insert = array(
                        'username' => $this->input->post('username'),
                        'phone_number' => $this->input->post('phone_number'),
                        'note' => $this->input->post('note'),
                        'group_id' => $this->input->post('group_id'),
                    );

                    $this->Staff_model->insert($insert);
                    $this->data['check_error'] = 0;

        }

        $this->template->write_view('content_block', 'staff/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['staff'] = $this->Staff_model->get_by_key($id);
        if (empty($this->data['staff'])) {
            redirect(base_url() . ADMIN_URL . 'staff');
        }
        if (isset($_POST['submit'])) {
            
                $update = array(
                    'username' => $this->input->post('username'),
                    'phone_number' => $this->input->post('phone_number'),
                    'note' => $this->input->post('note'),
                    'group_id' => $this->input->post('group_id'),
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Staff_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['staff'] = $this->Staff_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'staff');
        }
        $this->template->write_view('content_block', 'staff/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Staff_model->delete($id);
    }

}
