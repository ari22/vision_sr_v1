<?php
$ci_path = 'srci';
$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://';

$newurl = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
$newurl = str_replace('loader.php', '', $newurl);
$newurl = str_replace('loader_rpt.php', '', $newurl);
$base_url = "$http" . $_SERVER['SERVER_NAME'] . $newurl . $ci_path . '/';
$site_url = $base_url . 'index.php/';

$search_url = "$http" . $_SERVER['SERVER_NAME'] . $newurl . 'search/';
?>
<style>
    .caps{border:1px solid red !important;}
</style>
<script>
    var search_url = '<?php echo $search_url; ?>';
    function dateTop() {

        $("#due_day").keyup(function () {
            $("#due_date").datebox('setValue', '');
            var day = $(this).val();
            var dateVal = setExpDate(parseInt(day));

            var date = (dateVal.getDate()) + "/" + (dateVal.getMonth() + 1) + "/" + dateVal.getFullYear();
            $("#due_date").datebox('setValue', date);
        });

        //Restric Calendar
        /*$('#due_date').datebox().datebox('calendar').calendar({
         validator: function (date) {
         var now = new Date();
         var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
         var d2 = new Date(now.getFullYear() + 5, now.getMonth(), now.getDate());
         return d1 <= date && date <= d2;
         }
         });*/
        //Onselect Datebox       
        $('#due_date').datebox({
            onSelect: function (date) {
                var date1 = new Date('<?php echo date('m/d/Y'); ?>');
                var date2 = new Date((date.getMonth() + 1) + "/" + (date.getDate()) + "/" + date.getFullYear());
                //var time = Math.abs(date2.getTime() - date1.getTime());
                var time = date2.getTime() - date1.getTime();
                var day = Math.ceil(time / (1000 * 3600 * 24));

                $("#due_day").numberbox('setValue', day);
            }
        });
    }

    function getDateDiff(ldTglAwal, ldTglAkhir) {
        //var ldTglAwal = new Date(2015,6,1); //22 Juli 2015
        // alert(ldTglAwal);
        //var ldTglAkhir = new Date;
        var one_day = 1000 * 60 * 60 * 24;
        var selisih = 0;
        selisih = ldTglAkhir - ldTglAwal;
        selisih = Math.floor(selisih / one_day)
        alert(selisih);
        return selisih;
    }
    function getEndDate(ldTglAwal, lnDay) {
        //alert(ldTglAwal);
        var ldTglAkhir = ldTglAwal;
        ldTglAkhir.setDate(ldTglAwal.getDate() + lnDay);
        //alert(a);
        var yr = ldTglAkhir.getFullYear();
        var mn = ldTglAkhir.getMonth() + 1;
        var hr = ldTglAkhir.getDate();
        var ldTglAkhir = mn + '/' + hr + '/' + yr;
        return ldTglAkhir;
    }

    function validateNumber(evt) {
        var e = evt || window.event;
        var key = e.keyCode || e.which;

        if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                // numbers   
                key >= 48 && key <= 57 ||
                // Numeric keypad
                key >= 96 && key <= 105 ||
                // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
                // Home and End
                key == 35 || key == 36 ||
                // left and right arrows
                key == 37 || key == 39 ||
                // Del and Ins
                key == 46 || key == 45) {
            // input is VALID
        }
        else {
            // input is INVALID
            e.returnValue = false;
            if (e.preventDefault)
                e.preventDefault();
        }
    }
    function showAlert(title, msg) {
        if(title == ''){
            title = 'Notification';
        }
        $.messager.show({
            title: title,
            msg:'<div style="height:100%">'+ msg +'</div>',
            showType: 'fade', //null,slide,fade,show
            timeout: 2000,
            //showType:'fade',
            width:300,  
            height:'auto',
            style: {
                right: '',
                top: document.body.scrollTop + document.documentElement.scrollTop,
                bottom: ''
            }
        });
    }
    function number_format(num, dig, dec, sep) {
        x = new Array();
        s = (num < 0 ? "-" : "");
        num = Math.abs(num).toFixed(dig).split(".");
        r = num[0].split("").reverse();
        for (var i = 1; i <= r.length; i++) {
            x.unshift(r[i - 1]);
            if (i % 3 == 0 && i != r.length)
                x.unshift(sep);
        }
        return s + x.join("") + (num[1] ? dec + num[1] : "");
    }
    /*$.extend($.fn.validatebox.defaults.rules,{
     exists:{
     validator:function(value,param){
     var cc = $(param[0]);
     var v = cc.combobox('getValue');
     var rows = cc.combobox('getData');
     for(var i=0; i<rows.length; i++){
     if (rows[i].id == v){return true}
     }
     return false;
     },
     message:'Tidak sesuai dengan data.'
     }
     });
     */
    /*  $.extend($.fn.validatebox.defaults.rules, {
     validDate: {
     validator: function (value) {
     var date = $.fn.datebox.defaults.parser(value);
     var s = $.fn.datebox.defaults.formatter(date);
     return s == value;
     },
     message: 'Please enter a valid date.'
     },
     minLength: {
     validator: function (value, param) {
     return value.length >= param[0];
     },
     message: 'Please enter at least {0} characters.'
     }
     });
     /*Edit Aris SA*/
    /* $.fn.datebox.defaults.formatter = function (date) {
     var y = date.getFullYear();
     var m = date.getMonth() + 1;
     var d = date.getDate();
     return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
     };
     */

    /* $.fn.datebox.defaults.parser = function(s){
     if (!s) return new Date();
     var ss = s.split('-');
     var y = parseInt(ss[0],10);
     var m = parseInt(ss[1],10);
     var d = parseInt(ss[2],10);
     if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
     return new Date(y,m-1,d);
     } else {
     return new Date();
     }
     }; */
    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        //return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
    }
    function myparser(s) {
        //alert(s);
        if (!s)
            return new Date();
        //alert(s);
        var ss = (s.split('/'));
        //alert (parseInt(ss[0]));
        var d = parseInt(ss[0]);
        var m = parseInt(ss[1]);
        var y = parseInt(ss[2]);
        //alert( y + "." + m + "." + d);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }

    function dateSplit(date) {
        if (date !== null) {
            var ss = (date.split('-'));
            var d = parseInt(ss[2]);
            var m = parseInt(ss[1]);
            var y = parseInt(ss[0]);

            var newdate = d + '/' + m + '/' + y;
            return newdate;
        }
    }
    function setExpDate(num) {
        var datenow = '<?php echo date('m/d/Y'); ?>';

        var interval = num;
        var startDate = new Date(datenow);
        startDate.toString('yyyy-MM-dd');
        var expDate = startDate;
        expDate.setDate(startDate.getDate() + interval);

        return expDate;

    }
    function formatDate(value, row) {
        stat = true;

        if (value == null) {
            stat = false;
        }
        if (value == '0000-00-00') {
            stat = false;
        }

        if (stat !== false) {
            var dateVal = new Date(value);
            var date = (dateVal.getDate()) + "/" + (dateVal.getMonth() + 1) + "/" + dateVal.getFullYear();
            return date;

        }
    }
    function formatDateTime(value, row) {
        stat = true;

        if (value == null) {
            stat = false;
        }
        if (value == '0000-00-00 00:00:00') {
            stat = false;
        }

        if (stat !== false) {
            var dateVal = new Date(value);
            var date = (dateVal.getDate()) + "/" + (dateVal.getMonth() + 1) + "/" + dateVal.getFullYear();
            var time = (dateVal.getHours()) + ":" + (dateVal.getMinutes()) + ":" + dateVal.getSeconds();
            
            return date+' '+time;
        }
    }
    function formatNumber(x) {
        if (x == null) {
            x = 0;
        }
        return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function condSearch() {
        $("#openFlag2").html('0');
        $('#windowSearch').window('open');
        
        var cond = '';
        
        if(table == 'acc_slh'){
            var cond = sinv_code;
        }
        
        if ($("#openFlag").html() == '0') {
            $('#windowSearch').empty().append('<div class="datagrid-mask-msg" style="display:block;left:40%;opacity:2 !important;">Processing, please wait ...</div>');
            $.post(search_url + 'index.php', {table: table,cond:cond}, function (html) {
                $('#windowSearch').empty().html(html);
            });
            $("#openFlag").html(1);

        }
    }

    function condSearch2() {
        $("#openFlag").html('0');
        
        $('#windowSearch').window('open');
        if ($("#openFlag2").html() == '0') {
            $('#windowSearch').empty().append('<div class="datagrid-mask-msg" style="display:block;left:40%;opacity:2 !important;">Processing, please wait ...</div>');
            $.post(search_url + 'index.php', {table: table2}, function (html) {
                $('#windowSearch').empty().html(html);
            });
            $("#openFlag2").html(1);
        }

        //may be needed
        /*
         $('#windowSearch2').window('open');
         
         if($("#openFlag2").html() == '0'){
         $.post(search_url+'index2.php',{table:table},function(html){
         $('#windowSearch2').empty().html(html);
         });
         $("#openFlag2").html(1);
         }*/

        //old
        /*$.post(search_url+'index.php',{table:table},function(html){
         $('#windowSearch').html(html);
         });*/
    }

    function version(v) {
        $('#version').tooltip({
            position: 'left',
            content: v
        });
    }

</script>
<?php
include "services/globalFunctions.php";
include "component.php";

class objField {

    public $name = 'fieldname';
    public $caption = 'caption';
    public $width = 100;
    public $maxlength = 10;

}

function getCaption($lcKeyWord) {
    $lang_id = "ENG";
    if ($lang_id == 'ENG') {

        $conn = connDB();
        $sql = "Select eng from dictionary where keyword='$lcKeyWord'";
        $result = mysql_query($sql) or die(mysql_error() . $sql);
        $row = mysql_fetch_array($result);
        $lcKeyWord = $row['eng'];
    }
    echo $lcKeyWord;
}

function textarea($name, $caption, $width, $maxlength = 120) {
    ?>
    <tr>
        <td valign="top"><?php getCaption($caption); ?> </td>
        <td valign="top" style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <textarea rows="4" autocomplete="off"  class="easyui-validatebox textbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true maxlength="<?php echo $maxlength; ?>"></textarea>
        </td>
    </tr>
    <?php
}

function datetimebox($name, $caption) {
    ?>
    <tr>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-datetimebox" autocomplete="off"  id="<?php echo $name; ?>" name="<?php echo $name; ?>"  disabled=true></input>
        </td>
    </tr>
    <?php
}

function emptybox($name, $width, $maxlength) {
    ?>	
    <tr>	
        <td>&nbsp; </td>
        <td>&nbsp;

        </td>
    </tr>
    <?php
}

function textbox($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-validatebox textbox" autocomplete="off" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?>
                   ></input>
        </td>
    </tr>


    <?php
}

function textboxmail($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?></td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-validatebox textbox" autocomplete="off" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?> data-options="prompt:'Enter a valid email.',validType:'email'"></input>
        </td>
    </tr>
    <?php
}

// width sudah dipaksa 15 digits khusus no hp dan fax
function numberbox($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" class="easyui-numberbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:120px;text-align:right;" disabled=true <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
                echo "onkeydown='validateNumber(event);'";
            } if ($name == 'due_day') {
                echo "onkeydown='startCalc();'  onkeyup='stopCalc();'";
            }
            ?>  ></input>
        </td>
    </tr>
    <!--onkeydown="validateNumber(event);"-->
    <script>

        /*
         $('#<?php echo $name; ?>').numberbox({
         formatter:function(value) {
         return number_format(value,0,',','.');
         }
         })*/
    </script>
    <!--========================= -->
    <?php
}

function pricebox($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" class="easyui-numberbox" data-options="precision:0,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '"	 id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?> 
                   value="" onFocus="startCalc();"  onBlur="stopCalc();" 
                   ></input>
        </td>
    </tr>

    <!--========================= -->
    <?php
}

// width sudah dipaksa 15 digits khusus no hp dan fax
function phonebox($name, $caption, $width) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true maxlength="15" onkeydown="validateNumber(event);" ></input>
        </td>
    </tr>
    <!--========================= -->
    <?php
}

//width sudah dipaksa 5 digits khusus zipcode
function zipbox($name, $caption, $width) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" class="easyui-numberbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="text-align:left;width:<?php echo $width; ?>px;" disabled=true maxlength="5" onkeydown="validateNumber(event);" ></input>
        </td>
    </tr>
    <?php
}

function currboxset($name1, $name2, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <table style="margin: -2 -3 ;">
                <td>
                    <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name1; ?>" name="<?php echo $name1; ?>" style="width:<?php echo $width; ?>px; margin:0px 0px 0px 0px;" disabled=true 
                    <?php
                    if (isset($maxlength)) {
                        echo "maxlength='" . $maxlength . "'";
                    }
                    ?>
                           onkeypress="return goodchars(event, '0123456789', this)" onblur="currformat('<?php echo $name1; ?>')"></input>
                </td>
                <td>
                    <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name2; ?>" name="<?php echo $name2; ?>" style="width:<?php echo $width; ?>px; margin:0px 0px 0px 20px;" disabled=true 
                    <?php
                    if (isset($maxlength)) {
                        echo "maxlength='" . $maxlength . "'";
                    }
                    ?>
                           onkeypress="return goodchars(event, '0123456789', this)" onblur="currformat('<?php echo $name2; ?>')"></input>
                </td>
            </table>
        </td>
    </tr>
    <script>
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }
        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null)
                return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            if (goods.indexOf(keychar) != -1)
                return true;
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;

            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            }
            ;
            return false;
        }
        function currformat(id) {
            var data = document.getElementById("" + id);
            data.value = parseFloat(data.value.replace(/,/g, "")).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    <?php
}

function currbox($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?></td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="padding:2px;height:25px;width:<?php echo $width; ?>px;" disabled=true 
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?>
                   onkeypress="return goodchars(event, '0123456789', this)" onblur="currformat('<?php echo $name; ?>')"></input>
        </td>
    </tr>
    <script>
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }
        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null)
                return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            if (goods.indexOf(keychar) != -1)
                return true;
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;

            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            }
            ;
            return false;
        }
        function currformat(id) {
            var data = document.getElementById("" + id);
            data.value = parseFloat(data.value.replace(/,/g, "")).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
    <?php
}

function exportbox($name, $caption, $width) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" type="text" class = "easyui-filebox" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="padding:2px;height:25px;width:<?php echo $width; ?>px;"  disabled=true></input>
        </td>
    <script>
        $('#<?php echo $name; ?>').filebox({
            buttonText: 'Choose File',
            buttonAlign: 'left'
        })
    </script>
    </tr>
    <?php
}

function textboxset($name1, $name2, $caption, $width1, $width2, $maxlength1 = null, $maxlength2 = null) {
    ?>	
    <tr>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <table style="margin: -2 -3;">
                <td>
                    <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name1; ?>" name="<?php echo $name1; ?>" style="width:<?php echo $width1; ?>px;" disabled=true maxlength="<?php echo $maxlength1; ?>" ></input>
                </td>
                <td>
                    <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name2; ?>" name="<?php echo $name2; ?>" style="width:<?php echo $width2; ?>px;" disabled=true  maxlength="<?php echo $maxlength2; ?>"></input>
                </td>
            </table>
        </td>



    </tr>
    <?php
}

function textdateset($name1, $name2, $caption, $width1, $width2) {
    ?>	
    <tr>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <table style="margin: -2 -3;">
                <td>
                    <input autocomplete="off" class="easyui-validatebox textbox" type="text" id="<?php echo $name1; ?>" name="<?php echo $name1; ?>" style="width:<?php echo $width1; ?>px;" disabled=true></input>
                </td>
                <td>
                    <input autocomplete="off" class="easyui-datebox" type="text" id="<?php echo $name2; ?>" name="<?php echo $name2; ?>" style="width:<?php echo $width2; ?>px;" disabled=true></input>
                </td>
            </table>
        </td>



    </tr>
    <?php
}

function datespin($name, $caption) {
    ?>	

    <tr>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td><input autocomplete="off"	class="easyui-datetimespinner" 
                   value="6/24/2014" 
                   data-options="formatter:formatter2,parser:parser1"
                   style="padding:2px;height:25px;width:180px;">
            </input>
        </td>
    </tr>
    <script type="text/javascript">
        function formatter1(date) {
            if (!date) {
                return '';
            }
            return $.fn.datebox.defaults.formatter.call(this, date);
        }
        function parser1(s) {
            if (!s) {
                return null;
            }
            return $.fn.datebox.defaults.parser.call(this, s);
        }
        function formatter2(date) {
            if (!date) {
                return '';
            }
            var d = date.getDay();
            var m = date.getMonth() + 1;
            return d + '-' + (m < 10 ? ('0' + m) : m);
        }
        function parser2(s) {
            if (!s) {
                return null;
            }
            var ss = s.split('-');
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            if (!isNaN(y) && !isNaN(m)) {
                return new Date(y, m - 1, 1);
            } else {
                return new Date();
            }
        }
    </script>
    <?php
}

function remotecombobox($name, $caption, $width, $datasource, $valuefield, $textfield) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-combobox" 
                   id="<?php echo $name; ?>"
                   name="<?php echo $name; ?>"
                   data-options="
                   url:'<?php echo $datasource; ?>',
                   method:'post',
                   mode:'remote',
                   panelHeight: 'auto',
                   selectOnNavigation: true,
                   valueField:'<?php echo $valuefield; ?>',
                   textField:'<?php echo $textfield; ?>',
                   required: true,    
                   width:<?php echo $width; ?>,
                   panelHeight:'auto'" disabled=true>
            </input>
            <script>
                $('#<?php echo $name; ?>').combobox({
                    validType: 'exists["#<?php echo $name; ?>"]',
                    onShowPanel: function () {
                        $('#<?php echo $name; ?>').combobox({
                            url: '<?php echo $datasource; ?>'
                        });
                        $('#<?php echo $name; ?>').combobox('enable');
                    },
                    onLoadSuccess: function (data) {
                        laValue = $('#<?php echo $name; ?>').combobox('getData');
                        var key, count = 0;
                        for (key in data) {
                            if (data.hasOwnProperty(key)) {
                                count++;
                            }
                        }
                        if (count == 0)
                        {
                            $('#<?php echo $name; ?>').combobox('setValue', '');
                        }
                        if (count == 1)
                        {
                            //alert(laValue[0]['<?php echo $textfield; ?>']);
                            $('#<?php echo $name; ?>').combobox('setValue', laValue[0]['<?php echo $textfield; ?>']);
                        }

                    }
                });
            </script>
        </td>
    </tr>
    <?php
}

function localcombobox($name, $caption, $width, $data) {
    if ($caption !== '') {
        ?>	
        <tr>	
            <td><?php getCaption($caption); ?> </td>
            <td style="max-width: 5px !important;" class="td-ro">:</td>
            <td>
                <select class="easyui-combobox" 
                        id="<?php echo $name; ?>" 
                        name="<?php echo $name; ?>" 
                        style="width:<?php echo $width; ?>px;" 
                        data-options="panelHeight:100,editable:false,width:<?php echo $width; ?>"
                        disabled=true
                        >
                            <?php
                            foreach ($data as $val) {
                                echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                            }
                            ?>				
                </select>
            </td>
        </tr>

        <?php
    } else {
        ?>
        <select class="easyui-combobox" 
                id="<?php echo $name; ?>" 
                name="<?php echo $name; ?>" 
                style="width:<?php echo $width; ?>px;" 
                data-options="panelHeight:100,editable:false,width:<?php echo $width; ?>"
                disabled=true
                >
                    <?php
                    foreach ($data as $val) {
                        echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                    }
                    ?>				
        </select>
        <?php
    }
}

function datebox($name, $caption, $width = null) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>

            <input autocomplete="off" class="easyui-datebox" validType='validDate'  data-options="formatter:myformatter,parser:myparser,required:false" id="<?php echo $name; ?>"  name="<?php echo $name; ?>" style="width:90;" disabled=false></input>

        </td>
    </tr>
    <?php
}

function checkbox($name, $caption) {
    ?>	
    <input type="checkbox" id="<?php echo $name; ?>"  name="<?php echo $name; ?>" disabled=true><?php getCaption($caption); ?></input>
    <?php
}

function checktextbox($name, $caption, $width) {
    ?>	
    <tr>
        <td><input type="checkbox" id="<?php echo $name; ?>"  name="<?php echo $name; ?>" disabled=true></input>
        </td>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-validatebox textbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;"  disabled=true></input>
        </td>
    </tr>
    <?php
}

function navigation() {
    ?>	
    <div style="padding:15px 0;">
        <table>
            <tr><td>
                    <a href="#" id="cmdFirst" title="First" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-first'"  onclick="showdata('F', lnRecNo)" ></a>
                    <a href="#" id="cmdPrev" title="Prev" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-prev'" onclick="showdata('P', lnRecNo)"></a>
                    <a href="#" id="cmdNext" title="Next" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-next'" onclick="showdata('N', lnRecNo)"></a>
                    <a href="#" id="cmdLast" title="Last" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-last'" onclick="showdata('L', lnRecNo)"></a>
                </td>
                <td align=center width="100px">
                    <a href="#" id="cmdSave" title="Save" class="easyui-linkbutton easyui-tooltip"  data-options="iconCls:'icon-save',group:'g2',disabled:true" onclick="saveData()" ></a>
                    <a href="#" id="cmdCancel" title="Batal" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-undo',group:'g2',disabled:true"  onclick="condCancel()" ></a>
                </td>
                <td align=left width="120px">
                    <a href="#" id="cmdAdd" title="<?php getCaption("Tambah"); ?>" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-add'"  onclick="condAdd()"></a>
                    <a href="#" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-edit'"  onclick="condEdit()"></a>
                    <a href="#" id="cmdDelete" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-no'" onclick="condDelete()" ></a>
                    <a href="#" id="cmdSearch" title="<?php getCaption("Cari"); ?>" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-search'" onclick="condSearch()" ></a>
                </td>

            </tr>
        </table>
        <script>
            function condSearch() {
                $('#windowSearch').window('open');
            }
        </script>

    </div>			
    <?php
}

function reportNav() {
    ?>	
    <div style="padding:15px 0;">
        <table>
            <td >
                <a href="#" class="easyui-linkbutton"  onclick="doSearch('screen')">Screen</a>
                &nbsp;&nbsp;

                <a href="#" class="easyui-linkbutton"  onclick="doSearch('print')">Printer</a>
                &nbsp;&nbsp;

                <a href="#" class="easyui-linkbutton"  onclick="doSearch('export')"><?php getCaption('Eksport'); ?></a>
                &nbsp;&nbsp;
            </td>
        </table>
    </div>			
    <?php
}

function searchWindow($name, $title, $fieldList, $lookup, $pk, $sk, $form, $table) {
//Ada masalah ketika di search, lebar kolomnya jadi autoresize.
    $lcFields = '';
    ?>

    <div id="<?php echo $name; ?>" class="easyui-window" title="<?php echo $title; ?>" data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false,iconCls:'icon-save'" 
         style="width:700px;height:500px;padding:10px;top:1px;">

        <table 	id= "dt" class="easyui-datagrid" title="Advanced Search"  
                data-options="rownumbers:true,singleSelect:true,method:'post',toolbar:'#tb',mode:'remote',pagination:true,remoteSort:true,multiSort:true">
            <thead>
                <tr>
                    <?php
                    foreach ($fieldList as $a) {
                        echo '<th data-options="field:' . "'" . $a[0] . "'" . ',width:' . $a[2] . '">' . $a[1] . '</th> ';
                        if (strlen($lcFields) >> 0) {
                            $lcFields .= ",";
                        }
                        $lcFields .= "'" . $a[0] . "'";
                    }
                    ?>
                </tr>
            </thead>
        </table>

        <br>
        <a href="javascript:void(0)" id="windowSearchOk" class="easyui-linkbutton" onClick= "getSelected()" >Ok</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#<?php echo $name; ?>').window('close')">Cancel</a>

        <div id="tb" style="padding:5px;height:auto">
            <div>
                <?php getCaption("Kata Kunci"); ?> : <input id="searchKeyword" class="easyui-textbox" style="width:200px">
                <a href="#" class="easyui-linkbutton" onClick = "doSearch()" iconCls="icon-search">Search</a>
            </div>
        </div>
    </div>		

    <script>
        function doSearch() {
            url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup; ?>&fields=<?php echo $lcFields; ?>&query=" + $("#searchKeyword").val() + "&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>";
            $('#dt').datagrid({
                url: url
            });
        }
        $('#<?php echo $name; ?>').window({
            onResize: function () {
                $('#dt').datagrid({
                    width: $('#<?php echo $name; ?>').width()
                });
            }
        });
        function getSelected() {
            var row = $('#dt').datagrid('getSelected');
            if (row) {

                lnTargetRec = row.id;
                url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup; ?>&id=" + (lnTargetRec)
                        + "&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>";
                $.getJSON(url, function (data) {
                    if (data.total == 0) {
                        lnRecNo = lnTargetRec - 1;
                    } else
                    {
                        $('#<?php echo $form; ?>').form('load', {<?php getFieldList($table, 'getData'); ?>});
                        lnRecNo = data.rows[0]['id'] * 1;
                    }

                });
            }
            $('#<?php echo $name; ?>').window('close');
        }


    </script>
    <?php
}

function textboxcustom($name, $val) {
    ?>	
    <input type="hidden" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $val; ?>" disabled=true readonly=true>
    <?php
}

function fieldItung($name, $caption, $width, $maxlength) {
    ?>	
    <tr>	
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" class="easyui-numberbox" 	 id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?> 
                   value="" onkeyup="startCalc();"  onkeydown="stopCalc();" 
                   ></input>
        </td>
    </tr>
    <?php
}

function fieldHasil($name, $caption, $width, $maxlength) {
    ?>
    <td><?php getCaption($caption); ?> </td>
    <td style="max-width: 5px !important;" class="td-ro">:</td>
    <td>
        <input autocomplete="off" class="easyui-numberbox" data-options="precision:0,groupSeparator:'.',decimalSeparator:',',prefix:'Rp. '" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
        <?php
        if (isset($maxlength)) {
            echo "maxlength='" . $maxlength . "'";
        }
        ?> 
               ></input>
    </td>
    </tr>
    <?php
}
?>
<?php

function cmbGrid($name1, $name2, $caption, $url, $array, $width1 = null, $width2 = null) {
    if ($width1 !== null) {
        $width1 = $width1;
    } else {
        $width1 = 80;
    }
    if ($width2 !== null) {
        $width2 = $width2;
    } else {
        $width2 = 200;
    }
    ?>	
    <tr>	
        <?php if ($caption !== '') { ?>
            <td><?php getCaption($caption); ?> </td>
            <td style="max-width: 5px !important;" class="td-ro">:</td>
        <?php } ?>
        <td>
            <table style="margin: -2 -3;">
                <td>
                    <input class="easyui-validatebox textbox" type="text" id="<?php echo $name1; ?>" name="<?php echo $name1; ?>" style="width:<?php echo $width1 ?>; height:22;" disabled=true></input>					
                </td>
                <td>
                    <input class="easyui-combogrid" 
                           id="<?php echo $name2; ?>"
                           name="<?php echo $name2; ?>"
                           data-options="
                           panelWidth: 400,
                           panelHeight:340,
                           delay: 500,
                           idField:'<?php echo $name2; ?>',
                           textField:'<?php echo $name2; ?>',
                           loadMsg:'Please wait...',
                           url:'<?php echo $url; ?>',
                           method:'post',
                           columns: [[               
                           <?php
                           foreach ($array as $a) {
                               echo "{field:'" . $a[0] . "',title:'" . $a[1] . "',width:" . $a[2] . ",sortable:true},";
                           }
                           ?>
                           ]],
                           fitColumns: true,
                           mode:'remote',
                           pagination:true,
                           remoteSort:true,
                           multiSort:true,
                           required:false,
                           " 
                           style="width:<?php echo $width2 ?>"
                           disabled=true>
                    </input>
                    <script>
                        $('#<?php echo $name2; ?>').combogrid({
                            
                            onShowPanel: function () {
                                $('#<?php echo $name1; ?>').val('');
                            },
                            onLoadSuccess: function (data) {
                               
                                var obj = JSON.parse(JSON.stringify(data));
                                var count = obj.total;
                                if (count == 0)
                                {
                                    $('#<?php echo $name2; ?>').combogrid('setValue', '');
                                }
                                else
                                {
                                    if (obj.rows[0]['<?php echo $name1; ?>'] == undefined)
                                    {
                                    } else
                                    {
                                       
                                        var lenCode = $('#<?php echo $name1; ?>').val().length;
                                        var lenName = obj.rows[0]['<?php echo $name2; ?>'].length;
                                        if (lenCode == 0)
                                        {
                                            $('#<?php echo $name2; ?>').combogrid('setValue', '');
                                           //  showAlert("Message", '<font color="red">Data based on keywords is not available</font>');
                                        }
                                    }

                                }

                            }
                        });
                    </script>
                </td>
            </table>

        </td>
    </tr>
    <?php
}
?>
<?php

function cmbGridSingle($name1, $caption, $url, $array, $width = null, $key = null, $key2 = null) {
    ?>	
    <script>
        var <?php echo "temp" . $name1; ?> = '';
    </script>
    <tr>	
        <?php
        if ($width == null) {
            $width = 120;
        }
        ?>
        <?php if ($caption !== '') { ?>
            <td><?php getCaption($caption); ?> </td>
            <td style="max-width: 5px !important;" class="td-ro">:</td>
            <?php
        }

        if ($key !== null) {
            $field = $array[$key][0];
        } else {
            $field = $array[0][0];
        }

        if ($key2 !== null) {
            $field2 = $array[$key2][0];
        } else {
            $field2 = $array[1][0];
        }
        ?>
        <td>
            <table style="margin: -2 -3;">
                <td>

                    <input class="easyui-combogrid" 
                           id="<?php echo $name1; ?>"
                           name="<?php echo $name1; ?>"
                           data-options="
                           panelWidth: 500,
                           panelHeight:340,
                           delay: 500,
                           idField:'<?php echo $field; ?>',
                           textField:'<?php echo $field2; ?>',
                           loadMsg:'Please wait...',
                           url:'<?php echo $url; ?>',
                           method:'post',
                           sortName: '<?php echo $field; ?>',
                           sortOrder: 'asc',
                           columns: [[               
                           <?php
                           foreach ($array as $a) {

                               echo "{field:'" . $a[0] . "',title:'" . $a[1] . "',width:" . $a[2] . ",sortable:true";

                               if (!empty($a[3])) { // set formater
                                   echo ",formatter:" . $a[3] . "";
                               }
                               if (!empty($a[4])) { // set position
                                   echo ",align:'" . $a[4] . "'";
                               }

                               echo "},";
                           }
                           ?>
                           ]],
                           fitColumns: false,
                           mode:'remote',
                           pagination:true,
                           remoteSort:true,
                           multiSort:true,
                           required:false,
                           " 
                           style="width:<?php echo $width; ?>px"
                           disabled=true>
                    </input>
                    
                                                            <script>
                        $('#<?php echo $name1; ?>').combogrid({
                            onShowPanel: function () {
                                <?php echo "temp" . $name1; ?> = '';
                            },
                            onBeforeload: function () {
                                <?php echo "temp" . $name1; ?> = '';

                            },
                            onLoadSuccess: function (data) { 
                                var obj = JSON.parse(JSON.stringify(data));
                                var count = obj.rows.length;

                                if (document.getElementById("<?php echo $name1; ?>").getAttribute("disabled") != "disabled")
                                {
                                    if (obj.total == 0)
                                    {
                                             $('#<?php echo $name1; ?>').combogrid('setValue', '');
                                            <?php echo "temp" . $name1; ?> = '';
                                        if (<?php echo "temp" . $name1; ?> == '')
                                        {


                                            $('#<?php echo $name1; ?>').combogrid({
                                                queryParams: {q: ''}
                                            });
                                            $('#<?php echo $name1; ?>').combogrid('enable');
                                           
                                            //showAlert("Message", '<font color="red">Data based on keywords is not available</font>');
                                            return false;
                                        }
                                    } else {
                                        if (count == 1) {
                                            $('#<?php echo $name1; ?>').combogrid('setValue', obj.rows[0]['<?php echo $array[0][1]; ?>']);
                                                <?php echo "temp" . $name1; ?> = '<?php echo $array[0][0]; ?>';
                                        } else {
                                            $('#<?php echo $name1; ?>').combogrid('setValue', '');
                                                <?php echo "temp" . $name1; ?> = '';
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </td>
            </table>

        </td>
    </tr>
    <?php
}

function numberspinner($name1, $caption, $width, $maxlength) {
    ?>
    <tr>
        <td><?php getCaption($caption); ?> </td>
        <td style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input autocomplete="off" type="text" class="easyui-numberspinner" style="width:<?php echo $width; ?>px;" name="<?php echo $name1; ?>" id="<?php echo $name1; ?>" required="required" data-options="editable:true" disabled=true
            <?php
            if (isset($maxlength)) {
                echo "maxlength='" . $maxlength . "'";
            }
            ?> 
                   />
        </td>
    </tr>
    <?php
}

/* Editing app CI */

function encrypt_decrypt($action, $string) {
    $output = false;

    if ($action == 'encrypt') {
        $output = strtr(base64_encode($string), '+/', '-_');
    } else if ($action == 'decrypt') {
        $output = base64_decode(strtr($string, '-_', '+/'));
    }

    return $output;
}

/* function encrypt_decrypt($action, $string) {

  $output = false;

  $encrypt_method = "AES-256-CBC";
  $secret_key = 'This is my secret key';
  $secret_iv = 'This is my secret iv';

  $key = hash('sha256', $secret_key);

  $iv = substr(hash('sha256', $secret_iv), 0, 16);

  if ($action == 'encrypt') {
  $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
  $output = base64_encode($output);
  } else if ($action == 'decrypt') {
  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }

  return $output;
  }
 */

function cmdPayType($name, $caption, $site_url, $width = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'pay_type');
    //remotecombobox($name,$caption,100,$url,'pay_code','pay_name');
    $field = array
        (
        array("pay_type", "Code", 120),
        array("pay_name", "Name", 220),
    );
    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width);
}

function navigation_ci() {
    ?>	

   <table class="table" style="width:500px;" border="0">
        <tr>
            <td  style="border-top:0px !important;">
                <button type="button" id="cmdFirst" title="First"  data-options="iconCls:'icon-first'" class="easyui-linkbutton cmdFirst" onclick="read_show('F')"></button>
                <button type="button" id="cmdPrev" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton cmdPrev"  onclick="read_show('P')" ></button>
                <button type="button" id="cmdNext" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton cmdNext"  onclick="read_show('N')" ></button>
                <button type="button" id="cmdLast" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton cmdLast"  onclick="read_show('L')" ></button>
            </td>
            <td  style="border-top:0px !important;">
                <button type="button" id="cmdSave" title="Save"  data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton cmdSave" onclick="rolesSaveCheck()" ></button>
                <button type="button" id="cmdCancel" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton cmdCancel"  onclick="rolesCancel()"  ></button>
                <button type="button" id="cmdSearch" title="Search" data-options="iconCls:'icon-search',group:'g2'" class="easyui-linkbutton cmdSearch"  onclick="condSearch()"  ></button>
                <!--<a href="#" id="refresh" title="Refresh" data-options="iconCls:'icon-reload',group:'g2'" class="easyui-linkbutton"   onclick="read_show('')"  ></a>-->
            </td>
            <td  style="border-top:0px !important;">
                <button type="button" id="cmdAdd" title="<?php getCaption("Tambah"); ?>" data-options="iconCls:'icon-add'" class="easyui-linkbutton cmdAdd"  onclick="rolesAdd()"></button>
                <button type="button" id="cmdEdit" title="<?php getCaption("Ubah"); ?>" data-options="iconCls:'icon-edit'" class="easyui-linkbutton cmdEdit"  onclick="rolesEdit()" ></button>
                <button type="button" id="cmdDelete" title="<?php getCaption("Hapus"); ?>" data-options="iconCls:'icon-no'" class="easyui-linkbutton cmdDelete"  onclick="rolesDel()" ></button>
                <!--<a href="#" id="cmdSearch" title="<?php getCaption("Cari"); ?>" class="glyphicon glyphicon-search btn btn-default" data-options="iconCls:'icon-search'" onclick="condSearch()" ></a>-->
                <!---<a  data-options="iconCls:'icon-ok'" class="glyphicon glyphicon-ok btn btn-default" href="javascript:void(0)" onclick="window_close()" ></a>-->
            </td>

        </tr>
    </table>  

    <div id="windowSearch" class="easyui-window" title="Search" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:auto; max-height: 550px;padding:10px;top:1;">
        <table id="tableSearch"></table>
        <div id="actionSearch"></div>
    </div>
    <div id="windowBrowse" class="easyui-window" title="Search" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:350px;padding:10px;top:1;">
        <table id="tableBrowse"></table>
        <br />
        <table style="margin-top:0px;">
            <tr>
                <td><button type="button" title="<?php getCaption("ok"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#WindowSJ').window('close');">OK</button></td>

                <td><button type="button" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#windowBrowse').window('close');">Quit</button></td>
            </tr>
        </table>
    </div>
    <script>


        /*
         function condSearch() { alert(table)
         
         $("#tableSearch").datagrid({
         method: 'post',
         url: site_url + 'builder/table_grid/load/'+table+'/?grid=true',
         idField: 'id',
         fitColumns: true,
         singleSelect: true,
         nowrap: true,
         fit: false,
         rownumbers: true,
         pageSize: 10,
         showFooter: false,
         pagination: true,
         columns: [[
         {field: pk, title: pk_name, width: 120, height: 20, sortable: true},
         {field: sk, title: sk_name, width: 120, height: 20, sortable: true}
         ]]
         });
         $('#windowSearch').window('open');
         }
         */
    </script>


    <?php
}

function acc_wkcd($name1, $caption, $site_url, $width = null, $key = null, $key2 = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_wkcd');
    $field = array
        (
        array("wk_desc", "Optional Name", 400),
        array("wk_code", "Optional Code", 200),
        array("sal_price", "Sale Price", 150, 'formatNumber', 'right'),
            // array("sal_price", "Sale Price", 120),
    );
    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }

    cmbGridSingle2($name1, $caption, $url, $field, 400, 1, 1, 120);
}

function cmbGridSingle2($name1, $caption, $url, $array, $width, $key = null, $key2 = null, $width2 = null) {
    if ($key !== null) {
        $field = $array[$key][0];
    } else {
        $field = $array[0][0];
    }

    if ($key2 !== null) {
        $field2 = $array[$key2][0];
    } else {
        $field2 = $array[1][0];
    }

    if ($width2 !== null) {
        $width2 = $width2;
    }
    ?>	
    <script>
        var <?php echo "temp" . $name1; ?> = '';
    </script>
    <table style="margin: -2 -3;">
        <td>
            <input class="easyui-combogrid" 

                   id="<?php echo $name1; ?>"
                   name="<?php echo $name1; ?>"
                   data-options="
                   novalidate:true,
                   panelWidth: <?php echo $width; ?>,
                   panelHeight:340,
                   fitColumns: false,
                   delay: 500,
                   idField:'<?php echo $field; ?>',
                   textField:'<?php echo $field2; ?>',
                   loadMsg:'Please wait...',
                   url:'<?php echo $url; ?>',
                   method:'post',
                   columns: [[               
                   <?php
                   foreach ($array as $a) {
                       ///echo "{field:'" . $a[0] . "',title:'" . $a[1] . "',width:" . $a[2] . ",sortable:true},";
                       echo "{field:'" . $a[0] . "',title:'" . $a[1] . "',width:" . $a[2] . ",sortable:true";

                       if (!empty($a[3])) { // set formater
                           echo ",formatter:" . $a[3] . "";
                       }
                       if (!empty($a[4])) { // set position
                           echo ",align:'" . $a[4] . "'";
                       }

                       echo "},";
                   }
                   ?>
                   ]],

                   fitColumns: true,
                   mode:'remote',
                   pagination:true,
                   remoteSort:true,
                   multiSort:true,
                   required:false,
                   " 
                   disabled="true"
                   style="width:<?php echo $width2; ?>"
                   >
            </input>
            <script>
                $('#<?php echo $name1; ?>').combogrid({
                    onShowPanel: function () {
    <?php echo "temp" . $name1; ?> = '';
                    },
                    onBeforeload: function () {
    <?php echo "temp" . $name1; ?> = '';

                    },
                    onLoadSuccess: function (data) {
                        var obj = JSON.parse(JSON.stringify(data));
                        var count = obj.rows.length;

                        if (document.getElementById("<?php echo $name1; ?>").getAttribute("disabled") != "disabled")
                        {
                            if (obj.total == 0)
                            {
                                showAlert("Message", '<font color="red">Data based on keywords is not available</font>');
                                $('#<?php echo $name1; ?>').combogrid('setValue', '');
                                return false;

                            } else {
                                if (count == 1) {
                                    $('#<?php echo $name1; ?>').combogrid('setValue', obj.rows[0]['<?php echo $array[0][1] ?>']);
                                } else {
                                    $('#<?php echo $name1; ?>').combogrid('setValue', '');

                                }
                            }
                        }
                    }
                });
            </script>
        </td>
    </table>
    <?php
}

function textbox2($name, $width, $maxlength) {
    ?>	
    <input class="easyui-validatebox textbox" autocomplete="off" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px;" disabled=true
    <?php
    if (isset($maxlength)) {
        echo "maxlength='" . $maxlength . "'";
    }
    ?>
           ></input>
           <?php
       }

       function datebox2($name, $width = null) {
           if ($width == null) {
               $width = 90;
           }
           ?>	
    <input autocomplete="off" class="easyui-datebox" validType='validDate'  data-options="formatter:myformatter,parser:myparser,required:false" id="<?php echo $name; ?>"  name="<?php echo $name; ?>" style="width:<?php echo $width; ?>;" disabled=false></input>
    <?php
}

function cmdLocation($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'location');
    $field = array
        (
        array("loc_name", "Name", 220),
        array("loc_code", "Code", 100)
    );
    cmbGridSingle($name, $caption, $url, $field, 150);
}

function cmdSlh($name1, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh') . '/cust_code/';
    $field = array
        (
        array("chassis", "Chassis", 250),
        array("so_no", "SPK No.", 150),
        array("so_date", "SPK Date", 150, 'formatDate'),
        array('sal_inv_no', 'Invoice No.', 150),
        array("sal_date", "Invoice Date", 150, 'formatDate')
    );
    cmbGridSingle2($name1, $caption, $url, $field, 650, 0, 0);
}

function cmdSingleMaccs($name1, $caption, $site_url, $width = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'maccs') . '/prt_inact/';
    $field = array
        (
        array("part_code", 'Item Code', 200),
        array("part_name", 'Item Name', 250),
        array("wrhs_code", 'Warehouse', 150),
        array("location", 'Location', 150),
        array('unit', 'Unit', 150, 'formatNumber', 'right'),
        array('qty', 'QTY', 150, 'formatNumber', 'right'),
        array('qty_pick', 'QTY Pick', 180, 'formatNumber', 'right'),
        array('qty_order', 'QTY Order', 180, 'formatNumber', 'right'),
        array('aver_price', 'QTY Order', 180, 'formatNumber', 'right')
    );
    if ($width !== null) {
        $width = $width;
    }
    cmbGridSingle2($name1, $caption, $url, $field, 700, 0, 0, $width);
}

function cmdOpname($name1, $caption, $site_url, $width) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'opname');
    $field = array(
        array("opn_code", 'Code', 100),
        array("opn_name", 'Name', 250)
    );
    if ($width !== null) {
        $width = $width;
    }
    cmbGridSingle2($name1, $caption, $url, $field, 350, 0, 0, $width);
}

function cmdBank($name, $caption, $site_url, $width = null, $key = null, $key2 = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'bank');
    $field = array
        (
        array("bank_code", "Code", 100),
        array("bank_name", "Name", 220)
    );
    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, $key, $key2);
}

function cmdCollector($name, $caption, $site_url, $width = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_coll');
    $field = array
        (
        array("coll_code", "Code", 150),
        array("coll_name", "Name", 250)
    );
    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width);
}

function cmdspk($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_spk');
    $field = array
        (
        array("so_date", "SPK Date", 120, 'formatDate'),
        array("so_no", "SPK No.", 150),
        array("cust_code", "Customer Code", 150),
        array("cust_name", "Customer Name", 250),
            //array("chassis", "Chassis", 50),
            //array("color_name", "Warna", 100),
            //array("wrhs_code", "Warehouse", 50)
    );
    cmbGridSingle($name, $caption, $url, $field, 150, 1);
}

function cmdspkForm($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_spk');
    $field = array
        (
        //array("so_date", "SPK Date", 120, 'formatDate'),
        array("so_no", "SPK No.", 100),
        array("chassis", "Chassis.", 150),
        array("veh_code", "Customer Code", 80),
        array("srep_name", "Sales Name", 200),
        array("cust_name", "Customer Name", 200),
        array("cust_rname", "STNK Name", 250)
    );
    cmbGridSingle($name, $caption, $url, $field, 120, 0, 0);
}

function cmdspkFormPick($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_spk') . '/pick';
    $field = array
        (
        array("so_no", "SPK No.", 100),
        array("so_date", "SPK Date", 120, 'formatDate'),
        array("cust_name", "Customer Name", 200),
        array("srep_name", "Sales Name", 200)
    );
    cmbGridSingle($name, $caption, $url, $field, 120, 0, 0);
}

function cmdponew($name, $caption, $site_url, $width = null, $cls=null) {
    if($cls !== null){
            $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_po').'/closed';
    }else{
            $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_po');
    }

    $field = array
        (
        array("po_no", "PO No.", 150),
        array("po_date", "PO Date", 100, 'formatDate'),
        array("chassis", "Chassis", 150),
        array("engine", "Engine", 250),
            //array("chassis", "Chassis", 50),
            //array("color_name", "Warna", 100),
            //array("wrhs_code", "Warehouse", 50)
    );

    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, 0, 0);
}

function cmdslhClose($name, $caption, $site_url, $width = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh');
    $field = array
        (
        array("sal_date", "Invoice Date", 120, 'formatDate'),
        array("sal_inv_no", "Invoice No.", 150),
        array("chassis", "Chassis", 150),
        array("engine", "Engine", 250),
        array("veh_code", "Vehicle Code", 100),
        array("veh_name", "Vehicle Name", 250),
        array("veh_model", "Model", 100),
        array("veh_transm", "Transm", 80),
        array("color_code", "Color Code", 100),
        array("color_name", "Color Name", 150),
        array("so_no", "SPK No.", 100),
        array("so_date", "SPK Date", 90, 'formatDate'),
        array("match_date", "Match Date", 80, 'formatDate')
    );

    cmbGridSingle($name, $caption, $url, $field, $width, 1);
}

function cmdacc_slhClose($name, $caption, $site_url, $width = null, $true = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_slh') . '/' . $true;
    $field = array
        (
        array("sal_date", "Invoice Date", 120, 'formatDate'),
        array("sal_inv_no", "Invoice No.", 150),
        array("cust_code", "Customer Code", 100),
        array("cust_name", "Customer Name", 250),
        array("srep_code", "Sales Code", 100),
        array("srep_name", "Sales Name", 250),
    );

    cmbGridSingle($name, $caption, $url, $field, $width, 1);
}

function cmdaccprhClose($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_prh');
    $field = array
        (
        array("pur_date", "Invoice Date", 120, 'formatDate'),
        array("pur_inv_no", "Invoice No.", 150),
        array("supp_code", "Supplier Code", 100),
        array("supp_name", "Supplier Name", 250),
        array("supp_invno", "Supplier Invoice No.", 150),
        array("po_no", "PO No.", 150),
        array("wrhs_code", "Warehouse", 100)
    );

    cmbGridSingle($name, $caption, $url, $field, 150, 1);
}

function cmdprhClose($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_prh');
    $field = array
        (
        array("pur_date", "Invoice Date", 120, 'formatDate'),
        array("pur_inv_no", "Invoice No.", 150),
        array("veh_code", "Vehicle Code", 100),
        array("veh_name", "Vehicle Name", 250),
        array("chassis", "Chassis", 150),
        array("engine", "Engine", 150),
        array("veh_model", "Model", 100),
        array("veh_transm", "Transm", 80),
        array("color_code", "Color Code", 150),
        array("color_name", "Color Name", 250),
    );

    cmbGridSingle($name, $caption, $url, $field, 150, 1);
}

function cmdapvhClose($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_apvh');
    $field = array
        (
        array("apv_date", "Invoice Date", 120, 'formatDate'),
        array("apv_inv_no", "Invoice No.", 150),
        array("supp_code", "Supplier Code", 100),
        array("supp_name", "Suplier Name", 250)
    );

    cmbGridSingle($name, $caption, $url, $field, 150, 1);
}

function cmbdpch($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_dpch');
    $field = array
        (
        array("dp_inv_no", "Invoice No.", 120),
        array("dp_date", "Invoice Date", 90, 'formatDate'),
        array("so_no", "SPK No.", 150),
        array("so_date", "SPK Date", 250, 'formatDate'),
        array("cust_code", "Customer Name", 100),
        array("cust_name", "Customer Name", 250),
        array("chassis", "Chassis", 150),
        array("warna", "Color", 250)
    );
    cmbGridSingle($name, $caption, $url, $field, 150, 0, 0);
}

function cmboreqtype($name, $caption, $site_url) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'oreqtype');
    $field = array
        (
        array("oreq_type", "Order Type", 120),
        array("oreq_name", "Order Name", 150)
    );
    cmbGridSingle($name, $caption, $url, $field, 150, 0, 0);
}

function cmdaccponew($name, $caption, $site_url, $width = null, $supp_code) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'acc_poh') . '/' . $supp_code;
    $field = array
        (
        array("po_date", "PO Date", 120, 'formatDate'),
        array("po_no", "PO No.", 150),
        array("supp_code", "Supplier Code", 150)
    );

    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, 1);
}

function numberbox2($name, $width, $maxlength, $min = null) {
    ?>	

    <input autocomplete="off" data-options="
           <?php
           if ($min !== null) {
               ?>
               min:0,
        <?php
    }
    ?>
           precision:0,groupSeparator:',',decimalSeparator:'.'
           " class="easyui-numberbox" type="text" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="width:<?php echo $width; ?>px !important;text-align:right;" disabled=true <?php
           if (isset($maxlength)) {
               echo "maxlength='" . $maxlength . "'";
           }
           ?> onkeydown="validateNumber(event);" ></input>

    <?php
}

function cmdslhBPKB($name, $caption, $site_url, $key = null, $key2 = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh');
    $field = array
        (
        array("chassis", "Chassis", 150),
        array("so_no", "SPK No.", 120),
        array("so_date", "SPK Date", 100, 'formatDate'),
        array("sal_inv_no", "Invoice No.", 200),
        array("veh_name", "Vehicle Name", 200),
        array("color_name", "Color", 200),
        array("wrhs_code", "Warehouse", 100),
        array("veh_bbn", "BBN", 120, 'formatNumber', 'right'),
        array("srep_name", "Sales Person", 200),
        array("cust_name", "Customer", 200),
        array("cust_rname", "Name in Vehicle Registration", 250),
        array("cust_raddr", "Address in Vehicle Registration", 250)
    );

    //cmbGridSingle($name1, $caption, $url, $array, $width, $key = null, $key2 = null)
    cmbGridSingle($name, $caption, $url, $field, 160, $key, $key2);
}

function cmdstkMove($name, $caption, $site_url, $key = null, $key2 = null) {
    $url = $site_url . 'builder/grid_stkMove/' . encrypt_decrypt('encrypt', 'veh_stk');
    $field = array
        (
        array("chassis", "Chassis", 150),
        array("pur_inv_no", "Invoice No.", 120),
        array("pur_date", "Invoice Date", 100, 'formatDate'),
         array("wrhs_code", "Warehouse", 80),
        array("veh_code", "Vehicle Code", 100),
         array("veh_name", "Vehicle Name", 150),
         array("veh_year", "Year", 100),
         array("veh_model", "Model", 100),
         array("engine", "Engine", 100),
         array("color_code", "Color Code", 100),
         array("color_name", "Color Name", 100)
    );

    //cmbGridSingle($name1, $caption, $url, $array, $width, $key = null, $key2 = null)
    cmbGridSingle($name, $caption, $url, $field, 160, 0, 0);
}

function chassisOptional($name, $caption, $site_url, $width = null) {
    $url = $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh').'/pick_date/?grid=true';
          
    $field = array
        (
        array("chassis", "Chassis", 150),
        array("so_no", "SPK No.", 150),
        array("so_date", "SPK Date", 100, 'formatDate'),
        array("sal_inv_no", "Sales Invoice No.", 250),
        array("cust_name", "Customer", 100),
        array("color_name", "Color", 100),
        array("cust_code", "Customer Code", 50),
        array("cust_name", "Customer Name", 50)
    );

    if ($width !== null) {
        $width = $width;
    } else {
        $width = 150;
    }
    cmbGridSingle($name, $caption, $url, $field, $width, 0, 0);
}
function searcharray($value, $key, $array) {
    foreach ($array as $k => $val) {
        if ($val[$key] == $value) {
            return $k;
        }
    }
    return null;
}

function password($name, $caption, $width, $maxlength) {
    ?>	
    <tr>

        <td><?php getCaption($caption); ?> </td>
        <td valign="top" style="max-width: 5px !important;" class="td-ro">:</td>
        <td>
            <input class="easyui-validatebox textbox" type="password" id="<?php echo $name; ?>" name="<?php echo $name; ?>" style="height:23px;width:<?php echo $width; ?>px;" disabled=true
                   <?php
                   if (isset($maxlength)) {
                       echo "maxlength='" . $maxlength . "'";
                   }
                   ?>
                   ></input>
        </td>
    </tr>


    <?php
}
?>
