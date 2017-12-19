<div id="wrapper"></div>
<script> 
    var field1 = {'name': 'loc_code', 'caption': '<?php getCaption("Kode Lokasi"); ?>', 'width': 90, 'maxlength': 7};
    var field2 = {'name': 'loc_name', 'caption': '<?php getCaption("Nama Lokasi"); ?>', 'width': 250, 'maxlength': 15};
    var table = 'location';
    var pk = 'loc_code';
    var sk = 'loc_name';

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