<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td width="600" valign="top">
                        <table>
                            <?php
                             textbox('opn_inv_no', 'No. Faktur', 150, 250);
                             datebox('opn_date', 'Tgl. Faktur', 200);
                             datebox('open_date', 'Tgl. Buat', 200);
                             cmdprtWrhs('wrhs_code', 'Warehouse');
                            ?>
                        </table>

                    </td>
                    <td valign="top">
                        <table >
                            <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                            <?php cmdAccOrep('oprep_code','oprep_name','Yang Opname', 93, 250); ?>
                            <?php textbox('note', 'Keterangan', 345, 250);?>
                             <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <div class="single-form">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
	<table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>
            <br />
            <table>
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td width="350"> 
                                    <table>
                                        <tr><td><?php numberbox2('tot_item', 40, 70); ?></td><td><?php getCaption('Item'); ?></td></tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><?php getCaption('QTY'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php numberbox2('tot_qty', 40, 70); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td><?php getCaption('Harga'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php numberbox2('tot_price', 100, 70); ?></td>
                                        </tr>
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
                    <td width="400"><?php navigation_ci(); ?></td>
                    <td width="400">
                        <table border="0">
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
<div id="DetailWindow" class="easyui-window" title="Accessories Opname" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1100px;height:500px;padding:5px;top:1;">
    <div style="width: 1040; margin: 20px; ">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>
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
                    <td><b><?php getCaption("Warehouse"); ?></b></td>
                    <td><b><?php getCaption("Lokasi"); ?></b></td>
                    <td><b><?php getCaption("QTY"); ?></b></td>
                    <td><b><?php getCaption("Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Satuan"); ?></b></td>
                    <td class="right"><b><?php getCaption("Harga Total"); ?></b></td>
                    <td><b><?php getCaption("Kode OPN"); ?></b></td>
                    <td><b><?php getCaption("Catatan"); ?></b></td>
                </tr>

                <tr>
                    <td><select class="easyui-combogrid" id="part_code" name="part_code" style="width:90px" disabled="true"></select></td>
                    <td><?php textbox2('part_name', 185, 150); ?></td>
                    <td><?php textbox2('wrhs_code', 70, 50); ?></td>
                    <td><?php textbox2('location', 70, 50); ?></td>
                    <td><?php numberbox2('qty', 50, 50); ?></td>
                    <td><?php textbox2('unit', 50, 50); ?></td>
                     <td><?php numberbox2('price_bd', 110, 50); ?></td>
                    <td><?php numberbox2('price_total', 110, 50); ?></td>
                    <td><?php cmdOpname('opn_code', '', $site_url,70);?></td>
                     <td><?php textbox2('note', 190, 50); ?></td>
                </tr>
                
                <tr><td colspan="9"></td><td><b><?php getCaption("Yang Opname"); ?></b></td></tr>
                <tr><td colspan="9"></td><td><?php cmdsingleAccOrep('oprep_code2','Yang Opname');?></td></tr>
               

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
            <?php textbox2('opn_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur"); ?>:</span>
            <input id="opn_date2"  name="opn_date2" style="width:90;"></input>
        
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
        
        </div>

    </form>
</div>
<?php include 'opname_fn.php';?>