<?php

/**
 * @property project_details_model $project_details_model
 */
Class projectdetails extends BACKEND_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('project_details_model');
        $this->load->model('project_model');
        $this->load->library(array('form_validation', 'resize_image', 'alias'));
        $this->load->library('image_lib');

        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'projectdetails';

        // data for all functions
        if(isset($_REQUEST['project_id'])){
          $id = $_REQUEST['project_id'];
          $this->data['project'] = $this->project_model->get_by_key($id);
          $this->data['results'] = $this->project_details_model->get_by('project_id = ' . $id, ' created_date desc ');
          $this->data['total_pay'] = 0;
          $this->data['total_receive'] = 0;
          foreach ($this->data['results'] as $eachPayment) {
            if($eachPayment['status'] == 'pay'){
              $this->data['total_pay'] += $eachPayment['money'];
            }else{
              $this->data['total_receive'] += $eachPayment['money'];
            }
          }
        }
    }

    public function index() {
        // $this->data['project_id'] = $id;
        $this->template->write_view('content_block', 'project_details/index', $this->data);
        $this->template->render();
    }
 // avc
    public function add() {
      $project_id = $_REQUEST['project_id'];
      $this->data['type'] = $_REQUEST['type'];
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            // $project_name = $this->input->post('project_name');
            // $project = $this->project_details_model->get_row_by(array('project_name' => $project_name));
            $img_name = '';
            $file_extention = '';
            $insert = array(
                'status' => $this->data['type'],
                'content' => $this->input->post('content'),
                'money' => $this->input->post('money'),
                'project_id' => $project_id,
                'created_date' => date("Y/m/d"),
                'created_user' => $this->input->post('created_user'),
            );

            if ($_FILES['photo']['name']) {
              $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $img_name = $project_id . '-' . date("dmyhms");
         // $img = '<img src="' . base_url() . 'asstes/thumb/' . $data . '">';
               // echo json_encode(array('img' => $img));
                $this->load->library('upload');
                $config = array(
                    'upload_path' => PATH_UPLOAD,
                    'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                    'overwrite' => FALSE,
                    'file_name' => $img_name,
                    'max_size' => 20480000000,
                    'max_width' => 30000,
                    'max_height' => 30000,
                );
                // echo('<pre>');
                // var_dump($config);
                // die;
                $this->upload->initialize($config);
                if ($this->upload->do_upload('photo')) {
                    // $img = $this->upload->data();

                    // resize image:
                    $this->resizeImage($img_name, $file_extention);

                }else{
                  $error = array('error' => $this->upload->display_errors());
                  var_dump($error);
                  die;
                }
                $insert['data_file'] = 'new' . $img_name . '.' . $file_extention;
              }

                if($this->data['type'] == 'pay'){
                  $insert['approved'] = 0;
                }else{ // receive
                  $insert['approved'] = 1;
                }

                $this->project_details_model->insert($insert);


                // update project money
                $project_details = $this->project_details_model->get_by('project_id = ' . $project_id);
                $total_pay = 0;
                $total_receive = 0;
                foreach ($project_details as $eachPayment) {
                  if($eachPayment['status'] == 'pay'){
                    $total_pay += $eachPayment['money'];
                  }else{
                    $total_receive += $eachPayment['money'];
                  }
                }
                $update = array(
                  'current_money' => $total_receive - $total_pay,
                );
                $this->project_model->update($update, $project_id);
                // redirect
                header("location: /admincp/projectdetails?project_id=$project_id");

                $this->data['check_error'] = 0;
            // } else {
            //     $this->data['check_error'] = 1;
            //     $this->data['msg'] = 'Tên dự án đã tồn tại';
            // }
        }

        $this->template->write_view('content_block', 'project_details/add', $this->data);
        $this->template->render();
    }
 // avc
 public function resizeImage($img_name, $file_extention){
    // $this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
    $this->load->library('image_lib');
    $config_resize['image_library'] = 'gd2';
    $config_resize['source_image'] = PATH_UPLOAD . $img_name . '.' . $file_extention;
    $config_resize['create_thumb'] = FALSE;
    $config_resize['maintain_ratio'] = TRUE;
    $config_resize['width']     = 375;
    $config_resize['height']   = 250;
    $config_resize['new_image'] = PATH_UPLOAD . 'new' . $img_name . '.' . $file_extention;
    $this->image_lib->clear();
    $this->image_lib->initialize($config_resize);
    if(!$this->image_lib->resize()){
      var_dump($this->image_lib->display_errors('', ''));
      die(PATH_UPLOAD . $img_name . '.' . $file_extention);
    }else{
      // remove origin file (very big size)
      unlink(PATH_UPLOAD . $img_name . '.' . $file_extention);
    }
  }
    public function edit($id) {

      // $project_id = $_REQUEST['project_id'];
      // $this->data['type'] = $_REQUEST['type'];

        $this->data['check_error'] = -1;
        $this->data['projectdetails'] = $this->project_details_model->get_by_key($id);
        if (empty($this->data['projectdetails'])) {
            redirect(base_url() . ADMIN_URL . '/projectdetails');
        }
        if (isset($_POST['submit'])) {

          $update = array(
            'status' => $this->input->post('status'),
            'content' => $this->input->post('content'),
            'money' => $this->input->post('money'),
            'approved' => $this->input->post('approved'),
          );

          if ($_FILES['photo']['name']) {

            // delete old image
            $projectDetails = $this->data['projectdetails'];
            if($projectDetails['data_file'] != ''){
              unlink(PATH_UPLOAD . $projectDetails['data_file']);
            }


            $img_name = '';
            $file_extention = '';
            if ($_FILES['photo']['name']) {
              // echo('<pre>');
              // var_dump(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
              // die;

              $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
              $img_name = $id . '-' . date("dmyhms");

              $this->load->library('upload');
              $config = array(
                  'upload_path' => PATH_UPLOAD,
                  'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                  'overwrite' => FALSE,
                  'file_name' => $img_name,
              );
              // echo('<pre>');
              // var_dump($config);
              // die;
              $this->upload->initialize($config);

              if ($this->upload->do_upload('photo')) {
                // resize image:
                $this->resizeImage($img_name, $file_extention);

              }else{
                $error = array('error' => $this->upload->display_errors());
                var_dump($error);
                die;
              }
            }

            $update['data_file']  = 'new'.$img_name . '.' . $file_extention;
          }

          if ($_FILES['photo_approve']['name']) {

            // delete old image
            $projectDetails = $this->data['projectdetails'];
            if($projectDetails['approve_image'] != ''){
              unlink(PATH_UPLOAD . $projectDetails['approve_image']);
            }



            $img_name = '';
            $file_extention = '';
            if ($_FILES['photo_approve']['name']) {

              $file_extention = pathinfo($_FILES['photo_approve']['name'], PATHINFO_EXTENSION);
              $img_name = $id . '-ptapprove-' . date("dmyhms");

              $this->load->library('upload');
              $config = array(
                  'upload_path' => PATH_UPLOAD,
                  'allowed_types' => 'gif|jpg|png|jpeg|jpeg|JPG',
                  'overwrite' => FALSE,
                  'file_name' => $img_name,
              );
              //

              $this->upload->initialize($config);
              if ($this->upload->do_upload('photo_approve')) {
                // resize image:
                $this->resizeImage($img_name, $file_extention);

                  // $img = $this->upload->data();
                  //$this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
                  $data['image'] = $img_name;
              }else{
                die($this->upload->display_errors());
              }
            }

            $update['approve_image']  = 'new'.$img_name . '.' . $file_extention;

          }

          $this->project_details_model->update($update, $id);
          $this->data['check_error'] = 0;
          $this->data['projectdetails'] = $this->project_details_model->get_by_key($id);

          // update project money
          $project_id = $this->data['projectdetails']['project_id'];
          $project_details = $this->project_details_model->get_by('project_id = ' . $project_id);
          $total_pay = 0;
          $total_receive = 0;
          foreach ($project_details as $eachPayment) {
            if($eachPayment['status'] == 'pay'){
              $total_pay += $eachPayment['money'];
            }else{
              $total_receive += $eachPayment['money'];
            }
          }


          // die($project_id . "_" . ($total_receive - $total_pay));  // avc
          $update_project = array(
            'current_money' => $total_receive - $total_pay,
          );
          $this->project_model->update($update_project, $project_id);



          header("location: /admincp/projectdetails?project_id=" . $this->data['projectdetails']['project_id']);

        }

        $this->template->write_view('content_block', 'project_details/edit', $this->data);
        $this->template->render();
    }


        public function watch($id) {

          // $project_id = $_REQUEST['project_id'];
          // $this->data['type'] = $_REQUEST['type'];

            $this->data['check_error'] = -1;
            $this->data['projectdetails'] = $this->project_details_model->get_by_key($id);
            if (empty($this->data['projectdetails'])) {
                redirect(base_url() . ADMIN_URL . '/projectdetails');
            }

            $this->template->write_view('content_block', 'project_details/watch', $this->data);
            $this->template->render();
        }

    public function del() {
        $id = intval($_POST['id']);
        $project_id = intval($_POST['project_id']);
        $projectDetails = $this->project_details_model->get_by_key($id);
        if($projectDetails['data_file'] != ''){
          unlink(PATH_UPLOAD . $projectDetails['data_file']);
        }
        if($projectDetails['approve_image'] != ''){
          unlink(PATH_UPLOAD . $projectDetails['approve_image']);
        }
        $this->project_details_model->delete($id);



        // update project money
        $project_details_list = $this->project_details_model->get_by('project_id = ' . $project_id);
        $total_pay = 0;
        $total_receive = 0;
        foreach ($project_details_list as $eachPayment) {
          if($eachPayment['status'] == 'pay'){
            $total_pay += $eachPayment['money'];
          }else{
            $total_receive += $eachPayment['money'];
          }
        }
        $update = array(
          'current_money' => $total_receive - $total_pay,
        );
        $this->project_model->update($update, $project_id);



    }

}
