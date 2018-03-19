<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

//require lps main helper file
require_once JPATH_COMPONENT.'/helpers/lps.php';

//add global styles
$document = JFactory::getDocument();
//$document->addStyleSheet('components/com_lps/assets/libraries/uikit/css/uikit.almost-flat.css'); //add uikit

// Execute the task.
$controller	= JControllerLegacy::getInstance('Lps');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
