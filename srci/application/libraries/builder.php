<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ob_start();

class builder {

    var $CI;

    public function __construct() {
        log_message('debug', 'Auth Library Loaded');

        $this->config = $config;

        $this->CI = & get_instance();
        $this->CI->load->database();
        $this->CI->load->model('all_m');
    }

    

}
