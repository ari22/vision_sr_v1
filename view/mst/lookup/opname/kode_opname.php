<div id="wrapper"></div>
<script> 
    var field1 = {'name': 'opn_code', 'caption': '<?php getCaption("Kode Opname"); ?>', 'width': 150, 'maxlength': 3};
    var field2 = {'name': 'opn_name', 'caption': '<?php getCaption("Nama Opname"); ?>', 'width': 250, 'maxlength': 10};
    var table = 'opname';
    var pk = 'opn_code';
    var sk = 'opn_name';

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