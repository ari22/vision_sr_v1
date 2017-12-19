<?php
$form = 'rpt_uj';
$table = "";
$lookup = 'mst/' . $table;
$optGroupBy = array
    (
    array("PO No.", "1"),
    array("Supplier", "2")
);

$rptType = array(
    array("Report Beginning Balance on the first day of the current ", "1"),
    array("Beginning Balance Today", "2"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        
        <div class="single-form teen-margin">
            <table>
                <tr><td colspan="3"><h1 style="font-size:20px"><u>Down Payment Supplier Report</u></h1></td></tr>
                <?php
                datebox('date', 'Pembayaran Per Tanggal', 200);
                localcombobox('group_by', 'Group By', 200, $optGroupBy);
                localcombobox('rpt_by', 'Jenis Laporan', 350, $rptType);
                ?>
                 <tr><td class="col120"></td></tr>
            </table>
        </div>
        <div class="single-form">  
                    <table>
                         <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                        <?php
                        cmdponew('po_no', 'No. PO', $site_url, null, 'cls'); 
                        cmdSupp('supp_code', 'supp_name', 'Supplier') 
                        ?>
                          <tr><td class="col120"></td></tr>
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
        var ldServer = '<?php echo date('Y-m-d'); ?>';
        $('#date').datebox('setValue', ldServer);
        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $('#po_no').combogrid('enable');
                }
                if (group == 2) {
                    $('#supp_name').combogrid('enable');
                }

            }
        });
        
        $('#po_no').combogrid('enable');
        $('#date').datebox('enable');
        $('#group_by').combobox('enable');
        $('#rpt_by').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcdate = $('#date').datebox('getValue');
        po_no = $("#po_no").combogrid('getValue');
        group_by =  $('#group_by').combobox('getValue');
        rpt_by = $('#rpt_by').combobox('getValue');
        supp_code = $("#supp_code").val();
        
        if ((lcdate.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/uangjaminansupplier"
                + "&output=" + lcOutput
                + "&date=" + lcdate
                + "&group_by=" + group_by
                + "&po_no=" + po_no
                + "&supp_code=" + supp_code
                + "&rpt_by=" + rpt_by;

        URL = URL + '#toolbar=0';

        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

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
</script>
