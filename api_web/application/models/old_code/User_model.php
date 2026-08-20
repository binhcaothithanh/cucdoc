<?php

class User_Model extends My_Model {

    public function __construct() {
        parent::__construct();
        $this->table_name = 'b_users';
    }
    public function login($email, $password) {
            $user = $this->db->where('email', $email)->get($this->table_name)->row();

            if ($user && password_verify($password, $user->password)) {
                return $user;
            }

            return false;
        }

        public function register($data) {
            // Kiểm tra email đã tồn tại chưa
            $exists = $this->db->where('email', $data['email'])->get($this->table_name)->row();
            if ($exists) {
                return ['status' => false, 'message' => 'Email already exists'];
            }

            // Mã hoá mật khẩu
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $this->db->insert($this->table_name, $data);
            return $this->db->insert_id();
        }

        public function get_user_by_email($email) {
            return $this->db->where('email', $email)->get($this->table_name)->row();
        }

        public function get_user_by_id($id) {
            return $this->db->where('id', $id)->get($this->table_name)->row();
        }

        public function update_password($email, $new_password) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $this->db->where('email', $email)->update($this->table_name, ['password' => $hashed]);
            return $this->db->affected_rows() > 0;
        }

        public function forget_password($email) {
            $user = $this->get_user_by_email($email);
            if (!$user) {
                return ['status' => false, 'message' => 'Email not found'];
            }

            // Tự sinh mật khẩu mới
            $new_password = substr(md5(time()), 0, 8);
            $this->update_password($email, $new_password);

            // Gửi mật khẩu mới (ở đây chỉ trả về, không gửi email thật)
            return ['status' => true, 'new_password' => $new_password];
        }

}
