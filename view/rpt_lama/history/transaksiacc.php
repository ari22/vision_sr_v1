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
		<table cellpadding="1" border="0"  style="margin:0px 0px 0px 0px;" >
			<td >
				<table cellpadding="3" style="margin:0px 0px 0px 7px;">
					<?php			
						textbox('','Kode Barang',90);
						textbox('','Nama Barang',150);
						textbox('','Warehouse',150);
						textbox('','Lokasi',90);
						
						localcombobox('','Bulan',200,'datasource');
						textbox('','Tahun',90);
					?>
				</table>
			</td>
	
</table>
	</form>
</div>	

	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Proccess</a>
	&nbsp;&nbsp;
				
								
	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
	&nbsp;&nbsp;