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
		array("Closed","1"),
		array("Not Closed","2"),
	  );	
?>
<div data-options="region:'east',split:true,title:'Filter',split:false" style="width:465px;padding:10px;" id='eastpanel'>
		
		<table>
				
				
				<table cellpadding="5" style="margin: 0cm 0px 0px 0px">
					<?php			
						localcombobox('rep_type','Cetak Faktur Terima',200,$optRepType);
						datebox('date_from','Tgl. Tanda Terima',200);
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
						cmdSupSet('supp_code','supp_name','Supplier');
						cmdWrhs('wrhs_code','Warehouse');	
					?>
				</table>
				<tr><td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Search</a></td>	</tr>
				
		</table>
	</div>
	<div data-options="region:'center'" title="Penerimaan Kendaraan" >
	<table id="dtrpt" class="easyui-datagrid"  
			data-options="rownumbers:false,singleSelect:true,method:'get',toolbar:'#tb1',method:'post',mode:'remote',	pagination:true,remoteSort:true,multiSort:false">
			<thead>
				<tr>
					
					
					<th data-options="field:'pur_date',width:80,halign:'center',sortable:true">Tanggal Terima</th>
					<th data-options="field:'pur_inv_no',width:100,halign:'center',sortable:true">Nomor Faktur</th>
					<th data-options="field:'chassis',width:100,halign:'center',sortable:true">Nomor Rangka</th>
					<th data-options="field:'engine',width:100,halign:'center',sortable:true">Nomor Mesin</th>
					<th data-options="field:'veh_brand',width:100,halign:'center',sortable:true">Merek</th>
					<th data-options="field:'veh_type',width:100,halign:'center',sortable:true">Tipe</th>
					<th data-options="field:'veh_year',width:250,halign:'center',sortable:true">Tahun</th>
					<th data-options="field:'veh_transm',width:100,halign:'center',sortable:true">Transmisi</th>
					<th data-options="field:'color_name',width:100,halign:'center',sortable:true">Warna</th>
					<th data-options="field:'supp_code',width:100,halign:'center',sortable:true">Kode Supplier</th>
					<th data-options="field:'sji_no',width:100,halign:'center',sortable:true">Nomor SJ Supplier</th>
					<th data-options="field:'sji_date',width:100,halign:'center',sortable:true">Tanggal SJ Supplier</th>
					<th data-options="field:'qty',width:100,halign:'center',sortable:true">Qty</th>
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
	$('#supp_name').combogrid('enable');
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
$('#supp_name').combogrid({
	onSelect: function(index,row){
		if (row){
			$("#supp_code").val(row.supp_code);
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
			url ="services/runCRUD.php?func=read&lookup=mst/tpl_lookup&table=veh_prh&pk=pur_inv_no&sk=supp_name";
			url = url + "&date_field=pur_date&date_from="+$('#date_from').datebox('getValue') + "&date_to="+$('#date_to').datebox('getValue');
			url = url + "&optRep=" + $('#rep_type').combogrid('getValue');
			url = url + "&fields=pur_date, pur_inv_no, chassis, engine, veh_brand, veh_type, veh_year, veh_transm, color_name, supp_code, sji_no, sji_date, qty";
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

	lcKey = $('#color_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "color_code ='" + $('#color_code').val() +"'" ;
	}
	lcKey = $('#supp_name').combogrid('getValue');
	if (lcKey.length>>0) { 
		if (lcFilter.length>>0){ lcFilter = lcFilter + " AND " ;}
		lcFilter = lcFilter + "supp_code ='" + $('#supp_code').val() +"'" ;
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