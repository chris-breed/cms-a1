/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

jQuery(function($) {
	//sortable calendar list
	//$( "#lps-fields-sortable" ).sortable();
	//$( "#lps-fields-sortable" ).disableSelection();

	//hide bulk actions checkboxes
	$( ".lps-fields-bulk-actions-checkboxes" ).hide();

 
    $( "#lps-fields-sortable" ).sortable({
     	//observe the update event...
        update: function(event, ui) {
			//create the array that hold the positions...
			var order = []; 
			//loop trought each tr...
			$('#lps-fields-sortable tr').each( function(e) {
				var item = {"id":$(this).attr('id'),"order":( $(this).index() + 1 )}
				order.push( item );
			});
			//alert( JSON.stringify(order) );
			var message = LanguageFile.COM_LPS_FIELDS_CONFIRM_ORDERING_CHANGE;
			var confirmStatus = UIkit.modal.confirm(message, function(){ 

				$( "#lps-fields-ordering" ).val(JSON.stringify(order));
				document.forms['lpsFieldOrderingForm'].submit();

			});
			if (!confirmStatus) {
				// /alert('user clicked cancel');
			}
        }
    });
    $( "#lps-fields-sortable" ).disableSelection();

});


var published = 1;
var fieldTypeId = 0;

var editItemId = 0;
var editPublished = 1;
var editFieldTypeId = 0;

function toggleIcon(state,field,id) {

	if (state == 0) {	
		var styles = 'cursor:pointer;font-size:30px;color:rgba(216, 80, 48, 1);';
		var classAttr = 'uk-icon-toggle-off';
		var newState = 1;
	} else {
		var styles = 'cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);';
		var classAttr = 'uk-icon-toggle-on';
		var newState = 0;
	}

	//change the UI
	jQuery( "#"+id ).removeAttr('onclick');
	jQuery( "#"+id ).attr('onclick','toggleIcon('+newState+',\''+field+'\',\''+id+'\')');

	jQuery( "#"+id ).removeAttr('class');
	jQuery( "#"+id ).attr('class',classAttr);

	jQuery( "#"+id ).removeAttr('style');
	jQuery( "#"+id ).attr('style',styles);

	//set the needed vars
	switch(field) {
		case 'published':
				published = state;
			break;
		case 'user-email-mode':
				userEmailMode = state;
			break;
		case 'admin-email-mode':
				adminEmailMode = state;
			break;				
	}
}	

function getFieldTypeData(typeId) {
	for (var i=0;i<window.FieldTypes.length;i++) {
		if (window.FieldTypes[i].id == typeId) {
			return window.FieldTypes[i];
		}
	}

	return false;
}

function toggleNewFieldTypes(typeId) {
		
	fieldTypeId = typeId;

	//iterate over field types hiding all and showing the selected field type
	for (var i=0;i<window.FieldTypes.length;i++) {
		var fieldName = window.FieldTypes[i].name;
		var fieldNameCleaned = fieldName.replace(/_/g,'');
		console.log(fieldNameCleaned)
		if (window.FieldTypes[i].id == typeId) {
			//show the field area
			jQuery( "#lps-fields-new-field-"+fieldNameCleaned+"-type-area" ).show('blind');
			//field type has been selected so hide the validation stuff for field type
			jQuery( "#lps-fields-field-type" ).removeAttr('class');
			jQuery( "#lps-fields-field-type" ).attr('class','uk-width-1-1 uk-form-large');
			jQuery( "#lps-fields-field-type-validation-msg" ).empty();
			jQuery( "#lps-fields-field-type-validation-msg" ).hide();
		} else {
			jQuery( "#lps-fields-new-field-"+fieldNameCleaned+"-type-area" ).hide();
		}
	}

	//jQuery( "#lps-fields-new-field-"+type+"-type-area" ).show();
}

function toggleEditFieldTypes(typeId) {
		
	editFieldTypeId = typeId;

	//iterate over field types hiding all and showing the selected field type
	for (var i=0;i<window.FieldTypes.length;i++) {
		var fieldName = window.FieldTypes[i].name;
		var fieldNameCleaned = fieldName.replace(/_/g,'');
		console.log(fieldNameCleaned)
		if (window.FieldTypes[i].id == typeId) {
			jQuery( "#lps-fields-edit-field-"+fieldNameCleaned+"-type-area" ).show();
		} else {
			jQuery( "#lps-fields-edit-field-"+fieldNameCleaned+"-type-area" ).hide();
		}
	}

	//jQuery( "#lps-fields-new-field-"+type+"-type-area" ).show();
}

/**
* catch all function to do tabs within the different form elements
* show the general area of a form element
*
**/
function showFormFieldGeneralArea(fieldTypeName) {
	jQuery(function($){

		//first reset button classes
		$( "#"+fieldTypeName+"-general-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-validation-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-attributes-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-general-btn" ).attr('class','uk-active');

		//then change the slides
		$( "#"+fieldTypeName+"-general" ).show();
		$( "#"+fieldTypeName+"-validation" ).hide();
		$( "#"+fieldTypeName+"-attributes" ).hide();
	});
}

/**
* catch all function to do tabs within the different form elements
* show the validations area of a form element
*
**/
function showFormFieldValidationArea(fieldTypeName) {
	jQuery(function($){
		//first reset button classes
		$( "#"+fieldTypeName+"-general-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-validation-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-attributes-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-validation-btn" ).attr('class','uk-active');

		//then change the slides
		$( "#"+fieldTypeName+"-general" ).hide();
		$( "#"+fieldTypeName+"-validation" ).show();
		$( "#"+fieldTypeName+"-attributes" ).hide();
	});	
}

/**
* catch all function to do tabs within the different form elements
* show the attributes area of a form element
*
**/
function showFormFieldAttributesArea(fieldTypeName) {
	jQuery(function($){
		//first reset button classes
		$( "#"+fieldTypeName+"-general-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-validation-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-attributes-btn" ).removeAttr('class');
		$( "#"+fieldTypeName+"-attributes-btn" ).attr('class','uk-active');

		//then change the slides
		$( "#"+fieldTypeName+"-general" ).hide();
		$( "#"+fieldTypeName+"-validation" ).hide();
		$( "#"+fieldTypeName+"-attributes" ).show();
	});	
}

/**
* catch all function to do tabs within the different form elements
* show the general area of a form element
*
**/
function showEditFormFieldGeneralArea(fieldTypeName) {
	jQuery(function($){
		//then change the slides
		$( "#"+fieldTypeName+"-edit-general" ).show();
		$( "#"+fieldTypeName+"-edit-validation" ).hide();
		$( "#"+fieldTypeName+"-edit-attributes" ).hide();
	});
}

/**
* catch all function to do tabs within the different form elements
* show the validations area of a form element
*
**/
function showEditFormFieldValidationArea(fieldTypeName) {
	jQuery(function($){
		//then change the slides
		$( "#"+fieldTypeName+"-edit-general" ).hide();
		$( "#"+fieldTypeName+"-edit-validation" ).show();
		$( "#"+fieldTypeName+"-edit-attributes" ).hide();
	});	
}

/**
* catch all function to do tabs within the different form elements
* show the attributes area of a form element
*
**/
function showEditFormFieldAttributesArea(fieldTypeName) {
	jQuery(function($){
		//then change the slides
		$( "#"+fieldTypeName+"-edit-general" ).hide();
		$( "#"+fieldTypeName+"-edit-validation" ).hide();
		$( "#"+fieldTypeName+"-edit-attributes" ).show();
	});	
}

/**
*  Get data from page and prepare for ajax call
*
*/
function getNewFieldData(type,typeId) {
	var field = {};
	var className = 'uk-width-1-1';
	if (type == 'textbox') {

		//general
		var name = jQuery( "#lps-fields-textbox-name" ).val();	
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-textbox-name" ).removeAttr('class');
			jQuery( "#lps-fields-textbox-name" ).attr('class',className);
			jQuery( "#lps-fields-textbox-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-textbox-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-textbox-name" ).removeAttr('class');
			jQuery( "#lps-fields-textbox-name" ).attr('class',className);	
			jQuery( "#lps-fields-textbox-name-validation-msg" ).empty();
			jQuery( "#lps-fields-textbox-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-textbox-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-textbox-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-textbox-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-textbox-form-id" ).removeAttr('class');	
		}
		var caption =jQuery( "#lps-fields-textbox-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-textbox-caption" ).removeAttr('class');
			jQuery( "#lps-fields-textbox-caption" ).attr('class',className);
			jQuery( "#lps-fields-textbox-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-textbox-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-textbox-caption" ).removeAttr('class');
			jQuery( "#lps-fields-textbox-caption" ).attr('class',className);	
			jQuery( "#lps-fields-textbox-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-textbox-caption-validation-msg" ).hide();	
		}
		var defaultValue = jQuery( "#lps-fields-textbox-default_value" ).val();
		var description = jQuery( "#lps-fields-textbox-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-textbox-required" ).val();
		var validationRule = jQuery( "#lps-fields-textbox-validation-rule" ).val();
		var validationMessage = jQuery( "#lps-fields-textbox-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-textbox-size" ).val();
		var maxSize = jQuery( "#lps-fields-textbox-max-size" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_rule":validateIllegalChars(validationRule),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"max_size":validateIllegalChars(maxSize)
						};

	} else if (type == 'textarea') {

		//general
		var name = jQuery( "#lps-fields-textarea-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-textarea-name" ).removeAttr('class');
			jQuery( "#lps-fields-textarea-name" ).attr('class',className);
			jQuery( "#lps-fields-textarea-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-textarea-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-textarea-name" ).removeAttr('class');
			jQuery( "#lps-fields-textarea-name" ).attr('class',className);	
			jQuery( "#lps-fields-textarea-name-validation-msg" ).empty();
			jQuery( "#lps-fields-textarea-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-textarea-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-textarea-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-textarea-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-textarea-form-id" ).removeAttr('class');	
		}
		var caption = jQuery( "#lps-fields-textarea-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-textarea-caption" ).removeAttr('class');
			jQuery( "#lps-fields-textarea-caption" ).attr('class',className);
			jQuery( "#lps-fields-textarea-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-textarea-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-textarea-caption" ).removeAttr('class');
			jQuery( "#lps-fields-textarea-caption" ).attr('class',className);	
			jQuery( "#lps-fields-textarea-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-textarea-caption-validation-msg" ).hide();	
		}
		var defaultValue = jQuery( "#lps-fields-textarea-default_value" ).val();
		var description = jQuery( "#lps-fields-textarea-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-textarea-required" ).val();
		var validationRule = jQuery( "#lps-fields-textarea-validation-rule" ).val();
		var validationMessage = jQuery( "#lps-fields-textarea-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-textarea-size" ).val();
		var maxSize = jQuery( "#lps-fields-textarea-max-size" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_rule":validateIllegalChars(validationRule),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"max_size":validateIllegalChars(maxSize)
						};

	} else if (type == 'selectlist') {

		//general
		var name = jQuery( "#lps-fields-selectlist-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-selectlist-name" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-name" ).attr('class',className);
			jQuery( "#lps-fields-selectlist-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-selectlist-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-selectlist-name" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-name" ).attr('class',className);	
			jQuery( "#lps-fields-selectlist-name-validation-msg" ).empty();
			jQuery( "#lps-fields-selectlist-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-selectlist-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-selectlist-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-selectlist-form-id" ).removeAttr('class');	
		}
		var caption = jQuery( "#lps-fields-selectlist-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-selectlist-caption" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-caption" ).attr('class',className);
			jQuery( "#lps-fields-selectlist-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-selectlist-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-selectlist-caption" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-caption" ).attr('class',className);	
			jQuery( "#lps-fields-selectlist-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-selectlist-caption-validation-msg" ).hide();	
		}
		var items = jQuery( "#lps-fields-selectlist-items" ).val();
		if (!items) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-selectlist-items" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-items" ).attr('class',className);
			jQuery( "#lps-fields-selectlist-items-validation-msg" ).empty().html('Items are required. Enter your choices one per line.');
			jQuery( "#lps-fields-selectlist-items-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-selectlist-items" ).removeAttr('class');
			jQuery( "#lps-fields-selectlist-items" ).attr('class',className);	
			jQuery( "#lps-fields-selectlist-items-validation-msg" ).empty();
			jQuery( "#lps-fields-selectlist-items-validation-msg" ).hide();	
		}
		var description = jQuery( "#lps-fields-selectlist-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-selectlist-required" ).val();
		var validationMessage = jQuery( "#lps-fields-selectlist-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-selectlist-size" ).val();
		var multiple = jQuery( "#lps-fields-selectlist-multiple" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"multiple":validateIllegalChars(multiple)
						};
		
	} else if (type == 'checkboxgroup') {

		//general
		var name = jQuery( "#lps-fields-checkboxgroup-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-checkboxgroup-name" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-name" ).attr('class',className);
			jQuery( "#lps-fields-checkboxgroup-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-checkboxgroup-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-checkboxgroup-name" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-name" ).attr('class',className);	
			jQuery( "#lps-fields-checkboxgroup-name-validation-msg" ).empty();
			jQuery( "#lps-fields-checkboxgroup-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-checkboxgroup-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-checkboxgroup-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-checkboxgroup-form-id" ).removeAttr('class');	
		}
		var caption = jQuery( "#lps-fields-checkboxgroup-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-checkboxgroup-caption" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-caption" ).attr('class',className);
			jQuery( "#lps-fields-checkboxgroup-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-checkboxgroup-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-checkboxgroup-caption" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-caption" ).attr('class',className);	
			jQuery( "#lps-fields-checkboxgroup-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-checkboxgroup-caption-validation-msg" ).hide();	
		}
		var items = jQuery( "#lps-fields-checkboxgroup-items" ).val();
		if (!items) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-checkboxgroup-items" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-items" ).attr('class',className);
			jQuery( "#lps-fields-checkboxgroup-items-validation-msg" ).empty().html('Items are required. Enter your choices one per line.');
			jQuery( "#lps-fields-checkboxgroup-items-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-checkboxgroup-items" ).removeAttr('class');
			jQuery( "#lps-fields-checkboxgroup-items" ).attr('class',className);	
			jQuery( "#lps-fields-checkboxgroup-items-validation-msg" ).empty();
			jQuery( "#lps-fields-checkboxgroup-items-validation-msg" ).hide();	
		}
		var description = jQuery( "#lps-fields-checkboxgroup-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-checkboxgroup-required" ).val();
		var validationMessage = jQuery( "#lps-fields-checkboxgroup-validation-message" ).val();

		//attributes
		var flow = jQuery( "#lps-fields-checkboxgroup-flow" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"flow":validateIllegalChars(flow)
						};
		
	} else if (type == 'radiogroup') {

		//general
		var name = jQuery( "#lps-fields-radiogroup-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-radiogroup-name" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-name" ).attr('class',className);
			jQuery( "#lps-fields-radiogroup-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-radiogroup-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-radiogroup-name" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-name" ).attr('class',className);	
			jQuery( "#lps-fields-radiogroup-name-validation-msg" ).empty();
			jQuery( "#lps-fields-radiogroup-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-radiogroup-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-radiogroup-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-radiogroup-form-id" ).removeAttr('class');	
		}
		var caption = jQuery( "#lps-fields-radiogroup-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-radiogroup-caption" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-caption" ).attr('class',className);
			jQuery( "#lps-fields-radiogroup-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-radiogroup-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-radiogroup-caption" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-caption" ).attr('class',className);	
			jQuery( "#lps-fields-radiogroup-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-radiogroup-caption-validation-msg" ).hide();	
		}
		var items = jQuery( "#lps-fields-radiogroup-items" ).val();
		if (!items) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-radiogroup-items" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-items" ).attr('class',className);
			jQuery( "#lps-fields-radiogroup-items-validation-msg" ).empty().html('Items are required. Enter your choices one per line.');
			jQuery( "#lps-fields-radiogroup-items-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-radiogroup-items" ).removeAttr('class');
			jQuery( "#lps-fields-radiogroup-items" ).attr('class',className);	
			jQuery( "#lps-fields-radiogroup-items-validation-msg" ).empty();
			jQuery( "#lps-fields-radiogroup-items-validation-msg" ).hide();	
		}
		var description = jQuery( "#lps-fields-radiogroup-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-radiogroup-required" ).val();
		var validationMessage = jQuery( "#lps-fields-radiogroup-validation-message" ).val();

		//attributes
		var flow = jQuery( "#lps-fields-radiogroup-flow" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"flow":validateIllegalChars(flow)
						};
		
	} else if (type == 'submitbutton') {

		//general
		var name = jQuery( "#lps-fields-submitbutton-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-submitbutton-name" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-name" ).attr('class',className);
			jQuery( "#lps-fields-submitbutton-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-submitbutton-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-submitbutton-name" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-name" ).attr('class',className);	
			jQuery( "#lps-fields-submitbutton-name-validation-msg" ).empty();
			jQuery( "#lps-fields-submitbutton-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-submitbutton-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-submitbutton-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-submitbutton-form-id" ).removeAttr('class');	
		}
		var label = jQuery( "#lps-fields-submitbutton-label" ).val();
		if (!label) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-submitbutton-label" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-label" ).attr('class',className);
			jQuery( "#lps-fields-submitbutton-label-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-submitbutton-label-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-submitbutton-label" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-label" ).attr('class',className);	
			jQuery( "#lps-fields-submitbutton-label-validation-msg" ).empty();
			jQuery( "#lps-fields-submitbutton-label-validation-msg" ).hide();	
		}
		var caption = jQuery( "#lps-fields-submitbutton-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-submitbutton-caption" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-caption" ).attr('class',className);
			jQuery( "#lps-fields-submitbutton-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-submitbutton-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-submitbutton-caption" ).removeAttr('class');
			jQuery( "#lps-fields-submitbutton-caption" ).attr('class',className);	
			jQuery( "#lps-fields-submitbutton-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-submitbutton-caption-validation-msg" ).hide();	
		}

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"label":validateIllegalChars(label)
						};
		
	} else if (type == 'freetext') {

		//general
		var name = jQuery( "#lps-fields-freetext-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-freetext-name" ).removeAttr('class');
			jQuery( "#lps-fields-freetext-name" ).attr('class',className);
			jQuery( "#lps-fields-freetext-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-freetext-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-freetext-name" ).removeAttr('class');
			jQuery( "#lps-fields-freetext-name" ).attr('class',className);	
			jQuery( "#lps-fields-freetext-name-validation-msg" ).empty();
			jQuery( "#lps-fields-freetext-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-freetext-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-freetext-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-freetext-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-freetext-form-id" ).removeAttr('class');	
		}
		var text = jQuery( "#lps-fields-freetext-text" ).val();
		if (!text) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-freetext-text" ).removeAttr('class');
			jQuery( "#lps-fields-freetext-text" ).attr('class',className);
			jQuery( "#lps-fields-freetext-text-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-freetext-text-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-freetext-text" ).removeAttr('class');
			jQuery( "#lps-fields-freetext-text" ).attr('class',className);	
			jQuery( "#lps-fields-freetext-text-validation-msg" ).empty();
			jQuery( "#lps-fields-freetext-text-validation-msg" ).hide();	
		}

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"text":validateIllegalChars(text)
						};

	} else if (type == 'calendar') {

		//general
		var name = jQuery( "#lps-fields-calendar-name" ).val();
		if (!name) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-calendar-name" ).removeAttr('class');
			jQuery( "#lps-fields-calendar-name" ).attr('class',className);
			jQuery( "#lps-fields-calendar-name-validation-msg" ).empty().html('Name is required');
			jQuery( "#lps-fields-calendar-name-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-calendar-name" ).removeAttr('class');
			jQuery( "#lps-fields-calendar-name" ).attr('class',className);	
			jQuery( "#lps-fields-calendar-name-validation-msg" ).empty();
			jQuery( "#lps-fields-calendar-name-validation-msg" ).hide();	
		}
		var formId = jQuery( "#lps-fields-calendar-form-id" ).val();
		if (!formId) { //validation
			jQuery( "#lps-fields-calendar-form-id" ).removeAttr('class');
			jQuery( "#lps-fields-calendar-form-id" ).attr('class','uk-form-danger');
			return false;
		} else {
			jQuery( "#lps-fields-calendar-form-id" ).removeAttr('class');	
		}
		var caption = jQuery( "#lps-fields-calendar-caption" ).val();
		if (!caption) { //validation
			className += ' uk-form-danger'
			jQuery( "#lps-fields-calendar-caption" ).removeAttr('class');
			jQuery( "#lps-fields-calendar-caption" ).attr('class',className);
			jQuery( "#lps-fields-calendar-caption-validation-msg" ).empty().html('Caption is required');
			jQuery( "#lps-fields-calendar-caption-validation-msg" ).show();
			return false;
		} else {
			jQuery( "#lps-fields-calendar-caption" ).removeAttr('class');
			jQuery( "#lps-fields-calendar-caption" ).attr('class',className);	
			jQuery( "#lps-fields-calendar-caption-validation-msg" ).empty();
			jQuery( "#lps-fields-calendar-caption-validation-msg" ).hide();	
		}
		var defaultValue = jQuery( "#lps-fields-calendar-default-value" ).val();
		var description = jQuery( "#lps-fields-calendar-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-calendar-required" ).val();
		var validationMessage = jQuery( "#lps-fields-calendar-validation-message" ).val();

		//attributes
		var dateFormat = jQuery( "#lps-fields-calendar-date-format" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"date_format":validateIllegalChars(dateFormat)
						};
		
	} 

	return field;
}

function saveNewField() {

	//get the data from page for desired field creation
	var className = 'uk-width-1-1 uk-form-large';
	var fieldType = getFieldTypeData(fieldTypeId);
	if (!fieldType) {
		className += ' uk-form-danger'
		jQuery( "#lps-fields-field-type" ).removeAttr('class');
		jQuery( "#lps-fields-field-type" ).attr('class',className);
		jQuery( "#lps-fields-field-type-validation-msg" ).show();
		jQuery( "#lps-fields-field-type-validation-msg" ).empty().html('Select a field type first.');
		return false;
	} else {
		jQuery( "#lps-fields-field-type" ).removeAttr('class');
		jQuery( "#lps-fields-field-type" ).attr('class',className);
		jQuery( "#lps-fields-field-type-validation-msg" ).empty();
		jQuery( "#lps-fields-field-type-validation-msg" ).hide();
	}
	var fieldTypeName = fieldType.name.replace(/_/g, ''); //remove underscores
	var field = getNewFieldData(fieldTypeName,fieldTypeId);
	if (field) { //only submit form and proceed if validation has been passed
		//set the value of form object input
		jQuery( "#lps-fields-field-object" ).val( JSON.stringify(field) );
		//submit the form
		document.forms['createNewField'].submit(); 
	}

}

function clearNewLpsFormsValues() {
	jQuery( "#lps-fields-name" ).val('');

	published = 1;
	showTitle = 0;
	showButtons = 1;
	showTime = 0;

	jQuery( "#lps-fields-description" ).val('');

	gcalToggle = 0;
	gcalIdCount = 0;
	gcalIdBin = [0];
	jQuery( "#lps-fields-google-calendar-ids-bin" ).empty(); //empty gcal ids bin
	toggleIcon(0,'gcalToggle','lps-fields-gcal-toggle'); //turn off integration and hide gcal ids
}

function closeNewFieldModal() {
	UIkit.modal("#lps-fields-create-new").hide();
}

function launchEditFieldModal(itemId) {
	editItemId = itemId;
	UIkit.modal("#lps-fields-edit-field").show();
	populateEditField(itemId);	
}

function toggleEditIcon(state,field,id) {

	if (state == 0) {	
		var styles = 'cursor:pointer;font-size:30px;color:rgba(216, 80, 48, 1);';
		var classAttr = 'uk-icon-toggle-off';
		var newState = 1;
	} else {
		var styles = 'cursor:pointer;font-size:30px;color:rgba(101, 159, 19, 1);';
		var classAttr = 'uk-icon-toggle-on';
		var newState = 0;
	}

	//change the UI
	jQuery( "#"+id ).removeAttr('onclick');
	jQuery( "#"+id ).attr('onclick','toggleEditIcon('+newState+',\''+field+'\',\''+id+'\')');

	jQuery( "#"+id ).removeAttr('class');
	jQuery( "#"+id ).attr('class',classAttr);

	jQuery( "#"+id ).removeAttr('style');
	jQuery( "#"+id ).attr('style',styles);

	//set the needed vars
	switch(field) {
		case 'published':
				editPublished = state;
			break;
		case 'user-email-mode':
				editUserEmailMode = state;
			break;
		case 'admin-email-mode':
				editAdminEmailMode = state;
			break;				
	}

}	

function populateEditField(itemId) {
	var fieldItem = getFieldItemData(itemId);
	console.log(fieldItem)
	editItemId = itemId;

	jQuery( "#lps-fields-edit-field-type" ).val(fieldItem.type_id);
	toggleEditFieldTypes(fieldItem.type_id);

	var fieldType = getFieldTypeData(fieldItem.type_id);
	var fieldTypeName = fieldType.name.replace(/_/g, ''); //remove underscores

	populateEditFieldData(fieldTypeName,fieldItem);
	
}

/**
*  Get data from page and prepare for ajax call
*
*/
function populateEditFieldData(type,fieldItem) {
	var field = {};

	if (type == 'textbox') {

		//general
		jQuery( "#lps-fields-edit-textbox-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-textbox-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-textbox-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-textbox-default_value" ).val(fieldItem.properties.DEFAULT_VALUE);
		jQuery( "#lps-fields-edit-textbox-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-textbox-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-textbox-validation-rule" ).val(fieldItem.properties.VALIDATION_RULE);
		jQuery( "#lps-fields-edit-textbox-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-textbox-size" ).val(fieldItem.properties.SIZE);
		jQuery( "#lps-fields-edit-textbox-max-size" ).val(fieldItem.properties.MAX_SIZE);

	} else if (type == 'textarea') {

		//general
		jQuery( "#lps-fields-edit-textarea-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-textarea-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-textarea-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-textarea-default_value" ).val(fieldItem.properties.DEFAULT_VALUE);
		jQuery( "#lps-fields-edit-textarea-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-textarea-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-textarea-validation-rule" ).val(fieldItem.properties.VALIDATION_RULE);
		jQuery( "#lps-fields-edit-textarea-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-textarea-size" ).val(fieldItem.properties.SIZE);
		jQuery( "#lps-fields-edit-textarea-max-size" ).val(fieldItem.properties.MAX_SIZE);

	} else if (type == 'selectlist') {

		//general
		jQuery( "#lps-fields-edit-selectlist-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-selectlist-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-selectlist-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-selectlist-items" ).val(fieldItem.properties.DEFAULT_VALUE);
		jQuery( "#lps-fields-edit-selectlist-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-selectlist-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-selectlist-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-selectlist-size" ).val(fieldItem.properties.SIZE);
		jQuery( "#lps-fields-edit-selectlist-multiple" ).val(fieldItem.properties.MULTIPLE);
		
	} else if (type == 'checkboxgroup') {

		//general
		jQuery( "#lps-fields-edit-checkboxgroup-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-checkboxgroup-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-checkboxgroup-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-checkboxgroup-items" ).val(fieldItem.properties.ITEMS);
		jQuery( "#lps-fields-edit-checkboxgroup-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-checkboxgroup-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-checkboxgroup-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-checkboxgroup-flow" ).val(fieldItem.properties.FLOW);
		
	} else if (type == 'radiogroup') {

		//general
		jQuery( "#lps-fields-edit-radiogroup-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-radiogroup-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-radiogroup-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-radiogroup-items" ).val(fieldItem.properties.ITEMS);
		jQuery( "#lps-fields-edit-radiogroup-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-radiogroup-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-radiogroup-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-radiogroup-flow" ).val();
		
	} else if (type == 'submitbutton') {

		//general
		jQuery( "#lps-fields-edit-submitbutton-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-submitbutton-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-submitbutton-label" ).val(fieldItem.properties.LABEL);
		jQuery( "#lps-fields-edit-submitbutton-caption" ).val(fieldItem.properties.CAPTION);
		
	} else if (type == 'freetext') {

		//general
		jQuery( "#lps-fields-edit-freetext-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-freetext-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-freetext-text" ).val(fieldItem.properties.TEXT);

	} else if (type == 'calendar') {

		//general
		jQuery( "#lps-fields-edit-calendar-name" ).val(fieldItem.properties.NAME);
		jQuery( "#lps-fields-edit-calendar-form-id" ).val(fieldItem.form_id);
		jQuery( "#lps-fields-edit-calendar-caption" ).val(fieldItem.properties.CAPTION);
		jQuery( "#lps-fields-edit-calendar-default-value" ).val(fieldItem.properties.DEFAULT_VALUE);
		jQuery( "#lps-fields-edit-calendar-description" ).val(fieldItem.properties.DESCRIPTION);

		//validation
		jQuery( "#lps-fields-edit-calendar-required" ).val(fieldItem.properties.REQUIRED);
		jQuery( "#lps-fields-edit-calendar-validation-message" ).val(fieldItem.properties.VALIDATION_MESSAGE);

		//attributes
		jQuery( "#lps-fields-edit-calendar-date-format" ).val(fieldItem.properties.DATE_FORMAT);
		
	} 

}

function clearEditFormFormValues() {
	jQuery( "#lps-fields-edit-name" ).val('');
	jQuery( "#lps-fields-edit-description" ).val('');
	editPublished = 0;		
}

function clearNewFormFormValues() {
	jQuery( "#lps-fields-name" ).val('');
	jQuery( "#lps-fields-description" ).val('');
	published = 0;	
}

function getFieldItemData(itemId) {
	for (var i=0;i<window.FieldItems.length;i++) {
		if (window.FieldItems[i].id == itemId) {
			return window.FieldItems[i];
		}
	}

	return false;
}

/**
*  Get data from page and prepare for ajax call
*
*/
function getEditFieldData(type,typeId) {
	var field = {};

	if (type == 'textbox') {

		//general
		var name = jQuery( "#lps-fields-edit-textbox-name" ).val();
		var formId = jQuery( "#lps-fields-edit-textbox-form-id" ).val();
		var caption =jQuery( "#lps-fields-edit-textbox-caption" ).val();
		var defaultValue = jQuery( "#lps-fields-edit-textbox-default_value" ).val();
		var description = jQuery( "#lps-fields-edit-textbox-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-textbox-required" ).val();
		var validationRule = jQuery( "#lps-fields-edit-textbox-validation-rule" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-textbox-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-edit-textbox-size" ).val();
		var maxSize = jQuery( "#lps-fields-edit-textbox-max-size" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_rule":validateIllegalChars(validationRule),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"max_size":validateIllegalChars(maxSize)
						};

	} else if (type == 'textarea') {

		//general
		var name = jQuery( "#lps-fields-edit-textarea-name" ).val();
		var formId = jQuery( "#lps-fields-edit-textarea-form-id" ).val();
		var caption = jQuery( "#lps-fields-edit-textarea-caption" ).val();
		var defaultValue = jQuery( "#lps-fields-edit-textarea-default_value" ).val();
		var description = jQuery( "#lps-fields-edit-textarea-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-textarea-required" ).val();
		var validationRule = jQuery( "#lps-fields-edit-textarea-validation-rule" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-textarea-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-edit-textarea-size" ).val();
		var maxSize = jQuery( "#lps-fields-edit-textarea-max-size" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_rule":validateIllegalChars(validationRule),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"max_size":validateIllegalChars(maxSize)
						};

	} else if (type == 'selectlist') {

		//general
		var name = jQuery( "#lps-fields-edit-selectlist-name" ).val();
		var formId = jQuery( "#lps-fields-edit-selectlist-form-id" ).val();
		var caption = jQuery( "#lps-fields-edit-selectlist-caption" ).val();
		var items = jQuery( "#lps-fields-edit-selectlist-items" ).val();
		var description = jQuery( "#lps-fields-edit-selectlist-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-selectlist-required" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-selectlist-validation-message" ).val();

		//attributes
		var size = jQuery( "#lps-fields-edit-selectlist-size" ).val();
		var multiple = jQuery( "#lps-fields-edit-selectlist-multiple" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"size":validateIllegalChars(size),
							"multiple":validateIllegalChars(multiple)
						};
		
	} else if (type == 'checkboxgroup') {

		//general
		var name = jQuery( "#lps-fields-edit-checkboxgroup-name" ).val();
		var formId = jQuery( "#lps-fields-edit-checkboxgroup-form-id" ).val();
		var caption = jQuery( "#lps-fields-edit-checkboxgroup-caption" ).val();
		var items = jQuery( "#lps-fields-edit-checkboxgroup-items" ).val();
		var description = jQuery( "#lps-fields-edit-checkboxgroup-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-checkboxgroup-required" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-checkboxgroup-validation-message" ).val();

		//attributes
		var flow = jQuery( "#lps-fields-edit-checkboxgroup-flow" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"flow":validateIllegalChars(flow)
						};
		
	} else if (type == 'radiogroup') {

		//general
		var name = jQuery( "#lps-fields-edit-radiogroup-name" ).val();
		var formId = jQuery( "#lps-fields-edit-radiogroup-form-id" ).val();
		var caption = jQuery( "#lps-fields-edit-radiogroup-caption" ).val();
		var items = jQuery( "#lps-fields-edit-radiogroup-items" ).val();
		var description = jQuery( "#lps-fields-edit-radiogroup-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-radiogroup-required" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-radiogroup-validation-message" ).val();

		//attributes
		var flow = jQuery( "#lps-fields-edit-radiogroup-flow" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"items":validateIllegalChars(items),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"flow":validateIllegalChars(flow)
						};
		
	} else if (type == 'submitbutton') {

		//general
		var name = jQuery( "#lps-fields-edit-submitbutton-name" ).val();
		var formId = jQuery( "#lps-fields-edit-submitbutton-form-id" ).val();
		var label = jQuery( "#lps-fields-edit-submitbutton-label" ).val();
		var caption = jQuery( "#lps-fields-edit-submitbutton-caption" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"label":validateIllegalChars(label)
						};
		
	} else if (type == 'freetext') {

		//general
		var name = jQuery( "#lps-fields-edit-freetext-name" ).val();
		var formId = jQuery( "#lps-fields-edit-freetext-form-id" ).val();
		var text = jQuery( "#lps-fields-edit-freetext-text" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"text":validateIllegalChars(text)
						};

	} else if (type == 'calendar') {

		//general
		var name = jQuery( "#lps-fields-edit-calendar-name" ).val();
		var formId = jQuery( "#lps-fields-edit-calendar-form-id" ).val();
		var caption = jQuery( "#lps-fields-edit-calendar-caption" ).val();
		var defaultValue = jQuery( "#lps-fields-edit-calendar-default-value" ).val();
		var description = jQuery( "#lps-fields-edit-calendar-description" ).val();

		//validation
		var required = jQuery( "#lps-fields-edit-calendar-required" ).val();
		var validationMessage = jQuery( "#lps-fields-edit-calendar-validation-message" ).val();

		//attributes
		var dateFormat = jQuery( "#lps-fields-edit-calendar-date-format" ).val();

		field.type = type;
		field.type_id = typeId;
		field.form_id = formId;
		field.values = {
							"name":validateIllegalChars(name),
							"caption":validateIllegalChars(caption),
							"default_value":validateIllegalChars(defaultValue),
							"description":validateIllegalChars(description),
							"required":validateIllegalChars(required),
							"validation_message":validateIllegalChars(validationMessage),
							"date_format":validateIllegalChars(dateFormat)
						};
		
	} 

	return field;
}

function editField() {

	//get the data from page for desired field creation
	var fieldType = getFieldTypeData(editFieldTypeId);
	var fieldTypeName = fieldType.name.replace(/_/g, ''); //remove underscores
	var field = getEditFieldData(fieldTypeName,editFieldTypeId);

	//set the value of form object input
	jQuery( "#lps-fields-edit-field-object" ).val( JSON.stringify(field) );
	jQuery( "#lps-fields-edit-id" ).val(editItemId); 

	//submit the form
	document.forms['editFieldItem'].submit(); 
}


function closeEditFieldModal() {
	editItemId = 0;
	UIkit.modal("#lps-fields-edit-field").hide();
	//clearEditCalendarFormValues();
}

function searchLpsFields() {

	jQuery( "#lps-fields-clear-search" ).show();

	//submit the form
	document.forms['LpsFieldsSearchForm'].submit();
}

function clearLpsFieldsSearch() {

	jQuery( "#lps-fields-clear-search" ).hide();
	jQuery( "#lps-fields-search" ).val('');

	//submit the form
	document.forms['LpsFieldsSearchForm'].submit();	
}

function togglePublishing(state,itemId) {

	jQuery( "#lps-fields-state" ).val(state);
	jQuery( "#lps-fields-item-id" ).val(itemId);

	//submit the form
	document.forms['lpsFieldsTogglePublishing'].submit();
}

function removeFieldItem(itemId) {
	var message = LanguageFile.COM_LPS_FIELDS_CONFIRM_REMOVE;
	UIkit.modal.confirm(message, function(){ 
	
		jQuery( "#lps-fields-remove-item-id" ).val(itemId);

		//submit the form
		document.forms['lpsFieldsRemoveItem'].submit();	

	});
}

//modal event handling to clear data from closed modals
jQuery(function($){

	//anytime the new modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in new form
	$('#lps-fields-create-new').on({

	    'hide.uk.modal': function(){
	    	clearNewFormFormValues();
	    }

	});
	//anytime the edit modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in edit form
	$('#lps-fields-edit-landing-page').on({

	    'hide.uk.modal': function(){
	    	clearEditFormFormValues();
	    }

	});

});




