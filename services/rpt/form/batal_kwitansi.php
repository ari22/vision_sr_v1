<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$order = " ORDER BY veh_code,color_code,so_date";

$cust_type = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1' :
            $rptFile = "type.php";
            $order = " ORDER BY veh_code";
            $title = 'Vehicle Type, Color Type';
            break;

        case '2' :
            $rptFile = "color.php";
            $order = " ORDER BY color_code,veh_code";
            $title = 'Color Type, Vehicle Type';
            break;

        case '3' :
            $rptFile = "wrhs.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code";
            $title = 'Warehouse, Vehicle Type';
            break;
    }
}

$date1 = dateFormat($date1);

$date2 = dateFormat($date2);

$statsql = "SELECT a.* FROM " . $db1 . ".veh_kwch a";
$where = " WHERE 1=1 AND a.canc_date>='" . $date1 . "' AND a.canc_date<='" . $date2 . "'";

if (!empty($_REQUEST['veh_code'])) {
    $veh_type = $_REQUEST['veh_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.veh_code  = '" . $veh_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Vehicle Type =" . $veh_type;
}

if (!empty($_REQUEST['color_code'])) {
    $color_code = $_REQUEST['color_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.color_code  = '" . $color_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Color =" . $color_code;
}

if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.wrhs_code  = '" . $wrhs_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Warehouse =" . $wrhs_code;
}

$statsql .= $where;


$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include"batalkwitansi/" . $rptFile;

$filename = 'batalkwitansi_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_kwch';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
