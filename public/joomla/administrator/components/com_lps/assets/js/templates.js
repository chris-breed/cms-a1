/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

jQuery(function($) {
	//sortable calendar list
	//$( "#lps-templates-sortable" ).sortable();
	//$( "#lps-templates-sortable" ).disableSelection();

	//hide bulk actions checkboxes
	$( ".lps-templates-bulk-actions-checkboxes" ).hide();

});


var published = 1;
var showFormTitle = 1;

var editItemId = 0;
var editPublished = 1;

var layouts = {};
layouts.codeyourown = {
						name:"Code Your Own",
						src:"components/com_lps/assets/images/layouts/codeyourown_layout.png",
						desc:"Write or paste in your own HTML code to create your own layout."
					  };
layouts.onecolumn = {
						name:"1 Column",
						src:"components/com_lps/assets/images/layouts/1column_layout.png",
						desc:"Fully responsive 1 column layout usable with or without a form."
					};
layouts.leftsidebar = {
						name:"Left Sidebar",
						src:"components/com_lps/assets/images/layouts/leftsidebar_layout.png",
						desc:"Fully responsive left sidebar layout usable with or without a form."
					  };
layouts.rightsidebar = {
						name:"Right Sidebar",
						src:"components/com_lps/assets/images/layouts/rightsidebar_layout.png",
						desc:"Fully responsive right sidebar layout usable with or without a form."
					    };
layouts.twocolumn = {
						name:"2 Column",
						src:"components/com_lps/assets/images/layouts/2column_layout.png",
						desc:"Fully responsive 2 column layout usable with or without a form."
					};
layouts.threecolumn = {
						name:"3 Column",
						src:"components/com_lps/assets/images/layouts/3column_layout.png",
						desc:"Fully responsive 3 column layout usable with or without a form."
					  };
layouts.threecolumnrepeat = {
								name:"3 Column Repeat",
								src:"components/com_lps/assets/images/layouts/3columnrepeat_layout.png",
								desc:"Fully responsive 3 column repeat layout usable with or without a form."
							};
var selectedLayout = "";


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
		case 'showFormTitle':
				showFormTitle = state;
			break;
				
	}
}	
	
function validateTemplateEditForm() {
	var name = jQuery( "#lps-templates-name" ).val();
	if (!name) {
		jQuery( "#lps-templates-name" ).removeAttr('class');
		jQuery( "#lps-templates-name" ).attr('class','uk-form-danger');
		jQuery( "#lps-templates-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-templates-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-templates-name" ).removeAttr('class');
		jQuery( "#lps-templates-name-validation-msg" ).empty();
		jQuery( "#lps-templates-name-validation-msg" ).hide();	
		return true;
	}
}

function editTemplate() {
	var validation = validateTemplateEditForm();
	if (validation == true) {
		jQuery( "#lps-templates-published-value" ).val(published);
		//jQuery( "#lps-templates-edit-item-id" ).val(editItemId);
		jQuery( "#lps-templates-layout" ).val(selectedLayout);
		document.forms['editTemplateForm'].submit(); //submit the form
	}
}

function closeEditTemplateModal() {
	editItemId = 0;
	UIkit.modal("#lps-templates-edit-template").hide();
	//clearEditTemplateFormValues();
}

function searchLpsTemplates() {

	jQuery( "#lps-templates-clear-search" ).show();

	//submit the form
	document.forms['LpsTemplatesSearchForm'].submit();
}

function clearTemplatesSearch() {

	jQuery( "#lps-templates-clear-search" ).hide();
	jQuery( "#lps-templates-search" ).val('');

	//submit the form
	document.forms['LpsTemplatesSearchForm'].submit();	
}

function togglePublishing(state,itemId) {

	jQuery( "#lps-templates-state" ).val(state);
	jQuery( "#lps-templates-item-id" ).val(itemId);

	//submit the form
	document.forms['TemplatesTogglePublishing'].submit();
}

function removeTemplateItem(itemId) {
	var message = LanguageFile.COM_LPS_TEMPLATES_CONFIRM_REMOVE;
	UIkit.modal.confirm(message, function(){
		jQuery( "#lps-templates-remove-item-id" ).val(itemId);

		//submit the form
		document.forms['TemplatesRemoveTemplate'].submit();	
	});
}

function showBasicLayoutTab() {
	jQuery( "#lps-templates-layout-grid" ).hide();
	jQuery( "#lps-templates-layout-basic" ).show();
	jQuery( "#lp-templates-grid-tab" ).removeAttr('class');
	jQuery( "#lp-templates-basic-tab" ).attr('class','uk-active');
}

function showGridLayoutTab() {
	jQuery( "#lps-templates-layout-basic" ).hide();
	jQuery( "#lps-templates-layout-grid" ).show();
	jQuery( "#lp-templates-basic-tab" ).removeAttr('class');
	jQuery( "#lp-templates-grid-tab" ).attr('class','uk-active');
}

function selectLayout(layout) {
	selectedLayout = layout;
	jQuery( "#lp-templates-layout-selection-area" ).hide();
	jQuery( "#lp-templates-selected-layout-area" ).show('blind');

	jQuery( "#lp-templates-layout-selected-img" ).removeAttr('src').attr('src',layouts[layout].src);
	jQuery( "#lp-templates-layout-selected-name" ).empty().html(layouts[layout].name);
	jQuery( "#lp-templates-layout-selected-desc" ).empty().html(layouts[layout].desc);
}

function showMiniLayout(layout) {
	jQuery( "#lp-templates-layout-selection-area" ).hide();
	jQuery( "#lp-templates-selected-layout-area" ).hide();
	jQuery( "#lp-templates-mini-selected-layout-area" ).show('blind');

	jQuery( "#lp-templates-layout-mini-selected-img" ).removeAttr('src').attr('src',layouts[layout].src);
	jQuery( "#lp-templates-layout-mini-selected-name" ).empty().html(layouts[layout].name);
}

function initializeEditLayout() {
	showMiniLayout(selectedLayout);
	jQuery( "#lp-templates-selected-layout-editing-area" ).show();
	UIkit.htmleditor(jQuery( "#lp-templates-selected-layout-editing" ), { mode:'split' });
	
	var layoutContentHtml = getLayoutContent(selectedLayout);
	
	//Get a reference to the CodeMirror editor
	var editor = jQuery('.CodeMirror')[0].CodeMirror;

	//You can then use it as you wish
	editor.setValue(formatHtml(layoutContentHtml));

}

function formatHtml(html) {
    var formatted = '';
    var reg = /(>)(<)(\/*)/g;
    html = html.replace(reg, '$1\r\n$2$3');
    var pad = 0;
    jQuery.each(html.split('\r\n'), function(index, node) {
        var indent = 0;
        if (node.match( /.+<\/\w[^>]*>$/ )) {
            indent = 0;
        } else if (node.match( /^<\/\w/ )) {
            if (pad != 0) {
                pad -= 1;
            }
        } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
            indent = 1;
        } else {
            indent = 0;
        }

        var padding = '';
        for (var i = 0; i < pad; i++) {
            padding += '  ';
        }

        formatted += padding + node + '\r\n';
        pad += indent;
    });

    return formatted;
}

function getLayoutContent(layout) {
	if (layout == 'codeyourown') {
		var contents = '';
	} else if (layout == 'onecolumn') {
		var contents = window.oneColumnLayoutHtml;
	} else if (layout == 'leftsidebar') {
		var contents = window.leftSidebarLayoutHtml;
	} else if (layout == 'rightsidebar') {
		var contents = window.rightSidebarLayoutHtml;
	} else if (layout == 'twocolumn') {		
		var contents = window.twoColumnLayoutHtml;
	} else if (layout == 'threecolumn') {		
		var contents = window.threeColumnLayoutHtml;
	} else if (layout == 'threecolumnrepeat') {				
		var contents = window.threeRepeatColumnLayoutHtml;
	} else {
		var contents = '';
	}

	return contents;
}

function validateTemplateForm() {
	var name = jQuery( "#lps-templates-name" ).val();
	if (!name) {
		jQuery( "#lps-templates-name" ).removeAttr('class');
		jQuery( "#lps-templates-name" ).attr('class','uk-form-danger');
		jQuery( "#lps-templates-name-validation-msg" ).empty().html('Name is required');
		jQuery( "#lps-templates-name-validation-msg" ).show();
		return false;
	} else {
		jQuery( "#lps-templates-name" ).removeAttr('class');
		jQuery( "#lps-templates-name-validation-msg" ).empty();
		jQuery( "#lps-templates-name-validation-msg" ).hide();	
		return true;
	}
}

function saveNewTemplate() {
	var validation = validateTemplateForm();
	if (validation == true) {
		jQuery( "#lps-templates-published-value" ).val(published);
		jQuery( "#lps-templates-layout" ).val(selectedLayout);
		jQuery( "#lps-templates-show-form-title-value" ).val(showFormTitle);

		document.forms['createNewForm'].submit(); //submit the form
	}
}

function returnToSelectedLayout() {
	jQuery( "#lp-templates-mini-selected-layout-area" ).hide();
	jQuery( "#lp-templates-layout-selection-area" ).hide();
	jQuery( "#lp-templates-selected-layout-editing-area" ).hide();
	jQuery( "#lp-templates-selected-layout-area" ).show('blind');

	jQuery( "#lp-templates-layout-selected-img" ).removeAttr('src').attr('src',layouts[selectedLayout].src);
	jQuery( "#lp-templates-layout-selected-name" ).empty().html(layouts[selectedLayout].name);
	jQuery( "#lp-templates-layout-selected-desc" ).empty().html(layouts[selectedLayout].desc);


}

function removeLayout() {

	var message = LanguageFile.COM_LPS_TEMPLATES_CONFIRM_LAYOUT_REMOVE;
	UIkit.modal.confirm(message, function(){
		selectedLayout = "";
		jQuery( "#lp-templates-selected-layout-area" ).hide();
		jQuery( "#lp-templates-mini-selected-layout-area" ).hide();
		jQuery( "#lp-templates-selected-layout-editing-area" ).hide();
		jQuery( "#lp-templates-layout-selection-area" ).show('blind');
	});

}

//modal event handling to clear data from closed modals
jQuery(function($){

	//anytime the new modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in new form
	$('#lps-templates-create-new').on({

	    'hide.uk.modal': function(){
	    	clearNewTemplateFormValues();
	    }

	});
	//anytime the edit modal is closed we want to be sure we have cleared all input data from form
	//set form back to 'empty' state so we don't leave behind data in edit form
	$('#lps-templates-edit-landing-page').on({

	    'hide.uk.modal': function(){
	    	clearEditTemplateFormValues();
	    }

	});

});




