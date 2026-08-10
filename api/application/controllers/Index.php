<?php

/**
 * @property Product_Model $product_model
 */
class Index extends FONTEND_Controller {

    public function __construct() {
        parent::__construct();


        // bind data for menu
        $key = md5('category_parents_full_' . $_SERVER['SERVER_NAME']);
        $this->data['category_parents_full'] = $this->memcache->get($key);
        if($this->data['category_parents_full'] == false){
          $this->load->library('my_category');
          $this->data['category_parents_full'] = $this->my_category->build_list_cat();
          @$this->memcache->set($key, $this->data['category_parents_full'], false, LONG_TIME);
        }

        //get footer:

        $key = md5('footer' . $_SERVER['SERVER_NAME']);
        $this->data['footer'] = @$this->memcache->get($key);
        if ($this->data['footer'] === false) {
          $this->load->model('page_model');
          $this->data['footer'] = $this->page_model->get_row_by(array('alias' => 'footer'));
          @$this->memcache->set($key, $this->data['footer'], false, LONG_TIME);
        }

    }


    function index() {
        // full cat by hirachiavy


        // list parent category and products correspond:
        // $key = md5('list_cat_products_' . $_SERVER['SERVER_NAME']);
        // $this->data['list_cat_products'] = $this->memcache->get($key);
        // if($this->data['list_cat_products'] == false){
        //   $this->data['list_cat_products'] = $this->category_model->get_by('parent_id = ' . CATEGORY_ROOT_ID, 'order_by asc');
        //
        //   $this->load->library('my_category');
        //
        //
        //   $i = 0;
        //   foreach($this->data['list_cat_products'] as $cat){
        //     $list_id_child = $cat['id'] . ',';
        //     $list_id_return = '';
        //
        //     $list_id_return = $cat['id'];
        //     while($list_id_return != ''){
        //       $list_id_return = $this->my_category->get_child_by_parent($list_id_return);
        //       $list_id_child .= $list_id_return;
        //     }
        //     $list_id_child = trim($list_id_child, ',');
        //
        //     // command = select * from product where cat_id in( '. $list_id_child .') order by id asc LIMIT 10
        //     $command = 'SELECT * FROM product where cat_id IN('. $list_id_child .') ORDER BY count desc';
        //
        //     $this->data['list_cat_products'][$i]['10_product'] = $this->product_model->query_row($command);
        //     $i++;
        //   }
        //    @$this->memcache->set($key, $this->data['list_cat_products'], false, LONG_TIME);
        // }

        // $key = md5('get_slider_' . $_SERVER['SERVER_NAME']);
        // $this->data['sliders'] = @$this->memcache->get($key);
        // if ($this->data['sliders'] === false) {
        //     $this->load->model('gallery_model');
        //     $this->data['sliders'] = $this->gallery_model->get_by('type = "slider"');
        //     @$this->memcache->set($key, $this->data['sliders'], false, LONG_TIME);
        // }
        //
        // $key = md5('banners' . $_SERVER['SERVER_NAME']);
        // $this->data['banners'] = @$this->memcache->get($key);
        // if ($this->data['banners'] === false) {
        //     $this->load->model('gallery_model');
        //     $this->data['banners'] = $this->gallery_model->get_by('type = "banner"');
        //     @$this->memcache->set($key, $this->data['banners'], false, LONG_TIME);
        // }


        $this->template->write_view('content_block', $this->folder . 'home', $this->data);
        $this->template->render();
    }

    function backHome(){
        $this->load->view( $this->folder . 'home', $this->data);
    }

    function page($alias = '') {
        if ($alias == 'assets') {
            header("HTTP/1.0 404 Not Found");
            return false;
        }
        $this->load->model('page_model');
        $alias = strtolower($alias);
        $this->data['page'] = $this->page_model->get_row_by(array('alias' => $alias));
        if (!empty($this->data['page'])) {
            $this->data['seo']['seo_title'] = $this->data['page']['title'];
            $this->template->write_view('content_block', 'all/page', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    function donate(){
        $this->template->write_view('content_block', 'all/donate', $this->data);
        $this->template->render();
    }

    function search() {
        if (isset($_GET['q'])) {
            $this->data['keyword'] = $keyword = ($this->security->xss_clean($_GET['q']));
            $this->data['seo']['seo_title'] = 'Kết quả tìm kiếm với từ khoá ' . $keyword;

            $key = md5('search_' . $keyword . $_SERVER['SERVER_NAME']);
            $this->data['results'] = @$this->memcache->get($key);
            if ($this->data['results'] === false) {
                $this->load->model('product_model');
                $this->data['results'] = $this->product_model->get_for_fontend(0, $this->limit * 10, "title like '%$keyword%' or id = " . intval($keyword), 'count DESC');
                @$this->memcache->set($key, $this->data['results'], false, LONG_TIME);
            }

            $this->template->write_view('content_block', 'all/search', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    function category($alias = '', $page = 1) {
        $key = md5('category_' . $alias . $_SERVER['SERVER_NAME']);
        $this->data['cat'] = @$this->memcache->get($key);
        if ($this->data['cat'] === false) {
            //$this->load->model('category_model');
            $this->data['cat'] = $this->category_model->get_row_by(array('alias' => $alias));
            @$this->memcache->set($key, $this->data['cat'], false, LONG_TIME);
        }
        if (!empty($this->data['cat'])) {
            $this->data['seo']['seo_title'] = $this->data['cat']['seo_title'] ? $this->data['cat']['seo_title'] : $this->data['cat']['title'];
            $this->data['cat']['meta_description'] ? $this->data['seo']['meta_description'] = $this->data['cat']['meta_description'] : '';
            $this->data['cat']['meta_keyword'] ? $this->data['seo']['meta_keyword'] = $this->data['cat']['meta_keyword'] : '';
            $this->data['page_title'] = 'Danh mục ' . $this->data['cat']['title'];
            $this->data['meta_descript'] = $this->data['cat']['meta_description'];
            $cat_temp = @$this->data['categories'][$this->data['cat']['id']];


            $list_id_child = $this->data['cat']['id'] . ',';

            $list_id_return = $this->data['cat']['id'];
            while($list_id_return != ''){
              $list_id_return = $this->my_category->get_child_by_parent($list_id_return);
              $list_id_child .= $list_id_return;
            }
            $list_id_child = trim($list_id_child, ',');


            if ($list_id_child)
                $cond = 'cat_id in (' . $list_id_child . ')';
            else
                $cond = 'cat_id = ' . $this->data['cat']['id'];

            $page = intval($page);
            $page = $page > 0 ? $page : 1;

            $key = md5('get_for_fontend_' . $page . $alias . $_SERVER['SERVER_NAME']);
            $this->data['products'] = @$this->memcache->get($key);
            if ($this->data['products'] === false) {
                //$this->load->model('product_model');
                $this->data['products'] = $this->product_model->get_for_fontend(($page - 1) * $this->limit, $this->limit, $cond, 'count DESC');
                @$this->memcache->set($key, $this->data['products'], false, LONG_TIME);
            }

            $key = md5('get_total_rows' . $cond . $_SERVER['SERVER_NAME']);
            $total_row = @$this->memcache->get($key);
            if ($total_row === false) {
                //$this->load->model('product_model');
                $total_row = $this->product_model->get_total_rows($cond);
                @$this->memcache->set($key, $total_row, false, LONG_TIME);
            }

            $this->get_page_product($this->limit, '/danh-muc/' . $this->data['cat']['alias'], $total_row);
            if (isset($this->data['products'][0]))
                $this->data['url_image'] = base_url() . 'assets/upload/product/' . $this->data['products'][0]['folder'] . '/' . $this->data['products'][0]['image'];
            $this->template->write_view('content_block', $this->folder . 'category', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    private function get_page_product($limit, $url, $count, $uri_segment = 3) {

        $this->load->library('my_pagination');
        $config['per_page'] = $limit;
        $config['base_url'] = $url;
        $config['uri_segment'] = $uri_segment;
        $config['use_page_numbers'] = true;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $config['total_rows'] = $count;
        $config['first_link'] = '&laquo; Trang đầu';
        $config['last_link'] = 'Trang cuối &raquo;';
        $this->my_pagination->initialize($config);
        $this->data['links'] = $this->my_pagination->create_links();
    }

    function product($id) {
        $id = intval($id);
        $key = md5('get_product_by_key' . $id . $_SERVER['SERVER_NAME']);
        $this->data['product'] = @$this->memcache->get($key);
        if ($this->data['product'] === false) {
            $this->load->model('product_model');
            $this->data['product'] = $this->product_model->get_by_key($id);
            @$this->memcache->set($key, $this->data['product'], false, SHORT_TIME);
        }

        if (!empty($this->data['product'])) {
            $this->load->model('report_product_model');
            $this->report_product_model->update_view($id, $this->data['product']['title']);

            $key = md5('list_image_product' . $id . $_SERVER['SERVER_NAME']);
            $this->data['list_image'] = @$this->memcache->get($key);
            if ($this->data['list_image'] === false) {
                $this->load->model('image_model');
                $this->data['list_image'] = $this->image_model->get_by('product_id = ' . $id);
                @$this->memcache->set($key, $this->data['list_image'], false, SHORT_TIME);
            }

            $key = md5('category_' . $this->data['product']['cat_id'] . $_SERVER['SERVER_NAME']);
            $cat = $this->data['cat'] = @$this->memcache->get($key);
            if ($this->data['cat'] === false) {
                $this->load->model('category_model');
                $cat = $this->data['cat'] = $this->category_model->get_by_key($this->data['product']['cat_id']);
                @$this->memcache->set($key, $this->data['cat'], false, LONG_TIME);
            }

            $this->data['cat_parent'] = @$this->data['categories'][$cat['parent_id']];


            $key = md5('other_products_' . $id . $_SERVER['SERVER_NAME']);
            $this->data['other_products'] = @$this->memcache->get($key);
            if ($this->data['other_products'] === false) {
                $this->load->model('product_model');
                $this->data['other_products'] = $this->product_model->get_for_fontend(0, 400, 'cat_id = ' . $cat['id'] . ' and id != ' . $id, 'count DESC');
                @$this->memcache->set($key, $this->data['other_products'], false, LONG_TIME);
            }


            $key = md5('skus_' . $id . $_SERVER['SERVER_NAME']);
            $this->data['skus'] = @$this->memcache->get($key);
            if ($this->data['skus'] === false) {
                $this->load->model('sku_model');
                $this->data['skus'] = $this->sku_model->get_by('product_id = ' . $id, 'color ASC,size ASC');
                @$this->memcache->set($key, $this->data['skus'], false, LONG_TIME);
            }


            $this->data['seo']['seo_title'] = $this->data['product']['seo_title'] ? $this->data['product']['seo_title'] : $this->data['product']['title'];
            $this->data['product']['meta_description'] ? $this->data['seo']['meta_description'] = $this->data['product']['meta_description'] : '';
            $this->data['product']['meta_keyword'] ? $this->data['seo']['meta_keyword'] = $this->data['product']['meta_keyword'] : '';
            $this->data['url_image'] = base_url() . 'assets/upload/product/' . $this->data['product']['folder'] . '/' . $this->data['product']['image'];

            $this->template->write_view('content_block', $this->folder . 'product', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    function cart() {
        $this->load->model(array('product_model', 'location_model', 'sku_model'));
        $this->data['cities'] = $this->location_model->get_by('parent = ""', 'priority DESC,name ASC');
        $this->data['seo']['seo_title'] = 'Giỏ hàng';
        $this->data['maps_count_product'] = $this->session->userdata('maps_count_product');
        if ($this->data['maps_count_product']) {
            $this->data['maps_count_product'] = $maps_count_product = unserialize($this->data['maps_count_product']);
            if (!empty($maps_count_product)) {
                $sku_ids = '';
                //$maps_count_product contains only sku id
                foreach ($maps_count_product as $k => $v) {
                    $sku_ids .= $k . ',';
                }
                $this->data['skus'] = $this->product_model->get_for_cart(trim($sku_ids, ','));

            } else {
                $this->data['maps_count_product'] = '';
            }
        }
        $this->get_user_info();
        $this->data['districts'] = array();
        if ($this->data['user']['city']) {
            $this->data['districts'] = $this->location_model->get_by('parent = "' . $this->data['user']['city'] . '"', 'priority DESC,name ASC');
        }
        $this->template->write_view('content_block', 'web/cart', $this->data);
        $this->template->render();
    }

    private function get_user_info() {
        $this->data['user'] = array(
            'fullname' => @$_COOKIE['customer_info_name'],
            'phone' => @$_COOKIE['customer_info_phone'],
            'address' => @$_COOKIE['customer_info_address'],
            'city' => @$_COOKIE['customer_info_city'],
            'district' => @$_COOKIE['customer_info_district']
        );
    }


    //aaaaaaaaaaaaaaa

    function finish_order() {
        if (isset($_POST['submit'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Tên khách hàng', 'required');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
            $this->form_validation->set_rules('city', 'Tỉnh thành', 'required');
            $this->form_validation->set_rules('district', 'Quận huyện', 'required');
            $this->form_validation->set_rules('address', 'Địa chỉ', 'required');

            $list_product_names = '';
            if ($this->form_validation->run() == true) {
                $this->load->model(array('product_model', 'order_model', 'location_model', 'sku_model', 'order_product_model'));
                $city = $this->location_model->get_by_key(intval($_POST['city']));
                $district = $this->location_model->get_by_key(intval($_POST['district']));
                if ($city && $district && @$city['id'] == @$district['parent']) {
                    $this->data['maps_count_product'] = $this->session->userdata('maps_count_product');
                    if ($this->data['maps_count_product']) {
                        $source = @$_COOKIE['source'] ? $_COOKIE['source'] : 'other';
                        $campaign = @$_COOKIE['campaign'] ? $_COOKIE['campaign'] : 'other';
                        $this->data['maps_count_product'] = $maps_count_product = unserialize($this->data['maps_count_product']);
                        if (!empty($maps_count_product)) {
                            $sku_ids = '';
                            foreach ($maps_count_product as $k => $v) {
                                $sku_ids .= $k . ',';
                            }
                            $skus = $this->product_model->get_for_insert(trim($sku_ids, ','));

                            setcookie("customer_info_name", $_POST['name'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
                            setcookie("customer_info_address", $_POST['address'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
                            setcookie("customer_info_phone", $_POST['phone'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
                            setcookie("customer_info_city", $city['id'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
                            setcookie("customer_info_district", $district['id'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
                            $shipping_type = 'post_office';
//                            if ($city['id'] == '24' || $city['id'] == '9' || $city['id'] == '14' || $city['id'] == '19') {
//                                $shipping_type = 'f_shipping';
//                            }
                            $total_cogs = $total = 0;
$product_ids = '';
                            $report_product = [];
                            $old_order = $this->order_model->get_row_by('( status = "order" or status = "unknown" or status = "waitting_pay" or status = "waitting_product")  and date like "' . date('Y-m-d') . '%" and phone = "' . $_POST['phone'] . '"');
//                            $this->load->model('voucher_model');
//                            $voucher = $this->voucher_model->get_row_by('status ="unused" and code = "' . $_POST['voucher'] . '"');
//                            if (!empty($voucher))
//                                $this->voucher_model->update(array('date_use' => date('Y-m-d H:i:s'), 'status' => 'used'), $voucher['id']);
                            $voucher = '';

                            if (!empty($old_order)) {
                                $total = $old_order['total'];

                                $list_product_names =  $old_order['product_names'];

                                $total_cogs = $old_order['total_cogs'];
                                $order_id = $old_order['id'];
                                $old_sku = $this->order_product_model->get_by('order_id = ' . $old_order['id'], null, 'sku_id');
                                $update_order_product = $insert_order_product = [];
                                foreach ($skus as &$item) {
                                    $item['attr'] = ($item['size'] ? $item['size'] . ' / ' : '') . $item['color'];
                                    unset($item['color']);
                                    unset($item['size']);
                                    $item['order_id'] = $old_order['id'];
                                    $item['count'] = $maps_count_product[$item['sku_id']];
                                    $total+=$item['price'] * $item['count'];

                                	//$item['product_names'] = $list_product_names . ', ' . $item['name'];
                                    $total_cogs+=$item['cogs'] * $item['count'];
                                    if (isset($report_product[$item['product_id']])) {
                                        $report_product[$item['product_id']]['count']+=$item['count'];
                                    } else {
                                        $report_product[$item['product_id']] = array(
                                            'count' => $item['count'],
                                            'name' => $item['name'],
                                            'source' => $source
                                        );
                                    }
                                    $product_ids .= $item['product_id'] . ',';
                                    if (isset($old_sku[$item['sku_id']])) {
                                        $update_order_product[] = array(
                                            'id' => $old_sku[$item['sku_id']]['id'],
                                            'count' => $old_sku[$item['sku_id']]['count'] + $item['count']
                                        );
                                    } else {
                                        $insert_order_product[] = $item;
                                    }
                                }
                                if (!empty($voucher)) {
                                    $this->order_model->update(array('voucher_id' => $voucher['id'], 'voucher_price' => $voucher['price'], 'voucher_type' => $voucher['type'] . ''), $old_order['id']);
                                }
                                if ($insert_order_product) {
                                    $this->order_product_model->insert_batch($insert_order_product);
                                }
                                if ($update_order_product) {
                                    @$this->order_product_model->update_batch($update_order_product);
                                }
                            } else {
                                $status = 'order';
                                $ip = $this->getUserIpAddr();
                                foreach ($skus as $k => $v)
                                {
                                  $list_product_names .= ', ' . $v['name'];
                                  if ($v['count'] == 0)
                                      $status = 'waitting_product';
                                  unset($skus[$k]['count']);
                                }
                                $order = array(
                                    'name' => $_POST['name'],
                                    'address' => $_POST['address'],
                                    'phone' => $_POST['phone'],
                                    'note' => $_POST['note'],
                                    'email' => $_POST['email'],
                                    'date' => date('Y-m-d H:i:s'),
                                    'status' => 'order',
                                    'city' => $city['name'],
                                    'district' => $district['name'],
                                    'shipping_type' => $shipping_type,
                                    'source' => $source,
                                    'campaign' => $campaign,
                                    'device_type' => $this->data['is_mobile'] ? 'mobile' : 'desktop' . ' ip: ',
                                    'voucher_id' => intval(@$voucher['id']),
                                    'voucher_price' => intval(@$voucher['price']),
                                    'voucher_type' => @$voucher['type'] . '',
                                    'status' => $status,
                                    'product_names' => $list_product_names,
                                    'ip' => $ip,
                                    'count_ip' => $this->getCountIp($ip),
                                    'count_phone'=> $this->getCountPhone($_POST['phone'])
                                );
                                $order_id = $this->order_model->insert($order);
                                foreach ($skus as &$item) {
                                    $item['attr'] = ($item['size'] ? $item['size'] . ' / ' : '') . $item['color'];
                                    unset($item['color']);
                                    unset($item['size']);
                                    $item['order_id'] = $order_id;
                                    $item['count'] = $maps_count_product [$item['sku_id']];
                                    $total+=$item['price'] * $item['count'];
                                    $total_cogs+=$item['cogs'] * $item['count'];
                                    if (isset($report_product[$item['product_id']])) {
                                        $report_product[$item['product_id']]['count']+=$item['count'];
                                    } else {
                                        $report_product[$item['product_id']] = array(
                                            'count' => $item['count'],
                                            'name' => $item['name'],
                                            'source' => $source
                                        );
                                    }
                                    $product_ids.=$item['product_id'] . ',';
                                    unset($item['is_limit']);
                                }

                                $this->order_product_model->insert_batch($skus);
                            }
                            $this->order_model->update(array('total' => $total, 'total_cogs' => $total_cogs), $order_id);
                            $this->data['order_id'] = $order_id;

                            // Send email notify Admin to have new order:
                            $this->load->library('lib_email');
                            $subject = 'You got new Order From: ' . $_SERVER['SERVER_NAME'];
                            $message = 'Order id: ' . $order_id;
                            $message .= '\n from user: ' . $_POST['phone'];
                            $this->lib_email->send('thang020185@gmail.com' , $subject,  $message);


                            $this->report_product($report_product, $product_ids);
                            $this->session->set_userdata('maps_count_product', '');
                            $this->session->set_userdata('total_money', 0);
                            $this->session->set_userdata('total_count', 0);
                            $this->data['seo']['seo_title'] = 'Đặt hàng thành công';

                            $this->data['total_money'] = $total;
                            $this->template->write_view('content_block', 'all/order_ante', $this->data);
                            // $this->template->write_view('content_block', 'all/order_success', $this->data);
                            $this->template->render();
                            return false;
                        }
                    }
                }
            }
        }
        // $this->template->write_view('content_block', 'all/order_ante', $this->data);
        // $this->template->render();

        redirect(base_url());
    }

     function getCountIp($ip){

       $this->load->model('order_model');
       $cond = 'ip like "%'.$ip.'%"';

       $count_ip = $this->order_model->get_count_by_status($cond);
       return $count_ip['count'];
    }
     function getCountPhone($phone){

      $this->load->model('order_model');
      $cond = 'phone like "%'.$phone . '%"';

      $count_phone = $this->order_model->get_count_by_status($cond);

      return $count_phone['count'];
    }

    private function report_product($report_product, $product_ids) {
        $this->load->model(array('report_product_model'));
        $date = date('Y-m-d');
        $report = $this->report_product_model->get_by('date = "' . $date . '" and product_id in (' . trim($product_ids, ',') . ')', null, 'product_id');
        $insert = $update = [];
        foreach ($report_product as $k => $v) {
            $temp = @$report[$k];
            if ($temp) {
                $update[] = array(
                    'id' => $temp['id'],
                    'buyed' => $temp['buyed'] + $v['count']
                );
            } else {
                $insert[] = array(
                    'buyed' => $v['count'],
                    'product_name' => $v['name'],
                    'product_id' => $k,
                    'date' => $date,
                    'source' => $v['source']
                );
            }
        }
        if ($insert) {
            @$this->report_product_model->insert_batch($insert);
        }
        if ($update) {
            @$this->report_product_model->update_batch($update);
        }
    }

    function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    function test(){
          $this->template->write_view('content_block', 'all/test', $this->data);
          $this->template->render();
    }

}
