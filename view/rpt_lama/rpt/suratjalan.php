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
        <h1 style="font-size:20px">Delivery Order Report</h1>
        <div class="single-form teen-margin">
            <table >
                <?php
                datebox('date1', 'Tanggal', 200);
                datebox('date2', 's/d', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);
                ?>
            </table>
        </div>
        <div  class="single-form" id="formactive">  
            <table>
                <?php cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan'); ?>
                <?php cmdColSet('color_code', 'color_name', 'Warna');?>
                <?php cmdprtWrhs('wrhs_code', 'Warehouse'); ?>
            </table>
        </div>


        <div class="main-nav">
            <table>
                <tr>
                    <td>
                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('print')">Printer</a>
                        &nbsp;&nbsp;

                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('export')"><?php getCaption('Eksport'); ?></a>
                        &nbsp;&nbsp;
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<script>
    $(document).ready(function ()
    {
       var ldServer = '<?php echo date('y-m-d'); ?>';
        $('#date1').datebox('setValue', ldServer);
         $('#date2').datebox('setValue', ldServer);
        setEnable();
        $(".loader").hide(1000);
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

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/suratjalan"
                + "&date1=" + date1
                + "&date2=" + date2
                + "&group_by=" + group_by
                + "&veh_code=" + veh_code
                + "&wrhs_code=" + wrhs_code
                + "&color_code=" + color_code
                + "&output=" + lcOutput;
        var win = window.open(URL, "_blank", strWindowFeatures);
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