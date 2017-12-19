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
    var res;
    var counts;
    var num = 0;
    var cond;

    $(document).ready(function () {
        setVal();
        checbox();
         //checkboxClick();
        $('.loader').hide();
         $('#form_validation input:checkbox').prop("checked", true);
                $('#form_validation input:checkbox').val(1);
        $('#form_validation #checkAll').click(function () {

            var check =  $('#form_validation #checkAll').prop("checked");

            if (check == true) {
                $('#form_validation input:checkbox').prop("checked", true);
                $('#form_validation input:checkbox').val(1);
            }
            else {
                $('#form_validation input:checkbox').prop("checked", false);
                $('#form_validation input:checkbox').val(0);
            }

        });
         version('07.17-31');
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
                var str = $('#form_validation input[type="checkbox"]').serialize();
       
                num = 0;
                res = str.split("&");
                counts = res.length - 1;

                var gettb = res[num];

                tbl = resTable(gettb);
                cond = resFunc(gettb);
   
               if(tbl !== undefined){   
                 Process(tbl, cond); 
               }else{
                  showAlert("Notification", "<font color='red'>Please selected Checkbox</font>");
               }
            }
        });

    }
    function resTable(gettb){

        var tbl0 = gettb.split("=");
        var tbl10 = tbl0[0];
        var tbl10 = tbl10.split("_");
        
        var tbl = tbl10[0]+'_'+tbl10[1];
        
        return tbl;
        
    }
    function resFunc(gettb){
        var tbl0 = gettb.split("=");
        var tbl10 = tbl0[0];
        var tbl10 = tbl10.split("_");
        
        var cond = tbl10[2];
        
        return cond;
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
            case 'veh_movh':
                title = 'Movement';
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
            case 'acc_rprh':
                title = 'Accessories Purchase Return';
                break;
            case 'acc_rslh':
                title = 'Sales Return Accessories';
                break;
             case 'acc_movh':
                title = 'Accessories Moving';
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
            
            case 'veh_bwoh':
                title = 'BBN Work Order';
                break;              
            case 'veh_bprh':
                title = 'BBN Registration';
                break;
        }


    }

    function Process(tbl, cond) {
        setTitle(tbl);
        start();
        
        var myInterval = setInterval(function () {
            var count = checking('count', tbl, cond); 
            if (parseInt(count) > 0) {
                stop();
                
                if(cond == 0){
                    var msgs = '  Invoice closed but not printed  '
                }
                
                if(cond == 1){
                    var msgs = ' Invoice printed more than once '
                }
                $.messager.confirm('Notification', 'There is ' + count + msgs, function (r) {
                    if (r) {
                        setTable(tbl,cond);
                        $('#dlg').dialog('open');

                    } 
                    else {
                        //start();
                        condCancel();
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
            //$(this).css('background-color', 'green');
            $start.attr('disabled', true);
            $stop.attr('disabled', true);
            $log.html('100 %');
            clearInterval(timer);

            if(num < counts){
               num = num + 1;
               
               gettb = res[num];       
               tbl = resTable(gettb);
               cond = resFunc(gettb);
            }else{
                tbl = '';
                showAlert("Complete", "Invoice Checking process is complete");
                $('#bar').hide();
                $("#log").empty();
                $("#statTable").empty();
            }
            


            if (tbl !== '') {
                $('#bar').css("width", 0);
                Process(tbl, cond); 
                setTable(tbl, cond);
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


    function checking(par, tbl, cond) {

        var tmp = null;

        $.ajax({
            async: false,
            type: "POST",
            global: false,
            dataType: 'html',
            url: site_url + 'utility/processChecking',
            data: {mounth: mounth, year: year, tbl: tbl, cond:cond},
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

    function setTable(tbl, cond) { 
        var data = checking('data', tbl, cond);

        switch (tbl) {
            case 'veh_spk':
                header = [{field: "so_no", title: "SPK No.", sortable: true}, {field: "so_date", title: "SPK Date", formatter: formatDate, sortable: true}, {field: "soseq_date", title: "SPK Order Date", formatter: formatDate, sortable: true}, {field: "cust_code", title: "Customer Code", sortable: true}, {field: "cust_name", title: "Customer Name", sortable: true}, {field: "cust_rname", title: "Name in Vehicle Registration", sortable: true}, {field: "srep_code", title: "Sales Code", sortable: true}, {field: "srep_name", title: "Sales Name", sortable: true}, {field: "veh_code", title: "Vehicle Code", sortable: true}, {field: "veh_name", title: "Vehicle Name", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "veh_transm", title: "Transmission", sortable: true}, {field: "color_code", title: "Color Code", sortable: true}];
                break;
            case 'veh_movh':
                header = [{field: "mov_inv_no", title: "Invoice No.", sortable: true}, {field: "mov_date", title: "Invoice Date", formatter: formatDate, sortable: true}, {field: "opn_date", title: "Created On", formatter: formatDate, sortable: true}, {field: "mvrep_code", title: "Moving By Code ", sortable: true}, {field: "mvrep_name", title: "Moving By Name ", sortable: true}, {field: "wrhs_from", title: "From Warehouse", sortable: true}, {field: "wrhs_to", title: "To Warehouse", sortable: true}, {field: "veh_name", title: "Vehicle", sortable: true}, {field: "chassis", title: "Chassis", sortable: true}, {field: "color_name", title: "Color", sortable: true}];
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
                
            case 'veh_bwoh':
                title = 'BBN Work Order';
                header = [{field: "wo_no", title: "WO No.", sortable: true},{field: "wo_date", title: "WO Date", formatter: formatDate, sortable: true},{field: "opn_date", title: "Pick Date", formatter: formatDate, sortable: true},{field: "quote_no", title: "Quotation No.", sortable: true},{field: "quote_date", title: "Quotation Date ", formatter: formatDate, sortable: true},{field: "supp_code", title: "Agent Code", sortable: true},{field: "supp_name", title: "Agent Name ", sortable: true},{field: "prep_code", title: "Purchaser Code", sortable: true},{field: "prep_name", title: "Purchaser Name ", sortable: true},{field: "raddr_code", title: "Recipient Code", sortable: true},{field: "rname", title: "Recipient Name", sortable: true}];
                break;              
            case 'veh_bprh':
                header = [{field: "pur_inv_no", title: "Invoice No.", sortable: true},{field: "pur_date", title: "Invoice Date", formatter: formatDate, sortable: true},{field: "opn_date", title: "Created On", formatter: formatDate, sortable: true},{field: "supp_code", title: "Agent Code", sortable: true},{field: "supp_name", title: "Agent Name ", sortable: true},{field: "sj_no", title: "DO (SJ) No.", sortable: true},{field: "supp_invno", title: "Supplier Invoice No.", sortable: true},{field: "wo_no", title: "WO No.", sortable: true}];
                title = 'BBN Registration';
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
        $.post(site_url + 'utility/processChecking', {tbl: tbl, mounth: mounth, year: year, cond:cond}, function (data) {
            var json = $.parseJSON(data);
            var rows = json.rows;

            JSONToCSVConvertor(rows, title, true);
            window.open('data:application/vnd.ms-excel,' + html);
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
    
    function clearProcess(){ alert('hello')
        $('#dlg').window('close');
        $('#bar').hide();
    }
   
</script>