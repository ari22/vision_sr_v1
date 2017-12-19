<?php

$result = "select * from menu_seq";
$result = mysql_query($result);
$menu = array();

while ($row = mysql_fetch_object($result)) {
    $menu[] = $row;
    unset($row);
}
//print_r($menu);exit;
mysql_close($conn);

$html = '';
$html .= '<div class="easyui-accordion" data-options="fit:true" style="width:500px;height1:300px;">';
foreach ($menu as $m):
    if ($m->parent_id == 0) {

        $html .= '<div title="' . $m->text . '" style="padding:10px;">';
        $html .='<ul class="easyui-tree">';


        $html .= submenu($menu, $m->id);

        $html .='</ul>';
        $html .='</div>';
    }
endforeach;

$html .='</div>';

echo $html;
//mysql_close($conn);

function submenu($menu, $id) {
    $html = '';

    foreach ($menu as $m):

        if ($m->parent_id == $id) {

            if ($m->has_child == 1) {
                $html .='<li data-options="state:\'closed\'">';
                $html .='<span>' . $m->text . '</span>';
                $html .='<ul>';
                $html .= submenu($menu, $m->id);
                $html .='</ul>';
                $html .='</li>';
                
            } else {
                $url ='';
                if ($m->form_type == 'rpt') {
                    $url .= "loader_rpt.php?gen_type=" . $m->gen_type;
                } else {
                    $url .= "loader.php?gen_type=" . $m->gen_type;
                }
                
                $url .="&form_id=" . $m->id."&form_type=" . $m->form_type . "&form_name=" . $m->form_name. "&form_alias=" . $m->form_alias;

                $lnModel = strlen($m->model);
                
                if ($lnModel >> 0) {
                    $url .= "&model=" . $m->model;
                }
                $lnname = strlen($m->tbl);
                
                if ($lnname >> 0) {
                    $url .= "&name=" . $m->tbl;
                }
                
                $lntext = strlen($m->text);
                
                if ($lntext >> 0) {
                    $url .= "&text=" . $m->text;
                }
                
                $html .='<li><a href="#" onclick="addTab(\'' . $m->text . '\',  \'' . $url . '\')">' . $m->text . '</a></li> ';
                                      
            }
        }

    endforeach;

    return $html;
}
