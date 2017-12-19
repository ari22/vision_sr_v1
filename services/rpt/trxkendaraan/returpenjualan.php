<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}
$tbl = tblstyle();
$rptFile = "veh_rslv.php";
$order = " ORDER BY veh_code,color_code,rsl_date";
$rptTitle = "VEHICLE SALES RETURN REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';

$rsl_date1 = dateFormat($rsl_date1);
$rsl_date2 = dateFormat($rsl_date2);

$statsql = "select a.*,a.wrhs_code as wrhs_name,1 as qty from " . $db1 . ".veh_rslh a  ";
//$where = " WHERE 1=1 and a.rsl_date<>'0000-00-00' ";

$where = " WHERE 1=1 ";
//$where = " WHERE 1=1 and a.opn_date >='" . $rsl_date1 . "' and a.opn_date <='" . $rsl_date2 . "'";

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "type.php";
            $order = " ORDER BY veh_code,color_code,rsl_date";
            $title = 'Vehicle Type, Color';
            break;
        case '2' :
            $rptFile = "color.php";
            $order = " ORDER BY color_code,veh_code,rsl_date";
            $title = 'Color, Vehicle Type';
            break;
        case '3' :
            $rptFile = "dealer.php";
            $order = " ORDER BY cust_code,veh_code,color_code,rsl_date";
            $title = 'Dealer, Vehicle Type';

            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " a.cust_type  = '2' ";
            if ($len >> 0) {
                $filterdesc .= " AND ";
            }

            break;
        case '4' :
            $rptFile = "customer.php";
            $order = " ORDER BY cust_code,veh_code,color_code,rsl_date";
            $title = 'Customer, Vehicle Type';
            break;
        case '5' :
            $rptFile = "sales.php";
            $order = " ORDER BY srep_code,veh_code,color_code,rsl_date";
            $title = 'Sales, Vehicle Type';
            break;
        case '6' :
            $rptFile = "warehouse.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,rsl_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        case '7' :
            $rptFile = "location.php";
            $order = " ORDER BY loc_code,rsl_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}


if (!empty($rsal_cls)) {
//Closed,1
//Not Closed,2
//All SPK,3
    $rsal_cls = $_REQUEST['rsal_cls'];
    switch ($rsal_cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date is not null) ";
            $where .= " (a.cls_date not in('0000-00-00')) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= ", ";
            } $filterdesc .= "Close Date";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date is null or a.cls_date > '" . $rsl_date2 . "') ";
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $rsl_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                //$filterdesc .= " AND ";
            } //$filterdesc .= "Close Date ";
            break;
        case '3' :
            /* $len = strlen($where);
              if ($len >> 0) {
              $where .= " AND ";
              }
              $where .= " (a.rsl_date <= '" . $rsl_date2 . "' and a.rsl_date >= '" . $rsl_date1 . "' ) ";
              $len = strlen($filterdesc);
              if ($len >> 0) {
              $filterdesc .= " AND ";
              } */
            //$filterdesc .= "Close Date ";
            break;
    }
}

if (!empty($_REQUEST['veh_code'])) {
    $veh_code = $_REQUEST['veh_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.veh_code  = '" . $veh_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Vehicle Type = ".$veh_code;
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
    } $filterdesc .= "Color = ".$color_code;
}



if (!empty($_REQUEST['cust_code'])) {
    $cust_code = $_REQUEST['cust_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_code  = '" . $cust_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Customer = ".$cust_code;
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
    } $filterdesc .= "Sales = ".$srep_code;
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
    } $filterdesc .= "Supervisor = ".$sspv_code;
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
    } $filterdesc .= "Warehouse = ".$wrhs_code;
}
if (!empty($_REQUEST['loc_code'])) {
    $loc_code = $_REQUEST['loc_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.loc_code  = '" . $loc_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Location = " . $loc_code;
}


$statsql .= $where;

$mounth = rangeMounth($rsl_date1, $rsl_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';


//$statsql .= $where . $order;
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "returPenjualan/" . $rptFile;
$filename = 'vehicle_sales_return_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_rslh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

?>