<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <td valign="top">
                    <table width="350">
                        <?php
                        textbox('pur_inv_no', 'No. Faktur', 120, 15);
                        datebox('pur_date', 'Tgl. Faktur', 200);
                        datebox('opn_date', 'Tgl. Buat', 200);
                        datebox('due_date', 'Tgl J. Tempo', 200);
                        ?>
                    </table>
                </td>
                <td valign="top">
                    <table style="margin-left: 200px;">
                        <?php textboxset('supp_code', 'supp_name', 'Supplier', 75, 300); ?>
                        <tr>
                            <td><?php getCaption("No. Faktur Supplier"); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td><?php textbox2('supp_invno', 138, 12); ?></td>
                                        <td width="135"><?php getCaption("Tgl. Faktur Supplier"); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('supp_invdt'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?php getCaption("No. PO"); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table  class='marginmin'>
                                    <tr>
                                        <td><?php textbox2('po_no', 138, 12); ?></td>
                                        <td width="135"><?php getCaption("Tgl. PO"); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('po_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <?php textbox('note', 'Keterangan', 380, 20); ?>
                    </table>
                </td>
            </table>
        </div>

        <div class="single-form">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"></table>
            <br />
            <table width="100%">
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td><?php getCaption("Chassis"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('chassis', 150, 12); ?></td>
                                            <td width="60"><?php getCaption("Model"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_model', 100, 50); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Engine"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('engine', 150, 12); ?></td>
                                            <td width="60"><?php getCaption("Tipe"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_type', 100, 50); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('veh_name', 'Kendaraan', 326, 15); ?>
                            <?php textbox('color_name', 'Warna', 326, 15); ?>
                            <?php textbox('cust_name', 'Pelanggan', 326, 15); ?>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td><?php getCaption("No. SPK"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table  class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('so_no', 150, 12); ?></td>
                                            <td><?php getCaption("Tgl. SPK"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php datebox2('so_date'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table style="margin-left: 100px;" >

                            <?php
                            numberbox('inv_bt', 'DPP', 200, 70);
                            numberbox('inv_vat', 'PPN', 200, 70);

                            numberbox('inv_stamp', 'Lain - Lain', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('inv_total', 'Grand Total', 200, 70);
                            ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table class="table">

                            <?php
                            numberbox('hd_begin', 'Hutang Awal', 200, 70);
                            numberbox('hd_paid', 'Pembayaran', 200, 70);

                            numberbox('hd_disc', 'Discount', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('hd_end', 'Hutang Akhir', 200, 70);
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
                    <td width="100">
                        <table border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="bayar" title="<?php getCaption("Bayar"); ?>" class="bayar easyui-linkbutton"  onclick="bayarHutang();" data-options="iconCls:'icon-payment'">Bayar</button>
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
<div id="BayarWindow" class="easyui-window" title="Accessories Payable Payment"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1070px;height:450px;padding:10px;top:1;">
    <table id="dt2" class="easyui-datagrid"  title="" style="width:1035px;height:200px;"></table><br />

    <table style="float: right;">
        <tr>
            <td><b>Total <?php getCaption("Pembayaran"); ?></b></td>
            <td class="td-ro">:</td>
            <td><?php numberbox2('hd_paid2', 95, 100); ?></td>
            <td><b>Total <?php getCaption("Diskon"); ?></b></td>
            <td class="td-ro">:</td>
            <td><?php numberbox2('hd_disc2', 95, 100); ?></td>
        </tr>
    </table>
    <br /> <br /><br />
    <form id="form_validation3" method="post" >
        <div id="tableId2"></div>
        <table>
            <tr>
                <td><?php getCaption("Tgl. Bayar"); ?></td>
                <td><?php getCaption("Jenis Bayar"); ?></td>
                <td><?php getCaption("No. Check"); ?></td>
                <td><?php getCaption("Tanggal Check"); ?></td>
                <td><?php getCaption("Tgl J. Tempo"); ?></td>
                <td class='right'><?php getCaption("Pembayaran"); ?></td>
                <td class='right'><?php getCaption("Diskon"); ?></td>
                <td><?php getCaption("Keterangan"); ?></td>
                <td><?php getCaption("Kolektor"); ?></td>
            </tr>
            <tr>
                <td><?php datebox2('pay_date'); ?> </td>
                <td>
                    <table><?php cmdPayType('pay_type', '', $site_url); ?></table>
                </td>
                <td><?php textbox2('check_no', 100, 200); ?> </td>
                <td><?php datebox2('check_date'); ?> </td>
                <td><?php datebox2('due_date'); ?> </td>
                <td><?php numberbox2('pay_val', 90, 100); ?> </td>
                <td><?php numberbox2('disc_val', 90, 100); ?> </td>
                <td><?php textbox2('pay_desc', 150, 200); ?> </td>               
                <td><table><?php cmdCollector('coll_code', '', $site_url, 100); ?></table></td>
            </tr>
        </table>



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
                            </td>
                            <td  style="border-top:0px !important;">

                                <button id="ok2" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#BayarWindow').window('close');"></button>

                            </td>

                        </tr>
                    </table>  </td>       
            </tr>
        </table>

    </form>
</div>
<div id="SearchOption" style="display:none;">  
    <form id="form_validation5" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="code" name="code">
            <!--<span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <input class="easyui-datebox" validType='validDate' data-options="required:false" id="arg_date2"  name="arg_date2" style="width:90;" disabled=false></input>
            -->
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();" data-options="iconCls:'icon-no'">Cancel</button>

        </div>
        <br />

    </form>
</div>

<?php include 'hutangacc_fn.php'; ?>

