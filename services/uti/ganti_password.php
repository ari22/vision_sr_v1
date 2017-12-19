<?php
session_start();
//$session= $_SESSION;
//unset($_SESSION['debug']);
//echo json_encode($_SESSION);exit;
if (!isset($_SESSION['C_USER'])) {
    echo '{"success":false,"message":"<font color=red>Session inactive c_username</font>"}';
    return;
}
if (!isset($_SESSION['C_ID'])) {
    echo '{"success":false,"message":"<font color=red>Session inactive c_userid</font>"}';
    return;
}
if (!isset($c_oldpwd)) {
    echo '{"success":false,"message":"<font color=red>Session inactive c_oldpwd</font>"}';
    return;
}
if (!isset($c_newpwd1)) {
    echo '{"success":false,"message":"<font color=red>Session inactive c_newpwd1</font>"}';
    return;
}
if (!isset($c_newpwd2)) {
    echo '{"success":false,"message":"<font color=red>Session inactive c_newpwd2</font>"}';
    return;
}

$passold = strtr(base64_encode($c_oldpwd), '+/', '-_');
//$passold = md5(hash("haval256,5", '12336', $c_oldpwd));
$statsql = "select id,username from usr where username = '" . $_SESSION['C_USER'] . "' and passwd = '$passold'";
$result = mysql_query($statsql);

//print_r($statsql);exit;
if (mysql_num_rows($result) == 0) {
    echo '{"success":false,"message":"<font color=red>Wrong Current Password</font>"}';
    return;
}

if ($c_newpwd1 == $c_newpwd2) {
    
} else {
    echo '{"success":false,"message":"<font color=red>New Password does not match</font>"}';
    return;
}

$passnew = strtr(base64_encode($c_newpwd1), '+/', '-_');
$statsql = "update usr set passwd = '$passnew' where username = '" . $_SESSION['C_USER'] . "'";

$result = mysql_query($statsql);
if (mysql_affected_rows() == 0) {
    echo '{"success":false,"message":"<font color=red>Update failed</font>"}';
} else {
    echo '{"success":true,"message":"Password changed"}';
}
?>