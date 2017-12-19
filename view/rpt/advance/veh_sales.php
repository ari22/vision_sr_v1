<?php

	foreach ( $_GET as $key => $value ) 
	{
		$$key=$value;
	}
	foreach ( $_POST as $key => $value ) 
	{
		$$key=$value;
	}
	$optRepType = array
	(
		array("All","0"),
		array("Sold","1"),
		array("Picked","2"),
	);	
	$optRepGroup = array
	(
		array("Sales Rep","by_srep"),
		array("Model","by_model"),
		
	);	
?>
	<script>  
		function addTab(title, url){  
			if ($('#tabRptSalesBySrep').tabs('exists', title)){  
				$('#tabRptSalesBySrep').tabs('close', title);  
			} 
				
				var content = '<iframe scrolling="auto" frameborder="0"  src="'+url+'" style="width:100%;height:98%;padding:0px;"></iframe>';  
				$('#tabRptSalesBySrep').tabs('add',{  
					title:title,  
					content:content,  
					closable:true  
				});  

		}  

		$(function(){
			$('#showTop').numberspinner('setValue',5);
		  $("#closeTab").click(function() {
					$.post("clear.php",function(data){
					 window.parent.$('#tabRptSalesBySrep').tabs('close','Create List'); 
					 location.reload();     
			  });
		  });
		});

	</script>
	<div data-options="region:'east',split:true,title:'Filter',split:true" style="width:465px;padding:10px;" id='eastpanel'>
		
		<table>
				
				
				<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
					<tr>	
						<td>Show Only Top :</td>
						<td><input id="showTop" class="easyui-numberspinner" style="width:80px;"
						required="required" data-options="min:3,max:10,editable:false">
						</td>
					</tr>
					<?php			
						localcombobox('group_by','Group Per',200,$optRepGroup);
						datebox('date_from','Tgl. Jual',200);
						datebox('date_to','s/d',200);
					?>
					<?php			
						cmdVehSet('veh_code','veh_name','Tipe Kendaraan');
						cmdColSet('color_code','color_name','Warna');
						/*$url="services/runCRUD.php?func=datasource&lookup=mst/veh_tran&pk=trans_code&sk=trans_name&order=trans_name";	
						remotecombobox('','Dealer / Resseler',250,$url,'trans_code','trans_name');*/
						cmdCustSet('cust_code','cust_name','Pelanggan');
						cmdSalSet('srep_code','srep_name','Nama Sales');
						cmdWrhs('wrhs_code','Warehouse');	
					?>
				</table>
				<tr><td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Search</a></td>	</tr>
				
		</table>
	</div>
	<div data-options="region:'center'" title="Penjualan Kendaraan" >
		<div id="tabRptSalesBySrep" class="easyui-tabs" data-options="fit:true,border:false,plain:true">
			
		</div>
	</div>


<script>

$(function(){
	$('#group_by').combobox('enable');
	$('#date_from').datebox('enable');
	$('#date_to').datebox('enable');
	$('#veh_name').combogrid('enable');
	$('#color_name').combogrid('enable');
	$('#cust_name').combogrid('enable');
	$('#srep_name').combobox('enable');
	$('#wrhs_code').combobox('enable');
	var ldServer = new Date("<?php echo date('F d, Y G:i:s'); ?>");
	$('#date_from').datebox('setValue',ldServer);
	$('#date_to').datebox('setValue',ldServer);
	//addTab('Insurance','loader.php?gen_type=view&form_type=rpt&form_name=advance/veh_sales_by_srep');
});
		
$('#cust_name').combogrid({
		onSelect: function(index,row){
			if (row){
				$("#cust_code").val(row.cust_code);
			}
		}
});
$('#veh_name').combogrid({
	onSelect: function(index,row){
		if (row){
			$("#veh_code").val(row.veh_code);
		}			
	},
});
$('#srep_name').combogrid({
	onSelect: function(index,row){
		if (row){
			$("#srep_code").val(row.srep_code);
		}			
	},
});
$('#color_name').combogrid({
	onSelect: function(index,row){
		if (row){
			$("#color_code").val(row.color_code);
		}			
	},
});
		
function doSearch(){
			url ="&lookup=mst/tpl_lookup&table=veh_slh&pk=sal_inv_no&sk=cust_name";
			url = url + "&date_field=sal_date&date_from="+$('#date_from').datebox('getValue') + "&date_to="+$('#date_to').datebox('getValue');
			url = url + "&showTop=" + $('#showTop').numberspinner('getValue');
			//url = url + "&optRep=" + $('#rep_type').combogrid('getValue');
			url = url + "&fields=srep_name,sal_inv_no,sal_date,so_no,so_date,cust_code,cust_name,veh_code,veh_name,chassis,engine,color_code,color_name";
			filter = searchFilter();
			if (filter.length>>0)
			{
				filter = "&filter=" + filter ;
			}
			url = url + filter ;
			
		addTab($('#group_by').combobox('getText'),'loader.php?gen_type=view&form_type=rpt&form_name=advance/veh_sales_' + $('#group_by').combobox('getValue')+url);
	}
function searchFilter(){
	lcFilter = ""
	lcKey = $('#veh_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "veh_code ='" + $('#veh_code').val() +"'" ;
	}
	lcKey = $('#cust_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "cust_code='" + $('#cust_code').val() + "'";
	}
	lcKey = $('#color_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "color_code ='" + $('#color_code').val() +"'" ;
	}
	lcKey = $('#srep_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "srep_code ='" + $('#srep_code').val() +"'" ;
	}
	lcKey = $('#wrhs_code').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "wrhs_code ='" + lcKey +"'" ;
	}
	
	
	return lcFilter;
}


</script>
