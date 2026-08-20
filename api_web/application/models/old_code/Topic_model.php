<?php

class Topic_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'topic';
    }

}
