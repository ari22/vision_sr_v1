<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(0);
date_default_timezone_set("Asia/Jakarta");

class Setting extends Application {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('crud_mdl', 'all_m'));
    }

    function read_access() {
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        $user = $this->input->post('user');

        $where = array('username' => $user);
        $read = $this->crud_mdl->read($table, $nav, $id, $where);

        $this->json($read);
    }

    function array_flatten($array) {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, $this->array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    function saveUser() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        $stat = true;

        if ($data['wrhs_input'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input this user\'s Default Input');
        }
        if ($data['wrhs_axs'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input User\'s Warehouse ');
        }
        if ($data['username'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input Username');
        }

        if ($id == '') {
            $checkuser = $this->all_m->countlimit($table, array('username' => $data['username']));

            if ($checkuser > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Username has been used');
            }
        }

        if ($stat !== false) {

            if ($id !== '') {
                $user = $this->all_m->getId($table, 'id', $id);
                $data['curr_login'] = $users->curr_login;
                $data['lin_dtime'] = $user->lin_dtime;
                $data['lout_dtime'] = $user->lout_dtime;
                $data['passwd'] = $user->passwd;


                $dataupdate = array(
                    'vw_prtradd' => 0,
                    'ed_prtradd' => 0,
                    'pr_prtradd' => 0,
                    'dl_prtradd' => 0,
                    'vw_lkup_rl' => 0,
                    'ed_lkup_rl' => 0,
                    'pr_lkup_rl' => 0,
                    'dl_lkup_rl' => 0,
                    'vw_sinv' => 0,
                    'ed_sinv' => 0,
                    'pr_sinv' => 0,
                    'dl_sinv' => 0,
                    'vw_pinv' => 0,
                    'ed_pinv' => 0,
                    'pr_pinv' => 0,
                    'dl_pinv' => 0,
                    'vw_usr_axs' => 0,
                    'ed_usr_axs' => 0,
                    'dl_usr_axs' => 0,
                    'vw_setform' => 0,
                    'ed_setform' => 0,
                    'pr_setform' => 0,
                    'dl_setform' => 0,
                    'ut_setup' => 0,
                    'ut_settrvn' => 0,
                    'vw_setfpno' => 0,
                    'ed_setfpno' => 0,
                    'vw_setvgl' => 0,
                    'ed_setvgl' => 0,
                    'pr_setvgl' => 0,
                    'dl_setvgl' => 0,
                    'ut_mth_cls' => 0, 'ut_backup' => 0, 'ut_restore' => 0, 'ut_reindex' => 0, 'ut_import' => 0, 'ut_usr_log' => 0
                );
                //$this->all_m->deleteData($table, 'id', $id);
                $this->all_m->updateData($table, 'id', $id, $dataupdate);
                $this->all_m->updateData($table, 'id', $id, $data);

                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $data['passwd'] = strtr(base64_encode('password'), '+/', '-_');

                $this->all_m->insertData($table, $data);
                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function saveAccess() {

        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        unset($data['vw_prtapg']);
        unset($data['ed_prtapg']);
        unset($data['pr_prtapg']);
        unset($data['dl_prtapg']);
        unset($data['xp_prtapg']);

        unset($data['vw_vehapg']);
        unset($data['ed_vehapg']);
        unset($data['pr_vehapg']);
        unset($data['dl_vehapg']);

        unset($data['vw_veharg']);
        unset($data['ed_veharg']);
        unset($data['pr_veharg']);
        unset($data['dl_veharg']);

        unset($data['vw_mparts2']);
        unset($data['pr_mparts2']);
        unset($data['xp_mparts2']);

        unset($data['vw_vehspk2']);
        unset($data['pr_vehspk2']);
        unset($data['cn_vehspk2']);
        unset($data['xp_vehspk2']);
        
        unset($data['vw_vehdpsg']);
        unset($data['ed_vehdpsg']);
        unset($data['pr_vehdpsg']);
        unset($data['dl_vehdpsg']);


        if ($id !== '') {
            $this->all_m->deleteData($table, 'id', $id);
            $this->all_m->insertData($table, $data);

            $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        } else {

            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        }

        $this->json($msg);
    }

    function deleteUser() {
        $stat = true;
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $user = $this->all_m->getId($tbl, 'id', $id);

        if (!empty($this->input->post('table2'))) {
            $tbl2 = $this->input->post('table2');
            $this->all_m->deleteData($tbl2, 'username', $user->username);
            $msg = array('success' => true, 'message' => 'success');
        } else {
            $check_veh = $this->all_m->countlimit('usr_veh', array('username' => $user->username));
            $check_veh2 = $this->all_m->countlimit('usr_veh2', array('username' => $user->username));
            $check_acc = $this->all_m->countlimit('usr_acc', array('username' => $user->username));

            if ($check_veh > 0) {
                $stat = false;
            }
            if ($check_veh2 > 0) {
                $stat = false;
            }
            if ($check_acc > 0) {
                $stat = false;
            }

            if ($stat !== false) {
                $this->all_m->deleteData($tbl, 'id', $id);
                $msg = array('success' => true, 'message' => 'success');
            } else {
                $msg = array('success' => false, 'message' => 'Sorry, this User cannot be deleted because it has access detail(s). Please delete them first');
            }
        }

        $this->json($msg);
    }

    function get_access($userid, $alias_form, $vw, $ed, $pr, $dl, $cl, $uc, $ut) {
        $access = array(
            'alias_form' => $alias_form,
            'vw_form' => $vw,
            'ed_form' => $ed,
            'pr_form' => $pr,
            'dl_form' => $dl,
            'cl_form' => $cl,
            'uc_form' => $uc,
            'ut_form' => $ut,
            'userid' => $userid
        );

        return $access;
    }

    function saveClone() {

        $post = $this->input->post();
        $stat = true;

        if ($post['n_password'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input Password for this new User');
        }
        if ($post['n_username'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please input new Username');
        }
        if ($post['c_username'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Please choose a username to clone');
        }
        
        if ($id == '') {
            $checkuser = $this->all_m->countlimit('usr', array('username' => $post['n_username']));

            if ($checkuser > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Username has been used');
            }
        }
        
        if ($stat !== false) {
            $sql = "SELECT * from usr usr left join usr_veh veh on usr.username=veh.username left join usr_veh2 veh2 on usr.username=veh2.username left join usr_acc acc on usr.username=acc.username where usr.username='" . $post['c_username'] . "' ";
            $data = (array) $this->all_m->query_single($sql);
            unset($data['id']);
            unset($data['lin_dtime']);
            unset($data['lout_dtime']);
            unset($data['curr_login']);

            $data['username'] = $post['n_username'];
            $data['useralias'] = $post['n_username'];
            //$data['passwd'] = md5(hash("haval256,5", '12336', $post['n_password']));
            $data['passwd'] = strtr(base64_encode($post['n_password']), '+/', '-_');

            $usr = "SHOW COLUMNS FROM usr";
            $usr = $this->all_m->query_all($usr);

            foreach ($usr as $u) {
                $field_usr[$u->Field] = '';
            }
            unset($field_usr['id']);

            foreach ($data as $k => $v) {

                if (array_key_exists($k, $field_usr)) {
                    $key[] = $k;
                    $val[] = $v;
                }
            }


            $usr_veh = "SHOW COLUMNS FROM usr_veh";
            $usr_veh = $this->all_m->query_all($usr_veh);

            foreach ($usr_veh as $veh) {
                $field_veh[$veh->Field] = '';
            }
            unset($field_veh['id']);

            foreach ($data as $k2 => $v2) {

                if (array_key_exists($k2, $field_veh)) {
                    $key2[] = $k2;
                    $val2[] = $v2;
                }
            }

            $usr_veh2 = "SHOW COLUMNS FROM usr_veh2";
            $usr_veh2 = $this->all_m->query_all($usr_veh2);

            foreach ($usr_veh2 as $veh2) {
                $field_veh2[$veh2->Field] = '';
            }
            unset($field_veh2['id']);

            foreach ($data as $k3 => $v3) {

                if (array_key_exists($k3, $field_veh2)) {
                    $key3[] = $k3;
                    $val3[] = $v3;
                }
            }

            $usr_acc = "SHOW COLUMNS FROM usr_acc";
            $usr_acc = $this->all_m->query_all($usr_acc);

            foreach ($usr_acc as $acc) {
                $field_acc[$acc->Field] = '';
            }
            unset($field_acc['id']);

            foreach ($data as $k4 => $v4) {

                if (array_key_exists($k4, $field_acc)) {
                    $key4[] = $k4;
                    $val4[] = $v4;
                }
            }

            $newdata_usr = array_combine($key, $val);
            $newdata_veh = array_combine($key2, $val2);
            $newdata_veh2 = array_combine($key3, $val3);
            $newdata_acc = array_combine($key4, $val4);

            $this->all_m->insertData('usr', $newdata_usr);
            $this->all_m->insertData('usr_veh', $newdata_veh);
            $this->all_m->insertData('usr_veh2', $newdata_veh2);
            $this->all_m->insertData('usr_acc', $newdata_acc);

            $msg = array('success' => true, 'message' => 'User has been cloned successfully', 'status' => 'save');
        }

        $this->json($msg);
    }

    function saveSet_form() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $data = $this->input->post();

        unset($data['table']);
        unset($data['id']);

        if ($id !== '') {

            $count = $this->all_m->countlimit('vehsjitm', array('id' => $id));

            if ($count > 0) {
                $this->all_m->updateData($table, 'id', $id, $data);
                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {
                $data['id'] = 1;
                $this->all_m->insertData($table, $data);
                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $data['id'] = 1;
            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        }

        $this->json($msg);
    }

    function deleteSet_form() {
        $stat = true;
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        if ($stat !== false) {
            $this->all_m->deleteData($tbl, 'id', $id);
            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = array('success' => false, 'message' => 'Failed');
        }

        $this->json($msg);
    }

    function saveResetInvoice() {
        $data = $this->input->post();
        $tbl = $data['table'];
        $id = $data['id'];

        $inv_seq = $this->all_m->getId($tbl, 'id', $id);


        if ($data['inv_mth'] == $inv_seq->inv_mth && $data['inv_year'] == $inv_seq->inv_year) {
            
        } else {
            $update = array(
                'inv_mth' => $data['inv_mth'],
                'inv_year' => $data['inv_year'],
                'inv_no' => 0
            );
            $this->all_m->updateData($tbl, 'id', $id, $update);
        }

        $msg = array('success' => true, 'message' => 'Finish');
        $this->json($msg);
    }

    function saveSystem() {
        $data = $this->input->post();

        $table = 'ssystem';
        $id = $data['id'];

        if ($data['comp_stamp'] == '') {
            $data['comp_stamp'] = 0;
        }
        if ($data['comp_stmpp'] == '') {
            $data['comp_stmpp'] = 0;
        }

        unset($data['id']);

        if ($id !== '') {
            $this->all_m->updateData($table, 'id', $id, $data);
            $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
        }

        $this->json($msg);
    }

    function save_vglh() {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data = $this->input->post();
        $user = $this->uri->segment(4);
        $c_code = $this->uri->segment(5);

        unset($data['id']);
        unset($data['table']);

        $stat = true;
        $check1 = $this->all_m->countlimit($table, $data);

        if ($check1 > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, unable to save data because it has already exist');
            $stat = false;
        }

        if ($stat !== false) {
            $data['add_by'] = $user;
            $data['add_date'] = date('Y-m-d');
            $data['comp_code'] = $c_code;

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
                $this->all_m->insertData($table, $data);
                array('success' => true, 'message' => 'Record saved', 'status' => 'save');
                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        } else {
            $msg = $msg;
        }

        $this->json($msg);
    }

    function deleteVglh() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $vglh = $this->all_m->getId($tbl, 'id', $id);

        $stat = true;
        //echo $vglh->trx_code; exit;
        $check = $this->all_m->countlimit('set_vgld', array('inv_div' => $vglh->inv_div, 'trx_code' => $vglh->trx_code, 'wrhs_code' => $vglh->wrhs_code));

        if ($check > 0) {
            $stat = false;
            $msg = array('success' => false, 'message' => 'Sorry, this data cannot be deleted because it has detail(s). Please delete them first');
        }


        if ($stat !== false) {
            $this->all_m->deleteData($tbl, 'id', $id);

            $check2 = $this->all_m->countlimit($tbl, array('id' => $id));

            if ($check2 > 0) {
                $msg = array('success' => false, 'message' => 'Delete failed');
            } else {
                $msg = array('success' => true, 'message' => 'Delete success');
            }
        } else {
            $msg = $msg;
        }
        $this->json($msg);
    }

    function save_vgld() {
        $table = $this->input->post('table2');
        $id = $this->input->post('id2');
        $data = $this->input->post();

        $inv_div = $this->uri->segment(4);
        $trx_code = $this->uri->segment(5);
        $user = $this->uri->segment(6);
        $wrhs_code = $this->uri->segment(7);
        $comp_code = $this->uri->segment(8);

        unset($data['table2']);
        unset($data['id2']);

        $data['inv_div'] = $inv_div;
        $data['trx_code'] = $trx_code;
        $data['wrhs_code'] = $wrhs_code;
        $data['comp_code'] = $comp_code;
        $data['add_by'] = $user;
        $data['add_date'] = date('Y-m-d');


        $check = $this->all_m->countlimit($table, array('inv_div' => $inv_div, 'trx_code' => $trx_code, 'trx_scode' => $data['trx_scode'], 'wrhs_code' => $wrhs_code));

        if ($check > 0) {
            $msg = array('success' => false, 'message' => 'Sorry, data cannot be saved because it has been used in this invoice');
        } else {

            $this->all_m->insertData($table, $data);
            $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
        }

        $this->json($msg);
    }

    function delete_vgld() {
        $table = $this->input->post('table');
        $id = $this->input->post('id');

        $data = $this->all_m->getId($table, 'id', $id);

        $stat = false;

        $check = $this->all_m->countlimit($table, array('id' => $id));

        if ($check > 0) {
            $stat = true;
        }

        if ($stat !== false) {

            $this->all_m->deleteData($table, 'id', $id);
            $msg = array('status' => true, 'message' => 'Detail has been deleted successfully');
        } else {
            $msg = array('status' => false, 'message' => 'Failed to delete detail');
        }

        $this->json($msg);
    }

    function handlePad() {
        $this->model->input();
    }

    function refreshInvNo() {
        $post = $this->input->post();
        $id = $post['id'];
        $table = $post['table'];
        $inv_type = $post['inv_type'];
        $inv_mth = $post['inv_mth'];
        $inv_year = $post['inv_year'];
        
        $stat = true;
                
        $month = $inv_mth;
        $lenmth = strlen($inv_mth);

        if ($lenmth == 1) {
            $int = 0;
            $month = $int . $inv_mth;
        }

        $year = substr($inv_year, 2);
        $inv_no = $year . $month;

        $priod = $inv_year . $month;
        $periodnow = strtotime(date('Ym'));
        $priod_set = strtotime($priod);
        
        $setTable = $this->setFieldTable($inv_type);
        $field = $setTable['field'];
        $tblsel = $setTable['table'];

        $data = $this->all_m->query_all("SELECT $field FROM $tblsel WHERE $field LIKE '%$inv_no%'");

        if(count($data) < 1){
            $stat = false;
            $msg = array('success' => false, 'message' => 'No Invoice No., in the period your choose');
        }
        if (intval($priod_set) > intval($periodnow)) {
            $stat = false;
             $msg = array('success' => false, 'message' => 'period should not exceed the current period now');
        }

        if ($stat !== false) {


            foreach ($data as $row) {
                $exp = explode('-', $row->$field);

                $numbers[] = $exp[1];
            }

            $max = max($numbers);

            $newinvno = substr($max, 4);

            $dataupdate = array(
                'inv_mth' => $inv_mth,
                'inv_year' => $inv_year,
                'inv_no' => $newinvno
            );

            $this->all_m->updateData($table, 'id', $id, $dataupdate);
            $msg = array('success' => true, 'message' => 'Success refresh Set Invoice No.');
        }
        
        $this->json($msg);
    }

    function setFieldTable($inv = null) {

        switch ($inv) {
            case 'VSL':
                $table = 'veh_slh';
                break;

            case 'VRS':
                $table = 'veh_rslh';
                break;
            case 'VRP':
                $table = 'veh_rprh';
                break;
            case 'VPR':
                $table = 'veh_prh';
                break;
            case 'VMV':
                $table = 'veh_movh';
                break;
            case 'VPO':
                $table = 'veh_po';
                break;
            case 'ARC':
                $table = 'acc_rslh';
                break;
            case 'ARP':
                $table = 'acc_rprh';
                break;
            case 'AMV':
                $table = 'acc_movh';
                break;
            case 'ASC':
                $table = 'acc_slh';
                break;
            case 'APR':
                $table = 'acc_prh';
                break;
            case 'ASA':
                $table = 'acc_slh';
                break;
            case 'APO':
                $table = 'acc_poh';
                break;
            case 'AOP':
                $table = 'acc_opnh';
                break;
            case 'ABW':
                $table = 'veh_bwoh ';
                break;
            case 'APB':
                $table = 'veh_bprh';
                break;
            case 'VDM':
                $table = 'veh_doc';
                break;
            case 'AWO':
                $table = 'veh_apvh';
                break;
            case 'VRG':
                $table = 'veh_argh';
                break;
            case 'VDC':
                $table = 'veh_dpch';
                break;
            case 'VPG':
                $table = 'veh_apgh';
                break;
            case 'VRD':
                $table = 'vehdpcch';
                break;
            case 'APG':
                $table = 'acc_apgh';
                break;
            case 'AWO':
                $table = 'acc_woh';
                break;
            case 'APW':
                $table = 'acc_wprh';
                break;
            case 'AWR':
                $table = 'acc_worh';
                break;
            case 'ASW':
                $table = 'acc_wslh';
                break;
            case 'APR':
                $table = 'acc_wprh';
                break;
        }

        $sql = "SHOW COLUMNS FROM $table";
        $fields = $this->all_m->query_all($sql);

        foreach ($fields as $k => $r) {
            $rows[] = $r->Field;
        }

        $field = $rows[1];

        $data = array(
            'table' => $table,
            'field' => $field
        );
        return $data;
    }

}

?>