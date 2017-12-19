<script>
    $(document).ready(function () {
        $('.loader').hide();
        $("#so_no").combogrid({
            onSelect: function (index, rowData) {
                disableEmptyButton();

                if (rowData !== '[]') {

                    $.each(rowData, function (i, v) {
                        $("#form_validation #" + i).val(v);
                        if (i == 'so_date') {
                            if (v !== '0000-00-00') {
                                var v_date = dateSplit(v);
                                $("#" + i).datebox('setValue', v_date);
                            }
                        }
                        if (i == 'tot_price') {
                            $("#" + i).numberbox('setValue', v);
                        }
                    });
                    table_grid(rowData.so_no)
                    $('#process').linkbutton('enable');
                }
            }
        });
        setEnable();
        version('02.04-17');
    });

    function disableEmptyButton() {
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');
        $('#form_validation :input').val('');
        $("#process").linkbutton('disable');
    }
    function setEnable()
    {
        $("#so_no").combogrid('enable');
        $('#form_validation #canc_note').attr('disabled', false);
    }
    function cancelling() {
        var so_no = $("#so_no").combogrid('getValue');
        $.messager.confirm('Confirmation', 'This process will cancel SPK No. <b>' + so_no + '</b>. Are you sure you want to proceed? ', function (r) {
            var c_note = $("#canc_note").val();
            var id = $("#id").val();

            if (c_note !== '') {
                $.post(site_url + 'form/spkcancel', {canc_by: '<?php echo $_SESSION['C_USER']; ?>', canc_note: c_note, id: id}, function (json) {
                    obj = JSON.parse(json);
                    if (obj.success == true) {
                        $("#id").val('');
                        showAlert("Information", obj.message);
                        disableEmptyButton();
                        table_grid(null);
                        var data = [];

                        $("#so_no").combogrid('grid').datagrid('loadData', data);
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

    function table_grid(so_no) {
        $("#tbl_dtl").datagrid({
            method: 'post',
            url: site_url + '<?php echo 'builder/datagrid/' . encrypt_decrypt('encrypt', 'veh_spkd'); ?>/so_no/' + so_no + '/?grid=true',
            title: '<?php getCaption("Deskripsi Service"); ?>',
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
                    {field: 'wk_code', title: '<?php getCaption("Kode Pekerjaan"); ?>', width: 120, height: 20, sortable: true},
                    {field: 'wk_desc', title: '<?php getCaption("Nama Pekerjaan"); ?>', width: 400, height: 20, sortable: true},
                    {field: 'price_bd', title: '<?php getCaption("Harga Jual"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_pct', title: '<?php getCaption("Diskon"); ?> %', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'disc_val', title: '<?php getCaption("Jumlah Diskon"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'price_ad', title: '<?php getCaption("Harga Netto"); ?>', width: 120, height: 20, align: 'right', sortable: true, formatter: formatNumber},
                    {field: 'add_by', title: '<?php getCaption("Ditambahkan Oleh"); ?>', width: 100, height: 20, align: 'center', sortable: true}

                ]]
        });
    }
</script>
