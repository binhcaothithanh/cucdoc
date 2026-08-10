<?php

class Timesheet_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'coffee_timesheet';
    }

    public function insert_data_if_date_not_exists($date, $data) {
       // Check if the date already exists
       $this->db->from('coffee_timesheet');
       $this->db->where(['created_date'=> $date, 'user_id' => $data['user_id']]);
       $query = $this->db->get();

       // If no record exists with this date, insert the data
       if ($query->num_rows() == 0) {
           $this->db->set($data);
           $this->db->insert('coffee_timesheet');
           return $this->db->insert_id(); // Return the ID of the inserted record
       } else {
           return false; // Or handle the logic when the date already exists
       }
   }

}
