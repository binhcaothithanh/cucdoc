<?php

/**
 * @property Exercise_model $Exercise_model
 */
Class Exercise extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Exercise_model');
        $this->load->model('Muscle_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'exercise';
        $this->data['pre2'] = 'exercise';
        $this->data['muscles'] = $this->Muscle_model->get_all();
        // $this->data['topics'] = $this->Topic_model->get_all();

    }

    public function index() {
        $this->data['results'] = $this->Exercise_model->get_all();
        $this->template->write_view('content_block', 'exercise/index', $this->data);
        $this->template->render();
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $exercise_name = $this->input->post('exercise_name');
            // $exercise = $this->Exercise_model->get_row_by(array('exercise_name' => $exercise_name));
                // if (empty($exercise)) {
                    $insert = array(
                        'exercise_name' => $this->input->post('exercise_name'),
                        'muscle' => $this->input->post('muscle_name'),
                        'equipment' => $this->input->post('equipment'),
                        'difficulty' => $this->input->post('difficulty'),
                        'image' => $this->input->post('image'),
                        'description' => $this->input->post('description'),
                    );

                    $this->Exercise_model->insert($insert);
                    $this->data['check_error'] = 0;
                // } else {
                //     $this->data['check_error'] = 1;
                //     $this->data['msg'] = 'Tên đã tồn tại';
                // }

        }

        $this->template->write_view('content_block', 'exercise/add', $this->data);
        $this->template->render();
    }

    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['exercise'] = $this->Exercise_model->get_by_key($id);
        if (empty($this->data['exercise'])) {
            redirect(base_url() . ADMIN_URL . 'exercise');
        }
        if (isset($_POST['submit'])) {
            $img = $this->input->post('image1');

                $update = array(
                  'exercise_name' => $this->input->post('exercise_name'),
                  'muscle' => $this->input->post('muscle_name'),
                  'equipment' => $this->input->post('equipment'),
                  'difficulty' => $this->input->post('difficulty'),
                  'image' => $this->input->post('image'),
                  'description' => $this->input->post('description'),
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Exercise_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['exercise'] = $this->Exercise_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'exercise');
        }
        $this->template->write_view('content_block', 'exercise/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Exercise_model->delete($id);
    }


    public function RefactorExerciseDescAjax(){
      $listExercise = $this->Exercise_model->get_all();
      $findDesc = 'Variations';
      $newDesc = '';
      foreach ($listExercise as $eachExercise) {
        $pos = strpos($eachExercise['description'], $findDesc);
        if($pos !== false){
          $id = $eachExercise['id'];
          // echo('------ old Desc: ' . $eachExercise['description']);
          // remove tab:
          $newDesc = trim(preg_replace('/\t+/', ' ', substr($eachExercise['description'], 0, $pos)));

          while(strstr($newDesc, PHP_EOL) || strpos($newDesc, "  ") !== false) {
              $newDesc = str_replace(PHP_EOL, " ", $newDesc);
              $newDesc = str_replace("  ", " ", $newDesc);
          }

          // echo('------ new Desc: ' .$newDesc);
          // Update:
          $update = array(
            'description' => $newDesc,
          );
          $this->Exercise_model->update($update, $id);
        }

      }
    }
}
