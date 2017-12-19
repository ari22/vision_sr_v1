<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "DELIVERY ORDER REPORT";

$table = 'veh_slh';


$where = ' WHERE 1=1';
$order = '';
$join = '';
$group = '';

$date1 = dateFormat($date1);
$date2 = dateFormat($date2);

if (!empty($_REQUEST['wrhs_code'])) {
    $where .= " and a.wrhs_code='$wrhs_code'";
}

if (!empty($_REQUEST['veh_code'])) {
    $where .= " and a.veh_code='$veh_code'";
}

if (!empty($_REQUEST['color_code'])) {
    $where .= " and a.color_code='$color_code'";
}

$where .= " and a.sj_no NOT IN('')";
$where .= " and a.cls_date NOT IN('0000-00-00') and a.cls_date >='" . $date1 . "' and a.cls_date <='" . $date2 . "'";

switch ($group_by) {
    case '1':
        $order = " ORDER BY a.veh_code, a.veh_name";
        $rptFile = 'veh.php';
        $title = 'By Vehicle Type';
        break;

    case '2':
        $order = " ORDER BY a.color_code, a.color_name";
        $rptFile = 'color.php';
        $title = 'By Color';
        break;
    case '3':
        $order = " ORDER BY a.wrhs_code,a.veh_code, a.veh_name";
        $rptFile = 'warehouse.php';
        $title = 'By Warehouse';
        break;

    case '4':
        $order = " ORDER BY a.lease_code, a.lease_name";
        $rptFile = 'leasing.php';
        $title = 'By Leasing';
        break;
}

$statsql = "select a.* from " . $db1 . ".$table a";
$statsql .= $join;
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}



include "suratjalan/" . $rptFile;

$tblimport = 'veh_slh';

$filename = 'deliveryorder_' . date('d') . '_' . date('m') . '_' . date('Y');

$keys = array(
    'key1' => 'do'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);

