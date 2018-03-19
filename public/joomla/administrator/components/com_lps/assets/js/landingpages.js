/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

jQuery(function($) {
	//sortable calendar list
	//$( "#lps-landing-pages-sortable" ).sortable();
	//$( "#lps-landing-pages-sortable" ).disableSelection();

	//hide bulk actions checkboxes
	$( ".lps-landing-pages-bulk-actions-checkboxes" ).hide();

});


var published = 1;
var showTitle = 0;
var showButtons = 1;
var showTime = 0;
var fixedWeeks = 0;
var rightToLeft = 0;
var gcalToggle = 0;
var gcalIdCount = 0;
var gcalIdBin = [0];

var editItemId = 0;
var editPublished = 1;
var editShowTitle = 0;
var editShowButtons = 1;
var editShowTime = 0;
var editFixedWeeks = 0;
var editRightToLeft = 0;
var editGcalToggle = 0;
var editGcalIdCount = 0;
var editGcalIdBin = [0];

var lpIdAddTmpl = 0;
var lpIdAddForm = 0;

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
		case 'showTitle':
				showTitle = state;
			break;
		case 'showButtons':
				showButtons = state;
			break;
		case 'showTime':
				showTime = state;
			break;	
		case 'fixedWeeks':
				fixedWeeks = state;
			break;		
		case 'rightToLeft':
				rightToLeft = state;
			break;			
		case 'gcalToggle':
				gcalToggle = state;
				if (state == 1) {
					jQuery( "#lps-landing-pages-gcal-setup-area" ).show();
				} else {
					jQuery( "#lps-landing-pages-gcal-setup-area" ).hide();
				}
			break;					
	}
}	

function saveNewLandingPage() {

	var validation = validateLandingPageForm();
	if (validation == true) {
		jQuery( "#lps-landing-pages-published-value" ).val(published);
		document.forms['createNewForm'].submit(); //submit the form
	}

}

function validateLandingPageForm() {
	var name = jQuery( "#lps-landing-pages-name" ).val();
	var className = 'uk-width-1-1';
	if (!name) {
		className += ' uk-form-danger'
		jQuery( "#lps-landing-pages-name" ).removeAttr('class');
		jQuery( "#lps-landing-pages-name" ).attr('class',className);
		jQuery( "#lps-landing-pages-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-landing-pages-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-landing-pages-name" ).removeAttr('class');
		jQuery( "#lps-landing-pages-name" ).attr('class',className);	
		jQuery( "#lps-landing-pages-name-validation-msg" ).empty();
		jQuery( "#lps-landing-pages-name-validation-msg" ).hide();	
		return true;
	}
}

function clearNewLpsLandingPagesValues() {
	jQuery( "#lps-landing-pages-name" ).val('');

	published = 1;
	showTitle = 0;
	showButtons = 1;
	showTime = 0;

	jQuery( "#lps-landing-pages-description" ).val('');

	gcalToggle = 0;
	gcalIdCount = 0;
	gcalIdBin = [0];
	jQuery( "#lps-landing-pages-google-calendar-ids-bin" ).empty(); //empty gcal ids bin
	toggleIcon(0,'gcalToggle','lps-landing-pages-gcal-toggle'); //turn off integration and hide gcal ids
}

function closeLpsLandingPagesModal() {
	UIkit.modal("#lps-landing-pages-create-new").hide();
}

/***********************************/
/* add templates to a landing page */
/***********************************/
function launchAddTemplateModal(itemId) {
	lpIdAddTmpl = itemId;
	UIkit.modal("#lps-landing-pages-add-template").show();

	var lp = getLandingPageItemData(itemId);
	if (lp.template_id > 0) {
		jQuery( "#lps-landing-pages-add-template-select" ).val(lp.template_id);
	}
	
}

function closeAddTemplateModal() {
	formIdAddTmpl = 0;
	UIkit.modal("#lps-landing-pages-add-template").hide();
}

function saveAddTemplate() {
	
	var idToBind = "#lps-landing-pages-add-template-select";
	//make sure we have everything we need before proceeding
	if ( (lpIdAddTmpl > 0) && (jQuery( idToBind ).val() !="") && (jQuery( idToBind ).val() > 0) ) {
		jQuery( "#lps-landing-pages-add-template-landing-page-id" ).val(lpIdAddTmpl);
		document.forms['associateTemplateForm'].submit();
	} else {
		alert('Please make sure to select a template before attempting to save.');
	}

}

/***********************************/
/*** add forms to a landing page ***/
/***********************************/
function launchAddFormModal(itemId) {
	lpIdAddForm = itemId;
	UIkit.modal("#lps-landing-pages-add-form").show();

	var lp = getLandingPageItemData(itemId);
	if (lp.form_id > 0) {
		jQuery( "#lps-landing-pages-add-form-select" ).val(lp.form_id);	
	}
	
}

function closeAddFormModal(itemId) {
	UIkit.modal("#lps-landing-pages-add-form").hide();
}

function saveAddForm() {
	
	var idToBind = "#lps-landing-pages-add-form-select";
	//make sure we have everything we need before proceeding
	if ( (lpIdAddForm > 0) && (jQuery( idToBind ).val() !="") && (jQuery( idToBind ).val() > 0) ) {
		jQuery( "#lps-landing-pages-add-form-landing-page-id" ).val(lpIdAddForm);
		document.forms['associateFormForm'].submit();
	} else {
		alert('Please make sure to select a form before attempting to save.');
	}
}

function launchEditLandingPageModal(itemId) {
	editItemId = itemId;
	UIkit.modal("#lps-landing-pages-edit-landing-page").show();
	populateEditLandingPage(itemId);	
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
		case 'showTitle':
				editShowTitle = state;
			break;
		case 'showButtons':
				editShowButtons = state;
			break;
		case 'showTime':
				editShowTime = state;
			break;				
		case 'fixedWeeks':
				editFixedWeeks = state;
			break;		
		case 'rightToLeft':
				editRightToLeft = state;
			break;			
		case 'gcalToggle':
				editGcalToggle = state;
				if (state == 1) {
					jQuery( "#lps-landing-pages-edit-gcal-setup-area" ).show();
				} else {
					jQuery( "#lps-landing-pages-edit-gcal-setup-area" ).hide();
				}
			break;		
	}

}	

function populateEditLandingPage(itemId) {
	var lp = getLandingPageItemData(itemId);
	console.log(lp)

	jQuery( "#lps-landing-pages-edit-name" ).val(lp.name); //set calendar name

	//set the toggle buttons
	toggleEditIcon(lp.published,'published',"lps-landing-pages-edit-published");

	editPublished = lp.published;

	jQuery( "#lps-landing-pages-edit-description" ).val(lp.description);

}

function clearEditLandingPageFormValues() {
	jQuery( "#lps-landing-pages-edit-name" ).val('');
	jQuery( "#lps-landing-pages-edit-description" ).val('');
	editPublished = 0;		
}

function clearNewLandingPageFormValues() {
	jQuery( "#lps-landing-pages-name" ).val('');
	jQuery( "#lps-landing-pages-description" ).val('');
	published = 0;	
}

function getLandingPageItemData(itemId) {
	for (var i=0;i<window.LandingPageItems.length;i++) {
		if (window.LandingPageItems[i].id == itemId) {
			return window.LandingPageItems[i];
		}
	}

	return false;
}

function editLandingPage() {
	var validation = validateLandingPageEditForm();
	if (validation == true) {
		jQuery( "#lps-landing-pages-edit-published-value" ).val(editPublished);
		jQuery( "#lps-landing-pages-edit-item-id" ).val(editItemId);
		document.forms['editLandingPageForm'].submit(); //submit the form
	}
}

function validateLandingPageEditForm() {
	var name = jQuery( "#lps-landing-pages-edit-name" ).val();
	var className = 'uk-width-1-1';
	if (!name) {
		className += ' uk-form-danger'
		jQuery( "#lps-landing-pages-edit-name" ).removeAttr('class');
		jQuery( "#lps-landing-pages-edit-name" ).attr('class',className);
		jQuery( "#lps-landing-pages-edit-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-landing-pages-edit-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-landing-pages-edit-name" ).removeAttr('class');
		jQuery( "#lps-landing-pages-edit-name" ).attr('class',className);	
		jQuery( "#lps-landing-pages-edit-name-validation-msg" ).empty();
		jQuery( "#lps-landing-pages-edit-name-validation-msg" ).hide();	
		return true;
	}
}

function closeEditLandingPageModal() {
	editItemId = 0;
	UIkit.modal("#lps-landing-pages-edit-landing-page").hide();
	//clearEditCalendarFormValues();
}

function searchLpsLandingPages() {

	jQuery( "#lps-landing-pages-clear-search" ).show();

	//submit the form
	document.forms['LpsLandingPagesSearchForm'].submit();
}

function clearLandingPagesSearch() {

	jQuery( "#lps-landing-pages-clear-search" ).hide();
	jQuery( "#lps-landing-pages-search" ).val('');

	//submit the form
	document.forms['LpsLandingPagesSearchForm'].submit();	
}

function togglePublishing(state,itemId) {

	jQuery( "#lps-landing-pages-state" ).val(state);
	jQuery( "#lps-landing-pages-item-id" ).val(itemId);

	//submit the form
	document.forms['LandingPagesTogglePublishing'].submit();
}

function removeLandingPageItem(itemId) {

	var message = LanguageFile.COM_LPS_LANDING_PAGES_CONFIRM_REMOVE;
	UIkit.modal.confirm(message, function(){
		jQuery( "#lps-landing-pages-remove-item-id" ).val(itemId);

		//submit the form
		document.forms['LandingPagesRemoveCalendar'].submit();	
	});

}

//modal event handling to clear data from closed modals
jQuery(function($){

	//anytime the new modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in new form
	$('#lps-landing-pages-create-new').on({

	    'hide.uk.modal': function(){
	    	clearNewLandingPageFormValues();
	    }

	});
	//anytime the edit modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in edit form
	$('#lps-landing-pages-edit-landing-page').on({

	    'hide.uk.modal': function(){
	    	clearEditLandingPageFormValues();
	    }

	});

});




