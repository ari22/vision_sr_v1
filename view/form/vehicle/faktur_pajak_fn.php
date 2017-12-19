<script>
    var table = 'veh_slh';
    $(document).ready(function () {
        $('.loader').hide();
        version('02.04-17');

        fp_seq();
        changeMount();
        changeYear();
        dateFromTo();
        $("#mounth").combobox('setValue', '<?php echo date('m'); ?>');
        $("#year").val('<?php echo date('Y'); ?>');
        $('#date_from').datebox('setValue', '01/<?php echo date('m/Y'); ?>');
        $('#date_to').datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $('#date').datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $("#chassis2").empty();
        spkData();

        enable();
    });


    function enable() {
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#chassis2").empty();
                $('#date_from').datebox('disable');
                $('#date_to').datebox('disable');
                $("#id").val('');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $("#chassis").combogrid('enable');
                    spkData();
                }
                if (group == 2) {
                    $('#date_from').datebox('enable');
                    $('#date_to').datebox('enable');
                    getChassis();
                }
                if (group == 3) {
                    $("#chassis").combogrid('disable');
                    $('#date_from').datebox('disable');
                    $('#date_to').datebox('disable');
                    getChassis();
                }

            }
        });


        $("#group_by").combobox('enable');
        $("#chassis").combogrid('enable');
        $("#date").datebox('enable');
        $("#mounth").combobox('enable');
        $("#year").attr('disabled', false);

    }

    function fp_seq() {
        $(".loader").show();
        $.post(site_url + 'crud/read', {table: 'fp_seq', nav: '', id: 1}, function (json) {
            var rowData = $.parseJSON(json);

            $("#form_validation").form('load', {
                fp_no_beg: rowData.fp_no_beg,
                fp_no_end: rowData.fp_no_end,
                fp_no: rowData.fp_no
            });

            var fp_remain = parseInt(rowData.fp_no_end) - parseInt(rowData.fp_no);

            var fp_no = parseInt(rowData.fp_no) + 1
            var inv_no = rowData.fp_code1 + rowData.fp_code2 + '<?php echo date("y"); ?>.' + fp_no;


            $("#sign_sr").val(rowData.sign_sr);
            $("#title_sr").val(rowData.title_sr);
            $("#inv_no").val(inv_no);
            $("#fp_remain").numberbox('setValue', fp_remain);
            $(".loader").hide();
        });
    }
    function emptyList() {
        $("#chassis2").empty();
        $("#chassis").empty();
    }
    function changeYear() {
        $("#year").keyup(function () {
            emptyList();
            setDate();

            var group = $('#group_by').combobox('getValue');

            if (group == 1) {
                spkData();
            }
            if (group == 2) {
                getChassis();
            }

        });
    }
    function changeMount() {
        $('#mounth').combobox({
            onSelect: function (index, row) {
                emptyList();
                setDate();

                var group = $('#group_by').combobox('getValue');

                if (group == 1) {
                    spkData();
                }
                if (group == 2) {
                    getChassis();
                }


            }
        });


    }
    function setDate() {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();

        $('#date_from').datebox('setValue', '01/' + mounth + '/' + year);
        $('#date_to').datebox('setValue', '31/' + mounth + '/' + year);
    }

    function dateFromTo() {
        $('#date_from').datebox({
            onSelect: function (date) {
                getChassis();
            }
        });
        $('#date_to').datebox({
            onSelect: function (date) {
                getChassis();
            }
        });
    }
    function getChassis() {
        var group = $("#group_by").combobox('getValue');
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        var from = $('#date_from').datebox('getValue');
        var to = $('#date_to').datebox('getValue');

        $("#chassis2").empty();
        var url = site_url + 'form/datalist/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/sj/' + group;
        $.post(url, {from: from, to: to, mounth: mounth, year: year}, function (res) {
            var json = $.parseJSON(res);

            $.each(json, function (i, v) {
                $("#chassis2").append('<option value="' + v.id + '">' + v.chassis + '</option>');
            });
        });

        $("#chassis2").change(function () {
            var id = $(this).val();
            $("#id").val(id)
        });
    }

    function spkData() {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        //alert("<?php echo $site_url . 'form/chassis/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>/" + mounth + "/" + year)
        $('#chassis').combogrid({
            panelWidth: 550,
            mode: 'remote',
            idField: 'chassis',
            textField: 'chassis',
            fitColumns: false,
            pagination: true,
            sortName: 'chassis',
            sortOrder: 'asc',
            url: "<?php echo $site_url . 'form/chassis/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>/" + mounth + "/" + year,
            columns: [[
                    {field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 160},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 100},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?>', width: 120},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur Jual"); ?>', width: 150, formatter: formatDate},
                    {field: 'opn_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                ]],
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id)
            }
        });

        $("#chassis").combogrid('enable');
    }



    function print_window(action) {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        
        var group = $("#group_by").combobox('getValue');
        var stat = true;
        var msg = 'Please Choose Chassis';
        if (group == 1) {
            var id = $("#id").val()
            var msg = 'Please Select Chassis';
        }
        if (group == 2) {
            var id = $("#chassis2").val();

        }


        if (id == null) {
            stat = false;
        }

        if (id == '') {
            stat = false;
        }

        if (stat !== false) {
            if (action == 'screen') {
                $("#buttondiv").empty().append('<button type="button" id="button_P" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-ok\'" onclick="printScreen(\'screen\');">Ok</button>');
            }
            if (action == 'print') {
                $("#buttondiv").empty().append('<button type="button" id="button_P" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-ok\'" onclick="printScreen(\'print\');" >Ok</button>');
            }

            $("#button_P").linkbutton();
            dataType();

            $.post(site_url + 'crud/read', {table: table, nav: '', id: id, mounth:mounth, year:year}, function (json) {

                if (json !== '[]') {

                    var rowData = $.parseJSON(json);
                    $.each(rowData, function (i, v) {
                        if (i !== 'fp_no') {
                            $("#" + i).val(v);
                            if (i == 'cust_area' || i == 'cust_city' || i == 'cust_rarea' || i == 'cust_rcity') {
                                $("#" + i).combogrid('setValue', v);
                            }
                        }
                    });

                    $("#WindowS").window('open');
                }
            });

        } else {
            showAlert("Information", '<font color=red>' + msg + '<font>');
        }
    }

    function dataType() {

        $('#form_validationDetail  :input').attr('disabled', false);
        $('#form_validationDetail  .easyui-combogrid').combogrid('enable');
        $('#data_by').combobox({
            onSelect: function (index, row) {

                var data_by = $(this).combobox('getValue');

                $("#CustomerData").hide();
                $("#STNKData").hide();
                $("#debitorData").hide();

                if (data_by == 1) {

                    $("#CustomerData").show();
                }
                if (data_by == 2) {

                    $("#STNKData").show();
                }
                if (data_by == 3) {

                    $("#debitorData").show();
                }

                $('#form_validationDetail .easyui-combobox').combogrid('enable');
            }
        });
    }

    function printScreen(action) {
         var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        
        var date = $('#date').datebox('getValue');
        var date = date.split('/');
        var invoicedate = date[2] + '-' + date[1] + '-' + date[0];
        var inv_no = $("#inv_no").val();


        var ids = $("#id").val();
        var form = $("#form_validationDetail").serialize();
        var inv_no = '&inv_no=' + inv_no;
        var signature = $("#sign_sr").val();
        var jabatan = $("#title_sr").val();

        var url = site_url + 'transaction/form/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + action + '/' + signature + '/' + jabatan + '/' + invoicedate + '/' + mounth + '/' + year + '?' + form + inv_no + '#toolbar=0';

        if (action == 'screen') {
            window.open(url);
        }

        if (action == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }


    function closeWindows() {
        fp_seq();
        $('#WindowS').window('close');
    }

    function editNo() {
        $("#WindowEditNo").window('open');

        var jsonStr = {"total": 239, "rows": [
                {"code": "010", "name": "Normal"},
                {"code": "020", "name": "Bendahara Negara"},
                {"code": "030", "name": "BUMN"},
                {"code": "040", "name": "Pemberian cuma-cuma dan pemakaian pribadi"},
                {"code": "090", "name": "Penyerahan Aktiva"}]};

        $('#fp_code1').combogrid({
            panelWidth: 365,
            value: '010',
            idField: 'code',
            textField: 'code',
            loadData: jsonStr,
            columns: [[
                    {field: 'code', title: 'Code', width: 60},
                    {field: 'name', title: 'Name', width: 300}
                ]]
        });
        var g = $('#fp_code1').combogrid('grid');    // get the datagrid object
        g.datagrid('loadData', jsonStr);

        $.post(site_url + 'crud/read', {table: 'fp_seq', nav: '', id: 1}, function (json) {
            var rowData = $.parseJSON(json);

            var fp_code2 = rowData.fp_code2;
            var fp_code2 = fp_code2.split("-");

            $("#form_validationEditNo").form('load', {
                fp_code2: fp_code2[0],
                yy: '<?php echo date("y"); ?>',
                fp_no2: parseInt(rowData.fp_no) + 1
            });

        });
    }

    function setNo() {
        fp_code1 = $('#fp_code1').combogrid('getValue');
        fp_code2 = $("#fp_code2").val();
        yy = $("#yy").val();
        fp_no2 = $("#fp_no2").val();

        var inv_no = fp_code1 + '.' + fp_code2 + '-' + yy + '.' + fp_no2;
        $("#inv_no").val(inv_no);
        $('#WindowEditNo').window('close');
    }
</script>
