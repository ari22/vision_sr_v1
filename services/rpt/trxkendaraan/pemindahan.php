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
$order = " ORDER BY veh_code,color_code,mov_date";
$rptTitle = "VEHICLE MOVEMENT REPORT";
$supp_type = '';
$title = '';
$filterdesc = '';

$date1 = dateFormat($date1);
$date2 = dateFormat($date2);

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        
        case '1' :
            $rptFile = "veh_slv.php";
            $order = " ORDER BY veh_code,color_code,mov_date";
            $title = 'Vehicle Type, Color Type';
            break;
        
        case '2' :
            $rptFile = "veh_slc.php";
            $order = " ORDER BY color_code,veh_code,mov_date";
            $title = 'Color Type, Vehicle Type';
            break;

        case '3' :
            $rptFile = "veh_slw.php";
            $order = " ORDER BY wrhs_from,veh_code,color_code,mov_date";
            $title = 'Warehouse, Vehicle Type';
            break;

        case '4' :
            $rptFile = "veh_loc.php";
            $order = " ORDER BY loc_from,mov_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}
$statsql = "select a.*,a.wrhs_from as wrhs_name,1 as qty from " . $db1 . ".veh_movh a  ";
$where = " WHERE 1=1 and a.opn_date >='" . $date1 . "' and a.opn_date <='" . $date2 . "'";
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
            } $filterdesc .= "Close Date ";
            
            $where .=" and a.cls_date >='" . $date1 . "' and a.cls_date <='" . $date2 . "'";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";


            break;
        case '3' :
            $len = strlen($where);
            /* 	if ($len>>0)
              {
              $where .= " AND ";
              }
              $where .= " (a.mov_date <= '".$date2."' and a.mov_date >= '".$date1."' ) ";
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


if (!empty($_REQUEST['wrhs_from']) && $_REQUEST['wrhs_from'] != "ALL") {
    $wrhs_from = $_REQUEST['wrhs_from'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.wrhs_from  = '" . $wrhs_from . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Warehouse = ".$wrhs_from;
}

if (!empty($_REQUEST['loc_from'])) {
    $loc_from = $_REQUEST['loc_from'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.loc_from  = '" . $loc_from . "' ";
    if ($len >> 0) {
       $filterdesc .= ", ";
    } $filterdesc .= "Location = ".$loc_from;
}

//$statsql .= $where . $order; 
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "pemindahan/" . $rptFile;
$filename = 'vehicle_moving_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);


?>