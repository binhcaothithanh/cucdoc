<?php

/**
 * @property Order_Model $order_model
 */
class Update_Shipping extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('order_model'));
        $this->data['pre1'] = 'order';
    }

    function index() {
        $this->data['pre2'] = 'update_shipping';
        $this->template->write_view('content_block', 'order/update_shipping', $this->data);
        $this->template->render();
    }

    private function get_excel() {
        $date = date('Ymd', strtotime($_POST['date']));
        if ($_POST['status'] == 'shipping') {
            $cond = ' and status  = "shipping" and shipping_date <= "' . date('Y-m-d', strtotime($_POST['date'])) . ' 23:59:59"';
        } else {
            $cond = ' and shipping_date like "' . date('Y-m-d', strtotime($_POST['date'])) . '%"';
        }

        $this->session->set_userdata('shipping_type', $_POST['shipping_type']);
        $this->session->set_userdata('export_excel_status', $_POST['status']);
        return $this->order_model->get_by('shipping_type = "' . $_POST['shipping_type'] . '"' . $cond);
    }

    function get_export_excel() {
        $data['results'] = $this->get_excel();
        $this->load->view('order/list_print', $data);
    }

    function export_excel() {
        $this->data['pre2'] = 'export_excel';
        $this->data['error'] = -1;
        $this->data['shipping_type'] = $this->session->userdata('shipping_type');
        $this->data['status'] = $this->session->userdata('export_excel_status');
        if (isset($_POST['submit'])) {
            $order = $this->get_excel();
            if (!empty($order)) {
                include APPPATH . 'libraries/php-export-data.class.php';
                $excel = new ExportDataExcel('browser');
                if ($_POST['shipping_type'] == 'f_shipping') {
                    $excel->filename = "giao-hang-nhanh-" . $_POST['date'] . '.xls';
                    $excel->initialize();
                    $i = 0;
                    $excel->addRow(array('STT', 'Mã đơn hàng', 'số điện thoại', 'Người liên hệ', 'Loại hàng', 'Tổng tiền', 'Địa chỉ', 'Tỉnh thành', 'Quận huyện'));
                    foreach ($order as $row) {
                        $discount = $row['voucher_price'];
                        if ($discount && $row['voucher_type'] == '%')
                            $discount = $row['total'] * $discount / 100;
                        $total = $row['total'] - $discount + $row['shipping_price'] - $row['payed_money'];
                        $excel->addRow(array(++$i, $row['shipping_code'], $row['phone'] . ' ', $row['name'] . '-' . $row['shipping_code'], 'Quần áo', $total, $row['address'], $row['city'], $row['district']));
                    }
                } else {
                    $excel->filename = "buu-dien-" . $_POST['date'] . '.xls';
                    $excel->initialize();
                    $i = 0;
                    $excel->addRow(array('STT', 'Mã đơn hàng', 'Mã bưu điện', 'số điện thoại', 'Người liên hệ', 'Loại hàng', 'Tổng tiền', 'Địa chỉ', 'Tỉnh thành', 'Quận huyện'));
                    foreach ($order as $row) {
                        $discount = $row['voucher_price'];
                        if ($discount && $row['voucher_type'] == '%')
                            $discount = $row['total'] * $discount / 100;
                        $total = $row['total'] - $discount + $row['shipping_price'] - $row['payed_money'];
                        $excel->addRow(array(++$i, $row['shipping_code'], $row['office_code'], $row['phone'] . ' ', $row['name'] . '-' . $row['shipping_code'], 'Quần áo', $total, $row['address'], $row['city'], $row['district']));
                    }
                }

                $excel->finalize();
                return false;
            } else {
                $this->data['error'] = 1;
            }
        }
        $this->template->write_view('content_block', 'order/export_excel', $this->data);
        $this->template->render();
    }

    function update_office_code() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->data['check_error'] = 1;
            $shipping_code = $_POST['shipping_code'];
            $office_code = $_POST['office_code'];
            if ($shipping_code && $office_code) {
                $shipping_code = explode("\n", trim($shipping_code, "\n"));
                $office_code = explode("\n", trim($office_code, "\n"));
                if (count($shipping_code) == count($office_code)) {
                    $update;
                    foreach ($shipping_code as $k => $v) {
                        if (trim($v) && trim($office_code[$k])) {
                            $update[] = array(
                                'shipping_code' => trim($v),
                                'office_code' => trim($office_code[$k])
                            );
                        }
                    }
                    echo @$this->order_model->update_batch($update, 'shipping_code');
                    $this->data['check_error'] = 0;
                } else {
                    $this->data['msg'] = 'Mã đi bưu điện và mã của bưu điện không bằng nhau';
                }
            } else {
                $this->data['msg'] = 'Vui lòng điều đầy đủ thông tin';
            }
        }
        $this->data['pre2'] = 'update_office_code';
        $this->template->write_view('content_block', 'order/office_code', $this->data);
        $this->template->render();
    }

    function ajax_update_success() {
        if (isset($_POST['shipping_code'])) {
            $shipping_code = $_POST['shipping_code'];
            $update = '';
            if (!empty($shipping_code)) {
                foreach ($shipping_code as $item) {
                    if (trim($item)) {
                        $update .= '"' . trim($item) . '"' . ',';
                    }
                }
                @$this->order_model->update_by(array('status' => 'success', 'date_success' => date('Y-m-d H:i:s')), 'id in (' . trim($update, ',') . ') and status = "shipping"');
                $content = date('d-m-Y H:i:s') . "\t" . $this->data['user']['username'] . "\t" . $_POST['type'] . "\t" . $update;
                file_put_contents(APPPATH . 'cache/success.txt', $content . "\n", FILE_APPEND);
            }
            echo 1;
        }
    }

    function update_order_fail() {
        $this->data['pre2'] = 'update_order_fail';
        $this->template->write_view('content_block', 'order/update_order_fail', $this->data);
        $this->template->render();
    }

    function update_fail() {
        if (isset($_POST['shipping_code'])) {
            $order = $this->order_model->get_row_by('shipping_code = "' . $_POST['shipping_code'] . '" and status = "shipping"');
            if (!empty($order)) {
                $this->re_import_store($order['id'], 1);
                $this->order_model->update(array('date_success' => date('Y-m-d H:i:s'), 'status' => 'fail'), $order['id']);
                include APPPATH . 'config/maps_order.php';
                echo "<tr>"
                . "<td class='location_current'>{$order['shipping_code']}</td>"
                . "<td>{$order['name']}</td>"
                . "<td>{$order['phone']}</td>"
                . "<td>{$order['address']}</td>"
                . "<td>{$order['total']}</td>"
                . "<td>{$this->data['maps_shipping'][$order['shipping_type']]}</td>"
                . "</tr>";
            }
        }
        echo 0;
    }

    function update_order_fail1() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->data['check_error'] = 1;
            $shipping_code = $_POST['shipping_code'];
            if ($shipping_code) {
                $shipping_code = explode("\n", $shipping_code);
                $code_string = '';
                foreach ($shipping_code as $k => $v) {
                    if (trim($v)) {
                        $code_string.='"' . trim($v) . '",';
                    }
                }
                $this->data['type'] = $type = @$_POST['shipping_type'] == 'post_office' ? 'office_code' : 'shipping_code';
                $update = array('status' => 'fail', 'date_success' => date('Y-m-d H:i:s'));
                $cond = 'shipping_type = "' . $_POST['shipping_type'] . '" and status = "shipping" and ';
                $final_cond = $cond . $type . ' in (' . trim($code_string, ',') . ')';
                $orders = $this->order_model->get_by($final_cond);
                $this->data['count'] = 0;
                if (!empty($orders)) {
                    $this->data['count'] = $this->order_model->update_by($update, $final_cond);
                } else if ($type == 'office_code') {
                    $final_cond = $cond . 'shipping_code in (' . trim($code_string, ',') . ')';
                    $orders = $this->order_model->get_by($final_cond);
                    $this->data['count'] = $this->order_model->update_by($update, $final_cond);
                }
                $this->data['check_error'] = 0;
                $content = date('d-m-Y H:i:s') . "\t" . $this->data['user']['username'] . "\t" . $type . "\t" . $code_string;
                file_put_contents(APPPATH . 'cache/fail.txt', $content . "\n", FILE_APPEND);
            } else {
                $this->data['msg'] = 'Vui lòng điều đầy đủ thông tin';
            }
        }
        $this->data['pre2'] = 'update_order_fail';
        $this->template->write_view('content_block', 'order/update_order_fail', $this->data);
        $this->template->render();
    }

    function update_order_success() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            $this->data['check_error'] = 1;
            $shipping_code = $_POST['shipping_code'];
            $prices = $_POST['prices'];
            if ($shipping_code && $prices) {
                $shipping_code = explode("\n", $shipping_code);
                $prices = explode("\n", $prices);
                if (count($shipping_code) == count($prices)) {
                    $code_string = '';
                    foreach ($shipping_code as $k => $v) {
                        $v = explode('-', $v);
                        $v = trim($v[count($v) - 1]);
                        if ($v) {
                            $prices[$k] = intval(str_replace(',', '', trim($prices[$k])));
                            $shipping_code[$k] = $v;
                            $code_string.='"' . $shipping_code[$k] . '",';
                        } else {
                            unset($prices[$k]);
                            unset($shipping_code[$k]);
                        }
                    }
                    $this->data['type'] = $type = @$_POST['shipping_type'] == 'post_office' ? 'office_code' : 'shipping_code';
                    $this->data['shipping_code'] = $shipping_code;
                    $this->data['prices'] = $prices;
                    if ($type == 'office_code') {
                        $this->data['orders'] = $this->order_model->get_by('shipping_type = "post_office" and status = "shipping" and office_code in (' . trim($code_string, ',') . ')', null, 'office_code');
                        if (empty($this->data['orders'])) {
                            $this->data['orders'] = $this->order_model->get_by('shipping_type = "post_office" and status = "shipping" and  shipping_code in (' . trim($code_string, ',') . ')', null, 'shipping_code');
                        }
                    } else {
                        $this->data['orders'] = $this->order_model->get_by('shipping_type = "f_shipping" and status = "shipping" and ' . $type . ' in (' . trim($code_string, ',') . ')', null, $type);
                    }

                    $this->data['check_error'] = 0;
                } else {
                    $this->data['msg'] = 'Số lượng không bằng nhau';
                }
            } else {
                $this->data['msg'] = 'Vui lòng điều đầy đủ thông tin';
            }
        }
        $this->data['pre2'] = 'update_order_success';
        $this->template->write_view('content_block', 'order/update_order_success', $this->data);
        $this->template->render();
    }

    function update() {
        if (isset($_POST['shipping_code'])) {
            $order = $this->order_model->get_row_by('shipping_code = "' . $_POST['shipping_code'] . '" and status = "success"');
            if (!empty($order)) {
                $this->re_import_store($order['id'], -1);
                $this->order_model->update(array('shipping_date' => date('Y-m-d H:i:s'), 'status' => 'shipping'), $order['id']);
                include APPPATH . 'config/maps_order.php';
                echo "<tr>"
                . "<td class='location_current'>{$order['shipping_code']}</td>"
                . "<td>{$order['name']}</td>"
                . "<td>{$order['phone']}</td>"
                . "<td>{$order['address']}</td>"
                . "<td>{$order['total']}</td>"
                . "<td>{$this->data['maps_shipping'][$order['shipping_type']]}</td>"
                . "</tr>";
            }
        }
        echo 0;
    }

}
