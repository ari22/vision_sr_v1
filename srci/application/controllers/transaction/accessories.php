<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Accessories extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function read_slh() {
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        $sinv_code = $this->uri->segment(4);

        $where = array('sinv_code' => $sinv_code);
        $read = $this->crud_mdl->read($table, $nav, $id, $where);
        $this->json($read);
    }

    function saveAccessories() {
        $date = date('Y-m-d');
        $user = $this->uri->segment(4);
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        unset($data['inv_type']);



        if (!empty($data['cls2_date'])) {
            $data['cls2_date'] = $this->dateFormat($data['cls2_date']);
        }
        if (!empty($data['cls_date'])) {
            $data['cls_date'] = $this->dateFormat($data['cls_date']);
        }
        if (!empty($data['sal_date'])) {
            $data['sal_date'] = $this->dateFormat($data['sal_date']);
        }
        if (!empty($data['opn_date'])) {
            $data['opn_date'] = $this->dateFormat($data['opn_date']);
        }
        if (!empty($data['due_date'])) {
            $data['due_date'] = $this->dateFormat($data['due_date']);
        }

        if (!empty($data['po_date'])) {
            $data['po_date'] = $this->dateFormat($data['po_date']);
        }
        if (!empty($data['quote_date'])) {
            $data['quote_date'] = $this->dateFormat($data['quote_date']);
        }
        if (!empty($data['prcvd_date'])) {
            $data['prcvd_date'] = $this->dateFormat($data['prcvd_date']);
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
        if (!empty($data['open_date'])) {
            $data['open_date'] = $this->dateFormat($data['open_date']);
        }
        if (!empty($data['rsl_date'])) {
            $data['rsl_date'] = $this->dateFormat($data['rsl_date']);
        }
        if (!empty($data['rpr_date'])) {
            $data['rpr_date'] = $this->dateFormat($data['rpr_date']);
        }
        if (!empty($data['mov_date'])) {
            $data['mov_date'] = $this->dateFormat($data['mov_date']);
        }

        $data['opn_date'] = date('Y-m-d');

        $stat = true;

        if ($table == 'acc_poh') {
            if ($data['prep_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Customer Name & Code');
            }

            if ($data['supp_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Supplier Name & Code');
            }

            $fieldunique = 'po_no';
            $inv_type = 'APO';
        }

        if ($table == 'acc_prh') {

            if ($data['supp_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Supplier Name & Code');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }

            $fieldunique = 'pur_inv_no';
            $inv_type = 'APR';
        }

        if ($table == 'acc_opnh') {
            if ($data['oprep_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Opname person Code & Name');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }

            $fieldunique = 'opn_inv_no';
            $inv_type = 'AOP';

            $data['opn_date'] = '';
        }

        if ($table == 'acc_rslh') {
            if ($data['cust_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Customer Name & Code');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }

            $fieldunique = 'rsl_inv_no';
            $inv_type = 'ARC';
        }

        if ($table == 'acc_rprh') {
            if ($data['supp_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Supplier Name and Code');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }
            if ($data['pur_date'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input purchase date');
            }
            if ($data['pur_inv_no'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input purchase invoice no.');
            }
            $fieldunique = 'rpr_inv_no';
            $inv_type = 'ARP';
        }

        if ($table == 'acc_slh') {
            $fieldunique = 'sal_inv_no';

            if ($this->uri->segment(5)) {

                if ($this->uri->segment(5) == 'ASC') {
                    if ($data['cust_code'] == '') {
                        $stat = false;
                        $msg = array('success' => false, 'message' => ' Please input Customer Name & Code');
                    }
                    $inv_type = 'ASC';
                    $data['sinv_code'] = 'ASC';
                } else {
                    if ($data['cust_code'] == '') {
                        $stat = false;
                        $msg = array('success' => false, 'message' => ' Please input Customer Name & Code');
                    }
                    if ($data['sal_inv_no'] == '') {
                        $stat = false;
                        $msg = array('success' => false, 'message' => ' Please input purchase invoice no.');
                    }
                    
                    $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);
                    
                    if($veh_slh->cls_date !== '0000-00-00'){
                        $stat = false;
                        $msg = array('success' => false, 'message' => 'Sorry, Sales Invoice No. already closed');
                    }
                    
                    $inv_type = 'VSL';
                    $data['sinv_code'] = 'VSL';
                }
            } else {
                if ($data['dept_code'] == '') {
                    $stat = false;
                    $msg = array('success' => false, 'message' => ' Please input Department Code & Name');
                }


                $inv_type = 'ASA';

                $data['cust_code'] = $data['dept_code'];
                $data['cust_name'] = $data['dept_name'];
                $data['sinv_code'] = 'ASA';
                unset($data['dept_code']);
                unset($data['dept_name']);
            }

            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse');
            }
        }

        if ($table == 'acc_movh') {
            if ($data['wrhs_to'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse destination of sent items');
            }
            if ($data['wrhs_from'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Warehouse where sent items were taken from');
            }
            if ($data['mvrep_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Please input Mover Name & Code');
            }

            $fieldunique = 'mov_inv_no';
            $inv_type = 'AMV';
        }


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
                if ($inv_type !== 'VSL') {
                    unset($data[$fieldunique]);
                }
                $count = $this->all_m->countlimit($table, array($fieldunique => $this->all_m->inv_seq('4', $inv_type)));

                if ($count < 1) {

                    if ($inv_type !== 'VSL') {
                        $data[$fieldunique] = $this->all_m->inv_seq('4', $inv_type);
                        $inv_seq = $this->all_m->getOne('inv_seq', array('inv_type' => $inv_type));
                        $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, array('inv_no' => $inv_seq->inv_no + 1));
                    }

                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                } else {
                    $msg = array('success' => false, 'message' => 'Failed');
                }
            }
        }

        $this->json($msg);
    }

    function closePO() {
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
            $check_pod = $this->all_m->countlimit('acc_pod', array('po_no' => $data['po_no']));

            if ($check_pod < 1) {
                $msg = array('success' => false, 'message' => 'PO (Purchase Order) cannot be closed because it has no transaction');
            } else {

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['po_date'] = $date;

                //$acc_worh = (array) $this->all_m->getId($table, 'id', $id);

                $acc_pod = $this->all_m->getWhere('acc_pod', array('po_no' => $data['po_no']));


                $sql_acc_pooh = "SHOW COLUMNS FROM acc_pooh";
                $acc_pooh = $this->all_m->query_all($sql_acc_pooh);

                foreach ($acc_pooh as $poh) {
                    $field_acc_pooh[$poh->Field] = '';
                }
                unset($field_acc_pooh['id']);


                foreach ($data as $k => $v) {

                    if (array_key_exists($k, $field_acc_pooh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_acc_pooh = array_combine($key, $val);

                $n = 1;
                $data_pod = array();
                foreach ($acc_pod as $pod) {

                    $data_pod = (array) $pod;
                    unset($data_pod['id']);
                    $data_pod['po_date'] = $date;
                    $data_pod['por_date'] = $date;
                    $data_pod['por_line'] = $n;
                    $data_pod['beg_qty'] = $pod->qty;
                    $data_pod['rcv_qty'] = 0;
                    $data_pod['end_qty'] = $pod->qty;

                    $this->all_m->insertData('acc_pood', $data_pod);
                    $this->all_m->updateData('acc_pod', 'id', $pod->id, array('po_date' => $date, 'por_date' => $date, 'por_line' => $n));

                    $n++;
                }

                $this->all_m->insertData('acc_pooh', $newdata_acc_pooh);
                $this->all_m->updateData($table, 'id', $id, $datacls);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function unclosePO() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $update['cls_date'] = $date;
        $update['cls_by'] = '';
        $update['po_date'] = $date;

        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        $check_prh = $this->all_m->countlimit('acc_prh', array('po_no' => $data['po_no']));

        if ($check_prh > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'PO no. has been used in accessories receiving');
        }

        $check_prd = $this->all_m->countlimit('acc_prd', array('po_no' => $data['po_no']));

        if ($check_prd > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Some item(s) in this PO has been received');
        }

        if ($stat !== false) {
            $acc_worh = (array) $this->all_m->getId($table, 'id', $id);
            $acc_pod = $this->all_m->getWhere('acc_pod', array('po_no' => $data['po_no']));

            foreach ($acc_pod as $pod) {
                $this->all_m->deleteData('acc_pood', 'po_no', $pod->po_no);
                $this->all_m->updateData('acc_pod', 'id', $pod->id, array('po_date' => '0000-00-00', 'por_date' => '0000-00-00', 'por_line' => 0));
            }

            $this->all_m->deleteData('acc_pooh', 'po_no', $data['po_no']);
            $this->all_m->updateData($table, 'id', $id, $update);

            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function delete_PO() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_poh = $this->all_m->getId($tbl, 'id', $id);
        $po_no = $acc_poh->po_no;

        $check_pod = $this->all_m->countlimit('acc_pod', array('po_no' => $po_no));

        if ($check_pod > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        }

        if ($msg['success'] !== false) {
            $this->all_m->deleteData($tbl, 'id', $id);
            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function save_pod() {
        $date = date('Y-m-d');
        $po_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);
        unset($data['disc_unit']);
        unset($data['price_ad_unit']);

        //print_r($data);exit;
        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

        $data_maccs['qty_order'] = $maccs->qty_order + $data['qty'];
        $data_mst['qty_order'] = $acc_mst->qty_order + $data['qty'];



        $data['po_no'] = $po_no;
        $data['add_by'] = $user;
        $data['add_date'] = $date;
        $data['pick_date'] = $date;

        if ($data['part_code'] !== '') {
            //$check = $this->all_m->countlimit($table, array('po_no' => $po_no, 'part_code' => $data['part_code']));
            $check = $this->all_m->countlimit($table, array('po_no' => $po_no, 'part_code' => $data['part_code'], 'part_name' => $data['part_name'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));

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
                    $acc_poh = $this->all_m->getId('acc_poh', 'po_no', $po_no);

                    $tot_price = intval($acc_poh->tot_price) + intval($data['price_ad']);
                    $dpp = $tot_price - intval($acc_poh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_poh = array(
                        'tot_item' => $acc_poh->tot_item + 1,
                        'tot_qty' => $acc_poh->tot_qty + $data['qty'],
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_poh->inv_stamp)
                    );


                    unset($data['price_total']);

                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('acc_poh', 'id', $acc_poh->id, $data_poh);
                    $this->all_m->insertData($table, $data);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function delete_pod() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        // $id_maccs = $this->input->post('id3');

        $acc_pod = $this->all_m->getId($table, 'id', $id);

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkpoh = $this->all_m->countlimit('acc_opnh', array('opn_inv_no' => $data['opn_inv_no']));
        $checkmaccs = $this->all_m->countlimit('maccs', array('part_code' => $acc_pod->part_code, 'part_name' => $acc_pod->part_name, 'wrhs_code' => $acc_pod->wrhs_code, 'location' => $acc_pod->location));
        $checkacc_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $acc_pod->part_code, 'part_name' => $acc_pod->part_name));

        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($checkacc_mst > 0) {
            $stat = true;
        }
        if ($check > 0) {
            $stat = true;
        }
        if ($checkpoh > 0) {
            $stat = true;
        }


        if ($stat !== false) {

            $maccs = $this->all_m->getOne('maccs', array('part_code' => $acc_pod->part_code, 'part_name' => $acc_pod->part_name, 'wrhs_code' => $acc_pod->wrhs_code, 'location' => $acc_pod->location));

            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $acc_pod->part_code, 'part_name' => $acc_pod->part_name));

            $data_maccs['qty_order'] = $maccs->qty_order - $acc_pod->qty;
            $data_mst['qty_order'] = $acc_mst->qty_order - $acc_pod->qty;

            $acc_poh = $this->all_m->getId('acc_poh', 'po_no', $acc_pod->po_no);


            $total = $acc_pod->price_ad;

            $tot_price = intval($acc_poh->tot_price) - intval($total);
            $dpp = $tot_price - intval($acc_poh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_poh = array(
                'tot_item' => $acc_poh->tot_item - 1,
                'tot_qty' => $acc_poh->tot_qty - $acc_pod->qty,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_poh->inv_stamp)
            );

            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);

            $this->all_m->updateData('acc_poh', 'id', $acc_poh->id, $data_poh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function unclosePenerimaan() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        $acc_prh = $this->all_m->getId($table, 'id', $id);

        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        if ($acc_prh->cls2_date !== '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Accessories purchase has been closed');
        }

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);



        if ($stat !== false) {
            if ($acc_prh) {
                $update['cls_date'] = $date;
                $update['cls_by'] = '';
                //$data['pur_date'] = $date;


                /* $acc_prd = $this->all_m->getWhere('acc_prd', array('pur_inv_no' => $data['pur_inv_no']));

                  foreach ($acc_prd as $prd) {
                  $this->all_m->updateData('acc_prd', 'id', $prd->id, array('pur_date' => $date));
                  }
                 */
                $this->all_m->updateData($table, 'id', $id, $update);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        } else {
            $msg = $msg;
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
            $check_prd = $this->all_m->countlimit('acc_prd', array('pur_inv_no' => $data['pur_inv_no']));

            if ($check_prd < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $acc_prh = $this->all_m->getId($table, 'id', $id);

                $acc_prd = $this->all_m->getWhere('acc_prd', array('pur_inv_no' => $data['pur_inv_no']));

                foreach ($acc_prd as $prd) {
                    $this->all_m->updateData('acc_prd', 'id', $prd->id, array('pur_date' => $date));
                }
                $datacls['cls2_date'] = '0000-00-00';
                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['pur_date'] = $date;
                $datacls['cls_cnt'] = $acc_prh->cls_cnt + 1;

                $this->all_m->updateData($table, 'id', $id, $datacls);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function delete_prd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_prd = $this->all_m->getId($table, 'id', $id);
        $data = (array) $acc_prd;


        $status = true;
        $msg = array('status' => false, 'message' => 'Failed to delete detail');
        

        $countacc_prd = $this->all_m->countlimit($table, array('id' => $id));
        $countacc_prh = $this->all_m->countlimit('acc_prh', array('pur_inv_no' => $acc_prd->pur_inv_no));
        $countpood = $this->all_m->countlimit('acc_pood', array('po_no' => $acc_prd->po_no,
            'part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['location'],
            'wrhs_code' => $data['wrhs_code']));
        
        $countacc_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        
                
        if ($countpood < 1) {
             $status = false;
        }

        if ($countacc_mst < 1) {
             $status = false;
        }

        if ($countacc_prd < 1) {
             $status = false;
        }

        if ($countacc_prh < 1) {
            $status = false;
        }

        
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
      
        
        if(intval($data['qty']) > intval($acc_mst->qty)){
            $status = false;
            $msg = array('status' => false, 'message' => ' Sorry, Received Qty ('.intval($data['qty']).') exceeds stock !  Remaining Stock: ' . intval($acc_mst->qty));
        }


        if ($status !== false) {

            $pood = (array) $this->all_m->getOne('acc_pood', array('po_no' => $acc_prd->po_no,
                        'part_code' => $data['part_code'],
                        'part_name' => $data['part_name'],
                        'location' => $data['location'],
                        'wrhs_code' => $data['wrhs_code']));

            $data_pood['rcv_qty'] = $pood['rcv_qty'] - $data['qty'];
            $data_pood['end_qty'] = $pood['beg_qty'] + ($pood['rcv_qty'] - $data['qty']);

            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

            $data_mst['qty'] = $acc_mst->qty - $data['qty'];
            $data_mst['qty_order'] = $acc_mst->qty_order + $data['qty'];

            $maccs = $this->all_m->getOne('maccs', array(
                'part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['location'],
                'wrhs_code' => $data['wrhs_code']
                    )
            );

            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_maccs['qty_order'] = $maccs->qty_order + $data['qty'];


            $acc_prh = $this->all_m->getId('acc_prh', 'pur_inv_no', $acc_prd->pur_inv_no);

            $total_price = $acc_prd->price_ad;

            $tot_price = intval($acc_prh->tot_price) - $total_price;
            $dpp = $tot_price - intval($acc_prh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_prh = array(
                'tot_qty' => $acc_prh->tot_qty - $acc_prd->qty,
                'tot_item' => $acc_prh->tot_item - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_prh->inv_stamp)
            );
            //print_r($data_prh);exit;
            $this->all_m->updateData('acc_pood', 'id', $pood['id'], $data_pood);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);

            $this->all_m->updateData('acc_prh', 'id', $acc_prh->id, $data_prh);
            $this->all_m->deleteData($table, 'id', $id);

            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = $msg;
        }


        $this->json($msg);
    }

    function save_prd() {
        $date = date('Y-m-d');
        $pur_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $pood_id = $data['pood_id'];

        unset($data['table2']);
        unset($data['id2']);
        unset($data['pood_id']);


        $pood = (array) $this->all_m->getId('acc_pood', 'id', $pood_id);
        $pood_id = $pood['id'];
        unset($pood['id']);

        $data_pood['rcv_qty'] = $pood['rcv_qty'] + $data['qty'];
        $data_pood['end_qty'] = $pood['beg_qty'] - ($pood['rcv_qty'] + $data['qty']);

        // print_r($pood);exit;
        $sql_acc_prd = "SHOW COLUMNS FROM acc_prd";
        $acc_prd = $this->all_m->query_all($sql_acc_prd);

        foreach ($acc_prd as $prd) {
            $field_acc_prd[$prd->Field] = '';
        }
        unset($field_acc_prd['id']);


        foreach ($pood as $k => $v) {

            if (array_key_exists($k, $field_acc_prd)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        $data_acc_prd = array_combine($key, $val);


        $data_acc_prd['pur_inv_no'] = $pur_inv_no;
        $data_acc_prd['add_by'] = $user;
        $data_acc_prd['add_date'] = $date;
        $data_acc_prd['qty'] = $data['qty'];
        $data_acc_prd['prep_code'] = $data['prep_code'];
        $data_acc_prd['prep_name'] = $data['prep_name'];

        if ($data['price_bd']) {
            $data_acc_prd['price_bd'] = $data['price_bd'];
            $data_acc_prd['disc_pct'] = $data['disc_pct'];
            $data_acc_prd['disc_val'] = $data['disc_val'];
            $data_acc_prd['price_ad'] = $data['price_ad'];
        }

        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        $data_mst['qty'] = $acc_mst->qty + $data['qty'];
        $data_mst['qty_order'] = $acc_mst->qty_order - $data['qty'];

        $maccs = $this->all_m->getOne('maccs', array('part_code' => $pood['part_code'],
            'part_name' => $pood['part_name'],
            'location' => $pood['location'],
            'wrhs_code' => $pood['wrhs_code']
                )
        );

        $data_maccs['qty'] = $maccs->qty + $data['qty'];
        $data_maccs['qty_order'] = $maccs->qty_order - $data['qty'];
        //print_r($maccs);exit;
        if ($data['part_code'] !== '') {
            $check = $this->all_m->countlimit($table, array('pur_inv_no' => $pur_inv_no, 'part_code' => $data['part_code']));

            if ($id !== '') {
                if ($check > 1) {
                    $msg = array('success' => false, 'message' => 'Maaf, data tidak dapat disimpan karena sudah ada di faktur ini');
                } else {
                    unset($data['price_total']);
                    unset($data['disc_unit']);
                    unset($data['price_ad_unit']);
                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                }
            } else {
                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
                } else {

                    $acc_prh = $this->all_m->getId('acc_prh', 'pur_inv_no', $pur_inv_no);
                    if ($data['price_ad']) {
                        $total_price = $data['price_ad'];
                    } else {
                        $total_price = $maccs->pur_price * $data['qty'];
                    }

                    $tot_price = intval($acc_prh->tot_price) + intval($total_price);
                    $dpp = $tot_price - intval($acc_prh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_prh = array(
                        'tot_item' => $acc_prh->tot_item + 1,
                        'tot_qty' => $acc_prh->tot_qty + $data['qty'],
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($acc_prh->inv_stamp)
                    );

                    $this->all_m->updateData('acc_pood', 'id', $pood_id, $data_pood);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_prh', 'id', $acc_prh->id, $data_prh);

                    $this->all_m->insertData($table, $data_acc_prd);
                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
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

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }
        if ($msg['success'] !== false) {
            if (!empty($data['due_date'])) {
                $data['due_date'] = $this->dateFormat($data['due_date']);
            }

            $acc_prh = (array) $this->all_m->getId($table, 'id', $id);
            unset($acc_prh['id']);



            $sql_acc_aph = "SHOW COLUMNS FROM acc_aph";
            $acc_aph = $this->all_m->query_all($sql_acc_aph);

            foreach ($acc_aph as $aph) {
                $field_acc_aph[$aph->Field] = '';
            }
            unset($field_acc_aph['id']);


            foreach ($acc_prh as $k => $v) {

                if (array_key_exists($k, $field_acc_aph)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }

            $data_aph = array_combine($key, $val);
            $data_aph['pur_date'] = $date;
            $data_aph['pinv_code'] = 'APR';
            $data_aph['hd_begin'] = $data['inv_total'];
            $data_aph['hd_paid'] = 0;
            $data_aph['hd_disc'] = 0;
            $data_aph['hd_end'] = $data['inv_total'];

            $stat = true;
            if (intval(strtotime($data['due_date'])) < intval(strtotime($date))) {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Today\'s date + TOP day(s) doesn\'t equal TOP Date');
            }

            if ($acc_prh['cls_date'] == '0000-00-00') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Accessories Receiving hasn\'t been closed (finished). Please close it first');
            }

            if ($stat !== false) {

                $check_pod = $this->all_m->countlimit('acc_prd', array('pur_inv_no' => $data['pur_inv_no']));

                if ($check_pod < 1) {
                    $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
                } else {
                    $update['cls2_date'] = $date;
                    $update['cls2_by'] = $user;
                    $update['pur_date'] = $date;
                    $update['cls2_cnt'] = $acc_prh['cls_cnt'] + 1;


                    $acc_prd = $this->all_m->getWhere('acc_prd', array('pur_inv_no' => $data['pur_inv_no']));

                    foreach ($acc_prd as $prd) {
                        $maccs = $this->all_m->getOne('maccs', array('wrhs_code' => $prd->wrhs_code, 'location' => $prd->location, 'part_code' => $prd->part_code));

                        $this->all_m->updateData('maccs', 'id', $maccs->id, array('last_pur' => $date));
                        $this->all_m->updateData('acc_prd', 'id', $prd->id, array('pur_date' => $date));
                    }

                    $this->all_m->updateData($table, 'id', $id, $update);
                    $this->all_m->insertData('acc_aph', $data_aph);
                    $msg = array('success' => true, 'message' => 'success');
                }
            } else {
                $msg = $msg;
            }
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

        $acc_prh = $this->all_m->getId($table, 'id', $id);

        $update['cls2_date'] = $date;
        $update['cls2_by'] = '';
        $update['pur_date'] = $date;

        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        $check_apd = $this->all_m->countlimit('acc_apd', array('pur_inv_no' => $acc_prh->pur_inv_no));
        $check_apgd = $this->all_m->countlimit('acc_apgd', array('pur_inv_no' => $acc_prh->pur_inv_no));
        
        if ($check_apgd > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
            $stat = false;
        }
        if ($check_apd > 0) {
            $msg = array('success' => false, 'message' => ' Sorry, this Invoice cannot be unclosed because it already have payable payment(s). Please delete them first');
            $stat = false;
        }  


        if ($stat !== false) {
            $acc_prd = $this->all_m->getWhere('acc_prd', array('pur_inv_no' => $acc_prh->pur_inv_no));

            foreach ($acc_prd as $prd) {
                $maccs = $this->all_m->getOne('maccs', array('wrhs_code' => $prd->wrhs_code, 'location' => $prd->location, 'part_code' => $prd->part_code));

                $this->all_m->updateData('maccs', 'id', $maccs->id, array('last_pur' => $date));
                $this->all_m->updateData('acc_prd', 'id', $prd->id, array('pur_date' => $date));
            }

            $this->all_m->updateData($table, 'id', $id, $update);
            $this->all_m->deleteData('acc_aph', 'pur_inv_no', $acc_prh->pur_inv_no);
            $msg = array('success' => true, 'message' => 'success');

            $msg = array('success' => true, 'message' => 'success');
        }
        $this->json($msg);
    }

    function save_opnd() {
        $date = date('Y-m-d');
        $opn_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        $data['oprep_code'] = $data['oprep_code2'];

        unset($data['oprep_code2']);
        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);



        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        $opnh = $this->all_m->getId('acc_opnh', 'opn_inv_no', $opn_inv_no);

        $data_maccs['qty'] = $maccs->qty + $data['qty'];
        $data_mst['qty'] = $acc_mst->qty + $data['qty'];

        $data_opnh['tot_qty'] = $opnh->tot_qty + $data['qty'];
        $data_opnh['tot_item'] = $opnh->tot_item + 1;
        $data_opnh['tot_price'] = $opnh->tot_price + $data['price_total'];

        $data['opn_inv_no'] = $opn_inv_no;
        $data['add_by'] = $user;
        $data['add_date'] = $date;
        $data['pick_date'] = $date;

        $check = $this->all_m->countlimit($table, array('opn_inv_no' => $opn_inv_no, 'part_code' => $data['part_code'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));

        if ($id !== '') {
            if ($check > 1) {
                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
            } else {

                $this->all_m->updateData($table, 'id', $id, $data);

                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            }
        } else {
            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
            } else {
                unset($data['price_total']);
                $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                $this->all_m->updateData('acc_opnh', 'id', $opnh->id, $data_opnh);

                $this->all_m->insertData($table, $data);

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function delete_opnd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $id_maccs = $this->input->post('id3');

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['price_total'] = $data['price_bd'] * $data['qty'];

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkopnh = $this->all_m->countlimit('acc_opnh', array('opn_inv_no' => $data['opn_inv_no']));
        $checkmaccs = $this->all_m->countlimit('maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['location'],
            'wrhs_code' => $data['wrhs_code']
                )
        );
        $checkacc_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($checkacc_mst > 0) {
            $stat = true;
        }

        if ($check > 0) {
            $stat = true;
        }
        if ($checkopnh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $opnh = $this->all_m->getId('acc_opnh', 'opn_inv_no', $data['opn_inv_no']);

            $maccs = $this->all_m->getOne('maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['location'],
                'wrhs_code' => $data['wrhs_code']
                    )
            );
            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_mst['qty'] = $acc_mst->qty - $data['qty'];

            $data_opnh['tot_qty'] = $opnh->tot_qty - $data['qty'];
            $data_opnh['tot_item'] = $opnh->tot_item - 1;
            $data_opnh['tot_price'] = $opnh->tot_price - $data['price_total'];


            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
            $this->all_m->updateData('acc_opnh', 'id', $opnh->id, $data_opnh);
            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closeOpname() {
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
            $check_opnd = $this->all_m->countlimit('acc_opnd', array('opn_inv_no' => $data['opn_inv_no']));

            if ($check_opnd < 1) {
                $msg = array('success' => false, 'message' => 'Sorry, invoice cannot be closed because it has no transaction');
            } else {
                $acc_opnh = $this->all_m->getId($table, 'id', $id);

                $acc_opnd = $this->all_m->getWhere('acc_opnd', array('opn_inv_no' => $data['opn_inv_no']));

                foreach ($acc_opnd as $opnd) {
                    $this->all_m->updateData('acc_opnd', 'id', $opnd->id, array('opn_date' => $date));
                }

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['opn_date'] = $date;
                $datacls['cls_cnt'] = $acc_opnh->cls_cnt + 1;

                $this->all_m->updateData($table, 'id', $id, $datacls);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function uncloseOpname() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $periode = $this->checkPeriode();
        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }
        if ($msg['success'] !== false) {

            $count = $this->all_m->countlimit($table, array('id' => $id));

            if ($count > 0) {

                $acc_opnh = $this->all_m->getId($table, 'id', $id);
                $update['cls_date'] = $date;
                $update['cls_by'] = '';
                $update['opn_date'] = $date;


                $acc_opnd = $this->all_m->getWhere('acc_opnd', array('opn_inv_no' => $data['opn_inv_no']));

                foreach ($acc_opnd as $opnd) {
                    $this->all_m->updateData('acc_opnd', 'id', $opnd->id, array('opn_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $update);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        }
        $this->json($msg);
    }

    function save_rsld() {
        $date = date('Y-m-d');
        $rsl_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);



        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        $rslh = $this->all_m->getId('acc_rslh', 'rsl_inv_no', $rsl_inv_no);

        $data_maccs['qty'] = $maccs->qty + $data['qty'];
        $data_mst['qty'] = $acc_mst->qty + $data['qty'];


        $tot_price = intval($rslh->tot_price) + intval($data['price_total']);
        $dpp = $tot_price - intval($rslh->inv_disc);
        $ppn = ($dpp / 100) * 10;
        $inv_at = $dpp + $ppn;

        $data_rslh = array(
            'tot_item' => $rslh->tot_item + 1,
            'tot_price' => $tot_price,
            'inv_bt' => $dpp,
            'inv_vat' => $ppn,
            'inv_at' => $inv_at,
            'inv_total' => $inv_at + intval($rslh->inv_stamp)
        );

        $data['rsl_inv_no'] = $rsl_inv_no;
        $data['add_by'] = $user;
        $data['add_date'] = $date;
        $data['pick_date'] = $date;
        $data['location'] = $maccs->location;

        $check = $this->all_m->countlimit($table, array('rsl_inv_no' => $rsl_inv_no, 'part_code' => $data['part_code'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));

        if ($id !== '') {
            if ($check > 1) {
                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
            } else {

                $this->all_m->updateData($table, 'id', $id, $data);

                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            }
        } else {
            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
            } else {
                unset($data['price_total']);
                unset($data['disc_unit']);
                unset($data['price_ad_unit']);
                $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                $this->all_m->updateData('acc_rslh', 'id', $rslh->id, $data_rslh);

                $this->all_m->insertData($table, $data);

                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function delete_rsld() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $id_maccs = $this->input->post('id3');

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['price_total'] = $data['price_bd'] * $data['qty'];

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkrslh = $this->all_m->countlimit('acc_rslh', array('rsl_inv_no' => $data['rsl_inv_no']));
        $checkmaccs = $this->all_m->countlimit('maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['location'],
            'wrhs_code' => $data['wrhs_code']
                )
        );
        $checkacc_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($checkacc_mst > 0) {
            $stat = true;
        }
        if ($check > 0) {
            $stat = true;
        }
        if ($checkrslh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $rslh = $this->all_m->getId('acc_rslh', 'rsl_inv_no', $data['rsl_inv_no']);

            $maccs = $this->all_m->getOne('maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['location'],
                'wrhs_code' => $data['wrhs_code']
                    )
            );
            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_mst['qty'] = $acc_mst->qty - $data['qty'];

            $data_opnh['tot_qty'] = $opnh->tot_qty - $data['qty'];
            $data_opnh['tot_item'] = $opnh->tot_item - 1;
            $data_opnh['tot_price'] = $opnh->tot_price - $data['price_total'];


            $tot_price = intval($rslh->tot_price) - intval($data['price_total']);
            $dpp = $tot_price - intval($rslh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_rslh = array(
                'tot_item' => $rslh->tot_item - 1,
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($rslh->inv_stamp)
            );

            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
            $this->all_m->updateData('acc_rslh', 'id', $rslh->id, $data_rslh);
            $this->all_m->deleteData($table, 'id', $id);

            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function closeReturnPenj() {
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
            $check_rsld = $this->all_m->countlimit('acc_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

            if ($check_rsld < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $acc_rslh = $this->all_m->getId($table, 'id', $id);

                $acc_rsld = $this->all_m->getWhere('acc_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

                foreach ($acc_rsld as $rsld) {
                    $this->all_m->updateData('acc_rsld', 'id', $rsld->id, array('rsl_date' => $date));
                }

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['rsl_date'] = $date;
                $datacls['cls_cnt'] = $acc_rslh->cls_cnt + 1;



                $sql_arh = "SHOW COLUMNS FROM acc_arh";
                $acc_arh = $this->all_m->query_all($sql_arh);

                foreach ($acc_arh as $arh) {
                    $field_acc_arh[$arh->Field] = '';
                }
                unset($field_acc_arh['id']);

                $rslh = (array) $acc_rslh;

                foreach ($rslh as $k => $v) {

                    if (array_key_exists($k, $field_acc_arh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_acc_rslh = array_combine($key, $val);
                $newdata_acc_rslh['cls_date'] = $date;
                $newdata_acc_rslh['sal_inv_no'] = $acc_rslh->rsl_inv_no;
                $newdata_acc_rslh['sal_date'] = $date;

                $newdata_acc_rslh['inv_bt'] = $acc_rslh->inv_bt - ($acc_rslh->inv_bt * 2);
                $newdata_acc_rslh['inv_vat'] = $acc_rslh->inv_vat - ($acc_rslh->inv_vat * 2);
                $newdata_acc_rslh['inv_stamp'] = $acc_rslh->inv_stamp - ($acc_rslh->inv_stamp * 2);
                $newdata_acc_rslh['inv_total'] = $acc_rslh->inv_total - ($acc_rslh->inv_total * 2);
                $newdata_acc_rslh['pd_begin'] = $acc_rslh->inv_total - ($acc_rslh->inv_total * 2);
                $newdata_acc_rslh['pd_paid'] = 0;
                $newdata_acc_rslh['pd_disc'] = 0;
                $newdata_acc_rslh['pd_end'] = $acc_rslh->inv_total - ($acc_rslh->inv_total * 2);
                $newdata_acc_rslh['sinv_code'] = 'ARC';

                $check = $this->all_m->insertData('acc_arh', $newdata_acc_rslh);
                $this->all_m->updateData($table, 'id', $id, $datacls);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function uncloseReturnPenj() {
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
            $acc_rslh = $this->all_m->getId($table, 'id', $id);

            if ($acc_rslh) {
                $data['cls_date'] = $date;
                $data['cls_by'] = '';
                $data['rsl_date'] = $date;


                $acc_rsld = $this->all_m->getWhere('acc_rsld', array('rsl_inv_no' => $data['rsl_inv_no']));

                foreach ($acc_rsld as $rsld) {
                    $this->all_m->updateData('acc_rsld', 'id', $rsld->id, array('rsl_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $data);
                $this->all_m->deleteData('acc_arh', 'sal_inv_no', $acc_rslh->rsl_inv_no);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        }
        $this->json($msg);
    }

    function save_rprd() {
        $date = date('Y-m-d');
        $rpr_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);

        $stat = true;

        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        $rprh = $this->all_m->getId('acc_rprh', 'rpr_inv_no', $rpr_inv_no);

        if (intval($maccs->qty) < intval($data['qty'])) {
            $stat = false;

            $msg = array('success' => false, 'message' => 'QTY exceeds stock! Stock remaining: ' . intval($maccs->qty));
        }


        if ($stat !== false) {
            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_mst['qty'] = $acc_mst->qty - $data['qty'];


            $tot_price = intval($rprh->tot_price) + intval($data['price_total']);
            $dpp = $tot_price - intval($rprh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_rprh = array(
                'tot_item' => $rprh->tot_item + 1,
                'tot_qty' => $rprh->tot_qty + $data['qty'],
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($rprh->inv_stamp)
            );

            $data['rpr_inv_no'] = $rpr_inv_no;
            $data['add_by'] = $user;
            $data['add_date'] = $date;
            $data['pick_date'] = $date;
            $data['location'] = $maccs->location;

            $check = $this->all_m->countlimit($table, array('rpr_inv_no' => $rpr_inv_no, 'part_code' => $data['part_code'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));

            if ($id !== '') {
                if ($check > 1) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {

                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                }
            } else {
                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {
                    unset($data['price_total']);
                    unset($data['disc_unit']);
                    unset($data['price_ad_unit']);
                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('acc_rprh', 'id', $rprh->id, $data_rprh);

                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        } else {
            $msg = $msg;
        }


        $this->json($msg);
    }

    function delete_rprd() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $id_maccs = $this->input->post('id3');

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['price_total'] = $data['price_bd'] * $data['qty'];

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkrprh = $this->all_m->countlimit('acc_rprh', array('rpr_inv_no' => $data['rpr_inv_no']));

        $checkmaccs = $this->all_m->countlimit('maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['location'],
            'wrhs_code' => $data['wrhs_code']
        ));

        $check_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

        if ($check_mst > 0) {
            $stat = true;
        }

        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($check > 0) {
            $stat = true;
        }
        if ($checkrprh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_rprh = $this->all_m->getId('acc_rprh', 'rpr_inv_no', $data['rpr_inv_no']);

            //$maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
            $maccs = $this->all_m->getOne('maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['location'],
                'wrhs_code' => $data['wrhs_code']
                    )
            );
            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

            $data_maccs['qty'] = $maccs->qty + $data['qty'];
            $data_mst['qty'] = $acc_mst->qty + $data['qty'];



            $tot_price = intval($acc_rprh->tot_price) - intval($data['price_total']);
            $dpp = $tot_price - intval($acc_rprh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;

            $data_acc_rprh = array(
                'tot_item' => $acc_rprh->tot_item - 1,
                'tot_qty' => $acc_rprh->tot_qty - $data['qty'],
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_at + intval($acc_rprh->inv_stamp)
            );

            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
            $this->all_m->updateData('acc_rprh', 'id', $acc_rprh->id, $data_acc_rprh);
            $this->all_m->deleteData($table, 'id', $id);

            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function save_sld() {
        $date = date('Y-m-d');
        $sal_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);

        $stat = true;

        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        $slh = $this->all_m->getId('acc_slh', 'sal_inv_no', $sal_inv_no);

        if (intval($maccs->qty) < intval($data['qty'])) {
            $stat = false;

            $msg = array('success' => false, 'message' => 'QTY exceeds stock! Stock remaining: ' . intval($maccs->qty));
        }


        if ($stat !== false) {
            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_mst['qty'] = $acc_mst->qty - $data['qty'];

            $data_maccs['qty_pick'] = $maccs->qty_pick + $data['qty'];
            $data_mst['qty_pick'] = $acc_mst->qty_pick + $data['qty'];


            $tot_price = intval($slh->tot_price) + intval($data['price_ad']);
            $dpp = $tot_price - intval($slh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;
            $inv_total = $inv_at + intval($slh->inv_stamp);

            $data_slh = array(
                'tot_item' => $slh->tot_item + 1,
                'tot_qty' => $slh->tot_qty + $data['qty'],
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_total
            );

            $data['sal_inv_no'] = $sal_inv_no;
            $data['add_by'] = $user;
            $data['add_date'] = $date;
            $data['pick_date'] = $date;
            $data['location'] = $maccs->location;

            /* Vehicle Sales */
            $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $sal_inv_no);
            $part_at = $veh_slh->part_at + $inv_total;
            $s_inv_total = $veh_slh->veh_total + $veh_slh->srv_at + $part_at + $veh_slh->inv_stamp;

            $datavehslh = array(
                'part_at' => $part_at,
                'inv_total' => $s_inv_total
            );
            /* Vehicle Sales */
            $check = $this->all_m->countlimit($table, array('sal_inv_no' => $sal_inv_no, 'part_code' => $data['part_code'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));

            if ($id !== '') {
                if ($check > 1) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {

                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                }
            } else {
                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {
                    unset($data['price_total']);
                    unset($data['disc_unit']);
                    unset($data['price_ad_unit']);
                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('acc_slh', 'id', $slh->id, $data_slh);
                    $this->all_m->updateData('veh_slh', 'id', $veh_slh->id, $datavehslh);

                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        } else {
            $msg = $msg;
        }


        $this->json($msg);
    }

    function delete_sld() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $id_maccs = $this->input->post('id3');

        $data = (array) $this->all_m->getId($table, 'id', $id);
        $data['price_total'] = $data['price_bd'] * $data['qty'];

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkslh = $this->all_m->countlimit('acc_slh', array('sal_inv_no' => $data['sal_inv_no']));
        $checkmaccs = $this->all_m->countlimit('maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['location'],
            'wrhs_code' => $data['wrhs_code']
                )
        );

        $checkacc_mst = $this->all_m->countlimit('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($checkacc_mst > 0) {
            $stat = true;
        }

        if ($check > 0) {
            $stat = true;
        }
        if ($checkslh > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $acc_slh = $this->all_m->getId('acc_slh', 'sal_inv_no', $data['sal_inv_no']);


            $maccs = $this->all_m->getOne('maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['location'],
                'wrhs_code' => $data['wrhs_code']
                    )
            );

            $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));

            $data_maccs['qty'] = $maccs->qty + $data['qty'];
            $data_mst['qty'] = $acc_mst->qty + $data['qty'];

            $data_maccs['qty_pick'] = $maccs->qty_pick - $data['qty'];
            $data_mst['qty_pick'] = $acc_mst->qty_pick - $data['qty'];

            $tot_price = intval($acc_slh->tot_price) - intval($data['price_ad']);
            $dpp = $tot_price - intval($acc_slh->inv_disc);
            $ppn = ($dpp / 100) * 10;
            $inv_at = $dpp + $ppn;
            $inv_total = $inv_at + intval($acc_slh->inv_stamp);

            $data_acc_slh = array(
                'tot_item' => $acc_slh->tot_item - 1,
                'tot_qty' => $acc_slh->tot_qty - $data['qty'],
                'tot_price' => $tot_price,
                'inv_bt' => $dpp,
                'inv_vat' => $ppn,
                'inv_at' => $inv_at,
                'inv_total' => $inv_total
            );

            /* Vehicle Sales */

            $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);
            $part_at = $inv_total;
            $s_inv_total = $veh_slh->veh_total + $veh_slh->srv_at + $part_at + $veh_slh->inv_stamp;

            $datavehslh = array(
                'part_at' => $part_at,
                'inv_total' => $s_inv_total
            );
            //print_r($tot_price);exit;
            /* Vehicle Sales */

            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
            $this->all_m->updateData('acc_slh', 'id', $acc_slh->id, $data_acc_slh);
            $this->all_m->updateData('veh_slh', 'id', $veh_slh->id, $datavehslh);
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

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotClose();
        }
        if ($msg['success'] !== false) {
            $check_sld = $this->all_m->countlimit('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

            if ($check_sld < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $acc_slh = $this->all_m->getId($table, 'id', $id);

                $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

                foreach ($acc_sld as $sld) {
                    $maccs = $this->all_m->getOne('maccs', array(
                        'part_code' => $sld->part_code,
                        'part_name' => $sld->part_name,
                        'location' => $sld->location,
                        'wrhs_code' => $sld->wrhs_code
                            )
                    );
                    $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $sld->part_code, 'part_name' => $sld->part_name));

                    $data_maccs['qty_pick'] = $maccs->qty_pick - $sld->qty;
                    $data_mst['qty_pick'] = $acc_mst->qty_pick - $sld->qty;

                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('acc_sld', 'id', $sld->id, array('sal_date' => $date));
                }

                $data_slh['cls_date'] = $date;
                $data_slh['cls_by'] = $user;
                $data_slh['sal_date'] = $date;
                $data_slh['cls_cnt'] = $acc_slh->cls_cnt + 1;

                $this->all_m->updateData($table, 'id', $id, $data_slh);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function unclosePenjualan() {
        /* belom */
        $user = $this->uri->segment(4);

        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);


        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }
        $check_vehslh = $this->all_m->countlimit('veh_slh', array('sal_inv_no' => $data['sal_inv_no']));

        if ($check_vehslh > 0) {
            $veh_slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $data['sal_inv_no']);

            if ($veh_slh->cls_date !== '0000-00-00') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Sorry, Vehicle Sales already closed');
            }
        }

        $check_sld = $this->all_m->countlimit('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));
        if ($check_sld < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
        }
        
        $check_rslh = $this->all_m->countlimit('acc_rslh', array('sal_inv_no' => $data['sal_inv_no']));
        
        if ($check_rslh > 0) {
            $veh_rslh = $this->all_m->getId('acc_rslh', 'sal_inv_no', $data['sal_inv_no']);
            $stat = false;
            $msg = array('success' => false, 'message' => 'This Invoice Number has been returned  with Return Invoice No . '.$veh_rslh->rsl_inv_no);
        }
        
        if ($stat !== false) {
            $acc_slh = $this->all_m->getId($table, 'id', $id);

            $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

            foreach ($acc_sld as $sld) {
                $maccs = $this->all_m->getOne('maccs', array(
                    'part_code' => $sld->part_code,
                    'part_name' => $sld->part_name,
                    'location' => $sld->location,
                    'wrhs_code' => $sld->wrhs_code
                        )
                );
                $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $sld->part_code, 'part_name' => $sld->part_name));

                $data_maccs['qty_pick'] = $maccs->qty_pick + $sld->qty;
                $data_mst['qty_pick'] = $acc_mst->qty_pick + $sld->qty;

                $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                $this->all_m->updateData('acc_sld', 'id', $sld->id, array('sal_date' => $date));
            }

            $data_slh['cls_date'] = $date;
            $data_slh['cls_by'] = '';
            $data_slh['sal_date'] = $date;

            $this->all_m->updateData($table, 'id', $id, $data_slh);

            $msg = array('success' => true, 'message' => 'success');
        }


        $this->json($msg);
    }

    function closePemakaian() {
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
            $check_sld = $this->all_m->countlimit('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

            if ($check_sld < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $acc_slh = $this->all_m->getId($table, 'id', $id);

                $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

                foreach ($acc_sld as $sld) {
                    $maccs = $this->all_m->getOne('maccs', array(
                        'part_code' => $sld->part_code,
                        'part_name' => $sld->part_name,
                        'location' => $sld->location,
                        'wrhs_code' => $sld->wrhs_code
                            )
                    );
                    $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $sld->part_code, 'part_name' => $sld->part_name));

                    $data_maccs['qty_pick'] = $maccs->qty_pick - $sld->qty;
                    $data_mst['qty_pick'] = $acc_mst->qty_pick - $sld->qty;

                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                    $this->all_m->updateData('acc_sld', 'id', $sld->id, array('sal_date' => $date));
                }

                $data_slh['cls_date'] = $date;
                $data_slh['cls_by'] = $user;
                $data_slh['sal_date'] = $date;
                $data_slh['cls_cnt'] = $acc_slh->cls_cnt + 1;


                $sql_arh = "SHOW COLUMNS FROM acc_arh";
                $acc_arh = $this->all_m->query_all($sql_arh);

                foreach ($acc_arh as $arh) {
                    $field_acc_arh[$arh->Field] = '';
                }
                unset($field_acc_arh['id']);

                $slh = (array) $acc_slh;

                foreach ($slh as $k => $v) {

                    if (array_key_exists($k, $field_acc_arh)) {
                        $key[] = $k;
                        $val[] = $v;
                    }
                }

                $newdata_acc_slh = array_combine($key, $val);
                $newdata_acc_slh['cls_date'] = $date;
                $newdata_acc_slh['sal_inv_no'] = $acc_slh->sal_inv_no;
                $newdata_acc_slh['sal_date'] = $date;

                $newdata_acc_slh['sinv_code'] = 'ASA';

                $newdata_acc_slh['pd_begin'] = $acc_slh->inv_total;
                $newdata_acc_slh['pd_paid'] = 0;
                $newdata_acc_slh['pd_disc'] = 0;
                $newdata_acc_slh['pd_end'] = $acc_slh->inv_total;


                $check = $this->all_m->insertData('acc_arh', $newdata_acc_slh);
                $this->all_m->updateData($table, 'id', $id, $data_slh);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function unclosePemakaian() {
        /* belom */
        $user = $this->uri->segment(4);

        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);


        $stat = true;

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $stat = false;
            $msg = $this->msgNotUnClose();
        }

        $check_ard = $this->all_m->countlimit('acc_ard', array('sal_inv_no' => $data['sal_inv_no']));
        if ($check_ard > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has payment');
        }

        $check_sld = $this->all_m->countlimit('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));
        if ($check_sld < 1) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
        }

        if ($stat !== false) {
            $acc_slh = $this->all_m->getId($table, 'id', $id);

            $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $data['sal_inv_no']));

            foreach ($acc_sld as $sld) {
                $maccs = $this->all_m->getOne('maccs', array(
                    'part_code' => $sld->part_code,
                    'part_name' => $sld->part_name,
                    'location' => $sld->location,
                    'wrhs_code' => $sld->wrhs_code
                        )
                );
                $acc_mst = $this->all_m->getOne('acc_mst', array('part_code' => $sld->part_code, 'part_name' => $sld->part_name));

                $data_maccs['qty_pick'] = $maccs->qty_pick + $sld->qty;
                $data_mst['qty_pick'] = $acc_mst->qty_pick + $sld->qty;

                $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                $this->all_m->updateData('acc_mst', 'id', $acc_mst->id, $data_mst);
                $this->all_m->updateData('acc_sld', 'id', $sld->id, array('sal_date' => $date));
            }

            $data_slh['cls_date'] = $date;
            $data_slh['cls_by'] = '';
            $data_slh['sal_date'] = $date;

            $this->all_m->deleteData('acc_arh', 'sal_inv_no', $acc_slh->sal_inv_no);
            $this->all_m->updateData($table, 'id', $id, $data_slh);

            $msg = array('success' => true, 'message' => 'success');
        }


        $this->json($msg);
    }

    function save_movd() {
        $date = date('Y-m-d');
        $mov_inv_no = $this->uri->segment(4);
        $user = $this->uri->segment(5);
        $data = $this->input->post();
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $id_maccs = $this->input->post('id3');

        unset($data['table2']);
        unset($data['id2']);
        unset($data['id3']);

        $stat = true;

        $maccs = $this->all_m->getId('maccs', 'id', $id_maccs);
        $maccs2 = $this->all_m->getOne(
                'maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['loc_to'],
            'wrhs_code' => $data['wrhs_to']
                )
        );
        $movh = $this->all_m->getId('acc_movh', 'mov_inv_no', $mov_inv_no);


        if ($data['loc_to'] == '') {
            $stat = false;

            $msg = array('success' => false, 'message' => 'To Location not empty!');
        }
        if ($data['part_code'] == '') {
            $stat = false;

            $msg = array('success' => false, 'message' => 'Item Code not empty!');
        }

        if (intval($data['qty']) > intval($maccs->qty)) {
            $stat = false;

            $msg = array('success' => false, 'message' => 'QTY exceeds stock! Stock remaining: ' . intval($maccs->qty));
        }


        if ($stat !== false) {
            $data_maccs['qty'] = $maccs->qty - $data['qty'];
            $data_maccs2['qty'] = $maccs2->qty + $data['qty'];


            $data_movh = array(
                'tot_item' => $movh->tot_item + 1,
                'tot_qty' => $movh->tot_qty + $data['qty']
            );

            $data['mov_inv_no'] = $mov_inv_no;
            $data['add_by'] = $user;
            $data['add_date'] = $date;
            $data['pick_date'] = $date;

            $check = $this->all_m->countlimit($table, array('mov_inv_no' => $mov_inv_no,
                'part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'wrhs_from' => $data['wrhs_from'],
                'loc_from' => $data['loc_from'],
                'wrhs_to' => $data['wrhs_to'],
                'loc_to' => $data['loc_to']
                    )
            );

            if ($id !== '') {
                if ($check > 1) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {

                    $this->all_m->updateData($table, 'id', $id, $data);

                    $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                }
            } else {
                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because item(s) existed in this invoice');
                } else {

                    $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
                    $this->all_m->updateData('maccs', 'id', $maccs2->id, $data_maccs2);
                    $this->all_m->updateData('acc_movh', 'id', $movh->id, $data_movh);

                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        } else {
            $msg = $msg;
        }


        $this->json($msg);
    }

    function delete_movd() {
        $mov_inv_no = $this->input->post('mov_inv_no');
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_movd = $this->all_m->getId($table, 'id', $id);
        $data = (array) $acc_movd;

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));
        $checkmovh = $this->all_m->countlimit('acc_movh', array('mov_inv_no' => $mov_inv_no));
        $checkmaccs = $this->all_m->countlimit(
                'maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['loc_from'],
            'wrhs_code' => $data['wrhs_from']
                )
        );

        $checkmaccs2 = $this->all_m->countlimit(
                'maccs', array('part_code' => $data['part_code'],
            'part_name' => $data['part_name'],
            'location' => $data['loc_to'],
            'wrhs_code' => $data['wrhs_to']
                )
        );

        if ($check > 0) {
            $stat = true;
        }
        if ($checkmovh > 0) {
            $stat = true;
        }
        if ($checkmaccs > 0) {
            $stat = true;
        }
        if ($checkmaccs2 > 0) {
            $stat = true;
        }


        if ($stat !== false) {

            $maccs = $this->all_m->getOne(
                    'maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['loc_from'],
                'wrhs_code' => $data['wrhs_from']
                    )
            );
            $maccs2 = $this->all_m->getOne(
                    'maccs', array('part_code' => $data['part_code'],
                'part_name' => $data['part_name'],
                'location' => $data['loc_to'],
                'wrhs_code' => $data['wrhs_to']
                    )
            );

            $movh = $this->all_m->getId('acc_movh', 'mov_inv_no', $mov_inv_no);


            $data_maccs['qty'] = $maccs->qty + $data['qty'];
            $data_maccs2['qty'] = $maccs2->qty - $data['qty'];


            $data_movh = array(
                'tot_item' => $movh->tot_item - 1,
                'tot_qty' => $movh->tot_qty - $data['qty']
            );



            $this->all_m->updateData('maccs', 'id', $maccs->id, $data_maccs);
            $this->all_m->updateData('maccs', 'id', $maccs2->id, $data_maccs2);
            $this->all_m->updateData('acc_movh', 'id', $movh->id, $data_movh);

            $this->all_m->deleteData($table, 'id', $id);

            $msg = array('success' => true, 'message' => 'Deleted');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }


        $this->json($msg);
    }

    function closePemindahan() {
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
            $check_movd = $this->all_m->countlimit('acc_movd', array('mov_inv_no' => $data['mov_inv_no']));

            if ($check_movd < 1) {
                $msg = array('success' => false, 'message' => 'Invoice cannot be closed because it has no transaction');
            } else {
                $acc_movh = $this->all_m->getId($table, 'id', $id);

                $acc_movd = $this->all_m->getWhere('acc_movd', array('mov_inv_no' => $data['mov_inv_no']));

                foreach ($acc_movd as $movd) {
                    $this->all_m->updateData('acc_movd', 'id', $movd->id, array('mov_date' => $date));
                }

                $datacls['cls_date'] = $date;
                $datacls['cls_by'] = $user;
                $datacls['mov_date'] = $date;
                $datacls['cls_cnt'] = $acc_movh->cls_cnt + 1;

                $this->all_m->updateData($table, 'id', $id, $datacls);

                $msg = array('success' => true, 'message' => 'success');
            }
        }
        $this->json($msg);
    }

    function unclosePemindahan() {
        $date = '0000-00-00';

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        $acc_movh = $this->all_m->getId($table, 'id', $id);


        unset($data['table']);
        unset($data['id']);
        unset($data['inv_type']);

        $periode = $this->checkPeriode();

        if ($periode == 'false') {
            $msg = $this->msgNotUnClose();
        }

        if ($msg['success'] !== false) {
            if ($acc_movh) {
                $update['cls_date'] = $date;
                $update['cls_by'] = '';
                $update['mov_date'] = $date;

                $acc_movd = $this->all_m->getWhere('acc_movd', array('mov_inv_no' => $data['mov_inv_no']));

                foreach ($acc_movd as $movd) {
                    $this->all_m->updateData('acc_movd', 'id', $movd->id, array('mov_date' => $date));
                }

                $this->all_m->updateData($table, 'id', $id, $update);

                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Unable to unclose invoice');
            }
        }
        $this->json($msg);
    }

    function delete_accesories() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $row = $this->all_m->getId($table, 'id', $id);

        if ($table == 'acc_prh') {
            $table2 = 'acc_prd';
            $fieldunique = 'pur_inv_no';
            $inv_type = 'APR';
        }

        if ($table == 'acc_opnh') {
            $table2 = 'acc_opnd';
            $fieldunique = 'opn_inv_no';
            $inv_type = 'AOP';
        }

        if ($table == 'acc_rslh') {
            $table2 = 'acc_rsld';
            $fieldunique = 'rsl_inv_no';
            $inv_type = 'ARC';
        }

        if ($table == 'acc_rprh') {
            $table2 = 'acc_rprd';
            $fieldunique = 'rpr_inv_no';
            $inv_type = 'ARP';
        }

        if ($table == 'acc_slh') {
            $table2 = 'acc_sld';
            $fieldunique = 'sal_inv_no';
            $inv_type = 'ASA';
        }

        if ($table == 'acc_movh') {
            $table2 = 'acc_movd';
            $fieldunique = 'mov_inv_no';
            $inv_type = 'AMV';
        }

        $count = $this->all_m->countlimit($table2, array($fieldunique => $row->$fieldunique));

        if ($count > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, this invoice cannot be deleted because it has detail(s). Please delete them first');
        } else {
            $this->all_m->deleteData($table, 'id', $id);

            $number = $this->all_m->getId('inv_seq', 'inv_type', $inv_type);
            $num = $number->inv_no - 1;
            $this->all_m->updateData('inv_seq', 'inv_type', $inv_type, array('inv_no' => $num));

            $count = $this->all_m->countlimit($table, array('id' => $id));

            if ($count > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete Success');
            }
        }

        $this->json($msg);
    }

    function check_prh() {
        $pur_inv_no = $this->input->post('pur_inv_no');
        $table = $this->input->post('table');

        $data = $this->all_m->getId($table, 'pur_inv_no', $pur_inv_no);
        $stat = true;


        if ($data->cls_date !== '0000-00-00') {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, Accessories Receiving has been closed. Please unclose it first');
        }

        if ($stat !== false) {
            $msg = array('success' => true);
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_diskon() {
        $data = $this->input->post();
        $sal_inv_no = $this->uri->segment(4);
        $slh = $this->all_m->getId('acc_slh', 'sal_inv_no', $sal_inv_no);

        if ($data['checkbox']) {
            if ($data['checkbox'] == '1') {
                $check = $this->all_m->check('acc_sld', array('sal_inv_no' => $sal_inv_no));
                if ($check > 0) {
                    $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $sal_inv_no));

                    foreach ($acc_sld as $datasld) {
                        $price_tot = intval($datasld->price_bd) * intval($datasld->qty);
                        $disc_tot = ($price_tot / 100) * $data['disc2'];

                        $total = $price_tot - $disc_tot;

                        $data_sld['disc_val'] = $disc_tot;
                        $data_sld['price_ad'] = $total;
                        $data_sld['disc_pct'] = $data['disc2'];

                        $tot_price = (intval($slh->tot_price) - intval($datasld->price_ad)) + $total;
                        $dpp = $tot_price - intval($slh->inv_disc);
                        $ppn = ($dpp / 100) * 10;
                        $inv_at = $dpp + $ppn;

                        $data_slh = array(
                            'tot_price' => $tot_price,
                            'inv_bt' => $dpp,
                            'inv_vat' => $ppn,
                            'inv_at' => $inv_at,
                            'inv_total' => $inv_at + intval($slh->inv_stamp)
                        );

                        $this->all_m->updateData('acc_slh', 'id', $slh->id, $data_slh);
                        $this->all_m->updateData('acc_sld', 'id', $datasld->id, $data_sld);
                    }
                    $msg = array('success' => true, 'message' => $check . ' Discount has been changed successfully');
                } else {
                    $msg = array('success' => false, 'message' => 'No discount has been changed');
                }
            } else {
                $check = $this->all_m->check('acc_sld', array('sal_inv_no' => $sal_inv_no, 'part_code' => $data['part_code']));
                if ($check > 0) {
                    $datasld = $this->all_m->getOne('acc_sld', array('sal_inv_no' => $sal_inv_no, 'part_code' => $data['part_code']));

                    $price_tot = intval($datasld->price_bd) * intval($datasld->qty);
                    $disc_tot = ($price_tot / 100) * $data['disc2'];

                    $total = $price_tot - $disc_tot;

                    $data_sld['disc_val'] = $disc_tot;
                    $data_sld['price_ad'] = $total;
                    $data_sld['disc_pct'] = $data['disc2'];

                    $tot_price = (intval($slh->tot_price) - intval($datasld->price_ad)) + $total;
                    $dpp = $tot_price - intval($slh->inv_disc);
                    $ppn = ($dpp / 100) * 10;
                    $inv_at = $dpp + $ppn;

                    $data_slh = array(
                        'tot_price' => $tot_price,
                        'inv_bt' => $dpp,
                        'inv_vat' => $ppn,
                        'inv_at' => $inv_at,
                        'inv_total' => $inv_at + intval($slh->inv_stamp)
                    );

                    $this->all_m->updateData('acc_slh', 'id', $slh->id, $data_slh);
                    $this->all_m->updateData('acc_sld', 'id', $datasld->id, $data_sld);
                    $msg = array('success' => true, 'message' => 'Discount has been successfully changed for selected item code(s)');
                } else {
                    $msg = array('success' => false, 'message' => 'No discount has been changed');
                }
            }
        } else {
            $msg = array('success' => false, 'message' => 'No discount has been changed');
        }
        $this->json($msg);
        //
    }

    function closeReturnPemb() {//desktop ga bisa close, ga ada contaoh, dan ga dipake
        $msg = array('success' => false, 'message' => 'Close Return Accessories Pembelian Didesktop Error(Close Pembelian belum selesai');
        $this->json($msg);
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

            case 'acc_slh':

                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'FakturPenjualanAccesoriesCounter_' . $read['number'],
                    'title' => 'Faktur Penjualan Accesories Counter_ ' . $read['number']
                );
                $margin = "P";
                $c_array['prn_by'] = $data['user'];
                break;

            case 'acc_poh':

                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'OrderPembelianAccesories_' . $read['number'],
                    'title' => 'Order Pembelian Accesories__ ' . $read['number']
                );
                $margin = "P";
                $c_array['prn_by'] = $data['user'];
                break;

            case 'acc_prh':

                $read = $this->readHtml($data);

                if ($data['act'] == 'penerimaan') {
                    $output = array(
                        'html' => $read['html'],
                        'filename' => 'PenerimaanBarang_' . $read['number'],
                        'title' => 'Penerimaan Barang_' . $read['number']
                    );
                    $c_array['prn_by'] = $data['user'];
                    $c_array['prn_by'] = $data['user'];
                }
                if ($data['act'] == 'pembelian') {
                    $output = array(
                        'html' => $read['html'],
                        'filename' => 'PembelianBarang_' . $read['number'],
                        'title' => 'Pembelian Barang_' . $read['number']
                    );

                    $prn_cnt = 'prn2_cnt';
                    $c_array['prn2_by'] = $data['user'];
                }
                $margin = "P";
                break;

            case 'acc_opnh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'FakturOpname_' . $read['number'],
                    'title' => 'Faktur Opname_' . $read['number']
                );
                $margin = "P";
                break;

            case 'acc_rslh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'ReturPenjualan_' . $read['number'],
                    'title' => 'Retur Penjualan_' . $read['number']
                );
                $margin = "P";
                break;

            case 'acc_movh':
                $read = $this->readHtml($data);

                $output = array(
                    'html' => $read['html'],
                    'filename' => 'PemindahanBarang' . $read['number'],
                    'title' => 'Pemindahan Barang_' . $read['number']
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
            case 'acc_slh':
                $sal_date = $this->dateView($read->sal_date);
                $quote_date = $this->dateView($read->quote_date);
                $due_date = $this->dateView($read->due_date);

                if ($inv_type == 'ASC') {


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
                    $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Faktur Penjualan/Sales Invoice</b></td></tr>';
                    $html .= '<tr>';
                    $html .= '<td>';
                    $html .= '<table class="tables">';
                    $html .='<tr><td>No. Faktur<br />Inv Number</td><td class="td-ro">:</td><td>' . $read->$inv_code . '</td></tr>';
                    $html .='<tr><td>Tgl. Faktur<br />Inv Date</td><td class="td-ro">:</td><td>' . $sal_date . '</td></tr>';
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
                    $html .= '<tr><td><b>Pelanggan / Customer:</b></td></tr>';
                    $html .= '<tr><td>' . $read->cust_name . '<br />' . $read->cust_addr . '</td></tr>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '<tr><td></td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';

                    //$html .= '<table class="tables">';
                    //$html .='<tr><td>';
                    $html .= '<table class="tables">';
                    $html .='<tr>'
                            . '<td colspan="8">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2"><table><tr><td>No. Quot.<br />Quot . Nbr</td><td class="td-ro">:</td><td  width="70"></td></tr></table></td><td colspan="2"><table><tr><td>Tgl. Quot.<br />Quot . Date</td><td class="td-ro">:</td><td></td></tr></table></td><td colspan="2"><table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="50">' . $read->due_day . ' hari (days)</td></tr></table></td><td colspan="2"><table><tr><td width="70">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table></td></tr>';
                    $html .= '<tr><td rowspan="2"  width="5%">No.</td><td rowspan="2" width="25%">Uraian<br />Description/Specification</td><td rowspan="2" width="10%">Satuan<br />U/M</td><td rowspan="2" width="10%">Kuantitas<br />Quantity</td><td rowspan="2">Harga Satuan<br />Unit Price</td><td colspan="2">Diskon<br />Discount </td><td rowspan="2">Jumlah/Amount</td></tr>';
                    $html .='<tr><td>%</td><td></td></tr>';

                    $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $read->sal_inv_no));
                    $no = 1;
                    foreach ($acc_sld as $sld):
                        $html .='<tr>'
                                . '<td  width="5%">' . $no . '</td>'
                                . '<td  width="25%">' . $sld->part_name . ' (' . $sld->part_code . ')</td>'
                                . '<td width="10%">' . $sld->unit . '</td>'
                                . '<td width="10%">' . number_format($sld->qty) . '</td>'
                                . '<td align="right">' . number_format($sld->price_bd) . '</td>'
                                . '<td align="right">' . $sld->disc_pct . '</td>'
                                . '<td align="right">' . number_format($sld->disc_val) . '</td>'
                                . '<td align="right">' . number_format($sld->price_ad) . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;
                    $html .='</table>';
                    $html .='</td>';
                    $html .= '</tr>';
                    $html .='<tr>'
                            . '<td colspan="8" style="padding:0px !important">';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td colspan="6" style="border:none !important;"></td><td align="right"><b>Sub Total</b></td><td align="right" border="1"><b>' . number_format($read->tot_price) . '</b></td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Discount</td><td  align="right" border="1">' . number_format($read->inv_disc) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Netto</td><td  align="right" border="1">' . number_format($read->inv_bt) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">PPN/VAT</td><td  align="right" border="1">' . number_format($read->inv_vat) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right"><b>Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_at) . '</b></td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Others</td><td  align="right" border="1">' . number_format($read->inv_stamp) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right"><b>Grand Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_total) . '</b></td></tr>';
                    $html .= '</table>';
                    $html .='</td></tr>';
                    $html .= '</table>';
                    //$html .='</td></tr>';
                    //$html .= '</table>';


                    $html .='<br /><br /><br />';
                    $html .='<table class="tables">';
                    $html .='<tr>';
                    $html .='<td width="55%"><table><tr><td>Accesories : Counter</td></tr></table></td>';
                    $html .='<td>';
                    $html .= '<table class="tables" style="float:right">';
                    $html .='<tr><td></td><td width="50%" align="center"><b>Kasir,<br />Cashier,</b></td><td></td></tr>';
                    $html .='<tr><td align="right"></td><td width="50%"></td><td></td></tr>';
                    $html .='<tr><td align="right"></td><td width="50%"></td><td></td></tr>';
                    $html .='<tr><td align="right"></td><td width="50%"></td><td></td></tr>';
                    $html .='<tr><td align="right">(</td><td width="50%"></td><td>)</td></tr>';
                    $html .='</table>';
                    $html .='</td>';
                    $html .='</tr>';
                    $html .='</table>';
                }

                if ($inv_type == 'ASA') {
                    $code_form = 'ASA';
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
                    $html .='<b style="text-align:center;font-size:16px;padding-top:50px;">SURAT PEMAKAIAN BARANG</b>';
                    $html .= '</td>';
                    $html .= '</tr>';

                    $html .= '<tr>';
                    $html .= '<td width="50%">';
                    $html .= '<table>';
                    $html .= '<tr><td><b>Bagian</b></td><td class="td-ro">:</td><td>' . $read->cust_name . '</td></tr>';
                    $html .= '<tr><td><b>Unit</b></td><td class="td-ro">:</td><td>' . $read->dunit_name . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';

                    $html .= '<td width="50%">';
                    $html .= '<table>';
                    $html .= '<tr><td><b>No. SPB</b></td><td class="td-ro">:</td><td><b>' . $read->sal_inv_no . '</b></td></tr>';
                    $html .= '<tr><td><b>Tgl. SPB</b></td><td class="td-ro">:</td><td><b>' . $sal_date . '</b></td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';

                    $html .= '</tr>';
                    $html .= '</table>';
                    $html .= '</td></tr>';
                    $html .= '</table>';



                    //$html .= '<table class="tables">';
                    //$html .= '<tr><td>';
                    $html .= '<table class="tables">';
                    $html .= '<tr>'
                            . '<td>';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td rowspan="2" width="5%">No.</td><td rowspan="2">Kode Barang<br />Item Code</td><td rowspan="2" width="20%">Uraian<br />Description</td><td rowspan="2" width="7%">Gudang<br />Wrhs</td><td rowspan="2" width="8%">Satuan<br />U/M</td><td rowspan="2" width="10%">Kuantitas<br />Quantity</td><td rowspan="2">Harga Satuan<br />Unit Price</td><td colspan="2">Diskon<br />Discount </td><td rowspan="2">Jumlah/Amount</td></tr>';
                    $html .='<tr><td>%</td><td></td></tr>';

                    $acc_sld = $this->all_m->getWhere('acc_sld', array('sal_inv_no' => $read->sal_inv_no));
                    $no = 1;
                    foreach ($acc_sld as $sld):
                        $html .='<tr>'
                                . '<td  width="5%">' . $no . '</td>'
                                . '<td>' . $sld->part_code . '</td>'
                                . '<td  width="20%">' . $sld->part_name . '</td>'
                                . '<td width="7%">' . $sld->wrhs_code . '</td>'
                                . '<td width="8%">' . $sld->unit . '</td>'
                                . '<td width="10%">' . number_format($sld->qty) . '</td>'
                                . '<td align="right">' . number_format($sld->price_bd) . '</td>'
                                . '<td align="right">' . $sld->disc_pct . '</td>'
                                . '<td align="right">' . number_format($sld->disc_val) . '</td>'
                                . '<td align="right">' . number_format($sld->price_ad) . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;
                    $html .='</table>';
                    $html .='</td>';
                    $html .= '</tr>';
                    $html .='<tr>'
                            . '<td style="padding:0px !important">';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td colspan="8" style="border:none !important;"></td><td align="right"><b>Sub Total</b></td><td align="right" border="1"><b>' . number_format($read->tot_price) . '</b></td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Discount</td><td  align="right" border="1">' . number_format($read->inv_disc) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Netto</td><td  align="right" border="1">' . number_format($read->inv_bt) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">PPN/VAT</td><td  align="right" border="1">' . number_format($read->inv_vat) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right"><b>Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_at) . '</b></td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right">Others</td><td  align="right" border="1">' . number_format($read->inv_stamp) . '</td></tr>';
                    $html .= '<tr><td colspan="8"></td><td align="right"><b>Grand Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_total) . '</b></td></tr>';
                    $html .= '</table>';
                    $html .='</td></tr>';
                    $html .= '</table>';
                    //$html .='</td></tr>';
                    //$html .= '</table>';
                }
                break;

            case 'acc_poh':
                $code_form = 'APO';
                $po_date = $this->dateView($read->po_date);
                $quote_date = $this->dateView($read->quote_date);
                $due_date = $this->dateView($read->due_date);

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
                $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Order Pembelian/Purchase Order</b></td></tr>';
                $html .= '<tr>';
                $html .= '<td>';
                $html .= '<table class="tables">';
                $html .='<tr><td>No. PO<br />PO No.</td><td class="td-ro">:</td><td width="90">' . $read->$inv_code . '</td></tr>';
                $html .='<tr><td>Tgl. PO<br />PO Date</td><td class="td-ro">:</td><td>' . $po_date . '</td></tr>';
                $html .='<tr><td>Jenis PO<br />PO Type</td><td class="td-ro">:</td><td>' . $read->po_type . '</td></tr>';
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
                $html .= '<tr><td>' . $read->saddr . ', ' . $read->sarea . '</td></tr>';
                $html .= '<tr><td>' . $read->scity . '-' . $read->scountry . ' ' . $read->szipcode . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '<td width="50%">';
                $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                $html .= '<tr><td>' . $read->rname . '</td></tr>';
                $html .= '<tr><td>' . $read->raddr . ',' . $read->rarea . '</td></tr>';
                $html .= '<tr><td>' . $read->rcity . '-' . $read->rcountry . ' ' . $read->rzipcode . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</table>';

                //$html .= '<table class="tables">';
                //$html .='<tr><td>';
                $html .= '<table class="tables">';
                $html .='<tr>'
                        . '<td colspan="8">';
                $html .= '<table class="tables" border="1">';
                $html .= '<tr><td colspan="2"><table><tr><td>No. Quot.<br />Quot . Nbr</td><td class="td-ro">:</td><td width="70"> ' . $read->quote_no . '</td></tr></table></td><td colspan="2"><table><tr><td>Tgl. Quot.<br />Quot . Date</td><td class="td-ro">:</td><td>' . $quote_date . '</td></tr></table></td><td colspan="2"><table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="80">' . $read->due_day . ' hari (days)</td></tr></table></td><td colspan="2"><table><tr><td width="80">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table></td></tr>';
                $html .= '<tr><td rowspan="2"  width="5%">No.</td><td rowspan="2" width="25%">Uraian<br />Description/Specification</td><td rowspan="2" width="10%">Satuan<br />U/M</td><td rowspan="2" width="10%">Kuantitas<br />Quantity</td><td rowspan="2">Harga Satuan<br />Unit Price</td><td colspan="2">Diskon<br />Discount </td><td rowspan="2">Jumlah/Amount</td></tr>';
                $html .='<tr><td>%</td><td></td></tr>';

                $acc_pod = $this->all_m->getWhere('acc_pod', array('po_no' => $read->$inv_code));
                $no = 1;
                foreach ($acc_pod as $pod):
                    $html .='<tr>'
                            . '<td  width="5%">' . $no . '</td>'
                            . '<td  width="25%">' . $pod->part_name . ' (' . $pod->part_code . ')</td>'
                            . '<td width="10%">' . $pod->unit . '</td>'
                            . '<td width="10%">' . number_format($pod->qty) . '</td>'
                            . '<td align="right">' . number_format($pod->price_bd) . '</td>'
                            . '<td align="right">' . $pod->disc_pct . '</td>'
                            . '<td align="right">' . number_format($pod->disc_val) . '</td>'
                            . '<td align="right">' . number_format($pod->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;
                $html .='</table>';
                $html .='</td>';
                $html .= '</tr>';
                $html .='<tr>'
                        . '<td colspan="8" style="padding:0px !important">';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="6" style="border:none !important;"></td><td align="right"><b>Sub Total</b></td><td align="right" border="1"><b>' . number_format($read->tot_price) . '</b></td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right">Discount</td><td  align="right" border="1">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right">Netto</td><td  align="right" border="1">' . number_format($read->inv_bt) . '</td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right">PPN/VAT</td><td  align="right" border="1">' . number_format($read->inv_vat) . '</td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right"><b>Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_at) . '</b></td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right">Others</td><td  align="right" border="1">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr><td colspan="6"></td><td align="right"><b>Grand Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_total) . '</b></td></tr>';
                $html .= '</table>';
                $html .='</td></tr>';
                $html .= '</table>';
                //$html .='</td></tr>';
                //$html .= '</table>';


                break;

            case 'acc_prh':

                $pur_date = $this->dateView($read->pur_date);
                $po_date = $this->dateView($read->po_date);
                $due_date = $this->dateView($read->due_date);

                if ($data['act'] == 'penerimaan') {
                    $code_form = 'ARCV';
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
                    $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Penerimaan Barang/Goods Received</b></td></tr>';
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
                    $html .= '<tr><td>' . $read->saddr . ', ' . $read->sarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->scity . '-' . $read->scountry . ' ' . $read->szipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                    $html .= '<tr><td>' . $read->rname . '</td></tr>';
                    $html .= '<tr><td>' . $read->raddr . ',' . $read->rarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->rcity . '-' . $read->rcountry . ' ' . $read->rzipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';

                    //$html .= '<table class="tables">';
                    //$html .='<tr><td>';
                    $html .= '<table class="tables">';
                    $html .='<tr>'
                            . '<td colspan="8">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2"><table><tr><td>No. PO.<br />PO . Nbr</td><td class="td-ro">:</td><td width="70"> ' . $read->po_no . '</td></tr></table></td><td colspan="2"><table><tr><td>Tgl. PO.<br />PO . Date</td><td class="td-ro">:</td><td>' . $po_date . '</td></tr></table></td><td colspan="2"><table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="80">' . $read->due_day . ' hari (days)</td></tr></table></td><td colspan="2"><table><tr><td width="70">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table></td></tr>';
                    $html .= '<tr><td width="5%">No.</td><td>Kode Barang<br />Item Code</td><td width="25%">Uraian<br />Description/Specification</td><td width="10%">Satuan<br />U/M</td><td width="10%">Kuantitas<br />Quantity</td><td>Gudang<br />Warehouse</td><td>Lokasi<br />Location </td><td>Pembeli<br />Purchaser</td></tr>';

                    $acc_prd = $this->all_m->getWhere('acc_prd', array($inv_code => $read->$inv_code));
                    $no = 1;
                    foreach ($acc_prd as $prd):
                        $html .='<tr>'
                                . '<td  width="5%">' . $no . '</td>'
                                . '<td>' . $prd->part_code . '</td>'
                                . '<td  width="25%">' . $prd->part_name . '</td>'
                                . '<td width="10%">' . $prd->unit . '</td>'
                                . '<td align="right">' . number_format($prd->qty) . '</td>'
                                . '<td>' . $prd->wrhs_code . '</td>'
                                . '<td>' . $prd->location . '</td>'
                                . '<td>' . $prd->prep_code . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;
                    $html .='</table>';
                    $html .='</td>';
                    $html .= '</tr>';
                    $html .='<tr>'
                            . '<td colspan="8" style="padding:0px !important">';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td width="5%"></td><td></td><td width="25%"></td><td align="right"  width="10%"><b>Sub Total</b></td><td align="right" border="1"  width="10%"><b>' . number_format($read->tot_qty) . '</b></td><td colspan="3"></td></tr>';
                    $html .= '</table>';
                    $html .='</td></tr>';
                    $html .= '</table>';
                    //$html .='</td></tr>';
                    //$html .= '</table>';
                }

                if ($data['act'] == 'pembelian') {
                    $code_form = 'APR';
                    $html .= '<table class="tables">';
                    $html .= '<tr>';
                    $html .= '<td width="40%">';
                    $html .= '<table class="tables">';
                    $html .='<tr><td style="font-size:14px;"><b>' . $company->comp_name . '</b></td></tr>';
                    $html .='<tr><td>' . $company->comp_add1 . '</td></tr>';
                    $html .='<tr><td>' . $company->comp_add2 . '</td></tr>';
                    $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td  width="60%">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Pembelian Barang/Purchase Invoice</b></td></tr>';
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
                    $html .= '<tr><td>' . $read->saddr . ', ' . $read->sarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->scity . '-' . $read->scountry . ' ' . $read->szipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '<td width="50%">';
                    $html .= '<table class="tables" style="border:1px solid #000;border-radius:8px !important;height:50px;" height="50">';
                    $html .= '<tr><td><b>Kirim Ke / Ship To:</b></td></tr>';
                    $html .= '<tr><td>' . $read->rname . '</td></tr>';
                    $html .= '<tr><td>' . $read->raddr . ',' . $read->rarea . '</td></tr>';
                    $html .= '<tr><td>' . $read->rcity . '-' . $read->rcountry . ' ' . $read->rzipcode . '</td></tr>';
                    $html .= '</table>';
                    $html .= '</td>';
                    $html .= '</tr>';
                    $html .= '</table>';

                    //$html .= '<table class="tables">';
                    //$html .='<tr><td>';
                    $html .= '<table class="tables">';
                    $html .='<tr>'
                            . '<td colspan="8">';
                    $html .= '<table class="tables" border="1">';
                    $html .= '<tr><td colspan="2"><table><tr><td>No. Quot.<br />Quot . Nbr</td><td class="td-ro">:</td><td width="70"> ' . $read->quote_no . '</td></tr></table></td><td colspan="2"><table><tr><td>Tgl. Quot.<br />Quot . Date</td><td class="td-ro">:</td><td>' . $quote_date . '</td></tr></table></td><td colspan="2"><table><tr><td width="50">Syarat Bayar<br />Billing Term</td><td class="td-ro">:</td><td width="70">' . $read->due_day . ' hari (days)</td></tr></table></td><td colspan="2"><table><tr><td width="70">Waktu Pengiriman<br />Delivery Date</td><td class="td-ro">:</td><td>' . $due_date . '</td></tr></table></td></tr>';
                    $html .= '<tr><td rowspan="2"  width="5%">No.</td><td rowspan="2" width="25%">Uraian<br />Description/Specification</td><td rowspan="2" width="10%">Satuan<br />U/M</td><td rowspan="2" width="10%">Kuantitas<br />Quantity</td><td rowspan="2">Harga Satuan<br />Unit Price</td><td colspan="2">Diskon<br />Discount </td><td rowspan="2">Jumlah/Amount</td></tr>';
                    $html .='<tr><td>%</td><td></td></tr>';

                    $acc_prd = $this->all_m->getWhere('acc_prd', array($inv_code => $read->$inv_code));
                    $no = 1;
                    foreach ($acc_prd as $prd):
                        $html .='<tr>'
                                . '<td  width="5%">' . $no . '</td>'
                                . '<td  width="25%">' . $prd->part_name . ' (' . $prd->part_code . ')</td>'
                                . '<td width="10%">' . $prd->unit . '</td>'
                                . '<td width="10%"  align="right">' . number_format($prd->qty) . '</td>'
                                . '<td align="right">' . number_format($prd->price_bd) . '</td>'
                                . '<td align="right">' . $prd->disc_pct . '</td>'
                                . '<td align="right">' . number_format($prd->disc_val) . '</td>'
                                . '<td align="right">' . number_format($prd->price_ad) . '</td>'
                                . '</tr>';
                        $no++;
                    endforeach;

                    $html .='</table>';
                    $html .='</td>';
                    $html .= '</tr>';
                    $html .='<tr>'
                            . '<td colspan="8" style="padding:0px !important">';
                    $html .= '<table class="tables">';
                    $html .= '<tr><td width="5%"></td><td width="25%"></td><td align="right"  width="10%"><b>Total</b></td><td align="right" border="1"  width="10%"><b>' . number_format($read->tot_qty) . '</b></td><td></td><td style="border:none !important;"></td><td align="right"><b>Sub Total</b></td><td align="right" border="1"><b>' . number_format($read->tot_price) . '</b></td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Discount</td><td  align="right" border="1">' . number_format($read->inv_disc) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Netto</td><td  align="right" border="1">' . number_format($read->inv_bt) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">PPN/VAT</td><td  align="right" border="1">' . number_format($read->inv_vat) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right"><b>Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_at) . '</b></td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right">Others</td><td  align="right" border="1">' . number_format($read->inv_stamp) . '</td></tr>';
                    $html .= '<tr><td colspan="6"></td><td align="right"><b>Grand Total</b></td><td  align="right" border="1"><b>' . number_format($read->inv_total) . '</b></td></tr>';
                    $html .= '</table>';
                    $html .='</td></tr>';
                    $html .= '</table>';
                    //$html .='</td></tr>';
                    //$html .= '</table>';
                }
                break;

            case 'acc_opnh':
                $code_form = 'AOPN';
                $opn_date = $this->dateView($read->opn_date);

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
                $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Faktur Opname / Opname Invoice</b></td></tr>';
                $html .= '<tr>';
                $html .= '<td>';
                $html .= '<table class="tables">';
                $html .='<tr><td>No. Faktur<br />Inv Number</td><td class="td-ro">:</td><td width="90">' . $read->$inv_code . '</td></tr>';
                $html .='<tr><td>Tgl. Faktur<br />Inv Date</td><td class="td-ro">:</td><td>' . $opn_date . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '<td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td colspan="2"><b><u>KETERANGAN/NOTE</u></b></td></tr>';
                $html .= '<tr><td colspan="2">Yang Opname: ' . $read->oprep_code . '-' . $read->oprep_name . '</td></tr>';
                $html .= '<tr><td colspan="2">' . $read->note . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '</tr>';
                $html .= '</table>';


                $html .= '<table class="tables">';
                $html .='<tr><td>';
                $html .= '<table class="tables">';
                $html .='<tr>'
                        . '<td colspan="9">';
                $html .= '<table class="tables" border="1">';
                $html .= '<tr><td width="5%"><b>No.<br />Line</b></td><td width="8%"><b>Kode<br />Code</b></td><td width="15%"><b>Uraian<br />Description</b></td><td width="9%"><b>Gudang<br />Warehouse</b></td><td width="10%"><b>Lokasi<br />Location</b></td><td width="9%"><b>Satuan<br />U/M</b></td><td width="9.5%" align="right"><b>Kuantitas<br />Quantity</b></td><td width="15%"  align="right"><b>Harga Satuan<br />Unit Price</b></td><td width="10%" align="right"><b>Jumlah / Amount</b></td><td width="10%"><b>Kode Opn<br />Opn Code</b></td></tr>';

                $acc_opnd = $this->all_m->getWhere('acc_opnd', array($inv_code => $read->$inv_code));
                $no = 1;
                foreach ($acc_opnd as $opnd):
                    $html .='<tr>'
                            . '<td>' . $no . '</td>'
                            . '<td>' . $opnd->part_code . '</td>'
                            . '<td>' . $opnd->part_name . '</td>'
                            . '<td>' . $opnd->wrhs_code . '</td>'
                            . '<td>' . $opnd->location . '</td>'
                            . '<td>' . $opnd->unit . '</td>'
                            . '<td align="right">' . number_format($opnd->qty) . '</td>'
                            . '<td align="right">' . number_format($opnd->price_bd) . '</td>'
                            . '<td align="right">' . number_format($opnd->price_bd * $opnd->qty) . '</td>'
                            . '<td>' . $opnd->opn_code . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;
                $html .='</table>';
                $html .='</td></tr>';

                $html .= '<tr><td colspan="9">';
                $html .= '<table class="tables">';
                $html .= '<tr>'
                        . '<td width="3%"></td>'
                        . '<td></td>'
                        . '<td width="20%"></td>'
                        . '<td width="8.5%"></td>'
                        . '<td width="10%"></td>'
                        . '<td align="right" width="9%"><b>Total:</b></td>'
                        . '<td align="right" width="10%"   border="1">' . number_format($read->tot_qty) . '</td>'
                        . '<td align="right" width="10%"><b>Total Harga:</b></td>'
                        . '<td align="right" width="10%"   border="1">' . number_format($read->tot_price) . '</td>'
                        . '<td></td></tr>';
                $html .='</table>';
                $html .= '</td></tr>';

                $html .='</table>';
                $html .='</td></tr>';
                $html .='</table>';


                break;

            case 'acc_rslh':
                $code_form = 'ARSL';
                $rsl_date = $this->dateView($read->rsl_date);

                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td style="font-size:16px;font-weight:bold;">' . $rsl_date . '</td></tr>'
                        . '<tr><td style="font-size:16px;font-weight:bold;">' . $read->rsl_inv_no . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '<td>'
                        . '<table>'
                        . '<tr><td  style="font-size:14px;font-weight:bold;"><b>Retur Penjualan</b></td></tr>'
                        . '<tr><td></td></tr>'
                        . '<tr><td>' . $read->sal_inv_no . '  &nbsp; &nbsp;' . $this->dateView($read->sal_date) . '</td></tr>'
                        . '<tr><td>' . $read->cust_name . '</td></tr>'
                        . '</table>'
                        . '</td>';
                $html .= '</tr>';
                $html .= '</table>';
                $html .= '<br /><br /><br />';

                $html .= '<table class="tables">';
                $html .='<tr><td>';
                $html .= '<table class="tables">';
                $html .='<tr><td>';
                $html .= '<table class="tables">';

                $html .= '<tr><td width="5%" style="border-bottom:0.5px solid black;"><b>No</b></td><td width="20%" style="border-bottom:0.5px solid black;"><b>Nama Part</b></td><td style="border-bottom:0.5px solid black;"><b>No. Part</b></td><td style="border-bottom:0.5px solid black;"><b>Unit</b></td><td align="right" style="border-bottom:0.5px solid black;"><b>Qty</b></td><td align="right" style="border-bottom:0.5px solid black;"><b>Harga</b></td><td align="right" style="border-bottom:0.5px solid black;"><b>Disc (%)</b></td><td align="right" style="border-bottom:0.5px solid black;"><b>Netto</b></td></tr>';
                $acc_rsld = $this->all_m->getWhere('acc_rsld', array($inv_code => $read->$inv_code));
                $no = 1;

                foreach ($acc_rsld as $rsld):
                    $html .='<tr>'
                            . '<td>' . $no . '</td>'
                            . '<td>' . $rsld->part_name . '</td>'
                            . '<td>' . $rsld->part_code . '</td>'
                            . '<td>' . $rsld->unit . '</td>'
                            . '<td align="right">' . number_format($rsld->qty) . '</td>'
                            . '<td align="right">' . number_format($rsld->price_bd) . '</td>'
                            . '<td align="right">' . number_format($rsld->disc_pct) . '</td>'
                            . '<td align="right">' . number_format($rsld->price_ad) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;
                $html .='</table>';
                $html .='</td></tr>';

                $html .= '<tr><td>';
                $html .= '<table class="tables">';

                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td>Sub Total:</td><td align="right" >' . number_format($read->tot_price) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right">' . number_format($read->inv_disc) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right">' . number_format($read->inv_bt) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right">' . number_format($read->inv_vat) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right">' . number_format($read->inv_at) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right">' . number_format($read->inv_stamp) . '</td></tr>';
                $html .= '<tr><td width="5%"></td><td width="20%"></td><td colspan="4"></td><td></td><td align="right"><b>' . number_format($read->inv_total) . '</b></td></tr>';

                $html .='</table>';
                $html .= '</td></tr>';

                $html .='</table>';
                $html .='</td></tr>';
                $html .='</table>';
                break;

            case 'acc_movh':
                $code_form = 'AMOV';
                $mov_date = $this->dateView($read->mov_date);

                $html .= '<table class="tables">';
                $html .= '<tr>';
                $html .= '<td width="40%">';
                $html .= '<table class="tables">';
                $html .='<tr><td style="font-size:14px;"><b>' . $company->comp_name . '</b></td></tr>';
                $html .='<tr><td>' . $company->comp_add1 . '</td></tr>';
                $html .='<tr><td>' . $company->comp_add2 . '</td></tr>';
                $html .='<tr><td><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
                $html .= '</table>';
                $html .= '</td>';
                $html .= '<td  width="60%">';
                $html .= '<table class="tables" border="1">';
                $html .= '<tr><td colspan="2" style="font-size:14px;text-align:center;"><b>Pemindahan Barang</b></td></tr>';
                $html .= '<tr>';
                $html .= '<td>';
                $html .= '<table class="tables">';
                $html .='<tr><td>No. Faktur<br />Inv Number</td><td class="td-ro">:</td><td width="90">' . $read->$inv_code . '</td></tr>';
                $html .='<tr><td>Tgl. Faktur<br />Inv Date</td><td class="td-ro">:</td><td>' . $mov_date . '</td></tr>';
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
                $html .='<tr><td>';
                $html .= '<table class="tables" border="1">';

                $html .= '<tr>'
                        . '<td rowspan="2" width="5%"><b>No.<br />Line</b></td>'
                        . '<td rowspan="2" width="8.6%"><b>Kode Barang<br />Item Code</b></td>'
                        . '<td rowspan="2" width="20%"><b>Uraian<br />Description/Specification</b></td>'
                        . '<td rowspan="2"><b>Satuan<br />U/M</b></td>'
                        . '<td colspan="2"><b>Dari/From</b></td>'
                        . '<td colspan="2"><b>Ke/To</b></td>'
                        . '<td rowspan="2"  align="right"><b>Kuantitas<br />Quantity</b></td>'
                        . '</tr>';
                $html .= '<tr>'
                        . '<td>Gudang<br /><b>Warehouse</b></td>'
                        . '<td>Lokasi<br /><b>Location</b></td>'
                        . '<td>Gudang<br /><b>Warehouse</b></td>'
                        . '<td>Lokasi<br /><b>Location</b></td>'
                        . '</tr>';
                $acc_movd = $this->all_m->getWhere('acc_movd', array($inv_code => $read->$inv_code));
                $no = 1;

                foreach ($acc_movd as $movd):
                    $html .='<tr>'
                            . '<td>' . $no . '</td>'
                            . '<td>' . $movd->part_code . '</td>'
                            . '<td>' . $movd->part_name . '</td>'
                            . '<td>' . $movd->unit . '</td>'
                            . '<td>' . $movd->wrhs_from . '</td>'
                            . '<td>' . $movd->loc_from . '</td>'
                            . '<td>' . $movd->wrhs_to . '</td>'
                            . '<td>' . $movd->loc_to . '</td>'
                            . '<td align="right">' . number_format($movd->qty) . '</td>'
                            . '</tr>';
                    $no++;
                endforeach;

                $html .='</table>';
                $html .='</td></tr>';
                $html .='<tr><td>';
                $html .= '<table class="tables">';
                $html .= '<tr><td width="5%"></td><td width="8.6%"></td><td width="20%"></td><td colspan="4"></td><td align="right"><b>Total</b></td><td align="right" border="1"><b>' . number_format($read->tot_qty) . '</b></td></tr>';
                $html .='</table>';
                $html .='</td></tr>';

                ////Foooter
                $html .='</table>';

                break;
        }

        if ($code_form !== '') {
            $html .= '<table class="tables">';
            $html .='<tr><td>';
            $html .= $this->set_form($code_form, $read);

            $html .='</td></tr>';
            $html .= '</table>';
        }
        $output = array(
            'html' => $html,
            'number' => $number
        );

        return $output;
    }

    function checkPO() {
        $po_no = $this->input->post('po_no');
        $pur_inv_no = $this->input->post('pur_inv_no');
        $check = $this->all_m->check('acc_prd', array('po_no' => $po_no, 'pur_inv_no' => $pur_inv_no));
        $res = array('count' => $check);
        $this->json($res);
    }

    function deleteNoPO() {
        $id = $this->input->post('id');
        $data = array('po_no' => '', 'po_date' => '');
        $this->all_m->updateData('acc_prh', 'id', $id, $data);
        $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        $this->json($msg);
    }

    function uncloseReturnPemb() {
        
    }

}
