<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Date", "1"),
    array("Supplier", "2"),
);
$optSortBy = array
    (
    array("Invoice No.", "1"),
    array("Invoice Date", "2")
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Vehicle Account Payable Report</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                datebox('ap_date', 'Tanggal Bayar', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                ?>
            </table>
        </div>

        <div  class="single-form">  
            <table >
                <table>		
                    <strong> FILTER BY </strong>

                    <table>
                        <?php
                        cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                        ?>

                        <?php
                        localcombobox('l_aging', 'Penuaan', 60, $aging);
                        cmdWrhs('wrhs_code', 'Warehouse');
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
        $('#ap_date').datebox('setValue', ldServer);

        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#ap_date').datebox('enable');
        $('#so_no').attr('disabled', false);
        $('#group_by').combobox('enable');
        $('#l_aging').combobox('enable');
        $('#supp_name').combogrid('enable');
        $('#wrhs_code').combogrid('enable');

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

        lcgroup_by = $('#group_by').combobox('getValue');
        lcaging = $('#l_aging').combobox('getValue');

        lcsupp_code = $('#supp_code').val();
        lcwrhs_code = $('#wrhs_code').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangkendaraan"
                + "&output=" + lcOutput
                + "&ap_date=" + lcap_date
                + "&supp_code=" + lcsupp_code
                + "&wrhs_code=" + lcwrhs_code
                + "&group_by=" + lcgroup_by
                + "&l_aging=" + lcaging
                ;
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

</script>
