<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$date1 = dateFormat($date1);
$date2 = dateFormat($date2);

//$where = ' WHERE 1=1';
$where =" WHERE 1=1 and a.opn_date>='".$date1."' and a.opn_date<='".$date2."'";
$order = '';
$join = '';
 $group = '';

$fieldDate = '';
$fieldName = '';

$keys = array();

switch ($table) {
    case 'acc_woh':
        $fieldDate = 'wo_date';
        $fieldName = 'wo_no';
        $rptTitle = "WORK ORDER OPTIONAL REPORT";
        $filename = 'workorderoptional';
        
        
        break;

    case 'acc_wprh':
        $fieldName = 'pur_inv_no';

        if (!empty($_REQUEST['text'])) {
            $rptTitle = "OPTIONAL PURCHASE REPORT";
            $fieldDate = 'cls2_date';
            $filename = 'optionalpurchase';
        } else {
            $fieldDate = 'cls_date';
            $rptTitle = "OPTIONAL RECEIVING REPORT";
            $filename = 'optionalreceiving';
        }
        break;

    case 'acc_wslh':
        $fieldDate = 'sal_date';
        $fieldName = 'sal_inv_no';
        $rptTitle = "OPTIONAL AFTER SALES REPORT";
        $filename = 'optionalaftersales';
        break;
}


if ($cls == 1) {
    $where .= " and (a.$fieldDate  NOT IN('0000-00-00'))";
}
if ($cls == 2) {
    $where .= " and (a.$fieldDate  IN('0000-00-00'))";
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



if (!empty($_REQUEST['wk_code'])) {
    //$where .= " and b.wk_code='$wk_code'";
	
	$wk_code = $_REQUEST['wk_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " b.wk_code  = '" . $wk_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Part  =" . $wk_code;
}

if (!empty($_REQUEST['cust_code'])) {
    //$where .= " and a.cust_code='$cust_code'";
	
	$cust_code = $_REQUEST['cust_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.cust_code  = '" . $cust_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Customer =" . $cust_code;
}

if (!empty($_REQUEST['srep_code'])) {
    //$where .= " and a.srep_code='$srep_code'";
	
	$srep_code = $_REQUEST['srep_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.srep_code  = '" . $srep_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Sales Person =" . $srep_code;
}

if (!empty($_REQUEST['supp_code'])) {
    //$where .= " and a.supp_code='$supp_code'";
	
	$supp_code = $_REQUEST['supp_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.supp_code  = '" . $supp_code . "' ";
    if ($len >> 0) {
        $filterdesc .= ", ";
    } $filterdesc .= "Supplier =" . $supp_code;
}

if (!empty($_REQUEST['prep_code'])) {
    //$where .= " and a.prep_code='$prep_code'";
	
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

if (!empty($_REQUEST['group_by'])) {

    $group_by = $_REQUEST['group_by'];


    switch ($group_by) {
        case '1' :
            $title = 'By Invoice No. By Invoice Date';
            $order = " ORDER BY $fieldName, $fieldDate";

            switch ($table) {
                case 'acc_woh':
                    $rptFile = "wo/no_date.php";
                    break;

                case 'acc_wprh':

                    if (!empty($_REQUEST['text'])) {
                        $rptFile = "pembelian/no_date.php";
                    } else {
                        $rptFile = "penerimaan/no_date.php";
                    }

                    break;

                case 'acc_wslh':
                    $rptFile = "penjualan/no_date.php";
                    break;
            }

            break;

        case '2' :
            $order = " ORDER BY $fieldDate,$fieldName";
            $title = 'By Invoice Date By Invoice No. ';
            switch ($table) {
                case 'acc_woh':
                    $rptFile = "wo/date_no.php";
                    break;

                case 'acc_wprh':
                    if (!empty($_REQUEST['text'])) {
                        $rptFile = "pembelian/date_no.php";
                    } else {
                        $rptFile = "penerimaan/date_no.php";
                    }

                    break;

                case 'acc_wslh':
                    $rptFile = "penjualan/date_no.php";
                    break;
            }
            break;

        case '3':
            $order = " ORDER BY b.wk_code, b.wk_desc";
            //  $title = 'By Invoice Date By Invoice No. ';
            switch ($table) {
                case 'acc_woh':
                    $join = ' inner join acc_wod b on a.wo_no=b.wo_no';
                    $rptFile = "wo/work.php";

                    break;

                case 'acc_wprh':
                    $join = ' inner join acc_wprd b on a.pur_inv_no=b.pur_inv_no';

                    if (!empty($_REQUEST['text'])) {
                        $rptFile = "pembelian/work.php";
                    } else {
                        $rptFile = "penerimaan/work.php";
                    }

                    break;

                case 'acc_wslh':
                    //$group .= ' GROUP BY a.wrhs_code';
                    $join = ' inner join acc_wsld b on a.sal_inv_no=b.sal_inv_no';
                    $rptFile = "penjualan/work.php";

                    break;
            }

            break;

        case '4' :
            switch ($table) {
                case 'acc_woh':
                    $rptFile = "wo/supplier.php";
                    $order = " ORDER BY supp_code,supp_name";
                    break;

                case 'acc_wprh':
                    if (!empty($_REQUEST['text'])) {
                        $rptFile = "pembelian/supplier.php";
                        $order = " ORDER BY supp_code,supp_name";
                    } else {
                        $rptFile = "penerimaan/supplier.php";
                        $order = " ORDER BY supp_code,supp_name";
                    }

                    break;

                case 'acc_wslh':
                    $rptFile = "penjualan/customer.php";
                    $order = " ORDER BY cust_code,cust_name";
                    break;
            }
            break;
        case '5' :
            switch ($table) {
                case 'acc_woh':
                    $rptFile = "wo/purchaser.php";
                    $order = " ORDER BY prep_code,prep_name";
                    break;

                case 'acc_wprh':
                    $join = ' inner join acc_wprd b on a.pur_inv_no=b.pur_inv_no';
                    if (!empty($_REQUEST['text'])) {
                        $rptFile = "pembelian/purchaser.php";
                        $order = " ORDER BY b.prep_code,b.prep_name";
                    } else {
                        $rptFile = "penerimaan/purchaser.php";
                        $order = " ORDER BY b.prep_code,b.prep_name";
                    }

                    break;

                case 'acc_wslh':
                    $rptFile = "penjualan/sales.php";
                    $order = " ORDER BY srep_code,srep_name";
                    break;
            }
            break;
    }
}


$statsql = "select * from " . $db1 . ".$table a";
$statsql .= $join;
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';
//echo $statsql;exit;

$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}
include "optional/" . $rptFile;
$filename = $filename.'_' . date('d') . '_' . date('m') . '_' . date('Y');

$tblimport = $table;

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

