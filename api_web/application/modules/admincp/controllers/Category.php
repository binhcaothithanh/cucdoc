<?php

Class Category extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('category_model', 'attribute_type_model', 'tutorial_model', 'product_model'));
        $this->data['pre1'] = 'product';
        $this->data['pre2'] = 'category';
    }

    public function index() {
        $this->load->library('my_category');
        $this->data['results'] = $this->my_category->build_list_cat();
        $this->template->write_view('content_block', 'category/index', $this->data);
        $this->template->render();
    }

    public function addcat_partner(){
      $this->data['check_error'] = 0;
      if (isset($_POST['submit'])) {

        // code get list cat:
        $linkfull = $this->input->post('link');
        $parent_id = $this->input->post('catid');
        $fullPage = file_get_contents($linkfull);

        $First_cat_signature = "Danh mục sản phẩm ";
        $Last_cat_signature = "block left-module title-variant";
        // Get left category:
        $vt0 = strpos($fullPage, $First_cat_signature);
        $vtE = strpos($fullPage, $Last_cat_signature);
        $cats = substr($fullPage, $vt0+strlen($First_cat_signature), $vtE - $vt0);
        // get lists details menu left
        $strFind = "</span><a";
        $strMid = "</a></li>";
        $name_cat = "";
        $link_cat = "";

        // make $cats more clear
        $cats = substr($cats, strpos($cats, $strFind), strlen($cats) - strpos($cats, $strFind));
        $dataCat = array();
        $i = 0;
         while(strpos($cats, $strMid) !== false)
         {
            $name_cat = substr($cats, strpos($cats, "title") + 7, strpos($cats, "href=") - (strpos($cats, "title") + 9));
            $link_cat = substr($cats, strpos($cats, "href=") + 6, strpos($cats, ".html") - (strpos($cats, "href=") + 1));

              if($name_cat == ''){
                break;
              }
            $dataCat[$i] = array("name_cat"=> $name_cat, "link_cat" => 'bisu.vn' . $link_cat);

            // re-fatory cats
            $cats = substr($cats, strpos($cats, $link_cat), strlen($cats) - strpos($cats, $link_cat));
            $cats = substr($cats, strpos($cats, $strMid), strlen($cats) - strpos($cats, $strMid));
            //var_dump($dataCat);
            $i++;

           }
           // INSERT to DATABASE
          foreach ($dataCat as $val){
            $insert = array(
              'title' => $val["name_cat"],
              'class' => $val["name_cat"],
              'parent_id' => $parent_id,
              'alias' => $val["name_cat"],
              'seo_title' => $val["name_cat"],
              'meta_description' => $val["name_cat"],
              'meta_keyword' => $val["name_cat"],
              'partner_link' => $val["link_cat"],
            );
            $this->category_model->insert($insert);
          }
      }
      $this->data['category_parents'] = $this->category_model->get_by('parent_id = 0');
      //$this->data['attr_types'] = $this->attribute_type_model->get_all();
      $this->template->write_view('content_block', 'category/addcat', $this->data);
      $this->template->render();

    }

    public function update_alias(){

      $this->data['check_error'] = -1;
      $list_cat = $this->category_model->get_all();


          foreach($list_cat as $item){
              $update = array(
                'partner_name' => 'bisu' //$this->alias->create_alias($item['bisu'])
              );

            $this->category_model->update($update, $item['id']);
          }
      $this->data['category'] = $this->category_model->get_by_key($id);
      $this->data['category_parents'] = $this->category_model->get_by('parent_id = 0 and id != ' . $id);
      $this->data['attr_types'] = $this->attribute_type_model->get_all();
      $this->template->write_view('content_block', 'category/edit', $this->data);
      $this->template->render();
    }

    public function update_image_des(){

      $this->data['check_error'] = -1;
      $list_cat = $this->category_model->get_all();
      $this->product_model->get_by('cat_id = ' . $item['id']);
      foreach($list_cat as $item){
          $update = array(
            'partner_name' => 'bisu' //$this->alias->create_alias($item['bisu'])
          );

        $this->category_model->update($update, $item['id']);
      }
      $this->data['category'] = $this->category_model->get_by_key($id);
      $this->data['category_parents'] = $this->category_model->get_by('parent_id = 0 and id != ' . $id);
      $this->data['attr_types'] = $this->attribute_type_model->get_all();
      $this->template->write_view('content_block', 'category/edit', $this->data);
      $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            //   $this->form_validation->set_rules('attr_type[]', 'Loại thuộc tính', 'required');
            $this->form_validation->set_rules('title', 'Tên', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $this->data['check_error'] = 0;
                // $attr_type_keys = implode(',', @$_POST['attr_type']);
                $insert = array(
                    'title' => $this->input->post('title'),
                    'class' => $this->input->post('class'),
                    'parent_id' => $this->input->post('parent_id'),
                    'alias' => $this->alias->create_alias($this->input->post('title')),
                    'seo_title' => $this->input->post('seo_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keyword' => $this->input->post('meta_keyword'),
                    'partner_name' => $this->input->post('partner_name'),
                    'partner_link' => $this->input->post('partner_link'),
                        // 'attr_type_keys' => $attr_type_keys
                );
                if ($_FILES['image']['name']) {
                    $this->load->library(array('upload', 'resize_image'));
                    $this->upload->initialize(array(
                        'upload_path' => PATH_UPLOAD . 'category/',
                        'allowed_types' => 'gif|jpg|png',
                        'overwrite' => false,
                        'file_name' => $this->alias->create_alias($_FILES['image']['name'])
                    ));
                    if ($this->upload->do_upload('image')) {
                        $img = $this->upload->data();
                        $insert['image'] = $img['file_name'];
                    } else {
                        $this->data['check_error'] = 1;
                        $this->data['msg'] = $this->upload->display_errors();
                    }
                }
                if ($this->data['check_error'] != 1)
                    $this->category_model->insert($insert);
            }
        }
        $this->load->library('my_category');
        $this->data['category_parents'] = $this->my_category->build_list_cat();
        $this->data['attr_types'] = $this->attribute_type_model->get_all();
        $this->template->write_view('content_block', 'category/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['category'] = $this->category_model->get_by_key($id);
        if (empty($this->data['category'])) {
            redirect(base_url() . ADMIN_URL . 'category');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('attr_type[]', 'Loại thuộc tính', 'required');
            $this->form_validation->set_rules('title', 'Tên', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $this->data['check_error'] = 0;
                //  $attr_type_keys = implode(',', $_POST['attr_type']);
                $update = array(
                    'title' => $this->input->post('title'),
                    'class' => $this->input->post('class'),
                    'parent_id' => $this->input->post('parent_id'),
                    'alias' => $this->alias->create_alias($this->input->post('title')),
                    'seo_title' => $this->input->post('seo_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'meta_keyword' => $this->input->post('meta_keyword'),
                    'partner_name' => $this->input->post('partner_name'),
                    'partner_link' => $this->input->post('partner_link'),
                        // 'attr_type_keys' => $attr_type_keys
                );
                if ($_FILES['image']['name']) {
                    $this->load->library(array('upload', 'resize_image'));
                    $this->upload->initialize(array(
                        'upload_path' => PATH_UPLOAD . 'category/',
                        'allowed_types' => 'gif|jpg|png',
                        'overwrite' => false,
                        'file_name' => $this->alias->create_alias($_FILES['image']['name'])
                    ));
                    if ($this->upload->do_upload('image')) {
                        $img = $this->upload->data();
                        $update['image'] = $img['file_name'];
                    } else {
                        $this->data['check_error'] = 1;
                        $this->data['msg'] = $this->upload->display_errors();
                    }
                }

                if ($this->data['check_error'] != 1) {
                    if ($this->data['category']['parent_id'] == 0 && $update['parent_id'] != 0)
                        $this->category_model->update_by(array('parent_id' => 0), array('parent_id' => $id));
                    $this->category_model->update($update, $id);
                    $this->data['category'] = $this->category_model->get_by_key($id);
                }
            }
        }
        //$this->data['category_parents'] = $this->category_model->get_by('parent_id != '.$id.' and id != ' . $id);
        $this->load->library('my_category');
        $this->data['category_parents'] = $this->my_category->build_list_cat();

        $this->data['attr_types'] = $this->attribute_type_model->get_all();
        $this->template->write_view('content_block', 'category/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        //$id = intval($_GET['id']);
        $this->load->library('my_category');
        $list_id_child = $id . ',';
        $list_id_return = $id;
        while($list_id_return != ''){
          $list_id_return = $this->my_category->get_child_by_parent($list_id_return);
          $list_id_child .= $list_id_return;
        }
        $list_id_child = trim($list_id_child, ',');
        $list_del = explode(',', $list_id_child);
        //$result = 'deleted: ';
        foreach($list_del as $each_cat_del){
          $this->category_model->delete($each_cat_del);
          //$result .= $each_cat_del;
        }
        // die($result);
        $this->category_model->delete($id);
    }

    public function del_attr() {
        $id = intval($_POST['id']);
        $this->attribute_model->delete($id);
    }

}
