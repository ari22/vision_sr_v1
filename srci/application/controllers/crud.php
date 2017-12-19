<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Crud extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function delete() {
        if (logged_in()) {

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
        } else {
            $this->login();
        }
    }

    function read() {
        $year = null;
        $mounth = null;
        
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        
        if($this->input->post('year')){
            $year = $this->input->post('year');
        }
        if($this->input->post('mounth')){
            $mounth = $this->input->post('mounth');
        }
        
        $dbs = $this->getDataHistory($year, $mounth);
         
        if ($this->input->get()) {
            $where = $this->input->get();
            $read = $this->crud_mdl->read($dbs.'.'.$table, $nav, $id, $where);
        } else {
            if ($table == 'set_vglh') {
                $where['inv_div IN ("VEH", "ACC")'] = NULL;
              
                $read = $this->crud_mdl->read($dbs.'.'.$table, $nav, $id, $where);
                
            }elseif ($table == 'veh_spk') {
                 $where['canc_date IN ("0000-00-00")'] = NULL;
              
                $read = $this->crud_mdl->read($dbs.'.'.$table, $nav, $id, $where);
                
            }
            else {
                $read = $this->crud_mdl->read($dbs.'.'.$table, $nav, $id);
            }
        }

        $this->json($read);
    }

    function read2() {
        if (logged_in()) {
            $table = $this->input->post('table');
            $nav = $this->input->post('nav');
            $id = $this->input->post('id');
            $read = $this->crud_mdl->read($table, $nav, $id);
            //$this->json($read);
            echo '<pre>';
            print_r($read);
            echo '</pre>';
        } else {
            $this->login();
        }
    }

    function read_relation() {
        if (logged_in()) {

            $relation = $this->input->post('relation');
            $table = $this->input->post('table');
            $data = $this->all_m->getOne($table, $relation);
            $this->json($data);
        } else {
            $this->login();
        }
    }

    function save() {
        if (logged_in()) {
            print_r($this->input->post());
        } else {
            $this->login();
        }
    }

    function update() {

        //$tbl = encrypt_decrypt('decrypt', $this->input->post('table'));
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);
        unset($data['field']);

        $this->all_m->updateData($tbl, $field, $id, $data);
    }

}
