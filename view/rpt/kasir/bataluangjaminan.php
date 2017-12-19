<?php
$form = 'rpt_batalUJ';
$table = "";
$lookup = 'mst/' . $table;

$stat = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);

$optGroupBy = array
    (
    array("Customer", "1"),
    array("Payment Type", "2"),
    array("EDC Engine", "3")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
       
        <div class="single-form teen-margin">
            <table >
                <tr><td colspan="3"> <h1 style="font-size:20px"><u>Down Payment Cancellation Report</u></h1></td></tr>
                <?php
                localcombobox('cls_date', 'Cetak Faktur', 200, $stat);
                datebox('opn_date1', 'Tgl. Batal', 200);
                datebox('opn_date2', 's/d', 200);
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
                        ?>
                        <tr> <td><?php getCaption('Cara Bayar'); ?> </td>
                            <td style="max-width: 5px !important;" class="td-ro">:</td>
                            <td><input class="easyui-combogrid" id="pay_type"	name="pay_type" style="width:200" disabled=true
                                       data-options="panelWidth: 300,panelHeight:340,delay: 500,method:'post',
                                       idField:'pay_type',textField:'pay_name',fitColumns: true,mode:'remote', pagination:true,
                                       remoteSort:true,multiSort:true,required:false,loadMsg:'Please wait...',editable:false,
                                       url:'services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name',
                                       columns: [[               
                                       {field:'pay_type',title:'Type',width:80,sortable:true},
                                       {field:'pay_name',title:'Name',width:230,sortable:true},
                                       ]],
                                       " >
                                </input></td></tr>
                        <?php cmdEDC('edc_code', 'Mesin EDC'); ?>
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
         
        $('#opn_date1').datebox('setValue', date1);
        $('#opn_date2').datebox('setValue', date2);
        
        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");
        $("#cls_date").datebox('enable');
        $('#opn_date1').datebox('enable');
        $('#opn_date2').datebox('enable');
        $('#so_no').attr('disabled', false);
        $('#group_by').combobox('enable');
        $('#cust_name').combogrid('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        opn_date1 = $('#opn_date1').datebox('getValue');
        opn_date2 = $('#opn_date2').datebox('getValue');

        if ((opn_date1.length == 0) || (opn_date2.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong", "Tanggal tidak boleh kosong");
            return false;
        }
        cls_date = $('#cls_date').combobox('getValue');
        group_by = $('#group_by').combobox('getValue');
        cust_code = $('#cust_code').val();
        edc_code = $('#edc_code').combogrid('getValue');
        pay_type = $('#pay_type').combogrid('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/bataluangjaminan"
                + "&output=" + lcOutput
                + "&opn_date1=" + opn_date1
                + "&opn_date2=" + opn_date2
                + "&group_by=" + group_by
                + "&cust_code=" + cust_code
                + "&edc_code=" + edc_code
                + "&cls_date=" + cls_date
                + "&pay_type=" + pay_type;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

    $("#group_by").combobox({
        onChange: function () {
            $("#cust_code").val('');
            //$('#<?php echo $form; ?> input:text').val('');
            $('#<?php echo $form; ?> .easyui-combogrid').combogrid('setValue', '');

            $("#cust_name").combogrid('disable');
            $("#edc_code").combogrid('disable');
            $("#pay_type").combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#cust_name").combogrid('enable');
            }
            if (group == '2') {
                $("#pay_type").combogrid('enable');
            }
            if (group == '3') {
                $("#edc_code").combogrid('enable');
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
</script>
