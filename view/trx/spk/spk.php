<div style=" margin: 10px;" id="form_content">
    <input type="hidden" name="notif" id="notif">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>

        <table class="main-form">
            <td style="width: 300px;" valign="top">
                <table>
                    <?php
                    textbox('so_no', 'No. SPK', 130, 12);
                    datebox('so_date', 'Tanggal SPK');
                    datebox('soseq_date', 'Tanggal Urut SPK');
                    cmdSoSrc('sosrc_name', 'Sumber SPK');

                    textbox('dp_inv_no', 'No. U. Jaminan', 130, 12);
                    datebox('dp_date', 'Tanggal U. Jaminan');
                    ?>
                    <td class="col100"></td>
                </table>
            </td>
            <td style="width: 470px;" valign="top">
                <table>
                    <?php
                    cmdCustSet('cust_code', 'cust_name', 'Pelanggan');
                    //textboxSet('srep_code', 'srep_name', 'Nama Sales', 80, 200);
                    cmdSalSet('srep_code', 'srep_name', 'Sales');
                    textbox('srep_lev', 'Sales Level', 80, 17);
                    textboxset('sspv_code', 'sspv_name', 'Supervisor', 80, 200);
                    textbox('sspv_lev', 'Supervisor Level', 80, 17);
                    //cmdWrhs('wrhs_code', 'Warehouse');
                    ?>
                </table>
            </td>
            <td valign="top">
                <table>
                    <?php
                    textbox('wrhs_code', 'Warehouse', 90, 17);
                    textbox('pur_inv_no', 'Matched Stock', 90, 12);
                    datebox('match_date', 'Tanggal Match');

                    textbox('cls_by', 'Closed By', 90, 35);
                    datebox('cls_date', 'Tgl Closed');
                    ?>
                </table>
            </td>

        </table>


        <div class="easyui-tabs" id="tabscoi" >
            <div title="<?php getCaption("Kendaraan"); ?>" class="main-tab">
                <table style="width:900px;">
                    <tr>
                        <td valign="top">
                            <table>
                                <?php
                                cmdVehSet('veh_code', 'veh_name', 'Kendaraan', 80, 250); //n
                                textbox('chassis', 'Chassis', 150, 17);
                                textbox('engine', 'Engine', 150, 15);
                                textbox('veh_type', 'Tipe', 150, 10);
                                textbox('veh_model', 'Model', 150, 20);

                                cmdColSet('color_code', 'color_name', 'Warna', 80, 250); //n
                                ?>
                                <tr><td class="col100"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>

                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('veh_brand', 'Merek', 200, 15);
                                textbox('veh_transm', 'Transmisi', 40, 2);
                                textbox('veh_year', 'Tahun', 40, 4);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php textbox('color_type', 'Tipe', 40, 10); ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" colspan="2">
                            <table>
                                <tr><td class="col100"></td></tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td class="right"><?php getCaption("Qty"); ?></td>
                                                            <td><?php getCaption("Satuan"); ?></td>
                                                            <td class="right"><?php getCaption("Harga Satuan"); ?></td>
                                                            <td class="right"><?php getCaption("Diskon"); ?></td>
                                                            <td class="right"><?php getCaption("Harga Kendaraan"); ?></td>

                                                        </tr>
                                                        <tr>
                                                            <td><input type="text" name="qty" id="qty" class="disabled" disabled="true" style="width: 40px; text-align: right;"></td>
                                                            <td><?php textbox2('unit', 70, 100); ?></td>

                                                            <td><?php numberbox2('unit_price', 95, 200); ?></td>
                                                            <td><?php numberbox2('unit_disc', 95, 200); ?></td>
                                                            <td><?php numberbox2('tot_price', 95, 200); ?></td>


                                                        </tr>
                                                    </table>
                                                </td>

                                                <td>
                                                    <table>
                                                        <tr><td><?php getCaption("Perkiraan Stok"); ?></td></tr>
                                                        <tr><td><?php datebox2('pred_stk_d', 100); ?></td>  </tr>
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
            <div title="<?php getCaption("Pelanggan"); ?>" class="main-tab">
                <table class="table" style="width:800px;" >
                    <td valign="top">
                        <table>
                            <?php
                            textarea('cust_addr', 'Alamat', 200);
                            cmdArea('cust_area', 'Wilayah');
                            cmdCity('cust_city', 'Kota');
                            cmdCountry('cust_cntry', 'Negara');
                            textbox('cust_zipc', 'Kode Pos', 80, 5);
                            phonebox('cust_phone', 'Telepon', 200);
                            ?>
                             <tr><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><td></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table width="100" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="cust_sex_1"><input type="radio" id="cust_sex_1" class="cust_sex_1"  name="cust_sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_2"><input type="radio" id="cust_sex_2" class="cust_sex_2" name="cust_sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_3"><input type="radio" id="cust_sex_3" class="cust_sex_3" name="cust_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table  style="margin-left:30px;" class="table">
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Pelanggan"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table width="170" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="cust_type_1"><input type="radio" id="cust_type_1" class="cust_type_1" name="cust_type" value="1"> End User</a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_2"><input type="radio" id="cust_type_2" class="cust_type_2" name="cust_type" value="2"> Dealer/Reseller</a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_3"><input type="radio" id="cust_type_3" class="cust_type_3" name="cust_type" value="3"> Government/BUMN</a></td></tr>
                                    </table>
                                </td>
                            </tr>
                           
                            <tr><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><td></td></tr>
                            <?php
                            phonebox('cust_fax', 'Fax', 170);
                            phonebox('cust_hp', 'HP Pribadi', 170);
                            ?>
                            <tr><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><td></td></tr>
                            <?php
                            textbox('cust_npwp', 'NPWP', 170, 20);
                            textbox('cust_nppkp', 'NPPKP', 170, 20);
                            ?>
                            <tr><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><td></td></tr>
                             <?php
                            textbox('cust_ktpno', 'No KTP', 150, 35);
                            ?>	

                        </table>
                    </td>
                </table>
            </div>
            <div title="<?php getCaption("Data Di STNK"); ?>" class="main-tab">
                <table style="width:800px;" >
                    <td valign="top">
                        <table >
                            <?php
                            textbox('cust_rname', 'Nama', 200, 40);
                            textarea('cust_raddr', 'Alamat', 200);
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota');
                            textbox('cust_rzipc', 'Kode Pos', 80, 5);
                            cmdCountry('cust_rcntr', 'Negara');
                            ?>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr style="margin-bottom: 20px !important;">
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table width="100" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_1"><input type="radio" id="cust_rsex_1" class="cust_rsex_1"  name="cust_rsex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_2"><input type="radio" id="cust_rsex_2" class="cust_rsex_2" name="cust_rsex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_3"><input type="radio" id="cust_rsex_3" class="cust_rsex_3" name="cust_rsex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td><td></td><td></td></tr>
                            <tr><td></td><td></td><td></td></tr>
                            <?php
                            phonebox('cust_rphon', 'HP Pribadi', 150);
                            ?>
                             <?php
                            textbox('cust_rktpno', 'No KTP', 150, 35);
                            ?>	
                        </table>
                    </td>
                </table>
            </div>
            <div title="<?php getCaption("Perlengkapan Tambahan"); ?>" class="main-tab">
                <table style="width:800px;" >
                    <tr><td colspan="2"><b><?php getCaption("Perlengkapan Tambahan"); ?></b></td></tr>
                    <tr>
                        <td valign="top">
                            <table >
                                <?php
                                textbox('add_item1', '1', 200, 20);
                                textbox('add_item2', '2', 200, 20);
                                textbox('add_item3', '3', 200, 20);
                                textbox('add_item4', '4', 200, 20);
                                ?>
                            </table>
                        </td>
                        <td valign="top">
                            <table >
                                <?php
                                textbox('add_item5', '5', 200, 20);
                                textbox('add_item6', '6', 200, 20);
                                textbox('add_item7', '7', 200, 20);
                                textbox('add_item8', '8', 200, 20);
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="<?php getCaption("Optional"); ?>" class="main-tab">
                <table id="dt_jasa" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
                <table style="float:right;margin-top: 10px;">
                    <td style="padding:0px 10px;">
                        <table style="margin:0px 0px 10px 0px;">
                            <?php
                            numberbox('srv_price', 'Total Harga Netto', 200, 70);
                            numberbox('srv_disc', 'Diskon', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('srv_bt', 'DPP', 200, 70);
                            numberbox('srv_vat', 'PPN', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('srv_at', 'Total Jasa', 200, 70);
                            ?>
                        </table>
                    </td>
                </table>
            </div>
            <div title="<?php getCaption("Leasing"); ?>" class="main-tab">
                <table style="width:800px;" >
                    <td valign="top">
                        <table>
                            <?php
                            textbox('crd_via', 'Kredit Via', 200, 40);
                            cmdLeaseSet('lease_code', 'lease_name', 'Leasing');
                            ?>
                            <tr>
                                <td><?php getCaption("Lama Kredit"); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php numberbox2('crd_term', 50, 50); ?> <?php getCaption("Bulan"); ?></td>
                            </tr>
                            <tr>
                                <td><?php getCaption("Bunga"); ?></td>
                                <td class="td-ro">:</td>
                                <td><input id="crd_irate" name="crd_irate" class="easyui-numberbox" label="<?php getCaption("Bunga"); ?>" labelPosition="top" precision="2" style="width:50px;"><?php //numberbox2('crd_irate', 50, 50); ?> %</td>
                            </tr>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>

                            <?php
                            textarea('lease_addr', 'Alamat', 200);
//textbox('lease_city', 'Kota', 200, 20);
                            cmdCity('lease_city', 'Kota');
                            textbox('lease_zipc', 'Kode Pos', 80, 5);
                            textbox('lcp1_name', 'Hubungi', 200, 40);
                            textbox('lcp1_title', 'Jabatan', 200, 40);
                            ?>
                        </table>
                    </td>
                </table>
            </div>
            <div title="<?php getCaption("Pembayaran & Lain-lain"); ?>" class="main-tab">
                <table style="width:800px;" >

                    <td valign="top">
                        <table>
                            <?php numberbox('unit_price2', 'Harga Kendaraan', 200, 20); ?>

                            <tr><td></td><td></td><td></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Harga"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table width="120" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="prc_type_1"><input type="radio" id="prc_type_1" class="prc_type_1" name="prc_type" value="1"> ON the road</a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="prc_type_2"><input type="radio" id="prc_type_2" class="prc_type_2" name="prc_type" value="2"> OFF the road</a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td><td></td></tr>
                            <tr><td></td><td></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Transaksi"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table width="80" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="salpaytype_1"> <input type="radio" id="salpaytype_1" class="salpaytype_1" name="salpaytype" value="1"> Cash</a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="salpaytype_2"><input type="radio" id="salpaytype_2" class="salpaytype_2" name="salpaytype" value="2"> Credit</a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td><td></td><td></td></tr>
                            <?php
                            numberbox('pay_val', 'Uang Muka', 150, 20);
                            datebox('pay_date', 'Tanggal Bayar', 200);
                            cmdPayType('pay_type', 'Jenis Pembayaran', $site_url);
                            ?>
                            <tr><td class="col100"></td></tr>
                            <?php
                            textbox('check_no', 'No. Check', 70, 10);
                            datebox('check_date', 'Tanggal Check', 200);
                            datebox('due_date', 'Tgl J. Tempo');
                            ?>

                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            numberbox('comm_val', 'Jumlah Komisi', 100, 12);
                            textbox('medtr_name', 'Nama Penerima', 200, 40);
                            textbox('medtr_addr', 'Alamat Penerima', 200, 40);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('so_made_by', 'Pembuat ', 100, 15);
                            textbox('so_appr_by', 'Disetujui', 100, 15);
                            textbox('so_desc', 'Keterangan', 200, 40);
                            ?>
                        </table>
                    </td>
                </table>
            </div>


        </div>

        <div class="main-nav">
            <table class="table">
                <tr>
                    <td style="width: 400px !important;"> <?php navigation_ci(); ?></td>
                    <td>
                        <table class="table" style="width:500px;" border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <!--<a id="searchSPK" data-options="iconCls:'icon-search'" class="easyui-linkbutton easyui-tooltip btn btn-default" href="javascript:void(0)" onclick="search_spk();" >Search</a>-->
                                    <button type="button" id="cmdOptional" class="easyui-linkbutton btn btn-default"  onclick="cmdOptionals()" data-options="iconCls:'icon-optional'" disabled="true">Optional</button>
                                    <span id="closeOn"></span>
                                    <!--<button type="button" id="screen" class="btn btn-default" data-options="iconCls:'icon-no'" onclick="screenspk();" disabled="true" >Screen</button>-->
                                    <button type="button" id="screen" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('download');" disabled="true" >Print</button>
                                    <!--<a id="ok"  class="btn btn-default" href="javascript:void(0)" onclick="window_close()" >Ok</a>-->
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
<div id="w" class="easyui-window" title="<?php getCaption("Isi Perincian Pekerjaan/Jasa"); ?>" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:950px;height:480px;padding:10px;top:1;">
    <table id="dt_jasa2" class="easyui-datagrid"  title="" style="width:900px;height:250px;"></table>
    <br />
    <form id="form_validation2" method="post" >
        <div id="tableId2"></div>

        <table class="table" style="width:100%;">
            <tr>
                <td>
                    <table class="table">
                        <tr>
                            <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                            <td><b><?php getCaption("Nama Pekerjaan"); ?></b></td>
                            <td class="right"><b><?php getCaption("Harga Jual"); ?></b></td>
                            <td class="right"><b><?php getCaption("Diskon"); ?> (%)</b></td>
                            <td class="right"><b><?php getCaption("Jumlah Diskon"); ?></b></td>
                            <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                        </tr>
                        <tr>
                            <td><?php acc_wkcd('wk_code', 'Kode', $site_url); ?></td>
                            <td><?php textbox2('wk_desc2', 240, 17); ?></td>
                            <td><?php numberbox2('sal_price2', 100, 17); ?></td>
                            <td><?php numberbox2('disc_pct2', 100, 17, 0); ?></td>
                           <!-- <td> <input class="easyui-validatebox textbox"  type="text" id="disc_pct2" autocomplete="off" name="disc_pct2" style="width:90px;text-align: right;" maxlength="17" disabled="true"></td>
                            -->
                            <td><?php numberbox2('disc_val2', 100, 17, 0); ?></td>
                            <td><?php numberbox2('price_ad2', 100, 17); ?></td>
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
                                <button type="button" id="cmdSave2" title="Save" data-options="iconCls:'icon-save',group:'g2'" class="easyui-linkbutton"   onclick="rolesSave2()" disabled="true" ></button>
                                <button type="button" id="cmdCancel2" title="Batal" data-options="iconCls:'icon-undo',group:'g2'" class="easyui-linkbutton "   onclick="condCancel2()" disabled="true" ></button>
                            </td>
                            <td  style="border-top:0px !important;">
                                <button type="button" id="cmdAdd2" title="<?php getCaption("Tambah"); ?>"  class="easyui-linkbutton" data-options="iconCls:'icon-add'"  onclick="rolesAdd2()" disabled="true"></button>
                                <!--<button type="button" id="cmdEdit2" title="<?php getCaption("Ubah"); ?>" class="easyui-linkbutton easyui-tooltip glyphicon glyphicon-pencil btn btn-default" data-options="iconCls:'icon-edit'"  onclick="condEdit2()" disabled="true"></button>-->
                                <button type="button" id="cmdDelete2" title="<?php getCaption("Hapus"); ?>" class="easyui-linkbutton " data-options="iconCls:'icon-no'" onclick="rolesDel2()" disabled="true" > </button>
                                <button type="button" id="ok2" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#w').window('close');"></button>
                            </td>

                        </tr>
                    </table>  </td>
            </tr>
        </table>
    </form>
</div>
<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<div id="spkWindow" class="easyui-window" title="SPK List" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:900px;height:500px;padding:10px;top:1;">
    <div style="float:left;">

        <form id="form" action="post">
            <table>
                <tr>
                    <td><b>View</b></td>
                    <td>
                        <select  id="viewShow" name="viewShow" style="width:120px;height: 25px;" onchange="viewShowAction()">
                            <option value="all">ALL</option>
                            <option value="so_no">Registered SPK</option>
                            <option value="so_regdate">Registration Date</option>
                            <option value="srep_code">Distributed To</option>
                        </select>
                    </td>
                    <td id="TDkeyword">
                        <table>
                            <tr>
                                <td>Contain</td>
                                <td>
                                    <input class="easyui-textbox" name="keyword" id="keyword" style="width:100px;height: 25px;">
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td id="TDDate">
                        <table>
                            <tr>
                                <td>
                                    <table>
                                        <tr>
                                            <td>From</td>
                                            <td><?php datebox2('from'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table>
                                        <tr>
                                            <td>To</td>
                                            <td><?php datebox2('to'); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td id="TDsales">
                        <table>
                            <?php cmdSalSet('srep_code', 'srep_name', 'Sales') ?>
                        </table>
                    </td>

                    <td id="TDbuttonKeyword">
                        <button class="easyui-linkbutton" data-options="iconCls:'icon-search'"  onclick="keywordSearch()"></button>
                    </td>

                    <td id="TDbuttonDate">
                        <button class="easyui-linkbutton" data-options="iconCls:'icon-search'"  onclick="dateSearch()"></button>
                    </td>

                    <td id="TDbuttonSales">
                        <button class="easyui-linkbutton" data-options="iconCls:'icon-search'"  onclick="salesSearch()"></button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <table class="table">
        <tr><td><table id="tb_spk" class="easyui-datagrid"  title="" style="width:860px;height:340px;"></table></td></tr>
        <tr><td></td></tr><tr><td> <button type="button" id="GetSpk" title="Get Spk" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="get_spk()">Get</button>&nbsp; &nbsp;<button type="button" title="Cancel" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="cancel_get_spk()">Cancel</button></td></tr>
    </table>
</div>
<div id="SearchOption" style="display:none;">
    <form id="form_validation2" method="post" >
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. SPK"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Nama Pelanggan"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<style>
    .labels{min-width: 20px !important;}
</style>

<?php include 'spk_fn.php'; ?>