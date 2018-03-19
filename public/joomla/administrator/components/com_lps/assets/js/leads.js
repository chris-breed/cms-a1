/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

function showStatusSelect(itemId) {
	UIkit.modal("#lps-leads-status-select-modal").show();
	jQuery( "#lps-leads-status-select-id" ).val(itemId);
}

function closeStatusSelect(itemId) {
	UIkit.modal("#lps-leads-status-select-modal").hide();
	jQuery( "#lps-leads-status-select-id" ).val(0);
}

function removeLeadItem(itemId) {

	var message = 'Are you sure you want to remove this lead?';
	UIkit.modal.confirm(message, function(){
		jQuery( "#lps-leads-remove-item" ).val(itemId);

		//submit the form
		document.forms['lpsLeadsRemoveItem'].submit();	
	});	
}