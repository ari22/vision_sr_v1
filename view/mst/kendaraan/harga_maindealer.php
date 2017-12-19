<div style=" margin: 10px;" id="form_content">
    <form id="form_validation" method="post" action="">	

        <input type="hidden" name="id"  id="id">
        <input type="hidden" name="table"  id="table" value="<?php echo 'veh_prc'; ?>">
        <div class="single-form teen-margin">
            <table>
                <tr>
                    <?php
                    $opttrans = array
                        (
                        array("AT", "1"),
                        array("MT", "2"),
                        array("", "3"),
                    );

                    $optinstf = array
                        (
                        array("Tidak ada Insentif", "1"),
                        array("Memakai Point", "2"),
                        array("Secara presentase", "3"),
                        array("Kombinasi point & presentase", "4"),
                        array("", "5"),
                    );
                    ?>
                    <td valign="top" width="300">
                        <table>
                            <?php
                            cmdColorType('col_type', 'Nama Tipe Warna');
                            textbox('veh_type', 'Tipe', 100, 15);
                            cmdTransm('veh_transm', 'Transmisi');
                            textbox('chas_pref', 'Chassis', 150, 13);
                            textbox('eng_pref', 'Engine', 150, 10);
                            ?>

                            <input type="hidden" name="prc_code" id="prc_code">
                            <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                    <td width="250" valign="top">
                        <table>
                            <?php
                            cmdVeh('veh_code', 'Kode Kendaraan', 0, 0);
                            textbox('veh_brand', 'Merek', 90, 15);
                            textbox('veh_model', 'Model', 90, 15);
                            textbox('veh_year', 'Tahun', 60, 4);
                            ?>

                        </table>
                    </td>
                    <td valign="top">
                        <table>
                            <?php
                            datebox('act_date', 'Tgl. Aktif', 100);
                            datebox('exp_date', 'Tgl. Non Aktif', 100);
                            ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td><?php getCaption('Deskripsi'); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php textbox2('veh_name', 380, 35); ?></td>
                            </tr>
                            <tr><td class="col120"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>

        <div class="single-form">
            <table>
                <tr>
                    <td valign="top">
                        <table>
                            <tr>
                                <td width="130"></td>
                                <td class="td-ro"></td>
                                <td style="text-align: right;"><b><?php getCaption("Base Price"); ?> </b></td>
                                <td class="space2"></td>
                                <td style="text-align: right;"><b><?php getCaption("Optional"); ?> </b></td>
                                <td class="space2"></td>
                                <td style="text-align: right;"><b><?php getCaption("Pembelian"); ?> </b></td>
                                <td class="space3"></td>
                                <td style="text-align: right;"><b><?php getCaption("Penjualan"); ?> (End User)</b></td>
                                <td class="space2"></td>
                                <td style="text-align: right;"><b>Movement(Dealer)</b></td>
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("Base Price"); ?></td>
                                <td class="td-ro">:</td>
                                <td><input onkeyup="sumBasePrice()" autocomplete="off" onkeydown="validateNumber(event);" name="purb_price" id="purb_price" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                <td class="space2"></td>
                                <td><input onkeyup="sumOptPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="puro_price" id="puro_price" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_bt', 130, 130);?></td>
                                <td class="space3"></td>
                                <td><?php numberbox2('salb_price', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><input onkeyup="movPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pr2b_price" id="pr2b_price" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                         
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("Optional"); ?> </td>
                                <td class="td-ro">:</td>
                                <td colspan="8"></td>
                                <td><input onkeyup="movPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pr2o_price" id="pr2o_price" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                          
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("PPN"); ?></td>
                                <td class="td-ro">:</td>
                                <td><?php numberbox2('pur_vat1', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_vat2', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_vat', 130, 130);?></td>
                                <td class="space3"></td>
                                <td><?php numberbox2('sal_vat', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pr2_vat', 130, 130);?></td>                            
                            </tr>
                            
                             <tr>
                                <td><?php getCaption("PBM"); ?></td>
                                <td class="td-ro">:</td>
                                <td><input onkeyup="sumBasePrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pur_pbm1" id="pur_pbm1" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>          
                                <td class="space2"></td>
                                <td><input onkeyup="sumOptPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pur_pbm2" id="pur_pbm2" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_pbm', 130, 130);?></td>
                                <td class="space3"></td>
                                <td><input onkeyup="minPrice()" autocomplete="off" onkeydown="validateNumber(event);" id="sal_pbm" name="sal_pbm" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                   
                                <td class="space2"></td>
                                <td><input onkeyup="movPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pr2_pbm" id="pr2_pbm" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                                                     
                            </tr>
                            
                             <tr>
                                <td><?php getCaption("PPH"); ?></td>
                                <td class="td-ro">:</td>
                                <td><input onkeyup="sumBasePrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pur_pph1" id="pur_pph1" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>          
                                <td class="space2"></td>
                                <td></td>
                                <td class="space2"></td>
                                <td><input onkeyup="pphPurPrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pur_pph" id="pur_pph" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>          
                                <td class="space3"></td>
                                <td></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pr2_pph', 130, 130);?></td>                            
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("BBN"); ?> </td>
                                <td class="td-ro">:</td>
                                <td colspan="6"></td>
                                <td><input onkeyup="minPrice()" autocomplete="off" onkeydown="validateNumber(event);" id="sal_bbn" name="sal_bbn" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>   
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("Lain - lain"); ?></td>
                                <td class="td-ro">:</td>
                                <td><input onkeyup="sumBasePrice()" autocomplete="off" onkeydown="validateNumber(event);" name="pur_misc1" id="pur_misc1" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>          
                                <td class="space2"></td>
                                <td><input onkeyup="sumOptPrice()"  autocomplete="off" onkeydown="validateNumber(event);" name="pur_misc2" id="pur_misc2" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_misc', 130, 130);?></td>
                                <td class="space3"></td>
                                <td><input onkeyup="minPrice()"  autocomplete="off" onkeydown="validateNumber(event);" id="sal_misc" name="sal_misc" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                      
                                <td class="space2"></td>
                                <td><input onkeyup="movPrice()"  autocomplete="off" onkeydown="validateNumber(event);" name="pr2_misc" id="pr2_misc" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                                                   
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("Harga Total"); ?></td>
                                <td class="td-ro">:</td>
                                 <td><?php numberbox2('pur_price1', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_price2', 130, 130);?></td>
                                <td class="space2"></td>
                                <td><?php numberbox2('pur_price', 130, 130);?></td>
                                <td class="space3"></td>
                                 <td><input onkeyup="minPrice()"  autocomplete="off" onkeydown="validateNumber(event);" id="sal_price" name="sal_price" class="easyui-numberbox pricenumber" data-options="precision:0,groupSeparator:',',decimalSeparator:'.'" disabled="true" style="width:130px;"></input></td>                       
                                <td class="space2"></td>
                                <td><?php numberbox2('pr2_price', 130, 130);?></td>                            
                            </tr>
                            
                            <tr>
                                <td><?php getCaption("Catatan"); ?> </td>
                                <td class="td-ro">:</td>
                                <td colspan="5">
                                    <input type="text" name="note" id="note" disabled="true" style="width:437px;">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td><br /></td></tr>
                <tr>
                    <td valign="top">
                        <table> 
                            
                            <tr>
                                <td width="130"></td>
                                <td class="td-ro"></td>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td valign="top"><b><?php getCaption("Perhitungan Insentif"); ?></b></td>
                                        </tr>
                                        <tr>                           
                                            <td>  
                                                <table  class="checkboxBorder" style="width: 280px;">
                                                    <tr><td><a href="#" class="checkbox" name="sal_inctyp_1"><input type="radio" id="sal_inctyp_1" class="sal_inctyp_1"  name="sal_inctyp" value="1" disabled="true"> <?php getCaption("Tidak Ada Insentif"); ?></a></td></tr>

                                                    <tr><td><a href="#" class="checkbox" name="sal_inctyp_2"><input type="radio" id="sal_inctyp_2" class="sal_inctyp_2" name="sal_inctyp" value="2" disabled="true"> <?php getCaption("Memakai Poin"); ?></a></td></tr>

                                                    <tr><td><a href="#" class="checkbox" name="sal_inctyp_3"><input type="radio" id="sal_inctyp_3" class="sal_inctyp_3" name="sal_inctyp" value="3" disabled="true"> <?php getCaption("Secara Persentase"); ?></a></td></tr>

                                                    <tr><td><a href="#" class="checkbox" name="sal_inctyp_4"><input type="radio" id="sal_inctyp_4" class="sal_inctyp_4" name="sal_inctyp" value="4" disabled="true"> <?php getCaption("Kombinasi Point & Persentase"); ?></a></td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            
                                <td valign="top">
                                    <table style="">
                                        <tr>
                                            <td><b><?php getCaption("Nilai Insentif Penjualan"); ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table class="checkboxBorder">
                                                    <tr>
                                                        <td><?php getCaption('Jumlah Point'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php numberbox2('sal_incpnt', 80, 100); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php getCaption('Persentase'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php numberbox2('sal_incpct', 80, 100); ?> %</td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="space"></td>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td><b>Term of Payment(TOP)</b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td><?php getCaption('Pembelian'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php numberbox2('topp_day', 40, 100); ?> <?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php getCaption('Penjualan'); ?></td>
                                                        <td class="td-ro">:</td>
                                                        <td><?php numberbox2('tops_day', 40, 100); ?> <?php getCaption("Hari"); ?></td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                 <td class="space"></td>
                                <td valign="top">
                                    <table>
                                        <tr>
                                            <td><b><?php getCaption("Terhitung Sejak"); ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" disabled="true" name="topp_since" id="topp_since" style="width:120px;">
                                                    <option value="0"></option>
                                                    <option value="1"><?php getCaption("Order"); ?></option>
                                                    <option value="2"><?php getCaption("Penerimaan"); ?></option>
                                                    <option value="3"><?php getCaption("Pembelian"); ?></option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select class="easyui-combobox" disabled="true" name="tops_since" id="tops_since" style="width:120px;">
                                                    <option value="0"></option>
                                                    <option value="1"><?php getCaption("Surat Jalan"); ?></option>
                                                    <option value="2">Sales Invoice</option>
                                                </select>
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

        <div class="main-nav">
            <table width="100%">
                <tr>
                    <td> <?php navigation_ci(); ?></td>
                    <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td>
                </tr>
            </table>          
        </div>
    </form>
</div>

<div id="SearchOption" style="display:none;">  
    <form id="form_validation2" method="post" >    
        <div style="padding:10px;">
            <span><?php getCaption("Kode Kendaraan"); ?>:</span>
            <input id="code" name="code">
            <span><?php getCaption("Warna"); ?>:</span>
            <input id="color" name="color" >
            <a href="#" class="easyui-linkbutton" onclick="doSearch()" iconCls="icon-search">Search</a>
            <button type="button"  title="<?php getCaption("Ok"); ?>" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" >Ok </button>
            <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" onclick="close_search();">Cancel</button>

        </div>

    </form>
</div>

<style>
     .space2{width: 15px !important;}
     .space3{width: 100px !important;}
</style>
<script>

    $(document).ready(function () {
        read_show('');
         version('01.04-17');
    });

    var table = 'veh_prc';
    var pk = 'veh_code';
    var sk = 'veh_name';

    var pk_name = '<?php getCaption("Kode Kendaraan"); ?>';
    var sk_name = '<?php getCaption("Tipe"); ?> <?php getCaption("Warna"); ?>';
        
        $('#form_validation #veh_code').combogrid({
            onSelect: function (index, row) {

                $("#form_validation #veh_type").val(row.veh_type);
                $("#form_validation #veh_transm").combogrid('setValue', row.veh_transm);
                $("#form_validation #chas_pref").val(row.chas_pref);
                $("#form_validation #eng_pref").val(row.eng_pref);
                $("#form_validation #veh_name").val(row.veh_name);
                $("#form_validation #veh_brand").val(row.veh_brand);
                $("#form_validation #veh_model").val(row.veh_model);
                $("#form_validation #veh_year").val(row.veh_year);

                code_price();

            }
        });
        function doSearch() {
            $("#tableSearch").datagrid('load', {
                field1: $('#code').val(),
                field2: $('#name').val()
            });
        }
        function getSearchselect() {
            var row = $("#tableSearch").datagrid('getSelected');

            if (row) {
                $("#form_validation #id").val(row.id);
                $('#windowSearch').window('close');
                $("#actionSearch").empty()
                $("#SearchOption").hide();
                read_show('');

            }
        }
        function close_search() {
            $('#windowSearch').window('close');
            $("#actionSearch").empty()
            $("#SearchOption").hide();
        }

   

        function parsePrice(number) {
            return Number(number.replace(/[^0-9\.]+/g, ""));
        }
       
        function sumBasePrice(){
            purb_price = $("#form_validation #purb_price").val();
            pur_vat1 = (parsePrice(purb_price) / 100) * 10;
            
            pur_pbm1 = $("#form_validation #pur_pbm1").val();
            pur_pph1 = $("#form_validation #pur_pph1").val();
            pur_misc1 = $("#form_validation #pur_misc1").val();
            
            pur_price1 = parsePrice(purb_price) + pur_vat1 + parsePrice(pur_pbm1) + parsePrice(pur_pph1) + parsePrice(pur_misc1);

            $('#form_validation #pur_vat1').numberbox('setValue', pur_vat1);
            $('#form_validation #pur_price1').numberbox('setValue', pur_price1);
            
            purPriceRow();
        }
        
        function sumOptPrice(){
            puro_price = $("#form_validation #puro_price").val();
            pur_vat2 = (parsePrice(puro_price) / 100) * 10;
            pur_pbm2 = $("#form_validation #pur_pbm2").val();
            pur_misc2 = $("#form_validation #pur_misc2").val();
            
            pur_price2 = parsePrice(puro_price) + pur_vat2 + parsePrice(pur_pbm2) + parsePrice(pur_misc2);

            $('#form_validation #pur_vat2').numberbox('setValue', pur_vat2);
            $('#form_validation #pur_price2').numberbox('setValue', pur_price2);
            
            purPriceRow();
        }
        function purPriceRow(){
            /*Price*/
            purb_price = $("#form_validation #purb_price").val();
            puro_price = $("#form_validation #puro_price").val();
            
            pur_bt = parsePrice(purb_price) + parsePrice(puro_price);
            
            $('#form_validation #pur_bt').numberbox('setValue', pur_bt);
            /*ppn*/
            pur_vat1 = (parsePrice(purb_price) / 100) * 10;
            pur_vat2 = (parsePrice(puro_price) / 100) * 10;
            
            pur_vat = pur_vat1 + pur_vat2;
            
            $('#form_validation #pur_vat').numberbox('setValue', pur_vat);
            /*pbm*/
            pur_pbm1 = $("#form_validation #pur_pbm1").val();
            pur_pbm2 = $("#form_validation #pur_pbm2").val();
            
            pur_pbm = parsePrice(pur_pbm1) + parsePrice(pur_pbm2);
            $('#form_validation #pur_pbm').numberbox('setValue', pur_pbm);
            
            pur_pph = $("#form_validation #pur_pph1").val();
            $('#form_validation #pur_pph').numberbox('setValue', pur_pph);
            
            pur_misc1 = $("#form_validation #pur_misc1").val();
            pur_misc2 = $("#form_validation #pur_misc2").val();
            pur_misc = parsePrice(pur_misc1) + parsePrice(pur_misc2);
            
            $('#form_validation #pur_misc').numberbox('setValue', pur_misc);
             
            purPrice();
        }
        
        function pphPurPrice(){
             pur_pph = $("#form_validation #pur_pph").val();
             $("#form_validation #pur_pph1").val(pur_pph);
             
             sumBasePrice();
        }
        function purPrice(){
             pur_bt = $("#form_validation #pur_bt").val();
             pur_vat = $("#form_validation #pur_vat").val();
             pur_pbm = $("#form_validation #pur_pbm").val();
             pur_pph = $("#form_validation #pur_pph").val();
             pur_misc = $("#form_validation #pur_misc").val();
             
             pur_price = parsePrice(pur_bt) + parsePrice(pur_vat) + parsePrice(pur_pbm) + parsePrice(pur_pph) + parsePrice(pur_misc);
             
             $('#form_validation #pur_price').numberbox('setValue', pur_price);
        }
        
        function movPrice(){
            pr2b_price = $("#form_validation #pr2b_price").val();
            pr2o_price = $("#form_validation #pr2o_price").val();
            
            pr2_vat = ((parsePrice(pr2b_price)+ parsePrice(pr2o_price)) / 100) * 10;
            
            pr2_pbm = $("#form_validation #pr2_pbm").val();
            pr2_pph = $("#form_validation #pr2_pph").val();
            pr2_misc = $("#form_validation #pr2_misc").val();
            
            pr2_price = parsePrice(pr2b_price) + parsePrice(pr2o_price) + pr2_vat + parsePrice(pr2_pbm) + parsePrice(pr2_pph) + parsePrice(pr2_misc);

            $('#form_validation #pr2_vat').numberbox('setValue', pr2_vat);
            $('#form_validation #pr2_price').numberbox('setValue', pr2_price);
        }
        
        function minPrice() {
            sal_pbm = parsePrice($("#form_validation #sal_pbm").val());
            sal_bbn = parsePrice($("#form_validation #sal_bbn").val());
            sal_misc = parsePrice($("#form_validation #sal_misc").val());
            sal_price = parsePrice($("#form_validation #sal_price").val());

            price = (sal_price - (sal_pbm + sal_bbn + sal_misc)) / 1.1;
            ppn = price * 0.1;
            //alert(price)
            $('#form_validation #salb_price').numberbox('setValue', price);
            $('#form_validation #sal_vat').numberbox('setValue', ppn);

        }
        function read_show(nav) {
            var id = $("#form_validation #id").val();

            $.post(site_url + 'master/vehicle/read', {table: table, nav: nav, id: id}, function (json) { //alert(json)        

                $('#form_validation input:text').val('');
                $('#form_validation textarea').val('');
                $('#form_validation .easyui-combogrid').combogrid('setValue', '');
                $("#form_validation input:radio").prop("checked", false);
                $(".easyui-datebox").datebox('setValue', '');
                $('#form_validation .easyui-combobox').combobox('setValue', '');

                if (json !== '[]') {
                    $("#form_validation input:radio").prop("checked", false);
                    var rowData = $.parseJSON(json);

                    $.each(rowData, function (i, v) {
                        $("#form_validation #" + i).val(v);

                        
                        
                        if(
                               i == 'purb_price' 
                                || i == 'puro_price'
                                || i == 'pur_bt'
                                || i == 'salb_price'
                                || i == 'pr2b_price'
                                || i == 'pr2o_price'
                                || i == 'pur_vat1'
                                || i == 'pur_vat2'
                                || i == 'pur_vat'
                                || i == 'sal_vat'
                                || i == 'pr2_vat'
                                || i == 'pur_pbm1'
                                || i == 'pur_pbm2'
                                || i == 'pur_pbm'
                                || i == 'sal_pbm'
                                || i == 'pr2_pbm'
                                || i == 'pur_pph1'
                                || i == 'pur_pph'
                                || i == 'pr2_pph'
                                || i == 'sal_bbn'
                                || i == 'pur_misc1'
                                || i == 'pur_misc2'
                                || i == 'pur_misc'
                                || i == 'sal_misc'
                                || i == 'pr2_misc'
                                || i == 'pur_price1'
                                || i == 'pur_price2'
                                || i == 'pur_price'
                                || i == 'sal_price'
                                || i == 'pr2_price' 
                                || i == 'sal_incpnt' 
                                || i == 'sal_incpct' 
                                || i == 'topp_day' 
                                || i == 'tops_day'){
                                     $("#" + i).numberbox('setValue', v);
                                }
                                
                        if (i == 'col_type' || i == 'veh_transm' || i == 'veh_code') {
                            $("#" + i).combogrid('setValue', v);
                        }
                        if (i == 'topp_since' || i == 'tops_since') {
                            $("#" + i).combobox('setValue', v);
                        }

                        if (i == 'act_date' || i == 'exp_date') {
                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);

                                $("#" + i).datebox('setValue', vdate);
                            }
                        }

                        if (i == 'tops_since' || i == 'topp_since') {
                            $("#" + i).combobox('setValue', v);
                        }
                    });


                    $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);
                     cmdcondAwal();
                        formDisabled();
                }else {
                    cmdcondAwal();
                    cmdEmptyData();
                }
                $('.loader').hide();

            });
        }

        function formDisabled() {
            $('#form_validation :input').attr('disabled', true);
            $('#form_validation .easyui-combogrid').combogrid('disable');
            $('#form_validation .easyui-combobox').combobox('disable');
            $(".easyui-datebox").datebox('disable');
            cmdcondAwal();

        }
        function saveData() {
            $('.loader').show();

            var url = site_url + 'master/vehicle/save_vehicle';

            $('#form_validation :input').attr('disabled', false);
            $('#form_validation').form('submit', {
                url: url,
                onSubmit: function () {
                    return $(this).form('validate');
                },
                success: function (data) {  

                    var obj = JSON.parse(data);
                    if (obj.success == true) {
                        showAlert("Information", obj.message);

                        read_show('');
                        // $('#dt').datagrid('reload');
                    } else
                    {
                        $('.loader').hide();
                        condReady();
                        showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');

                    }
                }
            });
        }
        function cmdcondAwal() {
            $('#cmdFirst').removeAttr('disabled');
            $('#cmdPrev').removeAttr('disabled');
            $('#cmdNext').removeAttr('disabled');
            $('#cmdLast').removeAttr('disabled');
            $('#cmdSave').attr('disabled', true);
            $('#cmdCancel').attr('disabled', true);
            $('#cmdAdd').removeAttr('disabled');
            $('#cmdEdit').removeAttr('disabled');
            $('#cmdDelete').removeAttr('disabled');
            $('#cmdSearch').removeAttr('disabled');



            $('.cmdFirst').linkbutton('enable');
            $('.cmdPrev').linkbutton('enable');
            $('.cmdNext').linkbutton('enable');
            $('.cmdLast').linkbutton('enable');
            $('.cmdSave').linkbutton('disable');
            $('.cmdCancel').linkbutton('disable');
            $('.cmdAdd').linkbutton('enable');
            $('.cmdEdit').linkbutton('enable');
            $('.cmdDelete').linkbutton('enable');
            $('.cmdSearch').linkbutton('enable');
        }

        function condReady() {

            $('#form_validation :input').attr('disabled', false);
            $("#form_validation .easyui-datebox").datebox('enable');

            $('#form_validation .easyui-combogrid').combogrid('enable');
            $('#form_validation .easyui-combobox').combobox('enable');


            $("#form_validation #veh_type").attr('disabled', true);
            $("#form_validation #veh_transm").combogrid('disable');
            $("#form_validation #chas_pref").attr('disabled', true);
            $("#form_validation #eng_pref").attr('disabled', true);
            $("#form_validation #veh_name").attr('disabled', true);
            $("#form_validation #veh_brand").attr('disabled', true);
            $("#form_validation #veh_model").attr('disabled', true);
            $("#form_validation #veh_year").attr('disabled', true);
           
            $("#form_validation #pur_bt, #salb_price, #pur_vat1, #pur_vat2, #pur_vat, #sal_vat, #pr2_vat, #pur_pbm, #pr2_pph, #pur_misc, #pur_price1, #pur_price2, #pur_price, #pr2_price").attr('disabled', true);
            $("#form_validation #salb_price").attr('disabled', true);
            $("#form_validation #sal_vat").attr('disabled', true);          
            $("#form_validation #pur_price").attr('disabled', true);

            checkboxClick();
            cmdcondReady();
        }

        function cmdcondReady() {
            //$("#cmdSave").show();
            //$("#cmdCancel").show();
            $('#cmdFirst').attr('disabled', true);
            $('#cmdPrev').attr('disabled', true);
            $('#cmdNext').attr('disabled', true);
            $('#cmdLast').attr('disabled', true);

            $('#cmdSave').removeAttr('disabled');
            $('#cmdCancel').removeAttr('disabled');
            //$("#cmdSave").removeAttr('disabled');
            //$("#cmdCancel").removeAttr('disabled');
            $('#cmdAdd').attr('disabled', true);
            $('#cmdEdit').attr('disabled', true);
            $('#cmdDelete').attr('disabled', true);
            $('#cmdSearch').attr('disabled', true);


            $('.cmdFirst').linkbutton('disable');
            $('.cmdPrev').linkbutton('disable');
            $('.cmdNext').linkbutton('disable');
            $('.cmdLast').linkbutton('disable');

            $('.cmdSave').linkbutton('enable');
            $('.cmdCancel').linkbutton('enable');

            $('.cmdAdd').linkbutton('disable');
            $('.cmdEdit').linkbutton('disable');
            $('.cmdDelete').linkbutton('disable');
            $('.cmdSearch').linkbutton('disable');
        }

        function condAdd() {
            $('#form_validation .easyui-combogrid').combogrid('setValue', '');
           $("#form_validation #col_type").combogrid('enable');
           $("#form_validation #veh_code").combogrid('enable');
           $('#form_validation #id').val('');
           $('#form_validation input:text').val('');
           $("#table").val(table);

            $("#form_validation input:radio").prop("checked", false);
            cmdcondReady();
        }

        $('#form_validation #col_type').combogrid({
            onSelect: function (index, row) {
                condReady();
                code_price();
            }
        });

        function code_price() {
            var type = $('#form_validation #col_type').combogrid('getValue');
            var code = $('#form_validation #veh_code').combogrid('getValue');
            var code_price = code + ' ' + type;

            $("#form_validation #prc_code").val(code_price);
        }
        function condEdit() {
            cmdcondReady();
            condReady();
            $("#form_validation #veh_code").attr('disabled', true);
            $('#form_validation #col_type').focus();
        }
        function condDelete() {
            var id = $("#id").val();
            var table = $("#table").val();

            $.messager.confirm('Warning', 'Are you sure delete selected data ?', function (r) {
                if (r) {

                    var url = site_url + 'master/vehicle/delete';

                    $('.loader').show();

                    $.post(url, {table: table, id: id}, function (data) {//alert(data)
                        var obj = JSON.parse(data);
                        if (obj.success == true) {
                            $("#id").val('');
                            showAlert("Information", obj.message);
                            cmdcondAwal();
                            read_show('');
                        } else
                        {
                            $('.loader').hide();
                            showAlert("Error while delete", '<font color="red">' + obj.message + '</font>');
                        }
                    });

                }
            });
        }
        function condCancel() {
            cmdcondAwal();
            read_show('');
           
        }

</script>