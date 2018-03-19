<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// no direct access
defined('_JEXEC') or die;

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_lps')) 
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

//include dependencies
jimport('joomla.application.component.controller');

//require artcalendar main helper file
require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/lps.php';

//add global styles
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root().'components/com_lps/assets/libraries/uikit/css/uikit.almost-flat.css'); //add uikit
$document->addStyleSheet('components/com_lps/assets/css/lps.css'); //add lps

$document->addScriptDeclaration('var LanguageFile = '.LpsHelper::getJavascriptFileLanguage().';');

//add joomlasales.com branding font stylesheets
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Viga');
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Lato');

$controller	= JControllerLegacy::getInstance('Lps');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
