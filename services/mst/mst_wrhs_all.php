<?php

/* Data yang diperlukan dikiriman lewat metode POST atau GET dari runCRUD.
  Antara lain :
  $table 	=> Nama Table MySQL
  $field1 => Field Primary (bukan id autoincrement)
  $field1 => Field Description
  Issue date [20140901]
 */

if (isset($func)) {
    if ($func == 'reccount') {
        $result = "select * from $table where 1=1 ";
        $sql = "select count($field1) as n_count,max(id) as max_id from ($result) ";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        echo json_encode($row); //$row['n_count'];
    }

    if ($func == 'datasource') {
        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "select $defaultfields from veh_wrhs where 1=1 and wrhs_code not in('ALL')";

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
        //echo '{"total":"'.$row['n_count'].'","rows":'.json_encode($table).'}';

        $count1 = $row['n_count'];
        $data1 = $table;

        /* table 2 */
        $defaultfields = "*";
        if (isset($fields)) {
            $defaultfields = $fields;
        }
        $result = "select $defaultfields from prt_wrhs where 1=1 and wrhs_code not in('ALL') ";

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
        $sql2 = "select count(*) as n_count from ($result) a ";
        if (isset($page)) {
            $start = ($rows * ($page - 1));
            $result .= " LIMIT $start,$rows ";
        }
        //echo $result;
        $result = mysql_query($result);

        $table2 = array();
        while ($row2 = mysql_fetch_object($result)) {
            $table2[] = $row2;
            unset($row2);
        }

        $result = mysql_query($sql2);
        $row2 = mysql_fetch_array($result);

        $count2 = $row2['n_count'];
        $data2 = $table2;


        $data = array_merge($data1, $data2);

        $total = intval($count1) + intval($count2);
        $rows = $data;       
         
        echo '{"total":"'.$total.'","rows":'.json_encode($rows).'}';
       
        
    }
}
?>