<div style="padding:10px 60px 20px 20px">
	<form id="ff" method="post" action="">
		<table cellpadding="5">
			<tr>
				<td>Kode Perkerjaan :</td>
				<td>
					<input class="easyui-validatebox textbox" type="text" name="" ></input>
				</td>
			</tr>
			<tr>
				<td>Nama Perkerjaan :</td>
				<td>
					<input class="easyui-validatebox textbox" type="text" name="" style="width:290px;"></input>
				</td>
			</tr>
			<tr>
				<td>Harga Beli :</td>
				<td>
					<input class="easyui-validatebox textbox" type="text" name="" ></input>
				</td>
			</tr>
			<tr>
				<td>Harga Jual :</td>
				<td>
					<input class="easyui-validatebox textbox" type="text" name="" ></input>
				</td>
			</tr>
			<tr>
				<td>Diinput Oleh :</td>
				<td>
					<input class="easyui-validatebox textbox" type="text" name="" ></input>
				</td>
			</tr>	
			<tr>					
				<td>Tgl Input :</td>
				<td>
					<input name="tgl_non_aktif" class="easyui-datebox" data-options="required:true"></input>
				</td>
			</tr>															
		</table>				
		<?php include "grp_command.php";?>				
	</form>		
	<!--
	<div style="text-align:center;padding:5px">
		<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Clear</a>
	</div>	
	-->
</div>		
<!--
<script>
	function submitForm(){
		$('#ff').form('submit');
	}
	function clearForm(){
		$('#ff').form('clear');
	}
</script>	
-->
