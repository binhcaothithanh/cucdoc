<?php

/**
 * @property Exercise_model $Exercise_model
 */
Class Bot extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Exercise_model');
        $this->load->model('Program_model');
        $this->load->model('Day_model');
        $this->load->model('Muscle_model');
        $this->load->model('Topic_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'exercise';
        $this->data['pre2'] = 'exercise';


    }

    public function index() {
        $this->data['totalPage'] = 60;
        // $this->data['linkFull'] = 'https://fitnessprogramer.com/exercises/';
        // $this->data['linkSingleWorkout'] = 'https://fitnessprogramer.com/workouts/';
        // $this->data['linkWorkoutPlan'] = 'https://fitnessprogramer.com/workout-plans/';
        //
         // $this->data['totalPage'] = $this->readUrlBy($this->data['linkFull'], 'span', 'page');



         // @$fullPage = file_get_contents($this->data['linkFull']);
         // libxml_use_internal_errors(false);
         //
         // @$dom = new DOMDocument();
         // @$dom->loadHTML($fullPage);
         // $tags = $dom->getElementsByTagName('a');
         // $aResult = '';
         // foreach ($tags as $tag) {
         //   if(strpos($tag->getAttribute('class'), 'page-numbers') !== false){ // for exercise gif
         //       $aResult = trim($tag->getAttribute('href'));
         //       break;
         //   }
         // }



        // $this->data['linkGet'] = substr($aResult, 0, strlen($aResult)-2);
        $this->template->write_view('content_block', 'bot/index', $this->data);
        $this->template->render();
    }

      public function ReadSingleWorkoutAjax(){
        // echo('read full');
        // die;

        $params = $this->security->xss_clean($_REQUEST);
        $link = $params['link'];

        $totalPage = $this->readUrlBy($link, 'span', 'page');
        $programList = array();

        $totalSave = 0;
//https://fitnessprogramer.com/workouts/page/2/
        $curPage = 1;
        while($curPage <= $totalPage){
          $link_each_page = $link . 'page/' . $curPage;

          @$fullPage = file_get_contents($link_each_page);
          libxml_use_internal_errors(false);

          @$dom = new DOMDocument();
          @$dom->loadHTML($fullPage);
          $imgList = $dom->getElementsByTagName('img');
          $tagH2 = $dom->getElementsByTagName('h2');
          foreach ($tagH2 as $eachH2) {
            if($eachH2->getAttribute('class') == "title"){
              $atag = $eachH2->childNodes->item(1);

              $programList[$curPage]['program_name'] = trim($atag->nodeValue);
              $programList[$curPage]['link_detail'] = $atag->getAttribute('href');
              foreach ($imgList as $eachImg) {
                if($eachImg->getAttribute('alt') == $programList[$curPage]['program_name'])
                {
                  $programList[$curPage]['link_img'] = $eachImg->getAttribute('src');
                  $programList[$curPage]['img_name'] = substr($programList[$curPage]['link_img'],strrpos($programList[$curPage]['link_img'], '/') + 1, strlen($programList[$curPage]['link_img']));

                  // download image to server:
                  $imgSave = PATH_DOWNLOAD_PROGRAM . '/' . $programList[$curPage]['img_name'];
                  file_put_contents($imgSave, file_get_contents($programList[$curPage]['link_img']));
                  // add new program to database

                  $insert = array(
                      'program_name' => $programList[$curPage]['program_name'],
                      'image' => $programList[$curPage]['img_name'],
                      'creator_id' => 0,
                      'link_root' => $programList[$curPage]['link_detail'],
                    );
                  $this->Program_model->insert($insert);
                  $totalSave++;
                  break;
                }
              }
            }
          }
          $curPage++;
        }



        echo 'total program added ' .  $totalSave;
      }


      public function ScanWorkoutPlanAjax(){
        // echo('read full');
        // die;

        $params = $this->security->xss_clean($_REQUEST);
        $link = $params['link'];

        $programList = array();
        // $totalSave = 0;
        //https://fitnessprogramer.com/workouts/page/2/



          @$fullPage = file_get_contents($link);
          libxml_use_internal_errors(false);

          @$dom = new DOMDocument();
          @$dom->loadHTML($fullPage);
          $imgList = $dom->getElementsByTagName('img');
          $tagH2 = $dom->getElementsByTagName('h2');
          $articleList = $dom->getElementsByTagName('article');
          $countItem = 0;
          foreach ($tagH2 as $eachH2) {
            if($eachH2->getAttribute('class') == "title"){
              $atag = $eachH2->childNodes->item(1);

              $programList['program_name'] = trim($atag->nodeValue);
              $programList['link_detail'] = $atag->getAttribute('href');

              foreach ($imgList as $eachImg) {
                if($eachImg->getAttribute('alt') == $programList['program_name'])
                {
                  $programList['link_img'] = $eachImg->getAttribute('src');
                  $programList['img_name'] = substr($programList['link_img'],strrpos($programList['link_img'], '/') + 1, strlen($programList['link_img']));

                  // download image to server:
                  $imgSave = PATH_DOWNLOAD_PROGRAM . '/' . $programList['img_name'];

                  // store image
                  if(!file_exists($imgSave)){
                    file_put_contents($imgSave, file_get_contents($programList['link_img']));
                  }

                  foreach ($articleList as $eachArticle) {
                    if(strpos($eachArticle->nodeValue,  $programList['program_name']) !== false){
                      $strTmp = trim($eachArticle->nodeValue);
                      $programList['gender'] = "";
                      $programList['goal'] = "";
                      $programList['week'] = 0;
                      if(strpos($strTmp, 'Male') !== false){
                        $programList['gender'] .= "Male, ";
                      }
                      if(strpos($strTmp, 'Female') !== false){
                        $programList['gender'] .= "Female, ";
                      }
                      $programList['gender'] = trim(trim($programList['gender']), ',');

                      if(strpos($strTmp, 'Build Muscle') !== false){
                        $programList['goal'] = "Build Muscle";
                      }
                      if(strpos($strTmp, 'Lose Fat') !== false){
                        $programList['goal'] = "Lose Fat";
                      }

                      $strTmp = substr($strTmp, strpos($strTmp, 'Workout Plan'));
                      $programList['week'] = trim(substr($strTmp, strpos($strTmp, 'Week')-2, 2));

                      break;
                    }
                  }
                  break;
                }
              }

              // add new program to database
              $insert = array(
                  'program_name' => $programList['program_name'],
                  'goal' => $programList['goal'],
                  'gender' => $programList['gender'],
                  'total_week' => $programList['week'],
                  'image' => $programList['img_name'],
                                'creator_id' => 0,
                  'link_root' => $programList['link_detail'],
                );
              // var_dump($insert);
              // die;
              $this->Program_model->insert($insert);
              $countItem++;

            }
          }
          echo('total insert: ' . $countItem++);
      }

      public function UpdateWorkoutPlanAjax(){
        $results = $this->Program_model->get_by("total_week > 0");  // only get workout plan (pro)

        $countUpdate = 0;

        $params = $this->security->xss_clean($_REQUEST);
        $numberProgram = $params['numberProgram'];
        $k = 0;
        $id=0;
        foreach($results as $item){ // each program (workout plan)
          $k++;

          // if($k == $numberProgram){ // 1 => 10

            $id = $item['id'];
            $link = $item['link_root'];
            // die($link);
            if($id >= 159 && $id <= 163){
            // $link = "https://fitnessprogramer.com/workout-plan/6-week-advanced-workout-plan-to-build-muscle/"; //hardcode
            $program_update = array();
            @$fullPage = file_get_contents($link);
            libxml_use_internal_errors(false);
            @$dom = new DOMDocument();
            @$dom->loadHTML($fullPage);
            $divList = $dom->getElementsByTagName("div");
            $week = 0;
            $description = "";
            foreach ($divList as $divWeek) {
              if($description == "" && trim($divWeek->getAttribute('class')) == 'wpb_text_column wpb_content_element'){ // program_description
                // var_dump($divWeek);
                $description = $divWeek->nodeValue;
                $description = trim(str_replace(" on fitnessprogramer.com", "", $description));
                $this->Program_model->update(array('description' => $description), $id);
              }
              if($divWeek->getAttribute('class') == "week"){
                $week++;
                $dvWeekEntry = $divWeek->childNodes->item(1);
                foreach($dvWeekEntry->childNodes as $entry){
                  $atag = $entry->childNodes->item(0);
                  $day_link = $atag->getAttribute('href');

                  $img_name = '';
                  $link_img_Day = '';
                  // var_dump($atag->childNodes->item(0)->childNodes->item(0));
                  // die;
                  if($atag->childNodes->item(0)->childNodes->item(0)->nodeName == 'img'){
                    $link_img_Day = $atag->childNodes->item(0)->childNodes->item(0)->getAttribute('src');
                    // $ex[$i]['img_link'] = $img->getAttribute('src');
                    $img_name = substr($link_img_Day,strrpos($link_img_Day, '/') + 1, strlen($link_img_Day));

                    // download image:
                    $imgSave = PATH_DOWNLOAD_DAY_TYPE . '/' . $img_name;
                    if(!file_exists($imgSave)){
                      file_put_contents($imgSave, file_get_contents($link_img_Day));
                    }
                    // var_dump($atag->childNodes->item(0));
                    // die;
                    $nameDay = trim($atag->childNodes->item(0)->childNodes->item(0)->getAttribute('alt'));
                    $dvDayNumber = trim(str_replace("Day","", $atag->childNodes->item(1)->nodeValue));
                  }else{
                    // echo('not exist image');
                    // var_dump($atag->childNodes->item(0)->childNodes->item(0));
                    $nameDay = trim($atag->childNodes->item(1)->nodeValue);
                    $dvDayNumber = trim(str_replace("Day","", $atag->childNodes->item(0)->nodeValue));
                  }

                  if($nameDay != "REST"){
                    $program_update = $this->ReadProgramProDetail($day_link);
                    for ($i = 0 ; $i < count($program_update['listExercise']) ; $i++) {
                      $insert_day = array(
                        'program_id' => $id,
                        'exercise_id' => $program_update['listExercise'][$i]['exercise_id'],
                        'set' => $program_update['listExercise'][$i]['set'],
                        'rep' => $program_update['listExercise'][$i]['rep'],
                        'rest' => $program_update['listExercise'][$i]['rest'],
                        'week_number' => $week,
                        'day_number' => $dvDayNumber,
                        'image_type' => $img_name,
                        'day_name' => $nameDay,
                        'description' => '',
                      );

                      $this->Day_model->insert($insert_day);
                      // var_dump($insert_day);
                      $countUpdate++;
                    }
                  }else{
                    $insert_day = array(
                      'program_id' => $id,
                      'exercise_id' => 0,
                      'set' => "0",
                      'rep' => "0",
                      'rest' => "0",
                      'week_number' => $week,
                      'day_number' => $dvDayNumber,
                      'image_type' => $img_name,
                      'day_name' => $nameDay,
                      'description' => '',
                    );
                    $this->Day_model->insert($insert_day);
                    $countUpdate++;
                  }
                }
              }
            }
          }
        }
        echo('add new day_exercise: ' . $countUpdate . ' for program' . $id);
      }

      public function ReadProgramProDetail($link)
      {
         // $link = 'https://fitnessprogramer.com/workout/chest-and-abs-workout/';
        //'https://fitnessprogramer.com/workout/5-min-total-abs-workout/';  // hardcode
        //https://fitnessprogramer.com/workout/chest-and-back-superset-workout/

        @$fullPage = file_get_contents($link);
        libxml_use_internal_errors(false);

        @$dom = new DOMDocument();
        @$dom->loadHTML($fullPage);
        $divList = $dom->getElementsByTagName("div");
  // $test = 0;
        $articleList = $dom->getElementsByTagName("article");
        $listTagH2 = $dom->getElementsByTagName('h2');

        $retVal = array();
        $retVal['goal'] = '';
        $retVal['level'] = '';
        $retVal['description'] = '';
        $retVal['listExercise'] = array();

        $count = 0;

        for($i = 0; $i < $articleList->length; $i++)
        {
            //"View Details 1 Sets 5 min Reps "
          $strTmp = $articleList->item($i)->nodeValue;
          $strTmp = trim(substr($strTmp, strpos($strTmp, 'View Details')+13, strlen($strTmp)));
          $retVal['listExercise'][$i]['set'] = '';
          $retVal['listExercise'][$i]['rep'] = '';
          $retVal['listExercise'][$i]['rest'] = '';
          // echo('str to get: ' . $strTmp . '<br />');
          if(strpos($strTmp, 'Sets') !== false){
              $set = trim(substr($strTmp, 0, strpos($strTmp, 'Sets')));
              // echo ('set: ' . $set);
              $retVal['listExercise'][$i]['set'] = $set;
              $strTmp = substr($strTmp, strpos($strTmp, 'Sets')+4); // refactor for set string
          }
          if(strpos($strTmp, 'Reps') !== false){
            $rep = trim(substr($strTmp, 0, strpos($strTmp, 'Reps')));
            // echo ('rep: ' . $rep);
            $retVal['listExercise'][$i]['rep'] = $rep;
            $strTmp = substr($strTmp, strpos($strTmp, 'Reps')+4); // refactor for set string
          }
          if(strpos($strTmp, 'Rest') !== false){
            $rest = trim(substr($strTmp, 0, strpos($strTmp, 'Rest')));
            // echo ('rest: ' . $rest);
            $retVal['listExercise'][$i]['rest'] = $rest;
          }
          // var_dump($retVal['listExercise'][$i]);
          // die;
        }

        $count = 0;
        foreach($listTagH2 as $tagH2){
          if($tagH2->getAttribute('class') == 'title'){
            $atag = $tagH2->childNodes->item(1);
            if($atag != null){
              $retVal['listExercise'][$count]['exercise_name'] = trim($atag->nodeValue);
              $exercise_link = trim(substr($atag->getAttribute('href'), 0, strpos($atag->getAttribute('href'), '/?pw'))).'/';
              $exercise = $this->Exercise_model->get_by(array('link_root' => $exercise_link))[0];
              $retVal['listExercise'][$count]['exercise_id'] = $exercise['id'];
              $count++;
            }
          }
        }
        // die;
        // foreach ($articleList as $eachArticle) {
          // $totalExercise = $articleList->length;
          // for($i = 1 ; $i <= $totalExercise; $i++){
          //
          // }
        // }

        return $retVal;
      }

          public function ReadWorkoutPlanDetailFromLink($link){

            // $link = 'https://fitnessprogramer.com/workout/beginner-bodyweight-workout/';
            @$fullPage = file_get_contents($link);
            libxml_use_internal_errors(false);

            @$dom = new DOMDocument();
            @$dom->loadHTML($fullPage);
            $divList = $dom->getElementsByTagName("div");
      // $test = 0;
            $articleList = $dom->getElementsByTagName("article");
            $listTagH2 = $dom->getElementsByTagName('h2');

            $retVal = array();
            $retVal['goal'] = '';
            $retVal['level'] = '';
            $retVal['description'] = '';
            $retVal['listExercise'] = array();

            $count = 0;
            foreach($divList as $eachDiv){
              //$retVal['listExercise'][$count]['set'] = '';
              if(strpos($eachDiv->getAttribute('class'),"page_subtitle")!== false){
                $tmpText = trim(str_replace("Workout /","", $eachDiv->textContent));
                $retVal['level'] = trim(substr($tmpText, strrpos($tmpText, '/')+1, strlen($tmpText)-strrpos($tmpText, '/')));
                $retVal['goal'] = trim(substr($tmpText, 0, strrpos($tmpText, '/')));
              }else if($eachDiv->getAttribute('class') == "workout_tips"){
                $retVal['description'] = trim($eachDiv->nodeValue);
              }
            }
            for($i = 0; $i < $articleList->length; $i++)
            {
                //"View Details 1 Sets 5 min Reps "
              $strTmp = $articleList->item($i)->nodeValue;
              $strTmp = trim(substr($strTmp, strpos($strTmp, 'View Details')+13, strlen($strTmp)));
              $retVal['listExercise'][$i]['set'] = '';
              $retVal['listExercise'][$i]['rep'] = '';
              $retVal['listExercise'][$i]['rest'] = '';
              // echo('str to get: ' . $strTmp . '<br />');
              if(strpos($strTmp, 'Sets') !== false){
                  $set = trim(substr($strTmp, 0, strpos($strTmp, 'Sets')));
                  // echo ('set: ' . $set);
                  $retVal['listExercise'][$i]['set'] = $set;
                  $strTmp = substr($strTmp, strpos($strTmp, 'Sets')+4); // refactor for set string
              }
              if(strpos($strTmp, 'Reps') !== false){
                $rep = trim(substr($strTmp, 0, strpos($strTmp, 'Reps')));
                // echo ('rep: ' . $rep);
                $retVal['listExercise'][$i]['rep'] = $rep;
                $strTmp = substr($strTmp, strpos($strTmp, 'Reps')+4); // refactor for set string
              }
              if(strpos($strTmp, 'Rest') !== false){
                $rest = trim(substr($strTmp, 0, strpos($strTmp, 'Rest')));
                // echo ('rest: ' . $rest);
                $retVal['listExercise'][$i]['rest'] = $rest;
              }
              // var_dump($retVal['listExercise'][$i]);
              // die;
            }

            $count = 0;
            foreach($listTagH2 as $tagH2){

              if($tagH2->getAttribute('class') == 'title'){

                $atag = $tagH2->childNodes->item(1);
                // var_dump($atag);
                if($atag != null){
                  $retVal['listExercise'][$count]['exercise_name'] = trim($atag->nodeValue);
                  $exercise_link = trim(substr($atag->getAttribute('href'), 0, strpos($atag->getAttribute('href'), '/?pw'))).'/';
                  $exercise = $this->Exercise_model->get_by(array('link_root' => $exercise_link))[0];
                  $retVal['listExercise'][$count]['exercise_id'] = $exercise['id'];
                  $count++;
                }
              }
            }
            // die;
            // foreach ($articleList as $eachArticle) {
              // $totalExercise = $articleList->length;
              // for($i = 1 ; $i <= $totalExercise; $i++){
              //
              // }
            // }


            return $retVal;
          }


        public function ReadPerPageAjax() {
          $params = $this->security->xss_clean($_REQUEST);

            //$this->data['check_error'] = -1;
            $link = $params['link'];
            //$link = 'https://fitnessprogramer.com/exercise/flutter-kick/';  // hardcode
            $totalGet = 0;
            // declare content to get:

            $ex = Array();
            @$fullPage = file_get_contents($link);
            libxml_use_internal_errors(false);

            @$dom = new DOMDocument();
            @$dom->loadHTML($fullPage);
            $tags = $dom->getElementsByTagName('h2');

            $imagesList = $dom->getElementsByTagName('img');

            $i = 0;
            foreach ($tags as $tag) {
              if($tag->getAttribute('class') == "title")
              {
                // $aChild = $tag->firstChild;
                if($tag->hasChildNodes()){
                  foreach($tag->childNodes as $eachNode)
                  {
                    // echo('--------');
                    // var_dump($eachNode);
                    if($eachNode->nodeName == "a"){
                      $ex[$i]['exercise_name'] = trim($eachNode->nodeValue);
                      $ex[$i]['exercise_link'] = trim($eachNode->getAttribute('href'));
                      foreach ($imagesList as $img) {
                        if($img->getAttribute('alt') == $ex[$i]['exercise_name'])
                        {
                          $ex[$i]['img_link'] = $img->getAttribute('src');
                          $ex[$i]['img_name'] = substr($ex[$i]['img_link'],strrpos($ex[$i]['img_link'], '/') + 1, strlen($ex[$i]['img_link']));

                          // download image:
                          $imgSave = PATH_DOWNLOAD . '/' . $ex[$i]['img_name'];
                          file_put_contents($imgSave, file_get_contents($ex[$i]['img_link']));
                          break;
                        }
                      }
                      $tmpInfor = $this->getDetailEx($ex[$i]['exercise_link']);
                      $ex[$i]['equipment'] = $tmpInfor['equipment'];
                      $ex[$i]['muscle'] = $tmpInfor['muscle'];
                      $ex[$i]['difficulty'] = $tmpInfor['difficulty'];
                      $tmpInfor['description'] = str_replace('Muscles worked in the ' . $ex[$i]['exercise_name'], 'Muscles worked in the ' . $ex[$i]['exercise_name'] . chr(13), $tmpInfor['description']);
                      $ex[$i]['description'] = $tmpInfor['description'];


                      // store to database:

                      $insert = array(
                          'exercise_name' => $ex[$i]['exercise_name'],
                          'image' => $ex[$i]['img_name'],
                          'equipment' => $ex[$i]['equipment'],
                          'muscle' => $ex[$i]['muscle'],
                          'difficulty' => $ex[$i]['difficulty'],
                          'description' => $ex[$i]['description'],
                          'link_root' => $ex[$i]['exercise_link']
                      );
                      $this->Exercise_model->insert($insert);
                      $i++;


                      break;
                    }
                  }

                  $totalGet++;
                  // break; // for demo get 1 data only
                }
              }
            }
            echo('total get ' . $totalGet . ' ');
            // var_dump($ex);
            // die;

        }
    public function getDetailEx($link){
      // $link = 'https://fitnessprogramer.com/exercise/clap-push-up/';  // hardcode
      @$fullPage = file_get_contents($link);
      libxml_use_internal_errors(false);

      @$dom = new DOMDocument();
      @$dom->loadHTML($fullPage);
      $divList = $dom->getElementsByTagName('div');

      $retVal = array();
      $retVal['muscle'] = '';
      $retVal['difficulty'] = '';
      $retVal['equipment'] = '';
      $retVal['description'] = '';

      foreach($divList as $eachDiv){

        if($retVal['description'] == '' && strpos($eachDiv->getAttribute('class'),"exercise_content")!== false){
          // echo('<pre>');
          // var_dump(str_replace('\n', chr(13),$eachDiv->textContent));
          // die;
            $retVal['description'] = trim($eachDiv->textContent);
        }


        if($retVal['muscle'] == '' && strpos($eachDiv->getAttribute('class'),"muscle_groups")!== false){
          //if($eachDiv->hasChildNodes()){
            foreach($eachDiv->childNodes as $eachDivGrContent)
            {
              if($eachDivGrContent->nodeName == "div"){
                foreach($eachDivGrContent->childNodes as $eachUl){
                  if($eachUl->nodeName == "ul")
                  {
                    foreach($eachUl->childNodes as $eachLi){
                      if(trim($eachLi->nodeValue) != ''){
                          $retVal['muscle'] .= $eachLi->nodeValue . ',';
                      }
                    }
                    break;
                  }
                }
                break;
              }
            }

            $retVal['muscle'] = trim($retVal['muscle'], ',');

        }else if($retVal['difficulty'] == '' && strpos($eachDiv->getAttribute('class'),"difficulties")!== false){
            //if($eachDiv->hasChildNodes()){
              foreach($eachDiv->childNodes as $eachDivGrContent)
              {
                if($eachDivGrContent->nodeName == "div"){
                  foreach($eachDivGrContent->childNodes as $eachUl){
                    if($eachUl->nodeName == "ul")
                    {
                      foreach($eachUl->childNodes as $eachLi){
                        if(trim($eachLi->nodeValue) != ''){
                            $retVal['difficulty'] .= $eachLi->nodeValue . ',';
                        }
                      }
                      break;
                    }
                  }
                  break;
                }
              }

              //$grContent = $eachDiv->childNodes->getElementsByTagName('div');
              $retVal['difficulty'] = trim($retVal['difficulty'], ',');
        }else if($retVal['equipment'] == '' && strpos($eachDiv->getAttribute('class'),"equipments")!== false){
            //if($eachDiv->hasChildNodes()){
              foreach($eachDiv->childNodes as $eachDivGrContent)
              {
                if($eachDivGrContent->nodeName == "div"){
                  foreach($eachDivGrContent->childNodes as $eachUl){
                    if($eachUl->nodeName == "ul")
                    {
                      foreach($eachUl->childNodes as $eachLi){
                        if(trim($eachLi->nodeValue) != ''){
                            $retVal['equipment'] .= $eachLi->nodeValue . ',';
                        }
                      }
                      break;
                    }
                  }
                  break;
                }
              }
              $retVal['equipment'] = trim($retVal['equipment'], ',');
        }
      }
      return $retVal;
    }

     public function readUrlBy($url, $tagSearch, $classSearch){

               @$fullPage = file_get_contents($url);
               libxml_use_internal_errors(false);

               @$dom = new DOMDocument();
               @$dom->loadHTML($fullPage);
               $tags = $dom->getElementsByTagName($tagSearch);

               $retVal = '';
               foreach ($tags as $tag) {

                 // for each product not last
                 if(strpos($tag->getAttribute('class'), $classSearch) !== false){ // for exercise gif
                   // echo($tag->nodeValue);
                   // echo('<br />');

                     $retVal = trim($tag->nodeValue);

                 }
               }

               return($retVal);
     }

     public function UpdateEquipAjax(){
       $results = $this->Exercise_model->get_all();
       $countUpdate = 0;
       foreach($results as $item){
         $id = $item['id'];
         $link = $item['link_root'];
         $update = array(
           'equipment' => $this->getEquipment($link)
         );
         $this->Exercise_model->update($update, $id);
         $countUpdate++;
       }


       // if ($_POST['password']) {
       //     $update['password'] = md5($_POST['password']);
       // }

       echo($countUpdate);
     }


     public function getEquipment($link){
       // $link = 'https://fitnessprogramer.com/exercise/clap-push-up/';  // hardcode
       @$fullPage = file_get_contents($link);
       libxml_use_internal_errors(false);

       @$dom = new DOMDocument();
       @$dom->loadHTML($fullPage);
       $divList = $dom->getElementsByTagName('div');

       $retVal = array();
       $retVal['equipment'] = '';

       foreach($divList as $eachDiv){
         if($retVal['equipment'] == '' && strpos($eachDiv->getAttribute('class'),"equipments")!== false){
             //if($eachDiv->hasChildNodes()){
               foreach($eachDiv->childNodes as $eachDivGrContent)
               {
                 if($eachDivGrContent->nodeName == "div"){
                   foreach($eachDivGrContent->childNodes as $eachUl){
                     if($eachUl->nodeName == "ul")
                     {
                       foreach($eachUl->childNodes as $eachLi){
                         if(trim($eachLi->nodeValue) != ''){
                             $retVal['equipment'] .= $eachLi->nodeValue . ',';
                         }
                       }
                       break;
                     }
                   }
                   break;
                 }
               }
               $retVal['equipment'] = trim($retVal['equipment'], ',');
         }
       }
       return $retVal['equipment'];
     }


    public function UpdateProgramDetailAjax(){
      $results = $this->Program_model->get_all();
      $countUpdate = 0;
      foreach($results as $item){
        $id = $item['id'];
        $link = $item['link_root'];

          $program_update = $this->ReadProgramDetailFromLink($link);
          // var_dump($program_update);
          // die;
        // $update = array();
        // $this->Program_model->update($update, $id);
        $update_program = array(
          'goal' => $program_update['goal'],
          'level' => $program_update['level'],
          'description' => $program_update['description'],
        );
        $this->Program_model->update($update_program, $id);
        // insert Day_model (add exercise - set rep rest)

        for ($i = 0 ; $i < count($program_update['listExercise']) ; $i++) {
          $insert_day = array(
            'program_id' => $id,
            'exercise_id' => $program_update['listExercise'][$i]['exercise_id'],
            'set' => $program_update['listExercise'][$i]['set'],
            'rep' => $program_update['listExercise'][$i]['rep'],
            'rest' => $program_update['listExercise'][$i]['rest'],
            'week_number' => 0,
            'day_number' => 0,
            'image_type' => '',
            'day_name' => '',
            'description' => '',
          );
          $this->Day_model->insert($insert_day);
        }

        $countUpdate++;

      }
      echo($countUpdate);
    }

    public function ReadProgramDetailFromLink($link){

      // $link = 'https://fitnessprogramer.com/workout/beginner-bodyweight-workout/';
      //'https://fitnessprogramer.com/workout/5-min-total-abs-workout/';  // hardcode
      //https://fitnessprogramer.com/workout/chest-and-back-superset-workout/

      @$fullPage = file_get_contents($link);
      libxml_use_internal_errors(false);

      @$dom = new DOMDocument();
      @$dom->loadHTML($fullPage);
      $divList = $dom->getElementsByTagName("div");
// $test = 0;
      $articleList = $dom->getElementsByTagName("article");
      $listTagH2 = $dom->getElementsByTagName('h2');

      $retVal = array();
      $retVal['goal'] = '';
      $retVal['level'] = '';
      $retVal['description'] = '';
      $retVal['listExercise'] = array();

      $count = 0;
      foreach($divList as $eachDiv){
        //$retVal['listExercise'][$count]['set'] = '';
        if(strpos($eachDiv->getAttribute('class'),"page_subtitle")!== false){
          $tmpText = trim(str_replace("Workout /","", $eachDiv->textContent));
          $retVal['level'] = trim(substr($tmpText, strrpos($tmpText, '/')+1, strlen($tmpText)-strrpos($tmpText, '/')));
          $retVal['goal'] = trim(substr($tmpText, 0, strrpos($tmpText, '/')));
        }else if($eachDiv->getAttribute('class') == "workout_tips"){
          $retVal['description'] = trim($eachDiv->nodeValue);
        }
      }
      for($i = 0; $i < $articleList->length; $i++)
      {
          //"View Details 1 Sets 5 min Reps "
        $strTmp = $articleList->item($i)->nodeValue;
        $strTmp = trim(substr($strTmp, strpos($strTmp, 'View Details')+13, strlen($strTmp)));
        $retVal['listExercise'][$i]['set'] = '';
        $retVal['listExercise'][$i]['rep'] = '';
        $retVal['listExercise'][$i]['rest'] = '';
        // echo('str to get: ' . $strTmp . '<br />');
        if(strpos($strTmp, 'Sets') !== false){
            $set = trim(substr($strTmp, 0, strpos($strTmp, 'Sets')));
            // echo ('set: ' . $set);
            $retVal['listExercise'][$i]['set'] = $set;
            $strTmp = substr($strTmp, strpos($strTmp, 'Sets')+4); // refactor for set string
        }
        if(strpos($strTmp, 'Reps') !== false){
          $rep = trim(substr($strTmp, 0, strpos($strTmp, 'Reps')));
          // echo ('rep: ' . $rep);
          $retVal['listExercise'][$i]['rep'] = $rep;
          $strTmp = substr($strTmp, strpos($strTmp, 'Reps')+4); // refactor for set string
        }
        if(strpos($strTmp, 'Rest') !== false){
          $rest = trim(substr($strTmp, 0, strpos($strTmp, 'Rest')));
          // echo ('rest: ' . $rest);
          $retVal['listExercise'][$i]['rest'] = $rest;
        }
        // var_dump($retVal['listExercise'][$i]);
        // die;
      }

      $count = 0;
      foreach($listTagH2 as $tagH2){

        if($tagH2->getAttribute('class') == 'title'){

          $atag = $tagH2->childNodes->item(1);
          // var_dump($atag);
          if($atag != null){
            $retVal['listExercise'][$count]['exercise_name'] = trim($atag->nodeValue);
            $exercise_link = trim(substr($atag->getAttribute('href'), 0, strpos($atag->getAttribute('href'), '/?pw'))).'/';
            $exercise = $this->Exercise_model->get_by(array('link_root' => $exercise_link))[0];
            $retVal['listExercise'][$count]['exercise_id'] = $exercise['id'];
            $count++;
          }
        }
      }
      // die;
      // foreach ($articleList as $eachArticle) {
        // $totalExercise = $articleList->length;
        // for($i = 1 ; $i <= $totalExercise; $i++){
        //
        // }
      // }


      return $retVal;
    }
    public function GetJv(){
      $params = $this->security->xss_clean($_REQUEST);

        //$this->data['check_error'] = -1;
        $link = $params['link'];

        @$fullPage = file_get_contents($link);
        libxml_use_internal_errors(false);

        @$dom = new DOMDocument();
        @$dom->loadHTML($fullPage);
        $divList = $dom->getElementsByTagName("div");
    }
}
