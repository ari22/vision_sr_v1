<?php
$form = 'rpt_spk';
$table = "";
$lookup = 'mst/' . $table;

$mounth = array(
    array('January', '1'),
    array('February', '2'),
    array('March', '3'),
    array('April', '4'),
    array('May', '5'),
    array('June', '6'),
    array('July', '7'),
    array('August', '8'),
    array('September', '9'),
    array('October', '10'),
    array('November', '11'),
    array('December', '12')
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
     array("Unit & Nilai HPP (Rp)", "2"),
    array("Unit", "1")
   
);


$year = $_SESSION['tahun'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <div class="single-form">
            <table>
                <tr>
                    <td valign="top" width="350">
                        <table>
                            <tr><td colspan="3"> <h1 style="font-size:18px"><u>REPORT BY</u></h1></td></tr>
                            <?php localcombobox('mounth', 'bulan1', 200, $mounth); ?>
                            <tr>
                                <td><?php getCaption('Tahun') ?></td>
                                <td class="td-ro">:</td>
                                <td><input class="easyui-numberbox" id="year" name="year" style="width: 60px;" value="<?php echo $year;?>"></td>
                            </tr>
                            <?php localcombobox('group_by', 'Group By', 200, $optGroupBy); ?>
                            <?php localcombobox('report_by', 'Laporan', 200, $rptGroupBy); ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                            <?php
                            cmdVehSet('veh_code', 'veh_name', 'Tipe Kendaraan');
                            cmdColSet('color_code', 'color_name', 'Warna');
                            cmdWrhs('wrhs_code', 'Warehouse');
                            ?>
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
        //console.log( "ready!" );
        setEnable();
        $(".loader").hide(1000);
        version('04.17-25');
    });
    function setEnable()
    {

        $('#pur_date').datebox('enable');
        $('#group_by').combobox({
            onSelect: function (index, row) {
                //$('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');

                /*var group = $(this).combobox('getValue');
                 
                 if (group == 1) {
                 $('#veh_name').combogrid('enable');
                 }
                 if (group == 2) {
                 $('#color_name').combogrid('enable');
                 }
                 
                 if (group == 3) {
                 $('#wrhs_code').combobox('enable');
                 }
                 */
                $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
            }
        });
        $('.easyui-combogrid').combogrid('enable');
        $('#veh_name').combogrid('enable');
        $('#group_by').combobox('enable');
        $('#report_by').combobox('enable');
        $("#mounth").combobox('enable');
        $("#year").numberbox('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
         $("#mounth").combobox('setValue', '<?php echo $_SESSION['bulan']; ?>');
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
        lcreport_by = $('#report_by').combobox('getValue');

        if (lcyear !== '') {
            var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";

            var URL = url + "?lookup=rpt/kartustock/price"
                    + "&wrhs_code=" + lcwrhs_code
                    + "&output=" + lcOutput
                    + "&veh_code=" + lcveh_code
                    + "&color_code=" + lccolor_code
                    + "&mounth=" + lcmounth
                    + "&year=" + lcyear
                    + "&group_by=" + lcgroup_by
                    + "&report_by=" + lcreport_by;


            URL = URL + '#toolbar=0';
            if (lcOutput !== 'screen') {
                $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            } else {
                var win = window.open(URL, "_blank", strWindowFeatures);
            }
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
