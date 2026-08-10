<?php

class Project_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'project';
    }

    // function get_count() { // 
    //     $data = $this->db->select('sum(count) as count,product_id as id')
    //                     ->from('sku')->group_by('product_id')
    //                     ->get()->result_array();
    //     @$this->db->update_batch('product', $data, 'id');
    // }

    function set_total_Project($Project_id) {
        $data = $this->db->select('sum(price*count) as total,sum(count*cogs) as total_cogs')
                        ->where('Project_id = ' . $Project_id)
                        ->get('Project_product')->row_array();
        $total = intval(@$data['total']);
        $total_cogs = intval(@$data['total_cogs']);
        $this->db->update('Project', array('total' => $total, 'total_cogs' => $total_cogs), array('id' => $Project_id));
    }

    function get_count_by_status($cond) {
        return $this->db->select('count(id) as count')
                        ->where($cond)->get($this->table_name)->row_array();
    }
}
