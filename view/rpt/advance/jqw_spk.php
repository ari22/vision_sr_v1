<?php
function right($string, $length)
{
	$str = substr($string, -$length, $length);
	return $str;
}
foreach ( $_GET as $key => $value ) 
{
	$$key=$value;
}
foreach ( $_POST as $key => $value ) 
{
	$$key=$value;
}
include_once "..\..\..\services\globalFunctions.php";
$conn=ConnDB();
$dateFilter='';
$textperiode='';

if (isset($date_from) && isset($date_to) && isset($date_field))
{
	$phpdate = strtotime( $date_from );
	$mysqldate = date( 'YmdHis', $phpdate );
	$dateFilter .= " AND ($date_field >= '$mysqldate' " ;
	$phpdate = strtotime( $date_to );
	$mysqldate = date( 'YmdHis', $phpdate );
	$dateFilter .= " AND $date_field <= '$mysqldate') " ;
	$textperiode= "Periode : " . $date_from . " s/d " . $date_to;
}
//ambil sejumlah c_periode

/*$sql = "drop table temp_201409;
drop table temp_201410;
drop table temp_201411;
drop table temp_201412;
drop table temp_201501;

drop table temp_spk;
drop table temp_spk_periodic;";
mysql_query($sql);
*/
$sql = "create temporary table temp_spk
SELECT srep_code,so_no,YEAR(so_date) as n_tahun,MONTH(so_date) as n_bulan,
CONCAT(CAST(YEAR(so_date) as char),RIGHT(CONCAT('00',CAST(month(so_date) as char)),2)) as c_periode
FROM veh_spk WHERE srep_code != '' ";
$sql .= $dateFilter;
$sql .=" order by srep_code,c_periode;";
echo $sql;
mysql_query($sql);

if (isset($showTop)){
	$sql = "create temporary table temp_top select srep_code,count(so_no) as n_qty from temp_spk 
	group by srep_code order by n_qty desc " ;
	$sql .= " limit $showTop";
	echo $sql;
	$result = mysql_query($sql);
	if (!$result) {
		  $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
		  $message .= '<b>Whole query:</b><br>' . $sql . '<br><br>';
		  die($message);
	}
	$sql = "delete from temp_spk where srep_code not in (select srep_code from temp_top)";
	$result = mysql_query($sql);
	if (!$result) {
		  $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
		  $message .= '<b>Whole query:</b><br>' . $sql . '<br><br>';
		  die($message);
	}
}
//return;
$sql = "create temporary table temp_srep 
select srep_code,srep_name from veh_srep where srep_code in (select distinct srep_code from temp_spk);";
$result = mysql_query($sql);
if (!$result) {
	  $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
	  $message .= '<b>Whole query:</b><br>' . $sql . '<br><br>';
	  die($message);
}

$sql = "select n_qty from temp_top order by n_qty desc limit 1;";
$result = mysql_query($sql);
$row = mysql_fetch_row($result);
$max = $row[0];
//echo $max;
if ($max<20){$max=20;}

$sql = "select distinct c_periode from temp_spk order by c_periode";
$result = mysql_query($sql);
$i=0;
$arperiode=array();
while($row=mysql_fetch_object($result)){
	$arperiode[]=$row;
	//echo $row->c_periode;
	unset($row);
	$i++;

}
$dropsql = "";
foreach ($arperiode as $a)
{
	$dropsql .= "drop table temp_".$a->c_periode.";";
}
//echo $dropsql;
//return ;
$sql = "create temporary table temp_spk_periodic
select srep_code,n_bulan,n_tahun,count(so_no) as n_qty,c_periode
from temp_spk 
group by srep_code,c_periode; ";
mysql_query($sql);
//return;


//mysql_query($sql);
//$sql='';
foreach ($arperiode as $a)
{
	$sql = "create temporary table temp_".$a->c_periode." select srep_code,n_qty from temp_spk_periodic where c_periode=".$a->c_periode.";";
	mysql_query($sql);
}
/*$sql = "create temporary table temp_201409 select srep_code,n_qty from temp_spk_periodic where c_periode=201409;";
mysql_query($sql);
$sql = "create temporary table temp_201410 select srep_code,n_qty from temp_spk_periodic where c_periode=201410;";
mysql_query($sql);
$sql = "create temporary table temp_201411 select srep_code,n_qty from temp_spk_periodic where c_periode=201411;";
mysql_query($sql);
$sql = "create temporary table temp_201412 select srep_code,n_qty from temp_spk_periodic where c_periode=201412;";
mysql_query($sql);
$sql = "create temporary table temp_201501 select srep_code,n_qty from temp_spk_periodic where c_periode=201501;";
mysql_query($sql);
*/


$i=1;
$sql = "select x.srep_code,x.srep_name, ";
foreach ($arperiode as $a)
{
	$sql .= " IFNULL(temp_".$a->c_periode.".n_qty,0) as mth$i,";
	$i++;
}

if (right($sql,1)==',')
{
	$sql = substr($sql, 0, strlen($sql)-1);
}
$sql .= " from temp_srep x " ;

foreach ($arperiode as $a)
{
	$sql.=" left join temp_".$a->c_periode." on x.srep_code = temp_".$a->c_periode.".srep_code " ;
}


//echo $sql;
/*$sql = "select x.srep_code,x.srep_name,IFNULL(a.n_qty,0) as mth01,
IFNULL(b.n_qty,0) as mth02,
IFNULL(c.n_qty,0) as mth03,
IFNULL(d.n_qty,0) as mth04,
IFNULL(e.n_qty,0) as mth05
from veh_srep x left join temp_201409 a on x.srep_code = a.srep_code
left join temp_201410 b on a.srep_code = b.srep_code
left join temp_201411 c on a.srep_code = c.srep_code
left join temp_201412 d on a.srep_code = d.srep_code
left join temp_201501 e on a.srep_code = e.srep_code
limit 5;
";*/
//echo $sql;

$result = mysql_query($sql);
if (!$result) {
      $message  = '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
      $message .= '<b>Whole query:</b><br>' . $sql . '<br><br>';
      die($message);
}

$table=array();
$i=0;
$string="";
$qty="";
$bulan ="";
$dataset = "";

/*while($row=mysql_fetch_object($result)){
	$table[]=$row;
	
	$dataset.= "{" ;
	$dataset.= "SalesCode: '".$row->srep_code."',";
	$dataset.= "Sales: '".$row->srep_name."',";
	
	if (isset($row->mth1)){ $dataset.= "mth1: ".$row->mth1.",";}
	if (isset($row->mth2)){ $dataset.= "mth2: ".$row->mth2.",";}
	if (isset($row->mth3)){ $dataset.= "mth3: ".$row->mth3.",";}
	if (isset($row->mth4)){ $dataset.= "mth4: ".$row->mth4.",";}
	if (isset($row->mth5)){ $dataset.= "mth5: ".$row->mth5.",";}
	
	$dataset.= '},';
	unset($row);
	$i++;
}*/

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
	$i=1;
	$dataset.= "{" ;
	$dataset.= "SalesCode: '".$row['srep_code']."',";
	$dataset.= "Sales: '".$row['srep_name']."',";
    foreach ($arperiode as $a)
	{
		$dataset.= "mth".$i.": ".$row['mth'.$i].",";
		$i++;
	}
	$dataset.= '},';
	
}
//echo $dataset;
//return;
if (right($bulan,1)==',')
{
$bulan = substr($bulan, 0, strlen($bulan)-1);
}
if (right($dataset,1)==',')
{
$dataset = substr($dataset, 0, strlen($dataset)-1);
}
if ($i==0){echo "<p>Tidak ada data transaksi.</p>";}
//echo $dataset;
$sql = $dropsql."
drop table temp_spk;
drop table temp_spk_periodic;";
mysql_query($sql);
//return;		
?>
    <title id='Description'>SPK Bulanan</title>
	<?php $loc_jqw = "/lib/jqw";?>
    <link rel="stylesheet" href="<?php echo $loc_jqw;?>/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxchart.core.js"></script>
	 <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="<?php echo $loc_jqw;?>/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare chart data as an array
            /*var sampleData = [
                    { Sales: 'Sales01', mth01: 30, mth02: 5, mth03: 25 },
                    { Sales: 'Sales02', mth01: 25, mth02: 25, mth03: 0 },
                    { Sales: 'Sales03', mth01: 30, mth02: 2, mth03: 25 },
                    { Sales: 'Sales04', mth01: 35, mth02: 25, mth03: 45 },
                    { Sales: 'Sales05', mth01: 0, mth02: 20, mth03: 25 },
                    { Sales: 'Sales06', mth01: 30, mth02: 0, mth03: 30 },
                    { Sales: 'Sales07', mth01: 60, mth02: 45, mth03: 0 }
                ];
			*/
			var sampleData = [<?php echo $dataset;?>];
            // prepare jqxChart settings
            var settings = {
                title: "Analisa performa sales berdasarkan jumlah SPK per bulan<br>",
                description: "<?php echo $textperiode;?> <br><br>",
                enableAnimations: true,
                showLegend: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: sampleData,
                xAxis:
                    {
                        dataField: 'Sales',
                        unitInterval: 1,
                        axisSize: 'auto',
                        tickMarks: {
                            visible: true,
                            interval: 1,
                            color: '#BCBCBC'
                        },
                        gridLines: {
                            visible: true,
                            interval: 1,
                            color: '#BCBCBC'
                        }
                    },
                valueAxis:
                {
                    unitInterval: 1,
                    minValue: 0,
                    maxValue: <?php echo $max;?>,
                    title: { text: 'Jumlah SPK' },
                    labels: { horizontalAlignment: 'right' },
                    tickMarks: { color: '#BCBCBC' }
                },
                colorScheme: 'scheme19',
                seriesGroups:
                    [
                        {
                            type: 'stackedcolumn',
                            columnsGapPercent: 50,
                            seriesGapPercent: 0,
                            series: [
							<?php
								$i=1;
								foreach ($arperiode as $a)
								{
									echo "{ dataField: 'mth".$i."', displayText: '".$a->c_periode."' },";
									$i++;
								}
							?>

									
                                ]
                        }
                    ]
            };

            // setup the chart
            $('#chartContainer').jqxChart(settings);

        });
		
    </script>
	
    <div id='chartContainer' style="width: 100%; height: 100%; float: left;">
    </div>
