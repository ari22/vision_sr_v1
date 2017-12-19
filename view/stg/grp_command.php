
	<div style="padding:15px 0;">
		<table>
		<tr><td>
			<a href="#" id="cmdFirst" title="First" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-first'"  onclick="showdata('F',lnRecNo)" ></a>
			<a href="#" id="cmdPrev" title="Prev" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-prev'" onclick="showdata('P',lnRecNo)"></a>
			<a href="#" id="cmdNext" title="Next" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-next'" onclick="showdata('N',lnRecNo)"></a>
			<a href="#" id="cmdLast" title="Last" class="easyui-linkbutton easyui-tooltip" data-options="iconCls:'icon-last'" onclick="showdata('L',lnRecNo)"></a>
		</td>
		<td align=center width="100px">
			<a href="#" id="cmdSave" title="Save" class="easyui-linkbutton easyui-tooltip"  data-options="iconCls:'icon-save',group:'g2',disabled:true" onclick="validationData()" ></a>
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