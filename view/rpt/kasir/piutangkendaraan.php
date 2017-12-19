<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    //array("Tanggal","1"),
    array("Customer", "1"),
    array("Sales", "2"),
    array("Invoice Type", "3"),
    array("Leasing", "4")
);
$optSortBy = array
    (
    array("Invoice No.", "1"),
    array("Date", "2")
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
$optAging = array
    (
    array("By Due Date", "1"),
    array("By Invoice Date", "2"),
);
$rptType = array(
        array("Report Beginning Balance on the first day of the current ", "1"),
        array("Beginning Balance Today", "2"),
);
$optInvoice = array
    (
    array("ALL", ""),
    array("VEHICLE DOCUMENT ", "VDM"),
    array("SALES", "VSL"),
    array("SALES RETURN", "VRS"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table> 
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                datebox('ar_date', 'Piutang Per Tanggal', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                 localcombobox('rpt_by', 'Jenis Laporan', 350, $rptType);
                ?>
                 <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div class="single-form">  
                    <table>
                         <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                        <?php
                        cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                        cmdSalSet('srep_code', 'srep_name', 'Nama Sales');
                        $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
                
                        localcombobox('l_sinv_code', 'Jenis Faktur', 160, $optInvoice);
                        
                        cmdLeaseSet('lease_code', 'lease_name', 'Leasing');
                        localcombobox('l_aging', 'Penuaan', 60, $aging);
                        localcombobox('age', 'Dengan Umur Piutang', 120, $optAging);
                        cmdWrhs('wrhs_code', 'Warehouse');
                        ?>
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
        var ldServer = '<?php echo date('Y-m-d'); ?>';
        $('#ar_date').datebox('setValue', ldServer);

        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");
        /*
         * $optGroupBy = array
         (
         array("Tanggal","1"),
         array("Customer","2"),
         array("Sales","3"),
         array("Faktur","4"),
         array("Leasing","5")
         );
         */
        /*
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $('#cust_name').combogrid('enable');
                }
                if (group == 2) {
                    $('#srep_name').combogrid('enable');
                }

                if (group == 4) {
                    $('#lease_name').combogrid('enable');
                }
            }
        });
        */
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
        $('#cust_name').combogrid('enable');
        $('#srep_name').combogrid('enable');
        $('#lease_name').combogrid('enable');
        $('#l_sinv_code').combogrid('enable');
        $('#ar_date').datebox('enable');
        $('#group_by').combobox('enable');
        $('#rpt_by').combobox('enable');
        $('#l_aging').combobox('enable');

        $('#cust_name').combogrid('enable');
        $('#wrhs_code').combogrid('enable');


    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcar_date = $('#ar_date').datebox('getValue');

        if (lcar_date.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        
        lcrpt_by = $('#rpt_by').combobox('getValue');
        lcgroup_by = $('#group_by').combobox('getValue');
        lcaging = $('#l_aging').combobox('getValue');
        l_sinv_code = $('#l_sinv_code').combogrid('getValue');
        lccust_code = $('#cust_code').val();
        lcsrep_code = $('#srep_code').val();
        lclease_code = $('#lease_code').val();
        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        aging = $('#age').combobox('getValue');
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/piutangkendaraan"
                + "&output=" + lcOutput
                + "&ar_date=" + lcar_date
                + "&cust_code=" + lccust_code
                + "&srep_code=" + lcsrep_code
                + "&wrhs_code=" + lcwrhs_code
                + "&lease_code=" + lclease_code
                + "&sinv_code=" + l_sinv_code
                + "&group_by=" + lcgroup_by
                + "&l_aging=" + lcaging
                + "&aging=" + aging
                + "&rpt_by=" + lcrpt_by
                ;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
    $("#l_aging").combobox({
        onChange: function () {
            //$('#age').combobox('setValue', '');
            $("#age").combobox('disable');

            var age = $(this).combobox('getValue');

            if (age == '1') {
                $("#age").combobox('enable');
            }


        }
    });
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
