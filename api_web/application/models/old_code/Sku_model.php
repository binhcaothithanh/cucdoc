<?php

class Sku_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'sku';
    }

    function get_list_image($product_id) {
        return $this->db->distinct('color')->select('image,color')
                        ->where('product_id', $product_id)
                        ->get($this->table_name)->result_array();
    }

    function get_sku_price($ids) {
        return $this->db->select('s.id,p.price')
                        ->from('sku as s')
                        ->join('product as p', 's.product_id = p.id')
                        ->where('s.id in (' . $ids . ')')
                        ->get()->result_array();
    }

    function re_count_product() {
        $data = $this->db->select('sum(count) count,product_id as id')->group_by('product_id')
                        ->get('sku')->result_array();     
        if (!empty($data))
            $this->db->update_batch('product', $data, 'id');
    }

}
