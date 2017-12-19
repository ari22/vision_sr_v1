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
    array("Tidak", "0"),
    array("Ya", "1"),
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
    array("Leasing", "6")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Laporan Penjualan Kendaraan</h1>

        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('sal_cls', 'Cetak Faktur', 200, $spk);
                datebox('sal_date1', 'Tanggal Faktur', 200);
                datebox('sal_date2', 's/d', 200);
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
                localcombobox('l_sal_price', 'Harga Jual', 60, $harga);
                ?>
            </table>
        </div>

        <div class="main-nav">
            <table>		
                <tr>
                    <td >
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
           var ldServer = '<?php echo date('y-m-d'); ?>';
        $('#sal_date1').datebox('setValue', ldServer);
        $('#sal_date2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {

        //window.alert("masuk");
        $('#sal_cls').combobox('enable');
        $('#sal_date1').datebox('enable');
        $('#sal_date2').datebox('enable');
        $('#veh_name').combogrid('enable');
        $('#color_name').combogrid('enable');
        $('#cust_name').combogrid('enable');
        $('#srep_name').combobox('enable');
        $('#sspv_name').combobox('enable');
        $('#wrhs_code').combobox('enable');
        $('#cust_type').combobox('enable');
        $('#group_by').combobox('enable');
        $('#l_sal_price').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcsal_cls = $('#sal_cls').combobox('getValue');
        lcsal_date1 = $('#sal_date1').datebox('getValue');
        lcsal_date2 = $('#sal_date2').datebox('getValue');
        if ((lcsal_date1.length == 0) || (lcsal_date2.length == 0))
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
        lcsal_price = $('#l_sal_price').combobox('getValue');
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/penjualan"
                + "&sal_cls=" + lcsal_cls
                + "&sal_date1=" + lcsal_date1
                + "&sal_date2=" + lcsal_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&cust_type=" + lccust_type
                + "&cust_code=" + lccust_code
                + "&srep_code=" + lcsrep_code
                + "&sspv_code=" + lcsspv_code
                + "&group_by=" + lcgroup_by
                + "&l_sal_price=" + lcsal_price;
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
