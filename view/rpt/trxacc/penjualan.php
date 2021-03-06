<?php
//===============CHANGE LOG=============
//tambah kirim pilihan di dropdown sales_type
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

$sales_type = array(
    array("All", "1"),
    array("Showroom", "2"),
    array("Counter Sales", "3")
);
$optGroupBy = array
    (
    array("Invoice No. & Invoice Date", "1"),
    array("Invoice Date & Invoice No.", "2"),
    array("Part Code", "3"),
    array("Customer Code", "5"),
    array("Sales", "6")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">
        <div class="single-form">
            <table >
                 <tr><td colspan="3"> <h1 style="font-size:18px"><u>Accessories Sales Report </u></h1></td></tr>
                <?php
                localcombobox('cls', 'Penerimaan', 200, $close);
                datebox('date1', 'Tanggal', 200);
                datebox('date2', 's/d1', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);
                localcombobox('sales_type', 'Jenis Penjualan', 240, $sales_type);
                cmdprtWrhs('wrhs_code', 'Warehouse');
                ?>
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
    $(document).ready(function () {
        $(".loader").hide(1000);

        $('#date1').datebox('setValue', date1);
        $('#date2').datebox('setValue', date2);
        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });

    function setEnable()
    {
        //window.alert("masuk");
        $("#sales_type").combogrid('enable');
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
        sales_type = $('#sales_type').datebox('getValue');

        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        group_by = $('#group_by').combobox('getValue');


        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxaccessories"
                + "&table=<?php echo $name; ?>"
                + "&cls=" + cls
                + "&date1=" + date1
                + "&date2=" + date2
                + "&title=PO_Accessories"
                + "&group_by=" + group_by
                + '&text=Penjualan'
                + "&output=" + lcOutput
                + "&saltype=" + sales_type;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
</script>
