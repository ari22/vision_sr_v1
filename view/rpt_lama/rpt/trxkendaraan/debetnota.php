<?php
$form = 'rpt_debit_note';
$mounth = array
    (
    array("Januari", "1"),
    array("Februari", "2"),
    array("Maret", "3"),
    array("April", "4"),
    array("Mei", "5"),
    array("Juni", "6"),
    array("Juli", "7"),
    array("Agustus", "8"),
    array("September", "9"),
    array("Oktober", "10"),
    array("November", "11"),
    array("Desember", "12"),
);


$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Dealer", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">DEBIT NOTE REPORT</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('mounth', 'Bulan', 200, $mounth);
                textbox('year', 'Tahun', 100, 4);
               // localcombobox('group_by', 'Group By', 200, $optGroupBy);
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
    $(document).ready(function () {
        setEnable();
    });

    function  setEnable() {
        $("#mounth").combobox('enable');
        $('#year').attr('disabled', false);
        $("#year").val("<?php echo date('Y'); ?>");
        $('#group_by').combobox('enable');
    }

    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";


        mounth = $('#mounth').combobox('getValue');
        year = $('#year').val();
       // group_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/debitnote"
                + "&output=" + lcOutput
                + "&mounth=" + mounth
                + "&year=" + year;
               // + "&group_by="+group_by;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }

</script>