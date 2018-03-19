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
 * Landing Pages list controller class.
 */
class LpsControllerLandingPages extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'LandingPages', $prefix = 'LpsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

	public function createNewLandingPage() {
   		$model = $this->getModel();
    	$model->store();

    	$app = JFactory::getApplication();
    	$msg = JText::_('COM_LPS_LANDING_PAGES_CREATED');
    	$app->redirect('index.php?option=com_lps&view=landingpages',$msg);		
	}

	public function editLandingPageItem() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $status = $model->editLandingPageItem();
        if ($status) {
            $msg = JText::_('COM_LPS_LANDING_PAGES_SAVED');
        } else {
            $msg = JText::_('COM_LPS_LANDING_PAGES_SAVED_WRONG');
        }
        
        $app->redirect('index.php?option=com_lps&view=landingpages',$msg);
	}

	public function removeLandingPageItem() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->removeLandingPageItem($app->input->getInt('lps-landing-pages-remove-item-id'));

    	$msg = JText::_('COM_LPS_LANDING_PAGES_REMOVED');
    	$app->redirect('index.php?option=com_lps&view=landingpages',$msg); 		
	}

	public function togglePublishing() {
    	$app = JFactory::getApplication();
    	$model = $this->getModel();
    	$model->togglePublishing($app->input->getInt('lps-landing-pages-state'),$app->input->getInt('lps-landing-pages-item-id'));

    	if ($app->input->getInt('lps-landing-pages-state') == 1) {
    		$msg = JText::_('COM_LPS_LANDING_PAGES_PUBLISHED');
    	} else {
    		$msg = JText::_('COM_LPS_LANDING_PAGES_UNPUBLISHED');
    	}
    	
    	$app->redirect('index.php?option=com_lps&view=landingpages',$msg);		
	}

    public function associateTemplate() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $status = $model->associateTemplate($app->input->getInt('lps-landing-pages-add-template-select'),$app->input->getInt('lps-landing-pages-add-template-landing-page-id'));

        if ($status) {
            $msg = JText::_('COM_LPS_LANDING_PAGES_TEMPLATE_ADDED');
        } else {
            $msg = JText::_('COM_LPS_LANDING_PAGES_TEMPLATE_ADDED_WRONG');
        }

        $app->redirect('index.php?option=com_lps&view=landingpages',$msg);      
    }

    public function associateForm() {
        $app = JFactory::getApplication();
        $model = $this->getModel();
        $status = $model->associateForm($app->input->getInt('lps-landing-pages-add-form-select'),$app->input->getInt('lps-landing-pages-add-form-landing-page-id'));

        if ($status) {
            $msg = JText::_('COM_LPS_LANDING_PAGES_FORM_ADDED');
        } else {
            $msg = JText::_('COM_LPS_LANDING_PAGES_FORM_ADDED_WRONG');
        }

        $app->redirect('index.php?option=com_lps&view=landingpages',$msg);      
    }

}