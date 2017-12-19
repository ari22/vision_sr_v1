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
            <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">

            <table>
                 <tr><td colspan="3"><h1><u>LOOK-UP : <?php echo strtoupper($text); ?></u></h1></td></tr>
                <?php localcombobox('opt', 'Urut Berdasarkan', 200, $opt); ?>
                <tr><td width="70"></td></tr>
            </table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td>
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"  onclick="doSearch('screen')">Screen</a>
                        &nbsp;&nbsp;
                        <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="rolesPrintScreenReport('print')">Printer</a>
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
    function setEnable() {
        $('#opt').combobox('enable');
    }
    function doSearch(lcOutput) {
        url = "services/runCRUD.php";
        lcopt = $('#opt').combobox('getValue');
        title = $("#title").val();

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";

        var URL = url + "?lookup=rpt/lookup"
                + "&table=<?php echo $name; ?>"
                + "&title=" + title
                + "&optby=" + lcopt
                + "&output=" + lcOutput;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
</script>