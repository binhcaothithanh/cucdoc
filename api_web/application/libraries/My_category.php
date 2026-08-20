<?php

class My_Category {

    function __construct() {
        $this->CI = $this->CI = & get_instance();
    }

    function build_list_cat() {
        $this->CI->load->model('category_model');

        //get infor for item first
        $parent = $this->CI->category_model->get_by('parent_id = 0', 'order_by asc', 'id');

        // get list all item not first item
        $child = $this->CI->category_model->get_by('parent_id != 0', 'order_by asc');
        $i = 0;
        foreach ($child as $item) {

            $parent[$item['parent_id']]['childs'][] = $item;
            @$parent[$item['parent_id']]['child_ids'].=$item['id'] . ',';
            if(!isset($parent[$item['parent_id']]['id'])){
              // join for some lack data
              $parent[$item['parent_id']] = array_merge($parent[$item['parent_id']], array_values($this->CI->category_model->get_by('id = ' . $item['parent_id']))[0]);
            }
        }
        
    return $parent;
    }

    function build_list_cat_news() {
        $this->CI->load->model('category_news_model');
        $parent = $this->CI->category_news_model->get_by('parent RLIKE "^([0-9]+,)$"', 'order ASC');
        $child = $this->CI->category_news_model->get_by('parent RLIKE "^([0-9]+,)([0-9]+,)+$"', 'order ASC');
        foreach ($parent as &$item) {
            foreach ($child as $k => $c) {
                $pattern = '/^' . $item['parent'] . '[0-9]+,/';
                if (preg_match($pattern, $c['parent']) != 0) {
                    $item['child'][] = $c;
                    unset($child[$k]);
                }
            }
        }
        return $parent;
    }

    function get_child_by_parent($parent_id){
      $this->CI->load->model('category_model');
      $list_child = $this->CI->category_model->get_by('parent_id in (' . trim($parent_id, ',') . ')');
      $list_id_child = '';
        foreach($list_child as $eachChild){
           $list_id_child .= $eachChild['id'] . ',';
      }
      return $list_id_child;
    }

    function build_list_location() {
        $this->CI->load->model('location_model');
        $parent = $this->CI->location_model->get_by('parent RLIKE "^([0-9]+,)$"', 'order ASC');
        $child = $this->CI->location_model->get_by('parent RLIKE "^([0-9]+,)([0-9]+,)+$"', 'order ASC');
        foreach ($parent as &$item) {
            foreach ($child as $k => $c) {
                $pattern = '/^' . $item['parent'] . '[0-9]+,/';
                if (preg_match($pattern, $c['parent']) != 0) {
                    $item['child'][] = $c;
                    unset($child[$k]);
                }
            }
        }
        return $parent;
    }

}
