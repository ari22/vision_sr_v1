<?php 
	$form = "dictionary";
	$table = "dictionary";
	$lookup = 'mst/'.$table;
	$pk='keyword';
	$sk='ENG';
	$field1 = new objField;
	$field1->name='keyword';
	$field1->caption='Keyword ID';
	$field1->width=300;
	$field1->maxlength=40;
	
	$field2 = new objField;
	$field2->name='ENG';
	$field2->caption='English';
	$field2->width=300;
	$field2->maxlength=40;
?>