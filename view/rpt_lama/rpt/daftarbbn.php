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
				localcombobox('','Cetak Faktur Beli',200,'datasource');
				datebox('oest_date','Tgl. Beli',200);
				datebox('oest_date','s/d',200);
			?>
		</table>
		
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				localcombobox('','Urut Per',200,'datasource');
			?>
		</table>
		
		<br>
		<strong> And </strong>
		<br>
		
		<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
			<?php			
				textbox('','Kode Kendaraan',50);
				textbox('','Biro Jasa',50);
				textbox('','Purchaser',50);
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
					checkbox('','Detail Transaksi',50);
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