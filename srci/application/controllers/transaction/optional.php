<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Optional extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function save_optional() {
        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['cls_date']);
        unset($data['inv_type']);

        if (!empty($data['wor_date'])) {
            $data['wor_date'] = $this->dateFormat($data['wor_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['need_date'])) {
            $data['need_date'] = $this->dateFormat($data['need_date']);
        }

        if (!empty($data['wo_date'])) {
            $data['wo_date'] = $this->dateFormat($data['wo_date']);
        }
        if (!empty($data['quote_date'])) {
            $data['quote_date'] = $this->dateFormat($data['quote_date']);
        }
        if (!empty($data['prcvd_date'])) {
            $data['prcvd_date'] = $this->dateFormat($data['prcvd_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }
        if (!empty($data['so_date'])) {
            $data['so_date'] = $this->dateFormat($data['so_date']);
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
        if (!empty($data['sal_date'])) {
            $data['sal_date'] = $this->dateFormat($data['sal_date']);
        }
        if (!empty($data['snd_date'])) {
            $data['snd_date'] = $this->dateFormat($data['snd_date']);
        }



        $stat = true;

        if ($table == 'acc_worh') {

            $need_date = strtotime($data['need_date']);

            if ($data['dunit_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Unit Code');
            }
            if ($data['dept_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Department Code');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse Code');
            }
            if (intval($need_date) < intval(strtotime($date))) {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Usage date has passed, please input other date');
            }
            if ($data['need_date'] == '' || $data['need_date'] == '0000-00-00') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Usage date');
            }
            if ($data['req_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Requester Name');
            }
            if ($data['oreq_type'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Please input SPOK Type');
            }

            $fieldunique = 'wor_no';
            $inv_type = 'AWR';
        }

        if ($table == 'acc_woh') {
            if ($data['prep_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Purchaser Code & Name');
            }

            if ($data['supp_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Supplier Name & Code');
            }

            $fieldunique = 'wo_no';
            $inv_type = 'AWO';

            $check = $this->all_m->countlimit('veh_slh', array('sal_inv_no' => $data['sal_inv_no']));

            if ($check > 0) {

                $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);
                $slh = (array) $veh_slh;

                unset($slh['id']);
                unset($slh['cls_cnt']);
                unset($slh['cls_by']);
                unset($slh['cls_date']);
                unset($slh['due_day']);
                unset($slh['due_date']);
                unset($slh['opn_date']);
                unset($slh['prn_cnt']);
                unset($slh['note']);
                unset($slh['inv_stamp']);
                unset($slh['inv_total']);


                $sql_acc_woh = "SHOW COLUMNS FROM acc_woh";
                $acc_woh = $this->all_m->query_all($sql_acc_woh);

                foreach ($acc_woh as $woh) {
                    $field_acc_woh[$woh->Field] = '';
                }
                unset($field_acc_woh['id']);


                foreach ($slh as $k => $v) {

                    if (array_key_exists($k, $field_acc_woh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_acc_woh = array_combine($key, $val);
                foreach ($newdata_acc_woh as $key => $woh) {
                    $data[$key] = $woh;
                }
            }
        }

        if ($table == 'acc_wprh') {
            
            if ($data['rcv_date'] == '' || $data['rcv_date'] == '0000-00-00') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Receive Date');
            }
            
            if ($data['supp_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Supplier Name & Code');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Receiver Warehouse');
            }

            $fieldunique = 'pur_inv_no';
            $inv_type = 'APW';
        }

        if ($table == 'acc_wslh') {

            if ($data['cust_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Customer Code & Name');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }

            $fieldunique = 'sal_inv_no';
            $inv_type = 'ASW';

            $acc_cust = $this->all_m->getId('acc_cust', 'id', $data['cust_id']);



            $data['cust_code'] = $acc_cust->cust_code;
            $data['cust_name'] = $acc_cust->cust_name;
            $data['cust_type'] = $acc_cust->cust_type;


            if ($acc_cust->postaddr == 1) {
                $data['cust_addr'] = $acc_cust->oaddr;
                $data['cust_area'] = $acc_cust->oarea;
                $data['cust_city'] = $acc_cust->ocity;
                $data['cust_zipc'] = $acc_cust->ozipcode;
                $data['cust_phone'] = $acc_cust->ophone;
                $data['cust_hp'] = $acc_cust->ohp;
                $data['cust_npwp'] = $acc_cust->onpwp;
            } else if ($acc_cust->postaddr == 2) {

                $data['cust_addr'] = $acc_cust->haddr;
                $data['cust_area'] = $acc_cust->harea;
                $data['cust_city'] = $acc_cust->hcity;
                $data['cust_zipc'] = $acc_cust->hzipcode;
                $data['cust_phone'] = $acc_cust->hphone;
                $data['cust_hp'] = $acc_cust->hp;
            }

            unset($data['cust_id']);
        }


        if ($stat !== false) {
            if ($id !== '') {
                //$check = $this->all_m->getId($table, 'id', $id);
                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {

                if ($table == 'acc_wprh') {
                    $data['cls_date'] = '0000-00-00';
                    $data['cls2_date'] = '0000-00-00';
                }
                unset($data[$fieldunique]);
                
                $count = $this->all_m->countlimit($table, array($fieldunique => $this->all_m->inv_seq('4', $inv_type)));

                if ($count < 1) {

                     $data[$fieldunique] = $this->all_m->inv_seq('4', $inv_type);
                     $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                     $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed');
                }
            }
        }

        $this->json($msg);
    }

    function delete_optional() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $row = $this->all_m->getId($table, 'id', $id);

        if ($table == 'acc_worh') {
            $table2 = 'acc_word';
            $fieldunique = 'wor_no';
            $inv_type = 'AWR';
        }
        if ($table == 'acc_woh') {
            $table2 = 'acc_wod';
            $fieldunique = 'wo_no';
            $inv_type = 'AWO';
        }

        if ($table == 'acc_wprh') {
            $table2 = 'acc_wprd';
            $fieldunique = 'pur_inv_no';
            $inv_type = 'APW';
        }

        if ($table == 'acc_wslh') {
            $table2 = 'acc_wsld';
            $fieldunique = 'sal_inv_no';
            $inv_type = 'ASW';
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

    function save_word() {
        $wor_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');

        unset($data['table2']);
        unset($data['id2']);

        $data['add_by'] = $user;
        $data['add_date'] = date('Y-m-d');
        $data['pick_date'] = date('Y-m-d');
        $data['wor_no'] = $wor_no;

        if ($data['wk_code'] !== '') {
            $check = $this->all_m->countlimit($table, array('wor_no' => $wor_no, 'wk_code' => $data['wk_code']));

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
                    $acc_worh = $this->all_m->getId('acc_worh', 'wor_no', $wor_no);
                    $data_worh = array(
                        'tot_item' => $acc_worh->tot_item + 1
                    );

                    $this->all_m->updateData('acc_worh', 'id', $acc_worh->id, $data_worh);
                    $this->all_m->insertData($table, $data);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function delete_word() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_word = $this->all_m->getId($table, 'id', $id);

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkworh = $this->all_m->countlimit('acc_worh', array('wor_no' => $acc_word->wor_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkworh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_worh = $this->all_m->getId('acc_worh', 'wor_no', $acc_word->wor_no);

            $data_worh = array(
                'tot_item' => $acc_worh->tot_item - 1
            );

            $this->all_m->updateData('acc_worh', 'id', $acc_worh->id, $data_worh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closeSPOK() {
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
            $check_word = $this->all_m->countlimit('acc_word', array('wor_no' => $data['wor_no']));

            if ($check_word < 1) {
                $msg = array('success' => false, 'message' => 'Unable to close SPOK because it has no transaction');
            } else {

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['wor_date'] = $date;

                //$acc_worh = (array) $this->all_m->getId($table, 'id', $id);

                $check = $this->all_m->countlimit('acc_word', array('wor_no' => $data['wor_no']));

                if ($check > 0) {
                    $acc_word = $this->all_m->getWhere('acc_word', array('wor_no' => $data['wor_no']));


                    $sql_accworoh = "SHOW COLUMNS FROM accworoh";
                    $accworoh = $this->all_m->query_all($sql_accworoh);

                    foreach ($accworoh as $roh) {
                        $field_accworoh[$roh->Field] = '';
                    }
                    unset($field_accworoh['id']);


                    foreach ($data as $k => $v) {

                        if (array_key_exists($k, $field_accworoh)) {
                            $key[] = $k;
                            $val[] = $v;
                        }
                    }

                    $newdata_accworoh = array_combine($key, $val);

                    $n = 1;
                    $data_word = array();
                    foreach ($acc_word as $word) {

                        $data_word['wor_no'] = $word->wor_no;
                        $data_word['pick_date'] = $word->pick_date;
                        $data_word['wk_code'] = $word->wk_code;
                        $data_word['wk_desc'] = $word->wk_desc;
                        $data_word['desc'] = $word->desc;
                        $data_word['act_code'] = $word->act_code;
                        $data_word['add_by'] = $word->add_by;
                        $data_word['add_date'] = $word->add_date;

                        $data_word['wor_date'] = $date;
                        $data_word['wor_line'] = $n;
                        $data_word['qty'] = 1;
                        $data_word['beg_qty'] = 1;
                        $data_word['ord_qty'] = 0;
                        $data_word['end_qty'] = 1;

                        $this->all_m->insertData('accworod', $data_word);
                        $this->all_m->updateData('acc_word', 'id', $word->id, array('wor_date' => $date, 'wor_line' => $n));

                        $n++;
                    }

                    $this->all_m->insertData('accworoh', $newdata_accworoh);
                    $this->all_m->updateData($table, 'id', $id, $datacls);

                    $msg = array('success' => true, 'message' => 'success');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
            }
        }
        $this->json($msg);
    }

    function uncloseSPOK() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $data['cls_date'] = $date;
        $data['cls_by'] = '';
        $data['wor_date'] = $date;

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            $acc_worh = (array) $this->all_m->getId($table, 'id', $id);
            $acc_word = $this->all_m->getWhere('acc_word', array('wor_no' => $data['wor_no']));

            foreach ($acc_word as $word) {
                $this->all_m->deleteData('accworod', 'wor_no', $word->wor_no);
                $this->all_m->updateData('acc_word', 'id', $word->id, array('wor_date' => '0000-00-00', 'wor_line' => 0));
            }

            $this->all_m->deleteData('accworoh', 'wor_no', $data['wor_no']);
            $this->all_m->updateData($table, 'id', $id, array('wor_date' => '0000-00-00', 'cls_date' => '0000-00-00', 'cls_by' => ''));

            $msg = array('success' => true, 'message' => 'success');
        }
        $this->json($msg);
    }

    function save_wod() {
        $wo_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $wk_code = $this->input->post('wk_code');
        $table = $this->input->post('table2');


        if ($wk_code !== '') {
            $check = $this->all_m->countlimit($table, array('wo_no' => $wo_no, 'wk_code' => $wk_code));

            if ($check > 0) {

                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
            } else {

                $check2 = $this->all_m->countlimit('acc_woh', array('wo_no', $wo_no));

                if ($check2 > 0) {

                    $acc_woh = $this->all_m->getId('acc_woh', 'wo_no', $wo_no);

                    $tot_price = intval($acc_woh->tot_price) + intval($this->input->post('price_ad'));

                    $dpp = $tot_price - intval($acc_woh->inv_disc);
                    //$ppn = ($dpp / 100) * 10;
                    $ppn = $this->vat($dpp);
                    $inv_at = $dpp + $ppn;

                    $data_woh = array(
                        'tot_item' => $acc_woh->tot_item + 1,
                        'tot_qty' => $acc_woh->tot_qty + 1,
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_woh->inv_stamp)
                    );


                    //print_r($data_woh);exit;
                    $data['wo_no'] = $wo_no;
                    $data['wk_code'] = $wk_code;
                    $data['wk_desc'] = $this->input->post('wk_desc');

                    $data['price_bd'] = $this->input->post('price_bd');
                    $data['disc_pct'] = $this->input->post('disc_pct');
                    $data['disc_val'] = $this->input->post('disc_val');
                    $data['price_ad'] = $this->input->post('price_ad');
                    $data['add_by'] = $user;
                    $data['add_date'] = date('Y-m-d');
                    $data['qty'] = 1;

                    $data['so_no'] = $acc_woh->so_no;
                    $data['so_date'] = $acc_woh->so_date;
                    $data['sal_inv_no'] = $acc_woh->sal_inv_no;

                    $this->all_m->insertData($table, $data);

                    $this->all_m->updateData('acc_woh', 'wo_no', $wo_no, $data_woh);

                    $veh_sld = $this->all_m->getOne('veh_sld', array('wk_code' => $data['wk_code'], 'sal_inv_no' => $acc_woh->sal_inv_no));
                    $this->all_m->updateData('veh_sld', 'id', $veh_sld->id, array('wo_no' => $wo_no));

                    $msg = array('success' => true, 'message' => 'Record saved');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed saved');
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Work Code');
        }

        $this->json($msg);
    }

    function delete_wod() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_wod = $this->all_m->getId($table, 'id', $id);
        $sal_inv_no = explode('-', $acc_wod->sal_inv_no);
        $vsl = $sal_inv_no[0];


        if ($vsl == 'VSL') {
            $tbld = 'veh_sld';
        }
        if ($vsl == 'ASW') {
            $tbld = 'acc_wsld';
        }

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkwoh = $this->all_m->countlimit('acc_woh', array('wo_no' => $acc_wod->wo_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkwoh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_woh = $this->all_m->getId('acc_woh', 'wo_no', $acc_wod->wo_no);

            //$total = $acc_wod->price_ad * $acc_wod->qty;

            $tot_price = intval($acc_woh->tot_price) - intval($acc_wod->price_ad);
            $dpp = $tot_price - intval($acc_woh->inv_disc);
            //$ppn = ($dpp / 100) * 10;
            $ppn = $this->vat($dpp);
            $inv_at = $dpp + $ppn;

            $data_woh = array(
                'tot_item' => $acc_woh->tot_item - 1,
                'tot_qty' => $acc_woh->tot_qty - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_woh->inv_stamp)
            );

            if ($vsl !== '') {
                $veh_sld = $this->all_m->getOne($tbld, array('sal_inv_no' => $acc_wod->sal_inv_no, 'wk_code' => $acc_wod->wk_code, 'wo_no' => $acc_wod->wo_no));

                $this->all_m->updateData($tbld, 'id', $veh_sld->id, array('wo_no' => NULL, 'wo_date' => '0000-00-00'));
            }
            $this->all_m->updateData('acc_woh', 'id', $acc_woh->id, $data_woh);
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
            $check_wod = $this->all_m->countlimit('acc_wod', array('wo_no' => $data['wo_no']));

            if ($check_wod < 1) {
                $msg = array('success' => false, 'message' => 'WO cannot be closed because it has no transaction');
            } else {

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['wo_date'] = $date;

                //$acc_worh = (array) $this->all_m->getId($table, 'id', $id);
                $check = $this->all_m->countlimit('acc_wod', array('wo_no' => $data['wo_no']));

                if ($check > 0) {
                    $acc_wod = $this->all_m->getWhere('acc_wod', array('wo_no' => $data['wo_no']));


                    $sql_acc_wooh = "SHOW COLUMNS FROM acc_wooh";
                    $acc_wooh = $this->all_m->query_all($sql_acc_wooh);

                    foreach ($acc_wooh as $woh) {
                        $field_acc_wooh[$woh->Field] = '';
                    }
                    unset($field_acc_wooh['id']);


                    foreach ($data as $k => $v) {

                        if (array_key_exists($k, $field_acc_wooh)) {
                            $key[] = $k;
                            $val[] = $v;
                        }
                    }

                    $newdata_acc_wooh = array_combine($key, $val);

                    $n = 1;
                    $data_wod = array();
                    foreach ($acc_wod as $wod) {

                        $data_wod = (array) $wod;
                        unset($data_wod['id']);
                        $data_wod['wor_date'] = $date;
                        $data_wod['wor_line'] = $n;
                        $data_wod['wo_date'] = $date;

                        $data_wod['beg_qty'] = $wod->qty;
                        $data_wod['rcv_qty'] = 0;
                        $data_wod['end_qty'] = $wod->qty;

                        if ($wod->sal_inv_no !== '') {
                            $sal_inv_no = explode('-', $wod->sal_inv_no);
                            $vsl = $sal_inv_no[0];

                            if ($vsl == 'VSL') {
                                $tbld = 'veh_sld';
                            }
                            if ($vsl == 'ASW') {
                                $tbld = 'acc_wsld';
                            }
                            $veh_sld = $this->all_m->getOne($tbld, array('wk_code' => $wod->wk_code, 'sal_inv_no' => $wod->sal_inv_no));
                            $this->all_m->updateData($tbld, 'id', $veh_sld->id, array('wo_date' => $date));
                        }

                        $this->all_m->insertData('acc_wood', $data_wod);
                        $this->all_m->updateData('acc_wod', 'id', $wod->id, array('wo_date' => $date, 'wor_date' => $date, 'wor_line' => $n));


                        $n++;
                    }

                    $this->all_m->insertData('acc_wooh', $newdata_acc_wooh);
                    $this->all_m->updateData($table, 'id', $id, $datacls);

                    $msg = array('success' => true, 'message' => 'success');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
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

        $datawo['cls_date'] = $date;
        $datawo['cls_by'] = '';
        $datawo['wo_date'] = $date;

        $stat = true;

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        $check_wprh = $this->all_m->countlimit('acc_wprh', array('wo_no' => $data['wo_no']));

        if ($check_wprh > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'WO No. has been used in Optional Receiving');
        }

        $check_wprd = $this->all_m->countlimit('acc_wprd', array('wo_no' => $data['wo_no']));

        if ($check_wprd > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Some Optional in this WO has been received');
        }

        if ($stat !== false) {
            $acc_worh = (array) $this->all_m->getId($table, 'id', $id);
            $acc_wod = $this->all_m->getWhere('acc_wod', array('wo_no' => $data['wo_no']));

            foreach ($acc_wod as $wod) {
                if ($wod->sal_inv_no !== '') {
                    $sal_inv_no = explode('-', $wod->sal_inv_no);
                    $vsl = $sal_inv_no[0];

                    if ($vsl == 'VSL') {
                        $tbld = 'veh_sld';
                    }
                    if ($vsl == 'ASW') {
                        $tbld = 'acc_wsld';
                    }
                    $veh_sld = $this->all_m->getOne($tbld, array('wk_code' => $wod->wk_code, 'sal_inv_no' => $wod->sal_inv_no));
                    $this->all_m->updateData($tbld, 'id', $veh_sld->id, array('wo_date' => $date));
                }
                $this->all_m->deleteData('acc_wood', 'wo_no', $wod->wo_no);
                $this->all_m->updateData('acc_wod', 'id', $wod->id, array('wo_date' => '0000-00-00', 'wor_date' => '0000-00-00', 'wor_line' => 0));
            }

            $this->all_m->deleteData('acc_wooh', 'wo_no', $data['wo_no']);
            $this->all_m->updateData($table, 'id', $id, $datawo);

            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_wprd() {
        $date = date('Y-m-d');
        $pur_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $wood_id = $data['wood_id'];

        unset($data['table2']);
        unset($data['id2']);
        unset($data['wood_id']);


        $wood = (array) $this->all_m->getId('acc_wood', 'id', $wood_id);
        $wood_id = $wood['id'];
        unset($wood['id']);
        $data_wood['rcv_qty'] = $wood['rcv_qty'] + 1;
        $data_wood['end_qty'] = $wood['beg_qty'] - ($wood['rcv_qty'] + 1);


        $sql_acc_wprd = "SHOW COLUMNS FROM acc_wprd";
        $acc_wprd = $this->all_m->query_all($sql_acc_wprd);

        foreach ($acc_wprd as $wprd) {
            $field_acc_wprd[$wprd->Field] = '';
        }
        unset($field_acc_wprd['id']);


        foreach ($wood as $k => $v) {

            if (array_key_exists($k, $field_acc_wprd)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        $data_acc_wprd = array_combine($key, $val);


        $data_acc_wprd['pur_inv_no'] = $pur_inv_no;
        $data_acc_wprd['add_by'] = $user;
        $data_acc_wprd['add_date'] = $date;
        $data_acc_wprd['prep_code'] = $data['prep_code'];
        $data_acc_wprd['prep_name'] = $data['prep_name'];
        $data_acc_wprd['wo_date'] = $this->dateFormat($data['wo_date']);

        if ($data['price_bd']) {
            $data_acc_wprd['price_bd'] = $data['price_bd'];
            $data_acc_wprd['disc_pct'] = $data['disc_pct'];
            $data_acc_wprd['disc_val'] = $data['disc_val'];
            $data_acc_wprd['price_ad'] = $data['price_ad'];
        } else {
            $data_acc_wprd['price_bd'] = $wood['price_bd'];
            $data_acc_wprd['disc_pct'] = $wood['disc_pct'];
            $data_acc_wprd['disc_val'] = $wood['disc_val'];
            $data_acc_wprd['price_ad'] = $wood['price_ad'];
        }

                // print_r($data_acc_wprd);exit;
        //print_r($maccs);exit;
        if ($data['wk_code'] !== '') {
            $check = $this->all_m->countlimit($table, array('pur_inv_no' => $pur_inv_no, 'wk_code' => $data['wk_code']));

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

                    $acc_wprh = $this->all_m->getId('acc_wprh', 'pur_inv_no', $pur_inv_no);
                    if ($data['price_bd']) {
                        $total_price = $data['price_ad'];
                    } else {
                        $total_price = $wood['price_ad'];
                    }

                    $tot_price = intval($acc_wprh->tot_price) + intval($total_price);
                    $dpp = $tot_price - intval($acc_wprh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_wprh = array(
                        'tot_item' => $acc_wprh->tot_item + 1,
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_wprh->inv_stamp)
                    );

                    $this->all_m->updateData('acc_wood', 'id', $wood_id, $data_wood);
                    $this->all_m->updateData('acc_wprh', 'id', $acc_wprh->id, $data_wprh);

                    $this->all_m->insertData($table, $data_acc_wprd);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function delete_wprd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_wprd = $this->all_m->getId($table, 'id', $id);
        $data = (array) $acc_wprd;

        $wood = (array) $this->all_m->getOne('acc_wood', array('wo_no' => $acc_wprd->wo_no, 'wk_code' => $acc_wprd->wk_code));

        $data_wood['rcv_qty'] = $wood['rcv_qty'] - 1;
        $data_wood['end_qty'] = $wood['beg_qty'] + ($wood['rcv_qty'] - 1);

        $stat = false;
        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkwprh = $this->all_m->countlimit('acc_wprh', array('pur_inv_no' => $acc_wprd->pur_inv_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkwprh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_wprh = $this->all_m->getId('acc_wprh', 'pur_inv_no', $acc_wprd->pur_inv_no);

            $total_price = $acc_wprd->price_ad;

            $tot_price = intval($acc_wprh->tot_price) - $total_price;
            $dpp = $tot_price - intval($acc_wprh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_wprh = array(
                'tot_item' => $acc_wprh->tot_item - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_wprh->inv_stamp)
            );

            $this->all_m->updateData('acc_wood', 'id', $wood['id'], $data_wood);
            $this->all_m->updateData('acc_wprh', 'id', $acc_wprh->id, $data_wprh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closePenerimaan() {
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
            $check_wprd = $this->all_m->countlimit('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check_wprd < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $check = $this->all_m->countlimit($table, array('id' => $id));
                if ($check > 0) {
                    $acc_wprh = $this->all_m->getId($table, 'id', $id);

                    /* $acc_wprd = $this->all_m->getWhere('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

                      foreach ($acc_wprd as $wprd) {
                      $this->all_m->updateData('acc_wprd', 'id', $wprd->id, array('pur_date' => $date));
                      }
                     */
                    $dataclose['cls_date'] = $date;
                    $dataclose['cls_by'] = $user;
                    // $data['pur_date'] = $date;
                    $dataclose['cls_cnt'] = $acc_wprh->cls_cnt + 1;

                    $this->all_m->updateData($table, 'id', $id, $dataclose);

                    $msg = array('success' => true, 'message' => 'success');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
            }
        }
        $this->json($msg);
    }

    function unclosePenerimaan() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        $acc_wprh = $this->all_m->getId($table, 'id', $id);

        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        if ($acc_wprh->cls2_date !== '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Optional Purchase has been closed');
        }

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);


        $check = $this->all_m->countlimit($table, array('id' => $id));

        if ($stat !== false) {

            if ($check > 0) {
                $unclosedata['cls_date'] = $date;
                $unclosedata['cls_by'] = '';
                $unclosedata['pur_date'] = $date;


                $acc_wprd = $this->all_m->getWhere('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

                foreach ($acc_wprd as $wprd) {
                    $this->all_m->updateData('acc_wprd', 'id', $wprd->id, array('pur_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $unclosedata);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function check_wprh() {
        $pur_inv_no = $this->input->post('pur_inv_no');
        $table = $this->input->post('table');

        $data = $this->all_m->getId($table, 'pur_inv_no', $pur_inv_no);
        $stat = true;


        if ($data->cls_date !== '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Optional Receiving has been closed. Please unclose this Optional Receiving first');
        }

        if ($stat !== false) {
            $msg = array('success' => true);
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function closePembelian() {
        $user = $this->uri->segment(4);

        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        $acc_wprh = (array) $this->all_m->getId($table, 'id', $id);
        unset($acc_wprh['id']);



        $sql_acc_aph = "SHOW COLUMNS FROM acc_aph";
        $acc_aph = $this->all_m->query_all($sql_acc_aph);

        foreach ($acc_aph as $aph) {
            $field_acc_aph[$aph->Field] = '';
        }
        unset($field_acc_aph['id']);


        foreach ($acc_wprh as $k => $v) {

            if (array_key_exists($k, $field_acc_aph)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        $data_aph = array_combine($key, $val);
        $data_aph['pur_date'] = $date;
        $data_aph['pinv_code'] = 'APW';
        $data_aph['hd_begin'] = $data['inv_total'];
        $data_aph['hd_paid'] = 0;
        $data_aph['hd_disc'] = 0;
        $data_aph['hd_end'] = $data['inv_total'];

        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }

        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
            $stat = false;
        }

        if (intval(strtotime($data['due_date'])) < intval(strtotime($date))) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Today\'s date + TOP day(s) doesn\'t equal TOP Date');
        }

        if ($acc_wprh['cls_date'] == '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Optional Receiving hasn\'t been closed (finished) yet. Please close it first');
        }

        if ($stat !== false) {

            $check_pod = $this->all_m->countlimit('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check_pod < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $dataclose['cls2_date'] = $date;
                $dataclose['cls2_by'] = $user;
                $dataclose['pur_date'] = $date;
                $dataclose['cls2_cnt'] = $acc_wprh['cls_cnt'] + 1;

                $count = $this->all_m->countlimit('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

                if ($count > 0) {

                    $acc_wprd = $this->all_m->getWhere('acc_wprd', array('pur_inv_no' => $data['pur_inv_no']));

                    foreach ($acc_wprd as $wprd) {
                        $sld = $this->all_m->getOne('veh_sld', array('sal_inv_no' => $wprd->sal_inv_no, 'wk_code' => $wprd->wk_code));

                        $data_sld = array(
                            'wo_no' => $wprd->wo_no,
                            'wo_date' => $wprd->wo_date,
                            'pur_inv_no' => $wprd->pur_inv_no,
                            'purinclvat' => 'T',
                            'pur_date' => $date,
                            'pur_bd' => $wprd->price_bd,
                            'pur_disc' => $wprd->disc_val,
                            'pur_ad' => $wprd->price_ad
                        );
                        $this->all_m->updateData('veh_sld', 'id', $sld->id, $data_sld);
                        $this->all_m->updateData('acc_wprd', 'id', $wprd->id, array('pur_date' => $date));
                    }
                    //print_r($sld);exit;
                    $this->all_m->updateData($table, 'id', $id, $dataclose);
                    $this->all_m->insertData('acc_aph', $data_aph);
                    $msg = array('success' => true, 'message' => 'success');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function unclosePembelian() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            $acc_wprh = $this->all_m->getId($table, 'id', $id);

            $stat = true;

            $dataunclose['cls2_date'] = $date;
            $dataunclose['cls2_by'] = '';
            $dataunclose['pur_date'] = $date;

            $count = $this->all_m->countlimit('acc_wprd', array('pur_inv_no' => $acc_wprh->pur_inv_no));

            $check_apd = $this->all_m->countlimit('acc_apd', array('pur_inv_no' => $acc_wprh->pur_inv_no));
            $check_apgd = $this->all_m->countlimit('acc_apgd', array('pur_inv_no' => $acc_wprh->pur_inv_no));

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
                $acc_wprd = $this->all_m->getWhere('acc_wprd', array('pur_inv_no' => $acc_wprh->pur_inv_no));

                foreach ($acc_wprd as $wprd) {
                    $sld = $this->all_m->getOne('veh_sld', array('sal_inv_no' => $wprd->sal_inv_no, 'wk_code' => $wprd->wk_code));

                    $data_sld = array(
                        'wo_no' => '',
                        'wo_date' => '',
                        'pur_inv_no' => '',
                        'purinclvat' => 'F',
                        'pur_date' => $date,
                        'pur_bd' => 0,
                        'pur_disc' => 0,
                        'pur_ad' => 0
                    );
                    $this->all_m->updateData('veh_sld', 'id', $sld->id, $data_sld);
                    $this->all_m->updateData('acc_wprd', 'id', $wprd->id, array('pur_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $dataunclose);
                $this->all_m->deleteData('acc_aph', 'pur_inv_no', $acc_wprh->pur_inv_no);
                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function save_wsld() {
        $sal_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $wk_code = $this->input->post('wk_code');
        $table = $this->input->post('table2');


        if ($wk_code !== '') {
            $check = $this->all_m->countlimit($table, array('sal_inv_no' => $sal_inv_no, 'wk_code' => $wk_code));

            if ($check > 0) {

                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
            } else {

                $check = $this->all_m->countlimit('acc_wslh', array('sal_inv_no' => $sal_inv_no));

                if ($check > 0) {
                    $acc_wslh = $this->all_m->getId('acc_wslh', 'sal_inv_no', $sal_inv_no);

                    $tot_price = intval($acc_wslh->tot_price) + intval($this->input->post('price_ad'));
                    $dpp = $tot_price - intval($acc_wslh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_wslh = array(
                        'tot_item' => $acc_wslh->tot_item + 1,
                        'tot_disc' => $acc_wslh->tot_disc + intval($this->input->post('disc_val')),
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_wslh->inv_stamp)
                    );


                    //print_r($data_wslh);exit;
                    $data['sal_inv_no'] = $sal_inv_no;
                    $data['wk_code'] = $wk_code;
                    $data['wk_desc'] = $this->input->post('wk_desc');

                    $data['price_bd'] = $this->input->post('price_bd');
                    $data['disc_pct'] = $this->input->post('disc_pct');
                    $data['disc_val'] = $this->input->post('disc_val');
                    $data['price_ad'] = $this->input->post('price_ad');
                    $data['add_by'] = $user;
                    $data['add_date'] = date('Y-m-d');


                    $data['pick_date'] = date('Y-m-d');
                    $data['so_no'] = $acc_wslh->so_no;
                    $data['so_date'] = $acc_wslh->so_date;
                    $data['sal_inv_no'] = $acc_wslh->sal_inv_no;
                    $data['vsl_inv_no'] = $acc_wslh->vsl_inv_no;
                    $data['srep_code'] = $acc_wslh->srep_code;
                    $data['srep_name'] = $acc_wslh->srep_name;

                    // print_r($data);exit;
                    $this->all_m->insertData($table, $data);

                    $this->all_m->updateData('acc_wslh', 'sal_inv_no', $sal_inv_no, $data_wslh);
                    $msg = array('success' => true, 'message' => 'Record saved');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed');
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Work Code');
        }

        $this->json($msg);
    }

    function delete_wsld() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $stat = false;

        $acc_wsld = $this->all_m->getId($table, 'id', $id);

        if (!empty($acc_wsld->wo_no)) {
            $stat = false;
        }

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkwslh = $this->all_m->countlimit('acc_wslh', array('sal_inv_no' => $acc_wsld->sal_inv_no));

        if ($check > 0) {
            $stat = true;
        }
        if ($checkwslh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_wslh = $this->all_m->getId('acc_wslh', 'sal_inv_no', $acc_wsld->sal_inv_no);

            $total = $acc_wsld->price_ad;

            $tot_price = intval($acc_wslh->tot_price) - intval($total);
            $dpp = $tot_price - intval($acc_wslh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_wslh = array(
                'tot_item' => $acc_wslh->tot_item - 1,
                'tot_disc' => $acc_wslh->tot_disc - intval($acc_wsld->disc_val),
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_wslh->inv_stamp)
            );


            $this->all_m->updateData('acc_wslh', 'id', $acc_wslh->id, $data_wslh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closePenjualan() {
        $user = $this->uri->segment(4);

        $date = date('Y-m-d');

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);
        unset($data['cust_id']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($msg['success'] !== false) {
            $check_wsld = $this->all_m->countlimit('acc_wsld', array('sal_inv_no' => $data['sal_inv_no']));

            if ($check_wsld < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {

                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $acc_wslh = $this->all_m->getId($table, 'id', $id);

                    $acc_wsld = $this->all_m->getWhere('acc_wsld', array('sal_inv_no' => $data['sal_inv_no']));

                    foreach ($acc_wsld as $wsld) {
                        $this->all_m->updateData('acc_wsld', 'id', $wsld->id, array('sal_date' => $date));
                    }

                    $datacls['cls_date'] = $date;
                    $datacls['cls_by'] = $user;
                    $datacls['sal_date'] = $date;
                    $datacls['cls_cnt'] = $acc_wslh->cls_cnt + 1;



                    $sql_arh = "SHOW COLUMNS FROM acc_arh";
                    $acc_arh = $this->all_m->query_all($sql_arh);

                    foreach ($acc_arh as $arh) {
                        $field_acc_arh[$arh->Field] = '';
                    }
                    unset($field_acc_arh['id']);

                    $wslh = (array) $acc_wslh;

                    foreach ($wslh as $k => $v) {

                        if (array_key_exists($k, $field_acc_arh)) {
                            $key[] = $k;
                            $val[] = $v;
                        }
                    }

                    $newdata_acc_wslh = array_combine($key, $val);
                    $newdata_acc_wslh['cls_date'] = $date;
                    $newdata_acc_wslh['sal_inv_no'] = $acc_wslh->sal_inv_no;
                    $newdata_acc_wslh['sal_date'] = $date;

                    $newdata_acc_wslh['inv_bt'] = $acc_wslh->inv_bt;
                    $newdata_acc_wslh['inv_vat'] = $acc_wslh->inv_vat;
                    $newdata_acc_wslh['inv_stamp'] = $acc_wslh->inv_stamp;
                    $newdata_acc_wslh['inv_total'] = $acc_wslh->inv_total;
                    $newdata_acc_wslh['pd_begin'] = $acc_wslh->inv_total;
                    $newdata_acc_wslh['pd_paid'] = $acc_wslh->tot_price;
                    $newdata_acc_wslh['pd_disc'] = $acc_wslh->inv_disc;
                    $newdata_acc_wslh['pd_end'] = $acc_wslh->inv_total;
                    $newdata_acc_wslh['sinv_code'] = 'ASW';

                    $data_slh['awsl_price'] = $acc_wslh->tot_price;
                    $data_slh['awsl_disc'] = $acc_wslh->inv_disc;
                    $data_slh['awsl_bt'] = $acc_wslh->inv_bt;
                    $data_slh['awsl_vat'] = $acc_wslh->inv_vat;
                    $data_slh['awsl_at'] = $acc_wslh->inv_at;
                    $data_slh['awsl_stamp'] = $acc_wslh->inv_stamp;
                    $data_slh['awsl_total'] = $acc_wslh->inv_total;

                    $check = $this->all_m->insertData('acc_arh', $newdata_acc_wslh);

                    $this->all_m->updateData('veh_slh', 'sal_inv_no', $acc_wslh->vsl_inv_no, $data_slh);
                    $this->all_m->updateData($table, 'id', $id, $datacls);


                    $msg = array('success' => true, 'message' => 'success');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
            }
        }
        $this->json($msg);
    }

    function unclosePenjualan() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);
        unset($data['cust_id']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {

            $check = $this->all_m->countlimit($table, array('id' => $id));

            if ($check > 0) {

                $acc_wslh = $this->all_m->getId($table, 'id', $id);

                $data['cls_date'] = $date;
                $data['cls_by'] = '';
                $data['sal_date'] = $date;


                $acc_wsld = $this->all_m->getWhere('acc_wsld', array('sal_inv_no' => $data['sal_inv_no']));

                foreach ($acc_wsld as $wsld) {
                    $this->all_m->updateData('acc_wsld', 'id', $wsld->id, array('sal_date' => $date));
                }

                $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $acc_wslh->vsl_inv_no);

                $data_slh['awsl_price'] = $veh_slh->awsl_price - $acc_wslh->tot_price;
                $data_slh['awsl_disc'] = $veh_slh->awsl_disc - $acc_wslh->inv_disc;
                $data_slh['awsl_bt'] = $veh_slh->awsl_bt - $acc_wslh->inv_bt;
                $data_slh['awsl_vat'] = $veh_slh->awsl_vat - $acc_wslh->inv_vat;
                $data_slh['awsl_at'] = $veh_slh->awsl_at - $acc_wslh->inv_at;
                $data_slh['awsl_stamp'] = $veh_slh->awsl_stamp - $acc_wslh->inv_stamp;
                $data_slh['awsl_total'] = $veh_slh->awsl_total - $acc_wslh->inv_total;

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = '';
                $datacls['sal_date'] = $date;

                $this->all_m->updateData('veh_slh', 'id', $veh_slh->id, $data_slh);
                $this->all_m->updateData($table, 'id', $id, $datacls);
                $this->all_m->deleteData('acc_arh', 'sal_inv_no', $acc_wslh->sal_inv_no);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        }
        $this->json($msg);
    }

    function get_optional() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $where[$this->uri->segment(5)] = $this->uri->segment(6);
        $where['wo_no'] = NULL;
        $data = $this->get_data_mdl->get_data($table, $where);
        $this->json($data);
    }

    function getSPKafterSaleOptional() {
        $wo_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $post = $this->input->post('data');
        $tbl = $this->input->post('tbl');
        $sal_inv_no = $this->input->post('sal_inv_no');
//print_r($tbl);exit;
        foreach ($post as $row) {


            $check = $this->all_m->countlimit('acc_wod', array('wo_no' => $wo_no, 'wk_code' => $row['wk_code'], 'wk_desc' => $row['wk_desc'], 'sal_inv_no' => $sal_inv_no));

            if ($check == 0) {

                $check_sld = $this->all_m->countlimit($tbl, array('sal_inv_no' => $sal_inv_no, 'wk_code' => $row['wk_code'], 'wk_desc' => $row['wk_desc']));

                if ($check_sld > 0) {
                    $acc_woh = $this->all_m->getId('acc_woh', 'wo_no', $wo_no);

                    $tot_price = intval($acc_woh->tot_price) + intval($row['price_ad']);
                    $dpp = $tot_price - intval($acc_woh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_woh = array(
                        'tot_item' => $acc_woh->tot_item + 1,
                        'tot_qty' => $acc_woh->tot_qty + 1,
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_woh->inv_stamp)
                    );


                    //print_r($data_woh);exit;
                    $data['wo_no'] = $wo_no;
                    $data['wk_code'] = $row['wk_code'];
                    $data['wk_desc'] = $row['wk_desc'];

                    $data['price_bd'] = $row['price_bd'];
                    $data['disc_pct'] = $row['disc_pct'];
                    $data['disc_val'] = $row['disc_val'];
                    $data['price_ad'] = $row['price_ad'];
                    $data['add_by'] = $user;
                    $data['add_date'] = date('Y-m-d');
                    $data['qty'] = 1;

                    $data['so_no'] = $acc_woh->so_no;
                    $data['so_date'] = $acc_woh->so_date;
                    $data['sal_inv_no'] = $row['sal_inv_no'];
                    $data['det_source'] = $row['sal_inv_no'];
                    $data['vsl_inv_no'] = $acc_woh->sal_inv_no;

                    $sld = $this->all_m->getId($tbl, 'id', $row['id']);
                    //print_r($wo_no);exit;
                    $this->all_m->insertData('acc_wod', $data);

                    $this->all_m->updateData($tbl, 'id', $row['id'], array('wo_no' => $wo_no));
                    $this->all_m->updateData('acc_woh', 'wo_no', $wo_no, $data_woh);
                    $msg = array('success' => true, 'message' => 'Record saved');
                }
            } else {
                $msg = array('success' => false, 'message' => 'Not Saved, Data already exits');
            }
        }

        $this->json($msg);
    }

    function checkOptional() {
        $tbl = $this->input->post('tbl');
        $sal_inv_no = $this->input->post('sal_inv_no');

        if ($tbl == 'veh_sld') {
            $check = $this->all_m->countlimit('veh_sld', array('sal_inv_no' => $sal_inv_no, 'wo_no' => NULL));
        }
        if ($tbl == 'acc_wsld') {
            $check = $this->all_m->countlimit('acc_wsld', array('vsl_inv_no' => $sal_inv_no, 'wo_no' => NULL));
        }
        $msg = array('count' => $check);
        $this->json($msg);
    }

    function check_wo() {
        $pur_inv_no = $this->input->post('pur_inv_no');
        $check_bprd = $this->all_m->countlimit('acc_wprd', array('pur_inv_no' => $pur_inv_no));
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

            case 'acc_worh':

                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'SPOK_' . $read['number'],
                    'title' => 'SPOK_ ' . $read['number']
                );
                $margin = "P";
                break;

            case 'acc_woh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'WorkOrderOptional' . $read['number'],
                    'title' => 'Work Order Optional_' . $read['number']
                );
                $margin = "P";
                break;

            case 'acc_wprh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'PenerimaanJasaOptional_' . $read['number'],
                    'title' => 'PenerimaanJasaOptional_' . $read['number']
                );
                $margin = "P";
                break;

            case 'acc_wslh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'PenjualanOptional_' . $read['number'],
                    'title' => 'Penjualan_Optional_' . $read['number']
                );
                $margin = "P";
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
            case 'acc_worh':
                $code_form = 'WOR';

                $html .= '<br /><br /><br />';
                $html .= '<table class="tables" >';
                $html .= '<tr><td>';
                $html .= '<table class="tables" border="1">';
                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:14px;"><b>' . $company->comp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add1 . '</td></tr>';
                $html .='<tr><td colspan="2">' . $company->comp_add2 . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td  width="50%">';
                $html .='<b style="text-align:center;font-size:16px;padding-top:50px;">SURAT PERMINTAAN ORDER KERJA</b>';
                $html .= '</td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table>';
                $html .= '<tr>'
                        . '<td><b>Gudang</b></td><td class="td-ro">:</td><td>' . $read->wrhs_code . '</td>'
                        . '<td><b>Jenis SPOK</b></td><td class="td-ro">:</td><td>' . $read->oreq_type . '</td>'
                        . '</tr>';
                $html .= '<tr>'
                        . '<td><b>Bagian</b></td><td class="td-ro">:</td><td>' . $read->dept_name . '</td>'
                        . '<td><b>Unit</b></td><td class="td-ro">:</td><td>' . $read->dunit_name . '</td>'
                        . '</tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td width="50%">';
                $html .= '<table>';
                $html .= '<tr>'
                        . '<td><b>No. SPOK</b></td><td class="td-ro">:</td><td width="70" d><b>' . $read->wor_no . '</b></td>'
                        . '<td width="50"><b>No. Dokumen</b></td><td class="td-ro">:</td><td><b>' . $read->doc_no . '</b></td>'
                        . '</tr>';
                $html .= '<tr>'
                        . '<td><b>Tgl. SPOK</b></td><td class="td-ro">:</td><td><b>' . $this->dateView($read->wor_date) . '</b></td>'
                        . '<td><b>No. Revisi</b></td><td class="td-ro">:</td><td><b></b></td>'
                        . '</tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '</tr>';
                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';

                $html .='<br /><br />';

                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables" border="1">';
                $html .= '<tr>'
                        . '<td width="5%">No.</td>'
                        . '<td>Work Code<br />Kode Kerja</td>'
                        . '<td width="45%">Uraian<br />Description/Specification</td>'
                        . '<td>Keterangan<br />Note</td>'
                        . '<td width="10%">Aksi<br />Action</td>'
                        . '</tr>';


                $acc_word = $this->all_m->getWhere('acc_word', array($inv_code => $read->$inv_code));
                $no = 1;
                foreach ($acc_word as $word):
                    $html .= '<tr>'
                            . '<td>' . $no . '</td>'
                            . '<td>' . $word->wk_code . '</td>'
                            . '<td align="center">' . $word->wk_desc . '</td>'
                            . '<td align="center">' . $word->desc . '</td>'
                            . '<td align="center">' . $word->act_code . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;

                $html .='</table>';

                $html .='</td></tr>';
                $html .= '</table>';


                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td><table><tr><td><b>Diperlukan Tanggal:</b> ' . $this->dateView($read->need_date) . '</td></tr><tr><td><b>Catatan: </b><br />' . $read->note . '<br />' . $read->note2 . '<br />' . $read->note3 . '<br />' . $read->note4 . '<br /></td></tr></table></td>';

                $html .= '<td><table><tr><td><b>Request By:</b> ' . $read->req_code . '</td></tr></table></td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .='</td></tr>';
                $html .= '</table>';

                $html .= '<br /><br />';

                break;

            case 'acc_woh':
                $code_form = 'WO';
                $html .= '<table class="tables" >';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $read->rname . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $read->raddr . '</td></tr>';
                $html .='<tr><td colspan="2">' . $read->rcity . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $read->rphone . '</td><td><b>Fax : </b>' . $read->rfax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td  width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $read->supp_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $read->saddr . '</td></tr>';
                $html .='<tr><td colspan="2">' . $read->scity . '-' . $read->scountry . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $read->rphone . '</td><td><b>Fax : </b>' . $read->rfax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';


                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="3"><hr /></td></tr>';
                $html .= '<tr>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Kendaraan</td><td class="td-ro">:</td><td width="110">' . $read->veh_name . '</td></tr>'
                        . '<tr><td>No. Rangka</td><td class="td-ro">:</td><td>' . $read->chassis . '</td></tr>'
                        . '<tr><td>No. Mesin</td><td class="td-ro">:</td><td>' . $read->engine . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Warna</td><td class="td-ro">:</td><td width="110">' . $read->color_name . '</td></tr>'
                        . '<tr><td>No. SPK</td><td class="td-ro">:</td><td>' . $read->so_no . '</td></tr>'
                        . '<tr><td>Tgl. SPK</td><td class="td-ro">:</td><td>' . $this->dateView($read->so_date) . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Pelanggan</td><td class="td-ro">:</td><td width="110"></td></tr>'
                        . '<tr><td></td><td class="td-ro"></td><td></td></tr>'
                        . '<tr><td>Sales</td><td class="td-ro">:</td><td></td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';


                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';
                $html .= '<tr><td width="15%"><b>Kode</b></td><td width="40%"><b>Keterangan</b></td><td align="right" width="15%"><b>Harga</b></td><td  width="15%" align="right"><b> Disc(%)</b></td><td  width="15%" align="right"><b>Netto</b></td></tr>';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';
                $acc_wod = $this->all_m->getWhere('acc_wod', array($inv_code => $read->$inv_code));
                $no = 1;
                foreach ($acc_wod as $wod):
                    $html .= '<tr>'
                            . '<td>' . $wod->wk_code . '</td>'
                            . '<td>' . $wod->wk_desc . '</td>'
                            . '<td align="right">' . number_format($wod->price_bd) . '</td>'
                            . '<td align="right">' . number_format($wod->disc_pct) . '</td>'
                            . '<td align="right">' . number_format($wod->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;
                $html .= '<tr><td colspan="5"></td></tr>';
                $html .= '<tr><td colspan="5"></td></tr>';
                $html .= '<tr><td colspan="5"></td></tr>';

                $html .= '</table>';
                $html .= '</td></tr>';

                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Sub Total:</b></td><td width="15%" align="right">' . number_format($read->inv_at) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Discount:</b></td><td width="15%" align="right">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Lain-lain:</b></td><td width="15%" align="right">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Grand Total:</b></td><td width="15%" align="right">' . number_format($read->inv_total) . '</td></tr>';


                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';
                break;

            case 'acc_wprh':

                $pur_date = $this->dateView($read->pur_date);

                if ($data['act'] == 'penerimaan') {
                    $code_form = 'WRCV';

                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="40%">';
                    $html .= '<table class="tables">';
                    $html .='<tr><td style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                    $html .='<tr><td>' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td>' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td  width="60%">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Penerimaan Jasa / Optional</b></td></tr>';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<table class="tables">';
                    $html .='<tr><td>No. Faktur<br />Inv Number</td><td class="td-ro">:</td><td width="90">' . $read->$inv_code . '</td></tr>';
                    $html .='<tr><td>Tgl. Faktur<br />Inv Date</td><td class="td-ro">:</td><td>' . $pur_date . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td colspan="2"><b><u>PENTING/IMPORTANT</u></b></td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';


                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Rekanan / Vendor:</b></td></tr>';
                    $html .= '<tr><td>' . $read->supp_name . '</td></tr>';
                    $html .= '<tr><td>' . $read->saddr . ' ' . $read->sarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->scity . ' ' . $read->scountry . ' ' . $read->szipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                    $html .= '<tr><td>' . $read->rname . '</td></tr>';
                    $html .= '<tr><td>' . $read->raddr . ' ' . $read->rarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->rcity . ' ' . $read->rcountry . ' ' . $read->rzipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';



                    $html .= '<table class="tables">';
                    $html .='<tr>'
                            . '<td colspan="8">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr>'
                            . '<td colspan="2">'
                            . '<table><tr><td>No. OK.<br />WO No.</td><td class="td-ro">:</td><td> ' . $read->po_no . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table><tr><td>Tgl. OK.<br />WO Date</td><td class="td-ro">:</td><td>' . $po_date . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table width="100%"><tr><td width="55">Gudang<br /> Warehouse</td><td class="td-ro">:</td><td>' . $read->wrhs_code . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="70">' . $read->due_day . ' hari (days)</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2"><table><tr><td width="70">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table>'
                            . '</td>'
                            . '</tr>';

                    $html .= '<tr>'
                            . '<td>No.<br />Line</td>'
                            . '<td colspan="2">Kode Pekerjaan<br />Work Code</td>'
                            . '<td colspan="3">Uraian<br />Description/Specification</td>'
                            . '<td colspan="2">No. OK<br />WO Nbr</td>'
                            . '<td>Tgl. OK <br />WO Date</td>'
                            . '<td>Pembeli <br />Purchaser</td>'
                            . '</tr>';
                    //$html .= '<tr><td width="5%">No.</td><td>Kode Barang<br />Item Code</td><td width="25%">Uraian<br />Description/Specification</td><td width="10%">Satuan<br />U/M</td><td width="10%">Kuantitas<br />Quantity</td><td>Gudang<br />Warehouse</td><td>Lokasi<br />Location </td><td>Pembeli<br />Purchaser</td></tr>';

                    $acc_wprd = $this->all_m->getWhere('acc_wprd', array($inv_code => $read->$inv_code));
                    $no = 1;

                    foreach ($acc_wprd as $wprd):
                        $html .= '<tr>'
                                . '<td>' . $no . '</td>'
                                . '<td colspan="2">' . $wprd->wk_code . '</td>'
                                . '<td colspan="3">' . $wprd->wk_desc . '</td>'
                                . '<td colspan="2">' . $wprd->wo_no . '</td>'
                                . '<td>' . $wprd->wo_date . '</td>'
                                . '<td>' . $wprd->prep_code . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;


                    $html .='</table>';
                    $html .='</td>';
                    $html .= '</tr>';

                    $html .= '</table>';
                    $html .= '<br /><br />';
                }

                if ($data['act'] == 'pembelian') {
                    $code_form = 'WPR';

                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="40%">';
                    $html .= '<table class="tables">';
                    $html .='<tr><td style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                    $html .='<tr><td>' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td>' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td  width="60%">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Faktur Pembelian Jasa / Optional</b></td></tr>';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<table class="tables">';
                    $html .='<tr><td>No. Faktur<br />Inv Number</td><td class="td-ro">:</td><td width="90">' . $read->$inv_code . '</td></tr>';
                    $html .='<tr><td>Tgl. Faktur<br />Inv Date</td><td class="td-ro">:</td><td>' . $pur_date . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td>';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td colspan="2"><b><u>PENTING/IMPORTANT</u></b></td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';


                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Rekanan / Vendor:</b></td></tr>';
                    $html .= '<tr><td>' . $read->supp_name . '</td></tr>';
                    $html .= '<tr><td>' . $read->saddr . ' ' . $read->sarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->scity . ' ' . $read->scountry . ' ' . $read->szipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                    $html .= '<tr><td>' . $read->rname . '</td></tr>';
                    $html .= '<tr><td>' . $read->raddr . ' ' . $read->rarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->rcity . ' ' . $read->rcountry . ' ' . $read->rzipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';


                    $html .= '<table class="tables">';
                    $html .='<tr>'
                            . '<td colspan="8">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr>'
                            . '<td colspan="2">'
                            . '<table><tr><td>No. OK.<br />WO No.</td><td class="td-ro">:</td><td> ' . $read->po_no . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table><tr><td>Tgl. OK.<br />WO Date</td><td class="td-ro">:</td><td>' . $po_date . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table width="100%"><tr><td width="55">Gudang<br /> Warehouse</td><td class="td-ro">:</td><td>' . $read->wrhs_code . '</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2">'
                            . '<table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="60">' . $read->due_day . ' hari (days)</td></tr></table>'
                            . '</td>'
                            . '<td colspan="2"><table><tr><td width="70">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table>'
                            . '</td>'
                            . '</tr>';

                    $html .= '<tr>'
                            . '<td rowspan="2">No.<br />Line</td>'
                            . '<td colspan="2" rowspan="2">Kode Pekerjaan<br />Work Code</td>'
                            . '<td colspan="3" rowspan="2">Uraian<br />Description/Specification</td>'
                            . '<td align="right" rowspan="2">Harga Satuan<br />Unit Price</td>'
                            . '<td  align="right"colspan="2" align="center">Diskon/Discount</td>'
                            . '<td align="right" rowspan="2">Jumlah <br />Amount</td>'
                            . '</tr>';

                    $html .='<tr><td>%</td><td></td></tr>';

                    $acc_wprd = $this->all_m->getWhere('acc_wprd', array($inv_code => $read->$inv_code));
                    $no = 1;

                    foreach ($acc_wprd as $wprd):
                        $html .= '<tr>'
                                . '<td>' . $no . '</td>'
                                . '<td colspan="2">' . $wprd->wk_code . '</td>'
                                . '<td colspan="3">' . $wprd->wk_desc . '</td>'
                                . '<td align="right">' . number_format($wprd->price_bd) . '</td>'
                                . '<td align="right">' . number_format($wprd->disc_pct) . '</td>'
                                . '<td align="right">' . number_format($wprd->disc_val) . '</td>'
                                . '<td align="right">' . number_format($wprd->price_ad) . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;

                    $html .='</table>';

                    $html .= '<table class="tables">';
                    $html .= '<tr><td colspan="8"></td><td align="right"><b>Sub Total</b></td><td align="right" border="1">' . number_format($read->tot_price) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Discount</td><td align="right" border="1">' . number_format($read->inv_disc) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Netto</td><td align="right" border="1">' . number_format($read->inv_bt) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">PPN/VAT</td><td align="right" border="1">' . number_format($read->inv_vat) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right"><b>Total</b></td><td align="right" border="1">' . number_format($read->inv_at) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Others</td><td align="right" border="1">' . number_format($read->inv_stamp) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right"><b>Grand Total</b></td><td align="right" border="1">' . number_format($read->inv_total) . '</td></tr>';
                    $html .= '</table>';
                    $html .='</td>';
                    $html .= '</tr>';


                    $html .= '</table>';
                    $html .= '<br /><br />';
                }
                break;

            case 'acc_wslh':
                $html .= '<table class="tables" >';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td style="font-size:12px;"><b>' . $company->comp_name . '</b></td></tr>';
                $html .='<tr><td>' . $company->comp_add1 . '</td></tr>';
                $html .='<tr><td>' . $company->comp_add2 . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';

                $html .= '<td  width="50%">';
                $html .= '<table class="tables">';
                $html .='<tr><td colspan="2" style="font-size:12px;"><b>' . $read->cust_name . '</b></td></tr>';
                $html .='<tr><td colspan="2">' . $read->cust_addr . '</td></tr>';
                $html .='<tr><td colspan="2">' . $read->cust_city . '-' . $read->cust_country . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $read->cust_phone . '</td><td><b>Fax : </b>' . $read->cust_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';

                $html .='<br /><br />';
                $html .='<table class="tables"><tr><td><table class="tables"><tr><td><h3 style="font-size:14px;">Penjualan Optional</h3></td></tr></table></td>'
                        . '<td><table class="tables" style="font-size:11px;">'
                        . '<tr><td>Nomor</td><td class="td-ro">:</td><td>' . $read->sal_inv_no . '</td></tr>'
                        . '<tr><td>Tanggal</td><td class="td-ro">:</td><td>' . $this->dateView($read->sal_date) . '</td></tr>'
                        . '</table></td>'
                        . '</tr>'
                        . '</table>';


                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="3"><hr /></td></tr>';
                $html .= '<tr>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Kendaraan</td><td class="td-ro">:</td><td width="110">' . $read->veh_name . '</td></tr>'
                        . '<tr><td>No. Rangka</td><td class="td-ro">:</td><td>' . $read->chassis . '</td></tr>'
                        . '<tr><td>No. Mesin</td><td class="td-ro">:</td><td>' . $read->engine . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Warna</td><td class="td-ro">:</td><td width="110">' . $read->color_name . '</td></tr>'
                        . '<tr><td>No. SPK</td><td class="td-ro">:</td><td>' . $read->so_no . '</td></tr>'
                        . '<tr><td>Tgl. SPK</td><td class="td-ro">:</td><td>' . $this->dateView($read->so_date) . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td width="50">Pelanggan</td><td class="td-ro">:</td><td width="110"></td></tr>'
                        . '<tr><td></td><td class="td-ro"></td><td></td></tr>'
                        . '<tr><td>Sales</td><td class="td-ro">:</td><td></td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '</tr>';

                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';


                $html .= '<table class="tables">';
                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';
                $html .= '<tr>'
                        . '<td width="15%"><b>Kode</b></td>'
                        . '<td width="40%"><b>Keterangan</b></td>'
                        . '<td align="right" width="15%"><b>Harga</b></td>'
                        . '<td  width="15%" align="right"><b> Disc(%)</b></td>'
                        . '<td  width="15%" align="right"><b>Netto</b></td>'
                        . '</tr>';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';

                $acc_wsld = $this->all_m->getWhere('acc_wsld', array($inv_code => $read->$inv_code));
                $no = 1;
                foreach ($acc_wsld as $wsld):
                    $html .= '<tr>'
                            . '<td>' . $wsld->wk_code . '</td>'
                            . '<td>' . $wsld->wk_desc . '</td>'
                            . '<td align="right">' . number_format($wsld->price_bd) . '</td>'
                            . '<td align="right">' . number_format($wsld->disc_pct) . '</td>'
                            . '<td align="right">' . number_format($wsld->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;

                $html .= '<tr><td colspan="5"></td></tr>';
                $html .= '<tr><td colspan="5"></td></tr>';
                $html .= '<tr><td colspan="5"></td></tr>';

                $html .= '</table>';
                $html .= '</td></tr>';

                $html .= '<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="5"><hr /></td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Sub Total:</b></td><td width="15%" align="right">' . number_format($read->inv_at) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Discount:</b></td><td width="15%" align="right">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td width="70%"></td><td width="15%" align="right"><b>Lain-lain:</b></td><td width="15%" align="right">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr>'
                        . '<td width="70%">'
                        . '</td>'
                        . '<td width="15%" align="right"><b>Grand Total:</b></td>'
                        . '<td width="15%" align="right">' . number_format($read->inv_total) . '</td></tr>';
                $html .= '</table>';
                $html .= '</td></tr>';
                $html .= '</table>';
                break;
        }

        if ($code_form !== '') {
            $html .= '<table class="tables">';
            $html .='<tr><td>';
            $html .= $this->set_form($code_form, $read);

            $html .='</td></tr>';
            $html .= '</table>';
        }
        
        $html .= '<table class="tables">';
        $html .='<tr><td><br /></td></tr>';
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $read->prn_cnt;

            $viewcnt = array(
                'user' => $user,
                'prn_cnt' => $prn_cnt,
                'action' => $data['action']
            );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer*/
         $html .= '</table>';
        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function checkWO() {
        $wo_no = $this->input->post('wo_no');
        $pur_inv_no = $this->input->post('pur_inv_no');
        $check = $this->all_m->check('acc_wprd', array('wo_no' => $wo_no, 'pur_inv_no' => $pur_inv_no));
        $res = array('count' => $check);
        $this->json($res);
    }

    function deleteNoWO() {
        $id = $this->input->post('id');
        $data = array(
            'wo_no' => '',
            'wo_date' => '',
            'chassis' => '',
            'engine' => '',
            'veh_type' => '',
            'veh_model' => '',
            'veh_code' => '',
            'veh_name' => '',
            'color_name' => '',
            'color_code' => '',
            'so_no' => '',
            'so_date' => '',
            'veh_transm' => '',
            'veh_year' => '',
            'srep_name' => '',
            'sal_inv_no' => ''
        );
        $this->all_m->updateData('acc_wprh', 'id', $id, $data);
        $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        $this->json($msg);
    }

    function check_sld() {
        $where = array('sal_inv_no' => $this->input->post('sal_inv_no'), 'wo_no' => NULL);
        $table = $this->input->post('table');
        $res = $this->all_m->countlimit($table, $where);

        $this->output->set_output($res);
    }

    function check_dp() {
        //$where = array('so_no' => $this->input->post('so_no'), 'use_date' => '0000-00-00', 'sal_inv_no'=> '');
        $table = $this->input->post('table');
        $so_no = $this->input->post('so_no');
        $sql = "SELECT count(*) as count, SUM(pay_val) as total_pay FROM $table WHERE so_no='$so_no' AND use_date is NULL AND sal_inv_no is NULL GROUP BY so_no";

        $result = $this->all_m->query_single($sql); 
        $res = array(
            'count' => $result->count,
            'total' => $result->total_pay
        );
        $this->json($res);
    }

}
