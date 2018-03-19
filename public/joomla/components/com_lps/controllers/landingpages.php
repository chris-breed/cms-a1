<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// No direct access.
defined('_JEXEC') or die;

//load and extend main controller class
require_once JPATH_COMPONENT.'/controller.php';

/**
 * Landing Pages dedicated controller class.
 */
class LpsControllerLandingPages extends LpsController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'LandingPages', $prefix = 'LpsModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function processForm() {	
		$formModel = JModelLegacy::getInstance('Forms','LpsModel');    
		$submissionModel = JModelLegacy::getInstance('Submissions','LpsModel'); 
		$app = JFactory::getApplication();
		$lpId = $app->input->getInt('lps-id');
		$formId = $app->input->getInt('lps-form-id');
		$form = $formModel->getForm($formId);

		$data = $formModel->retrieveFormValues($form);
		//var_dump($data);die();

		//save submission and submission values
		$submissionId = $submissionModel->storeSubmission($lpId,$formId);
		foreach($data as $fieldId => $value) {
			if (!empty($value)) {
				$submissionModel->storeSubmissionValue($submissionId,$fieldId,$value);
			}
		}

		//prepare to send admin email
		if ($form->admin_email_mode == 1) {

			//assemble email data
			$email = new stdClass;
			$email->to = $form->admin_email_from;
			$email->subject = $form->admin_email_subject;
			$email->body = $form->admin_email_text;
			$email->from = $form->admin_email_from;
			$email->from_name = $form->admin_email_from_name;
			$email->cc = $form->admin_email_cc;
			$email->bcc = $form->admin_email_bcc;
			$email->replyto = $form->admin_email_reply_to;

			//send email
			$submissionModel->sendEmail($email);
		}

		//prepare to send user email
		$user = JFactory::getUser();
		if ( ($user->id > 0) && ($form->user_email_mode == 1) ) {

			//assemble email data
			$email = new stdClass;
			$email->to = $user->email;
			$email->subject = $form->user_email_subject;
			$email->body = $form->user_email_text;
			$email->from = $form->user_email_from;
			$email->from_name = $form->user_email_from_name;
			$email->cc = $form->user_email_cc;
			$email->bcc = $form->user_email_bcc;
			$email->replyto = $form->user_email_reply_to;

			//send email
			$submissionModel->sendEmail($email);
		}
		
		$msg = ($form->thank_you_message !="") ? $form->thank_you_message : 'Thank you for submitting.';

		if (strlen($form->return_url) > 4) {
			$app->redirect($form->return_url,$msg);
		} else {
			$app->redirect('index.php?option=com_lps&view=landingpages&id='.$lpId,$msg);
		}

		
	}	


}