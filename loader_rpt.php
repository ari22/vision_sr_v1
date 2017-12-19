<?php
session_start();
//echo "Login sebagai : ".$_SESSION["C_USER"];
$username = $_SESSION["C_USER"];
include "services/procadd.php";
include "model/builder.php";


foreach ($_GET as $key => $value) {
    $$key = $value;
}
$form = $form_alias;

$fields = array('vw_' . $form, 'ed_' . $form, 'pr_' . $form, 'dl_' . $form, 'cl_' . $form, 'uc_' . $form, 'xp_' . $form, 'cn_' . $form, 'gn_' . $form, 'im_' . $form, 'ds_' . $form, 'sn_' . $form, 'ucp' . $form);

$usr_veh = mysql_query("SELECT * from usr usr left join usr_veh veh on usr.username=veh.username left join usr_veh2 veh2 on usr.username=veh2.username left join usr_acc acc on usr.username=acc.username where usr.username='" . $username . "' ");
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


if ($form == 'vehapg') {
    $form = 'vehap';
    $_SESSION['cl_' . $form] = $usr_access['cl_vehapg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_vehapg'];

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
    $form = 'vehar';
    $_SESSION['cl_' . $form] = $usr_access['cl_veharg'];
    $_SESSION['uc_' . $form] = $usr_access['uc_veharg'];

    $_SESSION['vw_' . $form] = $usr_access['vw_' . $form];
    $_SESSION['ed_' . $form] = $usr_access['ed_' . $form];
    $_SESSION['pr_' . $form] = $usr_access['pr_' . $form];
    $_SESSION['dl_' . $form] = $usr_access['dl_' . $form];
}


if (!empty($_SESSION['vw_' . $form])) {
    if ($_SESSION['vw_' . $form] == '1') {
        include "services/getsession.php";

        $bulan = $_SESSION['bulan'];
        $tahun = $_SESSION['tahun'];

        if (intval(strtotime($tahun.'-'.$bulan.'-30')) < intval(strtotime(date('Y-m-d')))) {
            $tgl = '31';
            
            if($bulan == '02'){
                $tgl = '29';
            }
            if($bulan == "04" OR $bulan == "06" OR $bulan == "09" OR $bulan == "11"){
                $tgl = '30';
            }
            $dateperiode2 =  $tgl.'/' . $bulan . '/' . $tahun;
        }else{
            $dateperiode2 = date('d/m/Y');
        }



        if (isset($gen_type) && isset($form_type) && isset($form_name)) {
            //echo $gen_type."<br/>".$form_type."<br/>".$form_name."php";
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
                ?>
                <html>
                    <head>
                        <meta charset="UTF-8">	
                        <noscript>
                        Your browser doesn't support JavaScript or you 
                        have disabled JavaScript. Therefore, here's 
                        alternative content...

                        </noscript>
                        <script language=JavaScript>
                            var message = "Function Disabled!";
                             var base_url = '<?php echo $base_url; ?>';
                             var site_url = '<?php echo $site_url; ?>';
                             
                             
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

                            function rolesPrintScreenReport(key) {
                                var num = checkRoles('pr');
                                if (num == '1') {
                                    doSearch(key);
                                    return false;
                                }

                                errorAccess();
                            }
                            function rolesExport(key) {
                                var num = checkRoles('xp');
                                if (num == '1') {
                                    doSearch(key);
                                    return false;
                                }

                                errorAccess();
                            }


                            function checkRoles(key) {
                                var num = 0;

                                if (key == 'pr') {

                                <?php if (!empty($_SESSION['pr_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['pr_' . $form]; ?>';
                                <?php } ?>

                                }
                               
                                if (key == 'xp') {

                                <?php if (!empty($_SESSION['xp_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['xp_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'cn') {

                                <?php if (!empty($_SESSION['cn_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['cn_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'gn') {

                                <?php if (!empty($_SESSION['gn_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['gn_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'im') {

                                <?php if (!empty($_SESSION['im_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['im_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'ds') {

                                <?php if (!empty($_SESSION['ds_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['ds_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'sn') {

                                <?php if (!empty($_SESSION['sn_' . $form])) { ?>
                                    num = '<?php echo $_SESSION['sn_' . $form]; ?>';
                                <?php } ?>

                                }
                                if (key == 'ucp<?php echo $form; ?>') {

                                <?php if (!empty($_SESSION['ucp' . $form])) { ?>
                                    num = '<?php echo $_SESSION['ucp' . $form]; ?>';
                                <?php } ?>

                                }
                                return num;


                            }
                            function errorAccess() {
                                alert('Acccess Denied!');
                            }
                            
                             var date1 = '<?php echo '01/' . $bulan . '/' . $tahun; ?>';
                             var date2 = '<?php echo $dateperiode2; ?>';

        
                        </script>
                        <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/metro/easyui.css"; ?>>


                        <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/icon.css" ?>>
                        <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "demo/demo.css" ?>>
                        <script type="text/javascript" src=<?php echo $loc_jui . "jquery.min.js" ?>></script>
                        <script type="text/javascript" src=<?php echo $loc_jui . "jquery.easyui.min.js" ?>></script>

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
                        background:#fff;width: 1080px; margin-bottom: 10px; border:1px solid #ddd;border-radius:4px;padding:10px;
                    }
                    .single-form{
                        background:#fff;
                        border:1px solid #ddd;
                        border-radius:4px 4px 0px 0px;
                        padding-top:15px;
                        padding-bottom:15px;
                        padding-left:10px;
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
                     .marginmin{margin: -3px;}
                     #version{cursor:pointer;}
                        </style>
                    </head>
                    <body class="body" id='cc'>
                        <div class="loader"> <div class="datagrid-mask-msg" style="display:block;left:40%;opacity:2 !important;">Processing, please wait ...</div></div>
                  
                        <?php
                        if (isset($model)) {
                            include $lcModel;
                        };
                        
                        $usr_id =  $_SESSION["C_ID"];
                        $usrsql = "select wrhs_axs, wrhs_input from usr where id='$usr_id'";
                        $usr = mysql_query($usrsql);
                        $usr = mysql_fetch_assoc($usr);
                        
                        $wrhs_axs =  $usr['wrhs_axs'];
                        $wrhs_input = $usr['wrhs_input'];
                        
                        include $lcFile;
                        ?>
                         
                          <div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
                    </body>
                </html>
                <?php
            } else {
                include "notfound.html";
                return;
            }
        } else {
            include "notfound.html";
            return;
        }
    } else {
        include "no_access.html";
    }
} else {
    include "no_access.html";
}
?>



