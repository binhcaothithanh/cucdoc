<?php

class Homeinfo extends BACKEND_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'homeinfo';
        $this->data['check_error'] = -1;
        if (isset($_POST['seo_title'])) {
            $this->data['check_error'] = 0;
            file_put_contents(APPPATH . 'cache/seo_home', serialize($_POST));
        }
        $this->data['result'] = @file_get_contents(APPPATH . 'cache/seo_home');
        if ($this->data['result']) {
            $this->data['result'] = unserialize($this->data['result']);
        }
        $this->template->write_view('content_block', 'seohome', $this->data);
        $this->template->render();
    }

}
