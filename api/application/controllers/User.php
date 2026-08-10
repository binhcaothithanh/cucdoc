<?php

class User extends FONTEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('location_model');
    }

    function reg_email() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        if ($this->form_validation->run() == true) {
            $this->load->model('email_model');
            $email = $this->email_model->get_row_by('email = "' . $_POST['email'] . '"');
            if (empty($email))
                $this->email_model->insert(array('email' => $_POST['email'], 'date_create' => date('Y-m-d H:i:s')));
        }
    }

    function info() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->data['check_error'] = 1;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fullname', 'fullname', 'required');
            $this->form_validation->set_rules('address', 'address', 'required');
            $this->form_validation->set_rules('city', 'city', 'required');
            $this->form_validation->set_rules('district', 'district', 'required');
            if ($this->form_validation->run() == true) {
                $this->load->model('user_model');
                $city = $this->location_model->get_by_key(intval($_POST['city']));
                $district = $this->location_model->get_by_key(intval($_POST['district']));
                if ($city && $district && @$city['id'] == @$district['parent']) {
                    $insert = array(
                        'fullname' => $this->input->post('fullname'),
                        'address' => $this->input->post('address'),
                        'city' => $city['id'],
                        'district' => $district['id']
                    );
                    if ($_POST['password'])
                        $insert['password'] = md5($_POST['password']);
                    $id = $this->user_model->update($insert, $this->data['user']['id']);
                    $this->data['user'] = $this->user_model->get_by_key($this->data['user']['id']);
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['msg'] = 'Dữ liệu không hợp lệ';
                }
            }
        }
        $this->load->model(array('order_model', 'order_product_model'));
        $this->data['results'] = $this->order_model->get_by('phone = "' . $this->data['user']['phone'] . '"', 'id DESC');
        if (!empty($this->data['results'])) {
            $order_ids = '';
            foreach ($this->data['results'] as $item) {
                $order_ids.=$item['id'] . ',';
            }
            $order_product = $this->order_product_model->get_by('order_id in(' . trim($order_ids, ',') . ')');
            foreach ($this->data['results'] as &$item) {
                foreach ($order_product as $k => $v) {
                    if ($item['id'] == $v['order_id']) {
                        $item['childs'][] = $v;
                        unset($order_product[$k]);
                    }
                }
            }
        }
        include APPPATH . 'config/maps_order.php';
        $this->data['cities'] = $this->location_model->get_by('parent = ""', 'priority DESC,name ASC');
        $this->data['districts'] = $this->location_model->get_by('parent = ' . $this->data['user']['city'], 'priority DESC,name ASC');
        $this->template->write_view('content_block', $this->folder . 'userinfo', $this->data);
        $this->template->render();
    }

}
