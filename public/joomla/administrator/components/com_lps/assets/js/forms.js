/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

jQuery(function($) {
	//sortable calendar list
	//$( "#lps-forms-sortable" ).sortable();
	//$( "#lps-forms-sortable" ).disableSelection();

	//hide bulk actions checkboxes
	$( ".lps-forms-bulk-actions-checkboxes" ).hide();

});


var published = 1;
var userEmailMode = 1;
var adminEmailMode = 1;

var editItemId = 0;
var editPublished = 1;
var editUserEmailMode = 1;
var editAdminEmailMode = 1;


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

function saveNewForm() {

	var formObj = {};

	//basic info
	formObj.name = jQuery( "#lps-forms-name" ).val();
	//validation for form name
	var className = 'uk-width-1-1';
	if (!formObj.name) {
		className += ' uk-form-danger';
		jQuery( "#lps-forms-name" ).removeAttr('class');
		jQuery( "#lps-forms-name" ).attr('class',className);
		jQuery( "#lps-forms-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-forms-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-forms-name" ).removeAttr('class');
		jQuery( "#lps-forms-name" ).attr('class',className);
		jQuery( "#lps-forms-name-validation-msg" ).empty();
		jQuery( "#lps-forms-name-validation-msg" ).hide();	
	}
	formObj.published = published;
	formObj.return_url = jQuery( "#lps-forms-return-url" ).val();
	formObj.show_thank_you = jQuery( "#lps-forms-show-thank-you" ).val();
	formObj.thank_you_message = jQuery( "#lps-forms-thank-you-message" ).val();

	//user emails
	formObj.user_email_text = jQuery( "#lps-forms-user-email-text" ).val();
	formObj.user_email_to = jQuery( "#lps-forms-user-email-to" ).val();
	formObj.user_email_cc = jQuery( "#lps-forms-user-email-cc" ).val();
	formObj.user_email_bcc = jQuery( "#lps-forms-user-email-bcc" ).val();
	formObj.user_email_from = jQuery( "#lps-forms-user-email-from" ).val();
	formObj.user_email_from_name = jQuery( "#lps-forms-user-email-from-name" ).val();
	formObj.user_email_reply_to = jQuery( "#lps-forms-user-email-reply-to" ).val();
	formObj.user_email_subject = jQuery( "#lps-forms-user-email-subject" ).val();
	formObj.user_email_mode = jQuery( "#lps-forms-user-email-mode" ).val();

	//admin emails
	formObj.admin_email_text = jQuery( "#lps-forms-admin-email-text" ).val();
	formObj.admin_email_to = jQuery( "#lps-forms-admin-email-to" ).val();
	formObj.admin_email_cc = jQuery( "#lps-forms-admin-email-cc" ).val();
	formObj.admin_email_bcc = jQuery( "#lps-forms-admin-email-bcc" ).val();
	formObj.admin_email_from = jQuery( "#lps-forms-admin-email-from" ).val();
	formObj.admin_email_from_name = jQuery( "#lps-forms-admin-email-from-name" ).val();
	formObj.admin_email_reply_to = jQuery( "#lps-forms-admin-email-reply-to" ).val();
	formObj.admin_email_subject = jQuery( "#lps-forms-admin-email-subject" ).val();
	formObj.admin_email_mode = jQuery( "#lps-forms-admin-email-mode" ).val();

	console.log(formObj)

	//set the value of form object input
	jQuery( "#lps-forms-form-object" ).val( JSON.stringify(formObj) );

	//submit the form
	document.forms['createNewForm'].submit(); 

}

function showNewFormBasicArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-new-form-basic-area" ).show();
		$( "#lps-forms-new-form-user-email-area" ).hide();
		$( "#lps-forms-new-form-admin-email-area" ).hide();
	});
}

function showNewFormUserEmailArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-new-form-basic-area" ).hide();
		$( "#lps-forms-new-form-user-email-area" ).show();
		$( "#lps-forms-new-form-admin-email-area" ).hide();
	});
}

function showNewFormAdminEmailArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-new-form-basic-area" ).hide();
		$( "#lps-forms-new-form-user-email-area" ).hide();
		$( "#lps-forms-new-form-admin-email-area" ).show();
	});
}

function showEditFormBasicArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-edit-form-basic-area" ).show();
		$( "#lps-forms-edit-form-user-email-area" ).hide();
		$( "#lps-forms-edit-form-admin-email-area" ).hide();
	});
}

function showEditFormUserEmailArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-edit-form-basic-area" ).hide();
		$( "#lps-forms-edit-form-user-email-area" ).show();
		$( "#lps-forms-edit-form-admin-email-area" ).hide();
	});
}

function showEditFormAdminEmailArea() {
	jQuery(function($){
		//then change the slides
		$( "#lps-forms-edit-form-basic-area" ).hide();
		$( "#lps-forms-edit-form-user-email-area" ).hide();
		$( "#lps-forms-edit-form-admin-email-area" ).show();
	});
}

function clearNewLpsFormsValues() {
	jQuery( "#lps-forms-name" ).val('');

	published = 1;
	showTitle = 0;
	showButtons = 1;
	showTime = 0;

	jQuery( "#lps-forms-description" ).val('');

	gcalToggle = 0;
	gcalIdCount = 0;
	gcalIdBin = [0];
	jQuery( "#lps-forms-google-calendar-ids-bin" ).empty(); //empty gcal ids bin
	toggleIcon(0,'gcalToggle','lps-forms-gcal-toggle'); //turn off integration and hide gcal ids
}

function closeNewFormModal() {
	UIkit.modal("#lps-forms-create-new").hide();
}

function launchAddTemplateModal(itemId) {
	UIkit.modal("#lps-forms-add-template").show();
}

function closeAddTemplateModal(itemId) {
	UIkit.modal("#lps-forms-add-template").hide();
}

function saveAddTemplate() {
	
}

function launchEditFormModal(itemId) {
	editItemId = itemId;
	UIkit.modal("#lps-forms-edit-form").show();
	populateEditForm(itemId);	
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

function populateEditForm(itemId) {
	var formItem = getFormItemData(itemId);
	console.log(formItem)

	//set the toggle buttons
	toggleEditIcon(formItem.published,'published',"lps-forms-edit-published");

	editPublished = formItem.published;

	//basic info
	jQuery( "#lps-forms-edit-name" ).val(formItem.name);
	jQuery( "#lps-forms-edit-description" ).val(formItem.description);
	jQuery( "#lps-forms-edit-return-url" ).val(formItem.return_url);
	jQuery( "#lps-forms-edit-show-thank-you" ).val(formItem.show_thank_you);
	jQuery( "#lps-forms-edit-thank-you-message" ).val(formItem.thank_you_message);

	//user emails
	jQuery( "#lps-forms-edit-user-email-text" ).val(formItem.user_email_text);
	jQuery( "#lps-forms-edit-user-email-to" ).val(formItem.user_email_to);
	jQuery( "#lps-forms-edit-user-email-cc" ).val(formItem.user_email_cc);
	jQuery( "#lps-forms-edit-user-email-bcc" ).val(formItem.user_email_bcc);
	jQuery( "#lps-forms-edit-user-email-from" ).val(formItem.user_email_from);
	jQuery( "#lps-forms-edit-user-email-from-name" ).val(formItem.user_email_from_name);
	jQuery( "#lps-forms-edit-user-email-reply-to" ).val(formItem.user_email_reply_to);
	jQuery( "#lps-forms-edit-user-email-subject" ).val(formItem.user_email_subject);
	toggleEditIcon(formItem.user_email_mode,'user-email-mode',"lps-forms-edit-user-email-mode");

	//admin emails
	jQuery( "#lps-forms-edit-admin-email-text" ).val(formItem.admin_email_text);
	jQuery( "#lps-forms-edit-admin-email-to" ).val(formItem.admin_email_to);
	jQuery( "#lps-forms-edit-admin-email-cc" ).val(formItem.admin_email_cc);
	jQuery( "#lps-forms-edit-admin-email-bcc" ).val(formItem.admin_email_bcc);
	jQuery( "#lps-forms-edit-admin-email-from" ).val(formItem.admin_email_from);
	jQuery( "#lps-forms-edit-admin-email-from-name" ).val(formItem.admin_email_from_name);
	jQuery( "#lps-forms-edit-admin-email-reply-to" ).val(formItem.admin_email_reply_to);
	jQuery( "#lps-forms-edit-admin-email-subject" ).val(formItem.admin_email_subject);
	toggleEditIcon(formItem.admin_email_mode,'admin-email-mode',"lps-forms-edit-admin-email-mode");

}

function clearEditFormFormValues() {
	jQuery( "#lps-forms-edit-name" ).val('');
	jQuery( "#lps-forms-edit-description" ).val('');
	editPublished = 0;		
}

function clearNewFormFormValues() {
	jQuery( "#lps-forms-name" ).val('');
	jQuery( "#lps-forms-description" ).val('');
	published = 0;	
}

function getFormItemData(itemId) {
	for (var i=0;i<window.FormItems.length;i++) {
		if (window.FormItems[i].id == itemId) {
			return window.FormItems[i];
		}
	}

	return false;
}

function editForm() {

	var formObj = {};

	//basic info
	formObj.id = editItemId;
	formObj.name = jQuery( "#lps-forms-edit-name" ).val();
	//validation for form name
	var className = 'uk-width-1-1';
	if (!formObj.name) {
		className += ' uk-form-danger';
		jQuery( "#lps-forms-edit-name" ).removeAttr('class');
		jQuery( "#lps-forms-edit-name" ).attr('class',className);
		jQuery( "#lps-forms-edit-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-forms-edit-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-forms-edit-name" ).removeAttr('class');
		jQuery( "#lps-forms-edit-name" ).attr('class',className);
		jQuery( "#lps-forms-edit-name-validation-msg" ).empty();
		jQuery( "#lps-forms-edit-name-validation-msg" ).hide();	
	}	
	formObj.published = published;
	formObj.description = jQuery( "#lps-forms-edit-description" ).val();
	formObj.return_url = jQuery( "#lps-forms-edit-return-url" ).val();
	formObj.show_thank_you = jQuery( "#lps-forms-edit-show-thank-you" ).val();
	formObj.thank_you_message = jQuery( "#lps-forms-edit-thank-you-message" ).val();

	//user emails
	formObj.user_email_text = jQuery( "#lps-forms-edit-user-email-text" ).val();
	formObj.user_email_to = jQuery( "#lps-forms-edit-user-email-to" ).val();
	formObj.user_email_cc = jQuery( "#lps-forms-edit-user-email-cc" ).val();
	formObj.user_email_bcc = jQuery( "#lps-forms-edit-user-email-bcc" ).val();
	formObj.user_email_from = jQuery( "#lps-forms-edit-user-email-from" ).val();
	formObj.user_email_from_name = jQuery( "#lps-forms-edit-user-email-from-name" ).val();
	formObj.user_email_reply_to = jQuery( "#lps-forms-edit-user-email-reply-to" ).val();
	formObj.user_email_subject = jQuery( "#lps-forms-edit-user-email-subject" ).val();
	formObj.user_email_mode = editUserEmailMode;

	//admin emails
	formObj.admin_email_text = jQuery( "#lps-forms-edit-admin-email-text" ).val();
	formObj.admin_email_to = jQuery( "#lps-forms-edit-admin-email-to" ).val();
	formObj.admin_email_cc = jQuery( "#lps-forms-edit-admin-email-cc" ).val();
	formObj.admin_email_bcc = jQuery( "#lps-forms-edit-admin-email-bcc" ).val();
	formObj.admin_email_from = jQuery( "#lps-forms-edit-admin-email-from" ).val();
	formObj.admin_email_from_name = jQuery( "#lps-forms-edit-admin-email-from-name" ).val();
	formObj.admin_email_reply_to = jQuery( "#lps-forms-edit-admin-email-reply-to" ).val();
	formObj.admin_email_subject = jQuery( "#lps-forms-edit-admin-email-subject" ).val();
	formObj.admin_email_mode = editAdminEmailMode;

	console.log(formObj)

	//set the value of form object input
	jQuery( "#lps-forms-edit-form-object" ).val( JSON.stringify(formObj) );

	//submit the form
	document.forms['editFormItem'].submit(); 
}

function closeEditFormModal() {
	editItemId = 0;
	UIkit.modal("#lps-forms-edit-form").hide();
	//clearEditCalendarFormValues();
}

function searchLpsForms() {

	jQuery( "#lps-forms-clear-search" ).show();

	//submit the form
	document.forms['LpsFormsSearchForm'].submit();
}

function clearFormsSearch() {

	jQuery( "#lps-forms-clear-search" ).hide();
	jQuery( "#lps-forms-search" ).val('');

	//submit the form
	document.forms['LpsFormsSearchForm'].submit();	
}

function togglePublishing(state,itemId) {

	jQuery( "#lps-forms-state" ).val(state);
	jQuery( "#lps-forms-item-id" ).val(itemId);

	//submit the form
	document.forms['lpsFormsTogglePublishing'].submit();
}

function removeFormItem(itemId) {

	var message = LanguageFile.COM_LPS_FORMS_CONFIRM_REMOVE;
	UIkit.modal.confirm(message, function(){
		jQuery( "#lps-forms-remove-item-id" ).val(itemId);

		//submit the form
		document.forms['lpsFormsRemoveForm'].submit();	
	});

}

//modal event handling to clear data from closed modals
jQuery(function($){

	//anytime the new modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in new form
	$('#lps-forms-create-new').on({

	    'hide.uk.modal': function(){
	    	clearNewFormFormValues();
	    }

	});
	//anytime the edit modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in edit form
	$('#lps-forms-edit-landing-page').on({

	    'hide.uk.modal': function(){
	    	clearEditFormFormValues();
	    }

	});

});




