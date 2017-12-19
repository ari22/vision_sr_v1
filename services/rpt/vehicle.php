<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}
$tbl = "<style>"
        . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;}"
        . "th, td {padding: 0.25em 0.75em;}"
        . "th{padding-bottom:10px;padding-top:10px;}"
        . "thead th {border-bottom: 1px solid #333;text-align:left;  }</style>";


$optby = $_REQUEST['optby'];
$title = $_REQUEST['title'];

switch ($table) {
    case 'veh_cust':
        $rptFile = 'veh_cust.php';
        $code = 'cust_code';
        $name = 'cust_name';
        break;
    case 'veh_supp':
        $rptFile = 'veh_supp.php';
        $code = 'supp_code';
        $name = 'supp_name';
        break;
    case 'veh_srep':
        $rptFile = 'veh_srep.php';
        $code = 'srep_code';
        $name = 'srep_name';
        break;
    case 'veh_coll':
        $rptFile = 'veh_coll.php';
        $code = 'coll_code';
        $name = 'coll_name';
        break;
    case 'veh_vtyp':
        $rptFile = 'veh_vtyp.php';
        $code = 'veh_code';
        $name = 'veh_name';
        break;
    case 'color':
        $rptFile = 'color.php';
        $code = 'color_code';
        $name = 'color_name';
        break;
    case 'veh_prc':
        $rptFile = 'veh_prc.php';
        $code = 'veh_code';
        $name = 'veh_name';
        break;
    case 'bank':
        $rptFile = 'bank.php';
        $code = 'bank_code';
        $name = 'bank_name';
        break;
    case 'insurance':
        $rptFile = 'insurance.php';
        $code = 'insr_code';
        $name = 'insr_name';
        break;
    case 'lease':
        $rptFile = 'lease.php';
        $code = 'lease_code';
        $name = 'lease_name';
        break;
    case 'agent':
        $rptFile = 'agent.php';
        $code = 'agent_code';
        $name = 'agent_name';
        break;
    case 'veh_stdopt':
        $rptFile = 'veh_stdopt.php';
        $code = 'stdoptcode';
        $name = 'stdoptname';
        break;
    case 'veh_pcus':
        $rptFile = 'veh_pcus.php';
        $code = 'cust_code';
        $name = 'cust_name';
        break;
    case 'veh_sspv':
        $rptFile = 'veh_sspv.php';
        $code = 'sspv_code';
        $name = 'sspv_name';
        break;
}


if (!empty($_REQUEST['optby'])) {

    switch ($optby) {
        case '1' :
            $order = " ORDER BY a.$code";
            break;
        case '2' :
            $order = " ORDER BY a.$name";
            break;
    }
}

$statsql = "select a.* from $table a";
$statsql .= $order;
//echo $statsql; exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "masterkendaraan/" . $rptFile;

$filename = $table .'_'. date('dmy') . '_' . date('his');

echo outputReport($output, $tbl, $filename, $statsql, $table);


