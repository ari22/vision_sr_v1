<?php
$form = 'rpt_argd';
$table = "";
$lookup = 'mst/' . $table;
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Vehicle Account Group Receivable Report</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                datebox('arg_date1', 'Tanggal Bayar', 200);
                datebox('arg_date2', 's/d', 200);
                ?>
            </table>
        </div>

        <div  class="single-form">  
            <table >
                <table>		
                    <strong> FILTER BY </strong>

                    <table>
                        <?php
                        cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                        $url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
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


                    </table>
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
        var ldServer = '<?php echo date('Y-m-d'); ?>';
        $('#arg_date1').datebox('setValue', ldServer);
        $('#arg_date2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#arg_date1').datebox('enable');
        $('#arg_date2').datebox('enable');
        $('#so_no').attr('disabled', false);
        $('#cust_name').combogrid('enable');
        $('#pay_type').combogrid('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcarg_date1 = $('#arg_date1').datebox('getValue');
        lcarg_date2 = $('#arg_date2').datebox('getValue');
        if (lcarg_date1.length == 0 || lcarg_date2.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        lcpay_type = $('#pay_type').combogrid('getValue');
        lccust_code = $('#cust_code').val();
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/pembayaranpiutangkendaraangabungan"
                + "&output=" + lcOutput
                + "&arg_date1=" + lcarg_date1
                + "&arg_date2=" + lcarg_date2
                + "&cust_code=" + lccust_code
                + "&pay_type=" + lcpay_type
                ;
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


</script>
