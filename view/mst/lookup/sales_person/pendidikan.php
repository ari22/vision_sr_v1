<div id="wrapper"></div>
<script>
    var field1 = {'name': 'educ_code', 'caption': '<?php getCaption("Kode Pendidikan"); ?>', 'width': 150, 'maxlength': 10};
    var field2 = {'name': 'educ_name', 'caption': '<?php getCaption("Nama Pendidikan"); ?>', 'width': 250, 'maxlength': 20};
    var table = 'educ_lev';
    var pk = 'educ_code';
    var sk = 'educ_name';

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