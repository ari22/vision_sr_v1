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

    function grid_lookup() {

        if (isset($_GET['grid'])) {
            $table = $this->uri->segment(4);
            $grid = $this->get_data_mdl->get_data_lookup($table);
            $this->json($grid);
        } else {
            $field1 = (object) $this->input->post('field1');
            $field2 = (object) $this->input->post('field2');
            $table = $this->input->post('table');
            $pk = $this->input->post('pk');
            $sk = $this->input->post('sk');

            $this->content['field1'] = $field1;
            $this->content['field2'] = $field2;
            $this->content['table'] = $table;
            $this->content['pk'] = $pk;
            $this->content['sk'] = $sk;

            $this->ag_auth->view('builder/grid_lookup', $this->content);
        }
    }

    function save_vehicle() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();
        //print_r($data);exit;

        unset($data['id']);
        unset($data['table']);

        if (!empty($data['dob'])) {
            $data['dob'] = $this->dateFormat($data['dob']);
        }
        if (!empty($data['wed_anniv'])) {
            $data['wed_anniv'] = $this->dateFormat($data['wed_anniv']);
        }
        if (!empty($data['spouse_dob'])) {
            $data['spouse_dob'] = $this->dateFormat($data['spouse_dob']);
        }
        if (!empty($data['child1_dob'])) {
            $data['child1_dob'] = $this->dateFormat($data['child1_dob']);
        }
        if (!empty($data['child2_dob'])) {
            $data['child2_dob'] = $this->dateFormat($data['child2_dob']);
        }
        if (!empty($data['oest_date'])) {
            $data['oest_date'] = $this->dateFormat($data['oest_date']);
        }
        if (!empty($data['in_date'])) {
            $data['in_date'] = $this->dateFormat($data['in_date']);
        }
        if (!empty($data['out_date'])) {
            $data['out_date'] = $this->dateFormat($data['out_date']);
        }
        if (!empty($data['act_date'])) {
            $data['act_date'] = $this->dateFormat($data['act_date']);
        }
        if (!empty($data['exp_date'])) {
            $data['exp_date'] = $this->dateFormat($data['exp_date']);
        }
        if (!empty($data['add_date'])) {
            $data['add_date'] = $this->dateFormat($data['add_date']);
        }


        if ($table == 'acc_mst') {
            unset($data['salvat']);
        }


        if ($table == 'maccs') {
            unset($data['salvat2']);
            unset($data['price_end']);
        }

        foreach ($data as $k => $v) {
            $key[] = $k;
        }


        if ($table !== 'veh_prc') {
            $code = $key[0];
            $name = $key[1];

            $code_msg = $this->code_msg($code);
            $name_msg = $this->name_msg($name);
        } else {
            $code = 'col_type';
            $name = 'veh_code';

            $code_msg = $this->code_msg($code);
            $name_msg = $this->name_msg($name);
        }


        if ($table == 'veh_cust' || $table == 'veh_supp' || $table == 'insurance' || $table == 'acc_cust' || $table == 'acc_supp') {
            if (empty($data['ovat'])) {
                $data['ovat'] = 0;
            }
        }

        if ($this->input->post($code) !== '') {
            if ($id == '') {
                $data[$code] = strtoupper($this->input->post($code));
            }

            if ($this->input->post($name) !== '') {

                if ($code == 'cust_code' || $code == 'supp_code' || $code == 'insr_code') {

                    if ($this->input->post('sex') !== false) {

                        if ($this->input->post('postaddr') !== false) {

                            if ($this->input->post('postaddr') == '1') {

                                if ($this->input->post('oaddr') == '') {
                                    $msg = array('status' => false, 'message' => 'Enter Office Address! ');
                                }
                            } elseif ($this->input->post('postaddr') == '2') {

                                if ($this->input->post('haddr') == '') {
                                    $msg = array('status' => false, 'message' => 'Enter Home Address! ');
                                }
                            } else {
                                $msg = array('status' => true);
                            }
                        } else {
                            $msg = array('status' => false, 'message' => 'Choose Destination Letter! ');
                        }
                    } else {
                        $msg = array('status' => false, 'message' => 'Choose Gender! ');
                    }
                } else {
                    $msg = array('status' => true);
                }
            } else {
                $msg = array('status' => false, 'message' => $name_msg);
            }
        } else {
            $msg = array('status' => false, 'message' => $code_msg);
        }


        /* if($data['sex'] == null){
          $data['sex'] = 0;
          }
         */
        if ($table == 'veh_vtyp') {
            $row = $this->all_m->getId($table, 'id', $id);

            $config = array(
                'upload_path' => '../uploads/'
                , 'allowed_types' => 'gif|jpg|png'
                , 'max_size' => '1000000000'
                , 'max_width' => '4048'
                , 'max_height' => '4024'
                , 'encrypt_name' => TRUE
            );

            $this->upload->initialize($config);


             $data['veh_image'] = '';

            if (isset($_FILES)) {
                if (!$this->upload->do_upload('veh_image')) {
                    
                } else {
                    if (count($row) == 1) {
                        if ($row->veh_image !== '') {                           
                            unlink('../uploads/' . $row->veh_image);
                        }
                    }
                    $tGambar = $this->upload->data();
                    $data['veh_image'] = $tGambar["file_name"];
                }
            } 
            
           
        }


        if ($msg['status'] !== false) {
            if ($id !== '') {


                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ');
                $this->updateLocked($table, $id);
            } else {

                if ($table !== 'maccs') {

                    if ($table !== 'veh_prc') {
                        $check = $this->all_m->check($table, array($code => $this->input->post($code)));
                    } else {
                        $check = $this->all_m->check($table, array($code => $this->input->post($code), $name => $this->input->post($name)));
                    }

                    if ($check > 0) {
                        $msg = array('status' => false, 'message' => 'Code already exist!');
                    } else {
                        $this->all_m->insertData($table, $data);
                        $msg = array('success' => true, 'message' => 'Record saved');
                    }
                } else if ($table == 'veh_prc') {
                    $checkData = $this->all_m->countlimit($table, array($code => $data[$code], $name => $data[$name]));

                    if ($checkData > 0) {
                        $msg = array('status' => false, 'message' => 'Data already exist!');
                    } else {
                        $this->all_m->insertData($table, $data);
                        $msg = array('success' => true, 'message' => 'Record saved');
                    }
                } else {
                    $this->all_m->insertData($table, $data);
                    $msg = array('success' => true, 'message' => 'Record saved');
                }
            }

            if ($msg['success']) {
                if ($table == 'maccs') {
                    $res = $this->all_m->query_single("SELECT SUM(min_qty) as min, SUM(max_qty) as max FROM $table WHERE part_code='$data[part_code]' AND part_name='$data[part_name]'");

                    $this->all_m->updateData('acc_mst', 'part_code', $data['part_code'], array('min_qty' => $res->min, 'max_qty' => $res->max));
                }
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function delete() {
        //print_r($this->input->post());exit;
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

    function read() {

        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');

        if ($this->input->post('field')) {
            $where = array($this->input->post('field') => $this->input->post('val'));
            $read = $this->crud_mdl->read($table, $nav, $id, $where);
        } else {
            $read = $this->crud_mdl->read($table, $nav, $id);
        }

        $this->json($read);
    }

    function code_msg($code) {
        switch ($code) {
            case 'cust_code':
                $msg = 'Enter the Customer Code!';
                break;

            case 'supp_code':
                $msg = 'Enter the Supplier Code!';
                break;

            case 'insr_code':
                $msg = 'Enter the Insurance Code!';
                break;

            case 'bank_code':
                $msg = 'Enter the Bank Code!';
                break;

            case 'agent_code':
                $msg = 'Enter the Agent Code!';
                break;

            case 'coll_code':
                $msg = 'Enter the Collector Code!';
                break;

            case 'lease_code':
                $msg = 'Enter the Leasing Code!';
                break;

            case 'srep_code':
                $msg = 'Enter the Sales Code!';
                break;

            case 'stdoptcode':
                $msg = 'Enter the Standart Optional Code!';
                break;

            case 'veh_code':
                $msg = 'Enter the Vehicle Code!';
                break;

            case 'color_code':
                $msg = 'Enter the Color Code!';
                break;

            case 'prep_code':
                $msg = 'Enter the Purchaser Code';
                break;

            case 'oprep_code':
                $msg = 'Enter the Opname Code';
                break;

            case 'wk_code':
                $msg = 'Enter the Work Code';
                break;

            case 'col_type':
                $msg = 'Please Select Color Type';
                break;

            case 'part_code':
                $msg = 'Enter the Part Code';
                break;
        }

        return $msg;
    }

    function name_msg($name) {
        switch ($name) {
            case 'veh_code':
                $msg = 'Enter the Vehicle Code';
                break;

            case 'cust_name':
                $msg = 'Enter the Customer Name!';
                break;

            case 'supp_name':
                $msg = 'Enter the Suplier Name!';
                break;

            case 'insr_name':
                $msg = 'Enter the Insurance Name!';
                break;

            case 'bank_name':
                $msg = 'Enter the Bank Name!';
                break;

            case 'agent_name':
                $msg = 'Enter the Agent Name!';
                break;

            case 'coll_name':
                $msg = 'Enter the Collector Name!';
                break;

            case 'lease_name':
                $msg = 'Enter the Leasing Name!';
                break;

            case 'srep_name':
                $msg = 'Enter the Sales Name!';
                break;

            case 'stdoptname':
                $msg = 'Enter the Standart Optional Name!';
                break;

            case 'veh_name':
                $msg = 'Enter the Vehicle Name!';
                break;

            case 'prep_name':
                $msg = 'Enter the Purchaser Name';
                break;

            case 'oprep_name':
                $msg = 'Enter the Opname Name';
                break;

            case 'wk_desc':
                $msg = 'Enter the Work Name';
                break;

            case 'color_name':
                $msg = 'Enter the Color Name!';
                break;

            case 'part_name':
                $msg = 'Enter the Part Name';
                break;
        }

        return $msg;
    }

    function save_subs() {

        $table = $this->input->post('table');
        $part1 = $this->input->post('part1');
        $part2 = $this->input->post('part2');

        $data = array(
            'part_code1' => $part1,
            'part_code2' => $part2
        );

        if ($part1 == $part2) {
            $msg = array('success' => false, 'message' => 'The Part Code entered should be different from ' . $part1);
        } else {
            $check = $this->all_m->countlimit($table, $data);

            if ($check > 0) {

                $row = $this->all_m->getOne($table, $data);

                $this->all_m->deleteData($table, 'id', $row->id);
            }

            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved');
        }

        $this->json($msg);
    }

    function save_accesories() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();


        $stat = true;
        unset($data['id']);
        unset($data['table']);
        unset($data['salvat']);
        unset($data['salvat2']);

        if (!empty($data['input_date'])) {
            $data['input_date'] = $this->dateFormat($data['input_date']);
        }
        if (!empty($data['last_sold'])) {
            $data['last_sold'] = $this->dateFormat($data['last_sold']);
        }
        if (!empty($data['last_pur'])) {
            $data['last_pur'] = $this->dateFormat($data['last_pur']);
        }

        if ($table == 'acc_mst') {

            if ($data['unit'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Enter Unit');
            }
            if ($data['part_name'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Enter the Part Name');
            }
            if ($data['part_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Enter the Part Code');
            }

            $check = $this->all_m->countlimit($table, array('part_code' => $data['part_code'], 'part_name' => $data['part_name']));
        }

        if ($table == 'maccs') {
            unset($data['price_end']);

            if ($data['pur_price'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Enter the Purchase Price');
            }
            if ($data['wrhs_code'] == '') {
                $stat = false;
                $msg = array('success' => false, 'message' => 'Enter the Warehouse');
            }

            if ($data['prt_inact'] == '') {
                $data['prt_inact'] = 0;
            }

            $data['qty'] = 0;
            $data['qty_pick'] = 0;
            $data['qty_order'] = 0;
            $data['qty_border'] = 0;

            //$data['purl_price'] = $data['pur_price'];



            $check = $this->all_m->countlimit($table, array('part_code' => $data['part_code'], 'part_name' => $data['part_name'], 'wrhs_code' => $data['wrhs_code'], 'location' => $data['location']));
        }

        if ($stat !== false) {
            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data);

                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
                $this->updateLocked($table, $id);
            } else {

                if ($check > 0) {
                    $msg = array('success' => false, 'message' => 'Warehouse and Location already available');
                } else {
                    $this->all_m->insertData($table, $data);

                    $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                }
            }
        }

        $this->json($msg);
    }

    function delete_accesories() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $acc_mst = $this->all_m->getId($tbl, 'id', $id);
        $part_code = $acc_mst->part_code;

        $check_maccs = $this->all_m->countlimit('maccs', array('part_code' => $part_code));

        if ($check_maccs > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, Record can not be deleted, Record has details, Please Details');
        }

        $check_subs2 = $this->all_m->countlimit('acc_subs', array('part_code2' => $part_code));
        if ($check_subs2 > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, Record can not be deleted, Record has details, Please Details');
        }

        $check_subs1 = $this->all_m->countlimit('acc_subs', array('part_code1' => $part_code));
        if ($check_subs1 > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, Record can not be deleted, Record has details, Please Details');
        }

        if ($msg['success'] !== false) {

            $this->all_m->deleteData($tbl, 'id', $id);
            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function form() {

        $page = $this->uri->segment(4);
        $path = 'form/' . $this->input->post('path') . 'kendaraan/' . $page;
        $this->ag_auth->view($path, $this->content);
    }

    function check_cust() {

        $cust = $this->input->post('cust_name');
        $cust_spl = str_split($cust);

        if (count($cust_spl) > 2) {

            $check = $this->all_m->check('veh_cust', array('cust_name' => $cust));

            if ($check > 0) {
                $msg = array('success' => false, 'message' => 'Please enter a different Name, This Name is already in the database');
            } else {
                $code = strtoupper(substr($cust, 0, 3));
                $number = $this->all_m->autoNumber('veh_cust', 'cust_code', 3, $code);
                $msg = array('success' => true, 'number' => $number);
            }
        } else {
            $msg = array('success' => false, 'message' => 'Please enter a different Name, Name Length of at least 3 characters');
        }


        $this->json($msg);
    }

    function refreshQty() {
        $part_code = $this->input->post('part_code');
        $row = $this->all_m->query_single("SELECT id, SUM(qty) as qty, SUM(qty_pick) as qty_pick, SUM(qty_order) as qty_order, SUM(qty_border) as qty_border FROM maccs WHERE part_code='$part_code'");
        $data = array(
            'qty' => $row->qty,
            'qty_pick' => $row->qty_pick,
            'qty_order' => $row->qty_order,
            'qty_border' => $row->qty_border
        );
        $this->all_m->updateData('acc_mst', 'id', $row->id, $data);
        $this->json($row);
    }

}
