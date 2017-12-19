<?php
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$mounth = array(
    array('Januari', '1'),
    array('Februari', '2'),
    array('Maret', '3'),
    array('April', '4'),
    array('Mei', '5'),
    array('Juni', '6'),
    array('Juli', '7'),
    array('Agustus', '8'),
    array('September', '9'),
    array('Oktober', '10'),
    array('November', '11'),
    array('Desember', '12')
);
$warehouse = array
    (
    array("ALL", "ALL"),
    array("HAS", "HAS"),
);
$optGroupBy = array
    (
    array("Vehicle Type", "1"),
    array("Color", "2"),
    array("Warehouse", "3")
);
$rptGroupBy = array
    (
    array("Unit", "1"),
    array("Unit & Nilai HPP (Rp)", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Stock Table (Unit) Report</h1>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td><table><tr><td width="75"></td></tr><?php localcombobox('mounth', 'Bulan', 200, $mounth); ?></table></td>
                    <td><?php getCaption('Tahun') ?></td>
                    <td class="td-ro">:</td>
                    <td><input class="easyui-numberbox" id="year" name="year" style="width: 60px;"></td>
                </tr>
                <tr><td><table><tr><td width="75"></td></tr><?php localcombobox('group_by', 'Group By', 200, $optGroupBy); ?></table></td></tr>
                <tr><td><table><tr><td width="75"></td></tr><?php localcombobox('report_by', 'Laporan', 200, $rptGroupBy); ?></table></td></tr>
            </table>
        </div>
        <div  class="single-form">  
            <table >
                <table>		

                    <strong> FILTER BY </strong>

                    <table>
                        <?php
                        cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                        cmdColSet('color_code', 'color_name', 'Warna');
                        cmdWrhs('wrhs_code', 'Warehouse');
                        ?>
                    </table>

                </table>
        </div>

        <div class="main-nav">
            <table>
                <tr>
                    <td>
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
        //console.log( "ready!" );
        setEnable();
        $(".loader").hide(1000);
    });
    function setEnable()
    {

        $('#pur_date').datebox('enable');
        
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $('#veh_name').combogrid('enable');
                }
                if (group == 2) {
                    $('#color_name').combogrid('enable');
                }

                if (group == 3) {
                    $('#wrhs_code').combobox('enable');
                }
            }
        });
        
        $('#veh_name').combogrid('enable');
        $('#group_by').combobox('enable');
        $("#mounth").combobox('enable');
        $("#year").numberbox('enable');

    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";

        lcwrhs_code = $('#wrhs_code').combobox('getValue');
        lcveh_code = $('#veh_code').val();
        lccolor_code = $('#color_code').val();
        lcmounth = $("#mounth").combobox('getValue');
        lcyear = $("#year").numberbox('getValue');
        lcgroup_by = $('#group_by').combobox('getValue');

        if (lcyear !== '') {
            var strWindowFeatures = "location=yes,height=570,width=220,scrollbars=yes,status=yes";
            var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";

            var URL = url + "?lookup=rpt/kartustock/unit"
                    + "&wrhs_code=" + lcwrhs_code
                    + "&output=" + lcOutput
                    + "&veh_code=" + lcveh_code
                    + "&color_code=" + lccolor_code
                    + "&mounth=" + lcmounth
                    + "&year=" + lcyear
                    + "&group_by=" + lcgroup_by;


            var win = window.open(URL, "_blank", strWindowFeatures);
        } else {
            alert('Transaksi Periode Ini Tidak Ada!')
        }
    }
    $('#cust_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#cust_code").val(row.cust_code);
            }
        },
        onChange: function () {
            if ($('#cust_name').combogrid('getValue') == '')
            {
                $("#cust_code").val('');
            }
        }

    });

    $('#veh_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#veh_code").val(row.veh_code);
            }
        },
        onChange: function () {
            if ($('#veh_name').combogrid('getValue') == '')
            {
                $("#veh_code").val('');
            }
        }
    });


    $('#color_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#color_code").val(row.color_code);
            }
        },
        onChange: function () {
            if ($('#color_name').combogrid('getValue') == '')
            {
                $("#color_code").val('');
            }
        }
    });
</script>
