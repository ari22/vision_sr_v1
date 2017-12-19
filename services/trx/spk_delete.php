<?php
//////////////////
// DELETE SPK //
//////////////////
// Menghapus SPK yang sudah di-register dan belum digunakan
// Ciri SPK belum digunakan adalah use_date masih kosong.
session_start();
$table='veh_spkreg';

$msg='';
$success='false';
if(isset($func))
{
	if ($func=='read')
	{
		include("spk_available.php");
	}

	if($func=='del')
	{		
		if (isset($so_no) or isset($list_so_no))
		{
			if (isset($list_so_no))
			{
				$arr = explode(",",$list_so_no);
				//echo json_encode($sarr);
				foreach ($arr as &$so_no) {
					$sql = new SqlSyntax;
					$sql->query = "select count(so_no) as n_count from $table ";
					$sql->where = "so_no = '$so_no' and year(use_date)<='1999' and LENGTH(srep_code)=0";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->GetData($sql);
					$count = $row['n_count'];
					//echo "$count<br>";
					if ($count>>0)
					{
						$sql = new SqlSyntax;
						$sql->query = "delete from veh_spkreg";
						$sql->where = "so_no = '$so_no'";
						$SqlEngine = new SqlEngine;
						$row = $SqlEngine->PutData($sql);
						if ($row>>0)
						{
							$sql = new SqlSyntax;
							$sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$so_no',NOW(),'','','".$_SESSION['C_USER']."','','Deleted',NOW(),'')";
							$SqlEngine = new SqlEngine;
							$row = $SqlEngine->PutData($sql);
							$success='true';
							$msg = ' SPK have been successfully deleted.<br>';
						}
					}else
					{
						$success='false';
						$msg = 'SPK  has never been registered or is in use.<br>';
					}
				}
                                
                                $msg = $msg;
			}else
			{
				
				/* Cek apakah sudah ada spk yang pernah diregister*/
				$sql = new SqlSyntax;
				$sql->query = "select count(so_no) as n_count from $table ";
				$sql->where = "so_no = '$so_no' and year(use_date)='0000'";
				$SqlEngine = new SqlEngine;
				$row = $SqlEngine->GetData($sql);
				$count = $row['n_count'];
				if ($count>>0)
				{
					$sql = new SqlSyntax;
					$sql->query = "delete from veh_spkreg";
					$sql->where = "so_no = '$so_no'";
					$SqlEngine = new SqlEngine;
					$row = $SqlEngine->PutData($sql);
					if ($row>>0)
					{
						$sql = new SqlSyntax;
						$sql->query = "insert into veh_spkhst (so_no,so_regdate,srep_code,srep_name,so_reg_by,so_note,action,act_date,use_date) values ('$so_no',NOW(),'','','$userid','','Deleted',NOW(),'')";
						$SqlEngine = new SqlEngine;
						$row = $SqlEngine->PutData($sql);

						$success='true';
						$msg = 'SPK have been successfully deleted.<br>';
					}
				}else
				{
					$success='false';
					$msg =  'SPK have never been registered or is in use.';
				}
				$msg = $msg;
			}
			echo '{"success":'.$success.',"message":"'.$msg.'"}';
		}
	}
}
?>