<?php

/**
 * @property Studenttransaction_Model $Studenttransaction_model
 */
Class StudentTransaction extends BACKEND_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Studenttransaction_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'StudentTransaction';
        $this->load->model('Student_model');
        $this->load->model('Studentconstant_model');
        $this->data['student_list'] = $this->Student_model->get_all();
        $this->data['constant_list'] = $this->Studentconstant_model->get_all();
        // $this->data['role_details'] = array(
        //     'StudentTransaction' => 'Quản Lý Sinh Viên',
        //     'StudentTransaction_transaction' => 'Phiên Làm Việc Sinh Viên',
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
      // die('1234');
        //
        // $this->data['results'] = $this->Studenttransaction_model->query_row("SELECT *, (select name from student where student.id = student_transaction.student_id) as student_name FROM student_transaction order by created_date desc");

        $this->template->write_view('content_block', 'studenttransaction/index', $this->data);
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
                // $user = $this->StudentTransaction_model->get_row_by(array('username' => $username));

                // if (empty($user)) {
                    $insert = array(
                        'student_id' => $this->input->post('student_id'),
                        'addon_money' => $this->input->post('addon_money'),
                        'state_transaction' => 'open',
                        'count_product_before' => $this->input->post('count_product_before'),
                        'count_product_before2' => $this->input->post('count_product_before2'),
                        'created_date' => date("Y-m-d H:i:s"),
                        'note' => $this->input->post('note'));

                    $this->Studenttransaction_model->insert($insert);
                    $this->data['check_error'] = 0;
                // } else {
                //     $this->data['check_error'] = 1;
                //     $this->data['msg'] = 'Tên đăng nhập đã tồn tại';
                // }
            // }
        }
        $this->template->write_view('content_block', 'studenttransaction/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['transaction'] = $this->Studenttransaction_model->get_by_key($id);
        $this->data['transaction']['student_name'] = $this->Student_model->get_by_key($this->data['transaction']['student_id'])['name'];
        if (empty($this->data['transaction'])) {
            redirect(base_url() . ADMIN_URL . 'StudentTransaction');
        }
        if (isset($_POST['submit'])) {
            // $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            // $this->form_validation->set_rules('repassword', 'Password Confirmation');
            // if ($this->form_validation->run() == FALSE) {
            //     $this->data['check_error'] = 1;
            // } else {
                $update = array(
                  'addon_money' => $this->input->post('addon_money'),
                  'note' => $this->input->post('note'),
                  'state_transaction' => 'finish',
                  'count_product_before' => $this->input->post('count_product_before'),
                  'count_product_after' => $this->input->post('count_product_after'),
                  'count_product_before2' => $this->input->post('count_product_before2'),
                  'count_product_after2' => $this->input->post('count_product_after2'),
                  'finish_date' => date("Y-m-d H:i:s"),
                  'total_money_back' => $this->input->post('TotalMoneyBack'),
                  'total_sell' => $this->input->post('TotalMoneySell'),
                  'totalproductsell' => $this->input->post('TotalProductSell'),
                );
                $this->Studenttransaction_model->update($update, $id);
                $this->data['check_error'] = 0;

                $this->data['transaction'] = $this->Studenttransaction_model->get_by_key($id);
                $this->data['transaction']['student_name'] = $this->Student_model->get_by_key($this->data['transaction']['student_id'])['name'];
            // }
        }

        $this->template->write_view('content_block', 'studenttransaction/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Studenttransaction_model->delete($id);
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


     // ajax function (search project from time to time)
     function load() {
         $parrams = $this->security->xss_clean($_REQUEST);
         if(isset($parrams['student_id']) && $parrams['student_id'] != ""){
           // var_dump($parrams);
           // die('xxxx');

           $cond = ($parrams['student_id']) ? 'student_id = ' . trim($parrams['student_id'])  : null;
           if ($parrams['fromTime']) {
               $temp = 'created_date >= "' . $parrams['fromTime'] . '"';

               if ($cond != null) {
                   $cond .= ' and (' . $temp . ')';
               } else {
                   $cond = '(' . $temp . ')';
               }
           }
           if ($parrams['toTime']) {
               $temp = 'created_date <= "' . $parrams['toTime'] . '"';

               if ($cond != null) {
                   $cond .= ' and (' . $temp . ')';
               } else {
                   $cond = '(' . $temp . ')';
               }
           }

           $data['results'] = $this->Studenttransaction_model->get_by($cond);
           // echo('<pre>');
           // var_dump($data['results']);
           // die;
           $data['student_name'] = $parrams['student_name'];
           $data['user']['role'] = $parrams['user_role'];
           $this->load->view('studenttransaction/list_ajax', $data);
         }else if(isset($parrams['fromTime']) || isset($parrams['toTime'])){
           // die('abc');
           $cond = null;
           if (isset($parrams['fromTime'])) {
               $temp = 'created_date >= "' . $parrams['fromTime'] . '"';

               if ($cond != null) {
                   $cond .= ' and (' . $temp . ')';
               } else {
                   $cond = '(' . $temp . ')';
               }
           }
           if (isset($parrams['toTime'])) {
               $temp = 'created_date <= "' . $parrams['toTime'] . '"';

               if ($cond != null) {
                   $cond .= ' and (' . $temp . ')';
               } else {
                   $cond = '(' . $temp . ')';
               }
           }

           if($cond == null){
             $data['user']['role'] = $parrams['user_role'];
             $this->data['results'] = $this->Studenttransaction_model->query_row("SELECT *, (select name from student where student.id = student_transaction.student_id) as student_name FROM student_transaction order by created_date desc");
             $this->load->view('studenttransaction/list_ajax', $this->data);
           }else{
             $data['user']['role'] = $parrams['user_role'];
             $this->data['results'] = $this->Studenttransaction_model->query_row("SELECT *, (select name from student where student.id = student_transaction.student_id) as student_name FROM student_transaction WHERE " . $cond . " order by created_date desc");
             $this->load->view('studenttransaction/list_ajax', $this->data);
           }
          }else{
           $this->data['user']['role'] = $parrams['user_role'];
           $this->data['results'] = $this->Studenttransaction_model->query_row("SELECT *, (select name from student where student.id = student_transaction.student_id) as student_name FROM student_transaction order by created_date desc");
           $this->load->view('studenttransaction/list_ajax', $this->data);
         }

     }
}
