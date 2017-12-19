<?php
//==========CHANGE LOG=======
//tambah biar otomatis keisi waktu baru buka

$form = 'rpt_retur_penjualan';
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
    array("End User", "1"),
    array("Dealer/Reseller", "2"),
    array("Goverment/BUMN", "3"),
);
$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Color", "2"),
    array("Dealer / Reseller", "3"),
    array("Customer", "4"),
    array("Sales Name", "5"),
    array("Warehouse", "6")

);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Vehicle Sales Return Report</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('rsal_cls', 'Cetak Faktur Jual', 200, $spk);
                datebox('rsl_date1', 'Tgl. Faktur Jual', 200);
                datebox('rsl_date2', 's/d1', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
            </table>
        </div>

        <div  class="single-form">
            <strong> FILTER BY </strong>

            <table>
                <?php
                cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                cmdColSet('color_code', 'color_name', 'Warna');
                localcombobox('cust_type', 'Jenis Pelanggan', 200, $optCust);
                cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                cmdSalSet('srep_code', 'srep_name', 'Nama Sales');
                cmdSpvSet('sspv_code', 'sspv_name', 'Supervisor');
                cmdWrhs('wrhs_code', 'Warehouse');
                localcombobox('l_rsal_price', 'Harga Jual', 60, $harga);
                ?>
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
        //console.log( "ready!" );
        var ldServer = '<?php echo date('Y-m-d');?>';
        $('#rsl_date1').datebox('setValue', ldServer);
        $('#rsl_date2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");
        $('#rsal_cls').combobox('enable');
        $('#rsl_date1').datebox('enable');
        $('#rsl_date2').datebox('enable');
        $('#veh_name').combogrid('enable');
        $('#color_name').combogrid('enable');
        $('#cust_name').combogrid('enable');
        $('#srep_name').combobox('enable');
        $('#sspv_name').combobox('enable');
        $('#wrhs_code').combobox('enable');
        $('#cust_type').combobox('enable');
        $('#group_by').combobox('enable');
        $('#l_rsal_price').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcrsal_cls = $('#rsal_cls').combobox('getValue');
        lcrsl_date1 = $('#rsl_date1').datebox('getValue');
        lcrsl_date2 = $('#rsl_date2').datebox('getValue');
        if ((lcrsl_date1.length == 0) || (lcrsl_date2.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lccust_type = $('#cust_type').combobox('getValue');
        lccust_code = $('#cust_code').val();
        lcsrep_code = $('#srep_code').val();
        lcsspv_code = $('#sspv_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');
        lcrsal_price = $('#l_rsal_price').combobox('getValue');
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/returpenjualan"
                + "&rsal_cls=" + lcrsal_cls
                + "&rsl_date1=" + lcrsl_date1
                + "&rsl_date2=" + lcrsl_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&cust_type=" + lccust_type
                + "&cust_code=" + lccust_code
                + "&srep_code=" + lcsrep_code
                + "&sspv_code=" + lcsspv_code
                + "&group_by=" + lcgroup_by
                + "&l_rsal_price=" + lcrsal_price;
        var win = window.open(URL, "_blank", strWindowFeatures);
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
</script>
