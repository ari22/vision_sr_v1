<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();


$rptTitle = "VEHICLE STOCK CARD REPORT";
$rptFile = "veh_sov.php";
$order = " ORDER BY veh_stk.veh_code,veh_stk.color_code,veh_stk.pur_date, veh_stk.chassis, veh_stk.engine";

$cust_type = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1' :
            $rptFile = "type.php";
            $title = 'Vehicle Type, Color Type';
            break;

        case '2':
            $rptFile = "color.php";
            $order = " ORDER BY veh_stk.color_code,veh_stk.veh_code,veh_stk.pur_date";
            $title = 'Color Type, Vehicle Type';
            break;

        case '3' :
            $rptFile = "wrhs.php";
            $order = " ORDER BY veh_stk.wrhs_code,veh_stk.veh_code,veh_stk.color_code,veh_stk.pur_date";
            $title = 'Warehouse, Vehicle Type';
            break;
    }
}

$dtl = 0;
$year = $_REQUEST['year'];
$mounth = $_REQUEST['mounth'];

$lenmth = strlen($mounth);

$mth = $mounth;

if ($lenmth == 1) {
    $int = 0;
    $mth = $int . $mounth;
}


    $tahun = $_SESSION['tahun'];
    $bulan = $_SESSION['bulan'];
    
    $lenmth2 = strlen($bulan);
    if ($lenmth2 == 1) {
        $int2 = 0;
        $bulan = $int2 . $bulan;
    }
    
   $period = strtotime($tahun . $bulan);
   $periodselect = strtotime($year . $mth);

    if ($periodselect < $period) {
        $dbs = $db1 . '_pr' . $year . $mth;
    } else {
        $dbs = $db1;
    }

$dat = $year . '-' . $mounth . '-31';
    
if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$dbs' ")))) {
    $statsql = "select * from " . $dbs . ".veh_stk ";

    $where = " WHERE 1=1";
    $where .= " and pur_date<='" . $dat . "' and pur_date not in ('0000-00-00') ";

    if (!empty($_REQUEST['veh_code'])) {
        $veh_type = $_REQUEST['veh_code'];
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " veh_stk.veh_code  = '" . $veh_code . "' ";
        $len = strlen($filterdesc);
        if ($len >> 0) {
            $filterdesc .= ", ";
        } $filterdesc .= "Vehicle Code ";
    }

    if (!empty($_REQUEST['color_code'])) {
        $color_code = $_REQUEST['color_code'];
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " veh_stk.color_code  = '" . $color_code . "' ";
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
        $where .= " veh_stk.wrhs_code  = '" . $wrhs_code . "' ";
        if ($len >> 0) {
            $filterdesc .= ", ";
        } $filterdesc .= "Warehouse =" . $wrhs_code;
    }
    $statsql .= $where . $order;

    $dtl = mysql_query($statsql) or die(mysql_error());
}


if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "unit_/" . $rptFile;

$filename = 'stock_table_unit' . date('dmy') . '_' . date('his');
$tblimport = 'veh_stk';


$keys = array(
    'key1' => 'stock_unit'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
?>