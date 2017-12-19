<?php

session_start();
$comp_name = "";

if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();


if ($so_reg == '1') {
    $rptFile = "veh_reg1.php";
} else {
    $rptFile = "veh_reg2.php";
}


$status = '';
$cust_type = '';
$title = '';
$filterdesc = '';

$statsql = "SELECT * FROM veh_spkreg";
$where = " WHERE 1=1 ";

if (isset($so_reg)) {
    if ($so_reg == '0') {
        $where .= "";
        $title = 'SPK';
    }
    if ($so_reg == '1') {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " LENGTH( TRIM( srep_code ) ) =0 ";
        $title = 'REGISTERED SPK';
		$order = " ORDER BY so_regdate";
    }
    if ($so_reg == '2') {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " LENGTH( TRIM( srep_code ) ) >0 ";
        $title = 'REGISTERED & DISTRIBUTED SPK';
		//$order = " ORDER BY so_regdate";
    }
}
if (isset($so_status)) {
    if ($so_status == '0') {
        $where .= "";
		$order = " ORDER BY so_no";
    }

    if ($so_status == '1') {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " YEAR(use_date) = '0000'";
        $status = '(UNUSED)';
		$order = " ORDER BY so_no";
    }
    if ($so_status == '2') {
        $len = strlen($where);
        if ($len >> 0) {
            $where .= " AND ";
        }
        $where .= " YEAR(use_date) != '0000' ";
        $status = '(USED)';
		$order = " ORDER BY so_no";
    }
}

$statsql .= $where;

$statsql .= $order . ' ASC';
//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include"spkmanagement/" . $rptFile;

$filename = 'spkreg_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_spkreg';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);
?>