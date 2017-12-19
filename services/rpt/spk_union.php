<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptFile = "veh_sov.php";
$order = " ORDER BY veh_code,color_code,so_date";

$cust_type = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "veh_sov.php";
            $title = 'Vehicle Type, Color Type';
            break;
        case '2' :
            $rptFile = "veh_soc.php";
            $order = " ORDER BY color_code,veh_code,so_date";
            $title = 'Color Type, Vehicle Type';
            break;
        case '3' :
            $rptFile = "veh_sod.php";
            $order = " ORDER BY cust_code,veh_code,color_code,so_date";
            $title = 'Customer, Vehicle Type';
            break;
        case '4' :
            $rptFile = "veh_sos.php";
            $order = " ORDER BY srep_code,veh_code,color_code,so_date";
            $title = 'Sales Person, Vehicle Type';
            break;
        case '5' :
            $rptFile = "veh_sow.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,so_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        case '6' :
            $rptFile = "veh_sol.php";
            $order = " ORDER BY lease_code,veh_code,so_date,color_code";
            $title = 'Leasing/Non Leasing, Vehicle Type';
            break;
        case '7' :
            $rptFile = "veh_soct.php";
            $order = " ORDER BY cust_city,veh_code,so_date,color_code";
            $title = 'Customer City, Vehicle Type';
            break;
    }
}

$so_date1 = dateFormat($so_date1);

$so_date2 = dateFormat($so_date2);
//$statsql = "select cust_city, lease_name, lease_code, wrhs_code, veh_code, veh_name, color_code, color_name, so_date, so_no, cust_name, cust_code, veh_type, color_type, veh_year, veh_transm, srep_name, srep_code, sspv_name, sspv_code, so_made_by, so_appr_by, qty, pay_type, pay_date, check_no, check_date, pred_stk_d, unit_price, unit_disc, tot_price, pay_val from veh_spk a ";
//$statsql = "select * from veh_spk a  ";
//$statsql = "select *,b.dp_begin from veh_spk a left join veh_dpch b on so_no = b.so_no  ";
$where = " WHERE 1=1 and so_date>='" . $so_date1 . "' and so_date<='" . $so_date2 . "'";
if (!empty($so_cls)) {
//Closed,1
//Not Closed,2
//All SPK,3
    $so_cls = $_REQUEST['so_cls'];
    switch ($so_cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (cls_date !='0000-00-00' or cls_date <= '".$so_date2."') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            
            $where .= "and cls_date>='" . $so_date1 . "' and cls_date<='" . $so_date2 . "'";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (cls_date='0000-00-00' or cls_date is null or cls_date > '" . $so_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            break;
        case '3' :
            break;
    }
}

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
    } $filterdesc .= "Vehicle Type =".$veh_type;
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
    } $filterdesc .= "Color =".$color_code;
}

if (!empty($_REQUEST['cust_type'])) {
    $cust_type = $_REQUEST['cust_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " cust_type  = '" . $cust_type . "' ";
    if ($len >> 0) {
         $filterdesc .= ", ";
    } $filterdesc .= "Customer Type =".$cust_type;
}

if (!empty($_REQUEST['srep_code'])) {
    $srep_code = $_REQUEST['srep_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " srep_code  = '" . $srep_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Sales =".$srep_code;
}
if (!empty($_REQUEST['sspv_code'])) {
    $sspv_code = $_REQUEST['sspv_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " sspv_code  = '" . $sspv_code . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Supervisor =".$sspv_code;
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
    } $filterdesc .= "Warehouse =".$wrhs_code;
}

//$statsql .= " union select cust_city, lease_name, lease_code, wrhs_code, veh_code, veh_name, color_code, color_name, so_date, so_no, cust_name, cust_code, veh_type, color_type, veh_year, veh_transm, srep_name, srep_code, sspv_name, sspv_code, so_made_by, so_appr_by, qty, pay_type, pay_date, check_no, check_date, pred_stk_d, unit_price, unit_disc, tot_price, pay_val from test_server.veh_spk a ";
$statsql1 = "select * from ".$db1.".veh_spk ".$where;


$statsql2 = "select * from test_server.veh_spk ".$where;
//$statsql2 .= $where . $order;

$sql =  $statsql1." UNION ".$statsql2. $order;

$statsql .= $sql;

//echo $statsql; exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include"spk/" . $rptFile;

$filename = 'spk_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_spk';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

?>