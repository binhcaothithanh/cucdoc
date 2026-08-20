<?php

/**
 * @property Ebook_model $Ebook_model
 */
Class Ebook extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Ebook_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'Ebook';
        $this->data['pre2'] = 'Ebook';

    }

    public function index() {
        $this->data['results'] = $this->Ebook_model->get_all();
        $this->template->write_view('content_block', 'ebook/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
                $page_content_vn = $this->input->post('page_content_vn');
                $Ebook = $this->Ebook_model->get_row_by(array('page_content_vn' => $page_content_vn));

                if (empty($Ebook)) {
                    $insert = array(
                    'page_content_vn' => $this->input->post('page_content_vn'),
                        'page_content_en' => $this->input->post('page_content_en'),
                        'page_type' => $this->input->post('page_type'),
                        'advise_type' => $this->input->post('advise_type'),
                    );

                    $this->Ebook_model->insert($insert);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['check_error'] = 1;
                    $this->data['msg'] = 'page_content_vn đã tồn tại';
                }

        }
        $this->template->write_view('content_block', 'ebook/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['ebook'] = $this->Ebook_model->get_by_key($id);
        if (empty($this->data['ebook'])) {
            redirect(base_url() . ADMIN_URL . 'Ebook');
        }
        if (isset($_POST['submit'])) {
                $update = array(
                  'page_content_en' => $this->input->post('page_content_en'),
                  'page_content_vn' => $this->input->post('page_content_vn'),
                  'page_type' => $this->input->post('page_type'),
                  'advise_type' => $this->input->post('advise_type'),
                );

                $this->Ebook_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['ebook'] = $this->Ebook_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'ebook');

        }

        $this->template->write_view('content_block', 'ebook/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Ebook_model->delete($id);
    }

}
