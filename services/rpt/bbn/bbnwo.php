<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$select = '';
//$where = ' WHERE 1=1';

$order = '';
$join = '';
$group = '';

$fieldDate = '';
$fieldName = '';
$rptTitle = "BBN WORK ORDER REPORT";

$date1 = dateFormat($wo_date1);
$date2 = dateFormat($wo_date2);
$cls_date = 'cls_date';

$a='';

if($status == 1){
	$statsql =  "select a.wo_no,a.wo_date,a.supp_name,a.supp_code,a.so_no,a.so_date,a.inv_bt,a.inv_vat,a.inv_stamp,a.inv_total,a.prep_code,a.prep_name,
				b.* from " . $db1 . ".veh_bwoh a inner join " . $db1 . ".veh_bwod b on a.wo_no=b.wo_no ";
	//$statsql = "select * from " . $db1 . ".veh_bwod ";

}else{
	$statsql = "select  a.wo_no,a.wo_date,a.supp_name,a.supp_code,a.so_no,a.so_date,a.inv_bt,a.inv_vat,a.inv_stamp,a.inv_total,a.prep_code,a.prep_name from " . $db1 . ".veh_bwoh a ";
	//$a='a.';
}

if($group_by == '3' || $group_by == '5'){
	$statsql =  "select a.wo_no,a.wo_date,a.supp_name,a.supp_code,a.so_no,a.so_date,a.inv_bt,a.inv_vat,a.inv_stamp,a.inv_total,a.prep_code,a.prep_name,
				b.* from " . $db1 . ".veh_bwoh a inner join " . $db1 . ".veh_bwod b on a.wo_no=b.wo_no ";

}
$where = "WHERE 1=1 ";

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
	
	switch ($group_by) {
		case '1' :
            $rptFile = "no_date.php";
            $order = " ORDER BY ".$a."wo_no,".$a."wo_date";
            $title = 'Invoice No. & Invoice Date';
			break;
		
		case '2' :
            $rptFile = "date_no.php";
            $order = " ORDER BY ".$a."wo_date, ".$a."wo_no";
            $title = 'Invoice Date & Invoice No.';
			break;
		
		case '3' :
            $rptFile = "veh.php";
            $order = " ORDER BY b.veh_code,".$a."wo_no,".$a."wo_date";
            $title = 'Vehicle Code';
			break;
		
		case '4' :
            $rptFile = "agent.php";
            $order = " ORDER BY ".$a."supp_code,".$a."wo_no,".$a."wo_date";
            $title = 'Agent';
			break;
			
		case '5' :
            $rptFile = "prch.php";
            $order = " ORDER BY ".$a."prep_code,".$a."wo_no,".$a."wo_date";
            $title = 'Purchaser';
			break;
			
		case '6' :
            $rptFile = "wrhs.php";
            $order = " ORDER BY ".$a."wrhs_code,".$a."wo_no,".$a."wo_date";
            $title = 'Warehouse';
			break;
		
	}
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

if (!empty($_REQUEST['veh_code'])) {
    $veh_code = $_REQUEST['veh_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.veh_code  = '" . $veh_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Vehicle Code =" . $veh_code;
}

if (!empty($_REQUEST['agent_code'])) {
    $agent_code = $_REQUEST['agent_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.supp_code  = '" . $agent_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Agent =" . $agent_code;
}

if (!empty($_REQUEST['prep_code'])) {
    $prep_code = $_REQUEST['prep_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.prep_code  = '" . $prep_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Purchaser =" . $prep_code;
}

if (!empty($cls)) {
    $cls = $_REQUEST['cls'];
    switch ($cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date !='0000-00-00' or a.cls_date <= '" . $date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";

            $where .= "and a.cls_date>='" . $date1 . "' and a.cls_date<='" . $date2 . "'";
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
            break;
    }
}

$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order . ' ASC';

//echo $rptFile;exit;

$dtl = mysql_query($statsql) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include"bbnwo/" . $rptFile;

$filename = 'bbnwo_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_bwoh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);