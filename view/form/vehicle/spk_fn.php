<script>
    var table = 'veh_spk';
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
        $("#so_no2").empty();
        spkData();

        enable();
    });

    function enable() {
        $('#group_by').combobox({
            onSelect: function (index, row) {
                $('.easyui-combogrid').combogrid('disable');
                $('.easyui-combogrid').combogrid('setValue', '');
                $("#so_no2").empty();
                $('#date_from').datebox('disable');
                $('#date_to').datebox('disable');
                $("#id").val('');

                var group = $(this).combobox('getValue');

                if (group == 1) {
                    $("#so_no").combogrid('enable');
                    spkData();
                }
                if (group == 2) {
                    $('#date_from').datebox('enable');
                    $('#date_to').datebox('enable');
                    getSPK();
                }
                if (group == 3) {
                    $("#so_no").combogrid('disable');
                    $('#date_from').datebox('disable');
                    $('#date_to').datebox('disable');
                    getSPK();
                }

            }
        });


        $("#group_by").combobox('enable');
        $("#so_no").combogrid('enable');
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
                getSPK();
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
                    getSPK();
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
                getSPK();
            }
        });
        $('#date_to').datebox({
            onSelect: function (date) {
                getSPK();
            }
        });
    }
    function getSPK() {
        var group = $("#group_by").combobox('getValue');
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        var from = $('#date_from').datebox('getValue');
        var to = $('#date_to').datebox('getValue');

        $("#so_no2").empty();
        var url = site_url + 'form/datalist/<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>/spk/' + group;
        $.post(url, {from: from, to: to, mounth: mounth, year: year}, function (res) {
            var json = $.parseJSON(res);

            $.each(json, function (i, v) {
                $("#so_no2").append('<option value="' + v.id + '">' + v.so_no + '</option>');
            });
        });

        $("#so_no2").change(function () {
            var id = $(this).val();
            $("#id").val(id)
        });
    }

    function spkData() {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        //alert("<?php echo $site_url . 'form/so_no/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/" + mounth + "/" + year)
        $('#so_no').combogrid({
            panelWidth: 550,
            mode: 'remote',
            idField: 'so_no',
            textField: 'so_no',
            fitColumns: false,
            pagination: true,
            sortName: 'so_no',
            sortOrder: 'asc',
            url: "<?php echo $site_url . 'form/spk/' . encrypt_decrypt('encrypt', 'veh_spk'); ?>/" + mounth + "/" + year,
            columns: [[
                    {field: 'so_no', title: '<?php getCaption("No. SPK"); ?>', width: 100},
                    {field: 'so_date', title: '<?php getCaption("Tgl. SPK"); ?>', width: 90, formatter: formatDate},
                    {field: 'match_date', title: '<?php getCaption("Tanggal Match"); ?>', width: 90, formatter: formatDate},
                    {field: 'sal_inv_no', title: '<?php getCaption("No. Faktur Jual"); ?>', width: 120},
                    {field: 'sal_date', title: '<?php getCaption("Tgl. Faktur Jual"); ?>', width: 150, formatter: formatDate},
                ]],
            onSelect: function (index, rowData) {
                $("#id").val(rowData.id)
            }
        });

        $("#so_no").combogrid('enable');
    }



    function print_sc(action) {

        var group = $("#group_by").combobox('getValue');
        var stat = true;
        var msg = 'Please Choose SPK No.';
        if (group == 1) {
            var id = $("#id").val()
            //  var msg = 'Please Choose Chassis';
        }
        if (group == 2) {
            var id = $("#so_no2").val();

        }


        if (id == null) {
            stat = false;
        }

        if (id == '') {
            stat = false;
        }

        if (stat !== false) {
            print_spk(action);
        } else {
            showAlert("Information", '<font color=red>' + msg + '<font>');
        }
    }

    function print_spk(action) {
        var mounth = $("#mounth").combobox('getValue');
        var year = $("#year").val();
        
        var id = $("#id").val();
        var user = '<?php echo $_SESSION['C_USER']; ?>';
        //var url = base_url + 'print/index.php?id=' + id + '&user=' + user ;
        var url = site_url + 'transaction/spk/outputpdf/<?php echo encrypt_decrypt('encrypt', 'veh_spk'); ?>/' + id + '/' + user + '/' + action +'/' + mounth + '/' + year + '#toolbar=0';


        if (action == 'screen') {
            // $('#sr').window('open');
            window.open(url);
        } else {
            $('#sr').empty().append('<iframe   frameborder="0"  src="' + url + '" style="width:100%;height:auto;min-height: 500px;padding:0px;"></iframe>');
        }

    }

    

</script>
