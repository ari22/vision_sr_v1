<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';

$newurl = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);

$config['base_url'] = "$http" . $_SERVER['SERVER_NAME'].$newurl;
$config['lib_url'] = "$http" . $_SERVER['SERVER_NAME'].'/';


$config['index_page'] = 'index.php/';
$config['uri_protocol'] = 'AUTO';
$config['url_suffix'] = '';
$config['language'] = 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
//$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['permitted_uri_chars'] = '';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd'; // experimental not currently in use
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['cache_path'] = '';
$config['encryption_key'] = '12336';
$config['sess_cookie_name'] = 'session1';
$config['sess_expiration'] = 86400 * 30;
$config['sess_expire_on_close'] = FALSE;
$config['sess_encrypt_cookie'] = FALSE;
$config['sess_use_database'] = false;
$config['sess_table_name'] = '';
$config['sess_match_ip'] = FALSE;
$config['sess_match_useragent'] = TRUE;
$config['sess_time_to_update'] = 86400 * 365;
$config['cookie_prefix'] = "";
$config['cookie_domain'] = "";
$config['cookie_path'] = "/";
$config['cookie_secure'] = FALSE;
$config['global_xss_filtering'] = true;
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
