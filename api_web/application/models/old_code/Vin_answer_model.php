<?php

class Vin_Answer_Pool_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'vin_answer_pool';
    }
    public function randomAnswer($category){
      $type = ['yes','no','neutral'][array_rand(['yes','no','neutral'])];

      $q = $this->db->order_by('RAND()')
        ->get_where('answer_pool',[
          'category'=>$category,
          'answer_type'=>$type
        ])->row();

      if(!$q){
        $q = $this->db->order_by('RAND()')
          ->get_where('answer_pool',['category'=>'general'])->row();
      }

      return [$type,$q->answer_text];
    }

    public function suggest(){
      return $this->db
        ->order_by('RAND()')
        ->get_where('suggested_questions',['active'=>1])
        ->row();
    }
  }
