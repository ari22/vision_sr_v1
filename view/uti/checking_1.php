<?php
$mounth = array
    (
    array("January", "1"),
    array("February", "2"),
    array("March", "3"),
    array("April", "4"),
    array("May", "5"),
    array("June", "6"),
    array("July", "7"),
    array("August", "8"),
    array("September", "9"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);

$bulan2 = array(
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
);


$bulan = $comp['bulan'];
$tahun = $comp['tahun'];

$bln = $bulan2[$bulan-1];
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form">
        <form id="form_validation">
        <table>
            <tr>

                <td valign="top">
                    <table>
                        <tr><td><h3>Before the Invoice Checking process (Pre-Close Books) : </h3></td></tr>
                        <tr>
                            <td>* Prepare a stationery to record if any messages are displayed</td>
                        </tr>
                        <tr><td><br /></td></tr>
                        <tr><td><h3>Memo : </h3></td></tr>
                        <tr>
                            <td>
                                * This program helps user detect things like :
                                <ul class="ullist">
                                    <li><!--<a href="#" name="veh" class="checkbox">--><input type="checkbox" id="veh" value="1" checked="true">Vehicle (Vehicle Sale, PO, Receiving, Purchase, Sales Return, Purchase Return) not closed<!--</a>--></li>
                                    <li><!--<a href="#" name="acc" class="checkbox">--><input type="checkbox" id="acc" value="1"  checked="true">Accessories (Sales, Counter Sales, Purchase Order, Receiving, Purchase, Opname, Sales Return, Purchase Return, Usage, Movement) not closed<!--</a>--></li>
                                    <li><!--<a href="#" name="opt" class="checkbox">--><input type="checkbox" id="opt" value="1" checked="true">Optional (Work Order Request, Work Order, Receiving, Purchase, After-Sales) not closed <!--</a>--></li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>

                <td valign="top">
                    <table >
                        <?php localcombobox('bulan', 'bulan1', 100, $mounth); ?>
                        <?php textbox('tahun', 'Tahun', 50, 4) ?>
                    </table>
                </td>
            </tr>

            <tr>
                <td valign="top">
                    <table>
                        <tr>
                            <td>
                                <div id="bar"></div>
                                <div><table><tr><td id="log"></td><td id="statTable"></td></tr></table></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        </form>
    </div>

    <div class="main-nav">
        <table width="100%">
            <tr>
                <td width="400">
                    <a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"   onclick="buttonProcess();" >Process</a>
                </td>
                <td align="right"><img src="<?php echo $loc_jui . "themes/icons/version.png" ?>" id="version"></td> 
            </tr>
        </table>
    </div>
</div>
<div id="dlg" class="easyui-dialog" title=" Notification" data-options="iconCls:'icon-ok',closable:true,minimizable:false,maximizable:false,collapsible:false,closed:false,modal:true,closed:true,inline:true" style="width:900px;height:320px;padding:10px">
    <table id="tableDialog" style="height: 200px;"></table>
    <table style="margin-top:20px;" width="100%">
        <tr>
            <td align="right" colspan="2">
                <table>
                    <tr>
                        <td><button type="button" id="exit" title="<?php getCaption("export"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-export'" onclick="exportTable();" style="width:80px;">Export</button></td>
                        <td><button type="button" id="exit" title="<?php getCaption("ok"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" onclick="start();" style="width:80px;">Ok</button></td>
                        <td><button type="button" id="exit" title="<?php getCaption("exit"); ?>" class="easyui-linkbutton" data-options="iconCls:'icon-no'" onclick="condCancel();" style="width:80px;">Quit</button></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<style>
    #tahun{text-align: right;}
    #bar {
        width:0px;
        height:25px;
        border:1px solid #ccc;
        background-color:yellow;
        border-radius:3px;
        display: none;
    }
    .ullist{
        margin-left: -20px;
    list-style-type: none;
    }
</style>
<script>
    var url = site_url + 'utility/closebook';
    var mounth = '<?php echo $bulan; ?>';
    var year = '<?php echo $tahun; ?>';
    var tbl;
    var maxWidth = 300;
    var duration = 3000;
    var $log = $('#log');
    var $start = $('#start');
    var $stop = $('#stop');
    var timer;

    var header;
    var title = 'SPK';
    var veh;
    var acc;
    var opt;

    $(document).ready(function () {
        setVal();
        checbox();
         //checkboxClick();
        $('.loader').hide();
    });
    
    function checbox() {
        $('#form_validation input[type="checkbox"]').click(function () {
            if ($(this).prop("checked") == true) { 
                $(this).val(1);
            }
            else if ($(this).prop("checked") == false) {
                $(this).val(0);
            }
        });
    }
    function condCancel(){
        $('#bar').css("width", 0);
        $('#bar').hide();
        $("#log").empty();
        $("#statTable").empty();
        $('#dlg').window('close');
    }
    function buttonProcess() {

        $.messager.confirm('Invoice Checking Process', 'Invoice Checking Process <?php echo $bln;?> <?php echo $tahun; ?>?', function (r) {
            if (r) {
                veh = $("#veh").val();
                acc = $("#acc").val();
                opt = $("#opt").val();
                
                if(opt == '1'){
                    tbl = 'acc_woh';
                }
                if(acc == '1'){
                    tbl = 'acc_slh';
                }
                if(veh == '1'){
                    tbl = 'veh_spk';
                }
               
               if(tbl !== undefined){
                 Process(tbl); 
               }else{
                  showAlert("Notification", "<font color='red'>Please selected Checkbox</font>");
               }
            }
        });

    }
    function setTitle(tbl) {
        switch (tbl) {
            case 'veh_spk':
                title = 'SPK';
                break;
            case 'veh_slh':
                title = 'Vehicle Sales';
                break;

            case 'veh_po':
                title = 'Vehicle Purchase Order';
                break;
            case 'veh_prh':
                title = 'Vehicle Receiving/Purchasing';
                break;
            case 'veh_rprh':
                title = 'Vehicle Purchase Return';
                break;
            case 'veh_rslh':
                title = 'Vehicle Sales Return';
                break;

            case 'acc_slh':
                title = 'Vehicle Accessories Sales';
                break;
            case 'acc_poh':
                title = 'Accessories Purchase Order';
                break;
            case 'acc_prh':
                title = 'Accessories Receiving/Purchasing';
                break;
            case 'acc_opnh':
                title = 'Accessories Opname';
                break;
            case 'acc_movh':
                title = 'Accessories Moving';
                break;
            case 'acc_rprh':
                title = 'Accessories Purchase Return';
                break;
            case 'acc_rslh':
                title = 'Sales Return Accessories';
                break;
            case 'acc_woh':
                title = 'Accessories Work Order';
                break;
            case 'acc_wprh':
                title = 'Accessories Receiving/Purchasing';
                break;
            case 'acc_worh':
                title = 'Accessories Work Order Request';
                break;
            case 'acc_wslh':
                title = 'Optional After-Sales';
                break;
        }


    }

    function Process(tbl) {
        setTitle(tbl);
        start();

        var myInterval = setInterval(function () {
            var count = checking('count', tbl);
            if (parseInt(count) > 0) {
                stop();
                $.messager.confirm('Notification', 'Ada ' + count + ' Data', function (r) {
                    if (r) {
                        setTable(tbl);
                        $('#dlg').dialog('open');

                    } else {
                        start();
                    }
                });
                clearInterval(myInterval);
            }
        }, 1000);
    }



    function start() {
        $('#statTable').empty().append(title);
        $('#dlg').window('close');
        $('#bar').show();
        var $bar = $('#bar');

        Horloge(maxWidth);
        timer = setInterval('Horloge(' + maxWidth + ')', 100);

        $bar.animate({
            width: maxWidth
        }, duration, function () {
            $(this).css('background-color', 'green');
            $start.attr('disabled', true);
            $stop.attr('disabled', true);
            $log.html('100 %');
            clearInterval(timer);


            switch (tbl) {

                case 'veh_spk':
                    tbl = 'veh_slh';
                    break;
                case 'veh_slh':
                    tbl = 'veh_po';
                    break;
                case 'veh_po':
                    tbl = 'veh_prh';
                    break;
                case 'veh_prh':
                    tbl = 'veh_rprh';
                    break;
                case 'veh_rprh':
                    tbl = 'veh_rslh';
                    break;
                case 'veh_rslh':
                    tbl = 'acc_slh';
                    break;
                case 'acc_slh':
                    tbl = 'acc_poh';
                    break;
                case 'acc_poh':
                    tbl = 'acc_prh';
                    break;
                case 'acc_prh':
                    tbl = 'acc_opnh';
                    break;
                case 'acc_opnh':
                    tbl = 'acc_movh';
                    break;
                case 'acc_movh':
                    tbl = 'acc_rprh';
                    break;
                case 'acc_rprh':
                    tbl = 'acc_rslh';
                    break;
                case 'acc_rslh':
                    tbl = 'acc_woh';
                    break;
                case 'acc_woh':
                    tbl = 'acc_wprh';
                    break;
                case 'acc_wprh':
                    tbl = 'acc_worh';
                    break;
                case 'acc_worh':
                    tbl = 'acc_wslh';
                    break;
                case 'acc_wslh':
                    tbl = '';
                    showAlert("Complete", "Invoice Checking process is complete");
                    $('#bar').hide();
                    $("#log").empty();
                    $("#statTable").empty();
                    break;

            }

            if (tbl !== '') {
                $('#bar').css("width", 0);
                Process(tbl);
                setTable(tbl);
            }


        });
    }

    function stop() {
        var $bar = $('#bar');
        $bar.stop();

        clearInterval(timer);

        var w = $bar.width();
        var percent = parseInt((w * 100) / maxWidth);
        $log.html(percent + '%');
    }
    function Horloge(maxWidth) {
        var w = $('#bar').width();
        var percent = parseInt((w * 100) / maxWidth);
        $('#log').html(percent + '%');
    }

    function setVal() {
        $('#bulan').combobox('setValue', '<?php echo $bulan; ?>');
        $('#tahun').val('<?php echo $tahun; ?>');
    }


    function checking(par, tbl) {

        var tmp = null;

        $.ajax({
            async: false,
            type: "POST",
            global: false,
            dataType: 'html',
            url: site_url + 'utility/processChecking',
            data: {mounth: mounth, year: year, tbl: tbl},
            success: function (res) {
                var json = $.parseJSON(res);

                if (par == 'count') {
                    tmp = parseInt(json.total);
                }
                if (par == 'data') {
                    tmp = json.rows;
                }

            }
        });

        return tmp;

    }

    function setTable(tbl) {
        var data = checking('data', tbl);


        switch (tbl) {
            case 'veh_spk':
                header = [{field: "so_no", title: "SPK No.", sortable: true}, {field: "so_date", title: "SPK Date", formatter: formatDate, sortable: true}, {field: "soseq_date", title: "SPK Order Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "cust_rname", title: "Name in Vehicle Registration", sortable: true}, {field: "srep_code", title: "Sales Code", sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "veh_code", title: "Vehicle Code", sortable: true}, {field: "veh_name", title: "Vehicle Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_transm", title: "Transmission", sortable: true}, {field: "color_code", title: "Color Code", sortable: true}];
                break;
            case 'veh_slh':
                header = [{field: "sal_inv_no", title: "Sales Invoice No.", sortable: true}, {field: "sal_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "so_no", title: "SPK No.", sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "cust_rname", title: "Name in Vehicle Registration", sortable: true}, {field: "srep_code", title: "Sales Code", sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "veh_code", title: "Vehicle Code", sortable: true}, {field: "veh_name", title: "Vehicle Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_transm", title: "Transmission", sortable: true}, {field: "color_code", title: "Color Code", sortable: true}, {field: "color_name", title: "Color Name", sortable: true}];
                break;

            case 'veh_po':
                header = [{field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}, {field: "wrhs_code", title: "Warehouse", sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_model", title: "Model", sortable: true}, {field: "color_name", title: "Color Name", sortable: true}, {field: "due_date", title: "Due Date", formatter: formatDate, sortable: true}];
                break;
            case 'veh_prh':
                header = [{field: "pur_inv_no", title: "Invoice No.", sortable: true}, {field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}, {field: "wrhs_code", title: "Warehouse", sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_model", title: "Model", sortable: true}, {field: "color_name", title: "Color Name", sortable: true}, {field: "due_date", title: "Due Date", formatter: formatDate, sortable: true}];
                break;
            case 'veh_rprh':
                header = [{field: "rpr_inv_no", title: "Invoice Return", sortable: true}, {field: "rpr_date", title: "Invoice Return Date", formatter: formatDate, sortable: true}, {field: "pur_inv_no", title: "Purchase No.", sortable: true}, {field: "pur_date", title: "Purchase Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "veh_code", title: "Vehicle Code", sortable: true}, {field: "veh_name", title: "Vehicle Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_transm", title: "Transmission", sortable: true}, {field: "color_code", title: "Color Code", sortable: true}, {field: "color_name", title: "Color Name", sortable: true}];
                break;
            case 'veh_rslh':
                header = [{field: "rsl_inv_no", title: "Invoice Return", sortable: true}, {field: "rsl_date", title: "Invoice Return Date", formatter: formatDate, sortable: true}, {field: "sal_inv_no", title: "Sales Invoice No.", sortable: true}, {field: "sal_date", title: "Sales Invoice Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "cust_rname", title: "Name in Vehicle Registration", sortable: true}, {field: "srep_code", title: "Sales Code", sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "veh_code", title: "Vehicle Code", sortable: true}, {field: "veh_name", title: "Vehicle Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_transm", title: "Transmission", sortable: true}, {field: "color_code", title: "Color Code", sortable: true}, {field: "color_name", title: "Color Name", sortable: true}];
                break;

            case 'acc_slh':
                header = [{field: "sal_inv_no", title: "Invoice No.", sortable: true}, {field: "sal_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "due_date", title: "TOP", formatter: formatDate, sortable: true}];
                break;
            case 'acc_poh':
                header = [{field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "po_type", title: "PO Type", sortable: true}, {field: "quote_no", title: "Quotation No.", sortable: true}, {field: "quote_date", title: "Quotation Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "prep_code", title: "Purchaser Code", sortable: true}, {field: "prep_name", title: "Purchaser Name", sortable: true}, {field: "raddr_code", title: "Recipient Code", sortable: true}, {field: "rname", title: "Recipient Name", sortable: true}, {field: "wrhs_code", title: "Warehouse", sortable: true}, {field: "note", title: "Note 1", sortable: true}, {field: "note2", title: "Note 2", sortable: true}, {field: "note3", title: "Note 3", sortable: true}, {field: "note4", title: "Note 4", sortable: true}];
                break;
            case 'acc_prh':
                header = [{field: "pur_inv_no", title: "Invoice No.", sortable: true}, {field: "pur_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "rcv_date", title: "Receive Date", formatter: formatDate, sortable: true}, {field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}, {field: "sj_no", title: "DO (SJ) No.", sortable: true}, {field: "sj_date", title: "DO (SJ) Date", formatter: formatDate, sortable: true}, {field: "supp_invno", title: "Supplier Invoice No.", sortable: true}, {field: "supp_invdt", title: "Supplier Invoice Date", sortable: true}];
                break;
            case 'acc_opnh':
                header = [{field: "opn_inv_no", title: "Invoice No.", sortable: true}, {field: "opn_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "open_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "oprep_code", title: "Opname by Code", sortable: true}, {field: "oprep_name", title: "Opname by Name", sortable: true}];
                break;
            case 'acc_movh':
                header = [{field: "mov_inv_no", title: "Invoice No.", sortable: true}, {field: "mov_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "mvrep_code", title: "Moving By Code", sortable: true}, {field: "mvrep_name", title: "Moving By Name", sortable: true}, {field: "wrhs_from", title: "From Warehouse", sortable: true}, {field: "wrhs_to", title: "To Warehouse", sortable: true}];
                break;
            case 'acc_rprh':
                title = 'Accessories Purchase Return';
                header = [{field: "rpr_inv_no", title: "Invoice No.", sortable: true}, {field: "rpr_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "pur_inv_no", title: "Purchase No.", sortable: true}, {field: "pur_date", title: "Purchase Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "sj_no", title: "DO (SJ) No.", sortable: true}, {field: "sj_date", title: "DO (SJ) Date", formatter: formatDate, sortable: true}, {field: "po_no", title: "PO No.", sortable: true}, {field: "po_date", title: "PO Date", formatter: formatDate, sortable: true}];
                break;
            case 'acc_rslh':
                header = [{field: "rsl_inv_no", title: "Invoice No.", sortable: true}, {field: "rsl_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "sal_inv_no", title: "Sales Invoice No.", sortable: true}, {field: "sal_date", title: "Sales Invoice Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "so_no", title: "Sales Order No.", sortable: true}, {field: "so_date", title: "Sales Order Date", formatter: formatDate, sortable: true}];
                break;
            case 'acc_woh':
                header = [{field: "wo_no", title: "WO No.", sortable: true}, {field: "wo_date", title: "WO Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "so_no", title: "SPK No.", sortable: true}, {field: "so_date", title: "SPK Date", formatter: formatDate, sortable: true}, {field: "quote_no", title: "Quotation No.", sortable: true}, {field: "quote_date", title: "Quotation Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "prep_code", title: "Purchaser Code", sortable: true}, {field: "prep_name", title: "Purchaser Name", sortable: true}, {field: "raddr_code", title: "Recipient Code", sortable: true}, {field: "rname", title: "Recipient Name", sortable: true}];
                break;
            case 'acc_wprh':
                header = [{field: "pur_inv_no", title: "Invoice No.", sortable: true}, {field: "pur_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "so_no", title: "SPK No.", sortable: true}, {field: "so_date", title: "SPK Date", formatter: formatDate, sortable: true}, {field: "supp_code", title: "Supplier Code", sortable: true}, {field: "supp_name", title: "Supplier Name", sortable: true}, {field: "rcv_date", title: "Receive Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}];
                break;
            case 'acc_worh':
                header = [{field: "wor_no", title: "SPOK No.", sortable: true}, {field: "wor_date", title: "SPOK Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "oreq_type", title: "SPOK Type", sortable: true}, {field: "dept_code", title: "Department Code", sortable: true}, {field: "dept_name", title: "Department Name", sortable: true}, {field: "dunit_code", title: "Unit Code", sortable: true}, {field: "dunit_name", title: "Unit Name", sortable: true}];
                break;
            case 'acc_wslh':
                header = [{field: "sal_inv_no", title: "Sales Invoice No.", sortable: true}, {field: "sal_date", title: "Sales Invoice Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "srep_code", title: "Sales Code", sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "sj_no", title: "DO (SJ) No.", sortable: true}, {field: "wo_no", title: "WO No.", sortable: true}, {field: "wo_date", title: "WO Date", formatter: formatDate, sortable: true}];
                break;
        }

        tablesGet(data, header, title);
    }
    function tablesGet(data, header, title) {
        $("#tableDialog").datagrid({
            //method: 'post',
            title: title,
            data: data,
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: false,
            columns: [header]
        });

        //$('#tableDialog').datagrid('appendRow',data);
        //$('#tableDialog').datagrid('reload');
    }


    function exportTable() {
        $.post(site_url + 'utility/processChecking', {tbl: tbl, mounth: mounth, year: year}, function (data) {
            var json = $.parseJSON(data);
            var rows = json.rows;

            JSONToCSVConvertor(rows, title, true);
            //window.open('data:application/vnd.ms-excel,' + html);
        });
    }

    function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
        //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

        var CSV = '';
        //Set Report title in first row or line

        // CSV += ReportTitle + '\r\n\n';

        //This condition will generate the Label/Header
        if (ShowLabel) {
            var row = "";

            //This loop will extract the label from 1st index of on array
            for (var index in arrData[0]) {

                //Now convert each value to string and comma-seprated
                row += index + ',';
            }

            row = row.slice(0, -1);

            //append Label row with line break
            CSV += row + '\r\n';
        }

        //1st loop is to extract each row
        for (var i = 0; i < arrData.length; i++) {
            var row = "";

            //2nd loop will extract each column and convert it in string comma-seprated
            for (var index in arrData[i]) {
                row += '"' + arrData[i][index] + '",';
            }

            row.slice(0, row.length - 1);

            //add a line break after each row
            CSV += row + '\r\n';
        }

        if (CSV == '') {
            alert("Invalid data");
            return;
        }

        //Generate a file name
        var fileName = "Checking_";
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += ReportTitle.replace(/ /g, "_");

        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

        // Now the little tricky part.
        // you can use either>> window.open(uri);
        // but this will not work in some browsers
        // or you will not get the correct file extension    

        //this trick will generate a temp <a /> tag
        var link = document.createElement("a");
        link.href = uri;

        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + '_' + year + mounth + ".csv";

        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>