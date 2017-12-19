<?php
$form = 'rpt_rcv';
$table = "";
$lookup = 'mst/' . $table;
$spk = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);


$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Color", "2"),
    array("Supplier", "3"),
    array("Warehouse", "4"),
    array("Location", "5")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form">
            <table>
                <tr>
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                            <?php
                            localcombobox('pur_inv_cls', 'Cetak Faktur Terima', 200, $spk);
                            datebox('pur_date1', 'Tanggal Terima', 200);
                            datebox('pur_date2', 's/d', 200);
                            localcombobox('group_by', 'Group By', 200, $optGroupBy);
                            ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                            <?php
                            cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                            cmdColSet('color_code', 'color_name', 'Warna');
                            cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                            cmdWrhs('wrhs_code', 'Warehouse');
                            cmdLoc('loc_code', 'Lokasi', 100, 0, 0);
                            ?>
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


    $(document).ready(function ()
    {
        //console.log( "ready!" );

        $('#pur_date1').datebox('setValue', date1);
        $('#pur_date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide();
        version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");
        $('#pur_inv_cls').combobox('enable');
        $('#pur_date1').datebox('enable');
        $('#pur_date2').datebox('enable');
        $('#group_by').combobox('enable');
        $('#veh_name').combogrid('enable');
        $("#wrhs_code").combogrid('enable');
        // $('#color_name').combogrid('enable');
        //$('#supp_name').combogrid('enable');
        // $('#wrhs_code').combobox('enable');

        $('.easyui-combogrid').combogrid('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcpur_inv_cls = $('#pur_inv_cls').combobox('getValue');
        lcpur_date1 = $('#pur_date1').datebox('getValue');
        lcpur_date2 = $('#pur_date2').datebox('getValue');
        if ((lcpur_date1.length == 0) || (lcpur_date2.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcsupp_code = $('#supp_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');
        loc_code = $('#loc_code').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/penerimaan"
                + "&pur_inv_cls=" + lcpur_inv_cls
                + "&pur_date1=" + lcpur_date1
                + "&pur_date2=" + lcpur_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&supp_code=" + lcsupp_code
                + "&loc_code=" + loc_code
                + "&group_by=" + lcgroup_by;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

    $("#group_by").combobox({
        onChange: function () {

            // $('#rpt_rcv input:text').val('');
            $('#rpt_rcv .easyui-combogrid').combogrid('setValue', '');
            // $('#rpt_rcv .easyui-combogrid').combogrid('disable');
            /*
             var group = $(this).combobox('getValue');
             
             if (group == '1') {
             $("#veh_name").combogrid('enable');
             }
             if (group == '2') {
             $("#color_name").combogrid('enable');
             }
             if (group == '3') {
             $("#supp_name").combogrid('enable');
             }
             if (group == '4') {
             $("#wrhs_code").combogrid('enable');
             }
             */
            $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
        }
    });

    $('#supp_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#supp_code").val(row.supp_code);
            }
        },
        onChange: function () {
            if ($('#supp_name').combogrid('getValue') == '')
            {
                $("#supp_code").val('');
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
