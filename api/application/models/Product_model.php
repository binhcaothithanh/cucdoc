<?php

class Product_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'product';
    }

    function update_count_product($product_id) {
        $data = $this->db->select('sum(count) total_count')->where('product_id', $product_id)
                        ->get('sku')->row_array();
        $this->db->update('product', array('count' => intval(@$data['total_count'])), array('id' => $product_id));
    }

    function get_for_fontend($offset, $limit, $cond = null, $order = 'id DESC') {
        if ($cond != null) {
            $this->db->where($cond);
        }
        return $this->db->select('id,title,alias,image,folder,price,price_compare,is_hot,product_status,count,can_buy')
                        ->limit($limit, $offset)->order_by($order)
                        ->get($this->table_name)->result_array();
    }

    function get_for_cart($sku_ids) {
        return $this->db->select('p.id as product_id,p.title as name,s.image as img,p.alias,p.price,p.folder,s.id as sku_id,s.color,s.size,s.count')
                        ->from('sku as s')->where('s.id in(' . $sku_ids . ')')
                        ->join('product as p', 's.product_id = p.id')
                        ->get()->result_array();
    }

    function get_for_insert($sku_ids) {
        return $this->db->select('p.id as product_id,p.title as name,p.cogs,s.id as sku_id,p.price,s.color,s.size,s.count')
                        ->from('sku as s')->where('s.id in(' . $sku_ids . ')')
                        ->join('product as p', 's.product_id = p.id')
                        ->get()->result_array('sku_id');
    }

}
