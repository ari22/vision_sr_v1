<?php

/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
  Antara lain :
  $table 	=> Nama Table MySQL
  $field1 => Field Primary (bukan id autoincrement)
  $field1 => Field Description
  Issue date [20140901]
 */
//table yang terlibat veh_spk dan veh_spkreg
session_start();
if (isset($func)) {
    if ($func == 'reccount') {
        $result = "SELECT * from $table where 1=1 ";
        $sql = "SELECT count($field1) as n_count,max(id) as max_id from ($result) ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo json_encode($row); //$row['n_count'];
    }
    if ($func == 'read') {
        include "/trx/navigation.php";
        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "SELECT $defaultfields from $table where 1=1 ";

        if (isset($query)) {
            $result .= " AND ($field1 like '%$query%' or $field2 like '%$query%' )";
        }
        if (isset($filter)) {
            $result .= " AND $filter ";
        }
        if (isset($order)) {
            $result .= " ORDER BY $order ";
        }
        if (isset($id)) {
            $result .= " AND id = $id ";
        }
        if (isset($start)) {
            $result .= " LIMIT $start,$limit ";
        }
        $sql = "SELECT count($field1) as n_count from ($result) a ";
        //echo $result;
        if (isset($page)) {
            $start = 1 + ($rows * ($page - 1));
            $result .= " LIMIT $start,$rows ";
        }
        $result = mysql_query($result);

        $table = array();
        while ($row = mysql_fetch_object($result)) {
            $table[] = $row;
            unset($row);
        }
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo '{"total":"' . $row['n_count'] . '","rows":' . json_encode($table) . '}';
    }
    if ($func == 'create') {

        if (isset($field1) && isset($field2)) {

            //IsiGakBolehKosong($pur_inv_no,"Masukkan No. Faktur (Invoice)");
            IsiGakBolehKosong($po_no, "Please input PO No.");
            IsiGakBolehKosong($wrhs_code, "Please input Warehouse");
            IsiGakBolehKosong($loc_code, "Please input Location");
            IsiGakBolehKosong($supp_code, "Please input Supplier Code");
            IsiGakBolehKosong($supp_name, "Please input Supplier Name");
            IsiGakBolehKosong($chassis, "Please input Chassis Code");
            IsiGakBolehKosong($engine, "Please input Engine Code");
            $sql = "SELECT count(id) as n_count from $table where $field2 = '" . $$field2 . "' ";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $count = $row['n_count'];
            if ($count >> 0) {
                //echo json_encode(array("success"=>"John","time"=>"2pm")); 
                msgFailed($id, $field2, $$field2, 'PO Sudah di gunakan di penerimaan lain');
                return;
            } else {
                /* ============== CHECK & UPDATE INV_SEQ Table for Invoice Number ========== */
                $slc_seq = mysql_query("SELECT inv_type,inv_year,inv_mth,inv_no from inv_seq where inv_type='" . $invtyp . "' ");
                $row = mysql_fetch_assoc($slc_seq);
                $month = $row['inv_mth'];
                $runingno = ($row['inv_no'] + 1);
                $month2 = date("m");
                if ($month != $month2) {
                    $slc_inv = "SELECT max(pur_inv_no) as hasil FROM veh_prh WHERE SUBSTR(po_no,7,2)=$month2 ";
                    $result = mysql_query($slc_inv);
                    $row2 = mysql_fetch_assoc($result);
                    $hsl = $row2['hasil'];
                    if ($hsl == null) {
                        $mth_val = date("m");
                        $old_mth_no = 1;
                    } else {
                        $mth_val = substr($row2['hasil'], 6, 2);
                        $old_mth_no = substr($row2['hasil'], 8, 4) + 1;
                    }
                    $mth_val = substr($row2['hasil'], 6, 2);
                    $old_mth_no = substr($row2['hasil'], 8, 4) + 1;
                    $newinv = $row['inv_type'] . "-" . substr($row['inv_year'], 2) . str_pad($mth_val, 2, "0", STR_PAD_LEFT) . str_pad($old_mth_no, 4, "0", STR_PAD_LEFT);

                    //=============  ===================//

                    $query_cek = mysql_query("SELECT count(pur_inv_no) as count from veh_prh where pur_inv_no='" . $newinv . "' ");
                    $row_cek = mysql_fetch_assoc($query_cek);
                    $count = $row_cek['count'];
                    if ($count > 0) {
                        msgFailed($id, $field1, $newinv, 'Invoice no. has been used a');
                        exit;
                    }
                    $newruningno = $old_mth_no;
                    $ins_seq = mysql_query("UPDATE inv_seq set inv_year=YEAR(now()), inv_mth=MONTH(now()), inv_no='" . $newruningno . "' where inv_type='" . $invtyp . "' ");
                    if (mysql_affected_rows() == 0) {
                        msgFailed($id, $field1, $$field1, 'Failed to update invoice no.');
                        exit;
                    }
                } else {

                    $newinv = $row['inv_type'] . "-" . substr($row['inv_year'], 2) . str_pad($month, 2, "0", STR_PAD_LEFT) . str_pad($runingno, 4, "0", STR_PAD_LEFT);
                    $query_cek = mysql_query("SELECT count(pur_inv_no) as count from veh_prh where pur_inv_no='" . $newinv . "' ");
                    $row_cek = mysql_fetch_assoc($query_cek);
                    $count = $row_cek['count'];
                    if ($count > 0) {
                        msgFailed($id, $field1, $newinv, 'Invoice no. has been used b');
                        exit;
                    }

                    $newruningno = (($month2 - $month) == 0) ? $runingno : 1;
                    $ins_seq = mysql_query("UPDATE inv_seq set inv_year=YEAR(now()), inv_mth=MONTH(now()), inv_no='" . $newruningno . "' where inv_type='" . $invtyp . "' ");
                    if (mysql_affected_rows() == 0) {
                        msgFailed($id, $field1, $$field1, 'Failed to update invoice no.');
                        exit;
                    }
                }
                /* ============= end of check & update ======================== */


                $po_date = date("Ymd", strtotime($po_date));
                $pred_stk_d = (empty($pred_stk_d)) ? '0000-00-00' : date("Ymd", strtotime($pred_stk_d));
                $sji_date = (empty($sji_date)) ? '0000-00-00' : date("Ymd", strtotime($sji_date));
                $kwiti_date = (empty($kwiti_date)) ? '0000-00-00' : date("Ymd", strtotime($kwiti_date));
                $fpi_date = (empty($fpi_date)) ? '0000-00-00' : date("Ymd", strtotime($fpi_date));
                $dni_date = (empty($dni_date)) ? '0000-00-00' : date("Ymd", strtotime($dni_date));
                $do_date = (empty($do_date)) ? '0000-00-00' : date("Ymd", strtotime($do_date));
                $pdi_date = (empty($pdi_date)) ? '0000-00-00' : date("Ymd", strtotime($pdi_date));
                $query_insert = "insert into " . $table . " (
								pur_inv_no,			stk_date,			po_no,				po_date,			cls_date,
								supp_code,			supp_name,			wrhs_code,			loc_code,			note,
								cls_by,				veh_code,			veh_name,			chassis,			engine,
								veh_type,			veh_model,			color_code,			color_name,			stdoptcode,
								veh_brand,			veh_transm,			veh_year,			color_type,			qty,	
								unit,				pred_stk_d,			alarm,				key_no,				serv_book,
								sji_no,				sji_date,			kwiti_no,			kwiti_date,			fpi_no,
								fpi_date,			dni_no,				dni_date,			do_no,				do_date,
								pdi_no,				pdi_date,			po_made_by,			po_appr_by,			pur_base,
								pur_opt,			pur_bt,				pur_pbm,			pur_vat,			pur_pph,
								pur_misc,			pur_price,			po_desc, 			unit_price,			tot_price,
								pinv_code,			opn_date,			due_day
					) values (
								'" . $newinv . "',		'" . $stk_date . "',	'" . $po_no . "',		'" . $po_date . "',	'" . $cls_date . "',
								'" . $supp_code . "',	'" . $supp_name . "',	'" . $wrhs_code . "',	'" . $loc_code . "',	'" . $note . "',
								'" . $cls_by . "',		'" . $veh_code . "',	'" . $veh_name . "',	'" . $chassis . "',		'" . $engine . "',
								'" . $veh_type . "',	'" . $veh_model . "',	'" . $color_code . "',	'" . $color_name . "',	'" . $stdoptcode . "',
								'" . $veh_brand . "',	'" . $veh_transm . "',	'" . $veh_year . "',	'" . $color_type . "',	'" . $qty . "',
								'" . $unit . "',		'" . $pred_stk_d . "',	'" . $alarm . "',		'" . $key_no . "',		'" . $serv_book . "',
								'" . $sji_no . "',		'" . $sji_date . "',	'" . $kwiti_no . "',	'" . $kwiti_date . "',	'" . $fpi_no . "',
								'" . $fpi_date . "',	'" . $dni_no . "',		'" . $dni_date . "',	'" . $do_no . "',		'" . $do_date . "',
								'" . $pdi_no . "',		'" . $pdi_date . "',	'" . $po_made_by . "',	'" . $po_appr_by . "',	'" . $pur_base . "',
								'" . $pur_opt . "',		'" . $pur_bt . "',		'" . $pur_pbm . "',		'" . $pur_vat . "',		'" . $pur_pph . "',
								'" . $pur_misc . "',	'" . $pur_price . "',	'" . $po_desc . "',		'" . $unit_price . "',	'" . $tot_price . "',
								'" . $pinv_code . "',	CURDATE(),			'" . $due_day . "'  )";

                $result = mysql_query($query_insert);
                $sql = "SELECT count(id) as n_count,id from $table where pur_inv_no = '" . $newinv . "' ";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                $count = $row['n_count'];
                $id = $row['id'];
                if ($count >> 0) {
                    /* =========== UPDATE veh_po & veh_poo ========================= */
                    $sql1 = mysql_query("UPDATE veh_po set pur_inv_no='" . $newinv . "' where po_no='" . $po_no . "'");
                    $sql2 = mysql_query("UPDATE veh_poo set pur_inv_no='" . $newinv . "' where po_no='" . $po_no . "'");
                    /* ========== END OF update veh_po & veh_poop ================= */
                    msgSuccess($id, $newinv, $newinv, 'Record saved');
                    return;
                } else {
                    msgFailed($id, $newinv, $newinv, 'Insert failed');
                    return;
                }
            }
        }
    }


    if ($func == 'update') {
        /* Hanya field "$field2" yang boleh diupdate */

        if (isset($field1) && isset($field2)) {
            $lnfield1 = strlen(trim($field1));
            $lnfield2 = strlen(trim($field2));
            if ($lnfield1 == 0 || $lnfield2 == 0) {
                msgFailed($id, $field1, $$field1, 'Data cannot be empty');
                return;
            }
            SudahTerisi($cls_date, "Invoice has been closed");
            IsiGakBolehKosong($po_no, "Please input PO No.");
            IsiGakBolehKosong($wrhs_code, "Please input Warehouse");
            IsiGakBolehKosong($loc_code, "Please input Location");
            IsiGakBolehKosong($supp_code, "Please input Supplier Code");
            IsiGakBolehKosong($supp_name, "Please input Supplier Name");
            IsiGakBolehKosong($chassis, "Please input Chassis Code");
            IsiGakBolehKosong($engine, "Please input Engine Code");
            $sql = "SELECT count(id) as n_count from $table where pur_inv_no = '" . $pur_inv_no . "' ";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $count = $row['n_count'];
            if ($count == 0) {
                //echo json_encode(array("success"=>"John","time"=>"2pm")); 
                msgFailed($id, $field1, $$field1, 'Record not found');
                return;
            } else {
                $pred_stk_d = (empty($pred_stk_d)) ? '0000-00-00' : date("Ymd", strtotime($pred_stk_d));
                $sji_date = (empty($sji_date)) ? '0000-00-00' : date("Ymd", strtotime($sji_date));
                $kwiti_date = (empty($kwiti_date)) ? '0000-00-00' : date("Ymd", strtotime($kwiti_date));
                $fpi_date = (empty($fpi_date)) ? '0000-00-00' : date("Ymd", strtotime($fpi_date));
                $dni_date = (empty($dni_date)) ? '0000-00-00' : date("Ymd", strtotime($dni_date));
                $do_date = (empty($do_date)) ? '0000-00-00' : date("Ymd", strtotime($do_date));
                $pdi_date = (empty($pdi_date)) ? '0000-00-00' : date("Ymd", strtotime($pdi_date));
                $po_date = date("Ymd", strtotime($po_date));
                $sql1 = "UPDATE veh_po set pur_inv_no='" . $pur_inv_no . "' where po_no='" . $po_no . "'";
                $result1 = mysql_query($sql1);
                $sql2 = "UPDATE veh_poo set pur_inv_no='" . $pur_inv_no . "' where po_no='" . $po_no . "'";
                $result2 = mysql_query($sql2);
                $query_update = "UPDATE veh_prh SET 
						supp_code='" . $supp_code . "', 	supp_name='" . $supp_name . "',		wrhs_code='" . $wrhs_code . "',
						loc_code='" . $loc_code . "',		note='" . $note . "',				stdoptcode='" . $stdoptcode . "',
						pred_stk_d='" . $pred_stk_d . "',	alarm='" . $alarm . "',				key_no='" . $key_no . "',
						serv_book='" . $serv_book . "',		chassis='" . $chassis . "',			engine='" . $engine . "',
						sji_no='" . $sji_no . "',			sji_date='" . $sji_date . "',		kwiti_no='" . $kwiti_no . "',
						kwiti_date='" . $kwiti_date . "',	fpi_no='" . $fpi_no . "',			fpi_date='" . $fpi_date . "',
						dni_no='" . $dni_no . "',			dni_date='" . $dni_date . "',		do_no='" . $do_no . "',
						do_date='" . $do_date . "',			pdi_no='" . $pdi_no . "',			pdi_date='" . $pdi_date . "',
						veh_code='" . $veh_code . "',		veh_name='" . $veh_name . "',		veh_type='" . $veh_type . "',
						veh_model='" . $veh_model . "',		color_name='" . $color_name . "',	color_code='" . $color_code . "',
						veh_brand='" . $veh_brand . "',		veh_transm='" . $veh_transm . "',	color_type='" . $color_type . "',
						qty='" . $qty . "',					unit='" . $unit . "',				pred_stk_d='" . $pred_stk_d . "',
						alarm='" . $alarm . "',				key_no='" . $key_no . "',			serv_book='" . $serv_book . "',
						po_made_by='" . $po_made_by . "',	po_appr_by='" . $po_appr_by . "',	po_no='" . $po_no . "',
						po_date='" . $po_date . "',			po_desc='" . $po_desc . "',			veh_year='" . $veh_year . "',
						unit_price='" . $unit_price . "',	tot_price='" . $tot_price . "',		pinv_code='" . $pinv_code . "',
						pur_base='" . $pur_base . "',		pur_opt='" . $pur_opt . "',			pur_bt='" . $pur_bt . "',
						pur_pbm='" . $pur_pbm . "',			pur_vat='" . $pur_vat . "',			pur_pph='" . $pur_pph . "',
						pur_misc='" . $pur_misc . "',		pur_price='" . $pur_price . "',		due_day='" . $due_day . "'
						WHERE pur_inv_no='" . $pur_inv_no . "' ";
                $result1 = mysql_query($query_update);
                if (mysql_affected_rows() == 1) {
                    msgSuccess($id, $field1, $$field1, 'Record updated');
                    return;
                } else {
                    msgFailed($id, $field1, $$field1, 'Update Failed');
                    return;
                }
            }
        }
    }
    if ($func == 'delete') {
        if (isset($field1) && isset($field2)) {
            $sql = "SELECT count(id) as n_count from $table where $field1 = '" . $$field1 . "' ";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $count = $row['n_count'];
            if ($count == 0) {
                //echo json_encode(array("success"=>"John","time"=>"2pm")); 
                msgFailed($id, $field1, $$field1, 'Record not found');
                return;
            } else

            if ($po_no != null) {
                $nid = $id + 1;
                echo '{"success":true,"message":"Please erase PO No. first", "id":"' . $nid . '"}';
                return;
            } else {
                $query_delete = "delete from $table where id=$id";
                //echo $sql;
                $result = mysql_query($query_delete);
                $sql = "SELECT count(id) as n_count,id from $table where id=$id";
                $result = mysql_query($sql);
                $row = mysql_fetch_array($result);
                $count = $row['n_count'];
                if ($count == 0) {
                    msgSuccess($id, $field1, $$field1, 'Record deleted');
                    return;
                } else {
                    msgFailed($id, $field1, $$field1, 'Delete failed');
                    return;
                }
            }
        }
    }
    if ($func == 'datasource') {

        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "SELECT $defaultfields from veh_po where 1=1 AND pur_inv_no is null AND po_date !='0000-00-00'";

        if (isset($query)) {
            $result .= " AND (po_no like '%$query%' )";
        }

        if (isset($order)) {
            $result .= " ORDER BY $order ";
        }
        if (isset($id)) {
            $result .= " AND id = $id ";
        }
        if (isset($start)) {
            $result .= " LIMIT $start,$limit ";
        }
        $result = mysql_query($result);

        $table = array();
        while ($row = mysql_fetch_object($result)) {
            $table[] = $row;
            unset($row);
        }

        echo json_encode($table);
    }
    if ($func == 'counter') {
        /* $slc_seq=mysql_query("SELECT inv_type,inv_year,inv_mth,inv_no from inv_seq where inv_type='".$keyword."' ");
          $row=mysql_fetch_assoc($slc_seq);
          $runingno=($row['inv_no']+1);
          $new=$row['inv_type']."-".substr($row['inv_year'], 2).str_pad($row['inv_mth'], 2,"0",STR_PAD_LEFT).str_pad($runingno, 4,"0",STR_PAD_LEFT);
          $query_cek=mysql_query("SELECT count(pur_inv_no) as count from veh_prh where pur_inv_no='".$new."' ");
          $row_cek=mysql_fetch_assoc($query_cek);
          $count=$row_cek['count'];
          if($count>0)
          {
          msgFailed($id,$field1,$$field1,'Nomor Faktur sudah ada');
          exit;
          }
          $ins_seq=mysql_query("update inv_seq set inv_year=YEAR(now()), inv_mth=MONTH(now()), inv_no='".$runingno."' where inv_type='".$keyword."' ");
          if(mysql_affected_rows()==0){
          echo '{"success":false,"message":"gagal update no invoice"}';
          exit;
          }
          $dateString = "20150924-03"; // get Last entry's date from database. ( date("Ymd"). Ex. 20150424-03
          $m1 = (int)substr($dateString,4,2); // $dtData[0] = date part, $dtData[1] = Prefix part

          //$month1 = date("m",strtotime($dtData[0]))

          $lenprefix = 3;
          $lenrunning = 4;
          //$today = date("ym");
          $y = date("y");
          //$m1=date("m");
          $sql = "SELECT ifnull(a.new,0) as new from (SELECT max($field1) as new from $table where left($field1,$lenprefix)=left('".$keyword."',$lenprefix))a";
          $result = mysql_query($sql);
          $row=mysql_fetch_array($result);
          //echo json_encode($row);//$row['n_count']; //AD017 >> VPO-15070126
          $m1=substr($row['new'],6,2);
          $m1=sprintf("%02d", $m1);
          $m2=date("m");
          $sql = "SELECT upper(left('$keyword',3)) as prefix,right('".$row['new']."',$lenrunning)+1 as new";
          $result = mysql_query($sql);
          $row=mysql_fetch_array($result);
          //echo json_encode($row);
          $suffix=(($m2-$m1) == 0) ?str_pad($row['new'],$lenrunning,"0",STR_PAD_LEFT) : str_pad(1,$lenrunning,"0",STR_PAD_LEFT);
          $new = $row['prefix']."-".$y.$m2.$suffix;
          echo $new; */
    }

    if ($func == 'podelete') {
        $pono = $_GET["pono"];
        $pinv = $_GET["pinv"];
        $clsdt = $_GET["clsdt"];
        $qry_chk = "SELECT cls_date, stk_date from veh_prh where pur_inv_no='" . $pinv . "'";
        $hsl_chk = mysql_query($qry_chk);
        $row = mysql_fetch_assoc($hsl_chk);
        $cls_date = $row['cls_date'];
        $stk_date = $row['stk_date'];
        if ($cls_date != '0000-00-00' && $stk_date != '0000-00-00') {
            echo '{"success":false,"message":"this invoice has been closed and cannot be edited."}';
            exit;
        }
        if ($clsdt != null) {
            echo '{"success":false,"message":"this invoice has been closed and cannot be edited."}';
            exit;
        }
        $query1 = "UPDATE veh_po set pur_inv_no=null where po_no='" . $pono . "'";
        $hasil1 = mysql_query($query1);
        $query2 = "UPDATE veh_poo set pur_inv_no=null where po_no='" . $pono . "'";
        $hasil2 = mysql_query($query2);
        $query3 = "UPDATE veh_prh set 
				po_no=null,		veh_name=null,		veh_code=null, 		veh_type=null,		veh_model=null,	
				chassis=null,	engine=null,		color_code=null,	color_name=null,	po_date=null,
				veh_brand=null, veh_transm=null,	veh_year=null,		color_type=null,	qty=null,
				unit=null,		supp_name=null,		supp_code=null,		wrhs_code=null, 	loc_code=null,
				note=null,	 	pred_stk_d=null, 	alarm=null, 		key_no=null, 		serv_book=null,
				stdoptcode=null,po_made_by=null, 	po_appr_by=null,	po_desc=null, 		pur_base=null,
				pur_opt=null,	pur_bt=null,		pur_pbm=null,		pur_vat=null,		pur_pph=null,
				pur_misc=null,	pur_price=null,		due_day=null
				WHERE pur_inv_no='" . $pinv . "'";
        $hasil3 = mysql_query($query3);
        $sql = "SELECT count(id) as n_count,id from veh_prh where pur_inv_no = '" . $pinv . "' ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $count = $row['n_count'];
        $id = $row['id'];
        if ($count >> 0) {
            echo '{"success":true,"total":"' . $count . '","message":"PO in ' . $pinv . ' Has been deleted successfully","id":"' . $id . '"}';
            return;
        } else {
            echo '{"success":false,"message":"' . $pinv . ' deletion cancelled","id":"' . $id . '"}';
            return;
        }
    }

    if ($func == 'cekpur') {
        $pono = $_GET["pono"];
        $qry_chk_pur = "SELECT pur_price from veh_prh where po_no='" . $pono . "'";
        $hsl_chk_pur = mysql_query($qry_chk_pur);
        $row = mysql_fetch_assoc($hsl_chk_pur);
        $pur_price = $row['pur_price'];
        if ((strlen($pur_price) == 0)) {
            echo '{"empty":true,"message":"Price detail NOT found.<br/>Import vehicle price from vehicle price master?"}';
            exit;
        } else {
            echo '{"empty":false,"message":" Price detail found.<br/>Do you still want to import vehicle price from vehicle price master?"}';
            exit;
        }
    }

    if ($func == 'rstpur') {
        $vcode = $_GET["vcode"];
        $coltp = $_GET["coltp"];
        $qry = "SELECT purb_price, puro_price, pur_pbm, pur_vat, pur_pph, pur_misc, pur_price FROM veh_prc WHERE veh_code='" . $vcode . "' and col_type='" . $coltp . "' ";
        $hsl_qry = mysql_query($qry);
        $row = mysql_fetch_assoc($hsl_qry);
        echo json_encode($row);
    }
}

if ($func == 'update2') {
    IsiGakBolehKosong($unit_price, "Please input Unit Price.");
    $sql = "SELECT count(id) as n_count from $table where pur_inv_no = '" . $pur_inv_no . "' ";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    $count = $row['n_count'];
    if ($count == 0) {

        msgFailed($id, $field1, $$field1, 'Record not found');
        return;
    } else {
        $pred_stk_d = (empty($pred_stk_d)) ? '0000-00-00' : date("Ymd", strtotime($pred_stk_d));
        $sji_date = (empty($sji_date)) ? '0000-00-00' : date("Ymd", strtotime($sji_date));
        $kwiti_date = (empty($kwiti_date)) ? '0000-00-00' : date("Ymd", strtotime($kwiti_date));
        $fpi_date = (empty($fpi_date)) ? '0000-00-00' : date("Ymd", strtotime($fpi_date));
        $dni_date = (empty($dni_date)) ? '0000-00-00' : date("Ymd", strtotime($dni_date));
        $do_date = (empty($do_date)) ? '0000-00-00' : date("Ymd", strtotime($do_date));
        $pdi_date = (empty($pdi_date)) ? '0000-00-00' : date("Ymd", strtotime($pdi_date));
        $due_date = (empty($due_date)) ? '0000-00-00' : date("Ymd", strtotime($due_date));

        $query_update = "UPDATE veh_prh SET 
					
						note='" . $note . "',				alarm='" . $alarm . "',				key_no='" . $key_no . "',
						serv_book='" . $serv_book . "',		sji_no='" . $sji_no . "',			sji_date='" . $sji_date . "',		
						kwiti_no='" . $kwiti_no . "',		kwiti_date='" . $kwiti_date . "',	fpi_no='" . $fpi_no . "',	
						fpi_date='" . $fpi_date . "',		dni_no='" . $dni_no . "',			dni_date='" . $dni_date . "',		
						do_no='" . $do_no . "',				do_date='" . $do_date . "',			pdi_no='" . $pdi_no . "',		
						pdi_date='" . $pdi_date . "',		alarm='" . $alarm . "',				key_no='" . $key_no . "',	
						serv_book='" . $serv_book . "',		po_made_by='" . $po_made_by . "',	po_appr_by='" . $po_appr_by . "',
						po_desc='" . $po_desc . "',			unit_price='" . $unit_price . "',	tot_price='" . $tot_price . "',		
						pur_base='" . $pur_base . "',		pur_opt='" . $pur_opt . "',			pur_bt='" . $pur_bt . "',
						pur_pbm='" . $pur_pbm . "',			pur_vat='" . $pur_vat . "',			pur_pph='" . $pur_pph . "',
						pur_misc='" . $pur_misc . "',		pur_price='" . $pur_price . "',		due_day='" . $due_day . "',
						due_date='" . $due_date . "'
						WHERE pur_inv_no='" . $pur_inv_no . "' ";
        $result1 = mysql_query($query_update);
        if (mysql_affected_rows() == 1) {
            msgSuccess($id, $field1, $$field1, 'Record updated');
            return;
        } else {
            msgFailed($id, $field1, $$field1, 'Update Failed');
            return;
        }
    }
}

if ($func == 'finddata') {
    $dtl = 0;
    $sal_inv_no = $_POST['sal_inv_no'];
    $sal_date = explode('/', $_POST['sal_date']);

    $year = $sal_date[2];
    $mounth = $sal_date[1];

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
    $periodselect = strtotime($year . $mounth);

    if ($periodselect < $period) {
        $dbs = $db1 . '_pr' . $year . $mth;
    } else {
        $dbs = $db1;
    }

    if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$dbs' ")))) {
        $statsql = "select * from " . $dbs . ".veh_slh where sal_inv_no='$sal_inv_no' limit 1";

        $result = mysql_query($statsql) or die(mysql_error());

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_assoc($result) or die(mysql_error());
           
            $rows = array('status' => true, 'data' => $row);
        }
    }else{
        $rows = array('status' => false, 'msg' => 'Data not found');
    }
    
    echo json_encode($rows);
}
?>
