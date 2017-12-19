<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Lookup extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function grid_lookup() {


        if (isset($_GET['grid'])) {
            $table = $this->uri->segment(4);
            $grid = $this->get_data_mdl->get_data($table);
            $this->json($grid);
        } else {
            $field1 = (object) $this->input->post('field1');
            $field2 = (object) $this->input->post('field2');
            $table = $this->input->post('table');
            $pk = $this->input->post('pk');
            $sk = $this->input->post('sk');
            $version = $this->input->post('v');

            $this->content['v'] = $version;
            $this->content['field1'] = $field1;
            $this->content['field2'] = $field2;
            $this->content['table'] = $table;
            $this->content['pk'] = $pk;
            $this->content['sk'] = $sk;

            $this->ag_auth->view('builder/grid_lookup', $this->content);
        }
    }

    function save_lookup() {

        $post = $this->input->post();

        foreach ($post as $k => $v) {
            $value[] = $this->input->post($k, true);
            $key[] = $k;
        }

        $id = $value[0];
        $table = $value[1];


        if ($id !== '') {
            if (strtoupper($value[2]) !== '') {
                $fields = array($key[2] => strtoupper($value[2]));
                $name_check = $this->all_m->countlimit($table, array($key[2] => strtoupper($value[2])));

                $data = $this->all_m->getId($table, 'id', $id);

                if (strtoupper($value[2] == $data->$key[2])) {
                    $msg = array('success' => true, 'message' => 'no data change');
                } else {
                    if ($name_check > 0) {
                        $msg = array('success' => false, 'message' => 'Data already exist!');
                    } else {
                        $this->all_m->updateData($table, 'id', $id, $fields);
                        $msg = array('success' => true, 'message' => 'Record updated ' . $value[3]);
                    }
                }
            } else {
                $msg = array('success' => false, 'message' => 'Data cannot be empty !');
            }

            $this->updateLocked($table, $id);
        } else {
            if (strtoupper($value[2]) !== '' && strtoupper($value[3]) !== '') {

                $fields = array($key[2] => strtoupper($value[2]), $key[3] => strtoupper($value[3]));
                $code_check = $this->all_m->countlimit($table, array($key[2] => strtoupper($value[2])));
                $name_check = $this->all_m->countlimit($table, array($key[3] => strtoupper($value[3])));
                if ($code_check > 0 || $name_check > 0) {
                    $msg = array('success' => false, 'message' => 'Data already exist!');
                } else {
                    $this->all_m->insertData($table, $fields);

                    $check = $this->all_m->countlimit($table, $fields);
                    if ($check > 0) {
                        $msg = array('success' => true, 'message' => 'Record saved');
                    } else {
                        $msg = array('success' => false, 'message' => 'Insert failed!');
                    }
                }
            } else {
                $msg = array('success' => false, 'message' => 'field not empty!');
            }
        }
        $this->json($msg);
    }

    function save_receiving() {

        $id = $this->input->post('id');
        $table = $this->input->post('table');

        $data['raddr_code'] = $this->input->post('raddr_code');
        $data['raddr_name'] = $this->input->post('raddr_name');
        $data['oname'] = $this->input->post('oname');
        $data['oaddr'] = $this->input->post('oaddr');
        $data['oarea'] = $this->input->post('oarea');
        $data['ocity'] = $this->input->post('ocity');
        $data['ozipcode'] = $this->input->post('ozipcode');
        $data['ocountry'] = $this->input->post('ocountry');
        $data['ophone'] = $this->input->post('ophone');
        $data['ofax'] = $this->input->post('ofax');
        $data['ocp1_name'] = $this->input->post('ocp1_name');
        $data['ocp1_title'] = $this->input->post('ocp1_title');

        if ($id !== '') {
            $this->all_m->updateData($table, 'id', $id, $data);
            $msg = array('success' => true, 'message' => 'Record updated ' . $value[3]);
            $this->updateLocked($table, $id);
        } else {

            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved');
        }
        $this->json($msg);
    }

    function read() {

        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        $read = $this->crud_mdl->read($table, $nav, $id);
        $this->json($read);
    }

    function delete() {


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

    function combogrid() {

        $table = encrypt_decrypt('decrypt', $this->uri->segment(4));
        $data = $this->get_data_mdl->get_data_combogrid($table);
        $rows = array();

        foreach ($data as $row) {
            $rows[] = $row;
        }

        $this->json($rows);
    }

    function ReceivingAddress() {

        $path = $this->input->post('path') . '/wilayah/form_alamat_penerima';
        $this->ag_auth->view($path, $this->content);
    }

}
