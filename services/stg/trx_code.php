<?php

if (isset($func)) {

    if ($func == 'datasource') {
        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "select $defaultfields from $table where 1=1 ";

        if (isset($id)) {
            $result .= " AND id = $id ";
        }
        if (isset($q)) {
            $result .= " AND ($field1 like '%$q%' or $field2 like '%$q%' )";
        }
        if (isset($order)) {
            if (isset($sort)) {
                $result .= " ORDER BY $sort $order ";
            } else {
                $result .= " order by $order";
            }
        }
        $sql = "select count(*) as n_count from ($result) a ";
        if (isset($page)) {
            $start = ($rows * ($page - 1));
            $result .= " LIMIT $start,$rows ";
        }
        //echo $result;
        $result = mysql_query($result);

        $table = array();
        while ($row = mysql_fetch_object($result)) {
            $table[] = $row;
            unset($row);
        }

        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo '{"total":"' . $row['n_count'] . '","rows":' . json_encode($table) . '}';
    }
}
?>