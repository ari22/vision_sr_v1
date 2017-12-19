<?php

//=============CHANGE LOG===========
//ganti title :
/*
  Sort Number DP =>Sort By DP No.
  Sort Date => Sort By Date
 */
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "BOOKING FEE SUPPLIER REPORT";

$rptFile = "veh_dpcc1.php";
$order = " ORDER BY po_no";

$cust_type = '';
$title = '';
$filterdesc = '';

$rptFile = "veh_dpcc1.php";
if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            //$rptFile = "veh_dpcc1.php";
            $title = '(Sort By PO No.)';
            $order = " ORDER BY po_no, po_date";
            break;
        case '2' :
            // $rptFile = "veh_dpcc2.php";
            $title = '(Sort By Supplier)';
            $order = " ORDER BY supp_code, supp_name";
            break;
    }
}

$where = "  WHERE 1=1 ";

$date1 = '1970-01-01';
$date2 = dateFormat($opn_date);

if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}
if (!empty($_REQUEST['opn_date'])) {
    $opn_date = dateFormat($_REQUEST['opn_date']);
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.opn_date  <= '" . $opn_date . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Date UJ ";
}

if (!empty($_REQUEST['po_no'])) {
    $po_no = $_REQUEST['po_no'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.po_no  = '" . $po_no . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "SPK No. ";
}

if (!empty($_REQUEST['supp_code'])) {
    $supp_code = $_REQUEST['supp_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.supp_code  = '" . $supp_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Customer";
}

if (!empty($_REQUEST['rpt_by'])) {
    $rpt_by = $_REQUEST['rpt_by'];

    switch ($rpt_by) {
        case '1':
            $statsql = "select a.* from " . $db1 . ".veh_dpsh a ";
            break;

        case '2':
            //$where .= " and b.used_val = 0 and a.dp_end != 0 ";
            $statsql = "select a.* from " . $db1 . ".veh_dpsh a ";
            //$statsql = "select a.*,  pd_paid=0, pd_disc=0,sum(pd_end) as pd_begin, DATEDIFF(curdate(),a.due_date) as aging from veh_arh a ";
            $rptFile = "veh_dpcc2.php";
            break;
    }
}
//$statsql .= $where . $order;
//$statsql .= $where . " Group by a.dp_inv_no " . $order;

$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';
//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "uangjaminansupplier/" . $rptFile;

$filename = 'downpayment_supplier' . date('dmy') . '_' . date('his');

$tblimport = 'veh_dpsh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

?>