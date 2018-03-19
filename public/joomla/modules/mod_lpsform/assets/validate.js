function submitLpsForm(formId) {
	
	for (var i=0;i<window.modLpsFormValidations.length;i++) {
		if (validateLpsField(window.modLpsFormValidations[i])) {
			return false;
		} else {
			continue;
		}
	}	

	//submit the form
	document.forms['lps-form-'+formId].submit(); 
}




function validateLpsField(field) {
	//var fieldInfo = getLpsFieldInfo(validations);
	//alert(JSON.stringify(fieldInfo));
	var name = field.NAME.replace(/ /g,'-').toLowerCase();
	//name = name.toLowerCase();
	if (field.hasOwnProperty('ITEMS')) { //if this is select, radio, checkbox
		var selectorBase = "[name="+name+"__"+field.field_id+"]";
		if (field.type_id == 3) { //this is a select
			var value = jQuery( selectorBase ).val();
		} else { //this is a radio or checkbox
			var value = jQuery( selectorBase+":checked" ).val();			
		}
	} else {
		var selectorBase = "#"+name+"__"+field.field_id;
		var value = jQuery( selectorBase ).val();
	}

	//alert(value);
	var problemsFound = false;

	if ( (field.hasOwnProperty('REQUIRED')) && (field.REQUIRED == 'YES') ) {
		//alert('here it is required property');
		if (value) {  //the required field is populated
			jQuery( selectorBase ).removeAttr('style');
			jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
			//continue;
		} else {
			problemsFound = true;
			triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
		}
	}

	if ( (field.hasOwnProperty('VALIDATION_RULE')) && (field.VALIDATION_RULE !== 'none') ) {
		//alert(validations[i].VALIDATION_RULE);
		switch (field.VALIDATION_RULE) {
			case 'alpha':
				if (/^[A-z]+$/.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'numeric':
				if (/^[0-9]+$/.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'alphanumeric':
				if (/^[a-zA-Z0-9]*$/.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'email':
				if (/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'phonenumber':
				if (/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'ipaddress':
				if (/^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break;
			case 'validurl':
				if (/^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i.test(value)) { //passes
					jQuery( selectorBase ).removeAttr('style');
					jQuery( selectorBase+"_error_msg" ).empty().hide(); //empty error message and hide
					//continue;
				} else { //fails
					problemsFound = true;
					triggerLpsValidation(field.field_id,name,field.VALIDATION_MESSAGE); //halt the form submission process and display validation msg
				}
				break; 
		} 

	}


	if (problemsFound) {
		return true;
	} else {
		return false;
	}

}

function triggerLpsValidation(fieldId,fieldName,validationMsg) {
	var styles = 'border-color:#dc8d99!important;background:#fff7f8!important;color:#d85030!important;';
	jQuery( "#"+fieldName+"__"+fieldId ).removeAttr('style');
	jQuery( "#"+fieldName+"__"+fieldId ).attr('style',styles);
	jQuery( "#"+fieldName+"__"+fieldId+"_error_msg" ).empty().show().html(validationMsg);
}

function getLpsFieldInfo(validations) {
	var info = {};
		info.name = '';
		info.msg = 'invalid input';
	for (var i=0;i<validations.length;i++) {
		if (validations[i].hasOwnProperty('NAME')) {
			info.name = validations[i].NAME;
		}
		if (validations[i].hasOwnProperty('VALIDATION_MESSAGE')) {
			info.msg = validations[i].VALIDATION_MESSAGE;
		}
	}
	return info;
}






