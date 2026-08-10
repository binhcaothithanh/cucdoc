<?php

class FONTEND_Controller extends CI_Controller {

    function __construct($is_ajax = false) {
        parent::__construct();
        $this->load->library('mobiledetect');
        $this->data['is_mobile'] = 0;
        $this->folder = 'web/';
        if (@$this->mobiledetect->detect_mobile()) {
            $this->data['is_mobile'] = 1;
//            $this->folder = 'wap/';
//            $this->template->set_template('wap');
        }
        if ($is_ajax == false)
            $this->ini_info();
        if (isset($_GET['utm_source'])) {
            setcookie("source", @$_GET['utm_source'], (time() + (86400 * 2)), '/', $_SERVER['SERVER_NAME']);
            setcookie("campaign", @$_GET['utm_campaign'], (time() + (86400 * 2)), '/', $_SERVER['SERVER_NAME']);
        }
        $this->data['map_product_status'] = array(1 => 'best-seller-cor.png', 2 => 'new-product-cor.png');




        $this->memcache = new Memcached();
        $this->memcache->addServer('localhost', 11211);
    }

    private function ini_info() {
        $this->load->model(array('product_model', 'category_model', 'user_model'));

        $this->load->library('my_category');
        $this->data['categories'] = $this->my_category->build_list_cat();
        $this->limit = LIMIT_PRODUCT;
        $this->data['current_url'] = str_replace('/index.php', '', current_url());


        $this->data['total_money'] = intval($this->session->userdata('total_money'));
        $this->data['total_count'] = intval($this->session->userdata('total_count'));
        $this->data['seo'] = unserialize(file_get_contents(APPPATH . 'cache/seo_home'));
        $this->data['url_image'] = base_url() . 'assets/user/images/logo.png';
    }

    protected function get_page($cur_page = 0, $total_rows = 0, $limit = 10) {
        $this->load->library('my_pagination');
        $config['per_page'] = $limit;
        $config['cur_page'] = $cur_page;
        $config['total_rows'] = $total_rows;
        $this->my_pagination->initialize($config);
        return $this->my_pagination->create_links();
    }

}
