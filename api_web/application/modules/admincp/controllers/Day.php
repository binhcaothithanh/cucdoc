<?php

/**
 * @property Day_model $Day_model
 */
class Day extends BACKEND_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Day_model');
        $this->load->model('Program_model');
        $this->load->library(array('form_validation', 'resize_image', 'alias'));
        $this->load->model('Muscle_model');
        $this->load->model('Exercise_model');
        //$this->load->model('Program_model');

        //$this->data['muscles'] = $this->Muscle_model->get_all();
        //$this->data['exercises'] = $this->Exercise_model->get_all();
        $this->data['muscles'] = $this->Muscle_model->get_all();

        $this->data['pre1'] = 'Day';
        $this->data['pre2'] = 'Day';
    }

    public function index()
    {

        $query = 'SELECT *,(select exercise_name from exercise where exercise.id = day.exercise_id) as exercise_name,
        (SELECT program_name FROM program WHERE program.id = day.program_id ) AS program_name  FROM day order by program_id, week_number, day_number';
        $this->data['results'] = $this->Day_model->query_row($query);
        $this->template->write_view('content_block', 'day/index', $this->data);
        $this->template->render();
    }

    // ajax function: for change muscle list
    public function bindExercise()
    {
      $params = $this->security->xss_clean($_REQUEST);
      if ($params['muscle_name']) {
          $cond = 'muscle = "' . $params['muscle_name'] .'" ';

      $data['exercises'] = $this->Exercise_model->get_by($cond);
      }else{
          $data['exercises'] = null;
      }
      $this->load->view('day/exercises', $data);
    }

    public function add($program_id = 0)
    {
      $program_id = intval($_GET['program_id']); // program_id
      $this->data['program_id'] = $program_id;
      $query = 'SELECT total_week FROM `program` where id = ' . $program_id;

      $this->data['total_week'] = $this->Program_model->query_row($query)[0]['total_week'];
      // echo('<pre>');
      // var_dump($this->data['total_week']);
      // die;

        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {

          // because:  $this->input->post('exercise_id') = id,name
          $ex_id = explode(",",$this->input->post('exercise_id'))[0];
          $ex_name = explode(",",$this->input->post('exercise_id'))[1];

                $insert = array(
                    'program_id' => $program_id, // get from url
                    'exercise_id' => $ex_id,
                    'exercise_name' => $ex_name,
                    'day_number' => $this->input->post('day_number'),
                    'day_name' => $this->input->post('day_name'),
                    'week_number' => $this->input->post('week_number'),
                    'setvalue' => $this->input->post('setvalue'),
                    'reps' => $this->input->post('reps'),
                    'rest' => $this->input->post('rest'),
                    'note' => $this->input->post('note'),
                );
                $this->Day_model->insert($insert);
                $this->data['check_error'] = 0;
        }
        $this->template->write_view('content_block', 'day/add', $this->data);
        $this->template->render();
    }


    public function ajaxadd($id = 0)
    {
      $program_id = intval($id); // program_id
      $params = $this->security->xss_clean($_REQUEST);
        //$this->data['check_error'] = -1;
      $insert = array(
          'program_id' => $program_id, // get from url
          'exercise_id' => $params['exercise_id'],
          'day_number' => $params['day_number'],
          'day_name' => $params['day_name'],
          'week_number' => $params['week_number'],
          'image_type' => $params['image_type'],
          'setvalue' => $params['setvalue'],
          'rep' => $params['rep'],
          'rest' => $params['rest'],
          'description' => $params['description']
      );

      $this->Day_model->insert($insert);
      $this->data['check_error'] = 0;
      echo('success');
    }

    public function edit($id)
    {
        $id = intval($id);
        $this->data['check_error'] = -1;
        //$this->data['day'] = $this->Day_model->get_by_key($id);
        $query = 'select *, (select exercise_name from exercise where exercise.id = day.exercise_id) as exercise_name,
        (select image from exercise where exercise.id = day.exercise_id) as image_exercise from day where id = ' . $id;


        $this->data['day'] =$this->Day_model->query_row($query)[0];

        if (empty($this->data['day'])) {
            redirect(base_url() . ADMIN_URL . 'day');
        }
        // echo('<pre>');
        // var_dump($this->data['day']);
        // die;
        if (isset($_POST['submit'])) {
          //die('sumited');
          if($this->input->post('image_type') == 'Rest'){
              $update = array(
                'day_number' => $this->input->post('day_number'),
                'day_name' => $this->input->post('day_name'),
                'week_number' => $this->input->post('week_number'),
                'image_type' => $this->input->post('image_type'),
                'description' => $this->input->post('description')
              );

            }else{
              $update = array(
                'exercise_id' => $this->input->post('exercise_id'),
                'day_number' => $this->input->post('day_number'),
                'day_name' => $this->input->post('day_name'),
                'week_number' => $this->input->post('week_number'),
                'image_type' => $this->input->post('image_type'),
                'setvalue' => $this->input->post('setvalue'),
                'rep' => $this->input->post('rep'),
                'rest' => $this->input->post('rest'),
                'description' => $this->input->post('description')
              );
            }

          //die($update);
            $this->Day_model->update($update, $id);
            $this->data['check_error'] = 0;
            //$this->data['day'] = $this->Day_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'day');
        }else{
        //    die('not set submit post method');
        //echo('not submit');
        }

        $this->template->write_view('content_block', 'day/edit', $this->data);
        $this->template->render();
    }

    public function del()
    {
        $id = intval($_POST['id']);
        $this->Day_model->delete($id);
    }

    //
    // function upload($id) {
    //     if ($_FILES['images']['name'][0] != '') {
    //         $folder = $this->input->post('folder');
    //         $order = $this->input->post('order') + 1;
    //         $config['upload_path'] = PATH_PRODUCT . $folder;
    //         $count = count($_FILES['images']['name']) + $order;
    //         for ($i = $order; $i < $count; $i++) {
    //             $order_image[] = $i;
    //         }
    //         $insert_images = $this->upload_mutiple($_FILES, $config['upload_path'], $order_image, $id);
    //         if ($insert_images) {
    //             $product = $this->product_model->get_by_key($id);
    //             $content = $product['content'] . '<br/>';
    //             foreach ($insert_images as $item) {
    //                 $content.='<img src="/assets/upload/product/' . $folder . '/450/' . $item['name'] . '" class="img-responsive"/><br/><br/>';
    //             }
    //             $this->product_model->update(array('content' => $content), $id);
    //             $this->image_model->insert_batch($insert_images);
    //         }
    //     }
    //     redirect(base_url() . 'product/edit/' . $id . '#image');
    // }

}
