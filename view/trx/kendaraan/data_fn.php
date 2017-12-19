<script>
    var edited = false;
    var table = 'veh';
    var divtableId = $("#tableId");

    function tableId() {
        divtableId.empty().append('<input type="hidden" name="id"  id="id"><input type="hidden" name="table"  id="table" value="' + table + '">');
    }

    function read_show(nav) {
        var id = $("#form_validation #id").val();
        $('#form_validation input:text').val('');
        $('#form_validation textarea').val('');
        $('#form_validation .easyui-combogrid').combogrid('setValue', '');
        //$("#form_validation input:radio").prop("checked", false);
        $("#form_validation #salpaytype").prop("checked", false);
        $(".easyui-datebox").datebox('setValue', '');
        $('#form_validation .easyui-numberbox').numberbox('setValue', '');

        $.post(site_url + 'crud/read', {table: table, nav: nav, id: id}, function (json) {

            if (json !== '[]') {
                var rowData = $.parseJSON(json);

                $('#form_validation .cust_sex_' + rowData.cust_sex).prop("checked", true);
                $('#form_validation .cust_type_' + rowData.cust_type).prop("checked", true);
                $('#form_validation .cust_rsex_' + rowData.cust_rsex).prop("checked", true);
                $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                /*$('#form_validation .salpaytype_' + rowData.salpaytype).prop("checked", true);
                 $('#form_validation .srep_sex_' + rowData.srep_sex).prop("checked", true);
                 $('#form_validation .kwit_data_' + rowData.kwit_data).prop("checked", true);
                 $('#form_validation .sal_inctyp_' + rowData.sal_inctyp).prop("checked", true);
                 $('#form_validation .fp_data_' + rowData.fp_data).prop("checked", true);
                 */
                $.each(rowData, function (i, v) {
                    $("#" + i).val(v);

                    if (i == 'wrhs_code' || i == 'veh_name' || i == 'color_name' || i == 'cust_name' || i == 'cust_area' || i == 'cust_city' || i == 'cust_rarea' || i == 'cust_rcity') {
                        $("#" + i).combogrid('setValue', v);
                    }

                    if (i == 'stnk_bdate' || i == 'stnk_edate' || i == 'sj_date' || i == 'kwit_date' || i == 'fp_date' || i == 'sal_date' || i == 'so_date' ||
                            i == 'sji_date' || i == 'kwiti_date' || i == 'fpi_date' || i == 'pur_date' || i == 'po_date' || i == 'do_date' || i == 'pdi_date' || i == 'dni_date') {
                        if (v !== '0000-00-00') {
                            var v_date = dateSplit(v);
                            $("#" + i).datebox('setValue', v_date);
                        }
                    }
                    if (i == 'sal_bt' || i == 'sal_pbm' || i == 'sal_vat' || i == 'sal_bbn' || i == 'sal_misc' || i == 'sal_total' || i == 'pur_bt' || i == 'pur_pbm' || i == 'pur_vat' || i == 'pur_pph' || i == 'pur_misc' || i == 'pur_price') {
                        $("#" + i).numberbox('setValue', v);
                    }
                });

                $("#cust_code2").val(rowData.cust_code);
                $("#cust_name2").val(rowData.cust_name);
            }

            cmdcondAwal()
            
        });
    }
    function cmdcondAwal() {
        $('.cmdFirst').removeAttr('disabled');
        $('.cmdPrev').removeAttr('disabled');
        $('.cmdNext').removeAttr('disabled');
        $('.cmdLast').removeAttr('disabled');
        $('.cmdSave').attr('disabled', true);
        $('.cmdCancel').attr('disabled', true);
        $('.cmdAdd').attr('disabled', true);
        $('.cmdEdit').attr('disabled', true);
        $('.cmdDelete').attr('disabled', true);
        $('.cmdSearch').removeAttr('disabled');


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
    
    $(document).ready(function () {
        // checkRunMonthYear('VSL');
        tableId();
        //dateTop();
        read_show('');
        $('.loader').hide();
        version('03.17-31');
    });


</script>