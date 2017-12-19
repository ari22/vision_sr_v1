<div id="wrapper"></div>
<script>
    var field1 = {'name': 'grp_code', 'caption': '<?php getCaption("Kode Group"); ?>', 'width': 120, 'maxlength': 10};
    var field2 = {'name': 'grp_name', 'caption': '<?php getCaption("Nama Group"); ?>', 'width': 300, 'maxlength': 20};
    var table = 'prt_grp';
    var pk = 'grp_code';
    var sk = 'grp_name';

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