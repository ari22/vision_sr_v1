<?php
session_start();
$comp_name = "BELUM DI SET";

if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "ACCESSORIES ACCOUNT PAYABLE PAYMENT REPORT";

$order = " ";

$date1 =  dateFormat($date1);
$date2 = dateFormat($date2);

$where = " WHERE 1=1 and b.pay_date>='" . $date1 . "' and b.pay_date<='" . $date2 . "'";

if (!empty($_REQUEST['supp_name'])) {
    $where .=" and a.supp_name='" . $supp_name . "'";
}

if (!empty($_REQUEST['pinv_code'])) {
    $where .=" and a.pinv_code='" . $pinv_code . "'";
}

if (!empty($_REQUEST['pay_type'])) {
    $where .=" and a.pay_type='" . $pay_type . "'";
}

if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];

    switch ($group_by) {
        case '1':
            $order .= " ORDER BY supp_code,supp_name";
            $rptFile = 'supplier.php';
            $title = 'Supplier';
            break;
        case '2':
            $order .= " ORDER BY pinv_code";
            $rptFile = 'invoice.php';
            $title = 'Invoice Type';
            break;

        case '3':
            $order .= " ORDER BY pay_type";
            $rptFile = 'type.php';
            $title = 'Payment Type';
            break;
    }
}

$statsql = "select a.*, b.* from " . $db1 . ".acc_aph a inner join " . $db1 . ".acc_apd b  on a.pur_inv_no=b.pur_inv_no ";

//$statsql .= $where . $order;
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}


 include "bayarhutangacc/" . $rptFile;
 $filename = 'bayarhutangacc_'  . date('dmy') . '_' . date('his');

$tblimport = 'acc_aph';

$keys = array(
    'key1' => 'payment'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);


?>