<?php
$form = 'rpt_hutangbbn';
$optGroupBy = array
    (
    array("Date", "1"),
    array("Customer", "2")
);
$optRptType = array
    (
    array("Saldo Awal Per Awal Periode", "1"),
    array("Saldo Awal Terkini", "2")
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
$optAgingSortBy = array
    (
    array("Due Date", "1"),
    array("Invoice Date", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Optional Account Payable Purchase Report</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                datebox('ap_date', 'Hutang Per Tanggal', 200);
                cmdAccSuppSet('supp_code', 'supp_name', 'Supplier');
                localcombobox('rpt_type', 'Jenis Laporan', 240, $optRptType);
                localcombobox('l_aging', 'Penuaan', 60, $aging);
                localcombobox('aging_sortby', 'Urut', 100, $optAgingSortBy);
                ?>
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
        $('#ap_date').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#ap_date').datebox('enable');
        $('#supp_name').combogrid('enable');
        $('#rpt_type').combobox('enable');
        $('#l_aging').combobox('enable');
        $('#aging_sortby').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcap_date = $('#ap_date').datebox('getValue');

        if ((lcap_date.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        //lcgroup_by = $('#group_by').combobox('getValue');
        lcsupp_code = $('#supp_code').val();
        lcaging = $('#l_aging').combobox('getValue');
        lcaging_sortby = $('#aging_sortby').combobox('getValue');
        lcrpt_type = $('#rpt_type').combobox('getValue');
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangoptional"
                + "&output=" + lcOutput
                + "&ap_date=" + lcap_date
                + "&supp_code=" + lcsupp_code
                + "&l_aging=" + lcaging
                + "&aging_sortby=" + lcaging_sortby
                + "&rpt_type=" + lcrpt_type;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
    ;
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
