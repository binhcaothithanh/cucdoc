<?php
// die('goto model');
class Vin_Users_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        die('goto model');
        $this->table_name = 'vin_users';
    }
    public function getOrCreate($device_id){
      $q = $this->db->get_where('vin_users',['device_id'=>$device_id])->row();
      if($q) return $q->id;

      $this->db->insert('vin_users',['device_id'=>$device_id]);
      return $this->db->insert_id();
    }
  }
