<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    //array("Tanggal","1"),
    array("Supplier", "1"),
    array("Invoice Type", "2"),
    array("Vehicle Code", "3")
);
$optSortBy = array
    (
    array("Invoice No.", "1"),
    array("Invoice Date", "2")
);
$optInvoice = array
    (
    array("ALL", "")
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1")
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
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table>
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                datebox('ap_date', 'Hutang Per Tanggal', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                localcombobox('rpt_by', 'Jenis Laporan', 350, $rptType);
                ?>
                 <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div  class="single-form">  
                    <table>
                         <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                        <?php
                        cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                        localcombobox('l_pinv_code', 'Jenis Faktur', 160, $optInvoice);
                        cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                        localcombobox('l_aging', 'Penuaan', 60, $aging);
                        localcombobox('age', 'Dengan Umur Piutang', 100, $optAging);
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
        $('#ap_date').datebox('setValue', ldServer);

        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#ap_date').datebox('enable');
        $('#so_no').attr('disabled', false);
        $('#group_by').combobox('enable');
        $('#l_aging').combobox('enable');
        $('#supp_name').combogrid('enable');
        $('#l_pinv_code').combogrid('enable');
        $('#veh_name').combogrid('enable');
        $('#wrhs_code').combogrid('enable');
        $('#rpt_by').combobox('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');

    }
    function doSearch(lcOutput)
    {

        url = "services/runCRUD.php";

        lcap_date = $('#ap_date').datebox('getValue');

        if (lcap_date.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        lcrpt_by = $('#rpt_by').combobox('getValue');
        lcgroup_by = $('#group_by').combobox('getValue');
        lcsupp_code = $('#supp_code').val();

        lcwrhs_code = $('#wrhs_code').combogrid('getValue');
        lcpinv_code = $('#l_pinv_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lcaging = $('#l_aging').combobox('getValue');
        aging = $('#age').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangkendaraan"
                + "&output=" + lcOutput
                + "&ap_date=" + lcap_date
                + "&supp_code=" + lcsupp_code
                + "&wrhs_code=" + lcwrhs_code
                + "&group_by=" + lcgroup_by
                + "&l_aging=" + lcaging
                + "&veh_code=" + lcveh_code
                + "&l_pinv_code=" + lcpinv_code
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

    $("#group_by").combobox({
        onChange: function () {

            $('#rpt_uj .easyui-combogrid').combogrid('setValue', '');
            $('#rpt_uj .easyui-combogrid').combogrid('disable');
            $('#l_pinv_code').combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#supp_name").combogrid('enable');
            }
            if (group == '2') {
                $("#l_pinv_code").combogrid('enable');
            }
            if (group == '3') {
                $("#veh_name").combogrid('enable');
            }
            //$("#veh_name").combogrid('enable');
            $("#wrhs_code").combogrid('enable');
        }
    });
</script>
