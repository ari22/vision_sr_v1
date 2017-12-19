<?php session_start(); ?>
<!DOCTYPE html>
<meta charset="UTF-8"> 
<?php
$loc_jui = "../lib/jeasyui/";

$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';
$newurl = str_replace("main.php", "", $_SERVER['SCRIPT_NAME']);
$pathurl = "$http" . $_SERVER['SERVER_NAME'] . $newurl;
        
if (!empty($_SESSION['C_USER'])) {

    include "services/globalFunctions.php";
    //include "services/getsession.php";
    $c_user = $_SESSION['C_USER'];
    $c_id = $_SESSION['C_ID'];
    
    $query = "select count(username) as n_count,id, curr_login from usr where id = '$c_id'";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    
    $curr_login = $row['curr_login'];
    
    $sql = "update usr set lin_dtime=now(), curr_login='1' where id ='$c_id'";
    mysql_query($sql);

} else {
    header("location:index.php");
    return;
}
?>
<html>
    <head>
        <noscript>
        Your browser doesn't support JavaScript or you 
        have disabled JavaScript. Therefore, here's 
        alternative content...

        </noscript>
        <script language=JavaScript>
            var message = "Function Disabled!";
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
            document.oncontextmenu = new Function("return false");
        </script>

        <title>Vision Showroom</title>
        <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/gray/easyui.css"; ?>>

        <script type="text/javascript" src=<?php echo $loc_jui . "jquery.min.js"; ?>></script>
        <script type="text/javascript" src=<?php echo $loc_jui . "jquery.easyui.min.js"; ?>></script>
        <link rel="stylesheet" type="text/css" href=<?php echo $loc_jui . "themes/icon.css"; ?>>
        <style type="text/css">
            body {
                font-family: Calibri, Arial, sans-serif;
            }

            a {
                font-size:10pt;
                font-family : Calibri;
                //font-family: Optima, Segoe, "Segoe UI", Candara, Calibri, Arial, sans-serif;
                text-decoration: none;
                background: inherit;
            }
            a:visited {color:#E0692A;}
            a:hover { color: #7fa1c4; background: inherit; }
            h1 { font-size:16pt; padding: 10px 0 0 8px; margin: 0; }
            h1 a { font-size:16pt;padding: 10px 0 0 8px;color: #737373; background: inherit; }
            .orange { color: #E0692A; }
            sup { font-size: 7pt; }
            .header { 
                height: 50px;
                background: #fff url(img/headerbg.gif) repeat-x bottom;
                //color: #808080;

                /*background: rgba(212,227,237,1);
                background: -moz-linear-gradient(top, rgba(212,227,237,1) 0%, rgba(212,227,237,1) 35%, rgba(136,173,200,1) 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212,227,237,1)), color-stop(35%, rgba(212,227,237,1)), color-stop(100%, rgba(136,173,200,1)));
                background: -webkit-linear-gradient(top, rgba(212,227,237,1) 0%, rgba(212,227,237,1) 35%, rgba(136,173,200,1) 100%);
                background: -o-linear-gradient(top, rgba(212,227,237,1) 0%, rgba(212,227,237,1) 35%, rgba(136,173,200,1) 100%);
                background: -ms-linear-gradient(top, rgba(212,227,237,1) 0%, rgba(212,227,237,1) 35%, rgba(136,173,200,1) 100%);
                background: linear-gradient(to bottom, rgba(212,227,237,1) 0%, rgba(212,227,237,1) 35%, rgba(136,173,200,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e3ed', endColorstr='#88adc8', GradientType=0 );*/

            }

            .top_info {
                float: right;
                width: 555px;
                color: #808080;
            }

            .top_info_left {
                width: 200px;
                float: left;
            }

            .top_info_right {
                float: right;
                width: 300px;
                padding: 0px 0 0 0;
            }
            footer [class ^= 'footer-']{
                padding:9px 13px 0px 13px;
                width:30%;
                display:inline-block;
                text-align:center;
            }
            footer .footer-left {

                float:left;
                text-align:left;
            }
            footer .footer-right{
                text-align:right;		
                float:right;
            }
            a:visited{color:#000;}

        </style>
        <script>
            /*$(document).ready(function(){   
             var user = "<?php echo $_POST['c_user']; ?>";
             alert("Welcome " + user);
             });*/

            function addTab(title, url) {
                urls = "services/runCRUD.php";
                data = "lookup=login"
                        + "&func=checksession";
                $.post(urls, data)
                        .done(function (msg) {
                            var status = $.parseJSON(msg);

                            if (status.success !== false) {
                                $('.loader').show();
                                if ($('#tt').tabs('exists', title)) {
                                   // $('#tt').tabs('select', title);
                                    $("#tt").tabs("close", title);
                                }
                                var content = '<iframe scrolling="auto" frameborder="0"  src="' + url + '" style="width:100%;height:98%;padding:0px;"></iframe>';
                                    $('#tt').tabs('add', {
                                        title: title,
                                        content: content,
                                        closable: true
                                    });
                            } else {
                                window.open('index.php', '_self');
                            }
                        });


            }

            $(function () {
                $("#closeTab").click(function () {
                    $.post("clear.php", function (data) {
                        window.parent.$('#tt').tabs('close', 'Create List');
                        location.reload();
                    });
                });
            });
            
            function helps(){
                window.open("<?php echo $pathurl;?>help","_blank")
            }


        </script>

    </head>
    <body class="easyui-layout">
        
        <div data-options="region:'north',border:true" style="height:50px;overflow:hidden;">
            <!-- North Region or Header Area 
            <span style="font-size:24px;font-family:Tahoma;font-weight: bold;">
                    Vision Showroom
            </span>
    <span style="float:right;">
                    <img  src = "img/company_logo.png" height="40px"/>
            </span>-->

            <div class="header">
                <div class="top_info">
                    <div class="top_info_right" align="right">
                            <!--<p><b>You are not Logged in!</b> <a href="#">Log in</a> to check your messages.<br />-->
                        <table><tr><td>
                                   
                                    <p><b>You are logged in as <a href="#"><?php echo $c_user; ?></a> </b></p></td>
                                <td><a href="#" onclick="helps()" class="easyui-linkbutton" title="help" iconCls="icon-help"></a></td></tr></table>
                    </div>		
                    <div class="top_info_left">

                    </div>
                </div>
                <div class="logo">
                    <h1>Vision<span class="orange">Showroom</span><sup>2nd edition</sup></h1>
                </div>
            </div>
        </div>
        <div data-options="region:'west',split:true,title:'Main menu'" style="width:220px;">
<?php
include "services/getmenu.php";
?>
        </div>		
        <!--<div data-options="region:'east',split:true,collapsed:true,title:'East'" style="width:250px;padding:10px;">
        <?php //include "/view/newstand.php"; ?>
        </div>-->
        <div data-options="region:'south',border:false" style="height:50px;">
            <!-- South Region or Footer Area 
            <span style="font-size:10px;font-family:Tahoma;">
                    Estimated End Of 2014
            </span>-->
            <footer>
                <aside class="footer-center"><a href="#">RSS Feed</a> | <a href="#">Contact</a> | <a href="#">Accessibility</a> | <a href="#">Vision Service</a> | <a href="#">Vision GL</a> | <a href="#">Disclaimer</a>  <a href="http://hoxware.com">Hoxware</a><br />
                </aside>
                <aside class="footer-right"><a href="logout.php"><b>Logout</b></a></aside>
                <aside class="footer-left">
                </aside>
            </footer>



        </div>
        <div data-options="region:'center'">
            <div id="tt" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
                <div title="Welcome" data-options="href:'blank.html',closable:true" style="padding:10px;" ></div>
            </div>
        </div>

    </body>
</html>
