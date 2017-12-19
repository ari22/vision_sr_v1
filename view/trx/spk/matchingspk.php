<div style=" margin: 10px;" id="form_content">
    <div class="easyui-tabs" id="tabscoi" >

        <div title="<?php getCaption('Matching : Urut Kendaraan & Warna'); ?>" class="main-tab">
            <div>
                <div style="float:left;width: 63%; ">
                    <span style="font-weight:bold; font-size:11pt;">SPK not yet Matched with Vehicle List</span>
                </div>
                <div style="width: 31%;float:right;text-align: right;">

                    <form id="formMatch1" action="post">
                        <table>
                            <tr>
                                <td><b>Show</b></td>
                                <td>
                                    <select  id="showMacthformMatch1" name="showMacth" style="width:150px;height: 25px;" onchange="showMacthkeyword('matchsatu', 'formMatch1')">
                                        <option value="all">ALL</option>
                                        <option value="cust_name"><?php getCaption("Nama Pelanggan"); ?></option>
                                        <option value="so_no"><?php getCaption("No. SPK"); ?></option>
                                        <option value="veh_code"><?php getCaption("Kode Kendaraan"); ?></option>
                                        <option value="color_code"><?php getCaption("Kode Warna"); ?></option>
                                        <option value="veh_transm"><?php getCaption("Transmisi"); ?></option>
                                    </select>
                                </td>
                                <td id="TDkeywordformMatch1">
                                    <input class="easyui-textbox" name="keyword" id="keywordformMatch1" style="width:100px;height: 25px;">
                                </td>
                                <td id="TDbuttonSearchformMatch1">
                                    <button class="easyui-linkbutton" id="buttonSearchformMatch1" data-options="iconCls:'icon-search'"  onclick="sortirMatch('matchsatu', 'formMatch1')"></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <table id="matchsatu" class="easyui-datagrid"  title="" style="width:1080px;height:230px;"></table>

            <br>
            <div>
                <div style="float:left;width: 63%; ">
                    <span style="font-weight:bold; font-size:11pt;">Vehicle Stock List to Match with SPK Above (Sorted by Vehicle Code, Transmission, Color Code)</span>
                </div>
                <div style="width: 31%;float:right;text-align: right;">

                    <form id="formMatchStock1" action="post">
                        <table>
                            <tr>
                                <td><b>Show</b></td>
                                <td>
                                    <select  id="showMacthformMatchStock1" name="showMacthStock" style="width:150px;height: 25px;" onchange="showMacthkeywordStock('matchsatu', 'stocksatu', 'formMatchStock1')">
                                        <option value="all">ALL</option>
                                        <option value="chassis"><?php getCaption("Chassis"); ?></option>
                                        <option value="engine"><?php getCaption("Engine"); ?></option>
                                    </select>
                                </td>
                                <td id="TDkeywordformMatchStock1">
                                    <input class="easyui-textbox" name="keywordStock" id="keywordformMatchStock1" style="width:100px;height: 25px;">
                                </td>
                                <td id="TDbuttonSearchformMatchStock1">
                                    <button class="easyui-linkbutton" id="buttonSearchformMatchStock1" data-options="iconCls:'icon-search'"  onclick="sortirMatchStock('matchsatu', 'stocksatu', 'formMatchStock1')"></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <table id="stocksatu" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"
                   data-options="url:'?',rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
                   remoteSort:true,
                   multiSort:true,
                   pagination:true">
                <thead>
                    <tr>
                        <th data-options="field:'stk_date',width:100,halign:'left'", formatter='formatDate'>Stock Date</th>
                        <th data-options="field:'day',width:80,halign:'left'">Age (days)</th>
                        <th data-options="field:'po_no',width:130,align:'left'">Purchase Inv No.</th>
                        <th data-options="field:'chassis',width:170,align:'left'">Chassis No.</th>
                        <th data-options="field:'veh_code',width:120,align:'left'">Vehicle Code</th>
                        <th data-options="field:'veh_name',width:170,align:'left'">Vehicle Name</th>
                        <th data-options="field:'veh_transm',width:60,align:'left'">Trans</th>
                        <th data-options="field:'color_code',width:100,align:'left'">Color Code</th>
                        <th data-options="field:'color_name',width:170,align:'left'">Color Name</th>
                        <th data-options="field:'color_type',width:80,align:'left'">Color Type</th>
                        <th data-options="field:'veh_type',width:120,align:'left'">Vehicle Type</th>
                        <th data-options="field:'engine',width:170,align:'left'">Engine</th>
                        <th data-options="field:'veh_model',width:100,align:'left'">Model</th>
                        <th data-options="field:'veh_year',width:60,align:'left'">Year</th>
                        <th data-options="field:'veh_brand',width:120,align:'left'">Brand</th>
                        <th data-options="field:'wrhs_code',width:100,align:'left'">Warehouse</th>
                        <th data-options="field:'loc_code',width:100,align:'left'">Location</th>
                    </tr>
                </thead>
            </table>

            <br />
            <div>
                <table width="100%">
                    <tr>
                        <td width="200">
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="rolesMatch()">Match</a>
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'"  onclick="rolesPrintMatch('spk_code')">Print</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div title="<?php getCaption('Matching : Urut SPK Order'); ?>" class="main-tab">

            <div>
                <div style="float:left;width: 60%; ">
                    <span style="font-weight:bold; font-size:11pt;">SPK Not yet Matched with Vehicle List</span>
                </div>
                <div style="width: 31%;float:right;text-align: right;">
                    <form id="formMatch2" action="post">
                        <table>
                            <tr>
                                <td><b>Show</b></td>
                                <td>
                                    <select  id="showMacthformMatch2" name="showMacth" style="width:150px;height: 25px;" onchange="showMacthkeyword('matchdua', 'formMatch2')">
                                        <option value="all">ALL</option>
                                        <option value="cust_name"><?php getCaption("Nama Pelanggan"); ?></option>
                                        <option value="so_no"><?php getCaption("No. SPK"); ?></option>
                                        <option value="veh_code"><?php getCaption("Kode Kendaraan"); ?></option>
                                        <option value="color_code"><?php getCaption("Kode Warna"); ?></option>
                                        <option value="veh_transm"><?php getCaption("Transmisi"); ?></option>
                                    </select>
                                </td>
                                <td id="TDkeywordformMatch2">
                                    <input class="easyui-textbox" name="keyword" id="keywordformMatch2" style="width:100px;height: 25px;">
                                </td>
                                <td id="TDbuttonSearchformMatch2">
                                    <button class="easyui-linkbutton" id="buttonSearchformMatch2" data-options="iconCls:'icon-search'"  onclick="sortirMatch('matchdua', 'formMatch2')"></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <table id="matchdua" class="easyui-datagrid"  title="" style="width:1080px;height:230px;"></table>

            <br>
            <div>
                <div style="float:left;width: 63%; ">
                    <span style="font-weight:bold; font-size:11pt;">Vehicle Stock List to Match with SPK Above (Sorted by Vehicle Code, Transmission, Color Code)</span>
                </div>
                <div style="width: 31%;float:right;text-align: right;">

                    <form id="formMatchStock2" action="post">
                        <table>
                            <tr>
                                <td><b>Show</b></td>
                                <td>
                                    <select  id="showMacthformMatchStock2" name="showMacthStock" style="width:150px;height: 25px;" onchange="showMacthkeywordStock('matchdua', 'stockdua', 'formMatchStock2')">
                                        <option value="all">ALL</option>
                                        <option value="chassis"><?php getCaption("Chassis"); ?></option>
                                        <option value="engine"><?php getCaption("Engine"); ?></option>
                                    </select>
                                </td>
                                <td id="TDkeywordformMatchStock2">
                                    <input class="easyui-textbox" name="keywordStock" id="keywordformMatchStock2" style="width:100px;height: 25px;">
                                </td>
                                <td id="TDbuttonSearchformMatchStock2">
                                    <button class="easyui-linkbutton" id="buttonSearchformMatchStock2" data-options="iconCls:'icon-search'"  onclick="sortirMatchStock('matchdua', 'stockdua', 'formMatchStock2')"></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <table id="stockdua" class="easyui-datagrid"  title="" style="width:1080px;height:200px;"
                   data-options="rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
                   remoteSort:false,
                   multiSort:true">
                <thead>
                    <tr>
                        <th data-options="field:'stk_date',width:100,halign:'left'", formatter='formatDate'>Stock Date</th>
                        <th data-options="field:'day',width:80,halign:'left'">Age (days)</th>
                        <th data-options="field:'po_no',width:130,align:'left'">Purchase Inv No.</th>
                        <th data-options="field:'chassis',width:180,align:'left'">Chassis No.</th>
                        <th data-options="field:'veh_code',width:120,align:'left'">Vehicle Code</th>
                        <th data-options="field:'veh_name',width:200,align:'left'">Vehicle Name</th>
                        <th data-options="field:'veh_transm',width:50,align:'left'">Trans</th>
                        <th data-options="field:'color_code',width:100,align:'left'">Color Code</th>
                        <th data-options="field:'color_name',width:170,align:'left'">Color Name</th>
                        <th data-options="field:'color_type',width:80,align:'left'">Color Type</th>
                        <th data-options="field:'veh_type',width:120,align:'left'">Vehicle Type</th>
                        <th data-options="field:'engine',width:170,align:'left'">Engine</th>
                        <th data-options="field:'veh_model',width:100,align:'left'">Model</th>
                        <th data-options="field:'veh_year',width:60,align:'left'">Year</th>
                        <th data-options="field:'veh_brand',width:120,align:'left'">Brand</th>
                        <th data-options="field:'wrhs_code',width:100,align:'left'">Warehouse</th>
                        <th data-options="field:'loc_code',width:100,align:'left'">Location</th>
                    </tr>
                </thead>
            </table>


            <br />
            <div>
                <table width='100%'>
                    <tr>
                        <td width='200'>
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="rolesMatch()">Match</a>
                            <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintMatch('tgl_urut')">Print</a>
                        </td>

                    </tr>
                </table>
            </div>
        </div>


        <div title="<?php getCaption('Unmatching SPK & Stock'); ?>" class="main-tab">

            <p style="font-weight:bold; font-size:11pt;">SPK Already Matched with Vehicle Stock List</p>

            <table id="matched" class="easyui-datagrid"  title="" style="width:1080px;height:325px;"
                   data-options="url:'services/runCRUD.php?lookup=trx/spk_matching&func=read&where2=2', rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
                   remoteSort:false,
                   multiSort:true,pagination:true">
                <thead>
                    <tr>
                        <th data-options="field:'match_date',width:100,align:'left'", formatter='formatDate'>Matched</th>
                        <th data-options="field:'so_no',width:150,align:'left'">SPK No.</th>
                        <th data-options="field:'pur_inv_no',width:130,align:'left'">Purchase Inv No.</th>
                        <th data-options="field:'chassis',width:170,align:'left'">Chassis No.</th>
                        <th data-options="field:'veh_code',width:120,align:'left'">Vehicle Code</th>
                        <th data-options="field:'veh_name',width:200,align:'left'">Vehicle Name</th>
                        <th data-options="field:'veh_transm',width:50,align:'left'">Trans</th>
                        <th data-options="field:'color_code',width:100,align:'left'">Color Code</th>
                        <th data-options="field:'color_name',width:170,align:'left'">Color Name</th>
                        <th data-options="field:'color_type',width:80,align:'left'">Color Type</th>
                        <th data-options="field:'veh_type',width:120,align:'left'">Vehicle Type</th>
                        <th data-options="field:'engine',width:170,align:'left'">Engine</th>
                        <th data-options="field:'veh_model',width:100,align:'left'">Model</th>
                        <th data-options="field:'veh_year',width:60,align:'left'">Year</th>
                        <th data-options="field:'veh_brand',width:120,align:'left'">Brand</th>
                        <th data-options="field:'match_date',width:100,align:'left'", formatter='formatDate'>Match Date</th>
                        <th data-options="field:'cust_name',width:200,align:'left'">Customer Name</th>
                        <th data-options="field:'srep_name',width:200,align:'left'">Sales Name</th>
                    </tr>
                </thead>
            </table>

            </table>
            <br />
            <div>
                <td >
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="rolesUnMatch()">Un-Match</a>
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintMatch('slip')">Print Slip</a>
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintMatch('matching')">Print</a>
                </td>
            </div>
        </div>

        <div title="<?php getCaption('Stock'); ?>" class="main-tab">
            <!--<div>
                <div style="float:left;width: 63%; ">
                         </div>
                <div style="width: 31%;float:right;text-align: right;">

                    <form id="formMatchStock3" action="post">
                        <table>
                            <tr>
                                <td><b>Show</b></td>
                                <td>
                                    <select  id="showMacthformMatchStock3" name="showMacthStock" style="width:150px;height: 25px;" onchange="showMacthkeywordStock('', 'stock', 'formMatchStock3')">
                                        <option value="all">ALL</option>
                                        <option value="chassis"><?php getCaption("Chassis"); ?></option>
                                        <option value="engine"><?php getCaption("Engine"); ?></option>
                                    </select>
                                </td>
                                <td id="TDkeywordformMatchStock3">
                                    <input class="easyui-textbox" name="keywordStock" id="keywordformMatchStock3" style="width:100px;height: 25px;">
                                </td>
                                <td id="TDbuttonSearchformMatchStock3">
                                    <button class="easyui-linkbutton" id="buttonSearchformMatchStock3" data-options="iconCls:'icon-search'"  onclick="sortirMatchStock('', 'stock', 'formMatchStock3')"></button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>-->
            <table id="stock" class="easyui-datagrid"  title="" style="width:1090px;height:325px;"
                   data-options="url:'services/runCRUD.php?lookup=trx/spk_matching&func=readstock', rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
                   remoteSort:false,
                   multiSort:true,
                   pagination:true">
                <thead>
                    <tr>
                        <th data-options="field:'stk_date',width:100,halign:'left'", formatter='formatDate'><?php getCaption('Tgl. Stock'); ?></th>
                        <th data-options="field:'day',width:100,halign:'left'"><?php getCaption('Umur Stock'); ?></th>
                        <th data-options="field:'po_no',width:130,align:'left'"><?php getCaption('No Faktur Pembelian'); ?></th>
                        <th data-options="field:'chassis',width:170,align:'left'"><?php getCaption('Chassis'); ?></th>
                        <th data-options="field:'veh_code',width:120,align:'left'"><?php getCaption('Kode Kendaraan'); ?></th>
                        <th data-options="field:'veh_name',width:200,align:'left'"><?php getCaption('Nama Kendaraan'); ?></th>
                        <th data-options="field:'veh_transm',width:60,align:'left'">Trans</th>
                        <th data-options="field:'color_code',width:100,align:'left'"><?php getCaption('Kode Warna'); ?></th>
                        <th data-options="field:'color_name',width:170,align:'left'"><?php getCaption('Nama Warna'); ?>e</th>
                        <th data-options="field:'color_type',width:80,align:'left'"><?php getCaption('Tipe Warna'); ?></th>
                        <th data-options="field:'veh_type',width:100,align:'left'"><?php getCaption('Tipe Kendaraan'); ?></th>
                        <th data-options="field:'engine',width:170,align:'left'"><?php getCaption('Engine'); ?></th>
                        <th data-options="field:'veh_model',width:100,align:'left'"><?php getCaption('Model'); ?></th>
                        <th data-options="field:'veh_year',width:60,align:'left'"><?php getCaption('Tahun'); ?></th>
                        <th data-options="field:'veh_brand',width:120,align:'left'"><?php getCaption('Merek'); ?></th>
                        <th data-options="field:'wrhs_code',width:100,align:'left'"><?php getCaption('Warehouse'); ?></th>
                        <th data-options="field:'loc_code',width:100,align:'left'"><?php getCaption('Lokasi'); ?></th>
                    </tr>
                </thead>
            </table>
            <br />

            <div>
                <table>
                    <tr>
                        <td><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPrintMatch('stock')">Print</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="main-nav">
        <table width="100%">
            <tr><td align="right" width="200"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td></tr>
        </table>
    </div>
</div>

<div id="MatchPrintWindow" class="easyui-window" data-options="closable:true,minimizable:false,maximizable:true,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:430px;height:200px;padding:10px;top:100;">
    <form id='form_validation'>
        <table cellpadding="3" class="table" style="margin-top: 0px;" >
            <input type="hidden" id="codeOption" name="codeOption">
            <tr>
                <td valign="top"><b><?php getCaption("Urut Per"); ?> :</b></td>

                <td>                             
                    <a href="#" class="checkbox" name="option_1"><input type="radio" id="option_1" class="option_1"  name="option" value="1" checked="true"> <span id="spanCaption"></span></a>  <br />              
                    <a href="#" class="checkbox" name="option_2"><input type="radio" id="option_2" class="option_2" name="option" value="2"> <span id="spanCaption2"><?php getCaption("No. SPK"); ?></span></a>      <br />         
                    <a href="#" class="checkbox" name="option_3"><input type="radio" id="option_3" class="option_3" name="option" value="3"> <span id="spanCaption3"><?php getCaption("Tgl. SPK"); ?></span></a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="rolesPopPrintMatch('screen', '');">Screen</button>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPopPrintMatch('download', '');">Print</button>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-export'" id="export" onclick="rolesPopPrintMatch('export', '');">Export</button>
                    <button class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#MatchPrintWindow').window('close')">Exit</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<div id="SlipPrintWindow" title="Taking Slip from Warehouse" class="easyui-window" data-options="closable:true,minimizable:false,maximizable:true,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:350px;height:100px;padding:10px;top:100;">
    <table cellpadding="3" class="table" style="margin-top: 0px;" >           
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td><button class="easyui-linkbutton" data-options="iconCls:'icon-search'" onclick="rolesPopPrintMatch('screen', 'slip');">Screen</button></td>
            <td><button class="easyui-linkbutton" data-options="iconCls:'icon-print'" onclick="rolesPopPrintMatch('download', 'slip');">Print</button></td>
            <td><button class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="$('#SlipPrintWindow').window('close')">Exit</button></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<div id="sr" class="easyui-window" title="screen" data-options="closable:true,minimizable:false,maximizable:false,collapsible:false,closed:true,modal:true,closed:true,inline:true" style="width:1050px;height:500px;padding:10px;top:1;"></div>
<script type="text/javascript" src=<?php echo $loc_jui . "../xls/jquery.battatech.excelexport.js" ?>></script>

<?php
include 'matchingspk_fn.php';
