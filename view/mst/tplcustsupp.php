<?php
	$lookup = 'mst/'.$table;
	$prefix = '';
	if ($table=='veh_cust') {$prefix='cust';}
	if ($table=='veh_supp') {$prefix='supp';}
	if ($table=='veh_pcus') {$prefix='cust';}
	if ($table=='acc_cust') {$prefix='cust';}
	if ($table=='acc_supp') {$prefix='supp';}
	$form = $table;
	$pk=$prefix.'_code';
	$sk=$prefix.'_name';
	/* line 180 sampai 210 maksudnya apa? dikomen tapi php tetap jalan. bersangkutan di setiap tabel
	di table veh_supp pakainya attr 7-19, 46,47, 20-23  . attr ohp belum ada di tabel.
	di table veh_cust&veh_pcus pakainya attr 26-47, 22-25
	di table k3 tabel tersebut tops_day dan tops_since untuk apa?
	*/
	
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	$lcFields = $prefix.'_code'.','.$prefix.'_name'.',id';
?>
		
			<td >
				<table cellpadding="3" style="margin:0px 0px 0px 7px;">
					<?php		
						textbox($prefix.'_code','Kode',90,10);
						textbox($prefix.'_name','Nama',250,65);
						textbox($prefix.'_alias','Alias',250,30);
						
					?>
				</table>
			</td>
			<td>
				<table cellpadding="3" style="margin:0px 0px 0px 55px;" >
					<?php			
						cmdSex('sex','Jenis Kelamin');
						if ($prefix=='cust')
						{
							cmdCustType($prefix.'_type','Jenis Pelanggan');
						}
						cmdMailTo('postaddr','Surat Ke');
					?>
				</table>
			</td>
		</table>
		
		<div class="easyui-accordion" style="width:818px;" >
	
			<div title="<?php getCaption('Perusahaan');?>" style="padding:0px 10px;"  >																	
				<table  cellpadding="1" >
					<td>
						<table style="margin:10px 0px 10px 0px; width:350px;" border="0">
							<?php	
								textarea('oaddr','Alamat',200,120);							
								cmdArea('oarea','Wilayah');				
								cmdCity('ocity','Kota');	
								zipbox('ozipcode','Kode Pos',60,5);
								cmdCountry('ocountry','Negara');
								phonebox('ophone','Telepon',200,35);							
								phonebox('ofax','Fax',200,35);							
							?>
						</table>
					</td>
				
					<td>
						<table style="margin:-55px 0px 0px 17px;">
							<?php	
								textboxmail('oemail','Email',250,40);							
								textbox('ocp1_name','Hubungi',250,20);							
								textbox('ocp1_title','Jabatan',250,20);							
								textbox('ocp2_name','Hubungi',250,20);							
								textbox('ocp2_title','Jabatan',250,20);												
								cmdBusType('bus_fld','Jenis Usaha');
								cmdBusProd('bus_item','Produk Usaha');
							?>	
						</table>
					</td>					
				</table>						
			</div>		
		
			<?php 
				if ($table=='veh_cust' || $table == 'veh_pcus' || $table == 'acc_cust')
				{?>
			<div title="<?php getCaption('Rumah');?>" style="padding:0px 10px;" data-options="selected:true">																	
				<table  cellpadding="1" >						
					<td>
						<table style="margin:10px 0px 10px 0px;">
							<?php
								textarea('haddr','Alamat',200,120);							
								cmdArea('harea','Wilayah');				
								cmdCity('hcity','Kota');		
								cmdCountry('hcountry','Negara');		
								zipbox('hzipcode','Kode Pos',200,5);
								phonebox('hphone','Telepon',200,35);							
								phonebox('hfax','Fax',200,35);							
							?>
						</table>
					</td>
					<td>
						<table  style="margin:10px 0px 0px 55px;">
							<?php
								phonebox('hp','HP Pribadi',120,35);
								textboxmail('hemail','Email',250,40);
								cmdCity('pob','Tempat Lahir');
								datebox('dob','Tanggal Lahir');
								cmdRelig('relig_code','Agama');		
								cmdJob('job_code','Pekerjaan');		
								phonebox('ktp_no','No KTP',150,25);
								phonebox('drv_lic_no','No SIM',150,25);
							?>	
						</table>
					</td>						
				</table>							
			</div>
			
			<div title="<?php getCaption('Keluarga');?>" style="padding:0px 10px;">	
				<table >
					<td style="padding:0px 10px;">
						<table style="margin:10px 0px 10px 0px;">
						<?php			
							textbox('spousename','Nama Pasangan',200,40);
							datebox('wed_anniv','Ulang Tahun Pernikahan');
							textbox('child1name','Nama Anak Ke. 1',200,30);
							textbox('child2name','Nama Anak Ke. 2',200,30);
						?>
						</table>
					</td>
				
					<td>	
						<table style="margin:10px 0px 10px 0px;">
						<?php			
							datebox('spouse_dob','Tanggal Lahir',120);
						?>
						<tr>
							<td>&nbsp;
								
							</td>
						</tr>
						<?php
							datebox('child1_dob','Tanggal Lahir',120);
							datebox('child2_dob','Tanggal Lahir',120);
						?>				
						</table>
					</td>
				</table>
			</div>
			<?php
			}
			?>
			<!--<div title="<?php getCaption('Pribadi');?>" style="overflow:auto;padding:10px;">
				<table cellpadding="1" >
					<td>
						<table>
							<span style="margin:0px 0px 0px 225px;">
								<b><?php getCaption('Uang Muka');?> </b>
							</span>
							<?php
								textbox('dp_beg','Saldo Awal',200,15);
								textbox('dp_db','Debit',200,15);
								textbox('dp_cr','Kredit',200,15);
								textbox('dp_end','Saldo Akhir',200,15);
							?>
						</table>
					</td>
					<td>
						<table style="margin:0px 0px 0px 35px;">
						<span style="margin:0px 0px 0px 282px;">
						<b><?php getCaption('Piutang');?> </b>
						</span>
							<?php
								textbox('ar_beg','Saldo Awal',200);
								textbox('ar_db','Debit',200);
								textbox('ar_cr','Kredit',200);
								textbox('ar_end','Saldo Akhir',200);
							?>						
						</table>
					</td>
				</table>	
			</div>
			-->
			<div title="<?php getCaption('Pajak');?>" style="padding:0px 0px;">	
				<table>
					<td style="padding:0px 10px;">
					<table>
						<td>
							<table style="margin:10px 0px 10px 0px;">
								<?php			
									textbox('onpwp','NPWP',200,20);
									textbox('opkp','PKP / NPPKP',200,20);
									datebox('oest_date','Tanggal Pengukuhan');
									cmdVat('ovat','PPN');
								?>
							</table >
						</td>
						<td>
							
						</td>
					</table>
				</table>
			</div>
		</div>	
		<?php navigation();?>
	</form>		
</div>
<?php 
	$lcField = "id,cust_code,cust_name";
	$fieldList = array(
	array($prefix.'_code','Code',100),
	array($prefix.'_name','Name',250),
	array('id','id',50),
);
searchWindow('windowSearch','Browse',$fieldList,$lookup,$pk,$sk,$form,$table,$lcField);

?>

<script>

var vMode=0;
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


function setEnable(status)
{
	var lcStatus1 = false;
	var lcStatus2 = false;
	var lcStatus2 = false;
	if (status==false)
	{
		lcStatus1 = true;
		lcStatus2 = 'disable';
	}else
	{
		lcStatus2 = 'enable';
		lcStatus3 = true;
	}

	<?php
		if($prefix=="cust"){
		print("
			
			$('#cust_code').attr('readonly', false);
			$('#cust_code').attr('disabled', lcStatus1);
			$('#cust_name').attr('disabled', lcStatus1);
			$('#cust_alias').attr('disabled', lcStatus1);
			$('#cust_type').combobox(lcStatus2);
			$('#haddr').attr('disabled', lcStatus1);
			$('#hcity').combogrid(lcStatus2);
			$('#harea').combogrid(lcStatus2);
			$('#hcountry').combogrid(lcStatus2);
			$('#hzipcode').attr('disabled', lcStatus1);
			$('#hphone').attr('disabled', lcStatus1);
			$('#hfax').attr('disabled', lcStatus1);
			$('#hemail').attr('disabled', lcStatus1);
			$('#hp').attr('disabled', lcStatus1);
			$('#relig_code').combogrid(lcStatus2);
			$('#job_code').combogrid(lcStatus2);
			$('#dob').datebox(lcStatus2);
			$('#pob').combogrid(lcStatus2);
			$('#drv_lic_no').attr('disabled', lcStatus1);
			$('#ktp_no').attr('disabled', lcStatus1);
			$('#spousename').attr('disabled', lcStatus1);
			$('#spouse_dob').datebox(lcStatus2);
			$('#child1name').attr('disabled', lcStatus1);
			$('#child1_dob').datebox(lcStatus2);
			$('#child2name').attr('disabled', lcStatus1);
			$('#child2_dob').datebox(lcStatus2);
			$('#wed_anniv').datebox(lcStatus2);
			$('#oest_date').datebox(lcStatus2);

		");	
		}
		else if($prefix=="supp"){
		print("
			$('#supp_code').attr('readonly', false);
			$('#supp_code').attr('disabled', lcStatus1);
			$('#supp_name').attr('disabled', lcStatus1);
			$('#supp_alias').attr('disabled', lcStatus1);
			
		");
		}
	?>

	$('#oname').attr('disabled', lcStatus1);
	$('#sex').combobox(lcStatus2);
	$('#postaddr').combobox(lcStatus2);
	$('#onpwp').attr('disabled', lcStatus1);
	$('#opkp').attr('disabled', lcStatus1);
	$('#ovat').combobox(lcStatus2);
	$('#oest_date').datebox(lcStatus2);
	$('#oaddr').attr('disabled', lcStatus1);
	$('#ocity').combogrid(lcStatus2);
	$('#oarea').combogrid(lcStatus2);
	$('#ocountry').combogrid(lcStatus2);
	$('#ozipcode').attr('disabled', lcStatus1);
	$('#ophone').attr('disabled', lcStatus1);
	$('#ofax').attr('disabled', lcStatus1);
	$('#oemail').attr('disabled', lcStatus1);
	$('#ocp1_name').attr('disabled', lcStatus1);
	$('#ocp1_title').attr('disabled', lcStatus1);
	$('#ocp2_name').attr('disabled', lcStatus1);
	$('#ocp2_title').attr('disabled', lcStatus1);
	$('#bus_fld').combogrid(lcStatus2);
	$('#bus_item').combogrid(lcStatus2);
	
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
	if($prefix=="cust"){
		?>
		if (vMode==2||vMode==1)
		{
			$('#<?php echo $pk; ?>').attr('readonly', true);
			$('#<?php echo $sk; ?>').focus();
		}
		<?php 
	}else{
		?>
		if (vMode==2)
		{
			$('#<?php echo $pk; ?>').attr('readonly', true);
			$('#<?php echo $sk; ?>').focus();
		}
		<?php
	}
	?>
	//alert("CondReady");
}
function condAdd(){
	//$('#wAddCust').window('open');
	vMode=1;	
	$('#<?php echo $pk; ?>').attr('disabled', true);
	<?php getFieldList($table,'condAdd');?>
	
		$('#oarea').combogrid('setValue','');
		$('#ocity').combogrid('setValue','');
		$('#ocountry').combogrid('setValue','');
		$('#bus_fld').combogrid('setValue','');
		$('#bus_item').combogrid('setValue','');
		$('#ozipcode').numberbox('setValue','');
		$('#ophone').numberbox('setValue','');
		$('#ofax').numberbox('setValue','');
		$('#sex').combobox('setValue','');
		$('#postaddr').combobox('setValue','');
		$('#ovat').combobox('setValue','');
		$('#wed_anniv').datebox('setValue','');
		$('#spouse_dob').datebox('setValue','');
		$('#child1_dob').datebox('setValue','');
		$('#child2_dob').datebox('setValue','');
		$('#oest_date').datebox('setValue','');
		$('#<?php echo $prefix;?>_type').combobox('setValue','');
	<?php
		
		if($prefix=="cust"){
		print("
			$('#harea').combogrid('setValue','');
			$('#hcity').combogrid('setValue','');
			$('#hcountry').combogrid('setValue','');
			$('#pob').combogrid('setValue','');
			$('#dob').datebox('setValue','');
			$('#relig_code').combogrid('setValue','');
			$('#job_code').combogrid('setValue','');
			$('#hzipcode').numberbox('setValue','');
			$('#hphone').numberbox('setValue','');
			$('#hfax').numberbox('setValue','');
			$('#hp').numberbox('setValue','');
			
		");	
		}
	?>

	
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

var lnRecCount=0;
var lnRecNo = 0;

function doSearch(){
		//alert('yes');
		url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup;?>&fields=<?php echo $lcFields;?>&query="+$("#searchKeyword").val()+"&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>" ;
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
	<?php getFieldList($table,'condAdd');?>
	url = "services/runCRUD.php?func=read&lookup=<?php echo $lookup;?>&id="+(lnTargetRec)+"&limit="+lnRec+"&nav="+lcType+"&pk=<?php echo $pk; ?>&sk=<?php echo $sk; ?>"  ;
	$.getJSON( url, function( data ) {
		//alert(data.total);
		//alert(data.rows[0]['keyword']);
		$('#<?php echo $prefix;?>_code').val('');
		$('#<?php echo $prefix;?>_name').val('');
		$('#oarea').combogrid('setValue','');
		$('#ocity').combogrid('setValue','');
		$('#ocountry').combogrid('setValue','');
		$('#bus_fld').combogrid('setValue','');
		$('#bus_item').combogrid('setValue','');
		$('#ozipcode').numberbox('setValue','');
		$('#ophone').numberbox('setValue','');
		$('#ofax').numberbox('setValue','');
		$('#sex').combobox('setValue','');
		$('#postaddr').combobox('setValue','');
		$('#ovat').combobox('setValue','');
		$('#wed_anniv').datebox('setValue','');
		$('#spouse_dob').datebox('setValue','');
		$('#child1_dob').datebox('setValue','');
		$('#child2_dob').datebox('setValue','');
		$('#oest_date').datebox('setValue','');
		$('#<?php echo $prefix;?>_type').combobox('setValue','');
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
//showAlert("error","tes klik tes");
var cMode = ''
if (vMode==1){cMode='create';}
if (vMode==2){cMode='update';}
if (vMode==3){cMode='delete';}
data = 		  "lookup=<?php echo $lookup;?>"
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
			showAlert("Information",obj.message + " with id #"+obj.id);
			getData(obj.id-1,1,'N');
		}
		if (vMode==2){
			showAlert("Information",obj.message);
			getData(obj.id-1,1,'N');
		}
		if (vMode==3){
			showAlert("Information",obj.message + " with id #"+obj.id);
			getData(obj.id,1,'P');
		}
		
		condAwal();
		//$("#cmdSearch").click();
	}else
	{
		showAlert("Error while saving",obj.message);
	}
})
.fail(function() {
showAlert("Error","Error while saving");
})
}

showdata('L',0);

	


</script>

