<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Bbn extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function save() {
        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        //unset($data['cls_date']);
        unset($data['inv_type']);

        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }
        if (!empty($data['wo_date'])) {
            $data['wo_date'] = $this->dateFormat($data['wo_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['quote_date'])) {
            $data['quote_date'] = $this->dateFormat($data['quote_date']);
        }
        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }
        if (!empty($data['prcvd_date'])) {
            $data['prcvd_date'] = $this->dateFormat($data['prcvd_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['pur_date'])) {
            $data['pur_date'] = $this->dateFormat($data['pur_date']);
        }
        if (!empty($data['rcv_date'])) {
            $data['rcv_date'] = $this->dateFormat($data['rcv_date']);
        }
        if (!empty($data['sj_date'])) {
            $data['sj_date'] = $this->dateFormat($data['sj_date']);
        }
        if (!empty($data['supp_invdt'])) {
            $data['supp_invdt'] = $this->dateFormat($data['supp_invdt']);
        }

        $stat = true;

        if ($table == 'veh_bwoh') {
            if ($data['prep_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Customer Name & Code');
            }
            if ($data['agent_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Agent Code & Name');
            }


            $fieldunique = 'wo_no';
            $inv_type = 'ABW';
        }

        if ($table == 'veh_bprh') {
            if ($data['agent_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Agent Code & Name');
            }
            $fieldunique = 'pur_inv_no';
            $inv_type = 'APB';
        }

        $data['supp_code'] = $data['agent_code'];
        $data['supp_name'] = $data['agent_name'];
        unset($data['agent_code']);
        unset($data['agent_name']);

        if ($stat !== false) {
            if ($id !== '') {

                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {

                unset($data[$fieldunique]);
                $data[$fieldunique] = $this->all_m->inv_seq('4', $inv_type);
                $check = $this->all_m->insertData($table, $data);
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function delete() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $row = $this->all_m->getId($table, 'id', $id);

        if ($table == 'veh_bwoh') {
            $table2 = 'veh_bwod';
            $fieldunique = 'wo_no';
            $inv_type = 'ABW';
        }


        if ($table == 'veh_bprh') {
            $table2 = 'veh_bprd';
            $fieldunique = 'pur_inv_no';
            $inv_type = 'APB';
        }

        $count = $this->all_m->countlimit($table2, array($fieldunique => $row->$fieldunique));

        if ($count >> 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);

            $number = $this->all_m->getId('inv_seq', 'inv_type', $inv_type);
            $num = $number->inv_no - 1;
            $this->all_m->updateData('inv_seq', 'inv_type', $inv_type, array('inv_no' => $num));

            $count = $this->all_m->countlimit($table, array('id' => $id));

            if ($count >> 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete Success');
            }
        }

        $this->json($msg);
    }

    function save_bwod() {
        $wo_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $table = $this->input->post('table2');

        $data = $this->input->post();
        
        $db = '';
        
        unset($data['id2']);
        unset($data['table2']);
        
        if($data['data'] == '2'){
            $veh = $this->all_m->getId('veh', 'sal_inv_no', $data['sal_inv_no']);
            $date = explode('-', $veh->sal_date);
            $db = $this->getDataHistory($date['0'], $date['1']);
            
            $db = $db.'.';
        }

        if ($data['chassis'] !== '') {
            $check = $this->all_m->countlimit($table, array('wo_no' => $wo_no, 'chassis' => $data['chassis']));

            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
            } else {
                $veh_bwoh = $this->all_m->getId('veh_bwoh', 'wo_no', $wo_no);

                $tot_price = intval($veh_bwoh->tot_price) + intval($this->input->post('price_ad'));
                $dpp = $tot_price - intval($veh_bwoh->inv_disc);
                // $ppn = ($dpp / 100) * 10;
                $ppn = 0;
                $inv_at = $dpp + $ppn;

                $data_bwoh = array(
                    'tot_item' => $veh_bwoh->tot_item + 1,
                    'tot_price' => $tot_price,
                    'inv_bt' => $dpp,
                    'inv_vat' => $ppn,
                    'inv_at' => $inv_at,
                    'inv_total' => $inv_at + intval($veh_bwoh->inv_stamp)
                );

                $veh_slh = $this->all_m->getId($db.'veh_slh', 'sal_inv_no', $data['sal_inv_no']);
                
                $data_slh = array(
                    'bbnwo_no' => $wo_no,
                    'bbnwo_prc' => $data['price_ad']
                );

                $data['cust_code'] = $veh_slh->cust_code;
                $data['cust_type'] = $veh_slh->cust_type;
                $data['srep_code'] = $veh_slh->srep_code;
                $data['engine'] = $veh_slh->engine;
                $data['color_code'] = $veh_slh->color_code;
                $data['veh_code'] = $veh_slh->veh_code;

                $data['veh_brand'] = $veh_slh->veh_brand;
                $data['veh_type'] = $veh_slh->veh_type;
                $data['veh_model'] = $veh_slh->veh_model;
                $data['veh_year'] = $veh_slh->veh_year;
                $data['veh_transm'] = $veh_slh->veh_transm;
                $data['wrhs_code'] = $veh_slh->wrhs_code;

                $data['wo_no'] = $wo_no;
                $data['pick_date'] = $veh_slh->pick_date;
                $data['qty'] = 1;
                $data['add_by'] = $user;
                $data['add_date'] = date('Y-m-d');

                $this->all_m->insertData($table, $data);
                $this->all_m->updateData($db.'veh_slh', 'sal_inv_no', $data['sal_inv_no'], $data_slh);
                
                if($data['data'] == '2'){
                    $this->all_m->updateData('veh', 'sal_inv_no', $data['sal_inv_no'], $data_slh);
                }
                
                $this->all_m->updateData('veh_bwoh', 'wo_no', $wo_no, $data_bwoh);
                $msg = array('success' => true, 'message' => 'Record saved');
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Chassis No.');
        }

        $this->json($msg);
    }

    function delete_bwod() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $veh_bwod = $this->all_m->getId($table, 'id', $id);
        
        $db = '';
        
        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkbwoh = $this->all_m->countlimit('veh_bwoh', array('wo_no' => $veh_bwod->wo_no));
        
        if($veh_bwod->data == '2'){
            $veh = $this->all_m->getId('veh', 'sal_inv_no', $veh_bwod->sal_inv_no);
            $date = explode('-', $veh->sal_date);
            $db = $this->getDataHistory($date['0'], $date['1']);
            
            $db = $db.'.';
            
        }

        if ($check > 0) {
            $stat = true;
        }
        if ($checkbwoh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $veh_bwoh = $this->all_m->getId('veh_bwoh', 'wo_no', $veh_bwod->wo_no);

            $total = $veh_bwod->price_ad * $veh_bwod->qty;

            $tot_price = intval($veh_bwoh->tot_price) - intval($total);
            $dpp = $tot_price - intval($veh_bwoh->inv_disc);
            //$ppn = ($dpp / 100) * 10;
            $ppn = 0;
            $inv_at = $dpp + $ppn;

            $data_bwoh = array(
                'tot_item' => $veh_bwoh->tot_item - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($veh_bwoh->inv_stamp)
            );

            $data_slh = array(
                'bbnwo_no' => '',
                'bbnwo_prc' => 0
            );

            $this->all_m->updateData($db.'veh_slh', 'sal_inv_no', $veh_bwod->sal_inv_no, $data_slh);
             if($veh_bwod->data == '2'){
                 $this->all_m->updateData('veh', 'sal_inv_no', $veh_bwod->sal_inv_no, $data_slh);
             }
            $this->all_m->updateData('veh_bwoh', 'id', $veh_bwoh->id, $data_bwoh);
            $this->all_m->deleteData($table, 'id', $id);

            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closeWO() {
        $user = $this->uri->segment(4);

        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
       

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }
        if ($msg['success'] !== false) {
            if (!empty($data['cls_date'])) {
                $data['cls_date'] = $this->dateFormat($data['cls_date']);
            }
            if (!empty($data['wo_date'])) {
                $data['wo_date'] = $this->dateFormat($data['wo_date']);
            }
            if (!empty($data['opn_date'])) {
                $data['opn_date'] = $this->dateFormat($data['opn_date']);
            }
            if (!empty($data['quote_date'])) {
                $data['quote_date'] = $this->dateFormat($data['quote_date']);
            }
            if (!empty($data['cls_date'])) {
                $data['cls_date'] = $this->dateFormat($data['cls_date']);
            }
            if (!empty($data['prcvd_date'])) {
                $data['prcvd_date'] = $this->dateFormat($data['prcvd_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }
            if (!empty($data['pur_date'])) {
                $data['pur_date'] = $this->dateFormat($data['pur_date']);
            }
            if (!empty($data['rcv_date'])) {
                $data['rcv_date'] = $this->dateFormat($data['rcv_date']);
            }
            if (!empty($data['sj_date'])) {
                $data['sj_date'] = $this->dateFormat($data['sj_date']);
            }
            if (!empty($data['supp_invdt'])) {
                $data['supp_invdt'] = $this->dateFormat($data['supp_invdt']);
            }


            $data['supp_code'] = $data['agent_code'];
            $data['supp_name'] = $data['agent_name'];

            unset($data['agent_code']);
            unset($data['agent_name']);

            $veh_bwoh = $this->all_m->getId('veh_bwoh', 'wo_no', $data['wo_no']);
            $bwoh = (array) $veh_bwoh;
            unset($bwoh['id']);

            $check_bwod = $this->all_m->countlimit('veh_bwod', array('wo_no' => $data['wo_no']));

            if ($check_bwod < 1) {
                $msg = array('success' => false, 'message' => 'WO cannot be closed because it has no transaction');
            } else {

                $data['cls_date'] = $date;
                $data['cls_by'] = $user;
                $data['wo_date'] = $date;



                $sql_vehbwooh = "SHOW COLUMNS FROM vehbwooh";
                $vehbwooh = $this->all_m->query_all($sql_vehbwooh);

                foreach ($vehbwooh as $bwooh) {
                    $field_vehbwooh[$bwooh->Field] = '';
                }
                unset($field_vehbwooh['id']);


                foreach ($bwoh as $k => $v) {

                    if (array_key_exists($k, $field_vehbwooh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_vehbwooh = array_combine($key, $val);

                $veh_bwod = $this->all_m->getWhere('veh_bwod', array('wo_no' => $data['wo_no']));

                $n = 1;
                $data_bwod = array();
                foreach ($veh_bwod as $bwod) {

                    $data_bwod = (array) $bwod;
                    unset($data_bwod['id']);
                    unset($data_bwod['data']);
                    $data_bwod['wor_date'] = $date;
                    $data_bwod['wor_line'] = $n;
                    $data_bwod['wo_date'] = $date;

                    $data_bwod['beg_qty'] = $bwod->qty;
                    $data_bwod['rcv_qty'] = 0;
                    $data_bwod['end_qty'] = $bwod->qty;

                    $this->all_m->insertData('vehbwood', $data_bwod);
                    $this->all_m->updateData('veh_bwod', 'id', $bwod->id, array('wo_date' => $date, 'wor_date' => $date, 'wor_line' => $n));

                    $n++;
                }

                $this->all_m->insertData('vehbwooh', $newdata_vehbwooh);
                $this->all_m->updateData($table, 'id', $id, $data);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function uncloseWO() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $data['supp_code'] = $data['agent_code'];
        $data['supp_name'] = $data['agent_name'];

        unset($data['agent_code']);
        unset($data['agent_name']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            $update['cls_date'] = $date;
            $update['cls_by'] = '';
            $update['wo_date'] = $date;

            $stat = true;

            $check_bprh = $this->all_m->countlimit('veh_bprh', array('wo_no' => $data['wo_no']));

            if ($check_bprh > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'WO no. has been used in BBN Registration');
            }

            if ($stat !== false) {
                $acc_worh = (array) $this->all_m->getId($table, 'id', $id);
                $veh_bwod = $this->all_m->getWhere('veh_bwod', array('wo_no' => $data['wo_no']));

                foreach ($veh_bwod as $bwod) {
                    $this->all_m->deleteData('vehbwood', 'wo_no', $bwod->wo_no);
                    $this->all_m->updateData('veh_bwod', 'id', $bwod->id, array('wo_date' => '0000-00-00', 'wor_date' => '0000-00-00', 'wor_line' => 0));
                }

                $this->all_m->deleteData('vehbwooh', 'wo_no', $data['wo_no']);
                $this->all_m->updateData($table, 'id', $id, $update);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = $msg;
            }
        }
        $this->json($msg);
    }

    function save_bprd() {
        $date = date('Y-m-d');
        $pur_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $bwood_id = $data['bwood_id'];


        unset($data['table2']);
        unset($data['id2']);
        unset($data['bwood_id']);


        $bwood = (array) $this->all_m->getId('vehbwood', 'id', $bwood_id);
        $bwood_id = $bwood['id'];
        unset($bwood['id']);

        $data_bwood['rcv_qty'] = $bwood['rcv_qty'] + 1;
        $data_bwood['end_qty'] = $bwood['beg_qty'] - ($bwood['rcv_qty'] + 1);


        // print_r($wood);exit;
        $sql_veh_bprd = "SHOW COLUMNS FROM veh_bprd";
        $veh_bprd = $this->all_m->query_all($sql_veh_bprd);

        foreach ($veh_bprd as $bprd) {
            $field_veh_bprd[$bprd->Field] = '';
        }
        unset($field_veh_bprd['id']);


        foreach ($bwood as $k => $v) {

            if (array_key_exists($k, $field_veh_bprd)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        $data_veh_bprd = array_combine($key, $val);


        $data_veh_bprd['pur_inv_no'] = $pur_inv_no;
        $data_veh_bprd['add_by'] = $user;
        $data_veh_bprd['add_date'] = $date;

        if ($data['price_bd']) {
            $data_veh_bprd['price_bd'] = $data['price_bd'];
            $data_veh_bprd['disc_pct'] = $data['disc_pct'];
            $data_veh_bprd['disc_val'] = $data['disc_val'];
            $data_veh_bprd['price_ad'] = $data['price_ad'];
        }

        //print_r($maccs);exit;
        if ($data['chassis'] !== '') {

            $check = $this->all_m->countlimit($table, array('pur_inv_no' => $pur_inv_no, 'chassis' => $data['chassis']));

            if ($id !== '') {
                if ($check > 1) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
                } else {

                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                }
            } else {
                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
                } else {

                    $veh_bprh = $this->all_m->getId('veh_bprh', 'pur_inv_no', $pur_inv_no);
                    $total_price = $data['price_ad'];
                    $tot_price = intval($veh_bprh->tot_price) + intval($total_price);
                    $dpp = $tot_price - intval($veh_bprh->inv_disc);
                    //$ppn = ($dpp / 100) * 10;
                    $ppn = 0;
                    $inv_at = $dpp + $ppn;

                    $data_bprh = array(
                        'tot_item' => $veh_bprh->tot_item + 1,
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($veh_bprh->inv_stamp)
                    );

                    $data_slh = array(
                        'bbnpur_no' => $pur_inv_no,
                        'bbnpur_prc' => $data['price_ad']
                    );

                    $this->all_m->updateData('veh_slh', 'sal_inv_no', $bwood['sal_inv_no'], $data_slh);
                    $this->all_m->updateData('vehbwood', 'id', $bwood_id, $data_bwood);
                    $this->all_m->updateData('veh_bprh', 'id', $veh_bprh->id, $data_bprh);

                    $this->all_m->insertData($table, $data_veh_bprd);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function delete_bprd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_bprd = $this->all_m->getId($table, 'id', $id);
        $data = (array) $veh_bprd;

        $vehbwood = (array) $this->all_m->getOne('vehbwood', array('wo_no' => $veh_bprd->wo_no, 'chassis' => $veh_bprd->chassis));

        $data_bwood['rcv_qty'] = $vehbwood['rcv_qty'] - 1;
        $data_bwood['end_qty'] = $vehbwood['beg_qty'] + ($vehbwood['rcv_qty'] - 1);


        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkbprh = $this->all_m->countlimit('veh_bprh', array('pur_inv_no' => $veh_bprd->pur_inv_no));
        $checkvehbwood = $this->all_m->countlimit('vehbwood', array('wo_no' => $veh_bprd->wo_no, 'chassis' => $veh_bprd->chassis));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkbprh > 0) {
            $stat = true;
        }
        if ($checkvehbwood > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $veh_bprh = $this->all_m->getId('veh_bprh', 'pur_inv_no', $veh_bprd->pur_inv_no);

            $total_price = $veh_bprd->price_ad;

            $tot_price = intval($veh_bprh->tot_price) - $total_price;
            $dpp = $tot_price - intval($veh_bprh->inv_disc);
            // $ppn = ($dpp / 100) * 10;
            $ppn = 0;
            $inv_at = $dpp + $ppn;

            $data_bprh = array(
                'tot_item' => $veh_bprh->tot_item - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($veh_bprh->inv_stamp)
            );

            $data_slh = array(
                'bbnpur_no' => '',
                'bbnpur_prc' => ''
            );

            $this->all_m->updateData('veh_slh', 'sal_inv_no', $vehbwood['sal_inv_no'], $data_slh);
            $this->all_m->updateData('vehbwood', 'id', $vehbwood['id'], $data_bwood);
            $this->all_m->updateData('veh_bprh', 'id', $veh_bprh->id, $data_bprh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function close_regbbn() {
        $user = $this->uri->segment(4);

        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($msg['success'] !== false) {
            if (!empty($data['cls_date'])) {
                $data['cls_date'] = $this->dateFormat($data['cls_date']);
            }
            if (!empty($data['wo_date'])) {
                $data['wo_date'] = $this->dateFormat($data['wo_date']);
            }
            if (!empty($data['opn_date'])) {
                $data['opn_date'] = $this->dateFormat($data['opn_date']);
            }
            if (!empty($data['quote_date'])) {
                $data['quote_date'] = $this->dateFormat($data['quote_date']);
            }
            if (!empty($data['cls_date'])) {
                $data['cls_date'] = $this->dateFormat($data['cls_date']);
            }
            if (!empty($data['prcvd_date'])) {
                $data['prcvd_date'] = $this->dateFormat($data['prcvd_date']);
            }
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }
            if (!empty($data['pur_date'])) {
                $data['pur_date'] = $this->dateFormat($data['pur_date']);
            }
            if (!empty($data['rcv_date'])) {
                $data['rcv_date'] = $this->dateFormat($data['rcv_date']);
            }
            if (!empty($data['sj_date'])) {
                $data['sj_date'] = $this->dateFormat($data['sj_date']);
            }
            if (!empty($data['supp_invdt'])) {
                $data['supp_invdt'] = $this->dateFormat($data['supp_invdt']);
            }
            $data['supp_code'] = $data['agent_code'];
            $data['supp_name'] = $data['agent_name'];

            unset($data['agent_code']);
            unset($data['agent_name']);



            $check_bprd = $this->all_m->countlimit('veh_bprd', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check_bprd < 1) {
                $msg = array('success' => false, 'message' => 'WO cannot be closed because it has no transaction');
            } else {
                $veh_bprh = $this->all_m->getId($table, 'id', $id);

                $veh_bprd = $this->all_m->getWhere('veh_bprd', array('pur_inv_no' => $data['pur_inv_no']));

                foreach ($veh_bprd as $bprd) {
                    $this->all_m->updateData('veh_bprd', 'id', $bprd->id, array('pur_date' => $date));
                }

                $update['cls_date'] = $date;
                $update['cls_by'] = $user;
                $update['pur_date'] = $date;
                $update['cls_cnt'] = $veh_bprh->cls_cnt + 1;



                $sql_aph = "SHOW COLUMNS FROM acc_aph";
                $acc_aph = $this->all_m->query_all($sql_aph);

                foreach ($acc_aph as $aph) {
                    $field_acc_aph[$aph->Field] = '';
                }
                unset($field_acc_aph['id']);

                $bprh = (array) $veh_bprh;

                foreach ($bprh as $k => $v) {

                    if (array_key_exists($k, $field_acc_aph)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_acc_aph = array_combine($key, $val);
                $newdata_acc_aph['cls_date'] = $date;
                $newdata_acc_aph['pur_inv_no'] = $veh_bprh->pur_inv_no;
                $newdata_acc_aph['pur_date'] = $date;

                $newdata_acc_aph['inv_bt'] = $veh_bprh->inv_bt;
                $newdata_acc_aph['inv_vat'] = $veh_bprh->inv_vat;
                $newdata_acc_aph['inv_stamp'] = $veh_bprh->inv_stamp;
                $newdata_acc_aph['inv_total'] = $veh_bprh->inv_total;
                
                $newdata_acc_aph['hd_begin'] = $veh_bprh->inv_total;
                $newdata_acc_aph['hd_paid'] = 0;
                $newdata_acc_aph['hd_disc'] = 0;
                $newdata_acc_aph['hd_end'] = $veh_bprh->inv_total;
                $newdata_acc_aph['pinv_code'] = 'APB';


                $check = $this->all_m->insertData('acc_aph', $newdata_acc_aph);

                $this->all_m->updateData($table, 'id', $id, $update);


                $msg = array('success' => true, 'message' => 'success');
            }
        }

        $this->json($msg);
    }

    function unclose_regbbn() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        $data['supp_code'] = $data['agent_code'];
        $data['supp_name'] = $data['agent_name'];

        unset($data['agent_code']);
        unset($data['agent_name']);

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            
            $stat = true;
            
            $count = $this->all_m->countlimit($table, array('id' => $id));
            
            $check_apd = $this->all_m->countlimit('acc_apd', array('pur_inv_no' => $data['pur_inv_no']));
            $check_apgd = $this->all_m->countlimit('acc_apgd', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check_apgd > 0) {
                $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
                $stat = false;
            }
            if ($check_apd > 0) {
                $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
                $stat = false;
            }  
            if ($count < 1) {
                $stat = false;
                 $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
            
            
            if ($stat !== false) {
                
                $veh_bprh = $this->all_m->getId($table, 'id', $id);
                $update['cls_date'] = $date;
                $update['cls_by'] = '';
                $update['pur_date'] = $date;

                $veh_bprd = $this->all_m->getWhere('veh_bprd', array('pur_inv_no' => $data['pur_inv_no']));

                foreach ($veh_bprd as $bprd) {
                    $this->all_m->updateData('veh_bprd', 'id', $bprd->id, array('pur_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $update);
                $this->all_m->deleteData('acc_aph', 'pur_inv_no', $veh_bprh->pur_inv_no);

                $msg = array('success' => true, 'message' => 'success');
                
            }
            
        }
        $this->json($msg);
    }

    function check_wo() {
        $pur_inv_no = $this->input->post('pur_inv_no');
        $check_bprd = $this->all_m->countlimit('veh_bprd', array('pur_inv_no' => $pur_inv_no));
        $count = array('count' => $check_bprd);
        $this->json($count);
    }

    function outputpdf() {
        $margin = null;

        $data['tbl'] = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $data['id'] = $this->uri->segment(5);
        $data['user'] = $this->uri->segment(6);
        $action = $this->uri->segment(7);
        $data['inv_code'] = encrypt_decrypt('decrypt', $this->uri->segment(8));
        $data['inv_type'] = encrypt_decrypt('decrypt', $this->uri->segment(9));
        $data['act'] = $this->uri->segment(10);

        $prn_cnt = 'prn_cnt';

        $c_array = array();

        switch ($data['tbl']) {

            case 'veh_bwoh':

                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'WorkOrderBBN_' . $read['number'],
                    'title' => 'Work Order BBN_ ' . $read['number']
                );
                $margin = "L";

                break;

            case 'veh_bprh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'PendaftaranBBN_' . $read['number'],
                    'title' => 'Pendaftaran BBN_ ' . $read['number']
                );
                $margin = "L";
                break;
        }

        $html = $output['html'];

        if ($action !== 'screen') {
            $this->count_prnt($data, $c_array, $prn_cnt);
        }

        $this->output_pdf($output['title'], $html, $output['filename'], $action, $margin);
    }

    function readHtml($data) {
        $company = $this->all_m->query_single("select * from ssystem limit 1");
        $read = $this->all_m->getId($data['tbl'], 'id', $data['id']);
        $inv_code = $data['inv_code'];
        $inv_type = $data['inv_type'];
        $number = $read->$inv_code;

        $code_form = '';
        $html = '';

        switch ($data['tbl']) {
            case 'veh_bwoh':
                $code_form = 'ABW';
                $html .= '<table class="tables" >';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add1 . '</td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add2 . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td  width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>Rekanan/Vendor</b></td></tr>';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $read->supp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $read->saddr . '</td></tr>';
                $html .='<tr><td colspan="2">' . $read->scity . '-' . $read->scountry . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $read->sphone . '</td><td><b>Fax : </b>' . $read->sfax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';

                $html .='<br /><br />';
                $html .='<table class="tables"><tr><td><table class="tables"><tr><td><h3 style="font-size:14px;">Work Order BBN</h3></td></tr></table></td>'
                        . '<td><table class="tables" style="font-size:14px;">'
                        . '<tr><td>Nomor</td><td class="td-ro">:</td><td>' . $read->wo_no . '</td></tr>'
                        . '<tr><td>Tanggal</td><td class="td-ro">:</td><td>' . $this->dateView($read->wo_date) . '</td></tr>'
                        . '</table></td>'
                        . '</tr>'
                        . '</table>';




                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables"  width="100%">';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';
                $html .= '<tr><td width="30">No.</td><td>No. Rangka</td><td width="150">Kendaraan</td><td width="155">Pelanggan</td><td align="right">Harga</td><td align="right">Disc(%)</td><td align="right">Netto</td></tr>';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';

                $veh_bwod = $this->all_m->getWhere('veh_bwod', array('wo_no' => $read->wo_no));
                $no = 1;
                foreach ($veh_bwod as $bwod):
                    $html .= '<tr>'
                            . '<td  width="30">' . $no . '</td>'
                            . '<td>' . $bwod->chassis . '</td>'
                            . '<td>' . $bwod->veh_name . '</td>'
                            . '<td>' . $bwod->cust_name . '</td>'
                            . '<td align="right">' . number_format($bwod->price_bd) . '</td>'
                            . '<td align="right">' . number_format($bwod->disc_pct) . '</td>'
                            . '<td align="right">' . number_format($bwod->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;


                $html .= '</table>';
                $html .= '</td></tr>';

                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Sub Total:</b></td><td width="15%" align="right">' . number_format($read->inv_at) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Discount:</b></td><td width="15%" align="right">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Lain-lain:</b></td><td width="15%" align="right">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr>'
                        . '<td width="70%" valign="top">';
                if ($code_form !== '') {
                    $html .= '<table class="tables" >';
                    $html .='<tr><td>';
                    $html .= $this->set_form($code_form, $read);
                    $html .='</td></tr>';
                    $html .= '</table>';
                }
                $html .= '</td>'
                        . '<td width="15%" align="right"><b>Grand Total:</b></td>'
                        . '<td width="15%" align="right">' . number_format($read->inv_total) . '</td></tr>';
                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';
                break;

            case 'veh_bprh':
                $code_form = 'APB';
                $html .= '<table class="tables" >';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add1 . '</td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add2 . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td  width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>Rekanan/Vendor</b></td></tr>';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $read->supp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $read->saddr . '</td></tr>';
                $html .='<tr><td colspan="2">' . $read->scity . '-' . $read->scountry . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $read->sphone . '</td><td><b>Fax : </b>' . $read->sfax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';

                $html .='<br /><br />';
                $html .='<table class="tables"><tr><td width="20%"><table class="tables"><tr><td><h3 style="font-size:14px;">Pendaftaran BBN</h3></td></tr></table></td>'
                        . '<td width="40%"><table class="tables" style="font-size:13px;">'
                        . '<tr><td>Nomor</td><td class="td-ro">:</td><td>' . $read->pur_inv_no . '</td></tr>'
                        . '<tr><td>Tanggal</td><td class="td-ro">:</td><td>' . $this->dateView($read->pur_date) . '</td></tr>'
                        . '</table></td>'
                        . '<td><table style="font-size:13px;"><tr><td colspan="3"></td></tr><tr><td ><b>Keterangan</b></td><td class="td-ro">:</td><td>' . $read->note . '</td></tr></table></td>'
                        . '</tr>'
                        . '</table>';




                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';
                $html .= '<tr><td width="30">No.</td><td>No. Rangka</td><td width="150">Kendaraan</td><td width="150">Pelanggan</td><td align="right">Harga</td><td align="right">Disc(%)</td><td align="right">Netto</td></tr>';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';

                $veh_bprd = $this->all_m->getWhere('veh_bprd', array('pur_inv_no' => $read->pur_inv_no));
                $no = 1;
                foreach ($veh_bprd as $bprd):
                    $html .= '<tr>'
                            . '<td>' . $no . '</td>'
                            . '<td>' . $bprd->chassis . '</td>'
                            . '<td>' . $bprd->veh_name . '</td>'
                            . '<td>' . $bprd->cust_name . '</td>'
                            . '<td align="right">' . number_format($bprd->price_bd) . '</td>'
                            . '<td align="right">' . number_format($bprd->disc_pct) . '</td>'
                            . '<td align="right">' . number_format($bprd->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;


                $html .= '</table>';
                $html .= '</td></tr>';

                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="7"><hr /></td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Sub Total:</b></td><td width="15%" align="right">' . number_format($read->inv_at) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Discount:</b></td><td width="15%" align="right">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Lain-lain:</b></td><td width="15%" align="right">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr>'
                        . '<td width="70%" valign="top">';
                if ($code_form !== '') {
                    $html .= '<table class="tables" >';
                    $html .='<tr><td>';
                    $html .= $this->set_form($code_form, $read);
                    $html .='</td></tr>';
                    $html .= '</table>';
                }
                $html .= '</td>'
                        . '<td width="15%" align="right"  valign="top"><b>Grand Total:</b></td>'
                        . '<td width="15%" align="right"  valign="top">' . number_format($read->inv_total) . '</td></tr>';
                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';
                break;
        }


        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function check_id() {
        $table = $this->input->post('tbl');
        $inv_no = $this->input->post('inv_no');
        $field = $this->input->post('field');
        $res = $this->all_m->getId($table, $field, $inv_no);

        $this->json($res);
    }

}
