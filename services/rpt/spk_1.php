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
            $order = " ORDER BY so_date";
            $title = 'Vehicle Type, Color Type';
            break;
        case '2' :
            $rptFile = "veh_soc.php";
            $order = " ORDER BY so_date,color_code,veh_code";
            $title = 'Color Type, Vehicle Type';
            break;
        case '3' :
            $rptFile = "veh_sod.php";
            $order = " ORDER BY so_date,cust_code,veh_code,color_code";
            $title = 'Customer, Vehicle Type';
            break;
        case '4' :
            $rptFile = "veh_sos.php";
            $order = " ORDER BY so_date,srep_code,veh_code,color_code";
            $title = 'Sales Person, Vehicle Type';
            break;
        case '5' :
            $rptFile = "veh_sow.php";
            $order = " ORDER BY so_date,wrhs_code,veh_code,color_code";
            $title = 'Warehouse, Vehicle Type';
            break;
        case '6' :
            $rptFile = "veh_sol.php";
            $order = " ORDER BY so_date,lease_code,veh_code,so_date,color_code";
            $title = 'Leasing/Non Leasing, Vehicle Type';
            break;
        case '7' :
            $rptFile = "veh_soct.php";
            $order = " ORDER BY so_date,cust_city,veh_code,so_date,color_code";
            $title = 'Customer City, Vehicle Type';
            break;
    }
}

$so_date1 = dateFormat($so_date1);

$so_date2 = dateFormat($so_date2);
$statsql = "select a.cust_city, a.lease_name, a.lease_code, a.wrhs_code, a.veh_code, a.veh_name, a.color_code, a.color_name, a.so_date, a.so_no, a.cust_name, a.cust_code, a.veh_type, a.color_type, a.veh_year, a.veh_transm, a.srep_name, a.srep_code, a.sspv_name, a.sspv_code, a.so_made_by, a.so_appr_by, a.qty, a.pay_type, a.pay_date, a.check_no, a.check_date, a.pred_stk_d, a.unit_price, a.unit_disc, a.tot_price, a.pay_val from " . $db1 . ".veh_spk a ";
//$statsql = "select a.* from veh_spk a  ";
//$statsql = "select a.*,b.dp_begin from veh_spk a left join veh_dpch b on a.so_no = b.so_no  ";
$where = " WHERE 1=1 and a.so_date>='" . $so_date1 . "' and a.so_date<='" . $so_date2 . "'";
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
            $where .= " (a.cls_date !='0000-00-00' or a.cls_date <= '" . $so_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";

            $where .= "and a.cls_date>='" . $so_date1 . "' and a.cls_date<='" . $so_date2 . "'";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $so_date2 . "') ";
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

if (!empty($_REQUEST['cust_type'])) {
    $cust_type = $_REQUEST['cust_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_type  = '" . $cust_type . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Customer Type =" . $cust_type;
}

if (!empty($_REQUEST['srep_code'])) {
    $srep_code = $_REQUEST['srep_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.srep_code  = '" . $srep_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Sales =" . $srep_code;
}
if (!empty($_REQUEST['sspv_code'])) {
    $sspv_code = $_REQUEST['sspv_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.sspv_code  = '" . $sspv_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Supervisor =" . $sspv_code;
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

if (!empty($_REQUEST['cust_city'])) {
    $cust_city = $_REQUEST['cust_city'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_city  = '" . $cust_city . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "City Customer = " . $cust_city;
}
if (!empty($_REQUEST['lease_code'])) {
    $lease_code = $_REQUEST['lease_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.lease_code  = '" . $lease_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Leasing = " . $lease_code;
}

$statsql .= $where;

$statsql .= " UNION select a.cust_city, a.lease_name, a.lease_code, a.wrhs_code, a.veh_code, a.veh_name, a.color_code, a.color_name, a.so_date, a.so_no, a.cust_name, a.cust_code, a.veh_type, a.color_type, a.veh_year, a.veh_transm, a.srep_name, a.srep_code, a.sspv_name, a.sspv_code, a.so_made_by, a.so_appr_by, a.qty, a.pay_type, a.pay_date, a.check_no, a.check_date, a.pred_stk_d, a.unit_price, a.unit_disc, a.tot_price, a.pay_val from " . $db1 . ".vehspkch a ";
$statsql .= " WHERE 1=1 and a.so_date>='" . $so_date1 . "' and a.so_date<='" . $so_date2 . "'";


$mounth = rangeMounth($so_date1, $so_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//echo $statsql;exit;

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