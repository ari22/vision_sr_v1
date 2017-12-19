<?php
//==========CHANGE LOG=======
//tambah biar otomatis keisi waktu baru buka

$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$spk = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All SPK", "3"),
);
$warehouse = array
    (
    array("ALL", "ALL"),
    array("HAS", "HAS"),
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
    array("Vehicle Type", "1"),
    array("Color", "2"),
    array("Supplier", "3"),
    array("Warehouse", "4"),
    array("Location", "5"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form">
            <table>
                <tr>
                    <td valign="top" width="300">
                        <table >
                            <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                            <?php
                            // localcombobox('so_cls', 'Cetak SPK', 200, $spk);
                            datebox('stk_date', 'Tgl. Stok', 200);
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
                            // localcombobox('cust_type', 'Jenis Pelanggan', 200, $optCust);
                            cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                            //cmdSalSet('srep_code', 'srep_name', 'Nama Sales');
                            //cmdSpvSet('sspv_code', 'sspv_name', 'Supervisor');
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
        setEnable();
        var ldServer = '<?php echo date('Y-m-d'); ?>';
        $('#stk_date').datebox('setValue', ldServer);
        $(".loader").hide(1000);
        $(".loader").hide();
        version('04.17-25');
    });
    function setEnable()
    {

        $('#stk_date').datebox('enable');

        $('#group_by').combobox({
            onSelect: function (index, row) {
                //$('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');
                /*
                 var group = $(this).combobox('getValue');
                 
                 if (group == 1) {
                 $('#veh_name').combogrid('enable');
                 }
                 if (group == 2) {
                 $('#color_name').combogrid('enable');
                 }
                 if (group == 3) {
                 $('#supp_name').combogrid('enable');
                 }
                 if (group == 4) {
                 $('#wrhs_code').combobox('enable');
                 }
                 */
                $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
            }
        });

        $('.easyui-combogrid').combogrid('enable');
        $('#veh_name').combogrid('enable');
        $('#group_by').combobox('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcstk_date = $('#stk_date').datebox('getValue');
        if (lcstk_date.length == 0)
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }
        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        loc_code = $('#loc_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcsupp_code = $('#supp_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/stock"
                + "&stk_date=" + lcstk_date
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&supp_code=" + lcsupp_code
                + "&group_by=" + lcgroup_by
                + "&loc_code=" + loc_code;

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
