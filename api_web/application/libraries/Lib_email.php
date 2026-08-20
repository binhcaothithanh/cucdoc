<?php

class Lib_email {

    function __construct() {
        $this->CI = $this->CI = & get_instance();
    }
    public function send($to, $subject, $message)
  	{
          $this->CI->load->config('email');
          $this->CI->load->library('email');

          $from = $this->CI->email->smtp_user;
          // $to = $this->input->post('to');
          // $subject = $this->input->post('subject');
          // $message = $this->input->post('message');

          $this->CI->email->set_newline("\r\n");
          $this->CI->email->from($from);
           $this->CI->email->to($to);

          $this->CI->email->subject($subject);
          $this->CI->email->message($message);
          $retVal = $this->CI->email->send();

          if($retVal) {
              // echo json_encode("send");
          } else {
              $error = $this->CI->email->print_debugger(array('headers'));
              echo json_encode($error);
          }
    }
}
