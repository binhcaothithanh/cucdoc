<?php

class Gallery_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'gallery';
    }

}
