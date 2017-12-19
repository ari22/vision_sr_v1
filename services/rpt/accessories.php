<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = "<style>"
        . "table{font-family : 'helvetica';font-size : 11px;border-collapse: collapse; border-spacing: 0;}"
        . "th, td {padding: 0.25em 0.75em;}"
        . "thead th {border-bottom: 1px solid #333; text-align: center; }</style>";

$optby = $_REQUEST['optby'];
$title = $_REQUEST['title'];
$where = '';

if (!empty($_REQUEST['inact'])) {
    switch ($inact) {
        case '1' :
            $where = " WHERE prt_inact=' '";
            break;
        case '2' :
            $where = "";
            break;
    }
}
switch ($table) {
    case 'acc_cust':
        $rptFile = 'acc_cust.php';
        $code = 'cust_code';
        $name = 'cust_name';
        break;
    case 'acc_supp':
        $rptFile = 'acc_supp.php';
        $code = 'supp_code';
        $name = 'supp_name';
        break;
    case 'acc_srep':
        $rptFile = 'acc_srep.php';
        $code = 'srep_code';
        $name = 'srep_name';
        break;
    case 'acc_coll':
        $rptFile = 'acc_coll.php';
        $code = 'coll_code';
        $name = 'coll_name';
        break;

    case 'acc_prep':
        $rptFile = 'acc_prep.php';
        $code = 'prep_code';
        $name = 'prep_name';
        break;
    case 'acc_orep':
        $rptFile = 'acc_orep.php';
        $code = 'oprep_code';
        $name = 'oprep_name';
        break;
    case 'acc_mst':
        $rptFile = 'acc_mst.php';
        $code = 'part_code';
        $name = 'part_name';
        break;
    case 'acc_wkcd':
        $rptFile = 'acc_wkcd.php';
        $code = 'wk_code';
        $name = 'wk_desc';
        break;
    case 'maccs':

        if (!empty($_REQUEST['rptby'])) {
            switch ($_REQUEST['rptby']) {
                case 'stock' :
                    $rptFile = 'acc_stk.php';
                    break;
                case 'price' :
                    $rptFile = 'acc_price.php';
                    break;
            }
        }
        $code = 'part_code';
        $name = 'part_name';
        break;
}

if (!empty($_REQUEST['optby'])) {

    switch ($optby) {
        case '1' :
            $order = " ORDER BY $code";
            break;
        case '2' :
            $order = " ORDER BY $name";
            break;
    }
}

$statsql = "select * from $table";
$statsql .= $where;
$statsql .= $order;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "masteracc/" . $rptFile;

$filename = $table .'_'. date('dmy') . '_' . date('his');

echo outputReport($output, $tbl, $filename, $statsql, $table);

