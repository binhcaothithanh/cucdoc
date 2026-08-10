<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Service_model');
        $this->load->helper('jwt_helper');
    }

    public function all() {
        $services = $this->Service_model->get_all();
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($services));
    }

    public function create()
  {
      $headers = $this->input->request_headers();
      $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
      $input = json_decode(trim(file_get_contents('php://input')), true);

      if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
          $token = $matches[1];
          $decoded = decode_jwt_token($token);
          $user_id = $decoded->id; // KHÔNG được là $decoded['id']
      } else {
          return $this->output
              ->set_status_header(401)
              ->set_output(json_encode(['error' => 'Unauthorized']));
      }

      $name = $input['name'];
      $price = $input['price'];
      $duration = $input['duration'];

      if (!$name || !$price || !$duration) {
          return $this->output
              ->set_status_header(400)
              ->set_output(json_encode(['error' => 'Missing fields']));
      }

      $this->load->model('Service_model');
      $service_id = $this->Service_model->create([
          'name' => $name,
          'price' => $price,
          'duration' => $duration,
          'user_id' => $user_id
      ]);

      return $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode(['success' => true, 'id' => $service_id]));
  }

  public function update($id)
  {
      $headers = $this->input->request_headers();
      $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;

      if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
          $token = $matches[1];
          $decoded = decode_jwt_token($token);
          $user_id = $decoded->id;
      } else {
          return $this->output
              ->set_status_header(401)
              ->set_output(json_encode(['message' => 'Unauthorized']));
      }

      // Lấy dữ liệu JSON gửi lên
      $input = json_decode(trim(file_get_contents('php://input')), true);

      if (!$input || !isset($input['name'], $input['price'], $input['duration'])) {
          return $this->output
              ->set_status_header(400)
              ->set_output(json_encode(['message' => 'Missing required fields']));
      }

      $this->load->model('Service_model');

      // Kiểm tra service tồn tại và thuộc về user đang đăng nhập
      $service = $this->Service_model->get_by_id($id);
      if (!$service) {
          return $this->output
              ->set_status_header(404)
              ->set_output(json_encode(['message' => 'Service not found']));
      }
      if ($service['user_id'] != $user_id) {
          return $this->output
              ->set_status_header(403)
              ->set_output(json_encode(['message' => 'Permission denied']));
      }

      $updatedData = [
          'name' => $input['name'],
          'price' => $input['price'],
          'duration' => $input['duration'],
      ];

      $this->Service_model->update($id, $updatedData);

      return $this->output
          ->set_status_header(200)
          ->set_output(json_encode(['message' => 'Service updated successfully', 'data' => $updatedData]));
  }

    // public function update($id) {
    //     $data = json_decode(file_get_contents('php://input'), true);
    //     $result = $this->Service_model->update($id, $data);
    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($result));
    // }

    public function mine() {
      // die('mine');
      $headers = $this->input->request_headers();
      $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
      $input = json_decode(trim(file_get_contents('php://input')), true);

      if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
          $token = $matches[1];
          $decoded = decode_jwt_token($token);
          $user_id = $decoded->id; // KHÔNG được là $decoded['id']
      } else {
          return $this->output
              ->set_status_header(401)
              ->set_output(json_encode(['error' => 'Unauthorized']));
      }


        // $user_id = $this->session->userdata('user_id');
        $services = $this->Service_model->get_by_user($user_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($services));
    }

    public function get($id) {
        $service = $this->Service_model->get_by_id($id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($service));
    }
}
