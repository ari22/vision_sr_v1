<script>
    $('.loader').hide();
    version('03.17-31');
    var table = 'matchsatu';
    var table2 = 'matchdua';
    var url = site_url + '<?php echo 'builder/grid_spk/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/match/?grid=true';

    var val1 = '';
    var val2 = '';
    var val3 = '';
    var val4 = '';
    var val5 = '';
    var sid = '';

    table_grid_spk(table, url);


    table_matchdua(table2, url);
    searchdisabled('formMatch1');
    searchdisabled('formMatch2');
    searchdisabled('formMatchStock1');
    searchdisabled('formMatchStock2');

    $('#matchsatu').datagrid({
        onClickRow: function (index, row) {


            url = "services/runCRUD.php?lookup=trx/spk_matching&func=readstock";
            if (row) {
                val1 = '';

                id = row.id;
                filter1 = row.veh_code;
                filter2 = row.color_code;
                filter3 = row.veh_transm;
                filter4 = '';
                filter5 = '';
                nospk = row.so_no;
                filter = dataFilter();
                if (filter.length >> 0)
                {
                    filter = "&filter=" + filter;
                }
                url = url + filter;
                $('#stocksatu').datagrid({
                    url: url
                });
                return{filter1: filter1, filter2: filter2, filter3: filter3};


            }
        }
    });
    $('#matchdua').datagrid({
        onClickRow: function (index, row) {
            url = "services/runCRUD.php?lookup=trx/spk_matching&func=readstock";
            if (row) {
                val1 = '';
                filter1 = row.veh_code;
                filter2 = row.color_code;
                filter3 = row.veh_transm;
                filter4 = '';
                filter5 = '';
                filter = dataFilter();
                if (filter.length >> 0)
                {
                    filter = "&filter=" + filter;
                }
                url = url + filter;
                $('#stockdua').datagrid({
                    url: url
                });
                return{filter1: filter1, filter2: filter2, filter3: filter3};
            }
        }
    });
    $('#stocksatu').datagrid({
        onClickRow: function (index, row) {
            if (row) {
                val1 = row.veh_code;
                val2 = row.color_code;
                val3 = row.veh_transm;
                val4 = row.chassis;
                val5 = row.engine;
                sid = row.id;
                return{val1: val1, val2: val2, val3: val3, sid: sid};
            }

        }
    });
    $('#stockdua').datagrid({
        onClickRow: function (index, row) {
            if (row) {
                val1 = row.veh_code;
                val2 = row.color_code;
                val3 = row.veh_transm;
                val4 = row.chassis;
                val5 = row.engine;
                sid = row.id;
                return{val1: val1, val2: val2, val3: val3, sid: sid};
            }

        }
    });
    $('#matched').datagrid({
        onClickRow: function (index, row) {
            if (row) {
                val1 = row.veh_code;
                val2 = row.color_code;
                val3 = row.veh_transm;
                val4 = row.chassis;
                val5 = row.engine;
                id = row.id;
                return{val1: val1, val2: val2, val3: val3};
            }

        }
    });
    function dataFilter() {
        lcFilter = "";
        if (filter1 !== '') {
            lcKey = filter1;
            if (lcKey.length >> 0) {
                if (lcFilter.length >> 0) {
                    lcFilter = lcFilter + " AND ";
                }
                lcFilter = lcFilter + "veh_code='" + filter1 + "'";
            }
        }
        if (filter2 !== '') {
            lcKey = filter2;
            if (lcKey.length >> 0) {
                if (lcFilter.length >> 0) {
                    lcFilter = lcFilter + " AND ";
                }
                lcFilter = lcFilter + "color_code='" + filter2 + "'";
            }
        }
        if (filter3 !== '') {
            lcKey = filter3;
            if (lcKey.length >> 0) {
                if (lcFilter.length >> 0) {
                    lcFilter = lcFilter + " AND ";
                }
                lcFilter = lcFilter + "veh_transm='" + filter3 + "'";
            }
        }
        if (filter4 !== '') {
            lcKey = filter4;
            if (lcKey.length >> 0) {
                if (lcFilter.length >> 0) {
                    lcFilter = lcFilter + " AND ";
                }
                lcFilter = lcFilter + "chassis='" + filter4 + "'";
            }
        }

        if (filter5 !== '') {
            lcKey = filter5;
            if (lcKey.length >> 0) {
                if (lcFilter.length >> 0) {
                    lcFilter = lcFilter + " AND ";
                }
                lcFilter = lcFilter + "engine='" + filter5 + "'";
            }
        }
        return lcFilter;

    }
    function getdate() {
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var today = d.getFullYear() + '-' + (('' + month).length < 2 ? '0' : '') + month + '-' + (('' + day).length < 2 ? '0' : '') + day;
        return today;
    }

    function doMatch() {
        if (val1 !== '') {
            //$.messager.confirm('SPK & Stock Matched?', '<strong>SPK &nbsp&nbsp &nbsp&nbsp</strong>=>&nbsp ' + filter1 + '&nbsp;|&nbsp;' + filter2 + '&nbsp;|&nbsp;' + filter3 + '<br/> <br/><strong>STOCK</strong> =>&nbsp ' + val1 + '&nbsp;|&nbsp;' + val2 + '&nbsp;|&nbsp;' + val3, function (r) {
            $.messager.confirm('SPK and Stock Matching', 'Match SPK with Vehicle Stock?', function (r) {

                if (r) {
                    url = "services/runCRUD.php?lookup=trx/spk_matching&func=match";
                    today = getdate();
                    data = "&date='" + today + "'"
                            + "&id='" + id + "'"
                            + "&chassis='" + val4 + "'"
                            + "&engine='" + val5 + "'"
                            + "&nospk='" + nospk + "'"
                            + "&sid='" + sid + "'";
                    url = url + data

                    // alert(url);return false;
                    /* $.post(url, data);
                     
                     $('#matchsatu').datagrid('reload');
                     $('#matchdua').datagrid('reload');
                     $('#stocksatu').datagrid('reload');
                     $('#stockdua').datagrid('reload');
                     $('#matched').datagrid('reload');
                     $('#stock').datagrid('reload');
                     */
                    $.post(url, data, function (res) {
                        if (res !== false) {
                            $('#matchsatu').datagrid('reload');
                            $('#matchdua').datagrid('reload');
                            $('#stocksatu').datagrid('reload');
                            $('#stockdua').datagrid('reload');
                            $('#matched').datagrid('reload');
                            $('#stock').datagrid('reload');
                        }
                    });
                }
            });
        } else {
            alert('Please choose a vehicle in stock');
        }
    }

    function doUnMatch() {
        if (val1 !== '') {
            $.messager.confirm('Un-Match this pair?', val1 + '&nbsp;|&nbsp;' + val2 + '&nbsp;|&nbsp;' + val3, function (r) {
                if (r) {
                    url = "services/runCRUD.php?lookup=trx/spk_matching&func=unmatch";
                    data = "&id='" + id + "'&username='<?php echo $username; ?>'";

                    /* $.post(url, data);
                     $('#matchsatu').datagrid('reload');
                     $('#matchdua').datagrid('reload');
                     $('#stocksatu').datagrid('reload');
                     $('#stockdua').datagrid('reload');
                     $('#matched').datagrid('reload');
                     $('#stock').datagrid('reload');
                     */
                    $.post(url, data, function (json) {
                        var res = $.parseJSON(json);

                        if (res.success !== false) {
                            $('#matchsatu').datagrid('reload');
                            $('#matchdua').datagrid('reload');
                            $('#stocksatu').datagrid('reload');
                            $('#stockdua').datagrid('reload');
                            $('#matched').datagrid('reload');
                            $('#stock').datagrid('reload');

                            val1 = '';
                            val2 = '';
                        } else {
                            showAlert("Error while Unmatching", '<font color="red">' + res.message + '</font>');
                        }
                    });
                }
            });
        }
    }


    function table_grid_spk(table, urls) {

        var ttable = $("#" + table);
        ttable.datagrid({
            method: 'post',
            url: urls,
            //title: 'SPK List',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_name', title: '<?php getCaption("Nama Warna"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'soseq_date', title: 'SPK Order', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 130, height: 20, sortable: true},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    //{field: 'chassis', title: '<?php getCaption("Chassis"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_type', title: '<?php getCaption("Tipe Warna"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_type', title: '<?php getCaption("Tipe"); ?>', width: 100, height: 20, sortable: true},
                    //{field: 'engine', title: '<?php getCaption("Engine"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_model', title: '<?php getCaption("Model"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_year', title: '<?php getCaption("Tahun"); ?>', width: 50, height: 20, sortable: true},
                    {field: 'veh_brand', title: '<?php getCaption("Merek"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 170, height: 20, sortable: true}
                ]]
        });
        //searchdisabled('formMatch1');

    }

    function table_matchdua(table, url) {

        var ttable2 = $("#" + table);
        ttable2.datagrid({
            method: 'post',
            url: url,
            //title: 'SPK List',
            idField: 'id',
            fitColumns: false,
            singleSelect: true,
            nowrap: true,
            fit: false,
            rownumbers: true,
            pageSize: 10,
            showFooter: false,
            pagination: true,
            columns: [[
                    {field: 'so_date', title: 'SPK Order', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 150, height: 20, sortable: true},
                    {field: 'veh_code', title: '<?php getCaption("Kode Kendaraan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'veh_transm', title: '<?php getCaption("Transmisi"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_code', title: '<?php getCaption("Kode Warna"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_name', title: '<?php getCaption("Nama Warna"); ?>', width: 250, height: 20, sortable: true},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'chassis', title: '<?php getCaption("Chassis"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'color_type', title: '<?php getCaption("Tipe Warna"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_type', title: '<?php getCaption("Tipe"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'engine', title: '<?php getCaption("Engine"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_model', title: '<?php getCaption("Model"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'veh_year', title: '<?php getCaption("Tahun"); ?>', width: 70, height: 20, sortable: true},
                    {field: 'veh_brand', title: '<?php getCaption("Merek"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'wrhs_code', title: '<?php getCaption("Warehouse"); ?>', width: 100, height: 20, sortable: true},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 170, height: 20, sortable: true},
                    //{field: 'salpaytype', title: 'Cash(1), Crd(2)', width: 100, height: 20, sortable: true}
                ]]
        });
        // searchdisabled('formMatch2');

    }



    function searchdisabled(form) {
        //$("#TDkeyword" + form).hide();
        //$("#TDbuttonSearch" + form).hide();
        $("#keyword" + form).attr('disabled', true);
        $("#keyword" + form).val('');
        $("#buttonSearch" + form).attr('disabled', true);
        /*
         
         $("#buttonSearch" + form).attr('disabled', true);
         $("#buttonSearch" + form).linkbutton('disable');
         */
    }


    function showMacthkeyword(table, form) {
        var showMacth = $("#showMacth" + form).val();
        if (showMacth !== 'all') {
            $("#TDkeyword" + form).show();
            $("#TDbuttonSearch" + form).show();
            $("#keyword" + form).attr('disabled', false);
            $("#buttonSearch" + form).attr('disabled', false);
            $("#buttonSearch" + form).linkbutton('enable');
        } else {
            searchdisabled(form);
            $("#buttonSearch" + form).attr('disabled', true);
            $("#buttonSearch" + form).linkbutton('disable');
            var urls = site_url + '<?php echo 'builder/grid_spk/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/match/?grid=true';
            if (table == 'matchsatu') {
                table_grid_spk(table, urls);
            } else {
                table_matchdua(table, urls);
            }

        }
    }

    function sortirMatch(table, form) {
        var keyword = $("#keyword" + form).val();
        var option = $("#showMacth" + form).val();
        var urls = site_url + '<?php echo 'builder/grid_spk/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/match/' + option + '/' + keyword + '/?grid=true';
        if (table == 'matchsatu') {
            table_grid_spk(table, urls);
        } else {
            table_matchdua(table, urls);
        }

    }

    function showMacthkeywordStock(table, table2, form) {
        var showMacth = $("#showMacth" + form).val();
        
        if (showMacth !== 'all') {
            $("#TDkeyword" + form).show();
            $("#TDbuttonSearch" + form).show();
            $("#keyword" + form).attr('disabled', false);
            $("#buttonSearch" + form).attr('disabled', false);
            $("#buttonSearch" + form).linkbutton('enable');
        } else {
            searchdisabled(form);
            $("#buttonSearch" + form).attr('disabled', true);
            $("#buttonSearch" + form).linkbutton('disable');
            
            filter1 = '';
            filter2 = '';
            filter3 = '';
            filter4 = '';
            filter5 = '';
        
            if(table !==''){
                var row = $('#' + table).datagrid('getSelected');

                id = row.id;
                filter1 = row.veh_code;
                filter2 = row.color_code;
                filter3 = row.veh_transm;
                nospk = row.so_no;
            }
           

            filter = dataFilter();
            if (filter.length >> 0)
            {
                filter = "&filter=" + filter;
            }
            url = url + filter;
            $('#' + table2).datagrid({
                url: url
            });
            return{filter1: filter1, filter2: filter2, filter3: filter3};
        }
    }

    function sortirMatchStock(table, table2, form) {
        var keyword = $("#keyword" + form).val();
        var option = $("#showMacth" + form).val();
        
        filter1 = '';
        filter2 = '';
        filter3 = '';
        filter4 = '';
        filter5 = '';
        
        if(table !==''){
            var row = $('#' + table).datagrid('getSelected');

            id = row.id;
            filter1 = row.veh_code;
            filter2 = row.color_code;
            filter3 = row.veh_transm;
            nospk = row.so_no;
        }
      
                    
       
        
        if(option == 'chassis'){
            filter4 = keyword;
        }
        if(option == 'engine'){
            filter5 = keyword;
        }
        
                  alert(filter4)
        filter = dataFilter();

        if (filter.length >> 0)
        {
            filter = "&filter=" + filter;
        }
        url = url + filter; alert(url)
        $('#' + table2).datagrid({
            url: url
        });
        return{filter1: filter1, filter2: filter2, filter3: filter3};

    }


    function print_sc(action) {

        var user = '<?php echo $_SESSION['C_USER']; ?>';
        var option = $('input[name=option]:checked', '#form_validation').val();
        var code = $("#codeOption").val();

        if (code == 'matching') {

            var url = site_url + 'transaction/spk/printSpkMatch/' + user + '/' + action + '/' + option + '/' + code;

            if (action == 'screen') {
                window.open(url);
            }
            else if (action == 'export') {
                var win = window.open(url);

                /*$.get(url, function (html) {
                 
                 var dataobj = $.parseJSON(html);
                 
                 if (option == '1') {
                 dataobj.sort(sort_by('so_date', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '2') {
                 dataobj.sort(sort_by('so_no', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '3') {
                 dataobj.sort(sort_by('pur_inv_no', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 
                 var header = [
                 {headertext: "<?php getCaption("No. SPK"); ?>", datatype: "string", datafield: "so_no"}
                 , {headertext: "<?php getCaption("No. Faktur"); ?>", datatype: "string", datafield: "pur_inv_no", width: "100px"}
                 , {headertext: "<?php getCaption("Kode Kendaraan"); ?>", datatype: "string", datafield: "veh_code", width: "100px"}
                 , {headertext: "<?php getCaption("Nama Kendaraan"); ?>", datatype: "string", datafield: "veh_name"}
                 , {headertext: "<?php getCaption("Transmisi"); ?>", datatype: "string", datafield: "veh_transm"}
                 , {headertext: "<?php getCaption("Kode Warna"); ?>", datatype: "string", datafield: "color_code"}
                 , {headertext: "<?php getCaption("Nama Warna"); ?>", datatype: "string", datafield: "color_name"}
                 , {headertext: "<?php getCaption("Tipe"); ?>", datatype: "string", datafield: "color_type"}
                 , {headertext: "<?php getCaption("Tipe Kendaraan"); ?>", datatype: "string", datafield: "veh_type"}
                 , {headertext: "<?php getCaption("Chassis"); ?>", datatype: "string", datafield: "chassis"}
                 , {headertext: "<?php getCaption("Engine"); ?>", datatype: "string", datafield: "engine"}
                 , {headertext: "<?php getCaption("Model"); ?>", datatype: "string", datafield: "veh_model"}
                 , {headertext: "<?php getCaption("Tahun"); ?>", datatype: "string", datafield: "veh_year"}
                 , {headertext: "<?php getCaption("Merek"); ?>", datatype: "string", datafield: "veh_brand"}
                 , {headertext: "<?php getCaption("Tanggal Match"); ?>", datatype: "string", datafield: "match_date"}
                 , {headertext: "<?php getCaption("Tanggal SPK"); ?>", datatype: "string", datafield: "so_date"}
                 , {headertext: "<?php getCaption("Tanggal Urut SPK"); ?>", datatype: "string", datafield: "soseq_date"}
                 , {headertext: "<?php getCaption("Nama Pelanggan"); ?>", datatype: "string", datafield: "cust_name"}
                 , {headertext: "<?php getCaption("Nama Sales"); ?>", datatype: "string", datafield: "srep_name"}
                 , {headertext: "<?php getCaption("Warehouse"); ?>", datatype: "string", datafield: "wrhs_code"}
                 , {headertext: "<?php getCaption("Kode Lokasi"); ?>", datatype: "string", datafield: "loc_code"}
                 ];
                 outputExcel('sr', dataobj, header);
                 });*/
            }
            else {
                $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        }
        else if (code == 'stock') {
            var url = site_url + 'transaction/spk/printStock/' + user + '/' + action + '/' + option + '/' + code;

            if (action == 'screen') {
                window.open(url);
            }
            else if (action == 'export') {
                var win = window.open(url);
                /*$.get(url, function (html) {
                 
                 var dataobj = $.parseJSON(html);
                 
                 if(option == '1'){
                 dataobj.sort(sort_by('so_date', false, function(a){return a.toUpperCase()}));
                 }                       
                 else if(option == '2'){
                 dataobj.sort(sort_by('so_no', false, function(a){return a.toUpperCase()}));
                 }
                 else if(option == '3'){
                 dataobj.sort(sort_by('pur_inv_no', false, function(a){return a.toUpperCase()}));
                 }
                 
                 var header = [
                 {headertext: "<?php getCaption("No. Faktur"); ?>", datatype: "string", datafield: "pur_inv_no", width: "100px"}
                 , {headertext: "<?php getCaption("No. SPK"); ?>", datatype: "string", datafield: "so_no"}
                 , {headertext: "<?php getCaption("Kode Kendaraan"); ?>", datatype: "string", datafield: "veh_code", width: "100px"}
                 , {headertext: "<?php getCaption("Nama Kendaraan"); ?>", datatype: "string", datafield: "veh_name"}
                 , {headertext: "<?php getCaption("Transmisi"); ?>", datatype: "string", datafield: "veh_transm"}
                 , {headertext: "<?php getCaption("Kode Warna"); ?>", datatype: "string", datafield: "color_code"}
                 , {headertext: "<?php getCaption("Nama Warna"); ?>", datatype: "string", datafield: "color_name"}
                 , {headertext: "<?php getCaption("Tipe"); ?>", datatype: "string", datafield: "color_type"}
                 , {headertext: "<?php getCaption("Tipe Kendaraan"); ?>", datatype: "string", datafield: "veh_type"}
                 , {headertext: "<?php getCaption("Chassis"); ?>", datatype: "string", datafield: "chassis"}
                 , {headertext: "<?php getCaption("Engine"); ?>", datatype: "string", datafield: "engine"}
                 , {headertext: "<?php getCaption("Model"); ?>", datatype: "string", datafield: "veh_model"}
                 , {headertext: "<?php getCaption("Tahun"); ?>", datatype: "string", datafield: "veh_year"}
                 , {headertext: "<?php getCaption("Merek"); ?>", datatype: "string", datafield: "veh_brand"}
                 , {headertext: "<?php getCaption("Tanggal Match"); ?>", datatype: "string", datafield: "match_date"}
                 , {headertext: "Stock Date", datatype: "string", datafield: "stk_date"}
                 , {headertext: "Pur Date", datatype: "string", datafield: "pur_date"}
                 , {headertext: "<?php getCaption("Warehouse"); ?>", datatype: "string", datafield: "wrhs_code"}
                 , {headertext: "<?php getCaption("Kode Lokasi"); ?>", datatype: "string", datafield: "loc_code"}
                 ];
                 outputExcel('sr', dataobj, header);
                 });*/
            }
            else {
                $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        }
        else {

            var url = site_url + 'transaction/spk/printNotSpkMatch/' + user + '/' + action + '/' + option + '/' + code;

            if (action == 'screen') {
                window.open(url);
            }
            else if (action == 'export') {

                var win = window.open(url);
                /*
                 $.get(url, function (html) {
                 
                 var dataobj = $.parseJSON(html);
                 
                 switch (code) {
                 case 'spk_code':
                 
                 if (option == '1') {
                 dataobj.sort(sort_by('veh_code', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '2') {
                 dataobj.sort(sort_by('so_no', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '3') {
                 dataobj.sort(sort_by('so_date', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 break;
                 
                 case 'tgl_urut':
                 if (option == '1') {
                 dataobj.sort(sort_by('soseq_date', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '2') {
                 dataobj.sort(sort_by('so_no', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 else if (option == '3') {
                 dataobj.sort(sort_by('so_date', false, function (a) {
                 return a.toUpperCase()
                 }));
                 }
                 break;
                 
                 }
                 
                 var header = [
                 {headertext: "<?php getCaption("No. SPK"); ?>", datatype: "string", datafield: "so_no"}
                 , {headertext: "<?php getCaption("No. Faktur"); ?>", datatype: "string", datafield: "pur_inv_no", width: "100px"}
                 , {headertext: "<?php getCaption("Kode Kendaraan"); ?>", datatype: "string", datafield: "veh_code", width: "100px"}
                 , {headertext: "<?php getCaption("Nama Kendaraan"); ?>", datatype: "string", datafield: "veh_name"}
                 , {headertext: "<?php getCaption("Transmisi"); ?>", datatype: "string", datafield: "veh_transm"}
                 , {headertext: "<?php getCaption("Kode Warna"); ?>", datatype: "string", datafield: "color_code"}
                 , {headertext: "<?php getCaption("Nama Warna"); ?>", datatype: "string", datafield: "color_name"}
                 , {headertext: "<?php getCaption("Tipe"); ?>", datatype: "string", datafield: "color_type"}
                 , {headertext: "<?php getCaption("Tipe Kendaraan"); ?>", datatype: "string", datafield: "veh_type"}
                 , {headertext: "<?php getCaption("Chassis"); ?>", datatype: "string", datafield: "chassis"}
                 , {headertext: "<?php getCaption("Engine"); ?>", datatype: "string", datafield: "engine"}
                 , {headertext: "<?php getCaption("Model"); ?>", datatype: "string", datafield: "veh_model"}
                 , {headertext: "<?php getCaption("Tahun"); ?>", datatype: "string", datafield: "veh_year"}
                 , {headertext: "<?php getCaption("Merek"); ?>", datatype: "string", datafield: "veh_brand"}
                 , {headertext: "<?php getCaption("Tanggal Match"); ?>", datatype: "string", datafield: "match_date"}
                 , {headertext: "<?php getCaption("Tanggal SPK"); ?>", datatype: "string", datafield: "so_date"}
                 , {headertext: "<?php getCaption("Tanggal Urut SPK"); ?>", datatype: "string", datafield: "soseq_date"}
                 , {headertext: "<?php getCaption("Nama Pelanggan"); ?>", datatype: "string", datafield: "cust_name"}
                 , {headertext: "<?php getCaption("Nama Sales"); ?>", datatype: "string", datafield: "srep_name"}
                 
                 ];
                 outputExcel('sr', dataobj, header);
                 });
                 */
            } else {
                $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        }

    }

    function outputExcel(divid, dataobj, header) {

        $("#" + divid).battatech_excelexport({
            containerid: divid
            , datatype: 'json'
            , dataset: dataobj
            , columns: header
        });

    }

    function sort_by(field, reverse, primer) {

        var key = primer ?
                function (x) {
                    return primer(x[field])
                } :
                function (x) {
                    return x[field]
                };

        reverse = !reverse ? 1 : -1;

        return function (a, b) {
            return a = key(a), b = key(b), reverse * ((a > b) - (b > a));
        }
    }

    function windowprint(code) {
        checkboxClick();

        if (code == 'matching') {
            $('#MatchPrintWindow').window({
                title: 'SPK Matched with stock'
            });
        }
        else if (code == 'stock') {
            $('#MatchPrintWindow').window({
                title: 'Vehicle Stock not yet matched with SPK'
            });
        }
        else {
            $('#MatchPrintWindow').window({
                title: 'SPK not yet matched with Vehicle Stock'
            });
        }

        $('#MatchPrintWindow').window('open');
        $("#codeOption").val(code);
        $("#spanCaption").empty();
        $("#spanCaption2").empty();
        $("#spanCaption3").empty();

        $("input:radio").prop("checked", false);
        $('#option_1').prop("checked", true);

        if (code == 'spk_code') {
            $("#spanCaption").append('Vehicle Code, Color Code, SPK Order Date');
            $("#spanCaption2").append('SPK No.');
            $("#spanCaption3").append('SPK Date');
        }
        else if (code == 'tgl_urut') {
            $("#spanCaption").append('SPK Order Date, SPK Date & SPK No.');
            $("#spanCaption2").append('SPK No.');
            $("#spanCaption3").append('SPK Date');
        }
        else if (code == 'matching') {
            $("#spanCaption").append('SPK Date & SPK No.');
            $("#spanCaption2").append('SPK No.');
            $("#spanCaption3").append('Purchase invoice no.');
        }
        else if (code == 'stock') {
            $("#spanCaption").append('Vehicle Code ,Color Code, Stock Date');
            $("#spanCaption2").append('Stock Date & Purchase invoice no.');
            $("#spanCaption3").append('Purchase invoice no.');
        }

    }

    function print_sc_slip(action) {
        var row = $("#matched").datagrid('getSelected');
        var user = '<?php echo $_SESSION['C_USER']; ?>';

        if (row) {
            var url = site_url + 'transaction/spk/printSlipSpkMatch/<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>/' + user + '/' + action + '/' + row.id;

            if (action == 'screen') {
                window.open(url);
            } else {
                $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        } else {
            alert('Please choose a data to print');
        }
    }
</script>
