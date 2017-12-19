<?php
$dataperiode = array
    (
    array("Current Period", "1"),
    array("History", "2")
);
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top">
                        <table style="width: 590px;">
                            <tr>
                                <td><?php getCaption("No. WO"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('wo_no', 130, 12); ?></td>

                                            <td width="110"></td>
                                            <td class="td-ro"></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Tgl. WO"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="130">
                                                <?php datebox2('wo_date'); ?>
                                            </td>
                                            <td width="110"><?php getCaption("Tgl. Pick"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('opn_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("No. Quotation"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('quote_no', 130, 12); ?></td>

                                            <td width="110"><?php getCaption("Tgl. Quotation"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('quote_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php cmdAgent('agent_code', 'agent_name', 'Biro Jasa', 100, 242); ?>
                            <?php textbox('saddr', 'Alamat', 345, 200); ?>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('sarea', 102, 12); ?></td>
                                            <td><?php textbox2('scity', 102, 12); ?></td>
                                            <td><?php textbox2('scountry', 80, 12); ?></td>
                                            <td><?php textbox2('szipcode', 50, 12); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php getCaption("Telepon"); ?>: <?php textbox2('sphone', 102, 12); ?></td>
                                            <td colspan="2"><?php getCaption("Fax"); ?>: <?php textbox2('sfax', 104, 12); ?></td>                                           
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td valign="top">
                        <table style="" width="100%"><tr><td align="right"><table><?php datebox('cls_date', 'Tgl Closed', 200); ?></table></td></tr></table>
                        <table class="marginmin" style="border:1px solid #fff;padding: 2px;margin-bottom: 5px;">
                            <?php cmdAccPrep('prep_code', 'prep_name', 'Purchaser', 120, 247); ?>
                            <tr><td class="col70"></td></tr>
                        </table>
                        <table class="marginmin" style="border:1px solid #ccc;padding: 2px;">
                            <tr>
                                <td width="63"><?php getCaption("Dikirim ke"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table style="margin-left: -5px;">
                                        <tr>
                                            <td>
                                                <table> <?php cmdRAddress('raddr_code', '', 0, 0); ?></table>
                                            </td>
                                            <td colspan="3"><?php textbox2('rname', 236, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php textbox('raddr', 'Alamat', 345, 200); ?>
                            <tr>
                                <td></td>
                                <td class="td-ro"></td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('rarea', 102, 12); ?></td>
                                            <td><?php textbox2('rcity', 102, 12); ?></td>
                                            <td><?php textbox2('rcountry', 80, 12); ?></td>
                                            <td><?php textbox2('rzipcode', 50, 12); ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><?php getCaption("Telepon"); ?>: <?php textbox2('rphone', 102, 12); ?></td>
                                            <td colspan="2"><?php getCaption("Fax"); ?>: <?php textbox2('rfax', 104, 12); ?></td>                                           
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td class="col70"></td></tr>
                        </table>
                        <table class="marginmin">
                            <tr>
                                <td><?php getCaption("Tgl. Kirim"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table>
                                        <tr>
                                            <td width="150"><?php datebox2('prcvd_date'); ?></td>

                                            <td  width='90'><?php getCaption("Jatuh Tempo"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                             
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td> <?php numberbox2('due_day', 45, 100) ?></td>
                                                        <td><?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Warehouse"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table >
                                        <tr>
                                            <td width="150"><table  class='marginmin'><?php cmdWrhs('wrhs_code', ''); ?></table></td>

                                            <td width='90'><?php getCaption("Tgl J. Tempo"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('due_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td class="col70"></td></tr>
                        </table>
                    </td>

                </tr>
            </table>
        </div>

        <div class="single-form" style="padding: 10px;">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid" style="width:1085px;height:150px;"></table>

            <table width="100%">
                <tr>
                    <td  valign="top">
                        <table >
                            <tr>
                                <td><?php numberbox2('tot_item', 50, 70); ?></td>
                                <td><?php getCaption('Item'); ?></td>
                            </tr>
                        </table>

                        <table style="margin-top: 5px;">
                            <tr><td><b><?php getCaption('Keterangan'); ?>:</b></td></tr>
                            <tr>
                                <td>
                                    <table style="border:1px solid #ccc;">
                                        <?php textbox('note', '1', 690, 250); ?>
                                        <?php textbox('note2', '2', 690, 250); ?>
                                        <?php textbox('note3', '3', 690, 250); ?>
                                        <?php textbox('note4', '4', 690, 250); ?>
                                    </table>
                                </td>
                            </tr>
                        </table>


                    </td>
                    <td valign="top" align="right">
                        <table class="table" style="padding-left: 5px;padding-top: 10px;padding-bottom: 10px;background: #ccc;margin-top:5px;">

                            <?php
                            numberbox('tot_price', 'Total Harga Netto', 100, 70);
                            numberbox('inv_disc', 'Diskon', 100, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('inv_bt', 'DPP', 100, 70);
                            numberbox('inv_vat', 'PPN', 100, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('inv_at', 'Sub Total', 100, 70);
                            numberbox('inv_stamp', 'Lain - Lain', 100, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>

                            <?php
                            numberbox('inv_total', 'Grand Total', 100, 70);
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
                    <td  width="400">
                        <table>
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                    <button type="button" id="search2" title="<?php getCaption("Search"); ?>" class="search2 easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="condSearch2();" >Search2</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->

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

<div id="DetailWindow" class="easyui-window" title="BBN Work Order Details" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1090px;height:510px;padding:10px;top:1;">

    <div style="width: 1020; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1020px;height:250px;"></table>
        <br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table class="table">
                <tr>
                    <td>
                        <table class="table">
                            <tr>
                                <td><b>Data</b></td>
                                <td><b><?php getCaption("Chassis"); ?></b></td>
                                <td><b><?php getCaption("No. SPK"); ?> </b></td>
                                <td><b><?php getCaption("Tgl. SPK"); ?> </b></td>
                                <td><b><?php getCaption("Faktur Jual"); ?> </b></td>
                                <td class="right"><b><?php getCaption("Harga Jual"); ?> BBN</b></td>
                                <td class="right"><b><?php // getCaption("Diskon");    ?>Disc(%)</b></td>
                                <td class="right"><b><?php getCaption("Jumlah Diskon"); ?></b></td>
                                <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php  localcombobox('data', '', 120, $dataperiode);?></td>
                                <td><select class="easyui-combogrid" id="chassis" name="chassis" style="width:160px" disabled="true"></select></td>
                                <td><?php textbox2('so_no', 100, 17); ?></td>
                                <td><?php datebox2('so_date'); ?></td>
                               
                                <td><?php textbox2('sal_inv_no', 100, 17); ?></td>
                                <td><?php numberbox2('price_bd', 100, 17); ?></td>
                                <td><?php numberbox2('disc_pct', 80, 17); ?></td>
                                <td><?php numberbox2('disc_val', 100, 17); ?></td>
                                <td><?php numberbox2('price_ad', 100, 17); ?></td>                       
                            </tr>

                            <tr>
                                <td colspan="8">
                                    <table>
                                        <tr>
                                            <td><b><?php getCaption("Kendaraan"); ?>:</b></td>
                                            <td><b><?php getCaption("Warna"); ?>:</b></td>
                                            <td><b><?php getCaption("Pelanggan"); ?></b></td>
                                            <td><b><?php getCaption("Sales"); ?>:</b></td>
                                        </tr>
                                        <tr>
                                            <td><?php textbox2('veh_name', 150, 17); ?></td>                                         
                                            <td><?php textbox2('color_name', 250, 17); ?></td>
                                            <td><?php textbox2('cust_name', 250, 17); ?></td>                                           
                                            <td><?php textbox2('srep_name', 250, 17); ?></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td></td></tr>
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
            <span><?php getCaption("No. WO"); ?>:</span>
            <?php textbox2('wo_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. WO"); ?>:</span>
            <input id="wo_date2"  name="wo_date2" style="width:90;"></input>
        
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>
        
        </div>

    </form>
</div>
<?php include 'wobbn_fn.php'; ?>
