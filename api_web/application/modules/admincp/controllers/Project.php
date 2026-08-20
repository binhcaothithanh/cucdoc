<?php

/**
 * @property project_Model $project_model
 */
Class project extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'project';
        $this->data['role_details'] = array(
            'category' => 'Danh mục', 'order' => 'Đơn hàng',
            'export_shipping' => 'In đơn hàng',
            'update_shipping' => 'Xuất đơn hàng', 'gallery' => 'Banner',
            'product' => 'Sản phẩm', 'attribute_type' => 'Thuộc tính',
            'report' => 'Thống kê', 'cache' => 'Xóa cache',
            'amdin' => 'Tài khoản', 'page' => 'Page', 'homeinfo' => 'SEO HOME'
        );
    }

    public function index() {

      $this->data['results'] = $this->project_model->get_all();
      if($this->data['user']['role'] == 'admin'){

      }else{
        // Get from filter
      }

        $this->template->write_view('content_block', 'project/index', $this->data);
        $this->template->render();
    }
 // avc
    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {
            // $project_name = $this->input->post('project_name');
            // $project = $this->project_model->get_row_by(array('project_name' => $project_name));

            // if (empty($project)) {
                $insert = array(
                    'project_name' => $this->input->post('project_name'),
                    'status' => 'open',
                    'type' => $this->input->post('type'),
                    'note' => $this->input->post('note'),
                    'created_date' => date("Y/m/d"),
                );

                $this->project_model->insert($insert);
                $this->data['check_error'] = 0;
            // } else {
            //     $this->data['check_error'] = 1;
            //     $this->data['msg'] = 'Tên dự án đã tồn tại';
            // }

                    header("location: /admincp/project");
        }
        $this->template->write_view('content_block', 'project/add', $this->data);
        $this->template->render();
    }
 // avc
    public function project_details($id) {
      $id = intval($id);
      $this->data['check_error'] = -1;
      $this->data['project'] = $this->project_model->get_by_key($id);
      if (empty($this->data['project'])) {
          redirect(base_url() . PROJECT_URL. '/project');
      }
      if (isset($_POST['submit'])) {
        $insert = array(
            'project_name' => $this->input->post('project_name'),
            'status' => 'open',
            'note' => $this->input->post('note'),
            'created_date' => date("Y/m/d"),
        );

          $this->project_model->update($update, $id);
          $this->data['check_error'] = 0;
          $this->data['project'] = $this->project_model->get_by_key($id);

      }

      $this->template->write_view('content_block', 'project/money', $this->data);
      $this->template->render();
    }
// a
    public function edit($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['project'] = $this->project_model->get_by_key($id);
        if (empty($this->data['project'])) {
            redirect(base_url() . PROJECT_URL . '/project');
        }
        if (isset($_POST['submit'])) {
            $update = array(
                'project_name' => $this->input->post('project_name'),
                'status' => $this->input->post('status'),
                'type' => $this->input->post('type'),
                'note' => $this->input->post('note'),
            );

            $this->project_model->update($update, $id);
            $this->data['check_error'] = 0;
            $this->data['project'] = $this->project_model->get_by_key($id);

                    header("location: /admincp/project");
        }


        $this->template->write_view('content_block', 'project/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->project_model->delete($id);
    }

    // ajax function (search project from time to time)
    function page() {
        $parrams = $this->security->xss_clean($_REQUEST);
        $cond = ($parrams['projectName']) ? 'project_name like "%' . trim($parrams['projectName']) . '%"' : null;
        if ($parrams['fromTime']) {
            $temp = 'created_date >= "' . $parrams['fromTime'] . '"';

            if ($cond != null) {
                $cond .= ' and (' . $temp . ')';
            } else {
                $cond = '(' . $temp . ')';
            }
        }
        if ($parrams['toTime']) {
            $temp = 'created_date <= "' . $parrams['toTime'] . '"';

            if ($cond != null) {
                $cond .= ' and (' . $temp . ')';
            } else {
                $cond = '(' . $temp . ')';
            }
        }


        // if ($this->data['user']['role'] == 'staff') {
        //     $cond != null ? $cond.=' and ' : '';
        //     $cond.=' username_owner = "' . $this->data['user']['username'] . '"';
        // }
//        die($temp);
        // if ($parrams['shipping_type']) {
        //     $cond != null ? $cond.=' and ' : '';
        //     $cond.='shipping_type = "' . $parrams['shipping_type'] . '"';
        // }
        // $pos = intval($parrams['pos']);
        // if ($pos < 0) {
        //     $pos = 0;
        // }

        // setcookie("order_pos", $pos, (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        // setcookie("status_order", $parrams['status'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);
        // setcookie("shipping_type", $parrams['shipping_type'], (time() + (86400 * 10)), '/', $_SERVER['SERVER_NAME']);

        $data['results'] = $this->project_model->get_by($cond);

        // $total = $this->order_model->get_total_rows($cond);
        // $data['links'] = $this->get_page($pos, $total, $this->limit);
        // include APPPATH . 'config/maps_order.php';
        // $data['maps_shipping'] = $this->data['maps_shipping'];
        // $data['status_order'] = $this->data['status_order'];
        // $data['total'] = $total;
        $data['user']['role'] = $parrams['user_role'];
        $this->load->view('project/list_ajax', $data);
    }
}
