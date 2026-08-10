<?php

/**
 * @property Product_Model $product_model
 */
class Chat extends FONTEND_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Vin_Question_Answer_Model');
        // $this->load->model('vin_category_model');
        // $this->load->model('vin_answer_pool_model');
        // $this->load->model('vin_users_model');
    }

      const DAILY_LIMIT = 5;

      public function ask(){

        $question = trim($this->input->post('question'));
        $device = $this->input->post('device_id');

        // $this->load->model([
        //   'vin_users_model','vin_question_model',
        //   'vin_category_model','vin_answer_pool_model'
        // ]);


die('3');
        if(mb_strlen($question) < 6){
          $s = $this->Vin_Answer_Pool_Model->suggest();
          echo json_encode(['error'=>"Câu hỏi chưa rõ. Gợi ý: ".$s->question_text]);
          return;
        }

        $user_id = $this->Vin_Users_Model->getOrCreate($device);

        if($this->Vin_Question_Model->countToday($user_id) >= self::DAILY_LIMIT){
          echo json_encode(['error'=>"Hôm nay bạn đã hỏi đủ rồi."]);
          return;
        }

        $category = $this->Vin_Category_Model->detect($question);
        [$type,$answer] = $this->Vin_Answer_Pool_Model->randomAnswer($category);

        $this->Vin_Question_Model->save([
          'user_id'=>$user_id,
          'question'=>$question,
          'normalized_question'=>mb_strtolower($question),
          'category'=>$category,
          'answer_type'=>$type,
          'answer_text'=>$answer
        ]);

        echo json_encode([
          'question'=>$question,
          'answer'=>$answer,
          'type'=>$type
        ]);
      }
    }
