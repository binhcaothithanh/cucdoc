<?php

class Attribute_Type_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'attribute_type';
    }

}
