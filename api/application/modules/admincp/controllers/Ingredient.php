<?php

/**
 * @property Ingredient_model $Ingredient_model
 */
Class Ingredient extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ingredient_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'ingredient';
        $this->data['pre2'] = 'ingredient';
        // $this->data['muscles'] = $this->Muscle_model->get_all();
        // $this->data['topics'] = $this->Topic_model->get_all();

    }

    public function index() {
        return;
        $this->data['results'] = $this->Ingredient_model->get_all();
        $this->template->write_view('content_block', 'ingredient/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $ingredient_name = $this->input->post('ingredient_name');
            // $ingredient = $this->Ingredient_model->get_row_by(array('ingredient_name' => $ingredient_name));
                // if (empty($ingredient)) {
                    $insert = array(
                        'username' => $this->input->post('username'),
                        'phone_number' => $this->input->post('phone_number'),
                        'note' => $this->input->post('note'),
                    );

                    $this->Ingredient_model->insert($insert);
                    $this->data['check_error'] = 0;

        }

        $this->template->write_view('content_block', 'ingredient/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['ingredient'] = $this->Ingredient_model->get_by_key($id);
        if (empty($this->data['ingredient'])) {
            redirect(base_url() . ADMIN_URL . 'ingredient');
        }
        if (isset($_POST['submit'])) {
            
                $update = array(
                    'username' => $this->input->post('username'),
                    'phone_number' => $this->input->post('phone_number'),
                    'note' => $this->input->post('note'),
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }
                    
                $this->Ingredient_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['ingredient'] = $this->Ingredient_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'ingredient');
        }
        $this->template->write_view('content_block', 'ingredient/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Ingredient_model->delete($id);
    }

}
