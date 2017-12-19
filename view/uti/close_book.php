<?php
$mounth = array
    (
    array("January", "1"),
    array("February", "2"),
    array("March", "3"),
    array("April", "4"),
    array("May", "5"),
    array("June", "6"),
    array("July", "7"),
    array("August", "8"),
    array("September", "9"),
    array("October", "10"),
    array("November", "11"),
    array("December", "12"),
);

$bulan = $comp['bulan'];
$tahun = $comp['tahun'];
?>
<div style=" margin: 10px;" id="form_content">
    <div class="single-form teen-margin">
        <table >
            <tr>
                <td>
                    <table class="marginmin" style="float: left;">
                        <?php localcombobox('bulan', 'bulan1', 100, $mounth); ?>
                    </table>

                </td>
                <td>
                    <table>
                        <?php textbox('tahun', 'Tahun', 50, 4) ?>
                    </table>
                </td>           
                <td align="right"><a href="#" class="easyui-linkbutton" data-options="iconCls:'icon-screen'"   onclick="closebook();" >Process</a></td>
            </tr>
        </table>


        <table>
            <tr><td colspan="2"><h3><u>Anda akan melakukan Proses Tutup Buku:</u></h3></td></tr>

            <tr><td colspan="2"><p>Showroom & Accessories</p></td></tr>

            <tr><td colspan="2"><h3><u>Sebelum melakukan Proses Tutup Buku:</u></h3></td></tr>

            <tr><td>1.</td><td>Pastikan User lain sudah keluar (logout)</td></tr>
            <tr><td>2.</td><td>Data sudah di-Back UP</td></tr>
            <tr><td>3.</td><td>Sudah menjalankan Reindex</td></tr>
            <tr><td>4.</td><td>Siapkan alat tulis untuk mencatat jika ada pesan yang ditampilkan</td></tr>
        </table>
        
        <div id="results"></div>
    </div>
</div>
<style>
    #tahun{text-align: right;}
</style>
<script>
    var url = site_url + 'utility/closebook';

    $(document).ready(function () {
        $('#bulan').combobox('setValue', '<?php echo $bulan; ?>');
        $('#tahun').val('<?php echo $tahun; ?>');
        $('.loader').hide();
    });

    function closebook() {
        var bulan = $("#bulan").combobox('getValue');
        var tahun = $("#tahun").val();
 
        $.post(url,{mounth:bulan,year:tahun}, function (res) { 
            //$("#results").empty().html(res);
        });
    }
</script>