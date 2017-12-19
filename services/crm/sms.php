<?php
/*
Modul			:	SMS - Gammu Versi 12
Cara pakai  	:	http://localhost:88/ver2/services/runCRUD.php?lookup=crm/sms&func=GetData&reminder=sr_birthday
Keterangan		: 	func -> Function
					reminder -> File query khusus berdasarkan jenis reminder
Jenis Reminder 	:	sr_birthday 	->	Ulang tahun customer showroom
					sv_birthday		->  Ulang tahun customer bengkel
Function Create :	http://localhost:88/ver2/services/runCRUD.php?lookup=crm/sms&func=create&pesan=test123&recipient=081222333;081888111
*/
$table='';
$msg='';
$success='false';
function InsertIntoOutbox($pesan,$hp)
{
	if (isset($pesan) && isset($hp))
	{
		$lnfield1 = strlen(trim($pesan));
		$lnfield2= strlen(trim($hp));
		if ($lnfield1==0 || $lnfield2==0)
		{
			//msgFailed($id,$field,$value,$msg)
			//msgFailed('',$pesan,$hp,'Failed');
			return false;
		}
		
		$sql = "insert into outbox (TextDecoded,DestinationNumber) values('".$pesan."','".$hp."')";
		$result = mysql_query($sql);
		$count = mysql_affected_rows();
		
		if ($count>>0){
			//msgSuccess('',$pesan,$hp,'Sending Message To :');
			return true;
		}else{
			//msgFailed('',$pesan,$hp,'Failed #2');
			return false;
		}
	}
}

mysql_select_db('sms');
if (isset($func))
{
	if ($func=='GetData')
	{
		include_once  $reminder.'.php'; 
	}
	if ($func=='GetInbox')
{
		$result = "select * from inbox where 1=1 ";
		if (isset($SenderNumber))
		{
			$result .= " AND SenderNumber like '%$SenderNumber%' " ;			
		}
		if (isset($pesan))
		{
			$result .= " AND TextDecoded like '%$pesan%' " ;			
		}
		if (isset($dtFrom))
		{
			$len = strlen($dtFrom);
			if ($len>0){
				$phpdate = strtotime( $dtFrom );
				$mysqldate = date( 'YmdHis', $phpdate );
			
				$result .= " AND ReceivingDateTime >= '$mysqldate' " ;
			}
		}
		if (isset($dtTo))
		{	
			$len = strlen($dtTo);
			if ($len>0){
				$phpdate = strtotime( $dtTo );
				$mysqldate = date( 'YmdHis', $phpdate );
				$result .= " AND ReceivingDateTime <= '$mysqldate' " ;
			}		
		}
		
		//echo $result;
		$sql = "select count(id) as n_count from ($result) a ";
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}
	if ($func=='GetOutBox')
	{
		
		$result = "select a.*,b.cust_name from outbox a left join hnd_template.veh_cust b on a.DestinationNumber = b.hp ";
		//echo $result;
		$sql = "select count(id) as n_count from ($result) a ";
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}
	if ($func=='GetSentItem')
	{
		$result = "select * from sentitems where 1=1 ";
		if (isset($DestinationNumber))
		{
			$result .= " AND DestinationNumber like '%$DestinationNumber%' " ;			
		}
		if (isset($Status))
		{
			$result .= " AND Status like '%$Status%' " ;			
		}
		if (isset($pesan))
		{
			$result .= " AND TextDecoded like '%$pesan%' " ;			
		}
		if (isset($dtFrom))
		{
			$len = strlen($dtFrom);
			if ($len>0){
				$phpdate = strtotime( $dtFrom );
				$mysqldate = date( 'YmdHis', $phpdate );
			
				$result .= " AND SendingDateTime >= '$mysqldate' " ;
			}
		}
		if (isset($dtTo))
		{	
			$len = strlen($dtTo);
			if ($len>0){
				$phpdate = strtotime( $dtTo );
				$mysqldate = date( 'YmdHis', $phpdate );
				$result .= " AND SendingDateTime <= '$mysqldate' " ;
			}		
		}
		
		//echo $result;
		$sql = "select count(id) as n_count from ($result) a ";
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  $table[]=$row;
		  unset($row);
		}
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
		echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}
	if ($func=='create')
	{		
		if (isset($pesan) && isset($recipient))
		{
			//echo $pesan."</br>";
			//echo $recipient."</br>";
			$lnfield1 = strlen(trim($pesan));
			$lnfield2= strlen(trim($recipient));
			if ($lnfield1==0 || $lnfield2==0)
			{
				//msgFailed($id,$field,$value,$msg)
				msgFailed('','','','Data cannot be empty');
				return;
				
			}
			$hp = explode(";", $recipient);
			$gagal = 0;
			$listgagal="No. HP gagal kirim ";
			for ($i=0;$i<count($hp);$i++)
			{
				//echo $hp[$i]."</br>"; // piece1
				if (InsertIntoOutbox($pesan,$hp[$i]) == false)
				{
					$gagal=$gagal+1;
					$listgagal .= " $hp[$i] gagal" ;
				}
				
			}
			//echo $listgagal;
			if ($gagal>>0)
			{
				msgFailed('',$listgagal,'','Insert failed');
			}else{
				msgSuccess('','','','Record saved');			
			}
		}
	}
	
}
mysql_select_db('hnd_template');

?>