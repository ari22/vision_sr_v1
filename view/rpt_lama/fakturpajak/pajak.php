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

if($name == 'veh_slh'){
    $status = 'exit';
}
if($name == 'veh_prh'){
    $status = 'entry';
}

?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">DAFTAR PAJAK KELUARAN</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('mounth', 'Bulan', 200, $mounth);
                textbox('year', 'Tahun', 150, 4)
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
        $("#year").val("<?php echo date('Y');?>");
    }

    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";


        mounth = $('#mounth').combobox('getValue');
        year = $('#year').val();
       
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/pajak"
                + "&output=" + lcOutput
                + "&table=<?php echo $name;?>"
                + "&mounth=" + mounth
                + "&year=" + year
                + "&status=<?php echo $status;?>";
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
</script>