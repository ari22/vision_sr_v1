<script>
    var mounth;
    var year;
        
    $(document).ready(function () {
        $('.loader').hide();
        version('02.04-17');

        changeYear();
        changeMounth();
        setEnable();

    });

    function disableButton() {
        $("#screen").linkbutton('disable');
        $("#print").linkbutton('disable');
    }
    function enableButton() {
        $("#screen").linkbutton('enable');
        $("#print").linkbutton('enable');
    }
    function setEnable()
    {
        $('#process').linkbutton('enable');
        $("#so_no").combogrid('enable');
        $('#period1').combobox('enable');
        $('#form_validation #year1').attr('disabled', false);
        // $('#form_validation #year2').attr('disabled', false);
        getSPK();
        table_grid(null, null, null);
        disableButton();
    }
    function changeYear() {
        $("#year1").keyup(function () {
            getSPK();
        });
    }
    function changeMounth() {
        $('#period1').combobox({
            onSelect: function (index, row) {
                getSPK();
            }
        });
    }
    function showSearch(lcOutput) {


        var so_no = $("#so_no").combogrid('getValue');
        var state = true;
        var msg = '';

        mounth1 = $("#period1").combobox('getValue');
        year1 = $("#year1").val();

        mounth2 = $("#period2").combobox('getValue');
        year2 = $("#year2").val();

        var date1 = new Date(mounth1 + '/01/' + year1);
        var date1 = date1.getTime();
        var date2 = new Date(mounth2 + '/01/' + year2);
        var date2 = date2.getTime();

        if (so_no == '') {
            state = false;
            msg = 'Invoice No. not empty!';
        }
        if (mounth1 == '') {
            state = false;
            msg = 'Period not empty!';
        }
        if (mounth2 == '') {
            state = false;
            msg = 'Until not empty!';
        }
        if (year1 == '') {
            state = false;
            msg = 'Year not empty!';
        }
        if (year2 == '') {
            state = false;
            msg = 'Year not empty!';
        }


        if (parseInt(date1) > parseInt(date2)) {
            state = false;
            msg = 'Period not be more than Until';
        }


        if (state !== false) {
            newdate1 = year1 + '-' + mounth1 + '-01';
            newdate2 = year2 + '-' + mounth2 + '-31';

            if (lcOutput == 'process') {
                $("#po_no, #wrhs_code, #color_code, #color_name, #chassis, #engine, #supp_code, #supp_name, #supp_invno").val('');
                $('#form_validation .easyui-numberbox').numberbox('setValue', '');

                table_grid(null, null,null);
                disableButton();

                $.post(site_url + 'history/read/?so_no=' + so_no + '&so_date1=' + newdate1 + '&so_date2=' + newdate2, {table: '<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>', nav: '', id: ''}, function (json) {

                    if (json !== '[]') {

                        var rowData = $.parseJSON(json); 
                        $.each(rowData, function (i, v) {
                            if (v !== '') {
                                $("#form_validation #" + i).val(v);

                                if (i == 'tot_price') {
                                    $("#form_validation #" + i).numberbox('setValue', v);
                                }
                            }

                        });
                        
                        mounth = rowData.mounth;
                        year = rowData.year;
                        
                        table_grid(so_no, year2, rowData.db);
                    } else {
                        showAlert("Message", '<font color="red">Data not available</font>');
                    }
                });

                enableButton();
            } else {
                url = "services/runCRUD.php";

                var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
                var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
                var URL = url + "?lookup=rpt/history/hutangkendaraan"
                        + "&output=" + lcOutput
                        + "&so_no=" + so_no
                        + "&pur_date1=" + newdate1
                        + "&pur_date2=" + newdate2;

                URL = URL + '#toolbar=0';
                if (lcOutput !== 'screen') {
                    $("#screenWindow").empty().append('<iframe frameborder="0"  src="' + URL + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
                } else {
                    var win = window.open(URL, "_blank", strWindowFeatures);
                }
            }


        } else {
            $("#so_no, #wrhs_code, #cust_code, #cust_name, #veh_code, #veh_name, #color_code, #color_name, #chassis, #engine, #veh_type, #veh_transm, #veh_model, #veh_year").val('');
            $('#form_validation .easyui-numberbox').numberbox('setValue', '');

            table_grid(null, null, null);
            disableButton();
            showAlert("Message", '<font color="red">' + msg + '</font>');
        }
    }

    function table_grid(so_no, year, db) {
        var url = site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_dpcd'); ?>/so_no/' + so_no + '/year/' + year + '?db='+db+'&grid=true';

        $("#tbl_dtl").datagrid({
            method: 'post',
            url:url,
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
                    {field: 'dp_inv_no', title: 'No. Faktur', width: 120, height: 20, sortable: true},
                    {field: 'pay_date', title: '<?php getCaption("Tgl. Bayar"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'bank_code', title: '<?php getCaption("Bank"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'pay_type', title: '<?php getCaption("Jenis Bayar"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_no', title: '<?php getCaption("No. Check"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'check_date', title: '<?php getCaption("Tanggal Check"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'due_date', title: '<?php getCaption("Tgl J. Tempo"); ?>', width: 100, height: 20, sortable: true, formatter: formatDate},
                    {field: 'pay_val', title: '<?php getCaption("Pembayaran"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Diskon"); ?>', width: 120, height: 20, sortable: true, align: "right", formatter: formatNumber},
                    {field: 'pay_desc', title: '<?php getCaption("Keterangan"); ?>', width: 200, height: 20, sortable: true},
                    {field: 'coll_code', title: '<?php getCaption("Kolektor"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'add_by', title: 'Added By', width: 120, height: 20, sortable: true},
                    {field: 'add_date', title: 'Tgl. Buat', width: 120, height: 20, sortable: true, formatter: formatDate},
                    {field: 'tts_no', title: 'No. Kwitansi', width: 120, height: 20, sortable: true},
                    {field: 'tts_date', title: 'Tgl. Kwitansi', width: 120, height: 20, sortable: true, formatter: formatDate}
                ]]
        });
    }

    function getSPK() {
        var mounth1 = $("#period1").combobox('getValue');
        var year1 = $("#year1").val();
        
        var mounth2 = $("#period2").combobox('getValue');
        var year2 = $("#year2").val();
        
        var url = "<?php echo $site_url . 'form/spk/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/" + mounth1 + "/" + year1 +"/status/" + mounth2 + "/" + year2;
        
        $('#so_no').combogrid({
            panelWidth: 550,
            mode: 'remote',
            idField: 'so_no',
            textField: 'so_no',
            fitColumns: false,
            pagination: true,
            sortName: 'so_no',
            sortOrder: 'asc',
            url:url,
            columns: [[
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 100},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                    {field: 'veh_name', title: '<?php getCaption("Nama Kendaraan"); ?>', width: 200},
                    {field: 'srep_name', title: '<?php getCaption("Nama Sales"); ?>', width: 200},
                    {field: 'cust_name', title: '<?php getCaption("Nama Pelanggan"); ?>', width: 200},
                    {field: 'cust_rname', title: 'STNK Name', width: 200}
                ]],
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id)
            }
        });
        $("#so_no").combogrid('enable');

    }
    function print_sc(action) {

        var ids = $("#form_validation #id").val();
        var url = site_url + 'transaction/form/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>/' + ids + '/<?php echo $_SESSION['C_USER']; ?>/' + action + '?year='+year+'&mounth='+mounth+'#toolbar=0';

        if (action == 'screen') {
            window.open(url);
        } else {
            $("#sr").empty().append('<iframe frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }
    }
</script>