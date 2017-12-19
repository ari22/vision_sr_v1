<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;
$optGroupBy = array
    (
    array("Tanggal", "1"),
    array("Customer", "2")
);
$optSortBy = array
    (
    array("No. UJ", "1"),
    array("Tanggal", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
         <h1 style="font-size:20px">Laporan Uang Jaminan Kendaraan</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                datebox('ar_date', 'Piutang Per Tanggal', 200);
                textbox("so_no", "No. SPK", 150, 12);
                localcombobox('sort_by', 'Urut', 200, $optSortBy);
                //localcombobox('group_by','Group By',200,$optGroupBy);
                ?>
            </table>
        </div>
        <div class="main-nav">
            <table>		
                <tr>
                    <td>
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
        $('#ar_date').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#ar_date').datebox('enable');
        $('#so_no').attr('disabled', false);
        //$('#group_by').combobox('enable');
        $('#sort_by').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcar_date = $('#ar_date').datebox('getValue');

        if ((lcar_date.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        //lcgroup_by = $('#group_by').combobox('getValue');
        lcsort_by = $('#sort_by').combobox('getValue');
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/uangjaminan"
                + "&output=" + lcOutput
                + "&ar_date=" + lcar_date
                //+ "&group_by=" + lcgroup_by
                + "&sort_by=" + lcsort_by;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }

</script>
