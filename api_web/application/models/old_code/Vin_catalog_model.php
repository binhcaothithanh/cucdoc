<?php

class Vin_Catalog_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'vin_question_categories';
      }

  public function detect($question){
    $cats = $this->db->get('vin_question_categories')->result();
    $score = [];

    foreach($cats as $c){
      if(!$c->keywords) continue;
      foreach(explode(',',$c->keywords) as $kw){
        if(mb_stripos($question,$kw)!==false){
          $score[$c->name] = ($score[$c->name] ?? 0) + 1;
        }
      }
    }

    if(empty($score)) return 'general';
    arsort($score);
    return array_key_first($score);
  }
}
