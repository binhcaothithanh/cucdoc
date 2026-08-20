<?php

class Tutorial extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('tutorial_model');
        $this->load->library(array('alias', 'form_validation'));
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'tutorial';
    }

    public function add() {        
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Title', 'required');            
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {               
                $add = array(
                    'title' => $this->input->post('title'),                    
                    'content' => $this->input->post('content'),
                );
                $this->data['check_error'] = 0;
                $this->tutorial_model->insert($add);
            }
        }
        $this->template->write_view('content_block', 'tutorial/add', $this->data);
        $this->template->render();
    }
    public function index() {
        $this->data['results'] = $this->tutorial_model->get_all();
        $this->template->write_view('content_block', 'tutorial/index', $this->data);
        $this->template->render();
    }
    public function edit($id) {
        $id=  intval($id);
        $this->data['check_error'] = -1;
        $this->data['tutorial'] = $this->tutorial_model->get_by_key($id);
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('alias', 'Alias', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {               
                $update = array(
                    'title' => $this->input->post('title'),
                    'alias' => $this->alias->create_alias($this->input->post('alias')),
                    'content' => $this->input->post('content'),
                );
                $this->data['check_error'] = 0;
                $this->tutorial_model->update($update,$id);
            }
        }
        $this->data['tutorial'] = $this->tutorial_model->get_by_key($id);
        $this->template->write_view('content_block', 'tutorial/edit', $this->data);
        $this->template->render();
    }
    public function del() {
        $id = intval(@$_POST['id']);
        $this->tutorial_model->delete($id);       
    }

}
