<?php

//=========CHANGE LOG=========
//ganti judul

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "ACCOUNT PAYABLE PAYMENT REPORT";

$rptFile = "veh_apc3.php";
$order = " ";

$supp_type = '';
$title = '';
$filterdesc = '';

$ap_datefrom = '1970-01-01';
$ap_date = dateFormat($_REQUEST['ap_date']);


$date = explode('-', $ap_date);
$periode = $date[0] . $date[1];

$year = $date[0];
$mounth = $date[1];

$lenmth = strlen($mounth);

$mth = $mounth;

if ($lenmth == 1) {
    $int = 0;
    $mth = $int . $mounth;
}


$tahun = $_SESSION['tahun'];
$bulan = $_SESSION['bulan'];

$lenmth2 = strlen($bulan);
if ($lenmth2 == 1) {
    $int2 = 0;
    $bulan = $int2 . $bulan;
}

$period = strtotime($tahun . $bulan);
$periodselect = strtotime($year . $mth);

if ($periodselect < $period) {
    $dbs = $db1 . '_pr' . $year . $mth;
} else {
    $dbs = $db1;
}

$db1 = $dbs;


//$where =" WHERE 1=1 and a.inv_total > 0 and a.hd_begin > 0 and a.hd_paid >=0";
//$where = " WHERE 1=1 and a.hd_begin != 0";
$where = " WHERE 1=1 ";
//$where .= " AND wrhs_code='$wrhs_axs' ";
if (!empty($_REQUEST['group_by'])) {
    $group_by = $_REQUEST['group_by'];
    switch ($group_by) {
        case '1' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_aps3.php";
            } else {
                $rptFile = "veh_aps4.php";
            }
            $title = '(Beginning Balance Group Period By Supplier, Date)';
            $order = " ORDER BY supp_code,pur_date,pur_inv_no";
            break;
        case '2' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_api3.php";
            } else {
                $rptFile = "veh_api4.php";
            }
            $title = '(Beginning Balance Group Period By Invoice Type, Date)';
            $order = " ORDER BY pinv_code,pur_date,pur_inv_no";
            break;
        case '3' :
            if ($_REQUEST['l_aging'] == 0) {
                $rptFile = "veh_apv3.php";
            } else {
                $rptFile = "veh_apv4.php";
            }
            $title = '(Beginning Balance Group Period By Vehicle Type, Date)';
            $order = " ORDER BY veh_code,pur_date,pur_inv_no";
            break;
    }
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
    } $filterdesc .= "Customer ";
}
if (!empty($_REQUEST['wrhs_code']) && $_REQUEST['wrhs_code'] != "ALL") {
    $wrhs_code = $_REQUEST['wrhs_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.wrhs_code  = '" . $wrhs_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Warehouse ";
}
if (!empty($_REQUEST['l_pinv_code'])) {
    $l_sinv_code = $_REQUEST['l_pinv_code'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.pinv_code  = '" . $l_sinv_code . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Invoice Type ";
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
        $filterdesc .= " AND ";
    } $filterdesc .= "Vehicle Type ";
}

//$statsql = "create temporary table temp_aph
//select * from veh_aph  ".$where ;
//echo $statsql;
//mysql_query($statsql) or die(mysql_error());
//$where = " where pur_inv_no in (select pur_inv_no from temp_aph) " ;

if (!empty(dateFormat($_REQUEST['ap_date']))) {
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " a.pur_date  <= '" . dateFormat($_REQUEST['ap_date']) . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Payment Date ";
}



//$statsql = "create temporary table temp_apd
//select * from veh_apd ".$where ;
//echo $statsql;
//mysql_query($statsql) or die(mysql_error());


/* $statsql ="select a.pur_inv_no,a.pur_date,a.chassis,a.engine,a.supp_code,a.supp_name,a.hd_begin,a.pinv_code,
  a.chassis,a.engine,a.veh_code,a.veh_name,a.inv_total,DATEDIFF(curdate() ,a.due_date) as aging,a.due_date,
  sum(b.pay_val) as hd_paid,sum(b.disc_val) as hd_disc
  from temp_aph a left join temp_apd b on a.pur_inv_no = b.pur_inv_no
  "; */


if (!empty($_REQUEST['rpt_by'])) {
    $rpt_by = $_REQUEST['rpt_by'];

    switch ($rpt_by) {
        case '1':
            $statsql = "create temporary table temp_aph select a.*, DATEDIFF(curdate(),a.due_date) as aging from " . $db1 . ".veh_aph a  ";
            $statsql .= $where;

            mysql_query($statsql) or die(mysql_error());

            $where = " where pur_inv_no in (select pur_inv_no from temp_aph) ";

            break;


        case '2':
         
            break;
    }
}


if (!empty($_REQUEST['ap_date'])) {
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    if ($rpt_by == '1') {
        $where .= " b.pay_date  <= '" . dateFormat($_REQUEST['ap_date']) . "' ";
    } else {
        $where1 = " b.pay_date  < '" . dateFormat($_REQUEST['ap_date']) . "' ";
        $where2 = " b.pay_date  = '" . dateFormat($_REQUEST['ap_date']) . "' ";
    }
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Tanggal Bayar ";
}

if (!empty($_REQUEST['pay_type'])) {
    $pay_type = $_REQUEST['pay_type'];
    $len = strlen($where);
    if ($len >> 0) {
        $where .= " AND ";
    }
    $where .= " b.pay_type  = '" . $pay_type . "' ";
    $len = strlen($filterdesc);
    if ($len >> 0) {
        $filterdesc .= " AND ";
    } $filterdesc .= "Pay Type ";
}



if (!empty($_REQUEST['rpt_by'])) {


    switch ($rpt_by) {
        case '1':
            $statsql = "create temporary table temp_apd select * from " . $db1 . ".veh_apd b " . $where;
            $dtl = mysql_query($statsql) or die(mysql_error());
            
          
            break;

        case '2':
            
            break;
    }
}

 $where = "where 1=1 ";
    
if (!empty($_REQUEST['rpt_by'])) {
    $rpt_by = $_REQUEST['rpt_by'];

    switch ($rpt_by) {
        case '1':
            $statsql = "select a.*,DATEDIFF(curdate(),a.due_date) as aging,a.due_date,
                            sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
                        from temp_aph a left join temp_apd b on a.pur_inv_no = b.pur_inv_no
                        ";
            

            break;

        case '2':

            $statsql = "select a.*,DATEDIFF(curdate(),a.due_date) as aging,a.due_date,
                         sum(b.pay_val) as pd_paid,sum(b.disc_val) as pd_disc
                        from temp_aph a left join temp_apd b on a.sal_inv_no = b.sal_inv_no 
                        ";
            // $where .= " and a.pd_end not in('0') ";
            break;
    }
}


$statsql .= $where;

/* $mounth = rangeMounth($ap_datefrom, $ap_date);

  $statsql .= queryUnion($mounth,$db1,$statsql);
 */
$statsql .= " Group by a.pur_inv_no " . $order . ' ASC';


//echo $statsql;exit;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl) == 0) {
    echo "Tidak ada data";
    return;
}
if (!empty($_REQUEST['aging'])) {
    $aging = $_REQUEST['aging'];

    switch ($aging) {
        case '1':
            $title .= "<br />Aging By Due Date";
            break;
        case '2':
            $title .= "<br />Aging By Invoice Date";
            break;
    }
}

include "hutangkendaraan/" . $rptFile;

$filename = 'VehicleAccountPayable_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_aph';

$keys = array(
    'key1' => 'default'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
?>