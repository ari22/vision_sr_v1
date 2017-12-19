<?php
$form = 'rpt_bbnwo';

$status = array
    (
    array("Closed", "1"),
    array("Not Closed", "2"),
    array("All", "3"),
);

$optGroupBy = array
    (
    array("Invoice No. & Invoice Date", "1"),
    array("Invoice Date & Invoice No.", "2"),
    array("Vehicle Code", "3"),
    array("Agent", "4"),
	array("Purchaser", "5"),
	array("Warehouse", "6")
);

$trans = array
    (
    array("No", "0"),
    array("Yes", "1"),
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
                            localcombobox('cls', 'Cetak Faktur', 200, $status);
                            datebox('wo_date1', 'Tgl. WO', 200);
                            datebox('wo_date2', 's/d', 200);
                            localcombobox('group_by', 'Group By', 200, $optGroupBy);
							localcombobox('status', 'Transaksi', 50, $trans);
                            ?>
                            <tr><td class="col80"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"><h1><u>FILTER BY</u></h1></td></tr>
                            <?php 
								cmdVehSet('veh_code', 'veh_name', 'Kendaraan');
								cmdAgent('agent_code', 'agent_name', 'Biro Jasa');
								cmdAccPrep('prep_code', 'prep_name', 'Purchaser');
								cmdWrhs('wrhs_code', 'Warehouse');
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

        $('#wo_date1').datebox('setValue', date1);
        $('#wo_date2').datebox('setValue', date2);
				$("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');	
        setEnable();

         version('12.17-14');
    });
    function setEnable()
    {
        $('#cls').combobox('enable');
        $('#wo_date1').datebox('enable');
        $('#wo_date2').datebox('enable');
		
        $('#group_by').combobox('enable');
		$('#status').combobox('enable');
		$('.easyui-combogrid').combogrid('enable');
        $("#wrhs_code").combogrid('setValue', '<?php echo $wrhs_axs; ?>');
    }
    function doSearch(lcOutput)
    {
        url = "services/runCRUD.php";
        cls = $('#cls').combobox('getValue');
		status = $('#status').combobox('getValue');
        wo_date1 = $('#wo_date1').datebox('getValue');
        wo_date2 = $('#wo_date2').datebox('getValue');
        wrhs_code = $("#wrhs_code").combogrid('getValue');
	
		veh_code = $("#veh_code").val();
		agent_code = $("#agent_code").val();
		prep_code = $("#prep_code").val();

        if ((wo_date1.length == 0) || (wo_date2.length == 0))
        {
            showAlert("Warning", "<font color='red'>Tanggal tidak boleh kosong!</font>");
            return false;
        }

        group_by = $('#group_by').combobox('getValue');

        var strWindowFeatures = "location=yes,height=650,width=1500,scrollbars=yes,status=yes";
        var URL = url + "?lookup=rpt/bbn/bbnwo"
                + "&table=veh_bwoh"
                + "&cls=" + cls
				+ "&status=" + status
				+ "&group_by=" + group_by
                + "&wo_date1=" + wo_date1
                + "&wo_date2=" + wo_date2
                + "&wrhs_code=" + wrhs_code
				+ "&veh_code=" + veh_code
				+ "&agent_code=" + agent_code
				+ "&prep_code=" + prep_code
                + "&output=" + lcOutput;
		
        URL = URL + '#toolbar=0';
        if (lcOutput !== 'screen') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        } else {
            var win = window.open(URL, "_blank", strWindowFeatures);
        }
    }

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
	
	$('#prep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#prep_code").val(row.prep_code);
            }
        },
        onChange: function () {
            if ($('#prep_name').combogrid('getValue') == '')
            {
                $("#prep_code").val('');
            }
        }
    });
	
	$('#agent_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#agent_code").val(row.agent_code);
            }
        },
        onChange: function () {
            if ($('#agent_name').combogrid('getValue') == '')
            {
                $("#agent_code").val('');
            }
        }
    });
	
</script>
