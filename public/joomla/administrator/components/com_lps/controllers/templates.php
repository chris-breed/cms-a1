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

jimport('joomla.application.component.controlleradmin');

/**
 * Templates list controller class.
 */
class LpsControllerTemplates extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Templates', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function createNewTemplate() {
        $app = JFactory::getApplication();
    	$model = $this->getModel();
    	$templateId = $model->store();
        $model->storeHtmlContent($templateId,$_POST['lp-templates-selected-layout-editing']);
    	
    	$msg = JText::_('COM_LPS_TEMPLATES_CREATED');
    	$app->redirect('index.php?option=com_lps&view=templates',$msg);		
	}

	public function editTemplate() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $status = $model->store();
        $model->storeHtmlContent($app->input->getInt('lps-templates-edit-item-id'),$_POST['lp-templates-selected-layout-editing']);

        $msg = JText::_('COM_LPS_TEMPLATES_SAVED');
        $app->redirect('index.php?option=com_lps&view=templates',$msg);  		
	}

	public function removeTemplateItem() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->removeTemplateItem($app->input->getInt('lps-templates-remove-item-id'));

    	$msg = JText::_('COM_LPS_TEMPLATES_REMOVED');
    	$app->redirect('index.php?option=com_lps&view=templates',$msg);		
	}

	public function togglePublishing() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->togglePublishing($app->input->getInt('lps-templates-state'),$app->input->getInt('lps-templates-item-id'));

    	if ($app->input->getInt('lps-templates-state') == 1) {
    		$msg = JText::_('COM_LPS_TEMPLATES_PUBLISHED');
    	} else {
    		$msg = JText::_('COM_LPS_TEMPLATES_UNPUBLISHED');
    	}
    	
    	$app->redirect('index.php?option=com_lps&view=templates',$msg);		
	}


}