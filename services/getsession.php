<?php

if (!empty($_SESSION['C_USER'])) {
    $query = "select * from ssystem";
    $result = mysql_query($query);
    $numfields = mysql_num_fields($result);
    
    for ($i = 0; $i < $numfields; $i++) {
        $fieldname[$i] = mysql_field_name($result, $i);
    }
    
    while ($row = mysql_fetch_assoc($result)) {
        for ($i = 0; $i < $numfields; $i++) {
            $_SESSION[$fieldname[$i]] = $row[$fieldname[$i]];
        }
    }
}

?>