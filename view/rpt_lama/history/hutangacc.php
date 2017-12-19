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
						textbox('','No. Faktur Beli',90);
						
						localcombobox('','Periode',200,'datasource');
						datebox('oest_date','Tahun',200);
						
						localcombobox('','Sampai',200,'datasource');
						datebox('oest_date','Tahun',200);
						
						textbox('','Total Faktur',90);
						
					?>
				</table>
			</td>
			<td>
				<table cellpadding="3" style="margin:0px 0px 0px 30px;" >
					<?php	
						textboxset('','','Supplier',50,150);
						textbox('','No. Faktur Supplier',150);

						textbox('','Hutang Awal',150);
						textbox('','Pembayaran',150);
						textbox('','Discount',150);
						textbox('','Piutang Akhir',150);
						
					?>
				</table>
			</td>
			
		</table>
	</div>
	
	<table id="dt" class="easyui-datagrid"  title="" style="width:1080px;height:150px;"
			data-options="rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
				remoteSort:false,
				multiSort:true">
		<thead>
			<tr>
				<th data-options="field:'raddr_code',width:120,halign:'center',sortable:true">Tgl Bayar</th>
				<th data-options="field:'raddr_name',width:120,halign:'center',sortable:true">Jenis Bayar</th>
				<th data-options="field:'id',width:100,align:'center'">No. Cek</th>
				<th data-options="field:'id',width:100,align:'center'">Tgl. Cek</th>
				<th data-options="field:'id',width:100,align:'center'">Tgl J. Tempo</th>
				<th data-options="field:'id',width:100,align:'center'">Pembayaran</th>
				<th data-options="field:'id',width:100,align:'center'">Discount</th>
				<th data-options="field:'id',width:100,align:'center'">Keterangan</th>
				<th data-options="field:'id',width:100,align:'center'">Dibuat Oleh</th>
				<th data-options="field:'id',width:100,align:'center'">Collector</th>
				<th data-options="field:'id',width:100,align:'center'">Tgl. Dibuat</th>
			
			</tr>
		</thead>
	</table>
	
	<div style="padding: 0px 0px 0px 0px; margin:0px 0px 0px 0px;">
	<form id="ff" method="post" action="">
		<table cellpadding="1" border="0"  style="margin:0px 0px 0px 0px;" >
			<td >
				<table cellpadding="3" style="margin:0px 0px 0px 0px;">
					<?php			
						textboxset('','','Total',100,100);
					?>
				</table>
			</td>
			
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
		</table>
		</form>
	</div>
	
	
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
	</div>	