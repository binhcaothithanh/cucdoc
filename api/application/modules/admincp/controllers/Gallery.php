<?php

/**
 * @property Gallery_Model $gallery_model
 */
class Gallery extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('gallery_model'));
        $this->load->library(array('form_validation'));
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'gallery';      
    }

    function index() {
        $this->data['pos'] = intval(@$_COOKIE['pos_gallery']);
        $this->data['results'] = $this->gallery_model->get_all();
        $this->template->write_view('content_block', 'gallery/index', $this->data);
        $this->template->render();
    }

    function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == true) {
                $image = '';
                if ($_FILES['image']['name']) {
                    $this->load->library(array('alias', 'upload', 'resize_image'));
                    $this->upload->initialize(array(
                        'upload_path' => PATH_UPLOAD . 'gallery/',
                        'allowed_types' => 'gif|jpg|png',
                        'overwrite' => false,
                        'file_name' => $this->alias->create_alias($_FILES['image']['name'])
                    ));
                    if ($this->upload->do_upload('image')) {
                        $img = $this->upload->data();
                        $this->resize_image->crop_resize($img['full_path'], $img['file_path'] . 'zithumb_' . $img['file_name'], 36, 36);                                               
                        $image = $img['file_name'];
                    } else {
                        $this->data['check_error'] = 1;
                        $this->data['msg'] = $this->upload->display_errors();
                    }
                }
                if ($this->data['check_error'] != 1) {
                    $insert = array(
                        'title' => $this->input->post('title'),
                        'link' => $this->input->post('link'),
                        'type' => $this->input->post('type'),
                        'description' => $this->input->post('description'),
                        'image' => $image
                    );
                    $this->gallery_model->insert($insert);
                    $this->data['check_error'] = 0;
                }
            } else {
                $this->data['check_error'] = 1;
            }
        }
        $this->template->write_view('content_block', 'gallery/add', $this->data);
        $this->template->render();
    }

    function edit($id = 0) {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == true) {
                $image = '';
                if ($_FILES['image']['name']) {
                    $this->load->library(array('alias', 'upload', 'resize_image'));
                    $this->upload->initialize(array(
                        'upload_path' => PATH_UPLOAD . 'gallery/',
                        'allowed_types' => 'gif|jpg|png',
                        'overwrite' => false,
                        'file_name' => $this->alias->create_alias($_FILES['image']['name'])
                    ));
                    if ($this->upload->do_upload('image')) {
                        $img = $this->upload->data();
                        $this->resize_image->crop_resize($img['full_path'], $img['file_path'] . 'zithumb_' . $img['file_name'], 36, 36);
                        $image = $img['file_name'];
                    } else {
                        $this->data['check_error'] = 1;
                        $this->data['msg'] = $this->upload->display_errors();
                    }
                }
                if ($this->data['check_error'] != 1) {
                    $insert = array(
                        'title' => $this->input->post('title'),
                        'link' => $this->input->post('link'),
                        'type' => $this->input->post('type'),
                        'description' => $this->input->post('description')
                    );
                    if ($image) {
                        $insert['image'] = $image;
                    }
                    $this->gallery_model->update($insert, $id);
                    $this->data['check_error'] = 0;
                }
            } else {
                $this->data['check_error'] = 1;
            }
        }
        $this->data['gallery'] = $this->gallery_model->get_by_key($id);
        if ($this->data['gallery']) {
            $this->template->write_view('content_block', 'gallery/edit', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    public function del() {
        $id = intval(@$_POST['id']);
        $gallery = $this->gallery_model->get_by_key($id);
        if (!empty($gallery)) {
            $this->gallery_model->delete($id);
            unlink(PATH_UPLOAD . 'gallery/' . $gallery['image']);
        }
    }

    function page() {
        $pos = intval(@$_POST['pos']);
        $cond = null;
        if ($_POST['type'])
            $cond['type'] = $_POST['type'];
        $data['results'] = $this->gallery_model->get_for_page($this->limit, $pos, $cond);
        $total = $this->gallery_model->get_total_rows($cond);
        setcookie("pos_gallery", $pos, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        $data['links'] = $this->get_page($pos, $total, $this->limit);
        $this->load->view('gallery/list', $data);
        return false;
    }

}
