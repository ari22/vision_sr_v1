<?php
	$form = 'rpt_uj';
	$table = "";
	$lookup = 'mst/'.$table;
		
	$optGroupBy = array
	(
		array("Tanggal","1"),
		array("Customer","2"),
		array("Sales","3"),
		array("Faktur","4"),
		array("Leasing","5")
	);	
	$optSortBy = array
	(
		array("No. Faktur","1"),
		array("Tanggal","2")
	);	
	$aging = array
	(
		array("Tidak","0"),
		array("Ya","1"),
	);	
?>
<div style=" margin: 10px;" id="form_content">
    <form id="<?php echo $form; ?>" >
        <h1 style="font-size:20px">Laporan Piutang Kendaraan</h1>
        <div class="single-form teen-margin">
			<table> 
				<?php			
					datebox('ar_date','Tanggal Bayar',200);
					localcombobox('group_by','Group By',200,$optGroupBy);
				?>
			</table>
		</div>
		
		<div class="single-form">  
            <table >
                <table>		
					<strong> FILTER BY </strong>
					<table>
						<?php			
							cmdCustSet('cust_code','cust_name','Pelanggan');
							cmdSalSet('srep_code','srep_name','Nama Sales');
							$url = "services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name";
						?>
						<tr> <td><?php getCaption('Cara Bayar'); ?> </td>
						<td style="max-width: 5px !important;" class="td-ro">:</td>
						<td><input class="easyui-combogrid" id="pay_type"	name="pay_type" style="width:200" disabled=true
						data-options="panelWidth: 300,panelHeight:340,delay: 500,method:'post',
									idField:'pay_type',textField:'pay_name',fitColumns: true,mode:'remote', pagination:true,
									remoteSort:true,multiSort:true,required:false,loadMsg:'Please wait...',editable:false,
									url:'services/runCRUD.php?func=datasource&lookup=mst/pay_type&pk=pay_type&sk=pay_name&order=pay_name&fields=id,pay_type,pay_name',
									columns: [[               
									{field:'pay_type',title:'Type',width:80,sortable:true},
									{field:'pay_name',title:'Name',width:230,sortable:true},
									]],
									" >
						</input></td></tr>
						<?php 
							cmdLeaseSet('lease_code','lease_name','Leasing');
							localcombobox('l_aging','Penuaan',60,$aging);
							cmdWrhs('wrhs_code', 'Warehouse');
						?>
						
					</table>
			</table>
        </div>
		<div class="main-nav">
            <table>
                <tr>
					<td >
						<a href="#" class="easyui-linkbutton"  onclick="doSearch('screen')">Screen</a>
						&nbsp;&nbsp;
						<a href="#" class="easyui-linkbutton"  onclick="doSearch('print')">Printer</a>
						&nbsp;&nbsp;
						<a href="#" class="easyui-linkbutton"  onclick="doSearch('export')"><?php getCaption('Eksport');?></a>
						&nbsp;&nbsp;
						<a href="#" class="easyui-linkbutton"  onclick="doSearch('save2xls')">Save To Excel</a>
						&nbsp;&nbsp;
					</td>
				</tr>
            </table>
        </div>
    </form>
</div>
<script>


	$( document ).ready(function() 
	{
                var ldServer = '<?php echo date('Y-m-d'); ?>';
		$('#ar_date').datebox('setValue',ldServer);			
	
		setEnable();
	});
	function setEnable()
	{
		//window.alert("masuk");
		
		$('#ar_date').datebox('enable');			
		$('#so_no').attr('disabled',false);
		$('#group_by').combobox('enable');
		$('#l_aging').combobox('enable');
		$('#cust_name').combogrid('enable');
		$('#pay_type').combogrid('enable');
		$('#wrhs_code').combogrid('enable');
		$('#srep_name').combogrid('enable');
		$('#lease_name').combogrid('enable');
	}
	function doSearch(lcOutput)
	{		
		url = "services/runCRUD.php";
		
		lcar_date = $('#ar_date').datebox('getValue');
				
		if (lcar_date.length==0)
		{
			showAlert("Tanggal tidak boleh kosong");
			return false;
		}
		
		lcgroup_by = $('#group_by').combobox('getValue');
		lcaging = $('#l_aging').combobox('getValue');
		lcpay_type = $('#pay_type').combogrid('getValue');
		lccust_code = $('#cust_code').val();
		lcsrep_code = $('#srep_code').val();
		lclease_code = $('#lease_code').val();
		lcwrhs_code = $('#wrhs_code').combobox('getValue');
		var strWindowFeatures = "location=yes,height=570,width=520,scrollbars=yes,status=yes";
		var strWindowFeatures = "location=yes,scrollbars=yes,status=yes";
		var URL = url+"?lookup=rpt/kasir/piutangkendaraan"
			+ "&output=" + lcOutput
			+ "&ar_date=" + lcar_date
			+ "&cust_code=" + lccust_code
			+ "&srep_code=" + lcsrep_code
			+ "&wrhs_code=" + lcwrhs_code
			+ "&lease_code=" + lclease_code
			+ "&pay_type=" + lcpay_type
			+ "&group_by=" + lcgroup_by
			+ "&l_aging=" + lcaging
			;
		var win = window.open(URL, "_blank", strWindowFeatures);
	}
	$('#cust_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#cust_code").val(row.cust_code);
            }
        },
        onChange: function () {
            if ($('#cust_name').combogrid('getValue') == '')
            {
                $("#cust_code").val('');
            }
        }

    });
	$('#srep_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#srep_code").val(row.srep_code);
            }
        },
        onChange: function () {
            if ($('#srep_name').combogrid('getValue') == '')
            {
                $("#srep_code").val('');
            }
        }
    });
	$('#lease_name').combogrid({
        onSelect: function (index, row) {
            if (row) {
                $("#lease_code").val(row.lease_code);
            }
        },
        onChange: function () {
            if ($('#lease_name').combogrid('getValue') == '')
            {
                $("#lease_code").val('');
            }
        }
    });
</script>
	