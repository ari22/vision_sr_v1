	<table id="dt" class="easyui-datagrid"  title="" style="width:700px;height:350px;"
			data-options="rownumbers:true,singleSelect:true,method:'get',toolbar:'#tb',method:'post',mode:'remote',	pagination:true,               remoteSort:true,multiSort:true">
		<thead>
			<tr>
				<th data-options="field:'<?php echo $field1->name;?>',width:<?php echo $field1->width;?>,halign:'center',sortable:true"><?php echo getCaption($field1->caption);?></th>
				<th data-options="field:'<?php echo $field2->name;?>',width:<?php echo $field2->width;?>,halign:'center',sortable:true"><?php echo getCaption($field2->caption);?></th>
				<th data-options="field:'id',width:40,align:'center'">ID</th>
			</tr>
		</thead>
	</table>
	<div id="tb" style="padding:5px;height:auto">
		<div>
			<table>
			<tr>
			<td>Keyword : <input id="searchKeyword" class="easyui-validatebox textbox" style="width:200px"></td>
			<td><a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Search</a></td>
			</tr>
			</table>
		</div>
	</div>

<script>
$('#dt').datagrid({
	onSelect : function(	rowIndex, rowData){
		//alert(rowData.id);
		$("#<?php echo $field1->name;?>").val(rowData.<?php echo $field1->name;?>);
		$("#<?php echo $field2->name;?>").val(rowData.<?php echo $field2->name;?>);
		lnRecNo = rowData.id;
	}
});
</script>