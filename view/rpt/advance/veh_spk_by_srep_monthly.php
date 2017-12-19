<?php
	$color = array
	(
		array(1,"0,0,255"),
		array(2,"0,255,0"),
		array(3,"255,0,0"),
		array(4,"102,51,153"),
		array(5,"128,128,0"),
		array(6,"204,255,255"),
		array(7,"128,128,255"),
		array(8,"153,255,255"),
		array(9,"204,255,204"),
		array(10,"0,153,255"),
	  );
	function right($string, $length)
	{
		$str = substr($string, -$length, $length);
		return $str;
	}
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
	

	$sql = "CREATE TEMPORARY TABLE temp_rpt_spk 
	SELECT count(srep_code) as n_qty,month(so_date) as n_bulan,srep_code,left(srep_name,15) as srep_name
	FROM veh_spk
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
	$sql .= "GROUP BY srep_code,srep_name,month(so_date) ORDER By n_qty desc limit $showTop;";
	echo $sql.'</br>';
	
	$result = mysql_query($sql);
	$sql = "SELECT a.*,b.srep_code,b.srep_name,b.n_qty 
	FROM bulan a left join temp_rpt_spk b on a.n_bulan = b.n_bulan
	";
	$result = mysql_query($sql);
	if (!$result) {
    die('Invalid query: ' . mysql_error());
	} 
	
	$table=array();
	$i=0;
	$string="";
	$qty="";
	$bulan ="";
	$dataset = "";
	while($row=mysql_fetch_object($result)){
		$table[]=$row;
		$string.="'".$row->srep_name."',";
		$qty.="'".$row->n_qty."',";
		$bulan.="'".$row->c_bulan."',";
		$dataset.= '{' ;
		$dataset.= '	label: "'.$row->srep_name.'",';
		$dataset.= '	fillColor : "rgba($color[$i],0.2)",';
		$dataset.= '	strokeColor : "rgba($color[$i],1)",';
		$dataset.= '	pointColor : "rgba($color[$i],1)",';
		$dataset.= '	pointStrokeColor : "#fff",';
		$dataset.= '	pointHighlightFill : "#fff",';
		$dataset.= '	pointHighlightStroke : "rgba(220,220,220,1)",';
		$dataset.= "	data : [".$qty."]";
		$dataset.= '},';
	  unset($row);
	  $i++;
	}
	if (right($bulan,1)==',')
	{
		$bulan = substr($bulan, 0, strlen($bulan)-1);
	}
	if (right($dataset,1)==',')
	{
		$dataset = substr($dataset, 0, strlen($dataset)-1);
	}
	if ($i==0){echo "<p>Tidak ada data transaksi.</p>";}
	//echo $bulan;
	//echo $dataset;
	$sql = "DROP TEMPORARY TABLE temp_rpt_spk ";
	$result = mysql_query($sql);
	if (!$result) {die('Invalid query: ' . mysql_error());} 
?>
 <style>
    #canvas-holder1 {
        width: 300px;
        margin: 20px auto;
    }
    #canvas-holder2 {
        width: 50%;
        margin: 20px 25%;
    }
    #chartjs-tooltip {
        opacity: 1;
        position: absolute;
        background: rgba(0, 0, 0, .7);
        color: white;
        padding: 3px;
        border-radius: 3px;
        -webkit-transition: all .1s ease;
        transition: all .1s ease;
        pointer-events: none;
        -webkit-transform: translate(-50%, 0);
        transform: translate(-50%, 0);
    }
   	.chartjs-tooltip-key{
   		display:inline-block;
   		width:10px;
   		height:10px;
   	}
    </style>	
<script src="../lib/chart.js-master/Chart.js"></script>

	<div>
		<canvas id="canvas" height="450" width="600"></canvas>
	</div>
	<div id="chartjs-tooltip"></div>


	<script>
		Chart.defaults.global.pointHitDetectionRadius = 1;
		Chart.defaults.global.customTooltips = function(tooltip) {

        var tooltipEl = $('#chartjs-tooltip');

        if (!tooltip) {
            tooltipEl.css({
                opacity: 0
            });
            return;
        }

		// tooltipEl.removeClass('above below');
        tooltipEl.addClass(tooltip.yAlign);

        var innerHtml = '';
        for (var i = tooltip.labels.length - 1; i >= 0; i--) {
        	innerHtml += [
        		'<div class="chartjs-tooltip-section">',
        		'	<span class="chartjs-tooltip-key" style="background-color:' + tooltip.legendColors[i].fill + '"></span>',
        		'	<span class="chartjs-tooltip-value">' + tooltip.labels[i] + '</span>',
				
        		'</div>'
        	].join('');
        }
        tooltipEl.html(innerHtml);

        tooltipEl.css({
            opacity: 1,
            left: tooltip.chart.canvas.offsetLeft + tooltip.x + 'px',
            top: tooltip.chart.canvas.offsetTop + tooltip.y + 'px',
            fontFamily: tooltip.fontFamily,
            fontSize: tooltip.fontSize,
            fontStyle: tooltip.fontStyle,
        });
    };
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
		var lineChartData = {
				labels : ['Januari','Februari','Maret','April','Mei'],
				datasets : [
				{	
					label: "RIZKY FAHRU ROZ",	
					fillColor : "rgba(192,192,192,0.2)",	
					strokeColor : "rgba(<?php echo $color[1][1];?>,1)",	
					pointColor : "rgba(<?php echo $color[1][1];?>,1)",	
					pointStrokeColor : "#aaf",	
					pointHighlightFill : "#EEE",	
					pointHighlightStroke : "rgba(220,220,220,1)",	
					data : ['1','3','0','5','3']
				},
				{	
					label: "PRABOWO ASMORO",	
					fillColor : "rgba(192,192,192,0.2)",	
					strokeColor : "rgba(<?php echo $color[2][1];?>,1)",	
					pointColor : "rgba(<?php echo $color[2][1];?>,1)",	
					pointStrokeColor : "#fff",	
					pointHighlightFill : "#fff",	
					pointHighlightStroke : "rgba(220,220,220,1)",	
					data : ['1','1','2','3','5']
				}
				<?php //echo $dataset;?>
				]

			}
	window.onload = function(){
		//getLabel();
		var ctx = document.getElementById("canvas").getContext("2d");
		/*window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});*/
		window.myBar = new Chart(ctx).Bar(lineChartData, {
			//responsive : true
		});
	}
	
	
	$(function(){
		
	});
	</script>