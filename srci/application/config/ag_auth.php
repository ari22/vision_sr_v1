<?php

$config['auth_groups'] = array(
    'admin' => '1',
    'editor' => '2',
    'user' => '100'
);

/**
 * The default URI string to redirect to after a successful login.
 */
$config['auth_login'] = 'main';

/**
 * The default URI string to redirect to after a successful logout.
 */
$config['auth_logout'] = 'main';

/**
 * The URI string to redirect to when a user entered incorrect login details or is not authenticated
 */
$config['auth_incorrect_login'] = 'login';


/**
 * bool TRUE / FALSE
 * Determines whether or not users will be remembered by the auth library
 */
$config['auth_remember'] = TRUE;

/**
 * The following options provide the ability to easily rename the directories
 * for your auth views, models, and controllers.
 *
 * Remember to also update your routes file if you change the controller directory
 * MUST HAVE A TRAILING SLASH!
 */
$config['auth_controllers_root'] = '';
$config['auth_models_root'] = '';
$config['auth_views_root']  = 'auth/';

/**
 * Set the names for your user tables below (sans prefix, which will be automatically added)
 * ex.: your table is named `ci_users` with 'ci_' defined as your dbprefix in config/database.php, so set it to 'users' below
 */
$config['auth_user_table']  = 'users';
$config['auth_group_table'] = 'group';
?>