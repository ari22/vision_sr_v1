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
    array("Report Beginning Balance on the first day of the current ", "1"),
    array("Beginning Balance Today", "2"),
);

$optAging = array
    (
    array("By Due Date", "1"),
    array("By Invoice Date", "2"),
);

$optAge = array(
    array("No", "1"),
    array("Yes", "2"),
);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >

        <div class="single-form teen-margin">
            <table> 
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <?php
                datebox('date', 'Hutang Per Tanggal', 200);
                localcombobox('group_by', 'Group By', 220, $optGroupBy);
                localcombobox('report_by', 'Jenis Laporan', 350, $optReport);
                localcombobox('age', 'Penuaan', 70, $optAge);
                ?>
                <tr><td class="col120"></td></tr>
            </table>
        </div>

        <div class="single-form">  

            <table>
                <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                <?php
                cmdSuppSet('supp_code', 'supp_name', 'Supplier');
                localcombobox('pinv_code', 'Jenis Faktur', 160, $optInvoice);
                localcombobox('aging', 'Dengan Umur Piutang', 100, $optAging);
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
        $('#date').datebox('setValue', ldServer);

        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
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
        age = $('#age').combobox('getValue');
        supp_name = $('#supp_name').combogrid('getValue');
        supp_code = $("#supp_code").val();
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangacc"
                + "&output=" + lcOutput
                + "&ap_date=" + date
                + "&group_by=" + group_by
                + "&rpt_by=" + report_by
                + "&pinv_code=" + pinv_code
                + "&aging=" + aging
                + "&age=" + age
                + "&supp_code=" + supp_code;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
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
            //$('#aging').combobox('setValue', '');
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
