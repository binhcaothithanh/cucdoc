<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    protected $table_name;

    public function __construct() {
        parent::__construct();
        $this->table_name = 'b_bookings';
    }

    public function create($data) {
        if (!$this->is_provider_available($data['provider_id'], $data['start_time'], $data['end_time'])) {
            return false; // or return custom error response
        }
        return $this->db->insert($this->table_name, $data);
    }

    // public function update_status($booking_id, $status)
    // {
    //     return $this->db->where('id', $booking_id)->update($this->table_name, ['status' => $status]);
    // }



    public function get_by_id($id) {
        return $this->db->get_where($this->table_name, ['id' => $id])->row_array();
    }

    public function get_by_client($client_id) {
        return $this->db->get_where($this->table_name, ['client_id' => $client_id])->result_array();
    }

    public function get_by_provider($provider_id) {
        return $this->db->get_where($this->table_name, ['provider_id' => $provider_id])->result_array();
    }

    public function update_status($id, $status) {
        return $this->db
            ->where('id', $id)
            ->update($this->table_name, ['status' => $status]);
    }

    public function cancel($id, $reason, $by){
        return $this->db->where('id',$id)->update($this->table_name,[
            'status'        => 'canceled',
            'canceled_by'   => $by,          // 'client'
            'cancel_reason' => $reason
        ]);
    }

    public function review($id,$rating,$comment){
        return $this->db->where('id',$id)->update($this->table_name,[
            'status'           => 'done',
            'client_rating'    => $rating,
            'client_comment'   => $comment
        ]);
    }


    public function is_provider_busy($provider_id, $start_time, $end_time)
     {
         $this->db->from($this->table_name);
         $this->db->where('provider_id', $provider_id);
         $this->db->where('status', 'pending');
         $this->db->where('start_time <', $end_time);
         $this->db->where('end_time >', $start_time);
         $query = $this->db->get();
         return $query->num_rows() > 0;
     }

    public function is_provider_available($provider_id, $start_time, $end_time) {
        $this->db->where('provider_id', $provider_id);
        $this->db->where('status !=', 'cancelled');
        $this->db->where("(
            (start_time <= '$start_time' AND end_time > '$start_time') OR
            (start_time < '$end_time' AND end_time >= '$end_time') OR
            (start_time >= '$start_time' AND end_time <= '$end_time')
        )", null, false);
        $query = $this->db->get($this->table_name);
        return $query->num_rows() === 0; // true means available
    }

}
