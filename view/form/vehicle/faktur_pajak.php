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
    <div class="single-form teen-margin">
        <form id="form_validation">
            <input type="hidden" name="id" id="id">
            <table>
                <tr>
                    <td valign="top" width="330">
                        <table>
                            <tr>
                                <td><?php getCaption('No. Faktur Pajak'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('inv_no', 170, 150); ?>
                                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"   onclick="editNo();" ></a></td>
                            </tr>
                            <?php //textbox('inv_no', 'No. Faktur Pajak', 150, 4); ?>
                            <?php datebox('date', 'Tgl. Faktur Pajak', 200); ?>
                            <tr>
                                <td colspan="3">
                                    <table class="marginmin" style="float: left;">
                                        <tr><td width="80"></td></tr>
                                        <?php localcombobox('mounth', 'bulan1', 100, $mounth); ?>
                                        <tr><td width="80"></td></tr>
                                    </table>
                                    <table>
                                        <?php textbox('year', 'Tahun', 52, 4); ?>
                                    </table>
                                </td>
                            </tr>
                            <?php localcombobox('group_by', 'Group By', 195, $optGroupBy); ?>
                            <tr><td width="80"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table style="border:1px solid #ccc;border-radius:8px;padding: 10px;">
                            <?php numberbox('fp_no_beg', 'Dari', 150, 150); ?>
                            <tr><td><br /></td></tr>
                            <?php numberbox('fp_no_end', 'Sampai', 150, 150); ?>
                            <?php //numberbox('fp_no', 'Last Printed', 150, 150); ?>
                            <tr>
                                <td><?php getCaption('Last Printed'); ?></td>
                                <td>:</td>
                                <td><?php numberbox2('fp_no', 120, 150) ?></td>
                                <td> <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-reload'"   onclick="fp_seq();" ></a></td>
                            </tr>

                            <tr><td colspan="3"><hr /></td><td>-</td></tr>
                            <?php numberbox('fp_remain', 'Sisa', 150, 4); ?>
                        </table>                   
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <div  class="single-form">  
        <table >
            <tr>
                <td valign="top"  width="330">
                    <table>
                        <tr>
                            <td>Chassis / SPK</td>
                            <td class="td-ro">:</td>
                            <td><input class="easyui-combogrid" id="chassis" name="chassis" disabled="true" style="width:195px;"></input></td>
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
                        <tr><td><br /></td></tr>
                        <tr>
                            <td>Signature</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="sign_sr" name="sign_sr" style='width: 195px;'></input></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="title_sr" name="title_sr"  style="width: 195px;text-transform: uppercase;"></input></td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                         <tr><td>Selected Item(s) </td></tr>
                        <tr><td>
                        <select id="chassis2" name="chassis2" size="4" style="width: 180px;height: 180px;">
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

<div id="WindowS" class="easyui-window" title="Data <?php getCaption('Faktur Pajak'); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:730px;height:auto;padding:10px;top:1;">
    <form id="form_validationDetail" method="post" >
        <table >
            <tr>
                <td>
                    <table style="border:1px solid #ccc;width: 100%;padding:10px; margin-bottom: 10px;">
                        <tr> <td width="100"><b>Data <?php getCaption('Faktur Pajak'); ?> By</b></td>
                            <td class="td-ro">:</td>
                            <td>
                                <select class="easyui-combobox" name="data_by"  id="data_by" style="width:200px;">
                                    <option value="1">Customer Data</option>
                                    <option value="2">STNK Data</option>
                                    <option value="3">Debitor Data</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td width="160"></td></tr>
                    </table>

                </td>
            </tr>
            <tr  id="CustomerData">
                <td height="300">

                    <table style="margin-left: 10px;" >
                        <tr><td colspan="3"><h3><u>Customer Data</u></h3></td></tr>
                        <?php
                        textboxset('cust_code', 'cust_name', 'Nama', 95, 400, 50, 120);
                        textarea('cust_addr', 'Alamat', 500, 380);
                        ?>
                        <tr>
                            <td colspan="3">
                                <table  style="float:left;">
                                    <?php cmdArea('cust_area', 'Wilayah', 100); ?>
                                    <tr><td class="col200"></td></tr>
                                </table>
                                <table style="float:left;">
                                    <?php cmdCity('cust_city', 'Kota', 150); ?>
                                </table>
                                <table >
                                    <?php zipbox('cust_zipc', 'Kode Pos', 80, 5); ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        textbox('cust_npwp', 'NPWP', 200, 70);
                        textbox('cust_nppkp', 'NPPKP', 200, 70);
                        ?>
                        <tr><td class="col190"></td></tr>
                        <tr><td><br /></td></tr>
                        <tr><td colspan="3"><table  style="color:blue;"><tr><td>Note: Data NPWP, NPPKP Pelanggan di atas akan di-Update ke Master Pelanggan</td></tr></table></td></tr>

                    </table>

                </td>
            </tr>
            <tr id="STNKData" style="display: none;">
                <td height="300">

                    <table style="margin-left:10px;margin-top: -80px;">
                        <tr><td colspan="3"><h3><u>STNK Data</u></h3></td></tr>
                        <?php
                        textbox('cust_rname', 'Nama', 500, 120);
                        textarea('cust_raddr', 'Alamat', 500, 380);
                        ?>
                        <tr>
                            <td colspan="3">
                                <table class="marginmin" style="float:left;">
                                    <?php cmdArea('cust_rarea', 'Wilayah', 150); ?>
                                    <tr><td width="160"></td></tr>
                                </table>
                                <table class="marginmin" style="float:left;">
                                    <?php cmdCity('cust_rcity', 'Kota', 150); ?>
                                </table>
                                <table class="marginmin">
                                    <?php zipbox('cust_rzipc', 'Kode Pos', 80, 5); ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        textbox('cust_rnpwp', 'NPWP', 200, 70);
                        ?>
                        <tr><td width="160"></td></tr>
                    </table>
                </td>
            </tr>
            <tr id="debitorData" style="display: none;">
                <td height="300" >
                    <table style="margin-left:10px;margin-top: -80px;" >
                        <tr><td colspan="3"><h3><u>Debitur Data</u></h3></td></tr>
                        <?php
                        textbox('cust_dname', 'Nama', 500, 120);
                        textarea('cust_daddr', 'Alamat', 500, 380);
                        ?>
                        <tr>
                            <td colspan="3">
                                <table class="marginmin" style="float:left;">
                                    <?php cmdArea('cust_darea', 'Wilayah', 150); ?>
                                    <tr><td width="160"></td></tr>
                                </table>
                                <table class="marginmin" style="float:left;">
                                    <?php cmdCity('cust_dcity', 'Kota', 150); ?>
                                </table>
                                <table class="marginmin">
                                    <?php zipbox('cust_dzipc', 'Kode Pos', 80, 5); ?>
                                </table>
                            </td>
                        </tr>
                        <?php
                        textbox('cust_dnpwp', 'NPWP', 200, 70);
                        ?>
                        <tr><td width="160"></td></tr>
                    </table>
                </td>
            </tr>


            <tr>
                <td>
                    <table style="margin-top:0px; float:right; width: 100%" class="main-nav">
                        <tr>
                            <td width="80%"></td>
                            <td>
                                <table>
                                    <tr>
                                        <td id="buttondiv"></td>
                                        <td><button type="button" id="exit" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#WindowS').window('close');">Quit</button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

    </form>
</div>
<div id="WindowEditNo" class="easyui-window" title="Edit Tax Invoice #" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:370px;height:140px;padding:10px;top:1;">
    <form id="form_validationEditNo" method="post" >
        <table>
            <tr><td><br /></td></tr>
            <tr>

                <td>
                    <input class="easyui-combogrid" id="fp_code1" name="fp_code1"  style="width:50px;"></input>
                </td>
                <td>.</td>
                <td><?php textbox2('fp_code2', 40, 50); ?></td>
                <td>-</td>
                <td><?php textbox2('yy', 30, 30); ?></td>
                <td>.</td>
                <td><?php textbox2('fp_no2', 100, 150); ?></td>

                <td><button type="button" id="okSetNo" title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="setNo();">Ok</button></td>
            </tr>
        </table>
    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php include 'faktur_pajak_fn.php'; ?>
