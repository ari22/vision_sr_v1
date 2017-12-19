<?php
	$form = 'registerspk';
	$table = "spkhist";
	$lookup = 'mst/'.$table;
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	
?>
	<table>
		
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				datebox('oest_date','Tgl. Batal',200);
				datebox('oest_date','s/d',200);
			?>
		</table>
		
		<br>
		<strong> Group By </strong>
		<br>
		
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				textbox('','Tipe Kendaraan',50);
				textbox('','Warna',50);
				localcombobox('','Warehouse',200,'datasource');
			?>
		</table>
		
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
				<tr>
					<td>
					<?php			
						exportbox('','Export Ke',250);
					?>
					</td>
				</tr>
		</table>
		<td>
			<table border = "0" cellpadding="5" style="margin: 0cm 0px 0px 0px">
				<?php	
					checktextbox('','Halaman',50);
				?>
			</table>
		</td>
		<td>
			<table border = "0" cellpadding="5" style="margin: 0cm 800px 0px 0px">
			<?php	
				textbox('','s/d',50);
			?>
			</table>
		</td>
		<br>
		
		<td >
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Screen</a>
				&nbsp;&nbsp;
				
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Printer</a>
				&nbsp;&nbsp;
				
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Export</a>
				&nbsp;&nbsp;
				
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
				&nbsp;&nbsp;
			</td>
	</table>