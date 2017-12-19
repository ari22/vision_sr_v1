<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td width="560" valign="top">
                        <table>
                            <?php textbox('mov_inv_no', 'No. Faktur', 150, 250); ?>
                            <?php datebox('mov_date', 'Tgl. Faktur', 100); ?>
                            <?php datebox('opn_date', 'Tgl. Buat', 100); ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                            <?php cmdMstMover('mvrep_code', 'mvrep_name', 'Yang Memindahkan', 105, 240); ?>
                            <?php cmdprtWrhs('wrhs_from', 'Dari Warehouse'); ?>
                            <?php cmdprtWrhs('wrhs_to', 'Ke Warehouse'); ?>
                            <?php textbox('note', 'Keterangan', 345, 250); ?>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
            <table>
                <tr>
                    <td width="693" valign="top">
                        <table>
                            <tr><td><?php getCaption('Item'); ?></td><td><?php numberbox2('tot_item', 50, 70); ?></td></tr></table>
                    </td>
                    <td>
                        <table valign="top">
                            <tr><td><?php getCaption('Total'); ?></td><td><?php numberbox2('tot_qty', 50, 70); ?></td></tr></table>
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
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-download'"  onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->
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
<div id="DetailWindow" class="easyui-window" title="Accessories Movement" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1000px;height:480px;padding:5px;top:1;">
    <div style="width: 940; margin: 20px; ">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:940px;height:200px;"></table>
        <br />
        <table style="float: right;">
            <tr>
                <td><b>Total <?php getCaption("Item"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('tot_item2', 95, 100); ?></td>
                <td><b>Total <?php getCaption("QTY"); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('tot_qty2', 95, 100); ?></td>
            </tr>
        </table>
        <br /><br /><br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>
            <input type="hidden" id="id3"  name="id3">
            <table class="table" id="detail">
                <tr>
                    <td><b><?php getCaption("Kode Barang"); ?></b></td>
                    <td><b><?php getCaption("Nama Barang"); ?></b></td>
                    <td width="55"><b><?php getCaption("Dari Warehouse"); ?></b></td>
                    <td width="55"><b><?php getCaption("Dari Lokasi"); ?></b></td>
                    <td width="55"><b><?php getCaption("Ke Warehouse"); ?></b></td>
                     <td width="55"><b><?php getCaption("Ke Lokasi"); ?></b></td>
                     <td class="right"><b><?php getCaption("QTY"); ?></b></td>
                      <td class="right"><b><?php getCaption("satuan"); ?></b></td>
                    <td><b><?php getCaption("Catatan"); ?></b></td>
                </tr>

                <tr>
                    <td><select class="easyui-combogrid" id="part_code" name="part_code" style="width:80px" disabled="true"></select></td>
                    <td><?php textbox2('part_name', 190, 150); ?></td>
                    <td width="50"><?php textbox2('wrhs_from', 75, 50); ?></td>
                    <td width="50"><?php textbox2('loc_from', 75, 50); ?></td>
                    <td width="50"><?php textbox2('wrhs_to', 75, 50); ?></td>
                    <td width="50">
                       <select class="easyui-combogrid" id="loc_to" name="loc_to" style="width:80px" disabled="true"></select>
                    </td>
                    <td><?php numberbox2('qty', 80, 50);?></td>
                     <td><?php textbox2('unit', 50, 50);?></td>
                    <td><?php textbox2('note', 200, 50); ?></td>
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
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
         <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <?php textbox2('mov_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="mov_date2"  name="mov_date2" style="width:90;"></input>
        
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
        
        </div>

    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php include 'pindahacc_fn.php'; ?>