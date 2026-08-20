<?php

/**
 * @property Order_Model $order_model
 */
class Order extends FONTEND_Controller {

    public function __construct() {
        parent::__construct(true);
        $this->load->model('order_model');
    }

    function select_location() {
        $id = intval(@$_POST['id']);
        if ($id > 0) {
            $this->load->model('location_model');
            $location = $this->location_model->get_by('parent = ' . $id, 'priority DESC,name ASC');
            if (!empty($location)) {
                echo json_encode($location);
            } else {
                echo '';
            }
        }
        exit;
    }

    function check_voucher() {
        if (isset($_POST['voucher'])) {
            $this->load->model('voucher_model');
            $voucher = $this->voucher_model->get_row_by('code = "' . $_POST['voucher'] . '" and status = "unused"');
            $return['error'] = 1;
            if (!empty($voucher)) {
                $return['error'] = 0;
                $return['price'] = $voucher['price'];
                $return['type'] = $voucher['type'];
            }
            echo json_encode($return);
        }
    }

    function del_product() {
        $sku_id = intval(@$_POST['sku_id']);
        if ($sku_id > 0) {
            $maps_count_product = $this->session->userdata('maps_count_product');
            if ($maps_count_product) {
                $maps_count_product = unserialize($maps_count_product);
            }
            unset($maps_count_product[$sku_id]);
            $this->session->set_userdata('maps_count_product', serialize($maps_count_product));
            $this->get_total_money($maps_count_product);
        }
        exit;
    }

    function add_product($product_id = 0) {
        $sku_id = $quantity = 0;
        if (!$product_id) {
            $parrams = $this->security->xss_clean($_POST);
            $product_id = intval(@$parrams['product_id']);
            $quantity = intval(@$parrams['quantity']);
            $sku_id = intval(@$parrams['sku_id']);
        }
        if ($product_id > 0) {
            ($quantity < 1 || $quantity > 11) ? $quantity = 1 : '';
            $this->load->model('sku_model');
            $cond = 'product_id = ' . $product_id;
            $sku = $this->sku_model->get_row_by($sku_id);
            if (empty($sku)){
                $sku = $this->sku_model->get_row_by($cond);
            }

            if (!empty($sku)) {
                $maps_count_product = $this->session->userdata('maps_count_product');
                $maps_count_product ? $maps_count_product = unserialize($maps_count_product) : [];

                if (!is_array($maps_count_product)) {
                    $maps_count_product = [];
                }
                if (!isset($maps_count_product[$sku['id']])) {
                    $maps_count_product[$sku['id']] += 0; // Initialize as number
                }
                @$maps_count_product[$sku['id']] .= $quantity;
                $this->session->set_userdata('maps_count_product', serialize($maps_count_product));
                $this->get_total_money($maps_count_product);
                redirect(base_url() . 'gio-hang.html');
                echo 1;
                exit;
            }else{ // CHUA CO SKU

                echo ('san pham dang co loi~. Vui long lien he admin xu ly: 0916.706.716');
                exit;

            }


        }
        echo 'Sản phẩm không tồn tại';
    }

    function change_quantity() {
        $sku_id = intval($_POST['sku_id']);
        $quantity = intval($_POST['quantity']);
        if ($sku_id > 0 && $quantity > 0) {
            $maps_count_product = $this->session->userdata('maps_count_product');
            if ($maps_count_product) {
                $maps_count_product = unserialize($maps_count_product);
            }
            if (isset($maps_count_product[$sku_id])) {
                $maps_count_product[$sku_id] = $quantity;
                $this->session->set_userdata('maps_count_product', serialize($maps_count_product));
                $this->get_total_money($maps_count_product);
                echo 1;
            } else {
                echo 'Sản phẩm không tồn tai';
            }
            exit;
        }
    }

    private function get_total_money($maps_count_product) {
        $this->load->model('sku_model');
        $total = 0;
        $total_count = 0;
        if (!empty($maps_count_product)) {
            $sku_ids = '';
            foreach ($maps_count_product as $k => $v) {
                $total_count+=$v;
                $sku_ids.=$k . ',';
            }
            $skus = $this->sku_model->get_sku_price(trim($sku_ids, ','));
            foreach ($skus as $item) {
                $total+=$item['price'] * @$maps_count_product[$item['id']];
            }
        }
        $this->session->set_userdata('total_money', $total);
        $this->session->set_userdata('total_count', $total_count);
    }

    function get_shipping_price($city_id = 0, $district_id = 0, $ajax = 1) {
        $maps_count_product = $this->session->userdata('maps_count_product');
        $shipping_price = 0;
        if ($maps_count_product) {
            $maps_count_product = unserialize($maps_count_product);
            $count = 0;
            foreach ($maps_count_product as $item) {
                $count+=$item;
            }
            if ($count < 3) {
                if ($city_id == 24) {
                    $urban = ',319,320,321,322,323,324,325,326,328,329,332,312,315,318,331,';
                    $suburban = ',311,327,330,333,';
                    if (strpos($urban, ',' . $district_id . ',') !== false) {

                    } elseif (strpos($suburban, ',' . $district_id . ',') !== false) {
                        $shipping_price = 10000;
                    } else {
                        $shipping_price = 20000;
                    }
                } else {
                    $shipping_price = $count == 1 ? 30000 : 35000;
                }
            }
        }
        if ($ajax) {
            echo $shipping_price;
        } else {
            return $shipping_price;
        }
    }

    private function rand_user() {
        $this->load->model('admin_model');
        $user = $this->admin_model->get_by('role = "staff"');
        $index = @intval(file_get_contents(APPPATH . 'cache/index_rand_user'));
        $index = count($user) > $index ? $index : 0;
        file_put_contents(APPPATH . 'cache/index_rand_user', $index + 1);
        return $user[$index]['username'];
    }

}
