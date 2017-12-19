<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td valign="top">
                    <table>
                        <?php textbox('rsl_inv_no', 'No. Faktur', 120, 70); ?>
                        <?php datebox('rsl_date', 'Tgl. Faktur'); ?>
                        <tr>
                            <td><?php getCaption('No. Faktur Jual');?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table style="margin-left: -3px;float:left">
                                     <tr>
                                        <td><?php textbox2('sal_inv_no', 120, 120);?></td>
                                        <td><button type="button" id="cmdDeleteVSL" title="Delete Faktur" class="easyui-linkbutton cmdDeleteVSL" data-options="iconCls:'icon-no'"  onclick="condDeleteVSL()" ></button></td>
                                        <td><button type="button" id="cmdSearchVSL" title="Search Faktur" class="easyui-linkbutton cmdSearchVSL" data-options="iconCls:'icon-search'"  onclick="condFindVSL()" ></button></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <?php //cmdslhClose('sal_inv_no', 'No. Faktur Jual', $site_url); ?>
                        <?php datebox('sal_date', 'Tgl. Faktur Jual'); ?>
                        <tr><td width="150"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table >
                        <?php
                        textbox('wrhs_code', 'Warehouse', 120, 50);
                        ?>
                        <tr>
                            <td><?php getCaption('Aging Dalam'); ?></td>
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
                        <?php
                        datebox('due_date', 'Tgl. Aging');
                        
                        ?>
                        <tr><td width="120"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                    <?php                  
                    datebox('cls_date', 'Tgl Closed');
                    textbox('cls_by', 'Closed By', 90, 70);
                    textbox('note', 'Keterangan', 200, 3);
                    ?>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Kendaraan'); ?>"  class="main-tab">
                <table>
                    <tr>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td></td>
                                    <td class="td-ro"></td>
                                    <td><?php getCaption("Kode"); ?></td>
                                    <td><?php getCaption("Nama"); ?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Kendaraan"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('veh_code', 100, 100);?></td>
                                    <td><?php textbox2('veh_name', 250, 250);?></td>
                                </tr>
                                
                                <tr>
                                    <td><?php getCaption("Chassis"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="2">
                                        <table style="margin-left: -3px;">
                                              <tr>
                                                  <td><?php textbox2('chassis', 150, 250);?></td>
                                                  <td class="col50"><?php getCaption("Tipe"); ?></td>
                                                  <td class="td-ro">:</td>
                                                  <td><?php textbox2('veh_type', 100, 250);?></td>
                                              </tr>
                                        </table>
                                        
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Engine"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="2">
                                        <table style="margin-left: -3px;">
                                            <tr>
                                                <td> <?php textbox2('engine', 150, 250);?>  </td>
                                                <td class="col50"><?php getCaption("Model"); ?></td>
                                                <td class="td-ro">:</td>
                                                <td> <?php textbox2('veh_model', 100, 250);?></td>
                                            </tr>
                                        </table>
                                                                           
                                    </td>
                                    
                                </tr>
                                <tr><td class="col100"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table style="margin-left: 50px;">
                                <tr><td>&nbsp;</td></tr>
                                <?php
                                textbox('veh_brand', 'Merek', 100, 100);
                                textbox('veh_transm', 'Transmisi', 100, 100);
                                textbox('veh_year', 'Tahun', 50, 50);
                                ?>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td></td>
                                    <td class="td-ro"></td>
                                    <td><?php getCaption("Kode"); ?></td>
                                    <td><?php getCaption("Nama"); ?></td>
                                    <td><?php getCaption("Tipe"); ?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Warna"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('color_code', 100, 100);?></td>
                                    <td><?php textbox2('color_name', 250, 250);?></td>
                                    <td><?php textbox2('color_type', 50, 250);?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Alarm"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3"><?php textbox2('alarm', 100, 250);?></td>
                                </tr>
                                 <tr>
                                    <td><?php getCaption("No. Kunci"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3"><?php textbox2('key_no', 100, 250);?></td>
                                </tr>
                                 <tr>
                                    <td><?php getCaption("Buku Service"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td colspan="3"><?php textbox2('serv_book', 100, 250);?></td>
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
                        <td valign="top" width="350">
                            <!--<h5><?php getCaption("Kendaraan"); ?></h5>-->
                            <table >

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
                                numberbox('srv_at', 'Total Jasa', 150, 70);
                                numberbox('part_at', 'Total Aksesoris', 150, 70);
                                numberbox('inv_stamp', 'Lain - Lain', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('inv_total', 'Grand Total', 150, 12);
                                ?>
                                <tr><td width="120"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <?php
                                numberbox('veh_pbm', 'PBM', 150, 70);
                                numberbox('veh_bt', 'DPP', 150, 70);
                                numberbox('veh_vat', 'PPN', 150, 70);
                                ?>
                                <tr><td></td><td class="td-ro"></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                                <?php
                                numberbox('veh_at2', 'Sub Total', 150, 70);
                                ?>
                                <tr><td class="col120"></td></tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </div>

            <div title="<?php getCaption("Pelanggan"); ?>" class="main-tab">
                <table>						
                    <td valign="top" width="450">
                        <table class="table">
                            <?php
                            cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                            textarea('cust_addr', 'Alamat', 200);
                            
                            cmdArea('cust_area', 'Wilayah');
                            cmdCity('cust_city', 'Kota'); 
                            
                           
                            zipbox('cust_zipc', 'Kode Pos', 200, 70);
                            textbox('cust_phone', 'Telepon', 200, 70);
                            ?>
                             <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                    <td valign="top">
                        <table class="table">
                            <tr style="margin-top:10px !important;margin-bottom: 10px !important;">
                                <td valign="top"  class="checkboxValign"><?php getCaption("Jenis Pelanggan"); ?></td>
                                <td valign="top"  class="checkboxValign td-ro">:</td>
                                <td>     
                                    <table  class="checkboxBorder" width="170">
                                        <tr><td><a href="#" class="checkbox" name="cust_type_1"><input type="radio" id="cust_type_1" class="cust_type_1" name="cust_type" value="1"> End User </a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_2"><input type="radio" id="cust_type_2" class="cust_type_2" name="cust_type" value="2"> Dealer/Reseller</a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_type_3"><input type="radio" id="cust_type_3" class="cust_type_3" name="cust_type" value="3"> Government/BUMN</a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td  class="checkboxValign td-ro" valign="top">:</td>
                                <td>   
                                    <table class="checkboxBorder" width="100">
                                        <tr><td><a href="#" class="checkbox" name="cust_sex_1"><input type="radio" id="cust_sex_1" class="cust_sex_1"  name="cust_sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_2"><input type="radio" id="cust_sex_2" class="cust_sex_2" name="cust_sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_sex_3"><input type="radio" id="cust_sex_3" class="cust_sex_3" name="cust_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
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

            <div title="<?php getCaption("Data Di STNK"); ?>" class="main-tab">
                <table class="table">
                    <td valign="top" width="450">
                        <table class="table">
                            <?php
                            textbox('veh_reg_no', 'No. Polisi', 200, 70);
                            textbox('cust_rname', 'Nama', 200, 70);
                            textarea('cust_raddr', 'Alamat', 200);
                            ?>
                            <?php
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota'); 
                            
                           
                            zipbox('cust_rzipc', 'Kode Pos', 200, 70);
                            textbox('cust_rphon', 'Telepon', 200, 70);
                            ?>
                            <tr style="margin-top:10px !important;margin-bottom: 10px !important;">
                                <td valign="top"  class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td class="checkboxValign td-ro" valign="top">:</td>
                                <td>                               
                                    <table class="checkboxBorder" width="100">
                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_1"><input type="radio" id="cust_rsex_1" class="cust_rsex_1 cust_rsex"  name="cust_rsex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_2"><input type="radio" id="cust_rsex_2" class="cust_rsex_2 cust_rsex" name="cust_rsex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_3"><input type="radio" id="cust_rsex_3" class="cust_rsex_3 cust_rsex" name="cust_rsex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                             <tr><td class="col120"></td></tr>
                        </table>
                    </td>

                    <td valign="top">
                        <table class="table">
                            <?php
                            textbox('stnk_no', 'No. STNK', 200, 70);
                            datebox('stnk_bdate', 'Berlaku', 200);
                            datebox('stnk_edate', 'S/D', 200);
                            ?>
                            <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Sales Representative"); ?>" class="main-tab">
                <table class="table"  cellpadding="1" >						
                    <td valign="top">
                        <table>
                            <?php
                            cmdSalSet('srep_code', 'srep_name', 'Sales');
                            textbox('srep_lev', 'Sales Level', 80, 17);
                            ?>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td valign="top"  class="checkboxValign td-ro">:</td>
                                <td>                               
                                    <table class="checkboxBorder" width="100">
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
                             <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Insentif"); ?>" class="main-tab">
                <table class="table" cellpadding="1" >						
                    <td width="450" valign="top">
                        <table class="table">
                            <tr>
                                <td><b><?php getCaption("Perhitungan Insentif"); ?></b></td>
                            </tr>
                            <tr>
                                <td>                             
                                    <table class="checkboxBorder" width="300">
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_1"><input type="radio" id="sal_inctyp_1" class="sal_inctyp_1 sal_inctyp"  name="sal_inctyp" value="1"><?php getCaption("Tidak Ada Insentif"); ?></a> </td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_2"><input type="radio" id="sal_inctyp_2" class="sal_inctyp_2 sal_inctyp" name="sal_inctyp" value="2"><?php getCaption("Memakai Poin"); ?></a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_3"><input type="radio" id="sal_inctyp_3" class="sal_inctyp_3 sal_inctyp" name="sal_inctyp" value="3"><?php getCaption("Secara Persentase"); ?> </a></td></tr>
                                        <tr><td><a href="#" class="checkbox" name="sal_inctyp_4"><input type="radio" id="sal_inctyp_4" class="sal_inctyp_4 sal_inctyp" name="sal_inctyp" value="3"><?php getCaption("Kombinasi Point & Persentase"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>	
                    <td></td>
                    <td valign="top">
                        <table>
                            <tr> <td colspan="3"><b><?php getCaption('Nilai Insentif Penjualan Kendaraan'); ?></b></td></tr>                 
                            <?php
                            numberbox('sal_incpnt', 'Jumlah Point', 70, 70);
                            ?>
                            <tr>
                                <td><?php getCaption('Persentase'); ?></td>
                                <td>:</td>
                                <td>
                                    <table class='marginmin'>
                                        <tr>
                                            <td><?php numberbox2('sal_incpct', 50, 150);?></td>
                                            <td> %</td>
                                        </tr>
                                    </table> 
                                </td>
                            </tr>

                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Dokumen Penjualan"); ?>" class="main-tab">
                <table class="table" cellpadding="1">						
                    <td valign="top" width="450">
                        <table class="table">
                            <tr>
                                <td></td> 
                                <td class="td-ro"></td>
                                <td><?php getCaption("Nomor"); ?></td>
                                <td><?php getCaption("Tanggal"); ?></td>
                            </tr>
                            <tr>
                                <td>SPK</td>   
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('so_no', 100, 120); ?></td>
                                <td><?php datebox2('so_date') ?></td>                          
                            </tr>
                            <tr>
                                <td><?php getCaption("Surat Jalan"); ?></td> 
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('sj_no', 100, 120); ?></td>
                                <td><?php datebox2('sj_date') ?></td>                                
                            </tr>
                            <tr>
                                <td><?php getCaption("Kwitansi"); ?></td>  
                                <td class="td-ro">:</td>
                                <td width="60"><?php textbox2('kwit_no', 100, 120); ?></td>
                                <td><?php datebox2('kwit_date'); ?></td>    
                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td valign="top"  class="checkboxValign"><?php getCaption('Nama di Kwitansi dari'); ?> </td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td colspan="2">                             
                                    <div>
                                        <table class="checkboxBorder" width="170">
                                            <tr><td><a href="#" class="checkbox" name="kwit_data_1"><input type="radio" id="kwit_data_1" class="kwit_data_1 kwit_data" name="kwit_data" value="1"> <?php getCaption("Data Pelanggan"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="kwit_data_2"><input type="radio" id="kwit_data_2" class="kwit_data_2 kwit_data" name="kwit_data" value="2"> <?php getCaption("Data di STNK"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="kwit_data_3"><input type="radio" id="kwit_data_3" class="kwit_data_3 kwit_data" name="kwit_data" value="3"> <?php getCaption("Data Leasing/Debitur"); ?></a></td></tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                        </table>  
                    </td>

                    <td valign="top">
                        <table>
                            <tr><td></td> <td class="td-ro"></td><td><?php getCaption("Nomor"); ?></td><td><?php getCaption("Tanggal"); ?></td></tr>
                            <tr>
                                <td><?php getCaption("Faktur Pajak"); ?></td> 
                                <td class="td-ro">:</td>
                                <td width="80"><?php textbox2('fp_no', 250, 150); ?></td>
                                <td><?php datebox2('fp_date'); ?></td>

                            </tr>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption('Nama di Faktur Pajak Dari'); ?> </td>
                                <td valign="top"  class="checkboxValign td-ro">:</td>
                                <td colspan="2">      
                              
                                        <table class="checkboxBorder" width="170">
                                            <tr><td><a href="#" class="checkbox" name="fp_data_1"><input type="radio" id="fp_data_1" class="fp_data_1 fp_data" name="fp_data" value="1"> <?php getCaption("Data Pelanggan"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="fp_data_2"><input type="radio" id="fp_data_2" class="fp_data_2 fp_data" name="fp_data" value="2"> <?php getCaption("Data di STNK"); ?></a></td></tr>

                                            <tr><td><a href="#" class="checkbox" name="fp_data_3"><input type="radio" id="fp_data_3" class="fp_data_3 fp_data" name="fp_data" value="3"> <?php getCaption("Data Leasing/Debitur"); ?></a></td></tr>
                                        </table>
                                 
                                </td>
                            </tr>
                        </table>
                    </td>

                </table>	
            </div>

            <div title="<?php getCaption("Optional"); ?>" class="main-tab">

                <table id="dt_jasa" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"></table>
                <br />
                <table class="table" style="margin-left: 740px;">
                    <td style="padding:0px 10px;">
                        <table class="table" style="margin:0px 0px 10px 0px;">
                            <?php
                            numberbox('srv_price', 'Total Harga Netto', 200, 70);
                            numberbox('srv_disc', 'Discount', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>-</b></td></tr>
                            <?php
                            numberbox('srv_bt', 'DPP', 200, 70);
                            numberbox('srv_vat', 'PPN', 200, 70);
                            ?>
                            <tr><td></td><td class='td-ro'></td><td style="text-align:right;"><hr /></td><td><b>+</b></td></tr>
                            <?php
                            numberbox('srv_at2', 'Total Jasa', 200, 70);
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
                                <td>
                                    <button type="button" id="cmdOptional"  class="easyui-linkbutton"  onclick="cmdOptionals()" disabled="true" data-options="iconCls:'icon-optional'">Optional</button>
                                </td>
                                <td  style="border-top:0px !important;">
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
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

            <table class="table">
                <tr>
                    <td>
                        <table class="table">
                            <tr>
                                <td><b><?php getCaption("Kode Pekerjaan"); ?></b></td>
                                <td><b><?php getCaption("Nama Pekerjaan"); ?> </b></td>
                                <td class="right"><b><?php getCaption("Harga Jual"); ?></b></td>
                                <td class="right"><b><?php //getCaption("Diskon");  ?>Disc(%)</b></td>
                                <td class="right"><b><?php getCaption("Jumlah Diskon"); ?></b></td>
                                <td class="right"><b><?php getCaption("Harga Netto"); ?></b></td>
                            </tr>
                            <tr>
                                <td><table><?php acc_wkcd('wk_code', '', $site_url); ?></td>
                                <!--<td><input id="wk_code" name="wk_code" style="width:120px" class="easyui-combogrid" autocomplete="off" disabled="true"></input></td>-->
                                <td><?php textbox2('wk_desc', 350, 17); ?></td>
                                <td><?php numberbox2('price_bd', 120, 200) ?></td>
                                <td><?php numberbox2('disc_pct', 120, 200) ?></td>
                                <td><?php numberbox2('disc_val', 120, 200) ?></td>
                                <td><?php numberbox2('price_ad', 100, 200) ?></td>                       
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
                                    <button type="button" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="$('#optionalWindow').window('close');"></button>
                                </td>

                            </tr>
                        </table>  </td>       
                </tr>
            </table>
        </form>
    </div>
</div>
<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("Faktur Retur"); ?>:</span>
            <input id="rsl_inv_no" name="rsl_inv_no">
            <span><?php getCaption("No. Faktur Jual"); ?>:</span>
            <input id="sal_inv_no" name="sal_inv_no" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<?php include 'retur_penjualan_fn.php'; ?>