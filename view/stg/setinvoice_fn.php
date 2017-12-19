<script>
    $('.loader').hide();
    var divtableId = $("#tableId");
    var table = 'inv_seq';
    var save_url = site_url + 'transaction/setting/saveResetInvoice';
    var refresh_url = site_url + 'transaction/setting/refreshInvNo';
    var form = $('#form_validation');


    $('#inv_mth').combobox({
        onSelect: function (index, row) {
            $("#cmdReset").linkbutton('disable');
            $("#inv_no").val('');
        }
    });

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function inv_typeData() {
        $('#remark').combogrid({
            panelWidth: 350,
            mode: 'remote',
            idField: 'inv_type',
            textField: 'remark',
            fitColumns: false,
            pagination: true,
            sortName: 'inv_type',
            sortOrder: 'asc',
            remoteSort: true,
            multiSort: true,
            url: "services/runCRUD.php?func=datasource&lookup=stg/inv_seq&pk=inv_type&sk=remark&order=remark",
            columns: [[
                    {field: 'inv_type', title: '<?php getCaption("Kode"); ?>', width: 70},
                    {field: 'remark', title: '<?php getCaption("Nama"); ?>', width: 300},
                ]],
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id);

                read_show('');
            }
        });

        $("#remark").combogrid('enable');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {

            $('#inv_year').val('');
            $('#inv_no').val('');
            $("#inv_mth").combobox('setValue', '');
            $("#inv_type").val('');

            if (json !== '[]') {
                // setEnable();
                var rowData = $.parseJSON(json);
                var inv_type = rowData.inv_type;

                $("#id").val(rowData.id);
                $("#inv_year").val(rowData.inv_year);
                $("#inv_mth").combobox('setValue', rowData.inv_mth);
                $("#remark").combogrid('setValue', rowData.remark);
                $("#inv_type").val(rowData.inv_type);

                $.post(site_url + 'main/get_number/' + inv_type, function (num) {
                    $("#form_validation #inv_no").val(num);
                });
                setEnable();
            }

            $('.loader').hide();
        });
    }
    function setEnable() {
        $("#remark").combogrid('enable');
        $("#inv_mth").combobox('enable');
        $("#inv_year").attr('disabled', false);
        //$('.cmdFirst').attr('disabled', false);
        $("#cmdReset").linkbutton('enable');
    }
    function saveData() {
        $('.loader').show();
        //$('#form_validation :input').attr('disabled', false);

        form.form('submit', {
            url: save_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    read_show('');
                    showAlert("Information", obj.message);

                } else
                {
                    $('.loader').hide();

                    showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }

    function refreshInvno() {
        $('.loader').show();
        //$('#form_validation :input').attr('disabled', false);
        form.form('submit', {
            url: refresh_url,
            onSubmit: function () {
                return $(this).form('validate');
            },
            success: function (data) { 
                var obj = JSON.parse(data);
                if (obj.success == true) {
                    read_show('');
                    showAlert("Information", obj.message);

                } else
                {
                     read_show('');
                    $('.loader').hide();

                   // showAlert("Error while saving", '<font color="red">' + obj.message + '</font>');
                }
            }
        });
    }
    $(document).ready(function () {
        tableId();
        inv_typeData();
        read_show('');
        version('05.04-17');
    });

</script>