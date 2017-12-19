<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;

$optGroupBy = array
    (
    array("Sales Agent", "1"),
    array("Invoice Type", "2")
);


$optReport = array
    (
    array("Report Beginning Balance on the first day of the current ", "1"),
    array("Beginning Balance Today", "2"),
);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >

        <div class="single-form">
            <table> 
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                <tr>
                    <td>Outstanding Balance On</td>
                    <td>:</td>
                    <td><?php datebox2('date');?></td>
                </tr>
                <?php
                localcombobox('group_by', 'Group By', 220, $optGroupBy);
                localcombobox('report_by', 'Jenis Laporan', 350, $optReport);
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
        $('#date').datebox('enable');
        $('#group_by').combobox('enable');
        $('#report_by').combobox('enable');

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

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangkomisi"
                + "&output=" + lcOutput
                + "&date=" + date
                + "&group_by=" + group_by
                + "&rpt_by=" + report_by;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }


</script>
