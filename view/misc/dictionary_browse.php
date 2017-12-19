	<table id="dt" class="easyui-datagrid"  title="" style="width:700px;height:350px;"
			data-options="rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'get',
				remoteSort:false,
				multiSort:true">
		<thead>
			<tr>
				<th data-options="field:'keyword',width:300,halign:'center',sortable:true">Keyword</th>
				<th data-options="field:'en',width:300,halign:'center',sortable:true">English</th>
				<th data-options="field:'id',width:40,align:'center'">ID</th>
			</tr>
		</thead>
	</table>
	<div id="tb" style="padding:5px;height:auto">
		<!--<div style="margin-bottom:5px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true"></a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true"></a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-save" plain="true"></a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-cut" plain="true"></a>
			<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true"></a>
		</div>-->
		<div>
			<table>
			<tr>
			<!--<td>Date From: <input class="easyui-datebox" style="width:80px"></td>
			<td>To: <input class="easyui-datebox" style="width:80px"></td>-->
			<td>Keyword : <input id="searchKeyword" class="easyui-validatebox textbox" style="width:200px"></td>
			<td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Search</a></td>
			</tr>
			</table>
		</div>
	</div>
	</div>
</div>
<script>
$('#dt').datagrid({
	onSelect : function(	rowIndex, rowData){
		//alert(rowData.id);
		$("#keyword").val(rowData.keyword);
		$("#en").val(rowData.en);
		lnRecNo = rowData.id;
	}
});
function getSelected(){
	var row = $('#dt').datagrid('getSelected');
	if (row){
		$.messager.alert('Info', row.itemid+":"+row.productid+":"+row.attr1);
	}
}
</script>