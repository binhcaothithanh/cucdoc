<?php
die('goto index controller');

class Auth extends CI_Controller {

    public function __construct() {

        parent::__construct();
        die('goto /api/auth/construct of AUth.php');
        $this->load->model('User_model');
        // Thiết lập header trả về chuẩn JSON RESTful
        header('Content-Type: application/json; charset=utf-8');
    }
    public function index() {
        die('goto /api/auth/index of AUth.php');
    }

    // API Đăng ký: POST /api/auth/register
    public function register() {
        die('goto /api/auth/register');
        // Lấy dữ liệu dạng JSON hoặc Form-data gửi lên
        $input = json_decode(trim(file_get_contents('php://input')), true);
        if (!$input) {
            $input = $this->input->post();
        }

        $phone = isset($input['phone']) ? trim($input['phone']) : '';
        $password = isset($input['password']) ? trim($input['password']) : '';
        $role = isset($input['role']) ? trim($input['role']) : 'customer'; // customer hoặc provider
        $full_name = isset($input['full_name']) ? trim($input['full_name']) : '';

        // Validate cơ bản ở tầng Code
        if (empty($phone) || empty($password)) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Số điện thoại và mật khẩu không được để trống.'
            ));
            return;
        }

        // Kiểm tra SĐT đã tồn tại chưa (Đúng ý bạn là check ở code trước khi insert)
        $existing_user = $this->User_model->check_phone_exists($phone);
        if ($existing_user) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Số điện thoại này đã được đăng ký tài khoản khác.'
            ));
            return;
        }

        // Mã hóa mật khẩu bằng Bcrypt chuẩn bảo mật
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $data_insert = array(
            'phone' => $phone,
            'password_hash' => $password_hash,
            'role' => ($role === 'provider') ? 'provider' : 'customer',
            'full_name' => $full_name
        );

        $user_id = $this->User_model->register_user($data_insert);

        if ($user_id) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Đăng ký tài khoản thành công!',
                'data' => array(
                    'user_id' => $user_id,
                    'phone' => $phone,
                    'role' => $data_insert['role']
                )
            ));
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'Lỗi hệ thống, không thể tạo tài khoản lúc này.'
            ));
        }
    }

    // API Đăng nhập: POST /api/auth/login
    public function login() {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        if (!$input) {
            $input = $this->input->post();
        }

        $phone = isset($input['phone']) ? trim($input['phone']) : '';
        $password = isset($input['password']) ? trim($input['password']) : '';

        if (empty($phone) || empty($password)) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Vui lòng nhập số điện thoại và mật khẩu.'
            ));
            return;
        }

        // Tìm user theo số điện thoại
        $user = $this->User_model->get_user_by_phone($phone);
        if (!$user) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Số điện thoại hoặc mật khẩu không chính xác.'
            ));
            return;
        }

        // Kiểm tra trạng thái tài khoản có bị khóa không
        if ($user['status'] === 'locked') {
            echo json_encode(array(
                'status' => false,
                'message' => 'Tài khoản của bạn đã bị khóa do nợ phí dịch vụ quá hạn.'
            ));
            return;
        }

        // Xác thực mật khẩu Bcrypt
        if (!password_verify($password, $user['password_hash'])) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Số điện thoại hoặc mật khẩu không chính xác.'
            ));
            return;
        }

        // Tạo một Access Token đơn giản (hoặc tích hợp JWT sau)
        $fake_token = bin2hex(random_bytes(32));

        echo json_encode(array(
            'status' => true,
            'message' => 'Đăng nhập thành công!',
            'data' => array(
                'user_id' => $user['id'],
                'phone' => $user['phone'],
                'role' => $user['role'],
                'debt_balance' => $user['debt_balance'],
                'access_token' => $fake_token
            )
        ));
    }
}
