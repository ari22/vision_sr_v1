<script>
    var table = 'veh_slh';
    $(document).ready(function () {
        $('.loader').hide();
        version('02.04-17');
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
    }

    function spkData() {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();

        var url = "<?php echo $site_url . 'form/chassis/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>/" + mounth + "/" + year;
        $('#chassis').combogrid({
            panelWidth: 550,
            mode: 'remote',
            idField: 'id',
            textField: 'chassis',
            fitColumns: false,
            pagination: true,
            sortName: 'chassis',
            sortOrder: 'asc',
            remoteSort: true,
            multiSort: true,
            url: url,
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
            var msg = 'Please Choose Chassis';
        } else {
            var id = $("#chassis2").val();
            $("#id").val(id)
            var msg = 'Please Select Chassis';
        }

        if (group == 3) {
            var id = '';
            var msg = 'Sorry, this chassis not closed in the Sales Invoice.<br />Please Close the Sales and try to print again.';
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

            $.post(site_url + 'transaction/vehicle/load_invoice', {table: table, id: id, mounth:mounth, year:year}, function (json) {
                var rowData = $.parseJSON(json);

                var cust_type = rowData.cust_type;

                var stat = true;

                if (cust_type !== 2) {

                    var price_ad = rowData.inv_total - rowData.pay_val;	//n
                    //var piutang = price_ad;
                    var piutang = rowData.pd_end;

                    if (piutang > 0) {

                        if (rowData.lease_code !== '' && rowData.salpaytype == '1') {
                            showAlert("Information", 'There is still outstanding AR : <b>' + formatNumber(piutang) + '</b>');
                        } else {
                            showAlert("Information", 'There is still outstanding AR : <b>' + formatNumber(piutang) + '</b>');
                            //showAlert("Information", 'Sorry, Account Receivable still available : ' + formatNumber(piutang) + '<br /><br />Make sure there are Leasing Name, No. Contract, Contract date and the number of credits exceeds Receivables');
                        }
                        return false;
                        stat = false;
                    }

                }

                if (stat !== false) {

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

                }


            });

        } else {
            showAlert("Information", '<font color=red>' + msg + '<font>');
        }
    }
    function dataType() {
        $('.radio').change(function () {
            if ($(this).is(':checked')) {
                var type = $('input[name="data_type"]:checked', '#form_validation4').val();
                var lease_code = $("#form_validation #lease_code").val();

                if (type == 'debitur') {
                    if (lease_code == '') {
                        $("#form_validation4 input:radio").prop("checked", false);
                        alert('Debitur/QQ data is empty. Please select other option(s)');
                        $('#data_type1').prop("checked", true);
                    }
                }
            }
        });


    }

    function printScreenSJ(action) {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        var type = $('input[name="data_type"]:checked', '#form_validation4').val();
        var ids = $("#id").val();
        var url = site_url + 'transaction/vehicle/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + action + '/' + type + '/' + mounth + '/' + year + '#toolbar=0';

        if (action == 'screen') {
            window.open(url);
        }

        if (action == 'print') {
            $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }

</script>
