<?php

/**
 * @property Timesheet_model $Timesheet_model
 */
Class Timesheet extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Timesheet_model');
        $this->load->model('Staff_model');
        $this->load->model('Group_model');
        $this->load->library('form_validation');
        $this->data['pre1'] = 'timesheet';
        $this->data['pre2'] = 'timesheet';
        $this->data['list_staff'] = $this->Staff_model->get_all();
        $this->data['list_group'] = $this->Group_model->get_all();
    }

    public function index() {
        $this->template->write_view('content_block', 'timesheet/index', $this->data);
        $this->template->render();
    }

    public function ajaxFilterTime() {

        $parrams = $this->security->xss_clean($_REQUEST);
        $query = 'SELECT coffee_group.group_name, coffee_group.money, sum(coffee_timesheet.salary_used) as salary_used, coffee_staff.username,coffee_staff.id, SUM(TIME_TO_SEC(TIMEDIFF(coffee_timesheet.out_time, coffee_timesheet.in_time)))/(60*60) as total_time FROM coffee_timesheet, coffee_staff, coffee_group
        WHERE coffee_staff.id = coffee_timesheet.user_id AND coffee_staff.group_id = coffee_group.id ';

        $startTime = date_default_timezone_set('Asia/Ho_Chi_Minh');        // Set Time-Zone
        $endTime = date_default_timezone_set('Asia/Ho_Chi_Minh');        // Set Time-Zone


        $this->data['fromTime'] = '';
        $this->data['toTime'] = '';

        if (isset($parrams['fromTime'])) {
            $query .= ' AND coffee_timesheet.created_date >= "'. $parrams['fromTime'] . '" ';
            $this->data['fromTime'] = $parrams['fromTime'];
        }
        // else{
        //     $startTime = date('Y-m-1'); //Fomat Date and time
        // }

        if (isset($parrams['toTime'])) {
            $query .= ' AND coffee_timesheet.created_date <= "' . $parrams['toTime'] . '" ';
            $this->data['toTime'] = $parrams['toTime'];
        }
        // else{
        //     $endTime = date('Y-m-t'); //Fomat Date and time
        // }


        $query .= 'GROUP BY coffee_timesheet.user_id';

        // die($query);


        $this->data['results'] = $this->Timesheet_model->query_row($query);
        $this->load->view('timesheet/list_ajax', $this->data);
    }

    public function details() {
        $parrams = $this->security->xss_clean($_REQUEST);
        // echo('<pre>');
        // var_dump($parrams);
        // die;
        $this->data['user_id'] = $parrams['user_id'];
        $this->data['fromTime'] = $parrams['fromTime'];
        $this->data['toTime'] = $parrams['toTime'];
        $this->template->write_view('content_block', 'timesheet/details', $this->data);
        $this->template->render();
    }

    public function ajaxDetails($user_id) {

        $parrams = $this->security->xss_clean($_REQUEST);
        // var_dump($user_id);
        // die;

        if(isset($user_id)){
            $query = 'SELECT coffee_group.group_name, coffee_group.money, coffee_timesheet.id as timesheet_id, coffee_timesheet.*, coffee_staff.*, (TIME_TO_SEC(TIMEDIFF(coffee_timesheet.out_time, coffee_timesheet.in_time)))/(60*60) as total_time
            FROM coffee_timesheet, coffee_staff,coffee_group
            WHERE coffee_staff.group_id = coffee_group.id AND coffee_staff.id = coffee_timesheet.user_id AND coffee_timesheet.user_id = ' . $user_id;
        }
        else{
            echo('error: ');
            var_dump($user_id);
            die;
        }
        // else{
        //     $query = 'SELECT coffee_group.group_name,coffee_group.money, coffee_timesheet.id as timesheet_id, coffee_timesheet.*, coffee_staff.*, SUBTIME(coffee_timesheet.out_time, coffee_timesheet.in_time) as total_time
        //     FROM coffee_timesheet, coffee_staff, coffee_group
        //     WHERE coffee_staff.group_id = coffee_group.id AND coffee_staff.id = coffee_timesheet.user_id ';
        // }


        $startTime = date_default_timezone_set('Asia/Ho_Chi_Minh');        // Set Time-Zone
        $endTime = date_default_timezone_set('Asia/Ho_Chi_Minh');        // Set Time-Zone

        // $this->data['fromTime'] = '';
        // $this->data['toTime'] = '';
        if (isset($parrams['fromTime'])) {
            $query .= ' AND coffee_timesheet.created_date >= "'. $parrams['fromTime'] . '" ';
            // $this->data['fromTime'] = $parrams['fromTime'];
        }
        // else{
        //     $startTime = date('Y-m-1'); //Fomat Date and time
        // }

        if (isset($parrams['toTime'])) {
            $query .= ' AND coffee_timesheet.created_date <= "' . $parrams['toTime'] . '" ';
            // $this->data['toTime'] = $parrams['toTime'];
        }
         $query .= ' ORDER BY coffee_timesheet.created_date ASC';
        // else{
        //     $endTime = date('Y-m-t'); //Fomat Date and time
        // }
        // die($query);
        $this->data['results'] = $this->Timesheet_model->query_row($query);
        $this->load->view('timesheet/list_ajax_detail', $this->data);
    }

    public function add() {
        $this->data['check_error'] = -1;
        if (isset($_POST['submit'])) {

          if($this->input->post('full_month')){
            $start_date = new DateTime('first day of this month');
            $end_date = new DateTime('last day of this month');
            // Create a DatePeriod object that will iterate through each day
            $interval = new DateInterval('P1D'); // 1 day interval
            $daterange = new DatePeriod($start_date, $interval, $end_date->modify('+1 day'));


            $insert = array(
                'user_id' => $this->input->post('user_id'),
                'in_time' => $this->input->post('in_time'),
                'out_time' => $this->input->post('out_time'),
                'salary_used' => 0,
                'created_date' => date('Y-m-d', strtotime($this->input->post('created_date'))) ,
            );
            $count = 0;
            foreach ($daterange as $date) {
                $insert['created_date'] = $date->format('Y-m-d');
                if($this->Timesheet_model->insert_data_if_date_not_exists($date->format('Y-m-d'), $insert)){
                  $count++;
                }
            }
            // die('total insert: ' . $count);
          }else{
            $timesheet_name = $this->input->post('timesheet_name');
            $insert = array(
                'user_id' => $this->input->post('user_id'),
                'in_time' => $this->input->post('in_time'),
                'out_time' => $this->input->post('out_time'),
                'salary_used' => $this->input->post('salary_used'),
                'created_date' => date('Y-m-d', strtotime($this->input->post('created_date'))) ,
            );
            $this->Timesheet_model->insert($insert);
            $this->data['check_error'] = 0;
          }
        }

        $this->template->write_view('content_block', 'timesheet/add', $this->data);
        $this->template->render();
    }

    public function editTimeSheetDetails($id) {
        $id = intval($id);
        $this->data['check_error'] = -1;
        $this->data['timesheet'] = $this->Timesheet_model->get_by_key($id);

        $query = 'SELECT coffee_staff.username FROM coffee_timesheet, coffee_staff
        WHERE coffee_staff.id = coffee_timesheet.user_id
        and coffee_timesheet.id = '. $id .' LIMIT 1 ';
        $this->data['staff'] = $this->Timesheet_model->query_row($query)[0];

        // var_dump($this->data['staff']);
        // die ($query);

        // die('id :' . $id);
        if (empty($this->data['timesheet'])) {
            redirect(base_url() . ADMIN_URL . 'timesheet');
        }
        if (isset($_POST['submit'])) {
            $img = $this->input->post('image1');

                $update = array(
                  'in_time' => $this->input->post('in_time'),
                  'out_time' => $this->input->post('out_time'),
                  'salary_used' => $this->input->post('salary_used'),
                  'created_date' => date('Y-m-d', strtotime($this->input->post('created_date'))) ,
                );
                // if ($_POST['password']) {
                //     $update['password'] = md5($_POST['password']);
                // }

                $this->Timesheet_model->update($update, $id);
                $this->data['check_error'] = 0;
                $this->data['timesheet'] = $this->Timesheet_model->get_by_key($id);
            // }
            redirect(base_url() . ADMIN_URL . 'timesheet');
        }
        $this->template->write_view('content_block', 'timesheet/edit', $this->data);
        $this->template->render();
    }

    public function del() {
        $id = intval($_POST['id']);
        $this->Timesheet_model->delete($id);
    }
}
