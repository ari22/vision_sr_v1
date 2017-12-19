<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	http://codeigniter.com/user_guide/general/hooks.html
  |
 */



/* End of file hooks.php */
/* Location: ./application/config/hooks.php */

/* config/hooks.php */
/*$hook['post_system'][] = array(
    'class' => 'LogQueryHook',
    'function' => 'log_queries',
    'filename' => 'LogQueryHook.php',
    'filepath' => 'hooks'
);*/

$hook['display_override'][] = array(
    'class' => '',
    'function' => 'compress',
    'filename' => 'compress.php',
    'filepath' => 'hooks'
);
