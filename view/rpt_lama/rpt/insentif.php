<?php
//========CHANGE LOG=============
//ganti nama bulan
//persentation => percentage
//INSENTIVE => INCENTIVE
// 1 point Rp= => 1 point = RP
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


$optReport = array
    (
    array("Based on existing data", "1"),
    array("Multiplier", "2"),
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">INCENTIVE SALES REPORT</h1>
        <div class="single-form teen-margin">
            <table>
                <?php
                localcombobox('mounth', 'Bulan', 200, $mounth);
                textbox('year', 'Tahun', 100, 4);
                localcombobox('report_by', 'Jenis Laporan', 200, $optReport);
                ?>
            </table>
        </div>
        <div class="single-form teen-margin">
            <table>
                <?php cmdSalSet('srep_code', 'srep_name', 'Nama Sales'); ?>
                <input type="hidden" name="srep_code1" id="srep_code1" >
                <tr>
                    <td>1 Point = Rp</td>
                    <td class="td-ro">:</td>
                    <td><?php numberbox2('point', 100, 100); ?></td>
                </tr>
                <tr>
                    <td>Percentage</td>
                    <td class="td-ro">:</td>
                    <td><?php numberbox2('persen', 100, 100); ?></td>
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
    $(document).ready(function () {
        setEnable();
    });

    function  setEnable() {
        $("#mounth").combobox('enable');
        $('#year').attr('disabled', false);
        $("#year").val("<?php echo date('Y'); ?>");
        $('#report_by').combobox('enable');
        $('#srep_name').combogrid('enable');
    }

    function doSearch(lcOutput)
    {

        url = "services/runCRUD.php";


        var mounth = $("#mounth").combobox('getValue');
        var year =$("#year").val();

      var report_by = $('#report_by').combobox('getValue');
       var srep_name = $('#srep_name').combogrid('getValue');
        var point = $('#point').numberbox('getValue');
        var persen= $('#persen').numberbox('getValue');
         var srep_code= $('#srep_code1').val();

        var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
        var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/insentif"
                + "&output=" + lcOutput
                + "&mounth=" + mounth
                + "&year=" + year
                + "&report_by=" + report_by
                + "&srep_name=" + srep_name
                + "&srep_code=" + srep_code
                + "&point=" + point
                + "&persen=" + persen;
        // + "&group_by="+group_by;

        var win = window.open(URL, "_blank", strWindowFeatures);
    }

    $('#report_by').combobox({
        onSelect: function (index, row) {
            $('#point').attr('disabled', true);
            $('#persen').attr('disabled', true);

            var report_by = $(this).combobox('getValue');

            if (report_by == 2) {
                $('#point').numberbox('enable');
                $('#persen').numberbox('enable');
            }

        }
    });

    $('#srep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#srep_code").val(row.srep_code);
                $("#srep_code1").val(row.srep_code);
            }
        },
        onChange: function () {
            if ($('#srep_name').combogrid('getValue') == '')
            {
                $("#srep_code").val('');
            }
        }

    });
</script>