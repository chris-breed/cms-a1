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
 * Leads list controller class.
 */
class LpsControllerLeads extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Leads', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

    public function changeStatus() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $model->changeLeadStatus($app->input->getInt('lps-leads-status-select-id'),$app->input->getString('lps-leads-status-select'));

        $msg = JText::_('COM_LPS_LEADS_STATUS_CHANGED');
        $app->redirect('index.php?option=com_lps&view=leads',$msg);      
    }

    public function addLead() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $model->store($app->input->getString('lps-lead-emails'),$app->input->getString('lps-lead-submission'));

        $msg = JText::_('COM_LPS_LEADS_ADDED');
        $app->redirect('index.php?option=com_lps&view=leads',$msg);     
    }

    public function massLeadConversion() {
        $app = JFactory::getApplication();
        $model = $this->getModel();

        $newLeads = json_decode($app->input->getString('lps-submissions-mass-lead-conversion'));
        if (count($newLeads) > 0) {
            foreach ($newLeads as $lead) {
                $model->store($lead->email,$lead->submission_id);
            }
        }

        $msg = JText::_('COM_LPS_LEADS_ADDED');
        $app->redirect('index.php?option=com_lps&view=leads',$msg);         
    }

    public function removeLeadItem() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $model->removeLeadItem($app->input->getInt('lps-leads-remove-item'));

        $msg = JText::_('Your lead has been removed.');
        $app->redirect('index.php?option=com_lps&view=leads',$msg);       
    }

}