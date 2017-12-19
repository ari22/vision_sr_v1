<?php
session_start();
$groupmain = '';
//echo "Login sebagai : ".$_SESSION["C_USER"];
$username = $_SESSION["C_USER"];
include "services/procadd.php";
include "model/builder.php";

foreach ($_GET as $key => $value) {
    $$key = $value;
}
$form = $form_alias;
$form2 = $form_alias;

$fields = array('vw_' . $form, 'ed_' . $form, 'pr_' . $form, 'dl_' . $form, 'cl_' . $form, 'uc_' . $form, 'xp_' . $form, 'cn_' . $form, 'gn_' . $form, 'im_' . $form, 'ds_' . $form, 'sn_' . $form, 'ucp' . $form);

$usr_veh = mysql_query("SELECT * from usr left join usr_veh veh on usr.username=veh.username left join usr_veh2 veh2 on usr.username=veh2.username left join usr_acc acc on usr.username=acc.username where usr.username='" . $username . "' ");
$usr_veh = mysql_fetch_object($usr_veh);
$usr_access = (array) $usr_veh;

foreach ($_SESSION as $key => $ses) {

    if ($key == 'C_USER' || $key == 'C_ID') {
        
    } else {
        unset($_SESSION[$key]);
    }
}

foreach ($fields as $key) {
    if (array_key_exists($key, $usr_access)) {
        $_SESSION[$key] = $usr_access[$key];
    }
}

if ($form == 'crm') {
    $no = 1;
    $_SESSION['vw_' . $form] = $no;
}
if ($form == 'mth_cls' || $form == 'backup' || $form == 'restore' || $form == 'reindex' || $form == 'import' || $form == 'usr_log') {
    $no = 0;

    if ($usr_access['ut_' . $form] == 1) {
        $no = 1;
    }
    $_SESSION['vw_' . $form] = $no;
}
if ($form == 'settrvn') {
    $no = 0;

    if ($usr_access['ut_' . $form] == 1) {
        $no = 1;
    }
    $_SESSION['vw_' . $form] = $no;
    $_SESSION['ed_' . $form] = $no;
}

if ($form == 'prtapg') {

    $_SESSION['cl_' . $form] = $usr_access['cl_prtapg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_prtapg'];

    $form = 'prtap';
    $_SESSION['vw_' . $form] = $usr_access['vw_' . $form];
    $_SESSION['ed_' . $form] = $usr_access['ed_' . $form];
    $_SESSION['pr_' . $form] = $usr_access['pr_' . $form];
    $_SESSION['dl_' . $form] = $usr_access['dl_' . $form];
}

if ($form == 'vehapg') {

    $_SESSION['cl_' . $form] = $usr_access['cl_vehapg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_vehapg'];

    $form = 'vehap';
    $_SESSION['vw_' . $form] = $usr_access['vw_' . $form];
    $_SESSION['ed_' . $form] = $usr_access['ed_' . $form];
    $_SESSION['pr_' . $form] = $usr_access['pr_' . $form];
    $_SESSION['dl_' . $form] = $usr_access['dl_' . $form];
}

if($form == 'vehdpsg'){
    $_SESSION['cl_' . $form] = $usr_access['cl_vehdpsg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_vehdpsg'];

    $form = 'vehdps';
    $_SESSION['vw_' . $form] = $usr_access['vw_' . $form];
    $_SESSION['ed_' . $form] = $usr_access['ed_' . $form];
    $_SESSION['pr_' . $form] = $usr_access['pr_' . $form];
    $_SESSION['dl_' . $form] = $usr_access['dl_' . $form];
}

if ($form == 'veharg') {

    $_SESSION['cl_' . $form] = $usr_access['cl_veharg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_veharg'];

    $form = 'vehar';
    $_SESSION['vw_' . $form] = $usr_access['vw_' . $form];
    $_SESSION['ed_' . $form] = $usr_access['ed_' . $form];
    $_SESSION['pr_' . $form] = $usr_access['pr_' . $form];
    $_SESSION['dl_' . $form] = $usr_access['dl_' . $form];
}

if ($form == 'setup') {
    if ($usr_access['ut_' . $form] == '1') {
        $_SESSION['vw_' . $form] = 1;
        $_SESSION['ed_' . $form] = 1;
    }
}
/*
echo $form.'==='.$form2;
echo '<br />';
  echo '<pre>';
  print_r($_SESSION);
  echo '</pre>';
  exit;
 
*/
if ($form == 'change_passwd') {
    $access = true;
} else {
    if (!empty($_SESSION['vw_' . $form])) {
        if ($_SESSION['vw_' . $form] == '1') {
            $access = true;
        } else {
            $access = false;
        }
    } else {
        $access = false;
    }
}


if ($form == 'vehmtcm') { //echo $usr_access['unmtch_pos'];exit;
    if ($usr_access['unmtch_pos'] == '') {
        ?>
        <script>
            alert('Parameter untuk Un-Match belum di set di user access untuk user ini')
        </script>
        <?php
        $access = false;
    }
}
?>

<?php
if ($access == true) {
    include "services/getsession.php";

    if (isset($gen_type) && isset($form_type) && isset($form_name)) {

        $lcFile = $gen_type . "/" . $form_type . "/" . $form_name . ".php";
        $lcModel = '';

        if ($form_name == 'tpl_lookup') {
            $lcFile = "view/misc/" . $form_name . ".php";
            if (!isset($model)) {
                include "notfound.html";
                return;
            } else {
                $lcModel = "model/" . $form_type . "/" . $model . ".php";
            }
        }


        if (file($lcFile)) {
            if (isset($model)) {
                if (!file($lcModel)) {
                    include "notfound.html";
                    return;
                };
            }
            $loc_jui = "../lib/jeasyui/";
            $loclib = "../lib/";
        } else {
            include "notfound.html";
            return;
        }
        ?>

        <html>
            <head>
                <meta charset="UTF-8"></meta>	
                <noscript></noscript>
                <script language=JavaScript>
                    var base_url = '<?php echo $base_url; ?>';
                    var site_url = '<?php echo $site_url; ?>';
                    var message = "Function Disabled!";
                    var cls_date = 'cls_date';

                    function clickIE4() {
                        if (event.button == 2) {
                            alert(message);
                            return false;
                        }
                    }
                    function clickNS4(e) {
                        if (document.layers || document.getElementById && !document.all)
                        {
                            if (e.which == 2 || e.which == 3) {
                                alert(message);
                                return false;
                            }
                        }
                    }
                    if (document.layers) {
                        document.captureEvents(Event.MOUSEDOWN);
                        document.onmousedown = clickNS4;
                    }
                    else if (document.all && !document.getElementById) {
                        document.onmousedown = clickIE4;
                    }
                    //document.oncontextmenu=new Function("alert(message);return false") 
                    document.oncontextmenu = new Function("return false")
                    function pad(n, width, z) {
                        z = z || '0';
                        n = n + '';
                        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
                    }
                    function scrlTop() {
                        $('html, body').animate({scrollTop: 0}, 300);
                    }
                    function checkboxClick() {
                        $(".checkbox").click(function () {
                            var name = $(this).attr('name');
                            var atr = $('#form_validation #' + name).attr('disabled');

                            if (atr !== 'disabled') {
                                $('#form_validation #' + name).prop("checked", true);
                            }
                        });

                        $('input[type="checkbox"]').click(function () {
                            if ($(this).prop("checked") == true) {
                                $(this).val(1);
                            }
                            else if ($(this).prop("checked") == false) {
                                $(this).val(0);
                            }
                        });
                    }


                    function formatNumber(x) {
                        if (x == null) {
                            x = 0;
                        }
                        return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    }

                    function rolesVw() {
                        var num = checkRoles('vw');

                        if (num == '1') {
                            return true;
                        } else {
                            errorAccess();
                        }

                    }

                    function rolesEdit() {
                        var num = checkRoles('ed');

                        if (num == '1') {
                            // condEdit();
                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleLocked', {table: table, id: id, user: '<?php echo $username; ?>', action: 'edit'}, function (res) {
                                var msg = $.parseJSON(res);

                                if (msg.status !== false) {
                                    condEdit();
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                }
                            });


                            return false;
                        }

                        errorAccess();
                    }

                    function rolesPopPrintMatch(key, act) {
                        var num = checkRoles('pr');

                        if (num == '1') {
                            if (act == 'slip') {
                                print_sc_slip(key);
                            } else {
                                print_sc(key);
                            }
                            return false;
                        }

                        errorAccess();
                    }

                    function rolesPrintMatch(key) {
                        var num = checkRoles('pr');

                        if (num == '1') {
                            if (key == 'slip') {
                                $('#SlipPrintWindow').window('open');
                            } else {
                                windowprint(key);
                            }
                            return false;
                        }

                        errorAccess();
                    }
                    function rolesMatch() {
                        var num = checkRoles('ed');

                        if (num == '1') {
                            doMatch();
                            return false;
                        }

                        errorAccess();
                    }
                    function rolesUnMatch() {
                        var num = checkRoles('dl');

                        if (num == '1') {
                            doUnMatch();
                            return false;
                        }

                        errorAccess();
                    }

                    function rolesCancel() {
                        //condCancel();
                        var id = $("#id").val();

                        $.post(site_url + 'builder/roleCancel', {table: table, id: id}, function (res) {
                            var msg = $.parseJSON(res);

                            if (msg.status !== false) {
                                condCancel();
                            }

                        });

                    }
                    function rolesAdd() {
                        var num = checkRoles('ed');

                        if (num == '1') {
                            condAdd();
                            return false;
                        } else {
                            errorAccess();
                        }

                    }
                    function rolesAdd2() {
                        var num = checkRoles('ed');

                        if (num == '1') {
                            condAdd2();
                            return false;
                        } else {
                            errorAccess();
                        }

                    }
                    function rolesDel() {
                        $('#cmdDelete').linkbutton('disable');

                        var num = checkRoles('dl');

                        if (num == '1') {
                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleLocked', {table: table, id: id, user: '<?php echo $username; ?>'}, function (res) {
                                var msg = $.parseJSON(res);

                                if (msg.status !== false) {
                                    condDelete();
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                    read_show('');
                                }

                            });

                            return false;
                        }

                        errorAccess();
                    }
                    function rolesDel2() {

                        var num = checkRoles('dl');

                        if (num == '1') {
                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleLocked', {table: table, id: id, user: '<?php echo $username; ?>'}, function (res) {
                                var msg = $.parseJSON(res);

                                if (msg.status !== false) {
                                    condDelete2();
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                    read_show2('');
                                }

                            });

                            return false;
                        }

                        errorAccess();
                    }

                    function rolesClose() {
                        $('#cmdClose').linkbutton('disable');

                        var num = checkRoles('cl');
                        if (num == '1') {
                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleLocked', {table: table, id: id, user: '<?php echo $username; ?>', cls_date: cls_date}, function (res) {
                                var msg = $.parseJSON(res);

                                if (msg.status !== false) {
                                    closeBtn();
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                    read_show('');
                                }

                            });

                            return false;
                        }

                        errorAccess();
                    }
                    function rolesSave2() {
                        var num = checkRoles('ed');
                        if (num == '1') {
                            saveData2();
                            return false;
                        }
                        errorAccess();
                    }

                    function rolesSaveCheck() {
                        $('#cmdSave').linkbutton('disable');

                        var num = checkRoles('ed');

                        if (table == 'usr' || table == 'veh_arh' || table == 'veh_aph' || table == 'acc_arh' || table == 'acc_aph' || table == 'veh_comaph') {
                            if (num == '1') {
                                saveData();
                            }
                            return false;
                        } else {



                            if (num == '1') {
                                var id = $("#id").val();

                                $.post(site_url + 'builder/checkCLose', {table: table, id: id, user: '<?php echo $username; ?>', cls_date: cls_date}, function (res) {
                                    var msg = $.parseJSON(res);

                                    if (msg.status !== false) {
                                        saveData();
                                    } else {
                                        showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                        read_show('');
                                        cmdcondAwal();
                                        formDisabled();
                                    }
                                });

                                return false;
                            }
                        }
                        errorAccess();

                    }

                    function rolesUnclose() {
                        $('#cmdUnClose').linkbutton('disable');

                        var num = checkRoles('uc');
                        if (num == '1') {
                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleUnclose', {table: table, id: id, user: '<?php echo $username; ?>', cls_date: cls_date}, function (res) { //alert(res)
                                var msg = $.parseJSON(res);
                                if (msg.status !== false) {
                                    UncloseBtn();
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                    read_show('');
                                }

                            });

                            return false;
                        }

                        errorAccess();
                    }

                    function rolesPrintScreen(key) {
                        var num = checkRoles('pr');
                        if (num == '1') {

                            var id = $("#id").val();

                            $.post(site_url + 'builder/roleLocked', {table: table, id: id, user: '<?php echo $username; ?>', print: 'print'}, function (res) {
                                var msg = $.parseJSON(res);

                                if (msg.status !== false) {
                                    print_sc(key);
                                } else {
                                    showAlert("Message", '<font color="red">' + msg.message + '</font>');
                                    read_show('');
                                }
                            });

                            return false;
                        }

                        errorAccess();
                    }

                    function rolesPopupPrint(key) {
                        var num = checkRoles('pr');
                        if (num == '1') {
                            print_window(key);
                            return false;
                        }

                        errorAccess();
                    }

                    function checkRoles(key) {
                        if (key !== 'vw') {
                            var view = getRoles('vw');

                            if (view !== '1') {
                                document.location = "no_access.html";
                            }
                        }

                        var paramList = getRoles(key);

                        //var paramList = $("#roles").val();

                        return paramList;

                    }

                    function getRoles(key) {
                        $.ajaxSetup({async: false});

                        var returnData = null;

                        var user = '<?php echo $_SESSION['C_USER']; ?>';
                        var form = '<?php echo $form; ?>';
                        var form2 = '<?php echo $form2; ?>';

                        var url = site_url + 'builder/checkRoles';
                        
                        if (form2 == 'vehdpsg' && key == 'cl') {
                            form = '<?php echo $form2; ?>';
                        }
                        
                        if (form2 == 'veharg' && key == 'cl') {
                            form = '<?php echo $form2; ?>';
                        }

                        if (form2 == 'vehapg' && key == 'cl') {
                            form = '<?php echo $form2; ?>';
                        }

                        if (form2 == 'prtapg' && key == 'cl') {
                            form = '<?php echo $form2; ?>';
                        }

                        if (form2 == 'veharg' && key == 'uc') {
                            form = '<?php echo $form2; ?>';
                        }

                        if (form2 == 'vehapg' && key == 'uc') {
                            form = '<?php echo $form2; ?>';
                        }

                        if (form2 == 'prtapg' && key == 'uc') {
                            form = '<?php echo $form2; ?>';
                        }
                        if (form2 == 'vehdpsg' && key == 'uc') {
                            form = '<?php echo $form2; ?>';
                        }

                        $.post(url, {user: user, form: form, key: key}, function (res) {
                            var json = $.parseJSON(res);

                            var num = json.num;

                            //$("#roles").val(num);
                            returnData = num;
                        });

                        $.ajaxSetup({async: true});  //return to default setting

                        return returnData;
                    }

                    function someFunction(data) {
                        var json = $.parseJSON(data);

                        var num = json.num;

                        return num;
                    }

                    function errorAccess() {
                        $.messager.alert('Access Privilege', 'Insufficient Access Privilege!', 'warning');

                    }

                    function updateFailed(obj) {

                        if (obj.update == false) {
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                            $("#form_validation #id").val('');

                            if (table == 'veh_slh') {
                                edited = false;
                            }

                            read_show('');
                        } else {
                            $('.loader').hide();
                            condReady();
                            //$('#form_validation :input').attr('disabled', true);
                            showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                        }
                    }

                    function cmdEmptyData() {
                        $('.cmdEdit').linkbutton('disable');
                        $('.cmdDelete').linkbutton('disable');
                    }

                    function checkRunMonthYear(inv_type) {
                        $.messager.defaults.ok = 'Yes';
                        $.messager.defaults.cancel = 'No';
                        
                        $.post(site_url + 'builder/checkRunMonthYear', {inv_type: inv_type}, function (json) { 
                            var obj = JSON.parse(json);
                          
                            if (obj.status == false) {
                                $.messager.confirm('Change Year / Month Invoice ?', obj.message,  function (r) {
                                    if (r) { 
                                        $.post(site_url + 'builder/UpdateMonthYear', {inv_type: inv_type}, function (read) {    
                                            return true;
                                        });
                                    }
                                });
                            }
                        });
                    }
                </script>
                <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/gray/easyui.css"; ?>>
                <!--<link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/gray/easyui.css"; ?>>-->
                <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/icon.css" ?>>
                <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "demo/demo.css" ?>>
                <script type="text/javascript" src=<?php echo $loc_jui . "jquery.min.js" ?>></script>
                <script type="text/javascript" src=<?php echo $loc_jui . "jquery.easyui.min.js" ?>></script>
                <script  src=<?php echo $loclib . "validate/jquery-validate.js" ?>></script>
                <style>
                    .loader {
                        position: fixed;
                        margin:auto;
                        left: 0px;
                        top: 0px;
                        width: 100%;
                        height: 100%;
                        z-index: 9999;
                        background: rgb(249,249,249) ;

                        /* background: url('<?php echo $loc_jui; ?>/themes/gray/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);*/
                    }
                    #form_validation a{text-decoration:none !important;color:#000;}
                    #form_validation a:hover{color:blue;}
                    body{background:#f5f5f5;}

                    .tabs li{background:#f5f5f5;}
                    .main-form{
                        background:#fff;width: 100%; margin-bottom: 10px; border:1px solid #ddd;border-radius:4px;padding:10px;
                    }
                    .single-form{
                        background:#fff;
                        border:1px solid #ddd;
                        border-radius:4px 4px 0px 0px;
                        padding-top:15px;
                        padding-bottom:15px;
                        padding-left:10px;
                        padding-right:10px;
                    }
                    .main-tab{padding:10px;padding-top:15px;}
                    .main-nav{padding:5px 10px 5px 10px;border:1px solid #ddd;background:#ddd;}
                    .td-ro{width: 5px !important;}
                    .teen-margin{margin-bottom:10px;}
                    .space{width: 25px !important;}
                    .easyui-numberbox{text-align:right;}
                    .pricenumber{width:120px;}
                    input[disabled]{background:#f2f2f2;border: 1px solid #ddd;
                                    select[disabled]{background:#f2f2f2;border: 1px solid #ddd;} 
                                    .select{border:1px solid #d3d3d3;}               }
                                    textarea[disabled]{background:#f2f2f2;}
                                    input[type=radio] {  vertical-align: middle; margin-top: -2px; }
                                    input[type=checkbox] {  vertical-align: middle; margin-top: -1px; }
                                    .right{text-align:right;}
                                    input[type=text]{height:22px}
                                    .checkboxValign{padding-top: 5px;} 
                                    .checkboxBorder{border: 1px solid #ddd; border-radius:5px;padding-bottom:3px;}
                                    .col10{width:10px;}
                                    .col20{width:20px;}
                                    .col30{width:30px;}
                                    .col40{width:40px;}
                                    .col50{width:50px;}
                                    .col60{width:60px;}
                                    .col70{width:70px;}
                                    .col80{width:80px;}
                                    .col90{width:90px;}
                                    .col100{width:100px;}
                                    .col110{width:110px;}
                                    .col120{width:120px;}
                                    .col130{width:130px;}
                                    .col140{width:140px;}
                                    .col150{width:150px;}
                                    .col160{width:150px;}
                                    .col170{width:150px;}
                                    .col180{width:150px;}
                                    .col190{width:150px;}
                                    .col200{width:150px;}
                                    .marginmin{margin: -3px;}
                                    #version{cursor:pointer;}
                    </style>
                </head>
                <body class="body">
                    <div id="windowSearch" class="easyui-window" title="Search" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:1020px;height:auto;min-height: 300px;max-height: 620px;padding:20px;top:1;"></div>
                    <a id="openFlag" style="display:none">0</a>
                    <a id="openFlag2" style="display:none">0</a>
                    <!--div id="windowSearch2" class="easyui-window" title="Search" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:1020px;height:auto;min-height: 300px;max-height: 620px;padding:10px;top:1;"></div>
                    <a id="openFlag2" style="display:none">0</a-->
                    <div class="loader"> <div class="datagrid-mask-msg" style="display:block;left:40%;opacity:2 !important;">Processing, please wait ...</div></div>
                    <?php
                    if ($_SESSION) {
                        $compid = $_SESSION['id'];
                        $compsql = "select * from ssystem where id='$compid'";
                        $comp = mysql_query($compsql);
                        $comp = mysql_fetch_assoc($comp);
                        $ppn = intval($comp['ppn']);
                        $pph = intval($comp['pph']);

                        $po_source = $comp['po_source'];
                        $vpg_source = $comp['vpg_source'];
                        $wo_source = $comp['wo_source'];
                        $optpur_set = $comp['optpur_set'];
                        $optprc_set = $comp['optprc_set'];
                        $bbn_set = $comp['bbn_set'];

                        $invsql = "select * from inv_seq";
                        $inv = mysql_query($invsql);

                        while ($row = mysql_fetch_array($inv)) {
                            $inv_seq[] = $row;
                            unset($row);
                        }

                        $usr_id = $_SESSION["C_ID"];
                        $usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
                        $usr = mysql_query($usrsql);
                        $usr = mysql_fetch_assoc($usr);

                        $wrhs_axs = $usr['wrhs_axs'];
                        $wrhs_input = $usr['wrhs_input'];

                        if ($wrhs_axs == 'MDLR') {
                            $groupmain = 'MDLR';
                        }
                    }
                    if (isset($model)) {
                        include $lcModel;
                    };
                    include $lcFile;
                    ?>

                    <!--
                    <script>                             
                        $('#<?php echo $form; ?>').validate({
                            onKeyup : true,
                            eachValidField : function() {

                                $(this).closest('div').removeClass('error').addClass('success');
                            },
                            eachInvalidField : function() {

                                $(this).closest('div').removeClass('success').addClass('error');
                            }
                        });
                    </script>
                    -->

                </body>
            </html>
            <?php
        } else {
            include "notfound.html";
            return;
        }
    } else {
        include "no_access.html";
    }