<?php

/**
 * @property catalog_Model $catalog_model
 */
Class Catalog extends BACKEND_Controller {

    public function __construct() {
        
        parent::__construct();
        // die('go to catalog crossing construct');
        $this->load->model('catalog_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'catalog';
        $this->data['pre2'] = 'catalog';
               
    }

    public function index() {
        $this->data['results'] = $this->catalog_model->get_all();
        $this->template->write_view('content_block', 'catalog/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $catalog_name = $this->input->post('catalog_name');
                $catalog = $this->catalog_model->get_row_by(array('catalog_name' => $catalog_name));
                
                if (empty($catalog)) {
                    $insert = array(
                        'catalog_name' => $this->input->post('catalog_name'),
                        'image' => $this->input->post('image'),
                        'description' => $this->input->post('description'),
                    );

                    $this->catalog_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'Tên đã tồn tại';
                }
         
        }
        $this->template->write_view('content_block', 'catalog/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['catalog'] = $this->catalog_model->get_by_key($id);
        if (empty($this->data['catalog'])) {
            redirect(base_url() . ADMIN_URL . 'catalog');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'catalog_name' => $this->input->post('catalog_name'),
                    'image' => $this->input->post('image'),
                    'description' => $this->input->post('description')
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->catalog_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['catalog'] = $this->catalog_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'catalog');

        }

        $this->template->write_view('content_block', 'catalog/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->catalog_model->delete($id);
    }

}
