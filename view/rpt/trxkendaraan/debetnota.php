<?php
$form = 'rpt_debit_note';
$mounth = array
    (
    array("January", "1"),
    array("February", "2"),
    array("March", "3"),
    array("April", "4"),
    array("May", "5"),
    array("June", "6"),
    array("July", "7"),
    array("August", "8"),
    array("September", "9"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
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
        <div class="single-form">
            <table>
                <?php
                localcombobox('mounth', 'Bulan1', 200, $mounth);
                textbox('year', 'Tahun', 100, 4);
               // localcombobox('group_by', 'Group By', 200, $optGroupBy);
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
        $(".loader").hide();
         version('04.17-25');
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

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/trxkendaraan/debitnote"
                + "&output=" + lcOutput
                + "&mounth=" + mounth
                + "&year=" + year;
               // + "&group_by="+group_by;
        
        URL = URL+'#toolbar=0';
        if(lcOutput !== 'screen'){
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }else{
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

</script>