<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Supplier", "1"),
    array("Invoice Type", "2")
);

$optInvoice = array
    (
            array('All', ''),
            array('APR', 'APR'),
            array('APW', 'APW')
);

$optReport = array
    (
    array("Saldo Awal Per Awal Periode", "1"),
    array("Saldo Awal Terkini", "2"),
);

$optAging = array
    (
    array("",""),
    array("Berdasarkan Tanggal Jatuh Tempo", "1"),
    array("Berdasarkan Tanggal Faktur", "2"),
);

$optAge = array(
     array("No", "1"),
    array("Yes", "2"),
);

?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Accessories Account Payable Report</h1>
        <div class="single-form teen-margin">
            <table> 
                <?php
                datebox('date', 'Tanggal Bayar', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                localcombobox('report_by', 'Jenis Laporan', 200, $optReport);
                localcombobox('age', 'Aging Active', 70, $optAge);
     
                ?>
            </table>
        </div>

        <div class="single-form">  
            <table>
                <table>		
                    <strong> FILTER BY </strong>
                    <table>
                        <?php
                            cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                            localcombobox('pinv_code', 'Jenis Faktur', 160, $optInvoice);
                            localcombobox('aging', 'Dengan Umur Piutang', 250, $optAging);
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
        $('#date').datebox('setValue', ldServer);

        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#date').datebox('enable');
        $('#group_by').combobox('enable');
        $('#report_by').combobox('enable');
        $('#age').combobox('enable');       
       // $('#pinv_code').combobox('enable');
        //$('#aging').combobox('enable');             
        $('#supp_name').combogrid('enable');
       
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcar_date = $('#date').datebox('getValue');

        if (lcar_date.length == 0)
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }
        
        date = $('#date').datebox('getValue');
        group_by = $('#group_by').combobox('getValue');
        report_by = $('#report_by').combobox('getValue');
        pinv_code = $('#pinv_code').combobox('getValue');
        aging = $('#aging').combobox('getValue');             
        supp_name = $('#supp_name').combogrid('getValue');
        
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangacc"
                + "&output=" + lcOutput
                + "&date=" + date
                + "&group_by=" + group_by
                + "&report_by=" + report_by
                + "&pinv_code=" + pinv_code
                + "&aging=" + aging
                + "&supp_name=" + supp_name;
        
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
    
     $("#group_by").combobox({
        onChange: function () {

            $('#supp_name').val('');
            $('.easyui-combogrid').combogrid('setValue', '');
             $('#pinv_code').combobox('setValue', '');
            

            $('#pinv_code').combogrid('disable');
            $("#supp_name").combogrid('disable');

            var group = $(this).combobox('getValue');

            if (group == '1') {
                $("#supp_name").combogrid('enable');
            }
            if (group == '2') {
               $('#pinv_code').combogrid('enable');
            }
            
        }
    });
    
    $("#age").combobox({
        onChange: function () {
             $('#aging').combobox('setValue', '');
            $("#aging").combobox('disable');

            var age = $(this).combobox('getValue');

            if (age == '2') {
                $("#aging").combobox('enable');
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
    
    
</script>
