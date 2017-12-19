<?php
session_start();

$table = "veh_spk";
$table2 = "veh_stk";


//include('tpl_lookup.php');

/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
  Antara lain :
  $table 	=> Nama Table MySQL
  $field1 => Field Primary (bukan id autoincrement)
  $field1 => Field Description
  Issue date [20140901]
 */

$usr_id = $_SESSION["C_ID"];
$usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
$usr = mysql_query($usrsql);
$usr = mysql_fetch_array($usr);

$wrhs_axs = $usr['wrhs_axs'];
$wrhs_input = $usr['wrhs_input'];

if (isset($func))
{
	
	if ($func=='read')
	{
		include "navigation.php";
		$defaultfields = "*";
		if (isset($fields)) {
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table where 1=1 ";
                
                if ($wrhs_axs !== 'ALL') {
                   $result .= " and wrhs_code='$wrhs_axs' ";
                }
        
		if (isset($where1)) {
			if($where1=='1'){
				$result .= " and match_date=0000-00-00 AND Length(chassis)=0 AND Length(engine)=0";
			}
		}
		if (isset($where2)) {
			if($where2=='2'){
				$result .= " and match_date>0000-00-00 AND Length(chassis)>0 AND Length(engine)>0 and pick_date='0000-00-00'";
			}

		}

		if (isset($sort)) {
			$result .= " ORDER BY $sort ";	
		}
		if (isset($start)) {
			$result .= " LIMIT $start,$limit ";
		}
		$sql = "select count(so_no) as n_count from ($result) a ";
		if (isset($page)) {
			$start = ($rows*($page-1));
			$result .= " LIMIT $start,$rows ";
		}
		//echo $result;
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

	if ($func=='readstock')
	{
		$defaultfields = "*";
		if (isset($fields)) {
			$defaultfields = $fields;
		}
		$result = "select $defaultfields from $table2 where match_date='0000-00-00'";
		
                if ($wrhs_axs !== 'ALL') {
                    $result .= " and wrhs_code='$wrhs_axs' ";
                }
                
		if (isset($filter)) {
			$result .= " AND $filter ";
			//echo $result;
		}
		if (isset($order)) {
			$result .= " ORDER BY $order ";	
		}
		if (isset($start)) {
			$result .= " LIMIT $start,$limit ";
		}
		$sql = "select count(so_no) as n_count from ($result) a ";
		if (isset($page)) {
			$start = ($rows*($page-1));
			$result .= " LIMIT $start,$rows ";
		}

		//echo $result;exit;
		$result = mysql_query($result);    
		
		$table=array();
		while($row=mysql_fetch_object($result)){
		  //$table[]=$row;
		  //unset($row);
                 
                  $datenow = new DateTime(date('Y-m-d'));
                  $stk_date = new DateTime($row->stk_date);
                  $day = $datenow->diff($stk_date);
             
                
                  $table[] = array(
                      'id' => $row->id,
                      'stk_date' => $row->stk_date,
                      'day'=> $day->days,
                      'po_no'=> $row->po_no,
                      'chassis'=> $row->chassis,
                      'veh_code'=> $row->veh_code,
                      'veh_name'=> $row->veh_name,
                      'veh_transm' => $row->veh_transm,
                      'color_code' => $row->color_code,
                      'color_name' => $row->color_name,
                      'color_type' => $row->color_type,
                      'veh_type' => $row->veh_type,
                      'engine' => $row->engine,
                      'veh_model' => $row->veh_model,
                      'veh_year' => $row->veh_year,
                      'veh_brand' => $row->veh_brand,
                      'wrhs_code' => $row->wrhs_code,
                      'loc_code' => $row->loc_code
                  );
		}
                
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
                
                $json = array(
                    'total' => $row['n_count'],
                    'rows' => $table
                );
                
                echo json_encode($json);
		//echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';
	}	

	if ($func=='match')
	{
                $sql1 = "select * from veh_stk where id =$sid";
                $result1 = mysql_query($sql1);
		$row1=mysql_fetch_array($result1);
                $pur_inv_no = $row1['pur_inv_no'];
		/* Hanya field "$field2" yang boleh diupdate */
		$query_update_spk="update veh_spk SET  match_date=$date, chassis=$chassis, engine=$engine, pur_inv_no='$pur_inv_no' WHERE id=$id";
		$result=mysql_query($query_update_spk);
		$sql = "select * from veh_spk where id =$id";
		$result = mysql_query($sql);
		$row=mysql_fetch_array($result);
                $so_date= $row['so_date'];
                
		$query_update_stock="update veh_stk SET match_date=$date, so_no=$nospk, so_date='$so_date' WHERE id=$sid";
		$result=mysql_query($query_update_stock);
		$sql = "select * from veh_stk where id =$sid";
		$result = mysql_query($sql);
		
	}

	if ($func=='unmatch')
	{
               //validation SPK UnMatch 
            
		/* Hanya field "$field2" yang boleh diupdate */

		$sql = "select * from veh_spk where id =$id";
		$result = mysql_query($sql);
		$row=mysql_fetch_assoc($result);
                $so_no = $row['so_no'];
                $sal_inv_no = $row['sal_inv_no'];
                
                if($row['pick_date'] !== '0000-00-00' ){
                   
                    $msg = array(
                        'success' => false,
                        'message' => "SPK is found in sales invoice ".$sal_inv_no
                    );
                    echo json_encode($msg);
                }else{
                    $usrsql = "SELECT * from usr left join usr_veh veh on usr.username=veh.username left join usr_veh2 veh2 on usr.username=veh2.username left join usr_acc acc on usr.username=acc.username where usr.username=$username";
                    $usr_veh = mysql_query($usrsql);
                    $usr_access = mysql_fetch_assoc($usr_veh);
              
                    
                    $soseq_date = '';
                    if($usr_access['unmtch_pos'] == '2'){
                        $soseq_date = "soseq_date='".date('Y-m-d')."',";
                    }
                    
                    
                    $query_update_spk="update veh_spk SET $soseq_date match_date=0000-00-00, chassis='', engine='', pur_inv_no='' WHERE id=$id";
                    $result=mysql_query($query_update_spk);

                    $sql2 = "select * from veh_stk WHERE so_no='$so_no'";
                    $result2 = mysql_query($sql2);
                    $row2=mysql_fetch_assoc($result2);
                    $id2 = $row2['id'];

                    $query_update_stock="update veh_stk SET match_date=0000-00-00,so_date=0000-00-00, so_no='' WHERE id=$id2";
                    $result=mysql_query($query_update_stock);
                    $sql = "select * from veh_stk where id=$id2";
                    $result = mysql_query($sql);
                    
                    $msg = array(
                        'success' => true
                    );
                    echo json_encode($msg);
                }
	}
}
?>