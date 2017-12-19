<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = $_POST['table1'];

$fielddate = 'opn_date';

if ($tbl == 'veh_arh' || $tbl == 'acc_arh') {
    $fielddate = 'sal_date';
}
if ($tbl == 'veh_aph' || $tbl == 'acc_aph') {
    $fielddate = 'pur_date';
}


$statsql = "select a.* from " . $db1 . ".$tbl a  ";
//$where = " WHERE 1=1 and a.$fielddate >='" . $date1 . "' and a.$fielddate <='" . $date2 . "'";
$where = " WHERE 1=1 ";
$where .=" AND $inv_no='$val_no' ";

$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= ' LIMIT 1';


$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    $alldata = array();
} else {
    $row = mysql_fetch_assoc($dtl);
    $header = $row;

    $defaultfields = "*";
    if (isset($fields)) {
        $defaultfields = $fields;
    }
    $result = "select $defaultfields from " . $db1 . ".$table2 where 1=1 ";
    $result .=" AND $inv_no='$val_no' ";

    $mounth = rangeMounth($date1, $date2);

    $result .= queryUnion($mounth, $db1, $result);

    $sql = "select count(sal_inv_no) as n_count from ($result) a ";
    // echo $result;exit;
    $result = mysql_query($result);

    $datas = array();
    while ($row = mysql_fetch_object($result)) {
        $datas[] = $row;
        unset($row);
    }
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $detail = array(
        'total' => $row['n_count'],
        'rows' => $datas
    );

    $alldata = array(
        'header' => $header,
        'detail' => $detail
    );
}

echo json_encode($alldata);
