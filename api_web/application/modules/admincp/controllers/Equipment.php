<?php

/**
 * @property Equipment_model $Equipment_model
 */
class Equipment extends BACKEND_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Equipment_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'equipment';
        $this->data['pre2'] = 'equipment';
    }

    public function index()
    {
        $this->data['results'] = $this->Equipment_model->get_all();
        $this->template->write_view('content_block', 'equipment/index', $this->data);
        $this->template->render();
    }

    public function add()
    {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $equipment_name = $this->input->post('equipment_name');
            $equipment = $this->Equipment_model->get_row_by(array('equipment_name' => $equipment_name));

            if (empty($equipment)) {

                $insert = array(
                    'equipment_name' => $this->input->post('equipment_name'),
                    'image' => $this->input->post('image'),
                    'description' => $this->input->post('description'),
                );

                $this->Equipment_model->insert($insert);
                $this->data['check_error'] = 0;
            } else {
                $this->data['check_error'] = 1;
                $this->data['msg'] = 'Tên đã tồn tại';
            }
        }
        $this->template->write_view('content_block', 'equipment/add', $this->data);
        $this->template->render();
    }

    public function edit($id)
    {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['equipment'] = $this->Equipment_model->get_by_key($id);
        if (empty($this->data['equipment'])) {
            redirect(base_url() . ADMIN_URL . 'equipment');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {


            $update = array(
                'equipment_name' => $this->input->post('equipment_name'),
                'image' => $this->input->post('image'),
                'description' => $this->input->post('description')
            );
            // if ($_POST['password']) {
            //     $update['password'] = md5($_POST['password']);
            // }

            $this->Equipment_model->update($update, $id);
            $this->data['check_error'] = 0;
            $this->data['equipment'] = $this->Equipment_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'equipment');
        }

        $this->template->write_view('content_block', 'equipment/edit', $this->data);
        $this->template->render();
    }

    public function del()
    {
        $id = intval($_POST['id']);
        $this->Equipment_model->delete($id);
    }
}
