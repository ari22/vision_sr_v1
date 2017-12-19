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

    function read_user() {
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $id = $this->input->post('id');
        $form = $this->input->post('form');



        $user = $this->crud_mdl->read($table, $nav, $id);


        $userid = $user->id;
        $access = $this->all_m->getWhere('usr_access', array('userid' => $userid, 'type_form' => $form));

        foreach ($access as $ac) {
            $rows[] = array(
                'vw_' . $ac->alias_form => $ac->vw_form,
                'ed_' . $ac->alias_form => $ac->ed_form,
                'pr_' . $ac->alias_form => $ac->pr_form,
                'dl_' . $ac->alias_form => $ac->dl_form,
                'cl_' . $ac->alias_form => $ac->cl_form,
                'uc_' . $ac->alias_form => $ac->uc_form,
                'ut_' . $ac->alias_form => $ac->ut_form,
            );
        }
        $data = $this->array_flatten($rows);

        $data['username'] = $user->username;
        $data['userrole'] = $user->userrole;
        $data['wrhs_axs'] = $user->wrhs_axs;
        $data['wrhs_input'] = $user->wrhs_input;
        $data['curr_login'] = $user->curr_login;
        $data['lin_dtime'] = $user->lin_dtime;
        $data['lout_dtime'] = $user->lout_dtime;
        $data['useralias'] = $user->useralias;
        $data['id'] = $user->id;

        $this->json($data);
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

        $data_usr['username'] = $data['username'];
        $data_usr['useralias'] = $data['useralias'];
        $data_usr['userrole'] = $data['userrole'];
        $data_usr['wrhs_axs'] = $data['wrhs_axs'];
        $data_usr['wrhs_input'] = $data['wrhs_input'];
        $type_form = 'main';

        $data_access = array();


        if (!empty($data['vw_prtradd']) OR ! empty($data['ed_prtradd']) OR ! empty($data['pr_prtradd']) OR ! empty($data['dl_prtradd'])) {
            $data_access[] = $this->get_access($id, 'prtradd', $data['vw_prtradd'], $data['ed_prtradd'], $data['pr_prtradd'], $data['dl_prtradd'], 0, 0, 0);
        }


        if (!empty($data['vw_lkup_rl']) OR ! empty($data['ed_lkup_rl']) OR ! empty($data['pr_lkup_rl']) OR ! empty($data['dl_lkup_rl'])) {
            $data_access[] = $this->get_access($id, 'lkup_rl', $data['vw_lkup_rl'], $data['ed_lkup_rl'], $data['pr_lkup_rl'], $data['dl_lkup_rl'], 0, 0, 0);
        }


        if (!empty($data['vw_sinv']) OR ! empty($data['ed_sinv']) OR ! empty($data['pr_sinv']) OR ! empty($data['dl_sinv'])) {
            $data_access[] = $this->get_access($id, 'sinv', $data['vw_sinv'], $data['ed_sinv'], $data['pr_sinv'], $data['dl_sinv'], 0, 0, 0);
        }

        if (!empty($data['vw_pinv']) OR ! empty($data['ed_pinv']) OR ! empty($data['pr_pinv']) OR ! empty($data['dl_pinv'])) {
            $data_access[] = $this->get_access($id, 'pinv', $data['vw_pinv'], $data['ed_pinv'], $data['pr_pinv'], $data['dl_pinv'], 0, 0, 0);
        }

        if (!empty($data['vw_usr_axs']) OR ! empty($data['ed_usr_axs']) OR ! empty($data['pr_usr_axs']) OR ! empty($data['dl_usr_axs'])) {
            $data_access[] = $this->get_access($id, 'usr_axs', $data['vw_usr_axs'], $data['ed_usr_axs'], $data['pr_usr_axs'], $data['dl_usr_axs'], 0, 0, 0);
        }

        if (!empty($data['vw_setform']) OR ! empty($data['ed_setform']) OR ! empty($data['pr_setform']) OR ! empty($data['dl_setform'])) {
            $data_access[] = $this->get_access($id, 'setform', $data['vw_setform'], $data['ed_setform'], $data['pr_setform'], $data['dl_setform'], 0, 0, 0);
        }

        if (!empty($data['ut_setup'])) {
            $data_access[] = $this->get_access($id, 'setup', 0, 0, 0, 0, 0, 0, $data['ut_setup']);
        }

        if (!empty($data['ut_settrvn'])) {
            $data_access[] = $this->get_access($id, 'settrvn', 0, 0, 0, 0, 0, 0, $data['ut_settrvn']);
        }

        if (!empty($data['vw_setfpno']) OR ! empty($data['ed_setfpno']) OR ! empty($data['pr_setfpno']) OR ! empty($data['dl_setfpno'])) {
            $data_access[] = $this->get_access($id, 'setfpno', $data['vw_setfpno'], $data['ed_setfpno'], $data['pr_setfpno'], $data['dl_setfpno'], 0, 0, 0);
        }

        if (!empty($data['vw_setvgl']) OR ! empty($data['ed_setvgl']) OR ! empty($data['pr_setvgl']) OR ! empty($data['dl_setvgl'])) {
            $data_access[] = $this->get_access($id, 'setvgl', $data['vw_setvgl'], $data['ed_setvgl'], $data['pr_setvgl'], $data['dl_setvgl'], 0, 0, 0);
        }

        if (!empty($data['ut_mth_cls'])) {
            $data_access[] = $this->get_access($id, 'mth_cls', 0, 0, 0, 0, 0, 0, $data['ut_mth_cls']);
        }

        if (!empty($data['ut_backup'])) {
            $data_access[] = $this->get_access($id, 'backup', 0, 0, 0, 0, 0, 0, $data['ut_backup']);
        }

        if (!empty($data['ut_restore'])) {
            $data_access[] = $this->get_access($id, 'restore', 0, 0, 0, 0, 0, 0, $data['ut_restore']);
        }

        if (!empty($data['ut_reindex'])) {
            $data_access[] = $this->get_access($id, 'reindex', 0, 0, 0, 0, 0, 0, $data['ut_reindex']);
        }

        if (!empty($data['ut_import'])) {
            $data_access[] = $this->get_access($id, 'import', 0, 0, 0, 0, 0, 0, $data['ut_import']);
        }

        if (!empty($data['ut_usr_log'])) {
            $data_access[] = $this->get_access($id, 'usr_log', 0, 0, 0, 0, 0, 0, $data['ut_usr_log']);
        }

        //print_r($data_access);exit;
        if ($data['wrhs_input'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Masukkan Default Warehouse ketika diinput User ini');
        }
        if ($data['wrhs_axs'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Masukkan Warehouse dimana User berada');
        }
        if ($data['username'] == '') {
            $stat = false;
            $msg = array('success' => false, 'message' => ' Masukkan Username');
        }



        if ($id == '') {
            $checkuser = $this->all_m->countlimit($table, array('username' => $data['username']));

            if ($checkuser > 0) {
                $stat = false;
                $msg = array('success' => false, 'message' => ' Username sudah ada!');
            }
        }

        if ($stat !== false) {

            if ($id !== '') {
                $this->all_m->updateData($table, 'id', $id, $data_usr);

                $accUser = $this->all_m->getWhere('usr_access', array('userid' => $id, 'type_form' => 'main'));

                foreach ($accUser as $dlacc) {
                    $this->all_m->deleteData('usr_access', 'id', $dlacc->id);
                }
                foreach ($data_access as $access) {

                    $acc = array(
                        'alias_form' => $access['alias_form'],
                        'type_form' => $type_form,
                        'vw_form' => $access['vw_form'],
                        'ed_form' => $access['ed_form'],
                        'pr_form' => $access['pr_form'],
                        'dl_form' => $access['dl_form'],
                        'cl_form' => $access['cl_form'],
                        'uc_form' => $access['uc_form'],
                        'ut_form' => $access['ut_form'],
                        'userid' => $access['userid'],
                    );

                    $this->all_m->insertData('usr_access', $acc);
                }

                $msg = array('success' => true, 'message' => 'Record updated ', 'status' => 'update');
            } else {

                $this->all_m->insertData($table, $data_usr);
                $user = $this->all_m->getOne($table, $data_usr);

                foreach ($data_access as $access) {
                    $acc = array(
                        'alias_form' => $access['alias_form'],
                        'type_form' => $type_form,
                        'vw_form' => $access['vw_form'],
                        'ed_form' => $access['ed_form'],
                        'pr_form' => $access['pr_form'],
                        'dl_form' => $access['dl_form'],
                        'cl_form' => $access['cl_form'],
                        'uc_form' => $access['uc_form'],
                        'ut_form' => $access['ut_form'],
                        'userid' => $access['userid'],
                    );

                    $this->all_m->insertData('usr_access', $acc);
                }


                $msg = array('success' => true, 'message' => 'Record saved', 'status' => 'save');
            }
        }

        $this->json($msg);
    }

    function deleteUser() {
        $tbl = $this->input->post('table');
        $id = $this->input->post('id');

        $user = $this->all_m->getId($tbl, 'id', $id);
        $iduser = $user->id;

        $access = $this->all_m->getWhere('usr_access', array('userid' => $iduser));

        $check_access = $this->all_m->countlimit('usr_access', array('type_form' => 'mst', 'userid' => $iduser));

        if ($check_access > 0) {
            $msg = array('success' => false, 'message' => 'Record ini ada detail User Access Kendaraan.Silahakan detailnya dihapus');
        }

        if ($msg['success'] !== false) {
            $this->all_m->deleteData($tbl, 'id', $id);

            foreach ($access as $acc) {
                $this->all_m->deleteData('usr_access', 'id', $acc->id);
            }
            $msg = array('success' => true, 'message' => 'success');
        } else {
            $msg = $msg;
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

}

?>