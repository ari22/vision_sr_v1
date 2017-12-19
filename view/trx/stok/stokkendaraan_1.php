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
						textbox('','Chassis',90);
						textbox('','No. Faktur',90);
						datebox('oest_date','Tgl. Faktur',200);
					?>
				</table>
			</td>
			<td>
				<table cellpadding="3" style="margin:40px 0px 0px 0px;" >
					<?php		
						textboxset('','','Supplier',50,150);
						localcombobox('','Warehouse',200,'datasource');
						localcombobox('','Lokasi',200,'datasource');
						textbox('','Keterangan',150);
					?>
				</table>
			</td>
			<td>
				<table cellpadding="3" style="margin:0px 0px 0px 0px;" >
					<?php		
						datebox('oest_date','Tgl Closed',90);
						textbox('','Closed By',150);
					?>
				</table>
			</td>
		</table>
	</div>


	<div class="easyui-accordion" style="width:830px;">
			<div title="<?php getCaption('Kendaraan');?>" style="padding:0px 10px;">							
				<table  cellpadding="1" >
					<td>
						<table style="margin:-30px 0px 10px 0px; width:370px;" border="0">
							<?php
								textboxset('','','Kendaraan',50,150);	
								textbox('','Chassis',200);				
								textbox('','Engine',200);
								textbox('','Tipe',200);
								textbox('','Model',200);			
								textboxset('','','Warna',50,150,'datasource');							
								localcombobox('','Std. Optional',200,'datasource');
								textbox('','Merek',200);
								textbox('','Transmisi',200);				
								textbox('','Tahun',200);
								textbox('','Tipe',200);	
							?>
						</table>
					</td>
					
					<td>
						<table style="margin:10px 0px 0px 0px;">
							<?php
						
								datebox('oest_date','Perkiraan Stok',200);
								datebox('oest_date','Real Stock',200);
								textbox('','SPK Matched',200);
								textbox('','Faktur Jual',200);	
								datebox('oest_date','Tgl. Match',200);
								datebox('oest_date','Tgl. Jual',200);								
										
							?>	
						</table>
						<br>
						<br>
						<strong>STOCK</strong>
						<br>
						
						<table style="margin:0px 0px 0px 0px;">
							<?php
								textbox('','Awal',50);
								textbox('','Beli',50);			
								textbox('','Retur Beli',50);
								textbox('','Pick',50);	
								textbox('','Jual',50);		
							?>	
						</table>
					</td>	
					<td>
						<table style="margin:210px 0px 0px -140px;">
							<?php
								textbox('','Retur Jual',50);	
								textbox('','Opname',50);	
								textbox('','Akhir',50);	
								textbox('','Status',50);
								textbox('','Umur Stock',50);									
							?>	
						</table>
					</td>
					
				</table>						
			</div>			
			
			<div title="<?php getCaption('Dokumen Pembelian');?>" style="padding:0px 15px;">
		<table>
			
			<td>
				
				<table cellpadding="5" style="margin:0px 0cm 0cm 0cm; width:340px;">
					<?php			
						textbox('','Surat Jalan',100);
						textbox('','Kwitansi',100);
						textbox('','Faktur Pajak',100);
						textbox('','Debit Note',100);
						textbox('','DO',100);	
						textbox('','PDI',100);	
					?>
				</table>
			</td>
			
			<td>
				
				<table cellpadding="4" style="margin:0px 0cm 0cm -50px;">
					<?php			
						datebox('','',80);
						datebox('','',80);
						datebox('','',80);
						datebox('','',80);
						datebox('','',80);
						datebox('','',80);
					?>
				</table>
			</td>
		</table>
		</div>
			
		<div title="<?php getCaption('Purchase Order');?>" style="padding:0px 15px;">
		<table>
			<td>
				<table cellpadding="5" style="margin:0px 0cm 0cm 0cm; width:340px;">
					<?php	
						textbox('','No. PO',100);
						datebox('','Tgl PO',80);
						textbox('','Pembuat',100);
						textbox('','Disetujui',100);
						textbox('','Keterangan',100);
					?>
				</table>
			</td>
		</table>
		</div>
		</div>
	
	
	<div style="padding:15px 0;">
		<table>
		<tr><td>
			<a href="#" id="cmdFirst" title="First" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-first'"  onclick="showdata('F',lnRecNo)" ></a>
			<a href="#" id="cmdPrev" title="Prev" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-prev'" onclick="showdata('P',lnRecNo)"></a>
			<a href="#" id="cmdNext" title="Next" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-next'" onclick="showdata('N',lnRecNo)"></a>
			<a href="#" id="cmdLast" title="Last" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-last'" onclick="showdata('L',lnRecNo)"></a>
		</td>
		<td align=center width="100px">
			<a href="#" id="cmdSave" title="Save" class="easyui-linkbutton easyui-tooltip"  data-options="iconCls:'icon-save',group:'g2',disabled:true" onclick="saveData()" ></a>
			<a href="#" id="cmdCancel" title="Batal" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-cancel',group:'g2',disabled:true"  onclick="condCancel()" ></a>
		</td>
		<td align=left width="100px">
			<a href="#" id="cmdAdd" title="Tambah" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-add'"  onclick="condAdd()"></a>
			<a href="#" id="cmdEdit" title="Edit" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-edit'"  onclick="condEdit()"></a>
			<a href="#" id="cmdDelete" title="Hapus" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-no'" onclick="condDelete()" ></a>
		</td>
		</tr>
		</table>
	</div>