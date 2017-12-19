<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Form extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'get_data_mdl', 'all_m'));
    }

    function chassis() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $mounth = $this->uri->segment(4);
        $year = $this->uri->segment(5);


        $dbs = $this->getDataHistory($year, $mounth);

        if ($this->uri->segment(4)) {
            $where['sal_date >='] = $year . '-' . $mounth . '-01';
        }
        if ($this->uri->segment(5)) {
            $where['sal_date <='] = $year . '-' . $mounth . '-31';
        }
        $where['chassis !=""'] = NULL;
        //$where['cls_date NOT IN ("0000-00-00")'] = NULL;
        $like = null;

        if ($_POST['q']) {
            $like = array(
                'field' => 'chassis',
                'value' => $_POST['q']
            );
        }
        $data = $this->get_data_mdl->get_data($dbs . '.' . $table, $where, $like, 'form');

        $this->json($data);
    }

    function spk() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $mounth1 = $this->uri->segment(4);
        $year1 = $this->uri->segment(5);

        if ($this->uri->segment(6)) {
            $db1 = $this->db->database;
            
            $mounth2 = $this->uri->segment(7);
            $year2 = $this->uri->segment(8);
            
            $so_date1 = $year1 . '-' . $mounth1 . '-01';
            $so_date2 = $year2 . '-' . $mounth2 . '-31';
            
            $statsql = "select * from $db1.$table where so_date >='$so_date1' and so_date <='$so_date2' ";
            
            $mounth = $this->rangeMounth($so_date1, $so_date2);
            
            $statsql .= $this->queryUnion($mounth, $db1, $statsql);
            
            $data = $this->all_m->query_all($statsql);
            
            
        } else {
            $dbs = $this->getDataHistory($year1, $mounth1);

            $where['so_date >='] = $year1 . '-' . $mounth1 . '-01';
            $where['so_date <='] = $year1 . '-' . $mounth1 . '-31';
            //$where['chassis !=""'] = NULL;
            //$where['cls_date NOT IN ("0000-00-00")'] = NULL;

            $data = $this->get_data_mdl->get_data($dbs . '.' . $table, $where);
        }

        $this->json($data);
    }

    function datalist() {
        $table = encrypt_decrypt('decrypt', $this->uri->segment(3));
        $form = $this->uri->segment(4);
        $type = $this->uri->segment(5);

        $mounth = $this->input->post('mounth');
        $year = $this->input->post('year');

        $dbs = $this->getDataHistory($year, $mounth);

        $where = array();

        if ($form == 'sj') {
            if ($type == 2) {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                $where['sal_date >='] = $this->dateFormat($this->input->post('from'));
                $where['sal_date <='] = $this->dateFormat($this->input->post('to'));
            }
            if ($type == 3) {


                $where['opn_date >='] = $year . '-' . $mounth . '-01';
                $where['opn_date <='] = $year . '-' . $mounth . '-31';

                $where['chassis !=""'] = NULL;
                $where['cls_date IN ("0000-00-00")'] = NULL;
                $where['pick_date NOT IN ("0000-00-00")'] = NULL;
            }

            $grids = $this->all_m->getWhere($dbs . '.' . $table, $where);

            foreach ($grids as $r) {
                $json[] = array(
                    'chassis' => $r->chassis,
                    'id' => $r->id
                );
            }
        }
        if ($form == 'spk') {
            if ($type == 2) {
                $where['cls_date NOT IN ("0000-00-00")'] = NULL;
                $where['so_date >='] = $this->dateFormat($this->input->post('from'));
                $where['so_date <='] = $this->dateFormat($this->input->post('to'));
            }

            $grids = $this->all_m->getWhere($dbs . '.' . $table, $where);

            foreach ($grids as $r) {
                $json[] = array(
                    'so_no' => $r->so_no,
                    'id' => $r->id
                );
            }
        }

        if ($form == 'btlsj') {
            $where['cls_date IN ("0000-00-00")'] = NULL;
            $where['pick_date NOT IN ("0000-00-00")'] = NULL;
            $grids = $this->all_m->getWhere($dbs . '.' . $table, $where);

            foreach ($grids as $r) {
                $json[] = array(
                    'chassis' => $r->chassis,
                    'id' => $r->id
                );
            }
        }

        if ($form == 'accsj') {

            $where['cls_date NOT IN ("0000-00-00")'] = NULL;
            $where['sal_date >='] = $this->dateFormat($this->input->post('from'));
            $where['sal_date <='] = $this->dateFormat($this->input->post('to'));
            $grids = $this->all_m->getWhere($dbs . '.' . $table, $where);

            foreach ($grids as $r) {
                $json[] = array(
                    'sal_inv_no' => $r->sal_inv_no,
                    'id' => $r->id
                );
            }
        }
        if ($json !== null) {
            sort($json);
        }

        $this->json($json);
    }

    function spkcancel() {
        $stat = true;
        $post = $this->input->post();
        $spk = $this->all_m->getId('veh_spk', 'id', $post['id']);
        $spko = $this->all_m->getId('vehspko', 'so_no', $spk->so_no);
        $spkd = $this->all_m->getWhere('veh_spkd', array('so_no' => $spk->so_no));

        $veh_spk = (array) $spk;

        $sql = "SHOW COLUMNS FROM vehspkch";
        $vehspkch = $this->all_m->query_all($sql);

        foreach ($vehspkch as $spkch) {
            $field_spkch[$spkch->Field] = '';
        }
        unset($field_spkch['id']);

        foreach ($veh_spk as $k => $v) {

            if (array_key_exists($k, $field_spkch)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        /* data vehspkch */
        $newdata_spkch = array_combine($key, $val);
        $newdata_spkch['canc_by'] = $post['canc_by'];
        $newdata_spkch['canc_date'] = date('Y-m-d');
        $newdata_spkch['canc_note'] = $post['canc_note'];

        $check_dp = $this->all_m->countlimit('veh_dpcd', array('so_no' => $spk->so_no));

        // if ($check_dp > 0) {
        // $msg = array('success' => false, 'message' => 'Sorry, SPK No. ' . $spk->so_no . ' Not Cancellation');
        // } else {
        if (count($spkd) > 0) {
            //update vehspkcd
            foreach ($spkd as $pkd) {
                $copyspkd = array(
                    'canc_by' => $post['canc_by'],
                    'canc_date' => date('Y-m-d'),
                    'so_no' => $pkd->so_no,
                    'so_date' => $pkd->so_date,
                    'wk_code' => $pkd->wk_code,
                    'wk_desc' => $pkd->wk_desc,
                    'price_bd' => $pkd->price_bd,
                    'disc_pct' => $pkd->disc_pct,
                    'disc_val' => $pkd->disc_val,
                    'price_ad' => $pkd->price_ad,
                    'srep_code1' => $pkd->srep_code1,
                    'srep_name1' => $pkd->srep_name1,
                    'add_by' => $pkd->add_by,
                    'add_date' => $pkd->add_date,
                );
            }
            //save vehspkcd
            $this->all_m->insertData('vehspkcd', $copyspkd);
            //delete vehspkd 
            //$this->all_m->deleteData('veh_spkd', 'id', $pkd->id);
        }
        $newdata_spk = array();
        $newdata_spk['canc_by'] = $post['canc_by'];
        $newdata_spk['canc_date'] = date('Y-m-d');
        $newdata_spk['canc_note'] = $post['canc_note'];

        $this->all_m->insertData('vehspkch', $newdata_spkch);
        $this->all_m->updateData('veh_spk', 'id', $spk->id, $newdata_spk);
        $this->all_m->updateData('vehspko', 'so_no', $spk->so_no, $newdata_spk);
        //$this->all_m->deleteData('veh_spk', 'id', $spk->id);
        //$this->all_m->deleteData('vehspko', 'so_no', $spk->so_no);
        // $this->all_m->deleteData('veh_dpch', 'so_no', $spk->so_no);

        $msg = array('success' => true, 'message' => 'SPK No. ' . $spk->so_no . ' Cancellation Successfull');
        //}

        $this->json($msg);
    }

    function UJKwitcancel() {
        $post = $this->input->post();
        $slh = $this->all_m->getId('veh_slh', 'id', $post['id']);
        $veh_sld = $this->all_m->getWhere('veh_sld', array('sal_inv_no' => $slh->sal_inv_no));

        $tbl;
        $no;
        $date;
        $copysld = array();

        $veh_slh = (array) $slh;

        if ($post['form'] == 'uj') {
            $tbl = 'veh_sjch';
            $tbl2 = 'veh_sjcd';
            $no = 'sj_no';
            $date = 'sj_date';

            $copysld['sj_no'] = $slh->sj_no;
            $copysld['sj_date'] = $slh->sj_date;
        }
        if ($post['form'] == 'kwitansi') {
            $tbl = 'veh_kwch';
            $tbl2 = 'veh_kwcd';
            $no = 'kwit_no';
            $date = 'kwit_date';

            $copysld['kwit_no'] = $slh->kwit_no;
            $copysld['kwit_date'] = $slh->kwit_date;
        }

        $sql = "SHOW COLUMNS FROM $tbl";
        $veh_sjk = $this->all_m->query_all($sql);

        foreach ($veh_sjk as $sjk) {
            $field_sjk[$sjk->Field] = '';
        }
        unset($field_sjk['id']);

        foreach ($veh_slh as $k => $v) {

            if (array_key_exists($k, $field_sjk)) {
                $key[] = $k;
                $val[] = $v;
            }
        }

        /* data veh_sjch */
        $newdata = array_combine($key, $val);
        $newdata['canc_by'] = $post['canc_by'];
        $newdata['canc_date'] = date('Y-m-d');
        $newdata['canc_note'] = $post['canc_note'];

        $checksjk = $this->all_m->countlimit($tbl, array('sal_inv_no' => $slh->sal_inv_no, $no => $slh->$no));

        if ($checksjk == 0) {
            if (count($veh_sld) > 0) {
                foreach ($veh_sld as $sld) {

                    $copysld['canc_by'] = $post['canc_by'];
                    $copysld['canc_date'] = date('Y-m-d');


                    $copysld['sal_inv_no'] = $sld->sal_inv_no;
                    $copysld['sal_date'] = $sld->sal_date;

                    $copysld['pick_date'] = $sld->pick_date;
                    $copysld['wk_code'] = $sld->wk_code;
                    $copysld['wk_desc'] = $sld->wk_desc;
                    $copysld['price_bd'] = $sld->price_bd;
                    $copysld['disc_pct'] = $sld->disc_pct;
                    $copysld['disc_val'] = $sld->disc_val;
                    $copysld['price_ad'] = $sld->price_ad;
                    $copysld['srep_code1'] = $sld->srep_code1;
                    $copysld['srep_name1'] = $sld->srep_name1;
                    $copysld['add_by'] = $sld->add_by;
                    $copysld['add_date'] = $sld->add_date;
                    $copysld['pur_price'] = $sld->pur_price;
                    $copysld['so_no'] = $sld->so_no;
                    $copysld['so_date'] = $sld->so_date;
                    $copysld['wo_no'] = $sld->wo_no;
                    $copysld['wo_date'] = $sld->wo_date;
                    $copysld['pur_inv_no'] = $sld->pur_inv_no;
                    $copysld['rcv_date'] = $sld->rcv_date;
                    $copysld['det_status'] = $sld->det_status;

                    $this->all_m->insertData($tbl2, $copysld);
                }
            }

            $this->all_m->insertData($tbl, $newdata);
            $this->all_m->updateData('veh_slh', 'id', $slh->id, array($no => '', $date => '0000-00-00'));

            if ($post['form'] == 'uj') {
                $msg = array('success' => true, 'message' => 'DO (SJ) No. ' . $slh->sj_no . ' Cancellation Successfull');
            } else {
                $msg = array('success' => true, 'message' => 'Receipt No.. ' . $slh->kwit_no . ' Cancellation Successfull');
            }
        } else {
            $msg = array('success' => false, 'message' => 'Failed Cancellation');
        }
        $this->json($msg);
    }

}
