<?php

class Order_Product_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'order_product';
    }

    function count_order($order_id) {
        $data = $this->db->select('count(id) as count')
                        ->get_where($this->table_name, array('order_id' => $order_id))->row_array();
        return intval(@($data['count']));
    }

}
