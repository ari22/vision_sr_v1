<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td valign="top">
                    <table>
                        <?php
                        textbox('chassis_cp', 'Chassis', 150, 100);
                        textbox('pur_inv_no', 'No. Faktur', 200, 100);
                        datebox('pur_date', 'Tgl. Faktur', 200);
                        ?>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php
                        textboxset('supp_code', 'supp_name', 'Supplier', 50, 250);
                        cmdWrhs('wrhs_orig', 'Warehouse', 150);
                        cmdLoc('loc_code', 'Lokasi',100, 0,0) ;
                        ?>
                        <tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr>
                        <?php textbox('note', 'Keterangan', 305, 200); ?>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <?php
                        datebox('cls_date', 'Tgl Closed', 90);
                        textbox('cls_by', 'Closed By', 90, 20);
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <div class="easyui-tabs">
            <div title="<?php getCaption('Data Kendaraan'); ?>"  class="main-tab">
                <table>
                    <tr>
                        <td valign="top">
                            <table class="table"  >
                                <tr>
                                    <td width="85"></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><b><?php getCaption("Kode"); ?>:</b></td>
                                                <td width="220"><b><?php getCaption("Nama"); ?>:</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="labels"><?php getCaption("Kendaraan"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3">
                                        <table style="margin-left: -2px;">
                                            <tr>
                                                <td width="100"><input type="text" name="veh_code" id="veh_code" disabled="true" style="width:100px;"></td>
                                                <td width="220"> <input type="text" name="veh_name" id="veh_name" disabled="true" style="width:285px;"></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td ><?php getCaption("Chassis"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td width="179"><input type="text" name="chassis" id="chassis" disabled="true" style="width: 160px;"></td>
                                    <td><?php getCaption("Tipe"); ?></td>
                                    <td>: <input type="text" name="veh_type" id="veh_type" disabled="true" style="width:160px;"></td>
                                </tr>
                                <tr>
                                    <td ><?php getCaption("Engine"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td width="179"><input type="text" name="engine" id="engine" disabled="true" style="width: 160px;"></td>
                                    <td><?php getCaption("Model"); ?></td>
                                    <td>: <input type="text" name="veh_model" id="veh_model" disabled="true" style="width:160px;"></td>
                                </tr>
                                <tr><td colspan="5"></td></tr>
                                <tr><td colspan="5"></td></tr>
                                <tr><td colspan="5"></td></tr>
                                <tr><td colspan="5"></td></tr>
                                <tr><td colspan="5"></td></tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3">
                                        <table>
                                            <tr>
                                                <td width="100"><b><?php getCaption("Kode"); ?>:</b></td>
                                                <td width="220"><b><?php getCaption("Nama"); ?>:</b></td>
                                                <td width="60"><b><?php getCaption("Tipe"); ?>:</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Warna"); ?></td>
                                    <td class="td-ro" valign="center">:</td>
                                    <td colspan="3">
                                        <table  style="margin-left: -2px;">

                                            <tr>
                                                <td><input type="text" name="color_code" id="color_code" disabled="true" style="width:100px;"></td>
                                                <td><input type="text" name="color_name" id="color_name" disabled="true" style="width:220px;"></td>
                                                <td><input type="text" name="color_type" id="color_type" disabled="true" style="width:60px;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td colspan="5"></td></tr>
                                <tr><td colspan="5"></td></tr>
                                <tr>
                                    <td><?php getCaption("Std. Optional"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3">
                                        <input type="text" name="stdoptcode" id="stdoptcode" disabled="true" style="width:390px;">
                                    </td>
                                </tr>

                            </table>
                        </td>

                        <td valign="top">
                            <table class="table" style="width:200px !important;">

                                <?php
                                textbox('veh_brand', 'Merek', 80, 200);
                                textbox('veh_transm', 'Transmisi', 40, 200);
                                textbox('veh_year', 'Tahun', 60, 4);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                ?>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('sal_inv_no', 'No. Faktur', 150, 70);
                                datebox('sal_date', 'Tgl. Faktur', 200);
                                ?>
                                <tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr>
                                <?php
                                textbox('so_no', 'SPK Match', 150, 70);
                                datebox('match_date', 'Tanggal Match', 100);
                                ?>
                            </table>
                        </td>

                    </tr>
                    <tr><td colspan="3"></td></tr>
                    <tr>
                        <td colspan="3">
                            <table>
                                <tr>
                                    <td width="85"><b>Stock</b></td>
                                    <td class="td-ro"></td>
                                    <td>
                                        <table style="color:#002166;margin-top: 20px;border:1px solid #ccc;padding: 5px;border-radius:4px;">
                                            <tr>
                                                <td width="60" align="right"><?php getCaption("Awal"); ?></td>
                                                <td width="50"></td>
                                                <td width="50"></td>
                                                <td width="50" align="right"><?php getCaption("Pick"); ?></td>
                                                <td width="50" align="right"><?php getCaption("Jual"); ?></td>
                                                <td width="50"></td>
                                                <td width="50"></td>
                                                <td width="50" align="right"><?php getCaption("Akhir"); ?></td>
                                                <td width="20"></td>
                                                <td width="50"><?php getCaption("Status"); ?></td>
                                                <td></td>
                                                <td width="50"></td>
                                                <td width="80"><?php getCaption("Perkiraan Stok"); ?></td>
                                                <td>Real Stock</td>
                                                <td width="20"></td>
                                                <td width="150" align="center"><?php getCaption("Umur Stock"); ?></td>
                                            </tr>

                                            <tr>
                                                <td width="60"><?php numberbox2('beg_qty', 60, 50);?></td>
                                                <td width="50"><?php numberbox2('pur_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('rpur_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('pick_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('sal_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('rsal_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('opn_qty', 50, 50);?></td>
                                                <td width="50"><?php numberbox2('end_qty', 50, 50);?></td>
                                                <td width="20"></td>
                                                <td width="50"><?php textbox2('stk_code', 50, 150);?></td>
                                                <td></td>
                                                <td> <button type="button" id="cmdRefresh"  class="easyui-linkbutton" data-options="iconCls:'icon-reload'"  onclick="cmdRef()" title="Refresh" disabled="true"></button></td>
                                                <td><?php datebox2('pred_stk_d'); ?></td>
                                                <td><?php datebox2('stk_date'); ?></td>
                                                <td></td>
                                                <td align="center"><span id="hari" style="font-size: 18px;font-weight: bold;text-align: center;"></span></td>
                                            </tr>
                                            <tr>
                                                <td width="50"></td>
                                                <td width="50" align="right"><?php getCaption("Beli"); ?></td>
                                                <td width="50" align="right"><?php getCaption("Retur Beli"); ?></td>
                                                <td width="50"></td>
                                                <td width="50"></td>
                                                <td width="50" align="right"><?php getCaption("Retur Jual"); ?></td>
                                                <td width="50" align="right"><?php getCaption("Opname"); ?></td>
                                                <td width="50"></td>
                                                <td width="20"></td>
                                                <td width="50"></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td align="center"><?php getCaption("Hari"); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </div>
            
            <div title="<?php getCaption('Dokumen Pembelian'); ?>"  class="main-tab">
                <table>
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td colspan="2"></td>
                                    <td><b><?php getCaption('Nomor'); ?>:</b></td>
                                    <td><b><?php getCaption('Tanggal'); ?>:</b></td>
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
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="<?php getCaption('Purchase Order'); ?>"  class="main-tab">
                <table>

                    <?php
                    textbox('po_no', 'No. PO', 200, 10);
                    datebox('po_date', 'Tgl PO', 100);
                    ?>
                    <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>
                    <?php
                    textbox('po_made_by', 'Pembuat', 150, 50);
                    textbox('po_appr_by', 'Disetujui', 150, 50);
                    textbox('po_note', 'Keterangan', 300, 50);
                    ?>
                </table>
            </div>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td><?php navigation_ci(); ?></td>
                     <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
           
        </div>

    </form>
</div>
<?php include 'stokkendaraan_fn.php'; ?>