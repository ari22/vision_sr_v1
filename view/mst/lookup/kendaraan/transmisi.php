<div id="wrapper"></div>
<script>

    var field1 = {'name': 'trans_code', 'caption': '<?php getCaption("Kode Transmisi"); ?>', 'width': 150, 'maxlength': 2};
    var field2 = {'name': 'trans_name', 'caption': '<?php getCaption("Nama Transmisi"); ?>', 'width': 300, 'maxlength': 10};
    var table = 'veh_tran';
    var pk = 'trans_code';
    var sk = 'trans_name';

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