<?php

function convert_id($id) {
    $id = '00000000' . $id;
    return substr($id, -5, 5);
}

function check_order($order) {
    if ($order['status'] != 'success' && $order['status'] != 'fail') {
        return true;
    }
    return false;
}

function check_is_export($order) {
    if ($order['status'] != 'shipping' && $order['status'] != 'success' && $order['status'] != 'fail') {
        return false;
    }
    return true;
}
