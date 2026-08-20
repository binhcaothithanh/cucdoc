<?php

/**
 * @property Student_Model $Student_model
 */
Class Student extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'Student';
        // $this->data['role_details'] = array(
        //     'student' => 'Quản Lý Sinh Viên',
        //     'student_transaction' => 'Phiên Làm Việc Sinh Viên',
        //     'category' => 'Danh mục',
        //     'order' => 'Đơn hàng',
        //     'export_shipping' => 'In đơn hàng',
        //     'update_shipping' => 'Xuất đơn hàng',
        //     'gallery' => 'Banner',
        //     'product' => 'Sản phẩm',
        //     'attribute_type' => 'Thuộc tính',
        //     'report' => 'Thống kê',
        //     'cache' => 'Xóa cache',
        //     'amdin' => 'Tài khoản',
        //     'page' => 'Page',
        //     'homeinfo' => 'SEO HOME'
        // );
    }

    public function index() {
        $this->data['results'] = $this->Student_model->get_all();
        $this->template->write_view('content_block', 'student/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[12]|alpha_dash');
            // $this->form_validation->set_rules('password', 'Password', 'required|matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation', 'required');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                // $username = $this->input->post('username');
                // $user = $this->Student_model->get_row_by(array('username' => $username));

                // if (empty($user)) {
                    $insert = array(
                        'name' => $this->input->post('name'),
                        'phone_number' => $this->input->post('phone_number'),
                        // 'image_id' => $this->input->post('image_id'),
                        'photo' => $this->input->post('photo'),
                        'created_date' => date("Y-m-d H:i:s"),
                        'note' => $this->input->post('fullname'));

                    if ($_FILES['image_id']['name']) {
                      $file_extention = pathinfo($_FILES['image_id']['name'], PATHINFO_EXTENSION);
                        $img_name = $this->input->post('phone') . '-CMND-' . date("dmyhms");
                 // $img = '<img src="' . base_url() . 'asstes/thumb/' . $data . '">';
                       // echo json_encode(array('img' => $img));
                        $this->load->library('upload');
                        $config = array(
                            'upload_path' => PATH_UPLOAD,
                            'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                            'overwrite' => FALSE,
                            'file_name' => $img_name,
                            'max_size' => 30480000000,
                            'max_width' => 30000,
                            'max_height' => 30000,
                        );
                        // echo('<pre>');
                        // var_dump($config);
                        // die;
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image_id')) {
                            $this->resizeImage($img_name, $file_extention);
                        }else{
                          $error = array('error' => $this->upload->display_errors());
                          var_dump($error);
                          die;
                        }
                        $insert['image_id'] = 'new' . $img_name . '.' . $file_extention;
                      }

                      if ($_FILES['photo']['name']) {
                        $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                          $img_name = $this->input->post('phone') . '-photo-' . date("dmyhms");
                   // $img = '<img src="' . base_url() . 'asstes/thumb/' . $data . '">';
                         // echo json_encode(array('img' => $img));
                          $this->load->library('upload');
                          $config = array(
                              'upload_path' => PATH_UPLOAD,
                              'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                              'overwrite' => FALSE,
                              'file_name' => $img_name,
                              'max_size' => 60480000000,
                              'max_width' => 30000,
                              'max_height' => 30000,
                          );
                          // echo('<pre>');
                          // var_dump($config);
                          // die;
                          $this->upload->initialize($config);
                          if ($this->upload->do_upload('photo')) {
                              $this->resizeImage($img_name, $file_extention);
                          }else{
                            $error = array('error' => $this->upload->display_errors());
                            var_dump($error);
                            die;
                          }
                          $insert['photo'] = 'new' . $img_name . '.' . $file_extention;
                        }

                      // var_dump($insert);
                      // die;
                    $this->Student_model->insert($insert);
                    $this->data['check_error'] = 0;
                // } else {
                //     $this->data['check_error'] = 1;
                //     $this->data['msg'] = 'Tên đăng nhập đã tồn tại';
                // }
            // }
        }
        $this->template->write_view('content_block', 'student/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['Student'] = $this->Student_model->get_by_key($id);
        if (empty($this->data['Student'])) {
            redirect(base_url() . ADMIN_URL . 'Student');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                    'name' => $this->input->post('name'),
                    'phone_number' => $this->input->post('phone_number'),
                    'note' => $this->input->post('note'),
                );

                if ($_FILES['image_id']['name']) {
                  $file_extention = pathinfo($_FILES['image_id']['name'], PATHINFO_EXTENSION);
                    $img_name = $this->input->post('phone') . '-CMND-' . date("dmyhms");
             // $img = '<img src="' . base_url() . 'asstes/thumb/' . $data . '">';
                   // echo json_encode(array('img' => $img));
                    $this->load->library('upload');
                    $config = array(
                        'upload_path' => PATH_UPLOAD,
                        'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                        'overwrite' => FALSE,
                        'file_name' => $img_name,
                        'max_size' => 60480000000,
                        'max_width' => 30000,
                        'max_height' => 30000,
                    );
                    // echo('<pre>');
                    // var_dump($config);
                    // die;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image_id')) {
                        $this->resizeImage($img_name, $file_extention);
                    }else{
                      $error = array('error' => $this->upload->display_errors());
                      var_dump($error);
                      die;
                    }
                    $update['image_id'] = 'new' . $img_name . '.' . $file_extention;
                  }

                  if ($_FILES['photo']['name']) {
                    $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                      $img_name = $this->input->post('phone') . '-photo-' . date("dmyhms");
                  // $img = '<img src="' . base_url() . 'asstes/thumb/' . $data . '">';
                     // echo json_encode(array('img' => $img));
                      $this->load->library('upload');
                      $config = array(
                          'upload_path' => PATH_UPLOAD,
                          'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                          'overwrite' => FALSE,
                          'file_name' => $img_name,
                          'max_size' => 60480000000,
                          'max_width' => 30000,
                          'max_height' => 30000,
                      );
                      // echo('<pre>');
                      // var_dump($config);
                      // die;
                      $this->upload->initialize($config);
                      if ($this->upload->do_upload('photo')) {
                          $this->resizeImage($img_name, $file_extention);
                      }else{
                        $error = array('error' => $this->upload->display_errors());
                        var_dump($error);
                        die;
                      }
                      $update['photo'] = 'new' . $img_name . '.' . $file_extention;
                    }


                $this->Student_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['Student'] = $this->Student_model->get_by_key($id);
            // }
        }

        $this->template->write_view('content_block', 'student/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Student_model->delete($id);
    }

    public function resizeImage($img_name, $file_extention){
       // $this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
       $this->load->library('image_lib');
       $config_resize['image_library'] = 'gd2';
       $config_resize['source_image'] = PATH_UPLOAD .'/' . $img_name . '.' . $file_extention;
       $config_resize['create_thumb'] = FALSE;
       $config_resize['maintain_ratio'] = TRUE;
       $config_resize['width']     = 375;
       $config_resize['height']   = 250;
       $config_resize['new_image'] = PATH_UPLOAD . '/new' . $img_name . '.' . $file_extention;
       $this->image_lib->clear();
       $this->image_lib->initialize($config_resize);
       if(!$this->image_lib->resize()){
         var_dump($this->image_lib->display_errors('', ''));
         die(PATH_UPLOAD . '/' . $img_name . '.' . $file_extention);
       }else{
         // remove origin file (very big size)
         unlink(PATH_UPLOAD . '/'. $img_name . '.' . $file_extention);
       }
     }
}
