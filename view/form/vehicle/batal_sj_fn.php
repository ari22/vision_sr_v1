<script>
    $(document).ready(function () {
        $('.loader').hide();
         version('02.04-17');
        spkData();
        setEnable();
    });

    function setEnable()
    {
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#form_validation .easyui-datebox").datebox('setValue', '');
                $('#form_validation #id').val('');

                 $('#form_validation #canc_note,#chassis,#sj_no,#so_no,#sal_inv_no,#veh_code,#veh_name,#chassis,#veh_type,#engine,#veh_model,#veh_brand,#veh_transm,#veh_year,#color_code,#color_name,#color_type,#cust_code,#cust_name,#cust_addr,#cust_area,#cust_city,#cust_zipcode').val('');
      
                $("#chassis2").empty();

                $("#id").val('');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $("#chassis").combogrid('enable');
                }
                if (group == 2) {
                    getChassis();
                }
            }
        });

        $("#group_by").combobox('enable');
        $("#chassis").combogrid('enable');
        $('#form_validation #canc_note').attr('disabled', false);
    }

    function spkData() {
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
            remoteSort: true,
            multiSort: true,
            url: "<?php echo $site_url . 'form/chassis/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>",
            //url: "<?php echo $site_url . 'builder/combogrid/' . encrypt_decrypt('encrypt', 'veh_slh'); ?>",
            columns: [[
                    {field: 'chassis', title: '<?php getCaption("Nomor Rangka"); ?>', width: 160, sortable: true},
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 100},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?>', width: 120},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur Jual"); ?>', width: 150, formatter: formatDate},
                    {field: 'opn_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                ]],
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id);
                 disableEmptyButton();

                if (rowData !== '[]') {

                    $.each(rowData, function (i, v) {
                        $("#form_validation #" + i).val(v);
                        if (i == 'so_date' || i == 'sj_date' || i == 'sal_date') {
                            if (v !== '0000-00-00') {
                                var v_date = dateSplit(v);
                                $("#" + i).datebox('setValue', v_date);
                            }
                        }
                        if (i == 'tot_price') {
                            $("#" + i).numberbox('setValue', v);
                        }
                    });

                    $('#process').linkbutton('enable');
                }
            }
        });

        $("#chassis").combogrid('enable');
    }

    function getChassis() {
        var group = $("#group_by").combobox('getValue');
        $("#chassis2").empty();
        var url = site_url + 'form/datalist/<?php echo encrypt_decrypt('encrypt', 'veh_slh'); ?>/btlsj/' + group;

        $.post(url, function (res) {
            if (res !== 'null') {
                var json = $.parseJSON(res);

                $.each(json, function (i, v) {
                    $("#chassis2").append('<option value="' + v.id + '">' + v.chassis + '</option>');
                });
            } else {
                showAlert("Information", '<font color="red">Chassis Not Available</font>');
            }
        });
    }

    function cancelling() {
        var sj_no = $("#sj_no").val();
        $.messager.confirm('Confirmation', 'This process will cancel DO (SJ) No. <b>' + sj_no + '</b>. Are you sure you want to proceed? ', function (r) {
            var c_note = $("#canc_note").val();
            var id = $("#id").val();

            if (c_note !== '') {
                $.post(site_url + 'form/UJKwitcancel', {canc_by: '<?php echo $_SESSION['C_USER']; ?>', canc_note: c_note, id: id,form:'uj'}, function (json) {
                   
                    obj = JSON.parse(json);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        disableEmptyButton();
                        var data = [];

                        $("#chassis").combogrid('grid').datagrid('loadData', data);
                        $("#chassis2").empty();
                    } else
                    {
                        $('.loader').hide();
                        showAlert("Error Cancellation", '<font color="red">' + obj.message + '</font>');
                    }
                });
            } else {
                showAlert("Information", '<font color=red>Please enter the cancellation description<font>');
                $("#canc_note").focus();
            }
        });

    }

    function disableEmptyButton() {
        $('#process').linkbutton('disable');
        $("#form_validation .easyui-datebox").datebox('setValue', '');
        $('#form_validation #id').val('');

        $('#form_validation #canc_note,#chassis,#sj_no,#so_no,#sal_inv_no,#veh_code,#veh_name,#chassis,#veh_type,#engine,#veh_model,#veh_brand,#veh_transm,#veh_year,#color_code,#color_name,#color_type,#cust_code,#cust_name,#cust_addr,#cust_area,#cust_city,#cust_zipcode').val('');
        
    }
</script>