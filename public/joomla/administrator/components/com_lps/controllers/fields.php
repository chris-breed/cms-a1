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
 * Fields list controller class.
 */
class LpsControllerFields extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Fields', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function createNewField() {
		$model = $this->getModel();
		$application = JFactory::getApplication();
		$fieldObjRaw = $application->input->getString('lps-fields-field-object');
		$field = json_decode($fieldObjRaw,true);

		$model->store($field);

		$msg = JText::_('COM_LPS_FIELDS_CREATED');
		$application->redirect('index.php?option=com_lps&view=fields',$msg);		
	}

	public function editFieldItem() {
		$model = $this->getModel();
		$application = JFactory::getApplication();
		$fieldObjRaw = $application->input->getString('lps-fields-edit-field-object');
		$field = json_decode($fieldObjRaw,true);
		$field['id'] = $application->input->getString('lps-fields-edit-id');

		$model->store($field);

		$msg = JText::_('COM_LPS_FIELDS_SAVED');
		$application->redirect('index.php?option=com_lps&view=fields',$msg);		
	}

	public function saveFieldOrdering() {
		$model = $this->getModel();
		$application = JFactory::getApplication();
		$fieldOrderingRaw = $application->input->getString('lps-fields-ordering');
		$ordering = json_decode($fieldOrderingRaw);

		$model->saveFieldOrdering($ordering);

		$msg = JText::_('COM_LPS_FIELDS_SAVE_ORDERING');
		$application->redirect('index.php?option=com_lps&view=fields',$msg);	
	}

	public function togglePublishing() {
		$model = $this->getModel();
		$app = JFactory::getApplication();

		$model->togglePublishing($app->input->getInt('lps-fields-state'),$app->input->getInt('lps-fields-item-id'));

    	if ($app->input->getInt('lps-fields-state') == 1) {
    		$msg = JText::_('COM_LPS_FIELDS_PUBLISHED');
    	} else {
    		$msg = JText::_('COM_LPS_FIELDS_UNPUBLISHED');
    	}
		$app->redirect('index.php?option=com_lps&view=fields',$msg);	
	}

	public function removeFieldItem() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->removeFieldItem($app->input->getInt('lps-fields-remove-item-id'));

    	$msg = JText::_('COM_LPS_FIELDS_REMOVED');
    	$app->redirect('index.php?option=com_lps&view=fields',$msg); 		
	}

}