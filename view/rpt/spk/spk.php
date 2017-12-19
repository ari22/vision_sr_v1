<?php
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
    array("Customer", "3"),
    array("Sales Name", "4"),
    array("Warehouse", "5"),
    array("City", "7"),
    array("Leasing", "6")
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
                            localcombobox('so_cls', 'Cetak SPK', 200, $spk);
                            datebox('so_date1', 'Tanggal SPK', 200);
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
                            // localcombobox('cust_type', 'Jenis Pelanggan', 200, $optCust);
                            cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                            cmdSalSet('srep_code', 'srep_name', 'Nama Sales');
                            cmdSpvSet('sspv_code', 'sspv_name', 'Supervisor');
                            cmdWrhs('wrhs_code', 'Warehouse');
                            cmdCity('cust_city', 'Kota', 120);
                            cmdLeaseSet('lease_code', 'lease_name', 'Leasing');
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


    $(document).ready(function ()
    {
        //console.log( "ready!" );

        $('#so_date1').datebox('setValue', date1);
        $('#so_date2').datebox('setValue', date2);
        setEnable();

        $(".loader").hide(1000);
        version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");
        $('#so_cls').combobox('enable');
        $('#so_date1').datebox('enable');
        $('#so_date2').datebox('enable');

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('enable');
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
                 $('#cust_name').combogrid('enable');
                 }
                 if (group == 4) {
                 $('#srep_name').combobox('enable');
                 $('#sspv_name').combobox('enable');
                 }
                 if (group == 5) {
                 $('#wrhs_code').combobox('enable');
                 }
                 if (group == 6) {
                 $('#wrhs_code').combobox('enable');
                 }
                 */
                $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
            }
        });

        $('#group_by').combobox('enable');
        $('.easyui-combogrid').combogrid('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
        /* 
         
         
         
         $('#sspv_name').combobox('enable');
         
         $('#cust_type').combobox('enable');
         $('#group_by').combobox('enable');*/

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcso_cls = $('#so_cls').combobox('getValue');
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
        // lccust_type = $('#cust_type').combobox('getValue');
        lccust_code = $('#cust_code').val();
        lcsrep_code = $('#srep_code').val();
        lcsspv_code = $('#sspv_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');
        lcust_city = $("#cust_city").combogrid('getValue');
        lclease_code = $('#lease_code').val();

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        //var strWindowFeatures = "scrollbars=1,fullscreen=yes,status=no,toolbar=no,menubar=no,location=no";

        var URL = url + "?lookup=rpt/spk"
                + "&so_cls=" + lcso_cls
                + "&so_date1=" + lcso_date1
                + "&so_date2=" + lcso_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&cust_city=" + lcust_city
                + "&cust_code=" + lccust_code
                + "&srep_code=" + lcsrep_code
                + "&sspv_code=" + lcsspv_code
                + "&group_by=" + lcgroup_by
                + "&lease_code=" + lclease_code;

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
    $('#cust_type').combobox({
        onSelect: function (index, row) {
            if (row) {
                $("#cust_code").val('');
                $("#cust_name").combogrid('setValue', '');
                $('#cust_name').combogrid({queryParams: {cust_type: $('#cust_type').combogrid('getValue')}})
                $('#cust_name').combogrid('enable');
            }
        },
        onChange: function () {
            $("#cust_code").val('');
            $("#cust_name").combogrid('setValue', '');
            $('#cust_name').combogrid({queryParams: {cust_type: $('#cust_type').combogrid('getValue')}})
            $('#cust_name').combogrid('enable');
        },
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
    $('#srep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#srep_code").val(row.srep_code);
            }
        },
        onChange: function () {
            if ($('#srep_name').combogrid('getValue') == '')
            {
                $("#srep_code").val('');
            }
        }
    });
    $('#sspv_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#sspv_code").val(row.sspv_code);
            }
        },
        onChange: function () {
            if ($('#sspv_name').combogrid('getValue') == '')
            {
                $("#sspv_code").val('');
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

    $('#lease_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#lease_code").val(row.lease_code);
            }
        },
        onChange: function () {
            if ($('#lease_name').combogrid('getValue') == '')
            {
                $("#lease_code").val('');
            }
        }
    });
</script>
