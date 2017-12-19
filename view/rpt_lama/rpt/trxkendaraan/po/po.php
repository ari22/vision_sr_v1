<?php
//==========CHANGE LOG=======
//tambah biar otomatis keisi waktu baru buka

$form = 'rpt_po';
$table = "";
$lookup = 'mst/' . $table;
$spk = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
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
    array("Supplier", "3"),
    array("Warehouse", "4"),
);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Vehicle Purchase Order (PO) Report</h1>

        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('po_cls', 'Cetak Faktur PO', 200, $spk);
                datebox('po_date1', 'Tanggal PO', 200);
                datebox('po_date2', 's/d1', 200);
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
                cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                cmdWrhs('wrhs_code', 'Warehouse');
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
        $('#po_date1').datebox('setValue', ldServer);
        $('#po_date2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");
        $('#po_cls').combobox('enable');
        $('#po_date1').datebox('enable');
        $('#po_date2').datebox('enable');
        
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

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

            }
        });
        
        $('#veh_name').combogrid('enable');
        $('#group_by').combobox('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcpo_cls = $('#po_cls').combobox('getValue');
        lcpo_date1 = $('#po_date1').datebox('getValue');
        lcpo_date2 = $('#po_date2').datebox('getValue');
        if ((lcpo_date1.length == 0) || (lcpo_date2.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcsupp_code = $('#supp_code').val();
        lcgroup_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/po/po"
                + "&po_cls=" + lcpo_cls
                + "&po_date1=" + lcpo_date1
                + "&po_date2=" + lcpo_date2
                + "&wrhs_code=" + lcwrhs_code
                + "&output=" + lcOutput
                + "&veh_code=" + lcveh_code
                + "&color_code=" + lccolor_code
                + "&supp_code=" + lcsupp_code
                + "&group_by=" + lcgroup_by;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
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
