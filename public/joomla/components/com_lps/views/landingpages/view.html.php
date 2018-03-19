<?php
/**
 * @version     2.7
 * @package     com_lps - LPs Simple Landing Pages
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Mike Hill <info@joomlasales.com> - http://joomlasales.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for landing pages
 */
class LpsViewLandingPages extends JViewLegacy
{
	//protected $items;
	//protected $pagination;
	//protected $state;
    //protected $params;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
        $app = JFactory::getApplication();
        $document = JFactory::getDocument();

        //load needed models
        $lpModel = $this->getModel();
        $tmplModel = JModelLegacy::getInstance('Templates','LpsModel');
        $formModel = JModelLegacy::getInstance('Forms','LpsModel');       

        if ($app->input->getInt('id')) { //only if id specified
            
            $this->landingpage = $lpModel->getLandingPage($app->input->getInt('id')); //get the needed landing page

            if ($this->landingpage->template_id > 0) {
                $this->template = $tmplModel->getTemplate($this->landingpage->template_id); //get the template 
            
                if ($this->landingpage->form_id > 0) {
                    $this->form = $formModel->getForm($this->landingpage->form_id);//get the form
                    $this->form_validations = $formModel->getFormValidations($this->landingpage->form_id);
                    $document->addScriptDeclaration('window.lpsFormValidations = '.json_encode($this->form_validations).';');
                    $this->form->content = $formModel->getFormHtml($this->template,$this->form);
                    $this->lp_content = $formModel->addFormToLandingPageContent($this->template->content,$this->form->content);
                } else {
                    $this->lp_content = $formModel->addFormToLandingPageContent($this->template->content,'');
                }

            } else {
                $this->template = false;
                $msg = 'Your landing page doesn\'t have a template associated with it. Please add a template to your landing page first.';
                $app->redirect('index.php?option=com_lps&view=landingpages',$msg);
            }

            
        } else {
            $msg = 'This is the wrong URL. Please don\'t visit this link directly. A landing page hasn\'t been specified in your request.';
            $app->redirect('index.php?option=com_lps&view=landingpages',$msg);
        }
        
        $this->addLpsJS(); //add the lps main js file

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {;
            throw new Exception(implode("\n", $errors));
        }
        
        //$this->_prepareDocument();
        parent::display($tpl);
	}

    public function addLpsJS() {
        echo "<script type=\"text/javascript\" src=\"//code.jquery.com/ui/1.11.4/jquery-ui.js\"></script>\n";
        echo "<script type=\"text/javascript\" src=\"components/com_lps/assets/js/lps.js\"></script>\n";
    }    



}
