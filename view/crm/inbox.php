<?php
	
	$form = 'sms_inbox';
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
?>
		<div title="<?php getCaption('Pekerjaan Jasa');?>" style="padding:0px 10px;">	
				<table >

					<table id="smsinbox" class="easyui-datagrid"  title="" toolbar="#tb" style="width:720px;height:300px;"
					data-options="rownumbers:true,singleSelect:true,method:'post',
								remoteSort:false,multiSort:true">
						<thead>
							<tr>
								<th data-options="field:'ReceivingDateTime',width:150,halign:'center',sortable:true">Received</th>
								<th data-options="field:'SenderNumber',width:120,halign:'center'">Phone Number</th>
								<th data-options="field:'TextDecoded',width:400,align:'center'">Message</th>
						</thead>
					</table>
		</div>
		<div id="tb">
			<table>
			<tr>
			<td><b>Inbox Message</b></td>
			</tr>
			</table>
		</div>
		<div>
			<td>
				<p><b>Filter</b></p>
				<table cellpadding="3" style="margin:0px 0px 0px 50x; padding: -10px -50px -30px -100px;">
				
					<?php
						
						datetimebox('dtFrom','Tgl. Kirim');
						datetimebox('dtTo','s/d');
						textbox('SenderNumber','Telepon',110,20);
						textbox('pesan','Pesan',300,100);
					?>
				</table>

			</td>
		</div>
			<div style="margin:5px 0px 0px 114px;">
			<a href="#" id="cmdSearch" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Get Data</a>
	
		 </div>


		
<script>


$( document ).ready(function() {
	$('#dtFrom').datetimebox('enable');
	$('#dtTo').datetimebox('enable');
	$('#SenderNumber').attr('disabled', false);
	$('#Status').combobox('enable');
	$('#pesan').attr('disabled', false);
});
function doSearch(){
	//alert();
	
	url = "services/runCRUD.php?lookup=crm/sms&func=GetInbox";
	url = url + "&dtFrom="+$("#dtFrom").datetimebox('getValue');
	url = url + "&dtTo="+$("#dtTo").datetimebox('getValue');
	url = url +  "&SenderNumber="+$("#SenderNumber").val();
	url = url +  "&pesan="+$("#pesan").val();
	//url = "services/runCRUD.php?lookup=crm/sms&func=GetSentItem";
	$('#smsinbox').datagrid({
		url:url,
	});

};

</script>