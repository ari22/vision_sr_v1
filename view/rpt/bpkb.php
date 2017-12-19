<?php
$form = 'rpt_bpkb';


$optGroupBy = array
    (
    array("Date", "1"),
    array("Customer", "2")
);
$optStatus = array
    (
    array("Not Yet", "1"),
    array("Already", "2")
);
$aging = array
    (
    array("No", "0"),
    array("Yes", "1"),
);
$optAgingSortBy = array
    (
    array("Due Date", "1"),
    array("Invoice Date", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form">
            <table>
                <tr><td colspan="3"><h1><u>Vehicle Ownership Book (BPKB) Report</u></h1></td></tr>
                <?php localcombobox('status1', 'Terima Dari Biro Jasa', 100, $optStatus); ?>
                <tr>	

                    <td><?php getCaption("Tanggal Faktur"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <?php datebox2('sal_date1'); ?> s/d <?php datebox2('sal_date2'); ?>
                    </td>

                </tr>

                <?php
                localcombobox('status2', 'Terima Oleh Pelanggan', 100, $optStatus);
                ?>
                <tr>	

                    <td><?php getCaption("Tanggal Terima Dari Biro Jasa"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <?php datebox2('bpkb_rdate1'); ?> s/d <?php datebox2('bpkb_rdate2'); ?>
                    </td>

                </tr>
                <tr>	

                    <td><?php getCaption("Tanggal Penyerahan Ke Pelanggan"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <?php datebox2('bpkb_sdate1'); ?> s/d <?php datebox2('bpkb_sdate2'); ?>
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

        $('#sal_date1').datebox('setValue', date1);
        $('#sal_date2').datebox('setValue', date2);


        $('#bpkb_rdate1').datebox('setValue', date1);
        $('#bpkb_rdate2').datebox('setValue', date2);
        $('#bpkb_sdate1').datebox('setValue', date1);
        $('#bpkb_sdate2').datebox('setValue', date2);
        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
    });
    function setEnable()
    {
        $('#sal_date1').datebox('enable');
        $('#sal_date2').datebox('enable');
        $('#status1').combobox('enable');

    }
    $('#status1').combobox({
        onSelect: function (record) {
            $('#status2').combobox('disable');
            $('#sal_date1').datebox('disable');
            $('#sal_date2').datebox('disable');
            $('#bpkb_rdate1').datebox('disable');
            $('#bpkb_rdate2').datebox('disable');
            $('#bpkb_sdate1').datebox('disable');
            $('#bpkb_sdate2').datebox('disable');
            //alert($('#status1').combobox('getValue'));
            lnJawab = $('#status1').combobox('getValue');
            //alert(lnJawab);
            switch (lnJawab)
            {
                case "1" :
                    $('#sal_date1').datebox('enable');
                    $('#sal_date2').datebox('enable');
                    break;
                case "2" :
                    $('#status2').combobox('enable');
                    $('#bpkb_rdate1').datebox('enable');
                    $('#bpkb_rdate2').datebox('enable');
                    break;
                default:
                    break;
            }



        }
    });
    $('#status2').combobox({
        onSelect: function (record) {
           // $('#bpkb_rdate1').datebox('disable');
           // $('#bpkb_rdate2').datebox('disable');
            $('#bpkb_sdate1').datebox('disable');
            $('#bpkb_sdate2').datebox('disable');
            //alert($('#status1').combobox('getValue'));
            lnJawab = $('#status2').combobox('getValue');
            //alert(lnJawab);
            switch (lnJawab)
            {
                case "1" :
                    $('#bpkb_rdate1').datebox('enable');
                    $('#bpkb_rdate2').datebox('enable');
                    break;
                case "2" :
                    $('#bpkb_sdate1').datebox('enable');
                    $('#bpkb_sdate2').datebox('enable');
                    break;
                default:
                    break;
            }



        }
    });
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";


        lcstatus1 = $('#status1').combobox('getValue');
        lcstatus2 = $('#status2').combobox('getValue');
        lcsal_date1 = $('#sal_date1').datebox('getValue');
        lcsal_date2 = $('#sal_date2').datebox('getValue');
        lcbpkb_rdate1 = $('#bpkb_rdate1').datebox('getValue');
        lcbpkb_rdate2 = $('#bpkb_rdate2').datebox('getValue');
        lcbpkb_sdate1 = $('#bpkb_sdate1').datebox('getValue');
        lcbpkb_sdate2 = $('#bpkb_sdate2').datebox('getValue');

        if ((lcsal_date1.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/bpkb"
                + "&output=" + lcOutput
                + "&status1=" + lcstatus1
                + "&status2=" + lcstatus2
                + "&bpkb_rdate1=" + lcbpkb_rdate1
                + "&bpkb_rdate2=" + lcbpkb_rdate2
                + "&bpkb_sdate1=" + lcbpkb_sdate1
                + "&bpkb_sdate2=" + lcbpkb_sdate2
                + "&sal_date1=" + lcsal_date1
                + "&sal_date2=" + lcsal_date2;

        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }
    ;
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
