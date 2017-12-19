<?php
session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();
$rptTitle = "OPTIONAL ACCOUNT PAYABLE PURCHASE REPORT";

$rptFile = "prt_aps2.php";
$order = " ";

$supp_type = '';
$title='';
$filterdesc = '';

$where =" WHERE LEFT(pur_inv_no,3)='APW' ";

if ($_REQUEST['rpt_type']==1)
{
	if  ($_REQUEST['l_aging']==0)
	{
		$title = '(Beginning Balance)';
		$rptFile = "prt_aps1.php"; 
	}else{
		$rptFile = "prt_aps2.php"; 
		if  ($_REQUEST['aging_sortby']==0)
		{
			$order = '';
		}else{
			$order = '';
		}
	}
}
if ($_REQUEST['rpt_type']==2)
{
	$where =" WHERE 1=1 and hd_begin - hd_paid>0 ";
	$title = '(Beginning Balance Update)';
	if  ($_REQUEST['l_aging']==0)
	{
		$rptFile = "prt_aps1.php"; 
	}else{
		$rptFile = "prt_aps2.php"; 
		if  ($_REQUEST['aging_sortby']==0)
		{
			$order = '';
		}else{
			$order = '';
		}
	}
}

if (!empty($_REQUEST['supp_code']))
{
	$supp_code = $_REQUEST['supp_code'];
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " supp_code  = '".$supp_code."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Customer ";
}
if (!empty($_REQUEST['wrhs_code']))
{
	$wrhs_code = $_REQUEST['wrhs_code'];
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " wrhs_code  = '".$wrhs_code."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Warehouse ";
}


$statsql = "create temporary table temp_arh 
select * from acc_aph  ".$where ;
//echo $statsql;exit;
mysql_query($statsql) or die(mysql_error());

$where = " where pur_inv_no in (select pur_inv_no from temp_arh) " ;
if (!empty(dateFormat($_REQUEST['ap_date'])))
{
	$len = strlen($where);
	if ($len>>0)
	{ 
		$where .= " AND ";
	}
	$where .= " pay_date  <= '".dateFormat($_REQUEST['ap_date'])."' ";	
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Tanggal Bayar ";
}

$statsql = "create temporary table temp_ard 
select * from acc_apd ".$where ;
//echo $statsql;

mysql_query($statsql) or die(mysql_error());

$where = "where 1=1 " ;
$statsql ="select a.pinv_code, a.pur_inv_no,a.pur_date,a.chassis,a.engine,a.supp_code,a.supp_name,a.hd_begin,
a.note,a.supp_invno,a.supp_invdt,a.inv_total,DATEDIFF(curdate() ,a.due_date) as aging,a.due_date,
sum(b.pay_val) as hd_paid,sum(b.disc_val) as hd_disc, a.hd_end
from temp_arh a left join temp_ard b on a.pur_inv_no = b.pur_inv_no
";

$statsql .= $where . " Group by a.pur_inv_no " . $order ;

//echo $statsql;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}
if (!empty($_REQUEST['aging'])) {
    $aging = $_REQUEST['aging'];

    switch ($aging) {
        case '1':
            //$where .= " and a.due_date<='" . dateFormat($date) . "'";
            $title .= "<br />Aging By Due Date";
            break;
        case '2':
            //$where .= " and a.sal_date<='" . dateFormat($date) . "'";
            $title .= "<br />Aging By Invoice Date";
            break;
    }
}


include "hutangbbn/".$rptFile; 
$filename = 'optionalPayable_' . date('dmy') . '_' . date('his');

echo outputReport($output, $tbl, $filename);
/*
$tblimport = 'veh_aph';

$keys = array(
    'key1' => 'optional'
);
echo outputReport($output, $tbl, $filename, $statsql, $tblimport, $keys);
*/
?>