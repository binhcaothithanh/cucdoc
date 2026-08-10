<?php

/**
 * @property CI_DB_active_record $db
 */
class MY_Model extends CI_Model {

    protected $table_name = 'news';
    protected $key = 'id';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function query($query) {
        return $this->db->query($query);
    }
    function query_row($query) {
        return $this->db->query($query)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function update($data, $key) {
        $this->db->update($this->table_name, $data, array($this->key => $key));
        return $this->db->affected_rows();
    }

    public function update_by($data, $cond) {
        $this->db->update($this->table_name, $data, $cond);
        return $this->db->affected_rows();
    }

    public function delete($key) {
        $this->db->delete($this->table_name, array($this->key => $key));
        return $this->db->affected_rows();
    }

    public function delete_where($cond) {
        $this->db->delete($this->table_name, $cond);
        return $this->db->affected_rows();
    }

    public function get_all($order = null, $rex_index = '') {
        if ($order !== null) {
            $this->db->order_by($order);
        }
        return $this->db->get($this->table_name)->result_array($rex_index);
    }

    public function get_by_key($key) {
        return $this->db->get_where($this->table_name, array($this->key => $key))->row_array();
    }

    public function get_by($cond, $order = null, $rex_index = '') {
        if ($order !== null) {
            $this->db->order_by($order);
        }
        return $this->db->get_where($this->table_name, $cond)->result_array($rex_index);
    }

    public function get_row_by($cond, $order = null) {
        if ($order !== null) {
            $this->db->order_by($order);
        }
        return $this->db->get_where($this->table_name, $cond)->row_array();
    }

    function insert_batch($data) {
        $this->db->insert_batch($this->table_name, $data);
        return $this->db->insert_id();
    }

    function update_set($add, $id, $field = 'count') {
        $this->db->set($field, "$field +" . $add, false)
                ->where("id", $id)->update($this->table_name);
        return $this->db->affected_rows();
    }

    function update_batch($set, $index = "id") {
        $this->db->update_batch($this->table_name, $set, $index);
        return $this->db->affected_rows();
    }

    function get_total_rows($cond = null) {
        if ($cond != null) {
            $this->db->where($cond);
        }
        return $this->db->count_all_results($this->table_name);
    }

    function get_for_page($limit, $offset, $cond = null, $order = 'id DESC') {
        if ($cond != null) {
            $this->db->where($cond);
        }
        return $this->db->limit($limit, $offset)->order_by($order)
                        ->get($this->table_name)->result_array();
    }

}
