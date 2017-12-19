<?php

/*
  Modul			:	Pelunasan Piutang Kendaraan (Detail Pembayaran)
  Cara pakai  	:	http://localhost:88/ver2/services/runCRUD.php?lookup=trx/veh_dpcd&func=select&query=VSL-15040001
  Keterangan		: 	func -> Function

 */
$table = 'veh_dpcd';
$msg = '';
$success = 'false';
if (isset($func)) {
    if ($func == 'reccount') {
        $result = "select * from $table where 1=1 ";
        $sql = "select count($dp_inv_no) as n_count,max(id) as max_id from ($result) ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo json_encode($row); //$row['n_count'];
    }
    if ($func == 'read') {
        include "navigation.php";
        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "select $defaultfields,IF(posted=1,pay_val,0) as pay_valp ,IF(posted=1,0,pay_val) as pay_valc  from $table where 1=1 ";

        if (isset($query)) {
            $result .= " AND (dp_inv_no like '%$query%')";
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
        $sql = "select count(dp_inv_no) as n_count from ($result) a ";
        //echo $result;
        $result = mysql_query($result);

        $table = array();
        while ($row = mysql_fetch_object($result)) {
            //$table[]=$row;
            // unset($row);

            if ($row->posted == 1) {
                $posted = $row->pay_val;
                $current = 0;
            } else {
                $posted = 0;
                $current = $row->pay_val;
            }


            $table[] = array(
                'pay_date' => $row->pay_date,
                'pay_type' => $row->pay_type,
                'bank_code' => $row->bank_code,
                'check_no' => $row->check_no,
                'check_date' => $row->check_date,
                'due_date' => $row->due_date,
                'posted' => $posted,
                'current' => $current,
                'used_val' => $row->pay_val - $row->pay_val,
                'pay_desc' => $row->pay_desc
            );
        }


        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo '{"total":"' . $row['n_count'] . '","rows":' . json_encode($table) . '}';
    }
    if ($func == 'create') {
        IsiGakBolehKosong($check_no, "Please input Cheque No. ");
        IsiGakBolehKosong($pay_date, "Please input Payment Date");
        IsiGakBolehKosong($due_date, "Please input TOP Date");
        IsiGakBolehKosong($pay_val, "Please input DP Value");
        IsiGakBolehKosong($payer_name, "Please input Payer Name");
        IsiGakBolehKosong($payer_addr, "Please input Payer Address");
        $sql = "select * from veh_dpcd where dp_inv_no = '$dp_inv_no' and check_no = '$check_no'";
        $result = mysql_query($sql);
        $row = mysql_num_rows($result);
        if ($row >> 0) {
            echo '{"success":false,"message":"Sorry, payment with Cheque No.: ' . $check_no . ' exists in this invoice."}';
            return;
        }
        $len = strlen($pay_val);
        if ($pay_val <= 0) {
            echo '{"success":false,"message":"Please check your DP value"}';
            exit;
        }


        /* if(strtotime($pay_date) !== strtotime(date('Y-m-d')) ){
          echo '{"success":false,"message":"Maaf, tanggal pembayaran harus sama dengan tanggal hari ini"}';
          exit;
          } */
        //IsiGakBolehKosong($payer_area,"Area Pembayar belum diisi");
        //IsiGakBolehKosong($payer_city,"Kota Pembayar belum diisi");
        //echo '{"success":true}';
        $pay_val = str_replace(',', '', $pay_val);
        $add_by = '';
        $coll_code = '';


        $pay_bt = round($pay_val * 0.9, 0);
        $pay_vat = $pay_val - $pay_bt;

        $pay_date = explode('/', $pay_date);
        $pay_date = $pay_date[2] . '-' . $pay_date[1] . '-' . $pay_date[0];

        $check_date = explode('/', $check_date);
        $check_date = $check_date[2] . '-' . $check_date[1] . '-' . $check_date[0];

        $due_date = explode('/', $due_date);
        $due_date = $due_date[2] . '-' . $due_date[1] . '-' . $due_date[0];

        $dp_date = explode('/', $dp_date);
        $dp_date = $dp_date[2] . '-' . $dp_date[1] . '-' . $dp_date[0];


        $so_date = explode('/', $so_date);
        $so_date = $so_date[2] . '-' . $so_date[1] . '-' . $so_date[0];


        $sql = "insert into veh_dpcd (dp_inv_no,dp_date,so_no,so_date,bank_code,
		pay_date,pay_type,check_no,check_date,due_date,pay_val,pay_desc,
		coll_code,add_by,add_date,pay_bt,pay_vat,payer_name,payer_addr,payer_area,payer_city,payer_zipc,wrhs_code, posted, edc_code) 
		values ('$dp_inv_no','$dp_date','$so_no','$so_date','$bank_code',
		'$pay_date','$pay_type','$check_no','$check_date','$due_date',$pay_val,'$pay_desc',
		'$coll_code','$add_by',curdate(),$pay_bt,$pay_vat,'$payer_name','$payer_addr','$payer_area','$payer_city','$payer_zipc','$wrhs_code', '0', '$edc_code')";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        $sql = "update veh_dpch set dp_paid = dp_paid + $pay_val where dp_inv_no = '$dp_inv_no'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        $sql = "update veh_dpch set dp_end = dp_begin+dp_paid-dp_used where dp_inv_no = '$dp_inv_no'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        echo '{"success":true}';
    }
    if ($func == 'update') {
        echo '{"success":false,"message":"Please use delete button"}';
    }
    if ($func == 'delete') {

        //$sql = "select * from veh_dpcd where id='$id' and dp_inv_no = '$dp_inv_no' and check_no = '$check_no'";
        $sql = "select * from veh_dpcd where id='$id'";
        $result = mysql_query($sql);
        $row = mysql_num_rows($result);
        if ($row == 0) {
            $msg = array('success' => false, 'message' => "Record not found.");
            echo json_encode($msg);
            exit;
        }
        $row = mysql_fetch_assoc($result);
        //print_r($row);exit;
        if ($row['posted'] == 1) {
            $msg = array('success' => false, 'message' => "Sorry, this payment is included in the previous period and can\'t be deleted.");
            echo json_encode($msg);
            exit;
        }
        $len = strlen($row['fp_no']);
        if ($len >> 0) {
            $msg = array('success' => false, 'message' => "Sorry, a Tax Invoice has been issued for this Payment.");
            echo json_encode($msg);
            exit;
        }
        $len = strlen($row['sal_inv_no']);
        if ($len >> 0 || $row['used_val'] <> 0) {
            if (substr($row['sal_inv_no'], 1, 3) == 'VRD') {

                $msg = array('success' => false, 'message' => "Sorry, this invoice has been cancelled in " . $row['sal_inv_no'] . "");
            } else {
                $msg = array('success' => false, 'message' => "Sorry, this payment is used in Account Receivable Payment No. " . $row['sal_inv_no'] . "");
            }
            echo json_encode($msg);
            exit;
        }
        $len = strlen($row['tts_no']);
        /* if ($len>>0 && $username <> 'SUPERVISOR')
          {
          $msg = array('success' => false, 'message' => "Maaf, untuk menghapus Tanda Terima yang sudah dicetak harus user SUPERVISOR.");
          echo json_encode($msg);
          exit;
          } */

        $sql = "update veh_dpch set dp_paid = dp_paid - $row[pay_val] where dp_inv_no = '$dp_inv_no'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        $sql = "update veh_dpch set dp_end = dp_begin+dp_paid-dp_used where dp_inv_no = '$dp_inv_no'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }


        $sql = "delete from veh_dpcd where id = '$id'";
        $result = mysql_query($sql);
        if (!$result) {
            $message = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        $msg = array('success' => true, 'message' => "$check_no has been deleted successfully");
        echo json_encode($msg);
    }
}
?>