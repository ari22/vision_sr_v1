<?php
$form = 'rpt';
$table = "";
$lookup = 'mst/' . $table;


$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Warna", "2"),
    array("Warehouse", "3"),
    array("Leasing / Non Leasing", "4")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">
        <div class="single-form teen-margin">
            <table >
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>DELIVERY ORDER REPORT</u></h1></td></tr>
                <?php
                datebox('date1', 'Tanggal', 200);
                datebox('date2', 's/d', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);
                ?>
                <tr><td class="col100"></td></tr>
            </table>
        </div>
        <div  class="single-form" id="formactive">  
            <table>
                 <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                <?php cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan'); ?>
                <?php cmdColSet('color_code', 'color_name', 'Warna'); ?>
                <?php cmdprtWrhs('wrhs_code', 'Warehouse'); ?>
                 <tr><td class="col100"></td></tr>
            </table>
        </div>


              <div class="main-nav">
            <table width="100%">
                <tr>
                    <td>
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="doSearch('print')">Printer</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-export'" onclick="doSearch('export')"><?php getCaption('Eksport'); ?></a>
                        &nbsp;&nbsp;
                    </td>
                    <td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>

                </tr>
            </table>
        </div>
    </form>
</div>
<script>
    $(document).ready(function ()
    {
        $('#date1').datebox('setValue', date1);
        $('#date2').datebox('setValue', date2);
        setEnable();
       $(".loader").hide(1000);
         version('04.17-25');
    });

    function setEnable() {
        $("#group_by").combobox('enable');
        $("#veh_name").combogrid('enable');
        $("#date1").datebox('enable');
        $("#date2").datebox('enable');
    }
    function doSearch(lcOutput) {
        url = "services/runCRUD.php";

        veh_code = $('#veh_code').val();
        wrhs_code = $('#wrhs_code').combogrid('getValue');
        group_by = $('#group_by').combobox('getValue');
        color_code = $("#color_code").val();

        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');

        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/suratjalan"
                + "&date1=" + date1
                + "&date2=" + date2
                + "&group_by=" + group_by
                + "&veh_code=" + veh_code
                + "&wrhs_code=" + wrhs_code
                + "&color_code=" + color_code
                + "&output=" + lcOutput;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

    $("#group_by").combobox({
        onChange: function () {

            $('#formactive input:text').val('');
            $('#formactive .easyui-combogrid').combogrid('setValue', '');

            $("#veh_name").combogrid('disable');
            $("#wrhs_code").combogrid('disable');
            $("#color_name").combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#veh_name").combogrid('enable');
            }
            if (group == '2') {
                $("#color_name").combogrid('enable');
            }
            if (group == '3') {
                $("#wrhs_code").combogrid('enable');
            }

        }
    });

    $('#veh_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#veh_code").val(row.veh_code);
            }
        },
        onChange: function () {
            if ($('#veh_name').combogrid('getValue') == '')
            {
                $("#veh_code").val('');
            }
        }

    });

    $('#color_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#color_code").val(row.color_code);
            }
        },
        onChange: function () {
            if ($('#color_name').combogrid('getValue') == '')
            {
                $("#color_code").val('');
            }
        }

    });


</script>