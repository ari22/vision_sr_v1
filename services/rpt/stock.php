<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();


$rptTitle = "VEHICLE STOCK REPORT";
$rptFile = "veh_sov.php";
$order = " ORDER BY veh_type,stk_date";

$cust_type = '';
$title = '';
$filterdesc = '';


if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1' :
            $rptFile = "type.php";
            $order = " ORDER BY veh_type,stk_date";
            $title = 'Vehicle Type, Color Code';

            break;

        case '2':
            $rptFile = "color.php";
            $order = " ORDER BY color_code,veh_code,stk_date";
            $title = 'Color Code, Vehicle Type';
            break;

        case '3':
            $rptFile = "supplier.php";
            $order = " ORDER BY supp_code,veh_code,color_code,stk_date";
            $title = 'Supplier, Vehicle Type';
            break;

        case '4' :
            $rptFile = "warehouse.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,stk_date";
            $title = 'Warehouse, Vehicle Type';
            break;

        case '5' :
            $rptFile = "location.php";
            $order = " ORDER BY loc_code,veh_code,color_code,stk_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}

$stk_date2 = '1970-01-01';
$stk_date = dateFormat($stk_date);

$statsql = "select * from " . $db1 . ".veh_stk a";
$datenow = date('Y-m-d');
$where = " WHERE 1=1 and stk_date<='" . $stk_date . "' and end_qty not in('0') ";

//$where = " WHERE 1=1 AND veh_stk.stk_date BETWEEN '".$stk_date."' AND '".$datenow."'";

if (!empty($_REQUEST['veh_code'])) {
    $veh_type = $_REQUEST['veh_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " veh_code  = '" . $veh_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Vehicle Type = " . $veh_code;
}

if (!empty($_REQUEST['color_code'])) {
    $color_code = $_REQUEST['color_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " color_code  = '" . $color_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= " Color = " . $color_code;
}

if (!empty($_REQUEST['supp_code'])) {
    $srep_code = $_REQUEST['supp_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " supp_code  = '" . $supp_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Supplier = " . $supp_code;
}

if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " wrhs_code  = '" . $wrhs_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Warehouse = " . $wrhs_code;
}

if (!empty($_REQUEST['loc_code'])) {
    $loc_code = $_REQUEST['loc_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " loc_code  = '" . $loc_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Location = " . $loc_code;
}


//$statsql .= $where . $order;
$statsql .= $where;

//$mounth = rangeMounth($stk_date2, $stk_date);

//$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';
//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "stock/" . $rptFile;

$filename = 'vehicle_stock_' . date('dmy') . '_' . date('his');
$tblimport = 'veh_stk';


$keys = array(
    'key1' => 'stock'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);



