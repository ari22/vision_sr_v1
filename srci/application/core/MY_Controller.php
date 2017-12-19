<?php

class Application extends CI_Controller {

    public function __construct() {
        parent::__construct();
        log_message('debug', 'Application Loaded');

        $this->content['controller'] = $this->router->fetch_class();
        $this->content['title'] = 'Vision Showroom';
        $this->content['app'] = $this;
    }

    function json($res) {
        echo json_encode($res);
    }

    function output_pdf($title = null, $html = null, $filename = null, $action, $margin = null, $font = null) {
        if ($font !== null) {
            $font = $font;
        } else {
            $font = 'helvetica';
        }

        $html = $html;
        $html .= '<style>
                    .tables {
                                    margin-bottom:20px !important;
                                    color: black;
                                    font-family: ' . $font . ';
                                    font-size: 7.5pt;
                                    
                                    margin-bottom:20px;
                                    padding:3pt;
                          }
                    .tables th{font-size:9pt;font-weight:bold !important;}
                    .tables td{padding-top:10px !important;padding-bottom:10px !important;}
                    
                    .center{text-align:center;}
                    .right{text-align:right;}
                    span.right{text-align:right; border:1px solid red;}
                    .td-ro{width:10px;}
                    .td-title{width:100px;font-weight:bold;}
                    .bold{font-weight:bold;} 
                    p{font-size: 7.5pt;}
                    h1{font-size: 10pt;margin-bottom:100px !important;}
                    hr{background:#000;}
                </style>';

        $this->load->library('Pdf');

        //$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTitle($title);

        if ($margin !== null) {
            $pdf->AddPage($margin, 'A4');
        } else {
            $pdf->AddPage('A4');
        }

        //$pdf->writeHTML($html, true, false, true, false, '');
        $pdf->writeHTML($html, true, 0, true, 0);
        $pdf->lastPage();

        if ($action == 'screen') {
            //$pdf->SetProtection(array('print','annot-forms','modify','copy'),'1','1');
            $pdf->Output($filename . '.pdf', 'I');
        } else {
            $js = 'print(true);';

            // set javascript
            $pdf->IncludeJS($js);
            $pdf->Output($filename . '.pdf', 'I');
        }
    }

    function get_number($code = null) {
        if ($code == null) {
            $code = $this->uri->segment(4);
        } else {
            $code = $code;
        }

        $number = $this->all_m->inv_seq('4', $code);
        $this->output->set_output($number);
    }

    function get_price() {
        $code = $this->input->post('code');
        $type = $this->input->post('type');

        $price = $this->all_m->getOne('veh_prc', array('veh_code' => $code, 'col_type' => $type));
        $this->json($price);
    }

    function explodeDate($date) {
        $b_date = explode('/', $date);
        $b_date = $b_date[2] . '-' . $b_date[0] . '-' . $b_date['1'];
        return $b_date;
    }

    function dateFormat($date) {
        /* $date = date_create($date);
          $date = date_format($date, 'Y-m-d');

          return $date; */
        $b_date = explode('/', $date);
        //$b_date = $b_date[2] . '-' . $b_date[0] . '-' . $b_date[1];
        $b_date = $b_date[2] . '-' . $b_date[1] . '-' . $b_date[0];
        return $b_date;
    }

    function dateView($in_date) {
        $out_date = '';

        if ($in_date != '0000-00-00') {
            $out_date = date_create($in_date);
            $out_date = date_format($out_date, "d/m/Y");
        }
        return $out_date;
    }

    function updateLocked($table, $id) {
        $update = $this->all_m->updateData($table, 'id', $id, array('locked_by' => '', 'locked_date' => '0000-00-00'));
        return true;
    }

    function set_form($code, $read = null) {
        $set_form = $this->all_m->getId('set_form', 'form_code', $code);

        $html .= '<table  class="tables">';
        $html .= '<tr>'
                . '<td>'
                . '<table class="tables">'
                . '<tr><td>' . $set_form->inote1 . '</td></tr>'
                . '<tr><td>' . $set_form->inote2 . '</td></tr>'
                . '<tr><td>' . $set_form->inote3 . '</td></tr>'
                . '<tr><td>' . $set_form->inote4 . '</td></tr>'
                . '<tr><td>' . $set_form->inote5 . '</td></tr>'
                . '</table>'
                . '</td>'
                . '<td>'
                . '<table class="tables">'
                . '<tr><td>' . $set_form->enote1 . '</td></tr>'
                . '<tr><td>' . $set_form->enote2 . '</td></tr>'
                . '<tr><td>' . $set_form->enote3 . '</td></tr>'
                . '<tr><td>' . $set_form->enote4 . '</td></tr>'
                . '<tr><td>' . $set_form->enote5 . '</td></tr>'
                . '</table>'
                . '</td>'
                . '</tr>';

        $html .= '<tr><td>'
                . '<table class="tables" style="width:500px;">'
                . '<tr><td width="25%" align="center"><b>' . $set_form->sign1 . '</b></td><td width="25%"  align="center"><b>' . $set_form->sign2 . '</b></td><td width="25%"  align="center"><b>' . $set_form->sign3 . '</b></td><td width="25%"  align="center"><b>' . $set_form->sign4 . '</b></td></tr>'
                . '<tr><td width="25%" align="center"><b>' . $set_form->esign1 . '</b></td><td width="25%"  align="center"><b>' . $set_form->esign2 . '</b></td><td width="25%"  align="center"><b>' . $set_form->esign3 . '</b></td><td width="25%"  align="center"><b>' . $set_form->esign4 . '</b></td></tr>'
                . '<tr><td><br /><br /><br /><br /></td></tr>';

        $html .= '<tr>';

        $name1 = $set_form->name1;

        if ($read !== null) {
            if ($code == 'AOPN') {
                $name1 = $read->oprep_name;
            }
        }

        $date1 = '';
        $date2 = '';
        $date3 = '';
        $date4 = '';

        if ($set_form->sign1 !== '' || $set_form->esign1 !== '') {
            $date1 = 'Tgl : / /';
            $html .= '<td width="25%"><table class="tables" width="100%"><tr><td width="10">(</td><td align="center" width="100" style="border-bottom:1px dotted black;">' . $name1 . '</td><td align="right"  width="10">)</td></tr></table></td>';
        } else {
            $html .= '<td align="center">' . $name1 . '</td>';
        }

        if ($set_form->sign2 !== '' || $set_form->esign2 !== '') {
            $date2 = 'Tgl : / /';
            $html .= '<td width="25%"><table class="tables" width="100%"><tr><td width="10">(</td><td align="center" width="100" style="border-bottom:1px dotted black;">' . $set_form->name2 . '</td><td align="right"  width="10">)</td></tr></table></td>';
        } else {
            $html .= '<td align="center">' . $set_form->name2 . '</td>';
        }

        if ($set_form->sign3 !== '' || $set_form->esign3 !== '') {
            $date3 = 'Tgl : / /';
            $html .= '<td width="25%"><table class="tables" width="100%"><tr><td width="10">(</td><td align="center" width="100" style="border-bottom:1px dotted black;">' . $set_form->name3 . '</td><td align="right"  width="10">)</td></tr></table></td>';
        } else {
            $html .= '<td align="center">' . $set_form->name3 . '</td>';
        }

        if ($set_form->sign4 !== '' || $set_form->esign4 !== '') {
            $date4 = 'Tgl : / /';
            $html .= '<td width="25%"><table class="tables" width="100%"><tr><td width="10">(</td><td align="center" width="100" style="border-bottom:1px dotted black;">' . $set_form->name4 . '</td><td align="right"  width="10">)</td></tr></table></td>';
        } else {
            $html .= '<td align="center">' . $set_form->name4 . '</td>';
        }
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td align="center">' . $set_form->title1 . '</td>';
        $html .= '<td align="center">' . $set_form->title2 . '</td>';
        $html .= '<td align="center">' . $set_form->title3 . '</td>';
        $html .= '<td align="center">' . $set_form->title4 . '</td>';
        $html .= '</tr>';

        if ($code == 'VDO') {
            $html .= '<tr>';
            $html .= '<td align="center">' . $date1 . '</td>';
            $html .= '<td align="center">' . $date2 . '</td>';
            $html .= '<td align="center">' . $date3 . '</td>';
            $html .= '<td align="center">' . $date4 . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table></td></tr>';

        $html .= '</table>';

        return $html;
    }

    function vat($val) {
        $vat = 0;
        $ssystem = $this->all_m->getId('ssystem', 'id', 1);

        $ppn = intval($ssystem->ppn);

        if ($ppn !== 0) {
            $vat = ($val / 100) * $ppn;
        }

        return $vat;
    }

    function checkPeriode() {
        $res = 'true';

        $ssystem = $this->all_m->getId('ssystem', 'id', 1);

        $periode = $ssystem->tahun . '-' . $ssystem->bulan . '-01';


        if (intval(strtotime(date('Y-m-d'))) < intval(strtotime($periode))) {
            $res = 'false';
        }

        return $res;
    }

    function msgNotClose() {
        $msg = array('success' => false, 'message' => 'Sorry, Invoice can not be closed before the current period ');
        return $msg;
    }

    function msgNotUnClose() {
        $msg = array('success' => false, 'message' => 'Sorry, Invoice can not be unclosed before the current period ');
        return $msg;
    }

    function checkPrnCnt($tbl, $id) {
        $data = $this->all_m->getId($tbl, 'id', $id);

        if ($data->prn_cnt > 0) {
            $res = array('status' => false, 'msg' => 'Faktur Sudah Pernah dicetak');
        } else {
            $res = array('status' => true, 'msg' => 'Faktur Belum Pernah dicetak');
        }
        return $res;
        //$res = $this->all_m->updateData($tbl, 'id', $id, $data);
    }

    function count_prnt($data, $c_array, $prn_cnt) {
        $row = $this->all_m->getId($data['tbl'], 'id', $data['id']);
        $count = intval($row->$prn_cnt) + 1;

        if ($data['tbl'] == 'veh_arh') {
            $slh = $this->all_m->getId('veh_slh', 'sal_inv_no', $row->sal_inv_no);
            $count = intval($slh->$prn_cnt) + 1;

            $data['tbl'] = 'veh_slh';
            $data['id'] = $slh->id;
        }

        $table = $data['tbl'];
        /*
          switch ($table) {
          case 'veh_ard':
          break;
          case 'veh_dpcd':
          break;

          default:
          $c_array[$prn_cnt] = $count;
          $this->all_m->updateData($data['tbl'], 'id', $data['id'], $c_array);
          break;
          } */
        $c_array[$prn_cnt] = $count;
        $this->all_m->updateData($data['tbl'], 'id', $data['id'], $c_array);
    }

    function checkRunMonthYear() {
        $inv_type = $this->input->post('inv_type');
        $inv_seq = $this->all_m->getId('inv_seq', 'inv_type', $inv_type);
        $inv_year = $inv_seq->inv_year;
        $inv_mth = $inv_seq->inv_mth;

        $lenmth = strlen($inv_mth);

        $month = $inv_mth;

        if ($lenmth == 1) {
            $int = 0;
            $month = $int . $inv_mth;
        }

        $priod = $inv_year . $month;
        $periodnow = strtotime(date('Ym'));
        $periodsave = strtotime($priod);

        $stat = true;
        $msg = '';

        if (intval($periodnow) > intval($periodsave)) {
            $stat = false;
            $msg = 'Change Year / Month Invoice from ' . $inv_year . '/' . $month . ' to ' . date('Y/m');
        }

        $msg = array('status' => $stat, 'message' => $msg);

        $this->json($msg);
    }

    function UpdateMonthYear() {
        $inv_type = $this->input->post('inv_type');
        $inv_seq = $this->all_m->getId('inv_seq', 'inv_type', $inv_type);

        $month = date('m');

        if ($lenmth == 1) {
            $int = 0;
            $month = $int . $inv_mth;
        }

        $data['inv_year'] = date('Y');
        $data['inv_mth'] = date('n');
        $data['inv_no'] = 0;

        $this->all_m->updateData('inv_seq', 'id', $inv_seq->id, $data);
    }

    function viewPrnCnt($data) {
        $user = $data['user'];
        $cnt = $data['prn_cnt'];
        $action = $data['action'];

        if ($action !== 'screen') {
            $cnt = $data['prn_cnt'] + 1;
        }

        if ($data['prn_cnt'] == 0) {
            $cnt = 1;
        }

        $tbl = '';
        $tbl .='<tr><td colspan="3">';
        $tbl .='<table>';
        $tbl .='<tr>';
        //$tbl .='<td width="50">Dicetak Oleh</td><td class="td-ro">:</td><td>'.$user.' (#'.$cnt.')</td>';
        $tbl .='<td>Dicetak Oleh : ' . $user . ' (#' . $cnt . ')</td>';
        $tbl .='</tr>';
        $tbl .='</table>';
        $tbl .='</td></tr>';

        return $tbl;
    }

    function getDataHistory($year = null, $mounth = null) {
        $ssystem = $this->all_m->getId('ssystem', 'id', 1);

        if ($year == null) {
            $year = date('Y');
        }
        if ($mounth == null) {
            $mounth = date('m');
        }

        $db1 = $this->db->database;

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

        return $dbs;
    }

    function rangeMounth($a, $b) {
        $i = date("Ym", strtotime($a));

        $mounth = array();

        while ($i <= date("Ym", strtotime($b))) {
            //echo $i."<br>";
            $mounth[] = $i;
            if (substr($i, 4, 2) == "12")
                $i = (date("Y", strtotime($i . "01")) + 1) . "01";
            else
                $i++;
        }

        return $mounth;
    }

    function queryUnion($mounth, $db1, $statsql) {

        $sql = '';
        foreach ($mounth as $k => $th) {
            $db = $db1 . '_pr' . $th;

            if (!empty(mysql_fetch_array(mysql_query("SHOW DATABASES LIKE '$db' ")))) {

                $strsql = str_replace($db1, $db, $statsql);
                $sql .= " UNION " . $strsql;
            }
        }

        return $sql;
    }

    function readhtmlcompany() {
        $company = $this->all_m->query_single("select * from ssystem limit 1");

        $html = '';
        $html .='<table class="tables">';
        $html .='<tr>';
        $html .='<td align="right"><table class="tables">';
        $html .='<tr><td colspan="3" style="font-size:14px;">' . $company->comp_name . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add1 . '</td></tr>';
        $html .='<tr><td colspan="3">' . $company->comp_add2 . '</td></tr>';
        $html .='<tr><td colspan="3"><b>Phone : </b>' . $company->comp_phone . '</td></tr><tr><td colspan="3"><b>Fax : </b>' . $company->comp_fax . '</td></tr>';
        $html .='</table></td>';
        $html .='</tr>';

        $html .='</table><br />';

        return $html;
    }

    function getWrhs(){
        $id = $this->input->post('id');
        $user = $this->all_m->getId('usr', 'id', $id);
        
        $res = array('wrhs' => $user->wrhs_input);
        
        $this->json($res);
    }
}

/* End of file: MY_Controller.php */
/* Location: application/core/MY_Controller.php */