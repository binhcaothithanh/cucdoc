<?php

class Report_Product_Model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'report_product';
    }

    function update_view($product_id, $product_name) {
        $source = @$_COOKIE['source'] ? $_COOKIE['source'] : 'other';
        $cond = array('source' => $source, 'product_id' => $product_id, 'date' => date('Y-m-d'));
        $this->db->set('view', 'view + 1', false)->where($cond)->update($this->table_name);
        if (!$this->db->affected_rows()) {
            $cond['product_name'] = $product_name;
            $cond['view'] = 1;
            $this->db->insert($this->table_name, $cond);
        }
    }

    function get_order_report($cond) {
        return $this->db->select('device_type,source,campaign,count(id) as count')
                        ->where($cond)
                        ->group_by('device_type,source,campaign')
                        ->order_by('source,campaign')
                        ->get('order')->result_array();
    }

    function get_global_report($date) {
        return $this->db->select("DATE_FORMAT(`date`, '%d-%m-%Y') as date_temp,sum(total) as global_total,sum(total_cogs) as global_total_cogs", FALSE)
                        ->where('status = "success" and EXTRACT(YEAR_MONTH from `date`) = "' . $date . '"')
                        ->group_by('date_temp')
                        ->get('order')->result_array('date_temp');
    }

}
