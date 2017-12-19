<script>
    var getDataUrl = site_url + 'utility/getData';
    var table;

    $(document).ready(function ()
    {

        //console.log( "ready!" );
        var date = '<?php echo date('Y-m-d') ?>';
        $('#date_from').datebox('setValue', date);
        $('#date_to').datebox('setValue', date);

        $(".loader").hide(1000);
        version('04.17-25');

        $("#inv_type").combobox({
            onSelect: function (index, row) {
                $("#supp_name").combogrid('disable');
                $("#dt_tbl").datagrid('loadData', {"total": 0, "rows": []});
                var inv_type = $(this).combobox('getValue');

                if (inv_type == '1') {
                    $("#supp_name").combogrid('enable');
                    table = 'veh_prh';
                } else {
                    table = 'veh_slh';
                }

                $("#table").val(table);
            }
        });

        setEnable();


    });
    function setEnable()
    {
        $('.loader').hide();
        $("#inv").combobox('enable');
        $("#inv_type").combobox('enable');
        $("#wrhs_code").combogrid('enable');
        $('#date_from').datebox('enable');
        $('#date_to').datebox('enable');
        $("#dt_tbl").datagrid('reload');

        var inv_type = $("#inv_type").combobox('getValue');

        if (inv_type == '1') {
            $("#supp_name").combogrid('enable');
            table = 'veh_prh';

        } else {
            table = 'veh_slh';
        }

        $("#table").val(table);
    }
    function getData() {

        var form = $("#form_validation").serialize();
        var geturl = getDataUrl + '?' + form;

        $("#dt_tbl").datagrid({
            method: 'post',
            url: geturl,
            rownumbers: true,
            singleSelect: false,
            // toolbar: toolbar,
            remoteSort: true,
            multiSort: true,
            pagination: true,
            columns: [[
                    {field: 'ck', checkbox: true},
                    {field: 'inv_no', title: '<?php getCaption("No. Faktur"); ?>', width: 130, height: 20},
                    {field: 'inv_date', title: '<?php getCaption("Tgl. Faktur"); ?>', width: 100, height: 20, sortOrder: 'desc', formatter: formatDate},
                    {field: 'fp_no', title: '<?php getCaption("No. Faktur Pajak"); ?>', width: 200, height: 20},
                    {field: 'fp_date', title: '<?php getCaption("Tgl. Faktur Pajak"); ?>', width: 120, height: 20, sortOrder: 'desc', formatter: formatDate},
                    //{field: 'cust_code', title: '<?php getCaption("Kode Pelanggan"); ?>', width: 150, height: 20},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>', width: 280, height: 20},
                    {field: 'total', title: '<?php getCaption("Total"); ?>', width: 150, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                ]]
        });
    }

    function getSelections() {
        var ids = [];
        var rows = $('#dt_tbl').datagrid('getSelections');
        for (var i = 0; i < rows.length; i++) {
            ids.push(rows[i].inv_no);
        }
        alert(ids.join('\n'));
    }

    function exportTable() {
        var ss = [];
        var rows = $('#dt_tbl').datagrid('getSelections');
        var data = "";

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            ss.push('<span>' + row.inv_no + '</span>');
            if (data.length >> 0) {
                data = data + ",";
            }
            data = data + "'" + row.inv_no + "'";
        }

        if (data !== '') {

            $.post(site_url + 'utility/exportData', {data: data}, function (res) {
                //alert(res); return false;
                var json = $.parseJSON(res);
                //var rows = json.rows;

                JSONToCSVConvertor(json, '', true);
                window.open('data:application/vnd.ms-excel,' + html);
            });

        } else {
            showAlert("Error export", '<font color="red">No data selected to export</font>');
        }
    }

    function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {

        var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

        var CSV = '';

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
        //var fileName = "<?php echo date('Ymdhis'); ?>";
        let now = new Date();

        year = now.getFullYear();
        datenow = now.getDate();
        mounth = now.getMonth();
        hour = now.getHours();
        minute = now.getMinutes();
        second = now.getSeconds();

        //Generate a file name
        var fileName = year + '' + mounth + '' + datenow + '' + hour + '' + minute + '' + second;
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += ReportTitle.replace(/ /g, "_");

        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

        var link = document.createElement("a");
        link.href = uri;

        link.style = "visibility:hidden";
        link.download = fileName + ".csv";

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>