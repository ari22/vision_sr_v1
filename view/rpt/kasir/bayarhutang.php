<?php
$form = 'rpt_ard';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Supplier", "1"),
    array("Payment Type", "2"),
);
$optSortBy = array
    (
    array("Invoice No.", "1"),
    array("Invoice Date", "2")
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
                        cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                         ?>
                         
                        <tr> <td><?php getCaption('Cara Bayar'); ?> </td>
                            <td style="max-width: 5px !important;" class="td-ro">:</td>
                            <td><table class="marginmin"><?php   cmdPayType('pay_type', '', $site_url); ?></table></td>
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

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $('#supp_name').combogrid('enable');
                }
                if (group == 2) {
                    $('#pay_type').combogrid('enable');
                }

            }
        });

        $('#group_by').combobox('enable');
        $('#supp_name').combogrid('enable');


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
        lcpay_type = $('#pay_type').combogrid('getValue');
        lcsupp_code = $('#supp_code').val();
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/pembayaranhutangkendaraan"
                + "&output=" + lcOutput
                + "&pay_date1=" + lcpay_date1
                + "&pay_date2=" + lcpay_date2
                + "&supp_code=" + lcsupp_code
                + "&pay_type=" + lcpay_type
                + "&group_by=" + lcgroup_by
                ;
        
                URL = URL + '#toolbar=0';
    if (lcOutput !== 'screen') {
        $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            } else {
                var win = window.open(URL, "_blank", strWindowFeatures);
                }
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


</script>
