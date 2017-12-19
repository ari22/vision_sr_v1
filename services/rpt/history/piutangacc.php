<?php

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$order = '';
$tbl = tblstyle();

$statsql = "select b.* from " . $db1 . ".acc_arh a inner join " . $db1 . ".acc_ard b on a.sal_inv_no = b.sal_inv_no  ";
//$where = " WHERE 1=1 and a.sal_date >='" . $date1 . "' and a.sal_date<='" . $date2 . "'";
$where = " WHERE 1=1 ";
if (!empty($_REQUEST['sal_inv_no'])) {
    $sal_inv_no = $_REQUEST['sal_inv_no'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " and ";
    }
    $where .= " a.sal_inv_no  = '" . $sal_inv_no . "' ";
}


$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth, $db1, $statsql);

$statsql .= $order;


$statsql2 = "select a.* from " . $db1 . ".acc_arh a";

$statsql2 .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql2 .= queryUnion($mounth, $db1, $statsql2);

$statsql2 .= $order;




$dtl = mysql_query($statsql) or die(mysql_error());
$dtl2 = mysql_query($statsql2) or die(mysql_error());

if (mysql_num_rows($dtl) == 0) {
    echo "Data not available";
    return;
}



include "view/piutangacc.php";
$filename = 'piutangacc_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
