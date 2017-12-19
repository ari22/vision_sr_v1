
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
	setEnable(false);
	//showAlert("CondAwal","Kondisi awal");
}
function condReady(){
	cmdcondReady.apply(this, arguments);
	setEnable(true);
	$('#<?php echo $pk; ?>').focus();
	<?php
		if($form_name=='tpl_lookup'){
			print('if (vMode==2)');
		}
		else{
			print('if (vMode==2||vMode==1)');
		}
	?>
	{
		$('#<?php echo $pk; ?>').attr('readonly', true);
		$('#<?php echo $sk; ?>').focus();
	}
}
function condAdd(){
	vMode=1;
	<?php
		if($form_name=='tpl_lookup'){}
		else{ print("$('#".$pk."').attr('readonly',false);");}
	?>
	<?php getFieldList($table,'condAdd');?>
	condReady();
}
function condEdit(){
	vMode=2;
	condReady();
}
function condDelete(){
	vMode=3;
	condReady(); <?php // Harus dienable, supaya fieldnya bisa ditransfer lewat POST atau GET ?>
	saveData();
}
function condCancel(){
	condAwal();
	showdata('',lnRecNo)
}
function condSearch(){
	<?php
		if($form_name=='tpl_lookup'){}
		else{ print("$('#windowSearch').window('open');");}
	?>
}
