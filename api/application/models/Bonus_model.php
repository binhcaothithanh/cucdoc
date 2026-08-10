<?php

class Bonus_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'bonus';
    }

    function get_report($cond = '') {
        return $this->db->select('username,status,count(id) as count_status')
                        ->where($cond)
                        ->group_by('status')
                        ->get($this->table_name)
                        ->result_array();
    }

}
