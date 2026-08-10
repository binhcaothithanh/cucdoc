<?php

Class Cache extends BACKEND_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['pre1'] = 'other';
        $this->data['pre2'] = 'cache';
    }

    public function index() {
        @$this->memcache = new Memcached;
        @$this->memcache->addServer('localhost', 11211);
        $this->memcache->flush();
        redirect(base_url() . ADMIN_URL);
    }

}
