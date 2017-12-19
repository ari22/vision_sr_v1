<?php
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$spk = array
    (
    array("Registered Only", "1"),
    array("Registered & Distributed", "2"),
    array("All SPK", "0"),
);
$status = array
    (
    array("Unused", "1"),
    array("Used", "2"),
    array("ALL", "0"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >

        <div class="single-form">
            <table>
                <tr>
                    <td valign="top" width="350">
                        <table>
                            <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                            <?php
                            localcombobox('so_reg', 'SPK', 200, $spk);
                            localcombobox('so_status', 'Status', 200, $status);
                            ?>
                            <tr><td class="col80"></td></tr>
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


    $(document).ready(function ()
    {

        $(".loader").hide(1000);
        setEnable();
        version('04.17-25');
    });
    function setEnable()
    {
        $('#so_reg').combobox({
            onSelect: function (index, row) {
                $('#so_status').combobox('enable');
                $('#so_status').combobox('setValue', '1');


                var so_reg = $("#so_reg").combobox('getValue');
                if (so_reg == 1) {
                    $('#so_status').combobox('disable');
                }
                if (so_reg == 2) {
                    $('#so_status').combobox('enable');
                }
                if (so_reg == 0) {
                    $('#so_status').combobox('enable');
                }
            }

        });
        $('#so_reg').combobox('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        lcso_reg = $('#so_reg').combobox('getValue');
        lcso_status = $('#so_status').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        //var strWindowFeatures = "scrollbars=1,fullscreen=yes,status=no,toolbar=no,menubar=no,location=no";

        var URL = url + "?lookup=rpt/spk_management"
                + "&so_reg=" + lcso_reg
                + "&so_status=" + lcso_status
                + "&output=" + lcOutput;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

</script>
