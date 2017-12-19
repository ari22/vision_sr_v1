<?php
	$form = 'spkcenter';
	$table = "spkhist";
	$lookup = 'mst/'.$table;
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	
	$data = array
	(
		array("ALL","AL"),
		array("Registered SPK","RS"),
		array("Registration Date","RD"),
		array("Distribution To","DT"),
	);	
?>
	<table>
		<tr>
			<td>
				<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="$('#dlg_register').dialog('open')">Register</a>
			</td>
			
			<td>
				&nbsp;
			</td>
			
			<td >
				<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="$('#dlg_delete').dialog('open');">Delete</a>
			</td>
			
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<td>
			
			<td >
				<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="$('#dlg_distribute').dialog('open')">Distribute</a>
			</td>
			
			<td>
				&nbsp;
			<td>
			
			<td >
				<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="$('#dlg_undistribute').dialog('open')">Un-Distribute</a>
			</td>
			
			<td>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<td>
			
			<td >
				<a href="javascript:void(0)" class="easyui-linkbutton"  onclick="$('#dlg_report').dialog('open')">Report</a>
			</td>
			
			<td>
				&nbsp;
			<td>
			
			<td >
				<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
			</td>
		</tr>
	</table>
	<br><br><br>
	<table>
		<td>
			<table cellpadding="5">
				<tr>	
					<td><?php getCaption("view");?> :</td>
					<td>
						<select id="cmbspk" class="easyui-combobox" name="cmbspk" style="width:200px;">
						<!--data-options=" onSelect: function(rec){alert(rec.value);}">-->
							<option value="ALL">ALL</option>
							<option value="RS">Registered SPK</option>
							<option value="RD">Registration Date</option>
							<option value="DT">Distribution To</option>
						</select>
					</td>
					<td id="hide_br" height="36px">
						<!-- hanya untuk mengakali agar saat combo box view yang ALL nya di pilih tinggi nya masih sama, saat ada field yang di hiden -->	
					</td>
					<td id="hide_contain">					
						<?php getCaption("contain");?> 											
						<input class="easyui-validatebox textbox" type="text" id="contain" name="contain" style="width:200px;" ></input>					
					</td>
					<td id="hide_from">					
						<?php //getCaption("from");?> 
						From :
						<input class="easyui-datebox" id="date_from" name="date_from" style="width:90px;" ></input>					
						<?php //getCaption("to");?> 											
						To :
						<input class="easyui-datebox"  id="date_to" name="date_to" style="width:90px;" ></input>					
					</td>
					<td id="hide_distribute">
						<?php getCaption("sales");?> :					
						<input class="easyui-combobox" 
							id="sales"
							name="sales"
							data-options="
								url:'services/runCRUD.php?func=cmb_sales&lookup=trx/veh_spkreg',
								method:'post',
								mode:'remote',
								valueField:'srep_code',
								textField:'srep_name',
								panelHeight:'auto',panelHeight:200,width:200" >
						<script>
							$('#sales').combobox({
								onLoadSuccess: function(data)
								{
									//showAlert("area","combo search not found");
									laArea = $('#sales').combobox('getData');
									//lnid = laArea[1]['id'];
									var key, count = 0;
									for(key in data) {
									  if(data.hasOwnProperty(key)) {
										count++;
									  }
									}
									if (count==0)
									{
										 $('#sales').combobox('setValue','');
									}							
								}
							});
						</script>	
						<?php
							//remotecombobox('cmb_sales','Sales',200,'services/runCRUD.php?func=cmb_sales&lookup=trx/veh_spkreg','id','srep_name');							
						?>
					</td>				
					<td id="hide_refresh">
						<a href="#" id="btn_refresh" title="Refresh" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-reload'"  onclick="btn_refresh()" ></a>
					</td>
					
				</tr>								
			</table>
		</td>
	</table>
	
	<br>		
	
	<table id="dt" class="easyui-datagrid"  title="" style="width:800px;height:350px;"
			data-options="url:'services/runCRUD.php?func=datasource&lookup=trx/veh_spkreg',rownumbers:true, 
			singleSelect:true,method:'get',toolbar:'#tb',method:'get',remoteSort:false,multiSort:true">
		<thead>
			<tr>
				<th data-options="field:'so_no',width:120,halign:'left',sortable:true">Registered SPK</th>
				<th data-options="field:'so_regdate',width:120,halign:'left',sortable:true">Registration Date</th>
				<th data-options="field:'srep_code',width:100,align:'left'">Sales Code</th>
				<th data-options="field:'srep_name',width:150,align:'left'">Sales Name</th>
				<th data-options="field:'so_note',width:100,align:'left'">Note</th>
				<th data-options="field:'so_reg_by',width:100,align:'left'">Registered By</th>
			</tr>
		</thead>
	</table>
	
	<script>
	$('#dt').datagrid({
		onSelect : function(rowIndex, rowData){
			//alert(rowData.id);			
		}
	});
	</script>	
	
				
	<div id="dlg_register" class="easyui-window" title="Registrasi SPK" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:540px;height:200px;padding:10px;">
		<?php include "registerspk.php" ?>		
	</div>	
	
	<div id="dlg_delete" class="easyui-window" title="Delete SPK" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:540px;height:200px;padding:10px;">
		<?php include "spkdelete.php" ?>		
	</div>
	
	<div id="dlg_distribute" class="easyui-window" title="Distribute SPK" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:540px;height:200px;padding:10px;">
		<?php include "spkdistribute.php" ?>		
	</div>
	
	<div id="dlg_undistribute" class="easyui-window" title="Undistribute SPK" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:540px;height:200px;padding:10px;">
		<?php include "spkundistribute.php" ?>		
	</div>
	
	<div id="dlg_report" class="easyui-window" title="Report SPK" data-options="modal:true,closed:true,iconCls:'icon-save'" style="width:540px;height:200px;padding:10px;">
				
	</div>		
	
</div>		

<script>		
	//pencet_all untuk mengakali agar saat cmb view di pilih tidak me reload ulang jika button refresh belum di klik
	var pencet_all = 0;
	condAwal();
				
	$('#cmbspk').combobox({
		onSelect: function(data)
		{
			if (data.value === "ALL")	
			{
				$('#hide_contain').hide();
				$('#hide_from').hide();
				$('#hide_distribute').hide();
				$('#hide_refresh').hide();	
				$('#hide_br').show();	
				if(pencet_all == 1)
				{
					url = "services/runCRUD.php?func=read&lookup=trx/veh_spkreg";	
					$('#dt').datagrid
					({
						url:url
					});		
					pencet_all = 0;
				}
				//alert("1");
			}
			else if (data.value === "RS")	
			{
				$('#hide_contain').show();
				$('#hide_from').hide();
				$('#hide_distribute').hide();
				$('#hide_refresh').show();
				$('#hide_br').hide();	
				//alert("2");
			}
			else if (data.value === "RD")	
			{
				$('#hide_contain').hide();
				$('#hide_from').show();
				$('#hide_distribute').hide();
				$('#hide_refresh').show();
				$('#hide_br').hide();	
				//alert("3");
			}
			else 	
			{
				$('#hide_contain').hide();
				$('#hide_from').hide();
				$('#hide_distribute').show();
				$('#hide_refresh').show();
				$('#hide_br').hide();	
				//alert("4");
			}											
		}    
	});		
	
	function condAwal()
	{
		$('#hide_contain').hide();
		$('#hide_from').hide();
		$('#hide_distribute').hide();			
		$('#hide_refresh').hide();						
	}				
	
	function btn_refresh()
	{				
		//untuk menfilter button refresh , karena button refresh ada di 3 menu cmb view
		value_cmb_spk = $("#cmbspk").combobox('getValue');
		
		//Combo box view : RS = Registered SPK
		if (value_cmb_spk == "RS")
		{
			url = "services/runCRUD.php?func=read&lookup=trx/veh_spkreg&contain="+$("#contain").val();
			$('#dt').datagrid
			({
				url:url
			});
		}		
		
		//Combo box view : RD = Registration Date
		if (value_cmb_spk == "RD")
		{
			url = "services/runCRUD.php?func=read&lookup=trx/veh_spkreg&date_from="+$("#date_from").datebox('getValue')+"&date_to="+$("#date_to").datebox('getValue');
			$('#dt').datagrid
			({
				url:url
			});
		}		
		
		//Combo box view : DT = Distribution To
		if (value_cmb_spk == "DT")
		{
			url = "services/runCRUD.php?func=read&lookup=trx/veh_spkreg&srep_code="+$("#sales").combobox('getValue');
			$('#dt').datagrid
			({
				url:url
			});
		}
		
		value_cmb_spk = ""
		pencet_all = 1;
	}	
	
</script>