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
 * Submissions list controller class.
 */
class LpsControllerSubmissions extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Submissions', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

    public function changeStatus() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $model->changeSubmissionStatus($app->input->getInt('lps-submission-status-select-id'),$app->input->getString('lps-submission-status-select'));

        $msg = JText::_('COM_LPS_SUBMISSIONS_SUBMISSION_STATUS_CHANGED');
        $app->redirect('index.php?option=com_lps&view=submissions',$msg);      

        
    }

    public function removeSubmissionItem() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->removeSubmissionItem($app->input->getInt('lps-submissions-remove-item'));

    	$msg = JText::_('Your submission has been removed.');
    	$app->redirect('index.php?option=com_lps&view=submissions',$msg); 		
	}
}