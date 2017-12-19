<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Customer", "1"),
    array("Invoice Type", "2"),
    array("Payment Type", "3")
);

$optInvoice = array
    (
    array('All', ''),
    array('ARC', 'ARC'),
    array('ASA', 'ASA'),
    array('ASC', 'ASC'),
    array('ASW', 'ASW')
);


$site_url = str_replace("loader_rpt.php", '', $site_url);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Accessories Account Receivable Payment Report</h1>
        <div class="single-form teen-margin">
            <table> 
                <tr>
                    <td><?php getCaption('Tanggal Bayar'); ?></td>
                    <td class="td-ro">:</td>
                    <td colspan="3">
                        <?php datebox2('date1') ?>
                        <?php datebox2('date2') ?>
                    </td>
                </tr>
                <?php
  

                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
            </table>
        </div>

        <div class="single-form">  
            <table>
                <table>		
                    <strong> FILTER BY </strong>
                    <table>
                        <?php
                        cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                        localcombobox('sinv_code', 'Jenis Faktur', 160, $optInvoice);
                        cmdPayType('pay_type', 'Jenis Bayar', $site_url, 100);
                        ?>

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
                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('save2xls')">Save To Excel</a>
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
        
        $('#date1').datebox('setValue', ldServer);
        $('#date2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#date1').datebox('enable');
        $('#date2').datebox('enable');
        $('#group_by').combobox('enable');
        //$('#sinv_code').combobox('enable');
      //  $('#pay_type').combogrid('enable');
        $('#cust_name').combogrid('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcso_date1 = $('#date1').datebox('getValue');
        lcso_date2 = $('#date2').datebox('getValue');
        if ((lcso_date1.length == 0) || (lcso_date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

       date1 = $('#date1').datebox('getValue');
       date2 = $('#date2').datebox('getValue');
       group_by = $('#group_by').combobox('getValue');
       sinv_code = $('#sinv_code').combobox('getValue');
        pay_type = $('#pay_type').combogrid('getValue');
         cust_name = $('#cust_name').combogrid('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/bayarpiutangacc"
                + "&output=" + lcOutput
                + "&date1=" + date1
                + "&date2=" + date2
                + "&group_by=" + group_by
                + "&sinv_code=" + sinv_code
                + "&pay_type=" + pay_type
                + "&cust_name=" + cust_name;

        var win = window.open(URL, "_blank", strWindowFeatures);
    }

    $("#group_by").combobox({
        onChange: function () {

            $('#cust_name').val('');
            $('.easyui-combogrid').combogrid('setValue', '');
            $('#sinv_code').combobox('setValue', '');


            $('#sinv_code').combogrid('disable');
            $("#cust_name").combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#cust_name").combogrid('enable');
            }
            if (group == '2') {
                $('#sinv_code').combogrid('enable');
            }
            if (group == '3') {
                $('#pay_type').combogrid('enable');
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
