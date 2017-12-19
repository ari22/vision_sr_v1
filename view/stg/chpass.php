<?php
/* Field yang dibutuhkan : 1.Current Password, 2.New Password , 3.Confirm New Password
	Cara kerja :
	1. User menginput current Password
	2. Current password divalidasi bersama dengan UserID
	3. Jika validasi ok, user bisa mengginput password baru dilanjut dengan input password baru 1x lagi. 
	Jika validasi gagal user tidak bisa menginput password baru.
*/
	//session_start();
	$_SESSION['C_ID']='SA';
	$table = 'ms_user';
	$lookup = 'stg/'.$table;
	$form = 'chpass';
	$id=$_SESSION['C_ID'];
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	//include "/model/component.php";
?>

		<td>
			<table cellpadding="5">
				<?php
					textbox('Username','Nama User',100,15);
					//textbox('Password1','Kata Sandi Saat Ini',200,15);
					//textbox('Password2','Kata Sandi Baru',200,15);
					//textbox('Password3','Konfirmasi Kata Sandi',200,15);
				?>
				<tr>	
					<td><?php getCaption('Kata Sandi Saat Ini');?> :</td>
					<td>
						<input id="Password1" name="Password1" type="password" class="easyui-validatebox" data-options="required:true" maxlength="15" style="width:150;">
						</input>
					</td>
				</tr>
				<tr>	
					<td><?php getCaption('Kata Sandi Baru');?> :</td>
					<td>
						<input id="Password2" name="Password2" type="password" class="easyui-validatebox" data-options="required:true" maxlength="15" style="width:150;"
						 disabled=true>
						</input>
					</td>
				</tr>
				<tr>	
					<td><?php getCaption('Konfirmasi Kata Sandi');?> :</td>
					<td>
						<input id="Password3" name="Password3" type="password" class="easyui-validatebox" data-options="required:true" validType="equals['#Password2']" maxlength=15 style="width:150;" disabled=true>
						</input>
					</td>
				</tr>
			</table>
		</td>
	
	</table>
		
	</form>		
	
</div>		
<script>
$( document ).ready(function() {
	$('#Username').attr('disabled',true);
	$('#Username').val('<?php echo $id;?>');
	$('#Password2').attr('disabled',true);
	$('#Password3').attr('disabled',true);
});

$.extend($.fn.validatebox.defaults.rules, {
    equals: {
        validator: function(value,param){
            return value == $(param[0]).val();
        },
        message: 'New Password do not match.'
    }
});
$('#Password1').on('blur',function(){
	url = "services/runCRUD.php";
	data =   "&lookup=<?php echo $lookup;?>"
			+ "&func=read"
			+"&username="+$('#Username').val()
			+"&password1="+$('#Password1').val();
	//url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup;?>" ;
	$.post( url,data )
	.done(function( data ) {
		obj = JSON.parse(data);
		if (obj.total>>0){
			//showAlert('Ganti Password','')
		$('#Password2').attr('disabled',false);
		$('#Password3').attr('disabled',false);
		$('#Password1').attr('disabled',true);
		}else
		{
			showAlert('Salah Password','Password lama anda tidak sesuai dengan data')
		}
	});
});
</script>