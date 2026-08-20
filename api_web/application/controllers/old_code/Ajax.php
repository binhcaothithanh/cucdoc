<?php

class Ajax extends FONTEND_Controller {

    public function __construct() {
        parent::__construct(true);
        $this->load->model('product_model');
    }

    function load_more() {      
        $page = intval(@$_POST['page']);        
        if ($page > 0) {
            $key = md5('products_home_page' . $page . $_SERVER['SERVER_NAME']);
            $html = @$this->memcache->get($key);
            if ($html === false) {
                $this->load->model('product_model');
                $data['products'] = $this->product_model->get_for_fontend(LIMIT_PRODUCT * ($page - 1), LIMIT_PRODUCT , null, 'count DESC');
                $html = $this->load->view('web/load_more', $data, true);
                @$this->memcache->set($key, $html, false, SHORT_TIME);
            }
            echo $html;
        }
    }

}
