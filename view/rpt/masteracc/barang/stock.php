<?php
$form = 'form_validation';
$table = $name;

$opt = array
    (
    array($text . ' Code', "1"),
    array($text . ' Name', "2")
);
?>

<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div  class="single-form" style="height:200px;">  
            <input type="hidden" name="title" id="title" value="<?php echo $text; ?>">

            <table>
                 <tr><td colspan="3"><h1><u>MASTER : <?php echo strtoupper($text); ?> ACCESSORIES</u></h1></td></tr>
                <?php cmdWrhs('wrhs', 'Warehouse', 150); ?>
                <?php localcombobox('opt', 'Urut Berdasarkan', 200, $opt); ?>
                <tr><td width="70"></td></tr>

                <tr>
                    <td valign="top">Proses</td>
                    <td valign="top" class="td-ro">:</td>
                    <td>
                        <table  style="border:1px solid #ccc;padding:10px;">
                            <tr>
                                <td> <a href="#" class="checkbox" name="prt_inact_1"><input type="radio" id="prt_inact_1" class="prt_inact_1"  name="prt_inact" value="1" checked="true"> Barang Yang Aktif Saja (Bermutasi atau Bersaldo)</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#" class="checkbox" name="prt_inact_2"><input type="radio" id="prt_inact_2" class="prt_inact_2" name="prt_inact" value="2"> Semua  Barang</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
        $('#wrhs').combogrid('enable');
    }
    function doSearch(lcOutput) {
        url = "services/runCRUD.php";
        lcopt = $('#opt').combobox('getValue');
        title = $("#title").val();

        $('input[name="prt_inact"]:checked').each(function () {
            inact = $(this).val();
        });

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";

        var URL = url + "?lookup=rpt/accessories"
                + "&table=<?php echo $name; ?>"
                + "&title=" + title
                + "&optby=" + lcopt
                + "&rptby=stock"
                + "&inact=" + inact
                + "&output=" + lcOutput;


        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
</script>