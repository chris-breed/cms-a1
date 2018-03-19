/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

function showStatusSelect(itemId) {
	UIkit.modal("#lps-submission-status-select-modal").show();
	jQuery( "#lps-submission-status-select-id" ).val(itemId);
}

function closeStatusSelect(itemId) {
	UIkit.modal("#lps-submission-status-select-modal").hide();
	jQuery( "#lps-submission-status-select-id" ).val(0);
}

function launchSubmissionDataModal(itemId) {
	UIkit.modal("#lps-submission-item-data-modal").show();
	populateSubmissionData(itemId);
}

function populateSubmissionData(itemId) {
	var submission = getSubmissionData(itemId);
	if (submission) {

		var html = '<table class="uk-table uk-table-striped">';
		html += '<thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>';
		var emailsFound = false;
		var virginEmailsFound = false;
		for (var i=0;i<submission.submission_values.length;i++) {
			html += '<tr>';
				html += '<td>'+submission.submission_values[i].field_name+'</td>';
				var value = submission.submission_values[i].value;
				if (value) {
					var emails = findEmails(value.toLowerCase());
				}

				//console.log(emails)

				if (emails) {
					emailsFound = true;
					html += '<td>';
						html += submission.submission_values[i].value;
						if (findExistingLeadEmail(emails[0],window.LeadItems)) { //this email is already a lead
							html += '<a class="uk-button uk-button-small uk-button-danger uk-float-right" href="javascript:void(0);" data-uk-tooltip title="'+LanguageFile.COM_LPS_SUBMISSION_EMAIL_ALREADY_LEAD+'">Lead</a>';
						} else { //this email is not yet a lead
							virginEmailsFound = true;
							html += '<a onclick="convertSubmissionToLead(\''+emails[0]+'\','+submission.id+')" class="uk-button uk-button-small uk-button-success uk-float-right" href="javascript:void(0);" data-uk-tooltip title="'+LanguageFile.COM_LPS_SUBMISSION_CLICK_HERE_TO_ADD_LEAD+'">'+LanguageFile.COM_LPS_SUBMISSION_ADD_LEAD+'</a>';
						}
					html += '</td>';
				} else {
					html += '<td>'+submission.submission_values[i].value+'</td>';
				}

			html += '</tr>';
		}
		html += '</tbody></table>';
		var alert = '<div class="uk-alert" data-uk-alert>';
			    alert += '<a href="" class="uk-alert-close uk-close"></a>';
			    alert += '<p>'+LanguageFile.COM_LPS_SUBMISSION_EMAIL_LEAD_DETECT+'</p>';
			alert += '</div>';
		html = ( (emailsFound) && (virginEmailsFound) ) ?  alert+html : html;
		jQuery( "#lps-submission-data-html-area" ).empty().html(html);
		jQuery( "#lps-submission-value-data-title" ).empty().html('submission-00'+submission.id);

	} else {
		//console.log('submission obj is false')
		return false;
	}

}

function convertAllSubmissionsToLead() {

	var message = 'Are you sure you want to convert all submissions which have an email address into leads?';
	UIkit.modal.confirm(message, function(){ 

		var newLeads = getEmailSubmissions();
		if (newLeads.length > 0) {
			jQuery( "#lps-submissions-mass-lead-conversion" ).val(JSON.stringify(newLeads));
			document.forms['lpsSubmissionsMassLeadConversion'].submit();
		} else {
			UIkit.modal.alert("There are currently no submission emails to add as a lead.");
		}

	});

	return false;
}

function getEmailSubmissions() {
	var emailSubmissions = [];

	//loop over the submissions
	for (var i=0;i<window.SubmissionItems.length;i++) {
		var submission = window.SubmissionItems[i];
		//loop over the submission's values
		for (var c=0;c<submission.submission_values.length;c++) {
			var value = submission.submission_values[c].value;
			if (value) {
				var emails = findEmails(value.toLowerCase());
				if (emails) {
					if (findExistingLeadEmail(emails[0],window.LeadItems)) { 
						//this email is already a lead
					} else {
						//this email is not yet a lead
						emailSubmissions.push({'email':emails[0],'submission_id':submission.id});
					}
				}
			}
		}
	}	

	return emailSubmissions;
}

function getSubmissionData(itemId) {
	for (var i=0;i<window.SubmissionItems.length;i++) {
		if (window.SubmissionItems[i].id == itemId) {
			return window.SubmissionItems[i];
		}
	}

	return false;
}

/**
 * Return an array of all email addresses found in input string.
 */
function findEmails(input) {
  var regex = /(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/gm
  return input.match(regex);
}

function findExistingLeadEmail(email,leads) {
	//console.log(email)
	//console.log(leads)
	for (var i=0;i<leads.length;i++) {
		if (leads[i].email == email) {
			return true;
		}
	}
	return false;
}

function convertSubmissionToLead(email,submission) {

	var message = LanguageFile.COM_LPS_SUBMISSION_CONFIRM_LEAD_CONVERSION;
	UIkit.modal.confirm(message, function(){ 

		jQuery( "#lps-lead-emails" ).val(email);
		jQuery( "#lps-lead-submission" ).val(submission);
		document.forms['LpsAddLeadForm'].submit();

	});

}

function removeSubmissionItem(itemId) {

	var message = 'Are you sure you want to remove this submission?';
	UIkit.modal.confirm(message, function(){
		jQuery( "#lps-submissions-remove-item" ).val(itemId);

		//submit the form
		document.forms['lpsSubmissionsRemoveItem'].submit();	
	});	
}
