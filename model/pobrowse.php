<?php
function searchWindowPO($name,$title,$fieldList,$lookup,$pk,$sk,$form,$table)
{
//Ada masalah ketika di search, lebar kolomnya jadi autoresize.
?>
	<div id="<?php echo $name;?>" class="easyui-window" title="<?php echo $title;?>" 
	data-options="modal:true,closed:true,iconCls:'icon-save',left:80,top:120" 
	style="width:600px;height:470px;">
	
		<table 	id= "gridpo" class="easyui-datagrid" title=""  
				data-options="rownumbers:true,singleSelect:true,method:'post',toolbar:'#tbPO',mode:'remote',pagination:true,remoteSort:true,multiSort:true">
		<thead>
			<tr>
					<?php 
						foreach ($fieldList as $a) 
						{
						  echo '<th data-options="field:'."'".$a[0]."'".',width:'.$a[2].'">'.$a[1].'</th> ';
						}
						?>
						<th data-options="field:'note',width:80, hidden:true">PO_desc</th>
						<th data-options="field:'po_appr_by',width:80, hidden:true">Approve by</th>
						<th data-options="field:'po_made_by',width:80, hidden:true">Made by</th>
						<th data-options="field:'unit_price',width:80, hidden:true">Unit price</th>
						<th data-options="field:'tot_price',width:80, hidden:true">Tot Price</th>
						<th data-options="field:'due_day',width:80, hidden:true">due day</th>											
			</tr>
		</thead>
		</table>
		
		<br>
			<a href="javascript:void(0)" id="windowSearchOk" class="easyui-linkbutton" onClick= "getSelectedPO()" >Ok</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#<?php echo $name;?>').window('close')">Cancel</a>
		
		<div id="tbPO" style="padding:5px;height:auto">
			<div>
				<?php getCaption("Kata Kunci");?> : <input id="searchKeyword" class="easyui-textbox" style="width:200px">
				<a href="#" class="easyui-linkbutton" onClick = "doSearchPO();" iconCls="icon-search">Search</a>
			</div>
		</div>
</div>		

	<script>
	$('#<?php echo $name;?>').window({
		onResize: function() {
		$('#gridpo').datagrid({
			width: $('#<?php echo $name;?>').width()
		});
		}
	});
	function getSelectedPO(){
		var row = $('#gridpo').datagrid('getSelected');
		if (row){
					$('#po_no').val(row.po_no);
					$("#po_date").datebox('setValue',row.po_date);
					$("#veh_code").val(row.veh_code);
					$('#veh_name').combogrid('setValue',row.veh_name);
					$("#veh_brand").val(row.veh_brand);
					$("#color_code").val(row.color_code);
					$('#color_name').combogrid('setValue',row.color_name);
					$("#veh_year").val(row.veh_year);
					$("#veh_model").val(row.veh_model);
					$("#veh_transm").val(row.veh_transm);
					$("#veh_type").val(row.veh_type);	
					$("#supp_name").combogrid('setValue',row.supp_name);	
					$("#supp_code").val(row.supp_code);	
					$("#wrhs_code").combogrid('setValue',row.wrhs_code);	
					$("#loc_code").combogrid('setValue',row.loc_code);	
					$("#chassis").val(row.chassis);	
					$("#engine").val(row.engine);
					$("#stdoptcode").combogrid('setValue',row.stdoptcode);
					$('#qty').val("1");
					$('#unit').val("Unit");
					$('#color_type').val(row.color_type);
					$('#po_made_by').val(row.po_made_by);
					$('#po_appr_by').val(row.po_appr_by);
					$('#po_desc').val(row.note);
					$('#unit_price').val(row.unit_price);
					$('#tot_price').val(row.tot_price);
					$('#due_day').val(row.due_day);
					var pono = row.po_no;
					url="services/runCRUD.php?func=cekpur&lookup=<?php echo $lookup;?>&pono="+pono;
					$.post(url).done(function(data)
					{
						obj = JSON.parse(data);
						if(obj.empty==true)
						{
							$.messager.confirm('Harga Beli Kendaraan', obj.message, function(r)
							{
								if(r)
								{
									var vcode=row.veh_code;
									var coltp=row.color_type;
									url="services/runCRUD.php?func=rstpur&lookup=<?= $lookup;?>&vcode="+vcode+"&coltp="+coltp;
									
									$.post(url).done(function(data)
									{	
										obje = JSON.parse(data);
											$('#pur_base').val(obje.purb_price);
											$('#pur_opt').val(obje.puro_price);
											$('#pur_bt').val((obje.pur_price*1)+(obje.puro_price*1));
											$('#pur_pbm').val(obje.pur_pbm);
											$('#pur_vat').val(obje.pur_vat);
											$('#pur_pph').val(obje.pur_pph);
											$('#pur_misc').val(obje.pur_misc);
											$('#pur_price').val(obje.pur_price);

									})
									return;
								}else
								{
									$.messager.alert('cancel','Canceled');
								}
							});
						}
					})
				}
		$('#<?php echo $name;?>').window('close');
	}
	function doSearchPO(){
		url = "services/runCRUD.php?func=datasource&lookup=<?php echo $lookup;?>&query="+$("#searchKeyword").val();
		$('#gridpo').datagrid({
		url:url
		});
	}
	
	</script>
<?php
}