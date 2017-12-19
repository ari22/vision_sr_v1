<script>
    var table = 'veh_stk';
    var form = $('#form_validation');
    var divtableId = $("#tableId");
    var stat = 0;

    var refresh_url = site_url + 'transaction/vehicle/refreshStock';

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }
    function read_show(nav) {
        var id = $("#form_validation #id").val();
        stat = 0;
        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) { 

            emptyForm();
            cmdcondAwal();
            if (json !== '[]') {

                var rowData = $.parseJSON(json);

                $.each(rowData, function (i, v) {
                    if (v !== '') {
                        $("#" + i).val(v);


                        if (i == 'pur_date' ||
                                i == 'cls_date' ||
                                i == 'sal_date' ||
                                i == 'match_date' ||
                                i == 'pred_stk_d' ||
                                i == 'stk_date' ||
                                i == 'sji_date' ||
                                i == 'kwiti_date' ||
                                i == 'fpi_date' ||
                                i == 'dni_date' ||
                                i == 'do_date' ||
                                i == 'pdi_date' ||
                                i == 'po_date') {

                            if (v !== '0000-00-00') {
                                var vdate = dateSplit(v);
                                $("#" + i).datebox('setValue', vdate);
                            }

                        }
                        if (i == 'wrhs_orig') {
                            $("#" + i).combogrid('setValue', v);
                        }
                        if (i == 'loc_code') {

                            $("#" + i).combogrid('setValue', v);
                        }
                    } else {
                        $("#" + i).val('');
                    }

                });
                var hari = hitungSelisihHari(rowData.stk_date, '<?php echo date("Y-m-d h:i:s"); ?>');
                $("#hari").empty().append(hari);
                $("#chassis_cp").val(rowData.chassis);

            }else {
                cmdcondAwal();
                cmdEmptyData();
            }

             $(".loader").hide();


        });
    }
    function getSearchselect() {
        var row = $("#tableSearch").datagrid('getSelected');

        if (row) {
            $("#form_validation #id").val(row.id);
            $('#windowSearch').window('close');
            $("#actionSearch").empty()
            $("#SearchOption").hide();
            read_show('');

        }
    }
    function close_search() {
        $('#windowSearch').window('close');
        $("#actionSearch").empty()
        $("#SearchOption").hide();
    }
    function emptyForm() {
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        $("#form_validation input:radio").prop("checked", false);
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');

    }


    function hitungSelisihHari(tgl1, tgl2) {
        // varibel miliday sebagai pembagi untuk menghasilkan hari
        var miliday = 24 * 60 * 60 * 1000;
        //buat object Date
        var tanggal1 = new Date(tgl1);
        var tanggal2 = new Date(tgl2);
        // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
        var tglPertama = Date.parse(tanggal1);
        var tglKedua = Date.parse(tanggal2);
        var selisih = (tglKedua - tglPertama) / miliday;
        return Math.round(selisih);
    }


    function condEdit() {
        stat = 1;
        changeLoc();
        cmdcondReady();

    }

    function changeLoc() {
        if (stat == '1') {
            $("#loc_code").combogrid({
                onSelect: function (index, row) {
                    if (stat == '1') {
                        var id = $("#id").val();
                        $.post(site_url + 'crud/update', {table: table, id: id, field: 'id', loc_code: row.loc_code}, function () {
                            read_show('');
                        });
                    }
                    //return false;
                }
            });

        }
    }
    function condCancel() {
        cmdcondAwal();
        read_show('');
    }
    function cmdcondReady() {
        //$("#cmdSave").show();
        //$("#cmdCancel").show();
        $('.cmdFirst').attr('disabled', true);
        $('.cmdPrev').attr('disabled', true);
        $('.cmdNext').attr('disabled', true);
        $('.cmdLast').attr('disabled', true);
        $('.cmdSave').removeAttr('disabled');
        $('.cmdCancel').removeAttr('disabled');
        $("#cmdRefresh").attr('disabled', true);
        //$("#cmdRefresh").removeAttr('disabled');
        $('.cmdAdd').attr('disabled', true);
        $('.cmdEdit').attr('disabled', true);
        $('.cmdDelete').attr('disabled', true);
        $('.cmdSearch').attr('disabled', true);

        $('#cmdAdd').attr('disabled', true);
        $('#cmdEdit').attr('disabled', true);
        $('#cmdDelete').attr('disabled', true);
        $('#cmdSearch').attr('disabled', true);

        $('#cmdRefresh').linkbutton('disable');
        $('.cmdFirst').linkbutton('disable');
        $('.cmdPrev').linkbutton('disable');
        $('.cmdNext').linkbutton('disable');
        $('.cmdLast').linkbutton('disable');

        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('enable');

        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('disable');
        $("#loc_code").combogrid('enable');
    }
    function cmdcondAwal() {
        $('.cmdFirst').removeAttr('disabled');
        $('.cmdPrev').removeAttr('disabled');
        $('.cmdNext').removeAttr('disabled');
        $('.cmdLast').removeAttr('disabled');
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdAdd').removeAttr('disabled');
        $('.cmdEdit').attr('disabled', true);
        $('.cmdDelete').removeAttr('disabled');
        $('.cmdSearch').removeAttr('disabled');
        $("#cmdRefresh").removeAttr('disabled');

        $('#cmdRefresh').linkbutton('enable');
        $('.cmdFirst').linkbutton('enable');
        $('.cmdPrev').linkbutton('enable');
        $('.cmdNext').linkbutton('enable');
        $('.cmdLast').linkbutton('enable');
        $('.cmdSave').linkbutton('disable');
        $('.cmdCancel').linkbutton('disable');
        $('.cmdAdd').linkbutton('disable');
        $('.cmdEdit').linkbutton('disable');
        $('.cmdDelete').linkbutton('disable');
        $('.cmdSearch').linkbutton('enable');

        $(".btn-cls").removeAttr('disabled');
        $('.btn-cls').linkbutton('enable');
        $("#loc_code").combogrid('disable');
    }

    function cmdRef() {
        $('.loader').show();
        
        var chassis = $("#chassis").val();
        var id = $("#form_validation #id").val();

        $.post(refresh_url, {table: table, id: id, chassis: chassis}, function (data) { 
            var obj = JSON.parse(data);
            if (obj.success == true) {
                 read_show('');
            }
             $('.loader').hide();
        });
    }
    $(document).ready(function () {
        tableId();
        read_show('');
        changeLoc();
        version('01.04-17');
    });
</script>