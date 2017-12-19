<div id="wrapper"></div>
<script>

    var field1 = {'name': 'act_code', 'caption': '<?php getCaption("Kode Action"); ?>', 'width': 120, 'maxlength': 8};
    var field2 = {'name': 'act_name', 'caption': '<?php getCaption("Ket. Action"); ?>', 'width': 300, 'maxlength': 15};
    var table = 'action';
    var pk = 'act_code';
    var sk = 'act_name';

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