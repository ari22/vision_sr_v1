<?php include "../../../model/builder.php";?>
<div style="width: 850; margin: 20px;" id="form_content">
    <form id="form_validation2" method="post" action="">	
        <table cellpadding="5">
            <tr>
                <td></td>
            </tr>
            <?php
            textbox('part_code', 'Part No.', 90, 17);
            textbox('part_name', 'Part Name', 250, 50);
            //textbox('part_alias', 'Part Alias', 250, 35);
            ?>
        </table>
    </form>
</div>