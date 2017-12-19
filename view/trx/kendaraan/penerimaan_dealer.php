<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>
        <input type="hidden" name="reset" id="reset">
        <table class="main-form">
            <tr>
                <td valign="top"  width="450">
                    <table width="100%">
                        <?php
                        textbox('pur_inv_no', 'No. Faktur', 90, 70);
                        datebox('stk_date', 'Tgl. terima', 250);
                        // textbox('po_no', 'No. PO', 90, 70);
                        ?>
                        <tr>
                            <td><?php getCaption('No. PO');?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table style="margin-left: -3px;float:left"><?php cmdponew('po_no', '', $site_url);?></table>
                                <table style="margin-top: -2px;"><tr><td><button type="button" id="cmdDeletePO" title="Delete PO" class="easyui-linkbutton cmdDelete" data-options="iconCls:'icon-no'"  onclick="condDeletePO()" ></button></td></tr></table>
                            </td>
                        </tr>
                        <?php

                        datebox('po_date', 'tgl PO', 100);//n
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td class="col100"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                         <?php datebox('cls_date', 'Tgl Closed', 200); ?>
                        <?php cmdSupp('supp_code', 'supp_name', 'Supplier', 80, 250); ?><!--n-->
                        <?php cmdWrhs('wrhs_code', 'Warehouse'); ?>
                        <?php cmdLoc('loc_code', 'Location',200,0,1); ?>
                        <?php textbox('note', 'Keterangan', 285, 70); ?>

                         <tr><td class="col100"></td></tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Data Kendaraan'); ?>"  class="main-tab">
                <table style="width:900px;" >
                    <tr>
                        <td valign="top" width="450">
                            <table>
                                <?php
                                cmdVehSet('veh_code', 'veh_name', 'Kendaraan', 80, 250);//n
                                textbox('chassis', 'Chassis', 150, 17);
                                textbox('engine', 'Engine', 150, 15);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_type', 'Tipe', 150, 10);
                                textbox('veh_model', 'Model', 150, 20);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_brand', 'Merek', 150, 15);
                                textbox('veh_transm', 'Transmisi', 40, 2);
                                textbox('veh_year', 'Tahun', 40, 4);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                //cmdStdopt('stdoptcode', 'Std. Optional');
                                cmdStdoptSet('stdoptcode','stdoptname', 'Std. Optional');
                                ?>
                                <input type="hidden" name="stdoptname" id="stdoptname">
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                 <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td></td>
                        <td valign="top">
                            <table>
                                <?php
                                cmdColSet('color_code', 'color_name', 'Warna');
                                textbox('color_type', 'Tipe', 40, 10);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                ?>
                                <tr><td width="100"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>

                                                            <td><?php getCaption("Qty"); ?></td>
                                                            <td><?php getCaption("Satuan"); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><?php textbox2('qty', 30, 30);?></td>
                                                            <td><?php textbox2('unit', 50, 50);?></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <table>
                                                        <tr><td><?php getCaption("Perkiraan Stok"); ?></td></tr>
                                                        <tr><td><?php datebox2('pred_stk_d', 120);?></td>  </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                </table>
            </div>

            <div title="<?php getCaption('Dokumen'); ?>" class="main-tab">
                <table>
                    <td>
                        <table>
                            <tr>
                                <td colspan="2"></td>
                                <td><b><?php getCaption('Nomor'); ?></b></td>
                                <td><b><?php getCaption('Tanggal'); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Surat Jalan'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('sji_no', 150, 30); ?></td>
                                <td><?php datebox2('sji_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Kwitansi'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('kwiti_no', 150, 30); ?></td>
                                <td><?php datebox2('kwiti_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Faktur Pajak'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('fpi_no', 150, 30); ?></td>
                                <td><?php datebox2('fpi_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Debit Note'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('dni_no', 150, 100); ?></td>
                                <td><?php datebox2('dni_date'); ?></td>
                            </tr>
                            <tr><td colspan="4"></td></tr> <tr><td colspan="4"></td></tr>
                            <tr>
                                <td><?php getCaption('DO'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('do_no', 150, 30); ?></td>
                                <td><?php datebox2('do_date'); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption('PDI'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('pdi_no', 150, 30); ?></td>
                                <td><?php datebox2('pdi_date'); ?></td>
                            </tr>
                             <tr><td class="col100"></td></tr>
                        </table>
                    </td>

                </table>

            </div>

            <div title="<?php getCaption('Purchase Order'); ?>" class="main-tab">
                <table>
                    <td>
                        <table>
                            <?php
                            textbox('po_made_by', 'Pembuat', 150, 100);
                            textbox('po_appr_by', 'Disetujui', 150, 100);
                            textbox('po_desc', 'Keterangan', 200, 100);
                            ?>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                </table>
            </div>
        </div>
        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"> <?php navigation_ci(); ?></td>
                    <td width="500">
                        <table class="table" border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('download');" disabled="true" >Print</button>
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

<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<div id="SearchOption" style="display:none;">
    <form id="form_validation2" method="post" >
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="pur_inv_no2" name="pur_inv_no2">
            <span><?php getCaption("No. PO"); ?>:</span>
            <input type="text" id="no_po2" name="no_po2" style="width:103px;"/>
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'penerimaan_kendaraan_fn.php'; ?>