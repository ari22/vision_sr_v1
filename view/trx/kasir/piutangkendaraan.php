<?php $session = $_SESSION; ?>
<div style="margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <td valign="top" width="350">
                        <table>
                            <?php
                            textbox('sal_inv_no', 'No. Faktur', 150, 12);
                            datebox('sal_date', 'Tgl. Faktur', 200);
                            datebox('opn_date', 'Tgl. Buat', 200);
                            datebox('due_date', 'Tgl J. Tempo', 200);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('so_no', 'No. SPK', 150, 12);
                            textbox('srep_name', 'Sales Representative', 200, 25);
                            textbox('wrhs_code', 'Warehouse', 90, 12);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <td valign="top" class="checkboxValign"><?php getCaption("Transaksi"); ?> </td>
                            <td valign="top" class="checkboxValign td-ro">:</td>
                            <td>                             
                                <table width="90" class="checkboxBorder">
                                    <tr><td><a href="#" class="checkbox salpaytype" name="salpaytype_1"><input type="radio" id="salpaytype_1" class="salpaytype_1 salpaytype" name="salpaytype" value="1"> <span>Cash</span></a></td></tr>

                                    <tr><td><a href="#" class="checkbox salpaytype" name="salpaytype_2"><input type="radio" id="salpaytype_2" class="salpaytype_2 salpaytype" name="salpaytype" value="2"> <span>Credit</span></a></td></tr>
                                </table>
                            </td>
                            <!--<tr>
                                <td valign="top"><?php getCaption("Transaksi"); ?></td>
                                <td valign="top" class="td-ro">:</td>
                                <td><a href="#" class="checkbox" name="salpaytype_1"> <input type="radio" id="salpaytype_1" class="salpaytype_1" name="salpaytype" value="1" disabled="true"> Cash</a> 
                                    <a href="#" class="checkbox" name="salpaytype_2"><input type="radio" id="salpaytype_2" class="salpaytype_2" name="salpaytype" value="2" disabled="true"> Credit</a> </td>
                            </tr>-->
                             
                             <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top"  width="500">
                        <table class="marginmin">
                            <tr>
                                <td colspan="2">
                                    <table class="marginmin">
                                        <?php
                                        textboxset('cust_code', 'cust_name', 'Pelanggan', 90, 256);
                                        textboxset('lease_code', 'lease_name', 'Leasing', 90, 256);
                                        textboxset('veh_code', 'veh_name', 'Kendaraan', 90, 256);
                                        textboxset('color_code', 'color_name', 'Warna', 90, 256);
                                        ?>
                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td><br /></td></tr>
                            <tr>
                                <td valign="top">
                                    <table class="marginmin">
                                        <?php
                                        textbox('chassis', 'Chassis', 150, 17);
                                        textbox('engine', 'Engine', 150, 17);
                                        ?>
                                        <tr><td colspan="3"></td></tr>
                                        <tr><td colspan="3"></td></tr>

                                        <tr><td class="col100"></td></tr>
                                    </table>
                                </td>

                                <td valign="top">
                                    <table class="marginmin">
                                        <?php
                                        textbox('veh_type', 'Tipe', 150, 15);
                                        textbox('veh_model', 'Model', 150, 15);
                                        ?>
                                    </table>
                                </td>
                            </tr>

                        </table>                        

                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            textbox('veh_transm', 'Transmisi', 150, 2);
                            textbox('veh_year', 'Tahun', 50, 4);
                            textbox('veh_brand', 'Merek', 50, 15);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                             <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"><br /></td></tr>
                            <tr><td colspan="3"><br /></td></tr>
                            <?php
                            datebox('cls_date', 'Tgl Closed ');
                            ?>
                        </table>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <?php
                            textbox('note', 'Catatan', 350, 12);
                            ?>
                             <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="single-form">
            <table id="dt_ard" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>

            <table style="margin-top:10px;">
                <tr>
                    <td>
                        <table>
                            <?php
                            numberbox('veh_price', 'Harga Kendaraan', 120, 12);
                            numberbox('srv_at', 'Optional', 120, 12);
                            numberbox('part_at', 'Aksesoris', 120, 12);
                            numberbox('inv_stamp', 'Lain - Lain', 120, 12);
                            ?>
                            <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('inv_total', 'Grand Total', 120, 12);
                            ?>
                        </table>
                    </td>
                    <td width="100"></td>
                    <td>
                        <table style="margin-top:-30px;">
                            <?php
                            numberbox('pd_begin', 'Piutang Awal', 120, 12);
                            numberbox('pd_paid', 'Pembayaran', 120, 12);
                            numberbox('pd_disc', 'Discount', 120, 12);
                            ?>
                            <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('pd_end', 'Piutang Akhir', 120, 12);
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
                    <td width="200">
                        <table border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="search2" title="<?php getCaption("Search"); ?>" class="search2 easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="condSearch2();" >Search2</button>
                                    <button type="button" id="bayar" title="<?php getCaption("Bayar"); ?>" class="bayar easyui-linkbutton"  onclick="bayarPiutang();" data-options="iconCls:'icon-payment'">Bayar</button>
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

<div id="BayarWindow" class="easyui-window" title="Vehicle Account Receivable Payment"  data-options="modal:true,closed:true,resizable:false,maximizable:true,minimizable:false,collapsible:false" 
     style="width:1025px;height:450px;padding:10px;top:1;">
    <table id="dt_ard2" class="easyui-datagrid"  title="" style="width:990px;height:200px;"></table>
    <br /><br />
    <form id="form_validation3" method="post" >
        <div id="tableId2"></div>

        <table>
            <tr>
                <td><?php getCaption("Dibayar Oleh"); ?></td>
                <td><?php getCaption("Alamat"); ?></td>
                <td><?php getCaption("Wilayah"); ?></td>
                <td><?php getCaption("Kota"); ?></td>
                <td><?php getCaption("Kode Pos"); ?></td>
            </tr>
            <tr>
                <td width="200"><input type="text" class="textbox" id="payer_name" name="payer_name" disabled="true" style="width: 215px;" ></input></td>
                <td width="300"><input type="text" class="textbox" id="payer_addr" name="payer_addr" disabled="true" style="width: 350px;" ></input></td>
                <td><input type="text" class="textbox" id="payer_area" name="payer_area" disabled="true" style="width: 150px;"></input></td>
                <td><input type="text" class="textbox" id="payer_city" name="payer_city" disabled="true" style="width: 150px;"></input></td>
                <td><input type="text" class="textbox" id="payer_zipc" name="payer_zipc" disabled="true" style="width: 100px;"></input></td>
            </tr>
        </table>


        <table>
            <tr>
                <td><?php getCaption("Tgl. Bayar"); ?></td>
                <td><?php getCaption("Jenis Bayar"); ?></td>
                <td><?php getCaption("Bank"); ?></td>
                <td><?php getCaption("No. Check"); ?></td>
                <td><?php getCaption("Tanggal Check"); ?></td>
                <td><?php getCaption("Tgl J. Tempo"); ?></td>
                <td><?php getCaption("Pembayaran"); ?></td>
                <td><?php getCaption("Diskon"); ?></td>
                <td><?php getCaption("Keterangan"); ?></td>
            </tr>
            <tr>
                <td><?php datebox2('pay_date'); ?> </td>
                <td>
                    <select class="easyui-combobox" id="pay_type" name="pay_type" style="width: 100px;" disabled="true"><option value=""></option><option value="TRANS">TRANS</option><option value="CASH">CASH</select>
                </td>
                <td><?php textbox2('bank_code', 90, 200); ?> </td>
                <td><?php textbox2('check_no', 120, 200); ?> </td>
                <td><?php datebox2('check_date'); ?> </td>
                <td><?php datebox2('due_date'); ?> </td>
                <td><?php numberbox2('pay_val', 90, 100); ?> </td>
                <td><?php numberbox2('disc_val', 90, 100); ?> </td>
                <td><?php textbox2('pay_desc', 190, 200); ?> </td>
            </tr>

            <tr>
                <td colspan="8"></td><td align="right"><?php echo getCaption('Kolektor'); ?></td>
            </tr>
            <tr>
                <td colspan="8">

                    <table class="table" style="width:520px;" border="0">
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
                                <button type="button" id="prepaid" title="<?php getCaption("prepaid"); ?>" class="easyui-linkbutton" onclick="prepaids();" data-options="iconCls:'icon-payment'" >Prepaid</button>
                                <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('invoice');" >Print</button>
                                <button id="ok" type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#BayarWindow').window('close');"> Ok</button>

                            </td>

                        </tr>
                    </table>  

                </td>
                <td align="right"><?php textbox2('coll_code', 60, 200); ?></td>
            </tr>

        </table>

    </form>
</div>

<div id="UJWindow" class="easyui-window" title="Booking Fee" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:724px;height:320px;padding:10px;top:1;">
    <table id="dt_uj" class="easyui-datagrid"  title="" style="width:690px;height:200px;"></table>
    <br />
    <div class="main-nav">
        <table width="100%">
            <tr>
                <td align="right">
                    <button type="button" id="getUJ" title="<?php getCaption("Get Uang Jaminan"); ?>" class="easyui-linkbutton" onclick="getUJaminan();" data-options="iconCls:'icon-ok'" style="width:70px;" >Get</button>
                    <button id="ok" type="button" class="easyui-linkbutton" onclick="$('#UJWindow').window('close');" data-options="iconCls:'icon-no'" style="width:70px;">Cancel</button>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="PrintsWindow" class="easyui-window" title="Print Vehicle Invoice" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:450px;height:250px;padding:10px;top:1;">
    <form id="form_validation4" method="post" style="text-align:center;padding:10px;">
        <table>
            <tr>
                <td style="width: 10%;"></td>
                <td style="width:80%;">
                    <table>
                        <?php
                        textbox('no_kwitansi', 'No. Kwitansi', 150, 150);
                        datebox('tgl_kwintansi', 'Tgl. Kwitansi');
                        ?>


                        <tr>
                            <td>Signature</td>
                            <td class="td-ro">:</td>
                            <td><input type="text" class="textbox" id="signature" name="signature" value="<?php echo $session['C_USER']; ?>"></input></td>
                        </tr>
                        <tr>
                            <td><?php getCaption('Jabatan'); ?></td>
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
                <td style="width:10%;"></td>
            </tr>
        </table>
    </form>
</div>

<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

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

<div id="SearchOption2" style="display:none;">  
    <form id="form_validation4" method="post" >    
        <div style="padding:10px;">
            <span><?php getCaption("No. Faktur"); ?>:</span>
            <input id="code" name="code">
            <!--<span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <input class="easyui-datebox" validType='validDate' data-options="required:false" id="arg_date2"  name="arg_date2" style="width:90;" disabled=false></input>
            -->
            <a href="#" class="easyui-linkbutton" onclick="doSearch2()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();" data-options="iconCls:'icon-no'">Cancel</button>

        </div>
        <br />

    </form>
</div>

<?php include 'piutangkendaraan_fn.php'; ?>

