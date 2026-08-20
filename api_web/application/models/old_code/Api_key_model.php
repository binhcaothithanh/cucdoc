<?php

class Api_key_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'api_key';
    }

}
