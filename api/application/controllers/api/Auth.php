<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'helpers/jwt_helper.php');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        header('Content-Type: application/json');
    }

    public function register()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        $name = $input['name'] ?? '';

        if (empty($email) || empty($password) || empty($name)) {
            $this->send_response(false, 'All fields are required');
            return;
        }

        if ($this->User_model->get_user_by_email($email)) {
            $this->send_response(false, 'Email already exists');
            return;
        }

        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'name' => $name,
        ];

        $user_id = $this->User_model->register($data);
        $user = $this->User_model->get_user_by_id($user_id);
        $token = generate_jwt_token($user);

        $this->send_response(true, 'Registration successful', [
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login()
    {
        $input = json_decode(trim(file_get_contents('php://input')), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        if (empty($email) || empty($password)) {
            $this->send_response(false, 'Email and password are required');
            return;
        }

        $user = $this->User_model->get_user_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $token = generate_jwt_token($user);
            $this->send_response(true, 'Login successful', [
                'token' => $token,
                'user' => $user
            ]);
        } else {
            $this->send_response(false, 'Invalid credentials');
        }
    }

    private function send_response($status, $message, $data = [])
    {
        echo json_encode(array_merge([
            'status' => $status,
            'message' => $message,
        ], $data ? ['data' => $data] : []));
    }
}
