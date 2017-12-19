<?php
$mounth = array(
    array('', ''),
    array('JANUARY', '01'),
    array('FEBRUARY', '02'),
    array('MARCH', '03'),
    array('APRIL', '04'),
    array('MAY', '05'),
    array('JUNE', '06'),
    array('JULY', '07'),
    array('AUGUST', '08'),
    array('SEPTEMBER', '09'),
    array('OCTOBER', '10'),
    array('NOVEMBER', '11'),
    array('DECEMBER', '12')
);

/* $bulan = $mounth[$_SESSION['bulan']];
  $bulan = $bulan[1];

  $tahun = $_SESSION['tahun'];
 */

//$m = date('m');
$bulan = $comp['bulan'];
$tahun = $comp['tahun'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <input type="hidden" name="id" id="id">
        <div class="single-form">
            <table>

                <tr>
                    <td valign="top" width="600">
                        <table>
                            <?php // cmdspkForm('so_no', 'No. SPK', $site_url); ?>
                            <tr>
                                <td><?php getCaption('No. SPK') ?></td>
                                <td class="td-ro">:</td>
                                <td><input class="easyui-combogrid" id="so_no" name="so_no" disabled="true" style="width:120px;"></input></td>
                            </tr>
                            <tr>
                                <td width="120"><?php getCaption('Periode'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" 
                                                        id="period1" 
                                                        name="period1" 
                                                        style="width:120px;" 
                                                        data-options="panelHeight:100,editable:false,width:120"
                                                        disabled=true
                                                        >
                                                            <?php
                                                            foreach ($mounth as $val) {
                                                                if ($val[1] == $bulan) {
                                                                    echo '<option value="' . $val[1] . '" selected>' . $val[0] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                                                                }
                                                            }
                                                            ?>				
                                                </select>
                                            </td>
                                            <td align="right" width="80"><?php getCaption('Tahun'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><input class="easyui-validatebox textbox" autocomplete="off" type="text" id="year1" name="year1" style="width:50px;text-align:right;" disabled=true value="<?php echo $tahun; ?>" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'');"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Sampai'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" 
                                                        id="period2" 
                                                        name="period2" 
                                                        style="width:120px;" 
                                                        data-options="panelHeight:100,editable:false,width:120"
                                                        disabled=true
                                                        >
                                                            <?php
                                                            foreach ($mounth as $val) {
                                                                if ($val[1] == $bulan) {
                                                                    echo '<option value="' . $val[1] . '" selected>' . $val[0] . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $val[1] . '">' . $val[0] . '</option>';
                                                                }
                                                            }
                                                            ?>				
                                                </select>
                                            </td>
                                            <td align="right" width="80"><?php getCaption('Tahun'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><input class="easyui-validatebox textbox" autocomplete="off" type="text" id="year2" name="year2" style="width:50px;text-align:right;" disabled=true value="<?php echo $tahun; ?>"  maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'');"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php textbox('wrhs_code', 'Warehouse', 120, 100); ?>
                            <tr>
                                <td><?php getCaption('Tipe'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('veh_type', 120, 120); ?></td>
                                            <td align="right" width="80"><?php getCaption('Transmisi'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_transm', 120, 120); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Model'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('veh_model', 120, 120); ?></td>
                                            <td align="right" width="80"><?php getCaption('Tahun'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_year', 120, 120); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php numberbox('tot_price', 'Harga Kendaraan', 120, 100); ?>

                        </table>
                    </td>

                    <td valign="top">
                        <table>
                            <?php
                            textboxset('cust_code', 'cust_name', 'Pelanggan', 90, 235);
                            textboxset('veh_code', 'veh_name', 'Kendaraan', 90, 235);
                            textboxset('color_code', 'color_name', 'Warna', 90, 235);
                            ?>
                            <tr>
                                <td width="100"><?php getCaption('Chassis'); ?></td>
                                <td class="td-ro">:</td>
                                <td colspan="4">
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('chassis', 150, 100); ?></td>
                                            <td><?php getCaption('Engine'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('engine', 120, 100); ?></td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr><td></td></tr><tr><td></td></tr>
                        </table>


                    </td>
                </tr>

            </table>
            <br />
            <table id="tbl_dtl" class="easyui-datagrid"  title="" style="width:1060px;height:130px;"></table>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="250">
                        <table border="0">
                            <tr>
                                <td><button type="button" id="process" title="<?php getCaption("Process"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="showSearch('process');"  disabled="true">Process</button></td>
                                <td><button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="print_sc('screen');">Screen</button></td>
                                <td><button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="print_sc('print');" >Print</button></td>
                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>

</div>
<div id="sr" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<style>
    .marginmin{margin: -3px;}
</style>
<?php include 'status_spk_fn.php'; ?>
