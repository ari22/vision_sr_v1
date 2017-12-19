<div id="wrapper"></div>
<script>

    var field1 = {'name': 'sgrp_code', 'caption': '<?php getCaption("Kode Sub Group"); ?>', 'width': 120, 'maxlength': 10};
    var field2 = {'name': 'sgrp_name', 'caption': '<?php getCaption("Nama Sub Group"); ?>', 'width': 300, 'maxlength': 20};
    var table = 'prt_sgrp';
    var pk = 'sgrp_code';
    var sk = 'sgrp_name';

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