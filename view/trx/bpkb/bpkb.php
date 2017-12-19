<?php
$key = searcharray('VDM', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <div id="results"></div>

        <table class="main-form">
            <tr>
                <td valign="top">
                    <table>
                        <?php textbox('inv_type', 'Jenis Faktur', 370, 250); ?>
                        <tr>
                            <td><?php getCaption('No. Dokumen'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class="marginmin">
                                    <tr>
                                        <td width="163"><?php textbox2('doc_inv_no', 150, 150); ?></td>
                                        <td width="100"><?php getCaption('Tgl. Dokumen'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('doc_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php cmdslhBPKB('chassis', 'Chassis', $site_url, 0, 0); ?>
                         <tr><td class="col100"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <tr>
                            <td><?php getCaption('Warehouse'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class="marginmin">
                                    <tr>
                                        <td width="121"><table  class="marginmin"> <?php cmdprtWrhs('wrhs_code', ''); ?></table></td>
                                        <td width="120"><?php getCaption('Tgl Closed'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('cls_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><?php getCaption('No. Faktur Jual'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class="marginmin">
                                    <tr>
                                        <td width="121"><?php textbox2('sal_inv_no', 121, 150); ?></td>
                                        <td width="120"><?php getCaption('Tgl. Faktur Jual'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('sal_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="td-ro"></td>
                            <td>
                                <table  class="marginmin">
                                    <tr>
                                        <td width="121"></td>
                                        <td width="120"><?php getCaption('Tgl. Pick'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('pick_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php textbox('note', 'Keterangan', 349, 200) ?>
                    </table>
                </td>
            </tr>
        </table>

        <div class="easyui-tabs">
            <div title="<?php getCaption('Data Kendaraan'); ?>"  class="main-tab">	
                                <table>
                    <tr>
                        <td valign="top">
                            <table class="marginmin">
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
                                                <td><?php textbox2('chassis1', 150, 250); ?></td>
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
                                <tr><td class="col80"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                             <table>
                                <tr>
                                    <td><br /></td>                                  
                                </tr>
                                <?php
                                textbox('veh_brand', 'Merek', 150, 15);
                                textbox('veh_transm', 'Transmisi', 40, 2);
                                textbox('veh_year', 'Tahun', 40, 4);
                                
                                ?>
                                <tr><td class="col80"></td></tr>
                             </table>
                        </td>
                        <td valign="top">
                             <table>
                                <tr>
                                    <td><br /></td>                                  
                                </tr>
                                 <?php
                                textbox('alarm', 'Alarm', 100, 10);
                                textbox('key_no', 'No. Kunci', 100, 10);
                                textbox('serv_book', 'Buku Service', 100, 10);
                                ?>
                                 <tr><td class="col80"></td></tr>
                             </table>
                        </td>
                    </tr>
                    <tr><td><br /><br /></td></tr>
                    <tr>
                        <td valign="top" width="500">
                            <table class="marginmin">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td width="100"><?php getCaption("Kode"); ?></td>
                                    <td width="190"><?php getCaption("Nama"); ?></td>
                                    <td width="60"><?php getCaption("Tipe"); ?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption("Warna"); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php textbox2('color_code', 100, 150); ?></td>
                                    <td><?php textbox2('color_name', 190, 250); ?></td>
                                    <td><?php textbox2('color_type', 80, 100); ?></td>
                                </tr>

                                 <tr><td class="col80"></td></tr>
                            </table>
                        </td>
                        <td valign="top" width="280">
                            <table>
                                <tr>
                                    <td><br /></td>                                  
                                </tr>
                                <?php textbox('so_no', 'No. SPK', 100, 10); ?>
                                <?php datebox('so_date', 'Tgl. SPK', 250); ?>
                                
                                 <tr><td class="col80"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td><br /></td>                                  
                                </tr>
                                <tr>
                                    <td><?php getCaption('Jatuh Tempo'); ?>  </td>
                                    <td class="td-ro">:</td>
                                    <td colspan="6">
                                        <table class='marginmin'>
                                            <tr>
                                                <td> <?php numberbox2('due_day', 50, 150) ?></td>
                                                <td> <?php getCaption('Hari'); ?></td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                                <?php datebox('due_date', 'Tgl J. Tempo', 250); ?>
                                 <tr><td class="col80"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div title="<?php getCaption('Faktur Kendaraan'); ?>"   class="main-tab" id="FakturKendaraan">
                <table>
                    <tr>
                        <td valign="top" width="500">
                            <h3><?php getCaption('Faktur Kendaraan'); ?></h3>
                            <table>
                                <?php textbox('veh_inv_no', 'No. Faktur', 200, 200); ?>
                                <?php datebox('veh_inv_dt', 'Tgl. Faktur'); ?>
                                <?php datebox('veh_invrdt', 'Tgl. Terima'); ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php textbox('veh_invnik', 'No. Sertifikat NIK', 300, 250); ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php textbox('forma_no', 'No. Form A', 300, 250); ?>
                                <?php datebox('forma_date', 'Tgl. Form A'); ?>
                                <tr><td width="150"></td><td colspan="2"></td></tr>
                            </table>
                        </td>
                        <td valign="top">
                             <h3><?php getCaption('Pengajuan Faktur Polisi'); ?></h3>
                                <table>
                                    <?php textbox('rapp_no', 'No. Aplikasi', 120, 100); ?>
                                    <?php datebox('rapp_date', 'Tgl. Aplikasi'); ?>
                                    <?php datebox('rapp_bdate', 'Tgl. Efektif'); ?>
                                    <tr><td width="150"></td><td colspan="2"></td></tr>
                                </table>
                        </td>
                    </tr>
                </table>
                    
               
            </div>


            <div title="<?php getCaption("Data Di STNK"); ?>" class="main-tab"  id="STNKTD">
                <table class="table">
                    <td width="500" valign="top">
                        <table>
                            <?php
                            textbox('cust_rname', 'Nama', 200, 70);
                            textarea('cust_raddr', 'Alamat', 200);
                            ?>
                            <?php
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota');
                            zipbox('cust_rzipc', 'Kode Pos', 100);
                            phonebox('cust_rphon', 'Telepon', 110);
                            ?>
                            <tr>
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
            
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            <?php
                            textbox('stnk_no', 'No. STNK', 200, 70);
                            datebox('stnk_bdate', 'Berlaku', 200);
                            datebox('stnk_edate', 'S/D', 200);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('veh_reg_no', 'No. Polisi', 200, 70); ?>
                        </table>
                    </td>

                    <td valign="top">

                        <h3>STNK Management</h3>
                        <table>
                            <?php cmdAgent('agent_code', 'agent_name', 'Biro Jasa', 100, 200); ?>
                            <tr><td width="150"></td><td colspan="2"></td></tr>
                        </table>

                        <h3>STNK-Receiving Staff</h3>
                        <table>
                            <?php textbox('stnk_rname', 'Nama Penerima', 200, 200); ?>
                            <?php datebox('stnk_rdate', 'Tgl. Terima'); ?>
                            <tr><td width="150"></td><td colspan="2"></td></tr>
                        </table>

                        <h3>STNK-Receiving Customer</h3>
                        <table>
                            <?php textbox('stnk_sname', 'Nama Penerima', 200, 200); ?>
                            <?php textbox('stnk_sidno', 'No KTP', 200, 200); ?>
                            <?php datebox('stnk_sdate', 'Tgl. Terima'); ?>
                            <tr><td width="150"></td><td colspan="2"></td></tr>
                        </table>

                        <h3>STNK-Handing Staff</h3>
                        <table>
                            <?php textbox('stnk_gname', 'Nama', 200, 200); ?>
                            <?php textbox('vds_inv_no', 'No. Tanda Terima', 200, 200); ?>
                            <?php datebox('vds_date', 'Tgl. Tanda Terima'); ?>
                            <tr><td width="150"></td><td colspan="2"></td></tr>
                        </table>
                    </td>
                </table>
                <!--<button style="float:right;" type="button" id="PrintSTNK" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="printbpkbstnk('stnk');">Print STNK Receipt</button>-->
                <table style="width:150px; float:right;">
                    <tr>
                        <td  style="border-top:0px !important;">
                            <button type="button" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-screen'" onclick="printbpkbstnk('stnk','screen');">Screen</button>
                            <button type="button" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-print'" onclick="printbpkbstnk('stnk','print');">Print</button>
                            <!--<button type="button" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-download'"  onclick="printbpkbstnk('stnk','download');">Download</button>   -->                      
                        </td>
                    </tr>
                </table>   
            </div>

            <div title="<?php getCaption('BPKB'); ?>"   class="main-tab" id="BKPNdiv">
                <table>
                    <tr>
                        <td valign="top">
                            <table>
                                <tr>
                                    <td valign="top" width="450">
                                        <h3> BPKB</h3>
                                        <table>
                                            <?php textbox('cust_rname2', 'Nama Penerima', 200, 200); ?>
                                            <?php textbox('bpkb_no', 'No. BPKB', 200, 200); ?>
                                            <?php datebox('bpkb_date', 'Tgl. BPKB'); ?>
                                            <tr><td width="150"></td><td colspan="2"></td></tr>
                                        </table>
                                        <h3> BPKB-Receiving Staff</h3>
                                        <table>
                                            <?php textbox('bpkb_rname', 'Nama Penerima', 200, 200); ?>
                                            <?php datebox('bpkb_rdate', 'Tgl. Terima'); ?>
                                            <tr><td width="150"></td><td colspan="2"></td></tr>
                                        </table>
                                    </td>
                                    <td valign="top">
                                        <h3>BPKB-Receiving Customer</h3>
                                        <table>
                                            <?php textbox('bpkb_sname', 'Nama Penerima', 200, 200); ?>
                                            <?php textbox('bpkb_sidno', 'No KTP', 200, 200); ?>
                                            <?php datebox('bpkb_sdate', 'Tgl. Terima'); ?>
                                            <tr><td width="150"></td><td colspan="2"></td></tr>
                                        </table>
                                        <h3>BPKB-Handing Staff</h3>
                                        <table>
                                            <?php textbox('bpkb_gname', 'Nama', 200, 200); ?>
                                            <?php textbox('vdb_inv_no', 'No. Tanda Terima', 200, 200); ?>
                                            <?php datebox('vdb_date', 'Tgl. Tanda Terima'); ?>
                                            <tr><td width="150"></td><td colspan="2"></td></tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
                <!--<button style="float:right;" type="button" id="PrintBPKB" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="printbpkbstnk('bpkb');">Print BPKB Receipt</button>-->
                <table style="width:150px; float:right;">
                    <tr>
                        <td  style="border-top:0px !important;">
                            <button type="button" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-screen'" onclick="printbpkbstnk('bpkb','screen');">Screen</button>
                            <button type="button" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-print'" onclick="printbpkbstnk('bpkb','print');">Print</button>
                            <!--<button type="button" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton print" data-options="iconCls:'icon-download'"  onclick="printbpkbstnk('stnk','download');">Download</button>   -->                      
                        </td>
                    </tr>
                </table>   
            </div>
            <div title="<?php getCaption("Pelanggan"); ?>" class="main-tab">
                <table>						
                    <td valign="top" width="500">
                        <table>
                            <?php
                            cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                            textarea('cust_addr', 'Alamat', 200);
                            textbox('cust_area', 'Wilayah', 70, 70);
                            textbox('cust_city', 'Kota', 70, 70);
                            textbox('cust_zipc', 'Kode Pos', 200, 70);
                            textbox('cust_phone', 'Telepon', 200, 70);
                            ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table>
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
            <div title="<?php getCaption('Sales Representative'); ?>"   class="main-tab">
                <table cellpadding="1" >						
                    <td valign="top">
                        <table>
                            <?php
                            cmdSalSet('srep_code', 'srep_name', 'Sales');
                            // textbox('srep_lev', 'Sales Level', 80, 17);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <tr><td colspan="3"></td></tr>
                            
                            <tr>
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?></td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>   
                                   <table width="100" class="checkboxBorder">
                                        <tr><td><a href="#" class="checkbox" name="srep_sex_1"><input type="radio" id="srep_sex_1" class="srep_sex_1"  name="srep_sex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="srep_sex_2"><input type="radio" id="srep_sex_2" class="srep_sex_2" name="srep_sex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="srep_sex_3"><input type="radio" id="srep_sex_3" class="srep_sex_3" name="srep_sex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                   </table>
                                </td>
                            </tr>

                            <?php
                            //textboxset('sspv_code', 'sspv_name', 'Supervisor', 80, 200);
                            //textbox('sspv_lev', 'Supervisor Level', 80, 17);
                            ?>

                        </table>
                    </td>
                </table>
            </div>
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"> <?php navigation_ci(); ?></td>
                    <td width="200">
                        <table border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <span id="closeOn"></span>
                                    <button type="button" id="screen" title="<?php getCaption("screen"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('status');" disabled="true" >Status SPK</button>
                                   <!-- <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="print_sc('download');" disabled="true" >Print</button>-->
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



<div id="printBPKBSTNK" class="easyui-window" title="Print" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:350px;height:100px;padding:10px;top:1;">
    <input type="hidden" id="doc" name="doc">
    <table class="table">
        <tr>

            <td>
                <table style="width:300px;" border="0">
                    <tr>
                        <td  style="border-top:0px !important;">
                            <button type="button" id="screenFaktur" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');">Screen</button>
                            <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');">Print</button>
                            <button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  onclick="rolesPrintScreen('download');">Download</button>
                            <button type="button" id="exit" title="<?php getCaption("Close Print"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'"  onclick="$('#printBPKBSTNK').window('close');">Quit</button>

                        </td>
                    </tr>
                </table>   
            </td>
        </tr>
    </table>
</div>
<div id="SearchOption" style="display:none;">  
    <form id="formSearch" method="post" >    
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Dokumen"); ?>:</span>
            <?php textbox2('doc_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Dokumen"); ?>:</span>
            <input id="doc_date2"  name="doc_date2" style="width:90;"></input>

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<?php
include 'bpkb_fn.php';
