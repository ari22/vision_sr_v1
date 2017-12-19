<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptFile = "veh_prv.php";
$order = " ORDER BY veh_code,color_code,pur_date";
$rptTitle = "VEHICLE PURCHASE REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "veh_prv.php";
            $order = " ORDER BY veh_code,color_code,pur_date";
            $title = 'Vehicle Type, Color';
            break;
        case '2' :
            $rptFile = "veh_prc.php";
            $order = " ORDER BY color_code,veh_code,pur_date";
            $title = 'Color, Vehicle Type';
            break;
        case '3' :
            $rptFile = "veh_prs.php";
            $order = " ORDER BY supp_code,veh_code,color_code,pur_date";
            $title = 'Supplier, Vehicle Type';
            break;
        case '4' :
            $rptFile = "veh_prw.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,pur_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        case '5' :
            $rptFile = "veh_loc.php";
            $order = " ORDER BY loc_code,pur_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}

$pur_date1 = dateFormat($pur_date1);
$pur_date2 = dateFormat($pur_date2);

$statsql = "select a.*,a.wrhs_code as wrhs_name from " . $db1 . ".veh_prh a  ";
$where = " WHERE 1=1 ";
//$where =" WHERE 1=1 ";
if (!empty($pur_inv_cls)) {
//Closed,1
//Not Closed,2
//All SPK,3
    $pur_inv_cls = $_REQUEST['pur_inv_cls'];
    switch ($pur_inv_cls) {
        case '1' :
            $where .=" and a.cls2_date>='" . $pur_date1 . "' and a.cls2_date<='" . $pur_date2 . "'";
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls2_date is not null) ";
            $where .= " (a.cls2_date not in('0000-00-00')) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            $where .=" and a.cls2_date>='" . $pur_date1 . "' and a.cls2_date<='" . $pur_date2 . "'";
            break;
            
        case '2' :
             $where .=" and a.opn_date <='" . $pur_date2 . "'";
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls2_date is null or a.cls2_date > '" . $pur_date2 . "') ";
            $where .= " (a.cls2_date='0000-00-00' or a.cls2_date is null) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                //$filterdesc .= " AND ";
            } //$filterdesc .= "Close Date ";
            break;
        case '3' :
            //$where .=" and a.opn_date>='" . $pur_date1 . "' and a.opn_date<='" . $pur_date2 . "'";
            break;
    }
}


$len = strlen($filterdesc);
if ($len >> 0) {
    //$filterdesc .= " AND ";
} //$filterdesc .= "Close Date ";
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
    } $filterdesc .= "Vehicle Type = " .$veh_code;
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

if (!empty($_REQUEST['supp_code'])) {
    $supp_code = $_REQUEST['supp_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.supp_code  = '" . $supp_code . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Supplier = ".$supp_code;
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
    } $filterdesc .= "Location = ".$loc_code;
}

//$statsql .= $where . $order;
//echo $statsql;exit;
$statsql .= $where;

$mounth = rangeMounth($pur_date1, $pur_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "pembelian/" . $rptFile;

$filename = 'vehicle_purchase_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_prh';
$keys = array(
    'key1' => 'purchase',
);

echo outputReport($output, $tbl, $filename, $statsql, $tblimport,$keys);

?>