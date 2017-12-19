<?php
$form = 'rpt_' . $name;
$table = $name;

$opt = array
    (
    array($text . ' Code', "1"),
    array($text . ' Name', "2")
);

?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div  class="single-form" style="height: 100px;">  
            <input type="hidden" name="title" id="title" value="<?php echo $text;?>">
            <h1 style="font-size:20px">MASTER : <?php echo strtoupper($text); ?> REPORT</h1>
            <table>
                <?php localcombobox('opt', 'Urut Berdasarkan', 200, $opt); ?>
                <tr><td width="70"></td></tr>
            </table>
        </div>
        <div class="main-nav">
            <table>
                <tr>
                    <td>
                        <a href="#" class="easyui-linkbutton"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;
                        <a href="#" class="easyui-linkbutton"  onclick="rolesPrintScreenReport('print')">Printer</a>
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
    function setEnable() {
        $('#opt').combobox('enable');
    }
    function doSearch(lcOutput) {
        url = "services/runCRUD.php";
        lcopt = $('#opt').combobox('getValue');
        title = $("#title").val();
        
        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";

        var URL = url + "?lookup=rpt/vehicle"
                + "&table=<?php echo $name; ?>"
                + "&title=" + title
                + "&optby=" + lcopt
                + "&output=" + lcOutput;
        var win = window.open(URL, "_blank", strWindowFeatures);
    }
</script>