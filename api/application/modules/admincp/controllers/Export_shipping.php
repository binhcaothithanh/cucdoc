<?php

/**
 * @property Order_Model $order_model
 */
class Export_Shipping extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('order_model', 'order_product_model', 'product_model', 'sku_model'));       
        include APPPATH . 'config/maps_order.php';
        $this->data['shipping_type'] = $this->session->userdata('shipping_type');
        $this->data['pre1'] = 'order';
        $this->data['pre2'] = 'export_shipping';
    }

    function index() {
        $this->data['status'] = 'approved';
        $this->template->write_view('content_block', 'order/shipping_order', $this->data);
        $this->template->render();
    }

    function load_list() {
        if (isset($_POST['status']) && isset($_POST['shipping_type'])) {
            $this->session->set_userdata('shipping_type', $_POST['shipping_type']);
            $data['results'] = $this->order_model->get_by('shipping_type = "' . $_POST['shipping_type'] . '" and status = "' . $_POST['status'] . '"');
            $this->load->view('order/list_print', $data);
        }
    }

    function re_print() {
        $this->data['pre2'] = 're_print';
        $this->data['status'] = 'had_invoiced';
        $this->template->write_view('content_block', 'order/shipping_order', $this->data);
        $this->template->render();
    }

    function print_order($shipping_type, $status = 'approved') {
        $this->data['orders'] = $this->order_model->get_by('shipping_type = "' . $shipping_type . '" and status = "' . $status . '"');
        if (!empty($this->data['orders'])) {
            if ($status == 'approved') {
                $date = date('Ymd');
                $order_date = @file_get_contents(APPPATH . 'cache/total_today_' . $shipping_type);
                if ($order_date) {
                    $order_date = explode('||', $order_date);
                    if ($order_date[0] == $date) {
                        $order_date = $order_date[1];
                    } else {
                        $order_date = 1;
                    }
                } else {
                    $order_date = 1;
                }
                $update;
                $order_ids = '';
                foreach ($this->data['orders'] as &$item) {
                    $order_ids.=$item['id'] . ',';
                    $time = date('Y-m-d');
                    $item['shipping_code'] = 'Z'.$date . ($item['shipping_type'] == 'f_shipping' ? 'SH' : '') . ($order_date < 10 ? '0' : '') . $order_date;
                    $update[] = array(
                        'id' => $item['id'],
                        'shipping_code' => $item['shipping_code'],
                        'status' => 'had_invoiced'
                    );
                    $order_date++;
                }
                file_put_contents(APPPATH . 'cache/total_today_' . $shipping_type, $date . '||' . $order_date);
                @$this->order_model->update_batch($update);
            } else {
                $order_ids = '';
                foreach ($this->data['orders'] as $item) {
                    $order_ids.=$item['id'] . ',';
                }
            }
            $order_product = $this->order_product_model->get_by('order_id in(' . trim($order_ids, ',') . ')');
            foreach ($this->data['orders'] as &$item) {
                foreach ($order_product as $k => $v) {
                    if ($item['id'] == $v['order_id']) {
                        $item['childs'][] = $v;
                        unset($order_product[$k]);
                    }
                }
            }
            $this->load->view('order/print', $this->data);
        }
    }

}
