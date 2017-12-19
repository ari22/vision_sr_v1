<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <td  valign="top">
                    <table>
                        <?php
                        textbox('sal_inv_no', 'No. Faktur', 150, 20);
                        datebox('sal_date', 'Tgl. Faktur', 200);
                        datebox('opn_date', 'Tgl. Buat', 200);
                        datebox('due_date', 'Tgl J. Tempo', 200);
                        ?>
                    </table>
                </td>
                <td valign="top">
                    <table style="margin-left: 75px;">
                        <?php
                        textboxset('cust_code', 'cust_name', 'Pelanggan', 100, 250);
                        textboxset('srep_code', 'srep_name', 'Sales', 100, 250);
                        ?>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <?php
                        textbox('note', 'Keterangan', 355, 20);
                        ?>
                    </table>
                </td>
            </table>
        </div>

        <div class="single-form">
            <table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:250px;"></table>
            <br />
            <table width="100%">
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td><?php getCaption("Chassis"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
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
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php textbox2('engine', 150, 12); ?></td>
                                            <td width="60"><?php getCaption("Tipe"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_type', 100, 50); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Transmisi"); ?></td>
                                <td class="td-ro">:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td width="150"><?php textbox2('veh_transm', 80, 12); ?></td>
                                            <td width="60"><?php getCaption("Tahun"); ?></td>
                                            <td class="td-ro">:</td>
                                            <td><?php textbox2('veh_year', 50, 12); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('veh_name', 'Kendaraan', 326, 15); ?>
                            <?php textbox('color_name', 'Warna', 326, 15); ?>
                            <tr><td colspan="3"></td></tr>

                        </table>
                    </td>
                    <td valign="top">
                        <table style="margin-left: 70px;" >

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
                        <table class="table" >

                            <?php
                            numberbox('pd_begin', 'Hutang Awal', 200, 70);
                            numberbox('pd_paid', 'Pembayaran', 200, 70);

                            numberbox('pd_disc', 'Discount', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('pd_end', 'Hutang Akhir', 200, 70);
                            ?>
                        </table>
                    </td>
                </tr>

            </table>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"> <?php navigation_ci(); ?></td>
                    <td align=left width="100px">
                        <button type="button" id="bayar" title="<?php getCaption("Bayar"); ?>" data-options="iconCls:'icon-payment'" class="bayar easyui-linkbutton"  onclick="bayarPiutang();" >Bayar</button>
                    </td>
                    <td align="right" ><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>
        </div>
    </form>
</div>

<div id="BayarWindow" class="easyui-window" title="Accessories Receivable Payment"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1040px;height:500px;padding:10px;top:1;">
    <table id="dt2" class="easyui-datagrid"  title="" style="width:1005px;height:200px;"></table>
    <br />
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
    <br /><br /><br />
    <form id="form_validation3" method="post" >
        <div id="tableId2"></div>

        <table>
            <tr>
                <td colspan="3"><?php getCaption("Dibayar Oleh"); ?></td>
                <td colspan="3"><?php getCaption("Alamat"); ?></td>
                <td colspan="2"><?php getCaption("Wilayah"); ?></td>
                <td><?php getCaption("Kota"); ?></td>
                <td><?php getCaption("Kode Pos"); ?></td>
            </tr>
            <tr>
                <td colspan="3"><?php textbox2('payer_name', 305, 200); ?></td>
                <td colspan="3"><?php textbox2('payer_addr', 290, 200); ?></td>
                <td colspan="2"><?php textbox2('payer_area', 180, 200); ?></td>
                <td><?php textbox2('payer_city', 100, 200); ?></td>
                <td><?php textbox2('payer_zipc', 100, 200); ?></td>                
            </tr>

            <tr>
                <td><?php getCaption("Tgl. Bayar"); ?></td>
                <td><?php getCaption("Jenis Bayar"); ?></td>
                <td><?php getCaption("Bank"); ?></td>
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
                <td><table><?php cmdPayType('pay_type', '', $site_url, 100); ?></table></td>
                <td> <table><?php cmdBank('bank_code', '', $site_url, 100); ?></table></td>
                <td><?php textbox2('check_no', 100, 200); ?> </td>
                <td><?php datebox2('check_date'); ?> </td>
                <td><?php datebox2('due_date'); ?> </td>
                <td><?php numberbox2('pay_val', 90, 100); ?> </td>
                <td><?php numberbox2('disc_val', 90, 100); ?> </td>
                <td><?php textbox2('pay_desc', 100, 200); ?> </td>
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
                                <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('invoice');" >Print</button>
                                <button id="ok2" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#BayarWindow').window('close');"></button>

                            </td>

                        </tr>
                    </table>  </td>       
            </tr>
        </table>

    </form>
</div>
<div id="PrintsWindow" class="easyui-window" title="Print Kwitansi Accesories" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:450px;height:250px;padding:10px;top:1;">
    <form id="form_validation4" method="post" style="text-align:center;padding:10px;">
        <table>
            <tr>
                <td style="width: 15%;"></td>
                <td style="width:70%;">
                    <table>
                        <tr>
                            <td>Invoice No.</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="no_kwitansi" name="no_kwitansi" disabled="true"></input></td>
                        </tr>
                        <tr>
                            <td>Invoice Date</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="tgl_kwintansi" name="tgl_kwintansi" disabled="true" value="<?php echo date('Y-m-d'); ?>"></input></td>
                        </tr>
                        <tr>
                            <td>Signature</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="signature" name="signature" value="<?php echo $session['C_USER']; ?>"></input></td>
                        </tr>
                        <tr>
                            <td>Job Position</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="jabatan" name="jabatan"  style="text-transform: uppercase;" value="KEPALA CABANG"></input></td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr><td colspan="3"></td></tr>
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <button type="button" title="<?php getCaption("Screen"); ?>" data-options="iconCls:'icon-screen'" class="easyui-linkbutton" onclick="rolesPrintScreen('screen');" >Screen</button>
                                <button type="button" title="<?php getCaption("Print"); ?>" data-options="iconCls:'icon-print'" class="easyui-linkbutton" onclick="rolesPrintScreen('print');" >Print</button>
                                <button id="ok" type="button" class="easyui-linkbutton" onclick="$('#PrintsWindow').window('close');" data-options="iconCls:'icon-no'">Cancel</button>
                            </td>
                        </tr>        
                    </table>
                </td>
                <td style="width:15%;"></td>
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
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>


<?php include 'piutangacc_fn.php'; ?>
