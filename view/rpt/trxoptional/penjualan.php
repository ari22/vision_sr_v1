<?php
//========CHANGE LOG========
//tanggal otomatis hari ini
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$cls = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
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
    array("Invoice No. & Invoice Date", "1"),
    array("Invoice Date & Invoice No.", "2"),
    array("Work Code", "3"),
    array("Customer", "4"),
    array("Sales", "5")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">

        <div class="single-form teen-margin">
            <table >
                <tr><td colspan="3"> <h1 style="font-size:18px"><u><?php echo strtoupper($text); ?> REPORT</u></h1></td></tr>
                <?php
                localcombobox('cls', 'Cetak Faktur Jual', 200, $cls);
                datebox('date1', 'Tgl. Terima', 200);
                datebox('date2', 's/d1', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);
                ?>
                 <tr><td class="col120"></td></tr>
            </table>
        </div>
        <div  class="single-form">

            <strong> FILTER BY </strong>

            <table>
                <?php cmdAccWorkOptSet('wk_code', 'wk_desc', 'Kode Pekerjaan', 100, 242); ?>
                <?php cmdAccCust('cust_code', 'cust_name', 'Pelanggan', 100, 242); ?>
                <?php cmdAccSalesPerson('srep_code', 'srep_name', 'Sales', 100, 242); ?>
                <?php cmdWrhs('wrhs_code', 'Warehouse', 200); ?>
                 <tr><td class="col120"></td></tr>
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

        $(".loader").hide(1000);
        $('#date1').datebox('setValue', date1);
        $('#date2').datebox('setValue', date2);
        setEnable();

        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");
        $("#wrhs_code").combogrid('enable');
        $('#cls').combobox('enable');
        $('#date1').datebox('enable');
        $('#date2').datebox('enable');

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 3) {
                    $('#wk_desc').combogrid('enable');
                }
                if (group == 4) {
                    $('#cust_name').combogrid('enable');
                }
                if (group == 5) {
                    $('#srep_name').combogrid('enable');
                }
                $("#wrhs_code").combogrid('enable');
            }
        });

        $('#group_by').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        cls = $('#cls').combobox('getValue');
        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');

        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        wrhs_code = $("#wrhs_code").combogrid('getValue');
        wk_code = $('#wk_code').val();
        cust_code = $('#cust_code').val();
        srep_code = $('#srep_code').val();
        group_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/optional"
                + "&table=<?php echo $name; ?>"
                + "&cls=" + cls
                + "&date1=" + date1
                + "&date2=" + date2
                + "&wk_code=" + wk_code
                + "&cust_code=" + cust_code
                + "&srep_code=" + srep_code
                + "&group_by=" + group_by
                + "&wrhs_code=" + wrhs_code
                + "&title=Penjualan Optional"
                + "&output=" + lcOutput;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

    $('#wk_desc').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#wk_code").val(row.wk_code);
            }
        },
        onChange: function () {
            if ($('#wk_desc').combogrid('getValue') == '')
            {
                $("#wk_code").val('');
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
    $('#srep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#srep_code").val(row.srep_code);
            }
        },
        onChange: function () {
            if ($('#srept_name').combogrid('getValue') == '')
            {
                $("#srep_code").val('');
            }
        }

    });
</script>
