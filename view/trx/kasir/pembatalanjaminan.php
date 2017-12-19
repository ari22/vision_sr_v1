<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top" width="560">                       
                        <table style="margin-top:25px;">
                            <tr>
                                <td valign='top'>
                                    <table class='marginmin'>
                                        <?php textbox('dpc_inv_no', 'No. Faktur', 150, 15); ?>
                                         <?php cmbdpch('dp_inv_no', 'No. Faktur U. J', $site_url); ?>
                                         <?php textbox('so_no', 'No. SPK', 150, 15);?>
                                         <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign='top'>
                                    <table class='marginmin'>
                                         <?php datebox('dpc_date', 'Tgl. Faktur', 200); ?>
                                         <?php datebox('dp_date', 'Tgl. Faktur U. J', 200); ?>
                                         <?php datebox('so_date', 'Tgl. SPK', 200);?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"> <table class='marginmin'><?php datebox('opn_date', 'Tgl. Buat', 200); ?> <tr><td class='col100'></td></tr></table></td>
                               
                            </tr>                        
                        </table>
                    </td>
                    <td valign="top">
                        <table style="float: right;margin-right: 9px;">  <?php datebox('cls_date', 'Tgl Closed', 200); ?></table>
                        <table style='background: #f5f5f5; padding:5px;'>
                            <tr>
                                <td valign="top">
                                    <table class='marginmin'>
                                        <?php datebox('pay_date', 'Tgl. Pengembalian'); ?>
                                        <?php cmdBank('bank_code', 'Bank', $site_url, 130, 0, 0); ?>
                                        <?php textbox('check_no','No. Check', 130, 150);?>
                                        <?php datebox('due_date', 'Jatuh Tempo'); ?>
                                         <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table class='marginmin'>
                                        <?php cmdPayType('pay_type', 'Jenis Bayar', $site_url); ?>
                                         <tr><td>&nbsp;</td></tr>
                                         <?php datebox('check_date', 'Tanggal Check'); ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                    <table class='marginmin'>
                                        <?php textbox('pay_desc', 'Keterangan', 385, 400) ?>
                                        <tr><td class='col100'></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>

        <div class="single-form">
            <table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
            <table style="margin-top: 10px;">
                <tr>
                    <td width="530" valign="top">
                        <table>
                            <?php cmdCustSet('cust_code', 'cust_name', 'Pelanggan', 100, 238); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td><?php getCaption("Chassis"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('chassis', 140, 12); ?></td>
                                            <td><?php getCaption("Engine"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('engine', 140, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php textbox('veh_name', 'Kendaraan', 340, 12); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php textboxset('color_code', 'color_name', 'Warna', 80, 256); ?>
                            <tr>
                                <td><?php getCaption("Warehouse"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('wrhs_code', 140, 12); ?></td>
                                            <td></td>
                                            <td class="td-ro"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('note', 'Catatan', 340, 12); ?>
                        </table>
                    </td>

                    <td valign="top">
                        <table>
                            <tr>
                                <td></td>
                                <td align="right"><?php getCaption("Uang Jaminan"); ?></td>
                                <td align="right"><?php getCaption("Pemotongan"); ?></td>
                                <td align="right"><?php getCaption("Pemotongan Lain"); ?></td>
                                <td align="right"><?php getCaption("Pengembalian"); ?></td>
                            </tr>
                            <tr>
                                <td><b>Total:</b></td>
                                <td><?php numberbox2('inv_at', 105, 70); ?></td>
                                <td><?php numberbox2('inv_deduct', 105, 70); ?></td>
                                <td><?php numberbox2('inv_deduc2', 105, 70); ?></td>
                                <td><?php numberbox2('inv_total', 105, 70); ?></td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>


        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="400">
                        <table border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->                                   
                                </td>
                            </tr>
                        </table>   
                    </td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>

    </form>
</div>
<div id="DetailWindow" class="easyui-window" title="Booking Fee Cancellation" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1080px;height:500px;padding:5px;top:1;">
    <div style="margin: 20px;">
        <table id="dt_dpccd2" class="easyui-datagrid"  title="" style="width:1020px;height:200px;"></table>
        <br />
        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td><?php getCaption("No. Check"); ?></td>
                    <td><?php getCaption("Tanggal Check"); ?></td>
                    <td><?php getCaption("Tgl J. Tempo"); ?></td>
                    <td><?php getCaption("Tgl. Bayar"); ?></td>
                    <td><?php getCaption("Bank"); ?></td>
                    <td>EDC</td>
                    <td align="right"><?php getCaption("Uang Jaminan"); ?></td>
                    <td align="right"><?php getCaption("Pemotongan"); ?></td>
                    <td align="right"><?php getCaption("Pemotongan Lain"); ?></td>
                    <td align="right"><?php getCaption("Pengembalian"); ?></td>
                </tr>
                <tr>
                    <td><input class="easyui-combogrid" id="check_no" name="check_no" disabled="true" style="width: 130px;"></input></td>
                    <td><?php datebox2('check_date'); ?></td>
                    <td><?php datebox2('due_date'); ?></td>
                    <td><?php datebox2('pay_date'); ?></td>
                    <td><?php textbox2('bank_code', 100, 200); ?></td>
                    <td> <?php textbox2('edc_code', 50, 200); ?></td>
                    <td><?php numberbox2('pay_val', 105, 17); ?></td>
                    <td><?php numberbox2('pay_deduct', 105, 17); ?></td>
                    <td><?php numberbox2('pay_deduc2', 105, 17); ?></td>
                    <td><?php numberbox2('pay_rval', 100, 17); ?></td>
                </tr>
                <tr><td colspan="10"></td></tr>
                <tr>
                    <td colspan="3"><?php getCaption("Dibayar oleh"); ?></td>
                    <td colspan="4"><?php getCaption("Alamat"); ?></td>
                    <td colspan="3"><?php getCaption("Keterangan"); ?></td>
                </tr>
                <tr>
                    <td colspan="3"><?php textbox2('payer_name', 330, 200); ?></td>
                    <td colspan="4"><?php textbox2('payer_addr', 350, 200); ?></td>
                    <td colspan="3"><?php textbox2('pay_desc', 295, 200); ?></td>
                </tr>

            </table>
            <br />
            <table>
                <tr>
                    <td>  
                        <table class="table" style="width:500px;" border="0">
                            <tr>
                                <td style="border-top:0px !important;">
                                    <button type="button" id="cmdFirst2" title="First" data-options="iconCls:'icon-first'" class="easyui-linkbutton" onclick="read_show2('F')" disabled="true"></button>
                                    <button type="button" id="cmdPrev2" title="Prev" data-options="iconCls:'icon-prev'" class="easyui-linkbutton" onclick="read_show2('P')" disabled="true"></button>
                                    <button type="button" id="cmdNext2" title="Next" data-options="iconCls:'icon-next'" class="easyui-linkbutton"  onclick="read_show2('N')" disabled="true"></button>
                                    <button type="button" id="cmdLast2" title="Last" data-options="iconCls:'icon-last'" class="easyui-linkbutton" onclick="read_show2('L')" disabled="true"></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton" onclick="rolesSave2()" disabled="true" ></button>
                                    <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton"   onclick="condCancel2()" disabled="true" ></button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="rolesAdd2()" disabled="true"></button>
                                    <button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>
                                    <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="rolesDel2()" disabled="true" > </button>
                                    <button id="ok2" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#DetailWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation3" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur Batal"); ?>:</span>
            <input id="code" name="code">

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();" data-options="iconCls:'icon-no'">Cancel</button>

        </div>
        <br />

    </form>
</div>

<?php include 'pembatalanjaminan_fn.php'; ?>
