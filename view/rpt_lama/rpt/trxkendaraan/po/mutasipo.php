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
				localcombobox('','Cetak SPK',200,'datasource');
				datebox('oest_date','Tanggal SPK',200);
				datebox('oest_date','s/d',200);
			?>
		</table>
		<br>
		<br>
		<strong> GROUP BY </strong>
		<br>
		<br>
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				textbox('','Tipe Kendaraan',250);
				textbox('','Warna',250);
				textbox('','Dealer / Resseler',250);
				textbox('','Pelanggan',250);
				textbox('','Sales',250);
				localcombobox('','Warehouse',200,'datasource');
			?>
		</table>
		<br>
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				textbox('','Halaman',250);
				textbox('','s/d',250);
			?>
		</table>
		<br>
		
		<td >
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Screen</a>
				&nbsp;&nbsp;
				
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Printer</a>
				&nbsp;&nbsp;
				
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
				&nbsp;&nbsp;
			</td>
	</table>