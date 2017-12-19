<?php
$key = searcharray('ARC', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
  
                <tr>
                    <td valign='top' width='350'>
                        <table>
                            <?php textbox('inv_type', 'Jenis Faktur', 200, 350);?>
                            <?php textbox('rsl_inv_no', 'No. Faktur', 142, 350);?>
                            <?php cmdacc_slhClose('sal_inv_no', 'No. Faktur Jual', $site_url,null,'retur'); ?>
                            <tr><td><br /></td></tr>
                             <tr><td><br /></td></tr>
                            <?php cmdprtWrhs('wrhs_code', 'Warehouse'); ?>
                            
                            
                        </table>
                    </td>
                    <td valign='top'  width='270'>
                        <table class="marginmin">
                            <?php datebox('opn_date', 'Tgl. Buat');?>
                            <?php datebox('rsl_date', 'Tgl. Faktur');?>
                            <tr><td class="col150"></td></tr>
                            <tr><td class="col150"></td></tr>
                            <?php datebox('sal_date', 'Tgl. Faktur Jual');?>
                             <tr><td class="col100"></td></tr>
                            <tr>
                                <td width="150"><?php getCaption('Aging Dalam'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php numberbox2('due_day', 45, 100) ?><?php getCaption("Hari"); ?></td>
                            </tr>
                            <?php datebox('due_date', 'Tgl. Aging');?>
                        </table>
                    </td>
                    <td valign="top">
                        <table class="marginmin">
                            <tr>
                                <td colspan="3">
                                    <table class="marginmin">
                                         <?php cmdAccCust('cust_code', 'cust_name', 'Pelanggan', 93, 250); ?>
                                         <?php cmdAccSalesPerson('srep_code', 'srep_name', 'Sales', 93, 250); ?>
                                        
                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="100"><?php getCaption('No. SO'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="110"><table class='marginmin'><?php textbox2('so_no', 93, 50); ?></table></td>
                                            <td width="130"><?php getCaption('Tgl. SO'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('so_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                             <tr><td class="col100"></td></tr>
                             <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                            <?php textbox('note', 'Keterangan', 345, 250); ?>
                        </table>
                    </td>
                    
                </tr>
            </table>
        </div>

        <div class="single-form" style="padding:10px;">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>
            <br />
            <table width="100%">
                <tr>
                    <td valign="top">
                        <table >
                            <tr>
                                <td width="350"> 
                                    <table>
                                        <tr><td><?php numberbox2('tot_item', 50, 70); ?></td><td><?php getCaption('Item'); ?></td></tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr><td><?php getCaption('Total'); ?> Qty</td><td><?php numberbox2('tot_qty', 50, 70); ?></td></tr>

                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td valign="top" align="right">
                        <table class="table" style="margin-left:10px; padding: 10px;">

                            <?php
                            numberbox('tot_price', 'Total Harga Netto', 200, 70);
                            numberbox('inv_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('inv_bt', 'DPP', 200, 70);
                            numberbox('inv_vat', 'PPN', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('inv_at', 'Sub Total', 200, 70);
                            numberbox('inv_stamp', 'Lain - Lain', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>

                            <?php
                            numberbox('inv_total', 'Grand Total', 200, 70);
                            ?>
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
                        <table>
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->

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

<div id="DetailWindow" class="easyui-window" title="Sales Return Accessories" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1100px;height:550px;padding:5px;top:1;">
    <div style="width: 1035; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1035px;height:200px;"></table>
        <br />
        <table style="float: right;">
            <tr>
                <td><b>Total <?php getCaption("QTY"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('hd_paid2', 95, 100); ?></td>
                <td><b>Total <?php getCaption("Harga Netto"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('hd_disc2', 95, 100); ?></td>
            </tr>
        </table>
        <br /><br /><br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>
            <input type="hidden" id="id3" name="id3">
            <table class="table" id="detail">
                <tr>
                    <td><b><?php getCaption("Kode Barang"); ?></b></td>
                    <td><b><?php getCaption("Nama Barang"); ?></b></td>
                    <td><b><?php getCaption("Warehouse"); ?></b></td>
                    <td><b><?php getCaption("QTY"); ?></b></td>
                    <td><b><?php getCaption("Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Total"); ?></b></td>
                    <td class="right"><b>Disc. (%)</b></td>
                    <td class="right"><b>Total Disc.</b></td>
                    <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                </tr>

                <tr>
                    <td><input id="part_code" name="part_code" style="width:100px" class="easyui-combogrid" autocomplete="off" disabled="true"></input></td>
                    <td><?php textbox2('part_name', 215, 150); ?></td>
                    <td><?php textbox2('wrhs_code', 70, 50); ?></td>
                    <td><?php numberbox2('qty', 50, 50); ?></td>
                    <td><table><?php textbox2('unit', 50, 50); ?></table></td>
                    <td class="right"><?php numberbox2('price_bd', 110, 50); ?></td>
                    <td class="right"><?php numberbox2('price_total', 110, 50); ?></td>
                    <td class="right"><input class="easyui-numberbox" precision="2" id="disc_pct"  name="disc_pct" style="width:65px"></td>
                    <td class="right"><?php numberbox2('disc_val', 110, 50); ?></td>
                    <td class="right"><?php numberbox2('price_ad', 110, 50); ?></td>
                </tr>

                <tr><td colspan="10"></td></tr>
                <tr><td colspan="10"></td></tr>

            </table>
            <table  style="float: right;">
                <tr>        
                    <td><b><?php getCaption("Sales"); ?> 1</b></td>
                    <td><b><?php getCaption("Sales"); ?> 2</b></td>
                    <td class="right"><b>Disc. <?php getCaption("Satuan"); ?> </b></td>
                    <td colspan="2" class="right"><b><?php getCaption("Harga Netto Satuan"); ?></b></td>
                </tr>
                <tr> 
                    <td><?php cmdaccSales('srep_code1', '', 0, 0, 100); ?></td>
                    <td><?php cmdaccSales('srep_code2', '', 0, 0, 100); ?></td>
                    <td><?php numberbox2('disc_unit', 90, 50); ?></td>
                    <td><?php numberbox2('price_ad_unit', 120, 50); ?></td>
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
                        </table>  
                    </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <?php textbox2('rsl_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="rsl_date2"  name="rsl_date2" style="width:90;"></input>

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'returpenjualanacc_fn.php'; ?>