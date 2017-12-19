<?php
$form = 'rpt_ard';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Customer", "1"),
    array("Invoice Type", "2"),
    array("Payment Type", "3"),
);
$optSortBy = array
    (
    array("Invoice No.", "1"),
    array("Date", "2")
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
                datebox('pay_date1', 'Tanggal Bayar', 200);
                datebox('pay_date2', 's/d', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
                <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div  class="single-form">  	
            <table>
                <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                <?php
                cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
                ?>
                <?php
                localcombobox('l_sinv_code', 'Jenis Faktur', 160, $optInvoice);
                ?>
                <tr> <td><?php getCaption('Cara Bayar'); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td><table class="marginmin"><?php cmdPayType('pay_type', '', $site_url); ?></table></td>
                </tr>

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

        $('#pay_date1').datebox('setValue', date1);
        $('#pay_date2').datebox('setValue', date2);

        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#pay_date1').datebox('enable');
        $('#pay_date2').datebox('enable');
        $('#so_no').attr('disabled', false);
        $('#group_by').combobox('enable');
        $('#l_sinv_code').combobox('disable');
        $('#cust_name').combogrid('enable');
        $('#pay_type').combogrid('disable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcpay_date1 = $('#pay_date1').datebox('getValue');
        lcpay_date2 = $('#pay_date2').datebox('getValue');
        if (lcpay_date1.length == 0 || lcpay_date2.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        lcgroup_by = $('#group_by').combobox('getValue');
        lcsinv_code = $('#l_sinv_code').combobox('getValue');
        lcpay_type = $('#pay_type').combogrid('getValue');
        lccust_code = $('#cust_code').val();

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/pembayaranpiutangkendaraan"
                + "&output=" + lcOutput
                + "&pay_date1=" + lcpay_date1
                + "&pay_date2=" + lcpay_date2
                + "&cust_code=" + lccust_code
                + "&pay_type=" + lcpay_type
                + "&group_by=" + lcgroup_by
                + "&l_sinv_code=" + lcsinv_code
                ;

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

    $("#group_by").combobox({
        onChange: function () {

            $('#rpt_ard .easyui-combogrid').combogrid('setValue', '');
            $('#rpt_ard .easyui-combogrid').combogrid('disable');

            $('#l_sinv_code').combobox('setValue', '');
            $('#l_sinv_code').combobox('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#cust_name").combogrid('enable');
            }

            if (group == '2') {
                $("#l_sinv_code").combogrid('enable');
            }

            if (group == '3') {
                $("#pay_type").combogrid('enable');
            }
        }
    });


</script>
