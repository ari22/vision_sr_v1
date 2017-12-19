<?php
$key = searcharray('VSL', 'inv_type', $inv_seq);
$remark = $inv_seq[$key]['remark'];
?>
<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" >
        <div id="tableId"></div>
        <table class="main-form">
            <tr>
                <td valign="top">
                    <table>
                        <?php textbox('inv_type', 'Jenis Faktur', 250, 250); ?>
                        <tr><td colspan="3"></td></tr>
                        <?php textbox('chassis', 'Chassis', 200, 70); ?>
                        <tr><td class="col80"></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <tr>
                            <td width="120"><?php getCaption('Warehouse'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td width="163"><table class='marginmin'><?php cmdWrhs('wrhs_code', '', 142); ?></table></td>
                                        <td width="80"><?php getCaption('Tgl Closed'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('cls_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="120"><?php getCaption('No. Faktur'); ?></td>
                            <td class="td-ro">:</td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td width="163"> <?php textbox2('sal_inv_no', 142, 100); ?></td>
                                        <td width="80"><?php getCaption('Tgl. Faktur'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('sal_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td>
                                <table class='marginmin'>
                                    <tr>
                                        <td width="163"> </td>
                                        <td width="80"><?php getCaption('Tgl. Pick'); ?></td>
                                        <td class="td-ro">:</td>
                                        <td><?php datebox2('pick_date'); ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php textbox('note', 'keterangan', 350, 70); ?>
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

            <div title="<?php getCaption('Pengajuan Aplikasi Kredit'); ?>"   class="main-tab">
                <table>
                    <tr>
                        <td valign="top" width="450">
                            <h3><?php getCaption('Pengajuan Aplikasi Kredit'); ?></h3>
                            <table class="marginmin">
                                <?php cmdLeaseSet('lease_code', 'lease_name', 'Leasing'); ?>
                                <?php textarea('lease_addr', 'Alamat', 250); ?>
                                <?php cmdCity('lease_city', 'Kota'); ?>
                                <?php textbox('lease_zipc', 'Kode Pos', 80, 5); ?>
                                <?php phonebox('lcp1_name', 'Hubungi', 150); ?>
                                <?php textbox('lcp1_title', 'Jabatan', 150, 20); ?>
                                <?php textbox('crd_note', 'Catatan', 150, 30); ?>
                            </table>
                        </td>
                        <td valign="top" width="250">
                            <h3><?php getCaption('Kelengkapan Dokumen'); ?></h3>
                            <table>
                                <tr>
                                    <td><?php getCaption('KTP'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input type="checkbox" name="cust_id" id="cust_id" value="T" style="vertical-align: middle; margin-top: 5px;margin-bottom:3px;"></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Kartu Keluarga'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input type="checkbox" name="cust_kk" id="cust_kk" value="T" style="vertical-align: middle; margin-top: 5px;margin-bottom: 3px;"></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Buku Tabungan'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input type="checkbox" name="cust_bnkac" id="cust_bnkac" value="T" style="vertical-align: middle; margin-top: 5px;margin-bottom: 3px;"></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('SIUP'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><input type="checkbox" name="cust_siup" id="cust_siup" value="T" style="vertical-align: middle; margin-top: 5px;margin-bottom: 3px;"></td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top">
                            <h3><br /></h3>
                            <table>
                                <?php textbox('crd_via', 'Kredit Via', 150, 50); ?>
                                <?php numberbox('crd_amount', 'Jumlah Kredit', 120, 200); ?>
                                <tr>
                                    <td><?php getCaption('Lama Kredit'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td> <table class='marginmin'><tr><td><?php numberbox2('crd_term', 80, 200); ?> </td><td><?php getCaption('Bulan'); ?></td></tr></table></td>
                                </tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr>
                                    <td><?php getCaption('Bunga'); ?> / <?php getCaption('Tahun'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td> <table class='marginmin'><tr><td><?php numberbox2('crd_irate', 80, 200); ?></td><td>%</td></tr></table></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Angsuran'); ?> / <?php getCaption('Bulan'); ?></td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('crd_mthpay', 120, 200); ?></td>
                                </tr>
                                <tr>
                                    <td><?php getCaption('Uang Muka'); ?> (PO)</td>
                                    <td class="td-ro">:</td>
                                    <td><?php numberbox2('crd_dppo', 120, 200); ?></td>
                                </tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php textbox('crd_apprby', 'Disetujui', 150, 5); ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption('Persetujuan Kredit'); ?>"   class="main-tab">
                <table>
                    <tr>
                        <td width="500" valign="top">
                            <h3><?php getCaption('Persetujuan Kredit'); ?></h3>
                            <table>
                                <?php textbox('crd_cntrno', 'No. Kontrak', 150, 25); ?>
                                <?php datebox('crd_cntrdt', 'Tgl. Kontrak', 250); ?>
                                <tr><td width="132"></td><td colspan="2"></td></tr>
                            </table>
                            <h3><?php getCaption('Asuransi'); ?></h3>
                            <table>
                                <tr><td width="132"></td><td colspan="2"></td></tr>
                                <?php cmdInsurance('insr_code', 'insr_name', 'Asuransi', 100, 200); ?>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <?php numberbox('crdinscomm', 'Refund / Komisi', 120, 200); ?>
                                <?php numberbox('crdinsdisc', 'Subsidi / Discount', 120, 200); ?>
                            </table>
                        </td>
                        <td valign="top">
                            <h3>Debitor / QQ </h3>
                            <table>
                                <tr>
                                    <td>Copy From</td>
                                    <td class="td-ro">:</td>
                                    <td>
                                        <a href="#" class="easyui-linkbutton copyQQbtn"   onclick="copyQQData('cust')">Customer</a>
                                        &nbsp
                                        &nbsp
                                        <a href="#" class="easyui-linkbutton copyQQbtn"  onclick="copyQQData('stnk')">STNK</a>
                                        &nbsp
                                        &nbsp
                                        <a href="#" class="easyui-linkbutton copyQQbtn"  onclick="clearQQ()">Clear QQ</a>
                                    </td>
                                </tr>
                                <?php textbox('cust_dname', 'Nama', 170, 5); ?>
                                <?php textarea('cust_daddr', 'Alamat', 200); ?>
                                <?php cmdArea('cust_darea', 'Wilayah'); ?>
                                <?php cmdCity('cust_dcity', 'Kota'); ?>
                                <?php textbox('cust_dzipc', 'Kode Pos', 80, 5); ?>
                                <?php phonebox('cust_dphon', 'Telepon', 150); ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div title="<?php getCaption("Data Di STNK"); ?>" class="main-tab">
                <table>
                    <td valign="top" width="400">
                        <table class="marginmin">
                            <?php
                            textbox('cust_rname', 'Nama', 200, 70);
                            textarea('cust_raddr', 'Alamat', 200);
                            ?>
                            <?php
                            cmdArea('cust_rarea', 'Wilayah');
                            cmdCity('cust_rcity', 'Kota');

                            textbox('cust_rzipc', 'Kode Pos', 200, 70);
                            textbox('cust_rphon', 'Telepon', 200, 70);
                            ?>
                        </table>
                    </td>

                    <td valign="top">
                        <table>
                            <tr style="margin-top:10px !important;margin-bottom: 10px !important;">
                                <td valign="top" class="checkboxValign"><?php getCaption("Jenis Kelamin"); ?> </td>
                                <td valign="top" class="checkboxValign td-ro">:</td>
                                <td>
                                    <table class="checkboxBorder" width="100">
                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_1"><input type="radio" id="cust_rsex_1" class="cust_rsex_1 cust_rsex"  name="cust_rsex" value="1"> <?php getCaption("Pria"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_2"><input type="radio" id="cust_rsex_2" class="cust_rsex_2 cust_rsex" name="cust_rsex" value="2"> <?php getCaption("Wanita"); ?></a></td></tr>

                                        <tr><td><a href="#" class="checkbox" name="cust_rsex_3"><input type="radio" id="cust_rsex_3" class="cust_rsex_3 cust_rsex" name="cust_rsex" value="3"> <?php getCaption("Perusahaan"); ?></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td><br /></td></tr>
                            <?php
                            textbox('stnk_no', 'No. STNK', 200, 70);
                            datebox('stnk_bdate', 'Berlaku', 200);
                            datebox('stnk_edate', 'S/D', 200);
                            ?>
                            <tr><td colspan="3"></td></tr>
                            <?php textbox('veh_reg_no', 'No. Polisi', 200, 70); ?>
                        </table>
                    </td>
                </table>
            </div>

            <div title="<?php getCaption("Pelanggan"); ?>" class="main-tab">
                <table>
                    <td valign="top">
                        <table class="table">
                            <?php
                            cmdCustSet('cust_code', 'cust_name', 'Pelanggan');

                            textarea('cust_addr', 'Alamat', 200);

                            cmdArea('cust_area', 'Wilayah');
                            cmdCity('cust_city', 'Kota');

                            textbox('cust_zipc', 'Kode Pos', 200, 70);
                            textbox('cust_phone', 'Telepon', 200, 70);
                            ?>
                        </table>
                    </td>
                    <td valign="top">
                        <table class="table"  style="margin-left:65px;">
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
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
                            <tr><td></td> <td class="td-ro"></td><td></td></tr>
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
                <table class="table"  cellpadding="1" >
                    <td valign="top">
                        <table>
                            <?php
                            cmdSalSet('srep_code', 'srep_name', 'Sales');
                            textbox('srep_lev', 'Sales Level', 80, 17);
                            ?>
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
        </div>

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td width="400"> <?php navigation_ci(); ?></td>
                    <td width="200">
                        <table class="table" border="0">
                            <tr>

                                <td  style="border-top:0px !important;">
                                    <span id="closeOn"></span>
                                    <button type="button" id="print" title="<?php getCaption("print"); ?>" class="easyui-linkbutton btn btn-default" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('show');" disabled="true" >Print</button>
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

<div id="windowPrint" class="easyui-window" title="Printing Credit Application" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:550px;height:430px;padding:10px;top:1;">
    <form id="form_validation3" method="post" >
        <table class="table">
            <tr>
                <td valign="top" width="150">Print Form</td>
                <td valign="top" class="td-ro">:</td>
                <td style="border:1px solid #ccc;background: #f5f5f5;" width="300">
                    <a href="#" class="checkbox" name="type_1"><input type="radio" id="type_1" class="type_1"  name="type" value="1" checked="true"> Cover Letter / BPKB Handover</a><br />
                    <a href="#" class="checkbox" name="type_2"><input type="radio" id="type_2" class="type_2"  name="type" value="2"> AR Transfer Request</a><br />
                    <a href="#" class="checkbox" name="type_3"><input type="radio" id="type_3" class="type_3"  name="type" value="3"> Refund Transfer Request</a><br />
                    <a href="#" class="checkbox" name="type_4"><input type="radio" id="type_4" class="type_4"  name="type" value="4"> DP Invoice</a><br />
                    <a href="#" class="checkbox" name="type_5"><input type="radio" id="type_5" class="type_5"  name="type" value="5"> Credit Invoice (full payment)</a>
                </td>
            </tr>
        </table>
        <br /><br />

        <table id="typeOne" style="display:none;">
            <tr>
                <td width="150">BPKB/Invoice Finished</td>
                <td class="td-ro">:</td>
                <td><?php numberbox2('nbr', 50, 100) ?><?php textbox2('bulan', 250, 150); ?></td>
            </tr>
            <tr>
                <td width="150">Counted from</td>
                <td class="td-ro">:</td>
                <td>
                    <select class="easyui-combobox" name="sejak" style="width:305px;">
                        <option value="1">the day this letter is made</option>
                        <option value="2">STNK date</option>
                        <option value="3">STNK date (by enclosing a copy of STNK)</option>
                    </select>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td width="150"><b><?php getCaption('Signature'); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php textbox2('nama', 305, 150); ?></td>
            </tr>
            <tr>
                <td width="150"><b><?php getCaption('Jabatan'); ?></b></td>
                <td class="td-ro">:</td>
                <td><?php textbox2('jabatan', 305, 150); ?></td>
            </tr>

        </table>

        <table id="typeTwo" style="display:none;">
            <tr>
                <td width="150"><?php getCaption('Signature'); ?></td>
                <td class="td-ro">:</td>
                <td><?php textbox2('sign', 305, 150); ?></td>
            </tr>
            <?php textbox('bank', 'Bank', 305, 150); ?>
            <?php textbox('cabang', 'Cabang', 305, 150); ?>
            <?php textbox('rek_no', 'No. Rekening', 305, 150); ?>
            <?php textbox('rek_name', 'Nama di Rekening', 305, 150); ?>
        </table>
        <div style="margin-top: 20px;">
            <table>
                <tr>
                    <td>
                        <table>
                            <tr>

                                <td  style="border-top:0px !important;">

                                    <button type="button" id="screen" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-screen'" onclick="rolesPrintScreen('screen');" disabled="true" >Screen</button>
                                    <button type="button" id="print" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintScreen('print');" disabled="true" >Print</button>
                                    <!--<button type="button" id="download" title="<?php getCaption("Download Faktur"); ?>" class="easyui-linkbutton"  data-options="iconCls:'icon-download'" onclick="rolesPrintScreen('download');" disabled="true" >Download</button>-->
                                    <button type="button" id="exit" title="<?php getCaption("Close Print"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'"  onclick="$('#windowPrint').window('close');">Quit</button>

                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
<div id="screenWindow" class="easyui-window" title="Screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<div id="SearchOption" style="display:none;">
    <form id="formSearch" method="post" >
        <div id="optionSPK" style="padding:10px;">
            <span><?php getCaption("No. Faktur Jual"); ?>:</span>
            <?php textbox2('sal_inv_no2', 150, 150); ?>
            <span><?php getCaption("Tgl. Faktur Jual"); ?>:</span>
            <input id="sal_date2"  name="sal_date2" style="width:90;"></input>

            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>
<style>
    #form_validation3 a{text-decoration:none !important;color:#000;}
    #form_validation3 a:hover{color:blue;}
</style>
<?php include 'aplikasikredit_fn.php'; ?>
