<?php
	$form = 'spkcenter';
	$table = "spkhist";
	$lookup = 'mst/'.$table;
	echo '<div style="padding: 0px 10px 20px 20px;">';
	echo '<form id="'.$form.'" >';
	echo '<table cellpadding="5">';
	
?>

<div style="padding: 0px 60px 0px 20px; margin:-10px 0px 0px 0px;">
	<form id="ff" method="post" action="">
		<table cellpadding="1" border="0"  style="margin:0px 0px 0px 0px;" >
			<td >
				<table cellpadding="3" style="margin:0px 0px 0px 7px;">
					<?php	
						textbox('','Nama Dealer',90);
						datebox('oest_date','Tgl. Faktur',200);
						datebox('oest_date','s/d',200);
						textbox('','Group Per',90);
					?>
				</table>
				
				
				<table cellpadding="3" style="margin:0px 0px 0px 7px;">
					<?php			
						exportbox('','Export Ke',250);
					?>
				</table>
				
				<table border = "0" cellpadding="5" style="margin: 0cm 0px 0px 0px">
					<?php	
						checktextbox('','Halaman',50);
						textbox('','s/d',50);
					?>
				</table>
				
				<table border = "0" cellpadding="5" style="margin: 0cm 800px 0px 0px">
					<?php	
						
					?>
				</table>
				
	
		</table>
	</form>
</div>	

	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Screen</a>&nbsp;&nbsp;
	
	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Printer</a>
	&nbsp;&nbsp;
				
	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Export</a>
	&nbsp;&nbsp;
				
	<a href="#" class="easyui-linkbutton"  onclick="doSearch()">Quit</a>
	&nbsp;&nbsp;
	
        <script>
            $('.loader').hide();
            </script>
		