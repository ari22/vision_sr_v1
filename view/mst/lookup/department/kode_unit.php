<div id="wrapper"></div>
<script>
    var field1 = {'name': 'dunit_code', 'caption': '<?php getCaption("Kode Unit"); ?>', 'width': 120, 'maxlength': 6};
    var field2 = {'name': 'dunit_name', 'caption': '<?php getCaption("Nama Unit"); ?>', 'width': 250, 'maxlength': 25};
    var table = 'dept_unt';
    var pk = 'dunit_code';
    var sk = 'dunit_name';

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