<?php

	foreach ( $_GET as $key => $value ) 
	{
		//echo $key.'='.$value.'</br>';
		$$key=$value;
	}
	foreach ( $_POST as $key => $value ) 
	{
		//echo $key.'='.$value.'</br>';
		$$key=$value;
	}
	
	$conn=ConnDB();
	$sql = "SELECT count(srep_code) as n_qty,srep_code,left(srep_name,15) as srep_name
	FROM veh_slh
	WHERE srep_code != '' ";
	
	if (isset($date_from) && isset($date_to) && isset($date_field))
	{
		$phpdate = strtotime( $date_from );
		$mysqldate = date( 'YmdHis', $phpdate );
		$sql .= " AND ($date_field >= '$mysqldate' " ;
		$phpdate = strtotime( $date_to );
		$mysqldate = date( 'YmdHis', $phpdate );
		$sql .= " AND $date_field <= '$mysqldate') " ;
		echo "<h3> Periode : " . $date_from . " s/d " . $date_to . "</h3>";
	}
	if (isset($filter)) {
		$sql .= " AND $filter ";
	}
	$sql .= "GROUP BY srep_code,srep_name ORDER By n_qty desc limit $showTop";
//echo $sql;
	
	$result = mysql_query($sql);
	if (!$result) {
    die('Invalid query: ' . mysql_error());
	} 
	
	$table=array();
	$i=0;
	$string="";
	$qty="";
	while($row=mysql_fetch_object($result)){
	  $table[]=$row;
	  $string.="'".$row->srep_name."',";
	  $qty.="'".$row->n_qty."',";
	  unset($row);
	  $i++;
	}
	if ($i==0){echo "<p>Tidak ada data transaksi.</p>";}
?>
	
<script src="../lib/chart.js-master/Chart.js"></script>

	<div>
		<canvas id="canvas" height="450" width="600"></canvas>
	</div>



	<script>
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
				labels : [<?php echo $string;?>	],
				datasets : [{
							label: "My First dataset",
							fillColor : "rgba(220,220,220,0.2)",
							strokeColor : "rgba(220,220,220,1)",
							pointColor : "rgba(220,220,220,1)",
							pointStrokeColor : "#fff",
							pointHighlightFill : "#fff",
							pointHighlightStroke : "rgba(220,220,220,1)",
							data : [<?php echo $qty;?>]
						}]

			}
	window.onload = function(){
		//getLabel();
		var ctx = document.getElementById("canvas").getContext("2d");
		//window.myLine = new Chart(ctx).Line(lineChartData, {
		//	responsive: true
		//});
		window.myBar = new Chart(ctx).Bar(lineChartData, {
			responsive : true
		});
	}
	
	
	$(function(){
		
	});
	</script>