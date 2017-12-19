<?php
$form = 'rpt_hutangbbn';

$optGroupBy = array
    (
    array("Tanggal", "1"),
    array("Customer", "2")
);
$optRptType = array
    (
    array("Report Beginning Balance on the first day of the current ", "1"),
    array("Beginning Balance Today", "2"),
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
$optAgingSortBy = array
    (
    array("By Due Date", "1"),
    array("By Invoice Date", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form teen-margin">
            <table cellpadding="1" style="margin: 0cm 0px 0px 0px">
                <tr><td colspan="3"> <h1 style="font-size:18px"><u>BBN Payable Report</u></h1></td></tr>
                
                <?php
                datebox('ap_date', 'Hutang Per Tanggal', 200);
                cmdAccSuppSet('supp_code', 'supp_name', 'Supplier');
                localcombobox('rpt_type', 'Jenis Laporan', 350, $optRptType);
                localcombobox('l_aging', 'Penuaan', 60, $aging);
                localcombobox('aging_sortby', 'Urut', 120, $optAgingSortBy);
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
        $('#ap_date').datebox('setValue', ldServer);
        setEnable();
        $(".loader").hide(1000);
         version('04.17-25');
    });
    function setEnable()
    {
        //window.alert("masuk");

        $('#ap_date').datebox('enable');
        $('#supp_name').combogrid('enable');
        $('#rpt_type').combobox('enable');
        $('#l_aging').combobox('enable');
        //$('#aging_sortby').combobox('enable');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcap_date = $('#ap_date').datebox('getValue');

        if ((lcap_date.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        //lcgroup_by = $('#group_by').combobox('getValue');
        lcsupp_code = $('#supp_code').val();
        lcaging = $('#l_aging').combobox('getValue');
        lcaging_sortby = $('#aging_sortby').combobox('getValue');
        lcrpt_type = $('#rpt_type').combobox('getValue');
        
        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/kasir/hutangbbn"
                + "&output=" + lcOutput
                + "&ap_date=" + lcap_date
                + "&supp_code=" + lcsupp_code
                + "&l_aging=" + lcaging
                + "&aging_sortby=" + lcaging_sortby
                + "&rpt_type=" + lcrpt_type;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
    ;
    $("#l_aging").combobox({
        onChange: function () {
            //$('#age').combobox('setValue', '');
            $("#aging_sortby").combobox('disable');

            var age = $(this).combobox('getValue');

            if (age == '1') {
                $("#aging_sortby").combobox('enable');
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
</script>
