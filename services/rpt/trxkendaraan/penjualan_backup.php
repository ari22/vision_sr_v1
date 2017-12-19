<?php
//========CHANGE LOG=========
//footer dibuang
//judul dan subjudul jadi inggris:
//-LAPORAN PENJUALAN KENDARAAN => VEHICLE SALES REPORT
//- Per Tipe Kendaraan Per Tipe Warna => By Vehicle Type By Color Type
//- Per Tipe Warna Per Tipe Kendaraan => By Color Type By Vehicle Type
//- Per Customer Per Tipe Kendaraan => By Customer By Vehicle Type
//- Per Salesname Per Tipe Kendaraan => By Sales Name By Vehicle Type
//- Per Warehouse Per Tipe Kendaraan => By Warehouse By Vehicle Type
//- Per Leasing Per Tipe Kendaraan => By Leasing By Vehicle Type
//

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptFile = "veh_slv.php";
$order = " ORDER BY a.veh_code,a.color_code,a.sal_date";
$rptTitle = "VEHICLE SALES REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';

$sal_date1 = dateFormat($sal_date1);
$sal_date2 = dateFormat($sal_date2);

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            $rptFile = "veh_slv.php";
            $order = " ORDER BY a.veh_code,a.color_code,a.sal_date";
            $title = 'Vehicle Type, Color Type';
            break;
        case '2' :
            $rptFile = "veh_slc.php";
            $order = " ORDER BY a.color_code,a.veh_code,a.sal_date";
            $title = 'Color Type, Vehicle Type';
            break;
        case '3' :
            $rptFile = "veh_sld.php";
            $order = " ORDER BY a.cust_code,a.veh_code,a.color_code,a.sal_date";
            $title = 'Customer, Vehicle Type';
            break;
        case '4' :
            $rptFile = "veh_sls.php";
            $order = " ORDER BY a.srep_code,a.veh_code,a.color_code,a.sal_date";
            $title = 'Sales Name, Vehicle Type';
            break;
        case '5' :
            $rptFile = "veh_slw.php";
            $order = " ORDER BY a.wrhs_code,a.veh_code,a.color_code,a.sal_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        case '6' :
            $rptFile = "veh_sll.php";
            $order = " ORDER BY a.lease_code,a.veh_code,a.color_code,a.sal_date";
            $title = 'Leasing, Vehicle Type';
            break;
        
        case '7' :
            $rptFile = "veh_loc.php";
            $order = " ORDER BY a.loc_code";
            $title = 'Location, Vehicle Type';
            break;
         case '8' :
            $rptFile = "city.php";
            $order = " ORDER BY a.cust_city";
            $title = 'City Customer, Vehicle Type';
            break;
    }
}
$statsql = "select a.*,a.cust_city,a.wrhs_code as wrhs_name,1 as qty from veh_slh a  ";
//$where =" WHERE 1=1 and a.sal_date<>'0000-00-00' ";
$where = " WHERE 1=1 and a.opn_date >='" . $sal_date1 . "' and a.opn_date <='" . $sal_date2 . "'";
if (!empty($sal_cls)) {

    $sal_cls = $_REQUEST['sal_cls'];
    switch ($sal_cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date is not null) ";
            $where .= " (a.cls_date not in('0000-00-00')) ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "SOLD ";
            
            $where .=" and a.cls_date >='" . $sal_date1 . "' and a.cls_date <='" . $sal_date2 . "'";
            break;
            
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            //$where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $sal_date2 . "') ";
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null) and pick_date not in(0000-00-00) and pur_inv_no not in('') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Picked ";

            break;
        case '3' :
            $len = strlen($where);
            /* 	if ($len>>0)
              {
              $where .= " AND ";
              }
              $where .= " (a.sal_date <= '".$sal_date2."' and a.sal_date >= '".$sal_date1."' ) ";
              $len = strlen($filterdesc); */
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
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
    } $filterdesc .= "Type = ".$veh_type;
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
    } $filterdesc .= "Customer = ".$supp_type;
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
    $srep_code = $_REQUEST['sspv_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.sspv_code  = '" . $sspv_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Supervisor = ".$srep_code;
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

if (!empty($_REQUEST['cust_city'])) {
    $cust_city = $_REQUEST['cust_city'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_city  = '" . $cust_city . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "City Customer = ".$cust_city;
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
    } $filterdesc .= "Leasing = ".$lease_code;
}

$statsql .= $where . $order; //echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "penjualan/" . $rptFile;

$filename = 'sales_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_slh';

$keys = array(
    'key1' => 'sales',
    'key2' => $l_sal_price
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);

?>