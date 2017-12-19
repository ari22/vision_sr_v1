<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "VEHICLE PURCHASE RETURN REPORT";

$order = " ORDER BY veh_code,color_code,rpr_date";
$rptFile = '';
$title = '';
$filterdesc = '';

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1' :
            $rptFile = "type.php";
            $title = 'Vehicle Type, Color';
            break;

        case '2':
            $rptFile = "color.php";
            $order = " ORDER BY color_code,veh_code,rpr_date";
            $title = 'Color, Vehicle Type';
            break;

        case '3' :
            $rptFile = "supplier.php";
            $order = " ORDER BY supp_code,veh_code,color_code,rpr_date";
            $title = 'Supplier, Vehicle Type';
            break;

        case '4' :
            $rptFile = "warehouse.php";
            $order = " ORDER BY wrhs_code,veh_code,color_code,rpr_date";
            $title = 'Warehouse, Vehicle Type';
            break;
        
        case '5' :
            $rptFile = "location.php";
            $order = " ORDER BY loc_code,rpr_date";
            $title = 'Location, Vehicle Type';
            break;
    }
}

$rpr_date1 = dateFormat($rpr_date1);        
$rpr_date2 = dateFormat($rpr_date2);

$statsql = "select * from " . $db1 . ".veh_rprh a";
$where = " WHERE 1=1 and a.opn_date>='" . $rpr_date1 . "' and a.opn_date<='" . $rpr_date2 . "'";

if (!empty($rsal_cls))
{
//Closed,1
//Not Closed,2
//All SPK,3
	$rsal_cls = $_REQUEST['rsal_cls'];
	switch ($rsal_cls)
	{
		case '1' :
			$len = strlen($where);
			if ($len>>0)
			{
				$where .= " AND ";
			}
			//$where .= " (a.cls_date is not null) ";
                        $where .= " (a.cls_date not in('0000-00-00')) ";
			$len = strlen($filterdesc);
			if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Close Date ";
		break;
		case '2' :
                    $len = strlen($where);
			if ($len>>0)
			{
				$where .= " AND ";
			}

			$where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '".$rpr_date2."') ";
			$len = strlen($filterdesc);
			if ($len>>0) {
                            //$filterdesc .= " AND ";
                            
                        } //$filterdesc .= "Close Date ";


		break;
		case '3' :
		$len = strlen($where);
		/*	if ($len>>0)
			{
				$where .= " AND ";
			}
			$where .= " (a.sal_date <= '".$sal_date2."' and a.sal_date >= '".$sal_date1."' ) ";
			$len = strlen($filterdesc);*/
			if ($len>>0) {
                            //$filterdesc .= " AND ";
                            } //$filterdesc .= "Close Date ";
                        
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
$statsql .= $where;

$mounth = rangeMounth($rpr_date1, $rpr_date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

$dtl = mysql_query($statsql) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include 'returPembelian/' . $rptFile;
$filename = 'vehicle_purchase_return' . date('dmy') . '_' . date('his');

$tblimport = 'veh_rprh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);



?>