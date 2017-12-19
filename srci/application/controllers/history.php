<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class History extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl'));
    }

    function read() {
        $table = encrypt_decrypt('decrypt', $this->input->post('table'));
        //$table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        
        $db1 = $this->db->database;

        if ($this->input->get()) {
            $where = $this->input->get();

            if ($table == 'veh_arh') {
                $date1 = $where['opn_date1'];
                $date2 = $where['opn_date2'];
                
                $field = 'sal_inv_no';
                $val   = $where['sal_inv_no'];
                $fielddate = 'opn_date';
                
                //$where = array('sal_inv_no' => $where['sal_inv_no'], 'opn_date >=' => $date1, 'opn_date <=' => $date2);
            }

            if ($table == 'veh_aph') {
                $date1 = $where['pur_date1'];
                $date2 = $where['pur_date2'];
                
                $field = 'pur_inv_no';
                $val   = $where['pur_inv_no'];
                $fielddate = 'pur_date';
                //$where = array('pur_inv_no' => $where['pur_inv_no'], 'pur_date >=' => $date1, 'pur_date <=' => $date2);
            }

            if ($table == 'acc_arh') {
                $date1 = $where['opn_date1'];
                $date2 = $where['opn_date2'];
                
                $field = 'sal_inv_no';
                $val   = $where['sal_inv_no'];
                $fielddate = 'opn_date';
                //$where = array('sal_inv_no' => $where['sal_inv_no'], 'opn_date >=' => $date1, 'opn_date <=' => $date2);
            }

            if ($table == 'acc_aph') {
                $date1 = $where['pur_date1'];
                $date2 = $where['pur_date2'];
                
                $field = 'pur_inv_no';
                $val   = $where['pur_inv_no'];
                $fielddate = 'pur_date';
                //$where = array('pur_inv_no' => $where['pur_inv_no'], 'pur_date >=' => $date1, 'pur_date <=' => $date2);
            }

            if ($table == 'veh_spk') {
                //$date1 = explode('-', $where['so_date1']);
                //$date2 = explode('-', $where['so_date2']);
                
                $date1 = $where['so_date1'];
                $date2 = $where['so_date2'];
                
                $field = 'so_no';
                $val   = $where['so_no'];
                $fielddate = 'so_date';
                
               // $where = array('so_no' => $where['so_no'], 'YEAR(so_date) <=' => $date2[0]);
            }

            
            
            $statsql = "select * from $db1.$table where $field='$val' and $fielddate >='$date1' and $fielddate <='$date2' ";
            
            $mounth = $this->rangeMounth($date1, $date2);
            
            $statsql .= $this->queryUnion($mounth, $db1, $statsql);
            
            $read = (array)$this->all_m->query_single($statsql);           
            
            $date = explode('-', $read[$fielddate]);
            
            $read['db'] = $this->getDataHistory($date[0], $date[1]);
            $read['mounth'] = $date[1];
            $read['year'] = $date[0];
           // $read = $this->crud_mdl->read($table, $nav, $id, $where);
        } else {
            $read = $this->crud_mdl->read($table, $nav, $id);
        }

        $this->json($read);
    }

}
