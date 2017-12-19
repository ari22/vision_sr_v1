<?php
	
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	
	textbox($field1->name,$field1->caption,$field1->width,$field1->maxlength);
	textbox($field2->name,$field2->caption,$field2->width,$field2->maxlength);
	loadData($table,$lookup,$form,$pk,$sk);
	navigation();
	include "tpl_browse.php";
?>	
	</div>

<script>
	
var vMode=0;
function showAlert(title,msg){
			$.messager.show({
				title:title,
				msg:msg,
				//showType:'show',
				timeout:2000,
				showType:'fade',
				style:{
					right:'',
					bottom:''
				}
			});
		}
function clearForm(){
	$('#<?php echo $form;?>').form('clear');
}
function cmdcondAwal(){
	//$('#cmdSave').hide();
	//$('#cmdCancel').hide();
	//$('#cmdSave').attr('disabled',true)
	//$('#cmdCancel').attr('disabled',true)
	$('#cmdFirst').linkbutton('enable');
	$('#cmdPrev').linkbutton('enable');
	$('#cmdNext').linkbutton('enable');
	$('#cmdLast').linkbutton('enable');
	$('#cmdSave').linkbutton('disable');
	$('#cmdCancel').linkbutton('disable');
	$('#cmdAdd').linkbutton('enable');
	$('#cmdEdit').linkbutton('enable');
	$('#cmdDelete').linkbutton('enable');
	$('#cmdSearch').linkbutton('enable');
	
}
function cmdcondReady(){
	//$("#cmdSave").show();
	//$("#cmdCancel").show();
	$('#cmdFirst').linkbutton('disable');
	$('#cmdPrev').linkbutton('disable');
	$('#cmdNext').linkbutton('disable');
	$('#cmdLast').linkbutton('disable');
	
	$('#cmdSave').linkbutton('enable');
	$('#cmdCancel').linkbutton('enable');
	//$("#cmdSave").removeAttr('disabled');
	//$("#cmdCancel").removeAttr('disabled');
	$('#cmdAdd').linkbutton('disable');
	$('#cmdEdit').linkbutton('disable');
	$('#cmdDelete').linkbutton('disable');
	$('#cmdSearch').linkbutton('disable');
}
function condAwal(){
	cmdcondAwal.apply(this, arguments);
	$('#<?php echo $field1->name; ?>').attr('readonly', false);
	$('#<?php echo $field1->name; ?>').attr('disabled', true);
	$('#<?php echo $field2->name; ?>').attr('disabled', true);
	//showAlert("CondAwal","Kondisi awal");
}
function condReady(){
	cmdcondReady.apply(this, arguments);
	$('#<?php echo $field1->name; ?>').attr('disabled', false);
	$('#<?php echo $field2->name; ?>').attr('disabled', false);
	$('#<?php echo $field1->name; ?>').focus();
	if (vMode==2)
	{
		$('#<?php echo $field1->name; ?>').attr('readonly', true);
		$('#<?php echo $field2->name; ?>').focus();
	}
	//alert("CondReady");
}
function condAdd(){
	vMode=1;	
	//$('#<?php echo $field1->name; ?>').val('');
	//$('#<?php echo $field2->name; ?>').val('');
	<?php getFieldList($table,'condAdd');?>
	condReady();
}
function condEdit(){
	vMode=2;
	condReady();
}
function condDelete(){
	vMode=3;
	condReady(); // Harus dienable, supaya fieldnya bisa ditransfer lewat POST atau GET
	saveData();
}
function condCancel(){
	condAwal();
	showdata('',lnRecNo)
}
function condSearch(){
	
}
<?php 
function loadData($table,$lookup,$form,$pk,$sk)
{
?>
	<script>
	var lnRecCount=0;
	var lnRecNo = 0;

	function doSearch(){
			//alert('yes');
			url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup;?>&query="+$("#searchKeyword").val()+"&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>" ;
		    $('#dt').datagrid({
			url:url
			});
	}
	function showdata(lcType,lnCurrPos)
	{	
		if (lcType=='')
		{
			lnCurrPos=lnCurrPos+1;
			lcType='P';
		}
		getData(lnCurrPos,1,lcType);		
	};
	function getData(lnTargetRec,lnRec,lcType)
	{
		url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup;?>&id="+(lnTargetRec)+"&limit="+lnRec+"&nav="+lcType+"&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>"  ;
		$.getJSON( url, function( data ) {
			//alert(data.total);
			//alert(data.rows[0]['keyword']);
			if (data.total==0){
				lnRecNo = lnTargetRec-1;
			}else
			{
				$('#<?php echo $form;?>').form('load',{<?php getFieldList($table,'getData');?>});	
				lnRecNo = data.rows[0]['id']*1;
			}
			
		});
	}
	
	function saveData(){
	url = "services/runCRUD.php";
	//alert($("#keyword").val());
	var cMode = ''
	if (vMode==1){cMode='create';}
	if (vMode==2){cMode='update';}
	if (vMode==3){cMode='delete';}
	data = 	 	  "lookup=<?php echo $lookup;?>"
				+ "&func="+cMode
				+ "&id="+lnRecNo		
				+ "&pk=<?php echo $pk; ?>"
				+ "&sk=<?php echo $sk; ?>" ;
	data = data+'&'+$( "#<?php echo $form;?>" ).serialize();
	$.post( url, data )
	.done(function( data ) {
		obj = JSON.parse(data);
		if (obj.success==true){
			
			if (vMode==1){
				showAlert("Information",obj.message );
				getData(obj.id-1,1,'N');
			}
			if (vMode==2){
				showAlert("Information",obj.message);
				getData(obj.id-1,1,'N');
			}
			if (vMode==3){
				showAlert("Information",obj.message);
				getData(obj.id,1,'P');
			}
			
			condAwal();
			$("#cmdSearch").click();
		}else
		{
			showAlert("Error while saving",obj.message);
		}
	})
	.fail(function() {
	showAlert("Error","Error while saving");
	})
	/*.always(function() {
	alert( "complete" );
	});*/
	
}
	showdata('L',0);
	
	</script>
<?php
}

?>

</script>

