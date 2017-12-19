<?php
//========CHANGE LOG=============
//buang footer

session_start();
$comp_name = "BELUM DI SET";
if (isset($_SESSION['comp_name'])) {
    $comp_name = $_SESSION['comp_name'];
}

$tbl = tblstyle();

$rptTitle = "VEHICLE ACCOUNT PAYABLE COMBINED REPORT";

$rptFile = "veh_apgc.php";
$order = " ORDER BY apg_inv_no,apg_date";

$supp_type = '';
$title='(By Date)';
$filterdesc = '';

$where =" WHERE 1=1 ";
if($wrhs_axs !== 'ALL'){
    $where .= " AND a.wrhs_code='$wrhs_axs' ";
}

$apg_date1 = dateFormat($apg_date1);
$apg_date2 = dateFormat($apg_date2);

if (!empty($_REQUEST['apg_date1']) && !empty($_REQUEST['apg_date2']) )
{
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.apg_date  <= '".dateFormat($_REQUEST['apg_date2'])."' and a.apg_date >= '" .dateFormat($_REQUEST['apg_date1']). "' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Payment Date ";
}

if (!empty($_REQUEST['pay_type']))
{
	$pay_type = $_REQUEST['pay_type'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.pay_type  = '".$pay_type."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Pay Type ";
}

if (!empty($_REQUEST['supp_code']))
{
	$supp_code = $_REQUEST['supp_code'];
	$len = strlen($where);
	if ($len>>0)
	{
		$where .= " AND ";
	}
	$where .= " a.supp_code  = '".$supp_code."' ";
	$len = strlen($filterdesc);
	if ($len>>0) {$filterdesc .= " AND ";} $filterdesc .= "Supplier ";
}


if (!empty($cls)) {
    $cls = $_REQUEST['cls'];
    
    switch ($cls) {
        case '1' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date !='0000-00-00' or a.cls_date <= '" . $apg_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";

            $where .= "and a.cls_date>='" . $apg_date1 . "' and a.cls_date<='" . $apg_date2 . "'";
            break;
        case '2' :
            $len = strlen($where);
            if ($len >> 0) {
                $where .= " AND ";
            }
            $where .= " (a.cls_date='0000-00-00' or a.cls_date is null or a.cls_date > '" . $apg_date2 . "') ";
            $len = strlen($filterdesc);
            if ($len >> 0) {
                $filterdesc .= " AND ";
            } $filterdesc .= "Close Date ";
            break;
        case '3' :
            break;
    }
}




$rptFile = "veh_apgh.php";
 
$statsql = "select a.*,
                sum(b.hd_paid) as hd_paid,sum(b.hd_disc) as hd_disc
                from " . $db1 . ".veh_apgh a left join " . $db1 . ".veh_apgd b on a.apg_inv_no = b.apg_inv_no
                ";

if (!empty($trans)) {
    $trans = $_REQUEST['trans'];

    if ($trans == '1') {
        $rptFile = "veh_apgd.php";
        
       $statsql ="select a.*,
                b.pur_inv_no,b.pur_date,b.chassis,b.engine,
                b.inv_total,b.hd_begin,b.hd_paid,b.hd_disc,b.hd_end,b.pph23,
                b.add_by,b.add_date
                from " . $db1 . ".veh_apgd b left join " . $db1 . ".veh_apgh a on b.apg_inv_no = a.apg_inv_no
                ";

    }
}

//$statsql .= $where . " " . $order ;
$statsql .= $where;
if ($trans !== '1') {
        $statsql .= " Group by a.apg_inv_no ";
}

$mounth = rangeMounth($apg_date1, $apg_date2);

$statsql .= queryUnion($mounth,$db1,$statsql);

$statsql .= $order.' ASC';
//echo $statsql;
$dtl = mysql_query($statsql) or die(mysql_error());
if (mysql_num_rows($dtl)==0)
{
	echo "Tidak ada data";
	return ;
}


include "pembayaranhutangkendaraangabungan/".$rptFile;

$filename = 'VehicleAccountPayableGroup_' . date('dmy') . '_' . date('his');

$tblimport = 'veh_apgh';

echo outputReport($output, $tbl, $filename, $statsql, $tblimport);

?>