<div style="padding:10px 60px 20px 20px">
	<form id="dictionary" >
		<table cellpadding="5">

<?php			
			textbox('keyword','Keyword ID',300);
			textbox('en','English',300);
			loadData('mst/dictionary');
			
?>					
		</table>
			<?php include "grp_command.php";	
			include "dictionary_browse.php";?>			
	</form>
</div>		
<script>
var vMode=0;
function condAwal(){
	cmdcondAwal.apply(this, arguments);
	$('#keyword').attr('readonly', false);
	$('#keyword').attr('disabled', true);
	$('#en').attr('disabled', true);
	//showAlert("CondAwal","Kondisi awal");
}
function condReady(){
	cmdcondReady.apply(this, arguments);
	$('#keyword').attr('disabled', false);
	$('#en').attr('disabled', false);
	$('#keyword').focus();
	if (vMode==2)
	{
		$('#keyword').attr('readonly', true);
		$('#en').focus();
	}
	//alert("CondReady");
}
function condAdd(){
	vMode=1;	
	$('#keyword').val('');
	$('#en').val('');
	condReady();
}
function condEdit(){
	vMode=2;
	condReady();
}
function condDelete(){
	vMode=3;
	condReady();
	saveData();
}
function condCancel(){
	condAwal();
	showdata('',lnRecNo)
}
function condSearch(){
	
}


</script>

