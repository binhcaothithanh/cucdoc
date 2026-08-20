<?php

/**
 * @property Admin_Model $admin_model
 */
class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
    }

    function login() {
        $this->data['error'] = -1;
        if (isset($_POST['submit'])) {
            $login = array(
                'username' => $this->input->post('username'),
                'password' => md5($this->input->post('password'))
            );
            $user = $this->admin_model->get_row_by($login);
            if (empty($user)) {
                $this->data['error'] = 1;
            } else {
                $this->session->set_userdata('username', $user['username']);
                redirect(base_url() . ADMIN_URL);
            }
        }
        $this->load->view('login', $this->data);
    }

    function change_password () {
      // var_dump($this->session->userdata('username'));
      // die;

      $username = $this->session->userdata('username');
      $this->data['check_error'] = -1;
      $this->data['user'] = $this->admin_model->get_row_by(array('username' =>  $username));
      // var_dump($this->data['admin']);
      // die;

      $this->data['error'] = -1;

        // $username = $this->session->userdata('username');
        // $this->data['check_error'] = -1;
        // $this->data['admin'] = $this->admin_model->get_by(array('username' =>  $username));

        if (empty($this->data['user'])) {
            redirect(base_url() . ADMIN_URL . 'admin');
        }
        if (isset($_POST['submit'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'matches[repassword]');
            $this->form_validation->set_rules('repassword', 'Password Confirmation');
            if ($this->form_validation->run() == FALSE) {
                $this->data['check_error'] = 1;
            } else {
                $update = array(
                    'fullname' => $this->input->post('fullname'),
                );
                if ($_POST['password']) {
                    $update['password'] = md5($_POST['password']);
                }

                $this->admin_model->update($update, $this->data['user']['id']);
                $this->data['check_error'] = 0;
                // $this->data['admin'] = $this->admin_model->get_by_key($id);
            }
        }
        $this->data['username'] = $username;
        $this->data['fullname'] =  $this->data['user']['fullname'];


        if (isset($this->data['user']['roles'])) {
            if (strpos($this->data['user']['roles'], $this->router->fetch_class()) === false) {
                $this->data["roles"] = explode(',', $this->data['user']['roles']);
            }
        }else{
          $this->data["roles"] = array();
        }
        if (isset($this->data['user']['role'])) {
            $this->data["role"] = $this->data['user']['role'];
        }else{
          // var_dump($this->data['user']);
            $this->data["role"] = "";
        }


        // $this->data['user'] = $this->data['admin'];
        $this->template->write_view('content_block', 'admin/ChangePassword', $this->data);
        $this->load->view('admin/ChangePassword', $this->data);
        $this->template->render();
    }

    function logout() {
      // Clear cache
        $this->session->set_userdata('username', '');

        redirect(base_url() . ADMIN_URL . 'auth/login');
    }

}
