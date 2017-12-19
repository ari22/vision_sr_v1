<?php
//==========CHANGE LOG=======
//tanggal2 otomatis keisi

$form = 'rpt';
$table = "";
$lookup = 'mst/' . $table;

$close = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);

$optGroupBy = array
    (
    array("Invoice No. & Invoice Date", "1"),
    array("Invoice Date & Invoice No.", "2"),
    array("Part Code", "3")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">
        <h1 style="font-size:20px">Accessories Stock Opname Report</h1>
        <div class="single-form teen-margin">
            <table >
                <?php
                localcombobox('cls', 'Penerimaan', 200, $close);
                datebox('date1', 'Tanggal', 200);
                datebox('date2', 's/d1', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);

                  cmdprtWrhs('wrhs_code', 'Warehouse');
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
        //console.log( "ready!" );

        $(".loader").hide(1000);
        var ldServer = '<?php echo date('y-m-d'); ?>';
        $('#date1').datebox('setValue', ldServer);
        $('#date2').datebox('setValue', ldServer);
        setEnable();


    });
    function setEnable()
    {
        //window.alert("masuk");
        $("#wrhs_code").combogrid('enable');
        $('#cls').combobox('enable');
        $('#date1').datebox('enable');
        $('#date2').datebox('enable');


        $('#group_by').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        cls = $('#cls').combobox('getValue');
        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');
        wrhs_code = $("#wrhs_code").combogrid('getValue');
        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        group_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxaccessories"
                + "&table=<?php echo $name; ?>"
                + "&cls=" + cls
                + "&date1=" + date1
                + "&date2=" + date2
                + "&title=Stock_Opname_Accessories"
                + "&group_by=" + group_by
                 + "&wrhs_code="+ wrhs_code
                + "&output=" + lcOutput;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }


</script>
