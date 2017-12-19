<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top" width="300">
                        <table>
                            <?php textbox('wor_no', 'No. SPOK', 150, 250); ?>
                            <?php datebox('wor_date', 'Tgl. SPOK'); ?>
                            <?php cmboreqtype('oreq_type', 'Jenis SPOK', $site_url); ?>
                            <?php datebox('opn_date', 'Tgl. Buat'); ?>
                        </table>
                    </td>
                    <td valign="top" width="300">
                        <table>
                            <?php textbox('req_code', 'Diminta Oleh', 150, 250); ?>
                            <?php datebox('need_date', 'Tgl. Pemakaian'); ?>
                            <?php textbox('doc_no', 'No. Dokumen', 150, 250); ?> 
                        </table>
                    </td>
                    <td valign="top">
                        <table>

                            <?php cmdprtWrhs('wrhs_code', 'Warehouse'); ?>
                            <?php cmdDepartment('dept_code', 'dept_name', 'Department'); ?>
                            <?php cmdDepartUnit('dunit_code', 'dunit_name', 'Kode Unit'); ?>
                            <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                        </table>
                       
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
            <table> <?php textbox('tot_item', 'Item', 50, 250); ?></table>
            <br />
            <table> 
                <?php textbox('note', '1', 550, 250); ?>
                <?php textbox('note2', '2', 550, 250); ?>
                <?php textbox('note3', '3', 550, 250); ?>
                <?php textbox('note4', '4', 550, 250); ?>
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
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="false">Detail</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                   <!-- <button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-download'"  onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->
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
<div id="DetailWindow" class="easyui-window" title="Accessories Work Order Request Detail" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1100px;height:420px;padding:5px;top:1;">
    <div style="width: 980; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>
        <br />
        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>
            <table class="table">
                <tr>
                    <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                    <td><b><?php getCaption("Nama Pekerjaan"); ?></b></td>
                    <td><b><?php getCaption("Keterangan"); ?></b></td>
                    <td><b><?php getCaption("Aksi"); ?></b></td>
                    <td><b><?php getCaption("Ditambahkan Oleh"); ?></b></td>
                    <td><b><?php getCaption("Tgl. Ditambahkan"); ?></b></td>
                </tr>
                <tr>
                    <td><?php acc_wkcd('wk_code', 'Kode', $site_url,120,0); ?></td>
                    <td><?php textbox2('wk_desc', 250, 250); ?></td>
                    <td><?php textbox2('desc', 320, 320); ?></td>
                    <td>
                        <select class="easyui-combobox" name="act_code" id="act_code" style="width:120px;">
                            <option value="HOLD">HOLD</option>
                            <option value="CANCEL">CANCEL</option>
                        </select>
                    </td>

                    <td><?php textbox2('add_by', 110, 17, 0); ?></td>
                    <td><?php datebox2('add_date'); ?></td>                       
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
            <span><?php getCaption("No. SPOK"); ?>:</span>
            <?php textbox2('wor_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. SPOK"); ?>:</span>
            <input id="wor_date2"  name="wor_date2" style="width:90;"></input>
        
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
        
        </div>

    </form>
</div>
<?php include 'spokacc_fn.php'; ?>