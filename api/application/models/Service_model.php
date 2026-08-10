 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {

  public function __construct() {
      parent::__construct();
      $this->table_name = 'b_services';
  }

    public function create($data) {
        return $this->db->insert($this->table_name, $data);
    }

    public function update($id, $data) {
      // var_dump($id);
      // var_dump($data);
      // die;
        return $this->db
        ->where('id', $id)
        ->update($this->table_name, $data);
    }


    public function update_status($id, $status) {
        return $this->db
            ->where('id', $id)
            ->update($this->table_name, ['status' => $status]);
    }


    public function delete($id) {
        return $this->db->delete($this->table_name, ['id' => $id]);
    }

    public function get_all() {
        return $this->db->get($this->table_name)->result_array();
    }

    public function get_by_user($user_id) {
        return $this->db->get_where($this->table_name, ['user_id' => $user_id])->result_array();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table_name, ['id' => $id])->row_array();
    }
}
