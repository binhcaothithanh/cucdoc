<?php

/**
 * @property Product_Model $product_model
 */
class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_key_model');
    }



    function index()
    {
        die('hello come to api class');
    }

    // Get
    function getAllData($tableName = '', $key = '')
    {
        if(isset($_GET['tableName']) && isset($_GET['key'])){
          $tableName = $_GET['tableName'];
          $key = $_GET['key'];
          if ($this->AuthenticateKey($key)) {
              $this->load->model('Catalog_model');
              $this->load->model('Exercise_model');
              $this->load->model('Muscle_model');
              $this->load->model('Difficulty_model');
              $this->load->model('Equipment_model');
              $this->load->model('Program_model');
              $this->load->model('Day_model');
              $this->load->model('User_model');
              $this->load->model('User_Program_model');

              switch ($tableName) {
                  case 'Catalog':
                      $data = $this->Catalog_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'Exercise':
                      $data = $this->Exercise_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'Muscle':
                      $data = $this->Muscle_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'Program':
                      $data = $this->Program_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'Day':
                      $data = $this->Day_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'User':
                      $data = $this->User_model->get_all();
                      $data['result'] = 'success';
                      break;
                  case 'all':
                      $data['Catalog'] = $this->Catalog_model->get_all();
                      $data['Exercise'] = $this->Exercise_model->get_all();

                      $data['Muscle'] = $this->Muscle_model->get_all();
                      $data['Difficulty'] = $this->Difficulty_model->get_all();
                      $data['Equipment'] = $this->Equipment_model->get_all();
                      $data['Program'] = $this->Program_model->get_all();
                      $data['Day'] = $this->Day_model->get_all();
                      $data['User'] = $this->User_model->get_all();
                      $data['User_Program'] = $this->User_Program_model->get_all();
                      $data['result'] = 'success';
                      break;
                  default:
                      $data = 'wrong table name';
              }
          } else {   // get all table
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'wrong api key';
          }
        } else {
          $data['data'] = null;
          $data['result'] = 'fail';
          $data['error_log'] = 'missing table name or key';
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    function testDecode()
    {
        $key = $_GET['key'];
        if ($key != '') {
            die(base64_encode($key));
        }
        die('key is null');
    }
    function testEncode()
    {
        $key = $_GET['key'];
        if ($key != '') {
            die(base64_decode($key));
        }
        die('key is null');
    }

    function AuthenticateKey($key = '')
    {
        if ($key != '') {
            $key = base64_decode($key);
            $this->load->model('Api_key_model');
            $retVal = $this->Api_key_model->get_row_by(array('key' => trim($key)));

            if ($retVal != null) {
                return $retVal['function'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    // check login
    function CheckAuthenticateUser()
    {
      if(isset($_GET['username']) && isset($_GET['password']) && isset($_GET['key']))
      {
        $username = $_GET['username'];
        $password = $_GET['password'];

        $key = $_GET['key'];
        if ($this->AuthenticateKey($key)) {
          $this->load->model('User_model');

          $retVal = $this->User_model->get_row_by('user_name = "' . $username . '" and password = "' . $password .'" ');
          if($retVal != NULL){
            $data['data'] = $retVal;
            $data['result'] = 'success';
          }else// null cant find =>> wrong username password
          {
            $data['data'] = null;
            $data['result'] = 'fail';
            $data['error_log'] = 'fail authentication, wrong username or password';
          }
        } else {   // get all table
            $data['data'] = null;
            $data['result'] = 'fail';
            $data['error_log'] = 'wrong api key';
        }
      }else{
          $data['data'] = null;
          $data['result'] = 'fail';
          $data['error_log'] = 'Missing username password or api key';
      }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }


        // register
        function RegisterUser()
        {
          if(isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['key']))
          {
            $this->load->model('User_model');

            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $key = $_REQUEST['key'];

            if ($this->AuthenticateKey($key)) {
              $retVal = $this->User_model->get_row_by('user_name="' . $username . '"');
              if($retVal != NULL){ // exist user
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'Existed user';
              }else{// not exist user => create user
                $insert = array(
                    'user_name' => $username,
                    'password' => $password,
                    'gender' => 'male',
                );
                $id_inserted = $this->User_model->insert($insert);
                $data['data'] = $this->User_model->get_by('id=' . $id_inserted);
                $data['result'] = 'success';
                $data['error_log'] = 'Created user ' . $username;
              }
            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing username password or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // Update
        function UpdateUser()
        {
          if(isset($_REQUEST['id']) && isset($_REQUEST['key']))
          {
            $this->load->model('User_model');
            $dataCheck = $this->User_model->get_by('id !=' . $_REQUEST['id'] . ' AND user_name="' . $_REQUEST['user_name'] . '"');
            if(empty($dataCheck)){
              $this->load->model('User_model');
              if($_REQUEST['password'] != ''){
                $update = array(
                    'user_name' => $_REQUEST['user_name'],
                    'password' => $_REQUEST['password'],
                    'age' => $_REQUEST['age'],
                    'height' => $_REQUEST['height'],
                    'weight' => $_REQUEST['weight'],
                    'goal' => $_REQUEST['goal'],
                    'calorie' => $_REQUEST['calorie'],
                    'gender' => $_REQUEST['gender'],
                );
              }else{
                $update = array(
                    'user_name' => $_REQUEST['user_name'],
                    'age' => $_REQUEST['age'],
                    'height' => $_REQUEST['height'],
                    'weight' => $_REQUEST['weight'],
                    'goal' => $_REQUEST['goal'],
                    'calorie' => $_REQUEST['calorie'],
                    'gender' => $_REQUEST['gender'],
                );
              }

                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }


                $data['data'] = $this->User_model->update($update, $_REQUEST['id']);
                $data['result'] = 'success';
                $data['error_log'] = 'Succes update user data';
            }else{ // duplicate user name
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'user name is duplicated';
            }
          }else{
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'Missing id or api key';
          }
          header('Content-Type: application/json; charset=utf-8');
          echo json_encode($data);
        }

        // add new exercise to Program
        // example: http://vuavechai.com/Api/InsertDayTable?program_id=164&exercise_id=999&setvalue=111&rep=112&rest=113&key=ZnJlZV9rZXk=
        function InsertDayTable()
        {
          // program_id,  exercise_id, set_value, rep, rest
          if(isset($_GET['week_number']) && isset($_GET['image_type'])
          && isset($_GET['day_name']) && isset($_GET['key'])
          && isset($_GET['description']) && isset($_GET['day_number'])
          && isset($_GET['program_id']) && isset($_GET['exercise_id'])
          && isset($_GET['setvalue']) && isset($_GET['rep']) && isset($_GET['rest']))
          {
            $this->load->model('Day_model');

            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {

              // not exist user => create user
                $insert = array(
                    'program_id' => $_GET['program_id'],
                    'exercise_id' => $_GET['exercise_id'],
                    'setvalue' => $_GET['setvalue'],
                    'rep' => $_GET['rep'],
                    'rest' => $_GET['rest'],
                    'week_number' => $_GET['week_number'],
                    'day_number' => $_GET['day_number'],
                    'description' => $_GET['description'],
                    'day_name' => $_GET['day_name'],
                    'image_type' => $_GET['image_type'],
                );
                $retVal = $this->Day_model->insert($insert);
                $data['data'] = $retVal;
                $data['result'] = 'success';
                $data['error_log'] = 'Created Day ' . $retVal;

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing data insert or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // insert new record to user_program
        /* params:
            user_id
            program_id
            key

            result: log
        */
        function SavedProgram()
        {
          if(isset($_GET['user_id']) && isset($_GET['program_id']) && isset($_GET['key']))
          {


            $user_id = $_GET['user_id'];
            $program_id = $_GET['program_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {

              $this->load->model('User_Program_model');

              $retVal = $this->User_Program_model->get_row_by('user_id=' . $user_id . ' AND program_id =' . $program_id);
              if($retVal != NULL){ // exist user with program
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'Existed user program';
              }else{// not exist user => create user
                $insert = array(
                    'user_id' => $user_id,
                    'program_id' => $program_id,
                    'exercise_id' => 0,
                    'saved_date' => @date('Y-m-d H:i:s'),
                );
                $id_inserted = $this->User_Program_model->insert($insert);
                // $data['data'] = $this->User_Program_model->get_by('user_name="' . $username . '"');
                $data['result'] = 'success';
                $data['id'] = $id_inserted;
                $data['error_log'] = '';
              }
            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing username password or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }


        // remove record to user_program
        /* params:
            user_id
            program_id
            key

            result: log
        */
        function UnSavedProgram()
        {
          if(isset($_GET['user_id']) && isset($_GET['program_id']) && isset($_GET['key']))
          {
            $this->load->model('User_Program_model');

            $user_id = $_GET['user_id'];
            $program_id = $_GET['program_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
                // remove record
                $cond = 'user_id = ' . $user_id . ' AND program_id = ' . $program_id;
                $this->User_Program_model->delete_where($cond);
                // $data['data'] = $this->User_Program_model->get_by('user_name="' . $username . '"');
                $data['result'] = 'success';
                $data['error_log'] = '';

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing username password or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // update user table set current_program_id
        //  http://bungbang.com/Api/InsertTrainingProgram?user_id=9&program_id=247&last_day_number=1&key=ZnJlZV9rZXk
        /* params:
            user_id
            program_id
            key
            result: log
        */
        function InsertTrainingProgram()
        {
          if(isset($_GET['user_id']) && isset($_GET['program_id']) && isset($_GET['key']))
          {
            $user_id = $_GET['user_id'];
            $program_id = $_GET['program_id'];
            $last_day_number = $_GET['last_day_number'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
              $this->load->model('User_model');

              $retVal = $this->User_model->get_row_by('id=' . $user_id);
              if($retVal != NULL){ // exist user
                $update = array(
                    'current_program_id' => $program_id,
                    'last_day_number' => $last_day_number,
                    'start_date_training' =>@date('Y-m-d'),
                    'last_date_training' => @date('Y-m-d'),
                );
                $id_inserted = $this->User_model->update($update, $user_id);
                $data['data'] = $this->User_model->get_row_by('id=' . $user_id);
                $data['result'] = 'success';
                $data['id'] = $id_inserted;
                $data['error_log'] = '';
              }
            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing user_id program_id or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }



          // update user table set current_program_id
          //  http://bungbang.com/Api/UpdateTrainingProgram?user_id=9&program_id=247&last_day_number=1&last_date_training=7/7/2023&key=ZnJlZV9rZXk
          /* params:
              user_id
              program_id
              key
              result: log
          */
          function UpdateTrainingProgram()
          {
            if(isset($_GET['user_id']) && isset($_GET['key']))
            {
              $user_id = $_GET['user_id'];
              $last_day_number = $_GET['last_day_number'];
              $key = $_GET['key'];

              if ($this->AuthenticateKey($key)) {
                $this->load->model('User_model');

                $retVal = $this->User_model->get_row_by('id=' . $user_id);
                if($retVal != NULL){ // exist user
                  $update = array(
                      'last_day_number' => $last_day_number,
                      'last_date_training' => @date('Y-m-d'),
                  );
                  $id_inserted = $this->User_model->update($update, $user_id);
                  $data['data'] = $this->User_model->get_row_by('id=' . $user_id);
                  $data['result'] = 'success';
                  $data['id'] = $id_inserted;
                  $data['error_log'] = '';
                }
              } else {   // get all table
                  $data['data'] = null;
                  $data['result'] = 'fail';
                  $data['error_log'] = 'wrong api key';
              }
            }else{
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'Missing user_id program_id or api key';
            }
              header('Content-Type: application/json; charset=utf-8');
              echo json_encode($data);
          }

        // insert new record to Program
        /* params:
            user_id
            program_name
            key

            result: log
        */
        function AddProgram()
        {
          if(isset($_GET['program_name']) && isset($_GET['key']))
          {
            $program_name = $_GET['program_name'];
            $key = $_GET['key'];
            $gender = $_GET['gender'];
            $goal = $_GET['goal'];
            $total_week = $_GET['total_week'];
            $creator_id = $_GET['creator_id'];
            $level = $_GET['level'];
            $image = $_GET['image'];
            if ($this->AuthenticateKey($key)) {

              $this->load->model('Program_model');

              // $retVal = $this->Program_model->get_row_by('program_name="' . $program_name . '"');
              // if($retVal != NULL){ // exist user with program
              //   $data['data'] = null;
              //   $data['result'] = 'fail';
              //   $data['error_log'] = 'Existed program';
              // }else{// not exist program => create program
                $insert = array(
                    'creator_id' => $creator_id,
                    'program_name' => $program_name,
                    'gender' => $gender,
                    'goal' => $goal,
                    'total_week' => $total_week,
                    'level' => $level,
                    'image' => $image, // test
                );
                $id_inserted = $this->Program_model->insert($insert);
                // $data['data'] = $this->User_Program_model->get_by('user_name="' . $username . '"');
                $data['result'] = 'success';
                $data['id'] = $id_inserted;
                $data['error_log'] = '';
              // }
            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing program name or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        function RemoveProgram()
        {
          if( isset($_GET['program_id']) && isset($_GET['key']))
          {
            $this->load->model('Program_model');
            $program_id = $_GET['program_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
              // check if this program is training in user table just remove it (set current_program_id = 0)
                $this->load->model('User_model');
                $cond0 = 'current_program_id=' . $program_id;
                $listUser = $this->User_model->get_by($cond0);

                foreach($listUser as $eachUser){
                  $update = array(
                      'current_program_id' => 0,
                  );
                  $this->User_model->update($update, $eachUser['id']);
                }


                // remove from program table
                $this->load->model('Day_model');
                $cond = 'id = ' . $program_id;
                $this->Program_model->delete_where($cond);

                // remove from day table (contain exercise)
                $cond = 'program_id = ' . $program_id;
                $this->Day_model->delete_where($cond);

                $data['result'] = 'success';
                $data['error_log'] = 'success remove program ' . $program_id;

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing program id or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // insert new record to user_program With new exercise to log user doing exercise or already finish another program
        /* params:
            user_id
            program_id
            exercise_id
            key

            result: log
        */
        function FinishExercise()
        {
          if(isset($_GET['user_id']) && isset($_GET['program_id'])&& isset($_GET['exercise_id']) && isset($_GET['key']))
          {
            $this->load->model('User_Program_model');

            $user_id = $_GET['user_id'];
            $program_id = $_GET['program_id'];
            $exercise_id = $_GET['exercise_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
              $retVal = $this->User_Program_model->get_row_by('user_id=' . $user_id . ' AND program_id =' . $program_id . ' AND exercise_id = ' . $exercise_id);
              if($retVal != NULL){ // exist user
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'Existed user program and exercise';
              }else{// not exist user => create user
                $insert = array(
                    'user_id' => $user_id,
                    'program_id' => $program_id,
                    'exercise_id' => $exercise_id,
                    'saved_date' => @date('Y-m-d H:i:s'),
                );
                $id_inserted = $this->User_Program_model->insert($insert);
                // $data['data'] = $this->User_Program_model->get_by('user_name="' . $username . '"');
                $data['result'] = 'success';
                $data['id'] = $id_inserted;
                $data['error_log'] = 'Finished exercise ' . $exercise_id;
              }
            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing username password or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // remove record to user_program
        /* params:
            user_id
            program_id
            exercise_id
            key

            result: log
        */
        function RemoveUserProgramExercise()
        {
          if(isset($_GET['user_id']) && isset($_GET['program_id']) && isset($_GET['exercise_id']) && isset($_GET['key']))
          {
            $this->load->model('User_Program_model');

            $user_id = $_GET['user_id'];
            $program_id = $_GET['program_id'];
            $exercise_id = $_GET['exercise_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
                // remove record
                $cond = 'user_id = ' . $user_id . ' AND program_id = ' . $program_id . ' AND exercise_id = '. $exercise_id;
                $this->User_Program_model->delete_where($cond);
                // $data['data'] = $this->User_Program_model->get_by('user_name="' . $username . '"');
                $data['result'] = 'success unsave exercise ' . $exercise_id;
                $data['error_log'] = '';

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing username password or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // remove record to user_program
        /* params:
            user_id
            program_id
            exercise_id
            key

            result: log
        */
        function RemoveExerciseInDayTable()
        {
          if(isset($_GET['day_id']) && isset($_GET['key']))
          {
            $this->load->model('Day_model');

            $day_id = $_GET['day_id'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
                // remove record
                $cond = 'id = ' . $day_id;
                $this->Day_model->delete_where($cond);
                $data['result'] = 'success remove exercise in day ' . $day_id;
                $data['error_log'] = '';

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing day_id or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }

        // Update SET REP REST
        /* params:
            day_id
            set
            rep
            rest
            key

            result: log
        */
        function UpdateDaySetRepRest()
        {
          if(isset($_GET['day_id'])&& isset($_GET['setvalue'])&& isset($_GET['rep'])&& isset($_GET['rest']) && isset($_GET['key']))
          {
            $this->load->model('Day_model');

            $day_id = $_GET['day_id'];
            $setvalue = $_GET['setvalue'];
            $rep = $_GET['rep'];
            $rest = $_GET['rest'];
            $key = $_GET['key'];

            if ($this->AuthenticateKey($key)) {
                $update = array(
                    'setvalue' => $setvalue,
                    'rep' => $rep,
                    'rest' => $rest
                );
                $this->Day_model->update($update, $day_id);
                $data['result'] = 'success update set rep rest in day ' . $day_id;
                $data['error_log'] = '';

            } else {   // get all table
                $data['data'] = null;
                $data['result'] = 'fail';
                $data['error_log'] = 'wrong api key';
            }
          }else{
              $data['data'] = null;
              $data['result'] = 'fail';
              $data['error_log'] = 'Missing day_id, set rep rest or api key';
          }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
        }
}
