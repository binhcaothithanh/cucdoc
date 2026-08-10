<?php

/**
 * @property Order_Model $order_model
 */
class Order extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('order_model', 'order_product_model', 'product_model', 'sku_model', 'location_model'));
        $this->data['pre1'] = 'order';
        $this->data['pre2'] = 'order';
        include APPPATH . 'config/maps_order.php';
    }

    function index() {
        $this->data['pos'] = intval(@$_COOKIE['pos_product']);
        $this->data['shipping_type'] = @$_COOKIE['shipping_type'];
        $this->data['status'] = @$_COOKIE['status_order'];
        $this->template->write_view('content_block', 'order/index', $this->data);
        $this->template->render();
    }

    function re_count_product() {
        $data = $this->sku_model->re_count_product();

    }

    function select_location() {
        $id = (@$_POST['id']);
        $this->load->model('location_model');
        $city = $this->location_model->get_row_by('name = "' . $id . '"');
        $id = $city['id'];
        if ($id > 0) {
            $location = $this->location_model->get_by('parent = ' . $id, 'priority DESC,name ASC');
            if (!empty($location)) {
                echo json_encode($location);
            } else {
                echo '';
            }
        }
    }

    function edit($id) {
        $id = intval($id);
        $order = $this->data['order'] = $this->order_model->get_by_key($id);
        if (!empty($this->data['order'])) {
            if (isset($_POST['submit'])) {
                if (check_order($order)) {
                    $news_status = $this->input->post('status');
                    $update = array(
                        'address' => $this->input->post('address'),
                        'shipping_type' => $this->input->post('shipping_type'),
                        'status' => $news_status,
                        'name' => $this->input->post('name'),
                        'note' => $this->input->post('note'),
                        'log_admin' => '@NV:'. $this->session->userdata('username').' change: "' . $news_status . '" at:' . date("Y-m-d H:i:s"). "\r\n"  . $this->input->post('log_admin'),
                        'phone' => $this->input->post('phone'),
                        'city' => $this->input->post('city'),
                        'district' => $this->input->post('district'),
                        'payed_money' => intval($this->input->post('payed_money')),
                        'username' => $this->data['user']['username'],
                        'shipping_price' => $this->input->post('shipping_price')
                    );
                    if ($order['status'] != $news_status) {
                        if ($news_status == 'approved' && $this->data['user']['role'] == 'staff')
                            $order['username_owner'] = $this->data['user']['username'];
                        $this->load->model('bonus_model');
                        $bonus = $this->bonus_model->get_row_by('order_id =' . $id);
                        if ($order['status'] == 'shipping') {
                            $update['shipping_code'] = '';
                            $update['office_code'] = '';
                            $update['shipping_date'] = '';
                            $this->re_import_store($id, 1);
                        }
                        if (!empty($bonus)) {
                            $this->bonus_model->update(array(
                                'status' => $news_status,
                                'username' => $order['username_owner'],
                                'status_history' => $bonus['status_history'] . $news_status . ',')
                                    , $bonus['id']);
                        } else {
                            if ($news_status == 'approved') {
                                $this->bonus_model->insert(array(
                                    'username' => $order['username_owner'],
                                    'date_create' => date('Y-m-d H:i:s'),
                                    'status' => $news_status,
                                    'status_history' => $news_status . ',',
                                    'order_id' => $id
                                ));
                            }
                        }
                    }
                    $this->order_model->update($update, $id);
                    redirect(base_url() . ADMIN_URL . 'order');
                    $this->data['order'] = $this->order_model->get_by_key($id);
                }
            }
            $this->data['order_details'] = $this->order_product_model->get_by('order_id = ' . $id);
            $product_ids = '';
            $sku_ids = '';
            foreach ($this->data['order_details'] as $v) {
                $sku_ids.=$v['sku_id'] . ',';
                $product_ids.=$v['product_id'] . ',';
            }
            $sku_ids = trim($sku_ids, ',');
            $product_ids = trim($product_ids, ',');
            $this->data['skus'] = $this->sku_model->get_by('id in(' . $sku_ids . ')', null, 'id');
            $this->data['products'] = $this->product_model->get_by('id in(' . $product_ids . ')', null, 'id');
            $skus_other = $this->sku_model->get_by('product_id in(' . $product_ids . ')');
            foreach ($skus_other as $item) {
                $this->data['skus_other'][$item['product_id']][] = $item;
            }
            $this->data['check_error'] = -1;
            $this->data['cities'] = $this->location_model->get_by('parent = ""', 'priority DESC,name ASC');
            $city = $this->location_model->get_row_by('name = "' . $this->data['order']['city'] . '"');
            $this->data['districts'] = $this->location_model->get_by('parent = "' . $city['id'] . '"', 'priority DESC,name ASC');
            $this->template->write_view('content_block', 'order/edit', $this->data);
            $this->template->render();
        } else {
            redirect(base_url());
        }
    }

    // Khi hoá đơn đang ở trạng thái chưa duyệt có thể thay đổi số lượng của sản phẩm trong hoá đơn đó 
    function change_order_product() {
        $sku_order_id = intval(@$_POST['id']);
        $order_id = intval(@$_POST['order_id']);
        $count = intval(@$_POST['count']);
        if ($sku_order_id > 0 && $order_id > 0 && $count > 0) {
            $order = $this->order_model->get_by_key($order_id);
            if (check_order($order)) {
                $sku_order = $this->order_product_model->get_by_key($sku_order_id);
                if ($sku_order['order_id'] == $order_id) {
                    $sku = $this->sku_model->get_by_key($sku_order['sku_id']);
                    $this->order_product_model->update(array('count' => $count), $sku_order_id);
                    $this->calc_order($order_id);
                    echo 1;
                } else {
                    echo 'Sản phẩm không thuộc hoá đơn này hoặc không tồn tại sản phẩm';
                }
            } else {
                echo 'Không thể thay đổi số lượng sản phẩm khi hoá đơn ở trạng thái ' . $this->data['status_order'][$order['status']];
            }
        }
    }

    function change_sku_id() {

        $order_product_id = intval(@$_POST['id']);
        $order_id = intval(@$_POST['order_id']);
        $news_sku_id = intval(@$_POST['news_sku_id']);
        if ($order_product_id > 0 && $order_id > 0 && $news_sku_id > 0) {
            $order = $this->order_model->get_by_key($order_id);
            if (check_order($order)) {
                $sku_order = $this->order_product_model->get_by_key($order_product_id);
                if ($sku_order['order_id'] == $order_id) {
                    if ($sku_order['sku_id'] != $news_sku_id) {
                        $check_exit_sku = $this->order_product_model->get_row_by(array('order_id' => $order_id, 'sku_id' => $news_sku_id));
                        if (!empty($check_exit_sku)) {
                            echo 'SKU này đã tồn tại trong hoá đơn';
                            exit;
                        }
                    }
                    $news_sku = $this->sku_model->get_by_key($news_sku_id);
                    if (empty($news_sku)) {
                        echo 'SKU này không tồn tại';
                        exit;
                    }
                    $update = array('sku_id' => $news_sku_id, 'attr' => ($news_sku['size'] ? $news_sku['size'] . ' / ' : '') . $news_sku['color']);
                    $this->order_product_model->update($update, $order_product_id);
                    $this->calc_order($order_id);
                    echo 1;
                } else {
                    echo 'Sản phẩm không thuộc hoá đơn này hoặc không tồn tại sản phẩm';
                }
            } else {
                echo 'Không thể thay đổi số lượng sản phẩm khi hoá đơn ở trạng thái ' . $this->data['status_order'][$order['status']];
            }
        }
    }

    function del_product() {
        $sku_order_id = intval(@$_POST['id']);
        $order_id = intval(@$_POST['order_id']);
        if ($sku_order_id > 0 && $order_id > 0) {
            $order = $this->order_model->get_by_key($order_id);
            if (check_order($order)) {
                $sku_order = $this->order_product_model->get_by_key($sku_order_id);
                if ($sku_order['order_id'] == $order_id) {
                    $count_product_order = $this->order_product_model->count_order($order_id);
                    if ($count_product_order > 1) {
                        $this->order_product_model->delete($sku_order_id);
                        $this->calc_order($order_id);
                        echo 1;
                    } else {
                        echo 'Không thể xoá sản phẩm này khi hiện tai  còn ' . $count_product_order;
                    }
                } else {
                    echo 'Sản phẩm không thuộc hoá đơn này hoặc không tồn tại sản phẩm';
                }
            } else {
                echo 'Không thể xoá sản phẩm khi hoá đơn ở trạng thái ' . $this->data['status_order'][$order['status']];
            }
        }
    }

    private function calc_order($id) {
        $order = $this->order_model->get_by_key($id);
        if (check_order($order)) {
            $this->order_model->set_total_order($id);
        }
    }

    function add_product() {
        $order_id = @intval($_POST['order_id']);
        $pro_id = @intval($_POST['pro_id']);
        if ($order_id && $pro_id) {
            $data['order'] = $order = $this->order_model->get_by_key($order_id);
            $data['product'] = $product = $this->product_model->get_by_key($pro_id);
            if (!empty($order) && !empty($product)) {
                if (check_order($order)) {
                    $data['skus'] = $this->sku_model->get_by('product_id = ' . $pro_id);
                    $data['price'] = $price = $data['product']['price'];
                    $data['sku_order_id'] = $this->order_product_model->insert(array(
                        'order_id' => $order_id,
                        'product_id' => $pro_id,
                        'count' => 1,
                        'price' => $price,
                        'sku_id' => $data['skus'][0]['id'],
                        'attr' => ($data['skus'][0]['size'] ? $data['skus'][0]['size'] . ' / ' : '') . $data['skus'][0]['color'],
                        'name' => $product['title']
                    ));
                    $this->calc_order($order_id);
                    $this->load->view('order/add_product', $data);
                } else {
                    echo 1;
                }
            } else {
                echo 1;
            }
        }
    }

    function page() {
        $parrams = $this->security->xss_clean($_REQUEST);
        $cond = ($parrams['status']) ? 'status ="' . ($parrams['status']) . '"' : null;
        if ($parrams['phone']) {
            $temp = 'phone like "%' . $parrams['phone'] . '%" or name like "%' . $parrams['phone'] . 
            '%" or shipping_code like "%' . $parrams['phone'] . '%" or  product_names like "%' . $parrams['phone'] . '%" or
             ip like "%' . $parrams['phone'] . '%"';
            if ($cond != null) {
                $cond .= ' and (' . $temp . ')';
            } else {
                $cond = '(' . $temp . ')';
            }
        } else if ($this->data['user']['role'] == 'staff') {
            $cond != null ? $cond.=' and ' : '';
            $cond.=' username_owner = "' . $this->data['user']['username'] . '"';
        }
//        die($temp);
        if ($parrams['shipping_type']) {
            $cond != null ? $cond.=' and ' : '';
            $cond.='shipping_type = "' . $parrams['shipping_type'] . '"';
        }
        $pos = intval($parrams['pos']);
        if ($pos < 0) {
            $pos = 0;
        }

        setcookie("order_pos", $pos, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        setcookie("status_order", $parrams['status'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        setcookie("shipping_type", $parrams['shipping_type'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);

        $data['results'] = $this->order_model->get_for_page($this->limit, $pos, $cond);
        $total = $this->order_model->get_total_rows($cond);
        $data['links'] = $this->get_page($pos, $total, $this->limit);
        include APPPATH . 'config/maps_order.php';
        $data['maps_shipping'] = $this->data['maps_shipping'];
        $data['status_order'] = $this->data['status_order'];
        $data['total'] = $total;
        $this->load->view('order/list', $data);
    }

    function del() {
        $id = intval($_POST['id']);
        $this->order_model->delete($id);
        $this->order_product_model->delete_where('order_id = ' . $id);
    }

}
