<?php
//========CHANGE LOG========
//tanggal otomatis hari ini
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$close = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);
$warehouse = array
    (
    array("ALL", "ALL"),
    array("HAS", "HAS"),
);
$optCust = array
    (
    array("ALL", ""),
    array("End User (Pemakai Langsung)", "1"),
    array("Dealer/Reseller", "2"),
    array("Goverment/BUMN", "3"),
);
$optGroupBy = array
    (
    array("Invoice No. & Invoice Date", "1"),
    array("Invoice Date & Invoice No.", "2"),
    array("Work Code", "3"),
    array("Supplier", "4"),
    array("Purchaser", "5")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">
        <h1 style="font-size:20px">OPTIONAL : <?php echo strtoupper($text); ?></h1>
        <div class="single-form teen-margin">
            <table >
                <?php
                localcombobox('cls', 'Cetak Penerimaan', 200, $close);
                datebox('date1', 'Tgl. Terima', 200);
                datebox('date2', 's/d1', 200);
                localcombobox('group_by', 'Group By', 240, $optGroupBy);
                ?>
            </table>
        </div>
        <div  class="single-form">

                    <strong> FILTER BY </strong>

                    <table>
                        <?php cmdAccWorkOptSet('wk_code', 'wk_desc', 'Kode Pekerjaan', 100, 242); ?>
                        <?php cmdAccSupp('supp_code', 'supp_name', 'Supplier', 100, 242); ?>
                        <?php cmdAccPrep('prep_code', 'prep_name', 'Purchaser', 100, 242); ?>
                         <?php cmdWrhs('wrhs_code', 'Warehouse', 200) ;?>
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

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 3) {
                    $('#wk_desc').combogrid('enable');
                }
                if (group == 4) {
                    $('#supp_name').combogrid('enable');
                }
                if (group == 5) {
                    $('#prep_name').combogrid('enable');
                }
                $("#wrhs_code").combogrid('enable');
            }
        });
        $('#group_by').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        cls = $('#cls').combobox('getValue');
        date1 = $('#date1').datebox('getValue');
        date2 = $('#date2').datebox('getValue');

        if ((date1.length == 0) || (date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        wk_code = $('#wk_code').val();
        supp_code = $('#supp_code').val();
        prep_code = $('#prep_code').val();
        group_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/optional"
                + "&table=<?php echo $name; ?>"
                + "&cls=" + cls
                + "&date1=" + date1
                + "&date2=" + date2
                + "&wk_code=" + wk_code
                + "&supp_code=" + supp_code
                + "&prep_code=" + prep_code
                 + "&title=Penerimaan Optional"
                + "&group_by=" + group_by

                + "&output=" + lcOutput;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }

    $('#wk_desc').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#wk_code").val(row.wk_code);
            }
        },
        onChange: function () {
            if ($('#wk_desc').combogrid('getValue') == '')
            {
                $("#wk_code").val('');
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
    $('#prep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#prep_code").val(row.prep_code);
            }
        },
        onChange: function () {
            if ($('#prept_name').combogrid('getValue') == '')
            {
                $("#prep_code").val('');
            }
        }

    });
</script>
