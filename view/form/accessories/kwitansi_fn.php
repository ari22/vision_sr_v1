<script>
    var table = 'acc_slh';
    $(document).ready(function () {
        $('.loader').hide();
         version('02.04-17');
        dateFromTo();

        $('#date_from').datebox('setValue', '01/<?php echo date('m/Y'); ?>');
        $('#date_to').datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $('#date').datebox('setValue', '<?php echo date('d/m/Y'); ?>');
        $("#sal_inv_no2").empty();
        // spkData();
        $("#sal_inv_no").combogrid({
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id);
            }
        });
        enable();
    });

    function enable() {
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#sal_inv_no2").empty();
                $('#date_from').datebox('disable');
                $('#date_to').datebox('disable');
                $("#id").val('');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $("#sal_inv_no").combogrid('enable');
                }
                if (group == 2) {
                    $('#date_from').datebox('enable');
                    $('#date_to').datebox('enable');
                    getInvoice();
                }

            }
        });


        $("#group_by").combobox('enable');
        $("#sal_inv_no").combogrid('enable');
        $("#date").datebox('enable');
        $("#mounth").combobox('enable');
        $("#year").attr('disabled', false);

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
                getInvoice();
            }
        });
        $('#date_to').datebox({
            onSelect: function (date) {
                getInvoice();
            }
        });
    }
    function getInvoice() {
        var group = $("#group_by").combobox('getValue');
        var from = $('#date_from').datebox('getValue');
        var to = $('#date_to').datebox('getValue');

        $("#sal_inv_no2").empty();
        var url = site_url + 'form/datalist/<?php echo encrypt_decrypt('encrypt', 'acc_slh'); ?>/accsj/' + group;
        $.post(url, {from: from, to: to}, function (res) {
            var json = $.parseJSON(res);

            $.each(json, function (i, v) {
                $("#sal_inv_no2").append('<option value="' + v.id + '">' + v.sal_inv_no + '</option>');
            });
        });
    }

    function spkData() {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        //alert("<?php echo $site_url . 'form/sal_inv_no/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>/" + mounth + "/" + year)
        $('#sal_inv_no').combogrid({
            panelWidth: 550,
            mode: 'remote',
            idField: 'id',
            textField: 'sal_inv_no',
            fitColumns: false,
            pagination: true,
            sortName: 'sal_inv_no',
            sortOrder: 'asc',
            remoteSort: true,
            multiSort: true,
            url: "<?php echo $site_url . 'form/sal_inv_no/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>/" + mounth + "/" + year,
            columns: [[
                    {field: 'sal_inv_no', title: '<?php getCaption("Nomor Rangka"); ?>', width: 160},
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

        $("#sal_inv_no").combogrid('enable');
    }



    function print_window(action) {

        var group = $("#group_by").combobox('getValue');
        var stat = true;
        var msg = 'Please Choose Chassis';
        if (group == 1) {
            var id = $("#id").val()
            //  var msg = 'Please Choose Chassis';
        } else {
            var id = $("#sal_inv_no2").val();
            $("#id").val(id)
            // var msg = 'Chassis List empty';
        }

        if (group == 3) {
            var id = '';
            var msg = 'Sorry, this sal_inv_no not closed in the Sales Invoice.<br />Please Close the Sales and try to print again.';
        }

        if (id == null) {
            stat = false;
        }

        if (id == '') {
            stat = false;
        }

        if (stat !== false) {
            if (action == 'screen') {
                $("#buttonSJ").empty().append('<button type="button" id="button_FSJ" title="<?php getCaption("Screen Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-print\'" onclick="printScreenSJ(\'screen\');">Ok</button>');
            }
            if (action == 'print') {
                $("#buttonSJ").empty().append('<button type="button" id="button_FSJ" title="<?php getCaption("Print Faktur"); ?>" class="easyui-linkbutton" data-options="iconCls:\'icon-print\'" onclick="printScreenSJ(\'print\');" >Ok</button>');
            }

            $("#button_FSJ").linkbutton();
            dataType();

            $.post(site_url + 'transaction/vehicle/load_invoice', {table: table, id: id}, function (json) {
                var rowData = $.parseJSON(json);

                var price_ad = rowData.inv_total - rowData.pay_val;	//n
                var piutang = price_ad;

                $('#form_validation4 input:text').val('');
                $("#form_validation4").form('load', {
                    wrhs_code: rowData.wrhs_code,
                    lease_code: rowData.lease_code,
                    lease_name: rowData.lease_name,
                    veh_name: rowData.veh_name,
                    key_no: rowData.key_no,
                    cust_name: rowData.cust_name,
                    cust_rname: rowData.cust_rname,
                    lease_name2: rowData.lease_name,
                    crd_cntrno: rowData.crd_cntrno,
                    // crd_cntrdt: rowData.crd_cntrdt,
                    crd_amount: rowData.crd_amount
                });

                if (rowData.crd_cntrdt !== '0000-00-00') {
                    var vdate = dateSplit(rowData.crd_cntrdt);

                    $("#crd_cntrdt").datebox('setValue', vdate);
                }
                $("#WindowSJ").window('open');

            });

        } else {
            showAlert("Information", '<font color=red>' + msg + '<font>');
        }
    }

    function print_sc(key) {
        var group = $("#group_by").combobox('getValue');
        var stat = true;
        var msg = 'Please Choose Chassis';
        var date = $('#date').datebox('getValue');
        var date = date.split('/');
        var date = date[2]+'-'+date[1]+'-'+date[0];
        

        if (group == 1) {
            var id = $("#id").val()
            var msg = 'Please Choose Invoice No.';
        } else {
            var id = $("#sal_inv_no2").val();
            $("#id").val(id)
            var msg = 'Invoice No. List empty';
        }

        if (id == null) {
            stat = false;
        }

        if (id == '') {
            stat = false;
        }

        if (stat !== false) {
            var type = $('input[name="data_type"]:checked', '#form_validation4').val();
            var ids = $("#id").val();
            var url = site_url + 'transaction/form/outputpdf/<?php echo encrypt_decrypt('encrypt', 'acc_slh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + key + '/' + type + '/<?php echo encrypt_decrypt('encrypt', 'AKW'); ?>/'+date+'#toolbar=0';

            if (key == 'screen') {
                window.open(url);
            }

            if (key == 'print') {
                $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
            }
        } else {
            showAlert("Information", '<font color=red>' + msg + '<font>');
        }
    }

</script>
