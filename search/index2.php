<?php include 'getTables.php'; ?>
<?php
if(!empty($_SESSION["tabel"])){
    $arr = json_decode($_SESSION["tabel"]);
}else{
    $arr = array();
}
?>

<div class="single-form">
    <table width="100%">
        <tr>
            <td valign="top">
                <a style="font-size:24px"><b>Search Result(s)   </b></a>
                <button id="deletehasil"  class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" onclick="refresh()" type="button" style="display:none">Clear Result</button>
                <hr />
                <div id="tulisanhasil">Start a Search!</div>
                <div id="hasilTableDiv" style="display:none">
                    <table id="tableSearch" class="easyui-datagrid"></table>
                </div>

            </td>
        </tr>
        <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
        <tr>
            <td width="350" valign="top">
                <a style="font-size:24px"><b>Define Your Filter Here  </b></a>
                <button id="tambah" class="easyui-linkbutton" data-options="iconCls:'icon-add'" onclick="add()">Filter</button>
                <button id="deleteparam"  class="easyui-linkbutton" data-options="iconCls:'icon-reload'" onclick="refreshparam()" type="button" style="display:none">Clear Filter </button>
                <button id="OK"  class="easyui-linkbutton" data-options="iconCls:'icon-search'"  type="button" style="display:initial" onclick="clickOK()">Start Search</button>
                <button id="ambil" type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-ok'" onclick="getSearchselect()" style="display:none">Get Data </button>
                <button type="button" class="easyui-linkbutton easyui-tooltip btn btn-default" data-options="iconCls:'icon-redo'" onclick="$('#windowSearch').window('close');">Quit</button>
                <hr />
                <!--a dibawah buat simpen no brp aj yg ud ada, dan no brp yg kosong, dan ud ad 10 ap blom-->
                <p>Filter by:<a id="urut" style="display:none">0</a></p>
                <form id="frm1" action="javascript:clickOK();" method="post">
                    <table id="tempat" class="table table-condensed" style="margin-left: -5px;">
                        <tbody id="body1">
                            <!--kasih parameter awal-->
                            <tr id='Divno0' class='row'>
                                <td><button type='button'  class='easyui-linkbutton' data-options="iconCls:'icon-no'" onclick="deleted('Divno0','0')">Delete</button></td>
                                <td><select class='combo'  id='SPK0' name='data[]' onchange="tanggal('0')" height='30px' style='width: 145px'>
                                </select></td>
                                <td><select  class='combo'  id='sel_type0' name='data[]' onchange="showTextBox('0')" height='30px' style='width: 90px'>
                                    <option value='1'>ALL          </option>
                                    <option value='2'>=		</option>
                                    <option value='3'>between	</option>
                                    <option value='4'>start with   </option>
                                    <option value='5'>contain	</option>
                                </select></td>
                                <td>
                                    <table id='innerTable0'>
                                        <thead><tr>
                                            <td><input type='hidden' name='data[]'></td>
                                            <td><input type='hidden' name='data[]'></td>
                                        </tr></thead>
                                    </table>
                                </td>
                            </tr>
                            <!--parameter awal selesai-->
                        </tbody>
                    </table>
                </form>
            </td>
        </tr>
    </table>
</div>

<script>
    var table_used = '<?php echo $_POST["table"]; ?>';

    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        //return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
    }
    function myparser(s) {
        //alert(s);
        if (!s)
            return new Date();
        //alert(s);
        var ss = (s.split('/'));
        //alert (parseInt(ss[0]));
        var d = parseInt(ss[0]);
        var m = parseInt(ss[1]);
        var y = parseInt(ss[2]);
        //alert( y + "." + m + "." + d);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }
    function formatDate(value, row) {
        stat = true;

        if (value == null) {
            stat = false;
        }
        if (value == '0000-00-00') {
            stat = false;
        }

        if (stat !== false) {
            var dateVal = new Date(value);
            var date = (dateVal.getDate()) + "/" + (dateVal.getMonth() + 1) + "/" + dateVal.getFullYear();
            return date;
        }
        else
            return "-";
    }

    function formatNumber(x) {
        if (x == null) {
            x = 0;
        }
        return isNaN(x) ? "" : x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function init(id) {
        // $("#" + id).addClass('easyui-datebox');
        $("#" + id).datebox();
        // Initialization
        /*$('#'+id).datepicker({
         format:'yyyy-mm-dd',
         autoclose:true
         });*/
    }

    function showTextBox(no) {

        $('#innerTable' + no).find('tr').empty();

        if ($('#sel_type' + no).val() > '1') {
            var tambah = "<input type='text' name='data[]' id='boxSPK" + no + "1' data-options='formatter:myformatter,parser:myparser,required:false' style='width:125px;'>";
            $('#innerTable' + no).find('tr')
                    .append('<td>' + tambah + '</td>');
            if ($('#sel_type' + no).val() == '3') {

                var tambah = "<input type='text' name='data[]' id='boxSPK" + no + "2' data-options='formatter:myformatter,parser:myparser,required:false' style='width:125px;'>";
                $('#innerTable' + no).find('tr')
                        .append('<td>' + tambah + '</td>');
            }
            else {
                var tambah = "<input type='hidden' name='data[]'>";
                $('#innerTable' + no).find('tr')
                        .append('<td>' + tambah + '</td>');
            }
        }
        else {
            var tambah = "<input type='hidden' name='data[]'>";
            $('#innerTable' + no).find('tr')
                    .append('<td>' + tambah + '</td>');
            var tambah = "<input type='hidden' name='data[]'>";
            $('#innerTable' + no).find('tr')
                    .append('<td>' + tambah + '</td>');
        }

        if ($('#SPK' + no).val().indexOf("date") >= 0) {
            if ($('#sel_type' + no).val() > '1') {
                init('boxSPK' + no + '1');
                if ($('#sel_type' + no).val() == '3') {
                    init('boxSPK' + no + '2');
                }
            }
        }
    }

    /*function tanggal(no) {
        $('#sel_type' + no).val('1');
        $('#innerTable' + no).find('tr').empty();
    }*/

    function refresh() {
        $('#tulisanhasil').html("Start a Search!");
        $('#tableSearch').hide();
        $("#hasilTableDiv").css({'display': 'none'});//.hide();
        $("#deletehasil").css({'display': 'none'});
    }
    /*
    function refreshAll() {
        $('#tulisanhasil').html("Start a Search!");
        $('#hasil').hide();
        document.getElementById("frm1").reset();
        $("#body1").empty();
        $("#OK").css({'display': 'none'});
        $("#deleteparam").css({'display': 'none'});
    }*/

    function refreshparam() {
        $("#urut").html("");
        $("#tempat").find('tbody').html("");
        $("#OK").css({'display': 'none'});
        $("#deleteparam").css({'display': 'none'});
    }

    function add() {
        $("#deleteparam").css({'display': 'initial'});
        $("#OK").css({'display': 'initial'});
        var urutan = document.getElementById("urut").innerHTML;
        var hasil = parsing(urutan);
        //kalo blom ada parameter sama skali
        if ($('#urut').is(':empty')) {
            urutan = 0;
        }
        //kalo ada parameter
        else {
            urutan += ",";
            urutan += hasil;
            urutan = JSON.parse("[" + urutan + "]");
            urutan.sort(function (a, b) {
                return a - b
            });
        }
        //tulis ke a dgn id=urut
        document.getElementById("urut").innerHTML = urutan.toString();
        //buat id
        var divIdName = 'Divno' + hasil;
        //siap2 buat ditulis
        var tabel = "<tr id='" + divIdName + "' class='row'>" +
                "<td><button type='button'  class='easyui-linkbutton' data-options=\"iconCls:'icon-no'\" onclick=\"deleted('" + divIdName + "','" + hasil + "')\">Delete</button></td>" +
                "<td><select class='combo'  id='SPK" + hasil + "' name='data[]' height='30px' style='width: 145px'>" +
                "</select></td>" +
                "<td><select  class='combo'  id='sel_type" + hasil + "' name='data[]' onchange=\"showTextBox('" + hasil + "')\" height='30px' style='width: 90px'>" +
                "<option value='1'>ALL          </option>" +
                "<option value='2'>=		</option>" +
                "<option value='3'>between	</option>" +
                "<option value='4'>start with   </option>" +
                "<option value='5'>contain	</option>" +
                "</select></td>" +
                "<td>\n\
                    <table id='innerTable" + hasil + "'>\n\
                        <thead><tr>\n\
                            <td><input type='hidden' name='data[]'></td>\n\
                            <td><input type='hidden' name='data[]'></td>\n\
                        </tr></thead>\n\
                    </table>\n\
                </td>"+
            "</tr>";
        //tulis ke bagian tbody dari tabel bernama "tempat"
        $('#tempat').find('tbody').append(tabel);

        generate(hasil);
        $(".easyui-linkbutton").linkbutton();
    }

    function deleted(dId, urut) {
        //buat buang div
        var ni = document.getElementById('tempat');
        $('#' + dId).remove();
        //kalo pakenya div, pake yang dibawah ini
        //ni.removeChild(document.getElementById(dId));

        //buat buang urutan
        var urutan = document.getElementById("urut").innerHTML;
        var array = JSON.parse("[" + urutan + "]");

        for (i = 0; i < array.length; i++) {
            if (urut == parseInt(array[i].toString(), 10)) {
                array.splice(i, 1);
            }
        }
        document.getElementById("urut").innerHTML = array.toString();

        //buang tombol 'start search' dan 'refresh parameter' kalo parameter kosong
        if ($('#urut').is(':empty')) {
            $("#OK").css({'display': 'none'});
            $("#deleteparam").css({'display': 'none'});
        }
        return false;
    }

    function parsing(urutan) {
        //kalo ga ada urutan sama sekali
        if ($('#urut').is(':empty')) {
            return 0;
        }
        else {
            //buat urutan jadi array
            var array = JSON.parse("[" + urutan + "]");
            //cek ke semua elemen
            var i = 0;
            while (1) {
                //kalo panjang array sesuai dengan urutan yg dicek
                //(jadi klo array cuma ada 1, ga bakal cek yang ke-2)
                if (i + 1 <= array.length) {
                    //kalo array yang dicek ga sesuai dengan urutan yg seharusnya
                    if (i != parseInt(array[i].toString(), 10)) {
                        //balikin urutan, biar klo urutanny 1,6 baliknya 0
                        return i;
                    }
                    //kalo sesuai lanjut ke urutan berikutnya
                    else {
                    }
                    ;
                }
                //kalo yang dicek urutannya lebih besar dari panjang array
                //jadi, kalo array 0,1 tru yg dicek urutan ke-3 (2), dibalikin angka 2
                else {
                    return i;
                }
                i++;
            }
        }
    }

    function generate(id) {
        var arr = <?php echo $_SESSION["tabel"]; ?>;
        $.each(arr, function (key, isi) {
            var option = document.createElement("option");
            option.text = key;
            option.value = isi;
            var select = document.getElementById("SPK" + id);
            select.appendChild(option);
        });
    }
    $(document).ready(function () {
        generate('0');

        // $('#tabelhasil').datagrid();
        $(".easyui-linkbutton").linkbutton();
        $('#hasil').hide();
            $('#tableSearch').datagrid({
                onClickCell: function(index,field,value){
                    $("#ambil").css({'display': 'initial'});
                }
            });
    });
	
    function clickOK(){
            $('#hasilTableDiv').show();
            $("#deletehasil").css({'display': 'initial'});
            $('#tulisanhasil').html("");

            var str = $("#frm1").serialize();
            var search = search_url + 'search_function.php?table=' + table_used + '&'+ str;
            //$.get(search, function(json){alert(json)})
            // return false;

            $('#tableSearch').datagrid({
                method: 'post',
                url: search,
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
                        <?php
                        $array = array('inv_total','pd_begin','pd_paid','pd_disc','pd_end','hd_begin','hd_paid','hd_disc','hd_end','tot_paid','veh_price','dp_end', 'total', 'qty','qty_order','qty_border','qty_pick','qty_border');
                            foreach ($arr as $key => $isi) {
                                if (strpos($isi, 'date') !== false) {
                                    echo "{field: '$isi', title: '$key', formatter:formatDate, sortable: true},";
                                } elseif (in_array($isi, $array, true)){
                                   echo "{field: '$isi', title: '$key', formatter:formatNumber, align:\"right\", sortable: true},";
                                }else {
                                    echo "{field: '$isi', title: '$key', sortable: true},";
                                }
                            }
                        ?>
                    ]]
            });
    }
</script>

<style>
    .combo {
        background-color: #ffffff;
        border-color: #d3d3d3;
        border-style: solid;
        border-width: 1px;
        display: inline-block;
        margin: 0;
        overflow: hidden;
        padding: 0;
        vertical-align: middle;
        white-space: nowrap;
        height: 25px;
    }
</style>