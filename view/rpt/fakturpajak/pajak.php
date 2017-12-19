<?php
$form = 'rpt_pajak';
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

if ($name == 'veh_slh') {
    $status = 'exit';
    $text = 'OUTPUT';
}
if ($name == 'veh_prh') {
    $status = 'entry';
    $text = 'INPUT';
}
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >

        <div class="single-form">
            <table>
                 <tr><td colspan="3"><h1><u><?php echo $text; ?> TAX REPORT</u></h1></td></tr>
                <?php
                localcombobox('mounth', 'Bulan', 200, $mounth);
                textbox('year', 'Tahun', 150, 4)
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
        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });

    function  setEnable() {
        $("#mounth").combobox('enable');
        $('#year').attr('disabled', false);
        $("#year").val("<?php echo date('Y'); ?>");
    }

    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";


        mounth = $('#mounth').combobox('getValue');
        year = $('#year').val();

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/pajak"
                + "&output=" + lcOutput
                + "&table=<?php echo $name; ?>"
                + "&mounth=" + mounth
                + "&year=" + year
                + "&status=<?php echo $status; ?>";
        
        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
</script>