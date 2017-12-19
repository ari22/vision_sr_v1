<?php
	$form = 'spkcenter';
	$table = "spkhist";
	$lookup = 'mst/'.$table;
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	
?>

<div style="padding: 0px 60px 0px 20px; margin:-10px 0px 0px 0px;">
	<form id="ff" method="post" action="">
		<table cellpadding="1" border="0"  style="margin:-20px 0px 0px 0px;" >
			<td >
				<table cellpadding="3" style="margin:30px 0px 0px 0px;">
					<?php			
						localcombobox('','Urut Per',200,'datasource');
						textbox('','Export Ke',200);
						textbox('oaddr','Halaman',50);
						textbox('oaddr','s/d',50);
					?>
				</table>
			</td>
			<td>
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">...</a>
						
			</td>
			<br><br>
			<td>
				
			</td>
		</table>
		<br><br>
		<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Screen</a>
		<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Printer</a>
		<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Export</a>
		<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
	</form>
</div>
<script>
    $('.loader').hide();
</script>
	
	