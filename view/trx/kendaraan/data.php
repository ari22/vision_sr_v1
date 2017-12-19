<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td>
                    <table>
                        <?php textbox('chassis', "Chassis", 150, 150) ?>
                        <?php textbox('engine', "engine", 150, 150) ?>
                        <?php cmdWrhs('wrhs_code', 'Warehouse', 150); ?>
                    </table>
                </td>
                <td>
                    <table style="margin-top: -40px;">
                        <?php cmdCustSet('cust_code', 'cust_name', 'Pelanggan', 100, 200); ?>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Kendaraan'); ?>"  class="main-tab">
                <table style="width:900px;" >
                    <tr>
                        <td>
                            <table>
                                <?php
                                cmdVehSet('veh_code', 'veh_name', 'Kendaraan');
                                textbox('chassis', 'Chassis', 150, 17);
                                textbox('engine', 'Engine', 150, 15);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_type', 'Tipe', 80, 10);
                                textbox('veh_model', 'Model', 150, 20);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php
                                textbox('veh_brand', 'Merek', 200, 15);
                                textbox('veh_transm', 'Transmisi', 40, 2);
                                textbox('veh_year', 'Tahun', 40, 4);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>



                            </table>
                        </td>
                        <td></td>
                        <td>
                            <table style="margin-top: -40px;">
                                <?php
                                cmdColSet('color_code', 'color_name', 'Warna');
                                textbox('color_type', 'Tipe', 40, 10);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                textbox('veh_reg_no', 'No. Polisi', 100, 10);
                                ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr> 

                            </table>
                        </td>
                    </tr>

                </table>
            </div>

            <div title="<?php getCaption('Pelanggan'); ?>"  class="main-tab">
                <table width="100%">						
                    <td>
                        <table class="table" style="margin:10px 0px 10px 0px;">
                            <?php
                            textbox('cust_code2', 'Kode Pelanggan', 100, 17);
                            textbox('cust_name2', 'Nama Pelanggan', 250, 17);
                            textarea('cust_addr', 'Alamat', 200);
                            cmdArea('cust_area', 'Wilayah');
                            cmdCity('cust_city', 'Kota');
                            textbox('cust_zipc', 'Kode Pos', 80, 70);
                            textbox('cust_phone', 'Telepon', 200, 70);
                            ?>
                        </table>
                    </td>
                    <td>
                        <table class="table"  style="margin-top:-50px;" >
                            <tr style="margin-top:10px !important;margin-bottom: 10px !important;">
                                <td valign="top"><?php getCaption("Jenis Pelanggan"); ?></td>
                                <td valign="top" class="td-ro">:</td>
                                <td>  
                                    <table style="margin-top: -2px;margin-left: -3px;">
                                        <tr>
                                            <td width="100"><a href="#" class="checkbox" name="cust_type_1"><input type="radio" id="cust_type_1" class="cust_type_1" name="cust_type" value="1"> End User </a></td>

                                            <td width="130"><a href="#" class="checkbox" name="cust_type_2"><input type="radio" id="cust_type_2" class="cust_type_2" name="cust_type" value="2"> Dealer/Reseller</a></td>

                                            <td  width="150"><a href="#" class="checkbox" name="cust_type_3"><input type="radio" id="cust_type_3" class="cust_type_3" name="cust_type" value="3"> Government/BUMN</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr>
                                <td valign="top"><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td class="td-ro">:</td>
                                <td>        
                                    <table style="margin-top: -1.5px;margin-left: -3px;">
                                        <tr>
                                            <td width="100"><a href="#" class="checkbox" name="cust_sex_1"><input type="radio" id="cust_sex_1" class="cust_sex_1"  name="cust_sex" value="1"> <?php getCaption("Pria"); ?></a></td>

                                            <td width="130"><a href="#" class="checkbox" name="cust_sex_2"><input type="radio" id="cust_sex_2" class="cust_sex_2" name="cust_sex" value="2"> <?php getCaption("Wanita"); ?></a></td>

                                            <td   width="150"><a href="#" class="checkbox" name="cust_sex_3"><input type="radio" id="cust_sex_3" class="cust_sex_3" name="cust_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <?php
                            textbox('cust_fax', 'Fax', 200, 70);
                            textbox('cust_hp', 'HP Pribadi', 200, 70);
                            textbox('cust_npwp', 'NPWP', 200, 70);
                            textbox('cust_nppkp', 'NPPKP', 200, 70);
                            ?>	
                        </table>
                    </td>						
                </table>
            </div>
            <div title="<?php getCaption('Data Di STNK'); ?>"  class="main-tab">
                <table class="table">
                    <td style="padding:0px 10px;">
                        <table class="table" style="margin:0px 0px 10px 0px;">
                            <?php
                            textbox('veh_reg_no', 'No. Polisi', 200, 70);
                            textbox('cust_rname', 'Nama', 200, 70);
                            textarea('cust_raddr', 'Alamat', 200);
                            ?>
                            <?php
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota');
                            textbox('cust_rzipc', 'Kode Pos', 80, 70);
                            textbox('cust_rphon', 'Telepon', 200, 70);
                            ?>
                            <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>

                            <tr style="margin-top:10px !important;margin-bottom: 10px !important;">
                                <td><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td class="td-ro">:</td>
                                <td>                             
                                    <a href="#" class="checkbox" name="cust_rsex_1"><input type="radio" id="cust_rsex_1" class="cust_rsex_1 cust_rsex"  name="cust_rsex" value="1"> <?php getCaption("Pria"); ?></a>

                                    <a href="#" class="checkbox" name="cust_rsex_2"><input type="radio" id="cust_rsex_2" class="cust_rsex_2 cust_rsex" name="cust_rsex" value="2"> <?php getCaption("Wanita"); ?></a>

                                    <a href="#" class="checkbox" name="cust_rsex_3"><input type="radio" id="cust_rsex_3" class="cust_rsex_3 cust_rsex" name="cust_rsex" value="3"> <?php getCaption("Perusahaan"); ?></a>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td>
                        <table class="table" style="margin-top:-130px;margin-left:65px;">
                            <?php
                            textbox('stnk_no', 'No. STNK', 200, 70);
                            datebox('stnk_bdate', 'Berlaku', 200);
                            datebox('stnk_edate', 'S/D', 200);
                            ?>
                        </table>
                    </td>
                </table>
            </div>

            <div title="Sales"  class="main-tab">
                <table>
                    <tr>
                        <td valign="top">
                            <table>
                                <tr><td></td> <td class="td-ro"></td><td><?php getCaption("Nomor"); ?></td><td><?php getCaption("Tanggal"); ?></td></tr>


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
                                <tr>
                                    <td><?php getCaption("Faktur Pajak"); ?></td> 
                                    <td class="td-ro">:</td>
                                    <td width="60"><?php textbox2('fp_no', 200, 120); ?></td>
                                    <td><?php datebox2('fp_date'); ?></td>   

                                </tr>
                                <tr><td><br /></td></tr>
                                <tr>
                                    <td><?php getCaption("Faktur Jual"); ?></td>   
                                    <td class="td-ro">:</td>
                                    <td width="60"><?php textbox2('sal_inv_no', 145, 120); ?></td>
                                    <td><?php datebox2('sal_date'); ?></td>                          
                                </tr>

                                <tr>
                                    <td>SPK</td>   
                                    <td class="td-ro">:</td>
                                    <td width="60"><?php textbox2('so_no', 145, 120); ?></td>
                                    <td><?php datebox2('so_date'); ?></td>                          
                                </tr>
                            </table>
                        </td>
                        <td width="50"></td>
                        <td valign="top">
                            <table>
                                <tr><td><br /></td></tr>
                                <?php textboxset('srep_code', 'srep_name', 'Sales', 100, 200, 100, 200) ?>
                                <tr><td colspan="3"></td></tr> <tr><td colspan="3"></td></tr>

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
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="<?php getCaption('Harga Jual'); ?>"  class="main-tab">
                <table>
                    <tr>
                        <td>
                            <table>
                                <?php
                                numberbox('sal_bt', 'DPP', 150, 150);
                                numberbox('sal_pbm', 'PBM', 150, 150);
                                numberbox('sal_vat', 'PPN', 150, 150);
                                ?>
                                <tr><td><?php getCaption('PPH') ?></td><td class="td-ro">:</td><td></td></tr>
                                 <?php
                                numberbox('sal_bbn', 'BBN', 150, 150);
                                numberbox('sal_misc', 'Lain - lain', 150, 150);
                                numberbox('sal_total', 'Harga', 150, 150);
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="<?php getCaption('Pembelian'); ?>"  class="main-tab">
                            <table>
                    <td valign="top">
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
                           
                            <tr><td colspan="4"></td></tr> <tr><td colspan="4"></td></tr>
                             <tr>
                                <td><?php getCaption('Pembelian'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('pur_inv_no', 150, 30); ?></td>
                                <td><?php datebox2('pur_date'); ?></td>
                            </tr>
                            <tr>
                                <td>PO</td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('po_no', 150, 30); ?></td>
                                <td><?php datebox2('po_date'); ?></td>
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
                             <tr>
                                <td><?php getCaption('Debit Note'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('dni_no', 200, 100); ?></td>
                                <td><?php datebox2('dni_date'); ?></td>
                            </tr>
                            <tr><td width="100"></td></tr>
                        </table>
                    </td>

                </table>
            </div>
            <div title="<?php getCaption('Harga Beli'); ?>"  class="main-tab">
            <table>
                    <tr>
                        <td>
                            <table>
                                <?php
                                numberbox('pur_bt', 'DPP', 150, 150);
                                numberbox('pur_pbm', 'PBM', 150, 150);
                                numberbox('pur_vat', 'PPN', 150, 150);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td></td></tr>
                                <?php numberbox('pur_pph', 'PPH', 150, 150); ?>
                                 <tr><td><?php getCaption('BBN') ?></td><td class="td-ro">:</td><td></td></tr>
                                <?php
                                numberbox('pur_misc', 'Lain - lain', 150, 150);
                                numberbox('pur_price', 'Harga', 150, 150);
                                ?>
                            </table>
                        </td>
                    </tr>
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

<?php include 'data_fn.php'; ?>