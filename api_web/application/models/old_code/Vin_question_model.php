<?php

class Vin_question_model extends My_Model {

    public function countToday($user_id){
      return $this->db
        ->where('user_id',$user_id)
        ->where('DATE(created_at)',date('Y-m-d'))
        ->count_all_results('vin_question_answer');
    }

    public function save($data){
      $this->db->insert('vin_question_answer',$data);
    }

    public function randomOldQuestion($user_id){
      return $this->db->query("
        SELECT question FROM vin_question_answer
        WHERE user_id = $user_id
        AND created_at <= NOW() - INTERVAL 1 DAY
        ORDER BY RAND() LIMIT 1
      ")->row();
    }
  }
