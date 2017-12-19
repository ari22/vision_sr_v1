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
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Vehicle Stock Report</h1>
        <div class="single-form teen-margin">
            <table >
                <?php
                // localcombobox('so_cls', 'Cetak SPK', 200, $spk);
                datebox('stk_date', 'Per Tanggal', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
            </table>
        </div>
        <div  class="single-form">
            <table >
                <table>

                    <strong> FILTER BY </strong>

                    <table>
                        <?php
                        cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                        cmdColSet('color_code', 'color_name', 'Warna');
                        // localcombobox('cust_type', 'Jenis Pelanggan', 200, $optCust);
                        cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                        //cmdSalSet('srep_code', 'srep_name', 'Nama Sales');
                        //cmdSpvSet('sspv_code', 'sspv_name', 'Supervisor');
                        cmdWrhs('wrhs_code', 'Warehouse');
                        ?>
                    </table>

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
        setEnable();
        var ldServer = '<?php echo date('Y-m-d');?>';
        $('#stk_date').datebox('setValue', ldServer);
        $(".loader").hide(1000);
    });
    function setEnable()
    {

        $('#stk_date').datebox('enable');
        $('#veh_name').combogrid('enable');
        $('#color_name').combogrid('enable');
        $('#supp_name').combogrid('enable');
        $('#wrhs_code').combobox('enable');
        $('#group_by').combobox('enable');

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
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcsupp_code = $('#supp_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/stock"
                + "&stk_date=" + lcstk_date
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&supp_code=" + lcsupp_code
                + "&group_by=" + lcgroup_by;
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
