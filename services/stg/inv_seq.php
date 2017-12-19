<?php

/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
  Antara lain :
  $table 	=> Nama Table MySQL
  $field1 => Field Primary (bukan id autoincrement)
  $field1 => Field Description
  Issue date [20140901]
 */

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
        //Sortir Showroom inv_type 
        $result .= " AND inv_type LIKE 'V%' OR inv_type  LIKE 'A%' ";
                
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