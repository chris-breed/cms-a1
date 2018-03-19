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
 * Forms list controller class.
 */
class LpsControllerForms extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Forms', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function createNewForm() {
		$model = $this->getModel();
		$application = JFactory::getApplication();
		$formObjRaw = $application->input->getString('lps-forms-form-object');
		$form = json_decode($formObjRaw,true);

		$model->store($form);

		$msg = JText::_('COM_LPS_FORMS_CREATED');
		$application->redirect('index.php?option=com_lps&view=forms',$msg);
	}

	public function editFormItem() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
		$formObjRaw = $app->input->getString('lps-forms-edit-form-object');
		$form = json_decode($formObjRaw,true);

        $status = $model->store($form);
        if ($status) {
            $msg = JText::_('COM_LPS_FORMS_SAVED');
        } else {
            $msg = JText::_('COM_LPS_FORMS_SAVED_WRONG');
        }
        
        $app->redirect('index.php?option=com_lps&view=forms',$msg);
	}

	public function removeFormItem() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->removeFormItem($app->input->getInt('lps-forms-remove-item-id'));

    	$msg = JText::_('COM_LPS_FORMS_REMOVED');
    	$app->redirect('index.php?option=com_lps&view=forms',$msg); 		
	}

	public function togglePublishing() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->togglePublishing($app->input->getInt('lps-forms-state'),$app->input->getInt('lps-forms-item-id'));

    	if ($app->input->getInt('lps-forms-state') == 1) {
    		$msg = JText::_('COM_LPS_FORMS_PUBLISHED');
    	} else {
    		$msg = JText::_('COM_LPS_FORMS_UNPUBLISHED');
    	}
    	
    	$app->redirect('index.php?option=com_lps&view=forms',$msg);		
	}
}