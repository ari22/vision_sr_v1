<?php
$form = 'rpt_stnk';


$optGroupBy = array
    (
    array("Tanggal", "1"),
    array("Customer", "2")
);
$optStatus = array
    (
    array(" ", "0"),
    array("Belum", "1"),
    array("Sudah", "2")
);
$aging = array
    (
    array("Tidak", "0"),
    array("Ya", "1"),
);
$optAgingSortBy = array
    (
    array("Due Date", "1"),
    array("Invoice Date", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">LAPORAN STNK</h1>
        <div class="single-form teen-margin">
            <table>
                <?php localcombobox('status1', 'Terima Dari Biro Jasa', 60, $optStatus); ?>
                <tr>	

                    <td><?php getCaption("Tanggal Faktur"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="sal_date1"  name="sal_date1" style="width:90;" disabled=false></input>
                        s/d	<input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="sal_date2"  name="sal_date2" style="width:90;" disabled=false></input>
                    </td>

                </tr>

                <?php
                localcombobox('status2', 'Terima Oleh Pelanggan', 60, $optStatus);
                ?>
                <tr>	

                    <td><?php getCaption("Tanggal Terima Dari Biro Jasa"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="stnk_rdate1"  name="stnk_rdate1" style="width:90;" disabled=false></input>
                        s/d	<input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="stnk_rdate2"  name="stnk_rdate2" style="width:90;" disabled=false></input>
                    </td>

                </tr>
                <tr>	

                    <td><?php getCaption("Tanggal Penyerahan Ke Pelanggan"); ?> </td>
                    <td style="max-width: 5px !important;" class="td-ro">:</td>
                    <td>
                        <input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="stnk_sdate1"  name="stnk_sdate1" style="width:90;" disabled=false></input>
                        s/d	<input autocomplete="off" class="easyui-datebox" validType='validDate' data-options="required:false" id="stnk_sdate2"  name="stnk_sdate2" style="width:90;" disabled=false></input>
                    </td>

                </tr>
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


    $(document).ready(function ()
    {
        var ldServer = new Date("<?php echo date('F d, Y G:i:s'); ?>");
        $('#sal_date1').datebox('setValue', ldServer);
        $('#sal_date2').datebox('setValue', ldServer);
        $('#stnk_rdate1').datebox('setValue', ldServer);
        $('#stnk_rdate2').datebox('setValue', ldServer);
        $('#stnk_sdate1').datebox('setValue', ldServer);
        $('#stnk_sdate2').datebox('setValue', ldServer);
        setEnable();
    });
    function setEnable()
    {
        $('#status1').combobox('enable');

    }
    $('#status1').combobox({
        onSelect: function (record) {
            $('#status2').combobox('disable');
            $('#sal_date1').datebox('disable');
            $('#sal_date2').datebox('disable');
            $('#stnk_rdate1').datebox('disable');
            $('#stnk_rdate2').datebox('disable');
            $('#stnk_sdate1').datebox('disable');
            $('#stnk_sdate2').datebox('disable');
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
                    break;
                default:
                    break;
            }



        }
    });
    $('#status2').combobox({
        onSelect: function (record) {
            $('#stnk_rdate1').datebox('disable');
            $('#stnk_rdate2').datebox('disable');
            $('#stnk_sdate1').datebox('disable');
            $('#stnk_sdate2').datebox('disable');
            //alert($('#status1').combobox('getValue'));
            lnJawab = $('#status2').combobox('getValue');
            //alert(lnJawab);
            switch (lnJawab)
            {
                case "1" :
                    $('#stnk_rdate1').datebox('enable');
                    $('#stnk_rdate2').datebox('enable');
                    break;
                case "2" :
                    $('#stnk_sdate1').datebox('enable');
                    $('#stnk_sdate2').datebox('enable');
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
        lcstnk_rdate1 = $('#sal_date1').datebox('getValue');
        lcstnk_rdate2 = $('#sal_date2').datebox('getValue');
        lcstnk_sdate1 = $('#sal_date1').datebox('getValue');
        lcstnk_sdate2 = $('#sal_date2').datebox('getValue');

        if ((lcsal_date1.length == 0))
        {
            showAlert("Tanggal tidak boleh kosong");
            return false;
        }

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/stnk"
                + "&output=" + lcOutput
                + "&status1=" + lcstatus1
                + "&status2=" + lcstatus2
                + "&stnk_rdate1=" + lcstnk_rdate1
                + "&stnk_rdate2=" + lcstnk_rdate2
                + "&stnk_sdate1=" + lcstnk_sdate1
                + "&stnk_sdate2=" + lcstnk_sdate2;
        var win = window.open(URL, "_blank", strWindowFeatures);
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
