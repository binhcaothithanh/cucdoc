<?php

class BACKEND_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->data['username'] = $this->session->userdata('username');
        if (!$this->data['username']) {
            redirect(base_url() . ADMIN_URL . 'auth/login');
        }
        $this->load->model('admin_model');
        $this->data['user'] = $this->admin_model->get_row_by(array('username' => $this->data['username']));
        $this->data['fullname'] = $this->data['user']['fullname'];
        if ($this->data['user']['role'] != 'admin') {
            if ($this->data['user']['roles']) {
                if (strpos($this->data['user']['roles'], $this->router->fetch_class()) === false) {
                    $roles = explode(',', $this->data['user']['roles']);
                    redirect(base_url() . ADMIN_URL . $roles[0]);
                }
            } else {
                echo '<h1>permission denied <a href="' . base_url() . ADMIN_URL . 'auth/logout">LOGOUT</a></h1>';
                exit;
            }
        }
        $this->load->library(array('form_validation', 'alias'));
        $this->data['pre2'] = $this->data['pre1'] = '';
        $this->limit = 15;
    }

    public function get_role() {
        $this->data['username'] = $this->session->userdata('username');
        if (!$this->data['username']) {
            redirect(base_url() . ADMIN_URL . 'auth/login');
        }
        $this->load->model('admin_model');
        $this->data['user'] = $this->admin_model->get_row_by(array('username' => $this->data['username']));
		$rolex = 'admin';
        if ($this->data['user']['role'] != 'admin') {

			$rolex = $this->data['user']['role'];
        }
        return $rolex;
        $this->load->library(array('form_validation', 'alias'));
        $this->data['pre2'] = $this->data['pre1'] = '';
        $this->limit = 15;
    }

    protected function get_page($cur_page = 0, $total_rows = 0, $limit = 10) {

        $this->load->library('my_pagination');
        $config['per_page'] = $limit;
        $config['cur_page'] = $cur_page;
        $config['total_rows'] = $total_rows;
        $this->my_pagination->initialize($config);
        return $this->my_pagination->create_links();
    }

    protected function re_import_store($order_id = 0, $type = 1) {
        $this->load->model(array('order_model', 'order_product_model', 'sku_model', 'product_model'));
        $order = $this->order_model->get_by_key($order_id);
        if (!empty($order)) {
            $order_details = $this->order_product_model->get_by('order_id = ' . $order_id);
            if (!empty($order_details)) {
                $product_id = '';
                foreach ($order_details as $item) {
                    $this->sku_model->update_set($type * $item['count'], $item['sku_id'], 'count');
                    $product_id[$item['product_id']] = $item['product_id'];
                }
                foreach ($product_id as $id) {
                    $this->product_model->update_count_product($id);
                }
            }
        }
    }

    function upload_image($dir, $name = 'image') {
        $this->load->library('upload');
        $image = '';
        $return = array('error' => 1, 'msg' => 'No image uploaded');
        if ($_FILES[$name]['name']) {
            $config = array(
                'upload_path' => $dir,
                'allowed_types' => 'gif|jpg|png',
                'file_name' => random_string()
            );
            $this->upload->initialize($config);
            if (!$this->upload->do_upload($name)) {
                $return['msg'] = $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $return = array('error' => 0, 'file_name' => $data['file_name']);
            }
        }
        return $return;
    }

    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    protected function revert_time($time = "") {
        $exp = explode('/', $time);
        @$var = $exp[2] . '-' . $exp[1] . '-' . $exp[0];
        return $var;
    }

}
