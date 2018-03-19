<?php
/**
 * @version     1.1
 * @package     mod_lpsform - Display LPs Forms via module - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Get thee gone!');

$document = JFactory::getDocument();
$document->addScript('modules/mod_lpsform/assets/validate.js');

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

echo '<link rel="stylesheet" type="text/css" href="components/com_lps/assets/libraries/uikit/css/uikit.almost-flat.css">'; //add uikit

//module paramaters
$moduleClassSuffix = $params->get('moduleclass_sfx', '');
$moduleClassSuffix = ($moduleClassSuffix !="") ? 'class="'.$moduleClassSuffix.'"' : '';
$formId = $params->get('lps_form_id', 0);

if ($formId > 0) {
	$form = modLpsFormHelper::getForm($formId);
	$form_validations = modLpsFormHelper::getFormValidations($formId);
	
	$document->addScriptDeclaration('window.modLpsFormValidations = '.json_encode($form_validations).';');
	echo modLpsFormHelper::getFormHtml($form,$params);
}

if ($app->input->getInt('lps-form-id')) {
	 modLpsFormHelper::processForm();
}

//Returns the path of the layout file
//require JModuleHelper::getLayoutPath('mod_lpsform','default');

?>