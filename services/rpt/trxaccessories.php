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

$date1 = dateFormat($date1);
$date2 = dateFormat($date2);
$cls_date = 'cls_date';

$where = " WHERE 1=1 and a.opn_date>='" . $date1 . "' and a.opn_date<='" . $date2 . "'";


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

switch ($table) {
    case 'acc_prh':
        $fieldName = 'pur_inv_no';

        if (!empty($_REQUEST['text'])) {
            $fieldDate = 'pur_date';
            $rptTitle = 'ACCESSORIES PURCHASE REPORT';
            $cls_date = 'cls2_date';
        } else {
            $fieldDate = 'rcv_date';
            $rptTitle = 'ACCESSORIES RECEIVER REPORT';
        }

        break;

    case 'acc_opnh':
        $fieldName = 'opn_inv_no';
        $fieldDate = 'opn_date';
        $rptTitle = 'STOCK OPNAME ACCESSORIES REPORT';
        break;

    case 'acc_rslh':
        $fieldName = 'rsl_inv_no';
        $fieldDate = 'rsl_date';
        $rptTitle = 'SALES RETURN ACCESSORIES REPORT';
        break;

    case 'acc_rprh':
        $fieldName = 'rpr_inv_no';
        $fieldDate = 'rpr_date';
        $rptTitle = 'PURCHASE RETURN ACCESSORIES REPORT';
        break;

    case 'acc_slh':
        $fieldName = 'sal_inv_no';
        $fieldDate = 'sal_date';

        if (!empty($_REQUEST['text'])) {
            $where .= " and a.sinv_code='VSL'";
            $rptTitle = 'SALE ACCESSORIES REPORT';
        } else {
            $where .= " and a.sinv_code='ASA'";
            $rptTitle = 'USE ACCESSORIES REPORT';
        }

        break;

    case 'acc_movh':
        $fieldName = 'mov_inv_no';
        $fieldDate = 'mov_date';
        $rptTitle = 'ACCESSORIES MOVEMENT REPORT';
        break;

    case 'acc_poh':
        $fieldName = 'po_no';
        $fieldDate = 'po_date';
        $rptTitle = 'PURCHASE ORDER ACCESSORIES REPORT';
        break;

    case 'acc_pooh':
        $fieldName = 'po_no';
        $fieldDate = 'po_date';

        if ($group_by !== '3') {
            $select .= 'a.po_no, a.po_date, a.supp_code, a.supp_name, a.tot_item, a.quote_no, a.quote_date, a.tot_qty, a.inv_bt, a.inv_vat, a.curr_code, b.part_code, b.part_name, SUM(b.qty) as qty2, SUM(b.beg_qty) as beg_qty, SUM(b.rcv_qty) as rcv_qty, SUM(b.end_qty) as end_qty, SUM(b.price_ad) price_ad2';
            $join = " inner join acc_pood b on a.$fieldName=b.$fieldName";
            $group .= ' GROUP BY a.po_no';
        }
        $rptTitle = 'OUTSTANDING PURCHASE ORDER ACCESSORIES REPORT';
        break;
}

if ($cls == 1) {
    $where .= " and a.$cls_date NOT IN('0000-00-00') and a.$fieldDate >='" . $date1 . "' and a.$fieldDate <='" . $date2 . "'";
}
if ($cls == 2) {
    $where .= " and a.$cls_date IN('0000-00-00') and a.". $fieldDate . " IN ('0000-00-00')";
}


switch ($group_by) {
    case '1':
        if ($table == 'acc_poh' || $table == 'acc_pooh') {
            $order = " ORDER BY curr_code, $fieldName, $fieldDate";
        } elseif ($table == 'acc_movh') {
            $order = " ORDER BY $fieldName, $fieldDate";
        } else {
            $order = " ORDER BY wrhs_code, $fieldName, $fieldDate";
        }


        switch ($table) {
            case 'acc_prh':

                if (!empty($_REQUEST['text'])) {
                    $rptFile = "pembelian/no_date.php";
                } else {
                    $rptFile = "penerimaan/no_date.php";
                }

                break;

            case 'acc_opnh':
                $rptFile = 'opname/no_date.php';
                break;

            case 'acc_rslh':
                $rptFile = 'returjual/no_date.php';
                break;

            case 'acc_rprh':
                $rptFile = 'returbeli/no_date.php';
                break;

            case 'acc_slh':

                if (!empty($_REQUEST['text'])) {
                    $rptFile = 'penjualan/no_date.php';
                } else {
                    $rptFile = 'pemakaian/no_date.php';
                }

                break;

            case 'acc_movh':
                $rptFile = 'pemindahan/no_date.php';
                break;

            case 'acc_poh':
                $rptFile = 'po/no_date.php';
                break;

            case 'acc_pooh':

                $rptFile = 'oustanding/no_date.php';
                break;
        }

        break;

    case '2':
        if ($table == 'acc_poh' || $table == 'acc_pooh') {
            $order = " ORDER BY  curr_code, $fieldDate, $fieldName";
        } elseif ($table == 'acc_movh') {
            $order = " ORDER BY $fieldDate,$fieldName";
        } else {
            $order = " ORDER BY wrhs_code, $fieldDate,$fieldName";
        }
        switch ($table) {
            case 'acc_prh':

                if (!empty($_REQUEST['text'])) {
                    $rptFile = "pembelian/date_no.php";
                } else {
                    $rptFile = "penerimaan/date_no.php";
                }
                break;

            case 'acc_opnh':
                $rptFile = 'opname/date_no.php';
                break;

            case 'acc_rslh':
                $rptFile = 'returjual/date_no.php';
                break;

            case 'acc_rprh':
                $rptFile = 'returbeli/date_no.php';
                break;

            case 'acc_slh':
                if (!empty($_REQUEST['text'])) {
                    $rptFile = 'penjualan/date_no.php';
                } else {
                    $rptFile = 'pemakaian/date_no.php';
                }
                break;

            case 'acc_movh':
                $rptFile = 'pemindahan/date_no.php';
                break;

            case 'acc_poh':
                $rptFile = 'po/date_no.php';
                break;

            case 'acc_pooh':
                $rptFile = 'oustanding/date_no.php';
                break;
        }

        break;

    case '3':
        if ($table == 'acc_poh' || $table == 'acc_pooh') {
            $order = " ORDER BY curr_code, b.part_code, b.part_name";
        } elseif ($table == 'acc_movh') {
            $order = " ORDER BY b.part_code, b.part_name";
        } else {
            $order = " ORDER BY wrhs_code,b.part_code, b.part_name";
        }


        switch ($table) {
            case 'acc_prh':
                $join = " left join acc_prd b on a.$fieldName=b.$fieldName";

                if (!empty($_REQUEST['text'])) {
                    $rptFile = "pembelian/part.php";
                } else {
                    $rptFile = "penerimaan/part.php";
                }
                break;

            case 'acc_opnh':
                $join = " inner join acc_opnd b on a.$fieldName=b.$fieldName";
                $rptFile = 'opname/part.php';
                break;

            case 'acc_rslh':
                $join = " inner join acc_rsld b on a.$fieldName=b.$fieldName";
                $rptFile = 'returjual/part.php';
                break;

            case 'acc_rprh':
                $join = " inner join acc_rprd b on a.$fieldName=b.$fieldName";
                $rptFile = 'returbeli/part.php';
                break;

            case 'acc_slh':
                $join = " inner join acc_sld b on a.$fieldName=b.$fieldName";

                if (!empty($_REQUEST['text'])) {
                    $rptFile = 'penjualan/part.php';
                } else {
                    $rptFile = 'pemakaian/part.php';
                }
                break;

            case 'acc_movh':
                $join = " inner join acc_movd b on a.$fieldName=b.$fieldName";
                $rptFile = 'pemindahan/part.php';
                break;

            case 'acc_poh':
                $join = " inner join acc_pod b on a.$fieldName=b.$fieldName";
                $rptFile = 'po/part.php';
                break;

            case 'acc_pooh':
                $join = " inner join acc_pood b on a.$fieldName=b.$fieldName";
                $rptFile = 'oustanding/part.php';
                break;
        }

        break;

    case '4':
        if ($table == 'acc_poh' || $table == 'acc_pooh') {
            $order = " ORDER BY   curr_code, supp_code,supp_name";
        } else {
            $order = " ORDER BY wrhs_code, supp_code,supp_name";
        }

        switch ($table) {
            case 'acc_prh':

                if (!empty($_REQUEST['text'])) {
                    $rptFile = "pembelian/supplier.php";
                } else {
                    $rptFile = "penerimaan/supplier.php";
                }
                break;

            case 'acc_poh':
                $rptFile = "po/supplier.php";
                break;

            case 'acc_pooh':
                $rptFile = 'oustanding/supplier.php';
                break;
            case 'acc_opnh':
                $rptFile = '';
                break;

            case 'acc_rslh':
                $rptFile = '';
                break;

            case 'acc_rprh':
                $rptFile = '';
                break;

            case 'acc_slh':
                if (!empty($_REQUEST['text'])) {
                    $rptFile = 'penjualan/supplier.php';
                }
                break;

            case 'acc_movh':
                $rptFile = '';
                break;
        }
        break;

    case '5':


        switch ($table) {
            case 'acc_prh':
                $order = " ORDER BY  wrhs_code, supp_invno,supp_invdt";
                $rptFile = "pembelian/supp_invno.php";
                break;

            case 'acc_slh':
                if (!empty($_REQUEST['text'])) {
                    $rptFile = 'penjualan/customer.php';
                }
                break;
        }
        break;

    case '6':
        switch ($table) {
            case 'acc_slh':
                $order = " ORDER BY wrhs_code, srep_code,srep_name";
                $rptFile = "penjualan/sales.php";
                break;

            default:
                $order = " ORDER BY wrhs_code, supp_invdt,supp_invno";
                $rptFile = "pembelian/supp_invdt.php";
                break;
        }

        break;
}

if ($table == 'acc_pooh' && $group_by !== '3') {
    $statsql = "select $select from " . $db1 . ".$table a";
} else {
    $statsql = "select $select * from " . $db1 . ".$table a";
}


$statsql .= $join;
$statsql .= $where;

$mounth = rangeMounth($date1, $date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $group;
$statsql .= $order.' ASC';
//echo $statsql;exit;
/*$statsql .= $join;
$statsql .= $where;
$statsql .= $group;
$statsql .= $order;*/
//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}

include "trxacc/" . $rptFile;
$filename = 'trxacc_' . date('d') . '_' . date('m') . '_' . date('Y');

echo outputReport($output, $tbl, $filename);
