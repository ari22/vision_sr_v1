<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top">
                        <table style="width: 600px;">
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
                            <?php cmdAccSupp('supp_code', 'supp_name', 'Supplier', 100, 242); ?>
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

                        <table style="border:1px solid #fff;padding: 2px;margin-bottom: 5px;">
                            <?php cmdAccPrep('prep_code', 'prep_name', 'Purchaser', 100, 260); ?>
                            <tr><td class="col70"></td></tr>
                        </table>
                        <table style="border:1px solid #ccc;padding: 2px;">
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
                            <?php textbox('raddr', 'Alamat', 365, 200); ?>
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
                        <table style="border:1px solid #fff;padding: 2px;">
                            <tr>
                                <td><?php getCaption("Tgl. Kirim"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin' >
                                        <tr>
                                            <td width="150"><?php datebox2('prcvd_date'); ?></td>

                                            <td  width='80'><?php getCaption("Jatuh Tempo"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td> <?php numberbox2('due_day', 60, 100) ?></td>
                                                        <td><?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Tgl Closed"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="150"><?php datebox2('cls_date'); ?></td>

                                            <td width='80'><?php getCaption("Tgl J. Tempo"); ?></td>
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

        <div class="single-form" style="padding:10px;">
            <!--<table id="dt_dpccd" class="easyui-datagrid"  title="" style="width:1040px;height:200px;"></table>-->
            <table id="dt" class="easyui-datagrid" style="width:1080px;height:150px;"></table>
            <br />
            <table width="100%">
                <tr>
                    <td colspan="2">
                        <table style="margin-top: 0px;">
                            <tr>
                                <td><?php numberbox2('tot_item', 50, 70); ?></td>
                                <td><?php getCaption('Item'); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td  valign="top" width="740">
                        <table style="border:1px solid #ccc;">

                            <tr>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td><?php getCaption('Chassis'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="160"><table  style="margin-left: -3px;float:left"><?php chassisOptional('chassis', '', $site_url, 160); ?></table></td>
                                                        <td width="80"><?php getCaption('engine'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php textbox2('engine', 120, 200); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?php getCaption('Tipe'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="165"><?php textbox2('veh_type', 120, 200); ?></td>
                                                        <td width="80"><?php getCaption('Model'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php textbox2('veh_model', 120, 200); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php textboxset('veh_code', 'veh_name', 'Kendaraan', 90, 263); ?>
                                        <?php textboxset('color_code', 'color_name', 'Warna', 90, 263); ?>
                                        <tr>
                                            <td><?php getCaption('No. SPK'); ?></td>
                                            <td class="td-ro">:</td>
                                            <td>
                                                <table class='marginmin'>
                                                    <tr>
                                                        <td width="165"><?php textbox2('so_no', 120, 200); ?></td>
                                                        <td width="80"><?php getCaption('Tgl. SPK'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php datebox2('so_date'); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr><td class="col70"></td></tr>
                                    </table>
                                </td>
                                <td valign="top">
                                    <table>
                                        <?php textbox('veh_transm', 'Transmisi', 60, 250); ?>
                                        <?php textbox('veh_year', 'Tahun', 60, 250); ?>
                                        <?php textbox('srep_name', 'Sales', 150, 250); ?>
                                        <?php textbox('sal_inv_no', 'Sales Invoice', 100, 250); ?>

                                    </table>
                                </td>
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
                    <td valign="top" >
                        <table class="table" style="background: #ccc;padding: 10px">

                            <?php
                            numberbox('tot_price', 'Total Harga Netto', 200, 70);
                            numberbox('inv_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('inv_bt', 'DPP', 200, 70);
                            //numberbox('inv_vat', 'PPN', 200, 70);
                            ?>
							<tr>
								<td><?php getCaption('PPN');?></td>
								<td>:</td>
								<td><?php numberbox2('inv_vat', 120, 70);?></td>
								<td><button type="button" data-options="iconCls:'icon-no'"  title="Tax(VAT) deleted" class="easyui-linkbutton deletePPN"  onclick="deletePPN()" ></button></td>
							</tr>
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
                    <td widthh="400"><?php navigation_ci(); ?></td>
                    <td width="650">
                        <table>
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdDetail"  class="easyui-linkbutton"  onclick="cmdDetails()" disabled="true">Detail</button>
                                    <button type="button" id="cmdGetSPK"  class="easyui-linkbutton"  onclick="get_spk()" disabled="true">Get SPK</button>
                                    <button type="button"id="cmdGetASales"  class="easyui-linkbutton"  onclick="get_aftersales()" disabled="true">Get After Sales</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->

                                </td>

                            </tr>
                        </table>   
                    </td>
                    <td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>

    </form>
</div>

<div id="DetailWindow" class="easyui-window" title="Work Order Optional / Accesories" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1100px;height:460px;padding:10px;top:1;">

    <div style="width: 820; margin: 20px;">
        <table id="dt2" class="easyui-datagrid"  title="" style="width:1020px;height:250px;"></table>
        <br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table class="table">
                <tr>
                    <td>
                        <table class="table">
                            <tr>
                                <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                                <td><b><?php getCaption("Nama Pekerjaan"); ?> </b></td>
                                <td class="right"><b><?php getCaption("Harga Jual"); ?></b></td>
                                <td class="right"><b><?php // getCaption("Diskon");      ?>Disc(%)</b></td>
                                <td class="right"><b><?php getCaption("Jumlah Diskon"); ?></b></td>
                                <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php acc_wkcd('wk_code', 'Kode', $site_url); ?></td>
                                <td><?php textbox2('wk_desc', 370, 17); ?></td>
                                <td><?php numberbox2('price_bd', 120, 17); ?></td>
                                <td><?php numberbox2('disc_pct', 120, 17); ?></td>
                                <td><?php numberbox2('disc_val', 120, 17); ?></td>
                                <td><?php numberbox2('price_ad', 120, 17); ?></td>                       
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

<div id="GetSPKWindow" class="easyui-window"  data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:880px;height:450px;padding:10px;top:1;">

    <div style="width: 820; margin: 20px;">
        <input type="hidden" name="tbl_get" id="tbl_get">
        <table id="dt3" class="easyui-datagrid"  title="" style="width:800px;height:250px;"></table>
        <br />
      <table style="margin-top:20px;" width="95%">
        <tr>
            <td align="right" colspan="2">
                    <button type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="copy_optional();"> Ok</button>
                    <button type="button"  title="<?php getCaption("Close"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#GetSPKWindow').window('close');"> Cancel</button>                  
                </td>

            </tr>
        </table>  
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

<?php include 'wooptional_fn.php'; ?>
