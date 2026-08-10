<?php

class Staff_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'coffee_staff';
    }

}
