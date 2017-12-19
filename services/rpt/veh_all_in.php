<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();


$rptTitle = "VEHICLE ALL IN REPORT";
$rptFile = "veh_sov.php";
$order = " ORDER BY a.veh_code,a.color_code,a.pur_date, a.chassis, a.engine";
$where = " where 1=1 ";
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
            $order = " ORDER BY a.color_code,a.veh_code,a.pur_date";
            $title = 'Color Type, Vehicle Type';
            break;

        case '3' :
            $rptFile = "wrhs.php";
            $order = " ORDER BY a.wrhs_code,a.veh_code,a.color_code,a.pur_date";
            $title = 'Warehouse, Vehicle Type';
            break;
    }
}
$statsql = "select 1 as unit, a.chassis, a.engine, a.veh_model, a.veh_transm, a.veh_year, a.key_no, a.serv_book, a.cust_code, a.cust_name, a.pur_inv_no, a.pur_date, a.sal_inv_no, a.sal_date, a.veh_name, a.veh_code, a.color_code, a.color_name, a.wrhs_code from veh a ";
 $statsql .= $where . $order;

/*
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
    $statsql = "select * from " . $dbs . ".veh ";

    $where = " WHERE 1=1";
    $where .= " and pur_date<='" . $dat . "' and pur_date not in ('0000-00-00') ";

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
        } $filterdesc .= "Vehicle Code ";
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
    $statsql .= $where . $order;

    $dtl = mysql_query($statsql) or die(mysql_error());
}

*/
  $dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "veh_all/" . $rptFile;

$filename = 'veh_all_in' . date('dmy') . '_' . date('his');
$tblimport = 'veh';


$keys = array(
    'key1' => 'veh'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
?>