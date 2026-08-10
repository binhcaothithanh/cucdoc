<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->helper(['form', 'url']);
        $this->load->helper('jwt_helper');

        $this->load->library('form_validation');
        header('Content-Type: application/json');
    }


    public function create()
    {
        $headers = $this->input->request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
        $input = json_decode(trim(file_get_contents('php://input')), true);

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            $decoded = decode_jwt_token($token);
            $client_id = $decoded->id;
        } else {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode(['message' => 'Unauthorized']));
        }

        $service_id = $input['service_id'] ?? null;
        $start_time = $input['start_time'] ?? null;

        if (!$service_id || !$start_time) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode(['message' => 'Missing service_id or start_time']));
        }

        $this->load->model('Service_model');
        $this->load->model('Booking_model');

        $service = $this->Service_model->get_by_id($service_id);
        if (!$service) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode(['message' => 'Service not found']));
        }

        $provider_id = $service['user_id'];
        $duration = $service['duration'];

        $start = new DateTime($start_time);
        $end = clone $start;
        $end->modify("+{$duration} minutes");

        // Kiểm tra xem provider có bận trong khoảng đó không
        $is_busy = $this->Booking_model->is_provider_busy(
            $provider_id,
            $start->format('Y-m-d H:i:s'),
            $end->format('Y-m-d H:i:s')
        );

        if ($is_busy) {
            return $this->output
                ->set_status_header(409)
                ->set_output(json_encode(['message' => 'Provider is busy at that time']));
        }

        // Nếu rảnh thì tạo booking
        $this->Booking_model->create([
            'service_id' => $service_id,
            'client_id' => $client_id,
            'provider_id' => $provider_id,
            'start_time' => $start->format('Y-m-d H:i:s'),
            'end_time' => $end->format('Y-m-d H:i:s'),
        ]);

        return $this->output
            ->set_status_header(201)
            ->set_output(json_encode(['message' => 'Booking created successfully']));
    }

    public function list_by_user() {

      $headers = $this->input->request_headers();
      $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
      $input = json_decode(trim(file_get_contents('php://input')), true);

      if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
          return $this->output->set_status_header(401)->set_output(json_encode(['message' => 'Unauthorized']));
      }

      $token = $matches[1];
      $decoded = decode_jwt_token($token);
      $user_id = $decoded->id;

        $bookings = $this->Booking_model->get_by_provider($user_id);
        echo json_encode(['status' => true, 'data' => $bookings]);
    }

    // Thường sẽ là: Danh sách các dịch vụ mà mình đã book
    public function list_by_client() {

      $headers = $this->input->request_headers();
      $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
      $input = json_decode(trim(file_get_contents('php://input')), true);

      if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
          return $this->output->set_status_header(401)->set_output(json_encode(['message' => 'Unauthorized']));
      }

      $token = $matches[1];
      $decoded = decode_jwt_token($token);
      $user_id = $decoded->id;

        $bookings = $this->Booking_model->get_by_client($user_id);
        echo json_encode(['status' => true, 'data' => $bookings]);
    }

    // Danh sách các dịch vụ mà mình cung cấp:
    public function list_by_provider($provider_id) {
        $bookings = $this->Booking_model->get_by_provider($provider_id);
        echo json_encode(['status' => true, 'data' => $bookings]);
    }

    // Booking.php (controller)
    public function update_status()
    {
        $headers = $this->input->request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
        $input = json_decode(trim(file_get_contents('php://input')), true);

        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $this->output->set_status_header(401)->set_output(json_encode(['message' => 'Unauthorized']));
        }

        $token = $matches[1];
        $decoded = decode_jwt_token($token);
        $user_id = $decoded->id;

        $booking_id = $input['booking_id'] ?? null;
        $new_status = $input['status'] ?? null;

        if (!$booking_id || !$new_status) {
            return $this->output->set_status_header(400)->set_output(json_encode(['message' => 'Missing data']));
        }

        $this->load->model('Booking_model');
        $booking = $this->Booking_model->get_by_id($booking_id);

        if (!$booking) {
            return $this->output->set_status_header(404)->set_output(json_encode(['message' => 'Booking not found']));
        }

        // Phân quyền: chỉ provider hoặc client của booking mới được thay đổi
        if ($booking['provider_id'] != $user_id && $booking['client_id'] != $user_id) {
            return $this->output->set_status_header(403)->set_output(json_encode(['message' => 'Permission denied']));
        }

        $this->Booking_model->update_status($booking_id, $new_status);

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode(['message' => 'Status updated']));
    }

    public function cancel()          // POST /booking/cancel
    {
        $input = json_decode($this->input->raw_input_stream,true);
        $id     = $input['booking_id'] ?? null;
        $reason = $input['reason']     ?? '';
        $uid    = $this->user_id();     // helper lấy user id từ token

        $booking = $this->Booking_model->get_by_id($id);
        if(!$booking)     return $this->not_found();
        if($booking['client_id'] != $uid) return $this->unauthorized();
        if($booking['status'] !== 'in_progress') return $this->bad_request('Chỉ hủy khi in_progress');

        $this->Booking_model->cancel($id,$reason,'client');
        return $this->success('Đã hủy booking');
    }

    public function review()          // POST /booking/review
    {
        $in = json_decode($this->input->raw_input_stream,true);
        $id=$in['booking_id']??null;
        $rating=$in['rating']??null;
        $comment=$in['comment']??'';

        $uid = $this->user_id();
        $bk  = $this->Booking_model->get_by_id($id);
        if(!$bk) return $this->not_found();
        if($bk['client_id']!=$uid) return $this->unauthorized();
        if($bk['status']!=='completed') return $this->bad_request('Must be completed');

        $this->Booking_model->review($id,$rating,$comment);
        return $this->success('Đã đánh giá');
    }


    private function is_provider($booking) {
    $provider_id = $booking['provider_id'];
    $user_id = $this->get_user_id_from_token();
    return $provider_id == $user_id;
    }

    private function is_client($booking) {
        $client_id = $booking['client_id'];
        $user_id = $this->get_user_id_from_token();
        return $client_id == $user_id;
    }

    private function get_user_id_from_token() {
        $headers = $this->input->request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
            $decoded = decode_jwt_token($token);
            return $decoded->id ?? null;
        }
        return null;
    }

    // private function unauthorized() {
    //     return $this->output->set_status_header(401)->set_output(json_encode(['message' => 'Unauthorized']));
    // }
    // private function not_found() {
    //     return $this->output->set_status_header(404)->set_output(json_encode(['message' => 'Booking not found']));
    // }
    // private function bad_request($msg) {
    //     return $this->output->set_status_header(400)->set_output(json_encode(['message' => $msg]));
    // }
    // private function success($msg) {
    //     return $this->output->set_status_header(200)->set_output(json_encode(['message' => $msg]));
    // }

}
