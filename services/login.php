<?php

include_once "globalFunctions.php";
session_start();
//echo $c_user;
//echo $c_password;
if ($func == 'auth') {

    //$conn = connDB();
    //$pass = md5(hash("haval256,5", '12336', $c_password));
    $pass = strtr(base64_encode($c_password), '+/', '-_');
    $query = "select count(username) as n_count,id, curr_login from usr where username ='$c_user' and passwd = '$pass'";
    //echo $query;
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    if ($row['n_count'] == 1) {
        //$_SESSION['C_ID']=$row['id'];
        $_SESSION['C_USER'] = $c_user;
        $_SESSION['C_ID'] = $row['id'];
        echo '{"success":"true","message":"Welcome ' . $c_user . '"}';
        //$curr_login = $row['curr_login'] + 1;
        $curr_login = 1;
        $sql = "update usr set lin_dtime=now(), curr_login='$curr_login' where username ='$c_user'";
        mysql_query($sql);
        return;
    } else {
        echo '{"success":"false","message":"Wrong username or password"}';
        return;
    }
    mysql_close($conn);
}

if ($func == 'checksession') {
    if (!empty($_SESSION['C_USER'])) {
        $msg = array('success' => true);
    } else {
        $msg = array('success' => false);
    }
    echo json_encode($msg);
}


function set_value($field = '', $default = '') {
    if (!isset($field)) {
        return $default;
    }

    // If the data is an array output them one at a time.
    //     E.g: form_input('name[]', set_value('name[]');
    if (is_array($field)) {
        return array_shift($field);
    }

    return $field;
}

?>
