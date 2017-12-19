<?php
$mounth = array
    (
    array("January", "01"),
    array("February", "02"),
    array("March", "03"),
    array("April", "04"),
    array("May", "05"),
    array("June", "06"),
    array("July", "07"),
    array("August", "08"),
    array("September", "09"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);
$optGroupBy = array
    (
    array("Chassis / SPK", "1"),
    array("Invoice Date", "2")
);
?>
<style>
    #year{text-align:right;}
</style>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <input type="hidden" name="id" id="id">
        <table>
            <tr>
                <td valign="top" width="320">
                    <table>
                        <tr>
                            <td valign="top">
                                <table >
                                    <?php datebox('date', 'Tgl. Faktur', 200); ?>
                                    <tr>
                                        <td colspan="3">
                                            <table class="marginmin">
                                                <tr>
                                                    <td>
                                                        <table class="marginmin" >
                                                            <?php localcombobox('mounth', 'bulan1', 100, $mounth); ?>
                                                             <tr><td width="90"></td></tr>
                                                        </table>
                                                    </td>
                                                    <td>
                                                        <table><?php textbox('year', 'Tahun', 53, 4); ?></table>
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </td>
                                    </tr>
                                    <?php localcombobox('group_by', 'Group By', 200, $optGroupBy); ?>
                                   <tr><td width="90"></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td><br /></td></tr>
                        <tr>
                            <td valign="top" width="350">
                                <table>
                                    <tr>
                                        <td>Chassis / SPK</td>
                                        <td class="td-ro">:</td>
                                        <td><input class="easyui-combogrid" id="chassis" name="chassis" disabled="true" style="width:200px;"></input></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="td-ro"></td>
                                        <td>
                                            <table class='marginmin' style='margin-bottom: -5px;'>
                                                <tr><td width='100'><?php getCaption('Dari') ?></td><td><?php getCaption('Sampai') ?></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php getCaption('Tgl. Faktur') ?></td>
                                        <td class="td-ro">:</td>
                                        <td>
                                            <table class='marginmin'>
                                                <tr><td width='100'><?php datebox2('date_from'); ?></td><td><?php datebox2('date_to'); ?></td></tr>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr><td width="90"></td></tr>
                                </table>

                            </td>
                        </tr>
                        <tr><td><br /></td></tr>
                        <tr>    
                            <td valign='top'>
                                <table>
                                    <tr>
                                        <td>Signature</td>
                                        <td class="td-ro">:</td>
                                        <td><input type="text" class="textbox" id="signature" name="signature" value="<?php echo $_SESSION['C_USER']; ?>" style="width:200px;"></input></td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td class="td-ro">:</td>
                                        <td><input type="text" class="textbox" id="jabatan" name="jabatan"  style="text-transform: uppercase;width:200px;"  value="KEPALA CABANG"></input></td>
                                    </tr>
                                   <tr><td width="90"></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <tr><td>Selected Item(s)  </td></tr>
                        <tr>
                            <td valign="top">
                                <table>
                                    <select id="chassis2" name="chassis2" size="4" style="width: 200px;height: 240px;">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </table>
                            </td>                         
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                          <tr><td><br /></td></tr>
                        <tr><td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"   onclick="rolesPopupPrint('screen');" >Screen</a></td></tr>
                        <tr><td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="rolesPopupPrint('print');" >Printer</a></td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr>
                
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
            </tr>
        </table>
    </div>
    
</div>

<div id="WindowSJ" class="easyui-window" title="Print Invoice" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:420px;height:230px;padding:10px;top:1;">
    <form id="form_validation4" method="post" >
        <table>
            <tr>
                <td>
                    <h1>Data in Invoice from :</h1>
                    <table>
                        <tr>
                            <td width="200"><input type="radio" name="data_type" id="data_type1" class="radio" value="pelanggan" checked="true"><?php getCaption("Data Pelanggan"); ?></td>
                            <td><?php textbox2('cust_name', 210, 150) ?></td>
                        </tr>
                        <tr>
                            <td width="200"><input type="radio" name="data_type" id="data_type2" class="radio" value="stnk"><?php getCaption("Data di STNK"); ?></td>
                            <td><?php textbox2('cust_rname', 210, 150) ?></td>
                        </tr>
                        <tr>
                            <td width="200"><input type="radio" name="data_type" id="data_type3" class="radio" value="debitur"><?php getCaption("Data Leasing/Debitur"); ?></td>
                            <td><?php textbox2('lease_name2', 210, 150) ?></td>
                        </tr>
                    </table>
                </td>             
            </tr>

        </table>
        <br />
        <table style="margin-top:0px; float:right; width: 100%">
            <tr>
                <td width="80%"></td>
                <td>
                    <table>
                        <tr>
                            <td id="buttonSJ"></td>
                            <td><button type="button" id="exit" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#WindowSJ').window('close');">Quit</button></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php include 'kwitansi_fn.php'; ?>
