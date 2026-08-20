<?php

class Ebook_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'ebook';
    }

    public function get_random_page_by_type($type = 'page') {
        $this->db->where('page_type', $type);
        $this->db->order_by('RAND()'); // Raw SQL order
        $this->db->limit(1);
        $query = $this->db->get('ebook');
        return $query->row(); // use row_array() if you prefer an array
    }

}
// change file name
