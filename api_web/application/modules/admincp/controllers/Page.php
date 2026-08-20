<?php

class Page extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('page_model');
        $this->load->library(array('alias', 'form_validation'));
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'page';
    }

    public function add() {        
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('alias', 'Alias', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {               
                $add = array(
                    'title' => $this->input->post('title'),
                    'alias' => $this->alias->create_alias($this->input->post('alias')),
                    'content' => $this->input->post('content'),
                );
                $this->data['check_error'] = 0;
                $this->page_model->insert($add);
            }
        }
        $this->template->write_view('content_block', 'page/add', $this->data);
        $this->template->render();
    }
    public function index() {
        $this->data['results'] = $this->page_model->get_all();
        $this->template->write_view('content_block', 'page/index', $this->data);
        $this->template->render();
    }
    public function edit($id) {
        $id=  intval($id);
        $this->data['check_error'] = -1;
        $this->data['page'] = $this->page_model->get_by_key($id);
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
                $this->page_model->update($update,$id);
            }
        }
        $this->data['page'] = $this->page_model->get_by_key($id);
        $this->template->write_view('content_block', 'page/edit', $this->data);
        $this->template->render();
    }
    public function del() {
        $id = intval(@$_POST['id']);
        $this->page_model->delete($id);       
    }

}
