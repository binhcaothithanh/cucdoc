<?php

Class Attribute_Type extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();  
        $this->load->model(array( 'attribute_type_model'));
        $this->load->library('form_validation');
        $this->data['pre1'] = 'product';
        $this->data['pre2'] = 'attribute_type';
    }

    public function index() {
        $this->data['results'] = $this->attribute_type_model->get_by('id < 3');
        $this->template->write_view('content_block', 'attribute_type/index', $this->data);
        $this->template->render();
    }

    private function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('name', 'Tên loại thuộc tính', 'required');
            $this->form_validation->set_rules('attribute', 'Thuộc tính', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $this->data['check_error'] = 0;
                $insert = array('name' => $this->input->post('name'));
                $id = $this->attribute_type_model->insert($insert);
                $attribute = $this->input->post('attribute');
                $attribute = explode(',', $attribute);
                $insert = '';
                foreach ($attribute as $item) {
                    $item = trim($item);
                    if ($item)
                        $insert[] = array('attr_type_id' => $id, 'name' => $item);
                }
                if ($insert) {
                    $this->attribute_model->insert_batch($insert);
                }
            }
        }
        $this->template->write_view('content_block', 'attribute_type/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['attribute_type'] = $this->attribute_type_model->get_by_key($id);
        if (empty($this->data['attribute_type'])) {
            redirect(base_url() . ADMIN_URL . 'attribute_type');
        }
        if (isset($_POST['submit'])) {
            $this->form_validation->set_rules('name', 'Tên loại thuộc tính', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $check_attr = ',' . strtolower($this->data['attribute_type']['attr']) . ',';
                $this->data['check_error'] = 0;
                $attribute = $this->input->post('attribute');
                $attribute = explode(',', $attribute);
                $more = '';
                foreach ($attribute as $item) {
                    $item = trim($item);
                    if ($item && strpos($check_attr, ',' . strtolower($item) . ',') === false)
                        $more .= $item . ',';
                }
                $update = array(
                    'name' => $this->input->post('name'),
                    'attr' => trim($more . $this->data['attribute_type']['attr'], ',')
                );
                $this->attribute_type_model->update($update, $id);
                $this->data['attribute_type'] = $this->attribute_type_model->get_by_key($id);
            }
        }
        $this->data['attributes'] = $this->data['attribute_type']['attr'];
        $this->template->write_view('content_block', 'attribute_type/edit', $this->data);
        $this->template->render();
    }

    private function del() {
        $id = intval($_POST['id']);
        $this->attribute_type_model->delete($id);
    }

    public function del_attr() {
        $attr_type_id = intval($_POST['attr_type_id']);
        
        $attribute_type = $this->attribute_type_model->get_by_key($attr_type_id);
        if (!empty($attribute_type)) {            
            $attr = str_replace(',' . $_POST['attr'] . ',', ',', ',' . $attribute_type['attr'] . ',');
            $this->attribute_type_model->update(array('attr' => trim($attr, ',')), $attr_type_id);
        }
    }

}
