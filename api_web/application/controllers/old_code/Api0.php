<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/Rest_Controller.php';

class Api extends Rest_Controller {

    function __construct()
    {
        parent::__construct();
        // Load any necessary models
        $this->load->model('Admin_model');
    }

    public function index_get()
    {
        // Retrieve the data from your model and return as JSON
        $data = $this->Admin_model->get_data();
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function index_post()
    {
        // Insert a new item
        $data = $this->post();
        $insert_id = $this->Admin_model->insert_data($data);
        $this->response(['id' => $insert_id], REST_Controller::HTTP_CREATED);
    }

    public function index_put()
    {
        // Update an existing item
        $id = $this->put('id');
        $data = $this->put();
        $this->Admin_model->update_data($id, $data);
        $this->response(['message' => 'Item updated successfully'], REST_Controller::HTTP_OK);
    }

    public function index_delete()
    {
        // Delete an item
        $id = $this->delete('id');
        $this->Admin_model->delete_data($id);
        $this->response(['message' => 'Item deleted successfully'], REST_Controller::HTTP_OK);
    }
}
