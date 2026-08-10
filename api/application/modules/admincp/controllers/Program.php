<?php

/**
 * @property Program_model $Program_model
 */
class Program extends BACKEND_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Program_model');

        // $this->load->model('Catalog_model');
        $this->load->model('User_model');


        // $this->load->model('Muscle_model');
        // $this->data['muscles'] = $this->Muscle_model->get_all();
        $this->load->library(array('form_validation', 'resize_image', 'alias'));

        // $this->data['catalogs'] = $this->Catalog_model->get_all();
        $this->data['users'] = $this->User_model->get_all();
        $this->data['pre1'] = 'Program';
        $this->data['pre2'] = 'program';
    }

    public function index()
    {
        $this->data['results'] = $this->Program_model->get_all();
        $this->template->write_view('content_block', 'program/index', $this->data);
        $this->template->render();
    }

    public function add()
    {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $program_name = $this->input->post('program_name');
            $program = $this->Program_model->get_row_by(array('program_name' => $program_name));

            if (empty($program)) {

              $alias = $this->alias->create_alias($this->input->post('program_name'));
              //$path = PATH_UPLOAD;
              $img = '';

              if ($_FILES['photo']['name']) {
                // echo('<pre>');
                // var_dump(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                // die;
                $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                  $img_name = $alias . '-' . rand(1, 9999);

                  $this->load->library('upload');
                  $config = array(
                      'upload_path' => PATH_UPLOAD_PROGRAM,
                      'allowed_types' => 'gif|jpg|png|jpeg',
                      'overwrite' => FALSE,
                      'file_name' => $img_name,
                  );
                  $this->upload->initialize($config);
                  if ($this->upload->do_upload('photo')) {
                      $img = $this->upload->data();
                      //$this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
                      $data['image'] = $img_name;

                      // echo('<Pre>');
                      // var_dump($img);
                      // die;
                  }else{
                    die('upload fail: 777 folder or that file cant upload, change another file');
                  }
                }

                $insert = array(
                    'program_name' => $this->input->post('program_name'),
                    'image' => $img_name . '.' . $file_extention,
                    'description' => $this->input->post('description'),

                    // 'catalog_name' => $this->input->post('catalog_name'),
                    'gender' => $this->input->post('gender'),
                    'goal' => $this->input->post('goal'),
                    'total_week' => $this->input->post('total_week'),
                    'creator_id' => $this->input->post('creator_id'),
                );

                $this->Program_model->insert($insert);
                $this->data['check_error'] = 0;
            } else {
                $this->data['check_error'] = 1;
                $this->data['msg'] = 'Tên Program đã tồn tại';
            }
        }
        $this->template->write_view('content_block', 'program/add', $this->data);
        $this->template->render();
    }

    public function edit($id)
    {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['program'] = $this->Program_model->get_by_key($id);
        if (empty($this->data['program'])) {
            redirect(base_url() . ADMIN_URL . 'program');
        }
        if (isset($_POST['submit'])) {

          if ($_FILES['photo']['name']) {

            $alias = $this->alias->create_alias($this->input->post('program_name'));
            //$path = PATH_UPLOAD;
            $img = '';

            $file_extention = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
              $img_name = $alias . '-' . rand(1, 9999);

              $this->load->library('upload');
              $config = array(
                  'upload_path' => PATH_UPLOAD_PROGRAM,
                  'allowed_types' => 'gif|jpg|png|jpeg',
                  'overwrite' => FALSE,
                  'file_name' => $img_name,
              );
              $this->upload->initialize($config);
              if ($this->upload->do_upload('photo')) {
                  $img = $this->upload->data();
                  //$this->resize_image->crop_resize($img['full_path'], $img['full_path'], 300, 400);
                  $data['image'] = $img_name;

                  // echo('<Pre>');
                  // var_dump($img);
                  // die;
              }else{
                die('upload fail: 777 folder or that file cant upload, change another file');
              }
              $update = array(
                  'program_name' => $this->input->post('program_name'),
                  'image' => $img_name . '.' . $file_extention,
                  'description' => $this->input->post('description'),
                  // 'catalog_name' => $this->input->post('catalog_name'),
                  'gender' => $this->input->post('gender'),
                  'goal' => $this->input->post('goal'),
                  'total_week' => $this->input->post('total_week'),
                  'creator_id' => $this->input->post('creator_id'),
              );
            }else{
              $update = array(
                  'program_name' => $this->input->post('program_name'),
                  'description' => $this->input->post('description'),
                  // 'level_id' => $this->input->post('level_id'),
                  // 'level_name' => $this->input->post('level_name'),
                  // 'catalog_name' => $this->input->post('catalog_name'),
                  'gender' => $this->input->post('gender'),
                  'goal' => $this->input->post('goal'),
                  'total_week' => $this->input->post('total_week'),
                  'creator_id' => $this->input->post('creator_id'),
              );
            }


            // if ($_POST['password']) {
            //     $update['password'] = md5($_POST['password']);
            // }

            $this->Program_model->update($update, $id);
            $this->data['check_error'] = 0;
            $this->data['program'] = $this->Program_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'program');
        }

        $this->template->write_view('content_block', 'program/edit', $this->data);
        $this->template->render();
    }

    public function del()
    {
        $id = intval($_POST['id']);
        // check if this program is training in user table just remove it (set current_program_id = 0)
          $this->load->model('User_model');
          $cond0 = 'current_program_id=' . $id;
          $listUser = $this->User_model->get_by($cond0);

          foreach($listUser as $eachUser){
            $update = array(
                'current_program_id' => 0,
            );
            $this->User_model->update($update, $eachUser['id']);
          }



        $this->Program_model->delete($id);
        $this->load->model('Day_model');
        $cond = 'program_id = ' . $id;
        $this->Day_model->delete_where($cond);
    }

}
