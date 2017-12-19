<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Vehicle extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function saveVehicleSale() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['so_no2']);
        unset($data['veh_at2']);
        unset($data['srv_at2']);
        unset($data['cls_date']);
        unset($data['cls_by']);
        unset($data['inv_total']);
        unset($data['bbnwo_no2']);
        unset($data['bbnpur_no2']);

        $res = true;

        $data['pick_date'] = $this->dateFormat($data['pick_date']);
        $data['match_date'] = $this->dateFormat($data['match_date']);
        $data['due_date'] = $this->dateFormat($data['due_date']);

        $data['stnk_bdate'] = $this->dateFormat($data['stnk_bdate']);
        $data['stnk_edate'] = $this->dateFormat($data['stnk_edate']);
        $data['so_date'] = $this->dateFormat($data['so_date']);
        $data['sj_date'] = $this->dateFormat($data['sj_date']);
        $data['kwit_date'] = $this->dateFormat($data['kwit_date']);
        $data['fp_date'] = $this->dateFormat($data['fp_date']);
        $data['crd_cntrdt'] = $this->dateFormat($data['crd_cntrdt']);

        if ($id == '') {
            $checkslh = $this->all_m->check($table, array('sal_inv_no' => $data['sal_inv_no']));

            if ($checkslh > 0) {
                $res = false;
                $msg = array('success' => false, 'message' => 'Sorry, invoice no. has been used');
            }
        }

        if ($res !== false) {
            $data['inv_total'] = $data['veh_total'] + $data['srv_at'] + $data['part_at'] + $data['inv_stamp'];
            $data['opn_date'] = date('Y-m-d');
            $data['cls_date'] = '0000-00-00';

            if ($id !== '') {
                //$check = $this->all_m->getId($table, 'id', $id);
                $check = $this->all_m->countlimit($table, array('id' => $id));
                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $data);
                    /* tambahan update veh_dpch belum dibuat */
                    if ($data['so_no'] !== '') {
                        $dpch = $this->all_m->getOne('veh_dpch', array('so_no' => $data['so_no']));
                        $price = intval($data['inv_total']);
                        $datadpch['veh_price'] = $price;
                        //$datadpch['pd_end'] = $price - intval($dpch->dp_end);
                        $this->all_m->updateData('veh_dpch', 'id', $dpch->id, $datadpch);
                    }
                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {
                unset($data['sal_inv_no']);
                $data['sal_inv_no'] = $this->all_m->inv_seq('4', 'VSL');
                $this->all_m->insertData($table, $data);
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VSL'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function pick_kendaraan() {

        $tbl = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $id = $this->uri->segment(5);
        $idstk = $this->uri->segment(6);

        $data = $this->input->post();
        $veh_prh = (array) $this->all_m->getId('veh_prh', 'pur_inv_no', $data['pur_inv_no']);

        unset($data['veh_at2']);
        unset($data['srv_at2']);
        unset($data['id']);
        unset($data['sal_inv_no']);
        unset($data['cls_date']);
        unset($data['cls_by']);

        $res = true;
        $slh = (array) $this->all_m->getId($tbl, 'id', $id);

        unset($slh['id']);
        unset($data['cls_date']);
        unset($data['cls_by']);

        $veh_stk = (array) $this->all_m->getId('veh_stk', 'pur_inv_no', $data['pur_inv_no']);

        if ($veh_stk['pick_date'] == '0000-00-00') {

            if ($slh['cust_name'] !== '') {
                $sal_inv_no = $slh['sal_inv_no'];

                foreach ($data as $k => $v) {

                    if (array_key_exists($k, $slh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }


                $data['sal_inv_no'] = $sal_inv_no;

                $data3 = array_combine($key, $val);
                unset($data3['opn_date']);
                /* update inv_total+accessories+lain-lain */
                $data3['inv_total'] = $data3['inv_total'] + $slh['part_at'] + $slh['inv_stamp'] + $slh['srv_at'];
                $data3['due_date'] = $veh_prh['due_date'];
                $data3['due_day'] = $veh_prh['due_day'];

                $veh_stk = $this->all_m->getId('veh_stk', 'id', $idstk);
                //$end_qty = $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - $veh_stk->pick_qty - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty;
                $end_qty = $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - 1 - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty;

                $res = $this->all_m->updateData($tbl, 'id', $id, $data3);

                $this->all_m->updateData('veh_slh', 'id', $id, array('pick_date' => date('Y-m-d')));
                $this->all_m->updateData('veh_stk', 'id', $idstk, array('pick_date' => date('Y-m-d'), 'sal_inv_no' => $sal_inv_no, 'pick_qty' => 1, 'end_qty' => $end_qty));
                $msg = array('success' => true, 'message' => 'Berhasil Pick kendaraan');
            } else {

                $checkspk = $this->all_m->check('veh_slh', array('so_no' => $data['so_no'], 'sal_inv_no' => $slh['sal_inv_no'], 'chassis' => $data['chassis']));

                if ($checkspk > 0) {
                    $res = false;
                }

                if ($res !== false) {


                    $sal_inv_no = $slh['sal_inv_no'];

                    foreach ($data as $k => $v) {

                        if (array_key_exists($k, $slh)) {
                            $key[] = $k;
                            $val[] = $v;
                        }
                    }


                    $data['sal_inv_no'] = $sal_inv_no;

                    $data3 = array_combine($key, $val);

                    unset($data3['opn_date']);

                    $spk = (array) $this->all_m->getId('veh_spk', 'so_no', $data['so_no']);
                    unset($spk['id']);
                    unset($spk['cls_date']);
                    unset($spk['cls_by']);
                    unset($spk['sal_inv_no']);

                    foreach ($spk as $k1 => $v1) {

                        if (array_key_exists($k1, $slh)) {
                            $key1[] = $k1;
                            $val1[] = $v1;
                        }
                    }

                    $data4 = array_combine($key1, $val1);
                    unset($data4['due_date']);
                    $veh_stk = $this->all_m->getId('veh_stk', 'so_no', $data3['so_no']);
                    $end_qty = $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - 1 - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty;

                    //Check Harga Master Kendaraan         
                    $price = $this->all_m->getOne('veh_prc', array('veh_code' => $spk['veh_code'], 'col_type' => $spk['color_type']));

                    $sal_bbn = $price->sal_bbn;
                    $sal_price = $price->sal_price;
                    $srv_at = $slh['srv_at'];
                    $veh_bt = $price->salb_price;
                    $veh_vat = $price->sal_vat;
                    $veh_pbm = $price->sal_pbm;
                    // $veh_at2

                    $data4['veh_bt'] = $veh_bt;
                    $data4['veh_vat'] = $veh_vat;

                    $data4['veh_price'] = $sal_price - $sal_bbn;
                    $data4['veh_at'] = $sal_price - $sal_bbn;
                    $data4['veh_total'] = $sal_price;
                    $data4['veh_bbn'] = $sal_bbn;
                    $data4['sovehprice'] = $spk['tot_price'];
                    /* update inv_total+accessories+lain-lain */
                    $data4['inv_total'] = $srv_at + $sal_price + $slh['part_at'] + $slh['inv_stamp'];
                    $data4['veh_pbm'] = $veh_pbm;
                    // print_r($price);exit;
                    //Update slh data stk
                    $data4['due_date'] = $veh_prh['due_date'];
                    $data4['due_day'] = $veh_prh['due_day'];

                    $res = $this->all_m->updateData($tbl, 'id', $id, $data3);
                    //Update slh data spk
                    $res = $this->all_m->updateData($tbl, 'id', $id, $data4);



                    $this->all_m->updateData('veh_slh', 'so_no', $data3['so_no'], array('pick_date' => date('Y-m-d')));
                    $this->all_m->updateData('veh_spk', 'so_no', $data3['so_no'], array('pick_date' => date('Y-m-d'), 'sal_inv_no' => $sal_inv_no));
                    $this->all_m->updateData('veh_stk', 'so_no', $data3['so_no'], array('pick_date' => date('Y-m-d'), 'sal_inv_no' => $sal_inv_no, 'pick_qty' => 1, 'end_qty' => $end_qty));
                    /* $sql = "UPDATE veh_stk 	SET veh_stk.pick_qty 	 = 1, 
                      veh_stk.end_qty      = veh_stk.beg_qty + veh_stk.pur_qty - veh_stk.rpur_qty - veh_stk.pick_qty - veh_stk.sal_qty + veh_stk.rsal_qty + veh_stk.opn_qty,
                      veh_stk.sal_inv_no   = veh_slh.sal_inv_no,
                      veh_stk.pick_date    = veh_slh.pick_date
                      WHERE  veh_stk.chassis = '$chassis'";
                      $this->all_m->query_single($sql); */
                    $veh_spkd = $this->all_m->getWhere('veh_spkd', array('so_no' => $data['so_no']));

                    foreach ($veh_spkd as $spkd) {
                        $veh_sld = array(
                            'so_no' => $spkd->so_no,
                            'so_date' => $spkd->so_date,
                            'wk_code' => $spkd->wk_code,
                            'wk_desc' => $spkd->wk_desc,
                            'price_bd' => $spkd->price_bd,
                            'disc_pct' => $spkd->disc_pct,
                            'disc_val' => $spkd->disc_val,
                            'price_ad' => $spkd->price_ad,
                            'srep_code1' => $spkd->srep_code1,
                            'srep_name1' => $spkd->srep_name1,
                            'add_by' => $spkd->add_by,
                            'add_date' => $spkd->add_date,
                            'sal_inv_no' => $sal_inv_no
                        );

                        $this->all_m->insertData('veh_sld', $veh_sld);
                    }
                    $msg = array('success' => true, 'message' => 'Vehicle has been Picked successfully');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed to Pick vehicle');
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'Selected stock, already Picked in another sales invoice', 'pick' => 'yes');
        }
        $this->json($msg);
    }

    function drop_kendaraan() {
        $stat = true;
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $so_no = $this->input->post('so_no');

        $slh = $this->all_m->getId($tbl, 'id', $id);
        $sal_inv_no = $slh->sal_inv_no;
        
        $check_wooptional = $this->all_m->countlimit('acc_woh', array('sal_inv_no' => $sal_inv_no));
         
        $check_sld = $this->all_m->countlimit('veh_sld', array('sal_inv_no' => $sal_inv_no));
        
        if ($slh->doc_inv_no !== NULL) {
            $msg = array('success' => false, 'message' => 'Sorry, The letters for this vehicle are in the process of making in : ' . $slh->doc_inv_no . '. so can not on Drop');
            $stat = false;
        }

        //if ($slh->bbnpur_no !== NULL) {
        if ($slh->bbnpur_no !== '') {

            $msg = array('success' => false, 'message' => 'Sorry this vehicle cannot be dropped because it has BBN Registration No. ' . $slh->bbnpur_no . ' Please Delete them first');
            $stat = false;
        }

        if ($slh->bbnwo_no !== '') {

            $msg = array('success' => false, 'message' => ' Sorry this vehicle cannot be dropped because it has BBN WO No. ' . $slh->bbnwo_no . ' Please Delete them first');
            $stat = false;
        }
        
        if ($check_wooptional > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice can not be dropped because already avaiable WO Optional. Please delete them first');
            $stat = false;
        }

        if ($check_sld > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be dropped because it has detail(s). Please delete them first');
            $stat = false;
        }

        if ($stat !== false) {

            $check = $this->all_m->countlimit('veh_spk', array('so_no' => $slh->so_no));

            if ($check > 0) {

                $spk = $this->all_m->getId('veh_spk', 'so_no', $slh->so_no);

                $veh_stk = $this->all_m->getId('veh_stk', 'sal_inv_no', $slh->sal_inv_no);

                $end_qty = $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - 0 - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty;


                $data4 = (array) $this->all_m->getId('veh_dpch', 'so_no', $slh->so_no);
                unset($data4['id']);
                unset($data4['so_no']);

                if ($data4) {
                    foreach ($data4 as $k1 => $v1) {

                        if (array_key_exists($k1, $slh)) {
                            $key1[] = $k1;
                            $val1[] = '';
                        }
                    }

                    $data5 = array_combine($key1, $val1);
                    $this->all_m->updateData('veh_dpch', 'so_no', $data3['so_no'], $data5);
                }

                unset($spk->id);


                foreach ($slh as $k => $v) {

                    if (array_key_exists($k, $spk)) {
                        $key[] = $k;
                        $val[] = '';
                    }
                }
                //print_r($spk);exit;
                $update = array_combine($key, $val);

                unset($update['loc_code']);
                unset($update['wrhs_code']);

                $update['veh_bt'] = 0;
                $update['veh_vat'] = 0;
                $update['veh_price'] = 0;
                $update['veh_at'] = 0;
                $update['veh_total'] = 0;
                $update['veh_bbn'] = 0;
                $update['veh_pbm'] = 0;
                $update['sovehprice'] = 0;
                $update['inv_total'] = $slh->part_at + $slh->inv_stamp;
                $update['stdoptcode'] = '';
                $update['stdoptname'] = '';
                $update['due_day'] = '';
                $update['due_date'] = '0000-00-00';
                $update['alarm'] = '';
                $update['key_no'] = '';
                $update['serv_book'] = '';
                $update['salpaytype'] = NULL;
                //$update['loc_code'] = '';

                unset($update['cls_date']);
                unset($update['cls_by']);
                unset($update['sal_inv_no']);
                //print_r($update);exit;
                //$this->all_m->updateData('veh_stk', 'so_no', $slh->so_no, array('pick_date' => ''));
                $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, array('pick_date' => '0000-00-00', 'sal_inv_no' => '', 'pick_qty' => 0, 'end_qty' => $end_qty));
                $this->all_m->updateData('veh_spk', 'so_no', $slh->so_no, array('pick_date' => '', 'sal_inv_no' => ''));

                $veh_sld = $this->all_m->getWhere('veh_sld', array('sal_inv_no' => $sal_inv_no));

                foreach ($veh_sld as $sld) {
                    $this->all_m->deleteData('veh_sld', 'id', $sld->id);
                }

                $this->all_m->updateData('veh_slh', 'id', $slh->id, $update);

                $check = $this->all_m->countlimit($tbl, array('so_no' => $so_no));

                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Failed to Drop vehicle');
                } else {
                    $msg = array('success' => true, 'message' => 'Vehicle has been Dropped successfully');
                }
            } else {
                $veh_stk = $this->all_m->getId('veh_stk', 'sal_inv_no', $slh->sal_inv_no);

                $end_qty = $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - 0 - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty;


                $stk = (array) $veh_stk;
                unset($stk['id']);
                $slh = (array) $slh;
                unset($slh['sal_inv_no']);

                foreach ($stk as $k => $v) {

                    if (array_key_exists($k, $slh)) {
                        $key[] = $k;
                        $val[] = '';
                    }
                }



                $update = array_combine($key, $val);
                $update['due_day'] = '';
                $update['due_date'] = '0000-00-00';
                $update['alarm'] = '';
                $update['key_no'] = '';
                $update['serv_book'] = '';

                $res = $this->all_m->updateData($tbl, 'id', $id, $update);

                $this->all_m->updateData('veh_slh', 'id', $id, array('pick_date' => '0000-00-00'));
                $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, array('pick_date' => '0000-00-00', 'sal_inv_no' => '', 'pick_qty' => 0, 'end_qty' => $end_qty));
                $msg = array('success' => true, 'message' => 'Berhasil Pick kendaraan');

                $msg = array('success' => true, 'message' => 'Drop Kendaraan berhasil');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save_sld() {
        $sal_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $wk_code = $this->input->post('wk_code');
        $table = $this->input->post('table2');

        if ($wk_code !== '') {
            $check = $this->all_m->countlimit($table, array('sal_inv_no' => $sal_inv_no, 'wk_code' => $wk_code));

            if ($check > 0) {

                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
            } else {

                $check = $this->all_m->countlimit('veh_slh', array('sal_inv_no' => $sal_inv_no));

                if ($check > 0) {
                    $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $sal_inv_no);
                    $srv_price = $veh_slh->srv_price + intval($this->input->post('price_ad'));
                    $srv_disc = $veh_slh->srv_disc;
                    $srv_bt = $srv_price - $srv_disc;

                    //$srv_vat = $srv_bt / 10;
                    $srv_vat = $this->vat($srv_bt);
                    $srv_at = $srv_bt + $srv_vat;

                    $inv_total = $veh_slh->veh_total + $srv_at + $veh_slh->part_at + $veh_slh->inv_stamp;

                    $data_slh = array(
                        'srv_price' => $srv_price,
                        'srv_disc' => $srv_disc,
                        'srv_bt' => $srv_bt,
                        'srv_vat' => $srv_vat,
                        'srv_at' => $srv_at,
                        'inv_total' => $inv_total
                    );

                    //print_r($data_slh);exit;
                    $data['sal_inv_no'] = $sal_inv_no;
                    $data['wk_code'] = $wk_code;
                    $data['wk_desc'] = $this->input->post('wk_desc');

                    $data['price_bd'] = $this->input->post('price_bd');
                    $data['disc_pct'] = $this->input->post('disc_pct');
                    $data['disc_val'] = $this->input->post('disc_val');
                    $data['price_ad'] = $this->input->post('price_ad');
                    $data['add_by'] = $user;
                    $data['add_date'] = date('Y-m-d');
                    $data['so_no'] = $veh_slh->so_no;
                    $data['so_date'] = $veh_slh->so_date;
                    $this->all_m->insertData($table, $data);

                    $this->all_m->updateData('veh_slh', 'sal_inv_no', $sal_inv_no, $data_slh);
                    $msg = array('success' => true, 'message' => 'Record saved');
                } else {
                    $msg = array('success' => false, 'message' => 'failed');
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Work Code');
        }

        $this->json($msg);
    }

    function check_sld() {
        $where = array('sal_inv_no' => $this->uri->segment(3));
        $table = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $res = $this->all_m->countlimit($table, $where);

        $this->output->set_output($res);
    }

    function check_dpcd() {
        $where = array('sal_inv_no' => $this->input->post('sal_inv_no'));
        $table = $this->input->post('table');
        $res = $this->all_m->countlimit($table, $where);

        $this->output->set_output($res);
    }

    /*
      function get_number() {
      $code = $this->uri->segment(4);
      $number = $this->all_m->inv_seq('4', $code);
      $this->output->set_output($number);
      }
     */

    function deleteVehicleSale() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $slh = $this->all_m->getId($tbl, 'id', $id);
        $sal_inv_no = $slh->sal_inv_no;

        $stat = true;
        $check_sld = $this->all_m->countlimit('veh_sld', array('sal_inv_no' => $sal_inv_no));

        $check_acc_slh = $this->all_m->countlimit('acc_slh', array('sal_inv_no' => $sal_inv_no));

        if ($check_acc_slh > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Sales Invoice cannot be deleted');
        }


        if ($slh->bbnpur_no !== '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Sales Invoice cannot be deleted');
        }

        if ($slh->bbnwo_no !== '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Sales Invoice cannot be deleted');
        }

        if ($check_sld > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, this Sales Invoice cannot be deleted because it has detail(s). Please delete them first');
        }


        if ($stat !== false) {
            $this->all_m->updateData('veh_stk', 'so_no', $slh->so_no, array('pick_date' => ''));
            $this->all_m->updateData('veh_spk', 'so_no', $slh->so_no, array('pick_date' => '', 'sal_inv_no' => ''));



            $this->all_m->deleteData($tbl, 'id', $id);

            $check = $this->all_m->countlimit($tbl, array('id' => $id));

            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete success');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function uncloseVehicleSale() {
        $user = $this->uri->segment(4);
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['so_no2']);
        unset($data['veh_at2']);
        unset($data['srv_at2']);
        unset($data['bbnwo_no2']);
        unset($data['bbnpur_no2']);

        $stat = true;

        $veh_slh = (array) $this->all_m->getId($tbl, 'id', $id);
        $sal_inv_no = $veh_slh['sal_inv_no'];

        $check_rslh = $this->all_m->countlimit('veh_rslh', array('sal_inv_no' => $sal_inv_no));

        $check_ard = $this->all_m->countlimit('veh_ard', array('sal_inv_no' => $sal_inv_no));

        $check_comapd = $this->all_m->countlimit('veh_comapd', array('sal_inv_no' => $sal_inv_no));

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        if ($check_rslh > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have Sales Return. Please delete them first');
            $stat = false;
        }

        if ($check_comapd > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have commission payable payment(s). Please delete them first');
            $stat = false;
        }

        if ($check_ard > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have receivable payment(s). Please delete them first');
            $stat = false;
        }

        $check_argd = $this->all_m->countlimit('veh_argd', array('sal_inv_no' => $sal_inv_no));

        if ($check_argd > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have receivable payment(s). Please delete them first');
            $stat = false;
        }

        if ($stat !== false) {
            $date = '';

            $veh_stk = $this->all_m->getOne('veh_stk', array('sal_inv_no' => $data['sal_inv_no'], 'chassis' => $data['chassis']));
            $veh_spk = $this->all_m->getOne('veh_spk', array('sal_inv_no' => $data['sal_inv_no'], 'so_no' => $data['so_no']));

            $sal_qty = $veh_stk->sal_qty - 1;
            $pick_qty = $veh_stk->pick_qty + 1;

            $data_stk = array(
                'pick_qty' => $pick_qty,
                'sal_qty' => $sal_qty,
                'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - $pick_qty - $sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty,
                'sal_date' => ''
            );
            $update = array(
                'sal_date' => $date,
                'cls_date' => $date,
                'cls_by' => ''
            );

            $this->all_m->deleteData('veh_comaph', 'sal_inv_no', $sal_inv_no);
            $this->all_m->deleteData('veh_arh', 'sal_inv_no', $sal_inv_no);
            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $data_stk);
            $this->all_m->updateData('veh_spk', 'id', $veh_spk->id, array('sal_date' => $date));
            $this->all_m->updateData($tbl, 'id', $id, $update);

            $msg = array('success' => true, 'message' => 'Sales invoice has been unclosed successfully');
        }

        $this->json($msg);
    }

    function closeVehicleSale() {
        $date = date('Y-m-d');
        $user = $this->uri->segment(4);
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['so_no2']);
        unset($data['veh_at2']);
        unset($data['srv_at2']);
        unset($data['bbnwo_no2']);
        unset($data['bbnpur_no2']);


        $data['pick_date'] = $this->dateFormat($data['pick_date']);
        $data['match_date'] = $this->dateFormat($data['match_date']);
        $data['due_date'] = $this->dateFormat($data['due_date']);

        $data['stnk_bdate'] = $this->dateFormat($data['stnk_bdate']);
        $data['stnk_edate'] = $this->dateFormat($data['stnk_edate']);
        $data['so_date'] = $this->dateFormat($data['so_date']);
        $data['sj_date'] = $this->dateFormat($data['sj_date']);
        $data['kwit_date'] = $this->dateFormat($data['kwit_date']);
        $data['fp_date'] = $this->dateFormat($data['fp_date']);
        $data['crd_cntrdt'] = $this->dateFormat($data['crd_cntrdt']);

        $sql_arh = "SHOW COLUMNS FROM veh_arh";
        $veh_arh = $this->all_m->query_all($sql_arh);


        foreach ($veh_arh as $arh) {
            $field_arh[$arh->Field] = '';
        }
        unset($field_arh['id']);

        $veh_slh = (array) $this->all_m->getId($tbl, 'id', $id);
        $sal_inv_no = $veh_slh['sal_inv_no'];
        unset($veh_slh['id']);

        $veh_stk = $this->all_m->getId('veh_stk', 'sal_inv_no', $sal_inv_no);
        $pick_qty = $veh_stk->pick_qty - 1;

        $veh_prh = $this->all_m->getId('veh_prh', 'pur_inv_no', $veh_stk->pur_inv_no);

        $res = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotClose();
        }

        if ($data['salpaytype'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Sorry, Please select Transaction Cash or Credit ');
        }

        $check_acc_slh = $this->all_m->countlimit('acc_slh', array('sal_inv_no' => $sal_inv_no));


        if ($check_acc_slh > 0) {

            $acc_slh = $this->all_m->getId('acc_slh', 'sal_inv_no', $sal_inv_no);
            if ($acc_slh->cls_date == '0000-00-00' || $acc_slh->cls_date == null) {
                $res = false;
                $msg = array('success' => false, 'message' => 'Sorry, Vehicle Accessories Sales not closed');
            }
        }

        if ($veh_prh->cls2_date == '0000-00-00' || $veh_prh->cls2_date == null) {
            $res = false;
            $msg = array('success' => false, 'message' => 'Sorry, Chassis ' . $data['chassis'] . ' not closed in Purchase Invoice No. ' . $veh_stk->pur_inv_no . '. to continue, Please closed Purchase Invoice');
        }

        if ($veh_stk->pur_qty < 0) {
            $res = false;
            $msg = array('success' => false, 'message' => 'Unable to close invoice. It has no stock');
        }

        if ($data['due_date'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Please input TOP Date');
        } else {
            if (intval(strtotime($data['due_date'])) < intval(strtotime(date('Y-m-d')))) {
                $res = false;
                $msg = array('status' => false, 'message' => 'Sorry, TOP Date has to be the same or after today\'s date');
            }
        }

        if ($data['due_day'] == '') {
            $data['due_day'] = 0;
        }


        if ($res !== false) {

            $res = $this->all_m->updateData($tbl, 'id', $id, $data);
            $veh_slh = (array) $this->all_m->getId($tbl, 'id', $id);
            $sal_qty = $veh_stk->sal_qty + 1;
            $pick_qty = $veh_stk->pick_qty - 1;
            $newdatastk = array(
                'pick_qty' => $pick_qty,
                'sal_qty' => $sal_qty,
                'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - $pick_qty - $sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty,
                'sal_date' => $date
            );

            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $newdatastk);

            foreach ($veh_slh as $k => $v) {

                if (array_key_exists($k, $field_arh)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            /* data veh_arh */
            $newdata_arh = array_combine($key, $val);
            $newdata_arh['pd_begin'] = $newdata_arh['inv_total'];
            $newdata_arh['pd_end'] = $newdata_arh['inv_total'] - $newdata_arh['pd_paid'] - $newdata_arh['pd_disc'];
            $newdata_arh['veh_price'] = $newdata_arh['veh_total'];
            $newdata_arh['cls_date'] = $date;
            $newdata_arh['sal_date'] = $date;
            /* insert veh_arh */
            $this->all_m->insertData('veh_arh', $newdata_arh);
            $veh_dpcd = $this->all_m->getWhere('veh_dpcd', array('so_no' => $veh_slh['so_no']));


            /* Looping DPCD */
            foreach ($veh_dpcd as $dpcd) {

                $veh_ard = array(
                    'sal_inv_no' => $sal_inv_no,
                    'sal_date' => $date,
                    'pay_date' => date('Y-m-d'),
                    'pay_type' => $dpcd->pay_type,
                    'bank_code' => $dpcd->bank_code,
                    'check_no' => $dpcd->check_no,
                    'check_date' => $dpcd->check_date,
                    'due_date' => $dpcd->due_date,
                    'pay_val' => $dpcd->pay_val,
                    'pay_desc' => $dpcd->pay_desc,
                    'edc_code' => $dpcd->edc_code,
                    'coll_code' => $dpcd->coll_code,
                    'add_by' => $user,
                    'add_date' => date('Y-m-d'),
                    'dp_inv_no' => $dpcd->dp_inv_no,
                    'dp_date' => $dpcd->dp_date,
                    'dppay_date' => $dpcd->pay_date,
                    'pay_bt' => $dpcd->pay_bt,
                    'pay_vat' => $dpcd->pay_vat,
                    'pay_bbn' => $dpcd->pay_bbn,
                    'dpfp_no' => $dpcd->fp_no,
                    'dpfp_date' => $dpcd->fp_date,
                    'payer_name' => $dpcd->payer_name,
                    'payer_addr' => $dpcd->payer_addr,
                    'payer_area' => $dpcd->payer_area,
                    'payer_city' => $dpcd->payer_city,
                    'payer_zipc' => $dpcd->payer_zipc
                );

                if ($dpcd->sal_inv_no == NULL) {

                    $pay_val += $dpcd->pay_val;
                    $used_val += $dpcd->pay_val;

                    $veh_arh = $this->all_m->getId('veh_arh', 'sal_inv_no', $veh_slh['sal_inv_no']);


                    $pd_paid = $veh_arh->pd_paid + $dpcd->pay_val;
                    $pd_disc = $veh_arh->pd_disc + $dpcd->disc_val;
                    $total = $veh_arh->pd_begin - $pd_paid - $pd_disc;

                    $newdata_arh2['pd_paid'] = $pd_paid;
                    $newdata_arh2['pd_disc'] = $pd_disc;
                    $newdata_arh2['pd_end'] = $total;


                    $this->all_m->updateData('veh_dpcd', 'id', $dpcd->id, array('use_date' => $date, 'sal_inv_no' => $sal_inv_no, 'sal_date' => $date, 'used_val' => $dpcd->pay_val));

                    $veh_dpch = $this->all_m->getId('veh_dpch', 'dp_inv_no', $dpcd->dp_inv_no);

                    $dp_paid = $veh_dpch->dp_paid;
                    $dp_used = $veh_dpch->dp_used + $dpcd->pay_val;
                    $dp_end = $dp_paid - $dp_used;

                    $datadpch = array(
                        //'dp_paid' => $dp_paid,
                        'dp_used' => $dp_used,
                        'dp_end' => $dp_end
                    );

                    $this->all_m->updateData('veh_dpch', 'id', $veh_dpch->id, $datadpch);

                    $this->all_m->insertData('veh_ard', $veh_ard);
                    $this->all_m->updateData('veh_arh', 'id', $veh_arh->id, $newdata_arh2);
                }
            }

            $veh_dpch = $this->all_m->getId('veh_dpch', 'sal_inv_no', $sal_inv_no);
            //$dp_end = $veh_dpch->dp_begin + $pay_val - $used_val;

            $data_dpch = array(
                //'dp_paid' => $pay_val,
                //'dp_used' => $used_val,
                // 'dp_end' => $dp_end,
                'sal_date' => $date,
                'sal_inv_no' => $sal_inv_no
            );
            $this->all_m->updateData('veh_dpch', 'id', $veh_dpch->id, $data_dpch);

            $this->all_m->updateData('veh_spk', 'so_no', $veh_slh['so_no'], array('sal_date' => $date));

            $data['sal_date'] = $date;
            $data['cls_date'] = $date;
            $data['cls_by'] = $user;
            $data['cls_cnt'] = $veh_slh['cls_cnt'] + 1;

            $res = $this->all_m->updateData($tbl, 'id', $id, $data);

            //insert payable commision
            if ($data['comm_val'] !== 0) {

                $sql_comaph = "SHOW COLUMNS FROM veh_comaph";
                $veh_comaph = $this->all_m->query_all($sql_comaph);

                foreach ($veh_comaph as $comaph) {
                    $field_comaph[$comaph->Field] = '';
                }
                unset($field_comaph['id']);

                foreach ($veh_slh as $k1 => $v1) {

                    if (array_key_exists($k1, $field_comaph)) {
                        $key1[] = $k1;
                        $val1[] = $v1;
                    }
                }

                /* data veh_arh */
                $newdata_comaph = array_combine($key1, $val1);
                $newdata_comaph['sal_date'] = $date;
                $newdata_comaph['cls_date'] = $date;
                $newdata_comaph['pay2_name'] = $data['medtr_name'];
                $newdata_comaph['pay2_addr'] = $data['medtr_addr'];
                $newdata_comaph['hd_begin'] = $data['comm_val'];
                $newdata_comaph['hd_paid'] = 0;
                $newdata_comaph['hd_disc'] = 0;
                $newdata_comaph['hd_pph'] = 0;
                $newdata_comaph['hd_end'] = $data['comm_val'];

                $this->all_m->insertData('veh_comaph', $newdata_comaph);
            }
            $res = true;

            if ($res) {
                $msg = array('success' => true, 'message' => 'Sales Invoice has been closed successfully');
            } else {
                $msg = array('success' => false, 'message' => 'Failed to close sales invoice');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deleteOptional() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $sal_inv_no = $this->input->post('sal_inv_no');
        $veh_sld = $this->all_m->getId($table, 'id', $id);

        $state = true;

        if ($veh_sld->wo_no !== NULL) {
            $state = false;
            $msg = array('success' => false, 'message' => 'Sorry, Optional cannot be deleted because it already has WO in: ' . $veh_sld->wo_no);
        }

        if ($state !== false) {
            $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $sal_inv_no);
            $srv_price = $veh_slh->srv_price - $veh_sld->price_ad;
            $srv_disc = $veh_slh->srv_disc;
            $srv_bt = $srv_price - $srv_disc;
            //$srv_bt = ($veh_slh->srv_bt - $veh_sld->price_ad) - $srv_disc;
            //$srv_vat = $srv_bt / 10;
            $srv_vat = $this->vat($srv_bt);
            $srv_at = $srv_bt + $srv_vat;

            $inv_total = $veh_slh->veh_total + $srv_at + $veh_slh->part_at + $veh_slh->inv_stamp;

            $data_slh = array(
                'srv_price' => $srv_price,
                'srv_disc' => $srv_disc,
                'srv_bt' => $srv_bt,
                'srv_vat' => $srv_vat,
                'srv_at' => $srv_at,
                'inv_total' => $inv_total
            );
            // print_r($data_slh);exit;
            $this->all_m->updateData('veh_slh', 'sal_inv_no', $sal_inv_no, $data_slh);

            $this->all_m->deleteData($table, 'id', $id);

            $check = $this->all_m->countlimit($table, array('id' => $id));
            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete success');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function load_invoice() {
        $year = null;
        $mounth = null;
        
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        if($this->input->post('year')){
            $year = $this->input->post('year');
        }
        if($this->input->post('mounth')){
            $mounth = $this->input->post('mounth');
        }
        
        $dbs = $this->getDataHistory($year, $mounth);
        
        $veh_slh = $this->all_m->getId($dbs.'.'.$tbl, 'id', $id);
        $veh_dpch = $this->all_m->getId($dbs.'.veh_dpch', 'so_no', $veh_slh->so_no);
        $veh_arh = $this->all_m->getId($dbs.'.veh_arh', 'sal_inv_no', $veh_slh->sal_inv_no);
        $veh_dpcd = $this->all_m->getWhere($dbs.'.veh_dpcd', array('so_no' => $veh_slh->so_no));

        foreach ($veh_dpcd as $dpcd) {
            $pay_val += $dpcd->pay_val;
            $used_val += $dpcd->used_val;
        }

        // print_r($veh_dpcd);exit;
        $data = array(
            'salpaytype' => $veh_slh->salpaytype,
            'wrhs_code' => $veh_slh->wrhs_code,
            'key_no' => $veh_slh->key_no,
            'veh_name' => $veh_slh->veh_name,
            'cust_name' => $veh_slh->cust_name,
            'cust_rname' => $veh_slh->cust_rname,
            'cust_type' => $veh_slh->cust_type,
            'lease_name' => $veh_slh->lease_name,
            'lease_code' => $veh_slh->lease_code,
            'chassis' => $veh_slh->chassis,
            'inv_total' => $veh_slh->inv_total,
            'lease_name' => $veh_slh->lease_name,
            'lease_code' => $veh_slh->lease_code,
            'crd_cntrno' => $veh_slh->crd_cntrno,
            'crd_cntrdt' => $veh_slh->crd_cntrdt,
            'crd_amount' => $veh_slh->crd_amount,
            'pd_begin' => $veh_arh->pd_begin,
            'pd_paid' => $veh_arh->pd_paid,
            'pd_disc' => $veh_arh->pd_disc,
            'pd_end' => $veh_arh->pd_end,
            'pay_val' => $pay_val,
            'used_val' => $used_val
        );

        //echo '<pre>';print_r($veh_arh);echo'</pre>';exit;
        $this->json($data);
    }

    function outputpdf() {
        $font = 'helvetica';
        $action = $this->uri->segment(7);

        $tbl = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $id = $this->uri->segment(5);
        
        $year = null;
        $mounth = null;
        
        $data['tbl'] =  $tbl;
        $data['id'] =  $id;
        $data['user'] =  $this->uri->segment(6);
        $data['action'] =  $action;
        
        $data['year'] = null;
        $data['mounth'] = null;
        
        $prn_cnt = 'prn_cnt';
        $c_array = array();
        $table = encrypt_decrypt('decrypt', $this->uri->segment(4));

        switch ($table) {
            case 'veh_slh';

                if ($this->uri->segment(8)) {
                    $prn_cnt = 'prn_cnt_sj';
                    $act = 'sj';
                    $data_type = $this->uri->segment(8);
                    $filename = 'Surat Jalan_';
                    $font = 'Courier';
                    
                    if($this->uri->segment(9)){
                        $data['mounth'] = $this->uri->segment(9);
                    }
                    if($this->uri->segment(10)){
                         $data['year'] = $this->uri->segment(10);
                    }
                
                    if ($action == 'download' || $action == 'print') {
                        $veh_slh = $this->all_m->getId($table, 'id', $this->uri->segment(5));

                        if ($veh_slh->sj_no == '') {
                            $d['sj_no'] = $this->all_m->inv_seq('4', 'VDO');
                            $d['sj_date'] = date('Y-m-d');
                            $this->all_m->updateData($table, 'id', $this->uri->segment(5), $d);

                            $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VDO'));
                            $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));
                        }
                    }
                } else {
                    $act = 'faktur';
                    $data_type = '';
                    $filename = 'Faktur_Penjualan_Kendaraan_';
                }

                $read = $this->htmlreadVehicleSale($data, $act, $data_type);
                $output = array(
                    'html' => $read['html'],
                    'filename' => $filename . $read['number'],
                    'title' => 'Faktur Penjualan Kendaraan ' . $read['number']
                );
                break;

            case 'veh_movh':
                $read = $this->htmlreadMove($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'VMV_' . $read['number'],
                    'title' => 'VMV ' . $read['number']
                );
                break;
                $c_array['prn_by'] = $data['user'];

            case 'veh_po':
                $read = $this->htmlreadPO($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'PO_' . $read['number'],
                    'title' => 'PO ' . $read['number']
                );

                break;

            case 'veh_prh':
                $faktur = $this->uri->segment(8);

                if ($faktur == 'pembelian') {
                    $read = $this->htmlreadPembelian($data);
                    $output = array(
                        'html' => $read['html'],
                        'filename' => 'Faktur_Pembelian_' . $read['number'],
                        'title' => 'Faktur Pembelian ' . $read['number']
                    );
                    $c_array['prn2_by'] = $data['user'];
                    $prn_cnt = 'prn2_cnt';
                }

                if ($faktur == 'penerimaan') {
                    $read = $this->htmlreadPenerimaan($data);
                    $output = array(
                        'html' => $read['html'],
                        'filename' => 'Faktur_Penerimaan_' . $read['number'],
                        'title' => 'Faktur Penerimaan ' . $read['number']
                    );

                    $c_array['prn_by'] = $data['user'];
                }

                break;

            case 'veh_rslh':
                $read = $this->htmlreadReturPenjualan($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Retur_Penjualan_Kendaraan_' . $read['number'],
                    'title' => 'Retur Penjualan Kendaraan ' . $read['number']
                );

                break;

            case 'veh_rprh':
                $read = $this->htmlreadReturPembelian($data);
                $output = array(
                    'html' => $read['html'],
                    'filename' => 'Retur_Pembelian_Kendaraan_' . $read['number'],
                    'title' => 'Retur Pembelian Kendaraan ' . $read['number']
                );
                break;
        }

        if ($action !== 'screen') {
            $this->count_prnt($data, $c_array, $prn_cnt);
        }
        $html = $output['html'];

        $this->output_pdf($output['title'], $html, $output['filename'], $action, null, $font);
    }

    function htmlreadVehicleSale($data, $act, $data_type) {
        $year = $data['year'];
        $mounth = $data['mounth'];
        
        $dbs = $this->getDataHistory($year, $mounth);
         
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        $veh_slh = $this->all_m->getId($dbs.'.'.$tbl, 'id', $id);
        
        $row = (array) $veh_slh;
        $sal_date = $this->dateView($veh_slh->sal_date);
        $due_date = $this->dateView($veh_slh->due_date);
        $so_date = $this->dateView($veh_slh->so_date);

        $html = '';

        if ($act == 'faktur') {

            $html .='<h3>Faktur Penjualan Kendaraan</h3>';
            $html .='<table border="0" class="tables">';

            $html .='<tr>';
            $html .='<td width="120">';
            $html .='<table style="padding-left:5pt;" border="1">';
            $html .='<tr><td height="23"><b>No. Faktur : </b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>' . $veh_slh->sal_inv_no . '</b></td></tr>';
            $html .='<tr><td height="23"><b>Tgl. Faktur : </b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $sal_date . '</td></tr>';
            $html .='<tr><td height="23"><b>Tgl.Jatuh Tempo :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $due_date . '</td></tr>';
            $html .='<tr><td height="23"><b>No. Surat Pesanan :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $veh_slh->so_no . '</td></tr>';
            if ($so_date[2] != 0) {
                $html .='<tr><td height="23"><b>Tgl. Surat Pesanan :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $so_date . '</td></tr>';
            } else {
                $html .='<tr><td height="23"><b>Tgl. Surat Pesanan :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>';
            }
            $html .='<tr><td height="25"><b>Kode Wiraniaga :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $veh_slh->srep_code . '</td></tr>';
            $html .='</table>';
            $html .='</td>';

            $html .='<td width="10"></td>';

            $html .= '<td width="75%">
                        <table class="tables" border="1">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td width="100"><b>Nama Pemesan</b></td><td class="td-ro"><b>:</b></td><td>' . $veh_slh->cust_name . '</td></tr>
                                    <tr><td><b>Alamat</b></td><td class="td-ro"><b>:</b></td><td width="250" height="36">' . $veh_slh->cust_addr . '<br />' . $veh_slh->cust_city . '-' . $veh_slh->cust_cntry . '</td></tr>
                                    <tr><td><b>Telp./HP</b></td><td class="td-ro"><b>:</b></td><td>' . $veh_slh->cust_phone . '</td></tr>
                                    <tr><td><b>NPWP</b></td><td class="td-ro"><b>:</b></td><td>' . $veh_slh->cust_npwp . '</td></tr>
                                </table>
                             </td>
                           </tr>
                           <tr>
                             <td style="border-top:1px solid #000;">
                                <table class="tables">
                                    <tr><td width="100"><b>Nama di STNK</b></td><td class="td-ro">:</td><td width="305">' . $veh_slh->cust_rname . '</td></tr>
                                    <tr><td><b>Telp.</b></td><td class="td-ro">:</td><td>' . $veh_slh->cust_rphon . '</td></tr>
                                    <tr><td></td></tr>
                                </table>
                             </td>
                           </tr>
                        </table>
                    </td>';
            $html .='</tr>';

            $html .='<tr><td>';

            $html .='<table class="tables" style="border:1px solid #000;">';
            $html .= '<tr>'
                    . '<th width="40" style="border-right:1px solid #000;border-bottom:0.5px solid #000;"><b>No.</b></th>'
                    . '<th width="300" style="border-right:1px solid #000;border-bottom:0.5px solid #000;"><b>Keterangan</b></th>'
                    . '<th width="40" style="border-right:1px solid #000;border-bottom:0.5px solid #000;" class="right"><b>Qty</b></th>'
                    . '<th width="150" style="border-bottom:1px solid #000;" class="right"><b>Harga</b></th>'
                    . '</tr>';
            $html .='<tr>';
            $html .='<td style="border-right:1px solid #000;">1.</td>';
            $html .='<td style="border-right:1px solid #000;">';
            $html .='<table>';
            $html .='<tr><td><b>Kendaraan</b></td><td width="10">:</td><td>' . $veh_slh->veh_brand . ' ' . $veh_slh->veh_name . '</td></tr>';
            $html .='<tr><td>Warna</td><td width="10">:</td><td>' . $veh_slh->color_name . '</td></tr>';
            $html .='<tr><td>Tahun</td><td width="10">:</td><td>' . $veh_slh->veh_year . '</td></tr>';
            $html .='<tr><td>No. Rangka</td><td width="10">:</td><td>' . $veh_slh->chassis . '</td></tr>';
            $html .='<tr><td>No. Mesin</td><td width="10">:</td><td>' . $veh_slh->engine . '</td></tr>';
            $html .='<tr><td>No. Kunci/Alarm</td><td width="10">:</td><td>' . $veh_slh->key_no . '</td></tr>';
            $html .='</table>';
            $html .='</td>';
            $html .='<td class="right" style="border-right:1px solid #000;">1</td>';
            $html .='<td class="right">' . rupiah($veh_slh->veh_bt) . '</td>';
            $html .='</tr>';
            $html .='<tr><td border="0" style="border-right:1px solid #000;"></td><td border="0" style="border-right:1px solid #000;">Dasar Pengenaan Pajak</td><td border="0" style="border-right:1px solid #000;"></td><td class="right">' . rupiah($veh_slh->veh_bt) . '</td></tr>';
            $html .='<tr><td style="border-right:1px solid #000;"></td><td style="border-right:1px solid #000;">Pajak Pertambahan Nilai</td><td style="border-right:1px solid #000;"></td><td class="right">' . rupiah($veh_slh->veh_vat) . '</td></tr>';
            $html .='<tr><td style="border-right:1px solid #000;"></td><td style="border-right:1px solid #000;">Titipan BBN</td><td style="border-right:1px solid #000;"></td><td class="right">' . rupiah($veh_slh->veh_bbn) . '</td></tr>';
            $html .='<tr><td colspan="2" style="border-top:1px solid #000;"><b>Terbilang:</b> # ' . terbilang($veh_slh->veh_total) . ' #</td><td style="border-top:1px solid #000;"><b>Jumlah</b></td><td class="right" style="border:1px solid #000;">' . rupiah($veh_slh->veh_total) . '</td></tr>';
            $html .='</table>';

            $html .='</td></tr>';

            $html .='</table>';
            $html .='<p><b>Ketentuan:</b></p>';
            $html .='<p></p><p></p><p></p><p></p><p></p><p></p><p></p>';

            $html .= $this->set_form('VSL');
            /*
              $html .='<table class="tables">';
              $html .='<tr><td width="115" class="center"><b>Di Terima Oleh</b></td><td width="300"></td><td width="115" class="center"><b>Hormat Kami,</b></td></tr>';
              $html .='<tr><td></td><td></td><td></td></tr>';
              $html .='<tr><td></td><td></td><td></td></tr>';
              $html .='<tr><td></td><td></td><td></td></tr>';
              $html .='<tr><td>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td>'
              . '<td></td><td>( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</td></tr>';
              $html .='</table>';
             */
            $html .='<br /><br /><br />';
            $html .='<table class="tables">';
            $html .='<tr><td>Lembar 1: Customer/Bank</td><td>Lembar 2: Dealer</td><td>Lembar 3: Arsip</td><td></td></tr>';
            $html .='</table>';
        } elseif ($act == 'sj') {
            if ($data_type == 'pelanggan') {
                $name = $veh_slh->cust_name;
                $addr = $veh_slh->cust_addr;

                if ($veh_slh->cust_phone !== '' && $veh_slh->cust_hp !== '') {
                    $phone1 = $veh_slh->cust_phone;
                } else {
                    $phone1 = '';
                }

                if ($veh_slh->cust_hp !== '') {
                    if ($phone1 !== '') {
                        $phone2 = ' / ' . $veh_slh->cust_hp;
                    } else {
                        $phone2 = $veh_slh->cust_hp;
                    }
                } else {
                    $phone2 = '';
                }

                $phone = $phone1 . $phone2;
            } elseif ($data_type == 'stnk') {
                $name = $veh_slh->cust_rname;
                $addr = $veh_slh->cust_raddr;
                $phone = $veh_slh->cust_rphon;
            } elseif ($data_type == 'debitur') {
                $name = $veh_slh->lease_name;
                $addr = $veh_slh->lease_addr;
                $phone = $veh_slh->lcp1_name;
            }

            $number = $this->all_m->inv_seq('4', 'VDO');

            if ($data['action'] !== 'screen') {
                if ($veh_slh->sj_no !== '') {
                    $number = $veh_slh->sj_no;
                }
            }


            $html .='<h3 style="text-align:center">SURAT JALAN</h3><br /><br />';
            $html .='<table class="tables">';
            $html .='<tr>';

            $html .='<td width="60%">';
            $html .='<table class="tables">'
                    . '<tr><td><b>Kepada Yth:</b></td></tr>'
                    . '<tr><td><b>' . $name . '</b></td></tr>'
                    . '<tr><td>' . $addr . '</td></tr>'
                    . '<tr><td></td></tr>'
                    . '<tr><td>HP : ' . $phone . '</td></tr>'
                    . '</table>';
            $html .='</td>';

            $html .='<td width="40%">';
            $html .='<table class="tables">'
                    . '<tr><td width="50"><b>Nomor</b></td><td>:&nbsp;&nbsp;<b>' . $number . '</b></td></tr>'
                    . '<tr><td><b>Tanggal</b></td><td>:&nbsp;&nbsp;' . date('d/m/Y') . '</td></tr>'
                    . '<tr><td><b>No. SPK</b></td><td>:&nbsp;&nbsp;<b>' . $veh_slh->so_no . '</b></td></tr>';
            if ($so_date[2] != 0) {
                $html .='<tr><td><b>Tgl. SPK</b></td><td>:&nbsp;&nbsp;' . $so_date . '</td></tr>';
            } else {
                $html .='<tr><td><b>Tgl. SPK</b></td><td>:&nbsp;&nbsp;</td></tr>';
            }
            $html .='<tr><td><b>Leasing</b></td><td width="150">:&nbsp;&nbsp;' . $veh_slh->lease_name . '</td></tr>'
                    . '</table>';
            $html .='</td>';

            $html .='</tr>';

            $html .='<tr><td colspan="2">Harap diterima satu kendaraan di bawah ini, dalam keadaan 100% baru  tanpa cacat:</td></tr>';
            $html .='<tr>';

            $html .= '<td width="280" valign="top">'
                    . '<table>'
                    . '<tr><td width="50">Merek/Type</td><td width="10">:</td><td width="200">' . $veh_slh->veh_brand . ' ' . $veh_slh->veh_type . '  </td></tr>'
                    . '<tr><td>Model/Tahun</td><td width="10">:</td><td>' . $veh_slh->veh_model . ' ' . $veh_slh->veh_year . '</td></tr>'
                    . '<tr><td>Keterangan</td><td width="10">:</td><td>' . $veh_slh->veh_name . '</td></tr>'
                    . '<tr><td>Warna</td><td width="10">:</td><td>' . $veh_slh->color_name . '</td></tr>'
                    . '</table>'
                    . '</td>';

            $html .= '<td  valign="top">'
                    . '<table>'
                    . '<tr><td>No. Rangka</td><td width="10">:</td><td width="200">' . $veh_slh->chassis . '</td></tr>'
                    . '<tr><td>No. Mesin</td><td width="10">:</td><td>' . $veh_slh->engine . '</td></tr>';
            $html .= '<tr><td></td><td width="10">:</td><td></td></tr>';
            if ($veh_slh->srep_name !== '') {
                $html .= '<tr><td>Sales</td><td width="10">:</td><td>' . $veh_slh->srep_name . '</td></tr>';
            }
            $html .= '</table>'
                    . '</td>';

            $html .= '</tr>';

            $html .='<tr><td colspan="2"></td></tr>';
            $html .='</table>';

            $html .='<table class="tables">';
            $html .='<tr colspan="2"><td><b>Perlengkapan Optional / Aksesoris / Lain-Lain:</b></td></tr>';

            $veh_sld = $this->all_m->getWhere($dbs.'.veh_sld', array('sal_inv_no' => $veh_slh->sal_inv_no));
            $no = 1;
            foreach ($veh_sld as $sld):

                $html .= '<tr>';
                $html .= '<td width="20">' . $no . '.</td>';
                $html .= '<td>' . $sld->wk_desc . '</td>';
                $html .= '</tr>';
                $no++;

            endforeach;

            $html .='<tr><td colspan="2"></td></tr>';
            $html .='<tr><td colspan="2"></td></tr>';
            $html .='<tr><td colspan="2"></td></tr>';
            $html .='</table>';
            $html .= $this->perlengkapan();
            /*
              $html .='<table class="tables">';
              $html .='<tr><td colspan="3"><b>Perlengkapan Standart:</b></td></tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="ASBAK" ><input>ASBAK</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KACA SPION" ><input>KACA SPION DALAM</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="ANTENA" ><input>ANTENA</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KIPAS" ><input>KIPAS KACA (WIPER)</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KUNCI KONTAK" ><input>KUNCI KONTAK/PINTU</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="RADIO/LOUD SPEAKER" ><input>RADIO/LOUD SPEAKER</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KACA" ><input>KACA DEPAN-BELAKANG</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="EMBLEM DEPAN" ><input>EMBLEM DEPAN/BLK/STR</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="BUMPER DEPAN" ><input>BUMPER DEPAN/BELAKANG</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KARPET" ><input>KARPET</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="PENYULUT ROKOK" ><input>PENYULUT ROKOK (LIGHTER)</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KACA SPION LUAR" ><input>KACA SPION LUAR KIRI-KANAN</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="DONGKRAK" ><input>DONGKRAK, KUNCI RODA, GAGANG</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="WHEEL DOP" ><input>WHEEL DOP/WHEEL RIM</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="PENAHAN LUMPUR" ><input>PENAHAN LUMPUR (MUDGUARD)</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="INTERIOR" ><input>INTERIOR/DASHBOARD</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KACA PINTU" ><input>KACA PINTU DPN-BLK, KA-KI</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="SEAT BELT DPN" ><input>SEAT BELT DPN/BLK/KN/KR</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="BUKU PETUNUK" ><input>BUKU PETUNJUK MOBIL/AUDIO</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="ASBAK" ><input>P3K &  SEGITIGA PENGAMAN</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="ASBAK" ><input>PENAHAN MATAHARI / SUNVISOR</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="JOK SANDARAN" ><input>JOK SANDARAN KEPALA</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="KLAKSON" ><input>KLAKSON</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="BAN DEPAN BELAKANG" ><input>BAN DEPAN BELAKANG (CADANGAN)</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="CENTRAL DOOR" ><input>CENTRAL DOOR LOCK</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="AIR CONDITION" ><input>AIR CONDITION</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="LAMPU DEPAN" ><input>LAMPU DEPAN /DLM/BLK/KN/KR</td>'
              . '</tr>';
              $html .='<tr>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="BUKU SERVICE" ><input>BUKU SERVICE * SMILE CAMPAIGN</td>'
              . '<td><input type="checkbox" name="checkbox" id="checkbox" value="GANTUNGAN KUNCI" ><input>GANTUNGAN KUNCI</td>'
              . '<td></td>'
              . '</tr>';
              $html .='</table><br /><br /><br />';
             */
            /* $html .='<table class="tables">';
              $html .='<tr><td width="50"><b>Catatan:</b></td><td width="500">APABILA ITEM YANG TERTULIS DISATAS ADA YANG KURANG SESUDAH MOBIL SERAH TERIMA, SEDANGKAN FORM INI SUDAH DITANDATANGANI PEMBELI, MAKA ITEM TERSEBUT TIDAK DAPAT DI KLAIM</td></tr>';
              $html .='</table><br /><br /><br /><br /><br />';
             */
            $html .= $this->set_form('VDO');
            /* $html .='<table class="tables">';
              $html .='<tr>'
              . '<td class="center">Security / Driver</td>'
              . '<td class="center">Diserahkan Oleh:</td>'
              . '<td class="center">Mengetahui,</td>'
              . '<td class="center">Penerima</td>'
              . '</tr>';
              $html .='<tr><td></td><td></td><td></td><td></td></tr>';
              $html .='<tr><td></td><td></td><td></td><td></td></tr>';
              $html .='<tr><td></td><td></td><td></td><td></td></tr>';

              $html .='<tr>'
              . '<td class="center"><table><tr><td>(</td><td></td><td>)</td></tr></table></td>'
              . '<td class="center"><table><tr><td>(</td><td></td><td>)</td></tr></table></td>'
              . '<td class="center"><table><tr><td>(</td><td></td><td>)</td></tr></table></td>'
              . '<td class="center"><table><tr><td>(</td><td></td><td>)</td></tr></table></td>'
              . '</tr>';
              $html .='<tr>'
              . '<td class="center bold">SECURITY / DRIVER</center> <br />Tgl :&nbsp;&nbsp;/&nbsp;&nbsp;/</td>'
              . '<td class="center bold">SALESMAN <br />Tgl :&nbsp;&nbsp;/&nbsp;&nbsp;/</td>'
              . '<td class="center bold">ADMINISTRATION HEAD <br />Tgl :&nbsp;&nbsp;/&nbsp;&nbsp;/</td>'
              . '<td class="center bold">CUSTOMER <br />Tgl :&nbsp;&nbsp;/&nbsp;&nbsp;/</td>'
              . '</tr>';
              $html .='</table>'; */
            $html .='<br /><br /><br />';
            $html .='<table class="tables"  style="border-top:1px solid black;">';
            $html .='<tr><td width="160">Lembar 1: Dealer / Main Dealer</td><td width="180">Lembar 2: Petugas Gudang & Security</td><td>Lembar 3: Pelanggan</td></tr>';
            

        
            $html .='</table>';

            if ($data['action'] !== 'screen') {
                if ($veh_slh->sj_no == '') {
                    $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VDO'));
                    $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));
                    $this->all_m->updateData($dbs.'.'.$data['tbl'], 'id', $read->id, array('sj_no' => $number, 'sj_date' => date('Y-m-d')));
                }
            }
        }
        
        $html .='<table class="tables">';
        $html .='<tr><td><br /></td></tr>';
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

            $viewcnt = array(
                'user' => $user,
                'prn_cnt' => $prn_cnt,
                'action' => $data['action']
            );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer*/
        
        $html .='</table>';
        $output = array(
            'html' => $html,
            'number' => $veh_slh->sal_inv_no
        );

        return $output;
    }

    function perlengkapan() {
        $vehsjitm = (array) $this->all_m->getId('vehsjitm', 'id', 1);
        $sjnote = $vehsjitm['sj_note'];
        unset($vehsjitm['id']);
        unset($vehsjitm['sj_note']);
        unset($vehsjitm['dlt_by']);
        unset($vehsjitm['dlt_date']);
        unset($vehsjitm['locked_by']);
        unset($vehsjitm['locked_date']);
        /// echo count($vehsjitm)
        $item = '';
        $html = '<table class="tables">';
        $html .='<tr><td colspan="3"><b>Perlengkapan Standart:</b></td></tr>';

        $count = $this->all_m->countlimit('vehsjitm', array('id' => 1));

        if ($count > 0) {

            for ($i = 1; $i <= count($vehsjitm); $i++) {
                $item = '';

                if ($vehsjitm["sj_item" . $i] !== '') {
                    $item .='<tr><td><input type="checkbox" name="checkbox" id="checkbox" value="' . $vehsjitm["sj_item" . $i] . '" >' . $vehsjitm["sj_item" . $i] . '</td></tr>';
                } else {
                    $item .='';
                }

                if ($i <= 12) {
                    $item1[] = $item;
                }
                if ($i > 12 && $i <= 24) {
                    $item2[] = $item;
                }
                if ($i > 24 && $i <= 35) {
                    $item3[] = $item;
                }
                /*
                  if ($i <= 3) {
                  $item1[] = $item;
                  }
                  if ($i > 3 && $i <= 6) {
                  $item2[] = $item;
                  }
                  if ($i > 6 && $i <= 9) {
                  $item3[] = $item;
                  }
                  if ($i > 9 && $i <= 12) {
                  $item4[] = $item;
                  }
                  if ($i > 12 && $i <= 15) {
                  $item5[] = $item;
                  }
                  if ($i > 15 && $i <= 18) {
                  $item6[] = $item;
                  }
                  if ($i > 18 && $i <= 21) {
                  $item7[] = $item;
                  }
                  if ($i > 21 && $i <= 24) {
                  $item8[] = $item;
                  }
                  if ($i > 24 && $i <= 27) {
                  $item9[] = $item;
                  }
                  if ($i > 27 && $i <= 30) {
                  $item10[] = $item;
                  }
                  if ($i > 30 && $i <= 33) {
                  $item11[] = $item;
                  }
                  if ($i > 33 && $i <= 35) {
                  $item12[] = $item;
                  }
                 */
            }

            $html .= '<tr>';

            $html .= '<td valign="top"><table class="tables">';
            foreach ($item1 as $html1):
                $html .= $html1;
            endforeach;
            $html .= '</table></td>';

            $html .= '<td valign="top"><table class="tables">';
            foreach ($item2 as $html2):
                $html .= $html2;
            endforeach;
            $html .= '</table></td>';

            $html .= '<td valign="top"><table class="tables">';
            foreach ($item3 as $html3):
                $html .= $html3;
            endforeach;
            $html .= '</table></td>';

            $html .= '</tr>';
            /*
              $html .= '<tr>';
              foreach ($item1 as $html1):
              $html .= $html1;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item2 as $html2):
              $html .= $html2;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item3 as $html3):
              $html .= $html3;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item4 as $html4):
              $html .= $html4;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item5 as $html5):
              $html .= $html5;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item6 as $html6):
              $html .= $html6;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item7 as $html7):
              $html .= $html7;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item8 as $html8):
              $html .= $html8;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item9 as $html9):
              $html .= $html9;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item10 as $html10):
              $html .= $html10;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item11 as $html11):
              $html .= $html11;
              endforeach;
              $html .= '</tr>';

              $html .= '<tr>';
              foreach ($item12 as $html12):
              $html .= $html12;
              endforeach;
              $html .= '</tr>';

             */
        }
        $html .='</table><br /><br /><br />';


        $html .='<table class="tables" >';
        $html .='<tr><td width="50"><b>Catatan:</b></td><td width="480">' . $sjnote . '</td></tr>';
        $html .='</table><br /><br /><br /><br /><br />';
        return $html;
    }

    function savePO() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $data['qty'] = 1;
        $data['due_date'] = $this->dateFormat($data['due_date']);
        $data['pred_stk_d'] = $this->dateFormat($data['pred_stk_d']);

        $res = true;

        $checkpo = $this->all_m->check('veh_po', array('po_no' => $data['po_no']));

        if ($id == '') {
            if ($checkpo > 0) {
                $res = false;
                $msg = array('success' => false, 'message' => 'PO No.:' . $data['po_no'] . ' has already been used');
            }
        }
        if ($data['supp_code'] == '' || $data['supp_name'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => ' Please input Supplier Name & Code');
        }
        if ($data['veh_code'] == '' || $data['veh_name'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Please input Vehicle Code & Name');
        }
        if ($data['color_code'] == '' || $data['color_name'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Please input Color Code & Name');
        }

        $supp = $this->all_m->getId('veh_supp', 'supp_code', $data['supp_code']);
        $addr = '';
        $phone = '';
        $city = '';
        $zipc = '';
        
        if ($supp->postaddr == 1) {
            $addr = $supp->oaddr;
            $phone = $supp->ophone;
            $city = $supp->ocity;
            $zipc = $supp->ozipcode;
        }
        if ($supp->postaddr == 2) {
            $addr = $supp->haddr;
            $phone = $supp->hphone;
            $city = $supp->hcity;
            $zipc = $supp->hzipcode;
            $data['hp'] = $supp->hp;
        }

        $data['addr'] = $addr;
        $data['phone'] = $phone;
        $data['city'] = $city;
        $data['zipcode'] = $zipc;
 
        
        if ($res !== false) {

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
                unset($data['po_no']);
                $data['pur_inv_no'] = '';
                $data['stk_date'] = '';
                $data['po_no'] = $this->all_m->inv_seq('4', 'VPO');
                $this->all_m->insertData($table, $data);
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPO'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function deletePO() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_po = $this->all_m->getId($table, 'id', $id);

        if ($veh_po->pur_inv_no !== '') {
            $msg = array('success' => false, 'message' => 'Sorry, PO cannot be closed because it has been used in vehicle receiving no.: ' . $veh_po->pur_inv_no);
        }

        if ($msg['success'] !== false) {
            $this->all_m->deleteData($table, 'id', $id);

            $check = $this->all_m->countlimit($table, array('id' => $id));

            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPO'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no - 1));

                $msg = array('success' => true, 'message' => 'Delete success');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function closePO() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $user = $this->uri->segment(4);

        $veh_po = (array) $this->all_m->getId($table, 'id', $id);
        unset($veh_po['id']);
        $veh_po['po_date'] = date('Y-m-d');
        $veh_po['cls_by'] = $user;
        $veh_po['cls_date'] = date('Y-m-d');
        $veh_po['cls_cnt'] = $veh_po['cls_cnt'] + 1;
        $veh_po['beg_qty'] = 1;
        $veh_po['rcv_qty'] = 0;
        $veh_po['end_qty'] = $veh_po['beg_qty'] + $veh_po['rcv_qty'];

        $res = true;
        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotClose();
        }

        if ($res !== false) {
            $this->all_m->insertData('veh_poo', $veh_po);

            $check = $this->all_m->countlimit($table, array('id' => $id));
            if ($check > 0) {
                $this->all_m->updateData($table, 'id', $id, $veh_po);
                $msg = array('success' => true, 'message' => 'PO has been closed successfully');
            } else {
                $msg = array('success' => false, 'message' => 'Failed to close PO');
            }
        }
        $this->json($msg);
    }

    function unclosePO() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_po = (array) $this->all_m->getId($table, 'id', $id);
        $veh_po['cls_by'] = '';
        $veh_po['cls_date'] = '';
        $veh_po['po_date'] = '';

        $res = true;
        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotUnClose();
        }

        if ($veh_po['pur_inv_no'] !== '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Sorry, PO cannot be closed because it has been used in vehicle receiving no.: ' . $veh_po['pur_inv_no']);
        }

        if ($res !== false) {
            $check = $this->all_m->countlimit($table, array('id' => $id));

            if ($check > 0) {
                $this->all_m->updateData($table, 'id', $id, $veh_po);
                $this->all_m->deleteData('veh_poo', 'po_no', $veh_po['po_no']);
                $msg = array('success' => true, 'message' => 'PO successfully unclosed');
            } else {
                $msg = array('success' => false, 'message' => 'PO failed unclosed');
            }
        }

        $this->json($msg);
    }

    function htmlreadPO($data) {
        $table = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];
        $row = (array) $this->all_m->getId($table, 'id', $id);
        
        $html = '';
        $html .= $this->readhtmlcompany();
        
        $html .= '<h3>Order Pembelian Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= '<td width="120">'
                . '<table border="1" class="tables">'
                . '<tr><td><b>No. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['po_no'] . '</td></tr>'
                . '<tr><td><b>Tgl. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['po_date']) . '</td></tr>'
                . '<tr><td><b>Tgl.J.Tempo :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['due_date']) . '</td></tr>'
                . '<tr><td><b>Tgl. Perkiraan Stok :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['pred_stk_d']) . '</td></tr>'
                . '</table></td>';
        $html .= '<td>'
                . '<table class="tables" border="1"  width="410">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td class="bold" width="100">NAMA PEMESAN</td><td width="305">:&nbsp;&nbsp;' . $row['supp_name'] . '</td></tr>
                                    <tr><td class="bold">ALAMAT</td><td>:&nbsp;&nbsp;' . $row['addr'] . '</td></tr>
                                    <tr><td class="bold">TELP./HP</td><td>:&nbsp;&nbsp;' . $row['phone'] . '/' . $row['hp'] . '</td></tr>
                                    <tr><td class="bold">NPWP</td><td>:&nbsp;&nbsp;' . $row['npwp'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                </table>
                             </td>
                           </tr>
                           
                        </table>'
                . '</td>';

        $html .= '</tr>';
        $html .= '</table><br /><br />';

        $html .= '<table class="tables">';
        $html .= '<tr><td>';
        $html .= '<table class="tables" width="580" style="border:1px solid #000;width:100%;">';
        $html .= '<tr>
                        <th border="1" colspan="3" class="center">Keterangan</th>
                        <th border="1" width="50" class="right">Qty</th>
                        <th border="1" class="right">Harga Satuan</th>
                        <th border="1" class="right">Harga</th>
                  </tr>';

        $html .= '<tr>
                        <td><b>Kendaraan</b></td>
                        <td class="td-ro"><b>:</b></td>
                        <td width="183.5">' . $row['veh_name'] . '</td>
                        <td rowspan="4"  style="border:1px solid #000;" class="right">1 UNIT</td>
                        <td rowspan="4" class="right" style="border:1px solid #000;">' . rupiah($row['unit_price']) . '</td>
                        <td rowspan="4" class="right" style="border:1px solid #000;">' . rupiah($row['tot_price']) . '</td>
                  </tr>';
        $html .= '<tr>
                            <td><b>Tipe</b></td>
                            <td class="td-ro">:</td>
                            <td>' . $row['veh_type'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                  </tr>';

        $html .= '<tr>
                            <td><b>Model</b></td>
                             <td width="8">:</td>
                            <td>' . $row['veh_model'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Warna</b></td>
                             <td width="8">:</td>
                            <td>' . $row['color_name'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td style="text-align: right !important;" width="92"><b>Jumlah:</b></td>
                            <td class="right">' . rupiah($row['tot_price']) . '</td>
                        </tr>';

        $html .= '</table>';
        $html .='</td></tr>';
        $html .= '</table>';
        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VPO');

        $html .='</td></tr>';
        
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];
       
            
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
            'number' => $row['po_no']
        );

        return $output;
    }

    function checkpur() {
        $po_no = $this->input->post('po_no');
        $count = $this->all_m->countlimit('veh_prh', array('po_no' => $po_no));
        $this->json(array('count' => $count));
    }

    function savePenerimaan($page) {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $reset = $this->input->post('reset');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['reset']);

        $data['po_date'] = $this->dateFormat($data['po_date']);
        $data['pred_stk_d'] = $this->dateFormat($data['pred_stk_d']);
        $data['sji_date'] = $this->dateFormat($data['sji_date']);
        $data['kwiti_date'] = $this->dateFormat($data['kwiti_date']);
        $data['fpi_date'] = $this->dateFormat($data['fpi_date']);
        $data['dni_date'] = $this->dateFormat($data['dni_date']);
        $data['do_date'] = $this->dateFormat($data['do_date']);
        $data['pdi_date'] = $this->dateFormat($data['pdi_date']);
        $data['due_date'] = $this->dateFormat($data['due_date']);
        $data['stk_date'] = $this->dateFormat($data['stk_date']);

        $data['sji2_date'] = $this->dateFormat($data['sji2_date']);
        $data['kwiti2date'] = $this->dateFormat($data['kwiti2date']);
        $data['fpi2_date'] = $this->dateFormat($data['fpi2_date']);
        $data['dni2_date'] = $this->dateFormat($data['dni2_date']);

        if ($page == 'penerimaan') {
            $data['cls_date'] = '0000-00-00';
            $data['cls2_date'] = '0000-00-00';
        }
        if ($page == 'pembelian') {
            $data['cls2_date'] = '0000-00-00';
        }


        $stat = true;
        //$data['pur_date'] = date('Y-m-d');

        if ($reset == 1) {
            //$qry = "SELECT purb_price, puro_price, pur_pbm, pur_vat, pur_pph, pur_misc, pur_price FROM veh_prc WHERE veh_code='" . $data['veh_code'] . "' and col_type='" . $data['color_type'] . "' ";
            //$veh_prc = $this->all_m->query_single($qry);
            $veh_prc = $this->all_m->getOne('veh_prc', array('veh_code' => $data['veh_code'], 'col_type' => $data['color_type']));

            $sql_prh = "SHOW COLUMNS FROM veh_prh";
            $veh_prh = $this->all_m->query_all($sql_prh);

            foreach ($veh_prh as $prh) {
                $field_prh[$prh->Field] = '';
            }
            unset($field_prh['id']);

            $countprice = $this->all_m->countlimit('veh_prc', array('veh_code' => $data['veh_code'], 'col_type' => $data['color_type']));
            if ($countprice > 0) {
                foreach ($veh_prc as $k => $v) {

                    if (array_key_exists($k, $field_prh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                /* data veh_arh */
                $combine = array_combine($key, $val);
                foreach ($combine as $combk => $combv) {
                    $data[$combk] = $combv;
                }

                /*
                  $data['pur_pbm'] = $veh_prc->pur_pbm;
                  $data['pur_vat'] = $veh_prc->pur_vat;
                  $data['pur_pph'] = $veh_prc->pur_pph;
                  $data['pur_misc'] = $veh_prc->pur_misc;
                  $data['pur_price'] = $veh_prc->pur_price; */

                $data['unit_price'] = $veh_prc->pur_price;
                $data['tot_price'] = $veh_prc->pur_price;
                $data['pur_base'] = $veh_prc->purb_price;
                $data['pur_opt'] = $veh_prc->puro_price;
                $data['pur_bt'] = $veh_prc->purb_price + $veh_prc->puro_price;
            }
        }

        if ($id == '') {
            $checkpo = $this->all_m->check('veh_prh', array('po_no' => $data['po_no']));

            if ($checkpo > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'PO No. has already been used');
            }

            $checkprh = $this->all_m->check('veh_prh', array('pur_inv_no' => $data['pur_inv_no']));

            if ($checkprh > 0) {
                $prhdata = $this->all_m->getId($table, 'pur_inv_no', $data['pur_inv_no']);
                $stat = false;
                $msg = array('success' => false, 'message' => 'Invoice No. has already been used', 'status' => 'exist', 'inv_no_id' => $prhdata->id);
            }
        }
        //print_r($data);exit;
        if ($data['loc_code'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Please input Vehicle Location');
        }
        if ($data['chassis'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Please input Chassis No.');
        }
        if ($data['engine'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Please input Engine No.');
        }

        if ($data['po_no'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Please input PO No.');
        }

        if ($stat !== false) {
            $podata = $this->all_m->getId('veh_po', 'po_no', $data['po_no']);
            $datapo = array(
                
            );
            
            if ($id !== '') {

                //$check = $this->all_m->getId($table, 'id', $id);
                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $veh_prh = $this->all_m->getId($table, 'id', $id);

                    /* empty po exists */
                    $this->all_m->updateData('veh_po', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));
                    $this->all_m->updateData('veh_poo', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));
                    /* update new po */
                    // print_r($data);exit;
                    $this->all_m->updateData($table, 'id', $id, $data);
                    $this->all_m->updateData('veh_po', 'po_no', $data['po_no'], array('pur_inv_no' => $data['pur_inv_no']));
                    $this->all_m->updateData('veh_poo', 'po_no', $data['po_no'], array('pur_inv_no' => $data['pur_inv_no']));

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $stat = false;
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {

                //  print_r($data);exit;
                $data['opn_date'] = date('Y-m-d');
                unset($data['pur_inv_no']);
                $data['pur_inv_no'] = $this->all_m->inv_seq('4', 'VPR');
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPR'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                
                $this->all_m->updateData('veh_po', 'po_no', $data['po_no'], array('pur_inv_no' => $data['pur_inv_no']));
                $this->all_m->updateData('veh_poo', 'po_no', $data['po_no'], array('pur_inv_no' => $data['pur_inv_no']));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function closePenerimaan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $user = $this->uri->segment(4);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotClose();
        }

        if ($msg['success'] !== false) {
            $veh_prh = (array) $this->all_m->getId($table, 'id', $id);
            unset($veh_prh['id']);

            if ($veh_prh['po_no'] !== '') {
                $sql_arh = "SHOW COLUMNS FROM veh_stk";
                $veh_stk = $this->all_m->query_all($sql_arh);

                foreach ($veh_stk as $stk) {
                    $field_stk[$stk->Field] = '';
                }
                unset($field_stk['id']);


                $veh_prh['cls_by'] = $user;
                $veh_prh['cls_date'] = date('Y-m-d');
                $veh_prh['stk_date'] = date('Y-m-d');
                $veh_prh['cls_cnt'] = $veh_prh['cls_cnt'] + 1;

                foreach ($veh_prh as $k => $v) {

                    if (array_key_exists($k, $field_stk)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                /* data veh_arh */
                $newdata_stk = array_combine($key, $val);
                //print_r($newdata_stk);exit;
                $newdata_stk['wrhs_orig'] = $veh_prh['wrhs_code'];
                $newdata_stk['loc_orig'] = $veh_prh['loc_code'];
                $newdata_stk['match_date'] = '0000-00-00';
                $newdata_stk['pick_date'] = '0000-00-00';
                $newdata_stk['so_no'] = '0';
                $newdata_stk['beg_qty'] = 0;
                $newdata_stk['pur_qty'] = 1;
                $newdata_stk['rpur_qty'] = 0;
                $newdata_stk['pick_qty'] = 0;
                $newdata_stk['sal_qty'] = 0;
                $newdata_stk['rsal_qty'] = 0;
                $newdata_stk['opn_qty'] = 0;
                $newdata_stk['end_qty'] = 1;
                $newdata_stk['stk_code'] = 'OH';
                $newdata_stk['pur_date'] = date('Y-m-d');
                $newdata_stk['opn_date'] = date('Y-m-d');
                $newdata_stk['sal_inv_no'] = '';



                //print_r($newdata_stk);exit;
                $this->all_m->insertData('veh_stk', $newdata_stk);

                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $veh_prh);
                    $this->all_m->updateData('veh_po', 'po_no', $veh_prh['po_no'], array('stk_date' => $veh_prh['stk_date']));
                    $this->all_m->updateData('veh_poo', 'po_no', $veh_prh['po_no'], array('stk_date' => $veh_prh['stk_date']));
                    $msg = array('success' => true, 'message' => 'Invoice has been closed successfully');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed to close invoice');
                }
            } else {
                $msg = array('success' => false, 'message' => 'Please input PO No.');
            }
        }
        $this->json($msg);
    }

    function unclosePenerimaan() {

        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_prh = $this->all_m->getId($table, 'id', $id);
        $veh_stk = $this->all_m->getOne('veh_stk', array('pur_inv_no' => $veh_prh->pur_inv_no, 'chassis' => $veh_prh->chassis));
        // print_r($veh_stk);exit;
        $match_date = $veh_stk->match_date;
        $prn_cnt = $veh_prh->prn_cnt;
        $ispd = $veh_prh->is_paid;
        $id = $veh_prh->id;
        $pur_date = $veh_prh->pur_date;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($veh_prh->cls2_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, invoice cannot be unclosed because Purchase invoice has been closed. Please unclose it first');
        }

        if ($match_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, unable to unclose invoice because it has been matched with SPK No. <b>' . $veh_stk->so_no . '</b>.<br /> Please unmatch it first');
        }

        if ($pur_date != 0000 - 00 - 00) {
            $msg = array('success' => false, 'message' => 'Sorry, invoice cannot be unclosed because Purchase invoice has been closed. Please unclose it first');
        }
        if ($prn_cnt > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to unclose invoice because it has been printed');
        }
        if ($ispd == 1) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to unclose this invoice because it has payment(s).<br/>Please delete them first , "id":"' . $id . '"');
        }


        if ($msg['success'] !== false) {
            $qry_dlt = "delete from veh_stk where pur_inv_no='" . $veh_prh->pur_inv_no . "' AND chassis='" . $veh_prh->chassis . "' ";
            $hsl_qry_dlt = mysql_query($qry_dlt);

            if (mysql_affected_rows() == 0) {
                $msg = array('success' => false, 'message' => 'cannot delete from stock, "id":"' . $id . '"');
            }

            if ($msg['success'] !== false) {
                $qry_upd = "update veh_prh set cls_by='" . $user . "', cls_date='0000-00-00', stk_date='0000-00-00', is_paid=0, stk_date='0000-00-00' where pur_inv_no='" . $veh_prh->pur_inv_no . "'";
                $hsl_qry_upd = mysql_query($qry_upd);

                if (mysql_affected_rows() > 0) {
                    $msg = array('success' => true, 'message' => 'Invoice has been unclosed successfully');
                } else {
                    $msg = array('success' => false, 'message' => 'Cannot unclosed');
                }
            } else {
                $msg = $msg;
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deletePenerimaan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_prh = $this->all_m->getId($table, 'id', $id);

        $this->all_m->updateData('veh_po', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));
        $this->all_m->updateData('veh_poo', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));

        $this->all_m->deleteData($table, 'id', $id);

        $check = $this->all_m->countlimit($table, array('id' => $id));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            // $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VPR'));
            //$this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no - 1));

            $msg = array('success' => true, 'message' => 'Delete success');
        }

        $this->json($msg);
    }

    function closePembelian() {
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $date = date('Y-m-d');
        
        $veh_prh = $this->all_m->getId($table, 'id', $id);
        $stk_date = explode('-', $veh_prh->stk_date);
        $stk_date1 = $stk_date[0] . $stk_date[1];

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($stk_date1 !== date('Ym')) {
            $msg = array('success' => false, 'message' => 'Sorry, Purchase has to be closed in the same month and year as its receiving');
        }

        if ($veh_prh->cls_date == '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, unable to close invoice because its receiving has not been closed. Please close it first');
        }

        if ($veh_prh->tot_price != $veh_prh->pur_price) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to close invoice because purchase price total has to be the same with vehicle price detail');
        }

        if ($veh_prh->pur_date > date("m/j/Y")) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to close invoice <br/>before PO date');
        }

        if ($veh_prh->cls2_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Sorry, unable to close invoice because it has been closed by other user');
        }

        if ($msg['success'] !== false) {
            $sql_aph = "SHOW COLUMNS FROM veh_aph";
            $veh_aph = $this->all_m->query_all($sql_aph);

            foreach ($veh_aph as $aph) {
                $field_aph[$aph->Field] = '';
            }
            unset($field_aph['id']);

            foreach ($veh_prh as $k => $v) {

                if (array_key_exists($k, $field_aph)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            /* data veh_aph */
            $newdata_aph = array_combine($key, $val);

            $newdata_aph['pur_date'] = date('Y-m-d');
            $newdata_aph['cls_date'] = date('Y-m-d');

            $newdata_aph['inv_total'] = $veh_prh->unit_price;
            $newdata_aph['hd_begin'] = $veh_prh->tot_price;
            $newdata_aph['hd_paid'] = 0;
            $newdata_aph['hd_disc'] = 0;
            $newdata_aph['hd_end'] = $veh_prh->pur_price;
            $newdata_aph['pinv_code'] = 'VPR';
            $newdata_aph['apv_inv_no'] = '';
            $newdata_aph['apg_inv_no'] = '';


            $newdata_prh = array(
                'pur_date' => date("Y-m-d"),
                'cls2_cnt' => $veh_prh->cls2_cnt + 1,
                'cls2_by' => $user,
                'cls2_date' => date("Y-m-d")
            );

            $newdata_stk = array(
                'pur_date' => date("Y-m-d"),
                'cls2_date' => date("Y-m-d"),
                'cls2_cnt' => $veh_prh->cls2_cnt + 1,
                'cls2_by' => $user,
                'sji_no' => $veh_prh->sji_no,
                'sji_date' => $veh_prh->sji_date,
                'kwiti_no' => $veh_prh->kwiti_no,
                'kwiti_date' => $veh_prh->kwiti_date,
                'fpi_no' => $veh_prh->fpi_no,
                'fpi_date' => $veh_prh->fpi_date,
                'dni_no' => $veh_prh->dni_no,
                'dni_date' => $veh_prh->dni_date,
                'do_no' => $veh_prh->do_no,
                'do_date' => $veh_prh->do_date,
                'pdi_no' => $veh_prh->pdi_no,
                'pdi_date' => $veh_prh->pdi_date,
                'pur_base' => $veh_prh->pur_base,
                'pur_opt' => $veh_prh->pur_opt,
                'alarm' => $veh_prh->alarm,
                'pur_bt' => $veh_prh->pur_bt,
                'pur_pbm' => $veh_prh->pur_pbm,
                'pur_vat' => $veh_prh->pur_vat,
                'key_no' => $veh_prh->key_no,
                'pur_pph' => $veh_prh->pur_pph,
                'pur_misc' => $veh_prh->pur_misc,
                'pur_price' => $veh_prh->pur_price,
                'serv_book' => $veh_prh->serv_book
            );
           
            $this->all_m->insertData('veh_aph', $newdata_aph);
             
            $veh_dpsd = $this->all_m->getWhere('veh_dpsd', array('po_no' => $veh_prh->po_no));
             
            foreach ($veh_dpsd as $dpsd) {
                $data_apd = array(
                    'pur_inv_no' => $veh_prh->pur_inv_no,
                    'pur_date' => $date,
                    'bank_code' => $dpsd->bank_code,
                    'pay_date' => $dpsd->pay_date,
                    'pay_type ' => $dpsd->pay_type,
                    'check_no' => $dpsd->check_no,
                    'check_date' => $dpsd->check_date,
                    'due_date ' => $dpsd->due_date,
                    'pay_val' => $dpsd->pay_bt,
                    //'disc_val' => $apgd->hd_disc,
                    'pay_desc' => $dpsd->pay_desc,
                    'add_by ' => $dpsd->add_by,
                    'add_date' => $dpsd->add_date,
                    'ref_no' => $dpsd->ref_no,
                    'ref_date' => $dpsd->ref_date,
                    'link_no' => $dpsd->link_no,
                    //'edc_code' => $veh_apgh->edc_code,
                    //'apv_inv_no' => $apgd->apv_inv_no,
                    //'apv_date' => $apgd->apv_date,
                    'dp_inv_no' => $dpsd->dp_inv_no,
                    'dp_date' => $dpsd->dp_date,
                );
                
                   $veh_aph = $this->all_m->getId('veh_aph', 'pur_inv_no', $veh_prh->pur_inv_no);
                   
                    $hd_paid = $veh_aph->hd_paid + $dpsd->pay_bt;
                    $hd_disc = $veh_aph->hd_disc + 0;
                    $total = $veh_aph->hd_begin - $hd_paid - $hd_disc;

                    $newdata_aph2['hd_paid'] = $hd_paid;
                    $newdata_aph2['hd_disc'] = $hd_disc;
                    $newdata_aph2['hd_end'] = $total;
                    
                    $this->all_m->updateData('veh_dpsd', 'id', $dpsd->id, array('use_date' => $date, 'pur_inv_no' => $veh_prh->pur_inv_no, 'pur_date' => $date, 'used_val' => $dpsd->pay_bt));
                
                    $veh_dpsh = $this->all_m->getId('veh_dpsh', 'po_no', $veh_prh->po_no);

                    $dp_paid = $veh_dpsh->dp_paid;
                    $dp_used = $veh_dpsh->dp_used + $dpsd->pay_bt;
                    $dp_end = $dp_paid - $dp_used;

                    $datadpsh = array(
                        //'dp_paid' => $dp_paid,
                        'dp_used' => $dp_used,
                        'dp_end' => $dp_end
                    );
                    $this->all_m->updateData('veh_dpsh', 'id', $veh_dpsh->id, $datadpsh);

                    $this->all_m->insertData('veh_apd', $data_apd);
                    $this->all_m->updateData('veh_aph', 'id', $veh_aph->id, $newdata_aph2);
            }

           
            $this->all_m->updateData('veh_stk', 'pur_inv_no', $veh_prh->pur_inv_no, $newdata_stk);
            $this->all_m->updateData($table, 'id', $id, $newdata_prh);

            $msg = array('success' => true, 'message' => 'Invoice successfully closed');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function unclosePembelian() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_prh = $this->all_m->getId($table, 'id', $id);

        $newdata_stk = array(
            'pur_date' => '0000-00-00',
            'cls2_date' => '0000-00-00',
            'cls2_cnt' => $veh_prh->cls2_cnt - 1,
            'cls2_by' => ''
        );

        $newdata_prh = array(
            'pur_date' => '0000-00-00',
            'cls2_cnt' => $veh_prh->cls2_cnt - 1,
            'cls2_by' => '',
            'cls2_date' => '0000-00-00'
        );

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {

            $stat = true;

            $check_apgd = $this->all_m->countlimit('veh_apgd', array('pur_inv_no' => $veh_prh->pur_inv_no));
            $check_apd = $this->all_m->countlimit('veh_apd', array('pur_inv_no' => $veh_prh->pur_inv_no));
            $check_slh = $this->all_m->countlimit('veh_slh', array('pur_inv_no' => $veh_prh->pur_inv_no, 'chassis' => $veh_prh->chassis));

            if ($check_apgd > 0) {
                $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
                $stat = false;
            }
            if ($check_apd > 0) {
                $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
                $stat = false;
            }
            if ($check_slh > 0) {
                $veh_slh = $this->all_m->getId('veh_slh', 'pur_inv_no', $veh_prh->pur_inv_no);

                if ($veh_slh->cls_date !== '0000-00-00') {
                    $msg = array('success' => false, 'message' => ' Sorry, this chassis is already sold and closed in sales invoice ' . $veh_slh->sal_inv_no . '. Open sales invoice if still possible');
                    $stat = false;
                }
            }

            if ($stat !== false) {
                $this->all_m->deleteData('veh_aph', 'pur_inv_no', $veh_prh->pur_inv_no);
                $this->all_m->updateData('veh_stk', 'pur_inv_no', $veh_prh->pur_inv_no, $newdata_stk);
                $this->all_m->updateData($table, 'id', $id, $newdata_prh);

                $msg = array('success' => true, 'message' => 'Invoice successfully unclosed');
            }
        }
        $this->json($msg);
    }

    function htmlreadPembelian($data) {
        $table = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];
        $row = (array) $this->all_m->getId($table, 'id', $id);
        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .='<table class="tables">';
        $html .='<tr>';
        $html .='<td style="width:65%"></td>';
        $html .='<td><table class="tables">';
        $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
        $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td><td colspan="2"><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
        $html .='</table></td>';
        $html .='</tr>';
        $html .='<tr><td></td><td></td></tr>';
        $html .='</table><br />';
        $html .= '<h3>Faktur Pembelian Kendaraan</h3>';

        $html .= '<table class="tables">';
        $html .= '<tr>';
        $html .= '<td width="120">'
                . '<table border="1" class="tables">'
                . '<tr><td><b>No. Faktur :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['pur_inv_no'] . '</td></tr>'
                . '<tr><td><b>Tgl. Beli :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['pur_date']) . '</td></tr>'
                . '<tr><td><b>Tgl.J.Tempo :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['due_date']) . '</td></tr>'
                . '<tr><td><b>No. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['po_no'] . '</td></tr>'
                . '<tr><td><b>Tgl. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['po_date']) . '</td></tr>'
                . '</table>'
                . '</td>';

        $html .= '<td width="420">
                        <table class="tables" border="1">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td width="100" class="bold">KODE SUPPLIER</td><td>:&nbsp;&nbsp;' . $row['supp_code'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td class="bold">NAMA SUPPLIER</td><td>:&nbsp;&nbsp;' . $row['supp_name'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td class="bold">WAREHOUSE</td><td>:&nbsp;&nbsp;' . $row['wrhs_code'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                </table>
                             </td>
                           </tr>
                           
                        </table>
                    </td>';
        $html .= '</tr>';
        $html .= '</table><br /><br />';

        $html .= '<table class="tables">';
        $html .= '<tr><td>';
        $html .= '<table class="tables" style="border:1px solid #000 ; padding-left:2pt;">';
        $html .= '<tr>
                        <th border="1" colspan="3" class="center">Keterangan</th>
                        <th border="1" class="right">Qty</th>
                        <th border="1" class="right">Harga Satuan</th>
                        <th border="1" class="right">Harga</th>
                  </tr>';

        $html .= '<tr>
                        <td><b>Kendaraan</b></td>
                        <td class="td-ro"><b>:</b></td>
                        <td width="167.5">' . $row['veh_name'] . '</td>
                        <td rowspan="4" border="1" class="right">1 UNIT</td>
                        <td rowspan="4" border="1" class="right">' . rupiah($row['unit_price']) . '</td>
                        <td rowspan="4" border="1" class="right">' . rupiah($row['tot_price']) . '</td>
                  </tr>';
        $html .= '<tr>
                            <td><b>Tipe</b></td>
                            <td class="td-ro">:</td>
                            <td>' . $row['veh_type'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                  </tr>';
        $html .= '<tr>
                            <td><b>Transmisi</b></td>
                             <td width="8">:</td>
                            <td>' . $row['veh_transm'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
        $html .= '<tr>
                            <td><b>Model</b></td>
                             <td width="8">:</td>
                            <td>' . $row['veh_model'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                </tr>';
        $html .= '<tr>
                            <td colspan="4"></td>
                            <td style="text-align: right !important;" width="91"><b>Jumlah:</b></td>
                            <td border="1" class="right">' . rupiah($row['tot_price']) . '</td>
                        </tr>';
        $html .= '<tr>
                            <td><b>Tahun</b></td>
                             <td width="8">:</td>
                            <td>' . $row['veh_year'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                </tr>';

        $html .= '<tr>
                            <td><b>Warna</b></td>
                             <td width="8">:</td>
                            <td>' . $row['color_name'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
        $html .= '<tr>
                            <td><b>No. Rangka</b></td>
                             <td width="8">:</td>
                            <td>' . $row['chassis'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
        $html .= '<tr>
                            <td><b>No. Mesin</b></td>
                             <td width="8">:</td>
                            <td>' . $row['engine'] . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';

        if ($row['alarm'] !== '') {
            $key = $row['key_no'] . '-' . $row['alarm'];
        } else {
            $key = $row['key_no'];
        }

        $html .= '<tr>
                            <td><b>No. Kunci</b></td>
                             <td width="8">:</td>
                            <td>' . $key . '</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';

        $html .= '<tr>
                            <td><b>No. Polisi</b></td>
                             <td width="8">:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
        $html .= '</table>';

        $html .='</td></tr>';


        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VPR');

        $html .='</td></tr>';
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

            $viewcnt = array(
                'user' => $user,
                'prn_cnt' => $prn_cnt,
                'action' => $data['action']
            );

        $html .= $this->viewPrnCnt($viewcnt);
        /* Counter Printer*/
        $html .= '</table>';

        $html .= '</table>';

        $output = array(
            'html' => $html,
            'number' => $row['pur_inv_no']
        );

        return $output;
    }

    function htmlreadPenerimaan($data) {
        $table = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];
        $row = (array) $this->all_m->getId($table, 'id', $id);
        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .= $this->readhtmlcompany();
               
        $html .= '<h3>Faktur Penerimaan Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= '<td width="120">'
                . '<table class="tables" border="1">'
                . '<tr><td><b>No. Faktur :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['pur_inv_no'] . '</td></tr>
                            <tr><td><b>Tgl. Terima :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['stk_date']) . '</td></tr>
                            <tr><td><b>Tgl.J.Tempo :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['due_date']) . '</td></tr>
                            <tr><td><b>No. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['po_no'] . '</td></tr>
                            <tr><td><b>Tgl. PO :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['po_date']) . '</td></tr>'
                . '</table></td>';
        $html .= '<td width="420">'
                . '<table class="tables" border="1">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td class="bold" width="80">KODE SUPPLIER</td><td width="305">:&nbsp;&nbsp;' . $row['supp_code'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td class="bold">NAMA SUPPLIER</td><td>:&nbsp;&nbsp;' . $row['supp_name'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td class="bold">WAREHOUSE</td><td>:&nbsp;&nbsp;' . $row['wrhs_code'] . '</td></tr>                                  
                                    <tr><td><br /></td></tr>                                   
                                </table>
                             </td>
                           </tr>
                           
                        </table></td>';

        $html .= '</tr>';
        $html .= '</table><br /><br />';

        $html .= '<table  class="tables">';
        $html .= '<tr><td>';
        $html .= '<table class="tables" style="border:1px solid #000 ;">';
        $html .= '<tr>
                        <th border="1" colspan="6" class="center">Keterangan</th>
                        <th border="1" class="right">Qty</th>
                  </tr>';

        $html .= '<tr>';
        $html .= '<td colspan="3"><table width="320" class="tables">';
        $html .= '<tr><td><b>Kendaraan</b></td><td class="td-ro">:</td><td>' . $row['veh_name'] . '</td></tr>';
        $html .= '<tr><td>Tipe</td><td class="td-ro">:</td><td>' . $row['veh_type'] . '</td></tr>';
        $html .= '<tr><td>Transmisi</td><td class="td-ro">:</td><td>' . $row['veh_transm'] . '</td></tr>';
        $html .= '<tr><td>Model</td><td class="td-ro">:</td><td>' . $row['veh_model'] . '</td></tr>';
        $html .= '<tr><td>Tahun</td><td class="td-ro">:</td><td>' . $row['veh_year'] . '</td></tr>';
        $html .= '<tr><td colspan="3"></td></tr>';
        $html .= '<tr><td colspan="3"></td></tr>';
        $html .= '<tr><td><b>Warna</b></td><td class="td-ro">:</td><td>' . $row['color_name'] . '</td></tr>';
        $html .= '<tr><td>Tipe</td><td class="td-ro">:</td><td>' . $row['color_type'] . '</td></tr>';

        $html .= '</table></td>';

        if ($row['alarm'] !== '') {
            $key = $row['key_no'] . '-' . $row['alarm'];
        } else {
            $key = $row['key_no'];
        }

        $html .= '<td colspan="3"><table class="tables">';
        $html .= '<tr><td>No. Rangka</td><td class="td-ro">:</td><td>' . $row['chassis'] . '</td></tr>';
        $html .= '<tr><td>No. Mesin</td><td class="td-ro">:</td><td>' . $row['engine'] . '</td></tr>';
        $html .= '<tr><td>No. Kunci</td><td class="td-ro">:</td><td>' . $key . '</td></tr>';
        $html .= '<tr><td>No. Polisi</td><td class="td-ro">:</td><td></td></tr>';
        $html .= '</table></td>';

        $html .= ' <td rowspan="4" border="1" class="right">1 UNIT</td>';
        $html .= '</tr>';

        $html .= '</table>';
        $html .= '</td></tr>';
        $html .= '</table>';

        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VRCV');

        $html .='</td></tr>';
        
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

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
            'number' => $row['pur_inv_no']
        );

        return $output;
    }

    function saveReturnPenjualan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        $stat = true;
       
        $sal_inv_no = $data['sal_inv_no'];
        $sal_date = explode('/', $data['sal_date']);

        $year = $sal_date[2];
        $mounth = $sal_date[1];

        $dbs = $this->getDataHistory($year, $mounth);
        
        $check_salinv = $this->all_m->countlimit('veh_rslh', array('sal_inv_no' => $sal_inv_no));

        if ($id == '') {
            if ($check_salinv > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Record saved failed, sales invoice no already exist', 'status' => 'save');
            }
        }

        if ($stat !== false) {
            $sql = "select * from " . $dbs . ".veh_slh where sal_inv_no='$sal_inv_no' limit 1";
            $slh = $this->all_m->query_single($sql);
            $slh = (array) $slh;

            unset($slh['id']);
            unset($slh['cls_date']);
            unset($slh['cls_by']);
            //unset($slh['sal_inv_no']);



            $sql_rslh = "SHOW COLUMNS FROM veh_rslh";
            $veh_rslh = $this->all_m->query_all($sql_rslh);

            foreach ($veh_rslh as $rslh) {
                $field_rslh[$rslh->Field] = '';
            }
            unset($field_rslh['id']);

            foreach ($slh as $k => $v) {

                if (array_key_exists($k, $field_rslh)) {
                    $key1[] = $k;
                    $val1[] = $v;
                }
            }

            $data_rslh = array_combine($key1, $val1);
            $data_rslh['opn_date'] = date('Y-m-d');
            $data_rslh['rsl_inv_no'] = $this->all_m->inv_seq('4', 'VRS');
            $data_rslh['due_day'] = $this->input->post('due_day');
            //$data_rslh['due_date'] = $this->input->post('due_date');
            $data_rslh['due_date'] = $this->dateFormat($data['due_date']);
            $data_rslh['note'] = $this->input->post('note');

            $data_rslh['inv_total'] = $data_rslh['veh_total'] + $data_rslh['srv_at'] + $data_rslh['part_at'] + $data_rslh['inv_stamp'];


            if ($id !== '') {


                // $check = $this->all_m->getId($table, 'id', $id);
                $check = $this->all_m->countlimit($table, array('id' => $id));

                if ($check > 0) {
                    $this->all_m->updateData($table, 'id', $id, $data_rslh);
                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                    $this->updateLocked($table, $id);
                } else {
                    $msg = array('success' => false, 'message' => 'Record updated failed, data not found', 'status' => 'update', 'update' => false);
                }
            } else {
                $check_rslh = $this->all_m->check('veh_rslh', array('sal_inv_no' => $data['sal_inv_no']));

                if ($check_rslh > 0) {
                    $rslh = $this->all_m->getId('veh_rslh', 'sal_inv_no', $data['sal_inv_no']);
                    $msg = array('success' => false, 'message' => 'Sorry, unable to save data because it has already exist', 'status' => 'exist', 'inv_no_id' => $rslh->id);
                } else {

                    $check = $this->all_m->insertData($table, $data_rslh);
                    $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VRS'));
                    $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));


                    $veh_sld = $this->all_m->query_all("select * from " . $dbs . ".veh_sld where sal_inv_no='$sal_inv_no'");

                    foreach ($veh_sld as $sld) {
                        $veh_sld = array(
                            'rsl_inv_no' => $data_rslh['rsl_inv_no'],
                            'pick_date' => $sld->pick_date,
                            'so_no' => $sld->so_no,
                            'so_date' => $sld->so_date,
                            'wk_code' => $sld->wk_code,
                            'wk_desc' => $sld->wk_desc,
                            'price_bd' => $sld->price_bd,
                            'disc_pct' => $sld->disc_pct,
                            'disc_val' => $sld->disc_val,
                            'price_ad' => $sld->price_ad,
                            'srep_code1' => $sld->srep_code1,
                            'srep_name1' => $sld->srep_name1,
                            'add_by' => $sld->add_by,
                            'add_date' => $sld->add_date
                        );

                        $this->all_m->insertData('veh_rsld', $veh_sld);
                    }

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }
        $this->json($msg);
    }

    function closeReturnPenjualan() {
        $res = true;
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $post = $this->input->post();

        $data = (array) $this->all_m->getId($table, 'id', $id);

        $data['rsl_date'] = date('Y-m-d');
        $data['cls_date'] = date('Y-m-d');
        $data['cls_by'] = $user;
        $data['cls_cnt'] = $data['cls_cnt'] + 1;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotClose();
        }

        if ($data['due_date'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Please input Aging Date');
        } else {
            if (intval(strtotime($data['due_date'])) < intval(strtotime(date('Y-m-d')))) {
                $res = false;
                $msg = array('status' => false, 'message' => 'Sorry, Aging Date has to be the same or after today\'s date');
            }
        }

        if ($data['due_day'] == '') {
            $data['due_day'] = 0;
        }


        if ($res !== false) {

            $ssystem = $this->all_m->getId('ssystem', 'id', 1);

            //$period = $ssystem->tahun . $ssystem->bulan;

            $db1 = $this->db->database;


            $sal_inv_no = $data['sal_inv_no'];
            $sal_date = explode('-', $data['sal_date']);

            $year = $sal_date[0];
            $mounth = $sal_date[1];

            $lenmth = strlen($mounth);

            $mth = $mounth;

            if ($lenmth == 1) {
                $int = 0;
                $mth = $int . $mounth;
            }

            $tahun = $ssystem->tahun;
            $bulan = $ssystem->bulan;

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

            if ($dbs == $db1) {
                $msg = $this->closeReturnPenjualanCurrent($post);
            } else {
                $msg = $this->closeReturnPenjualanHistory($post, $dbs);
            }
        }
        $this->json($msg);
    }

    function closeReturnPenjualanHistory($post, $dbs) {
        $res = true;
        $user = $this->uri->segment(4);
        $table = $post['table'];
        $id = $post['id'];

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['rsl_date'] = date('Y-m-d');
        $data['cls_date'] = date('Y-m-d');
        $data['cls_by'] = $user;
        $data['cls_cnt'] = $data['cls_cnt'] + 1;

        $chassis = $data['chassis'];

        unset($data['id']);

        $sql = "select * from " . $dbs . ".veh_prh where chassis='$chassis' limit 1";
        $prh = $this->all_m->query_single($sql);
        $veh_prh = (array) $prh;

        $sql_stk = "SHOW COLUMNS FROM veh_stk";
        $veh_stk = $this->all_m->query_all($sql_stk);

        foreach ($veh_stk as $stk) {
            $field_stk[$stk->Field] = '';
        }
        unset($field_stk['id']);


        $veh_prh['cls_by'] = $user;
        $veh_prh['cls_date'] = date('Y-m-d');
        $veh_prh['stk_date'] = date('Y-m-d');
        $veh_prh['cls_cnt'] = $veh_prh['cls_cnt'] + 1;

        foreach ($veh_prh as $k => $v) {

            if (array_key_exists($k, $field_stk)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        /* data veh_stk */
        $newdata_stk = array_combine($key, $val);
        $newdata_stk['wrhs_orig'] = $veh_prh['wrhs_code'];
        $newdata_stk['loc_orig'] = $veh_prh['loc_code'];
        $newdata_stk['match_date'] = '0000-00-00';
        $newdata_stk['pick_date'] = '0000-00-00';
        $newdata_stk['stk_code'] = 'OH';
        $newdata_stk['pur_date'] = $data['rsl_date'];
        $newdata_stk['pur_inv_no'] = $data['rsl_inv_no'];
        $newdata_stk['sal_inv_no'] = '';
        $newdata_stk['sal_date'] = '0000-00-00';
        $newdata_stk['so_no'] = '';
        $newdata_stk['so_date'] = '0000-00-00';
        $newdata_stk['rsl_inv_no'] = $data['rsl_inv_no'];
        $newdata_stk['rsl_date'] = $data['rsl_date'];
        $newdata_stk['rsal_qty'] = 1;
        $newdata_stk['end_qty'] = 1;


        $sql_slh = "select * from " . $dbs . ".veh_slh where chassis='$chassis' limit 1";
        $slh = $this->all_m->query_single($sql_slh);
        $veh_slh = (array) $slh;

        $sql_arh = "SHOW COLUMNS FROM veh_arh";
        $veh_arh = $this->all_m->query_all($sql_arh);

        foreach ($veh_arh as $arh) {
            $field_arh[$arh->Field] = '';
        }
        unset($field_arh['id']);


        foreach ($veh_slh as $k1 => $v1) {

            if (array_key_exists($k1, $field_arh)) {
                $key1[] = $k1;
                $val1[] = $v1;
            }
        }

        /* data veh_arh */
        $newdata_arh = array_combine($key1, $val1);

        $newdata_arh['sal_inv_no'] = $data['rsl_inv_no'];

        $newdata_arh['veh_price'] = $data['veh_total'] - ($data['veh_total'] * 2);
        $newdata_arh['srv_at'] = $data['srv_at'] - ($data['srv_at'] * 2);
        $newdata_arh['part_at'] = $data['part_at'] - ($data['part_at'] * 2);
        $newdata_arh['veh_misc'] = $data['inv_stamp'] - ($data['inv_stamp'] * 2);

        $newdata_arh['inv_total'] = $newdata_arh['veh_price'] + $newdata_arh['srv_at'] + $newdata_arh['part_at'] + $newdata_arh['veh_misc'];

        $newdata_arh['pd_begin'] = $data['veh_total'] - ($data['veh_total'] * 2);
        $newdata_arh['pd_end'] = $data['veh_total'] - ($data['veh_total'] * 2);


        $this->all_m->insertData('veh_arh', $newdata_arh);

        $this->all_m->insertData('veh_stk', $newdata_stk);

        $this->all_m->updateData($table, 'id', $id, $data);

        $veh_rsld = $this->all_m->getWhere('veh_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

        foreach ($veh_rsld as $rsld) {
            $this->all_m->updateData('veh_rsld', 'id', $rsld->id, array('rsl_date' => $data['rsl_date']));
        }

        $msg = array('success' => true, 'message' => 'close success');

        return $msg;
    }

    function closeReturnPenjualanCurrent($post) {
        //Update table veh_rslh, veh_rsld, veh_arh, veh_stk
        $res = true;
        $user = $this->uri->segment(4);
        $table = $post['table'];
        $id = $post['id'];

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['rsl_date'] = date('Y-m-d');

        $data['cls_date'] = date('Y-m-d');
        $data['cls_by'] = $user;
        $data['cls_cnt'] = $data['cls_cnt'] + 1;


        $veh_slh = (array) $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);

        $sql_arh = "SHOW COLUMNS FROM veh_arh";
        $veh_arh = $this->all_m->query_all($sql_arh);

        foreach ($veh_arh as $arh) {
            $field_arh[$arh->Field] = '';
        }
        unset($field_arh['id']);
        foreach ($veh_slh as $k => $v) {

            if (array_key_exists($k, $field_arh)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        /* data veh_arh */
        $newdata_arh = array_combine($key, $val);
        $newdata_arh['sal_inv_no'] = $data['rsl_inv_no'];

        $newdata_arh['veh_price'] = $data['veh_total'] - ($data['veh_total'] * 2);
        $newdata_arh['srv_at'] = $data['srv_at'] - ($data['srv_at'] * 2);
        $newdata_arh['part_at'] = $data['part_at'] - ($data['part_at'] * 2);
        $newdata_arh['veh_misc'] = $data['inv_stamp'] - ($data['inv_stamp'] * 2);

        $newdata_arh['inv_total'] = $newdata_arh['veh_price'] + $newdata_arh['srv_at'] + $newdata_arh['part_at'] + $newdata_arh['veh_misc'];

        $newdata_arh['pd_begin'] = $data['veh_total'] - ($data['veh_total'] * 2);
        $newdata_arh['pd_end'] = $data['veh_total'] - ($data['veh_total'] * 2);

        /* update veh_stk */


        $veh_stk = $this->all_m->getOne('veh_stk', array('sal_inv_no' => $veh_slh['sal_inv_no'], 'chassis' => $veh_slh['chassis']));

        $rsal_qty = $veh_stk->rsal_qty + 1;

        $stk = array(
            'rsal_qty' => $rsal_qty,
            //'sal_qty' => $sal_qty,
            'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - $veh_stk->pick_qty - $veh_stk->sal_qty + $rsal_qty + $veh_stk->opn_qty,
            'rsl_inv_no' => $data['rsl_inv_no'],
            'rsl_date' => $data['rsl_date'],
            'sal_inv_no' => '',
            'sal_date' => '0000-00-00',
            'so_no' => '',
            'match_date' => '0000-00-00'
        );



        $this->all_m->insertData('veh_arh', $newdata_arh);

        $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $stk);

        $this->all_m->updateData($table, 'id', $id, $data);

        $veh_rsld = $this->all_m->getWhere('veh_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

        foreach ($veh_rsld as $rsld) {
            $this->all_m->updateData('veh_rsld', 'id', $rsld->id, array('rsl_date' => $data['rsl_date']));
        }
        $msg = array('success' => true, 'message' => 'close success');


        return $msg;
    }

    function uncloseReturnPenjualan() {
        $stat = true;
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $post = $this->input->post();

        $rslh = $this->all_m->getId($table, 'id', $id);

        $check_ard = $this->all_m->countlimit('veh_ard', array('sal_inv_no' => $rslh->rsl_inv_no));

        if ($check_ard > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have receivable payment(s). Please delete them first');
            $stat = false;
        }

        $check_argd = $this->all_m->countlimit('veh_argd', array('sal_inv_no' => $rslh->rsl_inv_no));

        if ($check_argd > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have receivable payment(s). Please delete them first');
            $stat = false;
        }

        $periode = $this->checkPeriode();

        $check = $this->all_m->countlimit('veh_ard', array('sal_inv_no' => $rslh->rsl_inv_no));

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
            $stat = false;
        }

        if ($stat !== false) {
            $ssystem = $this->all_m->getId('ssystem', 'id', 1);

            // $period = $ssystem->tahun . $ssystem->bulan;

            $db1 = $this->db->database;


            $sal_inv_no = $data['sal_inv_no'];
            $sal_date = explode('-', $rslh->sal_date);

            $year = $sal_date[0];
            $mounth = $sal_date[1];

            $lenmth = strlen($mounth);

            $mth = $mounth;

            if ($lenmth == 1) {
                $int = 0;
                $mth = $int . $mounth;
            }

            $tahun = $ssystem->tahun;
            $bulan = $ssystem->bulan;

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

            if ($dbs == $db1) {
                $msg = $this->uncloseReturnPenjualanCurrent($post);
            } else {
                $msg = $this->uncloseReturnPenjualanHistory($post, $dbs);
            }
        }
        $this->json($msg);
    }

    function uncloseReturnPenjualanHistory($post, $dbs) {
        $user = $this->uri->segment(4);
        $table = $post['table'];
        $id = $post['id'];

        $data = (array) $this->all_m->getId($table, 'id', $id);

        $this->all_m->deleteData('veh_arh', 'sal_inv_no', $data['rsl_inv_no']);
        $this->all_m->deleteData('veh_stk', 'rsl_inv_no', $data['rsl_inv_no']);


        $this->all_m->updateData($table, 'id', $id, array('cls_date' => '0000-00-00', 'cls_by' => '', 'rsl_date' => '0000-00-00'));

        $veh_rsld = $this->all_m->getWhere('veh_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

        foreach ($veh_rsld as $rsld) {
            $this->all_m->updateData('veh_rsld', 'id', $rsld->id, array('rsl_date' => '0000-00-00'));
        }

        $msg = array('success' => true, 'message' => 'invoice has been unclosed successfully');

        return $msg;
    }

    function uncloseReturnPenjualanCurrent($post) {
        //Update table veh_rslh, veh_rsld, veh_arh, veh_stk
        $user = $this->uri->segment(4);
        $table = $post['table'];
        $id = $post['id'];

        $data = (array) $this->all_m->getId($table, 'id', $id);

        $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);

        /* update veh_stk */
        $veh_stk = $this->all_m->getOne('veh_stk', array('rsl_inv_no' => $data['rsl_inv_no']));

        $rsal_qty = $veh_stk->rsal_qty - 1;

        $stk = array(
            'rsal_qty' => $rsal_qty,
            //'sal_qty' => $sal_qty,
            'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $veh_stk->rpur_qty - $veh_stk->pick_qty - $veh_stk->sal_qty + $rsal_qty + $veh_stk->opn_qty,
            'rsl_inv_no' => '',
            'rsl_date' => '0000-00-00',
            'sal_inv_no' => $veh_slh->sal_inv_no,
            'sal_date' => $veh_slh->sal_date,
            'so_no' => $veh_slh->so_no,
            'match_date' => $veh_slh->match_date
        );


        $check_stk = $this->all_m->getId('veh_stk', 'rsl_inv_no', $data['rsl_inv_no']);
        // print_r($data['rsl_inv_no']);exit;
        if ($check_stk->end_qty < 1) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to unclose this invoice because its stock is empty');
        } else {
            $this->all_m->deleteData('veh_arh', 'sal_inv_no', $data['rsl_inv_no']);

            $this->all_m->updateData('veh_stk', 'rsl_inv_no', $data['rsl_inv_no'], $stk);

            $this->all_m->updateData($table, 'id', $id, array('cls_date' => '0000-00-00', 'cls_by' => '', 'rsl_date' => '0000-00-00'));

            $veh_rsld = $this->all_m->getWhere('veh_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

            foreach ($veh_rsld as $rsld) {
                $this->all_m->updateData('veh_rsld', 'id', $rsld->id, array('rsl_date' => '0000-00-00'));
            }

            $msg = array('success' => true, 'message' => 'invoice has been unclosed successfully');
        }
        return $msg;
    }

    function save_rsld() {
        $rsl_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $wk_code = $this->input->post('wk_code');
        $table = $this->input->post('table2');

        if ($wk_code !== '') {
            $check = $this->all_m->countlimit($table, array('rsl_inv_no' => $rsl_inv_no, 'wk_code' => $wk_code));

            if ($check > 0) {

                $msg = array('success' => false, 'message' => 'Sorry, unable to save data because it has already exist');
            } else {
                $veh_slh = $this->all_m->getId('veh_rslh', 'rsl_inv_no', $rsl_inv_no);
                $srv_price = $veh_slh->srv_price + intval($this->input->post('price_ad'));
                $srv_disc = $veh_slh->srv_disc;
                $srv_bt = $srv_price - $srv_disc;

                $srv_vat = $srv_bt / 10;
                $srv_at = $srv_bt + $srv_vat;

                $inv_total = $veh_slh->veh_total + $srv_at + $veh_slh->part_at + $veh_slh->inv_stamp;

                $data_slh = array(
                    'srv_price' => $srv_price,
                    'srv_disc' => $srv_disc,
                    'srv_bt' => $srv_bt,
                    'srv_vat' => $srv_vat,
                    'srv_at' => $srv_at,
                    'inv_total' => $inv_total
                );

                //print_r($data_slh);exit;
                $data['rsl_inv_no'] = $rsl_inv_no;
                $data['wk_code'] = $wk_code;
                $data['wk_desc'] = $this->input->post('wk_desc');

                $data['price_bd'] = $this->input->post('price_bd');
                $data['disc_pct'] = $this->input->post('disc_pct');
                $data['disc_val'] = $this->input->post('disc_val');
                $data['price_ad'] = $this->input->post('price_ad');
                $data['add_by'] = $user;
                $data['add_date'] = date('Y-m-d');
                $this->all_m->insertData($table, $data);

                $this->all_m->updateData('veh_rslh', 'rsl_inv_no', $rsl_inv_no, $data_slh);
                $msg = array('success' => true, 'message' => 'Record saved');
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please input Work Code');
        }

        $this->json($msg);
    }

    function deleteOptionalrsld() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $rsl_inv_no = $this->input->post('rsl_inv_no');
        $veh_sld = $this->all_m->getId($table, 'id', $id);

        $veh_slh = $this->all_m->getId('veh_rslh', 'rsl_inv_no', $rsl_inv_no);
        $srv_price = $veh_slh->srv_price - $veh_sld->price_ad;
        $srv_disc = $veh_slh->srv_disc;
        $srv_bt = $srv_price - $srv_disc;
        //$srv_bt = ($veh_slh->srv_bt - $veh_sld->price_ad) - $srv_disc;
        $srv_vat = $srv_bt / 10;
        $srv_at = $srv_bt + $srv_vat;

        $inv_total = $veh_slh->veh_total + $srv_at + $veh_slh->part_at + $veh_slh->inv_stamp;

        $data_slh = array(
            'srv_price' => $srv_price,
            'srv_disc' => $srv_disc,
            'srv_bt' => $srv_bt,
            'srv_vat' => $srv_vat,
            'srv_at' => $srv_at,
            'inv_total' => $inv_total
        );
        // print_r($data_slh);exit;
        $this->all_m->updateData('veh_rslh', 'rsl_inv_no', $rsl_inv_no, $data_slh);

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $this->all_m->deleteData($table, 'id', $id);

        $check = $this->all_m->countlimit($table, array('id' => $id));
        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            $msg = array('success' => true, 'message' => 'Delete success');
        }
        $this->json($msg);
    }

    function deleteReturnPenjualan() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $slh = $this->all_m->getId($tbl, 'id', $id);
        $rsl_inv_no = $slh->rsl_inv_no;

        $check_sld = $this->all_m->countlimit('veh_rsld', array('rsl_inv_no' => $rsl_inv_no));

        if ($check_sld > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        }

        if ($msg['success'] !== false) {

            $this->all_m->deleteData($tbl, 'id', $id);

            $check = $this->all_m->countlimit($tbl, array('id' => $id));

            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete success');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function htmlreadReturPenjualan($data) {
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        $row = (array) $this->all_m->getId($tbl, 'id', $id);

        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .= $this->readhtmlcompany();

        $html .= '<h3>Faktur Retur Penjualan Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= ' <td width="120">
                         <table cellpadding="1"  border="0.5" style="padding-left:5pt;">
                            <tr><td><b>No. Faktur :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['rsl_inv_no'] . '</td></tr>
                            <tr><td><b>Tgl. Retur Jual :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['rsl_date']) . '</td></tr>
                            <tr><td><b>Tgl.J.Tempo :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['due_date']) . '</td></tr>
                            <tr><td><b>No. Faktur Jual :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['sal_inv_no'] . '</td></tr>
                            <tr><td><b>Tgl. Faktur Jual :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['sal_date']) . '</td></tr>                        
                            <tr><td><b>Kode Wiraniaga :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['srep_code'] . '</td></tr>    
                        </table>
                    </td>';
        $html .= '  <td width="420">
                        <table class="tables" border="0.5">
                           <tr>
                             <td>
                                 <table cellpadding="1">
                                    <tr><td width="100" class="bold">Nama Pemesan</td><td width="5">:</td><td width="305">' . $row['cust_name'] . '</td></tr>';
        if ($row['cust_phone'] !== '' && $row['cust_hp'] !== '') {
            $phone = $row['cust_phone'] . ' - ' . $row['cust_hp'];
        } elseif ($row['cust_phone'] == '' && $row['cust_hp'] !== '') {
            $phone = $row['cust_hp'];
        } else {
            $phone = $row['cust_phone'];
        }

        $html .='<tr><td class="bold">Alamat</td><td width="5">:</td><td>' . $row['cust_addr'] . '</td></tr>
                                    <tr><td class="bold">Telp./HP</td><td width="5">:</td><td>' . $phone . '</td></tr>
                                    <tr><td class="bold">NPWP</td><td width="5">:</td><td>' . $row['cust_npwp'] . '</td></tr>
                                </table>
                             </td>
                           </tr>
                           <tr>
                             <td>
                                 <table cellpadding="1">
                                    <tr><td width="100" class="bold">Nama di STNK</td><td width="5">:</td><td width="305">' . $row['cust_rname'] . '</td></tr>
                                    <tr><td class="bold">Alamat di STNK</td><td width="5">:</td><td>' . $row['cust_raddr'] . '</td></tr>
                                    <tr><td class="bold">Telp</td><td width="5">:</td><td>' . $row['cust_rphon'] . '</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                </table>
                             </td>
                           </tr>
                           
                        </table>
                    </td>';
        $html .= '</tr>';
        $html .= '</table><br /><br />';

        if ($row['key_no'] !== '' && $row['alarm'] !== '') {
            $keyalarm = $row['key_no'] . ' - ' . $row['alarm'];
        } elseif ($row['key_no'] == '' && $row['alarm'] !== '') {
            $keyalarm = $row['alarm'];
        } else {
            $keyalarm = $row['key_no'];
        }

        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table class="tables" style="padding-left:2pt;border:0.5px solid #000">';
        $html .= '<tr>  
                        <th border="0.5" width="40" class="center">No</th>
                        <th border="0.5" colspan="3" class="center" width="350">Keterangan</th>
                        <th border="0.5" class="center" width="50">Qty</th>
                        <th border="0.5" class="right">Harga</th>
                  </tr>';
        $html .= '<tr>  
                        <td valign="top" class="center">1.</td>
                        <td colspan="3">
                            <table cellpadding="1">
                                <tr><td><b>Kendaraan</b></td><td class="td-ro">:</td><td>' . $row['veh_name'] . '</td></tr>
                                <tr><td>Warna</td><td class="td-ro">:</td><td>' . $row['color_name'] . '</td></tr>
                                <tr><td>Tahun</td><td class="td-ro">:</td><td>' . $row['veh_year'] . '</td></tr>
                                <tr><td>No.Rangka</td><td class="td-ro">:</td><td>' . $row['chassis'] . '</td></tr>
                                <tr><td>No.Mesin</td><td class="td-ro">:</td><td>' . $row['engine'] . '</td></tr>
                                <tr><td>No.Kunci / Alarm</td><td class="td-ro">:</td><td>' . $keyalarm . '</td></tr>
                            </table>
                        </td>
                        <td valign="top" class="center">1</td>
                        <td valign="top" class="right">' . rupiah($row['veh_bt']) . '</td>
                  </tr>';

        $html .='<tr><td border="0"></td><td colspan="3" border="0"></td><td></td><td></td></tr>';
        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >Dasar Pengenaan Pajak</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['veh_bt']) . '</td>
                  </tr>';

        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >Pajak Pertambahan Nilai</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['veh_vat']) . '</td>
                  </tr>';
        $html .='<tr><td></td><td colspan="3" border="0"></td><td></td><td></td></tr>';
        $html .='<tr><td></td><td colspan="3" border="0"></td><td></td><td></td></tr>';


        $html .= '</table>
                <table class="tables">';
        $html .= '<tr>
                        <td colspan="5" class="right"><b>Jumlah</b></td>
                        <td border="1" valign="top" class="right"><b>' . rupiah($row['veh_bt'] + $row['veh_vat']) . '</b></td>
                  </tr>';
        $html .= '</table>
                    </td>
                 </tr>';
        $html .= '</table>';


        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VRSL');

        $html .='</td></tr>';
        
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

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
            'number' => $row['rsl_inv_no']
        );

        return $output;
    }

    function saveReturnPembelian() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();
        $stat = true;

        $pur_inv_no = $this->input->post('pur_inv_no');

        $check_purinv = $this->all_m->countlimit('veh_rprh', array('pur_inv_no' => $pur_inv_no));

        if ($id == '') {
            if ($check_purinv > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Record saved failed, purchase invoice no already exist', 'status' => 'save');
            }
        }


        if ($stat !== false) {
            $ssystem = $this->all_m->getId('ssystem', 'id', 1);


            $db1 = $this->db->database;

            $pur_date = explode('/', $data['pur_date']);

            $year = $pur_date[2];
            $mounth = $pur_date[1];

            $lenmth = strlen($mounth);

            $mth = $mounth;

            if ($lenmth == 1) {
                $int = 0;
                $mth = $int . $mounth;
            }

            $tahun = $ssystem->tahun;
            $bulan = $ssystem->bulan;

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

            $sql = "select * from " . $dbs . ".veh_slh where pur_inv_no='$pur_inv_no' limit 1";
            $prh = $this->all_m->query_single($sql);
            $prh = (array) $prh;
            //$prh = (array) $this->all_m->getId('veh_prh', 'pur_inv_no', $pur_inv_no);

            unset($prh['id']);
            unset($prh['cls_date']);
            unset($prh['cls_by']);

            $sql_rprh = "SHOW COLUMNS FROM veh_rprh";
            $veh_rprh = $this->all_m->query_all($sql_rprh);

            foreach ($veh_rprh as $rprh) {
                $field_rprh[$rprh->Field] = '';
            }
            unset($field_rprh['id']);

            foreach ($prh as $k => $v) {

                if (array_key_exists($k, $field_rprh)) {
                    $key1[] = $k;
                    $val1[] = $v;
                }
            }
            $data = array();
            $data = array_combine($key1, $val1);

            unset($data['cls2_date']);
            unset($data['cls2_by']);
            unset($data['cls2_cnt']);

            $data['opn_date'] = date('Y-m-d');
            $data['rpr_inv_no'] = $this->all_m->inv_seq('4', 'VRP');

            $datapost = $this->input->post();
            unset($datapost['id']);
            unset($datapost['table']);

            foreach ($datapost as $key => $value) {
                $data[$key] = $value;
            }

            $data['due_date'] = $this->dateFormat($data['due_date']);
            $data['pur_date'] = $this->dateFormat($data['pur_date']);
            $data['pred_stk_d'] = $this->dateFormat($data['pred_stk_d']);
            $data['sji_date'] = $this->dateFormat($data['sji_date']);
            $data['kwiti_date'] = $this->dateFormat($data['kwiti_date']);
            $data['fpi_date'] = $this->dateFormat($data['fpi_date']);
            $data['dni_date'] = $this->dateFormat($data['dni_date']);
            $data['do_date'] = $this->dateFormat($data['do_date']);
            $data['pdi_date'] = $this->dateFormat($data['pdi_date']);
            $data['sji2_date'] = $this->dateFormat($data['sji2_date']);
            $data['kwiti2date'] = $this->dateFormat($data['kwiti2date']);
            $data['fpi2_date'] = $this->dateFormat($data['fpi2_date']);
            $data['dni2_date'] = $this->dateFormat($data['dni2_date']);

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
                $check_rprh = $this->all_m->check('veh_rprh', array('pur_inv_no' => $data['pur_inv_no']));

                if ($check_rprh > 0) {
                    $rprhdata = $this->all_m->getId('veh_rprh', 'pur_inv_no', $data['pur_inv_no']);
                    $msg = array('success' => false, 'message' => 'Invoice No. has already been used', 'status' => 'exist', 'inv_no_id' => $rprhdata->id);
                } else {

                    $check = $this->all_m->insertData($table, $data);
                    $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VRP'));
                    $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function deleteReturnPembelian() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $this->all_m->deleteData($tbl, 'id', $id);

        $check = $this->all_m->countlimit($tbl, array('id' => $id));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            $msg = array('success' => true, 'message' => 'Delete success');
        }
        $this->json($msg);
    }

    function closeReturnPembelian() {
        /* Insert table veh_aph
         * Update table veh_rprh
         * update table veh_stk
         */
        $res = true;
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $veh_rprh = $data;
        $data['rpr_date'] = date('Y-m-d');

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $res = false;
            $msg = $this->msgNotClose();
        }

        if ($data['due_date'] == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Please input Aging Date');
        } else {
            if (intval(strtotime($data['due_date'])) < intval(strtotime(date('Y-m-d')))) {
                $res = false;
                $msg = array('status' => false, 'message' => 'Sorry, Aging Date has to be the same or after today\'s date');
            }
        }

        if ($data['due_day'] == '') {
            $data['due_day'] = 0;
        }

        $veh_stk = $this->all_m->getOne('veh_stk', array('pur_inv_no' => $data['pur_inv_no']));

        if ($veh_stk->rsl_inv_no == '') {
            $res = false;
            $msg = array('success' => false, 'message' => 'Sorry, there is no stock in ' . $data['wrhs_code'] . ' Warehouse to return');
        }


        if ($res !== false) {
            //$data['due_date'] = date('Y-m-d');
            $data['cls_date'] = date('Y-m-d');
            $data['cls_by'] = $user;
            $data['cls_cnt'] = $data['cls_cnt'] + 1;

            //$veh_slh = (array) $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);

            $sql_aph = "SHOW COLUMNS FROM veh_aph";
            $veh_aph = $this->all_m->query_all($sql_aph);

            foreach ($veh_aph as $aph) {
                $field_aph[$aph->Field] = '';
            }
            unset($field_aph['id']);
            foreach ($veh_rprh as $k => $v) {

                if (array_key_exists($k, $field_aph)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }
            $price = $veh_rprh['pur_price1'] * 2;
            $pur_price1 = $veh_rprh['pur_price1'] - $price;
            /* data veh_arh */
            $newdata_aph = array_combine($key, $val);
            unset($newdata_aph['stk_date']);
            $newdata_aph['inv_total'] = $pur_price1;
            $newdata_aph['hd_begin'] = $pur_price1;
            $newdata_aph['hd_paid'] = 0;
            $newdata_aph['hd_disc'] = 0;
            $newdata_aph['hd_end'] = intVal($newdata_aph['hd_begin']) - intVal($newdata_aph['hd_paid']) - intVal($newdata_aph['hd_disc']);

            $newdata_aph['pinv_code'] = 'VPR';

            /* update veh_stk */
            //$stk = array();
            //$stk['rpr_inv_no'] = $data['rpr_inv_no'];
            //$stk['rpr_date'] = $data['rpr_date'];

            $rpur_qty = $veh_stk->rpur_qty + 1;

            $stk = array(
                'rpur_qty' => $rpur_qty,
                'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $rpur_qty - $veh_stk->pick_qty - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty,
                'rpr_inv_no' => $data['rpr_inv_no'],
                'rpr_date' => $data['rpr_date']
            );


            $this->all_m->insertData('veh_aph', $newdata_aph);

            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $stk);

            $this->all_m->updateData($table, 'id', $id, $data);


            $msg = array('success' => true, 'message' => 'close success');
        }
        $this->json($msg);
    }

    function uncloseReturnPembelian() {
        //Update table veh_rslh, veh_rsld, veh_arh, veh_stk
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            $data = (array) $this->all_m->getId($table, 'id', $id);

            $veh_stk = $this->all_m->getOne('veh_stk', array('pur_inv_no' => $data['pur_inv_no']));
            $rpur_qty = $veh_stk->rpur_qty - 1;

            $stk = array(
                'rpur_qty' => $rpur_qty,
                'end_qty' => $veh_stk->beg_qty + $veh_stk->pur_qty - $rpur_qty - $veh_stk->pick_qty - $veh_stk->sal_qty + $veh_stk->rsal_qty + $veh_stk->opn_qty,
                'rpr_inv_no' => '',
                'rpr_date' => '0000-00-00'
            );
            //print_r($stk);exit;
            /* update veh_stk */
            //$stk = array();
            // $stk['rpr_inv_no'] = '';
            //$stk['rpr_date'] = '0000-00-00';

            $this->all_m->deleteData('veh_aph', 'pur_inv_no', $data['pur_inv_no']);

            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $stk);

            $this->all_m->updateData($table, 'id', $id, array('cls_date' => '0000-00-00', 'cls_by' => '', 'rpr_date' => '0000-00-00'));


            $msg = array('success' => true, 'message' => 'unclose success');
        }
        $this->json($msg);
    }

    function htmlreadReturPembelian($data) {
        $tbl = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];

        $row = (array) $this->all_m->getId($tbl, 'id', $id);

        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .='<table class="tables" >';
        $html .= $this->readhtmlcompany();
        
        $html .= '<h3>Faktur Retur Penjualan Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= ' <td width="120">
                         <table border="0.5" style="padding-left:5pt;">
                            <tr><td><b>No. Faktur :</b> <br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['rpr_inv_no'] . '</span></td></tr>
                            <tr><td><b>Tgl. Retur Jual :</b> <br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['rpr_date']) . '</span></td></tr>
                            <tr><td><b>Tgl.J.Tempo :</b><br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['due_date']) . '</span></td></tr>
                            <tr><td><b>No. Faktur Beli :</b><br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['pur_inv_no'] . '</span></td></tr>
                            <tr><td><b>Tgl. Faktur Beli :</b><br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['pur_date']) . '</span></td></tr>                        
                            <tr><td><b>Kode Supplier :</b> <br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['supp_code'] . '</span></td></tr>    
                        </table>
                    </td>';
        $html .= '    <td width="420">
                        <table class="tables" >
                           <tr>
                             <td>
                                 <table cellpadding="1">
                                    <tr><td width="100" class="bold">Nama Supplier</td><td width="5">:</td><td width="305">' . $row['supp_name'] . '</td></tr>
                                </table>
                             </td>
                           </tr>
                        </table>
                    </td>';
        $html .= '</tr>';
        $html .= '</table><br /><br />';

        if ($row['key_no'] !== '' && $row['alarm'] !== '') {
            $keyalarm = $row['key_no'] . ' - ' . $row['alarm'];
        } elseif ($row['key_no'] == '' && $row['alarm'] !== '') {
            $keyalarm = $row['alarm'];
        } else {
            $keyalarm = $row['key_no'];
        }

        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table class="tables" style=" padding-left:2pt;border:0.5px solid #000">';
        $html .= '<tr>  
                        <th border="0.5" width="40" class="center">No</th>
                        <th border="0.5" colspan="3" class="center" width="350">Keterangan</th>
                        <th border="0.5" class="center" width="50">Qty</th>
                        <th border="0.5" class="right">Harga</th>
                  </tr>';
        $html .= '<tr>  
                        <td valign="top" class="center">1.</td>
                        <td colspan="3">
                            <table cellpadding="1" >
                                <tr><td><b>Kendaraan</b></td><td class="td-ro">:</td><td>' . $row['veh_name'] . '</td></tr>
                                <tr><td>Warna</td><td class="td-ro">:</td><td>' . $row['color_name'] . '</td></tr>
                                <tr><td>Tahun</td><td class="td-ro">:</td><td>' . $row['veh_year'] . '</td></tr>
                                <tr><td>No.Rangka</td><td class="td-ro">:</td><td>' . $row['chassis'] . '</td></tr>
                                <tr><td>No.Mesin</td><td class="td-ro">:</td><td>' . $row['engine'] . '</td></tr>
                                <tr><td>No.Kunci / Alarm</td><td class="td-ro">:</td><td>' . $keyalarm . '</td></tr>
                            </table>
                        </td>
                        <td valign="top" class="center">1</td>
                        <td valign="top" class="right">' . rupiah($row['pur_bt']) . '</td>
                  </tr>';

        $html .='<tr><td></td><td colspan="3" border="0"></td><td></td><td></td></tr>';
        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >&nbsp;&nbsp;&nbsp;Dasar Pengenaan Pajak</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['pur_bt']) . '</td>
                  </tr>';

        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >&nbsp;&nbsp;&nbsp;Pajak Pertambahan Nilai</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['pur_vat1']) . '</td>
                  </tr>';
        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >&nbsp;&nbsp;&nbsp;Pajak Penjualan Atas Barang Mewah</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['pur_pbm1']) . '</td>
                  </tr>';

        $html .= '<tr>  
                        <td valign="top" class="center"></td>
                        <td colspan="3" >&nbsp;&nbsp;&nbsp;Lain - lain</td>
                        <td valign="top" class="center"></td>
                        <td valign="top" class="right">' . rupiah($row['pur_misc1']) . '</td>
                  </tr>';

        $html .='<tr><td></td><td colspan="3" border="0"></td><td></td><td></td></tr>';
        $html .='<tr><td></td><td colspan="3" border="0"></td><td></td><td></td></tr>';

        $pur_price = $row['pur_bt'] + $row['pur_vat1'] + $row['pur_pbm1'] + $row['pur_pph1'] + $row['pur_misc1'];


        $html .= '</table>
                    </td>
                 </tr>';
        $html .= '</table>';

        $html .= '<table class="tables"><tr><td><table class="tables">';
        $html .= '<tr>
                        <td colspan="5" class="right"><b>Jumlah</b></td>
                        <td border="0.5" valign="top" class="right"><b>' . rupiah($pur_price) . '</b></td>
                  </tr>';
        $html .= '</table></td></tr></table>';

        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VRPR');

        $html .='</td></tr>';
        
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

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
            'number' => $row['rpr_inv_no']
        );

        return $output;
    }

    function check_matching() {
        $tbl = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $id = $this->input->post('id');

        $veh_stk = $this->all_m->getId($tbl, 'id', $id);

        if ($veh_stk->match_date == '0000-00-00' || $veh_stk->match_date == '') {

            $msg = array('status' => false, 'message' => 'Sorry, the vehicle you choose has not been matched. Please input customer data and Pick this vehicle again');
        } else {
            $msg = array('status' => true);
        }

        $this->json($msg);
    }

    function deletePOPenerimaan() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_prh = $this->all_m->getId($table, 'id', $id);

        $data['po_no'] = '';
        $data['po_date'] = '0000-00-00';
        $data["supp_code"] = '';
        $data["veh_code"] = '';

        $data["supp_name"] = '';
        $data["veh_name"] = '';
        $data["color_name"] = '';
        $data["stdoptcode"] = '';
        $data["loc_code"] = '';

        $data["veh_code"] = '';
        $data["veh_brand"] = '';

        $data["veh_transm"] = '';
        $data["veh_year"] = '';
        $data["chassis"] = '';
        $data["engine"] = '';
        $data["veh_type"] = '';
        $data["veh_model"] = '';

        $data["color_code"] = '';
        $data["color_type"] = '';

        $data["po_date"] = '';
        $data["pred_stk_d"] = '';
        $data["alarm"] = '';
        $data["key_no"] = '';
        $data["serv_book"] = '';

        $data["po_made_by"] = '';
        $data["po_appr_by"] = '';
        $data["po_desc"] = '';

        $data["qty"] = '';
        $data["unit"] = '';

        $this->all_m->updateData('veh_po', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));
        $this->all_m->updateData('veh_poo', 'po_no', $veh_prh->po_no, array('pur_inv_no' => ''));
        $this->all_m->updateData($table, 'id', $id, $data);

        $msg = array('success' => true, 'message' => 'Delete success');

        $this->json($msg);
    }

    function saveMove() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        //$data['mvrep_code'] = $data['supp_code'];
        //$data['mvrep_name'] = $data['supp_name'];

        unset($data['supp_code']);
        unset($data['supp_name']);
        unset($data['table']);
        unset($data['id']);


        if (!empty($data['mov_date'])) {
            $data['mov_date'] = $this->dateFormat($data['mov_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }

        if (!empty($data['sji_date'])) {
            $data['sji_date'] = $this->dateFormat($data['movsji_date_date']);
        }
        if (!empty($data['do_date'])) {
            $data['do_date'] = $this->dateFormat($data['do_date']);
        }
        if (!empty($data['pur_date'])) {
            $data['pur_date'] = $this->dateFormat($data['pur_date']);
        }

        $res = true;

        if ($res !== false) {

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
                unset($data['mov_inv_no']);
                $data['mov_inv_no'] = $this->all_m->inv_seq('4', 'VMV');
                $this->all_m->insertData($table, $data);

                $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VMV'));
                $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function closeMove() {
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_movh = $this->all_m->getId($table, 'id', $id);
        $veh_stk = $this->all_m->getId('veh_stk', 'chassis', $veh_movh->chassis);

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }

        if ($veh_movh->wrhs_from !== $veh_stk->wrhs_code) {
            $msg = array('success' => false, 'message' => 'Invoice no closed, Warehouse from not the same as stock Warehouse ');
        }

        if ($msg['success'] !== false) {

            $datamovh = array(
                'mov_date' => date("Y-m-d"),
                'cls_cnt' => $veh_prh->cls2_cnt + 1,
                'cls_by' => $user,
                'cls_date' => date("Y-m-d")
            );
            $datasstk = array(
                'wrhs_code' => $veh_movh->wrhs_to,
                'wrhs_orig' => $veh_movh->wrhs_from,
                'loc_code' => $veh_movh->loc_to,
                'loc_orig' => $veh_movh->loc_from
            );


            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $datasstk);
            $this->all_m->updateData($table, 'id', $id, $datamovh);

            $msg = array('success' => true, 'message' => 'Invoice successfully closed');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function uncloseMove() {
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $veh_movh = $this->all_m->getId($table, 'id', $id);
        $veh_stk = $this->all_m->getId('veh_stk', 'chassis', $veh_movh->chassis);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($veh_stk->sal_inv_no !== '') {
            $msg = array('success' => false, 'message' => 'Invoice unclosed, Stock already has sales ');
        }
        if ($veh_stk->match_date !== '0000-00-00') {
            $msg = array('success' => false, 'message' => 'Invoice unclosed, Stock already in matching');
        }

        if ($msg['success'] !== false) {

            $datamovh = array(
                'mov_date' => '0000-00-00',
                'cls_by' => '',
                'cls_date' => '0000-00-00',
            );
            $datasstk = array(
                'wrhs_code' => $veh_movh->wrhs_from,
                'wrhs_orig' => $veh_movh->wrhs_from,
                'loc_code' => $veh_movh->loc_from,
                'loc_orig' => $veh_movh->loc_from
            );


            $this->all_m->updateData('veh_stk', 'id', $veh_stk->id, $datasstk);
            $this->all_m->updateData($table, 'id', $id, $datamovh);

            $msg = array('success' => true, 'message' => 'Invoice successfully unclosed');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deleteMove() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $this->all_m->deleteData($table, 'id', $id);

        $check = $this->all_m->countlimit($table, array('id' => $id));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Delete failed');
        } else {
            $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => 'VMV'));
            $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no - 1));

            $msg = array('success' => true, 'message' => 'Delete success');
        }

        $this->json($msg);
    }

    function htmlreadMove($data) {
        $table = $data['tbl'];
        $id = $data['id'];
        $user = $data['user'];
        $row = (array) $this->all_m->getId($table, 'id', $id);
        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .= $this->readhtmlcompany();
        
        $html .= '<h3>Faktur Pemindahan Kendaraan</h3>';
        $html .= '<table  class="tables">';
        $html .= '<tr>';
        $html .= '<td width="120">'
                . '<table border="1" class="tables">'
                . '<tr><td><b>No. Faktur :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['mov_inv_no'] . '</td></tr>'
                . '<tr><td><b>Tgl. Faktur :</b> <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $this->dateView($row['mov_date']) . '</td></tr>'
                . '<tr><td><b>Kode Pemindah :</b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['mvrep_code'] . '</td></tr>'
                . '<tr><td><b></b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>'
                . '<tr><td><b></b><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>'
                . '</table></td>';
        $html .= '<td>'
                . '<table class="tables" border="1"  width="410">
                           <tr>
                             <td>
                                 <table class="tables">
                                    <tr><td><br /></td></tr>
                                    <tr><td class="bold" width="100">DARI WAREHOUSE</td><td width="100">:&nbsp;&nbsp;' . $row['wrhs_from'] . '</td></tr>
                                    <tr><td class="bold">KE WAREHOUSE</td><td>:&nbsp;&nbsp;' . $row['wrhs_to'] . '</td></tr>
                                        <tr><td><br /></td></tr>  
                                    <tr><td class="bold">NO. SURAT JALAN</td><td>:&nbsp;&nbsp;' . $row['sji_no'] . '</td><td class="bold" width="60">TANGGAL</td><td>:&nbsp;&nbsp;' . $this->dateView($row['sji_date']) . '</td></tr>
                                    <tr><td class="bold">NO. DO</td><td>:&nbsp;&nbsp;' . $row['do_no'] . '</td><td class="bold">TANGGAL</td><td>:&nbsp;&nbsp;' . $this->dateView($row['do_date']) . '</td></tr>
                                    <tr><td><br /><br /></td></tr>    
                                </table>
                             </td>
                           </tr>
                           
                        </table>'
                . '</td>';

        $html .= '</tr>';
        $html .= '</table><br /><br />';

        $html .= '<table class="tables">';
        $html .= '<tr><td>';
        $html .= '<table class="tables" width="580" style="border:1px solid #000;width:100%;">';
        $html .= '<tr>
                        <th border="1" colspan="3" class="center">Keterangan</th>
                        <th border="1" width="50" class="right">Qty</th>
                        <th border="1" class="right">Harga Satuan</th>
                        <th border="1" class="right">Harga</th>
                  </tr>';

        $html .= '<tr>                        
                        <td colspan="3">
                         <table>
                            <tr><td width="50"><b>Kendaraan</b></td><td class="td-ro"><b>:</b></td><td>' . $row['veh_name'] . '</td></tr>
                            <tr><td>Tipe</td><td class="td-ro">:</td><td>' . $row['veh_type'] . '</td></tr>
                            <tr><td>Transmisi</td><td class="td-ro">:</td><td>' . $row['veh_transm'] . '</td></tr>
                            <tr><td></td></tr>
                            <tr><td>Model</td><td class="td-ro">:</td><td>' . $row['veh_model'] . '</td></tr>
                            <tr><td>Tahun</td><td class="td-ro">:</td><td>' . $row['veh_year'] . '</td></tr>
                            <tr><td></td></tr>
                            <tr><td>Warna</td><td class="td-ro">:</td><td>' . $row['color_name'] . '</td></tr>
                             <tr><td></td></tr>
                            <tr><td>No. Rangka</td><td class="td-ro">:</td><td>' . $row['chassis'] . '</td></tr>
                            <tr><td>No. Mesin</td><td class="td-ro">:</td><td>' . $row['engine'] . '</td></tr>
                            <tr><td></td></tr>
                            <tr><td>No. Kunci</td><td class="td-ro">:</td><td>' . $row['key_no'] . '</td></tr>
                            <tr><td>No. Polisi</td><td class="td-ro">:</td><td>' . $row['veh_reg_no'] . '</td></tr>
                        </table>
                        </td>
                        <td rowspan="4"  style="border:1px solid #000;" class="right">1 UNIT</td>
                        <td rowspan="4" class="right" style="border:1px solid #000;">' . rupiah($row['unit_price']) . '</td>
                        <td rowspan="4" class="right" style="border:1px solid #000;">' . rupiah($row['tot_price']) . '</td>
                  </tr>';
        $html .= '<tr>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td></tr>';
        $html .= '<tr>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td></tr>';
        $html .= '<tr>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td>'
                . '<td></td></tr>';

        $html .= '<tr>
                            <td colspan="4"></td>
                            <td style="text-align: right !important;" ><b>Jumlah:</b></td>
                            <td class="right">' . rupiah($row['tot_price']) . '</td>
                        </tr>';

        $html .= '</table>';
        $html .='</td></tr>';
        $html .= '</table>';
        $html .= '<table class="tables">';
        $html .= '<tr>
                    <td>
                      <table>
                         <tr><td></td></tr>
                         <tr><td><b>KETENTUAN:</b></td></tr>       
                     </table>
                    </td>
                 </tr>';

        $html .='<tr><td>';
        $html .= $this->set_form('VMV');

        $html .='</td></tr>';
        /* Counter Printer*/
        $user = $data['user'];
        $prn_cnt = $row['prn_cnt'];

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
            'number' => $row['po_no']
        );

        return $output;
    }

    function refreshStock() {
        $chassis = $this->input->post('chassis');
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $beg_qty = 0;
        $pur_qty = 0;
        $rpur_qty = 0;
        $pick_qty = 0;
        $sal_qty = 0;
        $rsal_qty = 0;
        $opn_qty = 0;


        $query = $this->all_m->refreshingStock($chassis);
        $row = $query[0];

        if ($row->prh_cls !== '0000-00-00') {
            $pur_qty = 1;
        }

        if ($row->rprh_cls !== null) {
            if ($row->rprh_cls !== '0000-00-00') {
                $rpur_qty = 1;
            }
        }

        if ($row->pick_qty !== '0000-00-00') {
            $pick_qty = 1;
        }

        if ($row->slh_cls !== '0000-00-00') {
            $pick_qty = 0;
            $sal_qty = 1;
        }

        if ($row->rslh_cls !== null) {
            if ($row->rslh_cls !== '0000-00-00') {
                $rsal_qty = 1;
            }
        }

        $end_qty = $beg_qty + $pur_qty - $rpur_qty - $pick_qty - $sal_qty + $rsal_qty + $opn_qty;

        $data = array(
            'beg_qty' => $beg_qty,
            'pur_qty' => $pur_qty,
            'rpur_qty' => $rpur_qty,
            'pick_qty' => $pick_qty,
            'sal_qty' => $sal_qty,
            'rsal_qty' => $rsal_qty,
            'opn_qty' => $opn_qty,
            'end_qty' => $end_qty
        );

        $update = $this->all_m->updateData($table, 'id', $id, $data);

        $msg = array('success' => true);

        $this->json($msg);
    }

    function DeleteVSLReturn() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $stat = true;
        $data = $this->all_m->getId($table, 'id', $id);

        $check_sld = $this->all_m->countlimit('veh_rsld', array('rsl_inv_no' => $data->rsl_inv_no));

        if ($check_sld > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        }

        if ($stat !== false) {
            $sql_slh = "SHOW COLUMNS FROM veh_slh";
            $veh_slh = $this->all_m->query_all($sql_slh);


            foreach ($veh_slh as $slh) {
                $field_slh[$slh->Field] = '';
            }
            unset($field_slh['id']);
            unset($field_slh['wrhs_code']);

            foreach ($data as $k => $v) {

                if (array_key_exists($k, $field_slh)) {
                    $key[] = $k;
                    $val[] = '';
                }
            }

            /* data veh_arh */
            $newdata_slh = array_combine($key, $val);

            $this->all_m->updateData($table, 'id', $id, $newdata_slh);

            $msg = array('success' => true);
        }
        $this->json($msg);
    }
    function DeleteVPRReturn() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $stat = true;
        $data = $this->all_m->getId($table, 'id', $id);

        
        if ($stat !== false) {
            $sql_prh = "SHOW COLUMNS FROM veh_prh";
            $veh_prh = $this->all_m->query_all($sql_prh);


            foreach ($veh_prh as $prh) {
                $field_prh[$prh->Field] = '';
            }
            unset($field_prh['id']);
            unset($field_prh['wrhs_code']);

            foreach ($data as $k => $v) {

                if (array_key_exists($k, $field_prh)) {
                    $key[] = $k;
                    $val[] = '';
                }
            }

            /* data veh_arh */
            $newdata_prh = array_combine($key, $val);

            $this->all_m->updateData($table, 'id', $id, $newdata_prh);

            $msg = array('success' => true);
        }
        $this->json($msg);
    }

}
