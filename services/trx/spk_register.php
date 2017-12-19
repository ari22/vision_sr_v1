<?php
//////////////////
// Register SPK //
//////////////////
// User memasukan nomor awal SPK dan nomor akhir SPK yang akan digenerate.
// Validasi dilakukan untuk melihat apakah nomor SPK yang dimasukan sudah ada yang pernah diregister.
// SPK didaftarkan ke dalam tabel veh_spkreg dan direkam ke history veh_spkhst.
// Jika SPK sudah dihapus maka tetap dianggap pernah di register dan tidak bisa diregist ulang.

$table='veh_spkreg';
if (isset($so_no) && isset($sd_no))
{
	
	if ($so_no>$sd_no)
	{
		$temp = $so_no;
		$so_no = $sd_no;
		$sd_no = $temp;
	}
	$lnso_no = strlen(trim($so_no));
	$lnsd_no= strlen(trim($sd_no));
	if ($lnso_no==0 || $lnsd_no==0)
	{
		echo '{"success":false,"message":"Cannot be empty.","so_no":"'.$lnso_no.'"}';
		return;
	}
	
	$msg='';
	$success='false';
		/* Cek length di system setup */
		$select_system = new SqlSyntax;
		$select_system->query = "select spk_length,spk_prefix from ssystem ";
		$SqlEngine_system = new SqlEngine;
		$row=$SqlEngine_system->GetData($select_system);
		$spk_length=$row['spk_length'];
		$spk_prefix=$row['spk_prefix'];
		$length_prefix=strlen($spk_prefix);
		$hit_length_prefix=$spk_length-$length_prefix;
		$prefixso_no=$spk_prefix.str_pad($so_no, $hit_length_prefix, "0", STR_PAD_LEFT);
		$prefixsd_no=$spk_prefix.str_pad($sd_no, $hit_length_prefix, "0", STR_PAD_LEFT);

	$sql = new SqlSyntax;
	$sql->query = "select count(so_no) as n_count from $table ";
	$sql->where = "(so_no between '$so_no' and '$sd_no') and length(so_no) = length('$so_no')";
	$SqlEngine = new SqlEngine;
	$row = $SqlEngine->GetData($sql);
	$count = $row['n_count'];
	if ($count>>0)
	{
		$success='false';
		$msg = 'SPK has been registered.';
	}else
	{
		for ($x=$so_no; $x<=$sd_no; $x++) {
			$spk = $spk_prefix.str_pad($x, $hit_length_prefix, "0", STR_PAD_LEFT);
			$sql = new SqlSyntax;
			$sql->query = "select count(id) as n_count from $table ";
			$sql->where = "so_no = '$spk'";
			$SqlEngine = new SqlEngine;
			$row = $SqlEngine->GetData($sql);
			$count = $row['n_count'];
			if ($_SESSION['debug']==true) {echo "<br>Record found : $count<br>";}
			if ($count>>0)
			{
				//echo '{"success":false,"message":"SPK '.$spk. ' already exist"}';
				$lenmsg = strlen($msg);
				if ($lenmsg>>0){$msg.=',';}
				$msg .= "$spk";
			}else
			{
				//kondisi recall
				$sql_find = new SqlSyntax;
				$sql_find->query="select * from veh_spkhst ";
				$sql_find->where="so_no like $spk order by id desc limit 1";
				$sqlengine_find = new SqlEngine;
				$row = $SqlEngine->GetData($sql_find);
				if($row['action']=='Deleted'){
					$sql = new SqlSyntax;
					$sql->query = "insert into $table (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,use_date) values ('$spk',NOW(),'','','".$_SESSION['C_USER']."','','')";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->PutData($sql);
					if ($_SESSION['debug']==true) {echo '{"success":true,"message":"'.$row. ' row(s) inserted"}';}
					//Insert to VEH_SPKHST
					$sql = new SqlSyntax;
					$sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$spk',NOW(),'','','".$_SESSION['C_USER']."','','Recall',NOW(),'')";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->PutData($sql);
					if ($_SESSION['debug']==true) {echo '{"success":true,"message":"History '.$row. ' row(s) inserted"}';}
					$success='true';
				}
				//kondisi insert baru
				else{
					//insert to veh_spkreg
					$sql = new SqlSyntax;
					$sql->query = "insert into $table (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,use_date) values ('$spk',NOW(),'','','".$_SESSION['C_USER']."','','')";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->PutData($sql);
					if ($_SESSION['debug']==true) {echo '{"success":true,"message":"'.$row. ' row(s) inserted"}';}
					//Insert to VEH_SPKHST
					$sql = new SqlSyntax;
					$sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$spk',NOW(),'','','".$_SESSION['C_USER']."','','Generate',NOW(),'')";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->PutData($sql);
					if ($_SESSION['debug']==true) {echo '{"success":true,"message":"History '.$row. ' row(s) inserted"}';}
					$success='true';
				}
			}
		} 
		
	}
	$lenmsg = strlen($msg);
	if ($lenmsg>>0){
		echo '{"success":'.$success.',"message":"'.$msg.'"}';
	}else
		echo '{"success":'.$success.',"message":"SPK has been registered successfully"}';
	{		
	}
}

?>