<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'users';
    }

    // Kiểm tra xem số điện thoại đã tồn tại chưa
    public function check_phone_exists($phone) {
        $query = $this->db->get_where($this->table_name, array('phone' => $phone));
        return $query->row_array();
    }

    // Đăng ký user mới + tự động tạo profile rỗng cho user đó
    public function register_user($data) {
        $this->db->trans_start(); // Bắt đầu transaction để đảm bảo an toàn dữ liệu

        // 1. Insert vào bảng users
        $user_data = array(
            'phone'         => $data['phone'],
            'password_hash' => $data['password_hash'],
            'role'          => isset($data['role']) ? $data['role'] : 'customer',
            'status'        => 'active',
            'debt_balance'  => 0.00
        );
        $this->db->insert($this->table_name, $user_data);
        $user_id = $this->db->insert_id();

        // 2. Insert mặc định 1 dòng vào bảng profiles (liên kết mềm 1-1)
        $profile_data = array(
            'user_id'   => $user_id,
            'full_name' => isset($data['full_name']) ? $data['full_name'] : 'Người dùng mới'
        );
        $this->db->insert('profiles', $profile_data);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return $user_id;
    }

    // Lấy thông tin user bằng số điện thoại
    public function get_user_by_phone($phone) {
        $query = $this->db->get_where($this->table_name, array('phone' => $phone));
        return $query->row_array();
    }

    // Lấy thông tin user bằng ID
    public function get_user_by_id($user_id) {
        $query = $this->db->get_where($this->table_name, array('id' => $user_id));
        return $query->row_array();
    }
}