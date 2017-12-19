<?php
$form = 'rpt_penjualan';
$table = "";
$lookup = 'mst/' . $table;
$spk = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);
$harga = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
$optCust = array
    (
    array("ALL", ""),
    array("End User (Pemakai Langsung)", "1"),
    array("Dealer/Reseller", "2"),
    array("Goverment/BUMN", "3"),
);
$optGroupBy = array
    (
    array("Vehicle", "1"),
    array("Color", "2"),
    array("Warehouse", "3"),
    array("Location", "4")
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
                            localcombobox('sal_cls', 'Cetak Faktur', 200, $spk);
                            datebox('date1', 'Tanggal Faktur', 200);
                            datebox('date2', 's/d', 200);
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
                            cmdWrhs('wrhs_from', 'Warehouse');
                            cmdLoc('loc_from', 'Lokasi', 100, 0, 0);
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
        $('#date1').datebox('setValue', date1);
        $('#date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide();
        version('04.17-25');
    });
    function setEnable()
    {
        $('#sal_cls').combobox('enable');
        $('#date1').datebox('enable');
        $('#date2').datebox('enable');

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#wrhs_from").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
            }
        });

        $('.easyui-combogrid').combogrid('enable');
        $('#group_by').combobox('enable');
        $('#veh_name').combogrid('enable');
        $("#wrhs_from").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcsal_cls = $('#sal_cls').combobox('getValue');
        lcdate1 = $('#date1').datebox('getValue');
        lcdate2 = $('#date2').datebox('getValue');
        if ((lcdate1.length == 0) || (lcdate2.length == 0)) {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcwrhs_from = $('#wrhs_from').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');
        loc_from = $('#loc_from').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/pemindahan"
                + "&sal_cls=" + lcsal_cls
                + "&date1=" + lcdate1
                + "&date2=" + lcdate2
                + "&wrhs_from=" + lcwrhs_from
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&group_by=" + lcgroup_by
                + "&loc_from=" + loc_from;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
    $('#cust_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#cust_code").val(row.cust_code);
            }
        },
        onChange: function () {
            if ($('#cust_name').combogrid('getValue') == '')
            {
                $("#cust_code").val('');
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
