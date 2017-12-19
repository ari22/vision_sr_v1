<div id="wrapper"></div>
<script>

    var field1 = {'name': 'prov_code', 'caption': '<?php getCaption("Kode Provinsi"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'prov_name', 'caption': '<?php getCaption("Nama Provinsi"); ?>', 'width': 250, 'maxlength': 25};
    var table = 'provinsi';
    var pk = 'prov_code';
    var sk = 'prov_name';

    $(document).ready(function () {
        grid_master('wrapper');
    });

    function grid_master(selector) {
        var div = $("#" + selector);

        $.post(site_url + 'master/lookup/grid_lookup',
                {
                    field1: field1,
                    field2: field2,
                    table: table,
                    pk: pk,
                    sk: sk,
                    v: '01.04-17'
                },
        function (data) {
            div.html(data);
              $('.easyui-linkbutton').linkbutton();
        });

    }


</script>