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
?>

	<div data-options="region:'east',split:true,title:'Filter',split:true" style="width:465px;padding:10px;" id='eastpanel'>
		
		<table>
				
				
				<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
					<?php			
						//localcombobox('rep_type','Cetak Faktur Jual',200,$optRepType);
						datebox('date_from','Tgl. Jual',200);
						datebox('date_to','s/d',200);
					?>
				<!--</table>
				<br>
				<br>
				<strong> GROUP BY </strong>
				<br>
				<br>
				<table cellpadding="5" style="margin: 0cm 0px 0px 0px">-->
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
	<table id="dtrpt" class="easyui-datagrid"  
			data-options="rownumbers:false,singleSelect:true,method:'get',toolbar:'#tb1',method:'post',mode:'remote',	pagination:true,remoteSort:true,multiSort:false">
			<thead>
				<tr>
					
					<th data-options="field:'sal_inv_no',width:100,halign:'center',sortable:true">Faktur #</th>
					<th data-options="field:'sal_date',width:80,halign:'center',sortable:true">Tgl. Faktur</th>
					<th data-options="field:'so_no',width:100,halign:'center',sortable:true">SPK</th>
					<th data-options="field:'so_date',width:100,halign:'center',sortable:true">Tgl. SPK</th>
					<th data-options="field:'cust_code',width:100,halign:'center',sortable:true">Kode Customer</th>
					<th data-options="field:'cust_name',width:250,halign:'center',sortable:true">Nama Customer</th>
					<th data-options="field:'veh_code',width:100,halign:'center',sortable:true">Kode Kendaraan</th>
					<th data-options="field:'veh_name',width:250,halign:'center',sortable:true">Nama Kendaraan</th>
					<th data-options="field:'chassis',width:180,halign:'center',sortable:true">Chassis</th>
					<th data-options="field:'engine',width:180,halign:'center',sortable:true">Engine</th>
					<th data-options="field:'color_code',width:100,halign:'center',sortable:true">Kode Warna</th>
					<th data-options="field:'color_name',width:250,halign:'center',sortable:true">Warna</th>
					<th data-options="field:'srep_name',width:250,halign:'center',sortable:true">Sales Person</th>
				</tr>
			</thead>
		</table>
		<div id="tb1" style="padding:5px;height:auto">
			<div>
				
			</div>
		</div>
	</div>


<script>

$(function(){
	$('#rep_type').combobox('enable');
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
			
	$('#dtrpt').datagrid({
		onClickCell: onClickCell,
		onHeaderContextMenu: function(e, field){
			e.preventDefault();
			if (!cmenu){
				createColumnMenu();
			}
			cmenu.menu('show', {
				left:e.pageX,
				top:e.pageY
			});
		}
	});
});
		
		function onClickCell( 	index,field,value){
			//alert(value);
			if (field=='so_no')
			{
				//alert('buka data spk no. ' + value );
				$.messager.confirm('Lihat Detail', 'Buka data SPK No. ' + value, function(r){
				if (r){
					alert('buka data '+r);
					}
				});
			}
		}
		var cmenu;
		function createColumnMenu(){
			cmenu = $('<div/>').appendTo('body');
			cmenu.menu({
				onClick: function(item){
					if (item.iconCls == 'icon-ok'){
						$('#dtrpt').datagrid('hideColumn', item.name);
						cmenu.menu('setIcon', {
							target: item.target,
							iconCls: 'icon-empty'
						});
					} else {
						$('#dtrpt').datagrid('showColumn', item.name);
						cmenu.menu('setIcon', {
							target: item.target,
							iconCls: 'icon-ok'
						});
					}
				}
			});
			var fields = $('#dtrpt').datagrid('getColumnFields');
			for(var i=0; i<fields.length; i++){
				var field = fields[i];
				var col = $('#dtrpt').datagrid('getColumnOption', field);
				cmenu.menu('appendItem', {
					text: col.title,
					name: field,
					iconCls: 'icon-ok'
				});
			}
	
}
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
			//alert('yes');
			url ="services/runCRUD.php?func=read&lookup=mst/tpl_lookup&table=veh_slh&pk=sal_inv_no&sk=cust_name";
			url = url + "&date_field=sal_date&date_from="+$('#date_from').datebox('getValue') + "&date_to="+$('#date_to').datebox('getValue');
			//url = url + "&optRep=" + $('#rep_type').combogrid('getValue');
			url = url + "&fields=srep_name,sal_inv_no,sal_date,so_no,so_date,cust_code,cust_name,veh_code,veh_name,chassis,engine,color_code,color_name";
			filter = searchFilter();
			if (filter.length>>0)
			{
				filter = "&filter=" + filter ;
			}
			url = url + filter ;
			
		    $('#dtrpt').datagrid({
			url:url
			});
			//$('#dtrpt').datagrid('reload');
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
$(window).bind('resize', function() {
    $('#dtrpt').datagrid({
		width: $(window).width()-40
	});
	
}).trigger('resize');

var columnList = $('#dtrpt').datagrid('getColumnFields');	
columnList = "["+columnList+"]";
//alert(opts);

</script>
