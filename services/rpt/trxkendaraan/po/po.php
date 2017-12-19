<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
//////////////////////////////////
// Report SPK  //
//////////////////////////////////
// Pilihan yang disediakan dibagi menjadi : 
// 1. cetak Spk ALL, group per warehouse : ALL

$rptFile = "veh_pov.php";
$order = " ORDER BY veh_code,color_code,po_date";

$rptTitle = "VEHICLE PURCHASE ORDER REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "veh_pov.php";
            $order = " ORDER BY veh_code,color_code,po_date";
            $title = 'Vehicle Type, Color';
            break;
        case '2' :
            $rptFile = "veh_poc.php";
            $order = " ORDER BY color_code,veh_code,po_date";
            $title = 'Color, Vehicle Type';
            break;
        case '3' :
            $rptFile = "veh_pos.php";
            $order = " ORDER BY supp_code,veh_code,color_code,po_date";
            $title = 'Supplier, Vehicle Type';
            break;
        case '4' :
            $rptFile = "veh_pow.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,po_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        
         case '5' :
            $rptFile = "veh_loc.php";
            $order = " ORDER BY loc_code,po_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}


$po_date1 = dateFormat($po_date1);
$po_date2 = dateFormat($po_date2);

$statsql = "select a.*,a.wrhs_code as wrhs_name from " . $db1 . ".veh_po a  ";
$where = " WHERE 1=1 ";
/*
if (!empty($po_cls)) {
    $po_cls = $_REQUEST['po_cls'];

    if ($po_cls == '1') {
        $where = " WHERE 1=1 and a.po_date>='" . $po_date1 . "' and a.po_date<='" . $po_date2 . "'";
    } else {
        $where = " WHERE 1=1";
    }
}
*/
if (!empty($po_cls)) {

    $po_cls = $_REQUEST['po_cls'];
    switch ($po_cls) {
        case '1' :
            $where .= "and a.po_date>='" . $po_date1 . "' and a.po_date<='" . $po_date2 . "'";
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date is not null) ";
            $where .= " (a.cls_date not in('0000-00-00')) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            $where .= " and a.cls_date>='" . $po_date1 . "' and a.cls_date<='" . $po_date2 . "'";
            break;
        case '2' :
            $where .= " and a.po_date<='" . $po_date2 . "'";
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date is null or a.cls_date > '".$po_date2."') ";
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $po_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                //$filterdesc .= " AND ";
            } //$filterdesc .= "Tanggal Close ";
            break;
        case '3' :
			//$where .= " and(a.sal_date >='" . $sal_date1 . "' and a.sal_date <='" . $sal_date2 . "') or (a.pick_date >='" . $sal_date1 . "' and a.pick_date <='" . $sal_date2 . "') ";
         
            $where .= "and (a.po_date>='" . $po_date1 . "' and a.po_date<='" . $po_date2 . "') or (a.cls_date='0000-00-00' or a.cls_date is null )  ";
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

if (!empty($_REQUEST['supp_type'])) {
    $supp_type = $_REQUEST['supp_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.supp_type  = '" . $supp_type . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Customer Type = ".$supp_type;
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

if (!empty($_REQUEST['wrhs_code']) & $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.wrhs_code  = '" . $wrhs_code . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Warehouse ";
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



$statsql .= $where;

$mounth = rangeMounth($po_date1, $po_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//$statsql .= $where . $order;
//echo $statsql;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "po/" . $rptFile;

$filename = 'purchase_order_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_po';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>