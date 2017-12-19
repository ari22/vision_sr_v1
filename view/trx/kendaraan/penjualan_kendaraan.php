<?php $session = $_SESSION; ?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td width="300" valign="top">
                    <table>
                        <tr>
                            <td><?php getCaption("Jenis Faktur"); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <input type="hidden" name="sinv_code" id="sinv_code" disabled="disabled" value="Kendaraan Showroom">
                                <input type="text" id="sinv_code_copy" disabled="disabled" value="Kendaraan Showroom">
                            </td>
                        </tr>
                        <?php
                        textbox('sal_inv_no', 'No. Faktur', 90, 70);
                        datebox('sal_date', 'Tgl. Faktur', 200);
                        ?>
                        <tr><td class="col0"></td></tr>
                    </table>
                </td>
                <td  valign="top"> 
                    <table>
                        <?php
                        cmdWrhs('wrhs_code', 'Warehouse');
                        cmdLoc('loc_code', 'Location');
                        cmdSoSrc('sosrc_name', 'Sumber SPK');
                        ?>
                        <tr><td class="col100"></td></tr>
                    </table>
                </td>
                <td  valign="top">
                    <table>
                        <?php
                        datebox('cls_date', 'Tgl Closed', 200);
                        textbox('cls_by', 'Closed By', 90, 70);
                        textbox('note', 'Keterangan', 250, 70);
                        ?>
                        <tr><td class="col100"></td></tr>
                    </table>
                </td>
            </tr>
        </table>


        <div class="easyui-tabs" id="tabscoi" >
            <!-- Nav tabs -->

            <div title="<?php getCaption("Kendaraan"); ?>" class="main-tab">
                <table>
                    <tr>
                        <td valign="top" width="300">
                            <table>

                                <tr><td>&nbsp;</td><td class="td-ro"></td><td><span><?php getCaption("Tgl. Pick"); ?></span></td></tr>
                                <tr>
                                    <td><a href="#" id="cmdPick"  class="easyui-linkbutton btn-pick" style="width:60px;" disabled="true" onclick="cmdPick()">Pick</a></td>
                                    <td class="td-ro"></td>
                                    <td><?php datebox2('pick_date'); ?></td>
                                </tr>
                                <tr><td><a href="#" type="button" id="cmdDropPick"  class="easyui-linkbutton btn-pick" style="width: 60px;"  disabled="true" onclick="cmdDropPick()">Drop</a></td></tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td></td>
                                    <td class="td-ro"></td>
                                    <td width="100"><?php getCaption("Kode"); ?></td>
                                    <td width="220"><?php getCaption("Nama"); ?></td>
                                </tr>
                                <tr>
                                    <td class="labels"><?php getCaption("Kendaraan"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td width="100"><?php textbox2('veh_code', 100, 250); ?></td>
                                    <td width="220"><?php textbox2('veh_name', 272, 350); ?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Chassis"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" style='padding:0px !important'>
                                        <table class='marginmin'>
                                            <tr>                                               
                                                <td><?php textbox2('chassis', 150, 250); ?></td>
                                                <td class='col50'><?php getCaption("Tipe"); ?></td>
                                                <td class='td-ro'>:</td>
                                                <td><?php textbox2('veh_type', 160, 250); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td ><?php getCaption("Engine"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4">
                                        <table class='marginmin'>
                                            <tr>
                                                <td><?php textbox2('engine', 150, 250); ?></td>
                                                <td class='col50'><?php getCaption("Model"); ?></td>
                                                <td class='td-ro'>:</td>
                                                <td><?php textbox2('veh_model', 160, 250); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table style='margin-left: 20px;'>
                                <tr>
                                    <td></td><td class="td-ro"></td><td>&nbsp;</td>
                                </tr>
                                <?php
                                textbox('veh_brand', 'Merek', 90, 120);
                                textbox('veh_transm', 'Transmisi', 90, 120);
                                textbox('veh_year', 'Tahun', 90, 120);
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr style="height: 10px !important"><td colspan="3"></td></tr>
                    <tr>
                        <td valign="top">
                            <table  style="margin-top: 20px;">
                                <tr>
                                    <td valign="top" class="checkboxValign"><?php getCaption("Transaksi"); ?> </td>
                                    <td valign="top" class="checkboxValign td-ro">:</td>
                                    <td>                             
                                        <table width="100" class="checkboxBorder">
                                            <tr><td><a href="#" class="checkbox salpaytype" name="salpaytype_1"><input type="radio" id="salpaytype_1" class="salpaytype_1 salpaytype" name="salpaytype" value="1"> <span>Cash</span></a></td></tr>

                                            <tr><td><a href="#" class="checkbox salpaytype" name="salpaytype_2"><input type="radio" id="salpaytype_2" class="salpaytype_2 salpaytype" name="salpaytype" value="2"> <span>Credit</span></a></td></tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td width="100"><?php getCaption("Kode"); ?></td>
                                    <td width="190"><?php getCaption("Nama"); ?></td>
                                    <td width="60"><?php getCaption("Tipe"); ?></td>
                                </tr>
                                <tr>
                                    <td width="100"><?php getCaption("Warna"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('color_code', 100, 150); ?></td>
                                    <td><?php textbox2('color_name', 190, 250); ?></td>
                                    <td><?php textbox2('color_type', 80, 100); ?></td>
                                </tr>

                                <tr>
                                    <td width="100"><?php getCaption("Std. Optional"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4">
                                        <?php textbox2('stdoptname', 378, 100); ?>
                                    </td>
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>

                    </tr>
                    <tr style="height: 10px !important"><td colspan="3"></td></tr>
                    <tr>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('bbnwo_no', 'WO BBN', 100, 70);
                                textbox('bbnpur_no', 'Pendaftaran', 100, 70);
                                ?>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td width="100" class="labels"><?php getCaption("Alarm"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" class="labels">
                                        <?php textbox2('alarm', 140, 120); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="labels" ><?php getCaption("No. Kunci"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" class="labels">
                                        <?php textbox2('key_no', 140, 120); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="labels"><?php getCaption("Buku Service"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" class="labels">
                                        <?php textbox2('serv_book', 140, 120); ?>
                                    </td>
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>

                    </tr>
                    <tr style="height: 10px !important"><td colspan="3"></td></tr>
                    <tr>
                        <td valign="top">
                            <table>
                                <?php
                                textbox('so_no', 'No. SPK', 100, 70);
                                datebox('match_date', 'Tanggal Match', 100);
                                ?>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td width="100" class="labels"><?php getCaption("Jatuh Tempo"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" class="labels">

                                        <table class='marginmin'>
                                            <tr>
                                                <td> <?php numberbox2('due_day', 45, 100) ?></td>
                                                <td><?php getCaption("Hari"); ?></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="labels"><?php getCaption("Tgl J. Tempo"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="4" class="labels">
                                        <?php datebox2('due_date'); ?>
                                    </td>
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption("Harga Jual"); ?>" class="main-tab">
                <table>
                    <tr>
                        <td valign="top">
                            <!--<h5><?php getCaption("Kendaraan"); ?></h5>-->
                            <table>

                                <?php
                                numberbox('veh_price', 'Harga Jual', 150, 12);
                                numberbox('veh_disc', 'Discount', 150, 12);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                                <?php
                                numberbox('veh_at', 'Sub Total', 150, 12);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                numberbox('veh_bbn', 'BBN', 150, 12);
                                numberbox('veh_misc', 'Lain - Lain', 150, 12);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('veh_total', 'Harga Total', 150, 12);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                numberbox('srv_at', 'Total Optional', 150, 70);
                                numberbox('part_at', 'Total Aksesoris', 150, 70);
                                numberbox('inv_stamp', 'Lain - Lain', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('inv_total', 'Grand Total', 150, 12);
                                ?>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table style="margin-left:50px;">
                                <?php
                                numberbox('veh_pbm', 'PBM', 150, 70);
                                numberbox('veh_bt', 'DPP', 150, 70);
                                numberbox('veh_vat', 'PPN', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('veh_at2', 'Sub Total', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <?php
                                textbox('so_no2', 'No. SPK', 120, 70);
                                numberbox('sovehprice', 'Harga di SPK', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <tr><td></td><td class="td-ro"></td><td><b><?php echo getCaption('Nomor'); ?></b></td><td style="text-align:right;"><b><?php echo getCaption('Total'); ?></b></td></tr>
                                <tr>
                                    <td><?php echo getCaption('WO BBN'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('bbnwo_no2', 120, 120); ?></td>
                                    <td><?php numberbox2('bbnwo_prc', 120, 150); ?> </td>
                                </tr>
                                <tr>
                                    <td><?php echo getCaption('Pendaftaran'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('bbnpur_no2', 120, 120); ?></td>
                                    <td><?php numberbox2('bbnpur_prc', 120, 150); ?> </td>

                                </tr>

                            </table>
                        </td>
                    </tr>

                </table>
            </div>


            <div title="<?php getCaption("Pelanggan"); ?>" class="main-tab">
                <table>						
                    <td valign="top">
                        <table>
                            <?php
                            cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                            textarea('cust_addr', 'Alamat', 200);
                            cmdArea('cust_area', 'Wilayah');
                            cmdCity('cust_city', 'Kota');
                            zipbox('cust_zipc', 'Kode Pos', 80, 5);
                            phonebox('cust_phone', 'Telepon', 200);
                            ?>
                            <tr><td class="col100"></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr style="margin-bottom: 10px !important;">
                                <td valign="top"  class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>   
                                    <table class="checkboxBorder" width="100">
                                        <tr><td><a href="#" class="checkbox" name="cust_sex_1"><input type="radio" id="cust_sex_1" class="cust_sex_1"  name="cust_sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_2"><input type="radio" id="cust_sex_2" class="cust_sex_2" name="cust_sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_3"><input type="radio" id="cust_sex_3" class="cust_sex_3" name="cust_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Pelanggan"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>   
                                    <table class="checkboxBorder" width="170">
                                        <tr><td><a href="#" class="checkbox" name="cust_type_1"><input type="radio" id="cust_type_1" class="cust_type_1" name="cust_type" value="1"> End User</a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_2"><input type="radio" id="cust_type_2" class="cust_type_2" name="cust_type" value="2"> Dealer/Reseller</a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_3"><input type="radio" id="cust_type_3" class="cust_type_3" name="cust_type" value="3"> Government/BUMN</a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <?php
                            textbox('cust_fax', 'Fax', 200, 70);
                            textbox('cust_hp', 'HP Pribadi', 200, 70);
                            ?>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <?php
                            textbox('cust_npwp', 'NPWP', 200, 70);
                            textbox('cust_nppkp', 'NPPKP', 200, 70);
                            ?>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <?php
                            textbox('cust_ktpno', 'No KTP', 150, 35);
                            ?>	
                        </table>
                    </td>						
                </table>
            </div>

            <div title="<?php getCaption("Data Di STNK"); ?>" class="main-tab">
                <table>
                    <td valign="top">
                        <table>
                            <?php
                            textbox('veh_reg_no', 'No. Polisi', 200, 70);
                            textbox('cust_rname', 'Nama', 200, 70);
                            textarea('cust_raddr', 'Alamat', 200);
                            ?>
                            <?php
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota');

                            zipbox('cust_rzipc', 'Kode Pos', 80, 5);
                            phonebox('cust_rphon', 'Telepon', 200);
                            ?>
                             <?php
                            textbox('cust_rktpno', 'No KTP', 150, 35);
                            ?>	
                            <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>

                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>   
                                    <table class="checkboxBorder" width="120">
                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_1"><input type="radio" id="cust_rsex_1" class="cust_rsex_1 cust_rsex"  name="cust_rsex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_2"><input type="radio" id="cust_rsex_2" class="cust_rsex_2 cust_rsex" name="cust_rsex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_3"><input type="radio" id="cust_rsex_3" class="cust_rsex_3 cust_rsex" name="cust_rsex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td valign="top">
                        <table style="margin-left:65px;">
                            <?php
                            textbox('stnk_no', 'No. STNK', 200, 70);
                            datebox('stnk_bdate', 'Berlaku', 200);
                            datebox('stnk_edate', 'S/D', 200);
                            ?>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Komisi & Sales Reps"); ?>" class="main-tab">
                <table>						
                    <td>
                        <table>
                            <?php
                            numberbox('comm_val', 'Jumlah Komisi', 150, 70);
                            textbox('medtr_name', 'Nama Penerima', 200, 70);
                            textbox('medtr_addr', 'Alamat Penerima', 200, 70);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            cmdSalSet('srep_code', 'srep_name', 'Sales');
                            textbox('srep_lev', 'Sales Level', 80, 17);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td  class="checkboxValign td-ro" valign="top">:</td>
                                <td>   
                                    <table width="100" class="checkboxBorder">                         
                                        <tr><td><a href="#" class="checkbox" name="srep_sex_1"><input type="radio" id="srep_sex_1" class="srep_sex_1 srep_sex"  name="srep_sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="srep_sex_2"><input type="radio" id="srep_sex_2" class="srep_sex_2 srep_sex" name="srep_sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="srep_sex_3"><input type="radio" id="srep_sex_3" class="srep_sex_3 srep_sex" name="srep_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textboxset('sspv_code', 'sspv_name', 'Supervisor', 80, 200);
                            textbox('sspv_lev', 'Supervisor Level', 80, 17);
                            ?>

                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Insentif"); ?>" class="main-tab">
                <table>						
                    <td valign="top">
                        <table>
                            <tr>
                                <td><b><?php getCaption("Perhitungan Insentif"); ?></b></td>
                            </tr>
                            <tr>
                                <td>                             
                                    <table  width="300" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_1"><input type="radio" id="sal_inctyp_1" class="sal_inctyp_1 sal_inctyp"  name="sal_inctyp" value="1"> <?php getCaption("Tidak Ada Insentif"); ?></a> </td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_2"><input type="radio" id="sal_inctyp_2" class="sal_inctyp_2 sal_inctyp" name="sal_inctyp" value="2"> <?php getCaption("Memakai Poin"); ?></a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_3"><input type="radio" id="sal_inctyp_3" class="sal_inctyp_3 sal_inctyp" name="sal_inctyp" value="3"> <?php getCaption("Secara Persentase"); ?> </a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_4"><input type="radio" id="sal_inctyp_4" class="sal_inctyp_4 sal_inctyp" name="sal_inctyp" value="4"> <?php getCaption("Kombinasi Point & Persentase"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>	
                    <td></td>
                    <td valign="top">
                        <table style="margin-left: 65px;">
                            <tr> <td colspan="3"><b><?php getCaption('Nilai Insentif Penjualan Kendaraan'); ?></b></td></tr>                 

                            <tr>
                                <td><?php getCaption('Jumlah Point'); ?></td>
                                <td>:</td>
                                <td><?php numberbox2('sal_incpnt', 70, 150); ?> </td>
                            </tr>
                            <tr>
                                <td><?php getCaption('Persentase'); ?></td>
                                <td>:</td>
                                <td><table class='marginmin'><tr><td><?php numberbox2('sal_incpct', 50, 150); ?></td><td> %</td></tr></table></td>
                            </tr>

                        </table>
                    </td>
                </table>	
            </div>

            <div title="<?php getCaption("Dokumen Penjualan"); ?>" class="main-tab">
                <table>						
                    <td valign="top">
                        <table>
                            <tr><td></td> <td class="td-ro"></td><td><?php getCaption("Nomor"); ?></td><td><?php getCaption("Tanggal"); ?></td></tr>
                            <tr>
                                <td>SPK</td>   
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('so_no2', 145, 120); ?></td>
                                <td><?php datebox2('so_date'); ?></td>                          
                            </tr>

                            <tr>
                                <td><?php getCaption("Surat Jalan"); ?></td> 
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('sj_no', 145, 120); ?></td>
                                <td><?php datebox2('sj_date'); ?></td> 
                            </tr>
                            <tr>
                                <td><?php getCaption("Kwitansi"); ?></td>  
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('kwit_no', 145, 120); ?></td>
                                <td><?php datebox2('kwit_date'); ?></td>   
                            </tr>

                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption('Nama di Kwitansi dari'); ?> </td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td colspan="2">                             

                                    <table class="checkboxBorder" width="170">
                                        <tr><td><a href="#" class="checkbox" name="kwit_data_1"><input type="radio" id="kwit_data_1" class="kwit_data_1 kwit_data" name="kwit_data" checked="checked" value="1"> <?php getCaption("Data Pelanggan"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="kwit_data_2"><input type="radio" id="kwit_data_2" class="kwit_data_2 kwit_data" name="kwit_data" value="2"> <?php getCaption("Data di STNK"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="kwit_data_3"><input type="radio" id="kwit_data_3" class="kwit_data_3 kwit_data" name="kwit_data" value="3"> <?php getCaption("Data Leasing/Debitur"); ?></a></td></tr>
                                    </table>


                                </td>
                            </tr>

                        </table>  
                    </td>

                    <td valign="top">
                        <table style="margin-left:65px;">
                            <tr><td></td> <td class="td-ro"></td><td><?php getCaption("Nomor"); ?></td><td><?php getCaption("Tanggal"); ?></td></tr>
                            <tr>
                                <td><?php getCaption("Faktur Pajak"); ?></td> 
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('fp_no', 145, 120); ?></td>
                                <td><?php datebox2('fp_date'); ?></td>   

                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption('Nama di Faktur Pajak Dari'); ?> </td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td colspan="2">      
                                    <div>
                                        <table class="checkboxBorder" width="170">
                                            <tr><td><a href="#" class="checkbox" name="fp_data_1"><input type="radio" id="fp_data_1" class="fp_data_1 fp_data" name="fp_data" value="1" checked="checked"> <?php getCaption("Data Pelanggan"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="fp_data_2"><input type="radio" id="fp_data_2" class="fp_data_2 fp_data" name="fp_data" value="2"> <?php getCaption("Data di STNK"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="fp_data_3"><input type="radio" id="fp_data_3" class="fp_data_3 fp_data" name="fp_data" value="3"> <?php getCaption("Data Leasing/Debitur"); ?></a></td></tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>

                </table>	
            </div>

            <div title="<?php getCaption("Optional"); ?>" class="main-tab">

                <table id="dt_jasa" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
                <br />
                <table style="margin-left: 740px;" >
                    <td style="padding:0px 10px;">
                        <table style="margin:0px 0px 10px 0px;">
                            <?php
                            numberbox('srv_price', 'Total Harga Netto', 120, 70);
                            numberbox('srv_disc', 'Discount', 120, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('srv_bt', 'DPP', 120, 70);
                            numberbox('srv_vat', 'PPN', 120, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('srv_at2', 'Total Jasa', 120, 70);
                            ?>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Perlengkapan Tambahan"); ?>" class="main-tab">
                <table>
                    <tr><td><b><?php getCaption("Perlengkapan Tambahan"); ?></b></td></tr>
                    <tr>
                        <td  valign="top" style="padding:0px 10px;">
                            <table style="margin:0px 0px 10px 0px; width:50%;">
                                <tr>
                                    <td>1.</td>
                                    <td><?php textbox2('add_item1', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td><?php textbox2('add_item2', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td><?php textbox2('add_item3', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td><?php textbox2('add_item4', 250, 250); ?></td>
                                </tr>

                            </table>
                        </td>
                        <td  valign="top" style="padding:0px 10px;">
                            <table style="margin:0px 0px 10px 0px;width: 50%;">
                                <tr>
                                    <td>5.</td>
                                    <td><?php textbox2('add_item5', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>6.</td>
                                    <td><?php textbox2('add_item6', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>7.</td>
                                    <td><?php textbox2('add_item7', 250, 250); ?></td>
                                </tr>
                                <tr>
                                    <td>8.</td>
                                    <td><?php textbox2('add_item8', 250, 250); ?></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption("Leasing"); ?>" class="main-tab">
                <table>						
                    <td valign="top">
                        <table>
                            <tr><td colspan="3"><h1><?php getCaption("Pengajuan Aplikasi Kredit"); ?></h1></td></tr>
                            <?php
                            cmdLeaseSet('lease_code', 'lease_name', 'Leasing');
                            textarea('lease_addr', 'Alamat', 200);
                            textbox('lease_city', 'Kota', 200, 70);

                            zipbox('lease_zipc', 'Kode Pos', 80)
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('lcp1_name', 'Telepon', 200, 70);
                            textbox('lcp1_title', 'Jabatan', 200, 70);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('crd_note', 'Catatan', 280, 70);
                            ?>
                            <tr><td class="col100"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table style="margin-left: 25px;">
                            <tr><td colspan="3"><h1>&nbsp;</h1></td></tr>
                            <?php
                            textbox('crd_via', 'Kredit Via', 200, 70);
                            numberbox('crd_amount', 'Jumlah Kredit', 200, 70);
                            ?>
                            <tr>
                                <td><?php getCaption("Lama Kredit"); ?></td>
                                <td class="td-ro">:</td>
                                <td><table class='marginmin'><tr><td><?php numberbox2('crd_term', 60, 10); ?></td><td><?php getCaption("Bulan"); ?></td></tr></table></td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr><tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('crd_apprby', 'Disetujui', 200, 70);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"><h1><?php getCaption("Persetujuan Kredit"); ?></h1></td></tr>
                            <?php
                            textbox('crd_cntrno', 'No. Kontrak', 200, 70);
                            //textbox('crd_cntrdt', 'Tgl. Kontrak', 200, 70);
                            datebox('crd_cntrdt', 'Tgl. Kontrak', 200);
                            ?>	
                        </table>
                    </td>						
                </table>
            </div>

        </div>

        <div class="main-nav">
            <table>
                <tr>
                    <td>  <?php navigation_ci(); ?></td>
                    <td>
                        <table style="width:400px;" border="0">
                            <tr>
                                <td  style="border-top:0px !important;">
                                    <button type="button" id="cmdOptional"  class="easyui-linkbutton" data-options="iconCls:'icon-optional'"  onclick="cmdOptionals()" disabled="true">Optional</button>
                                    <span id="closeOn"></span>
                                    <button type="button" id="printSJ" title="<?php getCaption("Print SJ"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPopupPrint('sj');" disabled="true" >Print SJ</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPopupPrint('faktur');" disabled="true" >Print Fkt</button>
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

<div id="optionalWindow" class="easyui-window" title="<?php getCaption("Isi Perincian Pekerjaan/Jasa"); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1090px;height:500px;padding:10px;top:1;">

    <div style="width: 820; margin: 20px;">
        <table id="dt_jasa2" class="easyui-datagrid"  title="" style="width:1010px;height:250px;"></table>
        <br />

        <form id="form_validation2" method="post" >
            <div id="tableId2"></div>

            <table>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                                <td><b><?php getCaption("Nama Pekerjaan"); ?> </b></td>
                                <td class="right"><b><?php getCaption("Harga Jual"); ?></b></td>
                                <td class="right"><b><?php // getCaption("Diskon");     ?>Disc(%)</b></td>
                                <td class="right"><b><?php getCaption("Jumlah Diskon"); ?></b></td>
                                <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                            </tr>
                            <tr>
                                <td><?php acc_wkcd('wk_code', 'Kode', $site_url); ?></td>
                                <td><?php textbox2('wk_desc', 350, 17); ?></td>
                                <td><?php numberbox2('price_bd', 120, 100) ?></td>
                                <td><?php numberbox2('disc_pct', 120, 50); ?></td>
                                <td><?php numberbox2('disc_val', 120, 100) ?></td>
                                <td><?php numberbox2('price_ad', 120, 100) ?></td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>  
                        <table style="width:500px;" border="0">
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
                                    <button type="button" id="ok2" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#optionalWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="w" class="easyui-window" title="Please Choose Vehicle Stock" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;">

    <form id="formOption" action="post">
        <table>
            <tr>
                <td><b>Show</b></td>
                <td>
                    <select  id="showformOption" name="formOption" style="width:150px;height: 25px;" onchange="showMacthkeyword()">
                        <option value="all">ALL</option>
                        <option value="chassis"><?php getCaption("Chassis"); ?></option>
                        <option value="engine"><?php getCaption("No. Mesin"); ?></option>
                        <option value="veh_code"><?php getCaption("Kode Kendaraan"); ?></option>
                        <option value="veh_model"><?php getCaption("Model"); ?></option>
                        <option value="color_code"><?php getCaption("Kode Warna"); ?></option>
                        <option value="so_no"><?php getCaption("No. SPK"); ?></option>
                    </select>
                </td>
                <td id="TDkeywordform">
                    <input class="easyui-textbox" name="keyword" id="keywordformMatch" style="width:150px;height: 25px;">
                </td>
                <td id="TDbuttonSearchform">
                    <button class="easyui-linkbutton" id="buttonSearchformMatch1" data-options="iconCls:'icon-search'"  onclick="sortirOption()"></button>
                </td>
            </tr>
        </table>
    </form>
    <div id="tableStock"></div>
</div>
<div id="wUJ" class="easyui-window" title="Payment of DP" data-options="closable:false,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:300px;padding:10px;top:1;">
    <table id="tableUJ"></table>
    <br />
    <span>Note: Down Payment(s) listed above will automatically be inserted as Account Receivable Payment</span>
    <br /><br />
    <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="$('#wUJ').window('close');">Ok</button>
</div>
<div id="printWindow" class="easyui-window" title="<?php getCaption("Cetak Faktur Penjualan Kendaraan"); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:730px;height:490px;padding:10px;top:1;">
    <form id="form_validation3" method="post" >
        <input type="hidden" id="printAction">
        <table>
            <tr>
                <td>
                    <table style="width: 93%;">
                        <tr><td>
                                <table style="background: #f4f4f4; padding:10px;border-radius:10px;margin-bottom: 10px;">
                                    <?php
                                    textbox('chassis', 'Nomor Rangka', 150, 70);
                                    numberbox('inv_total', 'Harga Kendaraan', 150, 100);
                                    ?>
                                    <tr><td class="col150"></td><td colspan="2"></td></tr>
                                </table>
                                <table style="background: #f4f4f4; padding:10px;border-radius:10px;margin-bottom: 10px; width: 100%;">
                                    <?php
                                    numberbox('pay_val', 'Uang Jaminan', 145, 100);
                                    numberbox('used_val', 'U.J. yang Terpakai', 150, 100);
                                    numberbox('pay_total', 'SISA DP', 150, 100);
                                    ?>
                                    <tr><td colspan='3'd style="text-align:right;"><hr /></td></tr>
                                    <?php numberbox('price_ad', 'SISA Tagihan U.J', 150, 100); ?>

                                    <tr><td width="125"></td><td colspan="2"></td></tr>
                                </table>
                                <table style="background: #f4f4f4; padding:10px;border-radius:10px;margin-bottom: 10px; width: 100%;">
                                    <?php
                                    numberbox('pd_begin', 'Piutang Awal', 150, 12);
                                    numberbox('pd_paid', 'Pembayaran', 150, 12);
                                    numberbox('pd_disc', 'Diskon', 150, 12);
                                    ?>
                                    <tr><td colspan='3' style="text-align:right;"><hr /></td></tr>
                                    <?php numberbox('pd_end', 'Sisa Piutang', 150, 100); ?>

                                    <tr><td width="125"></td><td colspan="2"></td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td colspan="2"></td>
                <td>
                    <table style="margin-top:-50px;">
                        <?php
                        textbox('lease_name', 'Nama Leasing', 200, 70);
                        textbox('lease_code', 'Kode', 200, 70);
                        ?>
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr>   
                        <tr>
                            <td colspan='3'><h3><?php getCaption("Persetujuan Kredit"); ?>:</h3></td>
                        </tr>
                        <?php
                        textbox('crd_cntrno', 'No. Kontrak', 200, 70);
                        datebox('crd_cntrdt', 'Tgl. Kontrak', 200);
                        numberbox('crd_amount', 'Jumlah Kredit', 150, 12);
                        ?>
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr> 
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr>   
                        <tr><td colspan='3'></td></tr> 


                    </table>
                    <table style="margin-top:0px;">
                        <tr>
                            <td><button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');">Screen</button></td>
                            <td><button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" >Print</button></td>
                            <td><button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#printWindow').window('close');">Quit</button></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
</div>

<div id="WindowSJ" class="easyui-window" title="<?php getCaption("Cetak Surat Jalan"); ?>" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:550px;height:380px;padding:10px;top:1;">
    <form id="form_validation4" method="post" >
        <table>
            <tr>
                <td>
                    <h1><?php getCaption("Data di Surat Jalan dari"); ?>:</h1>
                    <table>
                        <tr>
                            <td><input type="radio" name="data_type" id="data_type1" class="radio" value="pelanggan" checked="true"><?php getCaption("Data Pelanggan"); ?></td>
                            <td><?php textbox2('cust_name', 200, 150) ?></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="data_type" id="data_type2" class="radio" value="stnk"><?php getCaption("Data di STNK"); ?></td>
                            <td><?php textbox2('cust_rname', 200, 150) ?></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="data_type" id="data_type3" class="radio" value="debitur"><?php getCaption("Data Leasing/Debitur"); ?></td>
                            <td><?php textbox2('lease_name2', 200, 150) ?></td>
                        </tr>
                    </table>
                </td>             
            </tr>
            <tr>
                <td>
                    <table>
                        <tr><td width="145"></td><td colspan="2"></td></tr>
                        <?php
                        textbox('wrhs_code', 'Warehouse', 190, 70);
//cmdLeaseSet('lease_code', 'lease_name', 'Nama Leasing');
                        textbox('veh_name', 'Kendaraan', 190, 70);
                        textbox('key_no', 'No. Kunci', 190, 70);
                        textbox('crd_cntrno', 'No. Kontrak', 200, 70);
                        datebox('crd_cntrdt', 'Tgl. Kontrak', 200);
                        numberbox('crd_amount', 'Jumlah Kredit', 150, 12);
                        ?>
                    </table>
                </td>
            </tr>
        </table>
        <table style="margin-top:0px;">
            <tr>
                <td id="buttonSJ"></td>

                <td><button type="button" id="exit" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="closeWUJ();">Quit</button></td>
            </tr>
        </table>
    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur Jual"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("No. SPK"); ?>:</span>
            <input id="name" name="name" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<style>
    #form_validation3 #price_ad,#form_validation3 #pd_end{color:red;}
</style>
<?php include 'penjualan_kendaraan_fn.php'; ?>