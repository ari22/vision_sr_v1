<?php
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Color", "2"),
    array("Warehouse", "3")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >

        <div class="single-form">
            <table>
                <tr>
                    <td valign="top" width="350">
                        <table>
                            <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                            <?php
                            datebox('so_date1', 'Tgl. Batal', 200);
                            datebox('so_date2', 's/d', 200);
                            localcombobox('group_by', 'Group By', 200, $optGroupBy);
                            ?>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                            <?php
                            cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                            cmdColSet('color_code', 'color_name', 'Warna');
                            cmdWrhs('wrhs_code', 'Warehouse');
                            ?>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                </tr>
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
    $(document).ready(function () {
        $('#so_date1').datebox('setValue', date1);
        $('#so_date2').datebox('setValue', date2);
        setEnable();

        $(".loader").hide(1000);
        version('Vesion: Q.09.28-1');
    });

    function setEnable() {
        $('#so_date1').datebox('enable');
        $('#so_date2').datebox('enable');

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('enable');
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
            }
        });

        $('#group_by').combobox('enable');
        $('.easyui-combogrid').combogrid('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');

    }

    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcso_date1 = $('#so_date1').datebox('getValue');
        lcso_date2 = $('#so_date2').datebox('getValue');
        if ((lcso_date1.length == 0) || (lcso_date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        //var strWindowFeatures = "scrollbars=1,fullscreen=yes,status=no,toolbar=no,menubar=no,location=no";

        var URL = url + "?lookup=rpt/form/batal_spk"
                + "&so_date1=" + lcso_date1
                + "&so_date2=" + lcso_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code       
                + "&group_by=" + lcgroup_by;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

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