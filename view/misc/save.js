$("document").ready(function() {
	$("#form_dictionary").submit(function() {
		save();
		return false;
	});
});

function save() 
{	
	// Submit our form via Ajax and then reset the form
	$("#form_dictionary").ajaxSubmit({success:showResult});
	return false;	
}

function showResult(data) {
	if (data == 'save_failed') {
		alert('Form save failed, please contact your administrator');
		return false;
	} else {
		$("#form_dictionary").clearForm().clearFields().resetForm();
		alert('Form save success');
		return false;
	}
}