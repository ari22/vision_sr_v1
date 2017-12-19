<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Main extends Application {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        
       print_r(DBPATH);
    }

    function loader() {
        
    }

}
