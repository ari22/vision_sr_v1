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
    array("SPK No.", "1"),
    array("SPK Date", "2")
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
                <td valign="top">
                    <table>
                         <tr>
                            <td valign="top">
                                <table >
                                    <tr>
                                        <td colspan="3">
                                            <table class="marginmin">
                                                <tr>
                                                    <td>
                                                        <table  class="marginmin">
                                                            <?php localcombobox('mounth', 'bulan1', 100, $mounth); ?>
                                                             <tr><td width="80"></td></tr>
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
                                   <tr><td width="80"></td></tr>
                                </table>
                            </td>
                        </tr>
        
                        <tr><td><br /></td></tr>
                        <tr>
                            <td valign="top">
                                <table>
                                    <tr>
                                        <td><?php getCaption('No. SPK') ?></td>
                                        <td class="td-ro">:</td>
                                        <td><input class="easyui-combogrid" id="so_no" name="so_no" disabled="true" style="width:195px;"></input></td>
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
                                        <td><?php getCaption('Tgl. SPK') ?></td>
                                        <td class="td-ro">:</td>
                                        <td>
                                            <table class='marginmin'>
                                                <tr><td width='100'><?php datebox2('date_from'); ?></td><td><?php datebox2('date_to'); ?></td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr><td width="80"></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <table >
                        <tr>
                            <td valign="top">
                                <table>
                                    <tr><td>Selected Item(s)  </td></tr>
                                    <tr><td>
                                            <select id="so_no2" name="so_no2" size="4" style="width: 200px;height: 200px;">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                            </select>
                                        </td></tr>
                                </table>
                            </td>
                            <td valign="top">
                                <table>
                                    <tr><td><br /></td></tr>
                                    <tr><td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"   onclick="rolesPrintScreen('screen');" >Screen</a></td></tr>
                                    <tr><td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="rolesPrintScreen('download');" >Printer</a></td></tr>
                                </table>
                            </td>
                        </tr>
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

<div id="sr" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php include 'spk_fn.php'; ?>
