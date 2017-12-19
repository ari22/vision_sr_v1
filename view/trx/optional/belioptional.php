<?php
$key = searcharray('APW', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td><?php getCaption('Jenis Faktur'); ?></td>
                                <td class="td-ro">:</td>
                                <td><input class="easyui-validatebox textbox" autocomplete="off" type="text" name="inv_type" id="inv_type" style="width: 360px;"></td>
                            </tr>

                            <tr>
                                <td width="150"><?php getCaption('No. Faktur Beli'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="163"><?php textbox2('pur_inv_no', 142, 150); ?></td>
                                            <td width="90"><?php getCaption('Tgl. Faktur Beli'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('pur_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php // datebox('opn_date', 'Tgl. Buat', 200); ?>
                              <?php cmdWrhsVehAcc('wrhs_code', 'Warehouse'); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php datebox('rcv_date', 'Tgl. Terima', 100); ?>
                            <?php textbox('note', 'Keterangan', 360, 250); ?>
                        </table>

                    </td>
                    <td valign="top">
                        
                        <table>

                            <?php cmdAccSupp('supp_code', 'supp_name', 'Supplier', 93, 270); ?>
                            <tr>
                                <td width="150"><?php getCaption('No. Surat Jalan'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="155"><?php textbox2('sj_no', 140, 150); ?></td>
                                            <td width="105"><?php getCaption('Tgl. Surat Jalan'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('sj_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="150"><?php getCaption('No. Faktur Supplier'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="155"><?php textbox2('supp_invno', 140, 150); ?></td>
                                            <td width="105"><?php getCaption('Tgl. Faktur'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('supp_invdt'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                           <tr>
                                <td width="150"><?php getCaption('No. WO'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="155">
                                                <table class='marginmin'>
                                                     <tr>
                                                         <td><select class="easyui-combogrid" id="wo_no" name="wo_no" style="width:120px"></select></td>
                                                         <td><button type="button" id="cmdDeleteWO" title="Delete PO" class="easyui-linkbutton cmdDelete" data-options="iconCls:'icon-no'"  onclick="condDeleteWO()" ></button></td>
                                                     </tr>
                                                 </table>    
                                            <td width="105"><?php getCaption('Tgl. WO'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('wo_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td width="150"><?php getCaption('Billing Term'); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="155">
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td><?php numberbox2('due_day', 50, 100) ?></td>
                                                        <td><?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="105"><?php getCaption('Billing Date'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('due_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php datebox('cls2_date', 'Tgl Closed', 200); ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="single-form">
     <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid" style="width:1080px;height:150px;"></table>

            <table>
                <tr>
                    <td colspan="2">
                        <table>
                            <tr>
                                <td><?php numberbox2('tot_item', 50, 70); ?></td>
                                <td><?php getCaption('Item'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td width="740" valign="top">
                        
                        <table style="border:1px solid #ccc;">
                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td width="120"><?php getCaption('Chassis'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="150"><?php textbox2('chassis', 150, 200); ?></td>
                                                        <td width="80"><?php getCaption('engine'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php textbox2('engine', 120, 200); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="120"><?php getCaption('Tipe'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="150"><?php textbox2('veh_type', 120, 200); ?></td>
                                                        <td width="80"><?php getCaption('Model'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php textbox2('veh_model', 120, 200); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php textboxset('veh_code', 'veh_name', 'Kendaraan', 80, 283); ?>
                                        <?php textboxset('color_code', 'color_name', 'Warna', 80, 283); ?>
                                        <tr>
                                            <td width="120"><?php getCaption('No. SPK'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="150"><?php textbox2('so_no', 120, 200); ?></td>
                                                        <td width="80"><?php getCaption('Tgl. SPK'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php datebox2('so_date'); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table>
                                        <?php textbox('veh_transm', 'Transmisi', 60, 250); ?>
                                        <?php textbox('veh_year', 'Tahun', 60, 250); ?>
                                        <?php textbox('srep_name', 'Sales', 100, 250); ?>
                                        <?php textbox('sal_inv_no', 'Sales Invoice', 100, 250); ?>
                                    </table>
                                </td>
                            </tr>

                        </table>

                    </td>
                    <td valign="top">
                        <table class="table" style="padding: 10px; background: #ccc;">

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
                    <td width="500">
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


<div id="DetailWindow" class="easyui-window" title="Optional Purchase Detail" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1100px;height:500px;padding:10px;top:1;">

    <div style="width: 830; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1030px;height:250px;"></table>
        <br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>
            <input type="hidden" id="wood_id" name="wood_id">
            <table class="table">
                <tr>
                    <td>
                        <table class="table">
                            <tr>
                                <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                                <td><b><?php getCaption("Nama Pekerjaan"); ?> </b></td>
                                <td class="right"><b><?php getCaption("Harga Satuan"); ?></b></td>
                                <td class="right"><b>Disc. (%)</b></td>
                                <td class="right"><b>Total Disc.</b></td>
                                <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                               
                            </tr>
                            <tr>
                                <td><select class="easyui-combogrid" id="wk_code" name="wk_code" style="width:150px" disabled="true"></select></td>

                                <td><?php textbox2('wk_desc', 350, 17); ?></td>
                                <td><?php numberbox2('price_bd', 120, 50); ?></td>
                                <td><input class="easyui-numberbox" autocomplete="off" precision="2" id="disc_pct"  name="disc_pct" style="width:120px"></td>
                                <td><?php numberbox2('disc_val', 120, 50); ?></td>
                                <td><?php numberbox2('price_ad', 120, 50); ?></td> 
                               
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                <td><b><?php getCaption("Faktur Jual"); ?>#</b></td>
                            </tr>
                            <tr>
                                <td colspan="5"></td>
                                 <td><?php textbox2('sal_inv_no', 120, 17); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
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
            <?php textbox2('pur_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="pur_date2"  name="pur_date2" style="width:90;"></input>
        
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
        
        </div>

    </form>
</div>
<?php include 'belioptional_fn.php'; ?>